<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";
final class Imp_DocumentoModel extends Db
{

    public function getEncabezado($encabezado_registro_id, $Conex)
    {
        
        if (is_numeric($encabezado_registro_id)) {

            $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, 
            (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
			(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp,
			(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
			(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
			(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,
			(SELECT texto_soporte FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_soporte,
			(SELECT texto_tercero FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_tercero,

			(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS tipo_documento,
            (SELECT codigo FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS prefijo_doc,

			(SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion,
			(SELECT nombre FROM forma_pago WHERE forma_pago_id=e.forma_pago_id) AS  formapago,
            (SELECT a.cufe FROM nota_debito a WHERE a.encabezado_registro_id=e.encabezado_registro_id) AS cufe,
            (SELECT i.valor FROM imputacion_contable i WHERE i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos IN('IV') AND i.encabezado_registro_id=e.encabezado_registro_id))AS ValIva,
			(SELECT consecutivo_factura FROM factura WHERE factura_id = (SELECT factura_id FROM nota_debito WHERE encabezado_registro_id = e.encabezado_registro_id)) AS consecutivo_factura,
			e.*,
			t.primer_nombre,
			t.segundo_nombre,
			t.primer_apellido,
			t.segundo_apellido,
			t.numero_identificacion,
			t.razon_social,
			t.digito_verificacion,
			t.sigla,
			t.direccion,
			of.nombre AS nom_oficina,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi
			FROM encabezado_de_registro  e, oficina of, tercero t WHERE e.encabezado_registro_id = $encabezado_registro_id AND of.oficina_id=e.oficina_id AND t.tercero_id=e.tercero_id";
            $result = $this->DbFetchAll($select, $Conex,true);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getimputaciones($encabezado_registro_id, $Conex)
    {

        if (is_numeric($encabezado_registro_id)) {

            $select = "SELECT i.*,
		(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = i.tercero_id ) AS nombre,
				(SELECT codigo_puc FROM puc WHERE puc_id=i.puc_id) AS puc_cod,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS identificacion_tercero,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo_cento
         FROM  imputacion_contable i   WHERE i.encabezado_registro_id = $encabezado_registro_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getTotal($encabezado_registro_id, $Conex)
    {        
        
        if (is_numeric($encabezado_registro_id)) {

            $select = "SELECT SUM(debito) AS total_debito, SUM(credito) AS total_credito
         FROM  imputacion_contable    WHERE encabezado_registro_id = $encabezado_registro_id ";
            $result = $this->DbFetchAll($select, $Conex,true);

        } else {
            $result = array();
        }
        return $result;
    }
    public function getTotales($encabezado_registro_id, $Conex)
    {

        $encabezado_registro_id = $this->requestDataForQuery('encabezado_registro_id', 'integer');

        if (is_numeric($encabezado_registro_id)) {

            $select = "SELECT SUM(debito) AS total
         FROM  imputacion_contable    WHERE encabezado_registro_id = $encabezado_registro_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }
}