<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InterfazViajesModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  

  public function selectAnticiposRangoFecha($desde,$hasta,$Conex){
  
   include_once("../../operacion/clases/UtilidadesContablesModelClass.php");
   
   $utilidadesContables = new UtilidadesContablesModel();
  
   $select = "SELECT  m.manifiesto_id,count(m.manifiesto_id) AS num FROM anticipos_manifiesto a, manifiesto m WHERE m.propio = 0 AND a.manifiesto_id = m.manifiesto_id 
              AND a.valor > 0 AND m.fecha_mc BETWEEN '$desde' AND '$hasta' GROUP BY manifiesto_id HAVING count(m.manifiesto_id) > 1";
  		  
   $result = $this -> DbFetchAll($select,$Conex,true);  
   
   $anticiposManifiesto = null;
   
   for($i = 0; $i < count($result); $i++){ $anticiposManifiesto .= "'".$result[$i]['manifiesto_id']."',"; }  
   
   $anticiposManifiesto = substr($anticiposManifiesto,0,strlen($anticiposManifiesto) - 1);
   
   if(trim(strlen($anticiposManifiesto)) > 0){
     
     $select = "SELECT m.numero_identificacion_tenedor AS numero_identificacion,m.oficina_id,tn.tercero_id,m.manifiesto AS numero,m.valor_flete AS valor_despacho,
	 m.fecha_mc AS fecha,m.manifiesto AS numero_despacho,   	 
	 (SELECT impuesto_id FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte,(SELECT impuesto_id FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica,	 
	 
	 (SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte_val,(SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica_val,
	 
	 (SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
     plantilla,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS docant,
     am.valor  AS valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('MANIFIESTO No.',m.manifiesto) AS detall,'N' AS urbano,m.saldo_por_pagar  FROM manifiesto m, 
	 anticipos_manifiesto am,tenedor tn, oficina of WHERE am.valor > 0 AND m.estado NOT IN ('A','P') AND m.propio = 0 AND m.manifiesto_id NOT IN ($anticiposManifiesto) AND m.fecha_mc 
	 BETWEEN '$desde' AND '$hasta' AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND m.manifiesto_id = am.manifiesto_id";
   
   }else{
   
	    $select = "SELECT m.numero_identificacion_tenedor AS numero_identificacion,m.oficina_id,tn.tercero_id,m.manifiesto AS numero,m.valor_flete AS valor_despacho,m.fecha_mc AS fecha,m.manifiesto AS numero_despacho,   	
	    
		(SELECT impuesto_id FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	    WHERE rte = 1) LIMIT 1) AS rte,(SELECT impuesto_id FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
        IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica,
		
			 (SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte_val,(SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica_val,
		
		
		(SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
        plantilla,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS docant,
        am.valor  AS valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('MANIFIESTO No.',m.manifiesto) AS detall ,'N' AS urbano,m.saldo_por_pagar FROM manifiesto m, 
	    anticipos_manifiesto am,tenedor tn, oficina of WHERE am.valor > 0 AND m.estado NOT IN ('A','P') AND m.propio = 0 AND m.fecha_mc BETWEEN '$desde' AND '$hasta' 
	    AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND m.manifiesto_id = am.manifiesto_id";	   
   
     }
	 
   $anticiposM = $this -> DbFetchAll($select,$Conex,true);	 
      
   $select = "SELECT  m.despachos_urbanos_id,count(m.despachos_urbanos_id) AS num FROM anticipos_despacho a, despachos_urbanos m 
   WHERE m.propio = 0 AND a.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' GROUP BY despachos_urbanos_id HAVING 
   count(m.despachos_urbanos_id) > 1";
  		  
   $result = $this -> DbFetchAll($select,$Conex,true);  
   
   $anticiposDespacho = null;
   
   for($i = 0; $i < count($result); $i++){ $anticiposDespacho .= "'".$result[$i]['despachos_urbanos_id']."',"; }  
   
   $anticiposDespacho = substr($anticiposDespacho,0,strlen($anticiposDespacho) - 1);
   
   if(trim(strlen($anticiposDespacho)) > 0){
     
     $select = "SELECT m.numero_identificacion_tenedor AS numero_identificacion,m.oficina_id,tn.tercero_id,m.despacho AS numero,m.valor_flete AS valor_despacho,m.fecha_du AS fecha,m.despacho AS numero_despacho,   	 
	 (SELECT impuesto_id FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM 
	 tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte,(SELECT impuesto_id FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica,
	 
	 
	 (SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM 
	 tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte_val,
	 	  (SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM 
	 tabla_impuestos 
	 WHERE ica = 1) LIMIT 1) AS ica_val,
	 	 	 
	 (SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
     plantilla,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS docant,
     am.valor  AS valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('DESPACHO No.',m.despacho) AS detall ,'N' AS urbano,m.saldo_por_pagar FROM despachos_urbanos m, 
	 anticipos_despacho am,tenedor tn, oficina of WHERE am.valor > 0 AND m.estado NOT IN ('A','P') AND m.propio = 0 AND  m.despachos_urbanos_id NOT IN ($anticiposDespacho) AND m.fecha_du   
	 BETWEEN '$desde' AND '$hasta' AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND m.despachos_urbanos_id = am.despachos_urbanos_id";
   
   }else{
   
	    $select = "SELECT m.numero_identificacion_tenedor AS numero_identificacion,m.oficina_id,tn.tercero_id,m.despacho AS numero,m.valor_flete AS valor_despacho,m.fecha_du AS fecha,m.despacho AS numero_despacho,   	 
	 (SELECT impuesto_id FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM 
	 tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte,(SELECT impuesto_id FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica,
	 
	 	  (SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM 
	 tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte_val,
	 	  (SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM 
	 tabla_impuestos 
	 WHERE ica = 1) LIMIT 1) AS ica_val,
	 	 	 	 
	 
	 (SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
     plantilla,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS docant,
     am.valor  AS valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('DESPACHO No.',m.despacho) AS detall,'N' AS urbano,m.saldo_por_pagar FROM despachos_urbanos m, 
	 anticipos_despacho am,tenedor tn, oficina of WHERE am.valor > 0 AND m.estado NOT IN ('A','P') AND m.propio = 0 AND m.fecha_du BETWEEN '$desde' AND '$hasta' 
	 AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND m.despachos_urbanos_id = am.despachos_urbanos_id";	   
   
     }
  			  
   $anticiposD = $this -> DbFetchAll($select,$Conex,true);
   
   if(is_array($anticiposM) && is_array($anticiposD)){
     $anticipos = array_merge($anticiposM,$anticiposD);
   }else{
      
	    if(is_array($anticiposM)){
		  $anticipos = $anticiposM;
		}else if(is_array($anticiposD)){
		     $anticipos = $anticiposD;
		  }else{
		       exit("<p align='center'><b>No existen manifiestos liquidados en este rango de fechas!!</b></p>");
		    }
   
     }
   
   
   $select  = "SELECT td.codigo FROM tipo_de_documento td, parametros_liquidacion pl WHERE pl.tipo_documento_id = td.tipo_documento_id";    
   $tipoDoc = $this -> DbFetchAll($select,$Conex,true);				   			   
   				   
   $arrayInterfaz = array();
   $cont          = 0;
  
   $despachosSinEgresoAnticipo = null;
      
   for($i = 0; $i < count($anticipos); $i++){
   
     if(strlen(trim($anticipos[$i]['docant'])) > 0){     
   
     $saldo_por_pagar = $anticipos[$i]['saldo_por_pagar'];   
	 
	 if($saldo_por_pagar > 0){
   		 
		 $valAnticipo = $anticipos[$i]['valant'];
		 $base        = $anticipos[$i]['valant'];
		 $oficina_id  = $anticipos[$i]['oficina_id'];
		  
		 $periodo_contable_id = $utilidadesContables -> getPeriodoContableId(date($desde),$Conex);		 		 
		 $rte_val             = $anticipos[$i]['rte_val'];	 
		 
		 if($rte_val > 0){
		 
			 $dataRte             = $utilidadesContables -> getDataImpuestoId($anticipos[$i]['rte'],$periodo_contable_id,$oficina_id,$Conex);
			 $porcentajeRte       = $dataRte[0]['porcentaje'];
			 $formulaRte          = str_replace('PORCENTAJE',$porcentajeRte,str_replace('BASE',$base,$dataRte[0]['formula']));
			 
			 $select    = "SELECT $formulaRte AS rte";
			 $resultRte = $this -> DbFetchAll($select,$Conex,true);		 
			 $rte       = $resultRte[0]['rte'];	 			 		   
		 
		 }else{
		     
			   $rte = 0;
		 
		   }
		   
		 $ica_val = $anticipos[$i]['ica_val'];	
		 
		 if($ica_val > 0){
		 
			 $dataIca             = $utilidadesContables -> getDataImpuestoId($anticipos[$i]['ica'],$periodo_contable_id,$oficina_id,$Conex);
			 $porcentajeIca       = $dataIca[0]['porcentaje'];
			 $formulaIca          = str_replace('PORCENTAJE',$porcentajeIca,str_replace('BASE',$base,$dataIca[0]['formula']));
			 
			 $select    = "SELECT $formulaIca AS ica";
			 $resultIca = $this -> DbFetchAll($select,$Conex,true);		 
			 $ica       = $resultIca[0]['ica'];	 		 
		 
		 }else{
		   
		       $ica = 0;
		   
		   }		   
		   
		 $base = ($base  + $rte + $ica);
	
		 if($rte_val > 0){
		 	
		   $formulaRte= str_replace('PORCENTAJE',$porcentajeRte,str_replace('BASE',$base,$dataRte[0]['formula']));	 
		   $select    = "SELECT $formulaRte AS rte";
		   $resultRte = $this -> DbFetchAll($select,$Conex,true);		 
		   $rte       = round($resultRte[0]['rte']);	
		 
		 }
		 
		 if($ica_val > 0){
		 
		   $formulaIca= str_replace('PORCENTAJE',$porcentajeIca,str_replace('BASE',$base,$dataIca[0]['formula']));	 
		   $select    = "SELECT $formulaIca AS ica";
		   $resultIca = $this -> DbFetchAll($select,$Conex,true);		 
		   $ica       = round($resultIca[0]['ica']);	 		 
		 
		 }		 
		 			 
		 $arrayInterfaz[$cont]['AÑO']	     =  substr($anticipos[$i]['fecha'],0,4);
		 $arrayInterfaz[$cont]['MES']	     =	substr($anticipos[$i]['fecha'],5,2);	
		 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
		 $arrayInterfaz[$cont]['NUMERO']	 =	$anticipos[$i]['numero'];	
		 $arrayInterfaz[$cont]['NUMREG']	 =	'1';	
		 $arrayInterfaz[$cont]['FECHA']	     =	$anticipos[$i]['fecha'];		
		 $arrayInterfaz[$cont]['NIT']	     =	$anticipos[$i]['numero_identificacion'];
		 $arrayInterfaz[$cont]['VALFLE']	 =	$base;	
		 $arrayInterfaz[$cont]['IVA']	     =	'0';	
		 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
		 $arrayInterfaz[$cont]['DTO']	     =	'0';	
		 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
		 $arrayInterfaz[$cont]['RTE']	     =	'1';		
		 $arrayInterfaz[$cont]['VALRTE']	 =	$rte > 0 ? $rte : 0;			
		 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
		 $arrayInterfaz[$cont]['VALICA']	 =	$ica > 0 ? $ica : 0;					
		 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
		 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
		 $arrayInterfaz[$cont]['PLANTI']	 =	$anticipos[$i]['plantilla'];										
		 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($anticipos[$i]['fecha'],0,4);	
		 $arrayInterfaz[$cont]['MESREF']	 =	substr($anticipos[$i]['fecha'],5,2);	
		 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
		 $arrayInterfaz[$cont]['NUMREF']	 =	$anticipos[$i]['numero'];	
		 $arrayInterfaz[$cont]['REGREF']	 =	'1';		
		 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($anticipos[$i]['fecha'],0,4);	
		 $arrayInterfaz[$cont]['MESANT']	 =	substr($anticipos[$i]['fecha'],5,2);	
		 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
		 $arrayInterfaz[$cont]['DOCANT']	 =	$anticipos[$i]['docant'];		
		 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
		 $arrayInterfaz[$cont]['VALANT']	 =	$anticipos[$i]['valant'];	
		 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
		 $arrayInterfaz[$cont]['CODSUC']	 =	$anticipos[$i]['codsuc'];	
		 $arrayInterfaz[$cont]['CENCOS']	 =	$anticipos[$i]['cencos'];			
		 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
		 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
		 $arrayInterfaz[$cont]['CLASI3']	 =	'999';		
		 $arrayInterfaz[$cont]['DETALL']	 =	$anticipos[$i]['detall'];					
		 $arrayInterfaz[$cont]['FECVEN']	 =	$anticipos[$i]['fecha'];
		 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
		 $arrayInterfaz[$cont]['FECTAS']	 =	$anticipos[$i]['fecha'];	
		 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
		 $arrayInterfaz[$cont]['FACPRO']	 =	$anticipos[$i]['numero_despacho'];
		 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
		 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
		 $arrayInterfaz[$cont]['URBANO']	 =	$anticipos[$i]['urbano'];		
		 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
		 $arrayInterfaz[$cont]['NOICAS']	 =	'N';
		 
		 $cont++;
			 
		 $valor_despacho = $anticipos[$i]['valor_despacho'];
		 $rte_valor      = $anticipos[$i]['rte_val'];
		 $ica_valor      = $anticipos[$i]['ica_val'];	 	 	 
		 $base           = ($valor_despacho -  $base);
		 $rte            = ($rte_valor - $rte);	
		 $ica            = ($ica_valor - $ica);
		 
		 $anticipos[$i]['valant'] = 0;	 
		 
		 $arrayInterfaz[$cont]['AÑO']	     =  substr($anticipos[$i]['fecha'],0,4);
		 $arrayInterfaz[$cont]['MES']	     =	substr($anticipos[$i]['fecha'],5,2);	
		 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
		 $arrayInterfaz[$cont]['NUMERO']	 =	$anticipos[$i]['numero'];	
		 $arrayInterfaz[$cont]['NUMREG']	 =	'2';	
		 $arrayInterfaz[$cont]['FECHA']	     =	$anticipos[$i]['fecha'];		
		 $arrayInterfaz[$cont]['NIT']	     =	$anticipos[$i]['numero_identificacion'];
		 $arrayInterfaz[$cont]['VALFLE']	 =	$base;	
		 $arrayInterfaz[$cont]['IVA']	     =	'0';	
		 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
		 $arrayInterfaz[$cont]['DTO']	     =	'0';	
		 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
		 $arrayInterfaz[$cont]['RTE']	     =	'1';		
		 $arrayInterfaz[$cont]['VALRTE']	 =	$rte > 0 ? $rte : 0;			
		 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
		 $arrayInterfaz[$cont]['VALICA']	 =	$ica > 0 ? $ica : 0;					
		 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
		 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
		 $arrayInterfaz[$cont]['PLANTI']	 =	$anticipos[$i]['plantilla'];										
		 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($anticipos[$i]['fecha'],0,4);	
		 $arrayInterfaz[$cont]['MESREF']	 =	substr($anticipos[$i]['fecha'],5,2);	
		 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
		 $arrayInterfaz[$cont]['NUMREF']	 =	$anticipos[$i]['numero'];	
		 $arrayInterfaz[$cont]['REGREF']	 =	'2';		
		 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($anticipos[$i]['fecha'],0,4);	
		 $arrayInterfaz[$cont]['MESANT']	 =	substr($anticipos[$i]['fecha'],5,2);	
		 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
		 $arrayInterfaz[$cont]['DOCANT']	 =	'0';		
		 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
		 $arrayInterfaz[$cont]['VALANT']	 =	$anticipos[$i]['valant'];	
		 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
		 $arrayInterfaz[$cont]['CODSUC']	 =	$anticipos[$i]['codsuc'];	
		 $arrayInterfaz[$cont]['CENCOS']	 =	$anticipos[$i]['cencos'];			
		 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
		 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
		 $arrayInterfaz[$cont]['CLASI3']	 =	'999';		
		 $arrayInterfaz[$cont]['DETALL']	 =	$anticipos[$i]['detall'];					
		 $arrayInterfaz[$cont]['FECVEN']	 =	$anticipos[$i]['fecha'];
		 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
		 $arrayInterfaz[$cont]['FECTAS']	 =	$anticipos[$i]['fecha'];	
		 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
		 $arrayInterfaz[$cont]['FACPRO']	 =	$anticipos[$i]['numero_despacho'];
		 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
		 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
		 $arrayInterfaz[$cont]['URBANO']	 =	$anticipos[$i]['urbano'];		
		 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
		 $arrayInterfaz[$cont]['NOICAS']	 =	'N';	 
		 
		 $cont++;
	   
	  }
   
     }else{
	 
	      $despachosSinEgresoAnticipo .= "{$anticipos[$i]['numero_despacho']},";
	 
	   }
   
   }  
       
   if(trim(strlen($anticiposManifiesto)) > 0){
   
      $manifiestos = explode(",",$anticiposManifiesto);
	    
	  for($i = 0; $i < count($manifiestos); $i++){
	  
         $manifiesto_id = str_replace("'",'',$manifiestos[$i]);
		 $numReg        = 1;
		 
         $select = "SELECT m.oficina_id,tn.tercero_id,m.manifiesto AS numero,m.valor_flete AS valor_despacho,m.fecha_mc AS fecha,m.manifiesto AS numero_despacho,   	 
	 (SELECT impuesto_id FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte,(SELECT impuesto_id FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica,
	 
	 
	 (SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte_val,(SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica_val,
	 
	 (SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
     plantilla,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS docant,
     am.valor  AS valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('MANIFIESTO No.',m.manifiesto) AS detall,'N' AS urbano,m.saldo_por_pagar  FROM manifiesto m, 
	 anticipos_manifiesto am,tenedor tn, oficina of WHERE am.valor > 0 AND m.estado NOT IN ('A','P') AND m.manifiesto_id =  $manifiesto_id AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND 
	 m.manifiesto_id = am.manifiesto_id";				

         $dataDespacho    = $this -> DbFetchAll($select,$Conex,true);			 
         $saldo_por_pagar = $dataDespacho[0]['saldo_por_pagar'];	 
		 $valor_despacho  = $dataDespacho[0]['valor_despacho'];	 
		 
		 $baseDespacho    = 0;
		 $rteDespacho     = 0;
		 $icaDespacho     = 0;
		 
		 if($saldo_por_pagar > 0){
		 
    		 $select          = "SELECT m.manifiesto AS numero_despacho,am.consecutivo,DATE(am.fecha_egreso) 
			                     AS fecha_egreso,am.valor,am.oficina_id,tn.tercero_id,tr.numero_identificacion,am.valor,m.oficina_id,'002' AS cencos,
			                     of.codigo_centro AS codsuc FROM anticipos_manifiesto am,tenedor tn, manifiesto m,oficina of,tercero tr WHERE am.valor > 0 AND 
								 am.manifiesto_id = $manifiesto_id AND 
								 am.manifiesto_id = m.manifiesto_id AND am.tenedor_id = tn.tenedor_id AND tn.tercero_id = tr.tercero_id AND am.oficina_id = of.oficina_id";
             $anticipos       = $this -> DbFetchAll($select,$Conex,true);		
			 
			 $falatEgreso     = false;			 		
			 
			 for($j = 0; $j < count($anticipos); $j++){
			 
			  if(!strlen(trim($anticipos[$j]['consecutivo'])) > 0){								 
			    $despachosSinEgresoAnticipo .= "{$anticipos[$j]['numero_despacho']},";
				$falatEgreso                 = true;	
				break;				   
			  }		
					 
		     }
			 
			 if(!$falatEgreso){			 
			 								 
			 for($j = 0; $j < count($anticipos); $j++){	
			 						  
					 
					 $valAnticipo = $anticipos[$j]['valor'];
					 $base        = $anticipos[$j]['valor'];
					 $oficina_id  = $anticipos[$j]['oficina_id'];					 
					 $rte_val     = $anticipos[$j]['rte_val'];					 			 
					  
					 $periodo_contable_id = $utilidadesContables -> getPeriodoContableId(date($desde),$Conex);
					 
					 if($rte_val > 0){					 
					 
					   $dataRte             = $utilidadesContables -> getDataImpuestoId($dataDespacho[0]['rte'],$periodo_contable_id,$oficina_id,$Conex);
					   $porcentajeRte       = $dataRte[0]['porcentaje'];
					   $formulaRte          = str_replace('PORCENTAJE',$porcentajeRte,str_replace('BASE',$base,$dataRte[0]['formula']));
					 
					   $select    = "SELECT $formulaRte AS rte";
					   $resultRte = $this -> DbFetchAll($select,$Conex,true);		 
					   $rte       = $resultRte[0]['rte'];	 
					 
					 }else{
					     $rte = 0;
					   }
					 
					 
 					 $ica_val = $anticipos[$j]['ica_val'];		
					 
					 if($ica_val > 0){
					 
					  $dataIca             = $utilidadesContables -> getDataImpuestoId($dataDespacho[0]['ica'],$periodo_contable_id,$oficina_id,$Conex);
					  $porcentajeIca       = $dataIca[0]['porcentaje'];
					  $formulaIca          = str_replace('PORCENTAJE',$porcentajeIca,str_replace('BASE',$base,$dataIca[0]['formula']));
					 
					  $select    = "SELECT $formulaIca AS ica";
					  $resultIca = $this -> DbFetchAll($select,$Conex,true);		 
					  $ica       = $resultIca[0]['ica'];	 
					 
					 }else{					    
						 $ica = 0;					    
					   }
					   
					   
					 
					 $base      = ($base  + $rte + $ica);
					 
					 $baseDespacho += $base;		 
				
					 if($rte_val > 0){				
				
					   $formulaRte= str_replace('PORCENTAJE',$porcentajeRte,str_replace('BASE',$base,$dataRte[0]['formula']));	 
					   $select    = "SELECT $formulaRte AS rte";
					   $resultRte = $this -> DbFetchAll($select,$Conex,true);		 
					   $rte       = round($resultRte[0]['rte']);					 
					 
					 }
					 
					 
					 if($ica_val > 0){
					 					 
					   $formulaIca= str_replace('PORCENTAJE',$porcentajeIca,str_replace('BASE',$base,$dataIca[0]['formula']));	 
					   $select    = "SELECT $formulaIca AS ica";
					   $resultIca = $this -> DbFetchAll($select,$Conex,true);		 
					   $ica       = round($resultIca[0]['ica']);	
					   
					 }
					 
					 $rteDespacho  += $rte;
					 $icaDespacho  += $ica;						  	
					 
					 $arrayInterfaz[$cont]['AÑO']	     =  substr($anticipos[$j]['fecha_egreso'],0,4);
					 $arrayInterfaz[$cont]['MES']	     =	substr($anticipos[$j]['fecha_egreso'],5,2);	
					 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
					 $arrayInterfaz[$cont]['NUMERO']	 =	$dataDespacho[0]['numero'];	
					 $arrayInterfaz[$cont]['NUMREG']	 =	$numReg;	
					 $arrayInterfaz[$cont]['FECHA']	     =	$anticipos[$j]['fecha_egreso'];		
					 $arrayInterfaz[$cont]['NIT']	     =	$anticipos[$j]['numero_identificacion'];
					 $arrayInterfaz[$cont]['VALFLE']	 =	$base;	
					 $arrayInterfaz[$cont]['IVA']	     =	'0';	
					 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
					 $arrayInterfaz[$cont]['DTO']	     =	'0';	
					 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
					 $arrayInterfaz[$cont]['RTE']	     =	'1';		
					 $arrayInterfaz[$cont]['VALRTE']	 =	$rte > 0 ? $rte : 0;			
					 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
					 $arrayInterfaz[$cont]['VALICA']	 =	$ica > 0 ? $ica : 0;					
					 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
					 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
					 $arrayInterfaz[$cont]['PLANTI']	 =	$dataDespacho[0]['plantilla'];										
					 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($anticipos[$j]['fecha_egreso'],0,4);	
					 $arrayInterfaz[$cont]['MESREF']	 =	substr($anticipos[$j]['fecha_egreso'],5,2);	
					 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
					 $arrayInterfaz[$cont]['NUMREF']	 =	$dataDespacho[0]['numero'];	
					 $arrayInterfaz[$cont]['REGREF']	 =	$numReg;		
					 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($anticipos[$j]['fecha_egreso'],0,4);	
					 $arrayInterfaz[$cont]['MESANT']	 =	substr($anticipos[$j]['fecha_egreso'],5,2);	
					 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
					 $arrayInterfaz[$cont]['DOCANT']	 =	$anticipos[$j]['consecutivo'];		
					 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
					 $arrayInterfaz[$cont]['VALANT']	 =	$anticipos[$j]['valor'];	
					 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
					 $arrayInterfaz[$cont]['CODSUC']	 =	$anticipos[$j]['codsuc'];	
					 $arrayInterfaz[$cont]['CENCOS']	 =	$anticipos[$j]['cencos'];			
					 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
					 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
					 $arrayInterfaz[$cont]['CLASI3']	 =	'999';		
					 $arrayInterfaz[$cont]['DETALL']	 =	$dataDespacho[0]['detall'];					
					 $arrayInterfaz[$cont]['FECVEN']	 =	$anticipos[$j]['fecha_egreso'];
					 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
					 $arrayInterfaz[$cont]['FECTAS']	 =	$anticipos[$j]['fecha_egreso'];	
					 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
					 $arrayInterfaz[$cont]['FACPRO']	 =	$dataDespacho[0]['numero_despacho'];
					 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
					 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
					 $arrayInterfaz[$cont]['URBANO']	 =	$dataDespacho[0]['urbano'];		
					 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
					 $arrayInterfaz[$cont]['NOICAS']	 =	'N';			 
					
					 $numReg++;		 
					 $cont++;			 

			 
			 }
			 

				 
				 $tercero_id            = $dataDespacho[0]['tercero_id'];
				 $select                = "SELECT numero_identificacion FROM tercero WHERE tercero_id = $tercero_id";			 
				 $dataTercero           = $this -> DbFetchAll($select,$Conex,true);	
				 $numero_identificacion = $dataTercero[0]['numero_identificacion'];
								 
				 $valor_despacho = $dataDespacho[0]['valor_despacho'];
				 $rte_valor      = $dataDespacho[0]['rte_val'];
				 $ica_valor      = $dataDespacho[0]['ica_val'];	 	 	 
				 $base           = ($valor_despacho -  $baseDespacho);
				 $rte            = ($rte_valor - $rteDespacho);	
				 $ica            = ($ica_valor - $icaDespacho);
				 
				 $anticipos[$j]['valant'] = 0;	 
				 
				 $arrayInterfaz[$cont]['AÑO']	     =  substr($dataDespacho[0]['fecha'],0,4);
				 $arrayInterfaz[$cont]['MES']	     =	substr($dataDespacho[0]['fecha'],5,2);	
				 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
				 $arrayInterfaz[$cont]['NUMERO']	 =	$dataDespacho[0]['numero'];
				 $arrayInterfaz[$cont]['NUMREG']	 =	$numReg;	
				 $arrayInterfaz[$cont]['FECHA']	     =	$dataDespacho[0]['fecha'];		
				 $arrayInterfaz[$cont]['NIT']	     =	$numero_identificacion;
				 $arrayInterfaz[$cont]['VALFLE']	 =	$base;	
				 $arrayInterfaz[$cont]['IVA']	     =	'0';	
				 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
				 $arrayInterfaz[$cont]['DTO']	     =	'0';	
				 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
				 $arrayInterfaz[$cont]['RTE']	     =	'1';		
				 $arrayInterfaz[$cont]['VALRTE']	 =	$rte > 0 ? $rte : 0;			
				 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
				 $arrayInterfaz[$cont]['VALICA']	 =	$ica > 0 ? $ica : 0;					
				 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
				 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
				 $arrayInterfaz[$cont]['PLANTI']	 =	$dataDespacho[0]['plantilla'];										
				 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($dataDespacho[0]['fecha'],0,4);	
				 $arrayInterfaz[$cont]['MESREF']	 =	substr($dataDespacho[0]['fecha'],5,2);	
				 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
				 $arrayInterfaz[$cont]['NUMREF']	 =	$dataDespacho[0]['numero'];
				 $arrayInterfaz[$cont]['REGREF']	 =	$numReg;		
				 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($dataDespacho[0]['fecha'],0,4);	
				 $arrayInterfaz[$cont]['MESANT']	 =	substr($dataDespacho[0]['fecha'],5,2);	
				 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
				 $arrayInterfaz[$cont]['DOCANT']	 =	'0';		
				 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
				 $arrayInterfaz[$cont]['VALANT']	 =	'0';	
				 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
				 $arrayInterfaz[$cont]['CODSUC']	 =	$dataDespacho[0]['codsuc'];	
				 $arrayInterfaz[$cont]['CENCOS']	 =	$dataDespacho[0]['cencos'];			
				 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
				 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
				 $arrayInterfaz[$cont]['CLASI3']	 =	'999';	
				 $arrayInterfaz[$cont]['DETALL']	 =	$dataDespacho[0]['detall'];					
				 $arrayInterfaz[$cont]['FECVEN']	 =	$dataDespacho[0]['fecha'];
				 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
				 $arrayInterfaz[$cont]['FECTAS']	 =	$dataDespacho[0]['fecha'];	
				 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
				 $arrayInterfaz[$cont]['FACPRO']	 =	$dataDespacho[0]['numero_despacho'];
				 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
				 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
				 $arrayInterfaz[$cont]['URBANO']	 =	$dataDespacho[0]['urbano'];		
				 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
				 $arrayInterfaz[$cont]['NOICAS']	 =	'N';	 
				 
				 $cont++;			 
				}
			
		 }
	  
	  }
   
   }
   
   if(trim(strlen($anticiposDespacho)) > 0){
      
      $manifiestos = explode(",",$anticiposDespacho);
	    
	  for($i = 0; $i < count($manifiestos); $i++){
	  
         $manifiesto_id = str_replace("'",'',$manifiestos[$i]);
		 $numReg        = 1;
		 
         $select = "SELECT m.despacho AS numero_despacho,m.oficina_id,tn.tercero_id,m.despacho AS numero,m.valor_flete AS valor_despacho,m.fecha_du AS fecha,m.despacho AS numero_despacho,   	 
	 (SELECT impuesto_id FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte,(SELECT impuesto_id FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica,
	 
	 
	 (SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	 WHERE rte = 1) LIMIT 1) AS rte_val,(SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id 
     IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica_val,
	 
	 (SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
     plantilla,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS docant,
     am.valor  AS valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('DESPACHO No.',m.despacho) AS detall,'N' AS urbano,m.saldo_por_pagar  FROM despachos_urbanos m, 
	 anticipos_despacho am,tenedor tn, oficina of WHERE am.valor > 0 AND m.estado NOT IN ('A','P') AND m.despachos_urbanos_id =  $manifiesto_id AND m.tenedor_id = tn.tenedor_id AND 
	 m.oficina_id = of.oficina_id AND m.despachos_urbanos_id = am.despachos_urbanos_id";				

         $dataDespacho    = $this -> DbFetchAll($select,$Conex,true);			 
         $saldo_por_pagar = $dataDespacho[0]['saldo_por_pagar'];	 
		 $valor_despacho  = $dataDespacho[0]['valor_despacho'];	 
		 
		 $baseDespacho    = 0;
		 $rteDespacho     = 0;
		 $icaDespacho     = 0;
		 
		 if($saldo_por_pagar > 0){
		 
    		 $select          = "SELECT m.despacho AS numero_despacho,am.consecutivo,DATE(am.fecha_egreso) 
			                     AS fecha_egreso,am.valor,am.oficina_id,tn.tercero_id,tr.numero_identificacion,am.valor,m.oficina_id,'002' AS cencos,
			                     of.codigo_centro AS codsuc FROM anticipos_despacho am,tenedor tn, despachos_urbanos m,oficina of,tercero tr WHERE am.valor > 0 
								 AND am.despachos_urbanos_id =    
								 $manifiesto_id AND am.despachos_urbanos_id = m.despachos_urbanos_id AND am.tenedor_id = tn.tenedor_id AND tn.tercero_id = tr.tercero_id 
								 AND am.oficina_id = of.oficina_id";
             $anticipos       = $this -> DbFetchAll($select,$Conex,true);
			 
			 $falatEgreso     = false;			 		
			 
			 for($j = 0; $j < count($anticipos); $j++){
			 
			  if(!strlen(trim($anticipos[$j]['consecutivo'])) > 0){								 
			    $despachosSinEgresoAnticipo .= "{$anticipos[$j]['numero_despacho']},";
				$falatEgreso                 = true;	
				break;				   
			  }		
					 
		     }
			 
			 
			if(!$falatEgreso){
												 
				 for($j = 0; $j < count($anticipos); $j++){						 
						 
						 $valAnticipo = $anticipos[$j]['valor'];
						 $base        = $anticipos[$j]['valor'];
						 $oficina_id  = $anticipos[$j]['oficina_id'];						 
						 $rte_val     = $anticipos[$j]['rte_val'];						 
						  
						 $periodo_contable_id = $utilidadesContables -> getPeriodoContableId(date($desde),$Conex);
						 
						 if($rte_val > 0){
						 
						  $dataRte             = $utilidadesContables -> getDataImpuestoId($dataDespacho[0]['rte'],$periodo_contable_id,$oficina_id,$Conex);
						  $porcentajeRte       = $dataRte[0]['porcentaje'];
						  $formulaRte          = str_replace('PORCENTAJE',$porcentajeRte,str_replace('BASE',$base,$dataRte[0]['formula']));
						 
						  $select    = "SELECT $formulaRte AS rte";
						  $resultRte = $this -> DbFetchAll($select,$Conex,true);		 
						  $rte       = $resultRte[0]['rte'];	 
						 
						 }else{
						    $rte = 0;
						   }
						   
						 $ica_val = $anticipos[$j]['ica_val'];	
						 
						 if($ica_val > 0){						   
						 
						  $dataIca             = $utilidadesContables -> getDataImpuestoId($dataDespacho[0]['ica'],$periodo_contable_id,$oficina_id,$Conex);
						  $porcentajeIca       = $dataIca[0]['porcentaje'];
						  $formulaIca          = str_replace('PORCENTAJE',$porcentajeIca,str_replace('BASE',$base,$dataIca[0]['formula']));
						 
						  $select    = "SELECT $formulaIca AS ica";
						  $resultIca = $this -> DbFetchAll($select,$Conex,true);		 
						  $ica       = $resultIca[0]['ica'];	 
						 
						 }else{
						    
							  $ica = 0;
						 
						   }
						 
						 $base      = ($base  + $rte + $ica);
						 
						 $baseDespacho += $base;		 					
					
					     if($rte_val > 0){
						 
						  $formulaRte= str_replace('PORCENTAJE',$porcentajeRte,str_replace('BASE',$base,$dataRte[0]['formula']));	 
						  $select    = "SELECT $formulaRte AS rte";
						  $resultRte = $this -> DbFetchAll($select,$Conex,true);		 
						  $rte       = round($resultRte[0]['rte']);					 
						 
						 }
						 
					     if($ica_val > 0){						 
						 
						  $formulaIca= str_replace('PORCENTAJE',$porcentajeIca,str_replace('BASE',$base,$dataIca[0]['formula']));	 
						  $select    = "SELECT $formulaIca AS ica";
						  $resultIca = $this -> DbFetchAll($select,$Conex,true);		 
						  $ica       = round($resultIca[0]['ica']);	
						  
						 }
						 
						 $rteDespacho  += $rte;
						 $icaDespacho  += $ica;						  	
						 
						 $arrayInterfaz[$cont]['AÑO']	     =  substr($anticipos[$j]['fecha_egreso'],0,4);
						 $arrayInterfaz[$cont]['MES']	     =	substr($anticipos[$j]['fecha_egreso'],5,2);	
						 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
						 $arrayInterfaz[$cont]['NUMERO']	 =	$dataDespacho[0]['numero'];	
						 $arrayInterfaz[$cont]['NUMREG']	 =	$numReg;	
						 $arrayInterfaz[$cont]['FECHA']	     =	$anticipos[$j]['fecha_egreso'];		
						 $arrayInterfaz[$cont]['NIT']	     =	$anticipos[$j]['numero_identificacion'];
						 $arrayInterfaz[$cont]['VALFLE']	 =	$base;	
						 $arrayInterfaz[$cont]['IVA']	     =	'0';	
						 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
						 $arrayInterfaz[$cont]['DTO']	     =	'0';	
						 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
						 $arrayInterfaz[$cont]['RTE']	     =	'1';		
						 $arrayInterfaz[$cont]['VALRTE']	 =	$rte > 0 ? $rte : 0;			
						 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
						 $arrayInterfaz[$cont]['VALICA']	 =	$ica > 0 ? $ica : 0;					
						 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
						 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
						 $arrayInterfaz[$cont]['PLANTI']	 =	$dataDespacho[0]['plantilla'];										
						 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($anticipos[$j]['fecha_egreso'],0,4);	
						 $arrayInterfaz[$cont]['MESREF']	 =	substr($anticipos[$j]['fecha_egreso'],5,2);	
						 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
						 $arrayInterfaz[$cont]['NUMREF']	 =	$dataDespacho[0]['numero'];	
						 $arrayInterfaz[$cont]['REGREF']	 =	$numReg;		
						 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($anticipos[$j]['fecha_egreso'],0,4);	
						 $arrayInterfaz[$cont]['MESANT']	 =	substr($anticipos[$j]['fecha_egreso'],5,2);	
						 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
						 $arrayInterfaz[$cont]['DOCANT']	 =	$anticipos[$j]['consecutivo'];		
						 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
						 $arrayInterfaz[$cont]['VALANT']	 =	$anticipos[$j]['valor'];	
						 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
						 $arrayInterfaz[$cont]['CODSUC']	 =	$anticipos[$j]['codsuc'];	
						 $arrayInterfaz[$cont]['CENCOS']	 =	$anticipos[$j]['cencos'];			
						 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
						 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
						 $arrayInterfaz[$cont]['CLASI3']	 =	'999';		
						 $arrayInterfaz[$cont]['DETALL']	 =	$dataDespacho[0]['detall'];					
						 $arrayInterfaz[$cont]['FECVEN']	 =	$anticipos[$j]['fecha_egreso'];
						 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
						 $arrayInterfaz[$cont]['FECTAS']	 =	$anticipos[$j]['fecha_egreso'];	
						 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
						 $arrayInterfaz[$cont]['FACPRO']	 =	$dataDespacho[0]['numero_despacho'];
						 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
						 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
						 $arrayInterfaz[$cont]['URBANO']	 =	$dataDespacho[0]['urbano'];		
						 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
						 $arrayInterfaz[$cont]['NOICAS']	 =	'N';			 
						
						 $numReg++;		 
						 $cont++;
	 
				 
				 }
				 
					 
					 $tercero_id            = $dataDespacho[0]['tercero_id'];
					 $select                = "SELECT numero_identificacion FROM tercero WHERE tercero_id = $tercero_id";			 
					 $dataTercero           = $this -> DbFetchAll($select,$Conex,true);	
					 $numero_identificacion = $dataTercero[0]['numero_identificacion'];
									 
					 $valor_despacho = $dataDespacho[0]['valor_despacho'];
					 $rte_valor      = $dataDespacho[0]['rte_val'];
					 $ica_valor      = $dataDespacho[0]['ica_val'];	 	 	 
					 $base           = ($valor_despacho -  $baseDespacho);
		
					 $rte            = ($rte_valor - $rteDespacho);	
					 $ica            = ($ica_valor - $icaDespacho);
					 
					 $anticipos[$j]['valant'] = 0;	 
					 
					 $arrayInterfaz[$cont]['AÑO']	     =  substr($dataDespacho[0]['fecha'],0,4);
					 $arrayInterfaz[$cont]['MES']	     =	substr($dataDespacho[0]['fecha'],5,2);	
					 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
					 $arrayInterfaz[$cont]['NUMERO']	 =	$dataDespacho[0]['numero'];
					 $arrayInterfaz[$cont]['NUMREG']	 =	$numReg;	
					 $arrayInterfaz[$cont]['FECHA']	     =	$dataDespacho[0]['fecha'];		
					 $arrayInterfaz[$cont]['NIT']	     =	$numero_identificacion;
					 $arrayInterfaz[$cont]['VALFLE']	 =	$base;	
					 $arrayInterfaz[$cont]['IVA']	     =	'0';	
					 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
					 $arrayInterfaz[$cont]['DTO']	     =	'0';	
					 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
					 $arrayInterfaz[$cont]['RTE']	     =	'1';		
					 $arrayInterfaz[$cont]['VALRTE']	 =	$rte > 0 ? $rte : 0;			
					 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
					 $arrayInterfaz[$cont]['VALICA']	 =	$ica > 0 ? $ica : 0;					
					 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
					 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
					 $arrayInterfaz[$cont]['PLANTI']	 =	$dataDespacho[0]['plantilla'];										
					 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($dataDespacho[0]['fecha'],0,4);	
					 $arrayInterfaz[$cont]['MESREF']	 =	substr($dataDespacho[0]['fecha'],5,2);	
					 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
					 $arrayInterfaz[$cont]['NUMREF']	 =	$dataDespacho[0]['numero'];
					 $arrayInterfaz[$cont]['REGREF']	 =	$numReg;		
					 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($dataDespacho[0]['fecha'],0,4);	
					 $arrayInterfaz[$cont]['MESANT']	 =	substr($dataDespacho[0]['fecha'],5,2);	
					 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
					 $arrayInterfaz[$cont]['DOCANT']	 =	'0';		
					 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
					 $arrayInterfaz[$cont]['VALANT']	 =	'0';	
					 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
					 $arrayInterfaz[$cont]['CODSUC']	 =	$dataDespacho[0]['codsuc'];	
					 $arrayInterfaz[$cont]['CENCOS']	 =	$dataDespacho[0]['cencos'];			
					 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
					 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
					 $arrayInterfaz[$cont]['CLASI3']	 =	'999';	
					 $arrayInterfaz[$cont]['DETALL']	 =	$dataDespacho[0]['detall'];					
					 $arrayInterfaz[$cont]['FECVEN']	 =	$dataDespacho[0]['fecha'];
					 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
					 $arrayInterfaz[$cont]['FECTAS']	 =	$dataDespacho[0]['fecha'];	
					 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
					 $arrayInterfaz[$cont]['FACPRO']	 =	$dataDespacho[0]['numero_despacho'];
					 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
					 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
					 $arrayInterfaz[$cont]['URBANO']	 =	$dataDespacho[0]['urbano'];		
					 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
					 $arrayInterfaz[$cont]['NOICAS']	 =	'N';	 
					 
					 $cont++;	
								 
					}		 
			 			
		 }
	  
	  }
   
   }  
   
   ///   manifiestos y despachos sin anticipo
         
  $select = "SELECT m.numero_identificacion_tenedor AS numero_identificacion,m.oficina_id,tn.tercero_id,m.manifiesto AS numero,m.valor_flete AS valor_despacho,m.fecha_mc 
              AS fecha,m.manifiesto AS numero_despacho,(SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id IN (SELECT impuesto_id 
			  FROM tabla_impuestos WHERE rte = 1) LIMIT 1) AS rte_val,(SELECT valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND impuesto_id 
              IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica_val,(SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
              plantilla,'0' AS docant,'0' valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('MANIFIESTO No.',m.manifiesto) AS detall ,'N' AS urbano,m.saldo_por_pagar 
			  FROM manifiesto m,tenedor tn, oficina of WHERE m.estado NOT IN ('A','P') AND m.propio = 0 AND m.fecha_mc BETWEEN '$desde' AND '$hasta' 
	          AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND ( m.manifiesto_id NOT IN (SELECT manifiesto_id FROM anticipos_manifiesto) OR 		
		      (SELECT COUNT(*) FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND valor = 0) = 1 )	UNION ALL SELECT m.numero_identificacion_tenedor AS  
			  numero_identificacion,m.oficina_id,tn.tercero_id,m.despacho AS numero,m.valor_flete AS valor_despacho,m.fecha_du AS fecha,m.despacho AS numero_despacho,   		    
              (SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos 
	          WHERE rte = 1) LIMIT 1) AS rte_val,(SELECT valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND impuesto_id 
              IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica = 1) LIMIT 1) AS ica_val,(SELECT plantilla FROM oficina WHERE oficina_id = m.oficina_id) AS 
              plantilla,'0' AS docant,'0' valant,of.codigo_centro AS codsuc, '002' AS cencos, CONCAT('DESPACHO No.',m.despacho) AS detall ,'N' AS urbano,m.saldo_por_pagar FROM 
			  despachos_urbanos m,tenedor tn, oficina of WHERE m.estado NOT IN ('A','P') AND m.propio = 0 AND m.fecha_du BETWEEN '$desde' AND '$hasta' 
	          AND m.tenedor_id = tn.tenedor_id AND m.oficina_id = of.oficina_id AND ( m.despachos_urbanos_id NOT IN (SELECT despachos_urbanos_id FROM anticipos_despacho) OR 		
		      (SELECT COUNT(*) FROM anticipos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND valor = 0) = 1 )";	
		
		$despachosSinAnticipo = $this -> DbFetchAll($select,$Conex,true);			
				
		for($i = 0; $i < count($despachosSinAnticipo); $i++){

			 $arrayInterfaz[$cont]['AÑO']	     =  substr($despachosSinAnticipo[$i]['fecha'],0,4);
			 $arrayInterfaz[$cont]['MES']	     =	substr($despachosSinAnticipo[$i]['fecha'],5,2);	
			 $arrayInterfaz[$cont]['TIPO']	     =	$tipoDoc[0]['codigo'];	
			 $arrayInterfaz[$cont]['NUMERO']	 =	$despachosSinAnticipo[$i]['numero'];	
			 $arrayInterfaz[$cont]['NUMREG']	 =	'1';	
			 $arrayInterfaz[$cont]['FECHA']	     =	$despachosSinAnticipo[$i]['fecha'];		
			 $arrayInterfaz[$cont]['NIT']	     =	$despachosSinAnticipo[$i]['numero_identificacion'];
			 $arrayInterfaz[$cont]['VALFLE']	 =	$despachosSinAnticipo[$i]['valor_despacho'];	
			 $arrayInterfaz[$cont]['IVA']	     =	'0';	
			 $arrayInterfaz[$cont]['VALIVA']	 =	'0';		
			 $arrayInterfaz[$cont]['DTO']	     =	'0';	
			 $arrayInterfaz[$cont]['VALDTO']	 =	'0';		
			 $arrayInterfaz[$cont]['RTE']	     =	'1';		
			 $arrayInterfaz[$cont]['VALRTE']	 =	$despachosSinAnticipo[$i]['rte_val'] > 0 ? $despachosSinAnticipo[$i]['rte_val'] : 0;			
			 $arrayInterfaz[$cont]['ICA']	     =	'0,006';		
			 $arrayInterfaz[$cont]['VALICA']	 =	$despachosSinAnticipo[$i]['ica_val'] > 0 ? $despachosSinAnticipo[$i]['ica_val'] : 0;						
			 $arrayInterfaz[$cont]['RIVA']	     =	'0';							
			 $arrayInterfaz[$cont]['VALRIVA']	 =	'0';		
			 $arrayInterfaz[$cont]['PLANTI']	 =	$dataDespacho[0]['plantilla'];										
			 $arrayInterfaz[$cont]['AÑOREF']	 =	substr($despachosSinAnticipo[$i]['fecha'],0,4);	
			 $arrayInterfaz[$cont]['MESREF']	 =	substr($despachosSinAnticipo[$i]['fecha'],5,2);	
			 $arrayInterfaz[$cont]['TIPREF']	 =	'122';	
			 $arrayInterfaz[$cont]['NUMREF']	 =	$despachosSinAnticipo[$i]['numero'];
			 $arrayInterfaz[$cont]['REGREF']	 =	'1';		
			 $arrayInterfaz[$cont]['AÑOANT']	 =	substr($despachosSinAnticipo[$i]['fecha'],0,4);	
			 $arrayInterfaz[$cont]['MESANT']	 =	substr($despachosSinAnticipo[$i]['fecha'],5,2);	
			 $arrayInterfaz[$cont]['TIPANT']	 =	'162';	
			 $arrayInterfaz[$cont]['DOCANT']	 =	$despachosSinAnticipo[$i]['docant'];		
			 $arrayInterfaz[$cont]['REGANT']	 =	'1';	
			 $arrayInterfaz[$cont]['VALANT']	 =	$despachosSinAnticipo[$i]['valant'];			
			 $arrayInterfaz[$cont]['INDVIS']	 =	'0';	
			 $arrayInterfaz[$cont]['CODSUC']	 =	$despachosSinAnticipo[$i]['codsuc'];			
			 $arrayInterfaz[$cont]['CENCOS']	 =	$despachosSinAnticipo[$i]['cencos'];						
			 $arrayInterfaz[$cont]['CLASI1']	 =	'999';	
			 $arrayInterfaz[$cont]['CLASI2']	 =	'999';	
			 $arrayInterfaz[$cont]['CLASI3']	 =	'999';		
			 $arrayInterfaz[$cont]['DETALL']	 =	$despachosSinAnticipo[$i]['detall'];						
			 $arrayInterfaz[$cont]['FECVEN']	 =	$despachosSinAnticipo[$i]['fecha'];			
			 $arrayInterfaz[$cont]['TIPMON']	 =	'00';		
			 $arrayInterfaz[$cont]['FECTAS']	 =	$despachosSinAnticipo[$i]['fecha'];
			 $arrayInterfaz[$cont]['TASACA']	 =	'0';		
			 $arrayInterfaz[$cont]['FACPRO']	 =	$despachosSinAnticipo[$i]['numero'];
			 $arrayInterfaz[$cont]['ROTTER']	 =	'N';		
			 $arrayInterfaz[$cont]['REASIG']	 =	'N';		
			 $arrayInterfaz[$cont]['URBANO']	 =	$despachosSinAnticipo[$i]['urbano'];
			 $arrayInterfaz[$cont]['ICAORI']	 =	'N';		
			 $arrayInterfaz[$cont]['NOICAS']	 =	'N';	
			 
			 $cont++;				
  
        }
		   
   $despachosSinEgresoAnticipo = substr($despachosSinEgresoAnticipo,0,strlen($despachosSinEgresoAnticipo) - 1);   
   $validacionesEgresoAnticipo = array();
   
   if(strlen(trim($despachosSinEgresoAnticipo)) > 0){
   
     $planillas = explode(",",$despachosSinEgresoAnticipo);
	 
	 for($i = 0; $i < count($planillas); $i++){
	 
	   $planilla     = $planillas[$i];
	 
	   $select       = "SELECT m.*, (SELECT nombre FROM oficina WHERE oficina_id =  m.oficina_id) AS  oficina FROM manifiesto m WHERE TRIM(manifiesto) = TRIM('$planilla')";
	   $dataPlanilla = $this -> DbFetchAll($select,$Conex,true);	
	   	   	   
	   if(count($dataPlanilla) > 0){

	     $validacionesEgresoAnticipo[$i]['oficina']  = $dataPlanilla[0]['oficina'];		 
	     $validacionesEgresoAnticipo[$i]['planilla'] = $planilla;
	     $validacionesEgresoAnticipo[$i]['usuario']  = $dataPlanilla[0]['usuario_registra'];		 
	   
	   }else{
	    
 	      $select       = "SELECT * FROM despachos_urbanos WHERE TRIM(despacho) = TRIM('$planilla')";
	      $dataPlanilla = $this -> DbFetchAll($select,$Conex,true);	
		  
	      $validacionesEgresoAnticipo[$i]['oficina']  = $dataPlanilla[0]['oficina'];		 
	      $validacionesEgresoAnticipo[$i]['planilla'] = $planilla;
	      $validacionesEgresoAnticipo[$i]['usuario']  = $dataPlanilla[0]['usuario_registra'];		 		  	      
	   
	     }
	  
	 
	 }
   
   }
            
   return array(array(interfaz => $arrayInterfaz, validaciones => $validacionesEgresoAnticipo)); 
   
 	
  }  
  
   
}


?>