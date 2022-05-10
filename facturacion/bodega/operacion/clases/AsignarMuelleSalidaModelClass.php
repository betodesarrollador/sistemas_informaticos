<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AsignarMuelleSalidaModel extends Db{

  private $Permisos;
  private $usuario_id;

   
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }

   public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
//// GRID ////

  public function getQueryAsignarMuelleSalidaGrid(){	//MODIFICAR FECHA INICIAL Y DIAS
				
	$Query = "SELECT IF((s.estado='D' AND s.muelle_id IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',enturnamiento_id,')\">',s.enturnamiento_id,'</a>' ),s.enturnamiento_id)AS enturnamiento_id,(SELECT placa FROM wms_vehiculo WHERE wms_vehiculo_id=s.wms_vehiculo_id)AS wms_vehiculo_id,IF((s.muelle_id>0),(SELECT nombre FROM wms_muelle WHERE muelle_id=s.muelle_id),'SIN MUELLE')AS muelle_id,(CASE WHEN s.estado ='D' THEN 'DISPONIBLE' WHEN s.estado ='B' THEN 'BLOQUEADO' ELSE 'FINALIZADO' END)AS estado,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=s.usuario_id)AS usuario_id,s.fecha_registro,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=s.usuario_actualiza_id)AS usuario_actualiza_id,s.fecha_actualiza,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=s.usuario_salida_id)AS usuario_salida_id,s.fecha_salida_turno,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=s.usuario_muelle_id)AS usuario_muelle_id,s.fecha_actualiza_muelle,s.observacion

	
				FROM wms_enturnamiento s WHERE s.estado!='B'"; 
     return $Query;
   }

   public function Save($Campos,$Conex){	

    $this -> assignValRequest('fecha_actualiza_muelle',date('Y-m-d H:i:s'));
    $this -> DbUpdateTable("wms_enturnamiento",$Campos,$Conex,true,false);	
  }

   // LISTA MENU //

    public function getMuelle($Conex){

			$select = "SELECT  muelle_id AS value, nombre AS text FROM wms_muelle";

			$result = $this -> DbfetchAll($select,$Conex,true);

			return $result;

  	}

  public function getQueryAsignarMuelleSalidaGrid1($Conex){	//MODIFICAR FECHA INICIAL Y DIAS
				
	$Query = "SELECT 
	                    s.consecutivo AS solicitud,
						s.fecha_solicitud,
						s.fecha_inicio,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre_arrendatario 
									   FROM tercero t, arrendatario a WHERE t.tercero_id=a.tercero_id and a.arrendatario_id=s.arrendatario_id) AS nombre_arrendatario,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre_cliente 
									   FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id and c.cliente_id=s.cliente_id) AS nombre_cliente,
						
						(SELECT MIN(DATE(r.fecha_inicial)) FROM relacion_mora r 
						WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D' AND
						((SELECT SUM(m.valor_abono) FROM  mora_factura m, encabezado_de_registro e 
						WHERE  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ) IS NULL
				 		OR ((r.valor)-(SELECT SUM(m.valor_abono) FROM  mora_factura m, encabezado_de_registro e 
						WHERE  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ))>0)) AS fecha_inicial,

						(SELECT MIN(DATE(r.fecha_registro)) FROM relacion_mora r 
						WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D' AND
						((SELECT SUM(m.valor_abono) FROM  mora_factura m, encabezado_de_registro e 
						WHERE  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ) IS NULL
				 		OR ((r.valor)-(SELECT SUM(m.valor_abono) FROM  mora_factura m, encabezado_de_registro e 
						WHERE  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ))>0)) AS fecha_registro,

						
						(SELECT DATEDIFF(CURDATE(),(SELECT MIN(fecha_registro)))) AS dias,						
						
						(SELECT SUM(r.valor) FROM relacion_mora r WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D') AS valor_total_historico,

						(SELECT SUM(r.valor) FROM relacion_mora r WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D' AND r.tipo!='R') AS valor_cartera_historico,
						(SELECT SUM(r.valor) FROM relacion_mora r WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D' AND r.tipo='R') AS valor_recuperaciones_historico,						


						((SELECT SUM(r.valor) FROM relacion_mora r WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D' AND r.tipo!='R')-
						IF((SELECT SUM(m.valor_abono) FROM relacion_mora r,  mora_factura m, encabezado_de_registro e 
						WHERE r.solicitud_id=s.solicitud_id AND r.tipo!='R' AND  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' )>0,
						(SELECT SUM(m.valor_abono) FROM relacion_mora r,  mora_factura m, encabezado_de_registro e 
						WHERE r.solicitud_id=s.solicitud_id AND r.tipo!='R' AND  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A'),0)) AS saldo_cartera,

						((SELECT SUM(r.valor) FROM relacion_mora r WHERE r.solicitud_id=s.solicitud_id AND r.estado != 'D' AND r.tipo='R')-
						IF((SELECT SUM(m.valor_abono) FROM relacion_mora r,  mora_factura m, encabezado_de_registro e 
						WHERE r.solicitud_id=s.solicitud_id AND r.tipo='R' AND  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' )>0,
						(SELECT SUM(m.valor_abono) FROM relacion_mora r,  mora_factura m, encabezado_de_registro e 
						WHERE r.solicitud_id=s.solicitud_id AND r.tipo='R' AND  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A'),0)) AS saldo_recuperaciones,

						IF((SELECT COUNT(*) FROM relacion_mora r WHERE r.solicitud_id=s.solicitud_id AND r.estado='C' AND
						((SELECT SUM(m.valor_abono) FROM  mora_factura m, encabezado_de_registro e 
						WHERE  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ) IS NULL
				 		OR ((r.valor)-(SELECT SUM(m.valor_abono) FROM  mora_factura m, encabezado_de_registro e 
						WHERE  m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ))>0) )>0,'MORA', 'PREMORA') AS estado
				FROM solicitud s
				WHERE s.solicitud_id IN (SELECT solicitud_id FROM relacion_mora WHERE estado IN('A','C')) AND 
				(SELECT SUM(r.valor) FROM relacion_mora r WHERE r.estado IN('A','C') AND r.solicitud_id=s.solicitud_id)>0 AND 
				
				((SELECT SUM(m.valor_abono) FROM relacion_mora r, mora_factura m, encabezado_de_registro e 
				WHERE r.solicitud_id = s.solicitud_id AND r.estado!='D' AND m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ) IS NULL
				 OR ((SELECT SUM(r.valor) FROM relacion_mora r WHERE r.estado IN('A','C') AND r.solicitud_id=s.solicitud_id)-(SELECT SUM(m.valor_abono) FROM relacion_mora r, mora_factura m, encabezado_de_registro e 
				WHERE r.solicitud_id = s.solicitud_id AND r.estado!='D' AND m.relacion_mora_id=r.relacion_mora_id AND e.encabezado_registro_id=m.encabezado_registro_id AND e.estado!='A' ))>0)"; 
				$results = $this -> DbFetchAll($Query,$Conex,true);
     return $results;
   }


   
}



?>