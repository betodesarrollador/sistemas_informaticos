<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleAlistamiento extends Controler{


	public function __construct(){

		parent::__construct(3);

	}

	public function Main(){

		$this -> noCache();

		require_once("DetalleAlistamientoLayoutClass.php");
		require_once("DetalleAlistamientoModelClass.php");
		
		$Layout = new DetalleAlistamientoLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new DetalleAlistamientoModel();	

		$Layout -> 	setIncludes($this -> Campos);

		$Layout -> 	setDetallesAlistamiento($Model -> 	getDetallesAlistamiento ($this -> getConex()));	
		$Layout -> 	setOficina			 ($Model -> 	selectOficina		  ($this -> getConex()));	
		
		$Layout -> RenderMain();

	}

	protected function onclickValidateRow(){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
		$this -> getArrayJSON($Data -> GetData());
	}

	protected function onclickSave(){

		require_once("DetalleAlistamientoModelClass.php");

		$Model = new DetalleAlistamientoModel();

		 $cantidad          		= $_REQUEST['cantidad'];  
		 $serial					= $this -> requestDataForQuery('serial','alphanum');
		 $ubicacion_bodega_id       = $_REQUEST['ubicacion_bodega_id'];
		 $producto_id       = $_REQUEST['producto_id'];
		 $alistamiento_salida_id    			= $_REQUEST['alistamiento_salida_id'];

		$return = $Model -> Save($this -> Campos,$this -> getConex(),$cantidad,$serial,$ubicacion_bodega_id,$alistamiento_salida_id,$producto_id);

		exit($return);		

	}

	protected function onclickUpdate(){

		require_once("DetalleAlistamientoModelClass.php");

		$Model = new DetalleAlistamientoModel();

		 $cantidad          		= $_REQUEST['cantidad'];  
		 $serial               		= $_REQUEST['serial']; 
		 $producto_id       = $_REQUEST['producto_id']; 
		 $ubicacion_bodega_id       = $_REQUEST['ubicacion_bodega_id'];
		 $alistamiento_salida_id    			= $_REQUEST['alistamiento_salida_id'];
		 $alistamiento_salida_detalle_id    			= $_REQUEST['alistamiento_salida_detalle_id'];

		$Model -> Update($this -> Campos,$this -> getConex(),$producto_id,$cantidad,$serial,$ubicacion_bodega_id,$alistamiento_salida_id,$alistamiento_salida_detalle_id);

		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
			exit("true");
		}	

	}

	protected function setLeerCodigobar() {
		require_once("DetalleAlistamientoModelClass.php");
		$Model= new DetalleAlistamientoModel();
	
		$Data = $Model -> setLeerCodigobar($this -> getConex());
				
		if($Data[0][producto_id]>0){
					$this -> getArrayJSON($Data);
		}else{
			exit('No existe el producto');	
		}
		
  }

	protected function onclickDelete(){

		require_once("DetalleAlistamientoModelClass.php");

		$Model = new DetalleAlistamientoModel();

		$alistamiento_salida_detalle_id    = $_REQUEST['alistamiento_salida_detalle_id'];

		$Model -> Delete($this -> Campos,$this -> getConex(),$alistamiento_salida_detalle_id);

		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
			exit("true");
		}	 

	}



	protected function setCampos(){

		$this -> Campos[alistamiento_salida_id] = array(
			name	=>'alistamiento_salida_id',
			id		=>'alistamiento_salida_id',
			type	=>'hidden',
			value => $this -> requestData('alistamiento_salida_id'),
			required=>'no',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'11'),
			transaction=>array(
				table	=>array('wms_alistamiento_salida_detalle'),
				type	=>array('column'))
		);

		$this -> SetVarsValidate($this -> Campos);

	}


}

$DetalleAlistamiento = new DetalleAlistamiento();

?>