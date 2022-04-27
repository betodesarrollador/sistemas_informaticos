<?php
require_once "../../../framework/clases/ControlerClass.php";
final class DetallesParametros extends Controler
{
    public function __construct()
    {
        parent::__construct(3);
    }
    
    public function Main()
    {

        $this->noCache();

        require_once "DetallesParametrosLayoutClass.php";
        require_once "DetallesParametrosModelClass.php";

        $Layout = new DetallesParametrosLayout();
        $Model  = new DetallesParametrosModel();

        $formato_exogena_id = $_REQUEST['formato_exogena_id'];
        $puc_id             = $_REQUEST['puc_id'];

        $Layout->setIncludes($this -> Campos);
        $Layout->setDetalles($Model->getDetalles($formato_exogena_id,$puc_id,$this->getConex()));
        $Layout->setTipo($Model->getTipo($formato_exogena_id,$puc_id,$this->getConex()));
        $Layout->setCentro($Model->getCentro($this->getConex()));
        $Layout->RenderMain();
    }
    
    protected function uploadFileAutomatically(){
  
        require_once("DetallesParametrosModelClass.php");
    
        $Model               = new DetallesParametrosModel();
        $ruta                = "../../../archivos/formato_exogena/";
        $archivo             = $_FILES['archivo_solicitud'];
        $nombreArchivo       = "formato_exogena_".rand();    
        $dir_file            = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);
        $camposArchivo       = $this -> excelToArray($dir_file,'ALL');
        $formato_exogena_id  = $_REQUEST['formato_exogena_id'];
        $puc_id              = $_REQUEST['puc_id'];
        
        if($formato_exogena_id>0){
            $Model -> setInsertDetalleExogena($camposArchivo,$formato_exogena_id,$this -> getConex()); 
        }else if($puc_id>0){
            $Model -> setInsertDetalleExogenaPC($camposArchivo,$puc_id,$this -> getConex()); 
        }
        
    
      } 
    
    protected function onclickValidateRow()
    {
        require_once "../../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), $this->Campos);
        echo json_encode($Data->GetData());
    }
    
    
    protected function onclickSave()
    {
        require_once "DetallesParametrosModelClass.php";
        $Model = new DetallesParametrosModel();
        $return = $Model->Save($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            if (is_numeric($return)) {
                exit("$return");
            } else {
                exit('false');
            }
        }
    }
    
    
    protected function onclickUpdate()
    {
        require_once "DetallesParametrosModelClass.php";
        $Model = new DetallesParametrosModel();
        $Model->Update($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            exit("true");
        }
    }

    protected function onclickDelete()
    {
        require_once "DetallesParametrosModelClass.php";
        $Model = new DetallesParametrosModel();
        $Model->Delete($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            exit("true");
        }
    }

    protected function generateFile(){

        require_once "DetallesParametrosModelClass.php";

        $Model  = new DetallesParametrosModel(); 		 	

        $data  = $Model->getDetallesExcelPC($_REQUEST['puc_id'],$this->getConex());
        
        $ruta  = $this -> arrayToExcel("parametrosExogena","Detalle parametros",$data);

        $this -> ForceDownload($ruta);

    }
    
    protected function setCampos(){  

        $formato_exogena_id = $_REQUEST['formato_exogena_id'];
        $puc_id             = $_REQUEST['puc_id'];

        if($formato_exogena_id>0){
    
        $this -> Campos[archivo_solicitud] = array(
            name	  =>'archivo_solicitud',
            id	  =>'archivo_solicitud',
            type	  =>'upload',
                    title     =>'Carga formato exogena',
                    parameters=> formato_exogena_id,
                    beforesend=>'validaSeleccionSolicitud',
                    onsuccess =>'onSendFile'
        );

       }else if($puc_id>0){
           $this -> Campos[archivo_solicitud] = array(
            name	  =>'archivo_solicitud',
            id	  =>'archivo_solicitud',
            type	  =>'upload',
                    title     =>'Carga formato exogena',
                    parameters=> puc_id,
                    beforesend=>'validaSeleccionSolicitud',
                    onsuccess =>'onSendFile'
        );
       }
        
        $this -> SetVarsValidate($this -> Campos);
      }
   
   
}
$DetallesParametros = new DetallesParametros();
