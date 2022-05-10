<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DevolucionPruebaModel extends Db{

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

 	  $this -> DbDeleteTable("devolucion_id",$Campos,$Conex,true,false);	
  	  $this -> DbDeleteTable("devolucion",$Campos,$Conex,true,false);	
	
	$this -> Commit($Conex);
  } 
  
  ////
  public function seleccionar_remesa($guia_id,$devolucion_id,$causal_devolucion_id,$Conex){
  	$this -> Begin($Conex);
	$detalle_devolucion_id = $this -> DbgetMaxConsecutive("detalle_devolucion","detalle_devolucion_id",$Conex,true,1);	
	$insert = "INSERT INTO detalle_devolucion (detalle_devolucion_id, guia_id,devolucion_id,causal_devolucion_id)
				VALUES ($detalle_devolucion_id,$guia_id,$devolucion_id,$causal_devolucion_id)";
	$this -> query($insert,$Conex,true);						  

	$update = "UPDATE guia SET estado_mensajeria_id=7 WHERE guia_id=$guia_id ";
	$this -> query($update,$Conex,true);
	$this -> Commit($Conex);
  }

  public function getEstadoReex($devolucion_id,$Conex){
    $select = "SELECT 
	estado
	FROM devolucion r 
	WHERE r.devolucion_id=$devolucion_id";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][estado];
 }

  public function getEstadoDisReex($devolucion_id,$Conex){
    $select = "SELECT 
	COUNT(*) AS movimientos
	FROM devolucion r, detalle_devolucion dg, guia g
	WHERE r.devolucion_id=$devolucion_id AND dg.devolucion_id=r.devolucion_id 
	AND g.guia_id=dg.guia_id AND g.estado_mensajeria_id != 7 ";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][movimientos]!='' ? $result[0][movimientos] : 0;
 }

	public function setLeerCodigobar($guia,$Conex){
		$select = "SELECT 
			g.guia_id,
			CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A'  ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor,
			(SELECT r.proveedor_id FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor_id,
			g.remitente,
			g.destinatario,
			(SELECT referencia_producto FROM detalle_guia WHERE guia_id=g.guia_id) AS descripcion_producto,
			(SELECT peso FROM detalle_guia WHERE guia_id=g.guia_id) AS peso,
			(SELECT cantidad FROM detalle_guia WHERE guia_id=g.guia_id) AS cantidad,
			g.estado_mensajeria_id
			FROM guia g 
			WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia'
			AND g.guia_id IN (SELECT dd.guia_id FROM detalle_despacho_guia dd, reexpedido d WHERE dd.reexpedido_id=d.reexpedido_id AND d.estado='M')";//echo $select;
		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function setLeerCodigobar1($guia,$Conex){
		$select = "SELECT 
			g.guia_interconexion_id,
			g.numero_guia,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_interconexion_id = g.guia_interconexion_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A'  ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor,
			(SELECT r.proveedor_id FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_interconexion_id = g.guia_interconexion_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor_id,
			g.remitente,
			g.destinatario,
			(SELECT referencia_producto FROM detalle_guia_interconexion WHERE guia_interconexion_id=g.guia_interconexion_id) AS descripcion_producto,
			(SELECT peso FROM detalle_guia_interconexion WHERE guia_interconexion_id=g.guia_interconexion_id) AS peso,
			(SELECT cantidad FROM detalle_guia_interconexion WHERE guia_interconexion_id=g.guia_interconexion_id) AS cantidad,
			g.estado_mensajeria_id
			FROM guia_interconexion g 
			WHERE g.numero_guia='$guia' 
			AND g.guia_interconexion_id IN (SELECT dd.guia_interconexion_id FROM detalle_despacho_guia dd, reexpedido d WHERE dd.reexpedido_id=d.reexpedido_id AND d.estado='M')";
		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}
	
	public function setLeerCodigobar2($guia,$Conex){
		$select = "SELECT 
			g.guia_encomienda_id,
			CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A'  ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor,
			(SELECT r.proveedor_id FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor_id,
			g.remitente,
			g.destinatario,
			(SELECT referencia_producto FROM detalle_guia WHERE guia_id=g.guia_id) AS descripcion_producto,
			(SELECT peso FROM detalle_guia WHERE guia_id=g.guia_id) AS peso,
			(SELECT cantidad FROM detalle_guia WHERE guia_id=g.guia_id) AS cantidad,
			g.estado_mensajeria_id
			FROM guia_encomienda g 
			WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia'
			AND g.guia_encomienda_id IN (SELECT dd.guia_encomienda_id FROM detalle_despacho_guia dd, reexpedido d WHERE dd.reexpedido_id=d.reexpedido_id AND d.estado='M')";//echo $select;
		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}	

  public function devolucionTieneGuias($devolucion_id,$Conex){  
    $select = "SELECT COUNT(*) AS num_guia FROM detalle_devolucion WHERE devolucion_id = $devolucion_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0]['num_guia'] > 0){
	  return true;
	}else{
	     return false;
	  }	  
  }  
 
  public function cancellation($devolucion_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){ 
 
	$select = "SELECT d.guia_id FROM detalle_devolucion d 
	WHERE d.devolucion_id = $devolucion_id AND 
	(d.guia_id IN (SELECT dd.guia_id FROM detalle_devolucion dd, devolucion dv WHERE dv.estado='D' AND dd.devolucion_id=dv.devolucion_id )
	 OR d.guia_id IN (SELECT dd.guia_id FROM detalle_entrega dd, entrega dv WHERE dv.estado='E' AND dd.entrega_id=dv.entrega_id )
	 OR d.guia_id IN (SELECT dd.guia_id FROM detalle_reenvio dd, reenvio dv WHERE dv.estado='R' AND dd.reenvio_id=dv.reenvio_id ))";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0][guia_id]>0){
		exit('No puede Anular la Devolucion, <br>debido a que una o varias de las guias estan relacionadas<br> en una devoluci&oacute;n,entrega o reenvio Activo');
	}
	
	$select = "SELECT d.guia_interconexion_id FROM detalle_devolucion d 
	WHERE d.devolucion_id = $devolucion_id AND 
	(d.guia_interconexion_id IN (SELECT dd.guia_interconexion_id FROM detalle_devolucion dd, devolucion dv WHERE dv.estado='D' AND dd.devolucion_id=dv.devolucion_id )
	 OR d.guia_interconexion_id IN (SELECT dd.guia_interconexion_id FROM detalle_entrega dd, entrega dv WHERE dv.estado='E' AND dd.entrega_id=dv.entrega_id )
	 OR d.guia_interconexion_id IN (SELECT dd.guia_interconexion_id FROM detalle_reenvio dd, reenvio dv WHERE dv.estado='R' AND dd.reenvio_id=dv.reenvio_id ))";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0][guia_interconexion_id]>0){
		exit('No puede Anular la Devolucion, <br>debido a que una o varias de las guias estan relacionadas<br> en una devoluci&oacute;n,entrega o reenvio Activo');
	}	


   $this -> Begin($Conex);
	$update = "UPDATE 
					devolucion 
				SET 
					estado = 'A',
					causal_anulacion_id = $causal_anulacion_id,
					observacion_anulacion = $observacion_anulacion,
					fecha_anulacion = NOW(),
					usuario_anulo_id = $usuario_anulo_id 
				WHERE
					devolucion_id = $devolucion_id";	 
	$this -> query($update,$Conex,true);	


	$update = "UPDATE guia SET estado_mensajeria_id = 4 WHERE guia_id IN (SELECT guia_id FROM detalle_devolucion WHERE devolucion_id = $devolucion_id)";
	$this -> query($update,$Conex,true);
	
	$update = "UPDATE guia_interconexion SET estado_mensajeria_id = 4 WHERE guia_interconexion_id IN (SELECT guia_interconexion_id FROM detalle_devolucion WHERE devolucion_id = $devolucion_id)";
	$this -> query($update,$Conex,true);
	
   $this -> Commit($Conex);
  }   
  
	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
    }	  

	public function getCausalesDevolucion($Conex){		
		$select = "SELECT causal_devolucion_id AS value,causal AS text FROM causal_devolucion WHERE estado='A'  ORDER BY causal";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
    }	  

  
	public function Update($Conex){ 

		$devolucion_id=$_REQUEST['devolucion_id'];
		$obser_dev=$_REQUEST['obser_dev'];

		$update="UPDATE
					devolucion d
				SET
					d.obser_dev='$obser_dev'
				WHERE
					d.devolucion_id=$devolucion_id
				";

		$this -> query($update,$Conex,true);
		if($this -> GetNumError() > 0){
			return false;
		}else{
			return array(devolucion_id => $devolucion_id);
		}


	}
  

   public function Save($obser_dev,$fecha_dev,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$guia_id,$proveedor,$proveedor_id,$Campos,$Conex){
			
    $devolucion_id = $this -> DbgetMaxConsecutive("devolucion","devolucion_id",$Conex,true,1);

    $this -> assignValRequest('proveedor',$proveedor);
    $this -> assignValRequest('proveedor_id',$proveedor_id);
	$this -> assignValRequest('fecha_dev',$fecha_dev);
	$this -> assignValRequest('obser_dev',$obser_dev);
	
    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
	
    $this -> assignValRequest('devolucion_id',$devolucion_id);

    $this -> Begin($Conex);

	$this -> assignValRequest('estado','D');
	$this -> DbInsertTable("devolucion",$Campos,$Conex,true,false);
  
	$detalle_devolucion_id = $this -> DbgetMaxConsecutive("detalle_devolucion","detalle_devolucion_id",$Conex,false,1);

	$causal_devolucion_id   = $_REQUEST['causal_devolucion_id'];

	$select = "SELECT CONCAT_WS('',prefijo,numero_guia) AS numero_guia FROM guia  WHERE guia_id = $guia_id AND estado_mensajeria_id!=4";
	$result = $this  -> DbFetchAll($select,$Conex,true);
	
	if($result[0][numero_guia]>0){
		exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
	  	$this -> RollBack($Conex);
	}
	 $insert = "INSERT INTO detalle_devolucion (detalle_devolucion_id, guia_id,devolucion_id,causal_devolucion_id)
				VALUES ($detalle_devolucion_id,$guia_id,$devolucion_id,$causal_devolucion_id)";
		
	$this -> query($insert,$Conex,true);

	 $update = "UPDATE guia SET estado_mensajeria_id=7 WHERE guia_id=$guia_id ";

	$this -> query($update,$Conex,true);

	$this -> Commit($Conex);

    return $devolucion_id;
  }

 	public function SaveInter($obser_dev,$fecha_dev,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$guia_interconexion_id,$proveedor,$proveedor_id,$Campos,$Conex){
			
    $devolucion_id = $this -> DbgetMaxConsecutive("devolucion","devolucion_id",$Conex,true,1);

    $this -> assignValRequest('proveedor',$proveedor);
    $this -> assignValRequest('proveedor_id',$proveedor_id);
	$this -> assignValRequest('fecha_dev',$fecha_dev);
	$this -> assignValRequest('obser_dev',$obser_dev);
	
    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
	
    $this -> assignValRequest('devolucion_id',$devolucion_id);

    $this -> Begin($Conex);

	$this -> assignValRequest('estado','D');
	$this -> DbInsertTable("devolucion",$Campos,$Conex,true,false);
  
	$detalle_devolucion_id = $this -> DbgetMaxConsecutive("detalle_devolucion","detalle_devolucion_id",$Conex,false,1);

	$causal_devolucion_id   = $_REQUEST['causal_devolucion_id'];

	$select = "SELECT numero_guia FROM guia_interconexion  WHERE guia_interconexion_id = $guia_interconexion_id AND estado_mensajeria_id!=4";
	$result = $this  -> DbFetchAll($select,$Conex,true);
	
	if($result[0][numero_guia]>0){
		exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
	  	$this -> RollBack($Conex);
	}
	 $insert = "INSERT INTO detalle_devolucion (detalle_devolucion_id, guia_interconexion_id,devolucion_id,causal_devolucion_id)
				VALUES ($detalle_devolucion_id,$guia_interconexion_id,$devolucion_id,$causal_devolucion_id)";
		
	$this -> query($insert,$Conex,true);

	 $update = "UPDATE guia_interconexion SET estado_mensajeria_id=7 WHERE guia_interconexion_id=$guia_interconexion_id ";

	$this -> query($update,$Conex,true);

	$this -> Commit($Conex);

    return $devolucion_id;
  }
  
   public function SaveEncomienda($obser_dev,$fecha_dev,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$guia_encomienda_id,$proveedor,$proveedor_id,$Campos,$Conex){
			
    $devolucion_id = $this -> DbgetMaxConsecutive("devolucion","devolucion_id",$Conex,true,1);

    $this -> assignValRequest('proveedor',$proveedor);
    $this -> assignValRequest('proveedor_id',$proveedor_id);
	$this -> assignValRequest('fecha_dev',$fecha_dev);
	$this -> assignValRequest('obser_dev',$obser_dev);
	
    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
	
    $this -> assignValRequest('devolucion_id',$devolucion_id);

    $this -> Begin($Conex);

	$this -> assignValRequest('estado','D');
	$this -> DbInsertTable("devolucion",$Campos,$Conex,true,false);
  
	$detalle_devolucion_id = $this -> DbgetMaxConsecutive("detalle_devolucion","detalle_devolucion_id",$Conex,false,1);

	$causal_devolucion_id   = $_REQUEST['causal_devolucion_id'];

	$select = "SELECT CONCAT_WS('',prefijo,numero_guia) AS numero_guia FROM guia_encomienda WHERE guia_encomienda_id = $guia_encomienda_id AND estado_mensajeria_id!=4";
	$result = $this  -> DbFetchAll($select,$Conex,true);
	
	if($result[0][numero_guia]>0){
		exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
	  	$this -> RollBack($Conex);
	}
	 $insert = "INSERT INTO detalle_devolucion (detalle_devolucion_id, guia_encomienda_id,devolucion_id,causal_devolucion_id)
				VALUES ($detalle_devolucion_id,$guia_encomienda_id,$devolucion_id,$causal_devolucion_id)";
		
	$this -> query($insert,$Conex,true);

	 $update = "UPDATE guia_encomienda SET estado_mensajeria_id=7 WHERE guia_encomienda_id=$guia_encomienda_id ";

	$this -> query($update,$Conex,true);

	$this -> Commit($Conex);

    return $devolucion_id;
  }  

//BUSQUEDA
  public function selectDevolucion($devolucion_id,$Conex){
    				
   $select = "SELECT r.*, 
   r.fecha_dev,r.proveedor
   FROM devolucion r WHERE r.devolucion_id=$devolucion_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	return $result;
  }

//// GRID ////
  public function getQueryDevolucionGrid(){
	   	   
	$Query = "SELECT r.fecha_dev,
	(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) FROM tercero t, proveedor p 
	WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
	CASE r.estado WHEN 'D' THEN 'DEVUELTO' WHEN 'A' THEN 'ANULADO' ELSE 'ANULADO' END AS estado,
	obser_dev
	FROM devolucion r";
	
//(SELECT re.numero_guia FROM guia re, detalle_devolucion dd WHERE dd.devolucion_id = r.devolucion_id AND re.guia_id = dd.guia_id) AS numero_guia	
   
     return $Query;
   }   
}

?>