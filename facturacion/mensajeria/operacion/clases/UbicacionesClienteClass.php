<?php

require_once("../../../framework/clases/ControlerClass.php");

final class UbicacionesCliente extends Controler{

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
    
    require_once("UbicacionesClienteLayoutClass.php");
    require_once("UbicacionesClienteModelClass.php");
	
    $Layout   = new UbicacionesClienteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new UbicacionesClienteModel();    

    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));           
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    	
		
    $Layout -> RenderMain();
    
  }

  protected function uploadFileAutomatically(){
  
    require_once("UbicacionesClienteModelClass.php");

    $Model           = new UbicacionesClienteModel();
  
    $this -> upload_max_filesize("2048M");
        
    $cliente_id      = $_REQUEST['cliente_id'];            
    $archivoPOST     = $_FILES['archivo_solicitud'];
    $rutaAlmacenar   = "../../../archivos/transporte/solicitud_servicio/";
    
    $dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"archivoCamposSolicitud");    
    $camposArchivo   = $this -> excelToArray($dir_file,$rowLimit = 0);
    
  }
  
  
  protected function setDetalleUbicacionesCliente(){
    
    require_once("UbicacionesClienteModelClass.php");
	
    $Model         = new UbicacionesClienteModel();    
    $ubicaciones   = $_REQUEST['ubicaciones']; 
    $cliente_id    = $_REQUEST['cliente_id'];
    	
    if($Model -> saveDetalleUbicacionesCliente($cliente_id,$ubicaciones,$this -> getConex())){    
      print 'true';    
    }    
    
  
  }
	
	
}

$UbicacionesCliente = new UbicacionesCliente();

?>