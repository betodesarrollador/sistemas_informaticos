<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";
final class reporteDocumentosModel extends Db
{
    private $Permisos;
    public function SetUsuarioId($UserId, $CodCId)
    {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($UserId, $CodCId);
    }
    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function GetOficina($Conex)
    {
        return $this->DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina", $Conex, $ErrDb = false);
    }

    public function GetEstado($Conex)
    {
        $opciones = array(0 => array('value' => 'E', 'text' => 'DOCUMENTOS EDICION'),
            1 => array('value' => 'C', 'text' => 'DOCUMENTOS CONTABILIZADO'),
            2 => array('value' => 'I', 'text' => 'DOCUMENTOS ANULADOS'),
        );
        return $opciones;
    }
    public function GetSi_Pro($Conex)
    {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }

    public function getReporte1($desde, $hasta, $Conex)
    {

        $select_DATABASE = "SELECT DATABASE() as db";
        $result_DATABASE = $this->DbFetchAll($select_DATABASE, $Conex, true);
        $database = $result_DATABASE[0]['db'];

        $select_COLUMN_encabezado_registro_id = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
	WHERE  COLUMN_NAME = 'encabezado_registro_id' AND TABLE_SCHEMA = (SELECT DATABASE()) AND TABLE_NAME NOT IN ('imputacion_contable','imputacion_contable_nivel4','encabezado_de_registro_anulado','legalizacion_despacho','legalizacion_manifiesto','liquidacion_cesantias','liquidacion_definitiva','liquidacion_despacho','liquidacion_int_cesantias','liquidacion_novedad','liquidacion_patronal','liquidacion_prima','liquidacion_provision','liquidacion_vacaciones','novedad_fija','liquidacion_nomina','anticipos_despacho','anticipos_manifiesto','anticipos_particular','anticipos_placa','anticipos_proveedor','cierre_crm','depreciacion_activo','guia','guia_domicilio','guia_interconexion','imputacion_contable_loc','legalizacion_caja','liquidacion_despacho_descu','liquidacion_despacho_sobre','plantilla_tesoreria','valorizacion_activo')
    GROUP BY TABLE_NAME";
//la tabla liquidacion_despacho_descu, liquidacion_despacho_sobre  no posee el campo usuario_id nos toca hacerlo
        $result_TABLE = $this->DbFetchAll($select_COLUMN_encabezado_registro_id, $Conex, true);

        $result_registro = array();

        $array_modulo = array("../../../facturacion/pago/clases/PagoClass.php" => abono_factura, "../../../proveedores/pago/clases/PagoClass.php" => abono_factura_proveedor, "../../../Nomina" => abono_nomina, "../../../transporte/operacion/clases/AnticiposClass.php?rand=1" => anticipos_despacho, "../../../transporte/operacion/clases/AnticiposClass.php?rand=2" => anticipos_manifiesto, "../../../transporte/operacion/clases/AnticiposClass.php?rand=3" => anticipos_particular, "../../../transporte/operacion/clases/AnticiposClass.php?rand=4" => anticipos_particular2, "../../../transporte/operacion/clases/CierreContadoClass.php" => cierre_contado, "../../../Comisiones" => comisiones, "../../../transporte/operacion/clases/DespachosUrbanosClass.php" => despachos_urbanos, "../../../Activos Fijos" => entrada_activo, "../../../facturacion/factura/clases/FacturaClass.php" => factura, "../../../Facturacion Pos" => factura_pos, "../../../proveedores/causar/clases/CausarClass.php" => factura_proveedor, "../../../transporte/operacion/clases/LegalizacionClass.php" => legalizacion_manifiesto, "../../../transporte/operacion/clases/LegalizacionDespachosClass.php" => legalizacion_despacho, "../../../transporte/operacion/clases/LegalizacionParticularesClass.php" => legalizacion_particular, "../../../nomina/movimientos/clases/CesantiasClass.php" => liquidacion_cesantias, "../../../nomina/movimientos/clases/LiquidacionFinalClass.php" => liquidacion_definitiva, "../../../transporte/operacion/clases/LiquidacionDescuClass.php" => liquidacion_despacho, "../../../transporte/operacion/clases/LiquidacionDescuDespaClass.php" => liquidacion_despacho_descu, "transporte" => liquidacion_despacho_sobre, "../../../nomina/movimientos/clases/RegistrarClass.php?rand=1" => liquidacion_novedad, "../../../nomina/movimientos/clases/PatronalesClass.php" => liquidacion_patronal, "../../../nomina/movimientos/clases/PrimaClass.php" => liquidacion_prima, "../../../nomina/movimientos/clases/ProvisionesClass.php" => liquidacion_provision, "../../../nomina/movimientos/clases/VacacionClass.php" => liquidacion_vacaciones, "../../../transporte/operacion/clases/ManifiestosClass.php" => manifiesto, "../../../nomina/movimientos/clases/NovedadClass.php" => novedad_fija, "../../../tesoreria/movimientos/clases/PlantillaTesoreriaClass.php" => plantilla_tesoreria, "../../../Activos Fijos" => salida_activo, "../../../Activos Fijos" => valorizacion_activo, "../../../transporte/operacion/clases/RemesasContadoClass.php" => remesa, "../../../nomina/movimientos/clases/RegistrarClass.php?rand=2" => liquidacion_nomina);

        for ($i = 0; $i < count($result_TABLE); $i++) {

            $tabla = $result_TABLE[$i][TABLE_NAME];

            $select_estado = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_NAME LIKE '%estado%'  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_estado = $this->DbFetchAll($select_estado, $Conex, true);

            $select_primary = "select COLUMN_NAME, COLUMN_KEY from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_KEY IN('PRI') AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_primary = $this->DbFetchAll($select_primary, $Conex, true);

            $select_oficina = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_NAME LIKE '%oficina_id%'  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_oficina = $this->DbFetchAll($select_oficina, $Conex, true);

            $select_usuario = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_NAME = 'usuario_id'  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_usuario = $this->DbFetchAll($select_usuario, $Conex, true);

            $select_fecha = "select COLUMN_NAME, TABLE_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND (COLUMN_NAME  = 'fecha' OR COLUMN_NAME = 'fecha_ingreso' OR COLUMN_NAME = 'fecha_factura_proveedor' OR COLUMN_NAME = 'fecha_remesa' OR COLUMN_NAME = 'fecha_du' OR COLUMN_NAME = 'fecha_mc')  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_fecha = $this->DbFetchAll($select_fecha, $Conex, true);

            foreach ($array_modulo as $nombre_modulo => $nombre_tabla) {

                if ($nombre_tabla == $tabla) {
                    $direccion = $nombre_modulo;
                    $modulo = strtoupper(substr($nombre_modulo, 9, 11));
                }
            }

            $campo = $result_estado[0]['COLUMN_NAME'];
            $primary = $result_primary[0]['COLUMN_NAME'];
            $oficina = $result_oficina[0]['COLUMN_NAME'];
            $usuario = $result_usuario[0]['COLUMN_NAME'];
            $fecha = $result_fecha[0]['COLUMN_NAME'];

            if ($tabla == 'encabezado_de_registro') {
                $estado = 'E';
            } elseif ($tabla == 'despachos_urbanos' || $tabla == 'manifiesto') {
                $estado = 'P';
            } else {
                $estado = 'A';
            }

            $select_registro = "select a.$primary AS consecutivo,
                '$direccion' AS direccion,
                '$primary' AS llave,
                '$modulo' AS modulo,
                a.$fecha AS fecha,
				(SELECT codigo_centro FROM oficina o WHERE o.oficina_id = a.$oficina) AS oficina_codigo,
				(SELECT nombre FROM oficina o WHERE o.oficina_id = a.$oficina) AS oficina_nombre,
				(SELECT CONCAT(t.numero_identificacion,'-',IF(t.razon_social IS NULL,CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,
				t.primer_apellido,t.segundo_apellido),t.razon_social)) FROM tercero t, usuario u WHERE t.tercero_id = u.tercero_id AND u.usuario_id = a.$usuario) AS modifica
				from $tabla a WHERE a.$campo = '$estado' AND $fecha BETWEEN '$desde' AND '$hasta'";

            $result_registro[$i] = $this->DbFetchAll($select_registro, $Conex, true);

        }

        return $result_registro;

    }

    public function getReporte2($desde, $hasta, $Conex)
    {
        $select_registro1 = "select c.consecutivo AS consecutivo,
                 c.encabezado_registro_id,
                c.fecha AS fecha,
				(SELECT codigo_centro FROM oficina o WHERE o.oficina_id = c.oficina_id) AS oficina_codigo,
				(SELECT nombre FROM oficina o WHERE o.oficina_id = c.oficina_id) AS oficina_nombre,
				(SELECT CONCAT(t.numero_identificacion,'-',IF(t.razon_social IS NULL,CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,
				t.primer_apellido,t.segundo_apellido),t.razon_social)) FROM tercero t, usuario u WHERE t.tercero_id = u.tercero_id AND u.usuario_id = c.usuario_id) AS modifica
				from encabezado_de_registro c WHERE c.estado = 'C' AND c.fecha BETWEEN '$desde' AND '$hasta'";
        $result_registro1 = $this->DbFetchAll($select_registro1, $Conex, true);

        return $result_registro1;
    }

    public function getReporte3($desde, $hasta, $Conex)
    {

        $select_DATABASE = "SELECT DATABASE() as db";
        $result_DATABASE = $this->DbFetchAll($select_DATABASE, $Conex, true);
        $database = $result_DATABASE[0]['db'];

        $select_COLUMN_encabezado_registro_id = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
	WHERE  COLUMN_NAME = 'encabezado_registro_id' AND TABLE_SCHEMA = (SELECT DATABASE()) AND TABLE_NAME NOT IN ('imputacion_contable','imputacion_contable_nivel4','encabezado_de_registro_anulado','legalizacion_despacho','legalizacion_manifiesto','liquidacion_cesantias','liquidacion_definitiva','liquidacion_despacho','liquidacion_int_cesantias','liquidacion_novedad','liquidacion_patronal','liquidacion_prima','liquidacion_provision','liquidacion_vacaciones','novedad_fija','liquidacion_nomina','anticipos_despacho','anticipos_manifiesto','anticipos_particular','anticipos_placa','anticipos_proveedor','cierre_crm','depreciacion_activo','guia','guia_domicilio','guia_interconexion','imputacion_contable_loc','legalizacion_caja','liquidacion_despacho_descu','liquidacion_despacho_sobre','plantilla_tesoreria','valorizacion_activo')
    GROUP BY TABLE_NAME";

        $result_TABLE = $this->DbFetchAll($select_COLUMN_encabezado_registro_id, $Conex, true);

        $result_registro = array();

        $array_modulo = array("../../../facturacion/pago/clases/PagoClass.php" => abono_factura, "../../../proveedores/pago/clases/PagoClass.php" => abono_factura_proveedor, "../../../Nomina" => abono_nomina, "../../../transporte/operacion/clases/AnticiposClass.php?rand=1" => anticipos_despacho, "../../../transporte/operacion/clases/AnticiposClass.php?rand=2" => anticipos_manifiesto, "../../../transporte/operacion/clases/AnticiposClass.php?rand=3" => anticipos_particular, "../../../transporte/operacion/clases/AnticiposClass.php?rand=4" => anticipos_particular2, "../../../transporte/operacion/clases/CierreContadoClass.php" => cierre_contado, "../../../Comisiones" => comisiones, "../../../transporte/operacion/clases/DespachosUrbanosClass.php" => despachos_urbanos, "../../../Activos Fijos" => entrada_activo, "../../../facturacion/factura/clases/FacturaClass.php" => factura, "../../../Facturacion Pos" => factura_pos, "../../../proveedores/causar/clases/CausarClass.php" => factura_proveedor, "../../../transporte/operacion/clases/LegalizacionClass.php" => legalizacion_manifiesto, "../../../transporte/operacion/clases/LegalizacionDespachosClass.php" => legalizacion_despacho, "../../../transporte/operacion/clases/LegalizacionParticularesClass.php" => legalizacion_particular, "../../../nomina/movimientos/clases/CesantiasClass.php" => liquidacion_cesantias, "../../../nomina/movimientos/clases/LiquidacionFinalClass.php" => liquidacion_definitiva, "../../../transporte/operacion/clases/LiquidacionDescuClass.php" => liquidacion_despacho, "../../../transporte/operacion/clases/LiquidacionDescuDespaClass.php" => liquidacion_despacho_descu, "transporte" => liquidacion_despacho_sobre, "../../../nomina/movimientos/clases/RegistrarClass.php?rand=1" => liquidacion_novedad, "../../../nomina/movimientos/clases/PatronalesClass.php" => liquidacion_patronal, "../../../nomina/movimientos/clases/PrimaClass.php" => liquidacion_prima, "../../../nomina/movimientos/clases/ProvisionesClass.php" => liquidacion_provision, "../../../nomina/movimientos/clases/VacacionClass.php" => liquidacion_vacaciones, "../../../transporte/operacion/clases/ManifiestosClass.php" => manifiesto, "../../../nomina/movimientos/clases/NovedadClass.php" => novedad_fija, "../../../tesoreria/movimientos/clases/PlantillaTesoreriaClass.php" => plantilla_tesoreria, "../../../Activos Fijos" => salida_activo, "../../../Activos Fijos" => valorizacion_activo, "../../../transporte/operacion/clases/RemesasContadoClass.php" => remesa, "../../../nomina/movimientos/clases/RegistrarClass.php?rand=2" => liquidacion_nomina);

        for ($i = 0; $i < count($result_TABLE); $i++) {

            $tabla = $result_TABLE[$i][TABLE_NAME];

            $select_estado = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_NAME LIKE '%estado%'  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_estado = $this->DbFetchAll($select_estado, $Conex, true);

            $select_primary = "select COLUMN_NAME, COLUMN_KEY from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_KEY IN('PRI') AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_primary = $this->DbFetchAll($select_primary, $Conex, true);

            $select_oficina = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_NAME LIKE '%oficina_id%'  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_oficina = $this->DbFetchAll($select_oficina, $Conex, true);

            $select_usuario = "select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND COLUMN_NAME = 'usuario_id'  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";
            $result_usuario = $this->DbFetchAll($select_usuario, $Conex, true);

            $select_fecha = "select COLUMN_NAME, TABLE_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$tabla' AND (COLUMN_NAME  = 'fecha' OR COLUMN_NAME = 'fecha_ingreso' OR COLUMN_NAME = 'fecha_factura_proveedor' OR COLUMN_NAME = 'fecha_remesa' OR COLUMN_NAME = 'fecha_du' OR COLUMN_NAME = 'fecha_mc')  AND TABLE_SCHEMA = '$database'  GROUP BY COLUMN_NAME";

            $result_fecha = $this->DbFetchAll($select_fecha, $Conex, true);

            foreach ($array_modulo as $nombre_modulo => $nombre_tabla) {

                if ($nombre_tabla == $tabla) {
                    $direccion = $nombre_modulo;
                    $modulo = strtoupper(substr($nombre_modulo, 9, 11));
                }
            }

            $campo = $result_estado[0]['COLUMN_NAME'];
            $primary = $result_primary[0]['COLUMN_NAME'];
            $oficina = $result_oficina[0]['COLUMN_NAME'];
            $usuario = $result_usuario[0]['COLUMN_NAME'];
            $fecha = $result_fecha[0]['COLUMN_NAME'];

            if ($tabla == 'encabezado_de_registro' || $tabla == 'despachos_urbanos' || $tabla == 'manifiesto') {
                $estado = 'A';
            } else {
                $estado = 'I';
            }

            $select_registro = "select a.$primary AS consecutivo,
                '$direccion' AS direccion,
                '$primary' AS llave,
                '$modulo' AS modulo,
                a.$fecha AS fecha,
				(SELECT codigo_centro FROM oficina o WHERE o.oficina_id = a.$oficina) AS oficina_codigo,
				(SELECT nombre FROM oficina o WHERE o.oficina_id = a.$oficina) AS oficina_nombre,
				(SELECT CONCAT(t.numero_identificacion,'-',IF(t.razon_social IS NULL,CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,
				t.primer_apellido,t.segundo_apellido),t.razon_social)) FROM tercero t, usuario u WHERE t.tercero_id = u.tercero_id AND u.usuario_id = a.$usuario) AS modifica
				from $tabla a WHERE a.$campo = '$estado' AND $fecha BETWEEN '$desde' AND '$hasta'";

            $result_registro[$i] = $this->DbFetchAll($select_registro, $Conex, true);

        }

        return $result_registro;

    }

}
