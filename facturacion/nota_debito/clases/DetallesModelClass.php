<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class DetallesModel extends Db
{

    private $Permisos;

    public function getImputacionesContables($factura_id, $fuente_facturacion_cod, $empresa_id, $oficina_id, $Conex)
    {

        if (is_numeric($factura_id)) {

            $select = "SELECT f.fuente_facturacion_cod,
						 f.factura_id,
						 IF(d.orden_servicio_id>0,'Orden de Servicio',IF(d.remesa_id,'Remesa','Despacho Particular')) AS fuente,
	  					 d.*,
						 (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
						 (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
						 (SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id) AS producto,
						 IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,d.seguimiento_id,(SELECT consecutivo FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id)) ) AS numero
	  		FROM detalle_factura  d, factura f WHERE f.factura_id = $factura_id AND d.factura_id=f.factura_id";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }

        return $result;

    }

}
