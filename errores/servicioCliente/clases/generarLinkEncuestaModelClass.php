<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TareaModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($TareaId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($TareaId,$Permiso,$Conex);
  }

  public function selectBarrio($ubicacion_id,$barrio_id,$Conex){
    
   $select = "SELECT b.barrio_id AS value, b.nombre AS text,$barrio_id AS selected FROM barrio b WHERE b.comuna_id IN(SELECT comuna_id FROM comuna WHERE ubicacion_id=$ubicacion_id)ORDER BY b.nombre ASC ";
           
      $resul = $this->DbFetchAll($select,$Conex,true);          
    
    return $resul;
    
  }  
  
  public function setAdjunto($actividad_programada_id,$dir_file,$Conex){
     $update    = "UPDATE actividad_programada SET archivo='$dir_file' WHERE actividad_programada_id= $actividad_programada_id";
     $result    = $this -> query($update,$Conex,true);
     return $result;					  			
	  
  }
  		
  public function Save($Campos,$UsuarioId,$Conex){
    $this -> assignValRequest('usuario_id',$UsuarioId);
     $this -> assignValRequest('usuario_cierre_id',$UsuarioId);
    $this -> assignValRequest('fecha_registro',date('Y-m-d g-i-s'));
    $this -> DbInsertTable("actividad_programada",$Campos,$Conex,true,false);	
  }

	
  public function Update($actividad_programada_id,$Campos,$UsuarioId,$Conex){	

    $select = "SELECT fecha_registro,usuario_id  FROM actividad_programada WHERE actividad_programada_id = $actividad_programada_id";
             
    $resul = $this->DbFetchAll($select,$Conex,true);  

    $this -> assignValRequest('usuario_actualiza_id',$UsuarioId);
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d g-i-s'));	
    $usuario_id = $resul[0]['usuario_id'];
    $fecha_registro = $resul[0]['fecha_registro'];
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('fecha_registro',$fecha_registro);

      $this -> DbUpdateTable("actividad_programada",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("actividad_programada",$Campos,$Conex,true,false);
	
  }	
  
  
  public function SaveCierre($actividad_programada_id,$fecha_cierre,$fecha_cierre_real,$observacion_cierre,$usuario_cierre_id,$Conex){
     $update="UPDATE actividad_programada SET estado = 2, fecha_cierre='$fecha_cierre', fecha_cierre_real='$fecha_cierre_real', observacion_cierre='$observacion_cierre',usuario_cierre_id=$usuario_cierre_id WHERE actividad_programada_id=$actividad_programada_id";
     $result  = $this -> query($update,$Conex,true);

     return $result;	
  }
   
   public function selectTarea($Conex){
      
      $actividad_programada_id = $this -> requestDataForQuery('actividad_programada_id','integer');

      $select         = "SELECT m.actividad_programada_id,
                                (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS cliente FROM tercero t,cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=m.cliente_id)AS cliente,
                                (SELECT c.cliente_id FROM tercero t,cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=m.cliente_id)AS cliente_id, 
                                m.nombre,
                                m.fecha_inicial,
                                m.fecha_final,
                                m.fecha_inicial_real,
                                m.fecha_final_real,
                                m.fecha_cierre,
                                m.prioridad,
                                m.descripcion,
                                m.archivo,
                                (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=m.responsable_id)AS responsable,
                                m.responsable_id,
                                m.estado
                                
                          FROM actividad_programada m WHERE m.actividad_programada_id = $actividad_programada_id";
                         	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function getQueryTareaGrid(){
         
     $Query = "SELECT m.actividad_programada_id,
                      m.nombre,
                      (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS cliente
                       FROM tercero t,cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=m.cliente_id)AS cliente,
                      m.fecha_inicial,
                      m.fecha_final,
                      m.fecha_inicial_real,
                      m.fecha_final_real,
                      m.fecha_cierre,
                      (CASE m.estado WHEN 0 THEN 'INACTIVO' WHEN 1 THEN 'ACTIVO' ELSE 'CERRADO' END)AS estado 
                       
              FROM actividad_programada m ORDER BY m.actividad_programada_id DESC";

     return $Query;
   
   }
   

}


?>