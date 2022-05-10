<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleAnticiposProveedorModel extends Db{

   public function getDataplaca($proveedor_id,$Conex){
    
	  $select = "SELECT $proveedor_id as proveedor_id, CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social)as nombre FROM tercero WHERE tercero_id = (SELECT tercero_id FROM proveedor WHERE proveedor_id = $proveedor_id)";
      $data   = $this -> DbFetchAll($select,$Conex);	  
	  
	  return $data;   
   
   }
   

   public function getAnticiposProveedor($proveedor_id,$Conex){
   
     $select    = "SELECT * FROM anticipos_proveedor WHERE proveedor_id = $proveedor_id AND devolucion=0 ORDER BY anticipos_proveedor_id desc";
     $anticipos = $this -> DbFetchAll($select,$Conex);
	 	 
     for($i = 0; $i < count($anticipos); $i++){
	 
	    $forma_pago_id    = $anticipos[$i]['forma_pago_id'];		
		
		if(is_numeric($forma_pago_id)){
		  $cuentasFormaPago = $this -> selectCuentasFormasPago($forma_pago_id,$Conex);		
		  $anticipos[$i]['cuentas_forma_pago'] = $cuentasFormaPago;				
		}else{
		     $anticipos[$i]['cuentas_forma_pago'] = array();						
		  }
		
	 
	 }
	 
   return  $anticipos;  
   
   }

   public function getRegDataplaca($proveedor_id,$Conex){
   
     $select    = "SELECT (MAX(numero)+1) AS numeros FROM anticipos_proveedor WHERE proveedor_id = $proveedor_id AND devolucion=0 ";
     $anticipos_num = $this -> DbFetchAll($select,$Conex);
	 if($anticipos_num[0][numeros]>0){
		 $anticipos=$anticipos_num[0][numeros];
	 }else{
	 	$anticipos=1;
	 }
   	 return  $anticipos;  
   
   }

 
   public function getFormasPago($Conex){
  
    $select = "SELECT * FROM forma_pago ORDER BY nombre ASC";
    $result = $this -> DbFetchAll($select,$Conex);	
	
	return $result;
  
  } 
  
  public function getTiposAnticipo($Conex){
  
    $select = "SELECT * FROM parametros_anticipo_proveedor ORDER BY nombre ASC";
    $result = $this -> DbFetchAll($select,$Conex);	
	
	return $result;
  
  } 
  public function Anular($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){
    $this -> Begin($Conex);
	exit("******");
     $anticipos_proveedor_id           = $this -> requestData('anticipos_proveedor_id');
	 $encabezado_registro_id       = $this -> requestData('encabezado_registro_id');
	 
	 $select1     = "SELECT COUNT(*) AS movi FROM relacion_anticipos_abono  WHERE anticipos_proveedor_id = $anticipos_proveedor_id";
	 $result1     = $this -> DbFetchAll($select1,$Conex,true);	
	 $movimientos1 = $result1[0]['movi'];
	 
	 if(!$movimientos1>0){
	 
	 
		 $update="UPDATE  anticipos_proveedor SET estado='A' WHERE anticipos_proveedor_id=$anticipos_proveedor_id";
		 $this -> query($update,$Conex,true);   
	
		 if($this -> GetNumError() > 0){
			return false;
		 }else{
			if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){	 
			  
			  $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
			  encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
			  forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
			  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,3 AS causal_anulacion_id,
			  'ERROR DIGITACION' AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
			
			  $this -> query($insert,$Conex,true);
			
			  if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			  }else{
				$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
			imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
			encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id FROM 
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
			  
		 }						  	 
	  
	 }else{
	  $this -> Rollback($Conex); 
	  exit('Este anticipo ya esta Cruzado en un Pago.<br> Por favor elimine o anule el pago primero.');
		 
	 }
  }

  public function Delete($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){
    $this -> Begin($Conex);
     $anticipos_proveedor_id           = $this -> requestData('anticipos_proveedor_id');
	 $encabezado_registro_id       = $this -> requestData('encabezado_registro_id');
	 
	 $select1     = "SELECT COUNT(*) AS movi FROM relacion_anticipos_abono  WHERE anticipos_proveedor_id = $anticipos_proveedor_id";
	 $result1     = $this -> DbFetchAll($select1,$Conex,true);	
	 $movimientos1 = $result1[0]['movi'];
	 
	 if(!$movimientos1>0){
		 $delete="DELETE FROM   anticipos_proveedor WHERE anticipos_proveedor_id=$anticipos_proveedor_id AND devolucion=0 ";
		 $this -> query($delete,$Conex,true);   
	
		 if($this -> GetNumError() > 0){
			return false;
		 }else{
			if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){	 
			
			  $select     = "SELECT COUNT(*) AS movi FROM imputacion_contable_anulada WHERE encabezado_registro_anulado_id = $encabezado_registro_id";
			  $result     = $this -> DbFetchAll($select,$Conex,true);	
			  
			  $movimientos = $result[0]['movi'];
			  if($movimientos>0){
				  $delete = "DELETE FROM  imputacion_contable_anulada  WHERE encabezado_registro_anulado_id = $encabezado_registro_id";
				  $this -> query($delete,$Conex,true);
				  
				  if(strlen($this -> GetError()) > 0){
					$this -> Rollback($Conex);
					return false;
				  }
		
				  $delete = "DELETE FROM  encabezado_de_registro_anulado  WHERE encabezado_registro_anulado_id = $encabezado_registro_id";
				  $this -> query($delete,$Conex,true);
	
				  if(strlen($this -> GetError()) > 0){
					$this -> Rollback($Conex);
					return false;
				  }
	
			  }
			  
			  $delete = "DELETE FROM  imputacion_contable  WHERE encabezado_registro_id = $encabezado_registro_id";
			  $this -> query($delete,$Conex,true);
	
			  
			  if(strlen($this -> GetError()) > 0){ 		
				$this -> Rollback($Conex);
				return false;
				
			  }else{
				  $delete = "DELETE FROM  encabezado_de_registro  WHERE encabezado_registro_id = $encabezado_registro_id";
				  $this -> query($delete,$Conex,true);
				if(strlen($this -> GetError()) > 0){
				  $this -> Rollback($Conex); 
				  return false;
				
				}else{	
				   $this -> Commit($Conex);	
				}
			
			   }
			}else{
	
			   $this -> Commit($Conex);		
			}
			  
		 }						  	 
	 }else{
		 
	  $this -> Rollback($Conex); 
	  exit('Este anticipo ya esta Cruzado en un Pago.<br> Por favor elimine el pago primero.');
	 }
 
  }

  public function save($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){

    require_once("UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();

    $this -> Begin($Conex);
  
     $encabezado_registro_id  = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,false,1);	  
	 $anticipos_proveedor_id  	  = $this -> DbgetMaxConsecutive("anticipos_proveedor","anticipos_proveedor_id",$Conex,false,1);	  
     $fecha_egreso            = $this -> requestData('fecha_egreso');
	 //$placa			          = $this -> requestData('placa');
	 $proveedor_id			      = $this -> requestData('proveedor_id');
	 //$propio			      = $this -> requestData('propio');
     $forma_pago_id           = $this -> requestData('forma_pago_id');
	 $consecutivo          	  = $this -> requestData('consecutivo');
	 $numero_soporte          = $this -> requestData('numero_soporte');
	 $cuenta_tipo_pago        = $this -> requestData('cuenta_tipo_pago');
	 $numero                  = $this -> requestData('numero');
	 $valor                   = $this -> requestDataForQuery('valor','numeric');
	 $parametros_anticipo_proveedor_id 			  = $this -> requestData('parametros_anticipo_proveedor_id');	 
//	 $tenedor_id 			  = $this -> requestData('tenedor_id');
	 $nombre 			      = $this -> requestData('nombre');	 
	// $tenedor 			      = $this -> requestData('tenedor');
	 $observaciones 		  = $this -> requestData('observaciones');

	   
	 
	
	     $select = "SELECT tercero_id FROM proveedor WHERE proveedor_id = $proveedor_id";
         $result = $this -> DbFetchAll($select,$Conex,true);		  		 
		 //echo $select;
	     $tercero_id = $result[0]['tercero_id'];		 

	     if(!count($tercero_id) > 0){
	       exit("Error al obtener datos del proveedor !!");
	     }	  
	
	  
	  

	$periodo_contable_id     = $utilidadesContables -> getPeriodoContableId($fecha_egreso,$Conex);
	$mes_contable_id         = $utilidadesContables -> getMesContableId($fecha_egreso,$periodo_contable_id,$Conex);	
	$concepto                =  "ANTICIPO PROVEEDOR  $nombre " ;
	$estado                  = "C";
	$fecha_registro          = date("Y-m-d H:m");
	$modifica                = $modifica;
	$usuario_id              = $usuario_id;
	$id_documento_fuente     = $anticipos_proveedor_id;
	$anulado                 = "0";

	$select = "SELECT * FROM parametros_anticipo_proveedor WHERE parametros_anticipo_proveedor_id = $parametros_anticipo_proveedor_id"; 
	$result = $this -> DbFetchAll($select,$Conex,true);			
	
	
	if(!count($result) > 0){
	  exit("No se ha configurado el parametro anticipos a proveedor!!");
	}

	$tipo_documento_id = $result[0]['tipo_documento_id'];	
	$parametros_anticipo_proveedor_id = $result[0]['parametros_anticipo_proveedor_id'];	
	if($consecutivo!=''){
		$select1 = "SELECT * FROM encabezado_de_registro WHERE consecutivo = $consecutivo AND tipo_documento_id=$tipo_documento_id"; 
		$result1 = $this -> DbFetchAll($select1,$Conex,true);			
		if(count($result1) > 0){
		  exit("Ya existe un Consecutivo igual para el Tipo de Documento!!");
		}

		/*$select1 = "SELECT MAX(consecutivo) AS max_cons FROM encabezado_de_registro WHERE  tipo_documento_id=$tipo_documento_id"; 
		$result1 = $this -> DbFetchAll($select1,$Conex,true);			
		if($result1[0][max_cons] <= $consecutivo ){
		  exit("El Consecutivo digitado. No puede superar el Consecutivo actual!!");
		}*/

	}
 	$consecutivo   = $consecutivo!='' ? $consecutivo : $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);	
    $insert = "INSERT INTO  encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,forma_pago_id,valor,numero_soporte,
   tercero_id,periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,
   numero_documento_fuente,id_documento_fuente,anulado) VALUES ($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$forma_pago_id,$valor,'$numero_soporte',
   $tercero_id,$periodo_contable_id,$mes_contable_id,$consecutivo,'$fecha_egreso','$concepto','$estado','$fecha_registro','$modifica',$usuario_id,
   '$numero_documento_fuente',$id_documento_fuente,0);";	
   
   $this -> query($insert,$Conex,true);   
	
   $select = "SELECT * FROM parametros_anticipo_proveedor WHERE oficina_id = $oficina_id"; 
	
    $result            = $this -> DbFetchAll($select,$Conex,true);		
	
	if(!count($result)>0){
		exit("No se han configurado los parametros de anticipos para esta oficina!!!");
	}
	$tipo_documento_id = $result[0]['tipo_documento_id'];
	$puc_id            = $result[0]['puc_id'];	
	$naturaleza        = $result[0]['naturaleza'];	
	
	if($naturaleza == 'D'){
	  $debito  = $valor;
	  $credito = 0;
	}else{
	    $debito  = 0;
	    $credito = $valor;	
	  }
	
	$select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
    $result = $this -> DbFetchAll($select,$Conex,true);	
	
	$centro_de_costo_id  = $result[0]['centro_de_costo_id'];	
    $codigo_centro_costo = "'".$result[0]['codigo']."'";
	
	
	
	
	if(!count($centro_de_costo_id) > 0){
	  exit("Esta oficina no tiene un centro de costo asignado aun !!");
	}
	
	
	 if($utilidadesContables -> requiereTercero($puc_id,$Conex)){
	 
	  $select = "SELECT * FROM tercero WHERE tercero_id = $tercero_id";
	  $result = $this  -> DbFetchAll($select,$Conex,true);			   
	
	  $tercero_imputacion_id            = $result[0]['tercero_id'];					 
	  $numero_identificacion_imputacion = $result[0]['numero_identificacion'];					 
	  $digito_verificacion_imputacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';					
	  
	 }else{
		  $tercero_imputacion_id            = 'NULL';					 
		  $numero_identificacion_imputacion = 'NULL';					 
		  $digito_verificacion_imputacion   = 'NULL';	
	   }  					 
	 
	 if($utilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
	   $centro_de_costo_imputacion_id  = $centro_de_costo_id ;
	   $codigo_centro_costo_imputacion = $codigo_centro_costo;
	 }else{
		 $centro_de_costo_imputacion_id  = 'NULL';
		 $codigo_centro_costo_imputacion = 'NULL';					 
	   }	
	

    $descripcion = strlen($observaciones)>0 ? $observaciones : "ANTICIPO $numero PROVEEDOR $nombre";	
	
	$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				
	
	$insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
	 VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_id,$encabezado_registro_id,$centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,0,$valor,$debito,$credito,'$descripcion');";
	  
	$this -> query($insert,$Conex,true);
		
	if($this -> GetNumError() > 0){
	  return false;
	}						  
					  
	$select = "SELECT puc_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id = $cuenta_tipo_pago";
    $result = $this -> DbFetchAll($select,$Conex,true);	
	
	$puc_contrapartida_id = $result[0]['puc_id'];
	
	$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				
	
	$debito  = 0;
	$credito = $valor;
	
	
	 if($utilidadesContables -> requiereTercero($puc_contrapartida_id,$Conex)){
	 
	  $select = "SELECT * FROM tercero WHERE tercero_id = $tercero_id";
	  $result = $this  -> DbFetchAll($select,$Conex,true);			   
	
	  $tercero_imputacion_id            = $result[0]['tercero_id'];					 
	  $numero_identificacion_imputacion = $result[0]['numero_identificacion'];					 
	  $digito_verificacion_imputacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';					 					 
	  
	 }else{
		  $tercero_imputacion_id            = 'NULL';					 
		  $numero_identificacion_imputacion = 'NULL';					 
		  $digito_verificacion_imputacion   = 'NULL';	
	   }  					 
	 
	 if($utilidadesContables -> requiereCentroCosto($puc_contrapartida_id,$Conex)){
	   $centro_de_costo_imputacion_id  = $centro_de_costo_id ;
	   $codigo_centro_costo_imputacion = $codigo_centro_costo;
	 }else{
		 $centro_de_costo_imputacion_id  = 'NULL';
		 $codigo_centro_costo_imputacion = 'NULL';					 
	   }	
	
	$insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
	 VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_contrapartida_id,$encabezado_registro_id,$centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,0,$valor,$debito,$credito,'$descripcion')";
	  
	$this -> query($insert,$Conex,true);
		
	if($this -> GetNumError() > 0){
	  return false;
	}	
	
	
   $insert = "INSERT INTO  anticipos_proveedor (anticipos_proveedor_id,parametros_anticipo_proveedor_id,consecutivo,fecha,oficina_id,proveedor_id,numero,proveedor,valor,estado,forma_pago_id,cuenta_tipo_pago_id,encabezado_registro_id,numero_soporte,fecha_egreso,observaciones)VALUES 
   ($anticipos_proveedor_id,$parametros_anticipo_proveedor_id,$consecutivo,'$fecha_egreso',$oficina_id,$proveedor_id,$numero,'$nombre',$valor,'P',$forma_pago_id,$cuenta_tipo_pago,$encabezado_registro_id,'$numero_soporte','$fecha_registro','$observaciones')";

   $this -> query($insert,$Conex,true);			  		
	
		
	$this -> Commit($Conex);
	
	$select = "SELECT * FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
    $result = $this -> DbFetchAll($select,$Conex,true);		
	
	$tipo_de_documento = $result[0]['nombre'];
	
	return array(encabezado_registro_id => $encabezado_registro_id,tipo_de_documento => $tipo_de_documento,consecutivo => $consecutivo,fecha_egreso 
	             => $fecha_egreso);
	    	 
  
  }
  
  public function selectCuentasFormasPago($forma_pago_id,$Conex){
  
    $select = "SELECT cuenta_tipo_pago_id AS value,(SELECT nombre FROM puc WHERE puc_id = c.puc_id) AS text FROM cuenta_tipo_pago c 
	WHERE forma_pago_id = $forma_pago_id AND cuenta_tipo_pago_natu = 'C'";
    $result = $this -> DbFetchAll($select,$Conex,true);		
	
	return $result;
  
  }
 
}



?>