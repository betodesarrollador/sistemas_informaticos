<?php
include_once "webservice_receptor.php";

class FacturaElectronica{

	public function sendFactura($opcion,$data_fac,$deta_fac,$deta_puc,$data_abo='',$deta_abo_puc=''){
	  
		$WebService = new WebService();
		$options = array('exceptions' => true, 'trace' => true);
		$params;
		/**
		* opciones :
		* 2 Descargar pdf,
		* 3 Descargar xml,
		* 4 Enviar factura,
		* 5 Enviar Correo,
		* 6 Estado Documento,
		* 7 Folios Restantes
		* 8 Enviar nota credito
		*/

		$TokenEnterprise = "9fea850d3d6c48769f13114c9c914d94c281083a";
		$TokenAutorizacion = "3de1b08bd62744daa16728675aa2a0694b62face";
		$vfactura=$data_fac[0]['consecutivo_factura'];

		$documento = $vfactura;
		$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion,'documento' => $documento );
		
		$resultado = "";
		
		$color="";
		$rutaArchivo="";

		switch($opcion){
		case 2: case 3: //descargas PDF o XML
			$tipoDescarga = ($opcion == 2) ? "pdf" : "xml";
			$factura=$data_fac[0]['prefijo1'].$data_fac[0]['consecutivo_factura'];
			//echo $factura.'-';
			//$factura='TEMF'.$data_fac[0]['consecutivo_factura'];
			$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion,'documento' => $factura);		
			
			$resultado = $WebService->Descargas(WSDL,$options,$params,$tipoDescarga);
			if($resultado["codigo"]!=200) $color="red";
			if($resultado["codigo"]==200) $color="blue";
			$extension = ($opcion==2) ? ".pdf" : ".xml";
			if($opcion==2){
				$rutaArchivo = "../../../archivos/facturacion/pdf/".$factura.$extension;
			}else{
				$rutaArchivo = "../../../archivos/facturacion/xml/".$factura.$extension;
			}
			if($resultado["codigo"]==200 and ($opcion==2 or $opcion==3)) file_put_contents($rutaArchivo, base64_decode($resultado["documento"]));
		break;
		case 5://Enviar Correo
			$factura=$data_fac[0]['prefijo1'].$data_fac[0]['consecutivo_factura'];
			$correo = trim($data_fac[0]['correo']).',facturacion@envipackcolombia.com';
			//$correo = 'johnatanleyva@gmail.com';
			$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion,'documento' => $factura,'correo' => $correo );		
			
			$resultado = $WebService->enviocorreo(WSDL,$options,$params);
			if($resultado["codigo"]==200) $color="blue";
		break;
		case 6://Estado de Referencia
			$factura=$data_fac[0]['prefijo1'].$data_fac[0]['consecutivo_factura'];
			//$factura='TEMF'.$data_fac[0]['consecutivo_factura'];
			$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion,'documento' => $factura );		
			$resultado = $WebService->getEstadoDocumento(WSDL,$options,$params);
			if($resultado["codigo"]!=200) $color="red";
			if($resultado["codigo"]==200) $color="blue";
		break;
		case 7://FoliosRestantes
			$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion );		
			$resultado = $WebService->foliosrestantes(WSDL,$options,$params);
		break;
		
		case 4://Generar Factura
			$impgen = json_decode($_POST["impgen"]);
			
			//Datos del Cliente Completo
			$factura = new FacturaGeneral();
			$factura->cliente->apellido = $data_fac[0]['apellido']; 
			$factura->cliente->ciudad = $data_fac[0]['ciudad'];
			$factura->cliente->direccion = $data_fac[0]['direccion'];
			$factura->cliente->email =trim($data_fac[0]['correo']).',facturacion@envipackcolombia.com';
			//$factura->cliente->email ='facturacionycartera@envipackcolombia.com,johnatanleyva@gmail.com';
			$factura->cliente->nombreRazonSocial  = ($data_fac[0]['tipo_persona'] == 2) ? $data_fac[0]['nombre'] : $data_fac[0]['razonsocial'];
			$factura->cliente->segundoNombre =  $data_fac[0]['cliente_segundo'];
			$factura->cliente->notificar = "SI";
			$factura->cliente->numeroDocumento = $data_fac[0]['nroDoc'];
			$factura->cliente->pais = "CO";
			$factura->cliente->regimen = $data_fac[0]['regimen'];
			$factura->cliente->tipoIdentificacion = $data_fac[0]['tipoDoc'];
			$factura->cliente->tipoPersona = $data_fac[0]['tipo_persona'];
			$factura->cliente->telefono = $data_fac[0]['telefono'];
			$factura->cliente->subDivision = "";
			
			/// Capturar el detalle de la factura
			
			for($j=0;$j<count($deta_fac);$j++){
				$l=0;
				$factDetalle = new FacturaDetalle();
				$objFactImp = new FacturaImpuestos();
				if($deta_fac[$j]['remesa_id']>0 || $deta_fac[$j]['seguimiento_id']>0){
					$factDetalle->cantidadUnidades = 1;
				}else{
					$factDetalle->cantidadUnidades = $deta_fac[$j]['cantidad'];
				}
				
				$factDetalle->codigoProducto = "N/A";
				//$factDetalle->codigoProducto = $deta_fac[$j]['detalle_factura_id'];
				if($deta_fac[$j]['remesa_id']>0){
					$factDetalle->descripcion = "Servicio de Transporte. Remesa No ".$deta_fac[$j]['no_remesa'].". Cantidad transportada: ".$deta_fac[$j]['cantidad'];
				}else{
					$factDetalle->descripcion = $deta_fac[$j]['descripcion'];
				}
				$factDetalle->descuento =  "0";
				$factDetalle->detalleAdicionalNombre = "";//Campo en blanco no requeridos
				$factDetalle->detalleAdicionalValor = "";//Campo en blanco no requeridos
				$factDetalle->precioTotal = $deta_fac[$j]['valor'];
				$factDetalle->precioTotalSinImpuestos =  $deta_fac[$j]['valor'];
				if($deta_fac[$j]['remesa_id']>0 || $deta_fac[$j]['seguimiento_id']>0){
					$factDetalle->precioVentaUnitario = $deta_fac[$j]['valor'];
				}else{
					$factDetalle->precioVentaUnitario = $deta_fac[$j]['valor_unitario'];
				}
				$factDetalle->seriales = "";
				$factDetalle->unidadMedida = "UNIDAD";
				if($deta_fac[$j]['iva']>0 || $deta_fac[$j]['ico']>0 || $deta_fac[$j]['riv']>0){
					if($deta_fac[$j]['iva']>0){
						$valorTOTALImp=0;
						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
					 	$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_iva'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = $valorTOTALImp;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}
					if($deta_fac[$j]['ico']>0){
						$valorTOTALImp=0;
						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_ico']);
					 	$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_ico'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_ico'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = $valorTOTALImp;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}

					if($deta_fac[$j]['riv']>0 && $deta_fac[$j]['iva']>0){
						$valorTOTALImp=0;

						$calculo1 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
					 	$calculo1 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo1);	
						eval("\$baseImponibleTOTALImp = $calculo1;");

						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_riv']);
					 	$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_riv'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $baseImponibleTOTALImp;
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_riv'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = $valorTOTALImp;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}

				}else{
					$objFactImp->baseImponibleTOTALImp = 0;
					$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
					$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
					$objFactImp->porcentajeTOTALImp = "0";//$impgen->tasaimpuesto;
					$objFactImp->valorTOTALImp = 0;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
					$factDetalle->impuestosDetalles[$l] = $objFactImp; 
				}
				$factura->detalleDeFactura[$j] = $factDetalle;

			}

			for($x=0;$x<count($deta_puc);$x++){
				$FacturaImpuestos = new FacturaImpuestos();

				$FacturaImpuestos->baseImponibleTOTALImp = $deta_puc{$x}['base_factura'];
				
				if($deta_puc{$x}['tipo_impuesto']=='RT'){ 
					if($deta_puc{$x}['tipo_subcodigo']!='21'){
						$codigoImp="05";
						$codigoInter="6";
					}else{
						$codigoImp="21";
						$codigoInter="";
						
					}
				}elseif($deta_puc{$x}['tipo_impuesto']=='IC'){
					$codigoImp="02";
					$codigoInter="";
				}elseif($deta_puc{$x}['tipo_impuesto']=='IV'){
					$codigoImp="01";
					$codigoInter="";					
				}
				
				$FacturaImpuestos->codigoTOTALImp = $codigoImp; //01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
				$FacturaImpuestos->controlInterno = $codigoInter;//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
				$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_puc{$x}['porcentaje_factura'],2,'.','');
				$FacturaImpuestos->valorTOTALImp = $deta_puc{$x}['valor_liquida'];

				$factura->impuestosGenerales[$x] = $FacturaImpuestos;
			}
			
			$factura->informacionAdicional = $data_fac[0]['observacion']; //se adiciona para adicional
			$factura->medioPago = "41";//ojo mirar
			$factura->moneda = "COP";//ojo mirar
			$factura->rangoNumeracion = "TYE-20001";
			$factura->tipoDocumento="01";//tipo de documento Factura de Venta
			$factura->totalDescuentos = "0";
			$factura->totalSinImpuestos = $data_fac[0]['totalSinImpuestos']; 
			$factura->importeTotal = $data_fac[0]['importeTotal']; 
			$factura->uuidDocumentoModificado ="";
			$factura->icoterms="";
			$factura->propina="0.00";
			$factura->consecutivoDocumento =  /*$data_fac[0]['prefijo'].*/$data_fac[0]['consecutivo_factura']; 
			$factura->fechaEmision = $data_fac[0]['fecha']." ".date("H:i:s");
			$factura->fechaVencimiento = $data_fac[0]['vencimiento']." ".date("H:i:s");
			$factura->fechaVencimiento = "";
			$factura->fechaEmisionDocumentoModificado = "";
			
			$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion,'factura' => $factura, 'adjuntos' => "0" );
			//Enviar Objeto Factura
			$resultado = $WebService->enviar(WSDL,$options,$params);	    
		break;
		
		
		
		case 8://Generar NOTA CREDITO
			$impgen = json_decode($_POST["impgen"]);
			
			//Datos del Cliente Completo
			$factura = new FacturaGeneral();
			$factura->cliente->apellido = $data_fac[0]['apellido']; 
			$factura->cliente->ciudad = $data_fac[0]['ciudad'];
			$factura->cliente->direccion = $data_fac[0]['direccion'];
			//$factura->cliente->email =$data_fac[0]['correo'];
			//$factura->cliente->email ='facturacionycartera@envipackcolombia.com,johnatanleyva@gmail.com';
			$factura->cliente->email =trim($data_fac[0]['correo']).',facturacion@envipackcolombia.com';
			$factura->cliente->nombreRazonSocial  = ($data_fac[0]['tipo_persona'] == 2) ? $data_fac[0]['nombre'] : $data_fac[0]['razonsocial'];
			$factura->cliente->segundoNombre =  $data_fac[0]['cliente_segundo'];
			$factura->cliente->notificar = "SI";
			$factura->cliente->numeroDocumento = $data_fac[0]['nroDoc'];
			$factura->cliente->pais = "CO";
			$factura->cliente->regimen = $data_fac[0]['regimen'];
			$factura->cliente->tipoIdentificacion = $data_fac[0]['tipoDoc'];
			$factura->cliente->tipoPersona = $data_fac[0]['tipo_persona'];
			$factura->cliente->telefono = $data_fac[0]['telefono'];
			$factura->cliente->subDivision = "";
			
			/// Capturar el detalle de la factura
			
			for($j=0;$j<count($deta_fac);$j++){
				$l=0;
				$factDetalle = new FacturaDetalle();
				$objFactImp = new FacturaImpuestos();
				if($deta_fac[$j]['remesa_id']>0){
					$factDetalle->cantidadUnidades = 1;
				}else{
					$factDetalle->cantidadUnidades = $deta_fac[$j]['cantidad'];
				}
				
				$factDetalle->codigoProducto = "N/A";
				//$factDetalle->codigoProducto = $deta_fac[$j]['detalle_factura_id'];
				if($deta_fac[$j]['remesa_id']>0){
					$factDetalle->descripcion = "Servicio de Transporte. Remesa No ".$deta_fac[$j]['no_remesa'].". Cantidad transportada: ".$deta_fac[$j]['cantidad'];
				}else{
					$factDetalle->descripcion = $deta_fac[$j]['descripcion'];
				}
				$factDetalle->descuento =  "0";
				$factDetalle->detalleAdicionalNombre = "";//Campo en blanco no requeridos
				$factDetalle->detalleAdicionalValor = "";//Campo en blanco no requeridos
				$factDetalle->precioTotal = $deta_fac[$j]['valor'];
				$factDetalle->precioTotalSinImpuestos =  $deta_fac[$j]['valor'];
				if($deta_fac[$j]['remesa_id']>0){
					$factDetalle->precioVentaUnitario = $deta_fac[$j]['valor'];
				}else{
					$factDetalle->precioVentaUnitario = $deta_fac[$j]['valor_unitario'];
				}
				$factDetalle->seriales = "";
				$factDetalle->unidadMedida = "UNIDAD";
				if($deta_fac[$j]['iva']>0 || $deta_fac[$j]['ico']>0 || $deta_fac[$j]['riv']>0){
					if($deta_fac[$j]['iva']>0){
						$valorTOTALImp=0;
						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
					 	$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_iva'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = $valorTOTALImp;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}
					if($deta_fac[$j]['ico']>0){
						$valorTOTALImp=0;
						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_ico']);
					 	$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_ico'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_ico'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = $valorTOTALImp;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}

					if($deta_fac[$j]['riv']>0 && $deta_fac[$j]['iva']>0){
						$valorTOTALImp=0;

						$calculo1 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
					 	$calculo1 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo1);	
						eval("\$baseImponibleTOTALImp = $calculo1;");

						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_riv']);
					 	$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_riv'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $baseImponibleTOTALImp;
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_riv'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = $valorTOTALImp;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}

				}else{
					$objFactImp->baseImponibleTOTALImp = 0;
					$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
					$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
					$objFactImp->porcentajeTOTALImp = "0";//$impgen->tasaimpuesto;
					$objFactImp->valorTOTALImp = 0;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
					$factDetalle->impuestosDetalles[$l] = $objFactImp; 
				}
				$factura->detalleDeFactura[$j] = $factDetalle;

			}

			for($x=0;$x<count($deta_abo_puc);$x++){
				$FacturaImpuestos = new FacturaImpuestos();

				$FacturaImpuestos->baseImponibleTOTALImp = $deta_abo_puc{$x}['base_abono'];
				
				if($deta_abo_puc{$x}['tipo_impuesto']=='RT'){ 
					if($deta_abo_puc{$x}['tipo_subcodigo']!='21'){
						$codigoImp="05";
						$codigoInter="6";
					}else{
						$codigoImp="21";
						$codigoInter="";
						
					}
				}elseif($deta_abo_puc{$x}['tipo_impuesto']=='IC'){
					$codigoImp="02";
					$codigoInter="";
				}elseif($deta_abo_puc{$x}['tipo_impuesto']=='IV'){
					$codigoImp="01";
					$codigoInter="";					
				}
				
				$FacturaImpuestos->codigoTOTALImp = $codigoImp; //01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
				$FacturaImpuestos->controlInterno = $codigoInter;//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
				$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_abo_puc{$x}['porcentaje_abono'],2,'.','');
				$FacturaImpuestos->valorTOTALImp = $deta_abo_puc{$x}['valor_liquida'];

				$factura->impuestosGenerales[$x] = $FacturaImpuestos;
			}
			
			$factura->medioPago = "41";//ojo mirar
			$factura->moneda = "COP";//ojo mirar
			$factura->rangoNumeracion = "NCR-1";
			$factura->tipoDocumento="04"; //tipo de documento NC de Venta
			$factura->totalDescuentos = "0";
			$factura->totalSinImpuestos = $data_abo[0]['valor_abono_factura']; 
			$factura->importeTotal = $data_abo[0]['valor_neto_factura']; //ACA
			$factura->uuidDocumentoModificado ="";
			$factura->icoterms="";
			$factura->propina="0.00";
			$factura->consecutivoDocumento =  $data_abo[0]['numero_soporte'];
			$factura->consecutivoDocumentoModificado = $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];
			//$factura->consecutivoDocumentoModificado =  'TEMF'.$data_fac[0]['consecutivo_factura'];
			$factura->uuidDocumentoModificado = $data_fac[0]['cufe'];
			$factura->fechaEmision = $data_abo[0]['fecha']." ".date("H:i:s");
			//$factura->fechaVencimiento = $data_fac[0]['vencimiento']." ".date("H:i:s");
			$factura->fechaVencimiento = "";
			$factura->fechaEmisionDocumentoModificado =  $data_fac[0]['fecha']." ".date("H:i:s");
			$factura->motivoNota =  $data_abo[0]['motivo_nota'];
			
			$params = array('tokenEmpresa' =>  $TokenEnterprise,'tokenPassword' =>$TokenAutorizacion,'factura' => $factura, 'adjuntos' => "0" );
			//Enviar Objeto 
			$resultado = $WebService->enviar(WSDL,$options,$params);	    
		break; //Generar NOTA CREDITO fin
		
		}
		return 	$resultado;
	}
}
/*01 Iva
02 ica
05 retencion en la fuente por renta cuentas 2365,2368 y 2369
06 RETENCION EN LA FUENTE IVA
07 RETENCIÓN FUENTE POR ICA


tipo de rentas poner subcodigo
*/

/*function codificacionUTF8($cadena = null){
    return mb_convert_encoding($cadena, "UTF-8", mb_detect_encoding($cadena, "UTF-8, ISO-8859-1, ISO-8859-15", true));
}*/

?>