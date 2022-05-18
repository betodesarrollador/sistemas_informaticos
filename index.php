<?php 

//exit('Servidor Fuera de Servicio');

require_once("framework/clases/ValidaSuspension.php");
$valida_suspension  = new ValidaSuspension();
$valida_suspension->validateSuspension();

class Main{

  private $mozillaVersion;
  private $msieVersion; 
  private $operaVersion; 
  private $safariVersion;   

  public function __construct(){
 
	require_once("framework/clases/browser_class_inc.php"); 	
	$br = new browser();   
		 
	$this -> mozillaVersion = 15;
	$this -> msieVersion; 
	$this -> operaVersion; 
	$this -> safariVersion=70; 

	$this -> setDesk();
	
  }
    
  private function redirectMessageIncompatibility(){
     include_once("framework/tpl/Incompatibility.tpl.php"); 
  }
  
  private function setDesk(){
	require_once("framework/clases/AccesoClass.php"); 

	$Autenticar        = new Acceso(1);
	$Conex             = $Autenticar -> Conex;
	$OficinaId         = $Autenticar->OficinaId;
	$SessionActiva     = $Autenticar->SessionActiva;
	$MostrarEscritorio = $Autenticar->MostrarEscritorio;
	require_once("framework/clases/LogonClass.php");
	
	$Logon  = new Logon($Conex);
	$usuario_id = $Logon -> getUsuarioId();
	
	require_once("framework/clases/OficinaClass.php");
	
	$Oficina      = new Oficina($usuario_id,$OficinaId,$SessionActiva,$MostrarEscritorio,$Conex);
	$OficinaId    = $Oficina -> GetOficina();
	
	require_once("framework/clases/EscritorioClass.php");

	$Escritorio   = new Escritorio($usuario_id,$OficinaId,$SessionActiva,$Conex);
	$Escritorio -> GetEscritorio();
    
  }
  

}

new Main();

?>