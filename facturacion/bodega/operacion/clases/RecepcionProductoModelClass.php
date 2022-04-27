<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RecepcionProductoModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($enturnamiento_id,$camposArchivo,$Campos,$Conex){
    
       

         for($i=1; $i<count($camposArchivo); $i++){
		 
				$enturnamiento_detalle_id = $this -> DbgetMaxConsecutive("wms_enturnamiento_detalle","enturnamiento_detalle_id",$Conex,true,1);   
				$insert = "INSERT INTO wms_enturnamiento_detalle (
                                       enturnamiento_detalle_id,
                                       enturnamiento_id,
                                       producto_id,
                                       serial,
                                       cantidad
								) 
						 VALUES ($enturnamiento_detalle_id,
                                 $enturnamiento_id,
                                 (SELECT producto_id FROM wms_producto_inv WHERE codigo_barra = '".$camposArchivo[$i][0]."'),
                                 '".trim($camposArchivo[$i][1])."',
								 '".trim($camposArchivo[$i][2])."' 							 
                                 )";
                                 
				$this -> query($insert,$Conex,true);
				
				if($this -> GetNumError() > 0){
				 $this -> Rollback($Conex);	
				 return false;
				}
			}
					
	 
            return $enturnamiento_id;
        
    	
  }
	
  public function Update($placa,$usuario_actualiza_id,$wms_vehiculo_id,$Campos,$Conex){		

    $vehiculo_id = $this -> DbgetMaxConsecutive("wms_vehiculo","wms_vehiculo_id",$Conex,false,1);

    $this -> assignValRequest('fecha_actualiza',date('Y-m-d : h:i:s'));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza_id);
    $this -> assignValRequest('placa',$placa);
    
    if($wms_vehiculo_id > 0){
      
       $this -> assignValRequest('wms_vehiculo_id',$wms_vehiculo_id);
       $this -> DbUpdateTable("wms_enturnamiento",$Campos,$Conex,true,false);
       	if($this -> GetNumError() > 0){
			   return false;
		    }else{
          $enturnamiento_id = $this -> DbgetMaxConsecutive("wms_enturnamiento","enturnamiento_id",$Conex,false,1);
        }
      }else{

        $this -> assignValRequest('wms_vehiculo_id',$vehiculo_id);
        $wms_vehiculo_id=$vehiculo_id;
        $this -> DbUpdateTable("wms_enturnamiento",$Campos,$Conex,true,false);
        	if($this -> GetNumError() > 0){
			      return false;
          }else{
            $enturnamiento_id = $this -> DbgetMaxConsecutive("wms_enturnamiento","enturnamiento_id",$Conex,false,1);
          }
        
        $fecha_registro=date('Y-m-d');

        $insert="INSERT INTO wms_vehiculo (wms_vehiculo_id,placa,estado,usuario_id,fecha_registro) 
                 VALUES($wms_vehiculo_id,'$placa','A',$usuario_actualiza_id,'$fecha_registro')";
      
        $this -> query($insert,$Conex,true);
      }
					
	 return $enturnamiento_id;
	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("wms_enturnamiento",$Campos,$Conex,true,false);
	
  }
  
  public function Salida($usuario_salida_id,$Campos,$Conex){		

    $enturnamiento_id = $this -> requestDataForQuery('enturnamiento_id','integer');
    $fecha_salida_turno = $this -> requestDataForQuery('fecha_salida_turno','date');
    $observacion_salida = $this -> requestDataForQuery('observacion_salida','text');

  
        $update="UPDATE wms_enturnamiento SET estado = 'F', fecha_salida_turno = $fecha_salida_turno, observacion_salida = $observacion_salida, usuario_salida_id= $usuario_salida_id
                 WHERE enturnamiento_id=$enturnamiento_id";
      
        $this -> query($update,$Conex,true);
      
					
	 return $enturnamiento_id;
	
  }
   
   public function selectEnturnamiento($Conex){
      
      $enturnamiento_id = $this -> requestDataForQuery('enturnamiento_id','integer');
      $select         = "SELECT p.*,
                         (SELECT v.placa FROM wms_vehiculo v WHERE p.wms_vehiculo_id=v.wms_vehiculo_id) AS placa,
                         (SELECT m.nombre FROM wms_muelle m WHERE p.muelle_id=m.muelle_id) AS muelle,
                         (SELECT m.muelle_id FROM wms_muelle m WHERE p.muelle_id=m.muelle_id) AS muelle_id
                         FROM wms_enturnamiento p WHERE enturnamiento_id = $enturnamiento_id";
      echo $select;       	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }


   public function getQueryEnturnamientoGrid(){
         
     $Query = "SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',enturnamiento_id,')\">',p.enturnamiento_id,'</a>' )AS enturnamiento_id,
                      p.fecha,
                      (SELECT v.placa FROM wms_vehiculo v WHERE v.wms_vehiculo_id=p.wms_vehiculo_id)AS vehiculo,
                      IF(p.estado='B','BLOQUEADO','DISPONIBLE')AS estado, 
                      (SELECT u.nombre FROM wms_muelle u WHERE u.muelle_id=p.muelle_id) AS muelle,
                      p.fecha_salida_turno, 
		                  p.fecha_registro,
                      p.fecha_actualiza FROM wms_enturnamiento p";
     return $Query;
   
   }
   

}


?>