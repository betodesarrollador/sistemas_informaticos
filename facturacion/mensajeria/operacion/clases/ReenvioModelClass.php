<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReenvioModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDivipolaUbicacion($ubicacion_id,$Conex){  
    $select = "SELECT divipola FROM ubicacion WHERE ubicacion_id = $ubicacion_id";
	$result = $this -> DbFetchAll($select,$Conex,true);		
	return $result[0]['divipola'];  
  }
  
/////  
  public function Delete($Campos,$Conex){
	$this -> Begin($Conex);

 	  $this -> DbDeleteTable("reenvio_id",$Campos,$Conex,true,false);	
  	  $this -> DbDeleteTable("reenvio",$Campos,$Conex,true,false);	
	
	$this -> Commit($Conex);
  } 
  
  ////

  public function setLeerCodigobar($guia,$Conex){
    $select = "SELECT 
	g.guia_id,
	g.numero_guia,
	g.remitente,
	g.destinatario,
	(SELECT referencia_producto FROM detalle_guia WHERE guia_id=g.guia_id) AS descripcion_producto,
	(SELECT peso FROM detalle_guia WHERE guia_id=g.guia_id) AS peso,
	(SELECT cantidad FROM detalle_guia WHERE guia_id=g.guia_id) AS cantidad,
	g.estado_mensajeria_id
	FROM guia g 
	WHERE g.numero_guia=$guia 
	AND g.guia_id  IN (SELECT dd.guia_id FROM detalle_devolucion dd, devolucion d WHERE  dd.devolucion_id=d.devolucion_id AND d.estado='D')";
    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result;
 }

  public function reenvioTieneGuias($reenvio_id,$Conex){  
    $select = "SELECT COUNT(*) AS num_guia FROM detalle_reenvio WHERE reenvio_id = $reenvio_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0]['num_guia'] > 0){
	  return true;
	}else{
	     return false;
	  }	  
  }  
 
  public function cancellation($reenvio_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){ 
  
 	$select = "SELECT d.guia_id FROM detalle_reenvio d 
	WHERE d.reenvio_id = $reenvio_id AND 
	 d.guia_id IN (SELECT dd.guia_id FROM detalle_entrega dd, entrega dv WHERE dv.estado='E' AND dd.entrega_id=dv.entrega_id )";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0][guia_id]>0){
		exit('No puede Anular el reenvio, <br>debido a que una o varias de las guias estan relacionadas<br> en una entrega Activa');
	}
  
   $this -> Begin($Conex);  
     $update = "UPDATE reenvio SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE reenvio_id = $reenvio_id";	 
	 $this -> query($update,$Conex,true);	
	 
	 $update = "UPDATE guia SET  estado_mensajeria_id = 7 WHERE guia_id IN (SELECT guia_id FROM detalle_reenvio WHERE reenvio_id = $reenvio_id)";
	 $this -> query($update,$Conex,true);	
	 
   $this -> Commit($Conex);
  }   
  
	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
    }	  


  
  public function Update($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){ 

 		$reenvio_id=$_REQUEST['reenvio_id'];
		$obser_ree=$_REQUEST['obser_ree'];

		$update="UPDATE
					reenvio 
				SET
					obser_ree='$obser_ree'
				WHERE
					reenvio_id=$reenvio_id
				";

		$this -> query($update,$Conex,true);
		if($this -> GetNumError() > 0){
			return false;
		}else{
			return array(reenvio_id => $reenvio_id);
		}
  }
  

   public function Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){
			
    $reenvio_id = $this -> DbgetMaxConsecutive("reenvio","reenvio_id",$Conex,true,1);	
	
    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
	
    $this -> assignValRequest('reenvio_id',$reenvio_id);
				
	 	
    $this -> Begin($Conex);    
	  
	$this -> assignValRequest('estado','R');		    					
	$this -> DbInsertTable("reenvio",$Campos,$Conex,true,false);

	if(is_array($_REQUEST['g'])){
	
	  $guias = $_REQUEST['g'];
							
	  for($i = 0; $i < count($guias); $i++){
	  
		$detalle_reenvio_id = $this -> DbgetMaxConsecutive("detalle_reenvio","detalle_reenvio_id",$Conex,false,1);					
		$guia_id 				= $guias[$i]['g_id'];
							
		$select = "SELECT numero_guia FROM guia  WHERE guia_id = $guia_id AND estado_mensajeria_id!=7";
		$result = $this  -> DbFetchAll($select,$Conex,true);						
		
		if($result[0][numero_guia]>0){
			exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Devolucion');
		  	$this -> RollBack($Conex);
		}
		
		 $insert = "INSERT INTO detalle_reenvio (detalle_reenvio_id, guia_id,reenvio_id)
					VALUES ($detalle_reenvio_id,$guia_id,$reenvio_id)";

		$this -> query($insert,$Conex,true);						  

		 $update = "UPDATE guia SET estado_mensajeria_id=1, desbloqueada=1 WHERE guia_id=$guia_id ";
			
		$this -> query($update,$Conex,true);	

	  }
	}
	$this -> Commit($Conex);

    return $reenvio_id;
  }




//BUSQUEDA
  public function selectReenvio($reenvio_id,$Conex){
    				
   $select = "SELECT r.*, 
   r.fecha_ree
   FROM reenvio r WHERE r.reenvio_id=$reenvio_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	return $result;
  }

//// GRID ////
  public function getQueryReenvioGrid(){
	   	   
	$Query = "SELECT r.fecha_ree,
	CASE r.estado WHEN 'R' THEN 'REENVIO' WHEN 'A' THEN 'ANULADO' ELSE 'ANULADO' END AS estado,
	obser_ree
	FROM reenvio r";
 
     return $Query;
   }   
}

?>