<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class archivoUIAFModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getPeriodosUIAF($Conex){
  
     $select = "SELECT periodo_uiaf_id AS value,CONCAT(anio,'-',numero,' : ',desde,' > ',hasta) AS text FROM periodo_uiaf WHERE mostrar = 1 AND 
	 estado = 'P' ORDER BY anio,numero";
	 
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result;	  	 
  
  }    
  
  public function getClientes($Conex){
  
     $select = "SELECT cliente_id AS value, t.razon_social AS text  FROM cliente c, tercero t  WHERE c.cliente_id IN (SELECT cliente_id FROM remesa WHERE clase_remesa = 'NN') AND c.tercero_id = t.tercero_id ORDER BY text ASC ";
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result;		 
  
  }
  
  public function selectDataUIAF($periodo_uiaf_id,$Conex){
  
     $select = "SELECT * FROM periodo_uiaf  WHERE periodo_uiaf_id = $periodo_uiaf_id";
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 $desde      = 	$result[0]['desde'];
	 $hasta      = 	$result[0]['hasta'];	 
	 $cliente_id =  $this -> requestData('cliente_id'); 
  
    $select = "SELECT cliente_id, SUM(valor_facturar) AS valor FROM remesa r /* WHERE cliente_id =  $cliente_id*/ GROUP BY r.cliente_id  HAVING SUM(valor_facturar) >= 30000000  /*HAVING SUM(valor_facturar) > 0*/";
	 
     $result = $this -> DbFetchAll($select,$Conex,true);
	  
	 if(count($result) > 0){
	 	   
	   $dataUIAF    = array();
	   $cont        = 0;
	   $consecutivo = 1;
	 
	   for($i = 0; $i < count($result); $i++){
	   
	      $cliente_id = $result[$i]['cliente_id'];
		  
		  $select = "SELECT fecha,remesa,manifiesto,origen,destino,placa,
		 tipo_identificacion_propietario_codigo,numero_identificacion_propietario,propietario,
		 tipo_identificacion_tenedor_codigo,numero_identificacion_tenedor,tenedor,
		 tipo_identificacion_conductor_codigo,numero_identificacion,
	     conductor,nombre,placa_remolque,tipo_identificacion_propietario_remolque_codigo,
		 numero_identificacion_propietario_remolque,
		 propietario_remolque,descripcion_producto,tipo_identificacion_remitente,doc_remitente, 	
		 remitente,tipo_identificacion_destinatario,doc_destinatario,destinatario,valor_facturar,observaciones FROM  (
		  
		  (SELECT m.fecha_mc AS fecha,r.numero_remesa 	  AS remesa,r.valor_facturar,m.manifiesto,
		  
		  (SELECT  divipola FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,
		  
		  (SELECT divipola FROM ubicacion WHERE ubicacion_id = m.destino_id) AS   destino,
		  m.placa,
		  
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE numero_identificacion = m.numero_identificacion_propietario)) 
		  AS tipo_identificacion_propietario_codigo,
		  
		  
		  m.numero_identificacion_propietario,m.propietario, 
		  
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE numero_identificacion = m.numero_identificacion_tenedor)) AS 
		  tipo_identificacion_tenedor_codigo,m.numero_identificacion_tenedor,
		  m.tenedor,
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = m.conductor_id))) AS tipo_identificacion_conductor_codigo,
		  
		  m.numero_identificacion,
		  m.conductor,m.nombre,m.placa_remolque,
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE numero_identificacion = m.numero_identificacion_propietario_remolque)) AS 
		  tipo_identificacion_propietario_remolque_codigo,
		  m.numero_identificacion_propietario_remolque,
		  m.propietario_remolque,r.descripcion_producto,
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = r.tipo_identificacion_remitente_id) AS 
		  tipo_identificacion_remitente, r.doc_remitente,r.remitente, 
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = r.tipo_identificacion_destinatario_id) 
		  AS tipo_identificacion_destinatario, r.doc_destinatario,r.destinatario,m.observaciones FROM manifiesto m, remesa r, 
		  detalle_despacho d  
		  WHERE /* r.valor_facturar > 0 AND*/ r.cliente_id = $cliente_id AND r.clase_remesa = 'NN' AND r.remesa_id = d.remesa_id 
		  AND d.manifiesto_id = m.manifiesto_id AND m.fecha_mc 
		  BETWEEN '$desde' AND '$hasta' AND r.oficina_id = m.oficina_id AND m.estado != 'A') 
		  
		  UNION ALL 
		  
		  (SELECT m.fecha_du AS fecha,r.numero_remesa AS remesa,r.valor_facturar,m.despacho AS manifiesto,
		  
		  (SELECT  divipola FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,
		  (SELECT divipola FROM ubicacion WHERE ubicacion_id = m.destino_id) AS  destino,
		  m.placa,
		  
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE numero_identificacion = m.numero_identificacion_propietario)) 
		  AS tipo_identificacion_propietario_codigo,
		  
		  m.numero_identificacion_propietario,m.propietario, 
		  
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE numero_identificacion = m.numero_identificacion_tenedor)) AS 
		  tipo_identificacion_tenedor_codigo,
		  
		  m.numero_identificacion_tenedor,
		  
		  m.tenedor,
			
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE 
		  tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = m.conductor_id))) AS 
		  
		  tipo_identificacion_conductor_codigo,
		  
		  m.numero_identificacion,
		  
		  m.conductor,m.nombre,m.placa_remolque,
		  
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
		  FROM tercero WHERE numero_identificacion = m.numero_identificacion_propietario_remolque)) AS 
		  tipo_identificacion_propietario_remolque_codigo,
		  
		  m.numero_identificacion_propietario_remolque,
		  m.propietario_remolque,r.descripcion_producto,
		  
		  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = r.tipo_identificacion_remitente_id) AS 
		  tipo_identificacion_remitente, r.doc_remitente,r.remitente, (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = r.tipo_identificacion_destinatario_id) 
		  AS tipo_identificacion_destinatario, r.doc_destinatario,r.destinatario,m.observaciones FROM despachos_urbanos m, remesa r, detalle_despacho d  
		  WHERE /* r.valor_facturar > 0 AND*/ r.cliente_id = $cliente_id AND r.clase_remesa = 'NN' AND r.remesa_id = d.remesa_id AND d.despachos_urbanos_id = m.despachos_urbanos_id AND 
		  m.fecha_du BETWEEN '$desde' AND '$hasta' AND r.oficina_id = m.oficina_id AND m.estado != 'A')
		  
		  ) T ORDER BY manifiesto ASC";
		  
		  
          $result2 = $this -> DbFetchAll($select,$Conex);		  
		  
		  $arrayRemesas = array();
		  $contRemesas  = 0;
		  
		  for($j = 0; $j < count($result2); $j++){
		  		  
		      $remesa = $result2[$j]['remesa'];
			  
			  if(!in_array($remesa,$arrayRemesas)){
		  
		      $arrayRemesas[$contRemesas] = $remesa;
			  $contRemesas++;
			  $comp_ceros='';
			  if(strlen($result2[$j]['manifiesto'])==1)  $comp_ceros='00000';
			  if(strlen($result2[$j]['manifiesto'])==2)  $comp_ceros='0000';			  
			  if(strlen($result2[$j]['manifiesto'])==3)  $comp_ceros='000';			  			  
			  if(strlen($result2[$j]['manifiesto'])==4)  $comp_ceros='00';
			  if(strlen($result2[$j]['manifiesto'])==5)  $comp_ceros='0';
			  if(strlen($result2[$j]['manifiesto'])==6)  $comp_ceros='';			  
		  
			  $dataUIAF[$cont]['consecutivo']                   = $consecutivo;
			  //$dataUIAF[$cont]['remesa']                        = $result2[$j]['remesa'];		  			  
			  $dataUIAF[$cont]['fecha_transaccion']             = $result2[$j]['fecha'];		  
			  $dataUIAF[$cont]['numero_manifiesto']             = '4250878'.$comp_ceros.$result2[$j]['manifiesto'];		  		  
			  $dataUIAF[$cont]['origen']                        = $result2[$j]['origen'];		  		  		  
			  $dataUIAF[$cont]['destino']                       = $result2[$j]['destino'];	
			  $dataUIAF[$cont]['placa']                         = $result2[$j]['placa'];			  	  		  		  		  
			  $dataUIAF[$cont]['tipo_id_propietario']           = $result2[$j]['tipo_identificacion_propietario_codigo'];			  	  		  		
			  $dataUIAF[$cont]['id_propietario']                = $result2[$j]['numero_identificacion_propietario'];			  	  		  		  		  		      
			  $dataUIAF[$cont]['nombre_propietario']            = utf8_decode($result2[$j]['propietario']);			  	  		  		  		  		  		  
			  $dataUIAF[$cont]['tipo_id_tenedor']               = $result2[$j]['tipo_identificacion_tenedor_codigo'];			  	  		  		  		  		  	  
			  $dataUIAF[$cont]['id_tenedor']                    = $result2[$j]['numero_identificacion_tenedor'];			  	  		  		  		
			  $dataUIAF[$cont]['tenedor']                       = utf8_decode($result2[$j]['tenedor']);			  	  		  		  		  		  		  		
			  $dataUIAF[$cont]['tipo_id_conductor']             = $result2[$j]['tipo_identificacion_conductor_codigo'];			  	  		  		  		  		  	  
			  $dataUIAF[$cont]['id_conductor']                  = $result2[$j]['numero_identificacion'];	
			  $dataUIAF[$cont]['conductor']                     = utf8_decode($result2[$j]['nombre']);		  		  	  		  		  		  		  		
			  $dataUIAF[$cont]['placa_remolque']                = $result2[$j]['placa_remolque'];			  		  
			  $dataUIAF[$cont]['tipo_id_propietario_remolque']  = $result2[$j]['tipo_identificacion_propietario_remolque_codigo'];		  	  		  	  		  	  
			  $dataUIAF[$cont]['id_propietario_remolque']       = $result2[$j]['numero_identificacion_propietario_remolque'];		  	  		  	  		  		  	  
			  $dataUIAF[$cont]['nombre_propietario_remolque']   = utf8_decode($result2[$j]['propietario_remolque']);		  	  		  	  		  		  		  		
			  
			  $dataUIAF[$cont]['producto']                      = substr(utf8_decode($result2[$j]['descripcion_producto']),0,70);	
			  $dataUIAF[$cont]['tipo_id_remitente']             = $result2[$j]['tipo_identificacion_remitente'];		  	  		  	  		  		
			  $dataUIAF[$cont]['id_remitente']                  = $result2[$j]['doc_remitente'];		  	  		  	  		  		
			  $dataUIAF[$cont]['nombre_remitente']              = utf8_decode($result2[$j]['remitente']);		  	  		  	  		  		  		  		  		
			  $dataUIAF[$cont]['tipo_id_destinatario']          = $result2[$j]['tipo_identificacion_destinatario'];		  	  		  	  		
			  $dataUIAF[$cont]['id_destinatario']               = $result2[$j]['doc_destinatario'];		  	  		  	  		  	
			  $dataUIAF[$cont]['nombre_destinatario']           = utf8_decode($result2[$j]['destinatario']);		  	  		  	  		  		  		  		  				
			  
			  $dataUIAF[$cont]['valor_flete']                   = $result2[$j]['valor_facturar'];			  	  		  		  		  		  		  
			  $dataUIAF[$cont]['valor_flete_efectivo']          = 0;	
			  $dataUIAF[$cont]['observaciones']                 = substr(utf8_decode($result2[$j]['observaciones']),0,70);			  	  		  		  		  		  		  		  		    		  		  
			  $cont++;		  
			  $consecutivo++;
		  
		  }
		  
		  
		 } 
	   
	   }
	   	   
	   return $dataUIAF;		   
	   
	 }else{
	      exit('No existen manifiestos planillados en este rango de fechas!!!!');
	   } 
	     
  
  }  
   
}


?>