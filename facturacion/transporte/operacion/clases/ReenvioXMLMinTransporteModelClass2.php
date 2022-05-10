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
	   error_reportando_ministerio = 1";
	   
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
	
	   $select = "SELECT p.*, (SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero 
	   WHERE tercero_id = p.tercero_id) AS propietario  FROM tercero p WHERE reportado_ministerio = 0 AND 
	   error_reportando_ministerio = 1 AND propietario_vehiculo = 1";
	   
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
	   error_reportando_ministerio = 1";
	   
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
	
	   $select = "SELECT * FROM remolque r WHERE reportado_ministerio = 0 AND error_reportando_ministerio = 1";
	   
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
	
	   $select = "SELECT * FROM vehiculo v WHERE reportado_ministerio = 0 AND error_reportando_ministerio = 1";
	   
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
	   c.reportado_ministerio = 0 AND c.error_reportando_ministerio = 1 AND r.cliente_id = c.cliente_id";
	   
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
	   reportado_ministerio = 0 AND error_reportando_ministerio = 1 AND r.tipo = 'R'";
	   
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
	   reportado_ministerio = 0 AND error_reportando_ministerio = 1 AND r.tipo = 'D'";
	   
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
	
  public function getReporteInformacionCarga($Conex){
  
      $select = "SELECT remesa_id,numero_remesa,fecha_error_reportando_ministerio,ultimo_error_reportando_ministario,path_xml_informacion_carga FROM remesa WHERE reportado_ministerio = 0 AND fecha_registro >= '{$this -> fechaInicioReporte}'";
	 
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	 	 	 	 
	    $ruta                                     = explode("transAlejandria",$result[$i]['path_xml_informacion_carga']);	 
	    $result[$i]['path_xml_informacion_carga'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',$ultimo_error_reportando_ministario);		
	 }
	 
	  
	 return $result;
  
  }
  
  public function selectErroresRemesasManifiesto($manifiesto_id,$Conex){
   
    $select = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = 
	$manifiesto_id) AND reportado_ministerio2 = 0 AND fecha_registro >= '{$this -> fechaInicioReporte}'";
	
   	$result  = $this->DbFetchAll($select,$Conex,true);	
  
  }
  	    							    
  public function getReporteManifiesto($Conex){
  
     $select = "SELECT m.*, (SELECT GROUP_CONCAT(numero_remesa) FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM 
	 detalle_despacho WHERE manifiesto_id = m.manifiesto_id)) AS remesas FROM manifiesto m WHERE reportado_ministerio = 0 
	 AND fecha_registro >= '{$this -> fechaInicioReporte}'";
		 
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	
	 
	    $manifiesto_id = $result[$i]['manifiesto_id'];
	  	 	 	 
	    $ruta                                     = explode("transAlejandria",$result[$i]['path_xml_informacion_viaje']);	 
	    $result[$i]['path_xml_informacion_viaje'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario               = $result[$i]['ultimo_error_reportando_ministario'];
		$result[$i]['ultimo_error_reportando_ministario'] = str_replace('Error ','</br><br/>Error : ',
		                                                    $ultimo_error_reportando_ministario);		
						
	 }
	 
	  
	 return $result;	
  
  }
  
  public function getReporteManifiesto2($Conex){
  
     $select = "SELECT m.*,r.* FROM manifiesto m, remesa r, detalle_despacho d WHERE r.reportado_ministerio2 = 0 AND 
	            r.remesa_id = d.remesa_id AND d.manifiesto_id = m.manifiesto_id AND m.fecha_registro >= 
				'{$this -> fechaInicioReporte}' ";
		 
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	
	 
	    $manifiesto_id = $result[$i]['manifiesto_id'];
	  	 	 	 
	    $ruta                          = explode("transAlejandria",$result[$i]['path_xml_remesa']);	 
	    $result[$i]['path_xml_remesa'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario                = $result[$i]['ultimo_error_reportando_ministario2'];
		$result[$i]['ultimo_error_reportando_ministario2'] = str_replace('Error ','</br><br/>Error : ',
		                                                    $ultimo_error_reportando_ministario);		
						
	 }
	  
	 return $result;	
  
  }  

  public function getReporteManifiesto3($Conex){
  
     $select = "SELECT m.*, (SELECT GROUP_CONCAT(numero_remesa) FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM 
	 detalle_despacho WHERE manifiesto_id = m.manifiesto_id)) AS remesas FROM manifiesto m WHERE reportado_ministerio3 = 0 AND m.fecha_registro >= '{$this -> fechaInicioReporte}'";
		 
   	 $result  = $this->DbFetchAll($select,$Conex,true);
	 
	 $dirHTTP = "http://".$_SERVER['SERVER_NAME']."/";
	 
	 for($i = 0; $i < count($result); $i++){	
	 
	    $manifiesto_id = $result[$i]['manifiesto_id'];
	  	 	 	 
	    $ruta                              = explode("transAlejandria",$result[$i]['path_xml_manifiesto']);	 
	    $result[$i]['path_xml_manifiesto'] = "$dirHTTP../../../".$ruta[1];
		
		$ultimo_error_reportando_ministario                = $result[$i]['ultimo_error_reportando_ministario3'];
		$result[$i]['ultimo_error_reportando_ministario3'] = str_replace('Error ','</br><br/>Error : ',
		                                                    $ultimo_error_reportando_ministario);		
						
	 }
	 
	  
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