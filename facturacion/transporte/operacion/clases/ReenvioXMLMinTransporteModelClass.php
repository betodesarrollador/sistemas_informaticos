<?php
require_once("../../../framework/clases/DbClass.php");

final class ReenvioXMLMinTransporteModel extends Db{

    private $fechaInicioReporte;
	
	public function __construct(){
	   $this -> fechaInicioReporte = '2013-03-28';	
	}
	
    public function getReporteConductores($Conex){
		
	   $select = "SELECT c.*, (SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero 
	   WHERE tercero_id = c.tercero_id) AS conductor  FROM conductor c WHERE reportado_ministerio = 0 AND 
	   error_reportando_ministerio = 1 LIMIT 0,200";
	   
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                                             = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml']                           = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);				
	   }
	 	  
	 return $result;
	
	}
	    
    public function getReportePropietarios($Conex){
	
	   $select = "SELECT p.*, (SELECT concat_ws(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero 
	   WHERE tercero_id = p.tercero_id) AS propietario  FROM tercero p WHERE reportado_ministerio = 0 AND 
	   error_reportando_ministerio = 1 AND propietario_vehiculo = 1 LIMIT 0,200";
	   
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	    
    public function getReporteTenedores($Conex){
	
	   $select = "SELECT t.*, (SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero 
	   WHERE tercero_id = t.tercero_id) AS tenedor  FROM tenedor t WHERE reportado_ministerio = 0 AND 
	   error_reportando_ministerio = 1  LIMIT 0,200";
	   
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	    
    public function getReporteRemolques($Conex){
	
	   $select = "SELECT * FROM remolque r WHERE reportado_ministerio = 0 AND error_reportando_ministerio = 1  LIMIT 0,200";
	   
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	    			
    public function getReporteVehiculos($Conex){
	
	   $select = "SELECT * FROM vehiculo v WHERE reportado_ministerio = 0 AND error_reportando_ministerio = 1  LIMIT 0,200";
	   
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	    				
    public function getReporteClientes($Conex){
	
	   $select = "SELECT c.*,r.* FROM remitente_destinatario r, cliente c WHERE 
	   c.reportado_ministerio = 0 AND c.error_reportando_ministerio = 1 AND r.cliente_id = c.cliente_id  LIMIT 0,200";
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	    						
    public function getReporteRemitentes($Conex){
	
	   $select = "SELECT r.* FROM remitente_destinatario r WHERE 
	   reportado_ministerio = 0 AND error_reportando_ministerio = 1 AND r.tipo = 'R'  LIMIT 0,200";
	   //echo $select;
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	    					
    public function getReporteDestinatarios($Conex){
	
	   $select = "SELECT r.* FROM remitente_destinatario r WHERE 
	   reportado_ministerio = 0 AND error_reportando_ministerio = 1 AND r.tipo = 'D' LIMIT 0,200";
	   
   	   $result  = $this->DbFetchAll($select,$Conex,true);
	 
	   $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	   for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                   = explode("transAlejandria",$result[$i]['path_xml']);	 
	    $result[$i]['path_xml'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	   }
	 	  
	 return $result;	
	
	}
	
  public function getReporteRemesas($Conex){
  
      $select = "SELECT r.remesa_id,r.numero_remesa,r.fecha_error_reportando_ministerio2,r.ultimo_error_reportando_ministario2,r.path_xml_remesa,m.manifiesto_id 
	  FROM remesa r, manifiesto m, detalle_despacho d,tiempos_clientes_remesas t 
	  WHERE  r.estado!='AN' AND r.reportado_ministerio2 = 0 AND r.error_reportando_ministerio2=1 
	  AND DATE(r.fecha_error_reportando_ministerio2) >= '{$this -> fechaInicioReporte}' AND d.remesa_id=r.remesa_id 
	  AND m.manifiesto_id=d.manifiesto_id AND t.cliente_id = r.cliente_id AND t.manifiesto_id=m.manifiesto_id
	  ORDER BY r.fecha_remesa DESC LIMIT 0,200"; //echo $select;
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                                     = explode("transAlejandria",$result[$i]['path_xml_remesa']);	 
	    $result[$i]['path_xml_remesa'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario2               = $result[$i]['ultimo_error_reportando_ministario2'];
		$result[$i]['ultimo_error_reportando_ministario2'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario2);		
	 }
	 
	  
	 return $result;
  
  }
  
  public function selectErroresRemesasManifiesto($manifiesto_id,$Conex){
   
    $select = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = 
	$manifiesto_id) AND reportado_ministerio2 = 0 AND fecha_registro >= '{$this -> fechaInicioReporte}' LIMIT 0,100";
	
   	$result  = $this->DbFetchAll($select,$Conex,true);	
  
  }
  	    							    
  
  public function getReporteManifiesto2($Conex){
  
     $select = "SELECT m.* FROM manifiesto m 
	 			WHERE m.estado!='A' AND m.reportado_ministerio2 = 0 AND m.error_reportando_ministerio2=1 
	  AND DATE(m.fecha_error_reportando_ministerio2) >= '{$this -> fechaInicioReporte}' ORDER BY m.fecha_mc DESC LIMIT 0,200";

   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	
	 
	    $manifiesto_id = $result[$i]['manifiesto_id'];
	  	 	 	 
	    $ruta                          = explode("transAlejandria",$result[$i]['path_xml_manifiesto']);	 
	    $result[$i]['path_xml_manifiesto'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario                = $result[$i]['ultimo_error_reportando_ministario2'];
		$result[$i]['ultimo_error_reportando_ministario2'] = str_replace('Error ','</br><br/>Error : ',
		                                                    $ultimo_error_reportando_ministario);		
						
	 }
	  
	 return $result;	
  
  }  

  public function getReporteRemesas3($Conex){
  
      $select = "SELECT remesa_id,numero_remesa,fecha_remesa,fecha_error_reportando_ministerio3,ultimo_error_reportando_ministario3,path_xml_remesa 
	  FROM remesa WHERE estado!='AN' AND reportado_ministerio3 = 0  AND  reportado_ministerio2=1
	  ORDER BY fecha_remesa DESC LIMIT 0,200";
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                                     = explode("transAlejandria",$result[$i]['path_xml_remesa']);	 
	    $result[$i]['path_xml_remesa'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario2               = $result[$i]['ultimo_error_reportando_ministario2'];
		$result[$i]['ultimo_error_reportando_ministario2'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario2);		
	 }
	 
	  
	 return $result;
  
  }
  

  public function getReporteManifiesto3($Conex){
  
     $select = "SELECT m.*,l.liquidacion_despacho_id FROM manifiesto m, liquidacion_despacho l 
	 			WHERE m.estado!='A' AND m.reportado_ministerio3 = 0  AND  m.reportado_ministerio2=1 AND m.propio=0 AND l.manifiesto_id=m.manifiesto_id
				AND l.estado_liquidacion!='A'
	  ORDER BY m.fecha_mc DESC LIMIT 0,200";
	 //echo $select;
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 return $result;	
  
  }  

  public function getReporteManifiesto3propios($Conex){
  
     $select = "SELECT m.* FROM manifiesto m
	 			WHERE m.estado!='A' AND m.reportado_ministerio3 = 0  AND  m.reportado_ministerio2=1 AND m.propio=1			
	  ORDER BY m.fecha_mc DESC LIMIT 0,200";
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	  
	 return $result;	
  
  }  

  public function getReporteAnuRemesas($Conex){//pendiente
  
      $select = "SELECT remesa_id,numero_remesa,fecha_remesa,fecha_error_anulando_ministerio,ultimo_error_anulando_ministario,path_xml_remesa,causal_anulacion_id 
	  FROM remesa WHERE estado='AN' AND anulado_ministerio = 0  AND  reportado_ministerio2=1
	  ORDER BY fecha_remesa DESC LIMIT 0,200"; //echo $select;
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 return $result;
  
  }
  

  public function getReporteAnuManifiesto($Conex){//pendiente
  
     $select = "SELECT m.* FROM manifiesto m 
	 			WHERE m.estado='A' AND m.anulado_ministerio = 0  AND  m.reportado_ministerio2=1
	  ORDER BY m.fecha_mc DESC LIMIT 0,200";

   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	  
	 return $result;	
  
  }  


  public function getXMLRemesa($remesa_id,$Conex){
  
    $select = "SELECT path_xml_informacion_carga FROM remesa WHERE remesa_id = $remesa_id";
  	$result = $this->DbFetchAll($select,$Conex,true);		
	$xml    = file_get_contents($result[0]['path_xml_informacion_carga']);
  
    return $xml;
  
  }
  

}

?>