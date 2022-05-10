			<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class CausarModel extends Db
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
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex, true);
    }

    public function selectDatosCausarId($factura_proveedor_id, $Conex)
    {
        $select = "SELECT f.*,
					f.estado_factura_proveedor AS estado,
					(SELECT GROUP_CONCAT(o.consecutivo) as orden FROM detalle_factura_proveedor df, orden_compra o WHERE o.orden_compra_id IN (df.orden_compra_id) AND df.factura_proveedor_id = f.factura_proveedor_id) as orden_compra,
					(SELECT GROUP_CONCAT(orden_compra_id) as orden FROM detalle_factura_proveedor WHERE factura_proveedor_id = f.factura_proveedor_id) as orden_compra_id,
					(SELECT DATEDIFF( f.vence_factura_proveedor, f.fecha_factura_proveedor ) )as dias_vencimiento,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS numero_soporte,
					(SELECT COUNT(*) AS pagos FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id=f.factura_proveedor_id AND a.abono_factura_proveedor_id=r.abono_factura_proveedor_id AND (a.estado_abono_factura='A' OR a.estado_abono_factura='C') ) AS numero_pagos
					FROM factura_proveedor f
					WHERE f.factura_proveedor_id = $factura_proveedor_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;

    }

    public function getCausalesAnulacion($Conex)
    {

        $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

    public function getDataProveedor($orden_compra_id, $Conex)
    {

        $select = "SELECT tr.numero_identificacion AS proveedor_nit,
					p.proveedor_id,
					o.orden_compra_id,
					tr.tercero_id,
					(SELECT tipo_bien_servicio_id FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=o.tipo_bien_servicio_id) AS tipo_bien_servicio_ord,
					(SELECT SUM(valoruni_item_liquida_orden*cant_item_liquida_orden) AS valor FROM item_liquida_orden  WHERE orden_compra_id=o.orden_compra_id) as valor
					FROM proveedor p, tercero tr, orden_compra o
					WHERE o.orden_compra_id = $orden_compra_id AND p.proveedor_id=o.proveedor_id AND tr.tercero_id = p.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }
    public function getDataProveedorOrden($proveedor_id, $Conex)
    {

        $select = "SELECT tr.numero_identificacion AS proveedor_nit,
					p.proveedor_id,
					tr.tercero_id

					FROM proveedor p, tercero tr
					WHERE p.proveedor_id=$proveedor_id AND tr.tercero_id = p.tercero_id";

        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }
    public function getDataTerceManifiesto($liquidacion_despacho_id, $Conex)
    {

        $select = "SELECT tr.numero_identificacion AS proveedor_nit,
					l.numero_despacho AS manifiesto_id,
					l.valor_despacho as valor,
					(SELECT proveedor_id FROM  proveedor WHERE tercero_id=l.tercero_id) AS proveedor_id
					FROM tercero tr, liquidacion_despacho l
					WHERE l.liquidacion_despacho_id = $liquidacion_despacho_id AND  tr.tercero_id = l.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }
    public function getDataTerceDespacho($liquidacion_despacho_id, $Conex)
    {

        $select = "SELECT tr.numero_identificacion AS proveedor_nit,
					l.numero_despacho AS despacho_id,
					l.valor_despacho as valor,
					(SELECT proveedor_id FROM  proveedor WHERE tercero_id=l.tercero_id) AS proveedor_id
					FROM tercero tr, liquidacion_despacho l
					WHERE l.liquidacion_despacho_id = $liquidacion_despacho_id AND tr.tercero_id = l.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }
    public function getDataFactura($factura_proveedor_id, $Conex)
    {

        $select = "SELECT (SELECT GROUP_CONCAT(orden_compra_id) as orden FROM detalle_factura_proveedor WHERE factura_proveedor_id = f.factura_proveedor_id) as orden_compra,
					(SELECT GROUP_CONCAT(orden_compra_id) as orden FROM detalle_factura_proveedor WHERE factura_proveedor_id = f.factura_proveedor_id) as orden_compra_id,
					f.liquidacion_despacho_id,
					f.codfactura_proveedor,
					f.tipo_bien_servicio_id,
					f.proveedor_id,
					f.valor_factura_proveedor as valor,
					f.factura_scan,
					(SELECT t.numero_identificacion FROM  proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND  t.tercero_id=p.tercero_id ) AS proveedor_nit,
					(SELECT tercero_id FROM  proveedor WHERE proveedor_id=f.proveedor_id ) AS tercero_id,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND  t.tercero_id=p.tercero_id ) AS proveedor_nombre,
					(SELECT numero_despacho FROM liquidacion_despacho  WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) as num_referencia
					FROM factura_proveedor f
					WHERE f.factura_proveedor_id = $factura_proveedor_id ";

        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }

    public function getDataProveedornn($proveedor_id, $Conex)
    {

        $select = "SELECT tr.numero_identificacion AS proveedor_nit
					FROM proveedor p, tercero tr
					WHERE p.proveedor_id=$proveedor_id AND tr.tercero_id = p.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }

    public function Save($Campos, $camposArchivo, $Conex)
    {

        $this->Begin($Conex);

        $factura_proveedor_id = $this->DbgetMaxConsecutive("factura_proveedor", "factura_proveedor_id", $Conex, true, 1);
        $numero_soporte = $this->requestDataForQuery('numero_soporte', 'alphanum');
        $fuente_servicio_cod = $this->requestDataForQuery('fuente_servicio_cod', 'alphanum');
        $fecha_factura_proveedor = $this->requestDataForQuery('fecha_factura_proveedor', 'date');
        $vence_factura_proveedor = $this->requestDataForQuery('vence_factura_proveedor', 'date');
        $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
        $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
        $ingreso_factura_proveedor = $this->requestDataForQuery('ingreso_factura_proveedor', 'date');
        $valor = $this->requestDataForQuery('valor', 'numeric');
        $concepto_factura_proveedor = $this->requestDataForQuery('concepto_factura_proveedor', 'text');
        $equivalente				 = $this -> requestDataForQuery('equivalente','integer');
        $parametros_equivalente_id = 'NULL';

        if($equivalente==1){
            $select="SELECT parametros_equivalente_id FROM  parametros_equivalente  WHERE estado='A' AND oficina_id=$oficina_id ";
            $result = $this -> DbFetchAll($select,$Conex,true);
            if($result[0]['parametros_equivalente_id']>0){
                $parametros_equivalente_id=$result[0]['parametros_equivalente_id'];
            }else{
                exit('No se ha configurado un rango para la Resoluci&oacute;n 42 para Documentos equivalentes!');
            }
            
        }

        if (!$valor > 0) {exit("Debe ingresar el valor!!!!");}

        $anticipos_cruzar = $this->requestDataForQuery('anticipos_cruzar', 'numeric');
        $val_anticipos_cruzar = $this->requestDataForQuery('val_anticipos_cruzar', 'numeric');

        $this->assignValRequest('factura_proveedor_id', $factura_proveedor_id);
        $this->assignValRequest('valor_factura_proveedor', $valor);
        
        if ($fuente_servicio_cod == "'OC'") {

            $orden_compra_id = $this->requestDataForQuery('orden_compra_id', 'text');
            $codfactura_proveedor = $this->requestDataForQuery('codfactura_proveedor', 'integer');
            $tipo_bien_servicio_ord = $this->requestDataForQuery('tipo_bien_servicio_ord', 'integer');

            $item_fr = explode(',', $orden_compra_id);
            $proveedor_id = $this->requestDataForQuery('proveedor_id', 'integer');

            $this->assignValRequest('proveedor_id', $proveedor_id);
            //$this -> assignValRequest('codfactura_proveedor',$codfactura_proveedor);
            $this->assignValRequest('tipo_bien_servicio_id', $tipo_bien_servicio_ord);

            //Se agrega el bloque de insert into de logitransporte debido a que hacen falta campos como parametros equivalente, revisar con bryan
            //$this->DbInsertTable("factura_proveedor", $Campos, $Conex, true, false);

            $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,orden_compra_id,codfactura_proveedor,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,tipo_bien_servicio_id,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor,equivalente,parametros_equivalente_id) 
						VALUES ($factura_proveedor_id,$orden_compra_id,'$codfactura_proveedor',$valor,$fecha_factura_proveedor,$vence_factura_proveedor,$concepto_factura_proveedor,$proveedor_id,$fuente_servicio_cod,$tipo_bien_servicio_ord,'A',$usuario_id,$oficina_id,$ingreso_factura_proveedor,$equivalente,$parametros_equivalente_id)"; 
            $this->query($insert, $Conex, true);
            for ($i = 0; $i < count($item_fr); $i++) {
                $orden_compra_tmp = str_replace("'", "", $item_fr[$i]);
                $detalle_factura_proveedor_id = $this->DbgetMaxConsecutive("detalle_factura_proveedor", "detalle_factura_proveedor_id", $Conex, true, 1);
                $insert = "INSERT INTO detalle_factura_proveedor (detalle_factura_proveedor_id,factura_proveedor_id,orden_compra_id,descripcion,valor)
										VALUES
										($detalle_factura_proveedor_id,$factura_proveedor_id,$orden_compra_tmp,(SELECT descrip_orden_compra FROM orden_compra WHERE orden_compra_id=$orden_compra_tmp),(SELECT SUM(valoruni_item_liquida_orden*cant_item_liquida_orden) AS valor FROM item_liquida_orden  WHERE orden_compra_id=$orden_compra_tmp))";
                $this->query($insert, $Conex, true);

            }

        } elseif ($fuente_servicio_cod == "'MC'") {
            $liquidacion_despacho_id = $this->requestDataForQuery('liquidacion_despacho_id', 'integer');

            $select = "SELECT l.tercero_id,
									(SELECT proveedor_id FROM proveedor WHERE tercero_id=l.tercero_id) AS proveedor_id
									FROM liquidacion_despacho l
									WHERE l.liquidacion_despacho_id=$liquidacion_despacho_id";
            $result = $this->DbFetchAll($select, $Conex, false);

            if ($result[0]['proveedor_id'] != 0 && $result[0]['proveedor_id'] != '' && $result[0]['proveedor_id'] != null) {
                $proveedor_id = $result[0]['proveedor_id'];
                // $this->assignValRequest('proveedor_id', $proveedor_id);

                //Se agrega el bloque de insert into de logitransporte debido a que hacen falta campos como parametros equivalente, revisar con bryan
                //$this->DbInsertTable("factura_proveedor", $Campos, $Conex, true, false);

                $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,liquidacion_despacho_id,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor,equivalente,parametros_equivalente_id) 
								VALUES ($factura_proveedor_id,$liquidacion_despacho_id,$valor,$fecha_factura_proveedor,$vence_factura_proveedor,$concepto_factura_proveedor,$proveedor_id,$fuente_servicio_cod,'A',$usuario_id,$oficina_id,$ingreso_factura_proveedor,$equivalente,$parametros_equivalente_id)"; 
                $this->query($insert, $Conex, true);
            }

        } elseif ($fuente_servicio_cod == "'DU'") {

            $liquidacion_despacho_id = $this->requestDataForQuery('liquidacion_despacho_id', 'integer');

            $select = "SELECT l.tercero_id,
										(SELECT proveedor_id FROM proveedor WHERE tercero_id=l.tercero_id) AS proveedor_id
										FROM liquidacion_despacho l
										WHERE l.liquidacion_despacho_id=$liquidacion_despacho_id";
            $result = $this->DbFetchAll($select, $Conex, false);

            if ($result[0]['proveedor_id'] != 0 && $result[0]['proveedor_id'] != '' && $result[0]['proveedor_id'] != null) {
                $proveedor_id = $result[0]['proveedor_id'];
                // $this->assignValRequest('proveedor_id', $proveedor_id);
                //Se agrega el bloque de insert into de logitransporte debido a que hacen falta campos como parametros equivalente, revisar con bryan
                // $this->DbInsertTable("factura_proveedor", $Campos, $Conex, true, false);

                $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,liquidacion_despacho_id,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor,equivalente,parametros_equivalente_id) 
								VALUES ($factura_proveedor_id,$liquidacion_despacho_id,$valor,$fecha_factura_proveedor,$vence_factura_proveedor,$concepto_factura_proveedor,$proveedor_id,$fuente_servicio_cod,'A',$usuario_id,$oficina_id,$ingreso_factura_proveedor,$equivalente,$parametros_equivalente_id)"; 
                $this->query($insert, $Conex, true);
            }

        } elseif ($fuente_servicio_cod == "'NN'") {

            $proveedor_id = $this->requestDataForQuery('proveedor_id', 'integer');
            $tipo_bien_servicio_nn = $this->requestDataForQuery('tipo_bien_servicio_nn', 'integer');
            $codfactura_proveedornn = $this->requestDataForQuery('codfactura_proveedornn', 'integer');
            //$valor                    = $this -> requestDataForQuery('valor','numeric');

            //Se agrega el bloque de insert into de logitransporte debido a que hacen falta campos como parametros equivalente, revisar con bryan
            /* $this->assignValRequest('proveedor_id', $proveedor_id);
            $this->assignValRequest('tipo_bien_servicio_id', $tipo_bien_servicio_nn);
            $this->assignValRequest('codfactura_proveedor', $codfactura_proveedornn); */

            // $this->DbInsertTable("factura_proveedor", $Campos, $Conex, true, false);

            $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,codfactura_proveedor,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,tipo_bien_servicio_id,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor,equivalente,parametros_equivalente_id) 
					VALUES ($factura_proveedor_id,'$codfactura_proveedornn',$valor,$fecha_factura_proveedor,$vence_factura_proveedor,$concepto_factura_proveedor,$proveedor_id,$fuente_servicio_cod,$tipo_bien_servicio_nn,'A',$usuario_id,$oficina_id,$ingreso_factura_proveedor,$equivalente,$parametros_equivalente_id)"; 
            $this->query($insert, $Conex, true);
        }

        if ($fuente_servicio_cod == "'MC'" || $fuente_servicio_cod == "'OC'" || $fuente_servicio_cod == "'DU'" || $fuente_servicio_cod == "'NN'") {
            /* $this -> query($insert,$Conex,true);
            $this -> assignValRequest('factura_proveedor_id',$factura_proveedor_id);*/

            if (!strlen(trim($this->GetError())) > 0) {

                if ($fuente_servicio_cod == "'OC'") {

                    $update = "UPDATE orden_compra  SET estado_orden_compra='C'
					 		WHERE   orden_compra_id = $orden_compra_id";
                    $this->query($update, $Conex, true);

                } elseif ($fuente_servicio_cod == "'MC'") {
                    $update = "UPDATE liquidacion_despacho  SET estado_liquidacion='C'
					 		WHERE   liquidacion_despacho_id = $liquidacion_despacho_id";
                    $this->query($update, $Conex, true);

                } elseif ($fuente_servicio_cod == "'DU'") {
                    $update = "UPDATE liquidacion_despacho  SET estado_liquidacion='C'
					 		WHERE   liquidacion_despacho_id = $liquidacion_despacho_id";
                    $this->query($update, $Conex, true);
                }

                /**************************************************
                 **************************************************
                 **************CUANDO SE CARGA ARCHIVO*************
                 **************************************************
                 ***************************************************/

                if (count($camposArchivo) > 0) {

                    include_once "UtilidadesContablesModelClass.php";

                    $utilidadesContables = new UtilidadesContablesModel();

                    foreach ($camposArchivo as $valor) {

                        if (is_numeric($valor[0]) && ($valor[4] > 0 || $valor[5] > 0)) {

                            $tercero_id = '';
                            $numero_identificacion = '';
                            $digito_verificacion = '';

                            $select = "SELECT puc_id FROM puc WHERE codigo_puc='$valor[0]'";
                            $result = $this->DbFetchAll($select, $Conex, true);
                            $puc_id = $result[0]['puc_id'];
                            if ($puc_id == '' && $valor[0] > 0) {
                                exit('EL codigo contable ' . $valor[0] . ', No se encuentra parametrizado');
                            }

                            $select1 = "SELECT tercero_id FROM tercero WHERE numero_identificacion=$valor[1]";
                            $result1 = $this->DbFetchAll($select1, $Conex, true);
                            $tercero_id = $result1[0]['tercero_id'];

                            if ($tercero_id == '' && $valor[1] != '') {
                                exit('EL Tercero ' . $valor[1] . ', No se encuentra en el sistema');
                            }

                            //echo $tercero_id.'-';
                            //$select2 = "SELECT centro_de_costo_id, codigo  FROM centro_de_costo WHERE CAST( codigo AS SIGNED )='".intval($valor[4])."'";

                            $select2 = "SELECT centro_de_costo_id, codigo  FROM centro_de_costo WHERE codigo='" . $valor[4] . "'";
                            $result2 = $this->DbFetchAll($select2, $Conex, true);
                            $centro_de_costo_id = $result2[0]['centro_de_costo_id'];
                            $codigo_centro_costo = "'" . $result2[0]['codigo'] . "'";

                            if ($centro_de_costo_id == '' && $valor[4] != '') {
                                exit('EL Centro de Costo ' . $valor[4] . ', No se encuentra en el sistema');
                            }

                            if (!$utilidadesContables->requiereTercero($puc_id, $Conex)) {
                                $tercero_id = 'NULL';
                                $numero_identificacion = 'NULL';
                                $digito_verificacion = 'NULL';
                            } else {

                                if (is_numeric($tercero_id)) {

                                    $numero_identificacion = $utilidadesContables->getNumeroIdentificacionTercero($tercero_id, $Conex);
                                    $digito_verificacion = $utilidadesContables->getDigitoVerificacionTercero($tercero_id, $Conex);

                                    if (!is_numeric($digito_verificacion)) {
                                        $digito_verificacion = 'NULL';
                                    }

                                }

                            }

                            if (!$utilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                                $centro_de_costo_id = 'NULL';
                                $codigo_centro_costo = 'NULL';
                            }

                            if ($valor[5] != '') {
                                $debito = $valor[5];
                            } else {
                                $debito = 0;
                            }

                            if ($valor[6] != '') {
                                $credito = $valor[6];
                            } else {
                                $credito = 0;
                            }

                            if ($valor[7] != '') {
                                $select2 = "SELECT area_id  FROM area WHERE codigo ='" . $valor[7] . "'";
                                $result2 = $this->DbFetchAll($select2, $Conex, true);
                                $area_id = $result2[0]['area_id'];
                                if ($area_id == '' && $valor[7] != '') {
                                    exit('EL Area ' . $valor[7] . ', No se encuentra en el sistema');
                                }

                            } else {
                                $area_id = 'NULL'; //aca
                            }
                            if ($valor[8] != '') {
                                $select2 = "SELECT departamento_id  FROM departamento WHERE codigo ='" . $valor[8] . "'";
                                $result2 = $this->DbFetchAll($select2, $Conex, true);
                                $departamento_id = $result2[0]['departamento_id'];
                                if ($departamento_id == '' && $valor[8] != '') {
                                    exit('EL Departamento ' . $valor[8] . ', No se encuentra en el sistema');
                                }

                            } else {
                                $departamento_id = 'NULL'; //aca
                            }
                            if ($valor[9] != '') {
                                $select2 = "SELECT unidad_negocio_id  FROM unidad_negocio WHERE codigo ='" . $valor[9] . "'";
                                $result2 = $this->DbFetchAll($select2, $Conex, true);
                                $unidad_negocio_id = $result2[0]['unidad_negocio_id'];
                                if ($unidad_negocio_id == '' && $valor[9] != '') {
                                    exit('La unidad  ' . $valor[9] . ', No se encuentra en el sistema');
                                }

                            } else {
                                $unidad_negocio_id = 'NULL';
                            }
                            if ($valor[10] != '') {
                                $select2 = "SELECT oficina_id  FROM oficina WHERE codigo_centro ='" . $valor[10] . "'";
                                $result2 = $this->DbFetchAll($select2, $Conex, true);
                                $sucursal_id = $result2[0]['oficina_id'];
                                if ($sucursal_id == '' && $valor[10] != '') {
                                    exit('La Sucursal  ' . $valor[10] . ', No se encuentra en el sistema');
                                }

                            } else {
                                $sucursal_id = 'NULL';
                            }

                            //echo $tercero_id.'<br>';
                            $item_factura_proveedor_id = $this->DbgetMaxConsecutive("item_factura_proveedor", "item_factura_proveedor_id", $Conex, true, 1);
                            $insert = "INSERT INTO item_factura_proveedor (item_factura_proveedor_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,factura_proveedor_id,centro_de_costo_id,codigo_centro_costo,deb_item_factura_proveedor,cre_item_factura_proveedor,area_id,departamento_id,unidad_negocio_id,sucursal_id,contra_factura_proveedor)
							VALUES ($item_factura_proveedor_id,
							$tercero_id,
							$numero_identificacion,
							$digito_verificacion,
							$puc_id,
							'" . trim($valor[3]) . "',
							$factura_proveedor_id,
							$centro_de_costo_id,
							$codigo_centro_costo,

							'$debito',
							'$credito',
							$area_id,
							$departamento_id,
							$unidad_negocio_id,
							$sucursal_id,
							" . trim($valor[6]) . "
						);";
                            $this->query($insert, $Conex, true);

                            if ($this->GetNumError() > 0) {
                                $this->Rollback($Conex);
                                exit($this->GetError() . " Error");
                            }

                        }

                    }
                }

                $this->Commit($Conex);
                return $factura_proveedor_id;
            }
        } else {
            exit('Fuente de Servicio Incorrecta, Por favor verifique');
        }
    }

    public function Update($Campos, $Conex)
    {
        $this->Begin($Conex);

        if ($_REQUEST['factura_proveedor_id'] != 'NULL') {

            $factura_proveedor_id = $this->requestDataForQuery('factura_proveedor_id', 'integer');
            $fuente_servicio_cod = $this->requestDataForQuery('fuente_servicio_cod', 'alphanum');
            $fecha_factura_proveedor = $this->requestDataForQuery('fecha_factura_proveedor', 'date');
            $vence_factura_proveedor = $this->requestDataForQuery('vence_factura_proveedor', 'date');
            $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
            $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
            $ingreso_factura_proveedor = $this->requestDataForQuery('ingreso_factura_proveedor', 'date');
            $concepto_factura_proveedor = $this->requestDataForQuery('concepto_factura_proveedor', 'text');
            $proveedor_id = $this->requestDataForQuery('proveedor_id', 'integer');
            $tipo_bien_servicio_ord = $this->requestDataForQuery('tipo_bien_servicio_id', 'integer');
            $anticipos_cruzar = $this->requestDataForQuery('anticipos_cruzar', 'text');

            $valor = $this->requestDataForQuery('valor', 'numeric');

            $select_estado = "SELECT estado_factura_proveedor FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
            $result_estado = $this->DbFetchAll($select_estado, $Conex, true);

            $estado = $result_estado[0]['estado_factura_proveedor'];

            if ($estado == 'A') {

                $this->assignValRequest('valor_factura_proveedor', $valor);

                if ($fuente_servicio_cod == "'OC'") {

                    $select = "SELECT GROUP_CONCAT(orden_compra_id) as orden FROM detalle_factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id";
                    $result = $this->DbFetchAll($select, $Conex, true);

                    $orden = $result[0]['orden'];

                    $update = "UPDATE orden_compra  SET estado_orden_compra='L'
				WHERE   orden_compra_id IN($orden)";
                    $this->DbFetchAll($update, $Conex, true);

                    $query = "DELETE FROM detalle_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
                    $this->query($query, $Conex, true);

                    $query = "DELETE FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
                    $this->query($query, $Conex, true);

                    $orden_compra_id = $this->requestDataForQuery('orden_compra_id', 'text');
                    $codfactura_proveedor = $this->requestDataForQuery('codfactura_proveedor', 'integer');
                    $tipo_bien_servicio_ord = $this->requestDataForQuery('tipo_bien_servicio_ord', 'integer');

                    $item_fr = explode(',', $orden_compra_id);
                    $proveedor_id = $this->requestDataForQuery('proveedor_id', 'integer');

                    for ($i = 0; $i < count($item_fr); $i++) {
                        $orden_compra_tmp = str_replace("'", "", $item_fr[$i]);
                        $detalle_factura_proveedor_id = $this->DbgetMaxConsecutive("detalle_factura_proveedor", "detalle_factura_proveedor_id", $Conex, true, 1);
                        $insert = "INSERT INTO detalle_factura_proveedor (detalle_factura_proveedor_id,factura_proveedor_id,orden_compra_id,descripcion,valor)
					VALUES
					($detalle_factura_proveedor_id,$factura_proveedor_id,$orden_compra_tmp,(SELECT descrip_orden_compra FROM orden_compra WHERE orden_compra_id=$orden_compra_tmp),(SELECT SUM(valoruni_item_liquida_orden*cant_item_liquida_orden) AS valor FROM item_liquida_orden  WHERE orden_compra_id=$orden_compra_tmp))";
                        $this->query($insert, $Conex, true);

                    }

                    $this->assignValRequest('tipo_bien_servicio_id', $tipo_bien_servicio_ord);
                }

                $this->assignValRequest('proveedor_id', $proveedor_id);

                /*$this -> assignValRequest('fecha_factura_proveedor',$fecha_factura_proveedor);
                $this -> assignValRequest('vence_factura_proveedor',$vence_factura_proveedor);
                 */
                $this->assignValRequest('anticipos_cruzar', $anticipos_cruzar);

                if ($fuente_servicio_cod == "'NN'") {
                    $codfactura_proveedornn = $this->requestDataForQuery('codfactura_proveedornn', 'integer');
                    $tipo_bien_servicio_nn = $this->requestDataForQuery('tipo_bien_servicio_nn', 'integer');
                    $this->assignValRequest('codfactura_proveedor', $codfactura_proveedornn);
                    $this->assignValRequest('tipo_bien_servicio_id', $tipo_bien_servicio_nn);

                } else {

                    $this->assignValRequest('codfactura_proveedor', $codfactura_proveedor);
                }

                /*if($fuente_servicio_cod=="'OC'"){

                $codfactura_proveedor     = $this -> requestDataForQuery('codfactura_proveedor','alphanum');

                $update = "UPDATE factura_proveedor SET      codfactura_proveedor=$codfactura_proveedor,
                fecha_factura_proveedor=$fecha_factura_proveedor,
                vence_factura_proveedor=$vence_factura_proveedor,
                concepto_factura_proveedor=$concepto_factura_proveedor
                WHERE factura_proveedor_id=$factura_proveedor_id";

                }elseif($fuente_servicio_cod=="'MC'"){

                $update = "UPDATE factura_proveedor SET      fecha_factura_proveedor=$fecha_factura_proveedor,
                vence_factura_proveedor=$vence_factura_proveedor,
                concepto_factura_proveedor=$concepto_factura_proveedor
                WHERE factura_proveedor_id=$factura_proveedor_id";
                $this -> DbInsertTable("factura_proveedor",$Campos,$Conex,true,false);

                }elseif($fuente_servicio_cod=="'DU'"){

                $update = "UPDATE factura_proveedor SET      fecha_factura_proveedor=$fecha_factura_proveedor,
                vence_factura_proveedor=$vence_factura_proveedor,
                concepto_factura_proveedor=$concepto_factura_proveedor
                WHERE factura_proveedor_id=$factura_proveedor_id";

                }elseif($fuente_servicio_cod=="'NN'"){

                $update = "UPDATE factura_proveedor SET      fecha_factura_proveedor=$fecha_factura_proveedor,
                vence_factura_proveedor=$vence_factura_proveedor,
                concepto_factura_proveedor=$concepto_factura_proveedor
                WHERE factura_proveedor_id=$factura_proveedor_id";

                }*/
                $this->DbUpdateTable("factura_proveedor", $Campos, $Conex, true, false);
                //$this -> query($update,$Conex,true);
            } else {
                $update = "UPDATE factura_proveedor SET
								vence_factura_proveedor=$vence_factura_proveedor,
								fecha_factura_proveedor=$fecha_factura_proveedor

								WHERE factura_proveedor_id=$factura_proveedor_id";
                $this->query($update, $Conex, true);
            }
            if (!strlen(trim($this->GetError())) > 0) {
                $this->Commit($Conex);
            }
        }

    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "factura_proveedor", $Campos);
        return $Data->GetData();
    }

    public function cancellation($Conex)
    {

        $this->Begin($Conex);

        $factura_proveedor_id = $this->requestDataForQuery('factura_proveedor_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $anul_factura_proveedor = $this->requestDataForQuery('anul_factura_proveedor', 'text');
        $desc_anul_factura_proveedor = $this->requestDataForQuery('desc_anul_factura_proveedor', 'text');
        $anul_usuario_id = $this->requestDataForQuery('anul_usuario_id', 'integer');

        $select = "SELECT fuente_servicio_cod,orden_compra_id,liquidacion_despacho_id, liquidacion_despacho_sobre_id, encabezado_registro_id,
						(SELECT GROUP_CONCAT(orden_compra_id) as orden FROM detalle_factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id) as orden_compra
						FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        $fuente = $result[0]['fuente_servicio_cod'];
        $orden = $result[0]['orden_compra'];
        $liquida = $result[0]['liquidacion_despacho_id'];
        $liquida_sobre = $result[0]['liquidacion_despacho_sobre_id'];
        $encabezado_registro_id = $result[0]['encabezado_registro_id'];

        if ($fuente == 'OC') {
            $update = "UPDATE orden_compra  SET estado_orden_compra='L'
							WHERE   orden_compra_id IN($orden)";
            $this->DbFetchAll($update, $Conex, true);

        } elseif ($fuente == 'MC') {

            if($liquida > 0){
                $update = "UPDATE liquidacion_despacho  SET estado_liquidacion='L'
                            WHERE   liquidacion_despacho_id = $liquida";
            }
            if($liquida_sobre>0){
                $update = "UPDATE liquidacion_despacho_sobre  SET estado_liquidacion='L'
                            WHERE   liquidacion_despacho_sobre_id = $liquida_sobre";
            }
            
            $this->DbFetchAll($update, $Conex, true);

        } elseif ($fuente == 'DU') {
            $update = "UPDATE liquidacion_despacho  SET estado_liquidacion='L'
							WHERE   liquidacion_despacho_id = $liquida";
            $this->DbFetchAll($update, $Conex, true);

        }

        if ($encabezado_registro_id > 0) {
            $select1 = "SELECT encabezado_registro_id FROM encabezado_de_registro_anulado WHERE encabezado_registro_id=$encabezado_registro_id";
            $result1 = $this->DbFetchAll($select1, $Conex, true);
        }

        if ($encabezado_registro_id > 0 && $encabezado_registro_id != '' && $encabezado_registro_id != null && !$result1[0]['encabezado_registro_id'] > 0) {

            $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS
							encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
							forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
							fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
							$desc_anul_factura_proveedor AS observaciones,usuario_anula,fecha_anulacion,usuario_actualiza,fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";

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

        $update = "UPDATE factura_proveedor SET estado_factura_proveedor= 'I',
						causal_anulacion_id = $causal_anulacion_id,
						anul_factura_proveedor=$anul_factura_proveedor,
						desc_anul_factura_proveedor =$desc_anul_factura_proveedor,
						anul_usuario_id=$anul_usuario_id
						WHERE factura_proveedor_id=$factura_proveedor_id";
        $this->query($update, $Conex, true);

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {
            $this->Commit($Conex);
        }
    }

    public function getTotalDebitoCredito($factura_proveedor_id, $Conex)
    {

        $select = "SELECT SUM(deb_item_factura_proveedor) AS debito,SUM(cre_item_factura_proveedor) AS credito FROM item_factura_proveedor  WHERE factura_proveedor_id=$factura_proveedor_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getContabilizarReg($factura_proveedor_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $Conex)
    {

        include_once "UtilidadesContablesModelClass.php";

        $utilidadesContables = new UtilidadesContablesModel();

        $this->Begin($Conex);

        $select = "SELECT f.factura_proveedor_id,
						f.fuente_servicio_cod,
						f.tipo_bien_servicio_id,
						f.valor_factura_proveedor,
						f.orden_compra_id,
						f.codfactura_proveedor,
						f.fecha_factura_proveedor,
						f.concepto_factura_proveedor,
                        f.equivalente,
                        f.parametros_equivalente_id,
						f.liquidacion_despacho_id,
						CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra No ' WHEN 'MC' THEN 'Manifiesto de Carga No ' ELSE 'Despacho Urbano No ' END AS tipo_soporte,
						(SELECT numero_despacho FROM  liquidacion_despacho  WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS numero_soporte_ord,
						(SELECT tercero_id  FROM  proveedor WHERE proveedor_id=f.proveedor_id) AS tercero,

						(SELECT puc_id  FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id=(SELECT tipo_bien_servicio_id FROM orden_compra WHERE orden_compra_id =(SELECT orden_compra_id FROM detalle_factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id LIMIT 0,1)) AND contra_bien_servicio=1) AS puc_contra,
                        (SELECT e.tipo_documento_id FROM parametros_equivalente e WHERE e.parametros_equivalente_id=f.parametros_equivalente_id ) AS tipo_documento_equiva,
					    (SELECT e.rango_inicial FROM parametros_equivalente e WHERE e.parametros_equivalente_id=f.parametros_equivalente_id ) AS rango_ini,						  
						(SELECT e.rango_final FROM parametros_equivalente e WHERE e.parametros_equivalente_id=f.parametros_equivalente_id ) AS rango_final,

						IF(f.fuente_servicio_cod = 'OC',(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id = (SELECT tipo_bien_servicio_id FROM orden_compra WHERE orden_compra_id =(SELECT orden_compra_id FROM detalle_factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id LIMIT 0,1))),IF(f.fuente_servicio_cod = 'NN',(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),(SELECT tipo_documento_id  FROM liquidacion_despacho WHERE liquidacion_despacho_id =f.liquidacion_despacho_id ))) AS tipo_documento

						FROM factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
        $result_usu = $this->DbFetchAll($select_usu, $Conex, true);

        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);
        $tipo_documento_id		= $result[0]['equivalente']==1 ? $result[0]['tipo_documento_equiva'] : $result[0]['tipo_documento'];
        $valor = $result[0]['valor_factura_proveedor'];
        $numero_soporte = $result[0]['codfactura_proveedor'] != '' ? $result[0]['codfactura_proveedor'] : $result[0]['numero_soporte_ord'];
        $tercero_id = $result[0]['tercero'];

        $fechaMes = substr($result[0]['fecha_factura_proveedor'], 0, 10);
        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex, true);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex, true);
        $consecutivo = $utilidadesContables->getConsecutivo($oficina_id, $tipo_documento_id, $periodo_contable_id, $Conex, true);

        if($result[0]['equivalente']==1 && $result[0]['rango_ini']>$consecutivo && $consecutivo==1){
			$consecutivo = $result[0]['rango_ini'];
			
		}elseif($result[0]['equivalente']==1  && $result[0]['rango_final']<$consecutivo){
			exit('El consecutivo a Superado el Rango Final');	
		}elseif($result[0]['equivalente']==1  && $result[0]['rango_ini']>$consecutivo){
			exit('El consecutivo no esta dentro del Parametro de la Resoluci&oacute;n de documentos Equivalentes');	
			
		}

        $fecha = $result[0]['fecha_factura_proveedor'];
        $concepto = $result[0]['concepto_factura_proveedor'];
        $puc_id = $result[0]['puc_contra'] != '' ? $result[0]['puc_contra'] : 'NULL';
        $fecha_registro = date("Y-m-d H:m");
        $modifica = $result_usu[0]['usuario'];
        $fuente_servicio_cod = $result[0]['fuente_servicio_cod'];
        $numero_documento_fuente = $numero_soporte;
        $id_documento_fuente = $result[0]['factura_proveedor_id'];
        $liquidacion_despacho_id = $result[0]['liquidacion_despacho_id'];
        $con_fecha_factura_prov = $fecha_registro;

        $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
						mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
						VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
						$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)";
        $this->query($insert, $Conex, true);
        //echo $insert;

        $select_contra = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND contra_factura_proveedor=1";
        $result_contra = $this->DbFetchAll($select_contra, $Conex, true);

        if (!count($result_contra) > 0) {exit("No Ha seleccionado una contrapartida!!!");}

        $select_item = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
        $result_item = $this->DbFetchAll($select_item, $Conex, true);
        foreach ($result_item as $result_items) {
            $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
            $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
							formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,area_id,departamento_id,unidad_negocio_id,sucursal_id
							FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]";
            $this->query($insert_item, $Conex, true);
        }

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {

            $update = "UPDATE factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,
							estado_factura_proveedor= 'C',
							con_usuario_id = $usuario_id,
							con_fecha_factura_proveedor='$con_fecha_factura_prov'
							WHERE factura_proveedor_id=$factura_proveedor_id";
            $this->query($update, $Conex, true);
            if ($liquidacion_despacho_id > 0) {
                $update = "UPDATE liquidacion_despacho SET encabezado_registro_id=$encabezado_registro_id
								WHERE  liquidacion_despacho_id=$liquidacion_despacho_id";
                $this->query($update, $Conex, true);
            }
            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);

            } else {
                $this->Commit($Conex);
                return true;
            }
        }
    }

    public function mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha_factura_proveedor, $Conex)
    {

        $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND
						oficina_id = $oficina_id AND '$fecha_factura_proveedor' BETWEEN fecha_inicio AND fecha_final";
        $result = $this->DbFetchAll($select, $Conex, true);

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
            $result = $this->DbFetchAll($select, $Conex, true);

            return $result[0]['estado'] == 1 ? true : false;
        }

    }

    public function selectEstadoEncabezadoRegistro($factura_proveedor_id, $Conex)
    {

        $select = "SELECT estado_factura_proveedor FROM factura_proveedor  WHERE factura_proveedor_id = $factura_proveedor_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        $estado = $result[0]['estado_factura_proveedor'];

        return $estado;

    }

    public function GetFuente($Conex)
    {
        return $this->DbFetchAll("SELECT fuente_servicio_cod AS value,fuente_servicio_nom AS text FROM fuente_servicio", $Conex,
            $ErrDb = false);
    }

    public function GetServinn($Conex)
    {
        return $this->DbFetchAll("SELECT t.tipo_bien_servicio_id AS value,CONCAT_WS('-',t.codigo_tipo_servicio,t.nombre_bien_servicio) AS text FROM tipo_bien_servicio t
							WHERE t.fuente_servicio_cod IN('NN','OC') AND (((SELECT COUNT( * ) FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id = t.tipo_bien_servicio_id AND contra_bien_servicio =1) =1
							AND (SELECT COUNT( * ) FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id = t.tipo_bien_servicio_id ) >=1 )
							OR (SELECT COUNT( * ) FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id = t.tipo_bien_servicio_id) =0) ORDER BY text asc", $Conex, $ErrDb = false);
    }

    public function GetQueryCausarGrid()
    {

        $Query = "SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',factura_proveedor_id,')\">',IF((f.encabezado_registro_id)>0,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = f.encabezado_registro_id), 'VER'),'</a>') AS consecutivo,
						f.ingreso_factura_proveedor,
						f.orden_compra_id,
						f.codfactura_proveedor,
						(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS num_ref,
						(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS proveedor FROM tercero WHERE tercero_id=p.tercero_id) AS proveedor,
						(SELECT fuente_servicio_nom FROM fuente_servicio WHERE fuente_servicio_cod=f.fuente_servicio_cod) AS fuente_nombre,
						(SELECT codigo FROM tipo_de_documento WHERE tipo_documento_id = (SELECT tipo_documento_id FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id)) as tipo_documento,
						(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id) AS tipo_servicio,
						f.fecha_factura_proveedor,
						f.vence_factura_proveedor,
                        IF(f.equivalente=1,'SI','NO') AS equivalente, 
						CASE f.estado_factura_proveedor WHEN 'A' THEN 'CAUSADA' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS estado_factura_proveedor
						FROM factura_proveedor f, proveedor p
						WHERE p.proveedor_id=f.proveedor_id ORDER BY f.fecha_factura_proveedor DESC LIMIT 0,2000 ";

        return $Query;
    }
}

?>