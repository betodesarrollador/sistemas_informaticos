<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InterfazAnticiposModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }  

  public function selectAnticiposRangoFecha($desde,$hasta,$Conex){
  
   $select = "SELECT t.* FROM ((SELECT a.consecutivo AS numero,a.encabezado_registro_id,a.conductor,a.tenedor,a.fecha_egreso,a.conductor_id,a.tenedor_id,a.propio,a.valor,a.oficina_id,a.placa_id,a.cuenta_tipo_pago_id FROM anticipos_manifiesto a, manifiesto m WHERE a.consecutivo > 0 AND DATE(a.fecha_egreso) BETWEEN date('$desde') 
   AND date('$hasta') AND a.manifiesto_id = m.manifiesto_id AND m.estado NOT IN ('A','P') ORDER BY a.fecha_egreso ASC) UNION ALL (SELECT a.consecutivo AS numero,a.encabezado_registro_id,a.conductor,a.tenedor,a.fecha_egreso,a.conductor_id,a.tenedor_id,a.propio,a.valor,a.oficina_id,a.placa_id,a.cuenta_tipo_pago_id FROM anticipos_despacho a, despachos_urbanos d WHERE a.consecutivo > 0 AND DATE(a.fecha_egreso) BETWEEN DATE('$desde') 
   AND DATE('$hasta') AND a.despachos_urbanos_id = d.despachos_urbanos_id AND d.estado NOT IN ('A','P') ORDER BY fecha_egreso ASC)) t ORDER BY t.numero ASC";
			  
   $anticipos = $this -> DbFetchAll($select,$Conex,true);
   
   $select    = "SELECT tipo_documento_id FROM parametros_anticipo WHERE propio = 1";    
   $dataTipoDocumentoPropios = $this -> DbFetchAll($select,$Conex,true);				
   
   $select    = "SELECT tipo_documento_id FROM parametros_anticipo WHERE propio = 0";  
   $dataTipoDocumentoTerceros = $this -> DbFetchAll($select,$Conex,true);				   
   				
   if(count($dataTipoDocumentoPropios) > 0 && count($dataTipoDocumentoTerceros) > 0){
   
   $arrayInterfaz = array();
   
   for($i = 0; $i < count($anticipos); $i++){
   
        $encabezado_registro_id = $anticipos[$i]['encabezado_registro_id'];
		$oficina_id             = $anticipos[$i]['oficina_id'];
		$placa_id               = $anticipos[$i]['placa_id'];
		$cuenta_tipo_pago_id    = $anticipos[$i]['cuenta_tipo_pago_id'];
		$documento              = $anticipos[$i]['numero'];
			
		$select  = "SELECT codigo_centro FROM oficina WHERE oficina_id = $oficina_id";
	    $dataCen = $this -> DbFetchAll($select,$Conex,true);					 		  
	    $codsuc  = $dataCen[0]['codigo_centro'];   	
		
        $select = "SELECT codigo_interno,codigo_entidad FROM banco b, cuenta_tipo_pago ct WHERE ct.cuenta_tipo_pago_id = $cuenta_tipo_pago_id AND 
		ct.banco_id = b.banco_id";
		  
        $dataBan = $this -> DbFetchAll($select,$Conex,true);					 		  
		  
		if(count($dataBan) > 0){
		    $banco1  = strlen(trim($dataBan[0]['codigo_interno'])) > 0 ? $dataBan[0]['codigo_interno'] : '99';		   		  
		    $banco2  = strlen(trim($dataBan[0]['codigo_entidad'])) > 0 ? $dataBan[0]['codigo_entidad'] : '99';		   		  		  
		}else{
		      $banco1  = '99';		   		  
		      $banco2  = '99';		   		  		 
		  }					
   
        if($anticipos[$i]['propio'] == 1){
	 	
		 $conductor_id = $anticipos[$i]['conductor_id']; 
		 $beneficiario = $anticipos[$i]['conductor'];
		 
		  $select = "SELECT numero_identificacion FROM tercero WHERE tercero_id 
		             = (SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id)"; 
					 
          $dataProvee = $this -> DbFetchAll($select,$Conex,true);					 
		  $provee     = $dataProvee[0]['numero_identificacion']; 
		  
		  $select  = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS cuenta  FROM parametros_anticipo p WHERE propio = 1";
          $dataPuc = $this -> DbFetchAll($select,$Conex,true);					 
		  $cuenta  = $dataPuc[0]['cuenta'];				 
				 
		  $select  = "SELECT td.codigo FROM tipo_de_documento td, parametros_anticipo pa WHERE td.tipo_documento_id = pa.tipo_documento_id AND 
		  pa.propio";	 
          $dataDoc        = $this -> DbFetchAll($select,$Conex,true);					 		  
		  $tipo_documento = $dataDoc[0]['codigo'];
		  
		  $select = "SELECT codigo FROM centro_de_costo WHERE placa_id = placa_id";
          $dataCen = $this -> DbFetchAll($select,$Conex,true);					 		  
		  $cencos  = $dataCen[0]['codigo'];		   		  
		 
		 }else{

		   $tenedor_id   = $anticipos[$i]['tenedor_id']; 
		   $beneficiario = $anticipos[$i]['tenedor'];
		 
		   $select = "SELECT numero_identificacion FROM tercero WHERE tercero_id 
		             = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)"; 
					 
           $dataProvee = $this -> DbFetchAll($select,$Conex,true);					 
		   $provee     = $dataProvee[0]['numero_identificacion']; 
		   
		   $select  = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS cuenta  FROM parametros_anticipo p WHERE propio = 0";
           $dataPuc = $this -> DbFetchAll($select,$Conex,true);					 
		   $cuenta  = $dataPuc[0]['cuenta'];	
		   
		   $select  = "SELECT td.codigo FROM tipo_de_documento td, parametros_anticipo pa WHERE td.tipo_documento_id = pa.tipo_documento_id AND 
		   pa.propio";	 
           $dataDoc        = $this -> DbFetchAll($select,$Conex,true);					 		  
		   $tipo_documento = $dataDoc[0]['codigo'];	
		   
		   $cencos  = "999";			   

		  }
   
		$arrayInterfaz[$i]['AÑO']    = substr($anticipos[$i]['fecha_egreso'],0,4);	
		$arrayInterfaz[$i]['MES']    = substr($anticipos[$i]['fecha_egreso'],5,2);		
		$arrayInterfaz[$i]['TIPO']   = $tipo_documento;		
		$arrayInterfaz[$i]['DOCUME'] = $documento;				
		$arrayInterfaz[$i]['NUMREG'] = '1';		
		$arrayInterfaz[$i]['FECDOC'] = substr($anticipos[$i]['fecha_egreso'],0,10);						
		$arrayInterfaz[$i]['BANCO1'] = $banco1;		
		$arrayInterfaz[$i]['BANCO2'] = $banco2;		
		$arrayInterfaz[$i]['NUMCHE'] = strlen(trim($anticipos[$i]['numero_soporte'])) > 0 ? $anticipos[$i]['numero_soporte'] : 0;		
		$arrayInterfaz[$i]['DETALL'] = "ANTICIPO NO.$documento";		
		$arrayInterfaz[$i]['GIRADO'] = "BENEFICIARIO ANTICIPO: $beneficiario";		
		$arrayInterfaz[$i]['FECCON'] = substr($anticipos[$i]['fecha_egreso'],0,4);		
		$arrayInterfaz[$i]['FECTAS'] = substr($anticipos[$i]['fecha_egreso'],0,4);		
		$arrayInterfaz[$i]['TASA']   = '0';		
		$arrayInterfaz[$i]['TIPMON'] = '00';		
		$arrayInterfaz[$i]['INDTAS'] = 'N';		
		$arrayInterfaz[$i]['BANDES'] = '0';		
		$arrayInterfaz[$i]['PROVEE'] = $provee;		
		$arrayInterfaz[$i]['CLIENT'] = '0';		
		$arrayInterfaz[$i]['TERCER'] = $provee;		
		$arrayInterfaz[$i]['AÑOREF'] = '0';	
		$arrayInterfaz[$i]['MESREF'] = '0';	
		$arrayInterfaz[$i]['TIPREF'] = '0';	
		$arrayInterfaz[$i]['NUMREF'] = '0';	
		$arrayInterfaz[$i]['REGREF'] = '0';		
		$arrayInterfaz[$i]['CUENTA'] = $cuenta;		
		$arrayInterfaz[$i]['FLUJOS'] = "002";		
		$arrayInterfaz[$i]['TOTDOC'] = $anticipos[$i]['valor'];		
		$arrayInterfaz[$i]['DTO']    = '0';		
		$arrayInterfaz[$i]['NETO']   = $anticipos[$i]['valor'];				
		$arrayInterfaz[$i]['RTO']    = '0';		
		$arrayInterfaz[$i]['VALICA'] = '0';
		$arrayInterfaz[$i]['VALIVA'] = '0';
		$arrayInterfaz[$i]['MAYVAL'] = '0';
		$arrayInterfaz[$i]['MENVAL'] = '0';
		$arrayInterfaz[$i]['CODSUC'] = "$codsuc";		
		$arrayInterfaz[$i]['CENCOS'] = "$cencos";
		$arrayInterfaz[$i]['CLASI1'] = '999';	
		$arrayInterfaz[$i]['CLASI2'] = '999';	
		$arrayInterfaz[$i]['CLASI3'] = '999';		
		$arrayInterfaz[$i]['INDCON'] = '0';	
		$arrayInterfaz[$i]['BANPOS'] = '0';	
		$arrayInterfaz[$i]['DOCPOS'] = '0';	
		$arrayInterfaz[$i]['VALBAS'] = '0';	
		$arrayInterfaz[$i]['INDTRA'] = '0';	
		$arrayInterfaz[$i]['DEV']    = '0';
	  
   
   }  
   
   return $arrayInterfaz;    
   
   }else{
   
        if(count($dataTipoDocumentoPropios) > 0){
		   exit("<div align='center'>No ha parametrizado aun el tipo de documento contable para los anticipos propios<br>ingrese por:<br><b>Modulo Transporte -> Parametros Modulo -> Anticipos</b></div>");
		}
		
		if(count($dataTipoDocumentoTerceros) > 0){
		   exit("<div align='center'>No ha parametrizado aun el tipo de documento contable para los anticipos a terceros<br>ingrese por:<br><b>Modulo Transporte -> Parametros Modulo -> Anticipos</b></div>");		
		}
   
     }				

	

 	
  }  
   
}


?>