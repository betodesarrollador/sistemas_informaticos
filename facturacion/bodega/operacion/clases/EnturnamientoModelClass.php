<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EnturnamientoModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function getTipoVehiculo($Conex){

    $select = "SELECT tipo_vehiculo_id AS value,descripcion AS text FROM tipo_vehiculo ORDER BY descripcion";
    $result = $this -> DbFetchAll($select,$Conex,true); 
    return $result;
  }
  		
  public function Save($placa,$usuario_id,$wms_vehiculo_id,$Campos,$Conex){

  $marca_id = $_REQUEST['marca_id'];
  $tipo_vehiculo_id = $_REQUEST['tipo_vehiculo_id'];
	$color_id = $_REQUEST['color_id'];
	$soat = $_REQUEST['soat'];
	$tecnomecanica = $_REQUEST['tecnomecanica'];
	$nombre_conductor = $_REQUEST['nombre_conductor'];
	$cedula_conductor = $_REQUEST['cedula_conductor'];
	$telefono_conductor = $_REQUEST['telefono_conductor'];
  $telefono_ayudante = $_REQUEST['telefono_ayudante'];
  
  $select="SELECT wms_vehiculo_id FROM wms_enturnamiento WHERE estado NOT IN('F','A') AND wms_vehiculo_id = $wms_vehiculo_id ORDER BY enturnamiento_id DESC";
  $result  = $this -> DbFetchAll($select,$Conex,true);

  $vehiculo_enturnado = $result[0]['wms_vehiculo_id'];

  if($vehiculo_enturnado>0){
    return 0;
    exit();
  }else{

        $vehiculo_id = $this -> DbgetMaxConsecutive("wms_vehiculo","wms_vehiculo_id",$Conex,false,1);

        $this -> assignValRequest('fecha_registro',date('Y-m-d : h:i:s'));
        $this -> assignValRequest('usuario_id',$usuario_id);
        $this -> assignValRequest('placa',$placa);
        
        if($wms_vehiculo_id > 0){
          $this -> assignValRequest('wms_vehiculo_id',$wms_vehiculo_id);
          $this -> DbInsertTable("wms_enturnamiento",$Campos,$Conex,true,false);
            if($this -> GetNumError() > 0){
            return false;
            }else{
              $enturnamiento_id = $this -> DbgetMaxConsecutive("wms_enturnamiento","enturnamiento_id",$Conex,false,0);
            }
        }else{
            $this -> assignValRequest('wms_vehiculo_id',$vehiculo_id);
            $wms_vehiculo_id=$vehiculo_id;
            $fecha_registro=date('Y-m-d');

            $insert="INSERT INTO wms_vehiculo (wms_vehiculo_id,placa,marca_id,estado,usuario_id,fecha_registro,nombre_conductor,cedula_conductor,telefono_conductor,telefono_ayudante,tipo_vehiculo_id,color_id,soat,tecnomecanica) 
                    VALUES($wms_vehiculo_id,'$placa',$marca_id,'A',$usuario_id,'$fecha_registro','$nombre_conductor',$cedula_conductor,$telefono_conductor,$telefono_ayudante,$tipo_vehiculo_id,$color_id,$soat,$tecnomecanica)";
            
            $this -> query($insert,$Conex,true);

            $this -> DbInsertTable("wms_enturnamiento",$Campos,$Conex,true,false);
              if($this -> GetNumError() > 0){
                return false;
              }else{
                $enturnamiento_id = $this -> DbgetMaxConsecutive("wms_enturnamiento","enturnamiento_id",$Conex,false,0);
              }
            
          }
              
      return $enturnamiento_id;
    }
  }
	
  public function Update($placa,$usuario_actualiza_id,$wms_vehiculo_id,$Campos,$Conex){

    $marca_id = $_REQUEST['marca_id'];
    $tipo_vehiculo_id = $_REQUEST['tipo_vehiculo_id'];
    $color_id = $_REQUEST['color_id'];
    $soat = $_REQUEST['soat'];
    $tecnomecanica = $_REQUEST['tecnomecanica'];
    $nombre_conductor = $_REQUEST['nombre_conductor'];
    $cedula_conductor = $_REQUEST['cedula_conductor'];
    $telefono_conductor = $_REQUEST['telefono_conductor'];
    $telefono_ayudante = $_REQUEST['telefono_ayudante'];

    $vehiculo_id = $this -> DbgetMaxConsecutive("wms_vehiculo","wms_vehiculo_id",$Conex,false,1);

    $this -> assignValRequest('fecha_actualiza',date('Y-m-d : h:i:s'));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza_id);
    $this -> assignValRequest('placa',$placa);
    
    if($wms_vehiculo_id > 0){
      
       $this -> assignValRequest('wms_vehiculo_id',$wms_vehiculo_id);

       $update="UPDATE wms_vehiculo SET marca_id=$marca_id, tipo_vehiculo_id=$tipo_vehiculo_id, color_id=$color_id, soat=$soat, tecnomecanica=$tecnomecanica, nombre_conductor='$nombre_conductor', cedula_conductor=$cedula_conductor,telefono_conductor=$telefono_conductor,telefono_ayudante=$telefono_ayudante,usuario_actualiza_id=$usuario_actualiza_id, fecha_actualiza='$fecha_registro' 
                WHERE wms_vehiculo_id = $wms_vehiculo_id";
       $this -> query($update,$Conex,true);

       $this -> DbUpdateTable("wms_enturnamiento",$Campos,$Conex,true,false);
       	if($this -> GetNumError() > 0){
			   return false;
		    }else{
          $enturnamiento_id = $this -> DbgetMaxConsecutive("wms_enturnamiento","enturnamiento_id",$Conex,false,0);
        }
      }else{

        $this -> assignValRequest('wms_vehiculo_id',$vehiculo_id);
        $wms_vehiculo_id=$vehiculo_id;
        $this -> DbUpdateTable("wms_enturnamiento",$Campos,$Conex,true,false);
        	if($this -> GetNumError() > 0){
			      return false;
          }else{
            $enturnamiento_id = $this -> DbgetMaxConsecutive("wms_enturnamiento","enturnamiento_id",$Conex,false,0);
          }
        
        $fecha_registro=date('Y-m-d');

        $insert="INSERT INTO wms_vehiculo (wms_vehiculo_id,placa,marca_id,estado,usuario_id,fecha_registro,nombre_conductor,cedula_conductor,telefono_conductor,telefono_ayudante,tipo_vehiculo_id,color_id,soat,tecnomecanica) 
                 VALUES($wms_vehiculo_id,'$placa',$marca_id,'A',$usuario_actualiza_id,'$fecha_registro',$nombre_conductor,$cedula_conductor,$telefono_conductor,$telefono_ayudante,$tipo_vehiculo_id,$color_id,$soat,$tecnomecanica)";
      
        $this -> query($insert,$Conex,true);
      }
					
	 return $enturnamiento_id;
	
  }

  public function Cancellation($usuario_anula_id,$Campos,$Conex){		

    $enturnamiento_id = $this -> requestDataForQuery('enturnamiento_id','integer');
    $fecha_anula_turno = $this -> requestDataForQuery('fecha_anula_turno','date');
    $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');

  
        $update="UPDATE wms_enturnamiento SET estado = 'A', fecha_anula_turno = $fecha_anula_turno, observacion_anulacion = $observacion_anulacion, usuario_anula_id= $usuario_anula_id
                 WHERE enturnamiento_id=$enturnamiento_id";
      
        $this -> query($update,$Conex,true);
      
					
	 return $enturnamiento_id;
	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("wms_enturnamiento",$Campos,$Conex,true,false);
	
  }
  
 
   
   public function selectEnturnamiento($Conex){
      
      $enturnamiento_id = $this -> requestDataForQuery('enturnamiento_id','integer');
      $select         = "SELECT p.*,
                         (SELECT v.placa FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS placa,
                         (SELECT m.marca FROM marca m,wms_vehiculo v WHERE m.marca_id=v.marca_id AND v.wms_vehiculo_id=p.wms_vehiculo_id) AS marca,
                         (SELECT v.marca_id FROM wms_vehiculo v WHERE v.wms_vehiculo_id=p.wms_vehiculo_id) AS marca_id,
                         (SELECT v.tipo_vehiculo_id FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS tipo_vehiculo_id,
                         (SELECT c.color FROM color c,wms_vehiculo v WHERE c.color_id=v.color_id AND v.wms_vehiculo_id=p.wms_vehiculo_id) AS color,
                         (SELECT v.color_id FROM wms_vehiculo v WHERE v.wms_vehiculo_id=p.wms_vehiculo_id) AS color_id,
                         (SELECT v.soat FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS soat,
                         (SELECT v.tecnomecanica FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS tecnomecanica,
                         (SELECT v.nombre_conductor FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS nombre_conductor,
                         (SELECT v.cedula_conductor FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS cedula_conductor,
                         (SELECT v.telefono_conductor FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS telefono_conductor,
                         (SELECT v.telefono_ayudante FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS telefono_ayudante,
                         (SELECT m.nombre FROM wms_muelle m WHERE p.muelle_id=m.muelle_id) AS muelle  
                         FROM wms_enturnamiento p WHERE enturnamiento_id = $enturnamiento_id";
                      	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function selectVehiculo($wms_vehiculo_id,$Conex){
  
    $select = "SELECT v.wms_vehiculo_id,
                     v.placa,
                     v.marca_id,
                     (SELECT m.marca FROM marca m WHERE m.marca_id=v.marca_id) AS marca,
                     v.color_id,
                     (SELECT c.color FROM color c WHERE c.color_id=v.color_id) AS color,
                     v.estado,
                     v.nombre_conductor,
                     v.cedula_conductor,
                     v.telefono_conductor,
                     v.telefono_ayudante,
                     v.tipo_vehiculo_id,
                     v.soat,
                     v.tecnomecanica
	             FROM wms_vehiculo v WHERE v.wms_vehiculo_id = $wms_vehiculo_id AND v.estado='A'";	  
  
	$result = $this -> DbFetchAll($select,$Conex,false);

	return $result; 
  
  } 

   public function getQueryEnturnamientoGrid(){
         
     $Query = "SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',enturnamiento_id,')\">',p.enturnamiento_id,'</a>' )AS enturnamiento_id,
                      p.fecha,
                      (SELECT v.placa FROM wms_vehiculo v WHERE v.wms_vehiculo_id=p.wms_vehiculo_id)AS vehiculo,
                      IF(p.estado='B','BLOQUEADO',IF(p.estado='L','LEGALIZADO',IF(p.estado='A','ANULADO','DISPONIBLE')))AS estado, 
                      (SELECT u.nombre FROM wms_muelle u WHERE u.muelle_id=p.muelle_id) AS muelle,
                      p.fecha_anula_turno, 
		                  p.fecha_registro,
                      p.fecha_actualiza FROM wms_enturnamiento p";
                      
     return $Query;
   
   }
   

}


?>