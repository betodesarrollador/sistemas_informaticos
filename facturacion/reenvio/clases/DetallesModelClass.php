<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getReporteRF($oficina_id,$desde,$hasta,$cliente,$tipo_c,$Conex){  //ok
	   	
		$select = "SELECT 
					f.factura_id,
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  WHEN 'SE' THEN 'Orden de Servicio'  ELSE '' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
					(SELECT  	p.prefijo  FROM parametros_factura p WHERE p.parametros_factura_id=f.parametros_factura_id  ) AS prefijo,
					f.consecutivo_factura,				
					f.fecha,
					f.cliente_id,
					f.vencimiento,
					f.valor,
					IF(f.reportada=1,'SI','NO') AS reportada,
					f.cufe,
					IF(f.acuse=1,'RECIBIDO','EN_ESPERA') AS tipo_acuse,
					CASE f.acuseRespuesta WHEN '0' THEN 'A LA ESPERA' WHEN '1' THEN 'ACEPTADA' WHEN '2' THEN 'RECHAZADA' WHEN '3' THEN 'EN VERIFICAcION' ELSE  '' END AS acuse_respuesta,
					f.fecha_acuse,
					f.acuseComentario,
					f.xml_dian,
					f.pdf_dian,
					(SELECT (deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' )	AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
				FROM factura f
				WHERE f.estado IN ('A','C') AND f.fecha BETWEEN '$desde' AND '$hasta' $cliente $tipo_c AND f.oficina_id IN ($oficina_id) 
				AND f.parametros_factura_id IN (SELECT p.parametros_factura_id FROM parametros_factura p WHERE p.fact_electronica=1)
				ORDER BY  f.consecutivo_factura ASC "; 

    	$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
  
  }

  public function ActualizarPDF($factura_id,$factura,$Conex){
	  	  
  	$this -> Begin($Conex);
 	
	  $update = "UPDATE factura SET pdf_dian='$factura' WHERE factura_id=$factura_id";
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);
	

  }

  public function ActualizarXML($factura_id,$factura,$Conex){
	  	  
  	$this -> Begin($Conex);

      $update = "UPDATE factura SET xml_dian='$factura' WHERE factura_id=$factura_id";
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);
	

  }

}



?>