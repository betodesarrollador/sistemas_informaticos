<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class ClientesModel extends Db
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

    public function selectDatosClientesTerceroId($tercero_id, $Conex)
    {

        $select = "SELECT
						c.*,
	 					t.*,
						(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido) AS comercial  FROM comercial co, tercero te WHERE co.comercial_id=c.comercial_id AND te.tercero_id=co.tercero_id) AS comercial,
						c.estado AS estado,
						r.remitente_destinatario_id,
							(SELECT nombre
							 FROM ubicacion
							 WHERE ubicacion_id=t.ubicacion_id)
						AS ubicacion,
							(SELECT nombre
							 FROM ubicacion
							 WHERE ubicacion_id=c.rep_ubicacion_id)
						AS ciurepre_cliente_factura,

							(SELECT nombre_banco
							 FROM banco
							 WHERE 	banco_id=c.banco_id)
						AS banco
				   	FROM tercero t
				   		LEFT JOIN cliente c ON t.tercero_id = c.tercero_id
						LEFT JOIN remitente_destinatario r ON t.tercero_id = r.tercero_id
	                WHERE t.tercero_id = $tercero_id";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;

    }

    public function selectDatosClientesNumeroId($numero_identificacion, $Conex)
    {

        $select = "SELECT
						c.*,
	 					t.*,
						(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido) AS comercial  FROM comercial co, tercero te WHERE co.comercial_id=c.comercial_id AND te.tercero_id=co.tercero_id) AS comercial,
						IF(c.estado IS NULL,'B',c.estado) AS estado,
						r.remitente_destinatario_id,
				   			(SELECT nombre
							 FROM ubicacion
							 WHERE ubicacion_id=t.ubicacion_id)
						AS ubicacion,
							(SELECT nombre_banco
							 FROM banco
							 WHERE 	banco_id=c.banco_id)
						AS banco
				   	FROM tercero t
						LEFT JOIN cliente c ON t.tercero_id = c.tercero_id
						LEFT JOIN remitente_destinatario r ON t.tercero_id = r.tercero_id
	                WHERE t.numero_identificacion = $numero_identificacion";

        $result = $this->DbFetchAll($select, $Conex);
        return $result;

    }

    public function Save($Campos, $Conex)
    {

        $this->Begin($Conex);

        $tercero_id = $_REQUEST['tercero_id'] > 0 ? $_REQUEST['tercero_id'] : $this->DbgetMaxConsecutive("tercero", "tercero_id", $Conex, true, 1);
        $cliente_id = $this->DbgetMaxConsecutive("cliente", "cliente_id", $Conex, false, 1);
        $remitente_destinatario_id = $this->DbgetMaxConsecutive("remitente_destinatario", "remitente_destinatario_id", $Conex, false, 1);
        $ubicacion_id = $this->requestDataForQuery('ubicacion_id', 'integer');
        $tipo_persona_id = $this->requestDataForQuery('tipo_persona_id', 'integer');
        $tipo_identificacion_id = $this->requestDataForQuery('tipo_identificacion_id', 'integer');
        $numero_identificacion = $this->requestDataForQuery('numero_identificacion', 'bigint');
        $digito_verificacion = $this->requestDataForQuery('digito_verificacion', 'integer');
        $primer_apellido = $this->requestDataForQuery('primer_apellido', 'text');
        $segundo_apellido = $_REQUEST['segundo_apellido'];
        $primer_nombre = $this->requestDataForQuery('primer_nombre', 'text');
        $segundo_nombre = $_REQUEST['segundo_nombre'];
        //$segundo_nombre = $this->requestDataForQuery('segundo_nombre', 'text');
        $razon_social = $this->requestDataForQuery('razon_social', 'alphanum');
        $sigla = $this->requestDataForQuery('sigla', 'alphanum');
        $telefono = $this->requestDataForQuery('telefono', 'alphanum');
        $movil = $this->requestDataForQuery('movil', 'alphanum');
        $direccion = $this->requestDataForQuery('direccion', 'alphanum');
        $email = $this->requestDataForQuery('email', 'text');
        $regimen_id = $this->requestDataForQuery('regimen_id', 'integer');
        $zona_postal = $this->requestDataForQuery('zona_postal', 'text');
        $codigo_ciiu = $this->requestDataForQuery('codigo_ciiu', 'text');

        if($segundo_nombre == NULL || $segundo_nombre == 'NULL'){
            $segundo_nombre = '';
        }
        if($segundo_apellido == NULL || $segundo_apellido == 'NULL'){
            $segundo_apellido = '';
        }

        if (!$_REQUEST['tercero_id'] > 0 || $_REQUEST['tercero_id'] == 'NULL') {
            $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,
										  primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion,email,regimen_id,zona_postal,codigo_ciiu)
						VALUES
										($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,
										 $primer_apellido,'$segundo_apellido',$primer_nombre,'$segundo_nombre',$razon_social,$sigla,$telefono,$movil,$direccion,$email,$regimen_id,$zona_postal,$codigo_ciiu)";
            $this->query($insert, $Conex, true);
            $this->assignValRequest('contado', '1');
            $this->assignValRequest('tercero_id', $tercero_id);
           
        } else {
            $this->DbUpdateTable("tercero", $Campos, $Conex, true, false);
        }

        $hoy = date("Y-m-d");

        $this->assignValRequest('cliente_id', $cliente_id);
        $this->assignValRequest('fecha_ingreso', $hoy);
        $this->DbInsertTable("cliente", $Campos, $Conex, true, false);
        $nombre = $_REQUEST['primer_nombre'];

        if ($razonsocia != '' && $razonsocia != 'NULL' && $razonsocia != NULL ) {
            $nombre = $razonsocia;
            $primer_nombre = '';
            $primer_apellido = '';
            $segundo_apellido = '';
        }
    
        if($segundo_apellido == NULL || $segundo_apellido == 'NULL'){
            $segundo_apellido = '';
        }
        
        $insert1 = "INSERT INTO remitente_destinatario (remitente_destinatario_id,cliente_id,tercero_id,tipo_identificacion_id,
            numero_identificacion,digito_verificacion,nombre,primer_apellido,segundo_apellido,direccion,telefono,ubicacion_id,tipo,estado) VALUES($remitente_destinatario_id,$cliente_id,$tercero_id,$tipo_identificacion_id,
            $numero_identificacion,$digito_verificacion,'$nombre',$primer_apellido,'$segundo_apellido',$direccion,$telefono,$ubicacion_id,'R','D')";
        $this->query($insert1, $Conex, true);
        $this->Commit($Conex);
        return array(array(tercero_id => $tercero_id, cliente_id => $cliente_id, remitente_destinatario_id => $remitente_destinatario_id));
    }

    //    --------------------------------//
    public function Clinton($documento, $cliente_id, $Conex)
    {

        $lista = file_get_contents("http://www.treasury.gov/ofac/downloads/sdnlist.txt");
        $numero = $documento;
        $numero2 = str_pad($documento, (strlen($documento) + 2), " ", STR_PAD_BOTH);
        $apariciones = substr_count($lista, $numero) + substr_count($lista, $numero2);

        if ($cliente_id > 0) {
            $update = "UPDATE cliente SET ultima_clinton = CURDATE() WHERE cliente_id=$cliente_id";

            $this->query($update, $Conex);
        }

        return $apariciones;

    }

//    --------------------------------//

    public function Update($Campos, $Conex)
    {
        $this->Begin($Conex);
        $this->DbUpdateTable("tercero", $Campos, $Conex, true, false);
        if ($_REQUEST['cliente_id'] == 'NULL') {

            $cliente_id = $this->DbgetMaxConsecutive("cliente", "cliente_id", $Conex, false, 1);
            $this->assignValRequest('cliente_id', $cliente_id);
            $this->assignValRequest('contado', '1');
            $this->DbInsertTable("cliente", $Campos, $Conex, true, false);

            $remitente_destinatario_id = $this->DbgetMaxConsecutive("remitente_destinatario", "remitente_destinatario_id", $Conex, false, 1);

            $tercero_id = $_REQUEST['tercero_id'];
            $tipo_identificacion_id = $_REQUEST['tipo_identificacion_id'];
            $numero_identificacion = $_REQUEST['numero_identificacion'];
            $digito_verificacion = $_REQUEST['digito_verificacion'];
            $primer_apellido = $_REQUEST['primer_apellido'];
            $segundo_apellido = $_REQUEST['segundo_apellido'];
            $nombre = strlen(trim($_REQUEST['razon_social'])) > 0 ? $_REQUEST['razon_social'] :
            $_REQUEST['primer_nombre'];
            $direccion = $_REQUEST['direccion'];
            $telefono = $_REQUEST['telefono'];
            $ubicacion_id = $_REQUEST['ubicacion_id'];

            $insert = "INSERT INTO remitente_destinatario (remitente_destinatario_id,cliente_id,tercero_id,tipo_identificacion_id,
                numero_identificacion,digito_verificacion,nombre,direccion,telefono,ubicacion_id,tipo,estado)
                VALUES($remitente_destinatario_id,$cliente_id,$tercero_id,$tipo_identificacion_id,
                '$numero_identificacion','$digito_verificacion',$nombre,$primer_apellido,$segundo_apellido,'$direccion','$telefono',$ubicacion_id,'R','A')";

            $this->query($insert, $Conex);

        } else {

            $this->DbUpdateTable("cliente", $Campos, $Conex, true, false);

            $razonsocia = $_REQUEST['razon_social'];

            $remitente_destinatario_id = $_REQUEST["remitente_destinatario_id"];
            $numero_identificacion = $_REQUEST['numero_identificacion'];
            $tipo_identificacion_id = $_REQUEST['tipo_identificacion_id'];
            $digito_verificacion = $_REQUEST['digito_verificacion'];
            $direccion = $_REQUEST['direccion'];
            $telefono = $_REQUEST['telefono'];
            $ubicacion_id = $_REQUEST['ubicacion_id'];
            $nombre = $_REQUEST['primer_nombre'];
            $primer_apellido = $_REQUEST['primer_apellido'];
            $segundo_apellido = $_REQUEST['segundo_apellido'];
            
            if ($razonsocia != '' && $razonsocia != 'NULL' && $razonsocia != NULL ) {
                $nombre = $razonsocia;
                $primer_nombre = '';
                $primer_apellido = '';
                $segundo_apellido = '';
            }
        
            if($segundo_apellido == NULL || $segundo_apellido == 'NULL'){
                $segundo_apellido = '';
            }

            $update = "UPDATE remitente_destinatario SET tipo_identificacion_id = $tipo_identificacion_id,numero_identificacion ='$numero_identificacion',digito_verificacion='$digito_verificacion',nombre='$nombre',direccion='$direccion',primer_apellido='$primer_apellido',segundo_apellido='$segundo_apellido',
		        telefono='$telefono',ubicacion_id=$ubicacion_id WHERE remitente_destinatario_id = $remitente_destinatario_id";

            $this->query($update, $Conex);

        }
        $this->Commit($Conex);
        return $cliente_id;
    }

    public function SaveObligacion($tercero_id, $codigo_obligacion_id, $estado, $Conex)
    {
        $this->Begin($Conex);
        $tercero_obligacion_id = $this->DbgetMaxConsecutive("tercero_obligacion", "tercero_obligacion_id", $Conex, false, 1);
        $insert = "INSERT INTO tercero_obligacion (tercero_obligacion_id,codigo_obligacion_id,tercero_id,estado)
		VALUES($tercero_obligacion_id,$codigo_obligacion_id,$tercero_id,'$estado')";

        $this->query($insert, $Conex, true);

        $this->Commit($Conex);
        return $tercero_obligacion_id;
    }

    public function UpdateObligacion($tercero_id, $tercero_obligacion_id, $codigo_obligacion_id, $estado, $Conex)
    {
        $this->Begin($Conex);
        $update = "UPDATE tercero_obligacion SET estado='$estado' WHERE  tercero_obligacion_id=$tercero_obligacion_id AND tercero_id=$tercero_id
		 AND codigo_obligacion_id=$codigo_obligacion_id";

        $this->query($update, $Conex, true);

        $this->Commit($Conex);
        return $tercero_obligacion_id;
    }

    public function Delete($Campos, $Conex)
    {
        $this->DbDeleteTable("cliente", $Campos, $Conex, true, false);
        $this->DbDeleteTable("remitente_destinatario", $Campos, $Conex, true, false);
    }

    public function ValidateRow($Conex, $Campos)
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($Conex, "tercero", $Campos);
        return $Data->GetData();
    }

    public function GetTipoId($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion ORDER BY nombre
	ASC", $Conex, $ErrDb = false);
    }

    public function GetTipoPersona($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona", $Conex,
            $ErrDb = false);
    }

    public function GetTipoRegimen($Conex)
    {
        return $this->DbFetchAll("SELECT regimen_id AS value,nombre AS text FROM regimen", $Conex,
            $ErrDb = false);
    }

    public function GetTipoCuenta($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_cta_id AS value,nombre_tipo_cuenta AS text FROM tipo_cuenta", $Conex,
            $ErrDb = false);
    }

    public function GetBanco($Conex)
    {
        return $this->DbFetchAll("SELECT banco_id AS value,nombre_banco AS text FROM banco", $Conex,
            $ErrDb = false);
    }

    public function getObligacionesTercero($tercero_id, $Conex)
    {

        $select = "SELECT
	 					t.*,
						(SELECT teo.tercero_obligacion_id FROM tercero_obligacion teo WHERE teo.codigo_obligacion_id=t.codigo_obligacion_id AND teo.tercero_id=$tercero_id) AS tercero_obligacion_id,
						(SELECT teo.estado  FROM tercero_obligacion teo WHERE teo.codigo_obligacion_id=t.codigo_obligacion_id AND teo.tercero_id=$tercero_id) AS estado_obli

					FROM codigo_obligacion t
	                WHERE t.estado='A'";
        $result = $this->DbFetchAll($select, $Conex,true);
        return $result;

    }

    public function GetOfi($Conex)
    {
        return $this->DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina", $Conex, $ErrDb = false);
    }

    public function GetQueryClientesGrid()
    {

        $Query = "SELECT
   			(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_id,
			t.numero_identificacion,
			digito_verificacion,
			(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = t.tipo_persona_id) AS tipo_persona_id,
			t.primer_apellido,
   			t.segundo_apellido,
			t.primer_nombre,
			t.segundo_nombre,
			t.razon_social,
			t.sigla,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
			t.direccion,
			t.telefono,
			t.movil,
			t.telefax,
			t.apartado,
			t.email,
			c.numcuenta_cliente_factura,
			(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE 	tipo_cta_id=c.tipo_cta_id) AS tip_cuenta,
			(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) 	AS banco,
     		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS comercial  FROM comercial co, tercero t WHERE co.comercial_id=c.comercial_id AND t.tercero_id=co.tercero_id) AS comercial,
			IF(c.estado='B','BLOQUEADO','DISPONIBLE')AS estado
		FROM tercero t,cliente c
		WHERE t.tercero_id = c.tercero_id";

        return $Query;
    }
}
