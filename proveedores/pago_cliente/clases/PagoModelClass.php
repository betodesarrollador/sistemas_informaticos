<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class PagoModel extends Db
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

    public function selectDatosPagoId($abono_factura_id, $Conex)
    {
        $select = "SELECT a.*,
	 					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id) AS numero_soporte
					FROM abono_factura  a
	                WHERE a.abono_factura_id = $abono_factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;

    }

    public function GetTipoPago($Conex)
    {
        return $this->DbFetchAll("SELECT c.cuenta_tipo_pago_id AS value, CONCAT_WS(' - ',(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id ),(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id )) AS text FROM cuenta_tipo_pago c", $Conex,
            $ErrDb = false);
    }

    public function GetDocumento($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento  WHERE de_cierre=0 AND de_traslado=0 AND pago_factura=1", $Conex,
            $ErrDb = false);
    }

    public function getDocumentorev($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento  WHERE de_cierre=0 AND de_traslado=0 AND pago_factura=1", $Conex,
            $ErrDb = false);
    }

    public function getCausalesAnulacion($Conex)
    {

        $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;
    }

    public function getDataCliente($cliente_id, $Conex)
    {

        $select = "SELECT tr.numero_identificacion AS cliente_nit
	 			FROM cliente c, tercero tr
				WHERE c.cliente_id=$cliente_id AND tr.tercero_id = c.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }
    public function SelectSolicitud($factura_id, $Conex)
    {

        $select = "SELECT
				CASE f.fuente_facturacion_cod WHEN 'OS' THEN 'Ordenes de Servicio' ELSE 'Remesas' END AS tipo,
				f.consecutivo_factura
				FROM factura f
				WHERE f.factura_id=$factura_id";

        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }

    public function getDataFactura($abono_factura_id, $Conex)
    {

        $select = "SELECT
						(SELECT t.numero_identificacion FROM  cliente p, tercero t WHERE p.cliente_id=a.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_nit,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  cliente p, tercero t WHERE p.cliente_id=a.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_nombre
	 			FROM abono_factura a
				WHERE a.abono_factura_id = $abono_factura_id ";

        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }

    public function Save($empresa_id, $Campos, $Conex)
    {

        $this->Begin($Conex);

        $abono_factura_id = $this->DbgetMaxConsecutive("abono_factura", "abono_factura_id", $Conex, true, 1);
        $numero_soporte = $this->requestDataForQuery('numero_soporte', 'alphanum');
        $cuenta_tipo_pago_id = $this->requestDataForQuery('cuenta_tipo_pago_id', 'integer');
        $tipo_documento_id = $this->requestDataForQuery('tipo_documento_id', 'integer');
        $cliente_id = $this->requestDataForQuery('cliente_id', 'integer');
        $fecha = $this->requestDataForQuery('fecha', 'date');
        $num_cheque = $this->requestDataForQuery('num_cheque', 'text');
        $concepto_abono_factura = $this->requestDataForQuery('concepto_abono_factura', 'text');
        $causaciones_abono_factura = $this->requestDataForQuery('causaciones_abono_factura', 'text');
        $descuentos_items = $this->requestDataForQuery('descuentos_items', 'text');
        $valores_abono_factura = $this->requestDataForQuery('valores_abono_factura', 'text');
        $valor_descu_factura = $this->requestDataForQuery('valor_descu_factura', 'numeric');
        $valor_mayor_factura = $this->requestDataForQuery('valor_mayor_factura', 'numeric');
        $valor_neto_factura = $this->requestDataForQuery('valor_neto_factura', 'numeric');
        $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
        $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
        $ingreso_abono_factura = $this->requestDataForQuery('ingreso_abono_factura', 'date');
        $estado_abono_factura = $this->requestDataForQuery('estado_abono_factura', 'alphanum');
        $fact_comp = '';

        $descuentos_frac = explode('=', $descuentos_items);
        $id_des_ind = '';
        $value_des = '';
        $x = 0;

        foreach ($descuentos_frac as $descu_frac) {
            $id_descu = explode('-', $descu_frac);
            if ($id_descu[1] != '' && $id_descu[0] != '') {
                $id_des_ind[$x] = $id_descu[1];
                $value_des[$x] = $id_descu[0];
                $x++;
            }
        }

        $causacion_id = str_replace("'", "", $causaciones_abono_factura);
        $causacion_id = explode(',', $causacion_id);

        $valores_id = str_replace("'", "", $valores_abono_factura);
        $valores_id = explode('=', $valores_id);
        $valor_tot_pago = 0;
        foreach ($valores_id as $valor_pago) {
            $valor_pagos = str_replace(".", "", $valor_pago);
            $valor_pagos = str_replace(",", ".", $valor_pagos);
            $valor_tot_pago = $valor_tot_pago + $valor_pagos;
        }

        $select_codigo = "SELECT codigo FROM tipo_de_documento WHERE tipo_documento_id=$tipo_documento_id";
        $result_codigo = $this->DbFetchAll($select_codigo, $Conex, false);
        $codigo_documento = $result_codigo[0]['codigo'];

        $select_sucursal = "SELECT codigo_centro FROM oficina WHERE oficina_id = $oficina_id";
        $result_sucursal = $this->DbFetchAll($select_sucursal, $Conex, false);
        $codigo_sucursal = $result_sucursal[0]['codigo_centro'];

        $consecutivo_final = str_pad($abono_factura_id, 5, "0", STR_PAD_LEFT);

        $consecutivo_documento = $codigo_sucursal . $codigo_documento . $consecutivo_final;

        $insert = "INSERT INTO abono_factura (abono_factura_id,cuenta_tipo_pago_id,num_cheque,tipo_documento_id,cliente_id,fecha,valor_abono_factura,valor_mayor_factura,valor_descu_factura,valor_neto_factura,concepto_abono_factura,causaciones_abono_factura,descuentos_items,valores_abono_factura,usuario_id,oficina_id,ingreso_abono_factura,estado_abono_factura,consecutivo_documento)
				VALUES ($abono_factura_id,$cuenta_tipo_pago_id,$num_cheque,$tipo_documento_id,$cliente_id,$fecha,'$valor_tot_pago',$valor_mayor_factura,$valor_descu_factura,$valor_neto_factura,$concepto_abono_factura,$causaciones_abono_factura,$descuentos_items,$valores_abono_factura,$usuario_id,$oficina_id,$ingreso_abono_factura,$estado_abono_factura,$consecutivo_documento)";
        //echo $insert;
        $this->query($insert, $Conex);

        $select_clien = "SELECT
					CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente
					FROM cliente p, tercero t WHERE p.cliente_id=$cliente_id AND t.tercero_id=p.tercero_id";
        $result_clien = $this->DbFetchAll($select_clien, $Conex, true);

        $select_tipo = "SELECT c.puc_id,
					p.requiere_centro_costo,
					p.requiere_tercero,
					c.cuenta_tipo_pago_natu,
					TRIM(p.nombre) AS nombre,
					(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS por_emp,
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS for_emp
					FROM cuenta_tipo_pago c, puc p WHERE c.cuenta_tipo_pago_id=$cuenta_tipo_pago_id AND p.puc_id=c.puc_id";

        $result_tipo = $this->DbFetchAll($select_tipo, $Conex);
        $puc_tipo = $result_tipo[0][puc_id];
        $pucnom_tipo = 'CANC. FACTURAS: ' . $result_clien[0][cliente];
        $porcen_tipo = $result_tipo[0][por_emp];
        $formul_tipo = $result_tipo[0][for_emp];
        $natu_tipo = $result_tipo[0][cuenta_tipo_pago_natu];

        $j = 0;
        $final_credito_pago = 0;
        $final_debito_pago = 0;
        foreach ($causacion_id as $causaciones) {
            if ($causaciones > 0) {

                $valor_pago_ind = str_replace(".", "", $valores_id[$j]);
                $valor_pago_ind = str_replace(",", ".", $valor_pago_ind);
                $j++;

                $debito_pago = '';
                $credito_pago = '';
                $debito_contra = '';
                $credito_contra = '';

                $select_contra = "SELECT c.puc_id,
									f.consecutivo_factura,
									IF(d.cre_item_factura>0,'C','D') AS natu_bien_servicio,
									c.requiere_centro_costo,
									c.requiere_tercero,
									d.tercero_id,
									d.numero_identificacion,
									d.digito_verificacion,
									d.centro_de_costo_id,
									d.codigo_centro_costo,
									(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS nombre_puc,
									(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
									WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
									AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS por_emp,
									(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
									WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
									AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS for_emp
									FROM factura f,   puc c, detalle_factura_puc  d
									WHERE f.factura_id=$causaciones AND d.factura_id=f.factura_id  AND d.contra_factura=1  AND c.puc_id=d.puc_id ";
                //echo $select_contra;
                $result_contra = $this->DbFetchAll($select_contra, $Conex);
                $digito_verificacion = $result_contra[0][digito_verificacion] > 0 ? $result_contra[0][digito_verificacion] : 'NULL';
                $puc_contra = $result_contra[0][puc_id];
                $natu_contra = $result_contra[0][natu_bien_servicio];
                $nombre_contra = 'CANC. FACT: ' . $result_contra[0][consecutivo_factura];
                $fact_comp .= $result_contra[0][consecutivo_factura] . ',';
                $porcen_contra = $result_contra[0][por_emp];
                $formul_contra = $result_contra[0][for_emp];
                $tercero_id = $result_contra[0][requiere_tercero] == 1 ? $result_contra[0][tercero_id] : 'NULL';
                $numero_identificacion = $result_contra[0][requiere_tercero] == 1 ? $result_contra[0][numero_identificacion] : 'NULL';
                $digito_verificacion = $result_contra[0][requiere_tercero] == 1 ? $digito_verificacion : 'NULL';
                $centro_costo = $result_contra[0][requiere_centro_costo] == 1 ? $result_contra[0][centro_de_costo_id] : 'NULL';
                $codigo_centro_costo = $result_contra[0][requiere_centro_costo] == 1 ? $result_contra[0][codigo_centro_costo] : 'NULL';

                $tercero_id1 = $result_tipo[0][requiere_tercero] == 1 ? $result_contra[0][tercero_id] : 'NULL';
                $numero_identificacion1 = $result_tipo[0][requiere_tercero] == 1 ? $result_contra[0][numero_identificacion] : 'NULL';
                $digito_verificacion1 = $result_tipo[0][requiere_tercero] == 1 ? $digito_verificacion : 'NULL';
                $centro_costo1 = $result_tipo[0][requiere_centro_costo] == 1 ? $result_contra[0][centro_de_costo_id] : 'NULL';
                $codigo_centro_costo1 = $result_tipo[0][requiere_centro_costo] == 1 ? $result_contra[0][codigo_centro_costo] : 'NULL';

                if ($natu_contra == 'D') {
                    $debito_contra = 0;
                    $credito_contra = $valor_pago_ind;
                } else {
                    $debito_contra = $valor_pago_ind;
                    $credito_contra = 0;
                }

                if ($natu_tipo == 'C') {
                    $debito_pago = 0;
                    $credito_pago = $valor_pago_ind;

                } else {
                    $debito_pago = $valor_pago_ind;
                    $credito_pago = 0;

                }

                $rel_valor_descu = 0;
                $debito_des = 0;
                $credito_des = 0;
                $debito_des_uni = 0;
                $credito_des_uni = 0;

                if (in_array($causaciones, $id_des_ind)) {
                    $valor_des = explode(',', $value_des[array_search($causaciones, $id_des_ind)]);
                    foreach ($valor_des as $valor_descu) {
                        if ($valor_descu != '') {

                            $valor_final = explode('_', $valor_descu);
                            $valor_fin = str_replace(".", "", $valor_final[1]);
                            $valor_fin = str_replace(",", ".", $valor_fin);
                            $rel_valor_descu = $rel_valor_descu + $valor_fin;
                        }
                    }
                }

                $relacion_abono_id = $this->DbgetMaxConsecutive("relacion_abono", "relacion_abono_id", $Conex, true, 1);
                $insert_item = "INSERT INTO relacion_abono (relacion_abono_id,factura_id,abono_factura_id,rel_valor_abono,rel_valor_descu)
						VALUES ($relacion_abono_id,$causaciones,$abono_factura_id,'$valor_pago_ind',$rel_valor_descu)";
                $this->query($insert_item, $Conex);

                if (in_array($causaciones, $id_des_ind)) {
                    $valor_des = explode(',', $value_des[array_search($causaciones, $id_des_ind)]);
                    foreach ($valor_des as $valor_descu) {
                        if ($valor_descu != '') {

                            $valor_final = explode('_', $valor_descu);
                            $valor_fin = str_replace(".", "", $valor_final[1]);
                            $valor_fin = str_replace(",", ".", $valor_fin);
                            $id_param = str_replace("'", "", $valor_final[0]);

                            $select_des = "SELECT p.naturaleza, p.puc_id,
											(SELECT nombre FROM puc WHERE puc_id=p.puc_id) AS puc_des,
											(SELECT requiere_centro_costo FROM puc WHERE puc_id=p.puc_id) AS centro_des,
											(SELECT requiere_tercero FROM puc WHERE puc_id=p.puc_id) AS ter_des
											FROM parametros_descuento_factura p
											WHERE p.parametros_descuento_factura_id=$id_param ";

                            $result_des = $this->DbFetchAll($select_des, $Conex);

                            $puc_descu = $result_des[0][puc_id];
                            $puc_descu_nom = 'DESC. FACT: ' . $result_contra[0][consecutivo_factura];
                            $tercero_des = $result_des[0][ter_des] == 1 ? $tercero_id : 'NULL';
                            $numero_iden_des = $result_des[0][ter_des] == 1 ? $numero_identificacion : 'NULL';
                            $digito_iden_des = $result_des[0][ter_des] == 1 ? $digito_verificacion : 'NULL';
                            $centro_des = $result_des[0][centro_des] == 1 ? $centro_costo : 'NULL';
                            $codigo_centro_des = $result_des[0][centro_des] == 1 ? $codigo_centro_costo : '';

                            if ($result_des[0][naturaleza] == 'C') {
                                $credito_des = $credito_des + $valor_fin;
                                $credito_des_uni = $valor_fin;
                                $debito_des_uni = 0;
                            } elseif ($result_des[0][naturaleza] == 'D') {
                                $debito_des = $debito_des + $valor_fin;
                                $credito_des_uni = 0;
                                $debito_des_uni = $valor_fin;

                            }

                            $item_abono_id = $this->DbgetMaxConsecutive("item_abono", "item_abono_id", $Conex, true, 1);
                            $insert_descu = "INSERT INTO item_abono (
												item_abono_id,
												abono_factura_id,
												relacion_abono_id,
												puc_id,
												tercero_id,
												numero_identificacion,
												digito_verificacion,
												centro_de_costo_id,
												codigo_centro_costo,
												porcentaje_abono,
												formula_abono,
												desc_abono,
												deb_item_abono,
												cre_item_abono,
												sucursal_id)
										VALUES (
												$item_abono_id,
												$abono_factura_id,
												$relacion_abono_id,
												$puc_descu,
												$tercero_des,
												$numero_iden_des,
												$digito_iden_des,
												$centro_des,
												'$codigo_centro_des',
												NULL,
												NULL,
												'$puc_descu_nom',
												'$debito_des_uni',
												'$credito_des_uni',
												$oficina_id
										)";
                            $this->query($insert_descu, $Conex);

                        }
                    }

                }

                if ($debito_pago > 0) {
                    $debito_pago = $debito_pago - $debito_des;
                    $final_debito_pago = $final_debito_pago + $debito_pago;
                }

                if ($credito_pago > 0) {
                    $credito_pago = $credito_pago - $credito_des;
                    $final_credito_pago = $final_credito_pago + $credito_pago;
                }

                

                if ($debito_contra > 0) {
                    $debito_contra = $debito_contra - $debito_des;
                }

                if ($credito_contra > 0) {
                    $credito_contra = $credito_contra - $credito_des;
                }

                $item_abono_id = $this->DbgetMaxConsecutive("item_abono", "item_abono_id", $Conex, true, 1);
                $insert_contra = "INSERT INTO item_abono (
									item_abono_id,
									abono_factura_id,
									relacion_abono_id,
									puc_id,
									tercero_id,
								 	numero_identificacion,
									digito_verificacion,
									centro_de_costo_id,
									codigo_centro_costo,
									porcentaje_abono,
									formula_abono,
									desc_abono,
									deb_item_abono,
									cre_item_abono,
									sucursal_id)
							VALUES (
									$item_abono_id,
									$abono_factura_id,
									$relacion_abono_id,
									$puc_contra,
									$tercero_id,
									$numero_identificacion,
									$digito_verificacion,
									$centro_costo,
									'$codigo_centro_costo',
									'$porcen_contra',
									'$formul_contra',
									'$nombre_contra',
									'$debito_contra',
									'$credito_contra',
									$oficina_id
							)";
                $this->query($insert_contra, $Conex);
            }
        }

        if ($valor_mayor_factura > 0) {
            $final_debito_pago = $final_debito_pago + $valor_mayor_factura;
        }
        if ($valor_menor_factura > 0) {
            $final_debito_pago = $final_debito_pago - $valor_menor_factura;
        }
        $item_abono_id = $this->DbgetMaxConsecutive("item_abono", "item_abono_id", $Conex, true, 1);

        $insert_pago = "INSERT INTO item_abono (
							item_abono_id,
							abono_factura_id,
							relacion_abono_id,
							puc_id,
							tercero_id,
							numero_identificacion,
							digito_verificacion,
							centro_de_costo_id,
							codigo_centro_costo,
							porcentaje_abono,
							formula_abono,
							desc_abono,
							deb_item_abono,
							cre_item_abono,
							sucursal_id)
					VALUES (
							$item_abono_id,
							$abono_factura_id,
							$relacion_abono_id,
							$puc_tipo,
							$tercero_id1,
							$numero_identificacion1,
							$digito_verificacion1,
							$centro_costo1,
							'$codigo_centro_costo1',
							'$porcen_tipo',
							'$formul_tipo',
							'" . $pucnom_tipo . "',
							'$final_debito_pago',
							'$final_credito_pago',
							$oficina_id
					)";
        $this->query($insert_pago, $Conex);
        //exit("realizando pruebas deb:$final_debito_pago cre: $final_credito_pago");
        if (!strlen(trim($this->GetError())) > 0) {
            $this->Commit($Conex);
            return $abono_factura_id;
        }

    }

    public function Update($Campos, $Conex)
    {
        $this->Begin($Conex);

        if ($_REQUEST['abono_factura_id'] != 'NULL') {
            $abono_factura_id = $this->requestDataForQuery('abono_factura_id', 'integer');
            $tipo_documento_id = $this->requestDataForQuery('tipo_documento_id', 'integer');
            $fecha = $this->requestDataForQuery('fecha', 'date');
            $num_cheque = $this->requestDataForQuery('num_cheque', 'text');

            $update = "UPDATE abono_factura SET tipo_documento_id=$tipo_documento_id, fecha=$fecha, num_cheque=$num_cheque
					WHERE abono_factura_id=$abono_factura_id";
            $this->query($update, $Conex);
            if (!strlen(trim($this->GetError())) > 0) {
                $this->Commit($Conex);
            }
        }
    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "abono_factura", $Campos);
        return $Data->GetData();
    }

    public function cancellation($Conex)
    {

        $this->Begin($Conex);

        $abono_factura_id = $this->requestDataForQuery('abono_factura_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $anul_abono_factura = $this->requestDataForQuery('anul_abono_factura', 'text');
        $desc_anul_abono_factura = $this->requestDataForQuery('desc_anul_abono_factura', 'text');
        $anul_usuario_id = $this->requestDataForQuery('anul_usuario_id', 'integer');

        $select = "SELECT encabezado_registro_id FROM abono_factura WHERE abono_factura_id=$abono_factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        $encabezado_registro_id = $result[0]['encabezado_registro_id'];

        if ($encabezado_registro_id > 0 && $encabezado_registro_id != '' && $encabezado_registro_id != null) {

            $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$desc_anul_abono_factura AS observaciones,usuario_anula,fecha_anulacion,usuario_actualiza,fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
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
                        $this->query($update, $Conex);

                        if (strlen($this->GetError()) > 0) {
                            $this->Rollback($Conex);
                        } else {
                            $update = "UPDATE abono_factura   SET estado_abono_factura= 'I',
									causal_anulacion_id = $causal_anulacion_id,
									anul_abono_factura=$anul_abono_factura,
									desc_anul_abono_factura =$desc_anul_abono_factura,
									anul_usuario_id=$anul_usuario_id
								WHERE abono_factura_id 	=$abono_factura_id";
                            $this->query($update, $Conex);

                            $this->Commit($Conex);
                        }

                    }

                }

            }
        } else {
            $update = "UPDATE abono_factura   SET estado_abono_factura= 'I',
					causal_anulacion_id = $causal_anulacion_id,
					anul_abono_factura=$anul_abono_factura,
					desc_anul_abono_factura =$desc_anul_abono_factura,
					anul_usuario_id=$anul_usuario_id
				WHERE abono_factura_id 	=$abono_factura_id";
            $this->query($update, $Conex);

            $this->Commit($Conex);

        }

    }

    public function reversar($empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $Conex)
    {

        $this->Begin($Conex);

        $abono_factura_id = $this->requestDataForQuery('abono_factura_id', 'integer');
        $rever_documento_id = $this->requestDataForQuery('rever_documento_id', 'integer');
        $rever_abono_factura = $this->requestDataForQuery('rever_abono_factura', 'text');
        $desc_rever_abono_factura = $this->requestDataForQuery('desc_rever_abono_factura', 'text');
        $rever_usuario_id = $this->requestDataForQuery('rever_usuario_id', 'integer');

        $select = "SELECT a.abono_factura_id,
					  a.valor_abono_factura,
					  a.ingreso_abono_factura,
					  a.concepto_abono_factura,
					  (SELECT tercero_id  FROM  cliente WHERE cliente_id=a.cliente_id) AS tercero,
					  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
					  a.tipo_documento_id  AS tipo_documento
				FROM abono_factura a WHERE a.abono_factura_id=$abono_factura_id";
        $result = $this->DbFetchAll($select, $Conex);

        $select_con = "SELECT (MAX(consecutivo)+1) AS consecutivo FROM encabezado_de_registro
					WHERE tipo_documento_id=$rever_documento_id AND  oficina_id=$oficina_id AND empresa_id=$empresa_id";
        $result_con = $this->DbFetchAll($select_con, $Conex);

        $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
					WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
        $result_usu = $this->DbFetchAll($select_usu, $Conex);

        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);
        $tipo_documento_id = $rever_documento_id;
        $valor = $result[0]['valor_abono_factura'];
        $numero_soporte = $result[0]['concepto_abono_factura'];
        $tercero_id = $result[0]['tercero'];

        include_once "UtilidadesContablesModelClass.php";

        $utilidadesContables = new UtilidadesContablesModel();

        $fechaMes = substr(date("Y-m-d"), 0, 10);
        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);
        $consecutivo = $utilidadesContables->getConsecutivo($oficina_id, $tipo_documento_id, $periodo_contable_id, $Conex);

        $fecha = date("Y-m-d H:m");
        $concepto = 'Reversar pago: ' . $result[0]['concepto_abono_factura'];
        $puc_id = $result[0]['puc_contra'];
        $fecha_registro = date("Y-m-d H:m");
        $modifica = $result_usu[0]['usuario'];
        $numero_documento_fuente = $result[0]['abono_factura_id'];
        $id_documento_fuente = $result[0]['abono_factura_id'];
        $con_fecha_abono_factura = $fecha_registro;

        $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
						mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
						VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
						$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)";
        //echo $insert;
        $this->query($insert, $Conex);

        $select_item = "SELECT item_abono_id FROM item_abono WHERE abono_factura_id=$abono_factura_id";
        $result_item = $this->DbFetchAll($select_item, $Conex);

        foreach ($result_item as $result_items) {
            $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
            $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id, tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
						SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(cre_item_abono+deb_item_abono),base_abono,porcentaje_abono,
						formula_abono,cre_item_abono,deb_item_abono
						FROM item_abono WHERE abono_factura_id=$abono_factura_id AND item_abono_id=$result_items[item_abono_id]";
            //echo $insert_item;
            $this->query($insert_item, $Conex);
        }

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {

            $update = "UPDATE abono_factura SET rev_encabezado_registro_id=$encabezado_registro_id,
					estado_abono_factura= 'A',
					rever_usuario_id = $rever_usuario_id,
					rever_abono_factura=$rever_abono_factura,
					desc_rever_abono_factura=$desc_rever_abono_factura,
					rever_documento_id=$rever_documento_id
				WHERE abono_factura_id =$abono_factura_id";
            $this->query($update, $Conex);

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);

            } else {
                $this->Commit($Conex);
                return true;
            }
        }

    }

    public function getTotalDebitoCredito($abono_factura_id, $Conex)
    {

        $select = "SELECT SUM(deb_item_abono) AS debito,SUM(cre_item_abono) AS credito FROM item_abono   WHERE abono_factura_id=$abono_factura_id 	";
        $result = $this->DbFetchAll($select, $Conex);

        $selectv = "SELECT valor_abono_factura FROM abono_factura   WHERE abono_factura_id=$abono_factura_id";
        $resultv = $this->DbFetchAll($selectv, $Conex);
        $valor_total = $result[0][debito] > $result[0][credito] ? $result[0][debito] : $result[0][credito];

        if ($resultv[0][valor_abono_factura] != $valor_total) {
            $update = "UPDATE abono_factura SET valor_abono_factura='$valor_total' WHERE abono_factura_id=$abono_factura_id";
            $this->DbFetchAll($update, $Conex);
        }

        return $result;

    }

    public function getContabilizarReg($abono_factura_id, $empresa_id, $oficina_id, $usuario_id, $Conex)
    {

        $this->Begin($Conex);

        $select = "SELECT a.abono_factura_id,
						  a.valor_abono_factura,
						  a.ingreso_abono_factura,
						  a.fecha,
						  a.num_cheque,
						  a.cuenta_tipo_pago_id,
						  a.concepto_abono_factura,
						  (SELECT tercero_id  FROM  cliente WHERE cliente_id=a.cliente_id) AS tercero,
						  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
						  a.tipo_documento_id
					FROM abono_factura a WHERE a.abono_factura_id=$abono_factura_id";
        $result = $this->DbFetchAll($select, $Conex);

        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);
        $tipo_documento_id = $result[0]['tipo_documento_id'];
        $valor = $result[0]['valor_abono_factura'];
        $numero_soporte = $result[0]['concepto_abono_factura'];
        $tercero_id = $result[0]['tercero'];
        $periodo_contable_id = $periodoContable;
        $mes_contable_id = $mesContable;
        $fecha = $result[0]['fecha'];
        $num_cheque = $result[0]['num_cheque'] != '' ? "'" . $result[0]['num_cheque'] . "'" : 'NULL';
        $concepto = $result[0]['concepto_abono_factura'];
        $puc_id = $result[0]['puc_contra'];
        $fecha_registro = date("Y-m-d H:m");
        $numero_documento_fuente = $result[0]['abono_factura_id'];
        $id_documento_fuente = $result[0]['abono_factura_id'];
        $con_fecha_abono_factura = $fecha_registro;
        $cuenta_tipo_pago_id = $result[0][cuenta_tipo_pago_id];

        include_once "UtilidadesContablesModelClass.php";

        $utilidadesContables = new UtilidadesContablesModel();

        $fechaMes = substr($fecha, 0, 10);
        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);
        $consecutivo = $utilidadesContables->getConsecutivo($oficina_id, $tipo_documento_id, $periodo_contable_id, $Conex);

        $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
        $result_usu = $this->DbFetchAll($select_usu, $Conex);
        $modifica = $result_usu[0]['usuario'];

        $select_pago = "SELECT forma_pago_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id=$cuenta_tipo_pago_id";
        $result_pago = $this->DbFetchAll($select_pago, $Conex);
        $forma_pago_id = $result_pago[0]['forma_pago_id'];

        $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$forma_pago_id,'$valor',$num_cheque,$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)";
        $this->DbFetchAll($insert, $Conex);

        $select_item = "SELECT item_abono_id FROM item_abono WHERE abono_factura_id=$abono_factura_id";
        $result_item = $this->DbFetchAll($select_item, $Conex);

        foreach ($result_item as $result_items) {

            $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
            $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_abono+cre_item_abono),base_abono,porcentaje_abono,
							formula_abono,deb_item_abono,cre_item_abono
							FROM item_abono WHERE abono_factura_id=$abono_factura_id AND item_abono_id=$result_items[item_abono_id]";
            $this->DbFetchAll($insert_item, $Conex);
        }
        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {

            $update = "UPDATE abono_factura SET encabezado_registro_id=$encabezado_registro_id,
						estado_abono_factura= 'C',
						con_usuario_id = $usuario_id,
						con_fecha_abono_factura='$con_fecha_abono_factura'
					WHERE abono_factura_id =$abono_factura_id";
            $this->query($update, $Conex);

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);

            } else {
                $this->Commit($Conex);
                return true;
            }
        }
    }

    public function mesContableEstaHabilitado($empresa_id, $oficina_id, $ingreso_abono_factura, $Conex)
    {

        $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND
	                  oficina_id = $oficina_id AND '$ingreso_abono_factura' BETWEEN fecha_inicio AND fecha_final";
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

    public function selectEstadoEncabezadoRegistro($abono_factura_id, $Conex)
    {

        $select = "SELECT estado_abono_factura FROM abono_factura  WHERE abono_factura_id = $abono_factura_id";
        $result = $this->DbFetchAll($select, $Conex);
        $estado = $result[0]['estado_abono_factura'];
        return $estado;

    }

    public function GetQueryPagoGrid()
    {

        $Query = "SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',abono_factura_id,')\">',IF((a.encabezado_registro_id)>0,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id), 'VER'),'</a>') AS consecutivo,
   					a.fecha,
   					a.ingreso_abono_factura,
					(SELECT nombre  FROM tipo_de_documento  WHERE tipo_documento_id=a.tipo_documento_id) AS tipo_doc,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id) AS num_ref,
					(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS cliente FROM tercero WHERE tercero_id=p.tercero_id) AS cliente,
					(SELECT CONCAT_WS(' - ',(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id ),(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id )) AS text FROM cuenta_tipo_pago c WHERE c.cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS forma_pago,
					a.concepto_abono_factura,
					a.valor_abono_factura,
					CASE a.estado_abono_factura  WHEN 'A' THEN 'ACTIVA' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS estado_abono_factura
			FROM abono_factura a, cliente p
		WHERE p.cliente_id=a.cliente_id ORDER BY a.fecha DESC LIMIT 0,500";

        return $Query;
    }
}
