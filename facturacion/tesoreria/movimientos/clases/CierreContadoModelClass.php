<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CierreContadoModel extends Db{

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
			0=>array('value'=>'E','text'=>'EDICION'),
			1=>array('value'=>'C','text'=>'CONTABILIZADO'),
			2=>array('value'=>'A','text'=>'ANULADO')
		);
		return $opciones;
	}

   public function GetTipoPago($Conex){
	return $this -> DbFetchAll("SELECT c.cuenta_tipo_pago_id AS value, CONCAT_WS(' - ',(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id ),(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id )) AS text FROM cuenta_tipo_pago c",$Conex,
	$ErrDb = false);
   }

   public function GetDocumento($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento WHERE pago_factura=1",$Conex,
	$ErrDb = false);
   }

	public function getConsecutivo($OficinaId,$Conex){

		$select="SELECT MAX(consecutivo) AS consecutivo FROM cierre_contado WHERE oficina_id=$OficinaId";
		$result = $this -> DbFetchAll($select,$Conex);
		$consecutivo = $result[0][consecutivo];
		if($consecutivo=='' || $consecutivo=='NULL'){$consecutivo=0;}
		$consecutivo++;
		return $consecutivo;
	}

	public function getConsecutivoReal($cierre_contado_id,$Conex){

		$select="SELECT consecutivo FROM cierre_contado WHERE cierre_contado_id=$cierre_contado_id";
		$result = $this -> DbFetchAll($select,$Conex);
		$consecutivo = $result[0][consecutivo];
		return $consecutivo;
	}


	public function Save($Campos,$usuario_id,$oficina_id,$consecutivo,$estado,$Conex){

		$cierre_contado_id = $this -> DbgetMaxConsecutive('cierre_contado','cierre_contado_id',$Conex,true,1);
		$fecha_registro  = date('Y-m-d H:m');	
		$this -> assignValRequest('fecha_registro',$fecha_registro);			
		$this -> assignValRequest('cierre_contado_id',$cierre_contado_id);
		$this -> assignValRequest('consecutivo',$consecutivo);			
		$this -> assignValRequest('oficina_id',$oficina_id);
		$this -> assignValRequest('usuario_id',$usuario_id);
		$this -> assignValRequest('estado',$estado);
		$desde  = $_REQUEST['fecha_inicial'];				
		$hasta  = $_REQUEST['fecha_final'];							
		
		$this -> Begin($Conex);
		$this -> DbInsertTable("cierre_contado",$Campos,$Conex,true,false);
		
		
		$this -> Commit($Conex);
		
		return $cierre_contado_id;
	}


	public function cancellation($cierre_contado_id,$observacion_anulacion,$fecha_anulacion,$usuario_anulo_id,$Conex){ 

		$this -> Begin($Conex);


			$anular = "UPDATE remesa SET cierre = 0 
			WHERE remesa_id IN (SELECT remesa_id FROM detalle_cierre_contado WHERE cierre_contado_id=$cierre_contado_id) 
			AND cierre = 1";
			$this -> query($anular,$Conex,true);//verificar que no este en otra


			$anula="UPDATE cierre_contado SET estado = 'A', fecha_anulacion='$fecha_anulacion', observacion_anulacion='$observacion_anulacion', usuario_anulo_id = $usuario_anulo_id 
			WHERE cierre_contado_id = $cierre_contado_id";
			$this -> query($anula,$Conex,true);

		$this -> Commit($Conex);
		return $cierre_contado_id;
	}

	public function selectCierreContado($cierre_contado_id,$Conex){

		$select="SELECT	*
			FROM cierre_contado 
			WHERE cierre_contado_id = $cierre_contado_id
		";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}


	public function getValorPorFacturado($cierre_contado_id,$Conex){

		$select="SELECT SUM(valor_liquida) AS valor
			FROM detalle_cierre_contado dc,  detalle_remesa_puc dr
			WHERE  dc.cierre_contado_id=$cierre_contado_id AND dr.remesa_id=dc.remesa_id AND dr.contra=1";
		//echo $select;
		$result = $this -> DbFetchAll($select,$Conex,true);
		$valor = $result[0]['valor'];
		
		$update = "UPDATE cierre_contado SET valor = $valor	WHERE cierre_contado_id=$cierre_contado_id";
		$this -> query($update,$Conex,true);
		

		if($result[0][valor]>0){
			return $result[0][valor];			
		}else{
			return 0;			
		}

	}

  public function contabilizar($empresa_id,$modifica,$usuario_id,$Conex){
						
	$this -> Begin($Conex);
	
    require_once("UtilidadesContablesModelClass.php");	
	$UtilidadesContables = new UtilidadesContablesModel();
							
	$encabezado_registro_id     = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,false,1);		
	$cierre_contado_id = $this -> requestData('cierre_contado_id');
	
	
	$select = "SELECT c.*, 
	(SELECT forma_pago_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id=c.cuenta_tipo_pago_id) AS  forma_pago_id,
	(SELECT cc.centro_de_costo_id  FROM cuenta_tipo_pago ct, centro_de_costo cc WHERE ct.cuenta_tipo_pago_id=c.cuenta_tipo_pago_id AND cc.oficina_id=ct.oficina_id LIMIT 1) AS  centro_de_costo_id,	
	(SELECT cc.codigo  FROM cuenta_tipo_pago ct, centro_de_costo cc WHERE ct.cuenta_tipo_pago_id=c.cuenta_tipo_pago_id AND cc.oficina_id=ct.oficina_id LIMIT 1) AS  codigo,		
	(SELECT puc_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id=c.cuenta_tipo_pago_id) AS  puc_id	
	FROM cierre_contado c WHERE c.cierre_contado_id = $cierre_contado_id";
	$dataCierre = $this  -> DbFetchAll($select,$Conex,true);						
	
	$oficina_id = $dataCierre[0]['oficina_id'];
	$tipo_documento_id = $dataCierre[0]['tipo_documento_id'];
	$numero_soporte = $dataCierre[0]['consecutivo'];
	$numero_documento_fuente = $dataCierre[0]['consecutivo'];
	$id_documento_fuente     = $cierre_contado_id;	
	$fecha = $dataCierre[0]['fecha_inicial'];
	$puc_forma = $dataCierre[0]['puc_id'];
	$fecha_registro         = date("Y-m-d");
	$fecha_registro1         = date("Y-m-d H:i");

	$forma_pago_id           = $dataCierre[0]['forma_pago_id'];   		   
	$concepto                = "Cierre Remesas Contado No: ". $dataCierre[0]['consecutivo'];
	$fuente_servicio_cod     = 'CR';		   
	$estado                  = 'C';
	if($dataCierre[0]['fecha_inicial']!=$dataCierre[0]['fecha_final']){
		$observaciones           = "Rango: ".$dataCierre[0]['fecha_inicial']." al ".$dataCierre[0]['fecha_final'];   	
		$descripcion_diferencia = "Cierre Remesas Contado No: ". $dataCierre[0]['consecutivo'].". Rango: ".$dataCierre[0]['fecha_inicial']." al ".$dataCierre[0]['fecha_final'];
	}else{
		$observaciones           = "Fecha: ".$dataCierre[0]['fecha_inicial'];   		   		
		$descripcion_diferencia =  "Cierre Remesas Contado No: ". $dataCierre[0]['consecutivo'].". Fecha: ".$dataCierre[0]['fecha_inicial'];
	}

		   
	$select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id)";
  	$result = $this  -> DbFetchAll($select,$Conex,true);			   
		   
	$tercero_id            = $result[0]['tercero_id'];		   		   
	$tercero_diferencia_id = $result[0]['tercero_id'];	
	$numero_identificacion = $result[0]['numero_identificacion'];
	$digito_verificacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';		   		   
		   		   
	$select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
  	$result = $this  -> DbFetchAll($select,$Conex,true);			   
		   
	$centro_de_costo_id      = $dataCierre[0]['centro_de_costo_id']>0 ? $dataCierre[0]['centro_de_costo_id'] : $result[0]['centro_de_costo_id'];
	$codigo_centro_costo     = $dataCierre[0]['centro_de_costo_id']>0 ? "'".$dataCierre[0]['codigo']."'" : "'".$result[0]['codigo']."'";		   
	
		
		   
	$periodo_contable_id = $UtilidadesContables -> getPeriodoContableId($fecha,$Conex); 
	$mes_contable_id     = $UtilidadesContables -> getMesContableId($fecha,$periodo_contable_id,$Conex); 
	$consecutivoRegistro = $UtilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);
	
	$valor = 0;
	//falta actualizar valor en encabezado
	$insert = "INSERT INTO  encabezado_de_registro 	 
		(encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,
	   numero_documento_fuente,id_documento_fuente,anulado,observaciones) VALUES ($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,
	   $valor,'$numero_soporte',$tercero_id,$periodo_contable_id,$mes_contable_id,$consecutivoRegistro,'$fecha',
	   '$concepto','$estado','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente,0,'$observaciones')";
	   
	$this -> query($insert,$Conex,true);
	   
	$update = "UPDATE cierre_contado 
	SET encabezado_registro_id = $encabezado_registro_id, estado='C', usuario_cont_id= $usuario_id, fecha_cont='$fecha_registro1'
	WHERE cierre_contado_id  = $cierre_contado_id";
    $this -> query($update,$Conex,true);		   
		   
	if(!$this -> GetNumError() > 0){
		   
		 $select = "SELECT * FROM detalle_cierre_contado dc, remesa r, detalle_remesa_puc dp 
		 WHERE dc.cierre_contado_id= $cierre_contado_id AND r.remesa_id=dc.remesa_id AND dp.remesa_id=r.remesa_id AND dp.contra=1";
		 $result = $this  -> DbFetchAll($select,$Conex,true);					
					
		 $totalDebito                           = 0;
		 $totalCredito                          = 0;
		 $totalDebito1                           = 0;
		 $totalCredito1                          = 0;
				 	
	     if(is_array($result)){
	
	
			 for($i = 0; $i < count($result); $i++){


				 $puc_id            = $result[$i]['puc_id'];

				 $tercero_imputacion_id              = $result[$i]['tercero_id'];
				 $numero_identificacion_imputacion   = $result[$i]['numero_identificacion']!='' ? $result[$i]['numero_identificacion'] : 'NULL';
				 $digito_verificacion_imputacion     = $result[$i]['digito_verificacion']!='' ? $result[$i]['digito_verificacion'] : 'NULL';		   		   
				 $centro_de_costo_imputacion_id      = $result[$i]['centro_de_costo_id'];
				 $codigo_centro_costo_imputacion     = $result[$i]['codigo_centro_costo'];
				 $valor								 = $result[$i]['valor_liquida'];

				 $debito							 = $result[$i]['credito'];
				 $credito							 = $result[$i]['debito'];

				 $totalDebito1                           = $result[$i]['credito']+$totalDebito1;
				 $totalCredito1                          = $result[$i]['debito']+$totalCredito1;

				 $totalDebito                           = $result[$i]['debito']+$totalDebito;
				 $totalCredito                          = $result[$i]['credito']+$totalCredito;
				 $descripcion							= "Cierre Remesa: ".$result[$i]['prefijo_tipo'].''.$result[$i]['prefijo_oficina'].'-'.$result[$i]['numero_remesa'];
				 
				 $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				
				 
			
				 $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,debito,credito,descripcion) 
				 VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_id,$encabezado_registro_id,$centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,$valor,$debito,$credito,'$descripcion')";
				  
				  $this -> query($insert,$Conex,true);
					
				  if($this -> GetNumError() > 0){
					return false;
				  }	

				 
			 }
			 
			 //CUENTA DONDE ENTRA LA PLATA

			 if(($totalDebito1==$totalCredito && $totalDebito1>0  && $totalCredito1== $totalDebito  && $totalCredito1==0) || ($totalDebito1==$totalCredito && $totalDebito1==0  && $totalCredito1== $totalDebito  && $totalCredito1>0)){

				 $debito	= $totalDebito;
				 $credito	= $totalCredito;
				 $valor		= $debito+$credito;

				 $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);	
				 $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,debito,credito,descripcion) 
						 VALUES ($imputacion_contable_id,NULL,NULL,NULL,$puc_forma,$encabezado_registro_id, $centro_de_costo_id,$codigo_centro_costo,$valor,$debito,$credito,'$descripcion_diferencia')";					  
						 
				  $this -> query($insert,$Conex,true);
							
				  if($this -> GetNumError() > 0){
					$this -> RollBack($Conex);	
					return false;
				  }else{
					$this -> Commit($Conex);
					return $cierre_contado_id;
				  	
				  }
			 }else{
				exit('No existen Sumas Iguales para Contabilizar'); 	 
			 }
		 }else{
			exit('No existen Remesas Asociadas'); 
		 }
		 
	}
	
  }

}
?>