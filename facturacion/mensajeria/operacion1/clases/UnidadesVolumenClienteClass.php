<?php

require_once("../../../framework/clases/ControlerClass.php");

final class UnidadesVolumenCliente extends Controler{

  public function __construct(){
    parent::__construct(3);	  
  }

  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  

    $this -> Campos[cliente_id] = array(
	name	=>'cliente_id',
	id	=>'cliente_id',
	type	=>'select',
	options	=>array()
    );  
    
    $this -> Campos[archivo_solicitud] = array(
	name	  =>'archivo_solicitud',
	id	  =>'archivo_solicitud',
	type	  =>'upload',
        title     =>'Carga de Archivos Clientes',
        parameters=>'cliente_id',
        beforesend=>'validaSeleccionSolicitud',
        onsuccess =>'onSendFile'
    );    
  
    $this -> Campos[guardar] = array(
	name	=>'guardar',
	id	=>'guardar',
	type	=>'button',
	value	=>'Guardar'
    );
    
    
    $this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache(); 
    
    require_once("UnidadesVolumenClienteLayoutClass.php");
    require_once("UnidadesVolumenClienteModelClass.php");
	
    $Layout   = new UnidadesVolumenClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new UnidadesVolumenClienteModel();    

    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));           
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    	
		
    $Layout -> RenderMain();
    
  }

  protected function uploadFileAutomatically(){
  
    require_once("UnidadesVolumenClienteModelClass.php");

    $Model           = new UnidadesVolumenClienteModel();
  
    $this -> upload_max_filesize("2048M");
        
    $cliente_id      = $_REQUEST['cliente_id'];            
    $archivoPOST     = $_FILES['archivo_solicitud'];
    $rutaAlmacenar   = "../../../archivos/transporte/solicitud_servicio/";
    
    $dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"archivoCamposSolicitud");    
    $camposArchivo   = $this -> excelToArray($dir_file,$rowLimit = 0);
    
    $Model -> setCamposArchivo($camposArchivo,$cliente_id,$this -> getConex());
    
    
    


  }
  
  
  protected function setDetalleUnidadesVolumenCliente(){
  
    require_once("UnidadesVolumenClienteModelClass.php");
	
    $Model         = new UnidadesVolumenClienteModel();    
    $camposArchivo = $_REQUEST['campos_archivo']; 
    $cliente_id    = $_REQUEST['cliente_id'];
    
    $Model -> saveDetalleUnidadesVolumenCliente($cliente_id,$camposArchivo,$this -> getConex());    
    
  
  }
	
	
}

$UnidadesVolumenCliente = new UnidadesVolumenCliente();

?>