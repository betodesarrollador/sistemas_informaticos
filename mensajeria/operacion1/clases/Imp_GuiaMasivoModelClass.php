<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_GuiaMasivoModel extends Db{
  
  public function getGuiaMasivo($oficina_id,$Conex){
  
	$rango_desde = $_REQUEST['rango_desde'];
    $rango_hasta = $_REQUEST['rango_hasta'];
    $guia     = array();
				
	$select = "SELECT r.fecha_guia,(SELECT logo FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS logo,
	(SELECT pagina_web FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS pagina_web,
	(SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id))) AS empresa,
	(SELECT concat_ws('- ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id))) AS numero_identificacion,
	(SELECT nombre FROM oficina WHERE oficina_id = r.oficina_id) AS oficina,(SELECT direccion FROM oficina WHERE oficina_id = r.oficina_id) AS direccion,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM oficina WHERE oficina_id = r.oficina_id)) AS ciudad,
	(SELECT habilitacion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS resolucion_habilitacion,
	(SELECT fecha_habilitacion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS fecha_habilitacion,	
	(SELECT numero_resolucion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS resolucion_ministerio,
	(SELECT fecha_resolucion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS fecha_resolucion,	
	(SELECT rango_manif_ini FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS rango_manif_ini,	
	(SELECT rango_manif_fin FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS rango_manif_fin,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
	r.referencia_producto AS referencia,r.descripcion_producto AS descripcion_producto,
	r.guia_id,r.numero_guia,r.remitente,r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.telefono_remitente,r.telefono_destinatario ,
	r.cantidad,LPAD(r.numero_guia,8,'0') AS numero_guia_bar,(SELECT CONCAT(' RESPONSABLE : ',nombre) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina_responsable,
	r.estado_mensajeria_id FROM guia r WHERE r.oficina_id = $oficina_id AND r.guia_id BETWEEN $rango_desde AND $rango_hasta ORDER BY r.guia_id ASC";		
	
	$result  = $this -> DbFetchAll($select,$Conex,true);	
	$guia = $result;	
	
	for($i = 0; $i < count($guia); $i++){
	
	  $guia_id          = $guia[$i]['guia_id'];
	  $estado           = $guia[$i]['estado_mensajeria_id'];
	  	  
	  $select       = "SELECT * FROM detalle_despacho WHERE guia_id = $guia_id";
	  $dataDespacho = $this -> DbFetchAll($select,$Conex,true);		  
	  
	  if(count($dataDespacho) > 0){	  
	    if(count($dataDespacho) == 1){
			
          $manifiesto_id        = $dataDespacho[$i]['manifiesto_id'];
		  $despachos_urbanos_id = $dataDespacho[$i]['despachos_urbanos_id'];
		  $guia_id = $dataDespacho[$i]['guia_id'];
		  
		  if(is_numeric($manifiesto_id)){		  
		    $select         = "SELECT manifiesto, nombre FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	        $dataManifiesto = $this -> DbFetchAll($select,$Conex,true);		
			
		    $guia[$i]['planilla']  = $dataManifiesto[0]['manifiesto'];
	        $guia[$i]['conductor'] = $dataManifiesto[0]['nombre'];
		  
		  }else if(is_numeric($despachos_urbanos_id)){
		  
				$select         = "SELECT despacho,nombre FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
				$dataManifiesto = $this -> DbFetchAll($select,$Conex,true);		
				
				$guia[$i]['planilla']  = $dataManifiesto[0]['despacho'];
				$guia[$i]['conductor'] = $dataManifiesto[0]['nombre'];		  
		  
		    }else if(is_numeric($guia_id)){
		  
				$select         = "SELECT guia,nombre FROM guia WHERE guia_id = $guia_id";
				$dataManifiesto = $this -> DbFetchAll($select,$Conex,true);		
				
				$guia[$i]['planilla']  = $dataManifiesto[0]['despacho'];
				$guia[$i]['conductor'] = $dataManifiesto[0]['nombre'];
						
			}else{
				   $guia[$i]['planilla']  = '';
				   $guia[$i]['conductor'] = '';				
			  }
		
		}else{
		     $guia[$i]['planilla']  = '';
		     $guia[$i]['conductor'] = '';			 
		  }	  
	  }
	  
	  
	  $select  = "SELECT * FROM detalle_guia WHERE guia_id = $guia_id";
	  $result  = $this -> DbFetchAll($select,$Conex,true);	
	  $guia[$i]['detalles_guia'] = $result;		  
	  
	  if($estado == 'M'){
	  
	     $select = "SELECT * FROM detalle_despacho WHERE guia_id = $guia_id";
	     $result = $this -> DbFetchAll($select,$Conex,true);			 
		 
		 if(count($result) > 0){
		 
		    $manifiesto_id      = $result[0]['manifiesto_id'];
		    $despachos_urbanos_id_id = $result[0]['despachos_urbanos_id_id'];	
			$guia_id = $result[0]['guia_id'];
			
			if(is_numeric($manifiesto_id)){
			
			  $select = "SELECT placa,manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	          $result = $this -> DbFetchAll($select,$Conex,true);
			  
			  $guia[$i]['manifiesto'] = $result[0]['manifiesto'];
			  $guia[$i]['placa']      = $result[0]['placa'];		  					  
			
			}/*else if(is_numeric($despachos_urbanos_id_id)){
			
			    $select = "SELECT placa,manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	            $result = $this -> DbFetchAll($select,$Conex,true);
			  
			    $remesas[$i]['manifiesto'] = $result[0]['manifiesto'];
			    $remesas[$i]['placa']      = $result[0]['placa'];				
			
			  }*/		 
		 }	  
	  }	  
	}
			
	return $guia;	
  }
  
  public function getOficinas($empresa_id,$Conex){  
     $select = "SELECT * FROM oficina WHERE empresa_id = $empresa_id"; 
     $result = $this -> DbFetchAll($select,$Conex,true);
     return $result;  
  }    
}

?>