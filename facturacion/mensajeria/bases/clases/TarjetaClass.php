<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Tarjeta extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[archivo_solicitud] = array(
		name	  =>'archivo_solicitud',
		id	  =>'archivo_solicitud',
		type	  =>'upload',
                title     =>'Carga de Archivos Tarjetas',
                parameters=>'cliente_id',
                beforesend=>'validaSeleccionSolicitud',
                onsuccess =>'onSendFile'
	);


	$this -> Campos[cliente_id] = array(
		name	 => 'cliente_id',
		id	 => 'cliente_id',
		type	 => 'hidden'
	);

	$this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("TarjetaLayoutClass.php");
    require_once("TarjetaModelClass.php");
	
    $Layout   = new TarjetaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TarjetaModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> RenderMain();
    
  }
  
  protected function getArrayInsert($dir_file){
  
    $fileContent = $this -> excelToArray($dir_file);
    $keys        = $fileContent[0];
    $arrayInsert = array();
    
    for($i = 1; $i <= count($fileContent); $i++){
    
      foreach($keys as $llave => $valor){
        $arrayInsert[$i][$valor] = $fileContent[$i][$llave];
      }
      
    }
        
    return array_values($arrayInsert); 
  
  }

  protected function uploadFileAutomatically(){
  
    require_once("TarjetaModelClass.php");

    $Model         = new TarjetaModel();
    $ruta          = "../../../archivos/mensajeria/solicitud_servicios/";
    $archivo       = $_FILES['archivo_solicitud'];
    $nombreArchivo = "tarjetas_".rand();    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);
    $camposArchivo = $this -> excelToArray($dir_file,$rowLimit = 0);

    
    $errorLog      = '';

    
	$arrayInsert = $this -> getArrayInsert($dir_file);          
	$linea       = 2;
	
	for($i = 0; $i < count($arrayInsert) - 1; $i++){
	
		$errorLogTmp = '';
		$sql_valida ='';
			
		$errorLogTmp = $Model -> setInsertDetalleSolicitud($arrayInsert[$i],$this -> getOficinaId(),$this -> getUsuarioId(),$this -> getConex());      
		
		if(strlen(trim($errorLogTmp)) > 0){
		  $errorLog .= "LINEA[ $linea ] : $errorLogTmp\n";
		}
		$linea++;
	}    

    
	if(strlen(trim($errorLog)) > 0){
		print $errorLog;
	}else{
		print "La totalidad de las tarjetas del archivo fueron registradas con Exito";
	}


  }
	
}

$Tarjeta = new Tarjeta();

?>