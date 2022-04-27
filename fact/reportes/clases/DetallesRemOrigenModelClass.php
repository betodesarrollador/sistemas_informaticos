<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class DetallesRemOrigenModel extends Db
{

    private $Permisos;

    public function getReporteRemOrigen($desde, $hasta, $origen, $Conex)
    { //ok
        $select = "SELECT
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
			r.remesa_id,
			r.numero_remesa,
			r.valor_facturar,
			f.factura_id,
			f.consecutivo_factura,
			f.valor
		FROM
			factura f,
			remesa r,
			detalle_factura df
		WHERE
			r.origen_id = $origen AND
			f.fecha BETWEEN '$desde' AND '$hasta' AND
			df.remesa_id = r.remesa_id AND
			df.factura_id = f.factura_id";
		
		$result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

}
