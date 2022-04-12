<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ActividadModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function GetFase($Conex){
    
   $select = "SELECT b.fase_id AS value,
                     b.nombre AS text
             FROM fase b ORDER BY b.fase_id ASC";
   $result = $this->DbFetchAll($select,$Conex,true);          
    
    return $result;
    
  }  
  
  public function setAdjunto($actividad_id,$dir_file,$Conex){
     $update    = "UPDATE actividad_fase SET archivo='$dir_file' WHERE actividad_id= $actividad_id";
     $result    = $this -> query($update,$Conex,true);
     return $result;					  			
	  
  }

  public function selectBarrio($ubicacion_id,$barrio_id,$Conex){
    
   $select = "SELECT b.barrio_id AS value, b.nombre AS text,$barrio_id AS selected FROM barrio b WHERE b.comuna_id IN(SELECT comuna_id FROM comuna WHERE ubicacion_id=$ubicacion_id)ORDER BY b.nombre ASC ";
           
      $resul = $this->DbFetchAll($select,$Conex,true);          
    
    return $resul;
    
  }   
  		
  public function Save($Campos,$UsuarioId,$Conex){
    $this -> assignValRequest('usuario_id',$UsuarioId);
     $this -> assignValRequest('usuario_cierre_id',$UsuarioId);
    $this -> assignValRequest('fecha_registro',date('Y-m-d g-i-s'));
    $this -> DbInsertTable("actividad_fase",$Campos,$Conex,true,false);	
  }

	
  public function Update($actividad_id,$Campos,$UsuarioId,$Conex){	

    $select = "SELECT fecha_registro,usuario_id  FROM actividad_fase WHERE actividad_id = $actividad_id";
    
    $resul = $this->DbFetchAll($select,$Conex,true);  

    $this -> assignValRequest('usuario_actualiza_id',$UsuarioId);
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d g-i-s'));	
    $usuario_id = $resul[0]['usuario_id'];
    $fecha_registro = $resul[0]['fecha_registro'];
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_cierre_id',$usuario_id);
    $this -> assignValRequest('fecha_registro',$fecha_registro);

      $this -> DbUpdateTable("actividad_fase",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("actividad_fase",$Campos,$Conex,true,false);
	
  }			
  
    public function SaveCierre($actividad_id,$fecha_cierre,$fecha_cierre_real,$observacion_cierre,$usuario_cierre_id,$Conex){
     $update="UPDATE actividad_fase SET estado = 2, fecha_cierre='$fecha_cierre', fecha_cierre_real='$fecha_cierre_real', observacion_cierre='$observacion_cierre',usuario_cierre_id=$usuario_cierre_id WHERE actividad_id=$actividad_id";
     $result  = $this -> query($update,$Conex,true);

     return $result;	
  }
   
   public function selectActividad($Conex){
      
      $actividad_id = $this -> requestDataForQuery('actividad_id','integer');
      $select         = "SELECT m.actividad_id,
                                (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=m.responsable_id)AS responsable,
                                m.responsable_id,
                                m.nombre,
                                m.estado,
                                m.fase_id,
                                m.descripcion,
                                m.archivo,
                                m.prioridad,
                                m.fecha_inicial,
                                m.fecha_final,
                                m.fecha_inicial_real,
                                m.fecha_final_real
                        FROM actividad_fase m WHERE m.actividad_id = $actividad_id";	

      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function getQueryActividadGrid(){
         
     $Query = "SELECT m.actividad_id,
                      m.nombre,
                      (CASE m.estado WHEN 0 THEN 'INACTIVO' WHEN 1 THEN 'ACTIVO' ELSE 'CERRADO' END)AS estado,
                      m.fecha_inicial,
                      m.fecha_inicial_real,
                      m.fecha_final_real,
                      m.fecha_cierre,
                      m.fecha_cierre_real

              FROM actividad_fase m ORDER BY m.actividad_id DESC";
     return $Query;
   
   }
   

}


?>