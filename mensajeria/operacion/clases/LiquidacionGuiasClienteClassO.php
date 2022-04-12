<?php
require_once("../../../framework/clases/ControlerClass.php");
final class LiquidacionGuiasCliente extends Controler{

	public function __construct(){
		parent::__construct(2);
	}

	public function Main(){

		$this -> noCache();
		require_once("LiquidacionGuiasClienteLayoutClass.php");
		require_once("LiquidacionGuiasClienteModelClass.php");

		$Layout   = new LiquidacionGuiasClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new LiquidacionGuiasClienteModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setAnular   ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
		$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);
		$this -> SetVarsValidate($this -> Campos);
		$Layout -> setEstado		($Model -> getEstado());
    	$Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getConex())); 
		$Layout -> RenderMain();
	}

	protected function OnClickSave(){

		require_once("LiquidacionGuiasClienteModelClass.php");
		$Model = new LiquidacionGuiasClienteModel();

		$estado		= $_REQUEST['estado'];
		$guias_id	= $_REQUEST['guias_id'];
		$year  		= substr($_REQUEST['fecha_inicial'],0,4);	
		$desde  	= $_REQUEST['fecha_inicial'];				
		$hasta  	= $_REQUEST['fecha_final'];
		$cliente_id = $_REQUEST['cliente_id'];
		
		$oficina_id1 = $_REQUEST['oficina_id1'];
		
		$consecutivo	= $Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex());
		
		if($guias_id=='todas'){
			$result =  $Model -> getGuiasLiqtodas($desde,$hasta,$cliente_id,$this -> getOficinaId(),$oficina_id1,$this -> getConex());
		}else{
			$result =  $Model -> getGuiasLiqUni($desde,$hasta,$cliente_id,$this -> getOficinaId(),$oficina_id1,$guias_id,$this -> getConex());
		}
		$mensaje='';
		for($i=0;$i<count($result);$i++){
			$guia_id1=$result[$i]['guia_id'];
			$numero_guia=$result[$i]['numero_guia'];
			$valor_total=$result[$i]['valor_total'];
			$origen_id=$result[$i]['origen_id'];
			$destino_id=$result[$i]['destino_id'];
			$tipo_servicio_mensajeria_id=$result[$i]['tipo_servicio_mensajeria_id'];
			//$tipo_envio_id=$result[$i]['tipo_envio_id'];

			//inicio calculo tarifa
			$peso=$result[$i]['peso']/1000;
			
			$peso_volumen=$result[$i]['peso_volumen'];
			
			if($peso>=$peso_volumen){
				$pesoreal=$peso; 
			}else{
				$pesoreal=$peso_volumen; 
			}
		
			$peso_adicional=$pesoreal-1;
			$valor=$result[$i]['valor'];
			$valor_otros=$result[$i]['valor_otros']>0?$result[$i]['valor_otros']:'0';
			$total=0;
			
			if($origen_id==$destino_id){ 
				$tipo_envio_id=2;
			}else{
				$tipo_envio_id=$Model -> getTipoEnvio1($destino_id,$this -> getConex());
			}
			
			if($Model -> getTipoEnvioMetro($origen_id,$destino_id,$this -> getConex()) ) $tipo_envio_id=2;	
			
			if($tipo_envio_id=='' || $tipo_envio_id=='NULL' || $tipo_envio_id==NULL || $tipo_envio_id=='null') exit('El destino '.$Model -> getNombre_destino($destino_id,$this -> getConex()).' no tiene asociado el tipo de envio');
			
			$tabla_esc = $Model -> getTabla($tipo_servicio_mensajeria_id,$this -> getConex());
			
			if($tabla_esc[0]['tabla']=='tarifas_mensajeria'){
				$resultado = $Model -> getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());
				if(!count($resultado)>0){
					$resultado = $Model -> getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());	
				}
			}else{
				$resultado = $Model -> getCalcularTarifaMasivoCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());	
				if(!count($resultado)>0){
					$resultado = $Model -> getCalcularTarifaMasivo($tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());	
				}
				
			}
			if(!count($resultado)>0){ exit('No existe Tarifas configuradas, Por favor verifique');	}
			
			$valor_decla=($valor*$resultado[0][porcentaje_seguro])/100;
		
			//$manejo = $Model -> getCalcularCosto($destino_id,date('Y'),$this -> getConex(),$this -> getOficinaId());
			$manejo = 0;
			//poner validacion en de tarifa masivo aqui y guiaclass y guiacrm
			if($tabla_esc[0]['tabla']=='tarifas_mensajeria'){
				if($pesoreal<1){
					$valorinicial=$resultado[0]['vr_kg_inicial_min'];
					
				}else{
					$valorinicial=$resultado[0]['vr_kg_inicial_max'];
				}
				$valorkilo_adi=$resultado[0]['vr_kg_adicional_min'];
				
				if($pesoreal<=1){
					$valor_kilos_adi=0;
				}else{
					$peso_adicional = ceil($peso_adicional);
					$valor_kilos_adi=$valorkilo_adi*$peso_adicional;
				}
				$valorinicial= $valorinicial+$valor_kilos_adi;
				$total=$valor_decla+$valorinicial+$manejo+$valor_otros;
			}else{//tarifa masivo
				$valorinicial=$resultado[0]['valor_min'];
				$total=$valor_decla+$valorinicial+$manejo+$valor_otros;
			}
			//fin calculo tarifa
			
			
			if($valor_total>0 && $total!=$valor_total){
				$resultado = $Model -> getActualizarValor($guia_id1,$tipo_envio_id, $total,$valor_decla,$valorinicial,$manejo,$valor_otros,$this -> getConex());	
				if($resultado>0){
					$mensaje.="Guia ".$numero_guia." Actualizada<br>";				
				}else{
					$mensaje.="Guia NO".$numero_guia." Actualizada<br>";				
				}
					
			}elseif($valor_total=='' || $valor_total==NULL || $valor_total==0){
				$resultado = $Model -> getActualizarValor($guia_id1,$tipo_envio_id, $total,$valor_decla,$valorinicial,$manejo,$valor_otros,$this -> getConex());	
				if($resultado>0){
					$mensaje.="Guia ".$numero_guia." Actualizada<br>";				
				}else{
					$mensaje.="Guia NO".$numero_guia." Actualizada<br>";	
				}
			}
			
		}

		$result1 = $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getOficinaId(),$consecutivo,$estado,$this -> getConex());

		if ($Model -> GetNumError() > 0) {
			exit('Ocurrio una inconsistencia.');
		}else{
			exit("$result1");
		}

	}



	public function setConsecutivo(){

		require_once("LiquidacionGuiasClienteModelClass.php");
		$Model = new LiquidacionGuiasClienteModel();

		$result = $Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex());
		// echo "$result";
		exit("$result");
	}

	public function getConsecutivo(){

		require_once("LiquidacionGuiasClienteModelClass.php");
		$Model = new LiquidacionGuiasClienteModel();
		$liquidacion_guias_cliente_id			= $_REQUEST['liquidacion_guias_cliente_id'];
		$result = $Model -> getConsecutivoReal($liquidacion_guias_cliente_id,$this -> getConex());
		// echo "$result";
		exit("$result");
	}

  protected function onclickCancellation(){  
		require_once("LiquidacionGuiasClienteModelClass.php");
		$Model = new LiquidacionGuiasClienteModel();

		$liquidacion_guias_cliente_id	=	$_REQUEST['liquidacion_guias_cliente_id'];
		$observacion_anulacion	=	$_REQUEST['observacion_anulacion'];
		$fecha_anulacion	=	date('Y-m-d H:i:s');
		$result = $Model -> cancellation($liquidacion_guias_cliente_id,$observacion_anulacion,$fecha_anulacion,$this -> getUsuarioId(),$this -> getConex());
		
		if($Model -> GetNumError() > 0){
			exit('false');
		}else{
			exit("true");
		}
	}

//BUSQUEDA
	protected function onclickFind(){

		require_once("LiquidacionGuiasClienteModelClass.php");

		$Model                   = new LiquidacionGuiasClienteModel();
		$liquidacion_guias_cliente_id = $_REQUEST['liquidacion_guias_cliente_id'];
		$Data  = $Model -> selectLiquidacionGuiasCliente($liquidacion_guias_cliente_id,$this -> getConex());
		$this -> getArrayJSON($Data);
	}

	public function GetValorPorFacturado(){

		require_once("LiquidacionGuiasClienteModelClass.php");
		$Model = new LiquidacionGuiasClienteModel();
		if($_REQUEST[guias_id]=='todas'){
			$result = $Model -> getValorPorFacturado($_REQUEST[cliente_id],$_REQUEST[desde],$_REQUEST[hasta],$this -> getConex());
		}else{
			$result = $Model -> getValorPorFacturadoInd($_REQUEST[guias_id],$_REQUEST[cliente_id],$_REQUEST[desde],$_REQUEST[hasta],$this -> getConex());
		}
		exit("$result");
	}

	protected function onclickPrint(){

		require_once("Imp_LiquidacionGuiasClass.php");
		$print = new Imp_LiquidacionGuiasClass($this -> getConex());
		$print -> printOut();
	}

	protected function setCampos(){

		//campos formulario

		$this -> Campos[liquidacion_guias_cliente_id] = array(
			name	=>'liquidacion_guias_cliente_id',
			id	=>'liquidacion_guias_cliente_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'20'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('primary_key'))
		);

		$this -> Campos[consecutivo] = array(
			name		=>'consecutivo',
			id			=>'consecutivo',
			disabled 	=>'disabled',
			type		=>'text',
			datatype=>array(
				type	=>'integer'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
			
		);

		$this -> Campos[oficina_id] = array(
			name	=>'oficina_id',
			id	    =>'oficina_id',
			type	=>'hidden',
			value   => $this -> getOficinaId(),
			datatype=>array(
				type	=>'integer'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
		);	

		$this -> Campos[usuario_id] = array(
			name	=>'usuario_id',
			id	    =>'usuario_id',
			type	=>'hidden',
			value   => $this -> getUsuarioId(),
			datatype=>array(
				type	=>'integer'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
		);	
		$this -> Campos[oficina_id1] = array(
			name	=>'oficina_id1',
			id	=>'oficina_id1',
			type	=>'select',
			//required=>'yes',
			options	=>array(),
			datatype=>array(
				type	=>'integer')
		);

		$this -> Campos[cliente] = array(
			name		=>'cliente',
			id			=>'cliente',
			type		=>'text',
			required	=>'yes',
			size		=>60,
			suggest=>array(
				name	=>'cliente',
				setId	=>'cliente_id'
			)
		);

		$this -> Campos[cliente_id] = array(
			name		=>'cliente_id',
			id			=>'cliente_id',
			type		=>'hidden',
			datatype=>array(
				type	=>'integer'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
		);


		$this -> Campos[fecha_inicial] = array(
			name	=>'fecha_inicial',
			id		=>'fecha_inicial',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'date',
				length	=>'10'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
			
		);
		$this -> Campos[fecha_final] = array(
			name	=>'fecha_final',
			id		=>'fecha_final',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'date',
				length	=>'10'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
			
		);

		$this -> Campos[fecha_registro] = array(
			name	=>'fecha_registro',
			id		=>'fecha_registro',
			type	=>'hidden',
			value	=>date('Y-m-d H:m'),
			datatype=>array(
				type	=>'text',
				length	=>'10'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
			
		);

		$this -> Campos[guias_id] = array(
			name	=>'guias_id',
			id		=>'guias_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'text',
				length	=>'150'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
			
		);

		$this -> Campos[valor] = array(
			name		=>'valor',
			id			=>'valor',
			readonly	=>'yes',
			required	=>'yes',
			type		=>'text',
			datatype=>array(
				type	=>'numeric'),
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
			
		);

		$this -> Campos[estado] = array(
			name		=>'estado',
			id			=>'estado',
			disabled 	=>'disabled',
			type		=>'select',
			selected	=>'L',
			required	=>'yes',
			transaction=>array(
				table	=>array('liquidacion_guias_cliente'),
				type	=>array('column'))
		);
		//anulacion
		
		 $this -> Campos[observacion_anulacion] = array(
		 	name	=>'observacion_anulacion',
		 	id		=>'observacion_anulacion',
		 	type	=>'textarea',
		 	value	=>'',
		 	required=>'yes',
		 	datatype=>array(
		 		type	=>'text')
		 );				
		
		//botones
		$this -> Campos[guardar] = array(
			name	=>'guardar',
			id		=>'guardar',
			type	=>'button',
			value	=>'Guardar'
		);

		$this -> Campos[anular] = array(
			name	=>'anular',
			id		=>'anular',
			type	=>'button',
			value	=>'Anular',
			onclick =>'onclickCancellation(this.form)'
		);

		$this -> Campos[imprimir] = array(
			name    =>'imprimir',
			id      =>'imprimir',
			type    =>'print',
			disabled=>'disabled',
			value   =>'Imprimir',
			displayoptions => array(
				form        => 0,
				beforeprint => 'beforePrint',
				title       => 'Impresion Liquidacion',
				width       => '900',
				height      => '600'
			)
		);

		$this -> Campos[importSolicitud] = array(
			name	=>'importSolicitud',
			id		=>'importSolicitud',
			type	=>'button',
			value	=>'Importar Guias'
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			onclick =>'LiquidacionOnReset(this.form)'
		);

		//busqueda
		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			suggest=>array(
				name	=>'liquidacion_guias_facturar',
				setId	=>'liquidacion_guias_cliente_id',
				onclick	=>'setDataFormWithResponse')
		);

		$this -> SetVarsValidate($this -> Campos);
	}
}
$LiquidacionGuiasCliente = new LiquidacionGuiasCliente();
?>