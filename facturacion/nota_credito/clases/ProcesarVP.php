<?php
include_once "webservice_receptorVP.php";
error_reporting(E_ERROR);
class FacturaElectronica{

	public function sendFactura($opcion,$tokens,$data_fac,$deta_fac,$deta_puc,$data_abo='',$deta_abo_puc='',$deta_obli='',$deta_puc_con=''){
        
		$WebService = new WebService();
		$options = array('exceptions' => true, 'trace' => true);
		$params;
		$base_total_imp=0;
		
		$TokenEnterprise= $tokens[0]['tokenenterprise']; //$_POST["tokenEmpresa"];// //SE DEBE SETEAR ESTE VALOR (SUMINSTRADO POR TFHKA)
		$TokenAutorizacion= $tokens[0]['tokenautorizacion']; //$_POST["tokenPassword"];// //SE DEBE SETEAR ESTE VALOR (SUMINSTRADO POR TFHKA)
		$enviarAdjunto = $_POST["Check"];
        
		if($opcion==4 || $opcion==8 || $opcion==9){//valida envio factura 4, nota credto 8, nota debito 9
		
			$factura = new FacturaGeneral();
			$factura->cliente = new Cliente();
			$factura->cantidadDecimales = "2";
			$factura->cliente->actividadEconomicaCIIU = $data_fac[0]['codigo_ciiu'];//ok
			//Datos del Cliente Completo
			$destinatarios = new Destinatario();	
				$destinatarios->canalDeEntrega = "0";
			
				$correodestinatario = new strings();	 
				
				$correodestinatario->string = trim($data_fac[0]['correo']);
				//$correodestinatario->string = 'johnatanleyva@gmail.com';
			
				$destinatarios->email = $correodestinatario;
				$destinatarios->nitProveedorReceptor = $data_fac[0]['nroDoc'];//ok
				$destinatarios->telefono = $data_fac[0]['telefono'];//ok	
			
			$factura->cliente->destinatario[0] = $destinatarios;

			
			$destinatarios1 = new Destinatario();	

				$destinatarios1->canalDeEntrega = "0";
			
				$correodestinatario1 = new strings();	 
				
				$correodestinatario1->string = trim($tokens[0]['correo']);
			
				$destinatarios1->email = $correodestinatario1;
				$destinatarios1->nitProveedorReceptor = $data_fac[0]['nroDoc'];//ok
				$destinatarios1->telefono = $data_fac[0]['telefono'];//ok	
			
			$factura->cliente->destinatario[1] = $destinatarios1;

			if($data_fac[0]['correo2']!=''){
				$destinatarios2 = new Destinatario();	
	
					$destinatarios2->canalDeEntrega = "0";
				
					$correodestinatario2 = new strings();	 
					
					$correodestinatario2->string = trim($data_fac[0]['correo2']);
					
					//$correodestinatario->string = 'johnatanleyva@gmail.com';
				
					$destinatarios2->email = $correodestinatario2;
					$destinatarios2->nitProveedorReceptor = $data_fac[0]['nroDoc'];//ok
					$destinatarios2->telefono = $data_fac[0]['telefono'];//ok	
				
				$factura->cliente->destinatario[2] = $destinatarios2;
			}
			$tributos1 = new Tributos();	
				$tributos1->codigoImpuesto = "01";
				
			$extensible1 = new Extensibles();
				$extensible1->controlInterno1 = "";
				$extensible1->controlInterno2 = "";
				$extensible1->nombre = "";
				$extensible1->valor = "";
				
				$tributos1->extras[0] = $extensible1;
				
			$factura->cliente->detallesTributarios[0] = $tributos1;
			
			
			$DireccionFiscal = new Direccion();	
				$DireccionFiscal->aCuidadoDe = "";
				$DireccionFiscal->aLaAtencionDe = "";
				$DireccionFiscal->bloque = "";
				$DireccionFiscal->buzon = "";
				$DireccionFiscal->calle = "";
				$DireccionFiscal->calleAdicional = "";
				$DireccionFiscal->correccionHusoHorario = "";				
				$DireccionFiscal->ciudad = $data_fac[0]['ciudad'];//ok
				$DireccionFiscal->municipio =  $data_fac[0]['cod_ciudad'];//ok
				
				if($data_fac[0]['cod_ciudad']=='11001'){
					$DireccionFiscal->codigoDepartamento = "11";//ok
					$DireccionFiscal->departamento = "Bogotá";//ok
				}else{
					$DireccionFiscal->codigoDepartamento = substr($data_fac[0]['cod_depto'],0,2);//ok
					$DireccionFiscal->departamento = $data_fac[0]['departamento'];//ok
				}
				
				$DireccionFiscal->departamentoOrg = "";
				$DireccionFiscal->habitacion = "";
				$DireccionFiscal->distrito = $data_fac[0]['direccion'];//ok 
				$DireccionFiscal->lenguaje = "es";
				$DireccionFiscal->nombreEdificio = "";
				$DireccionFiscal->numeroParcela = "";
				$DireccionFiscal->pais = "CO";//ok
				$DireccionFiscal->piso = "";
				$DireccionFiscal->region = "";
				$DireccionFiscal->subDivision = "";
				$DireccionFiscal->ubicacion = "";
				$DireccionFiscal->zonaPostal = $data_fac[0]['zona_postal'];	//ok
			
			$factura->cliente->direccionFiscal = $DireccionFiscal;

			$factura->cliente->email = trim($data_fac[0]['correo']).'';
			//$factura->cliente->email = 'johnatanleyva@gmail.com';
			
			
			$InfoLegalCliente = New InformacionLegalCliente;
				$InfoLegalCliente->codigoEstablecimiento = "";
				$InfoLegalCliente->nombreRegistroRUT = ($data_fac[0]['tipo_persona'] == 2) ? $data_fac[0]['nombre'] : $data_fac[0]['razonsocial']; //ok
				$InfoLegalCliente->numeroIdentificacion = $data_fac[0]['nroDoc']; //ok
				$InfoLegalCliente->numeroIdentificacionDV = $data_fac[0]['nroDocDV']; //ok
				$InfoLegalCliente->tipoIdentificacion = $data_fac[0]['tipoDoc']; //ok
			
			$factura->cliente->informacionLegalCliente = $InfoLegalCliente;
			
			
			$factura->cliente->nombreRazonSocial  = ($data_fac[0]['tipo_persona'] == 2) ? $data_fac[0]['nombre'] : $data_fac[0]['razonsocial'];//ok
			$factura->cliente->notificar = "SI";
			$factura->cliente->numeroDocumento = $data_fac[0]['nroDoc']; //ok
			$factura->cliente->numeroIdentificacionDV = $data_fac[0]['nroDocDV']; //ok
			
			for($y=0;$y<count($deta_obli);$y++){
				
				$obligacionesCliente = new Obligaciones();
					$obligacionesCliente->obligaciones =$deta_obli[$y]['codigo'];
					$obligacionesCliente->regimen =$data_fac[0]['regimen_new']; //ok
				
				$factura->cliente->responsabilidadesRut[$y] = $obligacionesCliente;
			}
			$factura->cliente->tipoIdentificacion = $data_fac[0]['tipoDoc'];//ok
			$factura->cliente->tipoPersona = $data_fac[0]['tipo_persona'];//ok
			//FIN cliente
			//$factura->consecutivoDocumento = $data_fac[0]['consecutivo_factura1']; //ok			
			$factura->consecutivoDocumento = $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura']; //ok

			
			/// Capturar el detalle de la factura
			if($opcion==4){
				$cantidad_pro=0;
				for($j=0;$j<count($deta_fac);$j++){
					$l=0;
					$factDetalle = new FacturaDetalle();
					$factDetalle->cantidadPorEmpaque = "";
					$factDetalle->cantidadRealUnidadMedida = "WSD"; //ok
					if($deta_fac[$j]['remesa_id']>0 || $deta_fac[$j]['seguimiento_id']>0){
						$factDetalle->cantidadUnidades = 1;//ok
						$factDetalle->cantidadReal = "1";
						$cantidad_pro = $cantidad_pro + $factDetalle->cantidadReal;
					}else{
						$factDetalle->cantidadUnidades = $deta_fac[$j]['cantidad'];//ok
						$factDetalle->cantidadReal = "1";
						//$factDetalle->cantidadReal =$deta_fac[$j]['cantidad'];//ok
						$cantidad_pro = $cantidad_pro + $factDetalle->cantidadReal;
					}

					if($deta_fac[$j]['remesa_id']>0){
						$factDetalle->descripcion = "Servicio de Transporte. Remesa No ".$deta_fac[$j]['no_remesa'].". Cantidad transportada: ".$deta_fac[$j]['cantidad'];
					}else{
						$factDetalle->descripcion = $deta_fac[$j]['descripcion'];//OK
					}
					$factDetalle->codigoProducto = "N/A";//ok
					$factDetalle->descripcionTecnica = "";//Campo en blanco no requeridos  ok
					
					$factDetalle->estandarCodigo = "999";//preguntar
					$factDetalle->estandarCodigoProducto = $deta_fac[$j]['detalle_factura_id'];//preguntar
	
					$factDetalle->marca = ""; //ok
					$factDetalle->muestraGratis = "0";//ok
					$factDetalle->precioTotal = $deta_fac[$j]['valor']; //ok
					$factDetalle->precioTotalSinImpuestos = $deta_fac[$j]['valor']; //ok
					if($deta_fac[$j]['remesa_id']>0 || $deta_fac[$j]['seguimiento_id']>0){
						$factDetalle->precioVentaUnitario = $deta_fac[$j]['valor']; //ok
					}else{
						$factDetalle->precioVentaUnitario = $deta_fac[$j]['valor_unitario']>0 ? $deta_fac[$j]['valor_unitario'] : $deta_fac[$j]['valor'];//ok
					}
					$factDetalle->secuencia = ($j+1); //ok
					$factDetalle->unidadMedida = "WSD";	//ok	
	
					$factDetalle->descuento =  "0";
					$factDetalle->detalleAdicionalNombre = "";//Campo en blanco no requeridos
					$factDetalle->detalleAdicionalValor = "";//Campo en blanco no requeridos
					$factDetalle->seriales = "";
	
					$objFactImp = new FacturaImpuestos();
	
					if($deta_fac[$j]['iva']>0 || $deta_fac[$j]['ico']>0){
							
						if($deta_fac[$j]['iva']>0){// IVA IMPUESTO VALOR AGREGADO  01
							$valorTOTALImp=0;
							$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
							$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo);	
							eval("\$valorTOTALImp = $calculo;");
							$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
							$base_total_imp = $base_total_imp + $deta_fac[$j]['valor'];
							$objFactImp->codigoTOTALImp = "01";//01 IVA 02 IC 03 ICA O4 INC  05 Retención sobre el IVA  06 Retención sobre fuente por renta  07Retención sobre el ICA
							$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
							$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_iva'],2,'.','');//$impgen->tasaimpuesto;
							$objFactImp->valorTOTALImp = round($valorTOTALImp);//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
							$factDetalle->impuestosDetalles[$l] = $objFactImp; 
							$factDetalle->precioTotal = $factDetalle->precioTotal+$objFactImp->valorTOTALImp; //ok
	
							$l++;
						}
						if($deta_fac[$j]['ico']>0){  //INC IMPUESTO NACIONAL CONSUMO  04
							$valorTOTALImp=0;
							$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_ico']);
							$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_ico'],2,'.',''),$calculo);	
							eval("\$valorTOTALImp = $calculo;");
							$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
							$base_total_imp = $base_total_imp + $deta_fac[$j]['valor'];						
							$objFactImp->codigoTOTALImp = "04";//01 IVA 02 IC 03 ICA O4 INC  05 Retención sobre el IVA  06 Retención sobre fuente por renta  07Retención sobre el ICA
							$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
							$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_ico'],2,'.','');//$impgen->tasaimpuesto;
							$objFactImp->valorTOTALImp = round($valorTOTALImp);//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
							$factDetalle->impuestosDetalles[$l] = $objFactImp; 
							$l++;
						}
	
						/*if($deta_fac[$j]['riv']>0 && $deta_fac[$j]['iva']>0){ //RETEIVA  05
							$valorTOTALImp=0;
	
							$calculo1 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
							$calculo1 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo1);	
							eval("\$baseImponibleTOTALImp = $calculo1;");
	
							$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_riv']);
							$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_riv'],2,'.',''),$calculo);	
							eval("\$valorTOTALImp = $calculo;");
							$objFactImp->baseImponibleTOTALImp = $baseImponibleTOTALImp;
							$base_total_imp = $base_total_imp + $baseImponibleTOTALImp;
							$objFactImp->codigoTOTALImp = "05";//01 IVA 02 IC 03 ICA O4 INC  05 Retención sobre el IVA  06 Retención sobre fuente por renta  07Retención sobre el ICA
							$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
							$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_riv'],2,'.','');//$impgen->tasaimpuesto;
							$objFactImp->valorTOTALImp = round($valorTOTALImp);//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
							$factDetalle->impuestosDetalles[$l] = $objFactImp; 
							$l++;
						}*/
	
					}else{
						$objFactImp->baseImponibleTOTALImp = 0;
						$objFactImp->codigoTOTALImp = "01";//$impgen->codigoTOTALImp;//01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = "0";//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = 0;//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
					}
					$impTot = new ImpuestosTotales;
						$impTot->codigoTOTALImp = $objFactImp->codigoTOTALImp;
						$impTot->montoTotal = $objFactImp->valorTOTALImp;
					
					$factDetalle->impuestosTotales[$l] = $impTot;
					
					$factura->detalleDeFactura[$j] = $factDetalle;
					
	
				}
			}elseif($opcion==8){
				//detalles cuando es nota credito
				$cantidad_pro=1;
				$l=0;
				$j=0;
				$factDetalle = new FacturaDetalle();
				$factDetalle->cantidadPorEmpaque = "";
				$factDetalle->cantidadRealUnidadMedida = "WSD"; //ok
				$factDetalle->cantidadUnidades = 1;//ok
				$factDetalle->cantidadReal = "1";
				$cantidad_pro = $cantidad_pro;
				$factDetalle->descripcion = $data_abo[0]['observaciones'].' Nota Credito factura: '.$data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];//OJO
				$factDetalle->codigoProducto = "N/A";//ok
				$factDetalle->descripcionTecnica = "";//Campo en blanco no requeridos  ok
				
				$factDetalle->estandarCodigo = "999";//preguntar
				$factDetalle->estandarCodigoProducto = 1;//preguntar

				$factDetalle->marca = ""; //ok
				$factDetalle->muestraGratis = "0";//ok
				$factDetalle->precioTotal = $data_abo[0]['valor_neto_factura']; //ok
				$factDetalle->precioTotalSinImpuestos = $data_abo[0]['valor_neto_factura']; //ok
				$factDetalle->precioVentaUnitario =$data_abo[0]['valor_neto_factura']; //ok
				$factDetalle->secuencia = 1; //ok
				$factDetalle->unidadMedida = "WSD";	//ok	

				$factDetalle->descuento =  "0";
				$factDetalle->detalleAdicionalNombre = "";//Campo en blanco no requeridos
				$factDetalle->detalleAdicionalValor = "";//Campo en blanco no requeridos
				$factDetalle->seriales = "";


				if($deta_fac[$j]['iva']>0 || $deta_fac[$j]['ico']>0 ){

					$objFactImp = new FacturaImpuestos();

					if($deta_fac[$j]['iva']>0){// IVA IMPUESTO VALOR AGREGADO  01
						$valorTOTALImp=0;
						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
						$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
						$base_total_imp = $base_total_imp + $deta_fac[$j]['valor'];
						$objFactImp->codigoTOTALImp = "01";//01 IVA 02 IC 03 ICA O4 INC  05 Retención sobre el IVA  06 Retención sobre fuente por renta  07Retención sobre el ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_iva'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = round($valorTOTALImp);//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$factDetalle->precioTotal = $factDetalle->precioTotal+$objFactImp->valorTOTALImp; //ok

						$l++;
					}
					if($deta_fac[$j]['ico']>0){  //INC IMPUESTO NACIONAL CONSUMO  04
						$valorTOTALImp=0;
						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_ico']);
						$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_ico'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $deta_fac[$j]['valor'];
						$base_total_imp = $base_total_imp + $deta_fac[$j]['valor'];						
						$objFactImp->codigoTOTALImp = "04";//01 IVA 02 IC 03 ICA O4 INC  05 Retención sobre el IVA  06 Retención sobre fuente por renta  07Retención sobre el ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_ico'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = round($valorTOTALImp);//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}

					/*if($deta_fac[$j]['riv']>0 && $deta_fac[$j]['iva']>0){ //RETEIVA  05
						$valorTOTALImp=0;

						$calculo1 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_iva']);
						$calculo1 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_iva'],2,'.',''),$calculo1);	
						eval("\$baseImponibleTOTALImp = $calculo1;");

						$calculo 	= str_replace("BASE",$deta_fac[$j]['valor'],$deta_fac[$j]['for_riv']);
						$calculo 	= str_replace("PORCENTAJE",number_format($deta_fac[$j]['por_riv'],2,'.',''),$calculo);	
						eval("\$valorTOTALImp = $calculo;");
						$objFactImp->baseImponibleTOTALImp = $baseImponibleTOTALImp;
						$base_total_imp = $base_total_imp + $baseImponibleTOTALImp;
						$objFactImp->codigoTOTALImp = "05";//01 IVA 02 IC 03 ICA O4 INC  05 Retención sobre el IVA  06 Retención sobre fuente por renta  07Retención sobre el ICA
						$objFactImp->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$objFactImp->porcentajeTOTALImp = number_format($deta_fac[$j]['por_riv'],2,'.','');//$impgen->tasaimpuesto;
						$objFactImp->valorTOTALImp = round($valorTOTALImp);//$impgen->totalimpuesto;//valor del impuesto a sumar a la base imponible (preciounitario * cantidad) * tasaimpuesto/100 =>Ejemplo (2500 * 2) * (19 / 100)
						$factDetalle->impuestosDetalles[$l] = $objFactImp; 
						$l++;
					}*/

					$impTot = new ImpuestosTotales;
						$impTot->codigoTOTALImp = $objFactImp->codigoTOTALImp;
						$impTot->montoTotal = $objFactImp->valorTOTALImp;
					
					$factDetalle->impuestosTotales[$l] = $impTot;
					
					

				}
				
				$factura->detalleDeFactura[$j] = $factDetalle;


			}
			
			if($opcion==4){
				if(count($deta_puc)>0){
					$base_impuestos = 0;
					$valor_impuestos = 0;
					for($x=0;$x<count($deta_puc);$x++){
		
						$FacturaImpuestos = new FacturaImpuestos();
		
						
						if($deta_puc[$x]['tipo_impuesto']=='RT'){ // 06 RETENCION SOBRE LA FUENTE POR RENTA
							if($deta_puc{$x}['tipo_subcodigo']!='21'){
								$codigoImp="06";
								$codigoInter="6";
							}else{
								$codigoImp="06";
								$codigoInter="";
								
							}
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_puc[$x]['porcentaje_factura'],2,'.','');

						}elseif($deta_puc[$x]['tipo_impuesto']=='RIC'){ //07 RETEICA
							$codigoImp="07";
							$codigoInter="";
							$FacturaImpuestos->porcentajeTOTALImp =  number_format(($deta_puc[$x]['porcentaje_factura']/10),3,'.','');
	
						}elseif($deta_puc[$x]['tipo_impuesto']=='IC'){ //03 ICA
							$codigoImp="03";
							$codigoInter="";
							$base_impuestos = $deta_puc[$x]['base_factura'];//($base_impuestos+$deta_puc[$x]['base_factura']);
							$valor_impuestos = ($valor_impuestos+$deta_puc[$x]['valor_liquida']);
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_puc[$x]['porcentaje_factura'],2,'.','');
	
	
						}elseif($deta_puc[$x]['tipo_impuesto']=='IV'){  //01 IVA
							$codigoImp="01";
							$codigoInter="";					
							$base_impuestos = $deta_puc[$x]['base_factura']; //$deta_puc[$x]['base_factura']);
							$valor_impuestos = ($valor_impuestos+$deta_puc[$x]['valor_liquida']);
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_puc[$x]['porcentaje_factura'],2,'.','');

						}elseif($deta_puc[$x]['tipo_impuesto']=='RIV'){ //05 RETEIVA
							$codigoImp="05";
							$codigoInter="";
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_puc[$x]['porcentaje_factura'],2,'.','');

						}
		
						$FacturaImpuestos->baseImponibleTOTALImp = $deta_puc[$x]['base_factura']; 
						$FacturaImpuestos->codigoTOTALImp = $codigoImp; //01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$FacturaImpuestos->controlInterno = $codigoInter;//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$FacturaImpuestos->valorTOTALImp = $deta_puc[$x]['valor_liquida'];
						$FacturaImpuestos->unidadMedida = "";
						$FacturaImpuestos->unidadMedidaTributo = "";
						$FacturaImpuestos->valorTributoUnidad = "0";
						$factura->impuestosGenerales[$x] = $FacturaImpuestos;

						//$factura->impuestosGenerales[$x] = $FacturaImpuestos;
						
						
					}

					for($y=0;$y<count($deta_puc_con);$y++ ){

						if($deta_puc_con[$y]['tipo_impuesto']=='RT'){ // 06 RETENCION SOBRE LA FUENTE POR RENTA
							if($deta_puc_con[$y]['tipo_subcodigo']!='21'){
								$codigoImp="06";
								$codigoInter="6";
							}else{
								$codigoImp="06";
								$codigoInter="";
								
							}
						}elseif($deta_puc_con[$y]['tipo_impuesto']=='RIC'){ //07 RETEICA
							$codigoImp="07";
							$codigoInter="";
	
						}elseif($deta_puc_con[$y]['tipo_impuesto']=='IC'){ //03 ICA
							$codigoImp="03";
							$codigoInter="";
	
	
						}elseif($deta_puc_con[$y]['tipo_impuesto']=='IV'){  //01 IVA
							$codigoImp="01";
							$codigoInter="";					

						}elseif($deta_puc_con[$y]['tipo_impuesto']=='RIV'){ //05 RETEIVA
							$codigoImp="05";
							$codigoInter="";

						}

						$impTot2 = new ImpuestosTotales;
						
						    $impTot2->codigoTOTALImp = $codigoImp;
							$impTot2->montoTotal = $deta_puc_con[$y]['valor_liquida'];
								
						$factura->impuestosTotales[$y] = $impTot2;
						
					}
				}else{
					$FacturaImpuestos = new FacturaImpuestos();
					$FacturaImpuestos->baseImponibleTOTALImp = 0;
					$FacturaImpuestos->codigoTOTALImp = "01"; //01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
					$FacturaImpuestos->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
					$FacturaImpuestos->porcentajeTOTALImp =  0;
					$FacturaImpuestos->valorTOTALImp = 0;
					$FacturaImpuestos->unidadMedida = "";
					$FacturaImpuestos->unidadMedidaTributo = "";
					$FacturaImpuestos->valorTributoUnidad = "0";
		   
					$factura->impuestosGenerales[0] = $FacturaImpuestos;
	
					$impTot2 = new ImpuestosTotales;
						$impTot2->codigoTOTALImp = "01";
						$impTot2->montoTotal = 0;
							
					$factura->impuestosTotales[0] = $impTot2;
	
				}
			}
			if($opcion==8){
				if(count($deta_abo_puc)>0){
					for($x=0;$x<count($deta_abo_puc);$x++){

						$FacturaImpuestos = new FacturaImpuestos();
						
						if($deta_abo_puc[$x]['tipo_impuesto']=='RT'){ // 06 RETENCION SOBRE LA FUENTE POR RENTA
							if($deta_abo_puc{$x}['tipo_subcodigo']!='21'){
								$codigoImp="06";
								$codigoInter="6";
							}else{
								$codigoImp="06";
								$codigoInter="";
								
							}
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_abo_puc[$x]['porcentaje_factura'],2,'.','');
	
						}elseif($deta_abo_puc[$x]['tipo_impuesto']=='RIC'){ //07 RETEICA
							$codigoImp="07";
							$codigoInter="";
							$FacturaImpuestos->porcentajeTOTALImp =  number_format(($deta_abo_puc[$x]['porcentaje_factura']/10),2,'.','');
	
						}elseif($deta_abo_puc[$x]['tipo_impuesto']=='IC'){ //03 ICA
							$codigoImp="03";
							$codigoInter="";
							$base_impuestos = $deta_abo_puc[$x]['base_factura'];//($base_impuestos+$deta_puc[$x]['base_factura']);
							$valor_impuestos = ($valor_impuestos+$deta_abo_puc[$x]['valor_liquida']);
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_abo_puc[$x]['porcentaje_factura'],2,'.','');
	
	
						}elseif($deta_puc[$x]['tipo_impuesto']=='IV'){  //01 IVA
							$codigoImp="01";
							$codigoInter="";					
							$base_impuestos = $deta_abo_puc[$x]['base_factura']; //$deta_puc[$x]['base_factura']);
							$valor_impuestos = ($valor_impuestos+$deta_abo_puc[$x]['valor_liquida']);
							$FacturaImpuestos->porcentajeTOTALImp =  number_format($deta_abo_puc[$x]['porcentaje_factura'],2,'.','');
							
						}
		
						$FacturaImpuestos->baseImponibleTOTALImp = $deta_abo_puc[$x]['base_factura']; 
						$FacturaImpuestos->codigoTOTALImp = $codigoImp; //01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
						$FacturaImpuestos->controlInterno = $codigoInter;//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
						$FacturaImpuestos->valorTOTALImp = $deta_abo_puc[$x]['valor_liquida'];
						$FacturaImpuestos->unidadMedida = "";
						$FacturaImpuestos->unidadMedidaTributo = "";
						$FacturaImpuestos->valorTributoUnidad = "0";
			   
						$factura->impuestosGenerales[$x] = $FacturaImpuestos;
		
						//$factura->impuestosGenerales[$x] = $FacturaImpuestos;
		
						$impTot2 = new ImpuestosTotales;
							$impTot2->codigoTOTALImp = $codigoImp;
							$impTot2->montoTotal = $deta_abo_puc[$x]['valor_liquida'];
								
						$factura->impuestosTotales[$x] = $impTot2;

					}
				}else{
					$FacturaImpuestos = new FacturaImpuestos();
					$FacturaImpuestos->baseImponibleTOTALImp = 0;
					$FacturaImpuestos->codigoTOTALImp = "01"; //01 para iva, 02 ica, 03 para ico, 04 contribuciones, 05 Retención en la fuente por renta,06 Retención en la fuente por IVA, 07 Retención en la fuente por ICA
					$FacturaImpuestos->controlInterno = "0";//Aplica solo para RETENCIÓN EN LA FUENTE POR RENTA Subcodigos: 3 Compras | 5 Honorarios | 6 Servicios Generales | 7 Transporte de carga]
					$FacturaImpuestos->porcentajeTOTALImp =  0;
					$FacturaImpuestos->valorTOTALImp = 0;
					$FacturaImpuestos->unidadMedida = "";
					$FacturaImpuestos->unidadMedidaTributo = "";
					$FacturaImpuestos->valorTributoUnidad = "0";
		   
					$factura->impuestosGenerales[0] = $FacturaImpuestos;
	
					$impTot2 = new ImpuestosTotales;
						$impTot2->codigoTOTALImp = "01";
						$impTot2->montoTotal = 0;
							
					$factura->impuestosTotales[0] = $impTot2;
	
				}
			}
			
			$pagos = new MediosDePago();
				$pagos->medioPago = "31";
				$pagos->metodoDePago = $data_fac[0]['forma_compra_venta_id'];
				$pagos->numeroDeReferencia = "01";	
				$pagos->fechaDeVencimiento= $data_fac[0]['vencimiento'];

				


			$factura->mediosDePago[0] = $pagos;//ok
			$factura->moneda = "COP";//ok
			$factura->redondeoAplicado = "0.00"	;
			$factura->rangoNumeracion = $data_fac[0]['prefijo']."-".$data_fac[0]['rango_inicial'];//ok // //SE DEBE SETEAR ESTE VALOR (SUMINSTRADO POR TFHKA EN PRUEBAS, POR LA DIAN EN PRODUCCION)
			
			$factura->tipoOperacion = "10";
			
			if($opcion==4){
				if(count($deta_puc)>0){
					
					//$factura->totalBaseImponible = $base_total_imp>0 ? $base_total_imp : $data_fac[0]['totalSinImpuestos'];
					$factura->totalBaseImponible = $base_impuestos;
				}else{
					$factura->totalBaseImponible =  0;
					
				}
				$factura->totalBaseImponible =  0;   //ojo preguntar bien la base imponible validar para credito
				$total_bruto_conimpuesto= ($valor_impuestos + $data_fac[0]['totalSinImpuestos']);
				$factura->totalBrutoConImpuesto = intval($total_bruto_conimpuesto);
				$factura->totalMonto =intval($total_bruto_conimpuesto); 
				$factura->totalProductos=intval($cantidad_pro);
				$factura->totalSinImpuestos=intval($data_fac[0]['totalSinImpuestos']);
				$factura->fechaEmision = $data_fac[0]['fecha']." ".date("H:i:s");//ok

			}
			
			if($opcion==8){
				if(count($deta_abo_puc)>0){
					//$factura->totalBaseImponible = $base_total_imp>0 ? $base_total_imp : $data_fac[0]['totalSinImpuestos'];
					$factura->totalBaseImponible = $base_impuestos;
				}else{
					$factura->totalBaseImponible =  0;
					
				}
				$factura->totalBaseImponible =  0;   //ojo preguntar bien la base imponible validar para credito
				$total_bruto_conimpuesto= ($valor_impuestos + $data_abo[0]['valor_neto_factura']);
				$factura->totalBrutoConImpuesto = intval($total_bruto_conimpuesto);
				$factura->totalMonto =intval($data_abo[0]['valor_neto_factura']); 
				$factura->totalProductos=intval($cantidad_pro);
				$factura->totalSinImpuestos=intval($data_abo[0]['valor_abono_factura']);
				$factura->fechaEmision = $data_abo[0]['fecha_abono']." ".date("H:i:s");//ok
				
			}
			
			//echo $total_bruto_conimpuesto.'-'.intval($data_fac[0]['totalSinImpuestos']).'-'.$factura->totalBaseImponible;
			//print_r($factura);
		
			//Facturas
			if($opcion==4){
				$infoAdicion = new strings();	
				$infoAdicion->string = trim($data_fac[0]['observacion']);
				$factura->informacionAdicional = $infoAdicion; //se adiciona para adicional
				$factura->tipoDocumento="01";
				$factura->fechaVencimiento = $data_fac[0]['vencimiento'];
				//$factura->consecutivoDocumento = $data_fac[0]['consecutivo_factura1']; 
				$factura->consecutivoDocumento = $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura']; //ok
				//echo $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura1'];
				

			//Notas de credito
			}elseif($opcion==8){  //Notas credito $opcion==8
				$factura->tipoDocumento="91";
		
				$factura->rangoNumeracion = "050-1";
				$factura->consecutivoDocumento = "050".$data_abo[0]['numero_soporte']; //ok
				$DocRef = new DocumentoReferenciado();

					$DocRef->codigoEstatusDocumento = $data_abo[0]['motivo_nota'];
					$DocRef->codigoInterno = '4';
					$DocRef->cufeDocReferenciado = $data_fac[0]['cufe'];
					$DocRef->numeroDocumento=   $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];
				
				$factura->documentosReferenciados[0] =$DocRef;
				$factura->fechaVencimiento = "";

		
				$DocRef1 = new DocumentoReferenciado();
		
					$DocRef1->codigoInterno = '5';
					$DocRef1->cufeDocReferenciado = $data_fac[0]['cufe'];
					$DocRef1->fecha = $data_abo[0]['fecha'];
					$DocRef1->numeroDocumento=  $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];
		
				$factura->documentosReferenciados[1] =$DocRef1;
		
			}elseif($opcion==9){ //Notas de debito $opcion==9
				$factura->tipoDocumento="92";
				$factura->rangoNumeracion = "NDB-1";
				$factura->consecutivoDocumento = "NDB".$data_abo[0]['numero_soporte']; //ok
		
				$DocRef2 = new DocumentoReferenciado();
		
					$DocRef2->codigoEstatusDocumento = '2';
					$DocRef2->codigoInterno = '4';
					$DocRef2->cufeDocReferenciado = $data_fac[0]['cufe'];
					$DocRef2->numeroDocumento=  $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];
				
				$factura->documentosReferenciados[0] =$DocRef2;
		
				$DocRef3 = new DocumentoReferenciado();
		
					$DocRef3->codigoInterno = '5';
					$DocRef3->cufeDocReferenciado = $data_fac[0]['cufe'];
					$DocRef3->fecha = $data_abo[0]['fecha'];
					$DocRef3->numeroDocumento=  $data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];
		
				$factura->documentosReferenciados[1] =$DocRef3;
		
			}
		
			if ($enviarAdjunto == "TRUE"){
		
				$adjuntos="1";
		
			}else{
		
				$adjuntos="0";
			}
		
			 
			 $params = array(
				 'tokenEmpresa' => $TokenEnterprise,
				 'tokenPassword' => $TokenAutorizacion,
				 'factura' => $factura ,
				 'adjuntos' => $adjuntos);

			/*  echo '<div style="max-height:450px; min-height:200px; overflow-y:auto;">';
			 print_r($factura);
			 echo '</div>';
			 exit(); */
			 

			 //Enviar Objeto Factura
			// exit(print_r($params));
			 $resultado = $WebService->enviar(WSDL,$options,$params);
			 //capturar codigo de respuesta del WS del Autofact para dar respuesta al usuario
			 
			 echo "<h1>Resultado de la Emisión</h1></br>";
			/* 
			if($resultado["codigo"]==200){
				
					print_r("Código: " .$resultado["codigo"] ."</br>Mensaje:  " .$resultado["mensaje"] ."</br>Consecutivo:  " .$resultado["consecutivoDocumento"] ."</br>CUFE:  " .$resultado["cufe"] ."</br>Fecha de Respuesta:  " .$resultado["fechaRespuesta"] ."</br>Hash:  " .$resultado["hash"] ."</br>Reglas de validación DIAN:  " .$resultado["reglasValidacionDIAN"] ."</br>Resultado:  " .$resultado["resultado"] ."</br>Tipo de CUFE:  " .$resultado["tipoCufe"] ."</br>Mensaje Validación:  " );
		
					$max = sizeof($resultado["mensajesValidacion"]->string);
					 for($i = 0; $i < $max;$i++){
		
						print_r("</br>" .$resultado["mensajesValidacion"]->string[$i]  );
					 }
			
				// ENVIO DE ADJUNTOS
		
				if ($enviarAdjunto == "TRUE"){
		
						$handle = fopen($_FILES['archivo']["tmp_name"],"r");
						$conten = fread($handle,filesize($_FILES['archivo']["tmp_name"]));
						
		
						$nombreformato = explode(".", $_FILES['archivo']['name']);
						$tm = sizeof($nombreformato);
						
		
						$Adjunto = new adjunto();
						$Adjunto->archivo= $conten;
		
						$correo = new strings();
						$correo = $_POST["correo"];
		
						$Adjunto->email[0] = $correo;
						$Adjunto->enviar = "1";
						$Adjunto->formato = $nombreformato[$tm-1];
						$Adjunto->nombre= $nombreformato[0];
						$Adjunto->numeroDocumento = $resultado["consecutivoDocumento"];
						$Adjunto->tipo = "2";
		
						$params = new CargarAdjuntos();
							$params->tokenEmpresa =  $TokenEnterprise;
							$params->tokenPassword = $TokenAutorizacion;
							$params->adjunto = $Adjunto;
		
						$options = array('exceptions' => true, 'trace' => true);
						$resultado = $WebService->CargarAdjuntos(WSANEXO,$options,$params);
		
						echo "<h2>Resultado del Envío de Adjuntos</h2></br>";
		
						print_r("Código: " .$resultado["codigo"] ."</br>Mensaje:  " .$resultado["mensaje"] ."</br>Resultado:  " .$resultado["resultado"]);
		
					}
		
			}else{
					print_r($resultado);
					$max = sizeof($resultado["mensajesValidacion"]->string);

					print_r("Código: " .$resultado["codigo"] ."</br>Mensaje:  " .$resultado["mensaje"] ."</br>Fecha de Respuesta:  " .$resultado["fechaRespuesta"] ."</br>Mensaje Validación:  " );
					 for($i = 0; $i < $max;$i++){
		
						print_r("</br>" .$resultado["mensajesValidacion"]->string[$i]  );
					 }
					 //."</br>Resultado:  " .$resultado["resultado"] );
				
			}*/
			return $resultado;
			exit();
		
		}elseif(isset($_POST['Folios'])){
		
			$params = array(
				 'tokenEmpresa' =>  $TokenEnterprise,
				 'tokenPassword' =>$TokenAutorizacion);
			 //Enviar Objeto Factura
			 $resultado = $WebService->foliosrestantes(WSDL,$options,$params);
		
			echo "<h1>Resultado de la consulta de Folios</h1></br>";
		
			 print_r("Código: " .$resultado["codigo"] ."</br>Folios Restantes:  " .$resultado["foliosRestantes"] ."</br>Resultado:  " .$resultado["resultado"] ."</br>Mensaje:  " .$resultado["mensaje"] );
		
		}elseif(isset($_POST['EstadoDoc'])){
		
			$params = array(
				 'tokenEmpresa' =>  $TokenEnterprise,
				 'tokenPassword' =>$TokenAutorizacion,
				 'documento' => $_POST["ConsultaDoc"]);
				 
			 //Enviar Objeto Factura
			 $resultado = $WebService->getEstadoDocumento(WSDL,$options,$params);
		
			echo "<h1>Resultado de la consulta de Documento</h1></br>";
		
			 print_r("Código: " .$resultado["codigo"] ."</br>Aceptación Fisica:  " .$resultado["aceptacionFisica"] ."</br>Ambiente:  " .$resultado["ambiente"] ."</br>Consecutivo:  " .$resultado["consecutivo"] ."</br>CUFE:  " .$resultado["cufe"] ."</br>Descripcion Documento:  " .$resultado["descripcionDocumento"] ."</br>Fecha Documento:  " .$resultado["fechaDocumento"] ."</br>Resultado:  " .$resultado["resultado"] );
		
		}
	}
}
?>