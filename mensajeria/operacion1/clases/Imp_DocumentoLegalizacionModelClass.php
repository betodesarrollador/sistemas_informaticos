<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_DocumentoLegalizacionModel extends Db{

  private $totalDebito;
  private $totalCredito;
  
  public function getEncabezado($oficina_id,$legalizacion_manifiesto_id,$Conex){
  
	
	if(is_numeric($legalizacion_manifiesto_id)){			
				
        $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp, 
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,
		'Conductor' AS texto_tercero,				
		'Legalizacion' AS tipo_documento,		
		(SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion,
		e.*,
		t.*,
		of.nombre AS nom_oficina,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=e.origen_id) AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=e.destino_id) AS destino,		
		(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_manifiesto WHERE manifiesto_id = e.manifiesto_id) AS observaciones				
        FROM legalizacion_manifiesto  e, oficina of, tercero t, conductor c WHERE e.legalizacion_manifiesto_id = $legalizacion_manifiesto_id AND of.oficina_id=$oficina_id AND t.tercero_id=c.tercero_id AND c.conductor_id = e.conductor_id";				
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	  
	for($i = 0; $i < count($result); $i++){
      $this -> totalDebito  += $result[$i]['debito'];
      $this -> totalCredito += $result[$i]['credito'];
	}  
	  
	return $result;
  }


  public function getimputaciones($empresa_id,$oficina_id,$legalizacion_manifiesto_id,$Conex){
  
	
	if(is_numeric($legalizacion_manifiesto_id)){
				
		 $select = "SELECT * FROM parametros_legalizacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
		 $result = $this  -> DbFetchAll($select,$Conex,true);					
			
		 $totalDebito                           = 0;
		 $totalCredito                          = 0;
			
		 $parametros_legalizacion_id            = $result[0]['parametros_legalizacion_id'];
		 $cuenta_puc_anticipos_id               = $result[0]['contrapartida_id'];
		 $base                                  = 0;
		 $naturaleza_contrapartida              = $result[0]['naturaleza_contrapartida'];		   		   
		 $diferencia_favor_conductor_id         = $result[0]['diferencia_favor_conductor_id'];		   		   
		 $naturaleza_diferencia_favor_conductor = $result[0]['naturaleza_diferencia_favor_conductor'];		   		   
		 $diferencia_favor_empresa_id           = $result[0]['diferencia_favor_empresa_id'];		   		   
		 $naturaleza_diferencia_favor_empresa   = $result[0]['naturaleza_diferencia_favor_empresa'];
		 
         $select = "SELECT 
		  (SELECT codigo_puc FROM puc WHERE puc_id=$cuenta_puc_anticipos_id) AS puc_cod,
		  (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = 
		  i.conductor_id)) AS tercero_imputacion, 
		  (SELECT codigo FROM centro_de_costo WHERE oficina_id = i.oficina_id) AS codigo_centro_costo,
		  CONCAT('ANTICIPO :',i.consecutivo,' MC :',(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = i.manifiesto_id)) 
		  AS descripcion,'0' AS debito,i.valor AS credito FROM  anticipos_manifiesto i  WHERE 
		  i.legalizacion_manifiesto_id = $legalizacion_manifiesto_id UNION ALL SELECT (SELECT codigo_puc FROM puc WHERE puc_id = 
		  (SELECT puc_id FROM detalle_parametros_legalizacion WHERE detalle_parametros_legalizacion_id = 
		  i.detalle_parametros_legalizacion_id)) AS cod_puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = 
		  i.tercero_id) AS tercero_imputacion,(SELECT codigo FROM centro_de_costo WHERE placa_id = (SELECT placa_id FROM 		  		          legalizacion_manifiesto WHERE legalizacion_manifiesto_id = i.legalizacion_manifiesto_id)) AS codigo_centro_costo,		  		  
		  CONCAT((SELECT nombre_cuenta FROM detalle_parametros_legalizacion WHERE detalle_parametros_legalizacion_id = 
		  (i.detalle_parametros_legalizacion_id)),' MC: ',
		  (SELECT manifiesto FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM legalizacion_manifiesto WHERE 
		  legalizacion_manifiesto_id = i.legalizacion_manifiesto_id))) AS descripcion,
          IF((SELECT naturaleza FROM detalle_parametros_legalizacion WHERE 
		  detalle_parametros_legalizacion_id = i.detalle_parametros_legalizacion_id) = 'D',i.valor,0) AS debito,
          IF((SELECT naturaleza FROM detalle_parametros_legalizacion WHERE 
		  detalle_parametros_legalizacion_id = i.detalle_parametros_legalizacion_id) = 'C',i.valor,0) AS credito
		  FROM costos_viaje_manifiesto i WHERE legalizacion_manifiesto_id = $legalizacion_manifiesto_id
		  ";
		 
	     $result1 = $this -> DbFetchAll($select,$Conex,true);		 
		 		 
		 $select = "SELECT IF((SELECT SUM(valor) FROM anticipos_manifiesto WHERE legalizacion_manifiesto_id = 
		 $legalizacion_manifiesto_id) > (SELECT
		 SUM(valor) FROM costos_viaje_manifiesto WHERE legalizacion_manifiesto_id = $legalizacion_manifiesto_id),
		 (SELECT codigo_puc FROM puc WHERE puc_id=$diferencia_favor_empresa_id),(SELECT codigo_puc FROM puc WHERE 
		 puc_id=$diferencia_favor_conductor_id)) AS puc_cod,
		 (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = 
		 (SELECT conductor_id FROM legalizacion_manifiesto WHERE legalizacion_manifiesto_id = $legalizacion_manifiesto_id))) AS 
		 tercero_imputacion,		  
		  		  	  
		 (SELECT codigo FROM centro_de_costo WHERE oficina_id = (SELECT oficina_id FROM manifiesto WHERE manifiesto_id = 
		 (SELECT manifiesto_id FROM legalizacion_manifiesto WHERE legalizacion_manifiesto_id = $legalizacion_manifiesto_id))) 
		 AS codigo_centro_costo,CONCAT('ANTICIPO(S) : ',(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_manifiesto WHERE 
		 manifiesto_id = (SELECT  
		 manifiesto_id FROM legalizacion_manifiesto WHERE legalizacion_manifiesto_id = $legalizacion_manifiesto_id))) 
		 AS descripcion,i.diferencia  FROM legalizacion_manifiesto i WHERE legalizacion_manifiesto_id = 
		 $legalizacion_manifiesto_id	";
		 	
	      $result2 = $this -> DbFetchAll($select,$Conex,true);	
		  
		  
		  $select = "SELECT IF((SELECT SUM(valor) FROM anticipos_manifiesto WHERE legalizacion_manifiesto_id = 
		  $legalizacion_manifiesto_id) > (SELECT
		  SUM(valor) FROM costos_viaje_manifiesto WHERE legalizacion_manifiesto_id = $legalizacion_manifiesto_id),
		  'E','C') AS favor_de";
		 
	      $result3 = $this -> DbFetchAll($select,$Conex,true);			 
		  
		  if($result3[0]['favor_de'] == 'E'){
		  
		     if($naturaleza_diferencia_favor_empresa == 'D'){
			   $debito  = $result2[0]['diferencia'];
			   $credito = 0;
			 }else{
			     $debito  = 0;
			     $credito = $result2[0]['diferencia'];			 
			   }
		  
		  }else{
		  
		     if($naturaleza_diferencia_favor_conductor == 'D'){
			   $debito  = $result2[0]['diferencia'];
			   $credito = 0;			 
			 }else{
			     $debito  = 0;
			     $credito = $result2[0]['diferencia'];			 
			   } 
			 
		  
		    }
		  
		  $diferencia[0]['puc_cod']             = $result2[0]['puc_cod'];
		  $diferencia[0]['tercero_imputacion']  = $result2[0]['tercero_imputacion'];		  
		  $diferencia[0]['codigo_centro_costo'] = $result2[0]['codigo_centro_costo'];		  		  
		  $diferencia[0]['descripcion']         = $result2[0]['descripcion'];		  		  		  
		  $diferencia[0]['debito']              = $debito;		  		  		  
		  $diferencia[0]['credito']             = $credito;		  		  		  		  		  
		  
		  $result = array_values(array_merge($result1,$diferencia)); 

	  
	}else{
   	    $result = array();
	  }
	  
	  
	for($i = 0; $i < count($result); $i++){
	  $this -> totalDebito  += $result[$i]['debito'];
	  $this -> totalCredito += $result[$i]['credito'];	 	
	}  
	  
	return $result;
  }


  public function getTotal($legalizacion_manifiesto_id,$Conex){

	$result[0]['total_debito']  = $this -> totalDebito;
	$result[0]['total_credito'] = $this -> totalCredito;	  

	return $result;
	
  }

  public function getTotales($legalizacion_manifiesto_id,$Conex){

    $result[0]['total']  = $this -> totalDebito;

	return $result;
  }

}


?>