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
						 IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,d.seguimiento_id,(SELECT consecutivo FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id)) ) AS numero,
                         IF(d.remesa_id>0,(SELECT estado FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,d.seguimiento_id,(SELECT estado_orden_servicio FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id)) ) AS estado
	  		FROM detalle_factura  d, factura f WHERE f.factura_id = $factura_id AND d.factura_id=f.factura_id";

            $result = $this->DbFetchAll($select, $Conex,true);

        } else {
            $result = array();
        }

        return $result;

    }

    public function Detalles($detalle_factura_id,$Conex){

        $data = array();

        $select="SELECT d.remesa_id, 
                        d.orden_servicio_id,
                        d.valor,
                        IF(d.remesa_id>0,(SELECT estado FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,d.seguimiento_id,(SELECT estado_orden_servicio FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id)) ) AS estado
                FROM detalle_factura d WHERE detalle_factura_id = $detalle_factura_id";
        $result = $this->DbFetchAll($select,$Conex,true);

        $remesa_id = $result[0]['remesa_id'];
        $orden_servicio_id = $result[0]['orden_servicio_id'];
        $valor = $result[0]['valor'];
        $estado = $result[0]['estado'];

        $data['valor']=$valor;
        $data['estado']=$estado;

        if($remesa_id>0){

            $data['remesa_id']=$remesa_id;

        }else if($orden_servicio_id>0){

             $data['orden_servicio_id']=$orden_servicio_id;

        }

        return $data;

    }


}
