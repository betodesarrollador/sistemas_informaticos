<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleLiquidacionSolicitudServiciosModel extends Db{

	private $Permisos;

	public function Save($Conex){

		$solicitud_id		=	$this	->	requestDataForQuery('solicitud_id');
		$solicitud_id		=	str_replace("'", "", $solicitud_id);
		$liquidacion_id		=	$this	->	requestDataForQuery('liquidacion_id');

		$this -> Begin($Conex);

			$query1="UPDATE liquidacion_sol_serv_guia SET valor = (SELECT SUM(valor_total) FROM guia WHERE solicitud_id IN ($solicitud_id) AND facturado = 0 )
			WHERE liquidacion_id=$liquidacion_id";
			$this -> query($query1,$Conex,true);

			$facturar = "UPDATE guia SET facturado = 1 WHERE solicitud_id IN ($solicitud_id) AND facturado = 0";
			$this -> query($facturar,$Conex,true);
			$query="UPDATE solicitud_servicio_guia SET facturado = 1 WHERE solicitud_id IN ($solicitud_id) AND facturado = 0";
			$this -> query($query,$Conex,true);


			$solicitudes = explode(",", $solicitud_id);

			for ($i=0; $i < count($solicitudes); $i++) {
				$solicitud_id = $solicitudes[$i];
				$solicitud_id = str_replace(",","",$solicitud_id);
				$detalle_liq_sol_serv_guia_id = $this -> DbgetMaxConsecutive('detalle_liq_sol_serv_guia','detalle_liq_sol_serv_guia_id',$Conex,true,1);
				$query = "INSERT INTO detalle_liq_sol_serv_guia 
						VALUES(
							$detalle_liq_sol_serv_guia_id,
							$solicitud_id,
							$liquidacion_id
						)
					";
				$this -> query($query,$Conex);
			}
		$this -> Commit($Conex);
		if($this -> GetNumError() > 0){
			return "false";
		}else{
			return "true";
		}
	}

	public function getGuiasLiqtodasSSol($solicitud_id,$OficinaId,$Conex){
	
		$select = "SELECT s.numero_guia,s.fecha_guia,s.cliente_id,
			s.guia_id,s.valor_total,s.valor_flete,s.valor_otros,s.valor_seguro,
			s.origen_id,s.destino_id,s.peso,s.peso_volumen,	s.tipo_servicio_mensajeria_id,s.tipo_envio_id
		FROM guia s
		WHERE   s.solicitud_id IN ($solicitud_id)   AND s.facturado = 0  ";//AND  s.estado_mensajeria_id IN (1,4,6,7)
		$result = $this -> DbFetchAll($select,$Conex,true);	
		return $result;
	}


	public function getDetallesSolicitudServicios($Conex){

		$solicitud_id = $this -> requestDataForQuery('solicitud_id');
		$solicitud_id = str_replace("'", "", $solicitud_id);
		$select="SELECT
					s.solicitud_id AS solicitud_id,
					(SELECT concat_ws(' ',razon_social,sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
					(SELECT numero_identificacion  FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  nit,
					s.fecha_ss AS fecha,
					(SELECT COUNT(g.guia_id) FROM guia g WHERE g.solicitud_id=s.solicitud_id/* AND g.facturado=0*/) AS guia
				FROM solicitud_servicio_guia s
				WHERE solicitud_id IN($solicitud_id)";
		// echo $select;
		$result = $this -> DbFetchAll($select,$Conex,true);
		if(empty($result)){
			$result = array();
		}
		return $result;
	}

	public function getDetallesSolicitudServiciosAnular($Conex){

		$solicitud_id = $this -> requestDataForQuery('solicitud_id');
		$solicitud_id = str_replace("'", "", $solicitud_id);
		$select="SELECT
					s.solicitud_id AS solicitud_id,
					(SELECT concat_ws(' ',razon_social,sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
					(SELECT numero_identificacion  FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  nit,
					s.fecha_ss AS fecha,
					(SELECT COUNT(g.guia_id) FROM guia g WHERE g.solicitud_id=s.solicitud_id/* AND g.facturado=0*/) AS guia
				FROM solicitud_servicio_guia s
				WHERE solicitud_id IN($solicitud_id)";
		// echo $select;
		$result = $this -> DbFetchAll($select,$Conex,true);
		if(empty($result)){
			$result = array();
		}
		return $result;
	}
}
?>