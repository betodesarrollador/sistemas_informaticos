<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CierreCRMModel extends Db{

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
			0=>array('value'=>'L','text'=>'Liquidado'),
			1=>array('value'=>'F','text'=>'Facturado'),
			2=>array('value'=>'A','text'=>'Anulado')
		);
		return $opciones;
	}


	public function getConsecutivo($OficinaId,$Conex){

		$select="SELECT MAX(consecutivo) AS consecutivo FROM liquidacion_guias_cliente WHERE oficina_id=$OficinaId";
		$result = $this -> DbFetchAll($select,$Conex);
		$consecutivo = $result[0][consecutivo];
		if($consecutivo=='' || $consecutivo=='NULL'){$consecutivo=0;}
		$consecutivo++;
		return $consecutivo;
	}

	public function getConsecutivoReal($cierre_crm_id,$Conex){

		$select="SELECT consecutivo FROM cierre_crm WHERE cierre_crm_id=$cierre_crm_id";
		$result = $this -> DbFetchAll($select,$Conex);
		$consecutivo = $result[0][consecutivo];
		return $consecutivo;
	}


	public function Save($Campos,$usuario_id,$oficina_id,$consecutivo,$estado,$Conex){

		$cierre_crm_id = $this -> DbgetMaxConsecutive('cierre_crm','cierre_crm_id',$Conex,true,1);
		$fecha_registro  = date('Y-m-d H:m');	
		$this -> assignValRequest('fecha_registro',$fecha_registro);			
		$this -> assignValRequest('cierre_crm_id',$cierre_crm_id);
		$this -> assignValRequest('consecutivo',$consecutivo);			
		$this -> assignValRequest('oficina_id',$oficina_id);
		$this -> assignValRequest('usuario_id',$usuario_id);
		$this -> assignValRequest('estado',$estado);
		$guias_id  = $_REQUEST['guias_id'];	
		$cliente_id  = $_REQUEST['cliente_id'];	
		$desde  = $_REQUEST['fecha_inicial'];				
		$hasta  = $_REQUEST['fecha_final'];							
		
		$this -> Begin($Conex);
		$this -> DbInsertTable("cierre_crm",$Campos,$Conex,true,false);
		
		if($guias_id=='todas'){

			$select = "SELECT 
				s.guia_id,
				s.valor_total
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4)";
			$result = $this -> DbFetchAll($select,$Conex);	
			
			for($i=0;$i<count($result);$i++){
				$guia_id=$result[$i]['guia_id'];
				
				$detalle_liq_guias_cliente_id = $this -> DbgetMaxConsecutive('detalle_liq_guias_cliente','detalle_liq_guias_cliente_id',$Conex,true,1);
				$insert = "INSERT INTO detalle_liq_guias_cliente (detalle_liq_guias_cliente_id,cierre_crm_id,guia_id) 
						VALUES(	$detalle_liq_guias_cliente_id,$cierre_crm_id,$guia_id)";
				$this -> query($insert,$Conex,true);
				
				$update = "UPDATE guia SET facturado = 1 WHERE guia_id=$guia_id";
				$this -> query($update,$Conex,true);
			}
		}else{

			$select = "SELECT 
				s.guia_id,
				s.valor_total
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.guia_id IN ($guias_id) AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4)";
			$result = $this -> DbFetchAll($select,$Conex);	
			
			for($i=0;$i<count($result);$i++){
				$guia_id=$result[$i]['guia_id'];
				
				$detalle_liq_guias_cliente_id = $this -> DbgetMaxConsecutive('detalle_liq_guias_cliente','detalle_liq_guias_cliente_id',$Conex,true,1);
				$insert = "INSERT INTO detalle_liq_guias_cliente (detalle_liq_guias_cliente_id,cierre_crm_id,guia_id) 
						VALUES(	$detalle_liq_guias_cliente_id,$cierre_crm_id,$guia_id)";
				$this -> query($insert,$Conex,true);
				
				$update = "UPDATE guia SET facturado = 1 WHERE guia_id=$guia_id";
				$this -> query($update,$Conex,true);
			}

		}
		
		$this -> Commit($Conex);
		
		return $cierre_crm_id;
	}


	public function cancellation($cierre_crm_id,$observacion_anulacion,$fecha_anulacion,$usuario_anulo_id,$Conex){ 

		$this -> Begin($Conex);


			$anular = "UPDATE guia SET facturado = 0 
			WHERE guia_id IN (SELECT guia_id FROM detalle_liq_guias_cliente WHERE cierre_crm_id=$cierre_crm_id) 
			AND facturado = 1";
			$this -> query($anular,$Conex,true);//verificar que no este en otra


			$anula="UPDATE cierre_crm SET estado = 'A', fecha_anulacion='$fecha_anulacion', observacion_anulacion='$observacion_anulacion', usuario_anulo_id = $usuario_anulo_id 
			WHERE cierre_crm_id = $cierre_crm_id";
			$this -> query($anula,$Conex,true);

		$this -> Commit($Conex);
		return $cierre_crm_id;
	}

	public function selectCierreCRM($cierre_crm_id,$Conex){

		$select="SELECT
			ls.*,
			(
				SELECT CONCAT_WS(' ',
					UPPER(t.primer_nombre),
					UPPER(t.segundo_nombre),
					UPPER(t.primer_apellido),
					UPPER(t.segundo_apellido),
					UPPER(t.razon_social),
					UPPER(t.sigla))
				FROM tercero t, cliente c 
				WHERE t.tercero_id=c.tercero_id AND c.cliente_id=ls.cliente_id
			) AS cliente
			FROM cierre_crm ls
			WHERE $cierre_crm_id = ls.cierre_crm_id
		";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}


	public function getValorPorFacturado($cliente_id,$desde,$hasta,$Conex){

		$select="SELECT SUM(valor_total) AS valor
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4)";
		//echo $select;
		$result = $this -> DbFetchAll($select,$Conex,true);

		if($result[0][valor]>0){
			return $result[0][valor];			
		}else{
			return 0;			
		}

	}

	public function getValorPorFacturadoInd($guias_id,$cliente_id,$desde,$hasta,$Conex){

		$select="SELECT  SUM(valor_total) AS valor
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND  s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.guia_id IN ($guias_id) AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4)";
		// echo $select;
		$result = $this -> DbFetchAll($select,$Conex,true);
		if($result[0][valor]>0){
			return $result[0][valor];			
		}else{
			return 0;			
		}
	}

}
?>