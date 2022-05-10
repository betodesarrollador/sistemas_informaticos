<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ReenvioXMLMinTransporte extends Controler{

  public function __construct(){      
    parent::__construct(3);    
  }  
  
  public function Main(){
  
    $this -> noCache();
    
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");

    $Layout   = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReenvioXMLMinTransporteModel();
	
    $Layout -> setIncludes();	
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

   // $Layout -> SetReporteReenvioXMLMinTransporte($Model -> getReporteReenvioXMLMinTransporte($this -> getConex()));    	
   
    $Layout -> RenderMain();   
  
  }

  protected function generateReport(){

    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    $Layout   = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReenvioXMLMinTransporteModel();
			
    $Layout -> setCssInclude("../../../framework/css/reset.css");	 	 	 
    $Layout -> setCssInclude("../../../framework/css/general.css");	 	 	 	 
    $Layout -> setCssInclude("../../../framework/css/generalDetalle.css");	
	$Layout -> setCssInclude("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");			 
	

	 $Layout -> setJsInclude("../../../framework/js/jquery.js");
	 $Layout -> setJsInclude("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
	 $Layout -> setJsInclude("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $Layout -> setJsInclude("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $Layout -> setJsInclude("../../../framework/js/jqueryform.js");
	 $Layout -> setJsInclude("../../../framework/js/funciones.js");
	 $Layout -> setJsInclude("../../../framework/js/funcionesDetalle.js");	 
	 $Layout -> setJsInclude("../../../framework/js/ajax-list.js");
	 $Layout -> setJsInclude("../../../framework/js/ajax-dynamic-list.js");
	 $Layout -> setJsInclude("../../../transporte/operacion/js/ReenvioXMLMinTransporte.js");
	 $Layout -> setJsInclude("../../../framework/js/jquery.alerts.js");  

    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
	$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	

	$tipo=$_REQUEST['tipo']; 
	if($tipo=='CONDUCTOR'){
		$data = $Model -> getReporteConductores($this -> getConex());
		$Layout -> setVar("CONDUCTORES",$data);	
	}elseif($tipo=='PROPIETARIOS'){
		$data = $Model -> getReportePropietarios($this -> getConex());
		$Layout -> setVar("PROPIETARIOS",$data);	

	}elseif($tipo=='TENEDORES'){
		$data = $Model -> getReporteTenedores($this -> getConex());
		$Layout -> setVar("TENEDORES",$data);
		
	}elseif($tipo=='REMOLQUES'){
		$data = $Model -> getReporteRemolques($this -> getConex());
		$Layout -> setVar("REMOLQUES",$data);	

	}elseif($tipo=='VEHICULOS'){
		$data = $Model -> getReporteVehiculos($this -> getConex());
		$Layout -> setVar("VEHICULOS",$data);	

	}elseif($tipo=='CLIENTES'){
		$data = $Model -> getReporteClientes($this -> getConex());
		$Layout -> setVar("CLIENTES",$data);	

	}elseif($tipo=='REMITENTES'){
		$data = $Model -> getReporteRemitentes($this -> getConex());
		$Layout -> setVar("REMITENTES",$data);	

	}elseif($tipo=='DESTINATARIOS'){
		$data = $Model -> getReporteDestinatarios($this -> getConex());
		$Layout -> setVar("DESTINATARIOS",$data);	

	}elseif($tipo=='REMESAS'){
		$data = $Model -> getReporteRemesas($this -> getConex());
		$Layout -> setVar("REMESAS",$data);	
		
	}elseif($tipo=='MANIFIESTOS'){
		$data = $Model -> getReporteManifiesto2($this -> getConex());
		$Layout -> setVar("MANIFIESTOS",$data);	


	}elseif($tipo=='CUMREMESAS'){
		$data = $Model -> getReporteRemesas3($this -> getConex());
		$Layout -> setVar("CUMREMESAS",$data);	
		
	}elseif($tipo=='CUMMANIFIESTOS'){
		$data = $Model -> getReporteManifiesto3($this -> getConex());
		$Layout -> setVar("CUMMANIFIESTOS",$data);	

	}elseif($tipo=='CUMMANIFIESTOSPRO'){
		$data = $Model -> getReporteManifiesto3propios($this -> getConex());
		$Layout -> setVar("CUMMANIFIESTOSPRO",$data);	



	}elseif($tipo=='ANUREMESAS'){
		$data = $Model -> getReporteAnuRemesas($this -> getConex());
		$Layout -> setVar("ANUREMESAS",$data);	
		
	}elseif($tipo=='ANUMANIFIESTOS'){
		$data = $Model -> getReporteAnuManifiesto($this -> getConex());
		$Layout -> setVar("ANUMANIFIESTOS",$data);	


	}
	$Layout -> setVar("REPORTE","SI");		

    		
    $Layout	-> RenderLayout('ReenvioXMLMinTransporteLayout.tpl');	
  
  }

  
  public function sendConductorMintransporte(){
    
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir  = $this -> requestData('reconstruir');
	$conductor_id = $this -> requestData('conductor_id');
	$path_xml     = $this -> requestData('path_xml');
		
	if($reconstruir == 'true' || !is_file($path_xml)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS       = new WebServiceMinTransporteModel();		   			
	   $dataConductor = $ModelWS -> selectConductor($conductor_id,$this -> getConex());	   
	
	   $data = array(	  
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
		  
	   $webService -> sendConductorMintransporte($data,NULL);	
			   
	}else{
	
	     $webService -> sendConductorMintransporte(NULL,$path_xml);
	
	}
   	    
    $this -> generateReport();
  
  }
  
  public function sendPropietarioMintransporte(){
    
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir  = $this -> requestData('reconstruir');
	$tercero_id   = $this -> requestData('tercero_id');
	$path_xml     = $this -> requestData('path_xml');
		
	if($reconstruir == 'true' || !is_file($path_xml)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS         = new WebServiceMinTransporteModel();		   			
	   $dataPropietario = $ModelWS -> selectPropietario($tercero_id,$this -> getConex());	   
	
	   $data = array(	  
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
	  
  
       $webService -> sendPropietarioMintransporte($data,NULL);	  
			   
	}else{
	
	     $webService -> sendPropietarioMintransporte(NULL,$path_xml);	  
	
	  }
   	    
    $this -> generateReport();
  
  } 
  
  public function sendTenedorMintransporte(){
    
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir  = $this -> requestData('reconstruir');
	$tenedor_id   = $this -> requestData('tenedor_id');
	$path_xml     = $this -> requestData('path_xml');
		
	if($reconstruir == 'true' || !is_file($path_xml)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS     = new WebServiceMinTransporteModel();		   			
	   $dataTenedor = $ModelWS -> selectTenedor($tenedor_id,$this -> getConex());	   
	
	   $data = array(	  
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
	  
  
       $webService -> sendTenedorMintransporte($data,NULL);	  
			   
	}else{
	
	     $webService -> sendTenedorMintransporte(NULL,$path_xml);	  
	
	  }
   	    
    $this -> generateReport();
  
  } 
  
  public function sendRemolqueMintransporte(){
      
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir       = $this -> requestData('reconstruir');
	$placa_remolque_id = $this -> requestData('placa_remolque_id');
	$path_xml          = $this -> requestData('path_xml');
		
	if($reconstruir == 'true' || !is_file($path_xml)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS      = new WebServiceMinTransporteModel();		   			
	   $dataRemolque = $ModelWS -> selectRemolque($placa_remolque_id,$this -> getConex());	   
		  
		$data = array(	  
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
			  
		$webService -> sendRemolqueMintransporte($data,NULL);	      
			   
	}else{
	
		  $webService -> sendRemolqueMintransporte(NULL,$path_xml);	      
	
	  }
   	    
    $this -> generateReport();
  
  } 
  
  public function sendVehiculoMintransporte(){
          
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir = $this -> requestData('reconstruir');
	$placa_id    = $this -> requestData('placa_id');
	$path_xml    = $this -> requestData('path_xml');
	
	if($reconstruir == 'true' || !is_file($path_xml)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS      = new WebServiceMinTransporteModel();		   			
	   $dataVehiculo = $ModelWS -> selectVehiculo($placa_id,$this -> getConex());	   
		  
	   $data = array(	  
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
			  
      $webService -> sendVehiculoMintransporte($data,NULL);
			   
	}else{
	
		  $webService -> sendVehiculoMintransporte(NULL,$path_xml);
	
	  }	
			  
	$this -> generateReport();
	  	  
  }
  
  public function sendRemitenteDestinatarioMintransporte(){
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir               = $this -> requestData('reconstruir');
    $cliente_id                = $this -> requestData('cliente_id');
	$remitente_destinatario_id = $this -> requestData('remitente_destinatario_id');
	$tipo                      = $this -> requestData('tipo');
	$path_xml                  = $this -> requestData('path_xml');
	
	
	if($reconstruir == 'true' || !is_file($path_xml)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS      = new WebServiceMinTransporteModel();		   			
	   
	   if(is_numeric($cliente_id)){
	     $dataRemitenteDestinatario = $ModelWS -> selectDataCliente($cliente_id,$this -> getConex());
	   }else if(is_numeric($remitente_destinatario_id)){
	       $dataRemitenteDestinatario = $ModelWS -> selectDataRemitenteDestinatario($remitente_destinatario_id,$tipo,$this -> getConex());
	     }
	   
		$data = array(	  
			remitente_destinatario_id => $dataRemitenteDestinatario[0]['remitente_destinatario_id'],
			tipo_identificacion_id    => $dataRemitenteDestinatario[0]['tipo_identificacion_id'],
			numero_identificacion     => $dataRemitenteDestinatario[0]['numero_identificacion'].$dataRemitenteDestinatario[0]['digito_verificacion'],
			nombre                    => $dataRemitenteDestinatario[0]['nombre'],	
			nombre_sede               => $dataRemitenteDestinatario[0]['nombre'],	
			primer_apellido           => $dataRemitenteDestinatario[0]['primer_apellido'],
			segundo_apellido          => $dataRemitenteDestinatario[0]['segundo_apellido'],
			telefono                  => $dataRemitenteDestinatario[0]['telefono'],
			direccion                 => $dataRemitenteDestinatario[0]['direccion'],
			ubicacion_id              => $dataRemitenteDestinatario[0]['ubicacion_id']
		  );
		  
		$webService -> sendRemitenteDestinatarioMintransporte($data,NULL);
			   
	}else{
	
		  $webService -> sendRemitenteDestinatarioMintransporte(NULL,$path_xml);
	
	  }	
			  
	$this -> generateReport();	  	    	
  
  }
  
//aca
  
  public function sendInformacionViaje(){   
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir                = $this -> requestData('reconstruir');
    $manifiesto_id              = $this -> requestData('manifiesto_id');
	$path_xml_informacion_viaje = $this -> requestData('path_xml_informacion_viaje');
	
	if($reconstruir == 'true' || !is_file($path_xml_informacion_viaje)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS       = new WebServiceMinTransporteModel();		   			
       $dataInfoViaje = $ModelWS -> selectDataInfoViaje($manifiesto_id,$this -> getConex());	   	   
 
	   $data = array(	  	
		 manifiesto_id                        => $manifiesto_id,	
		 manifiesto                           => $dataInfoViaje[0]['manifiesto'],	
		 informacion_viaje                    => $dataInfoViaje[0]['informacion_viaje'],			 
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
	  
       $webService -> sendInformacionViaje($data,NULL);	
			   
	}else{
	
	   $webService -> sendInformacionViaje(NULL,$path_xml_informacion_viaje);	
	
	  }	
			  
	$this -> generateReport();	  	    	     
  
  }
  
  protected function sendInformacionRemesa(){   
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir     = $this -> requestData('reconstruir');
	$manifiesto_id   = $this -> requestData('manifiesto_id');
    $remesa_id       = $this -> requestData('remesa_id');	
	$path_xml_remesa = $this -> requestData('path_xml_remesa');
	
	if($reconstruir == 'true' || !is_file($path_xml_remesa)){
	
	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS    = new WebServiceMinTransporteModel();		   			
       $dataRemesa = $ModelWS -> selectInfoRemesa($remesa_id,$manifiesto_id,$this -> getConex());	   	   
 
	   $data = array(	  	
	   
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
		 hora_recogida_ss                    => $dataRemesa[0]['hora_recogida_ss'],		 
		 fecha_llegada_cargue                => $dataRemesa[0]['fecha_llegada_cargue'],		 
	     hora_llegada_cargue                 => $dataRemesa[0]['hora_llegada_cargue'],		 
	     fecha_entrada_cargue                => $dataRemesa[0]['fecha_entrada_cargue'],		 
	     hora_entrada_cargue                 => $dataRemesa[0]['hora_entrada_cargue'],		 
	     fecha_salida_cargue                 => $dataRemesa[0]['fecha_salida_cargue'],		 
	     hora_salida_cargue                  => $dataRemesa[0]['hora_salida_cargue']		 

	   );
	  
       $webService -> sendInformacionRemesa($data,NULL);	
			   
	}else{
	
	   $webService -> sendInformacionRemesa(NULL,$path_xml_remesa);	
	
	  }	
			  
	$this -> generateReport();	  	    	     
    
  }
  
  public function sendInformacionManifiesto(){
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $reconstruir         = $this -> requestData('reconstruir');
    $manifiesto_id       = $this -> requestData('manifiesto_id');	
	$path_xml_manifiesto = $this -> requestData('path_xml_manifiesto');
	
	if($reconstruir == 'true' || !is_file($path_xml_manifiesto)){

	   require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	   
	   $ModelWS  = new WebServiceMinTransporteModel();		   			
       $dataM    = $ModelWS -> selectManifiesto($manifiesto_id,$this -> getConex());
		   
       $webService -> sendInformacionViaje($dataM[0],NULL);	
			   
	}else{
	
	   $webService -> sendInformacionViaje(NULL,$path_xml_manifiesto);	
	
	  }	
			  
	$this -> generateReport();	  	    	               
  
  }

  public function sendInformacionCumManifiesto(){
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $manifiesto_id       = $this -> requestData('manifiesto_id');
	$liquidacion_despacho_id       = $this -> requestData('liquidacion_despacho_id');

	require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	
	$ModelWS  = new WebServiceMinTransporteModel();		   			
	$dataM    = $ModelWS -> selectManifiesto($manifiesto_id,$this -> getConex());
	$dataM[0]['liquidacion_despacho_id'] =  $liquidacion_despacho_id; 
	$webService -> cumplirManifiestoCargaMinisterio($dataM[0]);	
			   
	$this -> generateReport();	  	    	               
	
 }

  public function sendInformacionCumManifiestoPropio(){
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
    $manifiesto_id       = $this -> requestData('manifiesto_id');

	require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteModelClass.php");	
	
	$ModelWS  = new WebServiceMinTransporteModel();		   			
	$dataM    = $ModelWS -> selectManifiesto($manifiesto_id,$this -> getConex());
	$webService -> cumplirManifiestoCargaMinisterioPropio($dataM[0]);	
			   
	$this -> generateReport();	  	    	               
	
 }


  public function sendInformacionAnulRemesa(){
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
	$data = array(	  
	    remesa_id           => $this -> requestData('remesa_id'),		
	    numero_remesa       => $this -> requestData('numero_remesa'),	
		causal_anulacion_id => $this -> requestData('causal_anulacion_id')
	  );
	  
    $webService -> anularRemesaMinisterio($data);	     

			   
	$this -> generateReport();	  	    	               
	
 }

  public function sendInformacionAnulManifiesto(){
  
    require_once("ReenvioXMLMinTransporteLayoutClass.php");
    require_once("ReenvioXMLMinTransporteModelClass.php");
	
    require_once($_SERVER['DOCUMENT_ROOT']."../../../transporte/webservice/WebServiceMinTranporteClass.php");

    $Layout      = new ReenvioXMLMinTransporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ReenvioXMLMinTransporteModel();
    $webService  = new WebServiceMinTransporte($this -> getConex());	 	
		
	$data = array(	  
	    manifiesto_id           => $this -> requestData('manifiesto_id'),		
	    manifiesto       => $this -> requestData('manifiesto'),	
		causal_anulacion_id => $this -> requestData('causal_anulacion_id')
	  );
	  
    $webService -> anularManifiestoMinisterio($data);	     

   
	$this -> generateReport();	  	    	               
	
 }

}
new ReenvioXMLMinTransporte();
 
?>