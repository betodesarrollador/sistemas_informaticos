<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidacionPorOrdenServicioModel extends Db{

	private $usuario_id;
	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function getEstado(){

		$opciones = array(
			0=>array('value'=>'F','text'=>'Facturado'),
			1=>array('value'=>'L','text'=>'Liquidado'),
			2=>array('value'=>'A','text'=>'Anulado')
		);
		return $opciones;
	}
	

	public function getConsecutivo($OficinaId,$Conex){

		$select="SELECT MAX(consecutivo) AS consecutivo FROM liquidacion_sol_serv_guia WHERE oficina_id=$OficinaId";
		$result = $this -> DbFetchAll($select,$Conex);
		$consecutivo = $result[0][consecutivo];
		if($consecutivo=='' || $consecutivo=='NULL'){$consecutivo=0;}
		$consecutivo++;
		return $consecutivo;
	}

	public function selectSolicitudes($liquidacion_id,$Conex){

		$select="SELECT dss.solicitud_id FROM detalle_liq_sol_serv_guia dss WHERE dss.liquidacion_id = $liquidacion_id";
		// echo "$select";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function Save($Campos,$usuario_id,$oficina_id,$consecutivo,$Conex){

		$this -> Begin($Conex);
			$liquidacion_id = $this -> DbgetMaxConsecutive('liquidacion_sol_serv_guia','liquidacion_id',$Conex,true,1);
			$this -> assignValRequest('liquidacion_id',$liquidacion_id);
			$this -> assignValRequest('consecutivo',$consecutivo);
			$this -> assignValRequest('usuario_id',$usuario_id);
			$this -> assignValRequest('oficina_id',$oficina_id);
			$this -> assignValRequest('fecha_liquidacion',date('Y-m-d H:m'));
			$this -> DbInsertTable("liquidacion_sol_serv_guia",$Campos,$Conex,true,false);
		$this -> Commit($Conex);
		return $liquidacion_id;
	}

	public function Cancel($usuario_id,$liquidacion_id,$observacion,$cliente_id,$consecutivo,$Conex){

		$this -> Begin($Conex);

			$solicitudes_id = $this -> selectSolicitudes($liquidacion_id,$Conex);
			for ($i=0; $i < count($solicitudes_id); $i++) { 
				if ($result!='') {
					$result = $result.",".$solicitudes_id[$i][solicitud_id];
				}else{
					$result = $solicitudes_id[$i][solicitud_id];
				}
			}
			$solicitudes_id  = $result;

			$anular = "UPDATE guia SET facturado = 0 WHERE solicitud_id IN ($solicitudes_id) AND facturado = 1";
			$this -> query($anular,$Conex,true);

			$query="UPDATE solicitud_servicio_guia SET facturado = 0 WHERE solicitud_id IN ($solicitudes_id) AND facturado = 1";
			$this -> query($query,$Conex,true);

			$anula="UPDATE liquidacion_sol_serv_guia
				SET
					estado = 'A',
					fecha_anulacion = NOW(),
					usuario_anulo_id = $usuario_id,
					observacion_anulacion = '$observacion'
				WHERE
					liquidacion_id = $liquidacion_id
					AND consecutivo = $consecutivo
					AND cliente_id = $cliente_id
				";
			// echo "$anula";
			$this -> query($anula,$Conex,true);

		$this -> Commit($Conex);
		// echo $liquidacion_id;
		return $liquidacion_id;
	}

	public function selectLiquidacionPorOrdenServicio($liquidacion_id,$Conex){

		$select="SELECT
			liquidacion_id,
			consecutivo, 
			cliente_id,
			fecha_inicial,
			fecha_final,
			(SELECT CONCAT_WS(' ',UPPER(t.primer_nombre),UPPER(t.segundo_nombre),UPPER(t.primer_apellido),UPPER(t.segundo_apellido),UPPER(t.razon_social),
					UPPER(t.sigla))	FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=ls.cliente_id) AS cliente,
			estado
			FROM liquidacion_sol_serv_guia ls
			WHERE $liquidacion_id = ls.liquidacion_id
		";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}
}
?>