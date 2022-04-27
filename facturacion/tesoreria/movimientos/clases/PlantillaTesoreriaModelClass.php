<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PlantillaTesoreriaModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosPlantillaTesoreriaId($plantilla_tesoreria_id,$Conex){
	$select = "SELECT p.tipo_bien_servicio_teso_id,p.fecha_plantilla_tesoreria,p.proveedor_id, p.estado_plantilla_tesoreria, p.plantilla_tesoreria_id,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM proveedor pr, tercero t WHERE pr.proveedor_id=p.proveedor_id AND t.tercero_id=pr.tercero_id) AS proveedor,
	(SELECT CONCAT_WS(' ',t.numero_identificacion,t.digito_verificacion) FROM proveedor pr, tercero t WHERE pr.proveedor_id=p.proveedor_id AND t.tercero_id=pr.tercero_id) AS proveedor_nit,	
	p.codplantilla_tesoreria,p.valor_plantilla_tesoreria,p.encabezado_registro_id, p.cheques, p.cheques_ids,
	p.concepto_plantilla_tesoreria,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=p.encabezado_registro_id) AS numero_soporte
	FROM plantilla_tesoreria p WHERE p.plantilla_tesoreria_id = $plantilla_tesoreria_id";     
    $result = $this -> DbFetchAll($select,$Conex);
    return $result;  
  }

  public function Save($Campos,$Conex,$usuario_id,$oficina_id){	

    $this -> Begin($Conex);
					
	  $plantilla_tesoreria_id 	 	= $this -> DbgetMaxConsecutive("plantilla_tesoreria","plantilla_tesoreria_id",$Conex,true,1);
  	  $numero_soporte 			 	= $this -> requestDataForQuery('numero_soporte','alphanum');
  	  $cheques 			 			= $this -> requestDataForQuery('cheques','text');	 
  	  $cheques_ids		 			= $this -> requestDataForQuery('cheques_ids','text');	 	  
	  $fecha_plantilla_tesoreria 	= $this -> requestDataForQuery('fecha_plantilla_tesoreria','date');		  
	  $ingreso_plantilla_tesoreria 	= $this -> requestDataForQuery('ingreso_plantilla_tesoreria','date');
	  $valor_plantilla_tesoreria	= $this -> requestDataForQuery('valor_plantilla_tesoreria','numeric');
	  $proveedor_id 				= $this -> requestDataForQuery('proveedor_id','integer');
	  $forma_pago_id 				= $this -> requestDataForQuery('forma_pago_id','integer');	  
	  $tipo_bien_servicio_teso_id 	= $this -> requestDataForQuery('tipo_bien_servicio_teso_id','integer');			  
	  $codplantilla_tesoreria 		= $this -> requestDataForQuery('codplantilla_tesoreria','alphanum');
	  $concepto_plantilla_tesoreria	= $this -> requestDataForQuery('concepto_plantilla_tesoreria','text');	  
	  
	  
	  
	  $insert = "INSERT INTO plantilla_tesoreria (plantilla_tesoreria_id,cheques,cheques_ids,codplantilla_tesoreria,valor_plantilla_tesoreria,fecha_plantilla_tesoreria,concepto_plantilla_tesoreria,proveedor_id,forma_pago_id,
	  tipo_bien_servicio_teso_id,estado_plantilla_tesoreria,usuario_id,oficina_id,ingreso_plantilla_tesoreria,con_usuario_id,con_fecha_plantilla_tesoreria) 
      VALUES ($plantilla_tesoreria_id,$cheques,$cheques_ids,$codplantilla_tesoreria,$valor_plantilla_tesoreria,$fecha_plantilla_tesoreria,$concepto_plantilla_tesoreria,$proveedor_id,$forma_pago_id,
	  $tipo_bien_servicio_teso_id,'A',$usuario_id,$oficina_id,$ingreso_plantilla_tesoreria,$usuario_id,$ingreso_plantilla_tesoreria)"; 

	  $this -> query($insert,$Conex);
	 
	  if($_REQUEST['cheques_ids']!='' && $_REQUEST['cheques_ids']!=NULL && $_REQUEST['cheques_ids']!='NULL' && $_REQUEST['cheques_ids']!='null'){
		  $cheques1 		= explode(',',$_REQUEST['cheques']);	 
		  if($cheques1[0]=='')  $cheques1[0]= $_REQUEST['cheques'];
		  $cheques1_ids		= explode(',',$_REQUEST['cheques_ids']);	
		  if($cheques1_ids[0]=='')  $cheques1_ids[0]= $_REQUEST['cheques_ids'];	  

		  for($j=0;$j<count($cheques1_ids);$j++){
			  $update="UPDATE abono_factura SET estado_cheque='C' WHERE abono_factura_id=".$cheques1_ids[$j]." AND num_cheque='".$cheques1[$j]."' ";
			  $this -> query($update,$Conex);
			
		  }
	  }
	
	  
	  $this -> Commit($Conex);		 
	  return $plantilla_tesoreria_id;
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);

	  if($_REQUEST['plantilla_tesoreria_id'] != 'NULL'){
		$plantilla_tesoreria_id 		= $this -> requestDataForQuery('plantilla_tesoreria_id','integer');	
		$fuente_servicio_cod 			= $this -> requestDataForQuery('fuente_servicio_cod','alphanum');
	  	$cheques 			 			= $this -> requestDataForQuery('cheques','text');	 
  	  	$cheques_ids		 			= $this -> requestDataForQuery('cheques_ids','text');	 	  

		$fecha_plantilla_tesoreria 		= $this -> requestDataForQuery('fecha_plantilla_tesoreria','date');		  
		$vence_plantilla_tesoreria 		= $this -> requestDataForQuery('vence_plantilla_tesoreria','date');	
		$forma_pago_id					= $this -> requestDataForQuery('forma_pago_id','integer');	
		$usuario_id						= $this -> requestDataForQuery('usuario_id','integer');			
		$oficina_id						= $this -> requestDataForQuery('oficina_id','integer');		  
		$ingreso_plantilla_tesoreria	= $this -> requestDataForQuery('ingreso_plantilla_tesoreria','date');	
		$concepto_plantilla_tesoreria	= $this -> requestDataForQuery('concepto_plantilla_tesoreria','text');
		$codplantilla_tesoreria 	= $this -> requestDataForQuery('codplantilla_tesoreria','alphanum');

		$select = "SELECT cheques, cheques_ids	FROM plantilla_tesoreria p WHERE p.plantilla_tesoreria_id = $plantilla_tesoreria_id";     
		$result = $this -> DbFetchAll($select,$Conex);

		  if($result[0]['cheques_ids']!='' && $result[0]['cheques_ids']!=NULL && $result[0]['cheques_ids']!='NULL' && $result[0]['cheques_ids']!='null'){
			  $cheques1 		= explode(',',$result[0]['cheques']);	 
			  if($cheques1[0]=='')  $cheques1[0]= $result[0]['cheques'];
			  $cheques1_ids		= explode(',',$result[0]['cheques_ids']);	
			  if($cheques1_ids[0]=='')  $cheques1_ids[0]= $result[0]['cheques_ids'];	  
	
			  for($j=0;$j<count($cheques1_ids);$j++){
				  $update="UPDATE abono_factura SET estado_cheque='E' WHERE abono_factura_id=".$cheques1_ids[$j]." AND num_cheque='".$cheques1[$j]."' AND estado_abono_factura!='I'";
				  $this -> query($update,$Conex);
				
			  }
		  }


		$update = "UPDATE plantilla_tesoreria SET codplantilla_tesoreria=$codplantilla_tesoreria,cheques=$cheques,cheques_ids=$cheques_ids,fecha_plantilla_tesoreria=$fecha_plantilla_tesoreria,forma_pago_id=$forma_pago_id,
		concepto_plantilla_tesoreria=$concepto_plantilla_tesoreria
	    WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id"; 
		//echo $update;
		$this -> query($update,$Conex);

		  if($_REQUEST['cheques_ids']!='' && $_REQUEST['cheques_ids']!=NULL && $_REQUEST['cheques_ids']!='NULL' && $_REQUEST['cheques_ids']!='null'){
			  $cheques1 		= explode(',',$_REQUEST['cheques']);	 
			  if($cheques1[0]=='')  $cheques1[0]= $_REQUEST['cheques'];
			  $cheques1_ids		= explode(',',$_REQUEST['cheques_ids']);	
			  if($cheques1_ids[0]=='')  $cheques1_ids[0]= $_REQUEST['cheques_ids'];	  
	
			  for($j=0;$j<count($cheques1_ids);$j++){
				  $update="UPDATE abono_factura SET estado_cheque='C' WHERE abono_factura_id=".$cheques1_ids[$j]." AND num_cheque='".$cheques1[$j]."' ";
				  $this -> query($update,$Conex);
				
			  }
		  }

	  	if(!strlen(trim($this -> GetError())) > 0){
			$this -> Commit($Conex);
		}		
	  }
  }  
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"plantilla_tesoreria",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function cancellation($Conex){	 

	$this -> Begin($Conex);

      $plantilla_tesoreria_id 		  = $this -> requestDataForQuery('plantilla_tesoreria_id','integer');
      $causal_anulacion_id  		  = $this -> requestDataForQuery('causal_anulacion_id','integer');
      $anul_plantilla_tesoreria   	  = $this -> requestDataForQuery('anul_plantilla_tesoreria','text');
	  $desc_anul_plantilla_tesoreria  = $this -> requestDataForQuery('desc_anul_plantilla_tesoreria','text');
	  $anul_usuario_id          	  = $this -> requestDataForQuery('anul_usuario_id','integer');	

	  $select1 = "SELECT cheques, cheques_ids	FROM plantilla_tesoreria p WHERE p.plantilla_tesoreria_id = $plantilla_tesoreria_id";     
	  $result1 = $this -> DbFetchAll($select1,$Conex);
	
	  if($result1[0]['cheques_ids']!='' && $result1[0]['cheques_ids']!=NULL && $result1[0]['cheques_ids']!='NULL' && $result1[0]['cheques_ids']!='null'){
		  $cheques1 		= explode(',',$result1[0]['cheques']);	 
		  if($cheques1[0]=='')  $cheques1[0]= $result1[0]['cheques'];
		  $cheques1_ids		= explode(',',$result1[0]['cheques_ids']);	
		  if($cheques1_ids[0]=='')  $cheques1_ids[0]= $result1[0]['cheques_ids'];	  
	
		  for($j=0;$j<count($cheques1_ids);$j++){
			  $update="UPDATE abono_factura SET estado_cheque='E' WHERE abono_factura_id=".$cheques1_ids[$j]." AND num_cheque='".$cheques1[$j]."' AND estado_abono_factura!='I'";
			  $this -> query($update,$Conex);
			
		  }
	  }

	  $select = "SELECT  encabezado_registro_id FROM plantilla_tesoreria 
	  WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id";	
	  $result = $this -> DbFetchAll($select,$Conex); 
	  $encabezado_registro_id = $result[0]['encabezado_registro_id'];
	 
	  if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){	 
		  
		  $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		  encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,forma_pago_id,
		  valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		  $desc_anul_plantilla_tesoreria AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		
		  $this -> query($insert,$Conex,true);
	
		  if(strlen($this -> GetError()) > 0){
		  	$this -> Rollback($Conex);
		  }else{
			$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
			imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
			encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito FROM 
			imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
			  
			$this -> query($insert,$Conex,true);
			
			if(strlen($this -> GetError()) > 0){
			  $this -> Rollback($Conex);
			}else{	
			
			  $update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
			  $this -> query($update,$Conex,true);	
			  
			  if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			  }else{	
				
				$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
				$this -> query($update,$Conex);			  
				
				if(strlen($this -> GetError()) > 0){
				  $this -> Rollback($Conex);
				}else{		
				   $this -> Commit($Conex);			
				}
			  
				}			  
			  }	
		   }
	  }
	  
	  $update = "UPDATE plantilla_tesoreria SET estado_plantilla_tesoreria= 'I',causal_anulacion_id = $causal_anulacion_id,anul_plantilla_tesoreria=$anul_plantilla_tesoreria,
	  desc_anul_plantilla_tesoreria =$desc_anul_plantilla_tesoreria,anul_usuario_id=$anul_usuario_id WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id";	
      $this -> query($update,$Conex);		  
	
	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex);
	  }else{		
      	$this -> Commit($Conex);			
	  }  
  }

  public function getTotalDebitoCredito($plantilla_tesoreria_id,$Conex){
	  $select = "SELECT SUM(deb_item_plantilla_tesoreria) AS debito, SUM(cre_item_plantilla_tesoreria) AS credito 
	  FROM item_plantilla_tesoreria WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id";
      $result = $this -> DbFetchAll($select,$Conex);	  
	  return $result;   
  }

  public function getContabilizarReg($plantilla_tesoreria_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){	 
    include_once("UtilidadesContablesPlantillaTesoreriaModelClass.php");	  
	$utilidadesContables = new UtilidadesContablesPlantillaTesoreriaModel(); 	 
	 
	$this -> Begin($Conex);
		
		$select = "SELECT f.plantilla_tesoreria_id,f.tipo_bien_servicio_teso_id,f.valor_plantilla_tesoreria,f.codplantilla_tesoreria,f.fecha_plantilla_tesoreria,f.forma_pago_id,
		f.concepto_plantilla_tesoreria, (SELECT tercero_id FROM proveedor WHERE proveedor_id=f.proveedor_id) AS tercero,
		(SELECT tipo_documento_id FROM tipo_bien_servicio_teso WHERE tipo_bien_servicio_teso_id = f.tipo_bien_servicio_teso_id) AS tipo_documento
		FROM plantilla_tesoreria f WHERE f.plantilla_tesoreria_id = $plantilla_tesoreria_id";						
		$result 	= $this -> DbFetchAll($select,$Conex); 		

		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
		WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		$tipo_documento_id		= $result[0]['tipo_documento'];	
		$forma_pago_id			= $result[0]['forma_pago_id']>0 ? $result[0]['forma_pago_id'] : 'NULL';	
		$valor					= $result[0]['valor_plantilla_tesoreria'];
		$numero_soporte			= $result[0]['codplantilla_tesoreria'] !='' ? $result[0]['codplantilla_tesoreria'] : $result[0]['numero_soporte_ord'];	
		$tercero_id				= $result[0]['tercero'];		
		
	    $fechaMes                  = substr($result[0]['fecha_plantilla_tesoreria'],0,10);	
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	    $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);		
		
		$fecha					= $result[0]['fecha_plantilla_tesoreria'];
		$concepto				= $result[0]['concepto_plantilla_tesoreria'];
		$puc_id					= $result[0]['puc_contra']!='' ? $result[0]['puc_contra']:'NULL';
		$fecha_registro			= date("Y-m-d H:m");
		$modifica				= $result_usu[0]['usuario'];
		$numero_documento_fuente= $numero_soporte;
		$id_documento_fuente	= $result[0]['plantilla_tesoreria_id'];
		$con_fecha_planilla_tesoreria = $fecha_registro;	

		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,forma_pago_id,
        mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
		VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,$forma_pago_id,
		$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
		$this -> query($insert,$Conex);
		
		$select_item      = "SELECT item_plantilla_tesoreria_id FROM item_plantilla_tesoreria WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id";
		$result_item      = $this -> DbFetchAll($select_item,$Conex);
		foreach($result_item as $result_items){
		  $imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
		  $insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,
		  centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
		  SELECT $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_plantilla_tesoreria,$encabezado_registro_id,centro_de_costo_id,
		  codigo_centro_costo,(deb_item_plantilla_tesoreria+cre_item_plantilla_tesoreria),base_plantilla_tesoreria,porcentaje_plantilla_tesoreria,
		  formula_plantilla_tesoreria,deb_item_plantilla_tesoreria,cre_item_plantilla_tesoreria
		  FROM item_plantilla_tesoreria WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id AND item_plantilla_tesoreria_id=$result_items[item_plantilla_tesoreria_id]"; 
		  $this -> query($insert_item,$Conex);
		}
		
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{		
		
			$update = "UPDATE plantilla_tesoreria SET encabezado_registro_id=$encabezado_registro_id,estado_plantilla_tesoreria= 'C',
			con_usuario_id = $usuario_id,con_fecha_plantilla_tesoreria='$con_fecha_planilla_tesoreria' WHERE plantilla_tesoreria_id=$plantilla_tesoreria_id";	
			$this -> query($update,$Conex);		  
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);				
			}else{		
				$this -> Commit($Conex);
				return true;
			}  
	   }  
  }

  public function getCausalesAnulacion($Conex){	
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }
  
  public function getDataProveedor($proveedor_id,$Conex){
     $select = "SELECT tr.numero_identificacion AS proveedor_nit
	 FROM proveedor p, tercero tr WHERE p.proveedor_id=$proveedor_id AND tr.tercero_id = p.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);
     return $result;
  }   
  
  public function getTipoBienServicioTesoreria($oficina_id,$Conex){	  
	$select = "SELECT t.tipo_bien_servicio_teso_id AS value, t.nombre_bien_servicio_teso AS text FROM tipo_bien_servicio_teso t, tipo_bien_servicio_oficina_teso o 
	WHERE o.oficina_id = $oficina_id AND o.tipo_bien_servicio_teso_id = t.tipo_bien_servicio_teso_id ORDER BY t.nombre_bien_servicio_teso";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_plantilla_tesoreria,$Conex){	
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	  oficina_id = $oficina_id AND '$fecha_plantilla_tesoreria' BETWEEN fecha_inicio AND fecha_final";
      $result = $this -> DbFetchAll($select,$Conex);	  
	  $this -> mes_contable_id = $result[0]['mes_contable_id'];	  
	  return $result[0]['estado'] == 1 ? true : false;	  
  }
	
  public function PeriodoContableEstaHabilitado($Conex){	  
	 $mes_contable_id = $this ->  mes_contable_id;	 
	 if(!is_numeric($mes_contable_id)){
		return false;
     }else{		 
		$select = "SELECT estado FROM periodo_contable WHERE periodo_contable_id = (SELECT periodo_contable_id FROM mes_contable WHERE mes_contable_id = $mes_contable_id)";
		$result = $this -> DbFetchAll($select,$Conex);		 
		return $result[0]['estado'] == 1? true : false;		 
	  }	  
  }  

	public function getFormasPago($Conex){
		
		$select = "SELECT forma_pago_id AS value,nombre AS text FROM forma_pago ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
		
	}

  public function selectEstadoEncabezadoRegistro($plantilla_tesoreria_id,$Conex){ 
    $select = "SELECT estado_plantilla_tesoreria FROM plantilla_tesoreria WHERE plantilla_tesoreria_id = $plantilla_tesoreria_id";	  
	$result = $this -> DbFetchAll($select,$Conex); 
	$estado = $result[0]['estado_plantilla_tesoreria'];	
	return $estado;	  	  
  }  

  public function selectmanejacheque($tipo_bien_servicio_teso_id,$Conex){ 
    $select = "SELECT maneja_cheque FROM tipo_bien_servicio_teso WHERE tipo_bien_servicio_teso_id = $tipo_bien_servicio_teso_id";	  
	$result = $this -> DbFetchAll($select,$Conex); 
	if($result[0]['maneja_cheque']==1)	
		return 'true';	  	  
	else	
		return 'false';	  	  
  }  

  public function GetQueryPlantillaTesoreriaGrid($oficina_id){  	   
   $Query = "SELECT (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = f.encabezado_registro_id) AS consecutivo, f.fecha_plantilla_tesoreria, 
	f.codplantilla_tesoreria,f.concepto_plantilla_tesoreria,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS proveedor FROM tercero WHERE tercero_id=p.tercero_id) AS proveedor,
	(SELECT nombre_bien_servicio_teso FROM tipo_bien_servicio_teso WHERE tipo_bien_servicio_teso_id = f.tipo_bien_servicio_teso_id) AS tipo_servicio,f.valor_plantilla_tesoreria,
	CASE f.estado_plantilla_tesoreria WHEN 'A' THEN 'PAGA' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS estado_plantilla_tesoreria
	FROM plantilla_tesoreria f, proveedor p WHERE f.oficina_id=$oficina_id AND  p.proveedor_id=f.proveedor_id ORDER BY f.fecha_plantilla_tesoreria DESC LIMIT 0,200";		
   return $Query;
   }
}

?>