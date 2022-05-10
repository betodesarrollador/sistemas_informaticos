<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class BodegaPuenteModel extends Db{

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

 	  $this -> DbDeleteTable("entrega_parcial_id",$Campos,$Conex,true,false);	
  	  $this -> DbDeleteTable("entrega_parcial",$Campos,$Conex,true,false);	
	
	$this -> Commit($Conex);
  } 
  
  ////
  public function seleccionar_remesa($guia_id,$entrega_parcial_id,$Conex){
  	$this -> Begin($Conex);
	$detalle_entrega_parcial_id = $this -> DbgetMaxConsecutive("detalle_entrega_parcial","detalle_entrega_parcial_id",$Conex,true,1);	
	$insert = "INSERT INTO detalle_entrega_parcial (detalle_entrega_parcial_id, guia_id,entrega_parcial_id)
				VALUES ($detalle_entrega_parcial_id,$guia_id,$entrega_parcial_id)";
	$this -> query($insert,$Conex,true);						  

	$update = "UPDATE guia SET estado_mensajeria_id=9 WHERE guia_id=$guia_id ";
	$this -> query($update,$Conex,true);
	$this -> Commit($Conex);
  }

  public function getEstadoReex($entrega_parcial_id,$Conex){
    $select = "SELECT 
	estado
	FROM entrega_parcial r 
	WHERE r.entrega_parcial_id=$entrega_parcial_id";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][estado];
 }

  public function getEstadoDisReex($entrega_parcial_id,$Conex){
    $select = "SELECT 
	COUNT(*) AS movimientos
	FROM entrega_parcial r, detalle_entrega_parcial dg, guia g
	WHERE r.entrega_parcial_id=$entrega_parcial_id AND dg.entrega_parcial_id=r.entrega_parcial_id 
	AND g.guia_id=dg.guia_id AND g.estado_mensajeria_id != 6 ";

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
			g.descripcion_producto,
			g.peso,
			g.cantidad,
			g.estado_mensajeria_id
			FROM guia g 
			WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia'
			AND g.guia_id IN (SELECT dd.guia_id FROM detalle_despacho_guia dd, reexpedido d WHERE dd.reexpedido_id=d.reexpedido_id AND d.estado='M' ORDER BY d.fecha_rxp DESC )";
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
			g.descripcion_producto,
			g.peso,
			g.cantidad,
			g.estado_mensajeria_id
			FROM guia_interconexion g 
			WHERE g.numero_guia='$guia' 
			AND g.guia_interconexion_id IN (SELECT dd.guia_interconexion_id FROM detalle_despacho_guia dd, reexpedido d WHERE dd.reexpedido_id=d.reexpedido_id AND d.estado='M' ORDER BY d.fecha_rxp DESC )";
		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function setLeerCodigobar2($guia,$Conex){
		$select = "SELECT 
			g.guia_encomienda_id,
			CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A'  ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor,
			(SELECT r.proveedor_id FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS proveedor_id,
			g.remitente,
			g.destinatario,
			g.descripcion_producto,
			g.peso,
			g.cantidad,
			g.estado_mensajeria_id
			FROM guia_encomienda g 
			WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia'
			AND g.guia_encomienda_id IN (SELECT dd.guia_encomienda_id FROM detalle_despacho_guia dd, reexpedido d WHERE dd.reexpedido_id=d.reexpedido_id AND d.estado='M' ORDER BY d.fecha_rxp DESC )";
		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

  public function entregaTieneGuias($entrega_parcial_id,$Conex){  
    $select = "SELECT COUNT(*) AS num_guia FROM detalle_entrega_parcial WHERE entrega_parcial_id = $entrega_parcial_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0]['num_guia'] > 0){
	  return true;
	}else{
	     return false;
	  }	  
  }  
 
	public function cancellation($entrega_parcial_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){ 

		$select = "SELECT d.guia_id FROM detalle_entrega_parcial d 
		WHERE d.entrega_parcial_id = $entrega_parcial_id AND 
		(d.guia_id IN (SELECT dd.guia_id FROM detalle_devolucion dd, devolucion dv WHERE dv.estado='D' AND dd.devolucion_id=dv.devolucion_id )
		 OR d.guia_id IN (SELECT dd.guia_id FROM detalle_entrega_parcial dd, entrega_parcial dv WHERE dv.estado='E' AND dd.entrega_parcial_id=dv.entrega_parcial_id ))";
		$result = $this -> DbFetchAll($select,$Conex,true);	
		if($result[0][guia_id]>0){
			exit('No puede Anular la Entrega, <br>debido a que una o varias de las guias estan relacionadas<br> en una devoluci&oacute;n o entrega Activa');
		}

		

		$this -> Begin($Conex);

		$update = "UPDATE entrega_parcial SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
		fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE entrega_parcial_id = $entrega_parcial_id";
		$this -> query($update,$Conex,true);

		$update = "UPDATE guia SET estado_mensajeria_id = 4 WHERE guia_id IN (SELECT guia_id FROM detalle_entrega_parcial WHERE entrega_parcial_id = $entrega_parcial_id)";
		$this -> query($update,$Conex,true);
		
		$this -> Commit($Conex);
	}
  
	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
    }	  


  
	public function Update($Conex){ 

		$entrega_parcial_id=$_REQUEST['entrega_parcial_id'];
		$obser_ent=$_REQUEST['obser_ent'];

		$update="UPDATE
					entrega_parcial d
				SET
					d.obser_ent='$obser_ent'
				WHERE
					d.entrega_parcial_id=$entrega_parcial_id
				";

		$this -> query($update,$Conex,true);
		if($this -> GetNumError() > 0){
			return false;
		}else{
			return array(entrega_parcial_id => $entrega_parcial_id);
		}


	}
  

   public function Save($obser_ent,$fecha_ent,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$guia_id,$proveedor,$proveedor_id,$Campos,$Conex){
				
	    $entrega_parcial_id = $this -> DbgetMaxConsecutive("entrega_parcial","entrega_parcial_id",$Conex,true,1);	
		
	    $this -> assignValRequest('proveedor',$proveedor);
	    $this -> assignValRequest('proveedor_id',$proveedor_id);
		$this -> assignValRequest('fecha_ent',$fecha_ent);
		$this -> assignValRequest('obser_ent',$obser_ent);
	    $this -> assignValRequest('empresa_id',$empresa_id);
		$this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
	    $this -> assignValRequest('oficina_id',$oficina_id);
	    $this -> assignValRequest('usuario_id',$usuario_id);
	    $this -> assignValRequest('usuario_registra',$usuarioNombres);
	    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
		
	    $this -> assignValRequest('entrega_parcial_id',$entrega_parcial_id);
					
	    $this -> Begin($Conex);    
		  
		$this -> assignValRequest('estado','E');		    					
		$this -> DbInsertTable("entrega_parcial",$Campos,$Conex,true,false);

		$detalle_entrega_parcial_id = $this -> DbgetMaxConsecutive("detalle_entrega_parcial","detalle_entrega_parcial_id",$Conex,false,1);					

		$select = "SELECT CONCAT_WS('',prefijo,numero_guia) AS numero_guia FROM guia  WHERE guia_id = $guia_id AND estado_mensajeria_id!=4";

		$result = $this  -> DbFetchAll($select,$Conex,true);

		if($result[0][numero_guia]>0){
			exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
			$this -> RollBack($Conex);
		}
		$insert = "INSERT INTO detalle_entrega_parcial (detalle_entrega_parcial_id, guia_id,entrega_parcial_id)
		VALUES ($detalle_entrega_parcial_id,$guia_id,$entrega_parcial_id)";

		$this -> query($insert,$Conex,true);

		$update = "UPDATE guia SET estado_mensajeria_id=9 WHERE guia_id=$guia_id ";

		$this -> query($update,$Conex,true);

		$this -> Commit($Conex);

	    return $entrega_parcial_id;
	}

 public function SaveInter($obser_ent,$fecha_ent,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$guia_interconexion_id,$proveedor,$proveedor_id,$Campos,$Conex){
				
	    $entrega_parcial_id = $this -> DbgetMaxConsecutive("entrega_parcial","entrega_parcial_id",$Conex,true,1);	
		
	    $this -> assignValRequest('proveedor',$proveedor);
	    $this -> assignValRequest('proveedor_id',$proveedor_id);
		$this -> assignValRequest('fecha_ent',$fecha_ent);
		$this -> assignValRequest('obser_ent',$obser_ent);
		$this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
	    $this -> assignValRequest('empresa_id',$empresa_id);
	    $this -> assignValRequest('oficina_id',$oficina_id);
	    $this -> assignValRequest('usuario_id',$usuario_id);
	    $this -> assignValRequest('usuario_registra',$usuarioNombres);
	    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
		
	    $this -> assignValRequest('entrega_parcial_id',$entrega_parcial_id);
					
	    $this -> Begin($Conex);    
		  
		$this -> assignValRequest('estado','E');		    					
		$this -> DbInsertTable("entrega_parcial",$Campos,$Conex,true,false);

		$detalle_entrega_parcial_id = $this -> DbgetMaxConsecutive("detalle_entrega_parcial","detalle_entrega_parcial_id",$Conex,false,1);					

		$select = "SELECT numero_guia FROM guia_interconexion WHERE guia_interconexion_id = $guia_interconexion_id AND estado_mensajeria_id!=4";

		$result = $this  -> DbFetchAll($select,$Conex,true);

		if($result[0][numero_guia]>0){
			exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
			$this -> RollBack($Conex);
		}
		$insert = "INSERT INTO detalle_entrega_parcial (detalle_entrega_parcial_id, guia_interconexion_id,entrega_parcial_id)
		VALUES ($detalle_entrega_parcial_id,$guia_interconexion_id,$entrega_parcial_id)";

		$this -> query($insert,$Conex,true);

		$update = "UPDATE guia_interconexion SET estado_mensajeria_id=9 WHERE guia_interconexion_id=$guia_interconexion_id ";

		$this -> query($update,$Conex,true);

		$this -> Commit($Conex);

	    return $entrega_parcial_id;
	}

   public function SaveEncomienda($obser_ent,$fecha_ent,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$guia_encomienda_id,$proveedor,$proveedor_id,$Campos,$Conex){
				
	    $entrega_parcial_id = $this -> DbgetMaxConsecutive("entrega_parcial","entrega_parcial_id",$Conex,true,1);	
		
	    $this -> assignValRequest('proveedor',$proveedor);
	    $this -> assignValRequest('proveedor_id',$proveedor_id);
		$this -> assignValRequest('fecha_ent',$fecha_ent);
		$this -> assignValRequest('obser_ent',$obser_ent);
		$this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
	    $this -> assignValRequest('empresa_id',$empresa_id);
	    $this -> assignValRequest('oficina_id',$oficina_id);
	    $this -> assignValRequest('usuario_id',$usuario_id);
	    $this -> assignValRequest('usuario_registra',$usuarioNombres);
	    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
		
	    $this -> assignValRequest('entrega_parcial_id',$entrega_parcial_id);
					
	    $this -> Begin($Conex);    
		  
		$this -> assignValRequest('estado','E');		    					
		$this -> DbInsertTable("entrega_parcial",$Campos,$Conex,true,false);

		$detalle_entrega_parcial_id = $this -> DbgetMaxConsecutive("detalle_entrega_parcial","detalle_entrega_parcial_id",$Conex,false,1);					

		$select = "SELECT CONCAT_WS('',prefijo,numero_guia) AS numero_guia FROM guia_encomienda  WHERE guia_encomienda_id = $guia_encomienda_id AND estado_mensajeria_id!=4";

		$result = $this  -> DbFetchAll($select,$Conex,true);

		if($result[0][numero_guia]>0){
			exit('La Guia '.$result[0][numero_guia].' No se Encuentra en Transito');
			$this -> RollBack($Conex);
		}
		$insert = "INSERT INTO detalle_entrega_parcial (detalle_entrega_parcial_id, guia_encomienda_id,entrega_parcial_id)
		VALUES ($detalle_entrega_parcial_id,$guia_encomienda_id,$entrega_parcial_id)";

		$this -> query($insert,$Conex,true);

		$update = "UPDATE guia_encomienda SET estado_mensajeria_id=9 WHERE guia_encomienda_id=$guia_encomienda_id ";

		$this -> query($update,$Conex,true);

		$this -> Commit($Conex);

	    return $entrega_parcial_id;
	}


//BUSQUEDA
  public function selectEntrega($entrega_parcial_id,$Conex){
    				
   $select = "SELECT r.*, 
   r.fecha_ent,r.proveedor_id,proveedor
   FROM entrega_parcial r WHERE r.entrega_parcial_id=$entrega_parcial_id";
				
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
	FROM entrega_parcial r";
	
//(SELECT re.numero_guia FROM guia re, detalle_entrega_parcial dd WHERE dd.entrega_parcial_id = r.entrega_parcial_id AND re.guia_id = dd.guia_id) AS numero_guia	
   
     return $Query;
   }   
}

?>