<?php

$user                = "GERENTE@3893";
$passwordd                = "Gerente3893";
$ambiente                = "R";
$numnitempresatransporte = "9010054351";
$printMsj = true;


$hostname = "localhost";
$database = "siandsi4_trans_alejandria";
$username = "siandsi4_tranale";
$password = "_mLmn!&Fd-;Y";
$site_link = mysql_connect($hostname, $username, $password) or trigger_error(mysqli_error()); 
mysql_select_db($database,$site_link);

$getConex = array('conex' => $site_link,'Rdbms' =>'MYSQL');

require_once("WebServiceMinTranporteClass.php");
require_once("WebServiceMinTranporteModelClass.php");

$Class  = new WebServiceMinTransporte($getConex);
$Model  = new WebServiceMinTransporteModel();

$h = @get_headers('http://rndcws2.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices');
$status = array();
preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0] , $status);

	if($status[1] == 200){ 
		$wsdl          = 'http://rndcws2.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices';
	}else{
		$wsdl          = 'http://rndcws.mintransporte.gov.co:8080/ws/svr008w.dll/wsdl/IBPMServices';
	}
				
$oSoapClient   = new SoapClient($wsdl);


//inicio consulta manifistos propios
//inicio consulta manifistos propios
$query_propio= "SELECT m.*,
                (SELECT l.legalizacion_manifiesto_id FROM legalizacion_manifiesto l WHERE l.manifiesto_id=m.manifiesto_id)AS legalizacion_manifiesto_id

                FROM manifiesto m WHERE m.propio = 1 AND m.aprobacion_ministerio3 IS NULL
 	            AND m.aprobacion_ministerio2 IS NOT NULL AND (m.estado='L') AND (DATEDIFF(CURDATE(),m.fecha_mc)) > 15  LIMIT 0,80";

$propio = mysql_query($query_propio) or die(mysqli_error());


//inicio consulta manifistos no propios
$query_noPropio = "SELECT m.*,
                   (SELECT l.liquidacion_despacho_id FROM liquidacion_despacho l WHERE l.manifiesto_id=m.manifiesto_id)AS liquidacion_despacho_id,
                   (SELECT r.numero_remesa
					FROM remesa r WHERE r.remesa_id IN (SELECT de.remesa_id FROM detalle_despacho de WHERE 
					de.manifiesto_id = m.manifiesto_id) GROUP BY m.manifiesto_id)AS remesas
                   
                   FROM manifiesto m WHERE m.propio = 0 AND m.aprobacion_ministerio3 IS NULL
 	               AND m.aprobacion_ministerio2 IS NOT NULL AND (m.estado='L') AND (DATEDIFF(CURDATE(),m.fecha_mc)) > 15 AND (DATEDIFF(CURDATE(),m.fecha_mc)) < 99 LIMIT 0,80";
 	              
$no_propio = mysql_query($query_noPropio) or die(mysqli_error());


//propios
if(mysqli_num_rows($propio)>0){ 

	 for($i = 0; $Row = mysqli_fetch_assoc($propio); $i++){				
	     $Table[$i] = $Row;
	 }
	 
	 for($i = 0; $i<count($Table); $i++){

		$manifiesto_id = $Table[$i]['manifiesto_id'];
		$data_remesa="SELECT r.*
						FROM remesa r WHERE r.remesa_id IN (SELECT de.remesa_id FROM detalle_despacho de WHERE 
						de.manifiesto_id = $manifiesto_id) AND r.aprobacion_ministerio3 IS NULL";
					//echo $data_remesa."\n"; 
		$data_rem = mysql_query($data_remesa);
		$num_remesas = mysqli_num_rows($data_rem);
	    
		if($num_remesas>0){

			for($k = 0; $Row = mysqli_fetch_assoc($data_rem); $k++){				
	            $Data[$k] = $Row;
			}
			
	        for($j =0; $j<count($Data); $j++){

				$legalizacion_manifiesto_id        = $Table[$i]['legalizacion_manifiesto_id']; 

		        if($legalizacion_manifiesto_id>0){
			           $dataManifiesto  = $Model -> getDataManifiestoLiquidacionPropio($legalizacion_manifiesto_id,$getConex);//ok
				}else{
			           $dataManifiesto   = $Model -> getDataManifiestoLiquidacionMan($manifiesto_id,$getConex);//ok	
		        }

				require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				
				if($Data[$j]['remesa_id'] > 0){
                
                   			if(!$Model -> getEstaCumplidaRemesa($Data[$j]['remesa_id'],$getConex)){
							$CONSECUTIVOREMESA = $Data[$j]['numero_remesa'];
							$remesa_id = $Data[$j]['remesa_id'];			
							$TIPOCUMPLIDOREMESA =  $Data[$j]['estado']!='AN'?'C':'S';
							$observacion_anulacion = $Model -> getObservacionANulacion($Data[$j]['remesa_id'],$getConex);
							$CANTIDADCARGADA = $Data[$j]['peso'];
							$CANTIDADENTREGADA = $Data[$j]['peso_costo']>0? $Data[$j]['peso_costo']:$Data[$j]['peso'];			


							$CANTIDADCARGADA = $CANTIDADCARGADA>0 ? $CANTIDADCARGADA : 10;
							$CANTIDADENTREGADA = $CANTIDADENTREGADA>0 ? $CANTIDADENTREGADA : 10;		

							$DESCARGUE = $Model -> getDatosDescargue($manifiesto_id,$Data[$j]['cliente_id'],$getConex);
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
				
							
							
							if($Data[$j]['estado']!='AN'){
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
							<username>$user</username> 
							<password>$passwordd</password> 
							<ambiente>$ambiente</ambiente>
							</acceso> 
							
							<solicitud> 
							<tipo>1</tipo> 
							<procesoid>5</procesoid> 
							</solicitud> 
							
							<variables> 
							<NUMNITEMPRESATRANSPORTE>$numnitempresatransporte</NUMNITEMPRESATRANSPORTE> 
				
								<CONSECUTIVOREMESA>$CONSECUTIVOREMESA</CONSECUTIVOREMESA>
								<NUMMANIFIESTOCARGA>$NUMMANIFIESTOCARGA</NUMMANIFIESTOCARGA>
								<TIPOCUMPLIDOREMESA>$TIPOCUMPLIDOREMESA</TIPOCUMPLIDOREMESA>
								$MOTIVOSUSPENSIONREMESA
								<CANTIDADCARGADA>$CANTIDADCARGADA</CANTIDADCARGADA>
								<CANTIDADENTREGADA>$CANTIDADENTREGADA</CANTIDADENTREGADA>
				
								<FECHALLEGADADESCARGUE>$FECHALLEGADADESCARGUE</FECHALLEGADADESCARGUE>
								<HORALLEGADADESCARGUECUMPLIDO>$HORALLEGADADESCARGUECUMPLIDO</HORALLEGADADESCARGUECUMPLIDO>
								
								<FECHAENTRADADESCARGUE>$FECHAENTRADADESCARGUE</FECHAENTRADADESCARGUE>
								<HORAENTRADADESCARGUECUMPLIDO>$HORAENTRADADESCARGUECUMPLIDO</HORAENTRADADESCARGUECUMPLIDO>
								<FECHASALIDADESCARGUE>$FECHASALIDADESCARGUE</FECHASALIDADESCARGUE>
								<HORASALIDADESCARGUECUMPLIDO>$HORASALIDADESCARGUECUMPLIDO</HORASALIDADESCARGUECUMPLIDO>
								
							</variables> 
							</root>";
				            
							$aParametros   = array("Request" => $msj);
							$Class -> setOSoapClient($getConex);
							$respuesta   = $oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
								
							if ($respuesta=='') { 
								$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
								$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$getConex);
								if($printMsj) echo $respuesta;					 
							}else{ 
									
								$sError ='';
									
								if ($sError!='') { 
									$respuesta =  '<div id="message">Error:'. $sError.'</div>';
									$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$getConex);
									if($printMsj) echo $respuesta;						
								}else{
									
									if(preg_match("/ingresoid/i","$respuesta")){
										$contenido = $respuesta;
										$resultado = xml2array($contenido);			   
										$ingresoid = $resultado['root']['ingresoid'];
										$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$getConex);	
										if($printMsj)echo("Remesa ".$Data[$j]['numero_remesa']." Cumplida Exitosamente<br>");
										
									}else{			   
										
										$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$getConex);
																		
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
													
													$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$respuesta_final,$getConex);	 
													if($printMsj)echo("<br>Previamente reportado<br>");									
											}else{
												if($printMsj)echo("<br>Error reportando Cumplido de Remesa, revise el log de errores:<br>".$respuesta);
												
											}

										}
																		
									}									 						
													
								}
									
							} 
						}else{
							echo "Remesa ".$Data[$j]['numero_remesa']." Previamente Cumplida<br>";	
						}
                    

				}

			}//cierra for de remesas
		}//cierra validacion num remesa > 0

		//aca xml manifiestos

		$manifiesto_id       			= $Table[$i]['manifiesto_id']; //ok	 
		$legalizacion_manifiesto_id        =$Table[$i]['legalizacion_manifiesto_id']; //ok	
	
		if($legalizacion_manifiesto_id>0){
			$dataManifiesto                 = $Model -> getDataManifiestoLiquidacionPropio($legalizacion_manifiesto_id,$getConex);//ok
		}else{
			$dataManifiesto   = $Model -> getDataManifiestoLiquidacionMan($manifiesto_id,$getConex);//ok	
		}

		$NUMMANIFIESTOCARGA             = $Table[$i]['manifiesto'];//ok
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
		
		//$remesas             			= $data['remesas'];
		
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
		
		if(!$Model -> getEstaCumplidaManifiesto($manifiesto_id,$getConex)){
			
			$msj1 = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
			   <username>$user</username> 
			   <password>$passwordd</password> 
			   <ambiente>$ambiente</ambiente>
			  </acceso> 
			  
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>6</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>$numnitempresatransporte</NUMNITEMPRESATRANSPORTE> 
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
			 $Class -> setOSoapClient($getConex);
			 $respuesta   = $oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 
					
			 if ($respuesta=='') { 
				$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
				$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$getConex);
				if($printMsj) echo $respuesta;					 
			 }else{ 
					
				$sError ='';
					
				if ($sError!='') { 
					$respuesta =  '<div id="message">Error:'. $sError.'</div>';
					$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$getConex);
					if($printMsj) echo $respuesta;						
				}else{
					  
					if(preg_match("/ingresoid/i","$respuesta")){
						$contenido = $respuesta;
						$resultado = xml2array($contenido);			   
						$ingresoid = $resultado['root']['ingresoid'];
						$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$getConex);	
						if($printMsj)echo("<br>Manifiesto ".$Table[$i]['manifiesto']." Cumplido Exitosamente<br>");
						   
					}else{			   
						   
						$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$getConex);
														  
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
									
									$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$respuesta_final,$getConex);	 
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

	 }//cierra for de propios

}//cierra si es propio


//no propios
if(mysqli_num_rows($no_propio)>0){
	
 for($i = 0; $Row = mysqli_fetch_assoc($no_propio); $i++){				
	 $Table[$i] = $Row;
 }
 
for($i = 0; $i<count($Table); $i++){
	
     $manifiesto_id = $Table[$i]['manifiesto_id'];
		$data_remesa="SELECT r.*
						FROM remesa r WHERE r.remesa_id IN (SELECT de.remesa_id FROM detalle_despacho de WHERE 
						de.manifiesto_id = $manifiesto_id) AND r.aprobacion_ministerio3 IS NULL";
					//echo $data_remesa."\n"; 
		$data_rem = mysql_query($data_remesa);
		$num_remesas = mysqli_num_rows($data_rem);
	    
	  if($num_remesas>0){

		    for($k = 0; $Row = mysqli_fetch_assoc($data_rem); $k++){				
	           $Data[$k] = $Row;
			}
			
	        for($j =0; $j<count($Data); $j++){

	        	$liquidacion_despacho_id  = $Table[$i]['liquidacion_despacho_id'];

	        	if($liquidacion_despacho_id>0){
			        $dataManifiesto                 = $Model -> getDataManifiestoLiquidacion($liquidacion_despacho_id,$getConex);//ok
				}

				require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/xml2array.php");
				
	        	if($Data[$j]['remesa_id']>0){	
	        		//echo("***manifiesto--".$manifiesto_id."-numero_remesa--".$Data[$j]['numero_remesa']."<br>");

	        	if(!$Model -> getEstaCumplidaRemesa($Data[$j]['remesa_id'],$getConex)){

				$CONSECUTIVOREMESA = $Data[$j]['numero_remesa'];
				$remesa_id = $Data[$j]['remesa_id'];			
				$TIPOCUMPLIDOREMESA =  $Data[$j]['estado']!='AN'?'C':'S';
				$observacion_anulacion = $Model -> getObservacionANulacion($Data[$j]['remesa_id'],$getConex);
				$CANTIDADCARGADA =$Data[$j]['peso'];
				$CANTIDADENTREGADA = $Data[$j]['peso_costo']>0? $Data[$j]['peso_costo']:$Data[$j]['peso'];			

				$CANTIDADCARGADA = $CANTIDADCARGADA>0 ? $CANTIDADCARGADA : 10;
				$CANTIDADENTREGADA = $CANTIDADENTREGADA>0 ? $CANTIDADENTREGADA : 10;		

				$DESCARGUE = $Model -> getDatosDescargue($manifiesto_id,$Data[$j]['cliente_id'],$getConex);
				
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
	
				
				
				if( $Data[$j]['estado']!='AN'){
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
				   <username>$user</username> 
				   <password>$passwordd</password> 
				   <ambiente>$ambiente</ambiente>
				  </acceso> 
				  
				  <solicitud> 
				   <tipo>1</tipo> 
				   <procesoid>5</procesoid> 
				  </solicitud> 
				  
				  <variables> 
				   <NUMNITEMPRESATRANSPORTE>$numnitempresatransporte</NUMNITEMPRESATRANSPORTE> 
	
					<CONSECUTIVOREMESA>$CONSECUTIVOREMESA</CONSECUTIVOREMESA>
					<NUMMANIFIESTOCARGA>$NUMMANIFIESTOCARGA</NUMMANIFIESTOCARGA>
					<TIPOCUMPLIDOREMESA>$TIPOCUMPLIDOREMESA</TIPOCUMPLIDOREMESA>
					$MOTIVOSUSPENSIONREMESA
					<CANTIDADCARGADA>$CANTIDADCARGADA</CANTIDADCARGADA>
					<CANTIDADENTREGADA>$CANTIDADENTREGADA</CANTIDADENTREGADA>
	
					<FECHALLEGADADESCARGUE>$FECHALLEGADADESCARGUE</FECHALLEGADADESCARGUE>
					<HORALLEGADADESCARGUECUMPLIDO>$HORALLEGADADESCARGUECUMPLIDO</HORALLEGADADESCARGUECUMPLIDO>
					
					<FECHAENTRADADESCARGUE>$FECHAENTRADADESCARGUE</FECHAENTRADADESCARGUE>
					<HORAENTRADADESCARGUECUMPLIDO>$HORAENTRADADESCARGUECUMPLIDO</HORAENTRADADESCARGUECUMPLIDO>
					<FECHASALIDADESCARGUE>$FECHASALIDADESCARGUE</FECHASALIDADESCARGUE>
					<HORASALIDADESCARGUECUMPLIDO>$HORASALIDADESCARGUECUMPLIDO</HORASALIDADESCARGUECUMPLIDO>
					
				  </variables> 
				 </root>";

				 //echo($msj); 
	             
				 $aParametros   = array("Request" => $msj);
		
				 $Class -> setOSoapClient($getConex);
				 $respuesta   = $oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 		 
				 
				 if ($respuesta=='') { 
					$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
					$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$getConex);
					if($printMsj) echo $respuesta;					 
				 }else{ 
						
					$sError ='';
						
					if ($sError!='') { 
						$respuesta =  '<div id="message">Error:'. $sError.'</div>';
						$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$getConex);
						if($printMsj) echo $respuesta;						
					}else{
						  
						if(preg_match("/ingresoid/i","$respuesta")){
							
							$contenido = $respuesta;
							$resultado = xml2array($contenido);			   
							$ingresoid = $resultado['root']['ingresoid'];
							$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$getConex);	
							if($printMsj)echo("Remesa ".$data_r['numero_remesa']." Cumplida Exitosamente<br>");
							   
						}else{			   
							  
							$Model -> setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$getConex);
															  
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
												
												$Model -> setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$respuesta_final,$getConex);	 
												if($printMsj)echo("<br>Previamente reportado<br>");									
										}else{
											if($printMsj)echo("<br>Error reportando Cumplido de Remesa, revise el log de errores:<br>".$respuesta);
											
										}
									}
																	
								}								 						
												
							}
								
						} 
						}else{
											echo "Remesa ".$Data[$j]['numero_remesa']." Previamente Cumplida<br>";	
						}
		        }
	        }//cierro for de remesas
		}//cierro si remesas es mayor a 0

		//aca xml manifiesto

		$manifiesto_id       			= $Table[$i]['manifiesto_id']; //ok	 
		$liquidacion_despacho_id        = $Table[$i]['liquidacion_despacho_id']; //ok
	
		if($liquidacion_despacho_id>0){
			$dataManifiesto                 = $Model -> getDataManifiestoLiquidacion($liquidacion_despacho_id,$getConex);//ok
		}
		
		$NUMMANIFIESTOCARGA             = $Table[$i]['manifiesto'];//ok
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
		//$remesas             			= $data_rem['remesas'];
		
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
		
		if(!$Model -> getEstaCumplidaManifiesto($manifiesto_id,$getConex)){
			$msj1 = "<?xml version='1.0' encoding='UTF-8' ?> 
			 <root> 
			  <acceso> 
			   <username>$user</username> 
			   <password>$passwordd</password> 
			   <ambiente>$ambiente</ambiente>
			  </acceso> 
			  
			  <solicitud> 
			   <tipo>1</tipo> 
			   <procesoid>6</procesoid> 
			  </solicitud> 
			  <variables> 
			   <NUMNITEMPRESATRANSPORTE>$numnitempresatransporte</NUMNITEMPRESATRANSPORTE> 
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
			 $Class -> setOSoapClient($getConex);
			 $respuesta   = $oSoapClient->__soapCall("AtenderMensajeRNDC", $aParametros); 		 
					
			 if ($respuesta=='') { 
				$respuesta = '<div id="message">No se pudo completar la operaci&oacute;n</div>';
				$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$getConex);
				if($printMsj) echo $respuesta;					 
			 }else{ 
					
				$sError ='';
					
				if ($sError!='') { 
					$respuesta =  '<div id="message">Error:'. $sError.'</div>';
					$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$getConex);
					if($printMsj) echo $respuesta;						
				}else{
					  
					if(preg_match("/ingresoid/i","$respuesta")){
						$contenido = $respuesta;
						$resultado = xml2array($contenido);			   
						$ingresoid = $resultado['root']['ingresoid'];
						$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$getConex);	
						if($printMsj)echo("<br>Manifiesto ".$Table[$i]['manifiesto']." Cumplido Exitosamente<br>");
						   
					}else{			   
						   
						$Model -> setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$getConex);
														  
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
									
									$Model -> setAprobacionManifiestoCumplido($manifiesto_id,$respuesta_final,$getConex);	 
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
		   
		}//cierra for de manifiesto    
		
	}	
		

?>
