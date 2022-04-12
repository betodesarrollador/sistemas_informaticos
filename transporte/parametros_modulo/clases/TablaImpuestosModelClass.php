<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class TablaImpuestosModel extends Db
{

    private $Permisos;

    public function SetUsuarioId($usuario_id, $oficina_id)
    {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($usuario_id, $oficina_id);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function Save($Campos, $Conex)
    {
        $this->Begin($Conex);

        $tabla_impuestos_id = $this->DbgetMaxConsecutive("tabla_impuestos", "tabla_impuestos_id", $Conex, true, 1);
        $empresa_id = $this->requestData('empresa_id');
        $this->assignValRequest('tabla_impuestos_id', $tabla_impuestos_id);
        $this->DbInsertTable("tabla_impuestos", $Campos, $Conex, true, false);

        $oficinas = explode(",", $this->requestData('oficina_id'));

        for ($i = 0; $i < count($oficinas); $i++) {

            $impuesto_oficina_id = $this->DbgetMaxConsecutive("impuesto_oficina", "impuesto_oficina_id", $Conex, true, true);
            $oficina_id = $oficinas[$i];

            $insert = "INSERT INTO impuesto_oficina  (impuesto_oficina_id,tabla_impuestos_id,oficina_id,empresa_id)
		                VALUES ($impuesto_oficina_id,$tabla_impuestos_id,$oficina_id,$empresa_id)";

            $result = $this->query($insert, $Conex, true);

        }

        $this->Commit($Conex);
    }

    public function Update($Campos, $Conex)
    {

        $tabla_impuestos_id = $this->requestData("tabla_impuestos_id");
        $empresa_id = $this->requestData('empresa_id');

        $this->DbUpdateTable("tabla_impuestos", $Campos, $Conex, true, false);

        $delete = "DELETE FROM impuesto_oficina WHERE tabla_impuestos_id = $tabla_impuestos_id";
        $result = $this->query($delete, $Conex, true);

        $oficinas = explode(",", $this->requestData('oficina_id'));

        for ($i = 0; $i < count($oficinas); $i++) {

            $impuesto_oficina_id = $this->DbgetMaxConsecutive("impuesto_oficina", "impuesto_oficina_id", $Conex, true, true);
            $oficina_id = $oficinas[$i];

            $insert = "INSERT INTO impuesto_oficina  (impuesto_oficina_id,tabla_impuestos_id,oficina_id,empresa_id)
		                VALUES ($impuesto_oficina_id,$tabla_impuestos_id,$oficina_id,$empresa_id)";

            $result = $this->query($insert, $Conex, true);

        }

    }

    public function Delete($Campos, $Conex)
    {
        $this->DbDeleteTable("tabla_impuestos", $Campos, $Conex, true, false);
    }

//LISTA MENU
    public function getEmpresas($usuario_id, $Conex)
    {

        $select = "SELECT
	 			e.empresa_id AS value,
	 				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)
				AS text
				FROM empresa e,tercero t
	 			WHERE t.tercero_id = e.tercero_id
				AND e.empresa_id IN
					(SELECT empresa_id
					 FROM oficina
					 WHERE oficina_id IN
					 	(SELECT oficina_id
						 FROM opciones_actividad
						 WHERE usuario_id = $usuario_id)
					)";

        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

        return $result;
    }

    public function getBases($usuario_id, $Conex)
    {

        if (isset($_REQUEST['empresa_id'])) {

            $empresa_id = $this->requestDataForQuery('empresa_id', 'integer');

            $select = "(SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id = $empresa_id AND
	             estado = 'A' ORDER BY descuento) UNION (SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento)";
        } elseif (isset($_REQUEST['OFICINAID'])) {
            $oficina_id = $_REQUEST['OFICINAID'];
            $select = "(SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = $oficina_id) AND
	             estado = 'A' ORDER BY descuento) UNION (SELECT tabla_impuestos_id AS value, descuento AS text FROM
				 tabla_impuestos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento)";
        } else {
            $select = "SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento";
        }

        return $this->DbFetchAll($select, $Conex);
    }

    public function selectOficinasImpuesto($tabla_impuestos_id, $Conex)
    {

        $select = "SELECT oficina_id FROM impuesto_oficina WHERE tabla_impuestos_id = $tabla_impuestos_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

//BUSQUEDA
    public function selectTablaImpuestos($Conex)
    {

        $tabla_impuestos_id = $this->requestDataForQuery('tabla_impuestos_id', 'integer');

        $Query = "SELECT * FROM tabla_impuestos WHERE tabla_impuestos_id=$tabla_impuestos_id";
        $result = $this->DbFetchAll($Query, $Conex);

        return $result;
    }

    public function selectDataDescuento($usuario_id, $Conex)
    {

        $tabla_impuestos_id = $this->requestDataForQuery('tabla_impuestos_id', 'integer');
        $select = "SELECT * FROM tabla_impuestos WHERE tabla_impuestos_id = $tabla_impuestos_id";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function getImpuestos($empresa_id, $Conex)
    {

        $select = "SELECT impuesto_id AS value,nombre AS text FROM impuesto WHERE empresa_id = $empresa_id";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

//// GRID ////
    public function getQueryTablaImpuestosGrid()
    {

        $Query = "SELECT t.nombre AS impuesto,(SELECT codigo_puc FROM puc WHERE puc_id = (SELECT puc_id FROM impuesto WHERE impuesto_id = t.impuesto_id)) AS  puc, GROUP_CONCAT(o.nombre) AS  agencia,IF(t.base = 'F','VALOR DEL FLETE','IMPUESTO') AS base,(SELECT nombre FROM impuesto WHERE impuesto_id = t.base_impuesto_id) AS base_impuesto_id,t.orden,IF(t.visible_en_impresion = 0,'NO','SI') AS visible_en_impresion,t.estado FROM tabla_impuestos t,oficina o GROUP BY puc";

        return $Query;
    }

}
