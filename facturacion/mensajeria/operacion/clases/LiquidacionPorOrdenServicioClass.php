<?php 
require_once("../../../framework/clases/ControlerClass.php"); 

final class LiquidacionPorOrdenServicio extends Controler{ 

	public function __construct(){
		parent::__construct(2);
	}

	public function Main(){

		$this -> noCache();
		require_once("LiquidacionPorOrdenServicioLayoutClass.php");
		require_once("LiquidacionPorOrdenServicioModelClass.php");

		$Layout   = new LiquidacionPorOrdenServicioLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new LiquidacionPorOrdenServicioModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);
		$Layout -> setEstado		($Model -> getEstado());
		// $Layout -> setConsecutivo	($Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex()));
		$this -> SetVarsValidate($this -> Campos);
		// $Layout -> setOficinas   ($Model -> selectOficinas($this -> getEmpresaId(),$this -> getConex())); 
		// echo 'si';
		$Layout -> RenderMain();
	}

	protected function OnClickSave(){

		require_once("LiquidacionPorOrdenServicioModelClass.php");
		$Model = new LiquidacionPorOrdenServicioModel();

		$consecutivo	=	$Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex());

		$result = $Model -> Save($this -> Campos,$this -> getUsuarioId(), $this -> getOficinaId(),$consecutivo,$this -> getConex());
		if ($Model -> GetNumError() > 0) {
			exit('Ocurrio una inconsistencia.');
		}else{
			exit("$result");
		}

	}

	public function setConsecutivo(){

		require_once("LiquidacionPorOrdenServicioModelClass.php");
		$Model = new LiquidacionPorOrdenServicioModel();

		$result = $Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex());
		// echo "$result";
		exit("$result");
	}

	protected function OnClickCancel(){

		require_once("LiquidacionPorOrdenServicioModelClass.php");
		$Model = new LiquidacionPorOrdenServicioModel();

		$observacion	=	$_REQUEST['observacion_anulacion'];
		$cliente_id		=	$_REQUEST['cliente_id'];
		$consecutivo	=	$_REQUEST['consecutivo'];
		$liquidacion_id	=	$_REQUEST['liquidacion_id'];
		$result = $Model -> Cancel($this -> getUsuarioId(),$liquidacion_id,$observacion,$cliente_id,$consecutivo,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit("$result");
		}
	}

	protected function selectSolicitudes(){

		require_once("LiquidacionPorOrdenServicioModelClass.php");
		$Model = new LiquidacionPorOrdenServicioModel();
		$liquidacion_id = $_REQUEST['liquidacion_id'];
		// echo "$liquidacion_id";
		$return = $Model -> selectSolicitudes($liquidacion_id,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			for ($i=0; $i < count($return); $i++) { 
				// echo "<br>";
				if ($result!='') {
					$result = $result.",".$return[$i][solicitud_id];
				}else{
					$result = $return[$i][solicitud_id];
				}
			}
			exit("$result");
		}
	}

	protected function OnClickPrint(){

		require_once("Imp_LiquidacionPorOrdenServicioClass.php");
		$print = new Imp_LiquidacionPorOrdenServicioClass($this -> getConex());
		$print -> printOut();
	}
	
//BUSQUEDA
	protected function onclickFind(){

		require_once("LiquidacionPorOrdenServicioModelClass.php");

		$Model			= new LiquidacionPorOrdenServicioModel();
		$liquidacion_id	= $_REQUEST['liquidacion_id'];
		$Data  = $Model -> selectLiquidacionPorOrdenServicio($liquidacion_id,$this -> getConex());
		$this -> getArrayJSON($Data);
	}

	protected function setCampos(){

		//campos formulario

		$this -> Campos[liquidacion_id] = array(
			name		=>'liquidacion_id',
			id			=>'liquidacion_id',
			type		=>'hidden',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'20'),
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('primary_key'))
		);

		$this -> Campos[cliente] = array(
			name		=>'cliente',
			id			=>'cliente',
			type		=>'text',
			required	=>'yes',
			suggest=>array(
				name	=>'cliente',
				setId	=>'cliente_id')
		);

		$this -> Campos[cliente_id] = array(
			name		=>'cliente_id',
			id			=>'cliente_id',
			type		=>'hidden',
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('column'))
		);

		$this -> Campos[oficina_id] = array(
			name		=>'oficina_id',
			id			=>'oficina_id',
			type		=>'hidden',
			value		=>$this -> getOficinaId(),
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('column'))
		);

		$this -> Campos[usuario_id] = array(
			name		=>'usuario_id',
			id			=>'usuario_id',
			type		=>'hidden',
			value		=>$this -> getUsuarioId(),
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('column'))
		);

		$this -> Campos[estado] = array(
			name		=>'estado',
			id			=>'estado',
			disabled 	=>'disabled',
			type		=>'select',
			required	=>'yes',
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('column'))
		);

		$this -> Campos[consecutivo] = array(
			name		=>'consecutivo',
			id			=>'consecutivo',
			disabled 	=>'disabled',
			type		=>'text',
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
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
				table	=>array('liquidacion_sol_serv_guia'),
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
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('column'))
		);

		$this -> Campos[fecha_liquidacion] = array(
			name	=>'fecha_liquidacion',
			id		=>'fecha_liquidacion',
			type	=>'hidden',
			value	=>'',
			transaction=>array(
				table	=>array('liquidacion_sol_serv_guia'),
				type	=>array('column'))
		);

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
		
		$this -> Campos[importSolicitud] = array(
			name	=>'importSolicitud',
			id		=>'importSolicitud',
			type	=>'button',
			value	=>'Importar Solicitud'
		);

		$this -> Campos[guardar] = array(
			name	=>'guardar',
			id		=>'guardar',
			type	=>'button',
			disabled=>'disabled',
			value	=>'Guardar',
			onclick =>'OnClickSave(this.form)'
		);
		
		$this -> Campos[anular] = array(
			name    =>'anular',
			id      =>'anular',
			type    =>'button',
			value   =>'Anular',
			onclick =>'OnClickCancel(this.form)'
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar'
		);

		$this -> Campos[imprimir] = array(
			name    =>'imprimir',
			id      =>'imprimir',
			type	=>'button',
			disabled=>'disabled',
			value   =>'Imprimir',
			onclick =>'OnClickPrint(this.form)'
		);

		//busqueda
		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			suggest=>array(
				name	=>'liquidacion_solicitud',
				setId	=>'liquidacion_id',
				onclick	=>'setDataFormWithResponse')
		);

		$this -> SetVarsValidate($this -> Campos);
	}
}
$LiquidacionPorOrdenServicio = new LiquidacionPorOrdenServicio();
?>