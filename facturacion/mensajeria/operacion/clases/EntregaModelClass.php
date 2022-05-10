<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EntregaModel extends Db{

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

 	  $this -> DbDeleteTable("entrega_id",$Campos,$Conex,true,false);	
  	  $this -> DbDeleteTable("entrega",$Campos,$Conex,true,false);	
	
	$this -> Commit($Conex);
  } 
  
  ////
  public function seleccionar_remesa($guia_id,$entrega_id,$Conex){
  	$this -> Begin($Conex);
	$detalle_entrega_id = $this -> DbgetMaxConsecutive("detalle_entrega","detalle_entrega_id",$Conex,true,1);	
	$insert = "INSERT INTO detalle_entrega (detalle_entrega_id, guia_id,entrega_id)
				VALUES ($detalle_entrega_id,$guia_id,$entrega_id)";
	$this -> query($insert,$Conex,true);						  

	$update = "UPDATE guia SET estado_mensajeria_id=6 WHERE guia_id=$guia_id ";
	$this -> query($update,$Conex,true);
	$this -> Commit($Conex);
  }

  public function getEstadoReex($entrega_id,$Conex){
    $select = "SELECT 
	estado
	FROM entrega r 
	WHERE r.entrega_id=$entrega_id";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][estado];
 }

  public function getEstadoDisReex($entrega_id,$Conex){
    $select = "SELECT 
	COUNT(*) AS movimientos
	FROM entrega r, detalle_entrega dg, guia g
	WHERE r.entrega_id=$entrega_id AND dg.entrega_id=r.entrega_id 
	AND g.guia_id=dg.guia_id AND g.estado_mensajeria_id != 6 ";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][movimientos]!='' ? $result[0][movimientos] : 0;
 }

  public function setLeerCodigobar($guia,$proveedor_id,$Conex){
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
	AND g.guia_id IN (SELECT dd.guia_id FROM detalle_despacho_guia dd, reexpedido d WHERE  d.proveedor_id=$proveedor_id AND dd.reexpedido_id=d.reexpedido_id AND d.estado='M' ORDER BY d.fecha_rxp DESC )LIMIT 1";
    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result;
 }


  public function entregaTieneGuias($entrega_id,$Conex){  
    $select = "SELECT COUNT(*) AS num_guia FROM detalle_entrega WHERE entrega_id = $entrega_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0]['num_guia'] > 0){
	  return true;
	}else{
	     return false;
	  }	  
  }  
 
	public function cancellation($entrega_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){ 

		$select = "SELECT d.guia_id FROM detalle_entrega d 
		WHERE d.entrega_id = $entrega_id AND 
		(d.guia_id IN (SELECT dd.guia_id FROM detalle_devolucion dd, devolucion dv WHERE dv.estado='D' AND dd.devolucion_id=dv.devolucion_id )
		 OR d.guia_id IN (SELECT dd.guia_id FROM detalle_entrega dd, entrega dv WHERE dv.estado='E' AND dd.entrega_id=dv.entrega_id ))";
		$result = $this -> DbFetchAll($select,$Conex,true);	
		if($result[0][guia_id]>0){
			exit('No puede Anular la Entrega, <br>debido a que una o varias de las guias estan relacionadas<br> en una devoluci&oacute;n o entrega Activa');
		}

		

		$this -> Begin($Conex);

		$update = "UPDATE entrega SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
		fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE entrega_id = $entrega_id";
		$this -> query($update,$Conex,true);

		$update = "UPDATE guia SET estado_mensajeria_id = 4 WHERE guia_id IN (SELECT guia_id FROM detalle_entrega WHERE entrega_id = $entrega_id)";
		$this -> query($update,$Conex,true);
		
		$this -> Commit($Conex);
	}
  
	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
    }	  


  
	public function Update($Conex){ 

		$entrega_id=$_REQUEST['entrega_id'];
		$obser_ent=$_REQUEST['obser_ent'];

		$update="UPDATE
					entrega d
				SET
					d.obser_ent='$obser_ent'
				WHERE
					d.entrega_id=$entrega_id
				";

		$this -> query($update,$Conex,true);
		if($this -> GetNumError() > 0){
			return false;
		}else{
			return array(entrega_id => $entrega_id);
		}


	}
  

   public function Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){
			
    $entrega_id = $this -> DbgetMaxConsecutive("entrega","entrega_id",$Conex,true,1);	
	
    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
	
    $this -> assignValRequest('entrega_id',$entrega_id);
				
	 	
    $this -> Begin($Conex);    
	  
	$this -> assignValRequest('estado','E');		    					
	$this -> DbInsertTable("entrega",$Campos,$Conex,true,false);

	/*if(is_array($_REQUEST['g'])){
	
	  $guias = $_REQUEST['g'];
							
	  for($i = 0; $i < count($guias); $i++){
	  
		$detalle_entrega_id = $this -> DbgetMaxConsecutive("detalle_entrega","detalle_entrega_id",$Conex,false,1);					
		$guia_id 				= $guias[$i]['g_id'];
							
		$select = "SELECT numero_guia FROM guia  WHERE guia_id = $guia_id AND estado_mensajeria_id!=4";
		$result = $this  -> DbFetchAll($select,$Conex,true);						
		
		if($result[0][numero_guia]>0){
			exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
		  	$this -> RollBack($Conex);
		}
		 $insert = "INSERT INTO detalle_entrega (detalle_entrega_id, guia_id,entrega_id)
					VALUES ($detalle_entrega_id,$guia_id,$entrega_id)";
			
		$this -> query($insert,$Conex,true);						  

		 $update = "UPDATE guia SET estado_mensajeria_id=6 WHERE guia_id=$guia_id ";
			
		$this -> query($update,$Conex,true);						  

	  }
	}*/
	$this -> Commit($Conex);

    return $entrega_id;
  }


//BUSQUEDA
  public function selectEntrega($entrega_id,$Conex){
    				
   $select = "SELECT r.*, 
   r.fecha_ent,r.proveedor_id,proveedor
   FROM entrega r WHERE r.entrega_id=$entrega_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	return $result;
  }

//// GRID ////
  public function getQueryEntregaGrid(){
	   	   
	$Query = "SELECT r.fecha_ent,
	(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) FROM tercero t, proveedor p 
	WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
	CASE r.estado WHEN 'E' THEN 'ENTREGADO' WHEN 'A' THEN 'ANULADO' ELSE 'ANULADO' END AS estado,
	obser_ent
	FROM entrega r";
	
//(SELECT re.numero_guia FROM guia re, detalle_entrega dd WHERE dd.entrega_id = r.entrega_id AND re.guia_id = dd.guia_id) AS numero_guia	
   
     return $Query;
   }   
}

?>