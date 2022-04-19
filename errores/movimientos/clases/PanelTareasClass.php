<?php
require_once("../../../framework/clases/ControlerClass.php");

final class PanelTareas extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("PanelTareasLayoutClass.php");
	require_once("PanelTareasModelClass.php");
	
	$Layout = new PanelTareasLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new PanelTareasModel();
	
	$Layout -> SetCampos($this -> Campos);

   $tipos = $Model -> selectTipos($this -> getConex());

   $Layout -> setVar("TIPO_TAREA",$tipos);

    $Layout -> RenderMain();    
  }  


   public function getValores($Conex){
  
      require_once("PanelTareasModelClass.php"); 
     
      $Model = new PanelTareasModel();
    
      $Data  = $Model -> selectValores($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

     public function getActividades($Conex){
  
      require_once("PanelTareasModelClass.php"); 
     
	  $Model = new PanelTareasModel();
    
      $Data  = $Model -> selectActividades($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   } 


   public function guardarObservacion($Conex=''){
  
      require_once("PanelTareasModelClass.php"); 
     
	  $Model = new PanelTareasModel();
	  
	  $actividad_id = $_REQUEST['actividad_id'];
	  $observacion = $_REQUEST['observacion'];
    
      $Data  = $Model -> saveObservacion($actividad_id,$observacion,$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         print $Data; 
      } 
      
   }

   protected function sendCorreos($data,$i){

      require_once("../../../framework/clases/MailClass.php");
   
      $enviar_mail  = new Mail();	

      $fecha_inicial     = date_create($data[0]['fecha_inicial']);
      $fecha_final       = date_create($data[0]['fecha_final']);
      $fecha_cierre_real = date_create($data[0]['fecha_cierre_real']);
      $interval          = date_diff($fecha_inicial, $fecha_final);
      $interval_real     = date_diff($fecha_inicial, $fecha_cierre_real);
      $tipo_tarea        = $data[0]['tipo_tarea'];

      $dias      = $interval->days;

      if($fecha_inicial>$fecha_cierre_real){
         
         $dias_real = 'La tarea se culmina antes de lo estipulado';

      }else{

         $dias_real = $interval_real->days;
      }
      
      $mail_subject = "Tarea finalizada, codigo ".$data[0]['codigo'];
   
      $body='
         <table width="95%"   cellspacing="1">
            
            <tr>
               <td  align="left" colspan="2">
                  
                  Informacion general de la tarea.<br><br>
                  
               </td>
            </tr> 
   
            <tr>
               <td  align="left">Area :</td>
               <td  align="left">'.$tipo_tarea.'</td>
            </tr> 
            <tr>
               <td  align="left">Cliente(s) :</td>
               <td  align="left">'.$data[0]['cliente'].'</td>
            </tr> 
            <tr>
               <td  align="left">Nombre :</td>
               <td  align="left">'.$data[0]['nombre'].'</td>
            </tr> 
            <tr>
               <td  align="left">Descripcion :</td>
               <td  align="left">'.$data[0]['descripcion'].'</td>
            </tr> 
            <tr>
               <td  align="left">Responsable :</td>
               <td  align="left">'.$data[0]['responsable'].'</td>
            </tr> 
            <tr>
               <td  align="left">Fecha inicial :</td>
               <td  align="left">'.$data[0]['fecha_inicial'].'</td>
            </tr> 
            <tr>
               <td  align="left">Fecha final :</td>
               <td  align="left">'.$data[0]['fecha_final'].'</td>
            </tr> 

            <tr>
               <td  align="left">Dias estipulados para la tarea:</td>
               <td  align="left">'.$dias.'</td>
            </tr> 

            <tr>
               <td  align="left">Dias reales tomados para el requerimiento:</td>
               <td  align="left">'.$dias_real.'</td>
            </tr> 
   
            <tr>
               <td  align="left">
                  <br><br>
                  Cordialmente,<br /><br />
                  <img src="https://siandsi1.co/sistemas_informaticos/framework/media/images/varios/logosiandsi.jpg" alt="logo" width="125" /><br>
                  <strong>Sistemas informaticos y soluciones integrales</strong>
                  
               </td>
            </tr> 
          </table>';
   
      
         $enviar_mail->sendMail($data[$i]['email'],$mail_subject,$body);/* soporte@siandsi.co */
      
   
         if(!$enviar_mail) die('error enviando correo :'.$enviar_mail);
   }

   public function guardarCierre(){
  
      require_once("PanelTareasModelClass.php"); 
     
	   $Model = new PanelTareasModel();
	
      $data  = $Model -> saveCierre($this->getUsuarioId(),$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      
      }else{

         for ($i=0; $i < count($data); $i++) { 

            if($data[$i]['email']!=''){
   
               $this->sendCorreos($data,$i);
            }
   
         }

         print 'true';
      } 
      
   }

   public function pendienteSocializar(){
  
      require_once("PanelTareasModelClass.php"); 
     
	   $Model = new PanelTareasModel();
	
      $data  = $Model -> pendienteSocializar($this->getUsuarioId(),$this -> getConex());

      print 'true';
      
   }

   public function finalizar(){
  
      require_once("PanelTareasModelClass.php"); 
     
	   $Model = new PanelTareasModel();
	
      $data  = $Model -> finalizar($this -> getConex());

      for ($i=0; $i < count($data); $i++) { 

         if($data[$i]['email']!=''){

            $this->sendCorreos($data,$i);
         }

      }

      print 'true';
      
   }

   public function getObservaciones($Conex=''){
  
      require_once("PanelTareasModelClass.php"); 
     
      $Model = new PanelTareasModel();
    
      $actividad_id = $_REQUEST['actividad_id'];
      $Data  = $Model -> selectObservaciones($actividad_id,$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

  protected function SetCampos(){
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);


	$this -> Campos[proyecto] = array(
		name	=>'proyecto',
		id		=>'proyecto',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);


	$this -> SetVarsValidate($this -> Campos);
	}
  
  
}

new PanelTareas();

?>