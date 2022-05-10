<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SeguimientoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function calcularImpuesto($valor_flete,$impuesto_id,$impuestos,$Conex){
  
       $anio   = date("Y");
       $select = "SELECT * FROM periodo_contable WHERE anio = $anio";
	   $result = $this -> DbFetchAll($select,$Conex,true);
	 
	   if(count($result) > 0){
	 
	     $periodo_contable_id = $result[0]['periodo_contable_id'];
	 
         $select = "SELECT t.*,i.*,ip.* FROM tabla_impuestos t, impuesto i,impuesto_periodo_contable ip WHERE t.impuesto_id = $impuesto_id AND t.impuesto_id = i.impuesto_id 
		 AND t.impuesto_id = ip.impuesto_id";
		 
 	     $result = $this -> DbFetchAll($select,$Conex,true);
	 	 
	     $monto             = $result[0]['monto'];	 
	     $base              = $result[0]['base'];
	     $porcentaje        = $result[0]['porcentaje'];
         $formula           = $result[0]['formula'];
	     $base_impuesto_id  = $result[0]['base_impuesto_id'];
	 			 
	     if($valor_flete > $monto){
	 
	       $formula    = str_replace("BASE","$valor_flete",$formula);
	       $formula    = str_replace("PORCENTAJE","$porcentaje",$formula);	 
	 
		   if($base == 'F'){
		 
		     $select = "SELECT $formula AS valor_impuesto";  
		     $result = $this -> DbFetchAll($select,$Conex,true);
				   
		      return array(valor => $result[0]['valor_impuesto'], base => $valor_flete);
		 
		   }else{
		  			
			 if(count($result) > 0){
			 
				 $base_impuesto_id = $result[0]['base_impuesto_id'];
				 				 
				 for($i = 0; $i < count($impuestos); $i++){
				  
					$impuesto_id_base = $impuestos[$i]['impuesto_id'];
				 				 
					if($impuesto_id_base == $base_impuesto_id){										
					   $valorBase = str_replace(",",".",str_replace(".","",$impuestos[$i]['valor']));
					   break;				   
					
					}
				 
				 }
				 
				 if(is_numeric($valorBase)){
				 
				 
	               if($valorBase > $monto){				 
				 
					   $formula  = str_replace("BASE","$valorBase",$formula);
					   $formula  = str_replace("PORCENTAJE","$porcentaje",$formula);	
					   
					   $select = "SELECT $formula AS valor_impuesto";  
					   $result = $this -> DbFetchAll($select,$Conex,true);
								   
					   return array(valor => $result[0]['valor_impuesto'], base => $valorBase);
				   
				   }else{
				   
				         return array(valor => 0, base => $valorBase);
				   
				     }			      			 			 
				 
				 }else{
				 
					 $select         = "SELECT i.*,(SELECT nombre FROM impuesto WHERE impuesto_id = $base_impuesto_id) AS impuesto_base 
					 FROM impuesto i WHERE impuesto_id = $impuesto_id";			 
					 $result         = $this -> DbFetchAll($select,$Conex,true);
					 
					 $nombreImpuesto = $result[0]['nombre'];				 
					 $impuesto_base  = $result[0]['impuesto_base'];				 
				 
					  exit("<div align='center'>El impuesto [ $nombreImpuesto ] tiene como base el impuesto [ $impuesto_base ], cuyo valor en esta liquidacion es cero (0)por favor verifique la Tabla de impuestos!!!</div>");
					  
				   }			           
	
			 
			 }else{
			 
				 $select = "SELECT i.*,(SELECT impuesto_periodo_contable_id FROM impuesto_periodo_contable WHERE impuesto_id = i.impuesto_id 
				 AND periodo_contable_id = $periodo_contable_id) AS impuesto_periodo_contable FROM impuesto i WHERE impuesto_id = $impuesto_id";
				 
				 $result         = $this -> DbFetchAll($select,$Conex,true);			 			 
				 $nombreImpuesto = $result[0]['nombre'];
			 
				 exit("<div align='center'>El impuesto [ $nombreImpuesto ] no ha sido bien parametrizado para el periodo [ $anio ] !! <br> Por favor revise los parametros del impuesto</div>");
			 
			   }
			
		   }	
	   
	   }else{
	   
	       return array(valor => 0, base => 0);
	   
	     } 
	 
	 }else{
	 
	     exit("No existe periodo creado para el año $anio !!!, por favor ingrese periodo correspondiente");
	 
	   }
   
  
  }
  
  public function calcularDescuento($valor,$valor_flete,$descuento_id,$Conex){
  
  
     $select  = "SELECT * FROM tabla_descuentos  WHERE descuento_id = $descuento_id";
     $result  = $this -> DbFetchAll($select,$Conex,true);	 
	 
	 $calculo    = $result[0]['calculo'];
	 $porcentaje = $result[0]['porcentaje'];
	 
	 if($calculo == 'P'){
	 
	 
	   $select = "SELECT ($valor_flete*$porcentaje)/100 AS valor";
       $result = $this -> DbFetchAll($select,$Conex,true);	   
	   
	   $valor  = $result[0]['valor'];
	   
	   return $valor;	   
	 
	 }else{
	     return $valor;
	   }
  
  }  
  
  public function Save($oficina_id,$Campos,$Conex){
	
    $seguimiento_id    = $this -> DbgetMaxConsecutive("seguimiento","seguimiento_id",$Conex,true,1);	
	
    $this -> assignValRequest('seguimiento_id',$seguimiento_id);
	
	$placa_id = $this -> requestData("placa_id"); 
	
	$this -> Begin($Conex);
    
	$this -> DbInsertTable("seguimiento",$Campos,$Conex,true,false);
		
       if(is_array($_REQUEST['impuestos'])){
	         	 
	     $impuestos             = $_REQUEST['impuestos'];
		 $impuestosManifiestoId;
		 		 
		 for($i = 0; $i < count($impuestos); $i++){
						
		     $impuestos_particular_id = $impuestos[$i]['impuestos_particular_id'];
             $impuesto_id             = $impuestos[$i]['impuesto_id'];
             $nombre                  = $impuestos[$i]['nombre'];
			 $base                    = $impuestos[$i]['base'];
             $valor                   = str_replace(",",".",str_replace(".","",$impuestos[$i]['valor']));	 
			 
			 if(is_numeric($impuestos_particular_id)){
			 
			      $query = "UPDATE impuestos_particular SET /*impuesto_id = $impuesto_id,*/nombre = '$nombre',base = $base,valor = $valor
				  WHERE impuestos_particular_id = $impuestos_particular_id;";				  
			 
			 }else{
			 
			     $impuestos_particular_id = $this -> DbgetMaxConsecutive("impuestos_particular","impuestos_particular_id",$Conex,true,1);
				 
				 $query = "INSERT INTO impuestos_particular (impuestos_particular_id,seguimiento_id,impuesto_id,nombre,base,valor) 
				            VALUES ($impuestos_particular_id,$seguimiento_id,$impuesto_id,'$nombre',$base,$valor);";
			 
			   }
			   
			   $this -> query($query,$Conex,true);
			   
  			   if(is_numeric($impuestos_particular_id)) $impuestosManifiestoId  .= "$impuestos_particular_id,";			   
		  }
		  
		  $impuestosManifiestoId  = substr($impuestosManifiestoId,0,strlen($impuestosManifiestoId) - 1);
		  
		  if(strlen(trim($impuestosManifiestoId)) > 0){
		    $delete = "DELETE FROM impuestos_particular WHERE seguimiento_id = $seguimiento_id  AND impuestos_particular_id NOT 
			IN ($impuestosManifiestoId)";
		    $this -> query($delete,$Conex,true);		  
		  }
		  		  	  	   
	   }
	   
       if(is_array($_REQUEST['descuentos'])){
	      	 
		 $seguimiento_id         = $_REQUEST['seguimiento_id'];
	     $descuentos            = $_REQUEST['descuentos'];
		 $descuentosManifiestoId;
		 		 
		 for($i = 0; $i < count($descuentos); $i++){
						
		     $descuentos_particular_id = $descuentos[$i]['descuentos_particular_id'];
             $descuento_id             = $descuentos[$i]['descuento_id'];
             $nombre                   = $descuentos[$i]['nombre'];
             $valor                    = str_replace(",",".",str_replace(".","",$descuentos[$i]['valor']));	 
			 
			 if(is_numeric($descuentos_particular_id)){
			 
			      $query = "UPDATE descuentos_particular SET descuento_id = $descuento_id,nombre = '$nombre',valor = $valor
				  WHERE descuentos_particular_id = $descuentos_particular_id;";
				  
			 }else{
			 
			     $descuentos_particular_id = $this -> DbgetMaxConsecutive("descuentos_particular","descuentos_particular_id",$Conex,true,1);
				 
				 $query = "INSERT INTO descuentos_particular (descuentos_particular_id,seguimiento_id,descuento_id,nombre,valor) 
				            VALUES ($descuentos_particular_id,$seguimiento_id,$descuento_id,'$nombre',$valor);";
			 
			   }
			   
			   $this -> query($query,$Conex,true);
			   
  			   if(is_numeric($descuentos_particular_id)) $descuentosManifiestoId  .= "$descuentos_particular_id,";			   
		  }
		  
		  $descuentosManifiestoId  = substr($descuentosManifiestoId,0,strlen($descuentosManifiestoId) - 1);
		  
		  if(strlen(trim($impuestosManifiestoId)) > 0){
		    $delete = "DELETE FROM descuentos_particular WHERE seguimiento_id = $seguimiento_id  AND descuentos_particular_id NOT 
			IN ($descuentosManifiestoId)";
		    $this -> query($delete,$Conex,true);		  
		  }		  		  	   
	   
	   }	   

	 
	   if(is_array($_REQUEST['anticipos'])){
	   	   	   	 
		 $seguimiento_id         = $_REQUEST['seguimiento_id'];
	     $anticipos             = $_REQUEST['anticipos'];
		 $anticiposManifiestoId;
		 		 
		 for($i = 0; $i < count($anticipos); $i++){
						
		     $conductor                 = $anticipos[$i]['conductor'];
             $conductor_id              = $anticipos[$i]['conductor_id'];
             $anticipos_particular_id   = $anticipos[$i]['anticipos_particular_id'];
             $entrega                   = $anticipos[$i]['entrega'];			 
             $valor                   = str_replace(",",".",str_replace(".","",$anticipos[$i]['valor']));	 
			 
			 if($valor > 0){
			 
				 if(is_numeric($anticipos_particular_id)){
				 
					  $query = "UPDATE anticipos_particular SET conductor = '$conductor',conductor_id = $conductor_id,valor = $valor,
					  placa_id = $placa_id,entrega = '$entrega' WHERE anticipos_particular_id = $anticipos_particular_id;";				  
				 
				 }else{
				 
					 $anticipos_particular_id = $this -> DbgetMaxConsecutive("anticipos_particular","anticipos_particular_id",$Conex,true,1);
					 
					 $select = "SELECT MAX(numero) AS numero FROM anticipos_particular WHERE seguimiento_id = $seguimiento_id";
					 $result = $this -> DbFetchAll($select,$Conex,true);
		 
					 $numero = $result[0]['numero'] > 0 ? ($result[0]['numero'] + 1) : 1;					 
					 
					 $query = "INSERT INTO anticipos_particular (anticipos_particular_id,seguimiento_id,numero,conductor,conductor_id,valor,placa_id,oficina_id,entrega) 
								VALUES ($anticipos_particular_id,$seguimiento_id,$numero,'$conductor',$conductor_id,$valor,$placa_id,$oficina_id,'$entrega');";
				 
				   }
				   
				   $this -> query($query,$Conex,true);
				   
				   if(is_numeric($anticipos_particular_id)) $anticiposManifiestoId .= "$anticipos_particular_id,";
			 
			 }  
			   
		  }
		  
		  $anticiposManifiestoId  = substr($anticiposManifiestoId,0,strlen($anticiposManifiestoId) - 1);
		  
		  if(strlen(trim($anticiposManifiestoId)) > 0){
		    $delete = "DELETE FROM anticipos_particular WHERE seguimiento_id = $seguimiento_id  AND anticipos_particular_id NOT 
			IN ($anticiposManifiestoId)";
		    $this -> query($delete,$Conex,true);		  
		  }
		  		  
		 
		 }	   	   
		
		if($this -> GetNumError() > 0){
      		return false;
    	}else{

			$servicio_transporte_id = $this -> DbgetMaxConsecutive("servicio_transporte","servicio_transporte_id",$Conex,true,1);		   
			$this -> assignValRequest('servicio_transporte_id',$servicio_transporte_id);
			$this -> DbInsertTable("servicio_transporte",$Campos,$Conex,true,false);
			
			$trafico_id = $this -> DbgetMaxConsecutive("trafico","trafico_id",$Conex,true,1);
			$origen_id	  = $this -> requestData('origen_id','integer');
			$destino_id	  = $this -> requestData('destino_id','integer');			
			$insert = "INSERT INTO trafico (trafico_id,seguimiento_id,origen_id,destino_id,estado) 
						VALUES ($trafico_id,$seguimiento_id,$origen_id,$destino_id,'P')";
			$this -> query($insert,$Conex,true);
			
       		$contactos = explode(",",$_REQUEST['contacto_id']);
	   
	   		for($i = 0; $i < count($contactos); $i++){
	   
	     		$contacto_id = $contactos[$i];
				if($contacto_id>0){
					$insert = "INSERT INTO contacto_seguimiento (contacto_id,seguimiento_id) VALUES ($contacto_id,$seguimiento_id)";
					$this -> query($insert,$Conex,true);
				}
	     		if($this -> GetNumError() > 0){
           			return false;
		 		}
	   
	   		}
		}

	  
    $this -> Commit($Conex);
    return array(array(seguimiento_id=>$seguimiento_id,servicio_transporte_id=>$servicio_transporte_id));
  }
  
  public function Update($oficina_id,$Campos,$Conex){ 

    $this -> Begin($Conex);
	
	 $seguimiento_id = $this -> requestData("seguimiento_id"); 	 
 	 $placa_id       = $this -> requestData("placa_id"); 	
	 $valor_facturar = $this -> removeFormatCurrency($this -> requestData("valor_facturar")); 
	 
     $this -> DbUpdateTable("seguimiento",$Campos,$Conex,true,false);
	 
       if(is_array($_REQUEST['impuestos'])){
	         	 
	     $impuestos             = $_REQUEST['impuestos'];
		 $impuestosManifiestoId;
		 		 
		 for($i = 0; $i < count($impuestos); $i++){
						
		     $impuestos_particular_id = $impuestos[$i]['impuestos_particular_id'];
             $impuesto_id             = $impuestos[$i]['impuesto_id'];
             $nombre                  = $impuestos[$i]['nombre'];
			 $base                    = $impuestos[$i]['base'];
             $valor                   = str_replace(",",".",str_replace(".","",$impuestos[$i]['valor']));	 
			 
			 if(is_numeric($impuestos_particular_id)){
			 
			      $query = "UPDATE impuestos_particular SET /*impuesto_id = $impuesto_id,*/nombre = '$nombre',base = $base,valor = $valor
				  WHERE impuestos_particular_id = $impuestos_particular_id;";				  
			 
			 }else{
			 
			     $impuestos_particular_id = $this -> DbgetMaxConsecutive("impuestos_particular","impuestos_particular_id",$Conex,true,1);
				 
				 $query = "INSERT INTO impuestos_particular (impuestos_particular_id,seguimiento_id,impuesto_id,nombre,base,valor) 
				            VALUES ($impuestos_particular_id,$seguimiento_id,$impuesto_id,'$nombre',$base,$valor);";
			 
			   }
			   
			   $this -> query($query,$Conex,true);
			   
  			   if(is_numeric($impuestos_particular_id)) $impuestosManifiestoId  .= "$impuestos_particular_id,";			   
		  }
		  
		  $impuestosManifiestoId  = substr($impuestosManifiestoId,0,strlen($impuestosManifiestoId) - 1);
		  
		  if(strlen(trim($impuestosManifiestoId)) > 0){
		    $delete = "DELETE FROM impuestos_particular WHERE seguimiento_id = $seguimiento_id  AND impuestos_particular_id NOT 
			IN ($impuestosManifiestoId)";
		    $this -> query($delete,$Conex,true);		  
		  }
		  		  
	   
	   
	   }
	   
       if(is_array($_REQUEST['descuentos'])){
	      	 
		 $seguimiento_id         = $_REQUEST['seguimiento_id'];
	     $descuentos            = $_REQUEST['descuentos'];
		 $descuentosManifiestoId;
		 		 
		 for($i = 0; $i < count($descuentos); $i++){
						
		     $descuentos_particular_id = $descuentos[$i]['descuentos_particular_id'];
             $descuento_id             = $descuentos[$i]['descuento_id'];
             $nombre                   = $descuentos[$i]['nombre'];
             $valor                    = str_replace(",",".",str_replace(".","",$descuentos[$i]['valor']));	 
			 
			 if(is_numeric($descuentos_particular_id)){
			 
			      $query = "UPDATE descuentos_particular SET descuento_id = $descuento_id,nombre = '$nombre',valor = $valor
				  WHERE descuentos_particular_id = $descuentos_particular_id;";
				  
			 }else{
			 
			     $descuentos_particular_id = $this -> DbgetMaxConsecutive("descuentos_particular","descuentos_particular_id",$Conex,true,1);
				 
				 $query = "INSERT INTO descuentos_particular (descuentos_particular_id,seguimiento_id,descuento_id,nombre,valor) 
				            VALUES ($descuentos_particular_id,$seguimiento_id,$descuento_id,'$nombre',$valor);";
			 
			   }
			   
			   $this -> query($query,$Conex,true);
			   
  			   if(is_numeric($descuentos_particular_id)) $descuentosManifiestoId  .= "$descuentos_particular_id,";			   
		  }
		  
		  $descuentosManifiestoId  = substr($descuentosManifiestoId,0,strlen($descuentosManifiestoId) - 1);
		  
		  if(strlen(trim($impuestosManifiestoId)) > 0){
		    $delete = "DELETE FROM descuentos_particular WHERE seguimiento_id = $seguimiento_id  AND descuentos_particular_id NOT 
			IN ($descuentosManifiestoId)";
		    $this -> query($delete,$Conex,true);		  
		  }
		  		  
	   
	   
	   }	   

	 
	   if(is_array($_REQUEST['anticipos'])){
	   	   	   	 
		 $seguimiento_id         = $_REQUEST['seguimiento_id'];
	     $anticipos             = $_REQUEST['anticipos'];
		 $anticiposManifiestoId;
		 		 
		 for($i = 0; $i < count($anticipos); $i++){
						
		     $conductor                 = $anticipos[$i]['conductor'];
             $conductor_id              = $anticipos[$i]['conductor_id'];
             $anticipos_particular_id   = $anticipos[$i]['anticipos_particular_id'];
             $entrega                   = $anticipos[$i]['entrega'];			 
             $valor                   = str_replace(",",".",str_replace(".","",$anticipos[$i]['valor']));	 
			 
			 if($valor  > 0){
			 
			 if(is_numeric($anticipos_particular_id)){
			 
			      $query = "UPDATE anticipos_particular SET conductor = '$conductor',conductor_id = $conductor_id,valor = $valor,
				  placa_id = $placa_id,entrega = '$entrega' WHERE anticipos_particular_id = $anticipos_particular_id;";				  
			 
			 }else{
			 
			     $anticipos_particular_id = $this -> DbgetMaxConsecutive("anticipos_particular","anticipos_particular_id",$Conex,true,1);
				 
				 $select = "SELECT MAX(numero) AS numero FROM anticipos_particular WHERE seguimiento_id = $seguimiento_id";
	             $result = $this -> DbFetchAll($select,$Conex,true);
	 
	             $numero = $result[0]['numero'] > 0 ? ($result[0]['numero'] + 1) : 1;					 
				 
				 $query = "INSERT INTO anticipos_particular (anticipos_particular_id,seguimiento_id,numero,conductor,conductor_id,valor,placa_id,oficina_id,entrega) 
				            VALUES ($anticipos_particular_id,$seguimiento_id,$numero,'$conductor',$conductor_id,$valor,$placa_id,$oficina_id,'$entrega');";
			 
			   }
			   
			   $this -> query($query,$Conex,true);
			   
  	  		   if(is_numeric($anticipos_particular_id)) $anticiposManifiestoId .= "$anticipos_particular_id,";
			   
			  } 
			  
		  }
		  
		  $anticiposManifiestoId  = substr($anticiposManifiestoId,0,strlen($anticiposManifiestoId) - 1);
		  
		  if(strlen(trim($anticiposManifiestoId)) > 0){
		    $delete = "DELETE FROM anticipos_particular WHERE seguimiento_id = $seguimiento_id  AND anticipos_particular_id NOT 
			IN ($anticiposManifiestoId)";
		    $this -> query($delete,$Conex,true);		  
		  }
		  		  
		 
		 }	 
	 
	 $this -> DbUpdateTable("servicio_transporte",$Campos,$Conex,true,false);

	if($this -> GetNumError() > 0){
		return false;
	}else{

		$seguimiento_id	  = $this -> requestData('seguimiento_id','integer');
		$origen_id	  	  = $this -> requestData('origen_id','integer');
		$destino_id	  	  = $this -> requestData('destino_id','integer');			

		$update = "UPDATE trafico SET origen_id=$origen_id,destino_id=$destino_id
					WHERE seguimiento_id=$seguimiento_id";
		$this -> query($update,$Conex);

		$delete = "DELETE FROM contacto_seguimiento WHERE seguimiento_id=$seguimiento_id";
		$this -> query($delete,$Conex);
		
		$contactos = explode(",",$_REQUEST['contacto_id']);
   
		for($i = 0; $i < count($contactos); $i++){
   
			$contacto_id = $contactos[$i];
			if($contacto_id>0){			
				$insert = "INSERT INTO contacto_seguimiento (contacto_id,seguimiento_id) VALUES ($contacto_id,$seguimiento_id)";
				$this -> query($insert,$Conex);
			}
			if($this -> GetNumError() > 0){
				return false;
			}
   
		}
	}
	
	if(is_numeric($valor_facturar)){
	
	  $update = "UPDATE seguimiento SET estado = 'LQ' WHERE seguimiento_id = $seguimiento_id";
	  $this -> query($update,$Conex);	  
	
	}

    $this -> Commit($Conex);
	 
  }
  
  public function getImpuestos($empresa_id,$oficina_id,$Conex){
  
    $select = "SELECT * FROM tabla_impuestos WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id AND estado = 'A'";
	$result = $this  -> DbFetchAll($select,$Conex,true);
	
	return $result;
  
  }
  
  public function GetDescuentos($oficina_id,$Conex){
	  
	$select = "SELECT * FROM tabla_descuentos WHERE oficina_id = $oficina_id  AND estado = 'A' ORDER BY orden";
	  
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
	  
	  
  }

//LISTA MENU



  public function GetEstadoSeg($Conex){
	$opciones = array ( 0 => array ( 'value' => 'P', 'text' => 'PENDIENTE' ), 1 => array ( 'value' => 'T', 'text' => 'TRANSITO' ), 
						2 => array ( 'value' => 'F', 'text' => 'FINALIZADO' ), 3 => array ( 'value' => 'A', 'text' => 'ANULADO' ) );
	return  $opciones;
  }


  public function GetTipo($Conex){
	$opciones = array ( 0 => array ( 'value' => 'DU', 'text' => 'URBANO' ), 1 => array ( 'value' => 'MC', 'text' => 'NACIONAL' ) );
	return  $opciones;
  }
  
  public function getComprobarTrafico($Conex){
  
	$seguimiento_id = $_REQUEST['seguimiento_id'];
	
	$select = "SELECT estado FROM trafico
				WHERE seguimiento_id=$seguimiento_id ";
			
	$result = $this -> DbFetchAll($select,$Conex); 
	$estado = $result[0]['estado'];
	return $estado;
  }
  
  
  public function selectVehiculo($placa_id,$Conex){
  
    $select = "SELECT (SELECT marca FROM marca WHERE marca_id = v.marca_id) AS marca,(SELECT linea FROM linea WHERE linea_id = v.linea_id) AS linea,modelo_vehiculo AS modelo,modelo_repotenciado,(SELECT color FROM color WHERE color_id = v.color_id) AS color,(SELECT carroceria FROM carroceria WHERE carroceria_id = v.carroceria_id) AS carroceria,registro_nacional_carga,configuracion,peso_vacio,numero_soat,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = v.aseguradora_soat_id) AS nombre_aseguradora,vencimiento_soat,placa_id,(SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,placa_remolque_id,
	conductor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS numero_identificacion,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS nombre,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS direccion_conductor,
	(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS telefono_conductor,
	(SELECT movil FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS movil_conductor,
	(SELECT email FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS correo_conductor,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor 	WHERE conductor_id = v.conductor_id))) AS ciudad_conductor,
	(SELECT categoria FROM categoria_licencia WHERE categoria_id = (SELECT categoria_id FROM conductor WHERE conductor_id = v.conductor_id)) AS categoria_licencia_conductor,
	chasis AS serie,(SELECT remolque FROM tipo_vehiculo WHERE tipo_vehiculo_id = v.tipo_vehiculo_id) AS remolque FROM vehiculo v WHERE placa_id = $placa_id ";	  
			
	$result = $this -> DbFetchAll($select,$Conex,false);
	
	return $result; 
  
  } 
  
  public function selectConductor($conductor_id,$Conex){
  
     $select = "SELECT c.conductor_id,concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS nombre,t.numero_identificacion,t.email AS correo_conductor, t.movil AS movil_conductor,
     (SELECT categoria FROM categoria_licencia WHERE categoria_id = c.categoria_id) AS categoria_licencia_conductor,t.direccion AS direccion_conductor,t.telefono AS  
	  telefono_conductor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ciudad_conductor FROM conductor c, tercero t  WHERE 
	  t.tercero_id = c.tercero_id AND c.conductor_id = $conductor_id";
	  
	 $result = $this -> DbFetchAll($select,$Conex,false);
	
	 return $result; 
  
  }  

//BUSQUEDA
  public function selectseguimiento($seguimiento_id,$Conex){
    				
    $select = "SELECT s.seguimiento_id,s.fecha,	s.cliente_id,s.cliente,s.cliente_nit,s.cliente_tel,s.direccion_cargue,s.tipo,
					s.estado,s.estado AS estado_select,s.origen_id,s.destino_id,s.placa_id,s.placa,s.placa_remolque_id,s.marca,s.linea,s.modelo,
					s.modelo_repotenciado,s.serie,s.color,s.carroceria,s.registro_nacional_carga,
					s.configuracion,s.peso_vacio,s.numero_soat,s.nombre_aseguradora,s.vencimiento_soat,s.placa_remolque,
	                s.conductor_id,s.numero_identificacion,s.nombre,s.direccion_conductor,s.telefono_conductor,s.ciudad_conductor,s.movil_conductor,s.correo_conductor,
		            s.categoria_licencia_conductor,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino,
					(SELECT servicio_transporte_id FROM servicio_transporte WHERE seguimiento_id=s.seguimiento_id ) AS 
					servicio_transporte_id,s.valor_flete,s.saldo_por_pagar,s.valor_neto_pagar,s.fecha_estimada_salida,s.hora_estimada_salida,s.observaciones,s.valor_facturar ,s.documento_cliente
					FROM seguimiento s  WHERE s.seguimiento_id=$seguimiento_id";				
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	$data[0]['seguimiento'] = $result;
	
	$select = "SELECT * FROM impuestos_particular WHERE seguimiento_id = $seguimiento_id";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	
	$data[0]['impuestos'] = $result;
		
	$select = "SELECT * FROM descuentos_particular WHERE seguimiento_id = $seguimiento_id";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	
	$data[0]['descuentos'] = $result;

	$select = "SELECT a.*,a.conductor AS conductor_anticipo,a.conductor_id AS conductor_anticipo_id FROM anticipos_particular a 
		WHERE seguimiento_id = $seguimiento_id";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	
	$data[0]['anticipos'] = $result;	
	
	
	return $data;
  }
  
  
  public function getDataCliente($cliente_id,$Conex){

    $select = "SELECT  tr.telefono AS cliente_tel,
	 					tr.direccion AS direccion_cargue, 
						tr.numero_identificacion AS cliente_nit,
						tr.movil AS cliente_movil,
						CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social) AS cliente
	 FROM cliente p, tercero tr WHERE p.cliente_id = $cliente_id AND tr.tercero_id = p.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);
     return $result;

  }

  
  public function getContactos($ClienteId,$Conex){
  
    $select = "SELECT contacto_id AS value,nombre_contacto AS text,contacto_id AS selected FROM contacto 
	WHERE cliente_id =  $ClienteId";
	
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;
  
  }

  
  public function SelectContactosSeguimiento($seguimiento_id,$Conex){
  
    $select = "SELECT contacto_id FROM contacto_seguimiento WHERE seguimiento_id = $seguimiento_id";

	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;  
  
  }
  
	public function cancellation($Conex){
	 
	
	$this -> Begin($Conex);
	
	  $seguimiento_id 			= $this -> requestData('seguimiento_id','integer');
	  $anul_seguimiento    		= $this -> requestData('anul_seguimiento','text');
	  $desc_anul_seguimiento   = $this -> requestData('desc_anul_seguimiento','text');
	  $anul_usuario_id          = $this -> requestData('anul_usuario_id','integer');	
	  
	  $update = "UPDATE seguimiento SET estado= 'A',
					anul_seguimiento=$anul_seguimiento,
					desc_anul_seguimiento =$desc_anul_seguimiento,
					anul_usuario_id=$anul_usuario_id
				WHERE seguimiento_id=$seguimiento_id";	
	  $this -> query($update,$Conex);		  
	
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{		
		$this -> Commit($Conex);			
	  }  
	}


//// GRID ////   
  public function getQuerySeguimientoGrid($oficina_id){
	   	   
     $Query = "SELECT 
	 				s.seguimiento_id,
					s.fecha,
					s.fecha_ingreso,					
					IF(s.tipo='MC','NACIONAL','URBANO') AS tipo,
					CASE s.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'T' THEN 'TRANSITO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADO' END AS estado,
					s.cliente,
					s.cliente_nit,
					s.direccion_cargue,
					s.cliente_tel,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino,
					s.placa,
					s.marca,
					s.color,
					s.nombre,
					s.telefono_conductor,
					s.ciudad_conductor
	 			FROM seguimiento s
				ORDER BY s.seguimiento_id DESC";

     return $Query;
   }
   
}



?>