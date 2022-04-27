<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class DetallesContablesModel extends Db
{

    private $Permisos;

    public function getImputacionesContables($factura_id, $encabezado_registro_id, $Conex)
    {
        if (is_numeric($factura_id)) {

            $select = "SELECT
                p.codigo_puc,
                t.numero_identificacion,
                CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS tercero,
                t.tercero_id,
                ic.descripcion,
                ic.base,
                ic.debito,
                ic.credito
            FROM
                imputacion_contable ic, tercero t, puc p
            WHERE
                ic.encabezado_registro_id = $encabezado_registro_id AND ic.tercero_id = t.tercero_id AND ic.puc_id = p.puc_id";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }

        return $result;

    }

}
