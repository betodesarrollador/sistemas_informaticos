<?php
 error_reporting(1);
set_time_limit(30);
//ini_set('max_execution_time', 30);
//exit('Webservice RNDC fuera de servicio');
 class WebServiceMinTransporte{
 
    private $wsdl;
	private $username;
	private $password;
	private $ambiente;
	private $numnitempresatransporte;
	private $oSoapClient;
    private $tipo;
	private $procesoid;   
	private $Conex;
	private $ruta_archivos;
 
    public function __construct($Conex){
	   $this -> setOSoapClient($Conex);
	} 
	
	public function setOSoapClient($Conex){
	
      //require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/nusoap/nusoap.php");
	  
  	 //para nuevo cambio	
	  require_once("WebServiceMinTranporteModelClass.php");	 	  
	  $Model = new WebServiceMinTransporteModel();	
	  $activorndc=$Model -> getActivorndc($Conex);
	  if(!$activorndc){ exit('Envio Webservice RNDC Desactivado'); }
	 //para nuevo cambio fin
	  
	  //validacion de url que esten arriba
	  $h = @get_headers('http://rndcws2.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices');
	  $status = array();
	  preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0] , $status);

	  if($status[1] == 200){ 
		  $this -> wsdl          = 'http://rndcws2.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices';
	  }else{
		  $this -> wsdl          = 'http://rndcws.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices';
	  }
	  //fin validacion de url que esten arriba
	  
      //$this -> wsdl          = 'http://rndcws2.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices';
	  //$this -> wsdl          = 'http://rndcws.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices';
	  
      $this -> oSoapClient   = new SoapClient($this -> wsdl);
	  $this -> ruta_archivos = $_SERVER['DOCUMENT_ROOT'].'../../../archivos/transporte/xml_webservice_mintransporte/';

	  
	  $this -> username                = "TRANSALEJANDRIA@209";
	  $this -> password                = "transalejandria2020";
	  $this -> ambiente                = "R";
	  $this -> numnitempresatransporte = "9013207560";
	  $this -> Conex                   = $Conex;
	  
	
	
	}
	
	public function sendConductorMintransporte($data,$path_xml = NULL,$printMsj = true){
	
        require_once("WebServiceMinTranporteModelClass.php");	 	  
		
		$Model = new WebServiceMinTransporteModel();	
		  	
	    if(is_null($path_xml)){
			
		  $conductor_id                   = $data['conductor_id'];
		  $NUMIDTERCERO                   = substr($data['numero_identificacion'],0,15);	
		  $NOMIDTERCERO                   = substr(trim($this -> limpioCaracteresXML($data['nombre'])),0,90);	
		  $PRIMERAPELLIDOIDTERCERO        = substr(trim($this -> limpioCaracteresXML($data['primer_apellido'])),0,90);
		  $SEGUNDOAPELLIDOIDTERCERO       = substr(trim($this -> limpioCaracteresXML($data['segundo_apellido'])),0,90);
		  $NUMTELEFONOCONTACTO            = substr($data['telefono'],0,7);
		  $NOMENCLATURADIRECCION          = substr(trim($this -> limpioCaracteresXML($data['direccion'])),0,60);
		  $CODMUNICIPIORNDC               = str_pad($data['ubicacion_id'],8, "0", STR_PAD_LEFT);		
		  $CODCATEGORIALICENCIACONDUCCION = $Model -> getCodCategoriaLicencia($data['categoria_id'],$this -> Conex);		
          $NUMLICENCIACONDUCCION          = substr(trim($data['numero_licencia_cond']),0,60);
		  $FECHAVENCIMIENTOLICENCIA       = date("d/m/Y",strtotime($data['vencimiento_licencia_cond']));
			
		  if(strlen(trim($SEGUNDOAPELLIDOIDTERCERO)) > 0 && $SEGUNDOAPELLIDOIDTERCERO!='NULL'){
		    $SEGUNDOAPELLIDOIDTERCERO = "<SEGUNDOAPELLIDOIDTERCERO>$SEGUNDOAPELLIDOIDTERCERO</SEGUNDOAPELLIDOIDTERCERO>";
		  }else{
			 $SEGUNDOAPELLIDOIDTERCERO = "";  
		  }

		  if(strlen(trim($NUMTELEFONOCONTACTO)) > 0){
		    $NUMTELEFONOCONTACTO = "<NUMTELEFONOCONTACTO>$NUMTELEFONOCONTACTO</NUMTELEFONOCONTACTO>";
		  }	
			
          $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
				 <root> 
				  <acceso> 
					<username>{$this -> username}</username> 
					<password>{$this -> password}</password> 
					<ambiente>{$this -> ambiente}</ambiente>
				  </acceso> 				   
				  <solicitud> 
				   <tipo>1</tipo> 
					<procesoid>11</procesoid>
				  </solicitud>				  
				  <variables>
					<CODSEDETERCERO>0</CODSEDETERCERO>
					<NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
					<CODTIPOIDTERCERO>C</CODTIPOIDTERCERO> 
					<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
					<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
					<PRIMERAPELLIDOIDTERCERO>{$PRIMERAPELLIDOIDTERCERO}</PRIMERAPELLIDOIDTERCERO> 
					{$SEGUNDOAPELLIDOIDTERCERO} 
					{$NUMTELEFONOCONTACTO} 
					<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
					<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 
                    <CODCATEGORIALICENCIACONDUCCION>{$CODCATEGORIALICENCIACONDUCCION}</CODCATEGORIALICENCIACONDUCCION> 
					<NUMLICENCIACONDUCCION>{$NUMLICENCIACONDUCCION}</NUMLICENCIACONDUCCION> 
					<FECHAVENCIMIENTOLICENCIA>{$FECHAVENCIMIENTOLICENCIA}</FECHAVENCIMIENTOLICENCIA>					
				  </variables>
				 </root>";
		
		 $path_xml = "{$this -> ruta_archivos}conductor_{$data[numero_identificacion]}.xml";
		
		}else{
		    $msj = file_get_contents($path_xml);
		  }
		//echo  $msj; 
		$fp = fopen($path_xml,'w');
		fwrite($fp,"$msj");
		fclose($fp);		
				        		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		//$respuesta   = $this -> oSoapClient->call('AtenderMensajeRNDC0Request',$aParametros); 				
		
		if ($respuesta=='') { 		 
		 $respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
		 $Model -> setErrorReporteConductor($conductor_id,$respuesta,$path_xml,$this -> Conex);		 
		 if($printMsj)echo $respuesta;
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
		    $respuesta = '<div id="message">Error:'. $sError.'</div>';
		    $Model -> setErrorReporteConductor($conductor_id,$respuesta,$path_xml,$this -> Conex);						
		    if($printMsj)echo $respuesta;
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionConductor($conductor_id,$ingresoid,$path_xml,$this -> Conex);
				 
				 if($printMsj)echo"<div id='message'>Reportado Exitosamente</div>";
			   
			   }else{			   			   
				  
				  $Model -> setErrorReporteConductor($conductor_id,$respuesta,$path_xml,$this -> Conex);
				  
                  if(preg_match("/Connection refused./i","$respuesta")){
                    if($printMsj)echo"<div id='message' align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				      if($printMsj)echo"<div id='message' align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				  }else{
					  require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					  if(preg_match("/DUPLICADO:/i","$respuesta")){
								$resultado = xml2array($respuesta);	
								$respuesta_parcial = $resultado['root']['ErrorMSG'];
								$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
								$respuesta_parcial=explode(" ",$respuesta_parcial);
								$respuesta_final=$respuesta_parcial[0];
								
								$Model -> setAprobacionConductor($conductor_id,$respuesta_final,$path_xml,$this -> Conex);	 
								if($printMsj)echo("<br>Conductor Previamente Reportado.<br>");	
						}else{
				        	if($printMsj)echo"<div id='message'>Error reportando Conductor, revise el log de errores <br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a></div>";
							
						}
				     }
				  							 
			   }										 
						
						
			}
		
		} 		
	
	
	
	}
	
	public function sendTenedorMintransporte($data,$path_xml = NULL,$printMsj = true){
	
     require_once("WebServiceMinTranporteModelClass.php");	 	  
		
	 $Model = new WebServiceMinTransporteModel();
				
	 if(is_null($path_xml)){
				
		$tenedor_id                     = $data['tenedor_id'];
		$CODSEDETERCERO                 = $data['tenedor_id'];
		$CODTIPOIDTERCERO               = $Model -> getCodTipoIdentificacion($data['tipo_identificacion_id'],$this -> Conex);
		$NUMIDTERCERO                   = substr($Model -> getIdentificacionTenedor($data['tenedor_id'],$this -> Conex),0,15);		
		$NOMIDTERCERO                   = substr(trim($this -> limpioCaracteresXML($data['nombre'])),0,100);	
		$NOMSEDETERCERO                 = substr(trim($this -> limpioCaracteresXML($data['nombre_sede'])),0,100);	
		$PRIMERAPELLIDOIDTERCERO        = substr(trim($data['primer_apellido']),0,100);
		$SEGUNDOAPELLIDOIDTERCERO       = substr(trim($data['segundo_apellido']),0,100);		
		$NUMTELEFONOCONTACTO            = substr(trim($data['telefono']),0,7);
		$NOMENCLATURADIRECCION          = substr(trim($data['direccion']),0,60);
		$CODMUNICIPIORNDC               = str_pad($data['ubicacion_id'],8, "0", STR_PAD_LEFT);		
		
		if($CODTIPOIDTERCERO == 'N'){
			
			 $msj = "<?xml version='1.0' encoding='UTF-8' ?>
			  <root> 
				<acceso> 
					<username>{$this -> username}</username> 
					<password>{$this -> password}</password>
					<ambiente>{$this -> ambiente}</ambiente>					 
				</acceso> 
				<solicitud> 
					<tipo>1</tipo> 
					<procesoid>11</procesoid> 
				</solicitud> 
				<variables> 
				    <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
					<CODTIPOIDTERCERO>{$CODTIPOIDTERCERO}</CODTIPOIDTERCERO> 
					<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
					<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
					<CODSEDETERCERO>{$CODSEDETERCERO}</CODSEDETERCERO> 
					<NOMSEDETERCERO>{$NOMSEDETERCERO}</NOMSEDETERCERO> 
					<NUMTELEFONOCONTACTO>{$NUMTELEFONOCONTACTO}</NUMTELEFONOCONTACTO> 
					<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
					<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 
				</variables> 
			  </root>";	
						
		}else{
		
		  if(strlen(trim($SEGUNDOAPELLIDOIDTERCERO)) > 0){
		    $SEGUNDOAPELLIDOIDTERCERO = "<SEGUNDOAPELLIDOIDTERCERO>$SEGUNDOAPELLIDOIDTERCERO</SEGUNDOAPELLIDOIDTERCERO>";
		  }
		
		$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
				 <root> 
				  <acceso> 
					<username>{$this -> username}</username> 
					<password>{$this -> password}</password> 
					<ambiente>{$this -> ambiente}</ambiente>
				  </acceso> 				   
				  <solicitud> 
				   <tipo>1</tipo> 
					<procesoid>11</procesoid>
				  </solicitud>				  
				  <variables>
					<CODSEDETERCERO>0</CODSEDETERCERO>
					<NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
					<CODTIPOIDTERCERO>{$CODTIPOIDTERCERO}</CODTIPOIDTERCERO> 
					<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
					<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
					<PRIMERAPELLIDOIDTERCERO>{$PRIMERAPELLIDOIDTERCERO}</PRIMERAPELLIDOIDTERCERO> 
					{$SEGUNDOAPELLIDOIDTERCERO} 					
					<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
					<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 				
				  </variables>
				 </root>";		
		
		 }
		 		
				
		$path_xml = "{$this -> ruta_archivos}tenedor_{$data[numero_identificacion]}.xml";
		
		}else{
		    $msj = file_get_contents($path_xml);
		  }
				
		$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);
		       		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 $respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
		 $Model -> setErrorReporteTenedor($tenedor_id,$respuesta,$path_xml,$this -> Conex);		 
		 if($printMsj) echo $respuesta;		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
		    $respuesta = '<div id="message">Error:'. $sError.'</div>';
			$Model -> setErrorReporteTenedor($tenedor_id,$respuesta,$path_xml,$this -> Conex);			
			if($printMsj) echo $respuesta;			
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionTenedor($tenedor_id,$ingresoid,$path_xml,$this -> Conex);
				 
				 if($printMsj)echo"<div id='message'>Reportado Exitosamente</div>";
			   
			   }else{			   
				  
				  $Model -> setErrorReporteTenedor($tenedor_id,$respuesta,$path_xml,$this -> Conex);
				  
				  if(preg_match("/Connection refused./i","$respuesta")){
                    if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				     if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				  }else{
					   require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					   if(preg_match("/DUPLICADO:/i","$respuesta")){
								$resultado = xml2array($respuesta);	
								$respuesta_parcial = $resultado['root']['ErrorMSG'];
								$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
								$respuesta_parcial=explode(" ",$respuesta_parcial);
								$respuesta_final=$respuesta_parcial[0];
								
								$Model -> setAprobacionTenedor($tenedor_id,$respuesta_final,$path_xml,$this -> Conex);	 
								if($printMsj)echo("<br>Tenedor Previamente Reportado.<br>");									
						}else{
				      		if($printMsj)echo"<div id='message'>Error reportando Tenedor, revise el log de errores <br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a></div>";
						}
				    }
				  							 
			   }										 
						
						
			}
		
		} 		
	
	
	
	}	
	
	public function sendPropietarioMintransporte($data,$path_xml = NULL,$printMsj = true){
		
		require_once("WebServiceMinTranporteModelClass.php");	 	  
			
	    $Model = new WebServiceMinTransporteModel();	
					
		if(is_null($path_xml)){
				
			$tercero_id                     = $data['tercero_id'];
			$CODSEDETERCERO                 = $data['tercero_id']; 
			$CODTIPOIDTERCERO               = $Model -> getCodTipoIdentificacion($data['tipo_identificacion_id'],$this -> Conex);
			$NUMIDTERCERO                   = substr($Model -> getIdentificacionPropietario($data['tercero_id'],$this -> Conex),0,15);	
			$NOMIDTERCERO                   = substr(trim($this -> limpioCaracteresXML($data['nombre'])),0,100);	
			$NOMSEDETERCERO                 = substr(trim($this -> limpioCaracteresXML($data['nombre_sede'])),0,100);	
			$PRIMERAPELLIDOIDTERCERO        = substr(trim($this -> limpioCaracteresXML($data['primer_apellido'])),0,100);
			$SEGUNDOAPELLIDOIDTERCERO       = substr(trim($this -> limpioCaracteresXML($data['segundo_apellido'])),0,100);		
			$NUMTELEFONOCONTACTO            = substr(trim($this -> limpioCaracteresXML($data['telefono'])),0,7);
			$NOMENCLATURADIRECCION          = substr(trim($this -> limpioCaracteresXML($data['direccion'])),0,60);
			$CODMUNICIPIORNDC               = str_pad($data['ubicacion_id'],8, "0", STR_PAD_LEFT);		
			
			
			if($CODTIPOIDTERCERO == 'N'){
				
				 $msj = "<?xml version='1.0' encoding='UTF-8' ?>
				  <root> 
					<acceso> 
						<username>{$this -> username}</username> 
						<password>{$this -> password}</password> 
						<ambiente>{$this -> ambiente}</ambiente>					
					</acceso> 
					<solicitud> 
						<tipo>1</tipo> 
						<procesoid>11</procesoid> 
					</solicitud> 
					<variables> 
						<NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
						<CODTIPOIDTERCERO>{$CODTIPOIDTERCERO}</CODTIPOIDTERCERO> 
						<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
						<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
						<CODSEDETERCERO>{$CODSEDETERCERO}</CODSEDETERCERO> 
						<NOMSEDETERCERO>{$NOMSEDETERCERO}</NOMSEDETERCERO> 
						<NUMTELEFONOCONTACTO>{$NUMTELEFONOCONTACTO}</NUMTELEFONOCONTACTO> 
						<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
						<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 
					</variables> 
				  </root>";	
							
			}else{
			
			
	        if(strlen(trim($SEGUNDOAPELLIDOIDTERCERO)) > 0){
		      $SEGUNDOAPELLIDOIDTERCERO = "<SEGUNDOAPELLIDOIDTERCERO>{$SEGUNDOAPELLIDOIDTERCERO}</SEGUNDOAPELLIDOIDTERCERO>";
			}
			
			$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
					 <root> 
					  <acceso> 
						<username>{$this -> username}</username> 
						<password>{$this -> password}</password> 
						<ambiente>{$this -> ambiente}</ambiente>
					  </acceso> 				   
					  <solicitud> 
					   <tipo>1</tipo> 
						<procesoid>11</procesoid>
					  </solicitud>				  
					  <variables>
						<CODSEDETERCERO>0</CODSEDETERCERO>
						<NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
						<CODTIPOIDTERCERO>{$CODTIPOIDTERCERO}</CODTIPOIDTERCERO> 
						<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
						<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
						<PRIMERAPELLIDOIDTERCERO>{$PRIMERAPELLIDOIDTERCERO}</PRIMERAPELLIDOIDTERCERO> 
						{$SEGUNDOAPELLIDOIDTERCERO} 					
						<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
						<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 				
					  </variables>
					 </root>";		
			
			 }
					
			$path_xml = "{$this -> ruta_archivos}propietario_{$data[numero_identificacion]}.xml";
			
		}else{
		    $msj = file_get_contents($path_xml);
		  }
				
		$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);
					
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		

		if ($respuesta=='') { 
		 $respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
		 $Model -> setErrorReportePropietario($tercero_id,$respuesta,$path_xml,$this -> Conex);		 
		 if($printMsj) echo $respuesta;
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
		    $respuesta = '<div id="message">Error:'. $sError.'</div>';			
		    $Model -> setErrorReportePropietario($tercero_id,$respuesta,$path_xml,$this -> Conex);		  
			if($printMsj) echo $respuesta;
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionPropietario($tercero_id,$ingresoid,$path_xml,$this -> Conex);
				 
				 if($printMsj)echo"<div id='message'>Reportado Exitosamente</div>";
			   
			   }else{			   
				  
				  $Model -> setErrorReportePropietario($tercero_id,$respuesta,$path_xml,$this -> Conex);
				  
				  if(preg_match("/Connection refused./i","$respuesta")){
                     if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
				  }else if(preg_match("/listener could not find/i","$respuesta")){
				      if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				  }else{
					   require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					   if(preg_match("/DUPLICADO:/i","$respuesta")){
								$resultado = xml2array($respuesta);	
								$respuesta_parcial = $resultado['root']['ErrorMSG'];
								$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
								$respuesta_parcial=explode(" ",$respuesta_parcial);
								$respuesta_final=$respuesta_parcial[0];
								
								$Model -> setAprobacionPropietario($tercero_id,$respuesta_final,$path_xml,$this -> Conex);	 
								if($printMsj)echo("<br>Propietario Previamente Reportado.<br>");									
						}else{
				       		if($printMsj)echo"<div id='message'>Error reportando Propietario, revise el log de errores <br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a></div>";
				    	}
				  }
				  							 
			   }										 
						
						
			}
		
		} 		
	
	
	}	
	
	
	public function sendRemitenteDestinatarioMintransporte($data,$path_xml = NULL,$printMsj = true){
		
        require_once("WebServiceMinTranporteModelClass.php");	 	  
				
		$Model = new WebServiceMinTransporteModel();		
		
		if(is_null($path_xml)){
		
		$remitente_destinatario_id      = $data['remitente_destinatario_id'];
		$CODSEDETERCERO                 = $data['remitente_destinatario_id']; 
		$CODTIPOIDTERCERO               = $Model -> getCodTipoIdentificacion($data['tipo_identificacion_id'],$this -> Conex);
		$NUMIDTERCERO                   = substr($Model -> getIdentificacionRemDest($data['remitente_destinatario_id'],$this -> Conex),0,15);		
		$NOMIDTERCERO                   = substr(trim($this -> limpioCaracteresXML($data['nombre'])),0,100);	
		$NOMSEDETERCERO                 = substr(trim($this -> limpioCaracteresXML($data['nombre_sede'])),0,100);	
		$PRIMERAPELLIDOIDTERCERO        = substr(trim($this -> limpioCaracteresXML($data['primer_apellido'])),0,100);
		$SEGUNDOAPELLIDOIDTERCERO       = substr(trim($this -> limpioCaracteresXML($data['segundo_apellido'])),0,100);		
		$NUMTELEFONOCONTACTO            = substr(trim($this -> limpioCaracteresXML($data['telefono'])),0,7);
		$NOMENCLATURADIRECCION          = substr(trim($this -> limpioCaracteresXML($data['direccion'])),0,60);
		$CODMUNICIPIORNDC               = str_pad($data['ubicacion_id'],8, "0", STR_PAD_LEFT);		
				
		if($CODTIPOIDTERCERO == 'N'){
			
			 $msj = "<?xml version='1.0' encoding='UTF-8' ?>
			  <root> 
				<acceso> 
					<username>{$this -> username}</username> 
					<password>{$this -> password}</password> 
					<ambiente>{$this -> ambiente}</ambiente>					
				</acceso> 
				<solicitud> 
					<tipo>1</tipo> 
					<procesoid>11</procesoid> 
				</solicitud> 
				<variables> 
				    <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
					<CODTIPOIDTERCERO>{$CODTIPOIDTERCERO}</CODTIPOIDTERCERO> 
					<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
					<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
					<CODSEDETERCERO>{$CODSEDETERCERO}</CODSEDETERCERO> 
					<NOMSEDETERCERO>{$NOMSEDETERCERO}</NOMSEDETERCERO> 
					<NUMTELEFONOCONTACTO>{$NUMTELEFONOCONTACTO}</NUMTELEFONOCONTACTO> 
					<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
					<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 
				</variables> 
			  </root>";	
						
		}else{
		
			  if(strlen(trim($SEGUNDOAPELLIDOIDTERCERO)) > 0){
				$SEGUNDOAPELLIDOIDTERCERO = "<SEGUNDOAPELLIDOIDTERCERO>$SEGUNDOAPELLIDOIDTERCERO</SEGUNDOAPELLIDOIDTERCERO>";
			  }		
		
				$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
						 <root> 
						  <acceso> 
							<username>{$this -> username}</username> 
							<password>{$this -> password}</password> 
					        <ambiente>{$this -> ambiente}</ambiente>							
						  </acceso> 				   
						  <solicitud> 
						   <tipo>1</tipo> 
							<procesoid>11</procesoid>
						  </solicitud>				  
						  <variables>
							<CODSEDETERCERO>{$CODSEDETERCERO}</CODSEDETERCERO>
							<NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
							<CODTIPOIDTERCERO>{$CODTIPOIDTERCERO}</CODTIPOIDTERCERO> 
							<NUMIDTERCERO>{$NUMIDTERCERO}</NUMIDTERCERO> 
							<NOMIDTERCERO>{$NOMIDTERCERO}</NOMIDTERCERO> 
							<PRIMERAPELLIDOIDTERCERO>{$PRIMERAPELLIDOIDTERCERO}</PRIMERAPELLIDOIDTERCERO> 
							{$SEGUNDOAPELLIDOIDTERCERO}
							<NOMENCLATURADIRECCION>{$NOMENCLATURADIRECCION}</NOMENCLATURADIRECCION> 
							<CODMUNICIPIORNDC>{$CODMUNICIPIORNDC}</CODMUNICIPIORNDC> 				
						  </variables>
						 </root>";		
		
		 }
		 			
			
		$path_xml = "{$this -> ruta_archivos}remitente_destinatario_{$data[numero_identificacion]}.xml";	
		
		}else{
		    $msj = file_get_contents($path_xml);
		  }				
				
		$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);				
       		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 $respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';		 
		 $Model -> setErrorReporteRemitenteDestinatario($remitente_destinatario_id,$respuesta,$path_xml,$this -> Conex);		
		 if($printMsj) echo $respuesta;		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
			$respuesta = '<div id="message">Error:'. $sError.'</div>';						
		    $Model -> setErrorReporteRemitenteDestinatario($remitente_destinatario_id,$respuesta,$path_xml,$this -> Conex);		
		    if($printMsj) echo $respuesta;						
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionRemitenteDestinatario($remitente_destinatario_id,$ingresoid,$path_xml,$this -> Conex);
				 
				 if($printMsj) echo"<div id='message'>Reportado Exitosamente</div>";
			   
			   }else{			   
				  
				  $Model -> setErrorReporteRemitenteDestinatario($remitente_destinatario_id,$respuesta,$path_xml,$this -> Conex);
				  
				  if(preg_match("/Connection refused./i","$respuesta")){
                    if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				     if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				    }else{

					   require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					   if(preg_match("/DUPLICADO:/i","$respuesta")){
								$resultado = xml2array($respuesta);	
								$respuesta_parcial = $resultado['root']['ErrorMSG'];
								$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
								$respuesta_parcial=explode(" ",$respuesta_parcial);
								$respuesta_final=$respuesta_parcial[0];
								
								$Model -> setAprobacionRemitenteDestinatario($remitente_destinatario_id,$respuesta_final,$path_xml,$this -> Conex);	 
								if($printMsj)echo("<br>Remitente o Destinatario Previamente Reportado.<br>");									
						}else{
				       		if($printMsj)echo"<div id='message'>Error reportando Remitente o Destinatario, revise el log de errores <br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a></div>";
				    	}
					}
				  							 
			   }										 						
						
			}
		
		} 				
	
	}		
	
    public function sendVehiculoMintransporte($data,$path_xml = NULL,$printMsj = true){

		require_once("WebServiceMinTranporteModelClass.php");	
		$Model     = new WebServiceMinTransporteModel();			 	  
									
        $tenedor_id     = $data['tenedor_id'];									
		$propietario_id = $data['propietario_id'];									
		$cod_marca      = $Model -> getCodMarca($data['marca_id'],$this -> Conex);					
		$cod_linea      = $Model -> getCodLinea($data['linea_id'],$this -> Conex);		
		
		if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> Conex)){
		 
		   $dataTenedor = $Model -> selectTenedor($tenedor_id,$this -> Conex);	   
		
		   $dataT = array(	  
				tenedor_id                => $dataTenedor[0]['tenedor_id'],
				tipo_identificacion_id    => $dataTenedor[0]['tipo_identificacion_id'],
				numero_identificacion     => $dataTenedor[0]['numero_identificacion'],
				nombre                    => $dataTenedor[0]['primer_nombre'].' '.$dataTenedor[0]['segundo_nombre'].' '.$dataTenedor[0]['razon_social'],		
				nombre_sede               => $dataTenedor[0]['primer_nombre'].' '.$dataTenedor[0]['segundo_nombre'].' '.$dataTenedor[0]['primer_apellido'].' '.$dataTenedor[0]['segundo_apellido'].' '.$dataTenedor[0]['razon_social'],		
				primer_apellido           => $dataTenedor[0]['primer_apellido'],
				segundo_apellido          => $dataTenedor[0]['segundo_apellido'],
				telefono                  => $dataTenedor[0]['telefono'],
				direccion                 => $dataTenedor[0]['direccion'],
				ubicacion_id              => $dataTenedor[0]['ubicacion_id']
			);
		  
	  
		   $this -> sendTenedorMintransporte($dataT,NULL,false);
	   
		}
				
				
		if(!$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> Conex)){
		
		 	   $dataPropietario = $Model -> selectPropietario($propietario_id,$this -> Conex);	   
	
			   $dataP = array(	  
					tercero_id                => $dataPropietario[0]['tercero_id'],
					tipo_identificacion_id    => $dataPropietario[0]['tipo_identificacion_id'],
					numero_identificacion     => $dataPropietario[0]['numero_identificacion'],
					nombre                    => $dataPropietario[0]['primer_nombre'].' '.$dataPropietario[0]['segundo_nombre'].' '.$dataPropietario[0]['razon_social'],		
					nombre_sede               => $dataPropietario[0]['primer_nombre'].' '.$dataPropietario[0]['segundo_nombre'].' '.$dataPropietario[0]['primer_apellido'].' '.$dataPropietario[0]['segundo_apellido'].' '.$dataPropietario[0]['razon_social'],		
					primer_apellido           => $dataPropietario[0]['primer_apellido'],
					segundo_apellido          => $dataPropietario[0]['segundo_apellido'],
					telefono                  => $dataPropietario[0]['telefono'],
					direccion                 => $dataPropietario[0]['direccion'],
					ubicacion_id              => $dataPropietario[0]['ubicacion_id']
				);
	  
                $this -> sendPropietarioMintransporte($dataP,NULL,false);			
		
		}
		
		
		if(!is_null($cod_marca) && !is_null($cod_linea)){
			   
			if(is_null($path_xml)){
				   	   
				$placa_id                     = $data['placa_id'];   
				$NUMPLACA                     = $data['placa'];
				$CODCONFIGURACIONUNIDADCARGA  = $data['configuracion'];
				$CODMARCAVEHICULOCARGA        = $Model -> getCodMarca($data['marca_id'],$this -> Conex);
				$CODLINEAVEHICULOCARGA        = $Model -> getCodLinea($data['linea_id'],$this -> Conex);		
				$NUMEJES                      = $data['numero_ejes'];		
				$ANOFABRICACIONVEHICULOCARGA  = $data['modelo_vehiculo'];
				$ANOREPOTENCIACION            = $data['modelo_repotenciado'];
				$CODCOLORVEHICULOCARGA        = $data['color_id'];
				$PESOVEHICULOVACIO            = $data['peso_vacio'];
				$CAPACIDADUNIDADCARGA         = $data['capacidad'];
				$UNIDADMEDIDACAPACIDAD        = $data['unidad_capacidad_carga'];		
				$CODTIPOCARROCERIA            = $data['carroceria_id'];				
				$NUMCHASIS                    = $data['chasis'];	
				$CODTIPOCOMBUSTIBLE           = $data['combustible_id'];			
				$NUMSEGUROSOAT                = $data['numero_soat'];					
				$FECHAVENCIMIENTOSOAT         = date("d/m/Y",strtotime($data['vencimiento_soat']));
				$NUMNITASEGURADORASOAT        = $Model -> getNitAseguradora($data['aseguradora_soat_id'],$this -> Conex);									
				$CODTIPOIDPROPIETARIO         = $Model -> getCodTipoIdentificacionPropietario($data['propietario_id'],$this -> Conex);											
				$NUMIDPROPIETARIO             = $Model -> getIdentificacionPropietario($data['propietario_id'],$this -> Conex);
				$CODTIPOIDTENEDOR             = $Model -> getCodTipoIdentificacionTenedor($data['tenedor_id'],$this -> Conex);											
				$NUMIDTENEDOR                 = $Model -> getIdentificacionTenedor($data['tenedor_id'],$this -> Conex);
				
				if(in_array($data['configuracion'],array('55','56','64','74','85'))){
				  $NUMEJES = "<NUMEJES>{$NUMEJES}</NUMEJES>";
				}else{
					$NUMEJES = NULL;
				  }
				  
				if(is_numeric($ANOREPOTENCIACION)){
				  $ANOREPOTENCIACION = "<ANOREPOTENCIACION>{$ANOREPOTENCIACION}</ANOREPOTENCIACION>";
				}else{
					$ANOREPOTENCIACION = NULL;
				  }
				  
				if(in_array($data['configuracion'],array('50','55','56','64','74','85'))){
				  $CAPACIDADUNIDADCARGA = "<CAPACIDADUNIDADCARGA>{$CAPACIDADUNIDADCARGA}</CAPACIDADUNIDADCARGA>";
				}else{
					$CAPACIDADUNIDADCARGA = NULL;
				  } 
							  
				
				if(in_array($data['configuracion'],array('53','54','55'))){
				  $CODTIPOCARROCERIA = "<CODTIPOCARROCERIA>0</CODTIPOCARROCERIA>";
				}else{
					$CODTIPOCARROCERIA = "<CODTIPOCARROCERIA>{$CODTIPOCARROCERIA}</CODTIPOCARROCERIA>";
				  } 		
						  
								
				$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
				 <root> 
				  <acceso> 
					<username>{$this -> username}</username> 
					<password>{$this -> password}</password> 
					<ambiente>{$this -> ambiente}</ambiente>			
				  </acceso> 
				  
				  <solicitud> 
				   <tipo>1</tipo> 
				   <procesoid>12</procesoid> 
				  </solicitud> 
				  
				  <variables> 
				   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
				   <NUMPLACA>{$NUMPLACA}</NUMPLACA> 
				   <CODCONFIGURACIONUNIDADCARGA>{$CODCONFIGURACIONUNIDADCARGA}</CODCONFIGURACIONUNIDADCARGA> 
				   <CODMARCAVEHICULOCARGA>{$CODMARCAVEHICULOCARGA}</CODMARCAVEHICULOCARGA>
				   <CODLINEAVEHICULOCARGA>{$CODLINEAVEHICULOCARGA}</CODLINEAVEHICULOCARGA> 		   
				   {$NUMEJES}		   
				   <ANOFABRICACIONVEHICULOCARGA>{$ANOFABRICACIONVEHICULOCARGA}</ANOFABRICACIONVEHICULOCARGA> 
				   {$ANOREPOTENCIACION}
				   <CODCOLORVEHICULOCARGA>{$CODCOLORVEHICULOCARGA}</CODCOLORVEHICULOCARGA> 
				   <PESOVEHICULOVACIO>{$PESOVEHICULOVACIO}</PESOVEHICULOVACIO> 
				   {$CAPACIDADUNIDADCARGA}
				   <UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>
				   {$CODTIPOCARROCERIA}
				   <NUMCHASIS>{$NUMCHASIS}</NUMCHASIS>
				   <CODTIPOCOMBUSTIBLE>{$CODTIPOCOMBUSTIBLE}</CODTIPOCOMBUSTIBLE>
				   <NUMSEGUROSOAT>{$NUMSEGUROSOAT}</NUMSEGUROSOAT>
				   <FECHAVENCIMIENTOSOAT>{$FECHAVENCIMIENTOSOAT}</FECHAVENCIMIENTOSOAT>
				   <NUMNITASEGURADORASOAT>{$NUMNITASEGURADORASOAT}</NUMNITASEGURADORASOAT>
				   <CODTIPOIDPROPIETARIO>{$CODTIPOIDPROPIETARIO}</CODTIPOIDPROPIETARIO>
				   <NUMIDPROPIETARIO>{$NUMIDPROPIETARIO}</NUMIDPROPIETARIO>
				   <CODTIPOIDTENEDOR>{$CODTIPOIDTENEDOR}</CODTIPOIDTENEDOR>
				   <NUMIDTENEDOR>{$NUMIDTENEDOR}</NUMIDTENEDOR>		
				  </variables> 
				 </root>";	
				
				$path_xml = "{$this -> ruta_archivos}vehiculo_{$data[placa]}.xml";
				
			}else{
		       $msj = file_get_contents($path_xml);
		      }
			
			$fp = fopen($path_xml,'w');
			fwrite($fp,"$msj");
			fclose($fp);			
			
			$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
			$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
						
			if ($respuesta=='') { 
			 $respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';			 			 
			 $Model -> setErrorReporteVehiculo($placa_id,$respuesta,$path_xml,$this -> Conex);			 
			 if($printMsj) echo $respuesta;			 
			} else { 
			
			  $sError ='';
			
			  if ($sError!='') { 
			    $respuesta = '<div id="message">Error:'. $sError.'</div>';;			 			 
			    $Model -> setErrorReporteVehiculo($placa_id,$respuesta,$path_xml,$this -> Conex);			 
			    if($printMsj) echo $respuesta;			 				
			  }else{
		  
				   if(preg_match("/ingresoid/i","$respuesta")){

			  
					 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					 
					 $contenido = $respuesta;
					 $resultado = xml2array($contenido);			   
					 $ingresoid = $resultado['root']['ingresoid'];
					 
					 $Model -> setAprobacionVehiculo($placa_id,$ingresoid,$path_xml,$this -> Conex);
					 
					 if($printMsj) echo"<div id='message'>Reportado Exitosamente</div>";
				   
				   }else{							   
					  
					  $Model -> setErrorReporteVehiculo($placa_id,$respuesta,$path_xml,$this -> Conex);
					  
					  if(preg_match("/Connection refused./i","$respuesta")){
	                    if($printMsj) echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
	                  }else if(preg_match("/listener could not find/i","$respuesta")){
						  if($printMsj) echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
					  }else{
							//bloque duplicado inicio vehiculo
						   require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
						   if(preg_match("/DUPLICADO:/i","$respuesta")){
									$resultado = xml2array($respuesta);	
									$respuesta_parcial = $resultado['root']['ErrorMSG'];
									$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
									$respuesta_parcial=explode(" ",$respuesta_parcial);
									$respuesta_final=$respuesta_parcial[0];
									
									$Model -> setAprobacionVehiculo($placa_id,$respuesta_final,$path_xml,$this -> Conex);	 
									if($printMsj)echo("<br>Vehiculo Previamente Reportado.<br>");									
							}else{
						  		if($printMsj) echo"<div id='message'>Error reportando Vehiculo, revise el log de errores <br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a></div>";
							}
						}
						
												 
				   }									 						
							
				}
			
			} 			
		
		  }else{
		  
		      if(is_null($cod_linea)){
			    if($printMsj) echo "<div id='message'>Debe asignar <b>LINEA</b> al vehiculo antes de reportar al ministerio!!!</div>";
			  }
			  
			  if(is_null($cod_marca)){
			     if($printMsj) echo "<div id='message'>Debe asignar <b>MARCA</b> al vehiculo antes de reportar al ministerio!!!</div>";
			  }
		  
		    }	 
	
	}
	
	
	public function sendRemolqueMintransporte($data,$path_xml = NULL,$printMsj = true){
		   
        require_once("WebServiceMinTranporteModelClass.php");	 	  
				
		$Model          = new WebServiceMinTransporteModel();			 		   
		$tenedor_id     = $data['tenedor_id'];
		$propietario_id = $data['propietario_id'];		
		   
		if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> Conex)){
		 
		   $dataTenedor = $Model -> selectTenedor($tenedor_id,$this -> Conex);	   
		
		   $dataT = array(	  
				tenedor_id                => $dataTenedor[0]['tenedor_id'],
				tipo_identificacion_id    => $dataTenedor[0]['tipo_identificacion_id'],
				numero_identificacion     => $dataTenedor[0]['numero_identificacion'],
				nombre                    => $dataTenedor[0]['primer_nombre'].' '.$dataTenedor[0]['segundo_nombre'].' '.$dataTenedor[0]['razon_social'],		
				nombre_sede               => $dataTenedor[0]['primer_nombre'].' '.$dataTenedor[0]['segundo_nombre'].' '.$dataTenedor[0]['primer_apellido'].' '.$dataTenedor[0]['segundo_apellido'].' '.$dataTenedor[0]['razon_social'],		
				primer_apellido           => $dataTenedor[0]['primer_apellido'],
				segundo_apellido          => $dataTenedor[0]['segundo_apellido'],
				telefono                  => $dataTenedor[0]['telefono'],
				direccion                 => $dataTenedor[0]['direccion'],
				ubicacion_id              => $dataTenedor[0]['ubicacion_id']
			);
		  
	  
		   $this -> sendTenedorMintransporte($dataT,NULL,false);
	   
		}
				
		if(!$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> Conex)){
		
		 	   $dataPropietario = $Model -> selectPropietario($propietario_id,$this -> Conex);	   
	
			   $dataP = array(	  
					tercero_id                => $dataPropietario[0]['tercero_id'],
					tipo_identificacion_id    => $dataPropietario[0]['tipo_identificacion_id'],
					numero_identificacion     => $dataPropietario[0]['numero_identificacion'],
					nombre                    => $dataPropietario[0]['primer_nombre'].' '.$dataPropietario[0]['segundo_nombre'].' '.$dataPropietario[0]['razon_social'],		
					nombre_sede               => $dataPropietario[0]['primer_nombre'].' '.$dataPropietario[0]['segundo_nombre'].' '.$dataPropietario[0]['primer_apellido'].' '.$dataPropietario[0]['segundo_apellido'].' '.$dataPropietario[0]['razon_social'],		
					primer_apellido           => $dataPropietario[0]['primer_apellido'],
					segundo_apellido          => $dataPropietario[0]['segundo_apellido'],
					telefono                  => $dataPropietario[0]['telefono'],
					direccion                 => $dataPropietario[0]['direccion'],
					ubicacion_id              => $dataPropietario[0]['ubicacion_id']
				);
	  
  
                $this -> sendPropietarioMintransporte($dataP,NULL,false);			
		
		}		   
		   
		if(is_null($path_xml)){
		   	   
		 $placa_remolque_id            = $data['placa_remolque_id'];
		 $NUMPLACA                     = $data['placa_remolque'];
		 $CODCONFIGURACIONUNIDADCARGA  = $data['tipo_remolque_id'];
		 $CODMARCAVEHICULOCARGA        = $Model -> getCodMarcaRemolque($data['marca_remolque_id'],$this -> Conex);
		 $ANOFABRICACIONVEHICULOCARGA  = $data['modelo_remolque'];
		 $PESOVEHICULOVACIO            = $data['peso_vacio_remolque'];
		 $CAPACIDADUNIDADCARGA         = $data['capacidad_carga_remolque'];
		 //$CODCOLORVEHICULOCARGA        = $data['color_id'];
		 $UNIDADMEDIDACAPACIDAD        = $data['unidad_capacidad_carga'];		
		 $CODTIPOCARROCERIA            = $data['carroceria_remolque_id'];		
		 $CODTIPOIDPROPIETARIO         = $Model -> getCodTipoIdentificacionPropietario($data['propietario_id'],$this -> Conex);											
		 $NUMIDPROPIETARIO             = $Model -> getIdentificacionPropietario($data['propietario_id'],$this -> Conex);
		 $CODTIPOIDTENEDOR             = $Model -> getCodTipoIdentificacionTenedor($data['tenedor_id'],$this -> Conex);											
		 $NUMIDTENEDOR                 = $Model -> getIdentificacionTenedor($data['tenedor_id'],$this -> Conex);		
		
		 /*if(in_array($data['configuracion'],array('55','56','64','74','85'))){
		  $NUMEJES = "<NUMEJES>{$NUMEJES}</NUMEJES>";
		 }else{
		    $NUMEJES = NULL;
		  }
		  
		if(is_numeric($ANOREPOTENCIACION)){
		  $ANOREPOTENCIACION = "<ANOREPOTENCIACION>{$ANOREPOTENCIACION}</ANOREPOTENCIACION>";
		}else{
		    $ANOREPOTENCIACION = NULL;
		  }*/
		  
		 if(in_array($data['configuracion'],array('50','55','56','64','74','85'))){
		  $CAPACIDADUNIDADCARGA = "<CAPACIDADUNIDADCARGA>{$CAPACIDADUNIDADCARGA}</CAPACIDADUNIDADCARGA>";
		 }else{
		    $CAPACIDADUNIDADCARGA = NULL;
		  } 
		  		  	  
		
		 if(in_array($data['configuracion'],array('53','54','55'))){
		  $CODTIPOCARROCERIA = "<CODTIPOCARROCERIA>7</CODTIPOCARROCERIA>";
		 }else{
		    $CODTIPOCARROCERIA = "<CODTIPOCARROCERIA>{$CODTIPOCARROCERIA}</CODTIPOCARROCERIA>";
		  } 		
		  		  
		 		 		
		 $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
		  <root> 
		   <acceso> 
			<username>{$this -> username}</username> 
			<password>{$this -> password}</password> 
			<ambiente>{$this -> ambiente}</ambiente>			
		   </acceso> 
		   
		   <solicitud> 
		    <tipo>1</tipo> 
			<procesoid>12</procesoid> 
		   </solicitud> 
		   
		   <variables> 
		    <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			<NUMPLACA>{$NUMPLACA}</NUMPLACA> 
			<CODCONFIGURACIONUNIDADCARGA>{$CODCONFIGURACIONUNIDADCARGA}</CODCONFIGURACIONUNIDADCARGA> 
			<CODMARCAVEHICULOCARGA>{$CODMARCAVEHICULOCARGA}</CODMARCAVEHICULOCARGA> 
			<ANOFABRICACIONVEHICULOCARGA>{$ANOFABRICACIONVEHICULOCARGA}</ANOFABRICACIONVEHICULOCARGA> 
			<PESOVEHICULOVACIO>{$PESOVEHICULOVACIO}</PESOVEHICULOVACIO> 
			{$CAPACIDADUNIDADCARGA} 
			{$CODTIPOCARROCERIA}
			<CODTIPOIDPROPIETARIO>{$CODTIPOIDPROPIETARIO}</CODTIPOIDPROPIETARIO> 
			<NUMIDPROPIETARIO>{$NUMIDPROPIETARIO}</NUMIDPROPIETARIO> 
			<CODTIPOIDTENEDOR>{$CODTIPOIDTENEDOR}</CODTIPOIDTENEDOR> 
			<NUMIDTENEDOR>{$NUMIDTENEDOR}</NUMIDTENEDOR> 
			<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>
		  </variables> 
		 </root>";	
		
		 $path_xml = "{$this -> ruta_archivos}remolque_{$data[placa_remolque]}.xml";
		
		}else{
		   $msj = file_get_contents($path_xml);
		  }
		
		$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);		
		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 echo '<div id="message">No se pudo completar la operaci&oacute;n</div>';
		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
			echo '<div id="message">Error:'. $sError.'</div>';
			
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionRemolque($placa_remolque_id,$ingresoid,$path_xml,$this -> Conex);
				 
				 echo"<div id='message'>Reportado Exitosamente</div>";
			   
			   }else{			   			   
				  
				  $Model -> setErrorReporteRemolque($placa_remolque_id,$respuesta,$path_xml,$this -> Conex);
				  
				  if(preg_match("/Connection refused./i","$respuesta")){
                    echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
				  }else if(preg_match("/listener could not find/i","$respuesta")){
				     echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				  }else{
					   require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					   if(preg_match("/DUPLICADO:/i","$respuesta")){
								$resultado = xml2array($respuesta);	
								$respuesta_parcial = $resultado['root']['ErrorMSG'];
								$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
								$respuesta_parcial=explode(" ",$respuesta_parcial);
								$respuesta_final=$respuesta_parcial[0];
								
								$Model -> setAprobacionRemolque($placa_remolque_id,$respuesta_final,$path_xml,$this -> Conex);	 
								if($printMsj) echo("<br>Remolque Previamente Reportado.<br>");									
						}else{
				      		echo"<div id='message'>Error reportando Remolque, revise el log de errores <br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a></div>";
						}
				    }
				  							 
			   }										 						
						
			}
		
		} 			
		 
	
	}	  
	
	public function sendInformacionCarga($data,$path_xml = NULL,$printMsj = true){  //ENVIA INFORMACION DE CARGA 7.3.1. Creacion de Informacion de Carga

		require_once("WebServiceMinTranporteModelClass.php");	 	  
					
	    $Model = new WebServiceMinTransporteModel();	
		
		if(is_null($path_xml)){
					 	   	
			 $remesa_id                   = $data['remesa_id'];		
	         $peso                        = str_replace(",",".",str_replace(".","",$data['peso']));			 			
			 $numero_remesa               = $data['numero_remesa'];
			 $CONSECUTIVOINFORMACIONCARGA = $data['numero_remesa'];
			 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data['fecha_recogida_ss']));
			 $HORACITAPACTADACARGUE       = $data['hora_recogida_ss'];
			 $CODOPERACIONTRANSPORTE      = $Model -> getCodTipoRemesa($data['tipo_remesa_id'],$this -> Conex);
			 $CODTIPOEMPAQUE              = $data['empaque_id'];
			 $CODNATURALEZACARGA          = $data['naturaleza_id'];
			 $DESCRIPCIONCORTAPRODUCTO    = substr($data['descripcion_producto'],0,50);
			 $MERCANCIAINFORMACIONCARGA   = $Model -> getCodProducto($data['producto_id'],$this -> Conex);
			 $CANTIDADINFORMACIONCARGA    = $data['peso'];
			 $UNIDADMEDIDACAPACIDAD       = $Model -> getCodUnidadMedida($data['medida_id'],$this -> Conex);
			 $CODTIPOIDREMITENTE          = $Model -> getCodTipoIdentificacionRemDest($data['remitente_id'],$this -> Conex);
			 $NUMIDREMITENTE              = $Model -> getDocRemitenteDestinatario($data['remitente_id'],$this -> Conex);
			 $CODSEDEREMITENTE            = $data['remitente_id'];
			 $CODTIPOIDDESTINATARIO       = $Model -> getCodTipoIdentificacionRemDest($data['destinatario_id'],$this -> Conex);
			 $CODSEDEDESTINATARIO         = $data['destinatario_id'];
			 $NUMIDDESTINATARIO           = $Model -> getDocRemitenteDestinatario($data['destinatario_id'],$this -> Conex);
			 $PACTOTIEMPOCARGUE           = 'NO';
			 $PACTOTIEMPODESCARGUE        = 'NO';
			 $OBSERVACIONES               = $data['observaciones'];
			
			 if($CODOPERACIONTRANSPORTE == 'V'){
			   $MERCANCIAINFORMACIONCARGA = '<MERCANCIAINFORMACIONCARGA>009990</MERCANCIAINFORMACIONCARGA>';
			   $DESCRIPCIONCORTAPRODUCTO  = 'CONTENEDOR VACIO';
			   $CANTIDADINFORMACIONCARGA  = NULL;
			   $UNIDADMEDIDACAPACIDAD     = '1';
			 }else if($CODOPERACIONTRANSPORTE == 'P'){
				 $MERCANCIAINFORMACIONCARGA = '<MERCANCIAINFORMACIONCARGA>009880</MERCANCIAINFORMACIONCARGA>';
				 $DESCRIPCIONCORTAPRODUCTO  = 'PAQUETES VARIOS';
				 $CANTIDADINFORMACIONCARGA  = "<CANTIDADINFORMACIONCARGA>{$CANTIDADINFORMACIONCARGA}</CANTIDADINFORMACIONCARGA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";						               }else{
				 $MERCANCIAINFORMACIONCARGA = "<MERCANCIAINFORMACIONCARGA>{$MERCANCIAINFORMACIONCARGA}</MERCANCIAINFORMACIONCARGA>";
				 $CANTIDADINFORMACIONCARGA  = "<CANTIDADINFORMACIONCARGA>{$CANTIDADINFORMACIONCARGA}</CANTIDADINFORMACIONCARGA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";							 }	
			   
			   
			 if($CODOPERACIONTRANSPORTE == 'C' || $CODOPERACIONTRANSPORTE == 'V'){  
			   $PESOCONTENEDORVACIO	= "<PESOCONTENEDORVACIO>{$peso}</PESOCONTENEDORVACIO>";		      		   
			 }else{
				 $PESOCONTENEDORVACIO = NULL;		      		   
			   }
			   			   
			   if(!$Model -> remitenteDestinatarioEstaReportado($data['remitente_id'],$this -> Conex)){
			   
			    $remitente_destinatario_id = $data['remitente_id'];
                $dataRemDest  =  $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,'R',$this -> Conex); 
				  
				$dataR = array(	  
					remitente_destinatario_id => $dataRemDest[0]['remitente_destinatario_id'],
					tipo_identificacion_id    => $dataRemDest[0]['tipo_identificacion_id'],
					numero_identificacion     => $dataRemDest[0]['numero_identificacion'].$dataRemDest[0]['digito_verificacion'],
					nombre                    => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					nombre_sede               => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					primer_apellido           => $dataRemDest[0]['primer_apellido'],
					segundo_apellido          => $dataRemDest[0]['segundo_apellido'],
					telefono                  => $dataRemDest[0]['telefono'],
					direccion                 => $dataRemDest[0]['direccion'],
					ubicacion_id              => $dataRemDest[0]['ubicacion_id']
				  );
				  
				$this -> sendRemitenteDestinatarioMintransporte($dataR,NULL,false);			   
			   
			   }
			   
			   
			   if(!$Model -> remitenteDestinatarioEstaReportado($data['destinatario_id'],$this -> Conex)){

			    $remitente_destinatario_id = $data['destinatario_id'];
                $dataRemDest  =  $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,'D',$this -> Conex); 
								  
				$dataD = array(	  
					remitente_destinatario_id => $dataRemDest[0]['remitente_destinatario_id'],
					tipo_identificacion_id    => $dataRemDest[0]['tipo_identificacion_id'],
					numero_identificacion     => $dataRemDest[0]['numero_identificacion'].$dataRemDest[0]['digito_verificacion'],
					nombre                    => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					nombre_sede               => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					primer_apellido           => $dataRemDest[0]['primer_apellido'],
					segundo_apellido          => $dataRemDest[0]['segundo_apellido'],
					telefono                  => $dataRemDest[0]['telefono'],
					direccion                 => $dataRemDest[0]['direccion'],
					ubicacion_id              => $dataRemDest[0]['ubicacion_id']
				  );
								  
								  
				$this -> sendRemitenteDestinatarioMintransporte($dataD,NULL,false);			   			   
			   			   
			   }	
			   	  
			   if($CODTIPOIDREMITENTE == 'C'){
			    $CODSEDEREMITENTE = '<CODSEDEREMITENTE>0</CODSEDEREMITENTE>'; 
			   }else{
			       $CODSEDEREMITENTE = "<CODSEDEREMITENTE>{$CODSEDEREMITENTE}</CODSEDEREMITENTE>"; 
			     }					   			   
					
			   if($CODTIPOIDDESTINATARIO == 'C'){
			    $CODSEDEDESTINATARIO = '<CODSEDEDESTINATARIO>0</CODSEDEDESTINATARIO>';
			   }else{
   			      $CODSEDEDESTINATARIO = "<CODSEDEDESTINATARIO>{$CODSEDEDESTINATARIO}</CODSEDEDESTINATARIO>";
			     }	
						
			   $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			   <root> 
				<acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>			
				</acceso> 
				<solicitud> 
				 <tipo>1</tipo> 
				 <procesoid>1</procesoid> 
				</solicitud> 
				<variables> 
				 <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
				 <CONSECUTIVOINFORMACIONCARGA>{$CONSECUTIVOINFORMACIONCARGA}</CONSECUTIVOINFORMACIONCARGA> 
				 <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE> 
				 <CODTIPOEMPAQUE>{$CODTIPOEMPAQUE}</CODTIPOEMPAQUE> 
				 <CODNATURALEZACARGA>{$CODNATURALEZACARGA}</CODNATURALEZACARGA> 
				 <DESCRIPCIONCORTAPRODUCTO>{$DESCRIPCIONCORTAPRODUCTO}</DESCRIPCIONCORTAPRODUCTO> 
				 {$MERCANCIAINFORMACIONCARGA}
				 {$CANTIDADINFORMACIONCARGA}
				 {$UNIDADMEDIDACAPACIDAD}
				 <CODTIPOIDREMITENTE>{$CODTIPOIDREMITENTE}</CODTIPOIDREMITENTE> 
				 <NUMIDREMITENTE>{$NUMIDREMITENTE}</NUMIDREMITENTE> 
                 {$CODSEDEREMITENTE}
				 <CODTIPOIDDESTINATARIO>{$CODTIPOIDDESTINATARIO}</CODTIPOIDDESTINATARIO> 
				 <NUMIDDESTINATARIO>{$NUMIDDESTINATARIO}</NUMIDDESTINATARIO> 
				 {$CODSEDEDESTINATARIO}
				 <PACTOTIEMPOCARGUE>SI</PACTOTIEMPOCARGUE>
				 <HORASPACTOCARGA>12</HORASPACTOCARGA>
				 <MINUTOSPACTOCARGA>0</MINUTOSPACTOCARGA>
				 <PACTOTIEMPODESCARGUE>SI</PACTOTIEMPODESCARGUE>
				 <HORASPACTODESCARGUE>12</HORASPACTODESCARGUE>
				 <MINUTOSPACTODESCARGUE>0</MINUTOSPACTODESCARGUE>
 				 <FECHACITAPACTADACARGUE>{$FECHACITAPACTADACARGUE}</FECHACITAPACTADACARGUE>
				 <HORACITAPACTADACARGUE>{$HORACITAPACTADACARGUE}</HORACITAPACTADACARGUE>

				</variables>
			 </root>";
	
			$path_xml = "{$this -> ruta_archivos}info_carga_{$data[numero_remesa]}.xml";
			
		}else{
		   $msj = file_get_contents($path_xml);
		  }
		
		$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);	
		
		$aParametros = array("Request" => $msj); 
		$this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
						
			if ($respuesta=='') { 
			
			 $respuesta = "No se pudo completar la operaci&oacute;n";
			 $Model -> setErrorReporteInformacionCarga($path_xml,$numero_remesa,$respuesta,$this -> Conex);
			 
			} else { 
			
			  $sError ='';
			
			  if ($sError!='') { 
			  
			    $respuesta = 'Error:'. $sError;
			    $Model -> setErrorReporteInformacionCarga($path_xml,$numero_remesa,$respuesta,$this -> Conex);								
				
			  }else{
			  
				   if(preg_match("/ingresoid/i","$respuesta")){
	
					 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					 
					 $contenido = $respuesta;
					 $resultado = xml2array($contenido);			   
					 $ingresoid = $resultado['root']['ingresoid'];
					 
					 $Model -> setAprobacionInformacionCarga($path_xml,$numero_remesa,$ingresoid,$this -> Conex);
					 
					 if($printMsj)echo "<div id='message'>Reportado Exitosamente</div>";
					 				   
				   }else{			   
				   					  
					  $Model -> setErrorReporteInformacionCarga($path_xml,$numero_remesa,$respuesta,$this -> Conex);
					  
					  if(preg_match("/ya fue registrado/i","$respuesta")){
					   $ingresoid = 0;
					   $Model -> setAprobacionInformacionCarga($path_xml,$numero_remesa,$ingresoid,$this -> Conex);
                       $respuesta = 'Reportado Exitosamente';
                      }
					  
												 
				   }										 						
							
				}
			
			} 			
	
	       if($printMsj)echo '<div id="message">'.$respuesta.'</div>'; 

	}
	
	public function sendInformacionViaje($data,$path_xml = NULL,$printMsj = true,$reportAll = true){ //CREACION INFORMACION DE VIAJE 7.4.1 INICIO
		
		require_once("WebServiceMinTranporteModelClass.php");	 	  
	
		$Model = new WebServiceMinTransporteModel();			
	
		if(is_null($path_xml)){
			
			$manifiesto_id                = $data['manifiesto_id'];
			$conductor_id                 = $data['conductor_id'];			  	  		  
			$placa_id                     = $data['placa_id'];		  
			$placa_remolque_id            = $data['placa_remolque_id'];			  
			$informacion_viaje            = $data['informacion_viaje'];	
			
			if(!is_numeric($informacion_viaje)){
				
			$informacion_viaje = $Model -> DbgetMaxConsecutive("manifiesto","informacion_viaje",$this->Conex,true,1);							
			}
	
			$CONSECUTIVOINFORMACIONVIAJE  = $informacion_viaje;
			$CODIDCONDUCTOR               = $data['tipo_identificacion_conductor_codigo'];
			$NUMIDCONDUCTOR               = $data['numero_identificacion'];
			$NUMPLACA                     = $data['placa'];
			$NUMPLACAREMOLQUE             = $data['placa_remolque'];
			$CODMUNICIPIOORIGENINFOVIAJE  = str_pad($data['origen_id'],8,"0", STR_PAD_LEFT);		
			$CODMUNICIPIODESTINOINFOVIAJE = str_pad($data['destino_id'],8, "0", STR_PAD_LEFT);		
			$VALORFLETEPACTADOVIAJE       = str_replace(",",".",str_replace(".","",$data['valor_flete']));
			
			if(!$Model -> conductorEstaReportado($conductor_id,$this->Conex)){
				
				$dataConductor = $Model -> selectConductor($conductor_id,$this->Conex);
				$dataC = array(	  
				conductor_id              => $dataConductor[0]['conductor_id'],
				numero_identificacion     => $dataConductor[0]['numero_identificacion'],
				nombre                    => $dataConductor[0]['primer_nombre'].' '.$dataConductor[0]['segundo_nombre'],
				primer_apellido           => $dataConductor[0]['primer_apellido'],
				segundo_apellido          => $dataConductor[0]['segundo_apellido'],
				telefono                  => $dataConductor[0]['telefono'],
				direccion                 => $dataConductor[0]['direccion'],
				categoria_id              => $dataConductor[0]['categoria_id'],
				numero_licencia_cond      => $dataConductor[0]['numero_licencia_cond'],
				vencimiento_licencia_cond => $dataConductor[0]['vencimiento_licencia_cond'],				
				ubicacion_id              => $dataConductor[0]['ubicacion_id']
				);
				
				$this -> sendConductorMintransporte($dataC,NULL,false);			    
	
			}
	
			if(!$Model -> vehiculoEstaReportado($placa_id,$this->Conex)){
	
				$dataVehiculo = $Model -> selectVehiculo($placa_id,$this->Conex);	   
				
				$dataV = array(	  
				placa_id               =>  $dataVehiculo[0]['placa_id'],	
				placa                  =>  $dataVehiculo[0]['placa'],
				configuracion          =>  $dataVehiculo[0]['configuracion'],
				marca_id               =>  $dataVehiculo[0]['marca_id'],
				linea_id               =>  $dataVehiculo[0]['linea_id'],		
				numero_ejes            =>  $dataVehiculo[0]['numero_ejes'],		
				modelo_vehiculo        =>  $dataVehiculo[0]['modelo_vehiculo'],
				modelo_repotenciado    =>  $dataVehiculo[0]['modelo_repotenciado'],
				color_id               =>  $dataVehiculo[0]['color_id'],
				peso_vacio             =>  $dataVehiculo[0]['peso_vacio'],
				capacidad              =>  $dataVehiculo[0]['capacidad'],
				unidad_capacidad_carga =>  $dataVehiculo[0]['unidad_capacidad_carga'],		
				carroceria_id          =>  $dataVehiculo[0]['carroceria_id'],				
				chasis                 =>  $dataVehiculo[0]['chasis'],	
				combustible_id         =>  $dataVehiculo[0]['combustible_id'],			
				numero_soat            =>  $dataVehiculo[0]['numero_soat'],					
				vencimiento_soat       =>  $dataVehiculo[0]['vencimiento_soat'],							
				aseguradora_soat_id    =>  $dataVehiculo[0]['aseguradora_soat_id'],									
				propietario_id         =>  $dataVehiculo[0]['propietario_id'],											
				tenedor_id             =>  $dataVehiculo[0]['tenedor_id']
				);
				$this -> sendVehiculoMintransporte($dataV,NULL,false);		    
			}	
	
			if(is_numeric($placa_remolque_id) && !$Model -> remolqueEstaReportado($placa_remolque_id,$this->Conex)){
	
				$dataRemolque = $Model -> selectRemolque($placa_remolque_id,$this -> Conex);	   
				
				$dataR = array(	  
				placa_remolque_id        => $dataRemolque[0]['placa_remolque_id'],	
				placa_remolque           => $dataRemolque[0]['placa_remolque'],
				tipo_remolque_id         => $dataRemolque[0]['tipo_remolque_id'],
				marca_remolque_id        => $dataRemolque[0]['marca_remolque_id'],
				carroceria_remolque_id   => $dataRemolque[0]['carroceria_remolque_id'],
				modelo_remolque          => $dataRemolque[0]['modelo_remolque'],
				peso_vacio_remolque      => $dataRemolque[0]['peso_vacio_remolque'],
				capacidad_carga_remolque => $dataRemolque[0]['capacidad_carga_remolque'],
				unidad_capacidad_carga   => $dataRemolque[0]['unidad_capacidad_carga'],
				propietario_id           => $dataRemolque[0]['propietario_id'],											
				tenedor_id               => $dataRemolque[0]['tenedor_id']
				);
				$this -> sendRemolqueMintransporte($dataR,NULL,false);	 		   
			}		 	  
	
			$remesas    = $data['remesas'];	  
			$preRemesas = "<PREREMESAS procesoid='44'>";
	  
			for($i = 0; $i < count($remesas); $i++){
				$remesa_id = $remesas[$i]['remesa_id'];
				$numero_remesa = $remesas[$i]['numero_remesa'];
				$preRemesas .= "<MANPREREMESA><CONSECUTIVOINFORMACIONCARGA>{$numero_remesa}</CONSECUTIVOINFORMACIONCARGA></MANPREREMESA>"; 
			}
	
			if($NUMPLACAREMOLQUE == 'NULL' || !strlen(trim($NUMPLACAREMOLQUE)) > 0){
				$NUMPLACAREMOLQUE = '';
			}else{
				$NUMPLACAREMOLQUE = "<NUMPLACAREMOLQUE>{$NUMPLACAREMOLQUE}</NUMPLACAREMOLQUE>"; 
			}
	
			$preRemesas .= "</PREREMESAS>";
			
			// Informacion de Viaje
			
			$msj1 = "<?xml version='1.0' encoding='UTF-8' ?> 
			<root> 
			<acceso> 
			<username>{$this -> username}</username> 
			<password>{$this -> password}</password> 
			<ambiente>{$this -> ambiente}</ambiente>			
			</acceso> 
			
			<solicitud> 
			<tipo>1</tipo> 
			<procesoid>2</procesoid> 
			</solicitud> 
			
			<variables> 
			<NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			<CONSECUTIVOINFORMACIONVIAJE>{$CONSECUTIVOINFORMACIONVIAJE}</CONSECUTIVOINFORMACIONVIAJE> 
			<CODIDCONDUCTOR>{$CODIDCONDUCTOR}</CODIDCONDUCTOR> 
			<NUMIDCONDUCTOR>{$NUMIDCONDUCTOR}</NUMIDCONDUCTOR> 
			<NUMPLACA>{$NUMPLACA}</NUMPLACA> 
			{$NUMPLACAREMOLQUE}
			<CODMUNICIPIOORIGENINFOVIAJE>{$CODMUNICIPIOORIGENINFOVIAJE}</CODMUNICIPIOORIGENINFOVIAJE> 
			<CODMUNICIPIODESTINOINFOVIAJE>{$CODMUNICIPIODESTINOINFOVIAJE}</CODMUNICIPIODESTINOINFOVIAJE> 
			{$preRemesas}
			<VALORFLETEPACTADOVIAJE>{$VALORFLETEPACTADOVIAJE}</VALORFLETEPACTADOVIAJE> 
			</variables> 
			</root>";
			
			$pathXML = "{$this -> ruta_archivos}info_viaje_{$CONSECUTIVOINFORMACIONVIAJE}.xml";
	
	
		}else{
			$msj = file_get_contents($path_xml);
		}
		//$fp = fopen($pathXML,'w');
		//fwrite($fp,"$msj1");
		//fclose($fp);	
		//$Model -> setPathXMLInfoViaje($manifiesto_id,$pathXML,$this -> Conex);			
	
		if($reportAll){				
			$msj2 = $this -> setXMLRemesas($manifiesto_id); 
			$msj3 = $this -> setXMLManifiesto($manifiesto_id,$informacion_viaje);					
		}
		require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
					 
		if($reportAll){
	
			for($rm = 0; $rm < count($msj2); $rm++){ 
										
				$msjXml        = $msj2[$rm]['xml'];	
				$remesa_id     = $msj2[$rm]['remesa_id'];	 
				$numero_remesa = $msj2[$rm]['numero_remesa'];
				
				if(!$Model -> remesaEstaReportada($remesa_id,$this -> Conex)){ //ojo
					
					$aParametros   = array("Request" => $msjXml);
					$this -> setOSoapClient($this -> Conex);
					$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
					if ($respuesta=='') { 
						$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
						$Model -> setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
						
						if($printMsj) 	echo $respuesta;					 
					} else { 
						$sError ='';
	
						if ($sError!='') { 
							$respuesta =  '<div id="message">Error:'. $sError.'</div>';
							$Model -> setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
							if($printMsj) echo $respuesta;						
						}else{
							if(preg_match("/ingresoid/i","$respuesta")){ 
								$contenido = $respuesta;
								$resultado = xml2array($contenido);			   
								$ingresoid = $resultado['root']['ingresoid']; 
								$Model -> setAprobacionRemesa($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);						
							}else{			   
								$Model -> setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
								if(preg_match("/ya fue convertida a Remesa/i","$respuesta")){
									$ingresoid = 0;
									//$Model -> setAprobacionRemesa($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);
									if($printMsj)echo"<div align='center' id='message'><b>Reportado Exitosamente</b></div>";
								}else if(preg_match("/Connection refused./i","$respuesta")){
									if($printMsj)echo("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
								}else if(preg_match("/listener could not find/i","$respuesta")){
									if($printMsj)echo("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
								}else{

								   if(preg_match("/DUPLICADO:/i","$respuesta")){
											$resultado = xml2array($respuesta);	
											$respuesta_parcial = $resultado['root']['ErrorMSG'];
											$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
											$respuesta_parcial=explode(" ",$respuesta_parcial);
											$respuesta_final=$respuesta_parcial[0];
											
											$Model -> setAprobacionRemesa($manifiesto_id,$remesa_id,$respuesta_final,$this -> Conex);	 
											if($printMsj)echo("<br>Remesa Previamente Reportada.<br>");									
									}else{
										if($printMsj)echo("Error reportando Remesas, revise el log de errores<br>Error ".$respuesta."<br> <a href='http://siandsi.co/errores_rndc.pdf' target='_blank'>Ver Diccionario Errores</a>");
									}
								}
							}									 						
						}
					} 						 
				} 
			}
	        if(!$Model -> manifiestoEstaReportado($manifiesto_id,$this -> Conex)){ 
				$aParametros = array("Request" => $msj3);
				$this -> setOSoapClient($this -> Conex);
				$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
				if ($respuesta=='') { 
					$respuesta = 'No se pudo completar la operaci&oacute;n'; 
					$Model -> setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$this -> Conex);			 
					//if($printMsj) 
					echo $respuesta.'_';
				}else{ 
					$sError ='';
	
					if ($sError!='') { 
						$respuesta = 'Error:'. $sError;
						$Model -> setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$this -> Conex);			 
						//if($printMsj) 
						echo $respuesta.'_';								
					}else{
						if(preg_match("/ingresoid/i","$respuesta")){
							$contenido = $respuesta;
							$resultado = xml2array($contenido);			   
							$ingresoid = $resultado['root']['ingresoid'];
							$observacionesqr = $resultado['root']['observacionesqr'];
							 $seguridadqr = $resultado['root']['seguridadqr'];
							 $Model -> setAprobacionManifiesto($manifiesto_id,$informacion_viaje,$ingresoid,$observacionesqr,$seguridadqr,$this -> Conex);
							if($printMsj) echo "<div id='message'>Reportado Exitosamente</div>";
						}else{			   			   
							$Model -> setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$this -> Conex);
	
							if(preg_match("/ya fue registrado/i","$respuesta")){
								$ingresoid = 0;	
								//$Model -> setAprobacionManifiesto($manifiesto_id,$informacion_viaje,$ingresoid,$this -> Conex);
								if($printMsj)echo"<div align='center' id='message'><b>Reportado Exitosamente</b></div>";
							}else if(preg_match("/Connection refused./i","$respuesta")){
								if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
							}else if(preg_match("/listener could not find/i","$respuesta")){
								if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
							}else{
							   if(preg_match("/DUPLICADO:/i","$respuesta")){
										$resultado = xml2array($respuesta);	
										$respuesta_parcial = $resultado['root']['ErrorMSG'];
										$observacionesqr = $resultado['root']['observacionesqr'];
										$seguridadqr = $resultado['root']['seguridadqr'];
										$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
										$respuesta_parcial=explode(" ",$respuesta_parcial);
										$ingresoid=$respuesta_parcial[0];
										$observacionesqr = ''; 
										$seguridadqr = '';
										
										$Model -> setAprobacionManifiesto($manifiesto_id,$informacion_viaje,$ingresoid,$observacionesqr,$seguridadqr,$this -> Conex); 
										if($printMsj)echo("<br>Manifiesto Previamente Reportado.<br>");									
								}else{
									if($printMsj) echo"<div id='message'>Error reportando Manifiesto, revise el log de errores</div>";
								}
							}
						}										 						
					}
				} 		
			}else{
				echo "<div id='message'>Previamente Reportado</div>";
			}
		}	
	
	}
	
	public function sendCorreccionInformacionCarga($data,$path_xml = NULL,$printMsj = true){  //CORRIGE INFORMACION DE CARGA 7.3.1. Corrección de Informacion de Carga

		require_once("WebServiceMinTranporteModelClass.php");	 	  
					
	    $Model = new WebServiceMinTransporteModel();	
		
		if(is_null($path_xml)){
					 	   	
			 $remesa_id                   = $data['remesa_id'];		
	         $peso                        = str_replace(",",".",str_replace(".","",$data['peso']));			 			
			 $numero_remesa               = $data['numero_remesa'];
			 $CONSECUTIVOINFORMACIONCARGA = $data['numero_remesa'];
			 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data['fecha_recogida_ss']));
			 $HORACITAPACTADACARGUE       = $data['hora_recogida_ss'];
			 $CODOPERACIONTRANSPORTE      = $Model -> getCodTipoRemesa($data['tipo_remesa_id'],$this -> Conex);
			 $CODTIPOEMPAQUE              = $data['empaque_id'];
			 $CODNATURALEZACARGA          = $data['naturaleza_id'];
			 $DESCRIPCIONCORTAPRODUCTO    = substr($data['descripcion_producto'],0,50);
			 $MERCANCIAINFORMACIONCARGA   = $Model -> getCodProducto($data['producto_id'],$this -> Conex);
			 $CANTIDADINFORMACIONCARGA    = $data['peso'];
			 $UNIDADMEDIDACAPACIDAD       = $Model -> getCodUnidadMedida($data['medida_id'],$this -> Conex);
			 $CODTIPOIDREMITENTE          = $Model -> getCodTipoIdentificacionRemDest($data['remitente_id'],$this -> Conex);
			 $NUMIDREMITENTE              = $Model -> getDocRemitenteDestinatario($data['remitente_id'],$this -> Conex);
			 $CODSEDEREMITENTE            = $data['remitente_id'];
			 $CODTIPOIDDESTINATARIO       = $Model -> getCodTipoIdentificacionRemDest($data['destinatario_id'],$this -> Conex);
			 $CODSEDEDESTINATARIO         = $data['destinatario_id'];
			 $NUMIDDESTINATARIO           = $Model -> getDocRemitenteDestinatario($data['destinatario_id'],$this -> Conex);
			 $PACTOTIEMPOCARGUE           = 'NO';
			 $PACTOTIEMPODESCARGUE        = 'NO';
			 $OBSERVACIONES               = $data['observaciones'];
			
			 if($CODOPERACIONTRANSPORTE == 'V'){
			   $MERCANCIAINFORMACIONCARGA = '<MERCANCIAINFORMACIONCARGA>009990</MERCANCIAINFORMACIONCARGA>';
			   $DESCRIPCIONCORTAPRODUCTO  = 'CONTENEDOR VACIO';
			   $CANTIDADINFORMACIONCARGA  = NULL;
			   $UNIDADMEDIDACAPACIDAD     = '1';
			 }else if($CODOPERACIONTRANSPORTE == 'P'){
				 $MERCANCIAINFORMACIONCARGA = '<MERCANCIAINFORMACIONCARGA>009880</MERCANCIAINFORMACIONCARGA>';
				 $DESCRIPCIONCORTAPRODUCTO  = 'PAQUETES VARIOS';
				 $CANTIDADINFORMACIONCARGA  = "<CANTIDADINFORMACIONCARGA>{$CANTIDADINFORMACIONCARGA}</CANTIDADINFORMACIONCARGA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";						               }else{
				 $MERCANCIAINFORMACIONCARGA = "<MERCANCIAREMESA>{$MERCANCIAINFORMACIONCARGA}</MERCANCIAREMESA>";
				 $CANTIDADINFORMACIONCARGA  = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";							 }	
			   
			   
			 if($CODOPERACIONTRANSPORTE == 'C' || $CODOPERACIONTRANSPORTE == 'V'){  
			   $PESOCONTENEDORVACIO	= "<PESOCONTENEDORVACIO>{$peso}</PESOCONTENEDORVACIO>";		      		   
			 }else{
				 $PESOCONTENEDORVACIO = NULL;		      		   
			   }
			   			   
			   if(!$Model -> remitenteDestinatarioEstaReportado($data['remitente_id'],$this -> Conex)){
			   
			    $remitente_destinatario_id = $data['remitente_id'];
                $dataRemDest  =  $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,'R',$this -> Conex); 
				  
				$dataR = array(	  
					remitente_destinatario_id => $dataRemDest[0]['remitente_destinatario_id'],
					tipo_identificacion_id    => $dataRemDest[0]['tipo_identificacion_id'],
					numero_identificacion     => $dataRemDest[0]['numero_identificacion'].$dataRemDest[0]['digito_verificacion'],
					nombre                    => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					nombre_sede               => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					primer_apellido           => $dataRemDest[0]['primer_apellido'],
					segundo_apellido          => $dataRemDest[0]['segundo_apellido'],
					telefono                  => $dataRemDest[0]['telefono'],
					direccion                 => $dataRemDest[0]['direccion'],
					ubicacion_id              => $dataRemDest[0]['ubicacion_id']
				  );
				  
				$this -> sendRemitenteDestinatarioMintransporte($dataR,NULL,false);			   
			   
			   }
			   
			   
			   if(!$Model -> remitenteDestinatarioEstaReportado($data['destinatario_id'],$this -> Conex)){

			    $remitente_destinatario_id = $data['destinatario_id'];
                $dataRemDest  =  $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,'D',$this -> Conex); 
								  
				$dataD = array(	  
					remitente_destinatario_id => $dataRemDest[0]['remitente_destinatario_id'],
					tipo_identificacion_id    => $dataRemDest[0]['tipo_identificacion_id'],
					numero_identificacion     => $dataRemDest[0]['numero_identificacion'].$dataRemDest[0]['digito_verificacion'],
					nombre                    => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					nombre_sede               => $dataRemDest[0]['nombre'].' '.$dataRemDest[0]['razon_social'],		
					primer_apellido           => $dataRemDest[0]['primer_apellido'],
					segundo_apellido          => $dataRemDest[0]['segundo_apellido'],
					telefono                  => $dataRemDest[0]['telefono'],
					direccion                 => $dataRemDest[0]['direccion'],
					ubicacion_id              => $dataRemDest[0]['ubicacion_id']
				  );
								  
								  
				$this -> sendRemitenteDestinatarioMintransporte($dataD,NULL,false);			   			   
			   			   
			   }	
			   	  
			   if($CODTIPOIDREMITENTE == 'C'){
			    $CODSEDEREMITENTE = '<CODSEDEREMITENTE>0</CODSEDEREMITENTE>'; 
			   }else{
			       $CODSEDEREMITENTE = "<CODSEDEREMITENTE>{$CODSEDEREMITENTE}</CODSEDEREMITENTE>"; 
			     }					   			   
					
			   if($CODTIPOIDDESTINATARIO == 'C'){
			    $CODSEDEDESTINATARIO = '<CODSEDEDESTINATARIO>0</CODSEDEDESTINATARIO>';
			   }else{
   			      $CODSEDEDESTINATARIO = "<CODSEDEDESTINATARIO>{$CODSEDEDESTINATARIO}</CODSEDEDESTINATARIO>";
			     }	
						
			   /*$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			   <root> 
				<acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>			
				</acceso> 
				<solicitud> 
				 <tipo>1</tipo> 
				 <procesoid>38</procesoid> 
				</solicitud> 
				<variables> 
				 <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
				 <CONSECUTIVOREMESA>{$CONSECUTIVOINFORMACIONCARGA}</CONSECUTIVOREMESA> 
				 <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE> 
				 <CODTIPOEMPAQUE>{$CODTIPOEMPAQUE}</CODTIPOEMPAQUE> 
				 <CODNATURALEZACARGA>{$CODNATURALEZACARGA}</CODNATURALEZACARGA> 
				 <DESCRIPCIONCORTAPRODUCTO>{$DESCRIPCIONCORTAPRODUCTO}</DESCRIPCIONCORTAPRODUCTO> 
				 {$MERCANCIAINFORMACIONCARGA}
				 {$CANTIDADINFORMACIONCARGA}
				 {$UNIDADMEDIDACAPACIDAD}
				 <CODTIPOIDREMITENTE>{$CODTIPOIDREMITENTE}</CODTIPOIDREMITENTE> 
				 <NUMIDREMITENTE>{$NUMIDREMITENTE}</NUMIDREMITENTE> 
                 {$CODSEDEREMITENTE}
				 <CODTIPOIDDESTINATARIO>{$CODTIPOIDDESTINATARIO}</CODTIPOIDDESTINATARIO> 
				 <NUMIDDESTINATARIO>{$NUMIDDESTINATARIO}</NUMIDDESTINATARIO> 
				 {$CODSEDEDESTINATARIO}
				 <HORASPACTOCARGA>12</HORASPACTOCARGA>
				 <MINUTOSPACTOCARGA>0</MINUTOSPACTOCARGA>
				 <HORASPACTODESCARGUE>12</HORASPACTODESCARGUE>
				 <MINUTOSPACTODESCARGUE>0</MINUTOSPACTODESCARGUE>
 				 <FECHACITAPACTADACARGUE>{$FECHACITAPACTADACARGUE}</FECHACITAPACTADACARGUE>
				 <HORACITAPACTADACARGUE>{$HORACITAPACTADACARGUE}</HORACITAPACTADACARGUE>

				</variables>
			 </root>";
	
			$path_xml = "{$this -> ruta_archivos}info_carga_{$data[numero_remesa]}.xml";*/
			$manifiesto_id = $Model -> getManifiestoIdRemesa($remesa_id,$this ->Conex);
			$xml_remesas = $this -> setcorreccionXMLRemesas($manifiesto_id);
			
			$path_xml = "{$this -> ruta_archivos}remesa_{$data[numero_remesa]}.xml";
			$msj = file_get_contents($path_xml);
		}else{
		   $msj = file_get_contents($path_xml);
		  }
		//echo $msj.'**';
		/*$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);*/	
		
		$aParametros = array("Request" => $msj); 
		$this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		//echo ('si'.$respuesta.'no');				
			if ($respuesta=='') { 
			
			 $respuesta = "No se pudo completar la operaci&oacute;n";
			 $Model -> setErrorReporteInformacionCarga($path_xml,$numero_remesa,$respuesta,$this -> Conex);
			 
			} else { 
			
			  $sError ='';
			
			  if ($sError!='') { 
			  
			    $respuesta = 'Error:'. $sError;
			    $Model -> setErrorReporteInformacionCarga($path_xml,$numero_remesa,$respuesta,$this -> Conex);								
				
			  }else{
			  
				   if(preg_match("/ingresoid/i","$respuesta")){
	
					 require_once($_SERVER['DOCUMENT_ROOT']."/chiquinquira/framework/clases/xml2array.php");
					 
					 $contenido = $respuesta;
					 $resultado = xml2array($contenido);			   
					 $ingresoid = $resultado['root']['ingresoid'];
					 
					 $Model -> setCorreccionAprobacionInformacionCarga($path_xml,$numero_remesa,$ingresoid,$this -> Conex);
					 
					 if($printMsj)echo "<div id='message'>Reportado Exitosamente</div>";
					 				   
				   }else{			   
				   					  
					  $Model -> setErrorReporteInformacionCarga($path_xml,$numero_remesa,$respuesta,$this -> Conex);
					  
					  if(preg_match("/ya fue registrado/i","$respuesta")){
					   $ingresoid = 0;
					   $Model -> setAprobacionInformacionCarga($path_xml,$numero_remesa,$ingresoid,$this -> Conex);
                       $respuesta = 'Reportado Exitosamente';
                      }
					  
					
												 
				   }										 						
							
				}
			
			} 			
	
	       if($printMsj)echo '<div id="message">'.$respuesta.'</div>'; 

	}
	
	 //CORRECCION REMESAS
	
	      public function setcorreccionXMLRemesas($manifiesto_id){ 
	  
		 $Model                       = new WebServiceMinTransporteModel();		   	
		 $data                        = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> Conex);
		 $xmlArray                    = array();

		 for($i = 0; $i < count($data); $i++){
	
			 $remesa_id                   = $data[$i]['remesa_id'];		
			 $peso                        = $data[$i]['peso'];		  
			 $CONSECUTIVOREMESA           = $data[$i]['numero_remesa'];
			 //$CONSECUTIVOINFORMACIONCARGA = $data[$i]['numero_remesa'];
			 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss'])); 
			 $HORACITAPACTADACARGUE       = $data[$i]['hora_recogida_ss']; 
			 $CODOPERACIONTRANSPORTE      = $Model -> getCodTipoRemesa($data[$i]['tipo_remesa_id'],$this -> Conex);
			 $CODTIPOEMPAQUE              = $data[$i]['empaque_id'];
			 $NATURALEZACARGA             = $data[$i]['naturaleza_id'];
			 $DESCRIPCIONCORTAPRODUCTO    = substr($data[$i]['descripcion_producto'],0,50);
			 $MERCANCIAINFORMACIONCARGA   = $Model -> getCodProducto($data[$i]['producto_id'],$this -> Conex);
			 $CANTIDADINFORMACIONCARGA    = $data[$i]['peso'];//antes estaba cantidad
			 $UNIDADMEDIDACAPACIDAD       = $Model -> getCodUnidadMedida($data[$i]['medida_id'],$this -> Conex);
			 $UNIDADMEDIDACAPACIDAD       = $UNIDADMEDIDACAPACIDAD==3 ? 1 : $UNIDADMEDIDACAPACIDAD;
			 
			 $REMCIUDAD_ORIG			  = $data[$i]['origen_id'];
 			 $REMCIUDAD_DESTI			  = $data[$i]['destino_id'];
			 
			 
             $NUMIDPROPIETARIO            = $Model -> getNumeroIdentificacionPropietario($data[$i]['propietario_mercancia_id'],$this -> Conex);
 			 $CODSEDEPROPIETARIO          = $Model -> getCodSedePropietario($data[$i]['propietario_mercancia_id'], $this -> Conex);
             $CODTIPOIDPROPIETARIO        = $Model -> getCodTipoIdentificacionPropietario($data[$i]['propietario_mercancia_id'],
			                                $this -> Conex);														 
			 
			 $CODTIPOIDREMITENTE          = $Model -> getCodTipoIdentificacion($data[$i]['tipo_identificacion_remitente_id'],$this -> Conex);
			 $REMREMITENTE                = $Model -> getDocRemitenteDestinatario($data[$i]['remitente_id'],$this -> Conex);
			 $REMDIRREMITENTE             = $data[$i]['direccion_remitente'];
			 $CODSEDEREMITENTE            = $data[$i]['remitente_id'];
			 
			 $CODTIPOIDDESTINATARIO       = $Model -> getCodTipoIdentificacion($data[$i]['tipo_identificacion_destinatario_id'],$this -> Conex);
			 $CODSEDEDESTINATARIO         = $data[$i]['destinatario_id'];
			 $REMDESTINATARIO             = $Model -> getDocRemitenteDestinatario($data[$i]['destinatario_id'],$this -> Conex);
			 
			 $REMCIUDAD_ORIG                    = $data[$i]['origen_id'];
			 $REMCIUDAD_DESTI                   = $data[$i]['destino_id'];
			 
			 $PACTOTIEMPOCARGUE           = 'NO';
			 $PACTOTIEMPODESCARGUE        = 'NO';
			 $OBSERVACIONES               = $data[$i]['observaciones'];
			 
			 $DUENOPOLIZA                 = $data[$i]['amparada_por'];
			 $NUMPOLIZATRANSPORTE         = $data[$i]['numero_poliza'];
			 $FECHAVENCIMIENTOPOLIZACARGA = date("d/m/Y",strtotime($data[$i]['fecha_vencimiento_poliza']));
			 $COMPANIASEGURO              = $Model -> getNitAseguradora($data[$i]['aseguradora_id'],$this -> Conex);

			 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss']));
			 $HORACITAPACTADACARGUE       = substr($data[$i]['hora_recogida_ss'],0,5);


			 $FECHACITAPACTADADESCARGUE=date("d/m/Y",strtotime($Model -> getFechaCitadaDescargue($manifiesto_id,$this -> Conex)));
			 $HORACITAPACTADADESCARGUEREMESA = substr($Model -> getHoraCitadaDescargue($manifiesto_id,$this -> Conex),0,5);

			 $FECHALLEGADACARGUE          = $data[$i]['fecha_llegada_cargue']!='' ? date("d/m/Y",strtotime($data[$i]['fecha_llegada_cargue'])) : date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss'])); 
			 $HORALLEGADACARGUEREMESA     = substr($data[$i]['hora_llegada_cargue'],0,5)!='' ? substr($data[$i]['hora_llegada_cargue'],0,5) : substr($data[$i]['hora_recogida_ss'],0,5);
			 $FECHAENTRADACARGUE          = $data[$i]['fecha_entrada_cargue']!='' ? date("d/m/Y",strtotime($data[$i]['fecha_entrada_cargue'])) : date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss']));
			 $HORAENTRADACARGUEREMESA     = substr($data[$i]['hora_entrada_cargue'],0,5)!='' ? substr($data[$i]['hora_entrada_cargue'],0,5) : substr($data[$i]['hora_recogida_ss'],0,5);
			 $FECHASALIDACARGUE           = $data[$i]['fecha_salida_cargue']!='' ? date("d/m/Y",strtotime($data[$i]['fecha_salida_cargue'])) : date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss']));
			 $HORASALIDACARGUEREMESA      = substr($data[$i]['hora_salida_cargue'],0,5)!='' ? substr($data[$i]['hora_salida_cargue'],0,5) : substr($data[$i]['hora_recogida_ss'],0,5);
			
			 if($CODOPERACIONTRANSPORTE == 'V'){
			   $MERCANCIAREMESA           = '<MERCANCIAREMESA>009990</MERCANCIAREMESA>';
			   $DESCRIPCIONCORTAPRODUCTO  = '<DESCRIPCIONCORTAPRODUCTO>CONTENEDOR VACIO</DESCRIPCIONCORTAPRODUCTO>';
			   $CANTIDADCARGADA           = NULL;
			   $UNIDADMEDIDACAPACIDAD     = NULL;
			 }else if($CODOPERACIONTRANSPORTE == 'P'){
				 $MERCANCIAREMESA           = '<MERCANCIAREMESA>009880</MERCANCIAREMESA>';
				 $DESCRIPCIONCORTAPRODUCTO  = '<DESCRIPCIONCORTAPRODUCTO>PAQUETES VARIOS</DESCRIPCIONCORTAPRODUCTO>';
				 $CANTIDADCARGADA           = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";			 
			   }else{
				 $MERCANCIAREMESA           = "<MERCANCIAREMESA>{$MERCANCIAINFORMACIONCARGA}</MERCANCIAREMESA>";
				 $DESCRIPCIONCORTAPRODUCTO  = "<DESCRIPCIONCORTAPRODUCTO>{$DESCRIPCIONCORTAPRODUCTO}</DESCRIPCIONCORTAPRODUCTO>";				 
				 $CANTIDADCARGADA           = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";			 		
				 }	
			   
			   
			 if($CODOPERACIONTRANSPORTE == 'C' || $CODOPERACIONTRANSPORTE == 'V'){  
			   $PESOCONTENEDORVACIO	= "<PESOCONTENEDORVACIO>{$peso}</PESOCONTENEDORVACIO>";		      		   
			 }else{
				 $PESOCONTENEDORVACIO = NULL;		      		   
			   }
			   
			   
			 if($CODTIPOIDPROPIETARIO != 'N'){
			   //$CODSEDEPROPIETARIO = 0;
			 } 
			 
			 if($CODTIPOIDREMITENTE != 'N'){
			   //$CODSEDEREMITENTE = 0;
			 }
			 
			 if($CODTIPOIDDESTINATARIO != 'N'){
			   //$CODSEDEDESTINATARIO = 0;
			 }
			 
			 if($FECHASALIDACARGUE > $FECHACITAPACTADADESCARGUE){
			   $FECHACITAPACTADADESCARGUE = $FECHASALIDACARGUE;
			 }
			   
		   $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			  <root> 
				<acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>			
				</acceso> 
				
				<solicitud> 
				 <tipo>1</tipo> 
				 <procesoid>38</procesoid> 
				</solicitud> 
				
				<variables> 
				 <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
				 <CONSECUTIVOREMESA>{$CONSECUTIVOREMESA}</CONSECUTIVOREMESA>
 				 <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE>
				 <CODNATURALEZACARGA>$NATURALEZACARGA</CODNATURALEZACARGA>
				 <CODTIPOEMPAQUE>$CODTIPOEMPAQUE</CODTIPOEMPAQUE>
 				 $MERCANCIAREMESA
				 $DESCRIPCIONCORTAPRODUCTO
				 $UNIDADMEDIDACAPACIDAD
				 {$CANTIDADCARGADA}
				  $PESOCONTENEDORVACIO

             	 <NUMIDPROPIETARIO>$NUMIDPROPIETARIO</NUMIDPROPIETARIO>
				 <CODSEDEPROPIETARIO>$CODSEDEPROPIETARIO</CODSEDEPROPIETARIO>
				 <CODTIPOIDPROPIETARIO>$CODTIPOIDPROPIETARIO</CODTIPOIDPROPIETARIO>				 
             	 <NUMIDREMITENTE>$REMREMITENTE</NUMIDREMITENTE>
				 <CODSEDEREMITENTE>$CODSEDEREMITENTE</CODSEDEREMITENTE>	
				 <CODTIPOIDREMITENTE>$CODTIPOIDREMITENTE</CODTIPOIDREMITENTE>	
 				 <CODTIPOIDDESTINATARIO>$CODTIPOIDDESTINATARIO</CODTIPOIDDESTINATARIO>
				 <CODSEDEDESTINATARIO>$CODSEDEDESTINATARIO</CODSEDEDESTINATARIO>	
				 <NUMIDDESTINATARIO>$REMDESTINATARIO</NUMIDDESTINATARIO>
				 <FECHACITAPACTADACARGUE>$FECHACITAPACTADACARGUE</FECHACITAPACTADACARGUE>
				 <HORACITAPACTADACARGUE>$HORACITAPACTADACARGUE</HORACITAPACTADACARGUE>
				 <HORASPACTODESCARGUE>8</HORASPACTODESCARGUE>	
				 <HORASPACTOCARGA>10</HORASPACTOCARGA>
				 <FECHACITAPACTADADESCARGUE>$FECHACITAPACTADADESCARGUE</FECHACITAPACTADADESCARGUE>
				 <HORACITAPACTADADESCARGUE>$HORACITAPACTADADESCARGUEREMESA</HORACITAPACTADADESCARGUE>

				 <DUENOPOLIZA>{$DUENOPOLIZA}</DUENOPOLIZA>
				 <NUMPOLIZATRANSPORTE>{$NUMPOLIZATRANSPORTE}</NUMPOLIZATRANSPORTE> 	
				 <FECHAVENCIMIENTOPOLIZA>{$FECHAVENCIMIENTOPOLIZACARGA}</FECHAVENCIMIENTOPOLIZA> 	
				 <COMPANIASEGURO>{$COMPANIASEGURO}</COMPANIASEGURO> 
			     <FECHALLEGADACARGUE>{$FECHALLEGADACARGUE}</FECHALLEGADACARGUE>
			     <HORALLEGADACARGUE>{$HORALLEGADACARGUEREMESA}</HORALLEGADACARGUE>
			     <FECHAENTRADACARGUE>{$FECHAENTRADACARGUE}</FECHAENTRADACARGUE>
			     <HORAENTRADACARGUE>{$HORAENTRADACARGUEREMESA}</HORAENTRADACARGUE>
			     <FECHASALIDACARGUE>{$FECHASALIDACARGUE}</FECHASALIDACARGUE>
			     <HORASALIDACARGUE>{$HORASALIDACARGUEREMESA}</HORASALIDACARGUE>
				</variables> 
			   </root>";
					
			   //echo $msj.'ss';
			   $pathXML  = "{$this -> ruta_archivos}remesa_{$CONSECUTIVOREMESA}.xml";
			   $fp       = fopen($pathXML, 'w');
			   fwrite($fp,"$msj");
			   fclose($fp);
			   
			   $xmlArray[$i]['xml']                      = $msj;
			   $xmlArray[$i]['numero_remesa']            = $CONSECUTIVOREMESA;			   
   			   $xmlArray[$i]['remesa_id']                = $remesa_id;	
   			   $xmlArray[$i]['propietario_mercancia_id'] = $data[$i]['propietario_mercancia_id'];	
			   
		       $Model -> setPathXMLRemesa($manifiesto_id,$remesa_id,$pathXML,$this -> Conex);		   
			   
		   }
		   	//print_r($xmlArray);	   
		   return $xmlArray;		   		
	  
	  }
	
	
	//CREACION INFORMACION DE VIAJE 7.4.1 FINAL SE VALIDA CUANDO SE ENVIA INFORMACION DE CARGA Y SE ENVIA INMEDIATO REMESAS Y MANIFIESTO
	  
      public function setXMLRemesas($manifiesto_id){ 
	  
		 $Model                       = new WebServiceMinTransporteModel();		   	
		 $data                        = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> Conex);
		 $xmlArray                    = array();

		 for($i = 0; $i < count($data); $i++){
	
			 $remesa_id                   = $data[$i]['remesa_id'];		
			 $peso                        = $data[$i]['peso'];		  
			 $CONSECUTIVOREMESA           = $data[$i]['numero_remesa'];
			 //$CONSECUTIVOINFORMACIONCARGA = $data[$i]['numero_remesa'];
			 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss'])); 
			 $HORACITAPACTADACARGUE       = $data[$i]['hora_recogida_ss']; 
			 $CODOPERACIONTRANSPORTE      = $Model -> getCodTipoRemesa($data[$i]['tipo_remesa_id'],$this -> Conex);
			 $CODTIPOEMPAQUE              = $data[$i]['empaque_id'];
			 $NATURALEZACARGA             = $data[$i]['naturaleza_id'];
			 $DESCRIPCIONCORTAPRODUCTO    = substr($data[$i]['descripcion_producto'],0,50);
			 $MERCANCIAINFORMACIONCARGA   = $Model -> getCodProducto($data[$i]['producto_id'],$this -> Conex);
			 $CANTIDADINFORMACIONCARGA    = $data[$i]['peso'];//antes estaba cantidad
			 $UNIDADMEDIDACAPACIDAD       = $Model -> getCodUnidadMedida($data[$i]['medida_id'],$this -> Conex);
			 $UNIDADMEDIDACAPACIDAD       = $UNIDADMEDIDACAPACIDAD==3 ? 1 : $UNIDADMEDIDACAPACIDAD;
			 
			 $REMCIUDAD_ORIG			  = $data[$i]['origen_id'];
 			 $REMCIUDAD_DESTI			  = $data[$i]['destino_id'];
			 
			 
             $NUMIDPROPIETARIO            = $Model -> getNumeroIdentificacionPropietario($data[$i]['propietario_mercancia_id'],$this -> Conex);
 			 $CODSEDEPROPIETARIO          = $Model -> getCodSedePropietario($data[$i]['propietario_mercancia_id'], $this -> Conex);
             $CODTIPOIDPROPIETARIO        = $Model -> getCodTipoIdentificacionPropietario($data[$i]['propietario_mercancia_id'],
			                                $this -> Conex);														 
			 
			 $CODTIPOIDREMITENTE          = $Model -> getCodTipoIdentificacion($data[$i]['tipo_identificacion_remitente_id'],$this -> Conex);
			 $REMREMITENTE                = $Model -> getDocRemitenteDestinatario($data[$i]['remitente_id'],$this -> Conex);
			 $REMDIRREMITENTE             = $data[$i]['direccion_remitente'];
			 $CODSEDEREMITENTE            = $data[$i]['remitente_id'];
			 
			 $CODTIPOIDDESTINATARIO       = $Model -> getCodTipoIdentificacion($data[$i]['tipo_identificacion_destinatario_id'],$this -> Conex);
			 $CODSEDEDESTINATARIO         = $data[$i]['destinatario_id'];
			 $REMDESTINATARIO             = $Model -> getDocRemitenteDestinatario($data[$i]['destinatario_id'],$this -> Conex);
			 
			 $REMCIUDAD_ORIG                    = $data[$i]['origen_id'];
			 $REMCIUDAD_DESTI                   = $data[$i]['destino_id'];
			 
			 $PACTOTIEMPOCARGUE           = 'NO';
			 $PACTOTIEMPODESCARGUE        = 'NO';
			 $OBSERVACIONES               = $data[$i]['observaciones'];
			 
			 $DUENOPOLIZA                 = $data[$i]['amparada_por'];
			 $NUMPOLIZATRANSPORTE         = $data[$i]['numero_poliza'];
			 $FECHAVENCIMIENTOPOLIZACARGA = date("d/m/Y",strtotime($data[$i]['fecha_vencimiento_poliza']));
			 $COMPANIASEGURO              = $Model -> getNitAseguradora($data[$i]['aseguradora_id'],$this -> Conex);

			 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss']));
			 $HORACITAPACTADACARGUE       = substr($data[$i]['hora_recogida_ss'],0,5);


			 $FECHACITAPACTADADESCARGUE=date("d/m/Y",strtotime($Model -> getFechaCitadaDescargue($manifiesto_id,$this -> Conex)));
			 $HORACITAPACTADADESCARGUEREMESA = substr($Model -> getHoraCitadaDescargue($manifiesto_id,$this -> Conex),0,5);

			 $FECHALLEGADACARGUE          = $data[$i]['fecha_llegada_cargue']!='' ? date("d/m/Y",strtotime($data[$i]['fecha_llegada_cargue'])) : date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss'])); 
			 $HORALLEGADACARGUEREMESA     = substr($data[$i]['hora_llegada_cargue'],0,5)!='' ? substr($data[$i]['hora_llegada_cargue'],0,5) : substr($data[$i]['hora_recogida_ss'],0,5);
			 $FECHAENTRADACARGUE          = $data[$i]['fecha_entrada_cargue']!='' ? date("d/m/Y",strtotime($data[$i]['fecha_entrada_cargue'])) : date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss']));
			 $HORAENTRADACARGUEREMESA     = substr($data[$i]['hora_entrada_cargue'],0,5)!='' ? substr($data[$i]['hora_entrada_cargue'],0,5) : substr($data[$i]['hora_recogida_ss'],0,5);
			 $FECHASALIDACARGUE           = $data[$i]['fecha_salida_cargue']!='' ? date("d/m/Y",strtotime($data[$i]['fecha_salida_cargue'])) : date("d/m/Y",strtotime($data[$i]['fecha_recogida_ss']));
			 $HORASALIDACARGUEREMESA      = substr($data[$i]['hora_salida_cargue'],0,5)!='' ? substr($data[$i]['hora_salida_cargue'],0,5) : substr($data[$i]['hora_recogida_ss'],0,5);
			
			 if($CODOPERACIONTRANSPORTE == 'V'){
			   $MERCANCIAREMESA           = '<MERCANCIAREMESA>009990</MERCANCIAREMESA>';
			   $DESCRIPCIONCORTAPRODUCTO  = '<DESCRIPCIONCORTAPRODUCTO>CONTENEDOR VACIO</DESCRIPCIONCORTAPRODUCTO>';
			   $CANTIDADCARGADA           = NULL;
			   $UNIDADMEDIDACAPACIDAD     = NULL;
			 }else if($CODOPERACIONTRANSPORTE == 'P'){
				 $MERCANCIAREMESA           = '<MERCANCIAREMESA>009880</MERCANCIAREMESA>';
				 $DESCRIPCIONCORTAPRODUCTO  = '<DESCRIPCIONCORTAPRODUCTO>PAQUETES VARIOS</DESCRIPCIONCORTAPRODUCTO>';
				 $CANTIDADCARGADA           = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";			 
			   }else{
				 $MERCANCIAREMESA           = "<MERCANCIAREMESA>{$MERCANCIAINFORMACIONCARGA}</MERCANCIAREMESA>";
				 $DESCRIPCIONCORTAPRODUCTO  = "<DESCRIPCIONCORTAPRODUCTO>{$DESCRIPCIONCORTAPRODUCTO}</DESCRIPCIONCORTAPRODUCTO>";				 
				 $CANTIDADCARGADA           = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
				 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";			 		
				 }	
			   
			   
			 if($CODOPERACIONTRANSPORTE == 'C' || $CODOPERACIONTRANSPORTE == 'V'){  
			   $PESOCONTENEDORVACIO	= "<PESOCONTENEDORVACIO>{$peso}</PESOCONTENEDORVACIO>";		      		   
			 }else{
				 $PESOCONTENEDORVACIO = NULL;		      		   
			   }
			   
			   
			 if($CODTIPOIDPROPIETARIO != 'N'){
			   //$CODSEDEPROPIETARIO = 0;
			 } 
			 
			 if($CODTIPOIDREMITENTE != 'N'){
			   //$CODSEDEREMITENTE = 0;
			 }
			 
			 if($CODTIPOIDDESTINATARIO != 'N'){
			   //$CODSEDEDESTINATARIO = 0;
			 }
			 
			 if($FECHASALIDACARGUE > $FECHACITAPACTADADESCARGUE){
			   $FECHACITAPACTADADESCARGUE = $FECHASALIDACARGUE;
			 }
			   
		   $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			  <root> 
				<acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>			
				</acceso> 
				
				<solicitud> 
				 <tipo>1</tipo> 
				 <procesoid>3</procesoid> 
				</solicitud> 
				
				<variables> 
				 <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
				 <CONSECUTIVOREMESA>{$CONSECUTIVOREMESA}</CONSECUTIVOREMESA>
 				 <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE>
				 <CODNATURALEZACARGA>$NATURALEZACARGA</CODNATURALEZACARGA>
				 <CODTIPOEMPAQUE>$CODTIPOEMPAQUE</CODTIPOEMPAQUE>
 				 $MERCANCIAREMESA
				 $DESCRIPCIONCORTAPRODUCTO
				 $UNIDADMEDIDACAPACIDAD
				 {$CANTIDADCARGADA}
				 $PESOCONTENEDORVACIO				 

             	 <REMCIUDAD_ORIG>$REMCIUDAD_ORIG</REMCIUDAD_ORIG>
             	 <REMCIUDAD_DESTI>$REMCIUDAD_DESTI</REMCIUDAD_DESTI>

             	 <NUMIDPROPIETARIO>$NUMIDPROPIETARIO</NUMIDPROPIETARIO>
				 <CODSEDEPROPIETARIO>$CODSEDEPROPIETARIO</CODSEDEPROPIETARIO>
				 <CODTIPOIDPROPIETARIO>$CODTIPOIDPROPIETARIO</CODTIPOIDPROPIETARIO>				 
             	 <NUMIDREMITENTE>$REMREMITENTE</NUMIDREMITENTE>
				 <CODSEDEREMITENTE>$CODSEDEREMITENTE</CODSEDEREMITENTE>	
				 <CODTIPOIDREMITENTE>$CODTIPOIDREMITENTE</CODTIPOIDREMITENTE>	
 				 <CODTIPOIDDESTINATARIO>$CODTIPOIDDESTINATARIO</CODTIPOIDDESTINATARIO>
				 <CODSEDEDESTINATARIO>$CODSEDEDESTINATARIO</CODSEDEDESTINATARIO>	
				 <NUMIDDESTINATARIO>$REMDESTINATARIO</NUMIDDESTINATARIO>
				 <FECHACITAPACTADACARGUE>$FECHACITAPACTADACARGUE</FECHACITAPACTADACARGUE>
				 <HORACITAPACTADACARGUE>$HORACITAPACTADACARGUE</HORACITAPACTADACARGUE>
				 <HORASPACTODESCARGUE>8</HORASPACTODESCARGUE>	
				 <HORASPACTOCARGA>10</HORASPACTOCARGA>
				 <FECHACITAPACTADADESCARGUE>$FECHACITAPACTADADESCARGUE</FECHACITAPACTADADESCARGUE>
				 <HORACITAPACTADADESCARGUEREMESA>$HORACITAPACTADADESCARGUEREMESA</HORACITAPACTADADESCARGUEREMESA>

				 <DUENOPOLIZA>{$DUENOPOLIZA}</DUENOPOLIZA>
				 <NUMPOLIZATRANSPORTE>{$NUMPOLIZATRANSPORTE}</NUMPOLIZATRANSPORTE> 	
				 <FECHAVENCIMIENTOPOLIZACARGA>{$FECHAVENCIMIENTOPOLIZACARGA}</FECHAVENCIMIENTOPOLIZACARGA> 	
				 <COMPANIASEGURO>{$COMPANIASEGURO}</COMPANIASEGURO> 
			     <FECHALLEGADACARGUE>{$FECHALLEGADACARGUE}</FECHALLEGADACARGUE>
			     <HORALLEGADACARGUEREMESA>{$HORALLEGADACARGUEREMESA}</HORALLEGADACARGUEREMESA>
			     <FECHAENTRADACARGUE>{$FECHAENTRADACARGUE}</FECHAENTRADACARGUE>
			     <HORAENTRADACARGUEREMESA>{$HORAENTRADACARGUEREMESA}</HORAENTRADACARGUEREMESA>
			     <FECHASALIDACARGUE>{$FECHASALIDACARGUE}</FECHASALIDACARGUE>
			     <HORASALIDACARGUEREMESA>{$HORASALIDACARGUEREMESA}</HORASALIDACARGUEREMESA>
				</variables> 
			   </root>";
					
			   //echo $msj.'ss';
			   $pathXML  = "{$this -> ruta_archivos}remesa_{$CONSECUTIVOREMESA}.xml";
			   $fp       = fopen($pathXML, 'w');
			   fwrite($fp,"$msj");
			   fclose($fp);
			   
			   $xmlArray[$i]['xml']                      = $msj;
			   $xmlArray[$i]['numero_remesa']            = $CONSECUTIVOREMESA;			   
   			   $xmlArray[$i]['remesa_id']                = $remesa_id;	
   			   $xmlArray[$i]['propietario_mercancia_id'] = $data[$i]['propietario_mercancia_id'];	
			   
		       $Model -> setPathXMLRemesa($manifiesto_id,$remesa_id,$pathXML,$this -> Conex);		   
			   
		   }
		   		   
		   return $xmlArray;		   		
	  
	  } 
	  
	  
	  public function setXMLManifiesto($manifiesto_id,$informacion_viaje){
	  
         require_once("WebServiceMinTranporteModelClass.php");	 	  
				
         $Model                         = new WebServiceMinTransporteModel();	
		 $dataManifiesto                = $Model -> selectManifiesto($manifiesto_id,$this -> Conex);
		 $dataRemesas                   = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> Conex);	
		 $placa_id                      = $dataManifiesto[0]['placa_id']; 
		 
	     $NUMMANIFIESTOCARGA            = $dataManifiesto[0]['manifiesto'];
	     $CONSECUTIVOINFORMACIONVIAJE   = $informacion_viaje;
		 $NUMPLACA                      = $dataManifiesto[0]['placa'];
		 $NUMPLACAREMOLQUE              = $dataManifiesto[0]['placa_remolque'];
		 $CODIDCONDUCTOR                = $Model->getCodTipoIdentificacionConductorManifiesto($dataManifiesto[0]['conductor_id'],$this-> Conex);
		 $NUMIDCONDUCTOR                = $dataManifiesto[0]['numero_identificacion'];

		 $CODIDTENEDOR                = $Model->getCodTipoIdentificacionTenedorManifiesto($dataManifiesto[0]['tenedor_id'],$this-> Conex);
		 $NUMIDTENEDOR                = $dataManifiesto[0]['numero_identificacion_tenedor'];

	     $CODOPERACIONTRANSPORTE        = $Model -> getCodTipoManifiesto($dataManifiesto[0]['tipo_manifiesto_id'],$this -> Conex);
	  	 if($CODOPERACIONTRANSPORTE=='C') $CODOPERACIONTRANSPORTE='Y';
	     $FECHAEXPEDICIONMANIFIESTO     = date("d/m/Y",strtotime($dataManifiesto[0]['fecha_mc']));
	     $CODMUNICIPIOORIGENMANIFIESTO  = str_pad($dataManifiesto[0]['origen_id'],8, "0", STR_PAD_LEFT);
	     $CODMUNICIPIODESTINOMANIFIESTO = str_pad($dataManifiesto[0]['destino_id'],8, "0", STR_PAD_LEFT);
	     $CODIDTITULARMANIFIESTO        = $Model->getCodTipoIdentificacionTitularManifiesto($dataManifiesto[0]['titular_manifiesto_id'],$this-> Conex);
	     $NUMIDTITULARMANIFIESTO        =  $Model->getNumeroIdentificacionTitular($dataManifiesto[0]['titular_manifiesto_id'],$this-> Conex);
		 $VALORFLETEPACTADOVIAJE        = $dataManifiesto[0]['valor_flete'];
	     $RETENCIONICAMANIFIESTOCARGA   = $Model -> getRetencionicaManifiesto($manifiesto_id,$this -> Conex);
	     $VALORANTICIPOMANIFIESTO       = $Model -> getAnticipoManifiesto($manifiesto_id,$this -> Conex);
	     $CODMUNICIPIOPAGOSALDO         = $Model -> getCodCiudadPagoSaldo($manifiesto_id,$this -> Conex);
	     $FECHAPAGOSALDOMANIFIESTO      = date("d/m/Y",strtotime($dataManifiesto[0]['fecha_pago_saldo']));

	     $CODRESPONSABLEPAGOCARGUE      = $dataManifiesto[0]['cargue_pagado_por']!='' ? $dataManifiesto[0]['cargue_pagado_por'] : 'E';
	     $CODRESPONSABLEPAGODESCARGUE   = $dataManifiesto[0]['descargue_pagado_por']!='' ?  $dataManifiesto[0]['descargue_pagado_por'] : 'E';
	     $OBSERVACIONES                 = $dataManifiesto[0]['observaciones'];	
		 $remesas                       = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> Conex);	 		 


		 $RemesasMan = "<REMESASMAN procesoid='43'>";
					  
		 for($i = 0; $i < count($dataRemesas); $i++){
	
		   $numero_remesa = $dataRemesas[$i]['numero_remesa'];
		   $RemesasMan   .= "<REMESA><CONSECUTIVOREMESA>{$numero_remesa}</CONSECUTIVOREMESA></REMESA>"; 
		  
		 }
		 
		 if($Model -> vehiculoEsdelaTransportadora($this -> numnitempresatransporte,$placa_id,$this -> Conex)){
		   $VALORFLETEPACTADOVIAJE      = '<VALORFLETEPACTADOVIAJE>0</VALORFLETEPACTADOVIAJE>';
		   $RETENCIONICAMANIFIESTOCARGA = ''; 
		   $VALORANTICIPOMANIFIESTO     = ''; 
		   $CODMUNICIPIOPAGOSALDO       = ''; 
		   $FECHAPAGOSALDOMANIFIESTO    = ''; 	 
		 }else{
		    $VALORFLETEPACTADOVIAJE      = "<VALORFLETEPACTADOVIAJE>{$VALORFLETEPACTADOVIAJE}</VALORFLETEPACTADOVIAJE>";
		    $RETENCIONICAMANIFIESTOCARGA = "<RETENCIONICAMANIFIESTOCARGA>{$RETENCIONICAMANIFIESTOCARGA}</RETENCIONICAMANIFIESTOCARGA>"; 
			if($VALORANTICIPOMANIFIESTO>0){  
				$VALORANTICIPOMANIFIESTO  = "<VALORANTICIPOMANIFIESTO>{$VALORANTICIPOMANIFIESTO}</VALORANTICIPOMANIFIESTO>"; 
			}else{
				$VALORANTICIPOMANIFIESTO  = "<VALORANTICIPOMANIFIESTO>0</VALORANTICIPOMANIFIESTO>"; 
			}
		    $CODMUNICIPIOPAGOSALDO    = "<CODMUNICIPIOPAGOSALDO>{$CODMUNICIPIOPAGOSALDO}</CODMUNICIPIOPAGOSALDO>"; 
		    $FECHAPAGOSALDOMANIFIESTO = "<FECHAPAGOSALDOMANIFIESTO>{$FECHAPAGOSALDOMANIFIESTO}</FECHAPAGOSALDOMANIFIESTO>"; 
		   }
		   
		 if($Model -> esVehiculoRigido($placa_id,$this -> Conex)){
		  $NUMPLACAREMOLQUE = NULL;
		 }elseif($NUMPLACAREMOLQUE == 'NULL' || !strlen(trim($NUMPLACAREMOLQUE)) > 0){
		    $NUMPLACAREMOLQUE = NULL;
		 }else{
		   $NUMPLACAREMOLQUE = "<NUMPLACAREMOLQUE>{$NUMPLACAREMOLQUE}</NUMPLACAREMOLQUE>";
		 }
		  		  
		 $RemesasMan .= "</REMESASMAN>";	     
	  
	     $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
		 <root> 
		  <acceso> 
			 <username>{$this -> username}</username> 
			 <password>{$this -> password}</password> 
			 <ambiente>{$this -> ambiente}</ambiente>	
		  </acceso> 
		  
		  <solicitud> 
		   <tipo>1</tipo> 
		   <procesoid>4</procesoid> 
		  </solicitud> 
		  
		  <variables> 
		   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
		   <NUMMANIFIESTOCARGA>{$NUMMANIFIESTOCARGA}</NUMMANIFIESTOCARGA> 
		   <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE> 
		   <FECHAEXPEDICIONMANIFIESTO>{$FECHAEXPEDICIONMANIFIESTO}</FECHAEXPEDICIONMANIFIESTO> 
		   <CODMUNICIPIOORIGENMANIFIESTO>{$CODMUNICIPIOORIGENMANIFIESTO}</CODMUNICIPIOORIGENMANIFIESTO> 
		   <CODMUNICIPIODESTINOMANIFIESTO>{$CODMUNICIPIODESTINOMANIFIESTO}</CODMUNICIPIODESTINOMANIFIESTO>
		   <CODIDTITULARMANIFIESTO>{$CODIDTITULARMANIFIESTO}</CODIDTITULARMANIFIESTO> 
		   <NUMIDTITULARMANIFIESTO>{$NUMIDTITULARMANIFIESTO}</NUMIDTITULARMANIFIESTO> 
		   
   		   <NUMPLACA>{$NUMPLACA}</NUMPLACA> 
   		   <CODIDCONDUCTOR>{$CODIDCONDUCTOR}</CODIDCONDUCTOR>
   		   <NUMIDCONDUCTOR>{$NUMIDCONDUCTOR}</NUMIDCONDUCTOR>		   

		   $NUMPLACAREMOLQUE
		   {$VALORFLETEPACTADOVIAJE}
		   {$RETENCIONICAMANIFIESTOCARGA}
		   {$VALORANTICIPOMANIFIESTO}
		   {$CODMUNICIPIOPAGOSALDO}
		   {$FECHAPAGOSALDOMANIFIESTO}
		   <CODRESPONSABLEPAGOCARGUE>{$CODRESPONSABLEPAGOCARGUE}</CODRESPONSABLEPAGOCARGUE> 
		   <CODRESPONSABLEPAGODESCARGUE>{$CODRESPONSABLEPAGODESCARGUE}</CODRESPONSABLEPAGODESCARGUE> 
		   <OBSERVACIONES>{$OBSERVACIONES}</OBSERVACIONES>  
		   $RemesasMan
		 </variables>
		</root>";
		 
		   $pathXML  = "{$this -> ruta_archivos}manifiesto_{$NUMMANIFIESTOCARGA}.xml";
		   $fp       = fopen($pathXML, 'w');
		   fwrite($fp,"$msj");
		   fclose($fp);
		   
           $Model -> setPathXMLManifiesto($manifiesto_id,$pathXML,$this -> Conex);			   		 
	  
   		 return $msj;	
	  
	  }
	  
	   public function anularRemesaMinisterio($data){
	  
        require_once("WebServiceMinTranporteModelClass.php");	 	  
		
		$Model                       = new WebServiceMinTransporteModel();			
		$remesa_id                   = $data['remesa_id']; 
		$numero_remesa               = $data['numero_remesa']; 
		$CONSECUTIVOREMESA           = $numero_remesa;
		$CONSECUTIVOINFORMACIONCARGA = $numero_remesa;
		$MOTIVOREVERSAREMESA         = $Model -> getMotivoAnulacionRemesa($data['causal_anulacion_id'],$this -> Conex);
		$MOTIVOANULACIONINFOCARGA    = $Model -> getMotivoAnulacionRemesa($data['causal_anulacion_id'],$this -> Conex);

		if($Model -> remesaEstaReportada($data['remesa_id'],$this -> Conex)){
		
			$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>	
			  </acceso> 		  
	
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>9</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			   <CONSECUTIVOREMESA>{$CONSECUTIVOREMESA}</CONSECUTIVOREMESA> 
			   <MOTIVOREVERSAREMESA>{$MOTIVOREVERSAREMESA}</MOTIVOREVERSAREMESA> 
			   <MOTIVOANULACIONINFOCARGA>{$MOTIVOANULACIONINFOCARGA}</MOTIVOANULACIONINFOCARGA> 			   
			  </variables>
			 </root>";	
		
		}else{
		
			 
		  if($Model -> infoCargaEstaReportada($data['remesa_id'],$this -> Conex)){
		  
			$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>	
			  </acceso> 		  
	
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>7</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			   <CONSECUTIVOINFORMACIONCARGA>{$CONSECUTIVOREMESA}</CONSECUTIVOINFORMACIONCARGA> 
			   <MOTIVOANULACIONINFOCARGA>{$MOTIVOANULACIONINFOCARGA}</MOTIVOANULACIONINFOCARGA> 
			  </variables>
			 </root>";				  
		  
		  
		  }else{
		       exit("<div align='center'>Esta remesa no esta reportada en el ministerio de transporte<br>No necesita anulacion en el ministerio!!!</div>");
		    }			 
		
		  }	
			
	 
		$fp = fopen("{$this -> ruta_archivos}anulacion_remesa_{$numero_remesa}.xml", 'w');
		fwrite($fp,"$msj");
		fclose($fp);		
				        		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 echo 'No se pudo completar la operaci&oacute;n';
		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
			echo 'Error:'. $sError;
			
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionAnulacionRemesa($remesa_id,$ingresoid,$this -> Conex);
				 
				 exit("Reportado Exitosamente");
			   
			   }else{			   
			   				  
				  $Model -> setErrorAnulacionRemesa($remesa_id,$respuesta,$this -> Conex);				  				  
				  
				  
  				  if(preg_match("/Connection refused./i","$respuesta")){
                    exit("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				    exit("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
				     }else{
				      exit("Error reportando, revise el log de errores");
				      }
				  							 
			   }									 
						
						
			}
		
		} 		
	
		  
	  }
	  
	  public function anularManifiestoMinisterio($data){
	  
        require_once("WebServiceMinTranporteModelClass.php");	 	  
		
		$Model                       = new WebServiceMinTransporteModel();			
		$manifiesto_id               = $data['manifiesto_id']; 
		$manifiesto                  = $data['manifiesto']; 
		$NUMMANIFIESTOCARGA          = $manifiesto;
		$MOTIVOANULACIONMANIFIESTO   = $Model -> getMotivoAnulacionRemesa($data['causal_anulacion_id'],$this -> Conex);


        if($Model -> manifiestoEstaReportado($manifiesto_id,$this -> Conex)){
		
		  $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>	
			  </acceso> 		  
	
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>32</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			   <NUMMANIFIESTOCARGA>{$NUMMANIFIESTOCARGA}</NUMMANIFIESTOCARGA> 
			   <MOTIVOANULACIONMANIFIESTO>{$MOTIVOANULACIONMANIFIESTO}</MOTIVOANULACIONMANIFIESTO> 
			  </variables> 
		    </root>";
		
		
		}else{
		     exit("<div align='center'>Este manifiesto no esta reportado en el ministerio<br>No se requiere anulacion en el ministerio!!</div>");
		  }
			
	 
		$fp = fopen("{$this -> ruta_archivos}anulacion_manifiesto_{$manifiesto}.xml", 'w');
		fwrite($fp,"$msj");
		fclose($fp);		
				        		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 echo 'No se pudo completar la operaci&oacute;n';
		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
			echo 'Error:'. $sError;
			
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionAnulacionManifiesto($manifiesto_id,$ingresoid,$this -> Conex);
				 
				 exit("Reportado Exitosamente");
			   
			   }else{			   
			   				  
				  $Model -> setErrorAnulacionManifiesto($manifiesto_id,$respuesta,$this -> Conex);				  				  
				  
				  
  				  if(preg_match("/Connection refused./i","$respuesta")){
                    exit("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				    exit("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
				     }else{
				      exit("Error reportando, revise el log de errores");
				      }
				  							 
			   }									 
						
						
			}
		
		} 		
			  
	  }
	  
	  public function liberarRemesaMinisterio($data,$oficina_id){
	  
        require_once("WebServiceMinTranporteModelClass.php");	 	  
		
		$Model             = new WebServiceMinTransporteModel();			
		$remesa_id         = $data['remesa_id']; 
		$numero_remesa     = $data['numero_remesa']; 
		$CONSECUTIVOREMESA = $numero_remesa;

        if($Model -> remesaEstaAsignadaManifiestoReportado($remesa_id,$this -> Conex)){
		
		  $NUMMANIFIESTOCARGA     = $Model -> getManifiestoRemesa($remesa_id,$this -> Conex);
		  $ubicacion_id           = $Model -> getCodMunicipioDesbloquea($oficina_id,$this -> Conex);
		  $CODMUNICIPIOTRANSBORDO = str_pad($ubicacion_id,8, "0", STR_PAD_LEFT);		
		
		  $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
				 <root> 
				  <acceso> 
				   <username>{$this -> username}</username> 
				   <password>{$this -> password}</password> 
				   <ambiente>{$this -> ambiente}</ambiente>
				  </acceso> 
				  
				  <solicitud> 
				   <tipo>1</tipo> 
				   <procesoid>9</procesoid> 
				  </solicitud> 
				  
				  <variables> 
  				   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
				   <CONSECUTIVOREMESA>{$CONSECUTIVOREMESA}</CONSECUTIVOREMESA> 
				   <NUMMANIFIESTOCARGA>{$NUMMANIFIESTOCARGA}</NUMMANIFIESTOCARGA> 
				   <MOTIVOREVERSAREMESA>L</MOTIVOREVERSAREMESA> 
				   <CODMUNICIPIOTRANSBORDO>{$CODMUNICIPIOTRANSBORDO}</CODMUNICIPIOTRANSBORDO> 
				  </variables> 
				 </root>";
		
		
		}else{
		     exit("<div align='center'>Esta remesa no esta asignada a un manifiesto reportado al ministerio<br>No se requiere liberacion de remesa en el ministerio!!</div>");
		  }
			
	 
		$fp = fopen("{$this -> ruta_archivos}liberacion_remesa_{$numero_remesa}.xml", 'w');
		fwrite($fp,"$msj");
		fclose($fp);		
				        		
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 echo 'No se pudo completar la operaci&oacute;n';
		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
			echo 'Error:'. $sError;
			
		  }else{
		  
	           if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionLiberacionRemesa($remesa_id,$ingresoid,$this -> Conex);
				 
				 exit("Reportado Exitosamente");
			   
			   }else{			   
				  
				  $Model -> setErrorLiberacionRemesa($remesa_id,$respuesta,$this -> Conex);				  				  
				  
				  
  				  if(preg_match("/Connection refused./i","$respuesta")){
                    exit("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				    exit("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
				     }else{
				      exit("Error reportando, revise el log de errores");
				      }
				  							 
			   }									 
						
						
			}
		
		} 		
			  
	  }	
	  
	  public function cumplirManifiestoCargaMinisterio($data,$printMsj = true){  //aca
	  
             require_once("WebServiceMinTranporteModelClass.php");	 	  	  
	  
		$Model                          = new WebServiceMinTransporteModel();			
		$manifiesto_id       			= $data['manifiesto_id']; //ok	 
		$liquidacion_despacho_id        = $data['liquidacion_despacho_id']; //ok
		$liquidacion_despacho_descu_id  = $data['liquidacion_despacho_descu_id']; //ok
		if($liquidacion_despacho_id>0){
			$dataManifiesto                 = $Model -> getDataManifiestoLiquidacion($liquidacion_despacho_id,$this -> Conex);//ok
		}else{
			$dataManifiesto                 = $Model -> getDataManifiestoLiquidacionDesc($liquidacion_despacho_descu_id,$this -> Conex);//ok
		}
		
		$NUMMANIFIESTOCARGA             = $data['manifiesto'];//ok
		$observacion_anul_mani         	= $dataManifiesto[0]['observacion_anulacion'];//ok
		require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
		if( $dataManifiesto[0]['estado']!='A'){		 
			$TIPOCUMPLIDOMANIFIESTO         = 'C';	//OK	
			$MOTIVOSUSPENSIONMANIFIESTO		= ''; //OK
			$CONSECUENCIASUSPENSION			= '';//ok
		}else{
			$TIPOCUMPLIDOMANIFIESTO         = 'S'; //OK	
			if(strpos(strtoupper($observacion_anul_mani),'ACCIDEN')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='A';
			}elseif(strpos(strtoupper($observacion_anul_mani),'VARA')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='V';
			}elseif(strpos(strtoupper($observacion_anul_mani),'SINIE')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='S';
			}elseif(strpos(strtoupper($observacion_anul_mani),'ROBO')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='S';
			}else{
				$MOTIVOSUSPENSIONMANIFIESTO='V';				
			}

			if(strpos(strtoupper($observacion_anul_mani),'CONDUC')!==false){
				$CONSECUENCIASUSPENSION='C';
			}elseif(strpos(strtoupper($observacion_anul_mani),'CABE')!==false){
				$CONSECUENCIASUSPENSION='V';
			}elseif(strpos(strtoupper($observacion_anul_mani),'REMOL')!==false){
				$CONSECUENCIASUSPENSION='R';
			}elseif(strpos(strtoupper($observacion_anul_mani),'VEHICULO')!==false || strpos(strtoupper($observacion_anul_mani),'CAMBIO TOTAL')!==false){
				$CONSECUENCIASUSPENSION='T';
			}else{
				$CONSECUENCIASUSPENSION='F';				
			}


	  	}
		$FECHAENTREGADOCUMENTOS=date("d/m/Y",strtotime($dataManifiesto[0]['fecha']));
		$VALORADICIONALHORASCARGUE      = $dataManifiesto[0]['valor_sobre_flete'];//ok
		$VALORADICIONALHORASCARGUE      = $VALORADICIONALHORASCARGUE>0?$VALORADICIONALHORASCARGUE:0;//ok	
		$VALORDESCUENTOFLETE            = $dataManifiesto[0]['descuentos'];//
		if($VALORDESCUENTOFLETE>0){
			$MOTIVOVALORDESCUENTOMANIFIESTO = 'F';
		}else{
			$MOTIVOVALORDESCUENTOMANIFIESTO = '';//ok
		}
		$VALORSOBREANTICIPO             = $dataManifiesto[0]['valor_sobreanticipos'];//ok
		
		$manifiesto_id         			= $dataManifiesto[0]['manifiesto_id'];
		$remesas             			= $data['remesas'];
		
	    $VALORADICIONALHORASCARGUE = "<VALORADICIONALHORASCARGUE>{$VALORADICIONALHORASCARGUE}</VALORADICIONALHORASCARGUE>";
		
		if($VALORDESCUENTOFLETE>0){
	    	$VALORDESCUENTOFLETE            = "<VALORDESCUENTOFLETE>".$VALORDESCUENTOFLETE."</VALORDESCUENTOFLETE>";
		}else{

			$VALORDESCUENTOFLETE            = "<VALORDESCUENTOFLETE>0</VALORDESCUENTOFLETE>";
		}
		if($MOTIVOVALORDESCUENTOMANIFIESTO==''){
		    $MOTIVOVALORDESCUENTOMANIFIESTO = ""; 
		}else{
		    $MOTIVOVALORDESCUENTOMANIFIESTO = "<MOTIVOVALORDESCUENTOMANIFIESTO>{$MOTIVOVALORDESCUENTOMANIFIESTO}</MOTIVOVALORDESCUENTOMANIFIESTO>"; 
			
		}

		if($VALORSOBREANTICIPO==''){
		    $VALORSOBREANTICIPO = ""; 
		}else{
			$VALORSOBREANTICIPO = "<VALORSOBREANTICIPO>{$VALORSOBREANTICIPO}</VALORSOBREANTICIPO>";			
		}


		for($r=0;$r<count($remesas);$r++){
			if(!$Model -> getEstaCumplidaRemesa($remesas[$r][remesa_id],$this -> Conex)){
				$CONSECUTIVOREMESA = $remesas[$r][numero_remesa];
				$remesa_id = $remesas[$r][remesa_id];			
				$TIPOCUMPLIDOREMESA =  $remesas[$r][estado]!='AN'?'C':'S';
				$observacion_anulacion = $Model -> getObservacionANulacion($remesas[$r][remesa_id],$this -> Conex);
				$CANTIDADCARGADA = $remesas[$r][peso];
				$CANTIDADENTREGADA = $remesas[$r][peso_costo]>0? $remesas[$r][peso_costo]:$remesas[$r][peso];			

				$CANTIDADCARGADA = $CANTIDADCARGADA>0 ? $CANTIDADCARGADA : 25000;
				$CANTIDADENTREGADA = $CANTIDADENTREGADA>0 ? $CANTIDADENTREGADA : 25000;		

				$DESCARGUE = $Model -> getDatosDescargue($manifiesto_id,$remesas[$r][cliente_id],$this -> Conex);
				//fecha y hora de llegada cargue
				if($DESCARGUE[0]['fecha_llegada_cargue']!='0000-00-00' && $DESCARGUE[0]['fecha_llegada_cargue']!=''){

					$FECHALLEGADACARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_llegada_cargue']));
					$HORALLEGADACARGUEREMESA=$DESCARGUE[0]['hora_llegada_cargue'];

				}else{

					$FECHALLEGADACARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_llegada_cargue']));
					$HORALLEGADACARGUEREMESA=$dataManifiesto[0]['hora_llegada_cargue'];
					
				}
				//fecha y hora de entrada cargue
				if($DESCARGUE[0]['fecha_entrada_cargue']!='0000-00-00' && $DESCARGUE[0]['fecha_entrada_cargue']!=''){
				
					$FECHAENTRADACARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_entrada_cargue']));
					$HORAENTRADACARGUEREMESA=$DESCARGUE[0]['hora_entrada_cargue'];

				}else{

					$FECHAENTRADACARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_entrada_cargue']));
					$HORAENTRADACARGUEREMESA=$dataManifiesto[0]['hora_entrada_cargue'];
					
				}
				//fecha y hora de salida cargue
				if($DESCARGUE[0]['fecha_salida_cargue']!='0000-00-00' && $DESCARGUE[0]['fecha_salida_cargue']!=''){
				
					$FECHASALIDACARGUE= date("d/m/Y",strtotime($DESCARGUE[0]['fecha_salida_cargue']));
					$HORASALIDACARGUEREMESA=$DESCARGUE[0]['hora_salida_cargue'];

				}else{
					
					$FECHASALIDACARGUE= date("d/m/Y",strtotime($dataManifiesto[0]['fecha_estimada_salida']));
					$HORASALIDACARGUEREMESA=$dataManifiesto[0]['hora_estimada_salida'];

				}

				if($DESCARGUE[0]['fecha_llegada_descargue']!='0000-00-00' && $DESCARGUE[0]['fecha_llegada_descargue']!=''){
					$FECHALLEGADADESCARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_llegada_descargue']));
					$HORALLEGADADESCARGUECUMPLIDO=$DESCARGUE[0]['hora_llegada_descargue'];
				}else{
					
					$FECHALLEGADADESCARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_entrega_mcia_mc']));
					$HORALLEGADADESCARGUECUMPLIDO=$dataManifiesto[0]['hora_entrega'];
				}
				if($DESCARGUE[0]['fecha_entrada_descargue']!='0000-00-00' && $DESCARGUE[0]['fecha_entrada_descargue']!=''){
				
					$FECHAENTRADADESCARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_entrada_descargue']));
					$HORAENTRADADESCARGUECUMPLIDO=$DESCARGUE[0]['hora_entrada_descargue'];
				}else{
					$FECHAENTRADADESCARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_entrada_descargue']));
					$HORAENTRADADESCARGUECUMPLIDO=$dataManifiesto[0]['hora_entrada_descargue'];
					
				}
				if($DESCARGUE[0]['fecha_salida_descargue']!='0000-00-00' && $DESCARGUE[0]['fecha_salida_descargue']!=''){
				
					$FECHASALIDADESCARGUE= date("d/m/Y",strtotime($DESCARGUE[0]['fecha_salida_descargue']));
					$HORASALIDADESCARGUECUMPLIDO=$DESCARGUE[0]['hora_salida_descargue'];
				}else{
					
					$FECHASALIDADESCARGUE= date("d/m/Y",strtotime($dataManifiesto[0]['fecha_salida_descargue']));
					$HORASALIDADESCARGUECUMPLIDO=$dataManifiesto[0]['hora_salida_descargue'];
				}
				
				
				if( $remesas[$r][estado]!='AN'){
					$MOTIVOSUSPENSIONREMESA=  '';
				}else{
	
					if(strpos(strtoupper($observacion_anulacion),'ACCIDEN')!==false){
						$MOTIVOSUSPENSIONREMESA='A';
					}elseif(strpos(strtoupper($observacion_anulacion),'VARA')!==false){
						$MOTIVOSUSPENSIONREMESA='V';
					}elseif(strpos(strtoupper($observacion_anulacion),'SINIE')!==false){
						$MOTIVOSUSPENSIONREMESA='S';
					}elseif(strpos(strtoupper($observacion_anulacion),'ROBO')!==false){
						$MOTIVOSUSPENSIONREMESA='S';
					}else{
						$MOTIVOSUSPENSIONREMESA='V';				
					}
				}
				if($MOTIVOSUSPENSIONREMESA==''){
					$MOTIVOSUSPENSIONREMESA="";				
				}else{
					$MOTIVOSUSPENSIONREMESA="<MOTIVOSUSPENSIONREMESA>{$MOTIVOSUSPENSIONREMESA}</MOTIVOSUSPENSIONREMESA>";	
				}
				$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
				 <root> 
				  <acceso> 
				   <username>{$this -> username}</username> 
				   <password>{$this -> password}</password> 
				   <ambiente>{$this -> ambiente}</ambiente>
				  </acceso> 
				  
				  <solicitud> 
				   <tipo>1</tipo> 
				   <procesoid>5</procesoid> 
				  </solicitud> 
				  
				  <variables> 
				   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
	
					<CONSECUTIVOREMESA>$CONSECUTIVOREMESA</CONSECUTIVOREMESA>
					<NUMMANIFIESTOCARGA>$NUMMANIFIESTOCARGA</NUMMANIFIESTOCARGA>
					<TIPOCUMPLIDOREMESA>$TIPOCUMPLIDOREMESA</TIPOCUMPLIDOREMESA>
					$MOTIVOSUSPENSIONREMESA
					<CANTIDADCARGADA>$CANTIDADCARGADA</CANTIDADCARGADA>
					<CANTIDADENTREGADA>$CANTIDADENTREGADA</CANTIDADENTREGADA>
					<FECHALLEGADACARGUE>{$FECHALLEGADACARGUE}</FECHALLEGADACARGUE>
					<HORALLEGADACARGUEREMESA>{$HORALLEGADACARGUEREMESA}</HORALLEGADACARGUEREMESA>
					<FECHAENTRADACARGUE>{$FECHAENTRADACARGUE}</FECHAENTRADACARGUE>
					<HORAENTRADACARGUEREMESA>{$HORAENTRADACARGUEREMESA}</HORAENTRADACARGUEREMESA>
					<FECHASALIDACARGUE>{$FECHASALIDACARGUE}</FECHASALIDACARGUE>
					<HORASALIDACARGUEREMESA>{$HORASALIDACARGUEREMESA}</HORASALIDACARGUEREMESA>
	
					<FECHALLEGADADESCARGUE>$FECHALLEGADADESCARGUE</FECHALLEGADADESCARGUE>
					<HORALLEGADADESCARGUECUMPLIDO>$HORALLEGADADESCARGUECUMPLIDO</HORALLEGADADESCARGUECUMPLIDO>
					
					<FECHAENTRADADESCARGUE>$FECHAENTRADADESCARGUE</FECHAENTRADADESCARGUE>
					<HORAENTRADADESCARGUECUMPLIDO>$HORAENTRADADESCARGUECUMPLIDO</HORAENTRADADESCARGUECUMPLIDO>
					<FECHASALIDADESCARGUE>$FECHASALIDADESCARGUE</FECHASALIDADESCARGUE>
					<HORASALIDADESCARGUECUMPLIDO>$HORASALIDADESCARGUECUMPLIDO</HORASALIDADESCARGUECUMPLIDO>
					
				  </variables> 
				 </root>";
	
				 $aParametros   = array("Request" => $msj);
				 $this -> setOSoapClient($this -> Conex);
				 $respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
						
				 if ($respuesta=='') { 
					$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
					$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
					if($printMsj) echo $respuesta;					 
				 }else{ 
						
					$sError ='';
						
					if ($sError!='') { 
						$respuesta =  '<div id="message">Error:'. $sError.'</div>';
						$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
						if($printMsj) echo $respuesta;						
					}else{
						  
						if(preg_match("/ingresoid/i","$respuesta")){
							$contenido = $respuesta;
							$resultado = xml2array($contenido);			   
							$ingresoid = $resultado['root']['ingresoid'];
							$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);	
							if($printMsj)echo("Remesa ".$remesas[$r]['numero_remesa']." Cumplida Exitosamente<br>");
							   
						}else{			   
							   
							$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
															  
							if(preg_match("/ya fue convertida a Remesa/i","$respuesta")){
								//$ingresoid = 0;
								//$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);
								if($printMsj)echo"<div align='center' id='message'><b>Reportado Exitosamente</b></div>";
							}else if(preg_match("/Connection refused./i","$respuesta")){
								if($printMsj)echo("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
							}else if(preg_match("/listener could not find/i","$respuesta")){
								if($printMsj)echo("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
							}else{
							   if($printMsj)echo("Error reportando Cumplido de Remesas, revise el log de errores: ".$respuesta."<br>");
							   
							    if(preg_match("/DUPLICADO:/i","$respuesta")){
										$resultado = xml2array($respuesta);	
										$respuesta_parcial = $resultado['root']['ErrorMSG'];
										$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
										$respuesta_parcial=explode(" ",$respuesta_parcial);
										$respuesta_final=$respuesta_parcial[0];
										
										$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$respuesta_final,$this -> Conex);	 
										if($printMsj)echo("<br>Previamente reportado<br>");									
								}else{
									if($printMsj)echo("<br>Error reportando Cumplido de Remesa, revise el log de errores:<br>".$respuesta);
									
								}
							}
															 
						}									 						
										
					}
						
				} 
			}else{
				echo "Remesa ".$remesas[$r][numero_remesa]." Previamente Cumplida<br>";	
			}
		}

		if($MOTIVOSUSPENSIONMANIFIESTO==''){
			$MOTIVOSUSPENSIONMANIFIESTO="";				
		}else{
			$MOTIVOSUSPENSIONMANIFIESTO="<MOTIVOSUSPENSIONMANIFIESTO>{$MOTIVOSUSPENSIONMANIFIESTO}</MOTIVOSUSPENSIONMANIFIESTO>";	
		}
		if($CONSECUENCIASUSPENSION==''){
			$CONSECUENCIASUSPENSION="";				
		}else{
			$CONSECUENCIASUSPENSION="<CONSECUENCIASUSPENSION>{$CONSECUENCIASUSPENSION}</CONSECUENCIASUSPENSION>";	
		}
		
		if(!$Model -> getEstaCumplidaManifiesto($manifiesto_id,$this -> Conex)){
			$msj1 = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
			   <username>{$this -> username}</username> 
			   <password>{$this -> password}</password> 
			   <ambiente>{$this -> ambiente}</ambiente>
			  </acceso> 
			  
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>6</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			   <NUMMANIFIESTOCARGA>{$NUMMANIFIESTOCARGA}</NUMMANIFIESTOCARGA> 
			   <TIPOCUMPLIDOMANIFIESTO>{$TIPOCUMPLIDOMANIFIESTO}</TIPOCUMPLIDOMANIFIESTO> 
			   $MOTIVOSUSPENSIONMANIFIESTO
			   $CONSECUENCIASUSPENSION 
			   <FECHAENTREGADOCUMENTOS>{$FECHAENTREGADOCUMENTOS}</FECHAENTREGADOCUMENTOS> 
			   {$VALORADICIONALHORASCARGUE}
			   {$VALORDESCUENTOFLETE}
			   {$MOTIVOVALORDESCUENTOMANIFIESTO}
			   {$VALORSOBREANTICIPO}
			  </variables> 
			 </root>";

			 $aParametros   = array("Request" => $msj1);
			 $this -> setOSoapClient($this -> Conex);
			 $respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
					
			 if ($respuesta=='') { 
				$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
				$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$this -> Conex);
				if($printMsj) echo $respuesta;					 
			 }else{ 
					
				$sError ='';
					
				if ($sError!='') { 
					$respuesta =  '<div id="message">Error:'. $sError.'</div>';
					$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$this -> Conex);
					if($printMsj) echo $respuesta;						
				}else{
					  
					if(preg_match("/ingresoid/i","$respuesta")){
						$contenido = $respuesta;
						$resultado = xml2array($contenido);			   
						$ingresoid = $resultado['root']['ingresoid'];
						$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$this -> Conex);	
						if($printMsj)echo("<br>Manifiesto ".$data['manifiesto']." Cumplido Exitosamente<br>");
						   
					}else{			   
						   
						$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$this -> Conex);
														  
						if(preg_match("/ya fue convertida a Manifiesto/i","$respuesta")){
							//$ingresoid = 0;
							//$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$this -> Conex);
							if($printMsj)echo"<div align='center' id='message'><b>Reportado Exitosamente</b></div>";
						}else if(preg_match("/Connection refused./i","$respuesta")){
							if($printMsj)echo("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
						}else if(preg_match("/listener could not find/i","$respuesta")){
							if($printMsj)echo("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
						}else{
						   if(preg_match("/DUPLICADO:/i","$respuesta")){
								    $resultado = xml2array($respuesta);	
								    $respuesta_parcial = $resultado['root']['ErrorMSG'];
									$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
									$respuesta_parcial=explode(" ",$respuesta_parcial);
									$respuesta_final=$respuesta_parcial[0];
									
									$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$respuesta_final,$this -> Conex);	 
									if($printMsj)echo("<br>Previamente Reportado.<br>");									
						    }else{
						   		if($printMsj)echo("<br>Error reportando Cumplido de Manifiesto, revise el log de errores:<br>".$respuesta);
							}
						}
														 
					}									 						
									
				}
					
			} 	
		}else{
			echo "Manifiesto ".$NUMMANIFIESTOCARGA." Previamente Cumplido<br>";
		}
	  }  
	  
	   public function cumplirManifiestoCargaMinisterioPropio($data,$printMsj = true){  //bloque reporte cumplido
	  
        require_once("WebServiceMinTranporteModelClass.php");	 	  	  
	  
		$Model                          = new WebServiceMinTransporteModel();			
		$manifiesto_id       			= $data['manifiesto_id']; //ok	 
		$legalizacion_manifiesto_id        = $data['legalizacion_manifiesto_id']; //ok	
		if($legalizacion_manifiesto_id>0){
			$dataManifiesto                 = $Model -> getDataManifiestoLiquidacionPropio($legalizacion_manifiesto_id,$this -> Conex);//ok
		}else{
			$dataManifiesto                 = $Model -> getDataManifiestoLiquidacionMan($manifiesto_id,$this -> Conex);//ok	
		}
		$NUMMANIFIESTOCARGA             = $data['manifiesto'];//ok
		$observacion_anul_mani         	= $dataManifiesto[0]['observacion_anulacion'];//ok
		require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
		if( $dataManifiesto[0]['estado']!='A'){		 
			$TIPOCUMPLIDOMANIFIESTO         = 'C';	//OK	
			$MOTIVOSUSPENSIONMANIFIESTO		= ''; //OK
			$CONSECUENCIASUSPENSION			= '';//ok
		}else{
			$TIPOCUMPLIDOMANIFIESTO         = 'S'; //OK		

			if(strpos(strtoupper($observacion_anul_mani),'ACCIDEN')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='A';
			}elseif(strpos(strtoupper($observacion_anul_mani),'VARA')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='V';
			}elseif(strpos(strtoupper($observacion_anul_mani),'SINIE')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='S';
			}elseif(strpos(strtoupper($observacion_anul_mani),'ROBO')!==false){
				$MOTIVOSUSPENSIONMANIFIESTO='S';
			}else{
				$MOTIVOSUSPENSIONMANIFIESTO='V';				
			}

			if(strpos(strtoupper($observacion_anul_mani),'CONDUC')!==false){
				$CONSECUENCIASUSPENSION='C';
			}elseif(strpos(strtoupper($observacion_anul_mani),'CABE')!==false){
				$CONSECUENCIASUSPENSION='V';
			}elseif(strpos(strtoupper($observacion_anul_mani),'REMOL')!==false){
				$CONSECUENCIASUSPENSION='R';
			}elseif(strpos(strtoupper($observacion_anul_mani),'VEHICULO')!==false || strpos(strtoupper($observacion_anul_mani),'CAMBIO TOTAL')!==false){
				$CONSECUENCIASUSPENSION='T';
			}else{
				$CONSECUENCIASUSPENSION='F';				
			}


	  	}
		$FECHAENTREGADOCUMENTOS=date("d/m/Y",strtotime($dataManifiesto[0]['fecha']));
		$VALORADICIONALHORASCARGUE      = $dataManifiesto[0]['valor_sobre_flete'];//ok
		$VALORADICIONALHORASCARGUE      = $VALORADICIONALHORASCARGUE>0?$VALORADICIONALHORASCARGUE:0;//ok	
		$VALORDESCUENTOFLETE            = $dataManifiesto[0]['descuentos'];//
		if($VALORDESCUENTOFLETE>0){
			$MOTIVOVALORDESCUENTOMANIFIESTO = 'F';
		}else{
			$MOTIVOVALORDESCUENTOMANIFIESTO = '';//ok
		}
		$VALORSOBREANTICIPO             = $dataManifiesto[0]['valor_sobreanticipos'];//ok
		
		$manifiesto_id         			= $dataManifiesto[0]['manifiesto_id'];
		$remesas             			= $data['remesas'];
		
	    $VALORADICIONALHORASCARGUE = "<VALORADICIONALHORASCARGUE>{$VALORADICIONALHORASCARGUE}</VALORADICIONALHORASCARGUE>";
		
		if($VALORDESCUENTOFLETE>0){
	    	$VALORDESCUENTOFLETE            = "<VALORDESCUENTOFLETE>".$VALORDESCUENTOFLETE."</VALORDESCUENTOFLETE>";
		}else{

			$VALORDESCUENTOFLETE            = "<VALORDESCUENTOFLETE>0</VALORDESCUENTOFLETE>";
		}
		if($MOTIVOVALORDESCUENTOMANIFIESTO==''){
		    $MOTIVOVALORDESCUENTOMANIFIESTO = ""; 
		}else{
		    $MOTIVOVALORDESCUENTOMANIFIESTO = "<MOTIVOVALORDESCUENTOMANIFIESTO>{$MOTIVOVALORDESCUENTOMANIFIESTO}</MOTIVOVALORDESCUENTOMANIFIESTO>"; 
			
		}

		if($VALORSOBREANTICIPO==''){
		    $VALORSOBREANTICIPO = ""; 
		}else{
			$VALORSOBREANTICIPO = "<VALORSOBREANTICIPO>{$VALORSOBREANTICIPO}</VALORSOBREANTICIPO>";			
		}


		for($r=0;$r<count($remesas);$r++){
			if(!$Model -> getEstaCumplidaRemesa($remesas[$r][remesa_id],$this -> Conex)){
				$CONSECUTIVOREMESA = $remesas[$r][numero_remesa];
				$remesa_id = $remesas[$r][remesa_id];			
				$TIPOCUMPLIDOREMESA =  $remesas[$r][estado]!='AN'?'C':'S';
				$observacion_anulacion = $Model -> getObservacionANulacion($remesas[$r][remesa_id],$this -> Conex);
				$CANTIDADCARGADA = $remesas[$r][peso];
				$CANTIDADENTREGADA = $remesas[$r][peso_costo]>0? $remesas[$r][peso_costo]:$remesas[$r][peso];			


				$CANTIDADCARGADA = $CANTIDADCARGADA>0 ? $CANTIDADCARGADA : 10;
				$CANTIDADENTREGADA = $CANTIDADENTREGADA>0 ? $CANTIDADENTREGADA : 10;		

				$DESCARGUE = $Model -> getDatosDescargue($manifiesto_id,$remesas[$r][cliente_id],$this -> Conex);
				//fecha y hora de llegada cargue
				if($DESCARGUE[0]['fecha_llegada_cargue']!='0000-00-00' && $DESCARGUE[0]['fecha_llegada_cargue']!=''){

					$FECHALLEGADACARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_llegada_cargue']));
					$HORALLEGADACARGUEREMESA=$DESCARGUE[0]['hora_llegada_cargue'];

				}else{

					$FECHALLEGADACARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_llegada_cargue']));
					$HORALLEGADACARGUEREMESA=$dataManifiesto[0]['hora_llegada_cargue'];
					
				}
				//fecha y hora de entrada cargue
				if($DESCARGUE[0]['fecha_entrada_cargue']!='0000-00-00' && $DESCARGUE[0]['fecha_entrada_cargue']!=''){
				
					$FECHAENTRADACARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_entrada_cargue']));
					$HORAENTRADACARGUEREMESA=$DESCARGUE[0]['hora_entrada_cargue'];

				}else{

					$FECHAENTRADACARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_entrada_cargue']));
					$HORAENTRADACARGUEREMESA=$dataManifiesto[0]['hora_entrada_cargue'];
					
				}
				//fecha y hora de salida cargue
				if($DESCARGUE[0]['fecha_salida_cargue']!='0000-00-00' && $DESCARGUE[0]['fecha_salida_cargue']!=''){
				
					$FECHASALIDACARGUE= date("d/m/Y",strtotime($DESCARGUE[0]['fecha_salida_cargue']));
					$HORASALIDACARGUEREMESA=$DESCARGUE[0]['hora_salida_cargue'];

				}else{
					
					$FECHASALIDACARGUE= date("d/m/Y",strtotime($dataManifiesto[0]['fecha_estimada_salida']));
					$HORASALIDACARGUEREMESA=$dataManifiesto[0]['hora_estimada_salida'];

				}

				if($DESCARGUE[0]['fecha_llegada_descargue']!='0000-00-00' && $DESCARGUE[0]['fecha_llegada_descargue']!=''){
					$FECHALLEGADADESCARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_llegada_descargue']));
					$HORALLEGADADESCARGUECUMPLIDO=$DESCARGUE[0]['hora_llegada_descargue'];
				}else{
					
					$FECHALLEGADADESCARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_entrega_mcia_mc']));
					$HORALLEGADADESCARGUECUMPLIDO=$dataManifiesto[0]['hora_entrega'];
				}
				if($DESCARGUE[0]['fecha_entrada_descargue']!='0000-00-00' && $DESCARGUE[0]['fecha_entrada_descargue']!=''){
				
					$FECHAENTRADADESCARGUE=date("d/m/Y",strtotime($DESCARGUE[0]['fecha_entrada_descargue']));
					$HORAENTRADADESCARGUECUMPLIDO=$DESCARGUE[0]['hora_entrada_descargue'];
				}else{
					$FECHAENTRADADESCARGUE=date("d/m/Y",strtotime($dataManifiesto[0]['fecha_entrada_descargue']));
					$HORAENTRADADESCARGUECUMPLIDO=$dataManifiesto[0]['hora_entrada_descargue'];
					
				}
				if($DESCARGUE[0]['fecha_salida_descargue']!='0000-00-00' && $DESCARGUE[0]['fecha_salida_descargue']!=''){
				
					$FECHASALIDADESCARGUE= date("d/m/Y",strtotime($DESCARGUE[0]['fecha_salida_descargue']));
					$HORASALIDADESCARGUECUMPLIDO=$DESCARGUE[0]['hora_salida_descargue'];
				}else{
					
					$FECHASALIDADESCARGUE= date("d/m/Y",strtotime($dataManifiesto[0]['fecha_salida_descargue']));
					$HORASALIDADESCARGUECUMPLIDO=$dataManifiesto[0]['hora_salida_descargue'];
				}
	
				
				
				if( $remesas[$r][estado]!='AN'){
					$MOTIVOSUSPENSIONREMESA=  '';
				}else{
	
					if(strpos(strtoupper($observacion_anulacion),'ACCIDEN')!==false){
						$MOTIVOSUSPENSIONREMESA='A';
					}elseif(strpos(strtoupper($observacion_anulacion),'VARA')!==false){
						$MOTIVOSUSPENSIONREMESA='V';
					}elseif(strpos(strtoupper($observacion_anulacion),'SINIE')!==false){
						$MOTIVOSUSPENSIONREMESA='S';
					}elseif(strpos(strtoupper($observacion_anulacion),'ROBO')!==false){
						$MOTIVOSUSPENSIONREMESA='S';
					}else{
						$MOTIVOSUSPENSIONREMESA='V';				
					}
				}
				if($MOTIVOSUSPENSIONREMESA==''){
					$MOTIVOSUSPENSIONREMESA="";				
				}else{
					$MOTIVOSUSPENSIONREMESA="<MOTIVOSUSPENSIONREMESA>{$MOTIVOSUSPENSIONREMESA}</MOTIVOSUSPENSIONREMESA>";	
				}
				$msj = "<?xml version='1.0' encoding='UTF-8' ?> 
				 <root> 
				  <acceso> 
				   <username>{$this -> username}</username> 
				   <password>{$this -> password}</password> 
				   <ambiente>{$this -> ambiente}</ambiente>
				  </acceso> 
				  
				  <solicitud> 
				   <tipo>1</tipo> 
				   <procesoid>5</procesoid> 
				  </solicitud> 
				  
				  <variables> 
				   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
	
					<CONSECUTIVOREMESA>$CONSECUTIVOREMESA</CONSECUTIVOREMESA>
					<NUMMANIFIESTOCARGA>$NUMMANIFIESTOCARGA</NUMMANIFIESTOCARGA>
					<TIPOCUMPLIDOREMESA>$TIPOCUMPLIDOREMESA</TIPOCUMPLIDOREMESA>
					$MOTIVOSUSPENSIONREMESA
					<CANTIDADCARGADA>$CANTIDADCARGADA</CANTIDADCARGADA>
					<CANTIDADENTREGADA>$CANTIDADENTREGADA</CANTIDADENTREGADA>
					<FECHALLEGADACARGUE>{$FECHALLEGADACARGUE}</FECHALLEGADACARGUE>
					<HORALLEGADACARGUEREMESA>{$HORALLEGADACARGUEREMESA}</HORALLEGADACARGUEREMESA>
					<FECHAENTRADACARGUE>{$FECHAENTRADACARGUE}</FECHAENTRADACARGUE>
					<HORAENTRADACARGUEREMESA>{$HORAENTRADACARGUEREMESA}</HORAENTRADACARGUEREMESA>
					<FECHASALIDACARGUE>{$FECHASALIDACARGUE}</FECHASALIDACARGUE>
					<HORASALIDACARGUEREMESA>{$HORASALIDACARGUEREMESA}</HORASALIDACARGUEREMESA>
	
					<FECHALLEGADADESCARGUE>$FECHALLEGADADESCARGUE</FECHALLEGADADESCARGUE>
					<HORALLEGADADESCARGUECUMPLIDO>$HORALLEGADADESCARGUECUMPLIDO</HORALLEGADADESCARGUECUMPLIDO>
					
					<FECHAENTRADADESCARGUE>$FECHAENTRADADESCARGUE</FECHAENTRADADESCARGUE>
					<HORAENTRADADESCARGUECUMPLIDO>$HORAENTRADADESCARGUECUMPLIDO</HORAENTRADADESCARGUECUMPLIDO>
					<FECHASALIDADESCARGUE>$FECHASALIDADESCARGUE</FECHASALIDADESCARGUE>
					<HORASALIDADESCARGUECUMPLIDO>$HORASALIDADESCARGUECUMPLIDO</HORASALIDADESCARGUECUMPLIDO>
					
				  </variables> 
				 </root>";
	
				 $aParametros   = array("Request" => $msj);
				 $this -> setOSoapClient($this -> Conex);
				 $respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
						
				 if ($respuesta=='') { 
					$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
					$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
					if($printMsj) echo $respuesta;					 
				 }else{ 
						
					$sError ='';
						
					if ($sError!='') { 
						$respuesta =  '<div id="message">Error:'. $sError.'</div>';
						$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
						if($printMsj) echo $respuesta;						
					}else{
						  
						if(preg_match("/ingresoid/i","$respuesta")){
							$contenido = $respuesta;
							$resultado = xml2array($contenido);			   
							$ingresoid = $resultado['root']['ingresoid'];
							$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);	
							if($printMsj)echo("Remesa ".$remesas[$r]['numero_remesa']." Cumplida Exitosamente<br>");
							   
						}else{			   
							   
							$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
															  
							if(preg_match("/ya fue convertida a Remesa/i","$respuesta")){
								//$ingresoid = 0;
								//$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);
								if($printMsj)echo"<div align='center' id='message'><b>Reportado Exitosamente</b></div>";
							}else if(preg_match("/Connection refused./i","$respuesta")){
								if($printMsj)echo("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
							}else if(preg_match("/listener could not find/i","$respuesta")){
								if($printMsj)echo("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
							}else{
							   if($printMsj)echo("Error reportando Cumplido de Remesas, revise el log de errores: ".$respuesta."<br>");
							   

							   if(preg_match("/DUPLICADO:/i","$respuesta")){
										$resultado = xml2array($respuesta);	
										$respuesta_parcial = $resultado['root']['ErrorMSG'];
										$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
										$respuesta_parcial=explode(" ",$respuesta_parcial);
										$respuesta_final=$respuesta_parcial[0];
										
										$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$respuesta_final,$this -> Conex);	 
										if($printMsj)echo("<br>Previamente reportado<br>");									
								}else{
									if($printMsj)echo("<br>Error reportando Cumplido de Remesa, revise el log de errores:<br>".$respuesta);
									
								}

							}
															 
						}									 						
										
					}
						
				} 
			}else{
				echo "Remesa ".$remesas[$r]['numero_remesa']." Previamente Cumplida<br>";	
			}
		}

		if($MOTIVOSUSPENSIONMANIFIESTO==''){
			$MOTIVOSUSPENSIONMANIFIESTO="";				
		}else{
			$MOTIVOSUSPENSIONMANIFIESTO="<MOTIVOSUSPENSIONMANIFIESTO>{$MOTIVOSUSPENSIONMANIFIESTO}</MOTIVOSUSPENSIONMANIFIESTO>";	
		}
		if($CONSECUENCIASUSPENSION==''){
			$CONSECUENCIASUSPENSION="";				
		}else{
			$CONSECUENCIASUSPENSION="<CONSECUENCIASUSPENSION>{$CONSECUENCIASUSPENSION}</CONSECUENCIASUSPENSION>";	
		}
		
		if(!$Model -> getEstaCumplidaManifiesto($manifiesto_id,$this -> Conex)){
			$msj1 = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
			   <username>{$this -> username}</username> 
			   <password>{$this -> password}</password> 
			   <ambiente>{$this -> ambiente}</ambiente>
			  </acceso> 
			  
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>6</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			   <NUMMANIFIESTOCARGA>{$NUMMANIFIESTOCARGA}</NUMMANIFIESTOCARGA> 
			   <TIPOCUMPLIDOMANIFIESTO>{$TIPOCUMPLIDOMANIFIESTO}</TIPOCUMPLIDOMANIFIESTO> 
			   $MOTIVOSUSPENSIONMANIFIESTO
			   $CONSECUENCIASUSPENSION 
			   <FECHAENTREGADOCUMENTOS>{$FECHAENTREGADOCUMENTOS}</FECHAENTREGADOCUMENTOS> 
			   {$VALORADICIONALHORASCARGUE}
			   {$VALORDESCUENTOFLETE}
			   {$MOTIVOVALORDESCUENTOMANIFIESTO}
			   {$VALORSOBREANTICIPO}
			  </variables> 
			 </root>";

			 $aParametros   = array("Request" => $msj1);
			 $this -> setOSoapClient($this -> Conex);
			 $respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
					
			 if ($respuesta=='') { 
				$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
				$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$this -> Conex);
				if($printMsj) echo $respuesta;					 
			 }else{ 
					
				$sError ='';
					
				if ($sError!='') { 
					$respuesta =  '<div id="message">Error:'. $sError.'</div>';
					$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$this -> Conex);
					if($printMsj) echo $respuesta;						
				}else{
					  
					if(preg_match("/ingresoid/i","$respuesta")){
						$contenido = $respuesta;
						$resultado = xml2array($contenido);			   
						$ingresoid = $resultado['root']['ingresoid'];
						$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$this -> Conex);	
						if($printMsj)echo("<br>Manifiesto ".$data['manifiesto']." Cumplido Exitosamente<br>");
						   
					}else{			   
						   
						$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$this -> Conex);
														  
						if(preg_match("/ya fue convertida a Manifiesto/i","$respuesta")){
							//$ingresoid = 0;
							//$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$this -> Conex);
							if($printMsj)echo"<div align='center' id='message'><b>Reportado Exitosamente</b></div>";
						}else if(preg_match("/Connection refused./i","$respuesta")){
							if($printMsj)echo("<div align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>");
						}else if(preg_match("/listener could not find/i","$respuesta")){
							if($printMsj)echo("<div align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>");
						}else{
						   if(preg_match("/DUPLICADO:/i","$respuesta")){
								    $resultado = xml2array($respuesta);	
								    $respuesta_parcial = $resultado['root']['ErrorMSG'];
									$respuesta_parcial=str_replace("DUPLICADO:","",$respuesta_parcial);
									$respuesta_parcial=explode(" ",$respuesta_parcial);
									$respuesta_final=$respuesta_parcial[0];
									
									$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$respuesta_final,$this -> Conex);	 
									if($printMsj)echo("<br>Previamente reportado<br>");									
						    }else{
								if($printMsj)echo("<br>Error reportando Cumplido de Manifiesto, revise el log de errores:<br>".$respuesta.$manifiesto_id);
								
							}
						}
														 
					}									 						
									
				}
					
			} 	
		}else{
			echo "Manifiesto ".$NUMMANIFIESTOCARGA." Previamente Cumplido<br>";
		}
	  }//bloque reporte cumplido  
	  
	 public function sendInformacionRemesa($data,$path_xml = NULL,$printMsj = true){
	 
        require_once("WebServiceMinTranporteModelClass.php");	 	  
		
		$Model  = new WebServiceMinTransporteModel();	
			 
       if(is_null($path_xml)){		
	
		 $remesa_id                   = $data['remesa_id'];		
		 $manifiesto_id               = $data['manifiesto_id'];				 
		 $peso                        = $data['peso'];		  
		 $CONSECUTIVOREMESA           = $data['numero_remesa'];
		 $CONSECUTIVOINFORMACIONCARGA = $data['numero_remesa'];
		 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data['fecha_recogida_ss']));
		 $HORACITAPACTADACARGUE       = $data['hora_recogida_ss'];
		 $CODOPERACIONTRANSPORTE      = $Model -> getCodTipoRemesa($data['tipo_remesa_id'],$this -> Conex);
		 $CODTIPOEMPAQUE              = $data['empaque_id'];
		 $NATURALEZACARGA             = $data['naturaleza_id'];
		 $DESCRIPCIONCORTAPRODUCTO    = substr($data['descripcion_producto'],0,50);
		 $MERCANCIAINFORMACIONCARGA   = $Model -> getCodProducto($data['producto_id'],$this -> Conex);
		 $CANTIDADINFORMACIONCARGA    = $data['peso'];
		 $UNIDADMEDIDACAPACIDAD       = $Model -> getCodUnidadMedida($data['medida_id'],$this -> Conex);
		 		 
		 $NUMIDPROPIETARIO            = $Model -> getNumeroIdentificacionPropietario($data['propietario_mercancia_id'],
										$this -> Conex);
		 $CODSEDEPROPIETARIO          = $Model -> getCodSedePropietario($data['propietario_mercancia_id'],
										$this -> Conex);
		 $CODTIPOIDPROPIETARIO        = $Model -> getCodTipoIdentificacionPropietario($data['propietario_mercancia_id'],
										$this -> Conex);														 
		 
		 $CODTIPOIDREMITENTE          = $Model -> getCodTipoIdentificacion($data['tipo_identificacion_remitente_id'],
										$this -> Conex);
		 $REMREMITENTE                = $data['doc_remitente'];
		 $REMDIRREMITENTE             = $data['direccion_remitente'];
		 $CODSEDEREMITENTE            = $data['remitente_id'];
		 
		 $CODTIPOIDDESTINATARIO       = $Model -> getCodTipoIdentificacion($data['tipo_identificacion_destinatario_id'],
										$this -> Conex);
		 $CODSEDEDESTINATARIO         = $data['destinatario_id'];
		 $REMDESTINATARIO             = $data['doc_destinatario'];
		 
		 $REM_ORIG                    = $data['origen_id'];
		 $REM_DESTI                   = $data['destino_id'];
		 
		 $PACTOTIEMPOCARGUE           = 'NO';
		 $PACTOTIEMPODESCARGUE        = 'NO';
		 $OBSERVACIONES               = $data['observaciones'];
		 
		 $DUENOPOLIZA                 = $data['amparada_por'];
		 $NUMPOLIZATRANSPORTE         = $data['numero_poliza'];
		 $FECHAVENCIMIENTOPOLIZACARGA = date("d/m/Y",strtotime($data['fecha_vencimiento_poliza']));
		 $COMPANIASEGURO              = $Model -> getNitAseguradora($data['aseguradora_id'],$this -> Conex);

		 $FECHACITAPACTADACARGUE      = date("d/m/Y",strtotime($data['fecha_recogida_ss']));
		 $HORACITAPACTADACARGUE       = substr($data['hora_recogida_ss'],0,5);
				 
		 $FECHACITAPACTADADESCARGUE=date("d/m/Y",strtotime($Model -> getFechaCitadaDescargue($manifiesto_id,$this -> Conex)));
		 $HORACITAPACTADADESCARGUEREMESA = substr($Model -> getHoraCitadaDescargue($manifiesto_id,$this -> Conex),0,5);

		 /*$FECHALLEGADACARGUE          = date("d/m/Y",strtotime($data['fecha_llegada_cargue']));
		 $HORALLEGADACARGUEREMESA     = substr($data['hora_llegada_cargue'],0,5);
		 $FECHAENTRADACARGUE          = date("d/m/Y",strtotime($data['fecha_entrada_cargue']));
		 $HORAENTRADACARGUEREMESA     = substr($data['hora_entrada_cargue'],0,5);
		 $FECHASALIDACARGUE           = date("d/m/Y",strtotime($data['fecha_salida_cargue']));
		 $HORASALIDACARGUEREMESA      = substr($data['hora_salida_cargue'],0,5);*/

		 $FECHALLEGADACARGUE          = $data['fecha_llegada_cargue']!='' ? date("d/m/Y",strtotime($data['fecha_llegada_cargue'])) : date("d/m/Y",strtotime($data['fecha_recogida_ss'])); 
		 $HORALLEGADACARGUEREMESA     = substr($data['hora_llegada_cargue'],0,5)!='' ? substr($data['hora_llegada_cargue'],0,5) : substr($data['hora_recogida_ss'],0,5);
		 $FECHAENTRADACARGUE          = $data['fecha_entrada_cargue']!='' ? date("d/m/Y",strtotime($data['fecha_entrada_cargue'])) : date("d/m/Y",strtotime($data['fecha_recogida_ss']));
		 $HORAENTRADACARGUEREMESA     = substr($data['hora_entrada_cargue'],0,5)!='' ? substr($data['hora_entrada_cargue'],0,5) : substr($data['hora_recogida_ss'],0,5);
		 $FECHASALIDACARGUE           = $data['fecha_salida_cargue']!='' ? date("d/m/Y",strtotime($data['fecha_salida_cargue'])) : date("d/m/Y",strtotime($data['fecha_recogida_ss']));
		 $HORASALIDACARGUEREMESA      = substr($data['hora_salida_cargue'],0,5)!='' ? substr($data['hora_salida_cargue'],0,5) : substr($data['hora_recogida_ss'],0,5);
		
		 if($CODOPERACIONTRANSPORTE == 'V'){
		   $MERCANCIAREMESA           = '<MERCANCIAREMESA>009990</MERCANCIAREMESA>';
		   $DESCRIPCIONCORTAPRODUCTO  = 'CONTENEDOR VACIO';
		   $CANTIDADCARGADA           = NULL;
		   $UNIDADMEDIDACAPACIDAD     = NULL;
		 }else if($CODOPERACIONTRANSPORTE == 'P'){
			 $MERCANCIAREMESA           = '<MERCANCIAREMESA>009880</MERCANCIAREMESA>';
			 $DESCRIPCIONCORTAPRODUCTO  = 'PAQUETES VARIOS';
			 $CANTIDADCARGADA           = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
			 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";			 
		   }else{
			 $MERCANCIAREMESA           = "<MERCANCIAREMESA>{$MERCANCIAINFORMACIONCARGA}</MERCANCIAREMESA>";
			 $CANTIDADCARGADA           = "<CANTIDADCARGADA>{$CANTIDADINFORMACIONCARGA}</CANTIDADCARGADA>";
			 $UNIDADMEDIDACAPACIDAD     = "<UNIDADMEDIDACAPACIDAD>{$UNIDADMEDIDACAPACIDAD}</UNIDADMEDIDACAPACIDAD>";			 		
			 }	
		   
		   
		 if($CODOPERACIONTRANSPORTE == 'C' || $CODOPERACIONTRANSPORTE == 'V'){  
		   $PESOCONTENEDORVACIO	= "<PESOCONTENEDORVACIO>{$peso}</PESOCONTENEDORVACIO>";		      		   
		 }else{
			 $PESOCONTENEDORVACIO = NULL;		      		   
		   }
		   
		   
		 if($CODTIPOIDPROPIETARIO != 'N'){
		   //$CODSEDEPROPIETARIO = 0;
		 } 
		 
		 if($CODTIPOIDREMITENTE != 'N'){
		   //$CODSEDEREMITENTE = 0;
		 }
		 
		 if($CODTIPOIDDESTINATARIO != 'N'){
		   //$CODSEDEDESTINATARIO = 0;
		 }
		 
		 if($FECHASALIDACARGUE > $FECHACITAPACTADADESCARGUE){
		   $FECHACITAPACTADADESCARGUE = $FECHASALIDACARGUE;
		 }
		 
	    	 
		   
	   $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
		  <root> 
			<acceso> 
			 <username>{$this -> username}</username> 
			 <password>{$this -> password}</password> 
			 <ambiente>{$this -> ambiente}</ambiente>			
			</acceso> 
			
			<solicitud> 
			 <tipo>1</tipo> 
			 <procesoid>3</procesoid> 
			</solicitud> 
			
			<variables> 
			 <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			 <CONSECUTIVOINFORMACIONCARGA>{$CONSECUTIVOINFORMACIONCARGA}</CONSECUTIVOINFORMACIONCARGA> 
			 <CONSECUTIVOREMESA>{$CONSECUTIVOREMESA}</CONSECUTIVOREMESA>
			 <NATURALEZACARGA>{$NATURALEZACARGA}</NATURALEZACARGA>
			 {$MERCANCIAREMESA}
			 <DESCRIPCIONCORTAPRODUCTO>{$DESCRIPCIONCORTAPRODUCTO}</DESCRIPCIONCORTAPRODUCTO>
			 {$CANTIDADCARGADA}
			 <CODTIPOIDPROPIETARIO>{$CODTIPOIDPROPIETARIO}</CODTIPOIDPROPIETARIO> 
			 <CODSEDEPROPIETARIO>{$CODSEDEPROPIETARIO}</CODSEDEPROPIETARIO>
			 <NUMIDPROPIETARIO>{$NUMIDPROPIETARIO}</NUMIDPROPIETARIO>				 
			 <CODSEDEREMITENTE>{$CODSEDEREMITENTE}</CODSEDEREMITENTE>
			 <REMREMITENTE>{$REMREMITENTE}</REMREMITENTE>
			 <REMDIRREMITENTE>{$REMDIRREMITENTE}</REMDIRREMITENTE>
			 <CODSEDEDESTINATARIO>{$CODSEDEDESTINATARIO}</CODSEDEDESTINATARIO>
			 <REMDESTINATARIO>{$REMDESTINATARIO}</REMDESTINATARIO>
			 <REM_ORIG>{$REM_ORIG}</REM_ORIG>
			 <REM_DESTI>{$REM_DESTI}</REM_DESTI>
			 <DUENOPOLIZA>{$DUENOPOLIZA}</DUENOPOLIZA>
			 <NUMPOLIZATRANSPORTE>{$NUMPOLIZATRANSPORTE}</NUMPOLIZATRANSPORTE> 			   			   
			 <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE> 
			 <CODTIPOEMPAQUE>{$CODTIPOEMPAQUE}</CODTIPOEMPAQUE> 
			 {$UNIDADMEDIDACAPACIDAD}
			 <CODTIPOIDREMITENTE>{$CODTIPOIDREMITENTE}</CODTIPOIDREMITENTE> 
			 <CODTIPOIDDESTINATARIO>{$CODTIPOIDDESTINATARIO}</CODTIPOIDDESTINATARIO> 
			 <COMPANIASEGURO>{$COMPANIASEGURO}</COMPANIASEGURO> 
			 <HORASPACTOCARGA>12</HORASPACTOCARGA>
			 <MINUTOSPACTOCARGA>0</MINUTOSPACTOCARGA>
			 <HORASPACTODESCARGUE>12</HORASPACTODESCARGUE>
			 <MINUTOSPACTODESCARGUE>0</MINUTOSPACTODESCARGUE>			   
			 <FECHACITAPACTADACARGUE>{$FECHACITAPACTADACARGUE}</FECHACITAPACTADACARGUE>
			 <HORACITAPACTADACARGUE>{$HORACITAPACTADACARGUE}</HORACITAPACTADACARGUE>
			 <FECHACITAPACTADADESCARGUE>{$FECHACITAPACTADADESCARGUE}</FECHACITAPACTADADESCARGUE>
			 <HORACITAPACTADADESCARGUEREMESA>{$HORACITAPACTADADESCARGUEREMESA}</HORACITAPACTADADESCARGUEREMESA>	
			 <FECHALLEGADACARGUE>{$FECHALLEGADACARGUE}</FECHALLEGADACARGUE>
			 <HORALLEGADACARGUEREMESA>{$HORALLEGADACARGUEREMESA}</HORALLEGADACARGUEREMESA>
			 <FECHAENTRADACARGUE>{$FECHAENTRADACARGUE}</FECHAENTRADACARGUE>
			 <HORAENTRADACARGUEREMESA>{$HORAENTRADACARGUEREMESA}</HORAENTRADACARGUEREMESA>
			 <FECHASALIDACARGUE>{$FECHASALIDACARGUE}</FECHASALIDACARGUE>
			 <HORASALIDACARGUEREMESA>{$HORASALIDACARGUEREMESA}</HORASALIDACARGUEREMESA>
			</variables> 
		   </root>";
				
		   
		   $path_xml  = "{$this -> ruta_archivos}remesa_{$CONSECUTIVOREMESA}.xml";
			   
	     }else{
		   $msj = file_get_contents($path_xml);
		  }
		 
		 /*
		 if(!$Model -> infoCargaEstaReportada($remesa_id,$Conex)){
		 		   
		   $dataRemesa   = $Model -> selectRemesa($remesa_id,$this -> Conex);	   	   
	 
		   $dataIC = array(	  
	
			 remesa_id                           => $dataRemesa[0]['remesa_id'],	
			 numero_remesa                       => $dataRemesa[0]['numero_remesa'],
			 tipo_remesa_id                      => $dataRemesa[0]['tipo_remesa_id'],
			 fecha_recogida_ss                   => $dataRemesa[0]['fecha_recogida_ss'],
			 hora_recogida_ss                    => $dataRemesa[0]['hora_recogida_ss'],
			 empaque_id                          => $dataRemesa[0]['empaque_id'],
			 naturaleza_id                       => $dataRemesa[0]['naturaleza_id'],
			 descripcion_producto                => $dataRemesa[0]['descripcion_producto'],
			 producto_id                         => $dataRemesa[0]['producto_id'],
			 cantidad                            => $dataRemesa[0]['cantidad'],
			 peso                                => $dataRemesa[0]['peso'],		
			 medida_id                           => $dataRemesa[0]['medida_id'],
			 remitente_id                        => $dataRemesa[0]['remitente_id'],
			 destinatario_id                     => $dataRemesa[0]['destinatario_id'],
			 observaciones                       => $dataRemesa[0]['observaciones']
	
		  );
		  
		  $this -> sendInformacionCarga($dataIC,NULL,false);		   
		 
		 
		 }*/
			   
		$fp = fopen($path_xml, 'w');
		fwrite($fp,"$msj");
		fclose($fp);
		   
		$aParametros   = array("Request" => $msj);
		$this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 $respuesta ='<div id="message">No se pudo completar la operaci&oacute;n</div>';
		 $Model -> setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
		 if($printMsj)echo $respuesta;
		 
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 
		    $respuesta ='<div id="message">Error:'. $sErro.'</div>';
		    $Model -> setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
		    if($printMsj)echo $respuesta;						
		  }else{
		  
			   if(preg_match("/ingresoid/i","$respuesta")){

                 require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				 
                 $contenido = $respuesta;
                 $resultado = xml2array($contenido);			   
			     $ingresoid = $resultado['root']['ingresoid'];
				 
				 $Model -> setAprobacionRemesa($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);
				 if($printMsj)echo'<div id="message">Reportado Exitosamente!!</div>';						
			   
			   }else{			   
			   
				  
				  $Model -> setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$this -> Conex);
				  				  
				  if(preg_match("/ya fue convertida a Remesa/i","$respuesta")){
				   $ingresoid = 0;
				   $Model -> setAprobacionRemesa($manifiesto_id,$remesa_id,$ingresoid,$this -> Conex);
				   if($printMsj)echo'<div id="message">Reportado Exitosamente!!</div>';						
                  }elseif(preg_match("/Connection refused./i","$respuesta")){
                   if($printMsj) echo"<div align='center' id='message'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
                  }else if(preg_match("/listener could not find/i","$respuesta")){
				     if($printMsj)echo"<div align='center' id='message'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				 }else{
					 if($printMsj)echo"<div id='message'>Error reportando Remesas, revise el log de errores<br></div>";
				   }
											 
			   }									 						
						
			}
		
	   } 				   
			   
	 
	 }
	 
	 
	 public function sendInformacionManifiesto($data,$path_xml = NULL,$printMsj = true){	 
	  
         require_once("WebServiceMinTranporteModelClass.php");	 	  
				
         $Model = new WebServiceMinTransporteModel();	
		 
		 if(is_null($path_xml)){
					 
			 $manifiesto_id                 = $data[0]['manifiesto_id'];
			 $placa_id                      = $data[0]['placa_id']; 
			 $informacion_viaje             = $data[0]['informacion_viaje']; 
			 $dataRemesas                   = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> Conex);				 
			 $NUMMANIFIESTOCARGA            = $data[0]['manifiesto'];
			 $CONSECUTIVOINFORMACIONVIAJE   = $informacion_viaje;
			 $NUMPLACA                      = $data[0]['placa'];
			 $NUMPLACAREMOLQUE              = $data[0]['placa_remolque'];
			 $CODIDCONDUCTOR                = $Model->getCodTipoIdentificacionConductorManifiesto($data[0]['conductor_id'],
											  $this-> Conex);
			 $NUMIDCONDUCTOR                = $data[0]['numero_identificacion'];
			 
			 $CODOPERACIONTRANSPORTE        = $Model -> getCodTipoManifiesto($data[0]['tipo_manifiesto_id'],$this -> Conex);
			 $FECHAEXPEDICIONMANIFIESTO     = date("d/m/Y",strtotime($data[0]['fecha_mc']));
			 $CODMUNICIPIOORIGENMANIFIESTO  = str_pad($data[0]['origen_id'],8, "0", STR_PAD_LEFT);
			 $CODMUNICIPIODESTINOMANIFIESTO = str_pad($data[0]['destino_id'],8, "0", STR_PAD_LEFT);
			 $CODIDTITULARMANIFIESTO        = $Model->getCodTipoIdentificacionTitularManifiesto($data[0]['titular_manifiesto_id'],$this-> Conex);
			 $NUMIDTITULARMANIFIESTO        = $data[0]['numero_identificacion_titular_manifiesto'];
			 $VALORFLETEPACTADOVIAJE        = $data[0]['valor_flete'];
			 $RETENCIONICAMANIFIESTOCARGA   = $Model -> getRetencionicaManifiesto($manifiesto_id,$this -> Conex);
			 $VALORANTICIPOMANIFIESTO       = $Model -> getAnticipoManifiesto($manifiesto_id,$this -> Conex);
			 $CODMUNICIPIOPAGOSALDO         = $Model -> getCodCiudadPagoSaldo($manifiesto_id,$this -> Conex);
			 $FECHAPAGOSALDOMANIFIESTO      = date("d/m/Y",strtotime($data[0]['fecha_pago_saldo']));
			 $CODRESPONSABLEPAGOCARGUE      = $data[0]['cargue_pagado_por'];
			 $CODRESPONSABLEPAGODESCARGUE   = $data[0]['descargue_pagado_por'];
			 $OBSERVACIONES                 = $data[0]['observaciones'];	
	
			 $RemesasMan = "<REMESASMAN procesoid='43'>";
						  
			 for($i = 0; $i < count($dataRemesas); $i++){
		
			   $remesa_id = $dataRemesas[$i]['remesa_id'];
			   
			   if(!$Model -> remesaEstaReportada($remesa_id,$this -> Conex)){
			   
				   $dataRemesa   = $Model -> selectRemesa($remesa_id,$this -> Conex);	   	   
		 
				   $dataR = array(	  
			
			         manifiesto_id                       => $manifiesto_id,
					 remesa_id                           => $dataRemesa[0]['remesa_id'],	
					 numero_remesa                       => $dataRemesa[0]['numero_remesa'],
					 tipo_remesa_id                      => $dataRemesa[0]['tipo_remesa_id'],
					 fecha_recogida_ss                   => $dataRemesa[0]['fecha_recogida_ss'],
					 hora_recogida_ss                    => $dataRemesa[0]['hora_recogida_ss'],
					 empaque_id                          => $dataRemesa[0]['empaque_id'],
					 naturaleza_id                       => $dataRemesa[0]['naturaleza_id'],
					 descripcion_producto                => $dataRemesa[0]['descripcion_producto'],
					 producto_id                         => $dataRemesa[0]['producto_id'],
					 cantidad                            => $dataRemesa[0]['cantidad'],
					 peso                                => $dataRemesa[0]['peso'],		
					 medida_id                           => $dataRemesa[0]['medida_id'],
					 remitente_id                        => $dataRemesa[0]['remitente_id'],
					 destinatario_id                     => $dataRemesa[0]['destinatario_id'],
					 observaciones                       => $dataRemesa[0]['observaciones'],
					 propietario_mercancia_id            => $dataRemesa[0]['propietario_mercancia_id'],
					 tipo_identificacion_remitente_id    => $dataRemesa[0]['tipo_identificacion_remitente_id'],
					 doc_remitente                       => $dataRemesa[0]['doc_remitente'],
					 direccion_remitente                 => $dataRemesa[0]['direccion_remitente'],
					 remitente_id                        => $dataRemesa[0]['remitente_id'],
					 tipo_identificacion_destinatario_id => $dataRemesa[0]['tipo_identificacion_destinatario_id'],
					 destinatario_id                     => $dataRemesa[0]['destinatario_id'],
					 doc_destinatario                    => $dataRemesa[0]['doc_destinatario'],
					 origen_id                           => $dataRemesa[0]['origen_id'],
					 destino_id                          => $dataRemesa[0]['destino_id'],
					 observaciones                       => $dataRemesa[0]['observaciones'],
					 amparada_por                        => $dataRemesa[0]['amparada_por'],
					 numero_poliza                       => $dataRemesa[0]['numero_poliza'],
					 fecha_vencimiento_poliza            => $dataRemesa[0]['fecha_vencimiento_poliza'],
					 aseguradora_id                      => $dataRemesa[0]['aseguradora_id'],
					 fecha_recogida_ss                   => $dataRemesa[0]['fecha_recogida_ss'],
					 hora_recogida_ss                    => $dataRemesa[0]['hora_recogida_ss']
					 
			
				  );
												
				   $this -> sendInformacionRemesa($dataR,NULL,false);
			   
			   }
		
			   $numero_remesa = $dataRemesas[$i]['numero_remesa'];
			   $RemesasMan   .= "<REMESA><CONSECUTIVOREMESA>{$numero_remesa}</CONSECUTIVOREMESA></REMESA>"; 
			  
			 }
			 /*
			 if(!$Model -> informacionViajeFueReportada($manifiesto_id,$this -> Conex)){
			 
			   $dataInfoViaje = $Model -> selectDataInfoViaje($manifiesto_id,$this -> Conex);	   	   
		 
			   $dataIV = array(	  	
				 manifiesto_id                        => $manifiesto_id,	
				 manifiesto                           => $dataInfoViaje[0]['manifiesto'],	
				 conductor_id                         => $dataInfoViaje[0]['conductor_id'],			 				 		 
				 tipo_identificacion_conductor_codigo => $dataInfoViaje[0]['tipo_identificacion_conductor_codigo'],	
				 numero_identificacion                => $dataInfoViaje[0]['numero_identificacion'],	
				 placa_id                             => $dataInfoViaje[0]['placa_id'],			 				 
				 placa                                => $dataInfoViaje[0]['placa'],	
				 placa_remolque_id                    => $dataInfoViaje[0]['placa_remolque_id'],					 
				 placa_remolque                       => $dataInfoViaje[0]['placa_remolque'],			
				 origen_id                            => $dataInfoViaje[0]['origen_id'],			
				 destino_id                           => $dataInfoViaje[0]['destino_id'],			
				 valor_flete                          => $dataInfoViaje[0]['valor_flete'],		
				 remesas                              => $dataInfoViaje[0]['remesas']	
			   );
			  
			   $this -> sendInformacionViaje($dataIV,NULL,false);			   
			 
			 }*/
			 
			 if($Model -> vehiculoEsdelaTransportadora($this -> numnitempresatransporte,$placa_id,$this -> Conex)){
			   $VALORFLETEPACTADOVIAJE      = '<VALORFLETEPACTADOVIAJE>0</VALORFLETEPACTADOVIAJE>';
			   $RETENCIONICAMANIFIESTOCARGA = NULL; 
			   $VALORANTICIPOMANIFIESTO     = NULL; 
			   $CODMUNICIPIOPAGOSALDO       = NULL; 
			   $FECHAPAGOSALDOMANIFIESTO    = NULL; 	 
			 }else{
				$VALORFLETEPACTADOVIAJE      = "<VALORFLETEPACTADOVIAJE>{$VALORFLETEPACTADOVIAJE}</VALORFLETEPACTADOVIAJE>";
				$RETENCIONICAMANIFIESTOCARGA = "<RETENCIONICAMANIFIESTOCARGA>{$RETENCIONICAMANIFIESTOCARGA}</RETENCIONICAMANIFIESTOCARGA>"; 
				$VALORANTICIPOMANIFIESTO  = "<VALORANTICIPOMANIFIESTO>{$VALORANTICIPOMANIFIESTO}</VALORANTICIPOMANIFIESTO>"; 
				$CODMUNICIPIOPAGOSALDO    = "<CODMUNICIPIOPAGOSALDO>{$CODMUNICIPIOPAGOSALDO}</CODMUNICIPIOPAGOSALDO>"; 
				$FECHAPAGOSALDOMANIFIESTO = "<FECHAPAGOSALDOMANIFIESTO>{$FECHAPAGOSALDOMANIFIESTO}</FECHAPAGOSALDOMANIFIESTO>"; 
			   }
			   
			 if($Model -> esVehiculoRigido($placa_id,$this -> Conex)){
			  $NUMPLACAREMOLQUE = NULL;
			 }else{
				$NUMPLACAREMOLQUE = "<NUMPLACAREMOLQUE>{$NUMPLACAREMOLQUE}</NUMPLACAREMOLQUE>";
			  }		    		   
					  
			 $RemesasMan .= "</REMESASMAN>";	     
		  
			 $msj = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
				 <username>{$this -> username}</username> 
				 <password>{$this -> password}</password> 
				 <ambiente>{$this -> ambiente}</ambiente>	
			  </acceso> 
			  
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>4</procesoid> 
			  </solicitud> 
			  
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>{$this -> numnitempresatransporte}</NUMNITEMPRESATRANSPORTE> 
			   <NUMMANIFIESTOCARGA>{$NUMMANIFIESTOCARGA}</NUMMANIFIESTOCARGA> 
			   <CONSECUTIVOINFORMACIONVIAJE>{$CONSECUTIVOINFORMACIONVIAJE}</CONSECUTIVOINFORMACIONVIAJE> 
			   <CODOPERACIONTRANSPORTE>{$CODOPERACIONTRANSPORTE}</CODOPERACIONTRANSPORTE> 
			   <FECHAEXPEDICIONMANIFIESTO>{$FECHAEXPEDICIONMANIFIESTO}</FECHAEXPEDICIONMANIFIESTO> 
			   <CODMUNICIPIOORIGENMANIFIESTO>{$CODMUNICIPIOORIGENMANIFIESTO}</CODMUNICIPIOORIGENMANIFIESTO> 
			   <CODMUNICIPIODESTINOMANIFIESTO>{$CODMUNICIPIODESTINOMANIFIESTO}</CODMUNICIPIODESTINOMANIFIESTO> 
			   <CODIDTITULARMANIFIESTO>{$CODIDTITULARMANIFIESTO}</CODIDTITULARMANIFIESTO> 
			   <NUMIDTITULARMANIFIESTO>{$NUMIDTITULARMANIFIESTO}</NUMIDTITULARMANIFIESTO> 
			   <NUMPLACA>{$NUMPLACA}</NUMPLACA>	
			   {$NUMPLACAREMOLQUE}
			   <CODIDCONDUCTOR>{$CODIDCONDUCTOR}</CODIDCONDUCTOR>
			   <NUMIDCONDUCTOR>{$NUMIDCONDUCTOR}</NUMIDCONDUCTOR>	
			   {$VALORFLETEPACTADOVIAJE}
			   {$RETENCIONICAMANIFIESTOCARGA}
			   {$VALORANTICIPOMANIFIESTO}
			   {$CODMUNICIPIOPAGOSALDO}
			   {$FECHAPAGOSALDOMANIFIESTO}
			   <CODRESPONSABLEPAGOCARGUE>{$CODRESPONSABLEPAGOCARGUE}</CODRESPONSABLEPAGOCARGUE> 
			   <CODRESPONSABLEPAGODESCARGUE>{$CODRESPONSABLEPAGODESCARGUE}</CODRESPONSABLEPAGODESCARGUE> 
			   <OBSERVACIONES>{$OBSERVACIONES}</OBSERVACIONES> 
			   $RemesasMan
			 </variables>
			</root>";
			 
			 $path_xml  = "{$this -> ruta_archivos}manifiesto_{$NUMMANIFIESTOCARGA}.xml";
			   
		}else{

		    $msj = file_get_contents($path_xml);
		  }
		   
		$aParametros = array("Request" => $msj); $this -> setOSoapClient($this -> Conex);
		$this -> setOSoapClient($this -> Conex);
		$respuesta   = $this -> oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
		
		if ($respuesta=='') { 
		 $respuesta = "No se pudo completar la operaci&oacute;n";
		 $Model -> setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$this -> Conex);
		 echo "<div id='message'>$respuesta</div>";
		} else { 
		
		  $sError ='';
		
		  if ($sError!='') { 			
		   $respuesta = 'Error:'. $sError;
		   $Model -> setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$this -> Conex);
		   echo $respuesta = '<div id="message">'.$respuesta.'</div>';;
			
		  }else{
		  
			   if(preg_match("/ingresoid/i","$respuesta")){

				 $resultado = xml2array($contenido);			   
				 $ingresoid = $resultado['root']['ingresoid'];
				 $observacionesqr = $resultado['root']['observacionesqr'];
				 $seguridadqr = $resultado['root']['seguridadqr'];
						
				 $Model -> setAprobacionManifiesto($manifiesto_id,$informacion_viaje,$ingresoid,$observacionesqr,$seguridadqr,$this -> Conex);
				 
				 echo"<div id='message'>Reportado Exitosamente</div>";
			   
			   }else{			   			   
				  
				  $Model -> setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$this -> Conex);
				  
				  if(preg_match("/Connection refused./i","$respuesta")){
                    echo"<div id='message' align='center'><b>El servidor del Ministerio no acepto la Conexion</b><br>intente de nuevo en unos minutos.</div>";
                 }else if(preg_match("/listener could not find/i","$respuesta")){
					 echo"<div id='message' align='center'><b>El servidor del Ministerio de Transporte no se encuentra disponible</b><br>intente de nuevo en unos minutos.</div>";
				  }else{
					  echo"<div id='message'>Error reportando Manifiesto, revise el log de errores</div>";
					}
											 
			   }										 						
						
			}
		
		} 		

	 
	 }
	 
  public function limpioCaracteresXML($cadena){

    $search  = array("<", ">", "&", "'");
    $replace = array("&lt;", "&gt", "&amp;", "&apos");
    $final = str_replace($search, $replace, $cadena);
    return $final;

  }	 
	
 }
 
 ###################################
 #        tipo
 ###################################
 # 1. Registrar
 # 3. Consultar
 ###################################
 #        procesoid                #
 ###################################
 # 1 : Registrar Información de Carga
 # 2 : Registrar Información de Viaje
 # 3 : Expedir Remesa Terrestre de Carga
 # 4 : Expedir Manifiesto de Carga
 # 5 : Cumplir Remesa Terrestre de Carga
 # 6 : Cumplir Manifiesto de Carga
 # 7 : Anular Información de Carga
 # 8 : Anular Información del Viaje
 # 9 : Anular Remesa Terrestre de Carga
 # 11: Crear o Actualizar datos de Tercero
 # 12: Crear o Actualizar datos de Vehículo
 # 17. Diccionario de Datos
 # 27: Diccionario de Errores
 # 32: Anular Manifiesto de Carga
?>