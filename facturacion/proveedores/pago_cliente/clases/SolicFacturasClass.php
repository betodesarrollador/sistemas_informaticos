<?php
require_once("../../../framework/clases/ControlerClass.php");
final class SolicFacturas extends Controler{
  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }

  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicFacturasLayoutClass.php");
    require_once("SolicFacturasModelClass.php");
	
	$Layout = new SolicFacturasLayout();
    $Model  = new SolicFacturasModel();
    $cliente_id 	= $_REQUEST['cliente_id'];
	$tipo_doc 		= $_REQUEST['tipo_doc'] = 17 ? 'NC' : 'RC';
	
    $Layout -> setIncludes();
    $Layout -> SetSolicFacturas($Model -> getSolicFacturas($cliente_id,$this -> getConex()));
	$Layout -> setDescuentos($Model -> getDescuentos($this -> getOficinaId(),$this -> getConex()));
	$Layout -> setMayor($Model -> getMayor($this -> getOficinaId(),$this -> getConex()));
	$Layout -> SetCampos($this -> Campos);
	$Layout -> SetTipo($tipo_doc);
    $Layout -> RenderMain();
    
  }
  
   public function buscarImpuesto(){
  
    require_once("SolicFacturasModelClass.php");
	require_once("UtilidadesContablesModelClass.php");
	
	$Model  = new SolicFacturasModel();
	$Utilidades  = new UtilidadesContablesModel();
	
	$base 	= $_REQUEST['base'];
	//$puc_id = $_REQUEST['puc_id'];
	$fecha 	= $_REQUEST['fecha'];
	$parametros_descuento_factura_id =  $_REQUEST['parametros_descuento_factura_id'];
	
	$num_descu = $_REQUEST['num_descu'];
   
    $periodo_contable_id = $Utilidades->getPeriodoContableId($fecha,$this->getConex());
	
	for($i=1;$i<=$num_descu;$i++){
		$puc_id[$i] = $Model -> selectImpuesto($_REQUEST['puc_id'.$i],$base,$periodo_contable_id,$this -> getConex());
	}
	
	
	//$data = $Model -> selectImpuesto($puc_id,$base,$periodo_contable_id,$this -> getConex());
	
	print json_encode($puc_id);
	
	
	
   }
  
  protected function SetCampos(){
		
	//botones
	$this -> Campos[adicionar] = array(
		name	=>'adicionar',
		id		=>'adicionar',
		type	=>'button',
		value=>'ADICIONAR'
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
}
$SolicFacturas = new SolicFacturas();
?>