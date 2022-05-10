<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class DetallesLiqModel extends Db
{

    private $Permisos;

    public function getDetalles($orden_servicio_id, $Conex)
    {

        if (is_numeric($orden_servicio_id)) {
            $select = "SELECT COUNT(*) AS movimientos FROM item_liquida_servicio WHERE orden_servicio_id=$orden_servicio_id";
            $result = $this->DbFetchAll($select, $Conex);
            $movimientos = $result[0]['movimientos'];

            if ($movimientos == 0) {
                $select_cic = "SELECT item_orden_servicio_id FROM item_orden_servicio WHERE orden_servicio_id=$orden_servicio_id";
                $result_cic = $this->DbFetchAll($select_cic, $Conex);
                foreach ($result_cic as $item_id) {
                    $item_liquida_servicio_id = $this->DbgetMaxConsecutive("item_liquida_servicio", "item_liquida_servicio_id", $Conex, true, 1);

                    $insert = "INSERT INTO item_liquida_servicio (item_liquida_servicio_id,orden_servicio_id,cant_item_liquida_servicio,desc_item_liquida_servicio,valoruni_item_liquida_servicio,fecha_item_liquida,usuario_id,remesa_id)
						SELECT $item_liquida_servicio_id,orden_servicio_id,cant_item_orden_servicio,desc_item_orden_servicio,valoruni_item_orden_servicio,fecha_item_servicio,usuario_id,remesa_id  FROM  item_orden_servicio WHERE item_orden_servicio_id=$item_id[item_orden_servicio_id]";
                    $this->DbFetchAll($insert, $Conex, true);
                }
            }

            $select = "SELECT  i.cant_item_liquida_servicio,
					  i.item_liquida_servicio_id,
					  i.desc_item_liquida_servicio,
					  i.valoruni_item_liquida_servicio,
					  (SELECT numero_remesa FROM remesa WHERE remesa_id=i.remesa_id ) AS remesa,
					  i.remesa_id,
					  o.estado_orden_servicio
					 FROM item_liquida_servicio i, orden_servicio o
					 WHERE i.orden_servicio_id = $orden_servicio_id AND o.orden_servicio_id=i.orden_servicio_id";
            $result = $this->DbFetchAll($select, $Conex, true);

        } else {
            $result = array();
        }

        return $result;

    }

    public function Save($usuario_id, $Campos, $Conex)
    {

        $this->Begin($Conex);

        $orden_servicio_id = $this->requestDataForQuery('orden_servicio_id', 'integer');
        $item_liquida_servicio_id = $this->DbgetMaxConsecutive("item_liquida_servicio", "item_liquida_servicio_id", $Conex, true, 1);
        $cant_item_liquida_servicio = $this->requestDataForQuery('cant_item_liquida_servicio', 'numeric');
        $desc_item_liquida_servicio = $this->requestDataForQuery('desc_item_liquida_servicio', 'alphanum');
        $valoruni_item_liquida_servicio = $this->requestDataForQuery('valoruni_item_liquida_servicio', 'numeric');
		$remesa_id = $this->requestDataForQuery('remesa_id', 'integer');
		
		if($remesa_id > 0){

			$validacion = "SELECT os.orden_servicio_id FROM orden_servicio os, item_liquida_servicio ils WHERE os.orden_servicio_id = ils.orden_servicio_id AND ils.remesa_id = $remesa_id AND os.estado_orden_servicio != 'I'";
			
			$result_validacion = $this -> DbFetchAll($validacion,$Conex,true);

			if(count($result_validacion) > 0){

				exit('<center>La remesa no se puede adicionar ya que actualmente esta en la orden de servicio <strong>'.$result_validacion[0][orden_servicio_id].'</strong>. Revise la Orden de servicio actual si la remesa ya esta anexa o revise la Orden de Servicio <strong>'.$result_validacion[0][orden_servicio_id].'</strong><br><br>Si la remesa esta anexa en otro documento de Orden de Servicio, debe anular el mismo para poder liberar la remesa.</center>');

			}

		}

        $insert = "INSERT INTO item_liquida_servicio
	            (item_liquida_servicio_id,cant_item_liquida_servicio,desc_item_liquida_servicio,valoruni_item_liquida_servicio,orden_servicio_id,fecha_item_liquida,usuario_id,remesa_id )
	            VALUES
				($item_liquida_servicio_id,$cant_item_liquida_servicio,$desc_item_liquida_servicio,$valoruni_item_liquida_servicio,$orden_servicio_id,'" . date('Y-m-d H:m') . "',$usuario_id,$remesa_id)";
        $this->query($insert, $Conex);
        $this->Commit($Conex);

        return $item_liquida_servicio_id;

    }

    public function Update($Campos, $Conex)
    {

        $this->Begin($Conex);

        $item_liquida_servicio_id = $this->requestDataForQuery('item_liquida_servicio_id', 'integer');
        $cant_item_liquida_servicio = $this->requestDataForQuery('cant_item_liquida_servicio', 'numeric');
        $desc_item_liquida_servicio = $this->requestDataForQuery('desc_item_liquida_servicio', 'alphanum');
        $valoruni_item_liquida_servicio = $this->requestDataForQuery('valoruni_item_liquida_servicio', 'numeric');
        $remesa_id = $this->requestDataForQuery('remesa_id', 'integer');

        $update = "UPDATE item_liquida_servicio SET cant_item_liquida_servicio = $cant_item_liquida_servicio,desc_item_liquida_servicio = $desc_item_liquida_servicio,valoruni_item_liquida_servicio = $valoruni_item_liquida_servicio, remesa_id=$remesa_id
	  WHERE item_liquida_servicio_id = $item_liquida_servicio_id";

        $this->query($update, $Conex);

        $this->Commit($Conex);

        return $item_liquida_servicio_id;

    }

    public function Delete($Campos, $Conex)
    {

        $item_liquida_servicio_id = $_REQUEST['item_liquida_servicio_id'];

        $insert = "DELETE FROM item_liquida_servicio WHERE item_liquida_servicio_id = $item_liquida_servicio_id";
        $this->query($insert, $Conex);

    }

}
