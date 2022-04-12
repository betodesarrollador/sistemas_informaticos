<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReporteSeguimientoProductoModel extends Db{

  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }


  public function getDatosPrincipales($serial,$Conex){ 

	  $select="SELECT p.nombre AS producto,
	                 e.serial,
					 p.imagen, 
					 p.codigo_barra, 
					 (CASE p.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
					 FROM wms_enturnamiento_detalle e, wms_producto_inv p 
	           WHERE e.producto_id=p.producto_id AND  e.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  


  public function getDatosEnturnamiento($serial,$Conex){ 

	  $select="SELECT e.enturnamiento_id AS numero_turno, 
	                 e.fecha_registro,
					 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre, t.primer_apellido,t.segundo_apellido) 
					  FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario,
					  v.placa,
					  v.imagen,                  	   
					  v.nombre_conductor

			  FROM  wms_enturnamiento e,wms_enturnamiento_detalle ed, usuario u, wms_vehiculo v

              WHERE e.enturnamiento_id=ed.enturnamiento_id AND u.usuario_id=e.usuario_id AND v.wms_vehiculo_id=e.wms_vehiculo_id AND ed.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  

   public function getDatosMuelle($serial,$Conex){ 

	  $select="SELECT m.codigo AS numero_muelle,
	                  m.nombre,
					  (SELECT CONCAT_WS('-',b.nombre,b.codigo_bodega) FROM wms_bodega b WHERE b.bodega_id = m.bodega_id)AS bodega,
					  (CASE m.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado,
	                  m.fecha_registro,
	          (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id = m.usuario_id) AS usuario

		       FROM  wms_muelle m,wms_enturnamiento e,wms_enturnamiento_detalle ed

		       WHERE m.muelle_id = e.muelle_id AND e.enturnamiento_id = ed.enturnamiento_id AND ed.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  


   public function getDatosRecepcion($serial,$Conex){ 

	  $select="SELECT e.enturnamiento_id AS codigo_recepcion, 
	                  e.fecha_registro,
					  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario,
					  (CASE e.estado WHEN 'D' THEN 'DISPONIBLE' WHEN 'L' THEN 'LEGALIZADO' ELSE 'BLOQUEADO' END)AS estado

			  FROM  wms_enturnamiento e,wms_enturnamiento_detalle ed, usuario u

              WHERE e.enturnamiento_id=ed.enturnamiento_id AND u.usuario_id=e.usuario_id  AND ed.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  


   public function getDatosLegalizacion($serial,$Conex){ 

	  $select="SELECT r.recepcion_id,
	  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario,
	                  r.fecha_registro,
					  (CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'L' THEN 'LEGALIZADO' WHEN 'I' THEN 'INGRESADO' ELSE 'ANULADO' END)AS estado

	           FROM  wms_enturnamiento e,wms_enturnamiento_detalle ed, usuario u, wms_recepcion r 

	           WHERE e.enturnamiento_id=ed.enturnamiento_id AND u.usuario_id=e.usuario_id  AND r.enturnamiento_id = e.enturnamiento_id  AND ed.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  

   public function getDatosInventario($serial,$Conex){ 

	  $select = "SELECT ub.nombre AS ubicacion_bodega ,p.nombre AS posicion,es.nombre AS estado, en.fecha_registro,

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario,p.nombre AS nombre_posicion,

				(SELECT b.nombre FROM wms_bodega b WHERE b.bodega_id=(SELECT ub.bodega_id FROM wms_ubicacion_bodega ub WHERE ub.ubicacion_bodega_id=e.ubicacion_bodega_id)) AS bodega

				FROM  wms_entrada_detalle e, wms_entrada en, usuario u,wms_posicion p,wms_estado_producto es,wms_ubicacion_bodega ub

				WHERE e.entrada_id=en.entrada_id   AND u.usuario_id=en.usuario_id AND 
				e.posicion_id=p.posicion_id  AND es.estado_producto_id = e.estado_producto_id AND ub.ubicacion_bodega_id = e.ubicacion_bodega_id AND e.serial = '$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  


   public function getDatosTraslados($serial,$Conex){ 

	  $select = "SELECT u.nombre AS ubicacion, b.nombre AS nombre_bodega,tr.fecha_registro,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=us.tercero_id) AS usuario,IF(tr.estado ='A','ACTIVO','ANULADO')AS estado

				FROM wms_traslado_detalle t, wms_ubicacion_bodega u, wms_bodega b, wms_traslado tr,usuario us

				WHERE u.ubicacion_bodega_id=t.ubicacion_bodega_id AND b.bodega_id=u.bodega_id AND tr.traslado_id=t.traslado_id AND us.usuario_id=tr.usuario_id AND t.serial = '$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }
  
  
   public function getDatosAlistamientoSalida($serial,$Conex){ 

	  $select = "SELECT 
	            s.alistamiento_salida_id,
				s.turno,
				(SELECT CONCAT_WS('-',m.nombre,m.codigo) FROM wms_muelle m WHERE m.muelle_id=s.muelle_id)AS muelle, 
	            s.fecha_registro,
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
				FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario, 
               (CASE s.estado WHEN 'A' THEN 'ALISTAMIENTO' WHEN 'E' THEN 'ENTURNADO' ELSE 'DESPACHADO' END)AS estado
				FROM wms_alistamiento_salida_detalle d, wms_alistamiento_salida s, usuario u
				WHERE d.alistamiento_salida_id=s.alistamiento_salida_id  AND u.usuario_id=s.usuario_id
				AND s.estado IN ('A','E','D','EN') AND d.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  


   public function getDatosTurnoSalida($serial,$Conex){ 

	  $select = "SELECT s.fecha_registro,m.nombre AS muelle,s.turno,

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario  

				FROM wms_alistamiento_salida_detalle d, wms_alistamiento_salida s, usuario u, wms_muelle m
				WHERE s.alistamiento_salida_id=d.alistamiento_salida_detalle_id  AND u.usuario_id=s.usuario_id AND m.muelle_id=s.muelle_id
				AND s.estado = 'A' AND s.muelle_id IS NOT NULL AND d.serial='$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  

   public function getDatosDespacho($serial,$Conex){ 

	  $select = "SELECT d.despacho_id AS numero_despacho,
	                    d.fecha_registro,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
						FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id = d.usuario_id) AS usuario,
						(SELECT v.placa FROM wms_vehiculo v WHERE v.wms_vehiculo_id = d.wms_vehiculo_id)AS placa,
						(SELECT v.nombre_conductor FROM wms_vehiculo v WHERE v.wms_vehiculo_id = d.wms_vehiculo_id)AS nombre_conductor,
						(SELECT v.imagen FROM wms_vehiculo v WHERE v.wms_vehiculo_id = d.wms_vehiculo_id)AS imagen,
						d.estado

				FROM  wms_despacho d, wms_despacho_detalle dd

				WHERE d.estado IN('EN','E','A','D') AND d.despacho_id = dd.despacho_id AND dd.serial = '$serial'";
      
	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	 
	  return $result;
  }  

   public function getDatosEntrega($serial,$Conex){ 

	  $select = "SELECT d.fecha_entrega,
	                    d.observacion_entrega,
	           (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
			    FROM tercero t WHERE t.tercero_id=u.tercero_id) AS usuario

	  FROM wms_despacho_detalle dd, wms_despacho d, usuario u

	  WHERE d.despacho_id=dd.despacho_id AND u.usuario_id=d.usuario_entrega AND d.estado ='EN' AND dd.serial = '$serial'";

	  $result = $this -> DbFetchAll($select,$Conex,true);		  
	
	  return $result;
  }  
  
 
}

?>