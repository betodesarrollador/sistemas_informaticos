<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleAnticipos extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetalleAnticiposLayoutClass.php");
    require_once("DetalleAnticiposModelClass.php");
	
    $Layout = new DetalleAnticiposLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleAnticiposModel();
	
    $Layout -> setIncludes();
	
	$manifiesto_id        = $_REQUEST['manifiesto_id'];
	$despachos_urbanos_id = $_REQUEST['despachos_urbanos_id'];
	
	if(is_numeric($manifiesto_id)){
	  $Layout -> setDataManifiesto($Model -> getDataManifiesto($manifiesto_id,$this -> getConex()));
      $Layout -> setAnticipos($Model -> getAnticipos($manifiesto_id,$this -> getConex()));
	  $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));
	  $Layout -> setDataDescuento($Model -> getTipoDescuento($this -> getConex()));
	}else{
	    $Layout -> setDataDespacho($Model -> getDataDespacho($despachos_urbanos_id,$this -> getConex()));	
        $Layout -> setAnticiposDespacho($Model -> getAnticiposDespacho($despachos_urbanos_id,$this -> getConex()));		
	    $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));	
		$Layout -> setDataDescuento($Model -> getTipoDescuento($this -> getConex()));
	}

	
    $Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("DetalleAnticiposModelClass.php");
    $Model = new DetalleAnticiposModel();
    $return = $Model -> Save($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
         exit(json_encode($return));
	}	

  }

  protected function onclickUpdate(){
  
    require_once("DetalleAnticiposModelClass.php");
	
    $Model = new DetalleAnticiposModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleAnticiposModelClass.php");
    $Model = new DetalleAnticiposModel();
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

	protected function onclickAnular(){

		require_once("DetalleAnticiposModelClass.php");
		$Model = new DetalleAnticiposModel();

		$Model -> Anular($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
			exit("Anticipo Anulado Exitosamente");
		}
	}

	protected function onclickAnularAnticipos(){

		require_once("DetalleAnticiposModelClass.php");
		$Model = new DetalleAnticiposModel();

		$manifiesto_id	= $_REQUEST['manifiesto_id'];
		$despacho_id	= $_REQUEST['despacho_id'];

		if ($manifiesto_id>0) {
			$anticipos_manifiesto=$Model -> getAnticiposManifiestoAnular($manifiesto_id,$this -> getConex());
			for ($i=0; $i < count($anticipos_manifiesto); $i++) { 
				$anticipos_manifiesto_id=$anticipos_manifiesto[$i][anticipos_manifiesto_id];
				$encabezado_registro_id=$anticipos_manifiesto[$i][encabezado_registro_id];

				$Model -> AnularAnticipos($anticipos_despacho_id,$anticipos_manifiesto_id,$encabezado_registro_id,$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
				if(strlen(trim($Model -> GetError())) > 0){
					exit("Error : ".$Model -> GetError());
				}
			}
			exit("Anticipos Anulados Exitosamente");
		}elseif ($despacho_id>0) {
			$anticipos_despacho=$Model -> getAnticiposDespachoAnular($despacho_id,$this -> getConex());

			for ($i=0; $i <count($anticipos_despacho_id) ; $i++) { 
				$anticipos_despacho_id=$anticipos_despacho[$i][anticipo_despacho_id];
				$encabezado_registro_id=$anticipos_despacho[$i][encabezado_registro_id];

				$Model -> AnularAnticipos($anticipos_despacho_id,$anticipos_manifiesto_id,$encabezado_registro_id,$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
				if(strlen(trim($Model -> GetError())) > 0){
					exit("Error : ".$Model -> GetError());
				}
			}
			exit("Anticipos Anulados Exitosamente");
		}else{
			exit("Datos necesarios vacios, por favor complete el formulario.");
		}

	}

	protected function setAnticipos(){
		require_once("DetalleAnticiposModelClass.php");
		$Model         = new DetalleAnticiposModel();

		$cantidad=0;
		$manifiesto_id	= $_REQUEST['manifiesto_id'];
		$encabezados = $Model -> getAnticiposManifiestoAnular($manifiesto_id,$this -> getConex());
		for ($i=0; $i < count($encabezados); $i++) {
			$anticipos = $Model -> getAnticiposManifiestoAnular1($encabezados[$i][encabezado_registro_id],$this -> getConex());
			$cantidad = ($cantidad+count($anticipos));
		}
		// exit($cantidad);
		exit("$cantidad");
		
	}

	protected function setAnticipos1(){
		require_once("DetalleAnticiposModelClass.php");
		$Model         = new DetalleAnticiposModel();

		$manifiesto_id	= $_REQUEST['manifiesto_id'];
		$anticipos_manifiesto = $Model -> getAnticiposManifiestoAnular($manifiesto_id,$this -> getConex());
		for ($i=0; $i < count($anticipos_manifiesto); $i++) { 
			$anticipo_manifiesto_id= $anticipos_manifiesto[$i][anticipos_manifiesto_id];
			$encabezado_registro_id= $anticipos_manifiesto[$i][encabezado_registro_id];
			if (empty($encabezado_registro_id)) {
				$Model -> AnularAnticipoSinGenerar($anticipo_manifiesto_id,$this -> getConex());
				if(strlen(trim($Model -> GetError())) > 0){
					exit("Error : ".$Model -> GetError());
				}
			}
		}
		exit("Anticipos sin generar anulados exitosamente.");
	}
  
  protected function setCuentasFormaPago(){
  
    require_once("DetalleAnticiposModelClass.php");
    require_once("DetalleAnticiposLayoutClass.php");	
	
    $Model         = new DetalleAnticiposModel();	
    $Layout        = new DetalleAnticiposLayout($this -> getTitleTab(),$this -> getTitleForm());	
	$forma_pago_id = $_REQUEST['forma_pago_id'];
    $cuentas       = $Model -> selectCuentasFormasPago($forma_pago_id,$this -> getConex());
	
	if(count($cuentas) > 0){
	  
	  $field['cuenta_tipo_pago_id'] = array(
	    name     => 'cuenta_tipo_pago',
		id       => 'cuenta_tipo_pago_id',
		type     => 'select',
		datatype => array( type => 'integer'),
		options  => $cuentas
	  );
	  
	  
	 print $Layout -> getObjectHtml($field['cuenta_tipo_pago_id']);
	  
	}else{
	    exit("No se han definido cuentas para esta forma de pago!!!");
	  }
  
  }

  protected function setTercerosFormaPago(){
  
    require_once("DetalleAnticiposModelClass.php");
    require_once("DetalleAnticiposLayoutClass.php");	
	
    $Model         = new DetalleAnticiposModel();	
    $Layout        = new DetalleAnticiposLayout($this -> getTitleTab(),$this -> getTitleForm());	
	$forma_pago_id = $_REQUEST['forma_pago_id'];
    $terceros       = $Model -> selectTercerosFormasPago($forma_pago_id,$this -> getConex());
	
	if(count($terceros) > 0){
	  
	  $field['forma_pago_tercero_id'] = array(
	    name     => 'forma_pago_tercero',
		id       => 'forma_pago_tercero_id',
		type     => 'select',
		datatype => array( type => 'integer'),
		options  => $terceros
	  );
	  
	  
	 print $Layout -> getObjectHtml($field['forma_pago_tercero_id']);
	  
	}
  
  }

//CAMPOS
  protected function setCampos(){

  }
	
	
	
}

$DetalleAnticipos = new DetalleAnticipos();

?>