<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidacionGuiasClienteModel extends Db{

	private $usuario_id;
	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function getOficinas($empresa_id,$Conex){
	
	  $select = "SELECT oficina_id AS value, nombre AS text FROM oficina WHERE empresa_id = $empresa_id";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  	  
	
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

	public function getConsecutivoReal($liquidacion_guias_cliente_id,$Conex){

		$select="SELECT consecutivo FROM liquidacion_guias_cliente WHERE liquidacion_guias_cliente_id=$liquidacion_guias_cliente_id";
		$result = $this -> DbFetchAll($select,$Conex);
		$consecutivo = $result[0][consecutivo];
		return $consecutivo;
	}

	public function getGuiasLiqtodas($desde,$hasta,$cliente_id,$OficinaId,$oficina_id1,$Conex){

		if($oficina_id1>0){ $oficina=" AND s.oficina_id=$oficina_id1 "; }else{ $oficina="";}
		$select = "SELECT s.numero_guia,s.valor,
			s.guia_id,s.valor_total,s.valor_flete,s.valor_otros,s.valor_seguro,
			s.origen_id,s.destino_id,s.peso,s.peso_volumen,	s.tipo_servicio_mensajeria_id,s.tipo_envio_id
		FROM guia s
		WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND  s.estado_mensajeria_id IN (1,4,6,7) $oficina";
		$result = $this -> DbFetchAll($select,$Conex,true);	
		return $result;
	}

	public function getGuiasLiqUni($desde,$hasta,$cliente_id,$OficinaId,$oficina_id1,$guias_id,$Conex){

		if($oficina_id1>0){ $oficina=" AND s.oficina_id=$oficina_id1 "; }else{ $oficina="";}

		$select = "SELECT s.numero_guia, s.valor,
			s.guia_id,s.valor_total,s.valor_flete,s.valor_otros,s.valor_seguro,
			s.origen_id,s.destino_id,s.peso,s.peso_volumen,	s.tipo_servicio_mensajeria_id,s.tipo_envio_id
		FROM guia s
		WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.guia_id IN ($guias_id) AND  s.estado_mensajeria_id IN (1,4,6,7) $oficina";
		$result = $this -> DbFetchAll($select,$Conex,true);	
		return $result;
	}

   public function getTabla($tipo_servicio_mensajeria_id,$Conex){	   
	  $select = "SELECT tabla FROM  tipo_servicio_mensajeria   WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id";
	  $result = $this -> DbFetchAll($select,$Conex);	
	  return $result;
   
   }

  public function getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria_cliente
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND cliente_id=$cliente_id
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)"; 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	 return $result;    
  }  

  public function getCalcularTarifaMasivoCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_masivo_cliente WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id  AND cliente_id=$cliente_id
	  AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	 return $result;    
  }  

  public function getCalcularTarifaMasivo($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_masivo WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	  AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularCosto($destino_id,$anio,$Conex,$oficina_id){ 
     $select = "SELECT * FROM tarifas_destino WHERE ubicacion_id = $destino_id AND periodo=$anio";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getTipoEnvio1($destino_id,$Conex){ 
     $select = "SELECT tipo_envio_id FROM ubicacion WHERE ubicacion_id = $destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result[0]['tipo_envio_id'];    
  }  
  public function getTipoEnvioMetro($origen_id,$destino_id,$Conex){ 
     $select = "SELECT ubicacion_id FROM ubicacion WHERE ubicacion_id = $destino_id AND metropolitana_id=$origen_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 if($result[0]['ubicacion_id']>0){
		 return true;    
	 }else{
		 return false;
	 }
  }  
  
  public function getNombre_destino($destino_id,$Conex){ 
     $select = "SELECT nombre FROM ubicacion WHERE ubicacion_id = $destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result[0]['nombre'];    
  }  

  public function getActualizarValor($guia_id,$tipo_envio_id, $total,$valor_decla,$valorinicial,$manejo,$valor_otros,$Conex){ 
     $update = "UPDATE guia SET valor_flete=$valorinicial,valor_seguro=$valor_decla, valor_otros=$valor_otros,
	 			valor_total=$total, tipo_envio_id=$tipo_envio_id 
	 			WHERE guia_id = $guia_id";

	 $this -> query($update,$Conex,true);
	 
	 return $guia_id;    
  }  


	public function Save($Campos,$usuario_id,$oficina_id,$consecutivo,$estado,$Conex){

		$liquidacion_guias_cliente_id = $this -> DbgetMaxConsecutive('liquidacion_guias_cliente','liquidacion_guias_cliente_id',$Conex,true,1);
		$fecha_registro  = date('Y-m-d H:m');	
		$this -> assignValRequest('fecha_registro',$fecha_registro);			
		$this -> assignValRequest('liquidacion_guias_cliente_id',$liquidacion_guias_cliente_id);
		$this -> assignValRequest('consecutivo',$consecutivo);			
		$this -> assignValRequest('oficina_id',$oficina_id);
		$this -> assignValRequest('usuario_id',$usuario_id);
		$this -> assignValRequest('estado',$estado);
		$guias_id  = $_REQUEST['guias_id'];	
		$cliente_id  = $_REQUEST['cliente_id'];	
		$desde  = $_REQUEST['fecha_inicial'];				
		$hasta  = $_REQUEST['fecha_final'];		
		$oficina_id1  = $_REQUEST['oficina_id1'];		
		
		if($oficina_id1>0){ $oficina=" AND s.oficina_id=$oficina_id1 "; }else{ $oficina="";}
		$this -> Begin($Conex);
		$this -> DbInsertTable("liquidacion_guias_cliente",$Campos,$Conex,true,false);
		
		if($guias_id=='todas'){

			$select = "SELECT 
				s.guia_id,
				s.valor_total
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.estado_mensajeria_id IN (1,4,6,7) $oficina";
			$result = $this -> DbFetchAll($select,$Conex);	
			$valor_total = 0;
			for($i=0;$i<count($result);$i++){
				$guia_id=$result[$i]['guia_id'];
				$valor_total = $valor_total+$result[$i]['valor_total'];
				$detalle_liq_guias_cliente_id = $this -> DbgetMaxConsecutive('detalle_liq_guias_cliente','detalle_liq_guias_cliente_id',$Conex,true,1);
				$insert = "INSERT INTO detalle_liq_guias_cliente (detalle_liq_guias_cliente_id,liquidacion_guias_cliente_id,guia_id) 
						VALUES(	$detalle_liq_guias_cliente_id,$liquidacion_guias_cliente_id,$guia_id)";
				$this -> query($insert,$Conex,true);
				
				$update = "UPDATE guia SET facturado = 1 WHERE guia_id=$guia_id";
				$this -> query($update,$Conex,true);
			}
		}else{

			$select = "SELECT 
				s.guia_id,
				s.valor_total
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.guia_id IN ($guias_id) AND s.estado_mensajeria_id IN (1,4,6,7) $oficina";
			$result = $this -> DbFetchAll($select,$Conex);	
			$valor_total = 0;
			for($i=0;$i<count($result);$i++){
				$guia_id=$result[$i]['guia_id'];
				$valor_total = $valor_total+$result[$i]['valor_total'];
				$detalle_liq_guias_cliente_id = $this -> DbgetMaxConsecutive('detalle_liq_guias_cliente','detalle_liq_guias_cliente_id',$Conex,true,1);
				$insert = "INSERT INTO detalle_liq_guias_cliente (detalle_liq_guias_cliente_id,liquidacion_guias_cliente_id,guia_id) 
						VALUES(	$detalle_liq_guias_cliente_id,$liquidacion_guias_cliente_id,$guia_id)";
				$this -> query($insert,$Conex,true);
				
				$update = "UPDATE guia SET facturado = 1 WHERE guia_id=$guia_id";
				$this -> query($update,$Conex,true);
			}

		}
		
		$this -> Commit($Conex);
		$update = "UPDATE liquidacion_guias_cliente SET valor = $valor_total WHERE liquidacion_guias_cliente_id=$liquidacion_guias_cliente_id";
		$this -> query($update,$Conex,true);//ojo ultimo adicionado verificar
		
		return $liquidacion_guias_cliente_id;
	}


	public function cancellation($liquidacion_guias_cliente_id,$observacion_anulacion,$fecha_anulacion,$usuario_anulo_id,$Conex){ 

		$this -> Begin($Conex);


			$anular = "UPDATE guia SET facturado = 0 
			WHERE guia_id IN (SELECT guia_id FROM detalle_liq_guias_cliente WHERE liquidacion_guias_cliente_id=$liquidacion_guias_cliente_id) 
			AND facturado = 1";
			$this -> query($anular,$Conex,true);//verificar que no este en otra


			$anula="UPDATE liquidacion_guias_cliente SET estado = 'A', fecha_anulacion='$fecha_anulacion', observacion_anulacion='$observacion_anulacion', usuario_anulo_id = $usuario_anulo_id 
			WHERE liquidacion_guias_cliente_id = $liquidacion_guias_cliente_id";
			$this -> query($anula,$Conex,true);

		$this -> Commit($Conex);
		return $liquidacion_guias_cliente_id;
	}

	public function selectLiquidacionGuiasCliente($liquidacion_guias_cliente_id,$Conex){

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
			) AS cliente,
			ls.oficina_id AS oficina_id
			FROM liquidacion_guias_cliente ls
			WHERE $liquidacion_guias_cliente_id = ls.liquidacion_guias_cliente_id
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
	
		public function getUltimo($cliente_id,$Conex){

		$select="SELECT CONCAT(fecha_inicial,' ENTRE ',fecha_final) AS ultima
			FROM liquidacion_guias_cliente 
			WHERE  cliente_id=$cliente_id AND estado != 'A' ORDER BY fecha_final DESC LIMIT 1" ;
		//echo $select;
		$result = $this -> DbFetchAll($select,$Conex,true);

			return $result[0][ultima];			
		
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