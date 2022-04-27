<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class OrdenModel extends Db
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

    public function selectDatosOrdenId($orden_servicio_id, $Conex)
    {
        $select = "SELECT
	 				o.orden_servicio_id,
					o.consecutivo,
					o.fecha_orden_servicio,
					o.centro_de_costo_id,
					o.cliente_id,
					CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) AS cliente,
					t.telefono AS cliente_tele,
					t.direccion AS cliente_direccion,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cliente_ciudad,
					p.contac_cliente_factura AS cliente_contacto,
					t.email AS cliente_correo,
					b.nombre_bien_servicio_factura AS tiposervicio,
					b.tipo_bien_servicio_factura_id AS tipo_bien_servicio_factura_id,
					o.descrip_orden_servicio,
					o.forma_compra_venta_id ,
					o.estado_orden_servicio,
					o.usuario_id,
					o.ingreso_orden_servicio,
					o.oficina_id
					FROM orden_servicio o, cliente p, tercero t,  tipo_bien_servicio_factura b
					WHERE o.orden_servicio_id = $orden_servicio_id AND p.cliente_id=o.cliente_id AND t.tercero_id=p.tercero_id AND b.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function liquidar($empresa_id, $oficina_id, $Conex)
    {

        $this->Begin($Conex);

        $orden_servicio_id = $this->requestDataForQuery('orden_servicio_id', 'integer');
        $liq_usuario_id = $this->requestDataForQuery('liq_usuario_id', 'integer');
        $fec_liq_orden_servicio = $this->requestDataForQuery('fec_liq_orden_servicio', 'text');
        $descrip_liq_orden_servicio = $this->requestDataForQuery('descrip_liq_orden_servicio', 'text');

        $select = "SELECT COUNT(*) AS movimientos FROM  item_liquida_servicio WHERE orden_servicio_id=$orden_servicio_id";
        $result = $this->DbFetchAll($select, $Conex);
        $movimientos = $result[0]['movimientos'];

        if ($movimientos == 0) {
            $select_cic = "SELECT item_orden_servicio_id FROM item_orden_servicio WHERE orden_servicio_id=$orden_servicio_id";
            $result_cic = $this->DbFetchAll($select_cic, $Conex);
            foreach ($result_cic as $item_id) {
                $item_liquida_servicio_id = $this->DbgetMaxConsecutive("item_liquida_servicio", "item_liquida_servicio_id", $Conex, true, 1);

                $insert = "INSERT INTO item_liquida_servicio (item_liquida_servicio_id,orden_servicio_id,cant_item_liquida_servicio,desc_item_liquida_servicio,valoruni_item_liquida_servicio,fecha_item_liquida,usuario_id)
					SELECT $item_liquida_servicio_id,orden_servicio_id,cant_item_orden_servicio,desc_item_orden_servicio,valoruni_item_orden_servicio,fecha_item_servicio,usuario_id  FROM item_orden_servicio WHERE item_orden_servicio_id=$item_id[item_orden_servicio_id]";
                $this->DbFetchAll($insert, $Conex);
            }
		}
		
		//Dejar remesas en estado facturado
		$update_remesas_os = "UPDATE 
			remesa
		SET
			estado = 'FT'
		WHERE
			remesa_id IN (SELECT remesa_id FROM item_liquida_servicio WHERE orden_servicio_id = $orden_servicio_id)";
		$this->query($update_remesas_os,$Conex,true);
		

        $total_pagar = 0;
        $parcial = '';
        $select = "SELECT  c.despuc_bien_servicio_factura,
				c.natu_bien_servicio_factura,
				c.contra_bien_servicio_factura,
				c.puc_id,
				(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
				(SELECT autoret_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS autorete,
				(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS retei,
				(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS renta,
				(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
				(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
				(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,
				(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
				(SELECT SUM(valoruni_item_liquida_servicio*cant_item_liquida_servicio) AS total FROM  item_liquida_servicio WHERE orden_servicio_id=o.orden_servicio_id) AS total
				FROM codpuc_bien_servicio_factura  c, orden_servicio o
				WHERE o.orden_servicio_id = $orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";

        $result = $this->DbFetchAll($select, $Conex);

        foreach ($result as $resultado) {
            $debito = '';
            $credito = '';
            $ingresa = 0;
            if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1) {
                $ingresa = 1;
                $parcial = $resultado[total];
                $base = '';
                $porcentaje = '';
                $formula = '';

            } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[monto] <= $resultado[total] && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {
                $ingresa = 1;
                $base = $resultado[total];
                $formula = $resultado[formula];
                $porcentaje = $resultado[porcentaje];
                $calculo = str_replace("BASE", $base, $formula);
                $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                $select1 = "SELECT $calculo AS valor_total";
                $result1 = $this->DbFetchAll($select1, $Conex);
                $parcial = $result1[0]['valor_total'];

            } elseif ($resultado[contra_bien_servicio_factura] == 1) {
                $ingresa = 1;
                $parcial = $total_pagar;
                $base = '';
                $porcentaje = '';
                $formula = '';
            }
            $descripcion = $resultado[puc_nombre];
            if ($ingresa == 1) {
                if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                    $total_pagar = $total_pagar - $parcial;
                    $debito = number_format($parcial, 0, '.', '');
                    $credito = '0.00';

                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                    $total_pagar = $total_pagar + $parcial;
                    $debito = '0.00';
                    $credito = number_format($parcial, 0, '.', '');
                } elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
                    $debito = number_format($parcial, 0, '.', '');
                    $credito = '0.00';
                } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
                    $debito = '0.00';
                    $credito = number_format($parcial, 0, '.', '');
                }

                $item_puc_liquida_id = $this->DbgetMaxConsecutive("item_puc_liquida_servicio", "item_puc_liquida_id", $Conex, true, 1);

                $insert = "INSERT INTO item_puc_liquida_servicio (item_puc_liquida_id,orden_servicio_id,puc_id,base_item_puc_liquida,porcentaje_item_puc_liquida,formula_item_puc_liquida,desc_item_puc_liquida,deb_item_puc_liquida,cre_item_puc_liquida,contra_liquida_servicio)
						VALUES ($item_puc_liquida_id,$orden_servicio_id,$resultado[puc_id],'$base','$porcentaje','$formula','$descripcion','$debito','$credito',$resultado[contra_bien_servicio_factura])";
                $this->query($insert, $Conex);
            }
        }

        $update = "UPDATE orden_servicio SET liq_usuario_id=$liq_usuario_id, fec_liq_orden_servicio=$fec_liq_orden_servicio, estado_orden_servicio='L', descrip_liq_orden_servicio=$descrip_liq_orden_servicio
	  				WHERE orden_servicio_id=$orden_servicio_id AND estado_orden_servicio='A'";
        $this->query($update, $Conex);

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {
            $this->Commit($Conex);
        }
    }

    public function Checkconfig($orden_servicio_id, $empresa_id, $oficina_id, $Conex)
    {

        $contra = 0;
        $impuesto = 0;
        $subtotal = 0;

        $select = "SELECT  c.despuc_bien_servicio_factura,
		c.natu_bien_servicio_factura,
		c.contra_bien_servicio_factura,
		c.puc_id,
		(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
		(SELECT codigo_puc FROM puc WHERE puc_id = c.puc_id) AS codigo_puc,
		(SELECT autoret_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS autorete,
		(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS retei,
		(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS renta,
		(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
		(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
		WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
		AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
		(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
		WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
		AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,
		(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
		WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
		AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
		(SELECT SUM(valoruni_item_liquida_servicio*cant_item_liquida_servicio) AS total FROM  item_liquida_servicio  WHERE orden_servicio_id=o.orden_servicio_id) AS total
		FROM codpuc_bien_servicio_factura  c, orden_servicio o
		WHERE o.orden_servicio_id = $orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";

        $result = $this->DbFetchAll($select, $Conex, true);

        foreach ($result as $resultado) {
            if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1) {

                $subtotal++;
                $resultsub .= $resultado[codigo_puc] . ' ' . $resultado[puc_nombre] . '<br>';

            } else if ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[monto] <= $resultado[total] && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                $impuesto++;

            } else if ($resultado[contra_bien_servicio_factura] == 1) {
                $contra++;
                $resultcontra .= $resultado[codigo_puc] . ' ' . $resultado[puc_nombre] . '<br>';
            }
        }

        if ($subtotal == 1 && $impuesto >= 0 && $contra == 1) {
            $respuesta['mensaje'] = 'si';
            return $respuesta;
        } else {
            $respuesta['mensaje'] = 'no';
            $respuesta['subtotal_cuenta'] = $resultsub;
            $respuesta['subtotal'] = $subtotal;
            $respuesta['contra_cuenta'] = $resultcontra;
            $respuesta['contra'] = $contra;

            return $respuesta;
        }

    }

    public function getDataCliente($cliente_id, $Conex)
    {

        $select = "SELECT tr.telefono AS cliente_tele,tr.direccion AS cliente_direccion,p.contac_cliente_factura AS cliente_contacto,tr.email AS cliente_correo,(SELECT nombre FROM ubicacion WHERE ubicacion_id=tr.ubicacion_id) AS cliente_ciudad
	 FROM cliente p, tercero tr WHERE p.cliente_id = $cliente_id AND tr.tercero_id = p.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }
    public function getCausalesAnulacion($Conex)
    {

        $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;
    }

    public function getTotal($orden_servicio_id, $Conex)
    {

        $select = "SELECT SUM(valoruni_item_orden_servicio) AS subtotal,SUM(valoruni_item_orden_servicio*cant_item_orden_servicio) AS total FROM item_orden_servicio  WHERE orden_servicio_id=$orden_servicio_id";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function Save($Campos, $Conex)
    {

        $this->Begin($Conex);

        $orden_servicio_id = $this->DbgetMaxConsecutive("orden_servicio", "orden_servicio_id", $Conex, true, 1);
        $fecha_orden_servicio = $this->requestDataForQuery('fecha_orden_servicio', 'date');
        $descrip_orden_servicio = $this->requestDataForQuery('descrip_orden_servicio', 'text');
        $centro_de_costo_id = $this->requestDataForQuery('centro_de_costo_id', 'integer');
        $cliente_id = $this->requestDataForQuery('cliente_id', 'integer');
        $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_id', 'integer');
        $forma_compra_venta_id = $this->requestDataForQuery('forma_compra_venta_id', 'integer');
        $estado_orden_servicio = $this->requestDataForQuery('estado_orden_servicio', 'alphanum');
        $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
        $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
        $ingreso_orden_servicio = $this->requestDataForQuery('ingreso_orden_servicio', 'date');

        $select_con = "SELECT (MAX(consecutivo)+1) AS consecut FROM orden_servicio  WHERE oficina_id = $oficina_id";
        $result_con = $this->DbFetchAll($select_con, $Conex);
        $consecutivo = $result_con[0]['consecut'] > 0 ? $result_con[0]['consecut'] : 1;

        $insert = "INSERT INTO orden_servicio (orden_servicio_id,consecutivo,fecha_orden_servicio,descrip_orden_servicio,centro_de_costo_id,cliente_id,tipo_bien_servicio_factura_id,forma_compra_venta_id,estado_orden_servicio,usuario_id,ingreso_orden_servicio,oficina_id)
	  				VALUES ($orden_servicio_id,$consecutivo,$fecha_orden_servicio,$descrip_orden_servicio,$centro_de_costo_id,$cliente_id,$tipo_bien_servicio_factura_id,$forma_compra_venta_id,$estado_orden_servicio,$usuario_id,$ingreso_orden_servicio,$oficina_id)";
        $this->query($insert, $Conex);

        if (!strlen(trim($this->GetError())) > 0) {
            $this->Commit($Conex);
            return array(orden_servicio_id => $orden_servicio_id, consecutivo => $consecutivo);
        }
    }

    public function Update($Campos, $Conex)
    {
        $this->Begin($Conex);

        $orden_servicio_id = $this->requestDataForQuery('orden_servicio_id', 'integer');
        $fecha_orden_servicio = $this->requestDataForQuery('fecha_orden_servicio', 'date');
        $descrip_orden_servicio = $this->requestDataForQuery('descrip_orden_servicio', 'text');
        $centro_de_costo_id = $this->requestDataForQuery('centro_de_costo_id', 'integer');
        $cliente_id = $this->requestDataForQuery('cliente_id', 'integer');
        $tipo_bien_servicio_factura_id = $this->requestDataForQuery('tipo_bien_servicio_factura_id', 'integer');
        $forma_compra_venta_id = $this->requestDataForQuery('forma_compra_venta_id', 'integer');
        $estado_orden_servicio = $this->requestDataForQuery('estado_orden_servicio', 'alphanum');
        $usuario_id = $this->requestDataForQuery('usuario_id', 'integer');
        $oficina_id = $this->requestDataForQuery('oficina_id', 'integer');
        $ingreso_orden_servicio = $this->requestDataForQuery('ingreso_orden_servicio', 'date');

        if ($_REQUEST['orden_servicio_id'] == 'NULL') {

            $orden_servicio_id = $this->DbgetMaxConsecutive("orden_servicio", "orden_servicio_id", $Conex, true, 1);

            $select_con = "SELECT (MAX(consecutivo)+1) AS consecut FROM orden_servicio  WHERE oficina_id = $oficina_id";
            $result_con = $this->DbFetchAll($select_con, $Conex);
            $consecutivo = $result_con[0]['consecut'] > 0 ? $result_con[0]['consecut'] : 1;

            $insert = "INSERT INTO orden_servicio (orden_servicio_id,consecutivo,fecha_orden_servicio,descrip_orden_servicio,centro_de_costo_id,cliente_id,tipo_bien_servicio_factura_id,forma_compra_venta_id,estado_orden_servicio,usuario_id,ingreso_orden_servicio,oficina_id)
						VALUES ($orden_servicio_id,$consecutivo,$fecha_orden_servicio,$descrip_orden_servicio,$centro_de_costo_id,$cliente_id,$tipo_bien_servicio_factura_id,$forma_compra_venta_id,$estado_orden_servicio,$usuario_id,i$ngreso_orden_servicio,$oficina_id)";
            $this->query($insert, $Conex);

            if (!strlen(trim($this->GetError())) > 0) {
                $this->Commit($Conex);
                return array(orden_servicio_id => $orden_servicio_id, consecutivo => $consecutivo);
            }
        } else {
            $update = "UPDATE orden_servicio SET fecha_orden_servicio= $fecha_orden_servicio,
						descrip_orden_servicio = $descrip_orden_servicio,
						centro_de_costo_id=$centro_de_costo_id,
						cliente_id=$cliente_id,
						tipo_bien_servicio_factura_id =$tipo_bien_servicio_factura_id,
						forma_compra_venta_id=$forma_compra_venta_id
					WHERE orden_servicio_id=$orden_servicio_id";
            $this->query($update, $Conex);
            if (!strlen(trim($this->GetError())) > 0) {
                $this->Commit($Conex);
                return $orden_servicio_id;
            }
        }

    }

    public function cancellation($Conex)
    {

        $this->Begin($Conex);

        $orden_servicio_id = $this->requestDataForQuery('orden_servicio_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $anul_orden_servicio = $this->requestDataForQuery('anul_orden_servicio', 'text');
        $desc_anul_orden_servicio = $this->requestDataForQuery('desc_anul_orden_servicio', 'text');
		$anul_usuario_id = $this->requestDataForQuery('anul_usuario_id', 'integer');
		
		//devolver remesas al estado Liquidado
		$update_remesas_os = "UPDATE 
			remesa
		SET
			estado = 'LQ'
		WHERE
			remesa_id IN (SELECT remesa_id FROM item_liquida_servicio WHERE orden_servicio_id = $orden_servicio_id)";
		$this->query($update_remesas_os,$Conex,true);

        $update = "UPDATE orden_servicio SET estado_orden_servicio= 'I',
	  				causal_anulacion_id = $causal_anulacion_id,
					anul_orden_servicio=$anul_orden_servicio,
					desc_anul_orden_servicio =$desc_anul_orden_servicio,
					anul_usuario_id=$anul_usuario_id
	  			WHERE orden_servicio_id=$orden_servicio_id";
        $this->query($update, $Conex);

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {
            $this->Commit($Conex);
        }
    }

    public function selectEstadoEncabezadoRegistro($orden_servicio_id, $Conex)
    {

        $select = "SELECT estado_orden_servicio FROM orden_servicio  WHERE 	orden_servicio_id = $orden_servicio_id";
        $result = $this->DbFetchAll($select, $Conex);
        $estado = $result[0]['estado_orden_servicio'];

        return $estado;

    }

    public function selectItemliquida($orden_servicio_id, $Conex)
    {

        $select = "SELECT COUNT(*) AS movimientos FROM  item_orden_servicio   WHERE 	orden_servicio_id = $orden_servicio_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        $totali = $result[0]['movimientos'];

        return $totali;

    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "orden_servicio", $Campos);
        return $Data->GetData();
    }

    public function GetTipoPago($Conex)
    {
        return $this->DbFetchAll("SELECT forma_compra_venta_id AS value,nombre AS text FROM forma_compra_venta", $Conex,
            $ErrDb = false);
    }

    public function getCentroCosto($Conex)
    {
        return $this->DbFetchAll("SELECT centro_de_costo_id AS value,nombre AS text FROM centro_de_costo", $Conex,
            $ErrDb = false);
    }

    public function GetQueryOrdenGrid()
    {

        $Query = "SELECT
	 				o.consecutivo AS orden_servicio_id,
					(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
					o.fecha_orden_servicio AS fecha_orden_servicio,
					CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social) AS cliente_nombre,
					t.telefono AS cliente_tele,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cliente_ciudad,
					b.nombre_bien_servicio_factura AS tiposervicio,
					f.nombre AS nombre,
					CASE o.estado_orden_servicio WHEN 'A' THEN 'ACTIVO' WHEN 'F' THEN 'FACTURADA' WHEN 'L' THEN 'LIQUIDADA' ELSE 'ANULADA' END AS estado
					FROM orden_servicio o, cliente p, tercero t, tipo_bien_servicio_factura b, forma_compra_venta f
	                WHERE p.cliente_id=o.cliente_id AND t.tercero_id=p.tercero_id AND b.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND f.forma_compra_venta_id =o.forma_compra_venta_id ";
        return $Query;
    }
}
