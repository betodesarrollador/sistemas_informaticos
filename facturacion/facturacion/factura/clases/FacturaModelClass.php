<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";
final class FacturaModel extends Db
{

    private $UserId;
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
    //inicio bloque  factura electronica
    public function seAdjunto($factura_id, $dir_file, $Conex)
    {
        $update = "UPDATE factura SET adjunto='$dir_file'	 WHERE factura_id= $factura_id";
        $result = $this->query($update, $Conex, true);
        return $result;

    }
    public function setEstadoFactura($factura_id, $acuse, $fecha, $acuseRespuesta,$cufe,$esValidoDIAN,$acuseComentario, $Conex)
    {
        $update = "UPDATE factura SET acuse=$acuse, fecha_acuse='$fecha', acuseRespuesta=$acuseRespuesta, acuseComentario='$acuseComentario',cufe='$cufe',validacion_dian='$esValidoDIAN'
	 WHERE factura_id= $factura_id";
        $result = $this->query($update, $Conex, true);
        return $result;

    }
    public function setLeerCodigobar($remesa, $cliente_id, $Conex)
    {
        $select = "SELECT g.remesa_id AS consecutivo ,g.estado,'remesa' AS tipo,(SELECT of.nombre FROM oficina of 	WHERE 						of.oficina_id = g.oficina_id) AS oficina,g.numero_remesa AS guia FROM remesa g WHERE g.numero_remesa=$remesa
				AND g.cliente_id=$cliente_id
				 UNION ALL
				SELECT o.orden_servicio_id AS consecutivo,o.estado_orden_servicio AS estado, 'orden_servicio' AS tipo,(SELECT of.nombre FROM oficina of WHERE of.oficina_id = o.oficina_id) AS oficina,o.consecutivo AS guia FROM orden_servicio o WHERE o.consecutivo=$remesa AND o.cliente_id=$cliente_id";

        $result = $this->DbFetchAll($select, $Conex);
        return $result;
    }
    public function setMensajeFactura($factura_id, $fecha, $ultimo_mensaje, $cufe, $xml, $Conex)
    {
        $update = "UPDATE factura SET reportada=1, fecha_envio='$fecha', ultimo_mensaje='$ultimo_mensaje',cufe='$cufe',xml='$xml' WHERE factura_id= $factura_id";
        $result = $this->query($update, $Conex, true);
        return $result;

    }
    public function setMensajeNOFactura($factura_id, $fecha, $ultimo_mensaje, $Conex)
    {
        $update = "UPDATE factura SET reportada=0, fecha_envio='$fecha', ultimo_mensaje='$ultimo_mensaje' WHERE factura_id= $factura_id";
        $result = $this->query($update, $Conex, true);
        return $result;

    }
    public function getReteica($Conex)
    {

        $select = "SELECT impuesto_id AS value,nombre AS text FROM impuesto WHERE exentos='RIC' ORDER BY nombre";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;
    }
    public function getTokens($Conex)
    {
        $select = "SELECT wsdl,
	                  wsanexo,
					  wsdl_prueba,
					  wsanexo_prueba,
					  tokenenterprise,
					  tokenautorizacion,
					  correo,
					  correo_segundo,
					  ambiente
				FROM param_factura_electronica WHERE estado = 1";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }


    public function getFechavencimiento ($fecha_inicio,$cliente_id,$Conex){

	   

        $select = "SELECT dias_vencimiento FROM cliente WHERE cliente_id=$cliente_id ";
 
        $result = $this -> DbFetchAll($select,$Conex,false);
 
        $dias = $result[0]['dias_vencimiento'];
 
        if($dias==0){
 
            return false;
 
        }
 
        else{
 
        $vencimiento = date('Y-m-d', strtotime("$fecha_inicio + ".$dias." day"));
 
        
 
         return $vencimiento;
 
         }
 
    }
    public function getDataFactura_total($factura_id, $Conex)
    {
        $select = "SELECT f.*,
				 		(SELECT  pf.prefijo 	FROM  parametros_factura pf WHERE pf.parametros_factura_id=f.parametros_factura_id ) AS prefijo,
						(SELECT  pf.rango_inicial 	FROM  parametros_factura pf WHERE pf.parametros_factura_id=f.parametros_factura_id ) AS rango_inicial,
						(SELECT t.numero_identificacion FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS nroDoc,
						(SELECT t.digito_verificacion FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS nroDocDV,
						(SELECT t.razon_social FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS razonsocial,
						(SELECT CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS apellido,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre) FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS nombre,
						(SELECT t.segundo_nombre FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_segundo,
						(SELECT t.email FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS correo,
						(SELECT p.email_cliente FROM  cliente p WHERE p.cliente_id=f.cliente_id  ) AS correo2,
						(SELECT t.direccion FROM cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND t.tercero_id=p.tercero_id ) AS direccion,
						(SELECT t.email FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_email,
						(SELECT u.nombre FROM ubicacion u, cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id AND  u.ubicacion_id=t.ubicacion_id) AS ciudad,
						(SELECT u.divipola FROM ubicacion u, cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id AND  u.ubicacion_id=t.ubicacion_id) AS cod_ciudad,
						(SELECT (SELECT ub.nombre FROM  ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id ) FROM ubicacion u, cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id AND  u.ubicacion_id=t.ubicacion_id) AS departamento,
						(SELECT (SELECT ub.divipola FROM  ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )  FROM ubicacion u, cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id AND  u.ubicacion_id=t.ubicacion_id) AS cod_depto,
						(SELECT t.telefono FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND t.tercero_id=p.tercero_id ) AS telefono,
						(SELECT IF(t.tipo_persona_id=1,'2','1') FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS tipo_persona,
						(SELECT IF(t.regimen_id=1,'0','2') FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS regimen,
						(SELECT IF(t.regimen_id=1,'04','05') FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS regimen_new,
						(SELECT ti.codigo FROM  cliente p, tercero t, tipo_identificacion ti WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id AND ti.tipo_identificacion_id=t.tipo_identificacion_id ) AS tipoDoc,
						(SELECT t.zona_postal FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id) AS zona_postal,
						(SELECT c.codigo FROM codigo_ciiu c, cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id AND t.codigo_ciiu_id=c.codigo_ciiu_id) AS codigo_ciiu,
						(SELECT d.valor_liquida FROM detalle_factura_puc d WHERE d.factura_id = $factura_id AND d.contra_factura=0 AND (d.porcentaje_factura=0 OR d.porcentaje_factura IS NULL) LIMIT 1) AS totalSinImpuestos,
						(SELECT SUM(d.valor_liquida) FROM detalle_factura_puc d WHERE d.factura_id = $factura_id AND d.contra_factura=0 AND (d.porcentaje_factura=0 OR d.porcentaje_factura IS NULL)) AS totalSinImpuestosTercero,
					    (SELECT COUNT(*) FROM codpuc_bien_servicio_factura c WHERE c.tipo_bien_servicio_factura_id = f.tipo_bien_servicio_factura_id AND f.factura_id = $factura_id AND c.contra_bien_servicio_factura = 0)AS cuentas_sin_imp,
                        (SELECT cf.correo_cliente_factura_operativa FROM cliente_factura_operativa cf WHERE cf.cliente_factura_operativa_id = f.sede_id)AS correo_sede,

						(SELECT SUM(d.valor_liquida) FROM detalle_factura_puc d WHERE d.factura_id = $factura_id AND d.contra_factura=1  ) AS importeTotal,
						(SELECT SUM(df.cantidad) FROM detalle_factura df WHERE df.factura_id = $factura_id   ) AS cantidad_productos,
						(SELECT  	p.prefijo  FROM parametros_factura p WHERE p.parametros_factura_id=f.parametros_factura_id  ) AS prefijo1
					FROM factura f
	                WHERE f.factura_id = $factura_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;

    }
    public function getDataFactura_detalle($factura_id, $Conex)
    {
        $select = "SELECT f.*,
	 				(SELECT COUNT(*) FROM orden_servicio o,  codpuc_bien_servicio_factura c, impuesto  i
					  WHERE o.orden_servicio_id=f.orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id
					  AND i.puc_id=c.puc_id AND i.exentos='IV' ) AS iva,
	 				(SELECT COUNT(*) FROM orden_servicio o,  codpuc_bien_servicio_factura c, impuesto  i
					  WHERE o.orden_servicio_id=f.orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id
					  AND i.puc_id=c.puc_id AND i.exentos='ICO' ) AS ico,
	 				(SELECT COUNT(*) FROM orden_servicio o,  codpuc_bien_servicio_factura c, impuesto  i
					  WHERE o.orden_servicio_id=f.orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id
					  AND i.puc_id=c.puc_id AND i.exentos='RIV' ) AS riv,

					(SELECT df.porcentaje_factura FROM detalle_factura_puc df, impuesto i
					 WHERE df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='IV' LIMIT 1) AS por_iva,
					(SELECT df.porcentaje_factura FROM detalle_factura_puc df, impuesto i
					 WHERE df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='ICO' LIMIT 1) AS por_ico,
					(SELECT df.porcentaje_factura FROM detalle_factura_puc df, impuesto i
					 WHERE df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RIV' LIMIT 1) AS por_riv,
					(SELECT df.formula_factura  FROM detalle_factura_puc df, impuesto i
					 WHERE df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='IV' LIMIT 1) AS for_iva,
					(SELECT df.formula_factura  FROM detalle_factura_puc df, impuesto i
					 WHERE df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='ICO' LIMIT 1) AS for_ico,
					(SELECT df.formula_factura  FROM detalle_factura_puc df, impuesto i
					 WHERE df.factura_id=f.factura_id AND i.puc_id=df.puc_id AND i.exentos='RIV' LIMIT 1) AS for_riv,
					(SELECT numero_remesa FROM remesa WHERE remesa_id=f.remesa_id) AS no_remesa,
					(SELECT orden_despacho FROM remesa WHERE remesa_id=f.remesa_id) AS orden_despacho,
					(SELECT CONCAT_WS(' ',fecha_remesa, hora_recogida_ss) FROM remesa WHERE remesa_id=f.remesa_id) AS fecha_remesa					
					FROM detalle_factura f
					WHERE f.factura_id = $factura_id AND valor > 0";

        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;

    }
    public function getDataFactura_Obligaciones($factura_id, $Conex)
    {
        $select = "SELECT c.codigo, c.nombre
					FROM  tercero_obligacion tob, codigo_obligacion c, cliente cl, tercero t, factura f
	                WHERE f.factura_id = $factura_id AND cl.cliente_id=f.cliente_id AND t.tercero_id=cl.tercero_id AND tob.tercero_id=t.tercero_id
					AND c.codigo_obligacion_id=tob.codigo_obligacion_id AND tob.estado='A' AND c.estado='A'";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;

    }
    public function getDataFactura_puc($factura_id, $Conex)
    {
        $select = "SELECT f.*, f.valor_liquida AS valor_liquida,
	                           SUM(f.base_factura) AS base_factura,
	 				(SELECT i.exentos FROM impuesto i WHERE i.puc_id=f.puc_id AND i.estado='A' LIMIT 1) AS tipo_impuesto,
					(SELECT i.subcodigo FROM impuesto i WHERE i.puc_id=f.puc_id AND i.estado='A' LIMIT 1) AS tipo_subcodigo

					FROM detalle_factura_puc f
					WHERE f.factura_id = $factura_id AND f.base_factura>0 AND f.porcentaje_factura>0 GROUP BY tipo_impuesto, tipo_subcodigo";

        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;

    }
    public function getDataFactura_puc_con($factura_id, $Conex)
    {
        $select = "SELECT f.*, f.valor_liquida AS valor_liquida, SUM(f.base_factura) AS base_factura,
	 				(SELECT i.exentos FROM impuesto i WHERE i.puc_id=f.puc_id AND i.estado='A' LIMIT 1) AS tipo_impuesto,
					(SELECT i.subcodigo FROM impuesto i WHERE i.puc_id=f.puc_id AND i.estado='A' LIMIT 1) AS tipo_subcodigo

					FROM detalle_factura_puc f
	                WHERE f.factura_id = $factura_id AND f.base_factura>0 AND f.porcentaje_factura>0 GROUP BY tipo_impuesto";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;

    }
    //fin bloque  factura electronica
    public function selectDatosFacturaId($factura_id, $Conex)
    {
        $select = "SELECT f.*,
                         TRUNCATE(f.valor,0) AS valor,
				 		(SELECT  pf.prefijo 	FROM  parametros_factura pf WHERE pf.parametros_factura_id=f.parametros_factura_id ) AS prefijo,
						(SELECT t.numero_identificacion FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_nit,
						(SELECT t.email FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_email,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente,
						(SELECT t.direccion FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_direccion,
						(SELECT u.nombre FROM ubicacion u, cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id AND  u.ubicacion_id=t.ubicacion_id) AS cliente_ciudad,
						(SELECT t.telefono FROM  cliente p, tercero t WHERE p.cliente_id=f.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_tele,
						(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id)AS oficina,
						(SELECT COUNT(*) AS pagos FROM relacion_abono r, abono_factura a WHERE r.factura_id=f.factura_id AND a.abono_factura_id=r.abono_factura_id AND (a.estado_abono_factura='A' OR a.estado_abono_factura='C') ) AS numero_pagos,
                        (SELECT p.fact_electronica FROM parametros_factura p WHERE p.parametros_factura_id=f.parametros_factura_id)AS fact_electronica
                        
					FROM factura f
	                WHERE f.factura_id = $factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;

    }
    public function selectEmpresa($empresa_id, $Conex)
    {
        $select = "SELECT e.email,
	                (SELECT razon_social FROM tercero WHERE tercero_id=e.tercero_id)AS nombre
	                FROM empresa e WHERE empresa_id=$empresa_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }

    public function getCausalesAnulacion($Conex)
    {

        $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;
    }
    public function getDataCliente($cliente_id, $Conex)
    {
        $select = "SELECT tr.numero_identificacion AS cliente_nit,
	 				tr.direccion AS cliente_direccion,
					tr.telefono AS cliente_tele,
					tr.email AS cliente_email,
					CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social) AS cliente,
					(SELECT nombre FROM ubicacion WHERE  ubicacion_id=tr.ubicacion_id) AS cliente_ciudad
	 			FROM cliente c, tercero tr
				WHERE c.cliente_id = $cliente_id  AND tr.tercero_id = c.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        $select_sede = "SELECT c.cliente_factura_operativa_id AS value,CONCAT_WS (' ',c.nombre_cliente_operativa,(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=c.ubicacion_id),c.direccion_cliente_operativa)AS text FROM cliente_factura_operativa c WHERE c.cliente_id = $cliente_id  ORDER BY text";
        $result_sede = $this->DbFetchAll($select_sede, $Conex, true);
        $result[0]['sedes'] = $result_sede;
        return $result;
    }
    public function getDataClienteOpe($sede_id, $cliente_id, $Conex)
    {
        if ($sede_id > 0) {
            $select = "SELECT cf.telefono_cliente_operativa AS cliente_tele,
			cf.direccion_cliente_operativa AS cliente_direccion,
			cf.correo_cliente_factura_operativa AS cliente_email,
			(SELECT nombre FROM ubicacion WHERE  ubicacion_id=cf.ubicacion_id) AS cliente_ciudad
			FROM cliente_factura_operativa cf
			WHERE cf.cliente_factura_operativa_id = $sede_id ";
        } else {
            $select = "SELECT tr.numero_identificacion AS cliente_nit,
			tr.direccion AS cliente_direccion,
			tr.telefono AS cliente_tele,
			tr.email AS cliente_email,
			CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social) AS cliente,
			(SELECT nombre FROM ubicacion WHERE  ubicacion_id=tr.ubicacion_id) AS cliente_ciudad
			FROM cliente c, tercero tr
			WHERE c.cliente_id = $cliente_id  AND tr.tercero_id = c.tercero_id";
        }
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }
    public function getDataFactura($factura_id, $Conex)
    {
        $select = "SELECT f.tipo_bien_servicio_factura_id
	 			FROM factura f
				WHERE f.factura_id = $factura_id ";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }
    public function SelectSolicitud($detalle_id, $fuente_facturacion_cod, $Conex)
    {
        if ($fuente_facturacion_cod == 'OS') {
            $select = "SELECT
					(SELECT SUM(valoruni_item_liquida_servicio*cant_item_liquida_servicio) AS total FROM  item_liquida_servicio WHERE orden_servicio_id=o.orden_servicio_id) AS valor,
					CONCAT('Orden de Servicio No ',o.orden_servicio_id,' / ',(SELECT nombre_bien_servicio_factura  FROM tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id)) AS concepto_detalle
					FROM orden_servicio o
					WHERE o.orden_servicio_id=$detalle_id";
            $result = $this->DbFetchAll($select, $Conex, true);

        } elseif ($fuente_facturacion_cod == 'RM') {
            $select = "SELECT
					r.valor_facturar AS valor,
					CONCAT('Remesa No ',r.numero_remesa,' / ',(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.origen_id),' / ',(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.destino_id),' / ',descripcion_producto) AS concepto_detalle
					FROM remesa r
					WHERE r.remesa_id=$detalle_id";
            $result = $this->DbFetchAll($select, $Conex, true);
        } elseif ($fuente_facturacion_cod == 'ST') {
            $select = "SELECT
					r.valor_facturar AS valor,
					CONCAT('Seguimiento No ',r.seguimiento_id,' / ',(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.origen_id),' / ',(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.destino_id),' / ',observaciones) AS concepto_detalle
					FROM seguimiento r
					WHERE r.seguimiento_id=$detalle_id";
            $result = $this->DbFetchAll($select, $Conex, true);
        }
        return $result;

    }
    public function ValidaIca($consecutivo_rem, $tipo_bien_servicio_factura_rm, $Conex)
    {

        $remesas = explode(",", $consecutivo_rem);
        for ($i = 0; $i < count($remesas); $i++) {

            $select = "SELECT r.origen_id FROM remesa r WHERE remesa_id = $remesas[$i]";
            $result = $this->DbFetchAll($select, $Conex, true);
            $origen_id = $result[0]['origen_id'];
            $select = "SELECT i.ubicacion_id FROM impuesto i, codpuc_bien_servicio_factura c
					 WHERE i.puc_id=c.puc_id AND c.tipo_bien_servicio_factura_id = $tipo_bien_servicio_factura_rm AND i.exentos = 'RIC'";
            $result_ubi = $this->DbFetchAll($select, $Conex, true);
            $ubicacion_id = $result_ubi[0]['ubicacion_id'];
            if ($origen_id != $ubicacion_id) {
                return 1;
            }
        }

    }
    public function ValidaDist($consecutivo_rem, $tipo_bien_servicio_factura_rm, $Conex)
    {

        $remesas = explode(",", $consecutivo_rem);
        $origenes = array();
        if (count($remesas) > 1) {
            for ($i = 0; $i < count($remesas); $i++) {

                $select = "SELECT r.origen_id FROM remesa r WHERE remesa_id = $remesas[$i]";
                $result = $this->DbFetchAll($select, $Conex, true);
                $origen_id = $result[0]['origen_id'];
                array_push($origenes, $origen_id);

            }
            $firstValue = current($origenes);
            foreach ($origenes as $val) {
                if ($firstValue !== $val) {
                    return 0;
                }
            }

            $origen_id = $origenes[0];
            $select = "SELECT impuesto_id FROM impuesto WHERE ubicacion_id=$origen_id";
            $result = $this->DbFetchAll($select, $Conex, true);
            $impuesto_id = $result[0]['impuesto_id'];
            return $impuesto_id;

        } else {
            $select = "SELECT r.origen_id FROM remesa r WHERE remesa_id = $remesas[0]";
            $result = $this->DbFetchAll($select, $Conex, true);
            $origen_id = $result[0]['origen_id'];
            $select = "SELECT impuesto_id FROM impuesto WHERE ubicacion_id=$origen_id";
            $result = $this->DbFetchAll($select, $Conex, true);
            $impuesto_id = $result[0]['impuesto_id'];
            return $impuesto_id;
        }

    }
    public function Save($empresa_id, $oficina_id, $Campos, $Conex)
    {
        $this->Begin($Conex);

        $factura_id = $this->DbgetMaxConsecutive("factura", "factura_id", $Conex, true, 1);
        $consecutivo_factura = $this->requestDataForQuery('consecutivo_factura', 'alphanum');
        $fuente_facturacion_cod = $this->requestDataForQuery('fuente_facturacion_cod', 'alphanum');
        if ($fuente_facturacion_cod == "'OS'") {
            $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_os', 'integer');
        } elseif ($fuente_facturacion_cod == "'RM'") {
            $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_rm', 'integer');
        } elseif ($fuente_facturacion_cod == "'ST'") {
            $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_st', 'integer');
        }

        $cliente_id = $this->requestDataForQuery('cliente_id', 'integer');
        $fecha = $this->requestDataForQuery('fecha', 'date');
        $vencimiento = $this->requestDataForQuery('vencimiento', 'date');
        $radicacion = $this->requestDataForQuery('radicacion', 'date');
        $forma_compra_venta_id = $this->requestDataForQuery('forma_compra_venta_id', 'integer');
        $tipo_factura_id = $this->requestDataForQuery('tipo_factura_id', 'integer');
        $concepto_item = $this->requestDataForQuery('concepto_item', 'text');
        $concepto = $this->requestDataForQuery('concepto', 'text');
        $observacion = $this->requestDataForQuery('observacion', 'text');
        $estado = $this->requestDataForQuery('estado', 'alphanum');
        $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
        $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
        $ingreso_factura = $this->requestDataForQuery('ingreso_factura', 'date');
        $sede_id = $this->requestDataForQuery('sedes', 'integer');
        $impuesto_id = $this->requestDataForQuery('impuesto_id', 'integer');
        $valor = $this->requestDataForQuery('valor', 'numeric');
        $valor_comp = str_replace("'", "", $valor);
        $consecutivo_por = '';

        $select_tercero = "SELECT tercero_id FROM cliente WHERE cliente_id=$cliente_id";
        $result_tercero = $this->DbFetchAll($select_tercero, $Conex, true);
        $tercero_id = $result_tercero[0][tercero_id];
        $select = "SELECT tipo_documento_id FROM tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id";
        $result_doc = $this->DbFetchAll($select, $Conex, true);
        $tipo_documento_id = $result_doc[0]['tipo_documento_id'];

        $select_documento = "SELECT consecutivo_por FROM tipo_de_documento WHERE tipo_documento_id=$tipo_documento_id";
        $result_documento = $this->DbFetchAll($select_documento, $Conex, true);

        $consecutivo_por = $result_documento[0]['consecutivo_por'];

        $select_parame = '';
        $select_parame = "SELECT parametros_factura_id,
							rango_inicial,
							rango_final,
							tipo_documento_id

							FROM parametros_factura WHERE oficina_id=$oficina_id AND tipo_documento_id=$tipo_documento_id
							AND fuente_facturacion_cod = $fuente_facturacion_cod AND estado='A' ORDER BY fecha_resolucion_dian DESC";

        $result_parame = $this->DbFetchAll($select_parame, $Conex, true);

        if (!count($result_parame) > 0) {

            $select_parame = "SELECT parametros_factura_id,
								rango_inicial,
								rango_final,
								tipo_documento_id

								FROM parametros_factura WHERE oficina_id=$oficina_id AND tipo_documento_id=$tipo_documento_id
								AND (fuente_facturacion_cod = 'ST,OS,RM' OR fuente_facturacion_cod = 'ST,OS' OR fuente_facturacion_cod = 'OS,RM' OR fuente_facturacion_cod = 'ST,RM')
								AND estado='A' ORDER BY fecha_resolucion_dian DESC";

            $result_parame = $this->DbFetchAll($select_parame, $Conex, true);

            if (!count($result_parame) > 0) {

                $select_parame = "SELECT parametros_factura_id,
								rango_inicial,
								rango_final,
								tipo_documento_id

								FROM parametros_factura WHERE oficina_id=$oficina_id AND tipo_documento_id=$tipo_documento_id
								AND ((fuente_facturacion_cod IS NULL) OR (fuente_facturacion_cod = 'NULL'))
								AND estado='A' ORDER BY fecha_resolucion_dian DESC";

                $result_parame = $this->DbFetchAll($select_parame, $Conex, true);

                if (!count($result_parame) > 0) {

                    $select_parame = "SELECT parametros_factura_id,
						rango_inicial,
						rango_final,
						tipo_documento_id

						FROM parametros_factura WHERE tipo_documento_id=$tipo_documento_id
						AND fuente_facturacion_cod = $fuente_facturacion_cod AND estado='A' ORDER BY fecha_resolucion_dian DESC";
					$result_parame = $this -> DbFetchAll($select_parame,$Conex,true);

					if(!count($result_parame)>0){

						return("No tiene una resolucion parametrizada para la fuente de facturacion seleccionada");

					}
				}
		    }

		}
		
	 $fac_rango_inic = $result_parame[0]['rango_inicial'];
	 $fac_rango_fina = $result_parame[0]['rango_final'];
	 $tip_documento  = $result_parame[0]['tipo_documento_id'];
	 $parametros_factura_id  = $result_parame[0]['parametros_factura_id'];

	if($consecutivo_factura>0){
		 
		 $select_consecu = "SELECT consecutivo_factura  FROM factura WHERE oficina_id=$oficina_id AND consecutivo_factura=$consecutivo_factura";
		 
		 $result_consecu = $this -> DbFetchAll($select_consecu,$Conex,true);
		 
		 if($result_consecu[0]['consecutivo_factura']>0){
			 exit('Factura No. '.$consecutivo_factura.' Registrado Previamente');
			 
			}else{
				
				$consecutivo_actual = $consecutivo_factura;
				
				
			}
			
	}else{

		$select_consecu = "SELECT (MAX(consecutivo_factura)+1) AS consecutivo  FROM factura WHERE oficina_id=$oficina_id AND  	parametros_factura_id=$parametros_factura_id ";
		$result_consecu = $this -> DbFetchAll($select_consecu,$Conex,false);
		$consecutivo_actual = $result_consecu[0]['consecutivo'];
		
		
	}
	
			if($consecutivo_actual!='' && $consecutivo_actual>=$fac_rango_inic && $consecutivo_actual<=$fac_rango_fina){
			   
			   $consecutivo_final=$consecutivo_actual;
			   
			}elseif($consecutivo_actual==''){
				
			   $consecutivo_final=$fac_rango_inic;
			}

	 $select_compro = "SELECT consecutivo_factura   FROM factura WHERE cliente_id=$cliente_id AND fecha=$fecha 
	 AND vencimiento=$vencimiento AND radicacion=$radicacion AND concepto_item=$concepto_item AND fuente_facturacion_cod=$fuente_facturacion_cod
	 AND valor=$valor AND tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND estado!='I' ";
        $result_compro = $this->DbFetchAll($select_compro, $Conex, true);

        if ($result_compro[0]['consecutivo_factura'] > 0 && $result_compro[0]['consecutivo_factura'] != '') {
            $this->Rollback($Conex);
            return 'Ya esta en proceso el Ingreso de una Factura con los mismos datos.<br>Por favor Verifique.';
        }

        $insert = "INSERT INTO factura (factura_id,cliente_id,consecutivo_factura,fecha,vencimiento,radicacion,concepto,concepto_item,observacion,fuente_facturacion_cod,tipo_bien_servicio_factura_id,tipo_documento_id,parametros_factura_id,forma_compra_venta_id,valor,tipo_factura_id,estado,usuario_id,oficina_id,ingreso_factura,sede_id)
					VALUES ($factura_id,$cliente_id,$consecutivo_final,$fecha,$vencimiento,$radicacion,$concepto,$concepto_item,$observacion,$fuente_facturacion_cod,$tipo_bien_servicio_factura_id,$tip_documento,$parametros_factura_id,$forma_compra_venta_id,$valor,$tipo_factura_id,$estado,$usuario_id,$oficina_id,$ingreso_factura,$sede_id)";
        $this->query($insert, $Conex, true);

        $item = str_replace("'", "", $concepto_item);
        $item = explode(',', $item);

        $subtotal = 0;
        $sub_costos = 0;
        $ter_costos = [];
        $terid_costos = [];
        $complemento = [];
        $j = 0;
        foreach ($item as $item_id) {
            if ($item_id != '') {

                $item_fr = explode('-', $item_id);

                if ($item_fr[1] == 'OS') {
                    /*$select = "SELECT
                    o.orden_servicio_id,
                    o.centro_de_costo_id,
                    i.item_liquida_servicio_id,
                    i.desc_item_liquida_servicio,
                    i.cant_item_liquida_servicio,
                    i.valoruni_item_liquida_servicio,
                    (SELECT ipl.deb_item_puc_liquida FROM item_puc_liquida_servicio ipl WHERE ipl.orden_servicio_id=o.orden_servicio_id AND ipl.contra_liquida_servicio=1) AS valor_total
                    FROM orden_servicio o, item_liquida_servicio i
                    WHERE o.orden_servicio_id='$item_fr[0]' AND i.orden_servicio_id=o.orden_servicio_id";*/

                    $ordenes_id .= $item_fr[0] . ",";

                    $select = "SELECT
							o.orden_servicio_id,
							o.centro_de_costo_id,
							i.item_liquida_servicio_id,
							i.desc_item_liquida_servicio,
							i.cant_item_liquida_servicio,
							i.valoruni_item_liquida_servicio,
							(i.cant_item_liquida_servicio*i.valoruni_item_liquida_servicio) AS valor_total
							FROM orden_servicio o, item_liquida_servicio i
							WHERE o.orden_servicio_id='$item_fr[0]' AND i.orden_servicio_id=o.orden_servicio_id";

                    $result = $this->DbFetchAll($select, $Conex, true);

                    if ($impuesto_id > 0) {

                        $select = "SELECT i.puc_id,
									i.descripcion,
								  (SELECT p.formula FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id  ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS formula,
								  (SELECT p.porcentaje FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS porcentaje,
								  (SELECT p.monto FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id  ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS monto
							FROM impuesto i WHERE i.impuesto_id=$impuesto_id";
                        $result_ric = $this->DbFetchAll($select, $Conex, true);
                    }

                    foreach ($result as $result_item) {
                        $detalle_factura_id = $this->DbgetMaxConsecutive("detalle_factura", "detalle_factura_id", $Conex, true, 1);
                        $subtotal = $subtotal + $result_item[valor_total];
                        $centro_de_costo_id = $result_item[centro_de_costo_id];
                        $insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,orden_servicio_id,item_liquida_servicio_id,descripcion,cantidad,valor_unitario,valor)
								VALUES ($detalle_factura_id,$factura_id,$result_item[orden_servicio_id],$result_item[item_liquida_servicio_id],'$result_item[desc_item_liquida_servicio]',$result_item[cant_item_liquida_servicio],'$result_item[valoruni_item_liquida_servicio]','$result_item[valor_total]')";
                        $this->query($insert, $Conex, true);
                    }
                    if (!strlen(trim($this->GetError())) > 0) {

                        $update = "UPDATE orden_servicio  SET  	estado_orden_servicio='F'
					WHERE   orden_servicio_id = '$item_fr[0]'";
                        $this->query($update, $Conex, true);
                    }
                } elseif ($item_fr[1] == 'RM') {
                    $select = "SELECT
							r.remesa_id,
							r.numero_remesa,
							r.origen_id,
							r.destino_id,
							r.producto_id,
							r.descripcion_producto,
							r.cantidad,
							r.valor_facturar,
							r.valor_costo,
							r.conductor_id,
							(SELECT
							 IF(d.manifiesto_id>0,(SELECT CONCAT_WS(': ','MC',manifiesto) FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A' LIMIT 1),
							(SELECT CONCAT_WS(': ','DU',despacho) FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A' LIMIT 1)) AS complem
							 FROM detalle_despacho d,  tenedor  t
							 WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
							(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A' LIMIT 1),
						  	(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A' LIMIT 1)) ) AS complemento,


							(SELECT t.tercero_id FROM detalle_despacho d,  tenedor  t
							 WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
							(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A') ,
							(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A')) LIMIT 1 ) AS tercero_id,
							(SELECT df.factura_id FROM detalle_factura df, factura f WHERE df.remesa_id=r.remesa_id AND  f.factura_id!=$factura_id AND f.estado!='I' AND df.factura_id=f.factura_id AND df.liberada=0 AND df.remesa_id IS NOT NULL LIMIT 1) AS facturado
							FROM remesa r
							WHERE r.remesa_id='$item_fr[0]'";
                    /*(SELECT
                    IF(d.manifiesto_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(': ','MC',manifiesto)) FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A'),
                    (SELECT GROUP_CONCAT(CONCAT_WS(': ','DU',despacho)) FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A')) AS complem
                    FROM detalle_despacho d,  tenedor  t
                    WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
                    (SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A'),
                    (SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A')) ) AS complemento,    */

                    $result = $this->DbFetchAll($select, $Conex, true);
                    $detalle_factura_id = $this->DbgetMaxConsecutive("detalle_factura", "detalle_factura_id", $Conex, true, 1);

                    //si ingresa a este if es porque seleccionaron un reteica diferente al reteica del tipo de servicio

                    if ($impuesto_id > 0) {

                        $select = "SELECT i.puc_id,
						                 i.descripcion,
						               (SELECT p.formula FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id  ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS formula,
									   (SELECT p.porcentaje FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS porcentaje,
									   (SELECT p.monto FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id  ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS monto
								 FROM impuesto i WHERE i.impuesto_id=$impuesto_id";
                        $result_ric = $this->DbFetchAll($select, $Conex, true);
                    }
                    foreach ($result as $resultado) {
                        $subtotal = $subtotal + $resultado[valor_facturar];
                        $sub_costos = $sub_costos + round($resultado[valor_costo]);
                        $ter_costos[$j] = round($resultado[valor_costo]);
                        $ter_facturar[$j] = round($resultado[valor_facturar]);
                        $terid_costos[$j] = $resultado['tercero_id'];
                        $complemento[$j] = $resultado[complemento] . '- Remesa: ' . $resultado[numero_remesa];
                        $j++;

                        if ($resultado[facturado] > 0) {
                            $this->Rollback($Conex);
                            return "La remesa " . $resultado[numero_remesa] . " esta asociada a otra Factura NO ANULADA. Por favor comuniquese con el Administrador";

                        } else {
                            $insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,remesa_id,origen_id,destino_id,producto_id,descripcion,cantidad,valor)
									VALUES ($detalle_factura_id,$factura_id,$resultado[remesa_id],$resultado[origen_id],$resultado[destino_id],$resultado[producto_id],'SERVICIO FLETE $resultado[descripcion_producto]',$resultado[cantidad],'$resultado[valor_facturar]');";
                            $this->query($insert, $Conex, true);

                            if (!strlen(trim($this->GetError())) > 0) {
                                $update = "UPDATE remesa SET estado='FT' WHERE remesa_id = $resultado[remesa_id];";
                                $this->query($update, $Conex, true);

                            }
                        }
                    }

                } elseif ($item_fr[1] == 'ST') {
                    $select = "SELECT
							r.seguimiento_id,
							r.origen_id,
							r.destino_id,
							r.observaciones,
							r.valor_facturar
							FROM seguimiento r
							WHERE r.seguimiento_id='$item_fr[0]'";

                    $result = $this->DbFetchAll($select, $Conex, true);
                    $detalle_factura_id = $this->DbgetMaxConsecutive("detalle_factura", "detalle_factura_id", $Conex, true, 1);

                    foreach ($result as $resultado) {
                        $subtotal = $subtotal + $resultado[valor_facturar];
                        $insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,seguimiento_id,origen_id,destino_id,descripcion,cantidad,valor)
								VALUES ($detalle_factura_id,$factura_id,$resultado[seguimiento_id],$resultado[origen_id],$resultado[destino_id],'$resultado[observaciones]',1,'$resultado[valor_facturar]');";
                        $this->query($insert, $Conex, true);

                        if (!strlen(trim($this->GetError())) > 0) {
                            $update = "UPDATE seguimiento SET estado='F' WHERE seguimiento_id = $resultado[seguimiento_id];";
                            $this->query($update, $Conex, true);
                        }
                    }
                }
            }
        }
        $select_centro = "SELECT centro_de_costo_id FROM centro_de_costo  WHERE oficina_id=$oficina_id";
        $result_centro = $this->DbFetchAll($select_centro, $Conex, true);
        $centro_de_costo_id = $result_centro[0][centro_de_costo_id];

        $total_pagar = 0;
        $total_liqui = 0;
        $parcial = '';
        $valor_liqui = '';
        $select_com = "SELECT COUNT(*) AS num_cuentas
				 FROM codpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.tercero_bien_servicio_factura=1 AND c.activo=1 ";

        $result_com = $this->DbFetchAll($select_com, $Conex);
        $select = "SELECT  c.despuc_bien_servicio_factura,
				  c.natu_bien_servicio_factura,
				  c.contra_bien_servicio_factura,
				  c.tercero_bien_servicio_factura,
				  c.ret_tercero_bien_servicio_factura,
				  c.reteica_bien_servicio_factura,
				  c.aplica_ingreso,
				  c.aplica_tenedor,
				  c.puc_id,
				  (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
				  (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
				  (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,
					(SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,
					(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,
					(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,
					(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
					(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
					(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto
				 FROM codpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura!=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura ASC, c.aplica_ingreso ASC ";

        $result = $this->DbFetchAll($select, $Conex, true);

        $residual = 0;
        $ind_subtotal = 'no';
        if ($result_com[0][num_cuentas] > 0) {

            //CUANDO EXISTE CONFIGURACION PARA TERCEROS
            foreach ($result as $resultado) {
                $debito = '';
                $credito = '';
                $ingresa = 0;
                $descripcion = '';
                $descripcion = $resultado[puc_nombre];
                if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                    $parcial = $subtotal - $sub_costos;
                    $residual = $parcial;
                    $valor_liqui = $subtotal;
                    $base = '';
                    $porcentaje = '';
                    $formula = '';
                    $ingresa = 1;
                    $ind_subtotal = 'si';

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {
                    if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {
                        $resultado[puc_id] = $result_ric[0]['puc_id'];
                        $descripcion = $result_ric[0]['descripcion'];
                        $formula = $result_ric[0]['formula'];
                        $porcentaje = $result_ric[0]['porcentaje'];
                        $formula1 = $result_ric[0]['formula'];
                        $porcentaje1 = $result_ric[0]['porcentaje'];

                    } else {
                        $formula = $resultado[formula];
                        $porcentaje = $resultado[porcentaje];
                        $formula1 = $resultado[formula];
                        $porcentaje1 = $resultado[porcentaje];

                    }
                    $base = $resultado[reteica_bien_servicio_factura] == 1 ? $subtotal : ($subtotal - $sub_costos);
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select1 = "SELECT $calculo AS valor_total";
                    $result1 = $this->DbFetchAll($select1, $Conex);
                    $parcial = ceil($result1[0]['valor_total']);

                    $base1 = $subtotal;
                    $calculo1 = str_replace("BASE", $base1, $formula1);
                    $calculo1 = str_replace("PORCENTAJE", $porcentaje1, $calculo1);
                    $select2 = "SELECT $calculo1 AS valor_total";
                    $result2 = $this->DbFetchAll($select2, $Conex);
                    $valor_liqui = ceil($result2[0]['valor_total']);
                    $ingresa = 1;

                } elseif ($resultado[tercero_bien_servicio_factura] == 1) {

                    $i = 0;
                    foreach ($ter_costos as $ter_costo) {
                        if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar + round($ter_costo);
                            $debito = number_format(abs(round($ter_costo)), 2, '.', '');
                            $credito = '0.00';

                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {

                            if ($ind_subtotal == 'no') {
                                $total_pagar = $total_pagar + round($ter_facturar[$i]);
                            } else {
                                $total_pagar = $total_pagar - round($ter_costo);
                            }
                            if ($ind_subtotal == 'no') {
                                $debito = '0.00';
                                $credito = number_format(abs(round($ter_facturar[$i])), 2, '.', '');

                            } else {
                                $debito = '0.00';
                                $credito = number_format(abs(round($ter_costo)), 2, '.', '');
                            }

                        } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                            $debito = number_format(abs(round($ter_costo)), 2, '.', '');
                            $credito = '0.00';
                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                            $debito = '0.00';
                            $credito = number_format(abs(round($ter_costo)), 2, '.', '');
                        }

                        $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                        $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';

                        if ($ind_subtotal == 'no') {
                            $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                        } else {
                            $tercero = $resultado[puc_tercero] == 1 ? $terid_costos[$i] : 'NULL';
                        }
                        //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                        if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                            $tercero = $tercero;
                        } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                            $tercero = $tercero_id;
                        } else {
                            $tercero == 'NULL';
                        }
                        $descripcion = '';
                        $descripcion = $complemento[$i];
                        $base = '';
                        $porcentaje = '';
                        $formula = '';
                        $tercero_pro = $terid_costos[$i];

                        if ($ind_subtotal == 'no') {
                            $valor_liqui = round($ter_facturar[$i]);
                        } else {
                            $valor_liqui = round($ter_costo);
                        }

                        $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                        $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura,ingreso_tercero)
									VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura],$resultado[tercero_bien_servicio_factura])";

                        $this->query($insert, $Conex, true);

                        $select_ret = "SELECT  c.despuc_bien_servicio_factura,
									  c.natu_bien_servicio_factura,
									  c.contra_bien_servicio_factura,
									  c.tercero_bien_servicio_factura,
									  c.ret_tercero_bien_servicio_factura,
									  c.puc_id,
									  c.aplica_tenedor,
									  (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
									  (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
									  (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,
										(SELECT autoret_proveedor  FROM proveedor WHERE tercero_id=$tercero_pro ) AS autorete,
										(SELECT retei_proveedor FROM proveedor WHERE tercero_id=$tercero_pro ) AS retei,
										(SELECT renta_proveedor FROM proveedor WHERE tercero_id=$tercero_pro ) AS renta,
										(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
										(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
										(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
										(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto
									 FROM codpuc_bien_servicio_factura  c
									 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura=1 AND c.activo=1  ORDER BY c.contra_bien_servicio_factura";

                        $result_ret = $this->DbFetchAll($select_ret, $Conex, true);
                        foreach ($result_ret as $result_ret) {
                            if ($impuesto_id && $result_ret[exento] == 'RIC') {
                                $result_ret[monto] = $result_ric[0]['monto'];
                            }
                            if ($result_ret[formula] != '' && $result_ret[porcentaje] > 0 && $result_ret[monto] <= $valor_comp && (($result_ret[exento] == 'RT' && $result_ret[autorete] != 'S' && $resultado[autorete] != 'S') || ($result_ret[exento] == 'IC' && $result_ret[retei] != 'S' && $resultado[retei] != 'S') || ($result_ret[exento] == 'CR' && $result_ret[renta] != 'S' && $resultado[renta] != 'S') || ($result_ret[exento] == 'NN') || ($result_ret[exento] == 'RIC' && $result_ret[retei] != 'S' && $resultado[retei] != 'S'))) {

                                if ($impuesto_id > 0 && $result_ret[exento] == 'RIC') {

                                    $formula = $result_ric[0]['formula'];
                                    $porcentaje = $result_ric[0]['porcentaje'];
                                    $descripcion = $result_ric[0]['descripcion'] . ' - ' . $complemento[$i];
                                } else {
                                    $formula = $result_ret[formula];
                                    $porcentaje = $result_ret[porcentaje];
                                    $descripcion = $result_ret[puc_nombre] . ' - ' . $complemento[$i];
                                }
                                $base = round($ter_costo);
                                $calculo = str_replace("BASE", $base, $formula);
                                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                $select2 = "SELECT $calculo AS valor_total";
                                $result2 = $this->DbFetchAll($select2, $Conex);
                                $parcial = round($result2[0]['valor_total']);
                                $valor_liqui = round($result2[0]['valor_total']);

                                if ($result_ret[natu_bien_servicio_factura] == 'D' && $result_ret[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar + $parcial;
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';

                                } elseif ($result_ret[natu_bien_servicio_factura] == 'C' && $result_ret[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar - $parcial;
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                } elseif ($result_ret[natu_bien_servicio_factura] == 'D' && $result_ret[contra_bien_servicio_factura] == 1) {
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';
                                } elseif ($result_ret[natu_bien_servicio_factura] == 'C' && $result_ret[contra_bien_servicio_factura] == 1) {
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                }

                                $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                $centro_costo = $result_ret[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                $tercero = $result_ret[puc_tercero] == 1 ? $tercero_id : 'NULL';
                                //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                if ($result_ret['puc_tercero'] == 1 && $result_ret['aplica_tenedor'] == 1) {
                                    $tercero = $terid_costos[$i];
                                } elseif ($result_ret['puc_tercero'] == 1 && $result_ret['aplica_tenedor'] == 0) {
                                    $tercero = $tercero;
                                } else {
                                    $tercero == 'NULL';
                                }
                                $contra_bien_servicio_factura = $result_ret[contra_bien_servicio_factura];
                                $tercero_bien_servicio_factura = $result_ret[tercero_bien_servicio_factura];
                                $puc_id = $result_ret[puc_id];
                                $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                                $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura,ingreso_tercero)
											VALUES ($detalle_factura_puc_id,$factura_id,$puc_id,$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$contra_bien_servicio_factura,$tercero_bien_servicio_factura)";

                                $this->query($insert, $Conex, true);

                            }

                        }$i++;

                    }
                } elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {
                    $parcial = $total_pagar;
                    $valor_liqui = $total_liqui;
                    if ($valor_liqui != $parcial && $ind_subtotal == 'si') {
                        $diferencia = $valor_liqui - $parcial;
                        $parcial = $valor_liqui;
                        $update1 = "UPDATE detalle_factura_puc SET  deb_item_factura=(deb_item_factura + " . $diferencia . ") WHERE factura_id=$factura_id AND deb_item_factura>0 LIMIT 1";

                        $this->query($update1, $Conex, true);
                    }

                    $base = '';
                    $porcentaje = '';
                    $formula = '';
                    $puc_idcon = $resultado[puc_id];
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0 && ($resultado[exento] == 'RIC' && $resultado[retei] != 'S' && $resultado[retei] != 'S')) {

                    if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {

                        $formula = $result_ric[0]['formula'];
                        $porcentaje = $result_ric[0]['porcentaje'];

                    } else {

                        $formula = $resultado[formula];
                        $porcentaje = $resultado[porcentaje];

                    }
                    $base = $residual;
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select2 = "SELECT $calculo AS valor_total";
                    $result2 = $this->DbFetchAll($select2, $Conex);
                    $parcial = round($result2[0]['valor_total']);
                    $ingresa = 1;

                }

                if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar + $parcial;
                        $total_liqui = $total_liqui + $valor_liqui;
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar - $parcial;
                        $total_liqui = $total_liqui - $valor_liqui;
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = $parcial;
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                        $valor_liqui = $parcial;
                    }

                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                    //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                    if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                        $tercero = $terid_costos[$i];
                    } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                        $tercero = $tercero;
                    } else {
                        $tercero == 'NULL';
                    }

                    $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');
                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";

                    $this->query($insert, $Conex, true);

                } elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {
                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = number_format(round(abs($parcial)), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = '0.00';
                        $credito = number_format(round(abs($parcial)), 2, '.', '');
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(round(abs($parcial)), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(round(abs($parcial)), 2, '.', '');
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    }
                    $select_ter_emp = "SELECT tercero_id FROM empresa
								 WHERE empresa_id=$empresa_id";
                    $result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex, true);

                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero_1 = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                    //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                    if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                        $tercero_1 = $terid_costos[$i];
                    } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                        $tercero_1 = $tercero_1;
                    } else {
                        $tercero_1 == 'NULL';
                    }
                    $valor_liqui = number_format(round(abs($valor_liqui)), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                    $this->query($insert, $Conex, true);
                }
            }

        } else {

            //CUANDO NO EXISTE CONFIGURACION PARA TERCEROS}
            foreach ($result as $resultado) {

                $debito = '';
                $credito = '';
                $ingresa = 0;
                $descripcion = '';
                $descripcion = $resultado[puc_nombre];

                if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                    $parcial = $subtotal;
                    $residual = $parcial;
                    $valor_liqui = $subtotal;
                    $base = '';
                    $porcentaje = '';
                    $formula = '';
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                    if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {
                        $resultado[puc_id] = $result_ric[0]['puc_id'];
                        $descripcion = $result_ric[0]['descripcion'];
                        $formula = $result_ric[0]['formula'];
                        $porcentaje = $result_ric[0]['porcentaje'];

                    } else {
                        $formula = $resultado[formula];
                        $porcentaje = $resultado[porcentaje];

                    }
                    $base = $subtotal;
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select1 = "SELECT $calculo AS valor_total";
                    $result1 = $this->DbFetchAll($select1, $Conex);
                    $parcial = round($result1[0]['valor_total']);
                    $valor_liqui = round($result1[0]['valor_total']);
                    $ingresa = 1;

                } elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {
                    $parcial = $total_pagar;
                    $valor_liqui = $total_liqui;
                    $base = '';
                    $porcentaje = '';
                    $formula = '';
                    $puc_idcon = $resultado[puc_id];
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0 && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                    if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {

                        $resultado[puc_id] = $result_ric[0]['puc_id'];
                        $descripcion = $result_ric[0]['descripcion'];
                        $formula = $result_ric[0]['formula'];
                        $porcentaje = $result_ric[0]['porcentaje'];

                    } else {

                        $formula = $resultado[formula];
                        $porcentaje = $resultado[porcentaje];

                    }
                    $base = $residual;
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select2 = "SELECT $calculo AS valor_total";
                    $result2 = $this->DbFetchAll($select2, $Conex);
                    $parcial = round($result2[0]['valor_total']);
                    $ingresa = 1;

                }

                if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar + $parcial;
                        $total_liqui = $total_liqui + $valor_liqui;
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar - $parcial;
                        $total_liqui = $total_liqui - $valor_liqui;
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    }

                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';

                    //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                    if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                        $tercero = $terid_costos[$i];
                    } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                        $tercero = $tercero;
                    } else {
                        $tercero == 'NULL';
                    }
                    $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                    $this->query($insert, $Conex, true);

                } elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {

                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = number_format(round(abs($parcial)), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = '0.00';
                        $credito = number_format(round(abs($parcial)), 2, '.', '');
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(round(abs($parcial)), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(round(abs($parcial)), 2, '.', '');
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                    }

                    $select_ter_emp = "SELECT tercero_id FROM empresa WHERE empresa_id=$empresa_id";
                    $result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex, true);
                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero_1 = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';

                    //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                    if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                        $tercero_1 = $terid_costos[$i];
                    } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                        $tercero_1 = $tercero_1;
                    } else {
                        $tercero_1 == 'NULL';
                    }
                    $valor_liqui = number_format(round(abs($valor_liqui)), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";

                    $this->query($insert, $Conex, true);
                }
            }
        }

        if (!strlen(trim($this->GetError())) > 0) {

            $this->assignValRequest('factura_id', $factura_id);
            $this->Commit($Conex);
            return array(factura_id => $factura_id, consecutivo_final => $consecutivo_final);
        } else {
            exit("Ocurrio un problema: " . $this->GetError());
        }
    }

    public function Update($empresa_id, $oficina_id, $Campos, $Conex)
    {

        $this->Begin($Conex);

        if ($_REQUEST['factura_id'] != 'NULL') {

            $factura_id = $this->requestDataForQuery('factura_id', 'integer');
            $consecutivo_factura = $this->requestDataForQuery('consecutivo_factura', 'alphanum');
            $fuente_facturacion_cod = $this->requestDataForQuery('fuente_facturacion_cod', 'alphanum');
            if ($fuente_facturacion_cod == "'OS'") {
                $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_os', 'integer');
            } elseif ($fuente_facturacion_cod == "'RM'") {
                $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_rm', 'integer');
            } elseif ($fuente_facturacion_cod == "'ST'") {
                $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_st', 'integer');
            }

            $cliente_id = $this->requestDataForQuery('cliente_id', 'integer');
            $fecha = $this->requestDataForQuery('fecha', 'date');
            $vencimiento = $this->requestDataForQuery('vencimiento', 'date');
            $radicacion = $this->requestDataForQuery('radicacion', 'date');
            $forma_compra_venta_id = $this->requestDataForQuery('forma_compra_venta_id', 'integer');
            $tipo_factura_id = $this->requestDataForQuery('tipo_factura_id', 'integer');
            $concepto_item = $this->requestDataForQuery('concepto_item', 'text');
            $concepto = $this->requestDataForQuery('concepto', 'text');
            $observacion = $this->requestDataForQuery('observacion', 'text');
            $estado = $this->requestDataForQuery('estado', 'alphanum');
            $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
            $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
            $ingreso_factura = $this->requestDataForQuery('ingreso_factura', 'date');
            $sede_id = $this->requestDataForQuery('sedes', 'integer');
            $impuesto_id = $this->requestDataForQuery('impuesto_id', 'integer');
            $valor = $this->requestDataForQuery('valor', 'numeric');
            $valor_comp = str_replace("'", "", $valor);
            $consecutivo_por = '';

            date_default_timezone_set('America/Bogota');
            $fecha_actualiza = date("Y-m-d H:i:s");

            $select_tercero = "SELECT tercero_id FROM cliente WHERE cliente_id=$cliente_id";
            $result_tercero = $this->DbFetchAll($select_tercero, $Conex, true);
            $tercero_id = $result_tercero[0]['tercero_id'];

            $select = "SELECT encabezado_registro_id,reportada FROM factura WHERE factura_id = $factura_id";
            $result = $this->DbFetchAll($select, $Conex, true);

            //aqui validamos que la factura no este contabilizada, este en estado edicion y no este reportada!
            if ($estado == "'A'" && !$result[0]['encabezado_registro_id'] > 0 && $result[0]['reportada'] == 0) {

                $delete = "DELETE FROM detalle_factura_puc WHERE factura_id = $factura_id";
                $this->query($delete, $Conex, true);

                $delete = "DELETE FROM detalle_factura WHERE factura_id = $factura_id";
                $this->query($delete, $Conex, true);

                $update = "UPDATE factura SET cliente_id=$cliente_id,fecha=$fecha,vencimiento=$vencimiento,radicacion=$radicacion,concepto=$concepto,concepto_item=$concepto_item,observacion=$observacion,fuente_facturacion_cod=$fuente_facturacion_cod,tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id,forma_compra_venta_id=$forma_compra_venta_id,valor=$valor,tipo_factura_id=$tipo_factura_id,estado=$estado,usuario_actualiza_id=$usuario_id,fecha_actualiza='$fecha_actualiza',oficina_id=$oficina_id,sede_id=$sede_id
                     WHERE factura_id=$factura_id";
                $this->query($update, $Conex, true);

                if (strlen($this->GetError()) > 0) {
                    $this->Rollback($Conex);
                } else {

                    $item = str_replace("'", "", $concepto_item);
                    $item = explode(',', $item);
                    $item = array_filter($item);

                    $subtotal = 0;
                    $sub_costos = 0;
                    $ter_costos = [];
                    $terid_costos = [];
                    $complemento = [];
                    $j = 0;
                    foreach ($item as $item_id) {
                        if ($item_id != '') {

                            $item_fr = explode('-', $item_id);


                            if ($item_fr[1] == 'OS') {
                                /*$select = "SELECT
                                o.orden_servicio_id,
                                o.centro_de_costo_id,
                                i.item_liquida_servicio_id,
                                i.desc_item_liquida_servicio,
                                i.cant_item_liquida_servicio,
                                i.valoruni_item_liquida_servicio,
                                (SELECT ipl.deb_item_puc_liquida FROM item_puc_liquida_servicio ipl WHERE ipl.orden_servicio_id=o.orden_servicio_id AND ipl.contra_liquida_servicio=1) AS valor_total
                                FROM orden_servicio o, item_liquida_servicio i
                                WHERE o.orden_servicio_id='$item_fr[0]' AND i.orden_servicio_id=o.orden_servicio_id";*/

                                $ordenes_id .= $item_fr[0] . ",";

                                $select = "SELECT
							o.orden_servicio_id,
							o.centro_de_costo_id,
							i.item_liquida_servicio_id,
							i.desc_item_liquida_servicio,
							i.cant_item_liquida_servicio,
							i.valoruni_item_liquida_servicio,
							(i.cant_item_liquida_servicio*i.valoruni_item_liquida_servicio) AS valor_total
							FROM orden_servicio o, item_liquida_servicio i
							WHERE o.orden_servicio_id='$item_fr[0]' AND i.orden_servicio_id=o.orden_servicio_id";

                                $result = $this->DbFetchAll($select, $Conex, true);

                                foreach ($result as $result_item) {
                                    $detalle_factura_id = $this->DbgetMaxConsecutive("detalle_factura", "detalle_factura_id", $Conex, true, 1);
                                    $subtotal = $subtotal + $result_item[valor_total];
                                    $centro_de_costo_id = $result_item[centro_de_costo_id];
                                    $insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,orden_servicio_id,item_liquida_servicio_id,descripcion,cantidad,valor_unitario,valor)
								VALUES ($detalle_factura_id,$factura_id,$result_item[orden_servicio_id],$result_item[item_liquida_servicio_id],'$result_item[desc_item_liquida_servicio]',$result_item[cant_item_liquida_servicio],'$result_item[valoruni_item_liquida_servicio]','$result_item[valor_total]')";
                                    $this->query($insert, $Conex, true);
                                }
                                if (!strlen(trim($this->GetError())) > 0) {

                                    $update = "UPDATE orden_servicio  SET  	estado_orden_servicio='F'
					WHERE   orden_servicio_id = '$item_fr[0]'";
                                    $this->query($update, $Conex, true);
                                }
                            } elseif ($item_fr[1] == 'RM') {
                                $select = "SELECT
							r.remesa_id,
							r.numero_remesa,
							r.origen_id,
							r.destino_id,
							r.producto_id,
							r.descripcion_producto,
							r.cantidad,
							r.valor_facturar,
							r.valor_costo,
							r.conductor_id,
							(SELECT
							 IF(d.manifiesto_id>0,(SELECT CONCAT_WS(': ','MC',manifiesto) FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A' LIMIT 1),
							(SELECT CONCAT_WS(': ','DU',despacho) FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A' LIMIT 1)) AS complem
							 FROM detalle_despacho d,  tenedor  t
							 WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
							(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A' LIMIT 1),
						  	(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A' LIMIT 1)) ) AS complemento,


							(SELECT t.tercero_id FROM detalle_despacho d,  tenedor  t
							 WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
							(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A') ,
							(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A')) LIMIT 1 ) AS tercero_id,
							(SELECT df.factura_id FROM detalle_factura df, factura f WHERE df.remesa_id=r.remesa_id AND  f.factura_id!=$factura_id AND f.estado!='I' AND df.factura_id=f.factura_id AND df.liberada=0 AND df.remesa_id IS NOT NULL LIMIT 1) AS facturado
							FROM remesa r
							WHERE r.remesa_id='$item_fr[0]'";
                               

                                $result = $this->DbFetchAll($select, $Conex, true);
                                $detalle_factura_id = $this->DbgetMaxConsecutive("detalle_factura", "detalle_factura_id", $Conex, true, 1);

                                //si ingresa a este if es porque seleccionaron un reteica diferente al reteica del tipo de servicio

                                if ($impuesto_id > 0) {

                                    $select = "SELECT i.puc_id,
						                 i.descripcion,
						               (SELECT p.formula FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id  ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS formula,
									   (SELECT p.porcentaje FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS porcentaje,
									   (SELECT p.monto FROM impuesto_periodo_contable p WHERE p.impuesto_id=i.impuesto_id  ORDER BY impuesto_periodo_contable_id DESC LIMIT 1)AS monto
								 FROM impuesto i WHERE i.impuesto_id=$impuesto_id";
                                    $result_ric = $this->DbFetchAll($select, $Conex, true);
                                }
                                foreach ($result as $resultado) {
                                    $subtotal = $subtotal + $resultado['valor_facturar'];
                                    $sub_costos = $sub_costos + round($resultado['valor_costo']);
                                    $ter_costos[$j] = round($resultado['valor_costo']);
                                    $ter_facturar[$j] = round($resultado['valor_facturar']);
                                    $terid_costos[$j] = $resultado['tercero_id'];
                                    $complemento[$j] = $resultado['complemento'] . '- Remesa: ' . $resultado['numero_remesa'];
                                    $j++;
                                    if ($resultado['facturado'] > 0) {
                                        $this->Rollback($Conex);
                                        return "La remesa " . $resultado['numero_remesa']. " esta asociada a otra Factura NO ANULADA. Por favor comuniquese con el Administrador";

                                    } else {
                                        $insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,remesa_id,origen_id,destino_id,producto_id,descripcion,cantidad,valor)
									VALUES ($detalle_factura_id,$factura_id,$resultado[remesa_id],$resultado[origen_id],$resultado[destino_id],$resultado[producto_id],'SERVICIO FLETE $resultado[descripcion_producto]',$resultado[cantidad],'$resultado[valor_facturar]');";
                                        $this->query($insert, $Conex, true);

                                        if (!strlen(trim($this->GetError())) > 0) {
                                            $update = "UPDATE remesa SET estado='FT' WHERE remesa_id = $resultado[remesa_id];";
                                            $this->query($update, $Conex, true);

                                        }
                                    }
                                }

                            } elseif ($item_fr[1] == 'ST') {
                                $select = "SELECT
							r.seguimiento_id,
							r.origen_id,
							r.destino_id,
							r.observaciones,
							r.valor_facturar
							FROM seguimiento r
							WHERE r.seguimiento_id='$item_fr[0]'";

                                $result = $this->DbFetchAll($select, $Conex, true);
                                $detalle_factura_id = $this->DbgetMaxConsecutive("detalle_factura", "detalle_factura_id", $Conex, true, 1);

                                foreach ($result as $resultado) {
                                    $subtotal = $subtotal + $resultado[valor_facturar];
                                    $insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,seguimiento_id,origen_id,destino_id,descripcion,cantidad,valor)
								VALUES ($detalle_factura_id,$factura_id,$resultado[seguimiento_id],$resultado[origen_id],$resultado[destino_id],'$resultado[observaciones]',1,'$resultado[valor_facturar]');";
                                    $this->query($insert, $Conex, true);

                                    if (!strlen(trim($this->GetError())) > 0) {
                                        $update = "UPDATE seguimiento SET estado='F' WHERE seguimiento_id = $resultado[seguimiento_id];";
                                        $this->query($update, $Conex, true);
                                    }
                                }
                            }
                        }
                    }
                    $select_centro = "SELECT centro_de_costo_id FROM centro_de_costo  WHERE oficina_id=$oficina_id";
                    $result_centro = $this->DbFetchAll($select_centro, $Conex, true);
                    $centro_de_costo_id = $result_centro[0][centro_de_costo_id];

                    $total_pagar = 0;
                    $total_liqui = 0;
                    $parcial = '';
                    $valor_liqui = '';
                    $select_com = "SELECT COUNT(*) AS num_cuentas
				 FROM codpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.tercero_bien_servicio_factura=1 AND c.activo=1 ";

                    $result_com = $this->DbFetchAll($select_com, $Conex);
                    $select = "SELECT  c.despuc_bien_servicio_factura,
				  c.natu_bien_servicio_factura,
				  c.contra_bien_servicio_factura,
				  c.tercero_bien_servicio_factura,
				  c.ret_tercero_bien_servicio_factura,
				  c.reteica_bien_servicio_factura,
				  c.aplica_ingreso,
				  c.aplica_tenedor,
				  c.puc_id,
				  (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
				  (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
				  (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,
					(SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,
					(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,
					(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,
					(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
					(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
					(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto
				 FROM codpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura!=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura ASC, c.aplica_ingreso ASC ";

                    $result = $this->DbFetchAll($select, $Conex, true);

                    $residual = 0;
                    $ind_subtotal = 'no';
                    if ($result_com[0][num_cuentas] > 0) {

                        //CUANDO EXISTE CONFIGURACION PARA TERCEROS
                        foreach ($result as $resultado) {
                            $debito = '';
                            $credito = '';
                            $ingresa = 0;
                            $descripcion = '';
                            $descripcion = $resultado[puc_nombre];
                            if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                                $parcial = $subtotal - $sub_costos;
                                $residual = $parcial;
                                $valor_liqui = $subtotal;
                                $base = '';
                                $porcentaje = '';
                                $formula = '';
                                $ingresa = 1;
                                $ind_subtotal = 'si';

                            } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {
                                if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {
                                    $resultado[puc_id] = $result_ric[0]['puc_id'];
                                    $descripcion = $result_ric[0]['descripcion'];
                                    $formula = $result_ric[0]['formula'];
                                    $porcentaje = $result_ric[0]['porcentaje'];
                                    $formula1 = $result_ric[0]['formula'];
                                    $porcentaje1 = $result_ric[0]['porcentaje'];

                                } else {
                                    $formula = $resultado[formula];
                                    $porcentaje = $resultado[porcentaje];
                                    $formula1 = $resultado[formula];
                                    $porcentaje1 = $resultado[porcentaje];

                                }
                                $base = $resultado[reteica_bien_servicio_factura] == 1 ? $subtotal : ($subtotal - $sub_costos);
                                $calculo = str_replace("BASE", $base, $formula);
                                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                $select1 = "SELECT $calculo AS valor_total";
                                $result1 = $this->DbFetchAll($select1, $Conex);
                                $parcial = ceil($result1[0]['valor_total']);

                                $base1 = $subtotal;
                                $calculo1 = str_replace("BASE", $base1, $formula1);
                                $calculo1 = str_replace("PORCENTAJE", $porcentaje1, $calculo1);
                                $select2 = "SELECT $calculo1 AS valor_total";
                                $result2 = $this->DbFetchAll($select2, $Conex);
                                $valor_liqui = ceil($result2[0]['valor_total']);
                                $ingresa = 1;

                            } elseif ($resultado[tercero_bien_servicio_factura] == 1) {

                                $i = 0;
                                foreach ($ter_costos as $ter_costo) {
                                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                                        $total_pagar = $total_pagar + round($ter_costo);
                                        $debito = number_format(abs(round($ter_costo)), 2, '.', '');
                                        $credito = '0.00';

                                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {

                                        if ($ind_subtotal == 'no') {
                                            $total_pagar = $total_pagar + round($ter_facturar[$i]);
                                        } else {
                                            $total_pagar = $total_pagar - round($ter_costo);
                                        }
                                        if ($ind_subtotal == 'no') {
                                            $debito = '0.00';
                                            $credito = number_format(abs(round($ter_facturar[$i])), 2, '.', '');

                                        } else {
                                            $debito = '0.00';
                                            $credito = number_format(abs(round($ter_costo)), 2, '.', '');
                                        }

                                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                                        $debito = number_format(abs(round($ter_costo)), 2, '.', '');
                                        $credito = '0.00';
                                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                                        $debito = '0.00';
                                        $credito = number_format(abs(round($ter_costo)), 2, '.', '');
                                    }

                                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';

                                    if ($ind_subtotal == 'no') {
                                        $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                                    } else {
                                        $tercero = $resultado[puc_tercero] == 1 ? $terid_costos[$i] : 'NULL';
                                    }
                                    //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                    if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                                        $tercero = $tercero;
                                    } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                                        $tercero = $tercero_id;
                                    } else {
                                        $tercero == 'NULL';
                                    }
                                    $descripcion = '';
                                    $descripcion = $complemento[$i];
                                    $base = '';
                                    $porcentaje = '';
                                    $formula = '';
                                    $tercero_pro = $terid_costos[$i];

                                    if ($ind_subtotal == 'no') {
                                        $valor_liqui = round($ter_facturar[$i]);
                                    } else {
                                        $valor_liqui = round($ter_costo);
                                    }

                                    $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
									VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                                    $this->query($insert, $Conex, true);

                                    $select_ret = "SELECT  c.despuc_bien_servicio_factura,
									  c.natu_bien_servicio_factura,
									  c.contra_bien_servicio_factura,
									  c.tercero_bien_servicio_factura,
									  c.ret_tercero_bien_servicio_factura,
									  c.puc_id,
									  c.aplica_tenedor,
									  (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
									  (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
									  (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,
										(SELECT autoret_proveedor  FROM proveedor WHERE tercero_id=$tercero_pro ) AS autorete,
										(SELECT retei_proveedor FROM proveedor WHERE tercero_id=$tercero_pro ) AS retei,
										(SELECT renta_proveedor FROM proveedor WHERE tercero_id=$tercero_pro ) AS renta,
										(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
										(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
										(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
										(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto
									 FROM codpuc_bien_servicio_factura  c
									 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura=1 AND c.activo=1  ORDER BY c.contra_bien_servicio_factura";

                                    $result_ret = $this->DbFetchAll($select_ret, $Conex, true);
                                    foreach ($result_ret as $result_ret) {
                                        if ($impuesto_id && $result_ret[exento] == 'RIC') {
                                            $result_ret[monto] = $result_ric[0]['monto'];
                                        }
                                        if ($result_ret[formula] != '' && $result_ret[porcentaje] > 0 && $result_ret[monto] <= $valor_comp && (($result_ret[exento] == 'RT' && $result_ret[autorete] != 'S' && $resultado[autorete] != 'S') || ($result_ret[exento] == 'IC' && $result_ret[retei] != 'S' && $resultado[retei] != 'S') || ($result_ret[exento] == 'CR' && $result_ret[renta] != 'S' && $resultado[renta] != 'S') || ($result_ret[exento] == 'NN') || ($result_ret[exento] == 'RIC' && $result_ret[retei] != 'S' && $resultado[retei] != 'S'))) {

                                            if ($impuesto_id > 0 && $result_ret[exento] == 'RIC') {

                                                $formula = $result_ric[0]['formula'];
                                                $porcentaje = $result_ric[0]['porcentaje'];
                                                $descripcion = $result_ric[0]['descripcion'] . ' - ' . $complemento[$i];
                                            } else {
                                                $formula = $result_ret[formula];
                                                $porcentaje = $result_ret[porcentaje];
                                                $descripcion = $result_ret[puc_nombre] . ' - ' . $complemento[$i];
                                            }
                                            $base = round($ter_costo);
                                            $calculo = str_replace("BASE", $base, $formula);
                                            $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                            $select2 = "SELECT $calculo AS valor_total";
                                            $result2 = $this->DbFetchAll($select2, $Conex);
                                            $parcial = round($result2[0]['valor_total']);
                                            $valor_liqui = round($result2[0]['valor_total']);

                                            if ($result_ret[natu_bien_servicio_factura] == 'D' && $result_ret[contra_bien_servicio_factura] != 1) {
                                                $total_pagar = $total_pagar + $parcial;
                                                $debito = number_format(abs($parcial), 2, '.', '');
                                                $credito = '0.00';

                                            } elseif ($result_ret[natu_bien_servicio_factura] == 'C' && $result_ret[contra_bien_servicio_factura] != 1) {
                                                $total_pagar = $total_pagar - $parcial;
                                                $debito = '0.00';
                                                $credito = number_format(abs($parcial), 2, '.', '');
                                            } elseif ($result_ret[natu_bien_servicio_factura] == 'D' && $result_ret[contra_bien_servicio_factura] == 1) {
                                                $debito = number_format(abs($parcial), 2, '.', '');
                                                $credito = '0.00';
                                            } elseif ($result_ret[natu_bien_servicio_factura] == 'C' && $result_ret[contra_bien_servicio_factura] == 1) {
                                                $debito = '0.00';
                                                $credito = number_format(abs($parcial), 2, '.', '');
                                            }

                                            $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                            $centro_costo = $result_ret[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                            $tercero = $result_ret[puc_tercero] == 1 ? $tercero_id : 'NULL';
                                            //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                            if ($result_ret['puc_tercero'] == 1 && $result_ret['aplica_tenedor'] == 1) {
                                                $tercero = $terid_costos[$i];
                                            } elseif ($result_ret['puc_tercero'] == 1 && $result_ret['aplica_tenedor'] == 0) {
                                                $tercero = $tercero;
                                            } else {
                                                $tercero == 'NULL';
                                            }
                                            $contra_bien_servicio_factura = $result_ret[contra_bien_servicio_factura];
                                            $puc_id = $result_ret[puc_id];
                                            $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                                            $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
											VALUES ($detalle_factura_puc_id,$factura_id,$puc_id,$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$contra_bien_servicio_factura)";

                                            $this->query($insert, $Conex, true);

                                        }

                                    }$i++;

                                }
                            } elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {
                                $parcial = $total_pagar;
                                $valor_liqui = $total_liqui;
                                if ($valor_liqui != $parcial && $ind_subtotal == 'si') {
                                    $diferencia = $valor_liqui - $parcial;
                                    $parcial = $valor_liqui;
                                    $update1 = "UPDATE detalle_factura_puc SET  deb_item_factura=(deb_item_factura + " . $diferencia . ") WHERE factura_id=$factura_id AND deb_item_factura>0 LIMIT 1";

                                    $this->query($update1, $Conex, true);
                                }

                                $base = '';
                                $porcentaje = '';
                                $formula = '';
                                $puc_idcon = $resultado[puc_id];
                                $ingresa = 1;

                            } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0 && ($resultado[exento] == 'RIC' && $resultado[retei] != 'S' && $resultado[retei] != 'S')) {

                                if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {

                                    $formula = $result_ric[0]['formula'];
                                    $porcentaje = $result_ric[0]['porcentaje'];

                                } else {

                                    $formula = $resultado[formula];
                                    $porcentaje = $resultado[porcentaje];

                                }
                                $base = $residual;
                                $calculo = str_replace("BASE", $base, $formula);
                                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                $select2 = "SELECT $calculo AS valor_total";
                                $result2 = $this->DbFetchAll($select2, $Conex);
                                $parcial = round($result2[0]['valor_total']);
                                $ingresa = 1;

                            }

                            if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

                                if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar + $parcial;
                                    $total_liqui = $total_liqui + $valor_liqui;
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';

                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar - $parcial;
                                    $total_liqui = $total_liqui - $valor_liqui;
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';
                                    $valor_liqui = $parcial;
                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                    $valor_liqui = $parcial;
                                }

                                $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                                //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                                    $tercero = $terid_costos[$i];
                                } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                                    $tercero = $tercero;
                                } else {
                                    $tercero == 'NULL';
                                }

                                $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');
                                $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";

                                $this->query($insert, $Conex, true);

                            } elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {
                                if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $debito = number_format(round(abs($parcial)), 2, '.', '');
                                    $credito = '0.00';
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $debito = '0.00';
                                    $credito = number_format(round(abs($parcial)), 2, '.', '');
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                                } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = number_format(round(abs($parcial)), 2, '.', '');
                                    $credito = '0.00';
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = '0.00';
                                    $credito = number_format(round(abs($parcial)), 2, '.', '');
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                                }
                                $select_ter_emp = "SELECT tercero_id FROM empresa
								 WHERE empresa_id=$empresa_id";
                                $result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex, true);

                                $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                $tercero_1 = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                                //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                                    $tercero_1 = $terid_costos[$i];
                                } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                                    $tercero_1 = $tercero_1;
                                } else {
                                    $tercero_1 == 'NULL';
                                }
                                $valor_liqui = number_format(round(abs($valor_liqui)), 2, '.', '');

                                $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                                $this->query($insert, $Conex, true);
                            }
                        }

                    } else {

                        //CUANDO NO EXISTE CONFIGURACION PARA TERCEROS}
                        foreach ($result as $resultado) {

                            $debito = '';
                            $credito = '';
                            $ingresa = 0;
                            $descripcion = '';
                            $descripcion = $resultado[puc_nombre];

                            if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                                $parcial = $subtotal;
                                $residual = $parcial;
                                $valor_liqui = $subtotal;
                                $base = '';
                                $porcentaje = '';
                                $formula = '';
                                $ingresa = 1;

                            } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                                if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {
                                    $resultado[puc_id] = $result_ric[0]['puc_id'];
                                    $descripcion = $result_ric[0]['descripcion'];
                                    $formula = $result_ric[0]['formula'];
                                    $porcentaje = $result_ric[0]['porcentaje'];

                                } else {
                                    $formula = $resultado[formula];
                                    $porcentaje = $resultado[porcentaje];

                                }
                                $base = $subtotal;
                                $calculo = str_replace("BASE", $base, $formula);
                                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                $select1 = "SELECT $calculo AS valor_total";
                                $result1 = $this->DbFetchAll($select1, $Conex);
                                $parcial = round($result1[0]['valor_total']);
                                $valor_liqui = round($result1[0]['valor_total']);
                                $ingresa = 1;

                            } elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {
                                $parcial = $total_pagar;
                                $valor_liqui = $total_liqui;
                                $base = '';
                                $porcentaje = '';
                                $formula = '';
                                $puc_idcon = $resultado[puc_id];
                                $ingresa = 1;

                            } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0 && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                                if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {

                                    $resultado[puc_id] = $result_ric[0]['puc_id'];
                                    $descripcion = $result_ric[0]['descripcion'];
                                    $formula = $result_ric[0]['formula'];
                                    $porcentaje = $result_ric[0]['porcentaje'];

                                } else {

                                    $formula = $resultado[formula];
                                    $porcentaje = $resultado[porcentaje];

                                }
                                $base = $residual;
                                $calculo = str_replace("BASE", $base, $formula);
                                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                $select2 = "SELECT $calculo AS valor_total";
                                $result2 = $this->DbFetchAll($select2, $Conex);
                                $parcial = round($result2[0]['valor_total']);
                                $ingresa = 1;

                            }

                            if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

                                if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar + $parcial;
                                    $total_liqui = $total_liqui + $valor_liqui;
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';

                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar - $parcial;
                                    $total_liqui = $total_liqui - $valor_liqui;
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';
                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                }

                                $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';

                                //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                                    $tercero = $terid_costos[$i];
                                } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                                    $tercero = $tercero;
                                } else {
                                    $tercero == 'NULL';
                                }
                                $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                                $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                                $this->query($insert, $Conex, true);

                            } elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {

                                if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $debito = number_format(round(abs($parcial)), 2, '.', '');
                                    $credito = '0.00';
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                                    $debito = '0.00';
                                    $credito = number_format(round(abs($parcial)), 2, '.', '');
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                                } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = number_format(round(abs($parcial)), 2, '.', '');
                                    $credito = '0.00';
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                                    $debito = '0.00';
                                    $credito = number_format(round(abs($parcial)), 2, '.', '');
                                    $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');

                                }

                                $select_ter_emp = "SELECT tercero_id FROM empresa WHERE empresa_id=$empresa_id";
                                $result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex, true);
                                $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                $tercero_1 = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';

                                //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                                    $tercero_1 = $terid_costos[$i];
                                } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                                    $tercero_1 = $tercero_1;
                                } else {
                                    $tercero_1 == 'NULL';
                                }
                                $valor_liqui = number_format(round(abs($valor_liqui)), 2, '.', '');

                                $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";

                                $this->query($insert, $Conex, true);
                            }
                        }
                    }

                }

            }

        }

        if (!strlen(trim($this->GetError())) > 0) {
            $this->Commit($Conex);
        } else {
            exit("Ocurrio un problema: " . $this->GetError());
        }
    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "factura", $Campos);
        return $Data->GetData();
    }

    public function cancellation($Conex)
    {

        $this->Begin($Conex);
        $factura_id = $this->requestDataForQuery('factura_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $anul_factura = $this->requestDataForQuery('anul_factura', 'text');
        $desc_anul_factura = $this->requestDataForQuery('desc_anul_factura', 'text');
        $anul_usuario_id = $this->requestDataForQuery('anul_usuario_id', 'integer');

        $select = "SELECT fuente_facturacion_cod, encabezado_registro_id FROM factura WHERE factura_id=$factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        $fuente = $result[0]['fuente_facturacion_cod'];
        $encabezado_registro_id = $result[0]['encabezado_registro_id'];

        $select = "SELECT orden_servicio_id, remesa_id, seguimiento_id FROM detalle_factura WHERE factura_id=$factura_id";
        $result = $this->DbFetchAll($select, $Conex);

        foreach ($result as $item) {
            if ($item[orden_servicio_id] > 0) {

                $update = "UPDATE orden_servicio  SET estado_orden_servicio='L'
				WHERE   orden_servicio_id = $item[orden_servicio_id] AND orden_servicio_id NOT IN (SELECT df.orden_servicio_id FROM detalle_factura df, factura f WHERE f.factura_id!=$factura_id AND  f.estado!='I' AND df.factura_id=f.factura_id AND df.orden_servicio_id IS NOT NULL)";
                $this->query($update, $Conex, true);
            } elseif ($item[remesa_id] > 0) {

                $update = "UPDATE remesa  SET estado='LQ'
				WHERE   remesa_id = $item[remesa_id] AND remesa_id NOT IN (SELECT df.remesa_id FROM detalle_factura df, factura f WHERE f.factura_id!=$factura_id AND f.estado!='I' AND df.factura_id=f.factura_id AND df.remesa_id IS NOT NULL)";
                $this->query($update, $Conex, true);
            } elseif ($item[seguimiento_id] > 0) {
                $update = "UPDATE seguimiento  SET estado='L'
				WHERE   seguimiento_id = $item[seguimiento_id] AND seguimiento_id NOT IN (SELECT df.seguimiento_id FROM detalle_factura df, factura f WHERE f.factura_id!=$factura_id AND f.estado!='I' AND df.factura_id=f.factura_id AND df.seguimiento_id IS NOT NULL)";
                $this->query($update, $Conex, true);
            }
        }

        if ($encabezado_registro_id > 0 && $encabezado_registro_id != '' && $encabezado_registro_id != null) {

            $insert = "INSERT INTO encabezado_de_registro_anulado(`encabezado_de_registro_anulado_id`, `encabezado_registro_id`, `empresa_id`, `oficina_id`, `tipo_documento_id`, `forma_pago_id`, `valor`, `numero_soporte`, `tercero_id`, `periodo_contable_id`, `mes_contable_id`, `consecutivo`, `fecha`, `concepto`, `puc_id`, `estado`, `fecha_registro`, `modifica`, `usuario_id`, `causal_anulacion_id`, `observaciones`) SELECT $encabezado_registro_id AS
		  encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		  forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		  '$desc_anul_factura_proveedor' AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";

            $this->query($insert, $Conex, true);

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);
            } else {

                $insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS
			imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS
			encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id FROM
			imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";

                $this->query($insert, $Conex, true);

                if (strlen($this->GetError()) > 0) {
                    $this->Rollback($Conex);
                } else {

                    $update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";
                    $this->query($update, $Conex, true);

                    if (strlen($this->GetError()) > 0) {
                        $this->Rollback($Conex);
                    } else {

                        $update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
                        $this->query($update, $Conex, true);

                        if (strlen($this->GetError()) > 0) {
                            $this->Rollback($Conex);
                        } else {
                            $this->Commit($Conex);
                        }

                    }

                }

            }
        }

        $update = "UPDATE factura SET estado= 'I',
	  				causal_anulacion_id = $causal_anulacion_id,
					anul_factura=$anul_factura,
					desc_anul_factura =$desc_anul_factura,
					anul_usuario_id=$anul_usuario_id
	  			WHERE factura_id=$factura_id";
        $this->query($update, $Conex, true);

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {
            $this->Commit($Conex);
        }
    }
    public function getComprobarTercero($tipo_bien_servicio_factura_id, $Conex)
    {

        $select = "SELECT COUNT(*) AS movimientos FROM codpuc_bien_servicio_factura   WHERE tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND tercero_bien_servicio_factura=1 AND activo=1";
        $result = $this->DbFetchAll($select, $Conex);

        $movimientos = $result[0]['movimientos'];
        return $movimientos;

    }

    public function updateDetalleFac($factura_id,$id,$Conex){

        $item				= str_replace(",","",$id);
        $item				= explode('-',$item);

        $id = $item[0];
        $tipo = $item[1];

        if($id > 0 && $tipo != ''){

          if($tipo == 'RM'){

            $update = "UPDATE remesa SET estado = 'LQ' WHERE remesa_id = $id";
            $this->query($update, $Conex, true);

          }elseif($tipo == 'OS'){

            $update = "UPDATE orden_servicio SET estado_orden_servicio = 'L' WHERE orden_servicio_id = $id";
            $this->query($update, $Conex, true);

          }elseif($tipo == 'ST'){

            $update = "UPDATE seguimiento SET estado = 'L' WHERE seguimiento_id = $id";
            $this->query($update, $Conex, true);

          }

          return true;

        }

    }

    public function getTotalDebitoCredito($factura_id, $Conex)
    {

        $select = "SELECT SUM(deb_item_factura) AS debito,SUM(cre_item_factura) AS credito FROM detalle_factura_puc   WHERE factura_id=$factura_id";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }
    public function getContabilizarReg($factura_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $Conex)
    {

        $this->Begin($Conex);

        $select = "SELECT f.factura_id,
						  f.fuente_facturacion_cod,
						  f.tipo_bien_servicio_factura_id,
						  f.consecutivo_factura,
						  f.consecutivo_factura,
						  f.valor,
						  f.fecha,
						  f.encabezado_registro_id,
						  f.tipo_documento_id,
						  CASE f.fuente_facturacion_cod WHEN 'OS' THEN 'Ordenes de Servicio'  ELSE 'Remesas' END AS tipo_soporte,
						  (SELECT tercero_id  FROM  cliente WHERE cliente_id=f.cliente_id) AS tercero,
						  (SELECT puc_id  FROM codpuc_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id AND contra_bien_servicio_factura=1 AND activo=1) AS puc_contra
					FROM factura f WHERE f.factura_id=$factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        if ($result[0]['encabezado_registro_id'] > 0 && $result[0]['encabezado_registro_id'] != '') {
            exit('Ya esta en proceso la contabilizaci&oacute;n de la Factura.<br>Por favor Verifique.');
        }
        $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
        $result_usu = $this->DbFetchAll($select_usu, $Conex);
        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);
        $tip_documento = $result[0]['tipo_documento_id'];
        $tipo_documento_id = $result[0]['tipo_documento_id'];
        $valor = $result[0]['valor'];
        $numero_soporte = $result[0]['consecutivo_factura'];
        $tercero_id = $result[0]['tercero'];
        $forma_pago_id = $result_pago[0]['forma_pago_id'];

        include_once "UtilidadesContablesModelClass.php";

        $utilidadesContables = new UtilidadesContablesModel();

        $fecha = $result[0]['fecha'];
        $fechaMes = substr($fecha, 0, 10);
        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);

        if ($mes_contable_id > 0 && $periodo_contable_id > 0) {
            $consecutivo = $result[0]['consecutivo_factura'];

            $concepto = 'Facturacion ' . $result[0]['tipo_soporte'] . ' ' . $numero_soporte;
            $puc_id = $result[0]['puc_contra'];
            $fecha_registro = date("Y-m-d H:m");
            $modifica = $result_usu[0]['usuario'];
            $fuente_facturacion_cod = $result[0]['fuente_facturacion_cod'];
            $numero_documento_fuente = $numero_soporte;
            $id_documento_fuente = $result[0]['factura_id'];
            $con_fecha_factura = $fecha_registro;

            $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
								mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
								VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
								$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)";
            $this->query($insert, $Conex, true);

            $select_item = "SELECT detalle_factura_puc_id  FROM  detalle_factura_puc WHERE factura_id=$factura_id";
            $result_item = $this->DbFetchAll($select_item, $Conex);
            foreach ($result_item as $result_items) {
                $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
                $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
								SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura+cre_item_factura),base_factura,porcentaje_factura,
								formula_factura,deb_item_factura,cre_item_factura
								FROM detalle_factura_puc WHERE factura_id=$factura_id AND detalle_factura_puc_id=$result_items[detalle_factura_puc_id]";
                $this->query($insert_item, $Conex);
            }
            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);
            } else {

                $update = "UPDATE factura SET encabezado_registro_id=$encabezado_registro_id,
							estado= 'C',
							con_usuario_id = $usuario_id,
							con_fecha_factura='$con_fecha_factura'
						WHERE factura_id=$factura_id";
                $this->query($update, $Conex, true);

                if (strlen($this->GetError()) > 0) {
                    $this->Rollback($Conex);

                } else {
                    $this->Commit($Conex);
                    return true;
                }
            }
        } else {
            exit("No es posible contabilizar");
        }
    }
    public function mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha, $Conex)
    {

        $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND
	                  oficina_id = $oficina_id AND '$fecha' BETWEEN fecha_inicio AND fecha_final";
        $result = $this->DbFetchAll($select, $Conex);

        $this->mes_contable_id = $result[0]['mes_contable_id'];

        return $result[0]['estado'] == 1 ? true : false;

    }

    public function PeriodoContableEstaHabilitado($Conex)
    {

        $mes_contable_id = $this->mes_contable_id;

        if (!is_numeric($mes_contable_id)) {
            return false;
        } else {
            $select = "SELECT estado FROM periodo_contable WHERE periodo_contable_id = (SELECT periodo_contable_id FROM
                         mes_contable WHERE mes_contable_id = $mes_contable_id)";
            $result = $this->DbFetchAll($select, $Conex);
            return $result[0]['estado'] == 1 ? true : false;
        }

    }
    public function selectEstadoEncabezadoRegistro($factura_id, $Conex)
    {

        $select = "SELECT estado FROM factura  WHERE factura_id = $factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        $estado = $result[0]['estado'];

        return $estado;

    }

    public function GetFuente($Conex)
    {
        return $this->DbFetchAll("SELECT fuente_facturacion_cod AS value,fuente_facturacion_nom AS text FROM  fuente_facturacion", $Conex,
            $ErrDb = true);
    }
    public function GetServiOs($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_bien_servicio_factura_id AS value,nombre_bien_servicio_factura AS text FROM  tipo_bien_servicio_factura WHERE fuente_facturacion_cod='OS' AND estado ='D'", $Conex,
            $ErrDb = true);
    }
    public function GetServiRm($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_bien_servicio_factura_id AS value,nombre_bien_servicio_factura AS text FROM  tipo_bien_servicio_factura WHERE fuente_facturacion_cod='RM' AND estado ='D'", $Conex,
            $ErrDb = true);
    }
    public function GetServiSt($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_bien_servicio_factura_id AS value,nombre_bien_servicio_factura AS text FROM  tipo_bien_servicio_factura WHERE fuente_facturacion_cod='ST' AND estado ='D'", $Conex,
            $ErrDb = true);
    }
    public function GetFormaCom($Conex)
    {
        return $this->DbFetchAll("SELECT forma_compra_venta_id AS value,nombre AS text FROM  forma_compra_venta ", $Conex,
            $ErrDb = true);
    }
    public function GetTipoFac($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_factura_id AS value,nombre_tipo_factura AS text FROM  tipo_factura", $Conex,
            $ErrDb = true);
    }
    public function GetQueryFacturaGrid()
    {

        $Query = "SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"parent.viewDoc(',factura_id,')\">',f.consecutivo_factura,'</a>' ) AS consecutivo_factura,
   					CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente,
   					f.fecha,
					f.vencimiento,
					f.radicacion,
					f.valor,
					(SELECT fuente_facturacion_nom FROM fuente_facturacion WHERE fuente_facturacion_cod=f.fuente_facturacion_cod) AS fuente,
					(SELECT nombre_bien_servicio_factura FROM tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id) AS tipo_servicio,
					CASE f.estado WHEN 'A' THEN 'EN EDICION' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS estado_factura
			FROM factura f, cliente c, tercero t
		WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id ORDER BY consecutivo_factura DESC";

        return $Query;
    }

    public function getreContabilizarReg($factura_id, $empresa_id, $oficina_id, $usuario_id, $Conex)
    {

        $this->Begin($Conex);
        //$select_factura      = "SELECT * FROM factura  WHERE factura_id=$factura_id AND (tipo_bien_servicio_factura_id=1 OR  tipo_bien_servicio_factura_id=4)";
        $select_factura = "SELECT * FROM factura  WHERE factura_id=$factura_id";
        //exit($select_factura);
        $result_factura = $this->DbFetchAll($select_factura, $Conex, true);
        $tipo_bien_servicio_factura_id = $result_factura[0]['tipo_bien_servicio_factura_id'];
        $encabezado_registro_id = $result_factura[0]['encabezado_registro_id'];
        $cliente_id = $result_factura[0]['cliente_id'];
        $valor_comp = $result_factura[0]['valor'];
        $select_tercero = "SELECT tercero_id FROM cliente WHERE cliente_id=$cliente_id";
        $result_tercero = $this->DbFetchAll($select_tercero, $Conex, true);
        $tercero_id = $result_tercero[0][tercero_id];

        if (!$result_factura[0]['tipo_bien_servicio_factura_id'] > 0) {
            return false;
        }
        $select_detalle = "SELECT * FROM detalle_factura  WHERE factura_id=$factura_id";
        //echo($select_detalle);
        $result_detalle = $this->DbFetchAll($select_detalle, $Conex, true);
        $subtotal = 0;
        $sub_costos = 0;
        $ter_costos = [];
        $terid_costos = [];
        $complemento = [];
        $j = 0;

        foreach ($result_detalle as $detalle) {
            if ($detalle['detalle_factura_id'] != '') {

                if ($detalle['orden_servicio_id'] > 0) {

                    if (!strlen(trim($this->GetError())) > 0) {
                        $subtotal = $subtotal + $detalle['valor'];
                        $update = "UPDATE orden_servicio  SET  	estado_orden_servicio='F'
					WHERE   orden_servicio_id = '" . $detalle['orden_servicio_id'] . "'";
                        $this->query($update, $Conex, true);

                    }
                } elseif ($detalle['remesa_id'] > 0) {
                    $select = "SELECT
							r.remesa_id,
							r.origen_id,
							r.destino_id,
							r.producto_id,
							r.descripcion_producto,
							r.cantidad,
							r.numero_remesa,
							r.valor_facturar,
							r.valor_costo,
							r.conductor_id,
							(SELECT IF(d.manifiesto_id>0,(SELECT CONCAT_WS(': ','MC',manifiesto) FROM manifiesto WHERE manifiesto_id=d.manifiesto_id),(SELECT CONCAT_WS(': ','DU',despacho) FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id)) AS complem FROM detalle_despacho d,  tenedor  t WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id),(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id)) ) AS complemento,
							(SELECT t.tercero_id FROM detalle_despacho d,  tenedor  t WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id),(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id)) ) AS tercero_id
							FROM remesa r
							WHERE r.remesa_id='" . $detalle['remesa_id'] . "'";

                    $result = $this->DbFetchAll($select, $Conex, true);

                    foreach ($result as $resultado) {
                        /* if($resultado[valor_facturar] <$resultado[valor_costo]){
                        exit("Una de las remesas tiene el valor del costo mayor al valor a facturar");
                        }  */
                        $remesas = $resultado['remesa_id'];
                        //echo(','.$remesas);
                        $subtotal = $subtotal + $resultado['valor_facturar'];
                        $sub_costos = $sub_costos + round($resultado['valor_costo']);
                        $ter_costos[$j] = round($resultado['valor_costo']);
                        $terid_costos[$j] = $resultado['tercero_id'];
                        $complemento[$j] = $resultado['complemento'] . '- Remesa: ' . $resultado['numero_remesa'];
                        $j++;

                        if (!strlen(trim($this->GetError())) > 0) {
                            $update = "UPDATE remesa SET estado='FT' WHERE remesa_id = '" . $detalle['remesa_id'] . "'";
                            $this->query($update, $Conex, true);
                        }
                    }

                } elseif ($detalle['seguimiento_id'] > 0) {
                    $select = "SELECT
							r.seguimiento_id,
							r.origen_id,
							r.destino_id,
							r.observaciones,
							r.valor_facturar
							FROM seguimiento r
							WHERE r.seguimiento_id='" . $detalle['seguimiento_id'] . "'";

                    $result = $this->DbFetchAll($select, $Conex, true);

                    foreach ($result as $resultado) {
                        $subtotal = $subtotal + $resultado[valor_facturar];

                        if (!strlen(trim($this->GetError())) > 0) {
                            $update = "UPDATE seguimiento SET estado='FT' WHERE seguimiento_id = '" . $detalle['seguimiento_id'] . "'";
                            $this->query($update, $Conex, true);
                        }
                    }
                }
            }
        }
        $select_centro = "SELECT centro_de_costo_id FROM centro_de_costo  WHERE oficina_id=$oficina_id";
        $result_centro = $this->DbFetchAll($select_centro, $Conex, true);
        $centro_de_costo_id = $result_centro[0][centro_de_costo_id];

        $total_pagar = 0;
        $total_liqui = 0;
        $parcial = '';
        $valor_liqui = '';

        $select_com = "SELECT COUNT(*) AS num_cuentas
				 FROM codpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.tercero_bien_servicio_factura=1 AND c.activo=1 ";

        $result_com = $this->DbFetchAll($select_com, $Conex);
        $select = "SELECT  c.despuc_bien_servicio_factura,
				  c.natu_bien_servicio_factura,
				  c.contra_bien_servicio_factura,
				  c.tercero_bien_servicio_factura,
				  c.ret_tercero_bien_servicio_factura,
				  c.reteica_bien_servicio_factura,
			   	  c.aplica_ingreso,
				  c.aplica_tenedor,
				  c.puc_id,
				  (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
				  (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
				  (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,
					(SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,
					(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,
					(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,
					(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
					(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
					(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto
				 FROM codpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura!=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";
        $result = $this->DbFetchAll($select, $Conex, true);
        if ($result_com[0][num_cuentas] > 0) {
            $delete_puc = "DELETE FROM detalle_factura_puc WHERE factura_id=$factura_id";
            $this->query($delete_puc, $Conex);

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);
            }
            $residual = 0;
            //CUANDO EXISTE CONFIGURACION PARA TERCEROS
            foreach ($result as $resultado) {
                $debito = '';
                $credito = '';
                $ingresa = 0;
                $descripcion = $resultado[puc_nombre];
                if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                    $parcial = $subtotal - $sub_costos;
                    $residual = $parcial;
                    $valor_liqui = $subtotal;
                    $base = ' NULL';
                    $porcentaje = ' NULL';
                    $formula = ' NULL';
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {
                    $base = $resultado[reteica_bien_servicio_factura] == 1 ? $subtotal : ($subtotal - $sub_costos);
                    $formula = $resultado[formula];
                    $porcentaje = $resultado[porcentaje];
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select1 = "SELECT $calculo AS valor_total";
                    $result1 = $this->DbFetchAll($select1, $Conex);
                    $parcial = round($result1[0]['valor_total']);
                    $base1 = $subtotal;
                    $formula1 = $resultado[formula];
                    $porcentaje1 = $resultado[porcentaje];
                    $calculo1 = str_replace("BASE", $base1, $formula1);
                    $calculo1 = str_replace("PORCENTAJE", $porcentaje1, $calculo1);
                    $select2 = "SELECT $calculo1 AS valor_total";
                    $result2 = $this->DbFetchAll($select2, $Conex);
                    $valor_liqui = round($result2[0]['valor_total']);
                    $ingresa = 1;

                } elseif ($resultado[tercero_bien_servicio_factura] == 1 && $resultado[aplica_ingreso] != 1) {

                    $i = 0;
                    foreach ($ter_costos as $ter_costo) {
                        if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar + round($ter_costo);
                            $debito = number_format(abs(round($ter_costo)), 2, '.', '');
                            $credito = '0.00';

                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar - round($ter_costo);
                            $debito = '0.00';
                            $credito = number_format(abs(round($ter_costo)), 2, '.', '');
                        } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                            $debito = number_format(abs(round($ter_costo)), 2, '.', '');
                            $credito = '0.00';
                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                            $debito = '0.00';
                            $credito = number_format(abs(round($ter_costo)), 2, '.', '');
                        }

                        $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                        $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                        $tercero = $resultado[puc_tercero] == 1 ? $terid_costos[$i] : 'NULL';
                        //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                        if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                            $tercero = $tercero;
                        } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                            $tercero = $tercero_id;
                        } else {
                            $tercero == 'NULL';
                        }
                        $descripcion = '';
                        $descripcion = $resultado[puc_nombre] . ' - ' . $complemento[$i];
                        $base = ' NULL';
                        $porcentaje = ' NULL';
                        $formula = ' NULL';
                        $tercero_pro = $terid_costos[$i];
                        $valor_liqui = round($ter_costo);
                        $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                        $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
									VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),$base,$porcentaje,'$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                        $this->query($insert, $Conex, true);

                        $select_ret = "SELECT  c.despuc_bien_servicio_factura,
									  c.natu_bien_servicio_factura,
									  c.contra_bien_servicio_factura,
									  c.tercero_bien_servicio_factura,
									  c.ret_tercero_bien_servicio_factura,
									  c.puc_id,
									  (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
									  (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
									  (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,
										(SELECT autoret_proveedor  FROM proveedor WHERE tercero_id=$tercero_pro ) AS autorete,
										(SELECT retei_proveedor FROM proveedor WHERE tercero_id=$tercero_pro ) AS retei,
										(SELECT renta_proveedor FROM proveedor WHERE tercero_id=$tercero_pro ) AS renta,
										(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
										(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
										(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
										(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
										WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
										AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto
									 FROM codpuc_bien_servicio_factura  c
									 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura=1 AND c.activo=1  ORDER BY c.contra_bien_servicio_factura";
                        $result_ret = $this->DbFetchAll($select_ret, $Conex);
                        foreach ($result_ret as $result_ret) {
                            if ($result_ret[formula] != '' && $result_ret[porcentaje] > 0 && $result_ret[monto] <= $ter_costo && (($result_ret[exento] == 'RT' && $result_ret[autorete] != 'S' && $resultado[autorete] != 'S') || ($result_ret[exento] == 'IC' && $result_ret[retei] != 'S' && $resultado[retei] != 'S') || ($result_ret[exento] == 'CR' && $result_ret[renta] != 'S' && $resultado[renta] != 'S') || ($result_ret[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                                $base = round($ter_costo);
                                $formula = $result_ret[formula];
                                $porcentaje = $result_ret[porcentaje];
                                $calculo = str_replace("BASE", $base, $formula);
                                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                                $select2 = "SELECT $calculo AS valor_total";
                                $result2 = $this->DbFetchAll($select2, $Conex);
                                $parcial = round($result2[0]['valor_total']);
                                $valor_liqui = round($result2[0]['valor_total']);
                                $descripcion1 = $result_ret[puc_nombre] . ' - ' . $complemento[$i];

                                if ($result_ret[natu_bien_servicio_factura] == 'D' && $result_ret[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar + $parcial;
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';

                                } elseif ($result_ret[natu_bien_servicio_factura] == 'C' && $result_ret[contra_bien_servicio_factura] != 1) {
                                    $total_pagar = $total_pagar - $parcial;
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                } elseif ($result_ret[natu_bien_servicio_factura] == 'D' && $result_ret[contra_bien_servicio_factura] == 1) {
                                    $debito = number_format(abs($parcial), 2, '.', '');
                                    $credito = '0.00';
                                } elseif ($result_ret[natu_bien_servicio_factura] == 'C' && $result_ret[contra_bien_servicio_factura] == 1) {
                                    $debito = '0.00';
                                    $credito = number_format(abs($parcial), 2, '.', '');
                                }

                                $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                                $centro_costo = $result_ret[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                                $tercero = $result_ret[puc_tercero] == 1 ? $terid_costos[$i] : 'NULL';
                                //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                if ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 1) {
                                    $tercero = $tercero;
                                } elseif ($resultado['puc_tercero'] == 1 && $resultado['aplica_tenedor'] == 0) {
                                    $tercero = $tercero_id;
                                } else {
                                    $tercero == 'NULL';
                                }

                                $contra_bien_servicio_factura = $result_ret[contra_bien_servicio_factura];
                                $puc_id = $result_ret[puc_id];
                                $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                                $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
											VALUES ($detalle_factura_puc_id,$factura_id,$puc_id,$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),$base,$porcentaje,'$formula','$descripcion1','$debito','$credito','$valor_liqui',$contra_bien_servicio_factura)";
                                $this->query($insert, $Conex, true);
                                $descripcion1 = '';

                            }

                        }$i++;
                    }
                } elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {
                    $parcial = $total_pagar;
                    $valor_liqui = $total_liqui;
                    $base = ' NULL';
                    $porcentaje = ' NULL';
                    $formula = ' NULL';
                    $puc_idcon = $resultado[puc_id];
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0) {

                    $base = $residual;
                    $formula = $resultado[formula];
                    $porcentaje = $resultado[porcentaje];
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select2 = "SELECT $calculo AS valor_total";
                    $result2 = $this->DbFetchAll($select2, $Conex);
                    $parcial = round($result2[0]['valor_total']);
                    $ingresa = 1;

                }

                if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar + $parcial;
                        $total_liqui = $total_liqui + $valor_liqui;
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar - $parcial;
                        $total_liqui = $total_liqui - $valor_liqui;
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    }

                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                    $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),$base,$porcentaje,'$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                    $this->query($insert, $Conex, true);

                } elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {
                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = number_format(round(abs($parcial)), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = '0.00';
                        $credito = number_format(round(abs($parcial)), 2, '.', '');
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(round(abs($parcial)), 2, '.', '');
                        $credito = '0.00';
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(round(abs($parcial)), 2, '.', '');
                        $valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
                    }
                    $select_ter_emp = "SELECT tercero_id FROM empresa
								 WHERE empresa_id=$empresa_id";
                    $result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex);
                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero_1 = $resultado[puc_tercero] == 1 ? $result_ter_emp[0]['tercero_id'] : 'NULL';
                    $valor_liqui = number_format(round(abs($valor_liqui)), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),$base,$porcentaje,'$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                    $this->query($insert, $Conex, true);
                }
            }

        } else {
            $delete_puc = "DELETE FROM detalle_factura_puc WHERE factura_id=$factura_id";
            $this->query($delete_puc, $Conex);

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);
            }

            //CUANDO NO EXISTE CONFIGURACION PARA TERCEROS
            foreach ($result as $resultado) {
                $debito = '';
                $credito = '';
                $ingresa = 0;
                $descripcion = '';
                $descripcion = $resultado[puc_nombre];

                if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                    $parcial = $subtotal;
                    $residual = $parcial;
                    $valor_liqui = $subtotal;
                    $base = '';
                    $porcentaje = '';
                    $formula = '';
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                    $base = $subtotal;
                    $formula = $resultado[formula];
                    $porcentaje = $resultado[porcentaje];
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select1 = "SELECT $calculo AS valor_total";
                    $result1 = $this->DbFetchAll($select1, $Conex);
                    $parcial = $result1[0]['valor_total'];
                    $valor_liqui = $result1[0]['valor_total'];
                    $ingresa = 1;

                } elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

                    $parcial = $total_pagar;
                    $valor_liqui = $total_liqui;
                    $base = '';
                    $porcentaje = '';
                    $formula = '';
                    $puc_idcon = $resultado[puc_id];
                    $ingresa = 1;

                } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0 && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                    $base = $residual;
                    $formula = $resultado[formula];
                    $porcentaje = $resultado[porcentaje];
                    $calculo = str_replace("BASE", $base, $formula);
                    $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                    $select2 = "SELECT $calculo AS valor_total";
                    $result2 = $this->DbFetchAll($select2, $Conex);
                    $parcial = $result2[0]['valor_total'];
                    $ingresa = 1;

                }

                if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar + $parcial;
                        $total_liqui = $total_liqui + $valor_liqui;
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $total_pagar = $total_pagar - $parcial;
                        $total_liqui = $total_liqui - $valor_liqui;
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    }

                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
                    $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                    $this->query($insert, $Conex, true);

                } elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {
                    if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';

                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = number_format(abs($parcial), 2, '.', '');
                        $credito = '0.00';
                    } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                        $debito = '0.00';
                        $credito = number_format(abs($parcial), 2, '.', '');
                    }

                    $select_ter_emp = "SELECT tercero_id FROM empresa
								 WHERE empresa_id=$empresa_id";
                    $result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex);

                    $detalle_factura_puc_id = $this->DbgetMaxConsecutive("detalle_factura_puc", "detalle_factura_puc_id", $Conex, true, 1);
                    $centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
                    $tercero_1 = $resultado[puc_tercero] == 1 ? $result_ter_emp[0][tercero_id] : 'NULL';
                    $valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

                    $insert = "INSERT INTO detalle_factura_puc (detalle_factura_puc_id,factura_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,deb_item_factura,cre_item_factura,valor_liquida,contra_factura)
								VALUES ($detalle_factura_puc_id,$factura_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),'$base','$porcentaje','$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
                    $this->query($insert, $Conex, true);
                }
            }
        }

        if (!strlen(trim($this->GetError())) > 0) {

            if ($encabezado_registro_id > 0) {

                $delete_item = "DELETE FROM imputacion_contable WHERE encabezado_registro_id=$encabezado_registro_id";
                $this->query($delete_item, $Conex);
                $select_item = "SELECT detalle_factura_puc_id  FROM  detalle_factura_puc WHERE factura_id=$factura_id";
                $result_item = $this->DbFetchAll($select_item, $Conex);
                foreach ($result_item as $result_items) {
                    $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
                    $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
								SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura+cre_item_factura),base_factura,porcentaje_factura,
								formula_factura,deb_item_factura,cre_item_factura
								FROM detalle_factura_puc WHERE factura_id=$factura_id AND detalle_factura_puc_id=$result_items[detalle_factura_puc_id]";
                    $this->query($insert_item, $Conex);
                }
                if (strlen($this->GetError()) > 0) {
                    $this->Rollback($Conex);
                }
            }

            $this->Commit($Conex);
            return true;
        }
    }
}
