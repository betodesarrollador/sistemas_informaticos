<?php
require_once("../../../framework/clases/ControlerClass.php");
final class CierreContado extends Controler{

	public function __construct(){
		parent::__construct(2);
	}

	public function Main(){

		$this -> noCache();
		require_once("CierreContadoLayoutClass.php");
		require_once("CierreContadoModelClass.php");

		$Layout   = new CierreContadoLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new CierreContadoModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setAnular   ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
		$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);


		$this -> SetVarsValidate($this -> Campos);
		$Layout -> SetTiposPago($Model -> GetTipoPago($this -> getConex()));
		$Layout -> SetDocumento($Model -> GetDocumento($this -> getConex()));
		$Layout -> setEstado		($Model -> getEstado());
		$Layout -> RenderMain();
	}

	protected function OnClickSave(){

		require_once("CierreContadoModelClass.php");
		$Model = new CierreContadoModel();

		$estado			= $_REQUEST['estado'];
		$consecutivo	= $Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex());
		$result = $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getOficinaId(),$consecutivo,$estado,$this -> getConex());
		
		if ($Model -> GetNumError() > 0) {
			exit('Ocurrio una inconsistencia.');
		}else{
			exit("$result");
		}

	}

	public function setConsecutivo(){

		require_once("CierreContadoModelClass.php");
		$Model = new CierreContadoModel();

		$result = $Model -> getConsecutivo($this -> getOficinaId(),$this -> getConex());
		// echo "$result";
		exit("$result");
	}

	public function getConsecutivo(){

		require_once("CierreContadoModelClass.php");
		$Model = new CierreContadoModel();
		$cierre_contado_id			= $_REQUEST['cierre_contado_id'];
		$result = $Model -> getConsecutivoReal($cierre_contado_id,$this -> getConex());
		// echo "$result";
		exit("$result");
	}

  protected function onclickCancellation(){  
		require_once("CierreContadoModelClass.php");
		$Model = new CierreContadoModel();

		$cierre_contado_id	=	$_REQUEST['cierre_contado_id'];
		$observacion_anulacion	=	$_REQUEST['observacion_anulacion'];
		$fecha_anulacion	=	date('Y-m-d H:i:s');
		$result = $Model -> cancellation($cierre_contado_id,$observacion_anulacion,$fecha_anulacion,$this -> getUsuarioId(),$this -> getConex());
		
		if($Model -> GetNumError() > 0){
			exit('false');
		}else{
			exit("true");
		}
	}

  protected function OnclickContabilizar(){

  	require_once("CierreContadoModelClass.php");
    $Model = new CierreContadoModel();
	
	$response = $Model -> contabilizar($this -> getEmpresaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }
    
  }


//BUSQUEDA
	protected function onclickFind(){

		require_once("CierreContadoModelClass.php");

		$Model                   = new CierreContadoModel();
		$cierre_contado_id = $_REQUEST['cierre_contado_id'];
		$Data  = $Model -> selectCierreContado($cierre_contado_id,$this -> getConex());
		$this -> getArrayJSON($Data);
	}

	public function GetValorPorFacturado(){

		require_once("CierreContadoModelClass.php");
		$Model = new CierreContadoModel();
		$result = $Model -> getValorPorFacturado($_REQUEST[cierre_contado_id],$this -> getConex());
		exit("$result");
	}

	protected function onclickPrint(){

		require_once("Imp_DocumentoClass.php");
		$print = new Imp_Documento();
		$print -> printOut($this -> getConex());
	}

	protected function setCampos(){

		//campos formulario

		$this -> Campos[cierre_contado_id] = array(
			name	=>'cierre_contado_id',
			id	=>'cierre_contado_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'20'),
			transaction=>array(
				table	=>array('cierre_contado'),
				type	=>array('primary_key'))
		);


		$this -> Campos[encabezado_registro_id] = array(
			name	=>'encabezado_registro_id',
			id	=>'encabezado_registro_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'integer',
				length	=>'20')
		);

		$this -> Campos[consecutivo] = array(
			name		=>'consecutivo',
			id			=>'consecutivo',
			disabled 	=>'disabled',
			type		=>'text',
			datatype=>array(
				type	=>'integer'),
			transaction=>array(
				table	=>array('cierre_contado'),
				type	=>array('column'))
			
		);

		$this -> Campos[cuenta_tipo_pago_id] = array(
			name	=>'cuenta_tipo_pago_id',
			id		=>'cuenta_tipo_pago_id',
			type	=>'select',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('cierre_contado'),
				type	=>array('column'))
			
		);

	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('cierre_contado'),
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
				table	=>array('cierre_contado'),
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
				table	=>array('cierre_contado'),
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
				table	=>array('cierre_contado'),
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
				table	=>array('cierre_contado'),
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
				table	=>array('cierre_contado'),
				type	=>array('column'))
			
		);


		$this -> Campos[valor] = array(
			name		=>'valor',
			id			=>'valor',
			readonly	=>'yes',
			//required	=>'yes',
			type		=>'text',
			datatype=>array(
				type	=>'numeric'),
			transaction=>array(
				table	=>array('cierre_contado'),
				type	=>array('column'))
			
		);

		$this -> Campos[estado] = array(
			name		=>'estado',
			id			=>'estado',
			disabled 	=>'disabled',
			type		=>'select',
			selected	=>'E',
			required	=>'yes',
			transaction=>array(
				table	=>array('cierre_contado'),
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

		$this -> Campos[contabilizar] = array(
			name	=>'contabilizar',
			id		=>'contabilizar',
			type	=>'button',
			value	=>'Contabilizar',
			onclick =>'OnclickContabilizar(this.form)'
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
				title       => 'Impresion Cierre',
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
				name	=>'cierre_contado',
				setId	=>'cierre_contado_id',
				onclick	=>'setDataFormWithResponse')
		);

		$this -> SetVarsValidate($this -> Campos);
	}
}
$CierreContado = new CierreContado();
?>