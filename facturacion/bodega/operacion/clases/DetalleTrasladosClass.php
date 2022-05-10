<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleTraslados extends Controler{


	public function __construct(){

		parent::__construct(3);

	}

	public function Main(){

		$this -> noCache();

		require_once("DetalleTrasladosLayoutClass.php");
		require_once("DetalleTrasladosModelClass.php");
		
		$Layout = new DetalleTrasladosLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new DetalleTrasladosModel();	

		$Layout -> 	setIncludes($this -> Campos);

		$Layout -> 	setDetallesTraslados($Model -> 	getDetallesTraslados ($this -> getConex()));	
		$Layout -> 	setOficina			 ($Model -> 	selectOficina		  ($this -> getConex()));	
		
		$Layout -> RenderMain();

	}

	protected function onclickValidateRow(){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
		$this -> getArrayJSON($Data -> GetData());
	}

	protected function onclickSave(){

		require_once("DetalleTrasladosModelClass.php");

		$Model = new DetalleTrasladosModel();

		 $cantidad          		= $_REQUEST['cantidad'];  
		 $serial					= $this -> requestDataForQuery('serial','alphanum');
		 $ubicacion_bodega_id       = $_REQUEST['ubicacion_bodega_id'];
		 $traslado_id    			= $_REQUEST['traslado_id'];
		 $entrada_id    			= $_REQUEST['entrada_id'];

		$return = $Model -> Save($this -> Campos,$this -> getConex(),$cantidad,$serial,$ubicacion_bodega_id,$traslado_id,$entrada_id);

		exit($return);		

	}

	protected function onclickUpdate(){

		require_once("DetalleTrasladosModelClass.php");

		$Model = new DetalleTrasladosModel();

		 $cantidad          		= $_REQUEST['cantidad'];  
		 $serial               		= $_REQUEST['serial'];  
		 $ubicacion_bodega_id       = $_REQUEST['ubicacion_bodega_id'];
		 $traslado_id    			= $_REQUEST['traslado_id'];
		 $traslado_detalle_id    			= $_REQUEST['traslado_detalle_id'];
		 $entrada_id    			= $_REQUEST['entrada_id'];

		$Model -> Update($this -> Campos,$this -> getConex(),$cantidad,$serial,$ubicacion_bodega_id,$traslado_id,$traslado_detalle_id,$entrada_id);

		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
			exit("true");
		}	

	}

	protected function setLeerCodigobar() {
		require_once("DetalleTrasladosModelClass.php");
		$Model= new DetalleTrasladosModel();
	
		$Data = $Model -> setLeerCodigobar($this -> getConex());
				
		if($Data[0][producto_id]>0){
					$this -> getArrayJSON($Data);
		}else{
			exit('No existe el producto');	
		}
		
  }

	protected function onclickDelete(){

		require_once("DetalleTrasladosModelClass.php");

		$Model = new DetalleTrasladosModel();

		$traslado_detalle_id    = $_REQUEST['traslado_detalle_id'];

		$Model -> Delete($this -> Campos,$this -> getConex(),$traslado_detalle_id);

		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
			exit("true");
		}	 

	}



	protected function setCampos(){

		$this -> Campos[traslado_id] = array(
			name	=>'traslado_id',
			id		=>'traslado_id',
			type	=>'hidden',
			value => $this -> requestData('traslado_id'),
			required=>'no',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'11'),
			transaction=>array(
				table	=>array('wms_traslado_detalle'),
				type	=>array('column'))
		);

		$this -> SetVarsValidate($this -> Campos);

	}


}

$DetalleTraslados = new DetalleTraslados();

?>