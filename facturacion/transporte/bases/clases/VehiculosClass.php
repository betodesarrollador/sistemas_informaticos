<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Vehiculos extends Controler{

  public function __construct(){
    parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("VehiculosLayoutClass.php");
    require_once("VehiculosModelClass.php");
	
    $Layout   = new VehiculosLayout($this -> getTitleTab(),$this -> getTitleForm(),$this -> getActividadId());
    $Model    = new VehiculosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
    $Layout -> setCambioEstado  ($Model -> getPermiso($this -> getActividadId(),'STATUS',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
    //LISTA MENU
    $Layout -> SetConfig        ($Model -> GetConfig	   ($this -> getConex()));
    $Layout -> SetTipoVehiculo	($Model -> getTipoVehiculo ($this -> getConex()));
    $Layout -> SetCarroceria	($Model -> GetCarroceria   ($this -> getConex()));
    $Layout -> SetCombustible	($Model -> GetCombustible  ($this -> getConex()));
    $Layout -> SetAseguradoras	($Model -> getAseguradoras ($this -> getConex()));
    $Layout -> setEstado        ();	 	
	
	$placa_id = $_REQUEST['placa_id'];

if ($placa_id > 0) {

    $Layout->setPlacaid($placa_id);

}

	
	//// GRID ////
    $Attributes = array(
	  id=>'vehiculos',	width=>'auto',	height=>250,	title=>'Listado de vehiculos',	sortname=>'placa'
    );

	$Cols = array(
	  array(name=>'placa',						index=>'placa',							sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'marca',						index=>'marca',							sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'linea',						index=>'linea',							sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'configuracion',				index=>'configuracion',							sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'carroceria',						index=>'carroceria',							sorttype=>'text',	width=>'100',	align=>'center'),  	  
	  array(name=>'modelo_vehiculo',			index=>'modelo_vehiculo',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'modelo_repotenciado',		index=>'modelo_repotenciado',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'color',						index=>'color',							sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'combustible',				index=>'combustible',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'motor',						index=>'motor',							sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'chasis',						index=>'chasis',						sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'peso_vacio',					index=>'peso_vacio',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'capacidad',					index=>'capacidad',						sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'identificacion_tenedor',		index=>'identificacion_tenedor',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'tenedor',					index=>'tenedor',						sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'identificacion_propietario',	index=>'identificacion_propietario',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'propietario',				index=>'propietario',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'tecnomecanico_vehiculo',		index=>'tecnomecanico_vehiculo',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'vencimiento_tecno_vehiculo',	index=>'vencimiento_tecno_vehiculo',	sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'numero_soat',				index=>'numero_soat',					sorttype=>'text',	width=>'100',	align=>'center'),	    
	  array(name=>'aseguradora',				index=>'aseguradora',					sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'vencimiento_soat',		    index=>'vencimiento_soat',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'propio',		                index=>'propio',					    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'monitoreo_satelital',		index=>'monitoreo_satelital',			sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'usuario',		            index=>'usuario',					    sorttype=>'text',	width=>'70',	align=>'center'),	  
	  array(name=>'password',		            index=>'password',						sorttype=>'text',	width=>'70',	align=>'center'),	
  	  array(name=>'aprobacion_ministerio',		index=>'aprobacion_ministerio',			sorttype=>'text',	width=>'70',	align=>'center'),	  
	  array(name=>'estado',		                index=>'estado',					    sorttype=>'text',	width=>'100',	align=>'center')


	);
	
        $Titles = array('PLACA',			'MARCA',			'LINEA','CONFIGURACION','CARROCERIA',			'MODELO',			'MODELO REPOTENCIADO',			'COLOR',
						'COMBUSTIBLE',		'NUMERO MOTOR',		'NUMERO CHASIS',	'PESO VACIO',		'CAPACIDAD DE CARGA',			'IDENTIFICACION TENEDOR',				'TENEDOR',						'IDENTIFICACION PROPIETARIO',
						'PROPIETARIO',		'TECNICO MECANICO',	'VENCIMIENTO',
						'N° SOAT','ASEGURADORA','VENCIMIENTO','PROPIO','MONITOREO','USUARIO','CLAVE','APROBACION MIN.','ESTADO');
		
	$Layout -> SetGridVehiculos($Attributes,$Titles,$Cols,$Model -> getQueryVehiculosGrid());
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");    
    $Data = new ValidateRow($this -> getConex(),"vehiculo",$this ->Campos);
    print $Data  -> GetData();
  }
  
  protected function validaVencimientoSoat(){
  
     $vencimiento_soat = $this -> requestData('vencimiento_soat');
	 
	 if($Model -> vencimientoSoatEsunAnioMayor($vencimiento_soat,$this -> getConex())){
	   exit('true');
	 }else{
	      exit('false');
	   }
  
  }
  
  protected function validaRepotenciacion(){
  	  
     $modelo_vehiculo = $this -> requestData('modelo_vehiculo');
     $repotenciado    = $this -> requestData('repotenciado');
	 $anio_actual     = date("Y");
	 	 
	 if($repotenciado > $anio_actual){
	    exit('mayor');	 
	 }else if($repotenciado <= $modelo_vehiculo){

         if($repotenciado < $modelo_vehiculo){
   	       exit('menor');
		 }else if($repotenciado == $modelo_vehiculo){
      	     exit('igual');
		   }

	   }else{
	       exit('true');
	     }
  
  }
  
     protected function validapropio(){ 
	   require_once("VehiculosModelClass.php");
	   $Model= new VehiculosModel();


	   $data      = $Model -> getDatosPropietario($this -> getEmpresaId(),$this -> getConex());
	   
	   $this -> getArrayJSON($data);
   }


  protected function onclickSave(){
  
    require_once("VehiculosModelClass.php");
    $Model = new VehiculosModel();
	
	$fecha_actual     = date("Y-m-d");
	$anio_actual      = date("Y");	
	$vencimiento_soat = $this -> requestData('vencimiento_soat');
	$peso_vacio       = $this -> requestData('peso_vacio');
	$propietario_id   = $this -> requestData('propietario_id');
	$tenedor_id       = $this -> requestData('tenedor_id');	
	$configuracion    = $this -> requestData('configuracion');	
	$capacidad        = $this -> requestData('capacidad');	
	$unidad_capacidad_carga = $this -> requestData('unidad_capacidad_carga');
	$peso_capacidad   = $peso_vacio + $capacidad;
	$peso_maximo      = $Model -> getPesoMaximoConfiguracion($configuracion,$this -> getConex());	
	$galones_minimo   = $Model -> getGalonesMinimoConfiguracion($configuracion,$this -> getConex());
	$galones_maximo   = $Model -> getGalonesMaximoConfiguracion($configuracion,$this -> getConex());		
	
	
    if(in_array($configuracion,array('55','56','64','74','85'))){
     
	   if(!is_numeric($capacidad)){
	     exit("La capacidad del vehiculo debe ser reportada !!");
	   }else if(strlen($capacidad) < 3 || strlen($capacidad) > 5){
	   	   
		 if(strlen($capacidad) < 3){
		   exit("La capacidad del vehiculo debe ser mayor a 3 digitos !!");
		 }else{
			  exit("La capacidad del vehiculo no debe ser mayor a 5 digitos !!");
			}
	   
	     }
	 
	}

    if($unidad_capacidad_carga == 1){
	
      if($peso_maximo > 0 && $peso_capacidad > $peso_maximo){	
	   exit("<div align='center'>El Peso Vacío + la Capacidad de carga de un camión rigido, no puede sobrepasar el límite permitido<br>Limite para la configuracion seleccionada : $peso_maximo</div>");	
	  }
	  
	}else{
	
        if($galones_minimo > 0 && $peso_capacidad < $galones_minimo){	
	     exit("<div align='center'>El Peso Vacío + la Capacidad de carga de un camión rigido, no puede ser inferior al límite permitido<br><br>Galones Minimo : $galones_minimo</div>");	
	    }	   
		
        if($galones_maximo > 0 && $peso_capacidad > $galones_maximo){	
	     exit("<div align='center'>El Peso Vacío + la Capacidad de carga de un camión rigido, no puede ser sobrepasar al límite permitido<br><br>Galones Maximo : $galones_maximo</div>");	
	    }	   		
	
	  }
	  	
	
	/*if($Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex()) && $Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){*/
	
	if($peso_vacio > 200 && $peso_vacio < 53000){	
		
		if($vencimiento_soat <= $fecha_actual){
		  exit('La fecha de vencimiento del SOAT no puede ser menor a la fecha actual');	
		}else{
		
		  if($Model -> vencimientoSoatEsunAnioMayor($vencimiento_soat,$this -> getConex())){	
		   
			exit('La fecha de vencimiento del SOAT no puede ser un año mayor a la fecha actual');
		   
		  }else{
			  
			 $modelo_vehiculo = $this -> requestData('modelo_vehiculo');
			 $repotenciado    = $this -> requestData('repotenciado');
			 $anio_actual     = date("Y");
				 
			 if(is_numeric($repotenciado) && $repotenciado > $anio_actual){
				exit('El año al que fue repotenciado no puede ser mayor al año actual.');	 
			 }else if(is_numeric($repotenciado) && $repotenciado <= $modelo_vehiculo){
		
				 if(is_numeric($repotenciado) && $repotenciado < $modelo_vehiculo){
				   exit('No puede ser menor al modelo reportado');
				 }else if($repotenciado == $modelo_vehiculo){
					 exit('No puede ser igual al modelo reportado');
				   }
		
			   }else{
	
					  $Model -> Save($this -> getUsuarioId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
			
					 if($Model -> GetNumError() > 0){
					  exit('Ocurrio una inconsistencia');
					 }else{
					   exit('true');
					  }	
	
				 }	  
				  
			}		   
		   
		 }
		 
		}else{
	       exit("El peso vacio reportado debe ser mayor a 200 kilogramos y menor a 53000 kilogramos.");
         } 		
	
	/*}else{
	

       if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex()) && !$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){
	   
	     exit("<div align='center'>El tenedor y propietario asignados al vehiculo no han sido reportados al ministerio<br><br>debe reportar primero al tenedor y propietario para poder guardar el vehiculo</div>");
	   
	   }else if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex())){
		 
		   exit("<div align='center'>El tenedor asignado al vehiculo no ha sido reportado al ministerio<br>debe reportar primero el tenedor para poder guardar el vehiculo</div>");
		 		 
		 }else if(!$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){
		 
		      		   exit("<div align='center'>El propietario asignado al vehiculo no ha sido reportado al ministerio<br>debe reportar primero el propietario para poder guardar el vehiculo</div>");
		 
		   }
	
	
	  }*/
	
		
  }

  protected function onclickUpdate(){
  
    require_once("VehiculosModelClass.php");
	$Model = new VehiculosModel();
		
	$fecha_actual     = date("Y-m-d");
	$anio_actual      = date("Y");	
	$vencimiento_soat = $this -> requestData('vencimiento_soat');
	$peso_vacio       = $this -> requestData('peso_vacio');
	$propietario_id   = $this -> requestData('propietario_id');
	$tenedor_id       = $this -> requestData('tenedor_id');	
	$configuracion    = $this -> requestData('configuracion');	
	$capacidad        = $this -> requestData('capacidad');
	$unidad_capacidad_carga = $this -> requestData('unidad_capacidad_carga');
	$peso_capacidad   = $peso_vacio + $capacidad;
	$peso_maximo      = $Model -> getPesoMaximoConfiguracion($configuracion,$this -> getConex());	
	$galones_minimo   = $Model -> getGalonesMinimoConfiguracion($configuracion,$this -> getConex());
	$galones_maximo   = $Model -> getGalonesMaximoConfiguracion($configuracion,$this -> getConex());			
		
    if(in_array($configuracion,array('55','56','64','74','85'))){
     
	   if(!is_numeric($capacidad)){
	     exit("La capacidad del vehiculo debe ser reportada !!");
	   }else if(strlen($capacidad) < 3 || strlen($capacidad) > 5){
	   	   
	         if(strlen($capacidad) < 3){
			   exit("La capacidad del vehiculo debe ser mayor a 3 digitos !!");
			 }else{
    			  exit("La capacidad del vehiculo no debe ser mayor a 5 digitos !!");
			    }
	   
	     }
	 
	}

    if($unidad_capacidad_carga == 1){
	
      if($peso_maximo > 0 && $peso_capacidad > $peso_maximo){	
	   exit("<div align='center'>El Peso Vacío + la Capacidad de carga de un camión rigido, no puede sobrepasar el límite permitido<br><br>Limite para la configuracion seleccionada : $peso_maximo</div>");	
	  }
	  
	}else{
	
        if($galones_minimo > 0 && $peso_capacidad < $galones_minimo){	
	     exit("<div align='center'>El Peso Vacío + la Capacidad de carga de un camión rigido, no puede ser inferior al límite permitido<br><br>Galones Minimo : $galones_minimo</div>");	
	    }	   
		
        if($galones_maximo > 0 && $peso_capacidad > $galones_maximo){	
	     exit("<div align='center'>El Peso Vacío + la Capacidad de carga de un camión rigido, no puede ser sobrepasar al límite permitido<br><br>Galones Maximo : $galones_maximo</div>");	
	    }   		
	
	  }
	
	
	
	/*if($Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex()) && $Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){	*/
	
	if($peso_vacio > 200 && $peso_vacio < 53000){
		
		if($vencimiento_soat <= $fecha_actual){
		  exit('La fecha de vencimiento del SOAT no puede ser menor a la fecha actual');	
		}else{
		
		  if($Model -> vencimientoSoatEsunAnioMayor($vencimiento_soat,$this -> getConex())){	
		   
			exit('La fecha de vencimiento del SOAT no puede ser un año mayor a la fecha actual');
		   
		  }else{
			  
			 $modelo_vehiculo = $this -> requestData('modelo_vehiculo');
			 $repotenciado    = $this -> requestData('repotenciado');
			 $anio_actual     = date("Y");
				 
			 if(is_numeric($repotenciado) && $repotenciado > $anio_actual){
			 
				exit('El año al que fue repotenciado no puede ser mayor al año actual.');	 
				
			 }else if(is_numeric($repotenciado) && $repotenciado <= $modelo_vehiculo){
		
				 if(is_numeric($repotenciado) && $repotenciado < $modelo_vehiculo){
				   exit('No puede ser menor al modelo reportado');
				 }else if($repotenciado == $modelo_vehiculo){
					 exit('No puede ser igual al modelo reportado');
				   }
		
			   }else{
	
					$Model -> Update($this -> getUsuarioId(),$this -> Campos,$this -> getConex());
					
					if($Model -> GetNumError() > 0){
					  exit('Ocurrio una inconsistencia');
					}else{
					  exit('true');
					}
	
				 }	  
				  
			}		   
		   
		 }
		 
		}else{
	       exit("El peso vacio reportado debe ser mayor a 200 kilogramos y menor a 53000 kilogramos.");
         } 	
		
	/*}else{
	

       if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex()) && !$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){
	   
	     exit("<div align='center'>El tenedor y propietario asignados al vehiculo no han sido reportados al ministerio<br>debe reportar primero al tenedor y propietario para poder guardar el vehiculo</div>");
	   
	   }else if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex())){
		 
		   exit("<div align='center'>El tenedor asignado al vehiculo no ha sido reportado al ministerio<br>debe reportar primero el tenedor para poder guardar el vehiculo</div>");
		 		 
		 }else if(!$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){
		 
		      		   exit("<div align='center'>El propietario asignado al vehiculo no ha sido reportado al ministerio<br>debe reportar primero el propietario para poder guardar el vehiculo</div>");
		 
		   }
	
	
	  }	*/	
  }
  
  protected function sendVehiculoMintransporte(){
        
	include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	$webService = new WebServiceMinTransporte($this -> getConex());	  
	  
	$data = array(	  
	    placa_id               => $this -> requestData('placa_id'),	
	    placa                  => $this -> requestData('placa'),
		configuracion          => $this -> requestData('configuracion'),
	    marca_id               => $this -> requestData('marca_id'),
		linea_id               => $this -> requestData('linea_id'),		
		numero_ejes            => $this -> requestData('numero_ejes'),		
		modelo_vehiculo        => $this -> requestData('modelo_vehiculo'),
		modelo_repotenciado    => $this -> requestData('modelo_repotenciado'),
		color_id               => $this -> requestData('color_id'),
	    peso_vacio             => $this -> requestData('peso_vacio'),
		capacidad              => $this -> requestData('capacidad'),
		unidad_capacidad_carga => $this -> requestData('unidad_capacidad_carga'),		
		carroceria_id          => $this -> requestData('carroceria_id'),				
		chasis                 => $this -> requestData('chasis'),	
		combustible_id         => $this -> requestData('combustible_id'),			
		numero_soat            => $this -> requestData('numero_soat'),					
		vencimiento_soat       => $this -> requestData('vencimiento_soat'),							
		aseguradora_soat_id    => $this -> requestData('aseguradora_soat_id'),									
		propietario_id         => $this -> requestData('propietario_id'),											
		tenedor_id             => $this -> requestData('tenedor_id'),													
		tenedor_id             => $this -> requestData('tenedor_id')																						
	  );
	  	  
    $webService -> sendVehiculoMintransporte($data,NULL);	      
  
  }      
	  
  protected function onclickDelete(){
  	require_once("VehiculosModelClass.php");
    $Model = new VehiculosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Vehiculo');
	}
  }

  protected function setDataRemolque(){

    require_once("VehiculosModelClass.php");

    $Model = new VehiculosModel();    

    $placa_remolque_id = $_REQUEST['placa_remolque_id'];

    $data = $Model -> getDataRemolque($placa_remolque_id,$this -> getConex());

    $this -> getArrayJSON($data);

  }

  protected function setDataPropietario(){

    require_once("VehiculosModelClass.php");

    $Model = new VehiculosModel();    

    $propietario_id = $_REQUEST['propietario_id'];

    $data = $Model -> getDataPropietario($propietario_id,$this -> getConex());

    $this -> getArrayJSON($data);

  }

  protected function setDataTenedor(){

    require_once("VehiculosModelClass.php");

    $Model = new VehiculosModel();    

    $tenedor_id = $_REQUEST['tenedor_id'];

    $data = $Model -> getDataTenedor($tenedor_id,$this -> getConex());

    $this -> getArrayJSON($data);

  }
  
  protected function tieneRemolque(){
  
    require_once("VehiculosModelClass.php");

    $Model            = new VehiculosModel();      
    $tipo_vehiculo_id = $_REQUEST['tipo_vehiculo_id'];
	
	$tieneRemolque    = $Model -> selectRequiereRemolque($tipo_vehiculo_id,$this -> getConex());
	
	if($tieneRemolque){
	  exit('true');
	}else{
	     exit('false');
	  }	  
  
  }

  protected function getReferenciasConductor(){
  
     require_once("VehiculosModelClass.php");

     $Model        = new VehiculosModel();        
     $conductor_id = $_REQUEST['conductor_id'];
     $Data         = $Model -> selectReferenciasConductor($conductor_id,$this -> getConex());
	 
	 $this -> getArrayJSON($Data);  
  }

//BUSQUEDA
  protected function onclickFind(){
  
  	require_once("VehiculosModelClass.php");
    $Model   = new VehiculosModel();
	
    $PlacaId = $_REQUEST['placa_id'];
	$Placa   = $_REQUEST['placa'];
		
	if(strlen(trim($PlacaId)) > 0){
      $Data = $Model -> selectVehiculosId($PlacaId,$this -> getConex());
	}else{
	      $Data = $Model -> selectVehiculosPlaca($Placa,$this -> getConex());
	   }
	
    $this -> getArrayJSON($Data);
  }

  protected function onclickPrint(){
  
    require_once("Imp_HV_VehiculoClass.php");
	
    $print = new Imp_HV_Vehiculo();
	
	$print -> printOut($this -> getConex());
  
  }
  
  protected function validaRevision(){
  
     $modelo = $_REQUEST['modelo'];
	 $anio   = date("Y");	 
	 $uso    = ($anio - $modelo);
	 
	 if($uso > 0){
	 
	    if($uso >= 6){
		  print 'true';
		}else{
		     print 'false';
		  }
	 
	 }else{
	      print 'false';
	   }

  
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[placa_id] = array(
		name	=>'placa_id',
		id		=>'placa_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('primary_key'))
	);

	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id	=>'empresa_id',
		type	=>'hidden',
                value   => $this -> getEmpresaId(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[empresa_id_static] = array(
		name  =>'empresa_id_static',
		id	  =>'empresa_id_static',
		type  =>'hidden',
        value => $this -> getEmpresaId(),
		datatype=>array(type =>'integer')
	);


	
	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
		size	=>'7',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alphanum',
			length	=>'6'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[marca] = array(
		name	=>'marca',
		id		=>'marca',
		type	=>'text',
		value	=>'',
		suggest=>array(
			name	=>'marca_vehiculo',
			setId	=>'marca_hidden')
	);
	
	$this -> Campos[marca_id] = array(
		name	=>'marca_id',
		id	=>'marca_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alphanum',
			length	=>'11'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[linea] = array(
		name	=>'linea',
		id	=>'linea',
		type	=>'text',
		value	=>'',
		suggest=>array(
			name	=>'linea_vehiculo',
			setId	=>'linea_hidden',
                        form    => 0)
	);
	
	$this -> Campos[linea_id] = array(
		name	=>'linea_id',
		id	=>'linea_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[configuracion] = array(
		name	=>'configuracion',
		id		=>'configuracion',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		selected=>'0',
		datatype=>array(
			type	=>'alphanum',
			length	=>'4'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_vehiculo_id] = array(
		name	=>'tipo_vehiculo_id',
		id		=>'tipo_vehiculo_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		selected=>'0',
		datatype=>array(
			type	=>'alphanum',
			length	=>'4'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[numero_ejes] = array(
		name	=>'numero_ejes',
		id	    =>'numero_ejes',
		type	=>'text',
        size    =>'2',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	
    $this -> Campos[carroceria_id] = array(
		name	=>'carroceria_id',
		id		=>'carroceria_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[tarjeta_propiedad] = array(
		name	=>'tarjeta_propiedad',
		id	=>'tarjeta_propiedad',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[placa_remolque] = array(
		name	=>'placa_remolque',
		id	=>'placa_remolque',
		type	=>'text',
		value	=>'',
        readonly => 'readonly',
		datatype=>array(
			type	=>'alphanum'),
		suggest=>array(
			name	=>'remolque',
			setId	=>'placa_remolque_hidden',
                        onclick =>'setDataRemolque')
	);

        $this -> Campos[placa_remolque_id] = array(
		name	 => 'placa_remolque_id',
		id	 => 'placa_remolque_hidden',
		type	 => 'hidden',
		datatype => array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[marca_remolque] = array(
		name	=>'marca_remolque',
		id	=>'marca_remolque',
		type	=>'text',
		value	=>'',
                readonly=>'readonly'
	);

	$this -> Campos[modelo_remolque] = array(
		name	=>'modelo_remolque',
		id	=>'modelo_remolque',
                size    =>'4',
		type	=>'text',
		value	=>'',
                readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum')
	);

	$this -> Campos[tipo_remolque] = array(
		name	=>'tipo_remolque',
		id	=>'tipo_remolque',
                size    =>'4',
		type	=>'text',
		value	=>'',
                readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum')
	);

	$this -> Campos[empresa_afiliado] = array(
		name	=>'empresa_afiliado',
		id	=>'empresa_afiliado',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[numero_carnet] = array(
		name	=>'numero_carnet',
		id	=>'numero_carnet',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[vencimiento_afiliacion] = array(
		name	=>'vencimiento_afiliacion',
		id	=>'vencimiento_afiliacion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[ciudad_vehiculo] = array(
		name	=>'ciudad_vehiculo',
		id	=>'ciudad_vehiculo',
		type	=>'text',
		value	=>'',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_vehiculo_hidden')
	);
	
	$this -> Campos[ciudad_vehiculo_id] = array(
		name	=>'ciudad_vehiculo_id',
		id	=>'ciudad_vehiculo_hidden',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_vehiculo] = array(
		name	=>'telefono_vehiculo',
		id	=>'telefono_vehiculo',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);

	$this -> Campos[registro_nacional_carga] = array(
		name	=>'registro_nacional_carga',
		id	=>'registro_nacional_carga',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);

	/*$this -> Campos[resolucion_expedicion] = array(
		name	=>'resolucion_expedicion',
		id	=>'resolucion_expedicion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);*/

	$this -> Campos[monitoreo_satelital] = array(
		name	=>'monitoreo_satelital',
		id	=>'monitoreo_satelital',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);

	$this -> Campos[link_monitoreo_satelital] = array(
		name	=>'link_monitoreo_satelital',
		id	=>'link_monitoreo_satelital',
		type	=>'text',
		value	=>'',
		text_uppercase =>'no',		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);

	$this -> Campos[usuario] = array(
		name	=>'usuario',
		id	=>'usuario',
		type	=>'text',
		value	=>'',
		text_uppercase =>'no',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);

	$this -> Campos[password] = array(
		name	=>'password',
		id	=>'password',
		type	=>'text',
		value	=>'',
		text_uppercase =>'no',		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[propio] = array(
		name	=>'propio',
		id	    =>'propio',
		type	=>'select',
		required=>'yes',
		options => array(array(value => 1, text => 'SI', selected => 0),array(value => 0, text => 'NO', selected => 0)),
		datatype=> array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
		
	);	

	
	$this -> Campos[modelo_vehiculo] = array(
		name	=>'modelo_vehiculo',
		id		=>'modelo_vehiculo',
		type	=>'text',
		required=>'yes',
		value	=>'',
		size	=>'4',
		datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[modelo_repotenciado] = array(
		name	=>'modelo_repotenciado',
		id		=>'modelo_repotenciado',
		type	=>'text',
		value	=>'',
		size	=>'4',
		datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[color] = array(
		name	=>'color',
		id		=>'color',
		type	=>'text',
		value=>'',
		suggest=>array(
			name	=>'color_vehiculo',
			setId	=>'color_hidden')
	);
	
	$this -> Campos[color_id] = array(
		name	=>'color_id',
		id		=>'color_hidden',
		type	=>'hidden',
		required=>'yes',		
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[combustible_id] = array(
		name	=>'combustible_id',
		id	=>'combustible_id',
		type	=> 'select',
		required=> 'yes',		
		options	=> array(),
		selected=>'0',
		datatype=> array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[motor]  = array(
		name	=>'motor',
		id		=>'motor',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[chasis] = array(
		name	=>'chasis',
		id		=>'chasis',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[peso_vacio] = array(
		name	=>'peso_vacio',
		id		=>'peso_vacio',
		type	=>'text',
		value	=>'',
		size	=>'5',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length  =>'5'
		),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[capacidad] = array(
		name	=>'capacidad',
		id		=>'capacidad',
		type	=>'text',
		value	=>'',
		size	=>'5',
		datatype=>array(
			type	=>'integer',
			length  =>'5'
		),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[unidad_capacidad_carga] = array(
		name	=>'unidad_capacidad_carga',
		id		=>'unidad_capacidad_carga',
		type	=>'select',
		options	=>array(array(value => '1', text => 'kilogramos'),array(value => '2', text => 'galones')),
		selected=>'1',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);	
		
	$this -> Campos[tenedor] = array(
		name	=>'tenedor',
		id	=>'tenedor',
		type	=>'text',
                size    =>'45',
		suggest=>array(
			name	=>'tenedor',
			setId	=>'tenedor_hidden',
                        onclick =>'setDataTenedor')
	);
	
	$this -> Campos[tenedor_id] = array(
		name	=>'tenedor_id',
		id	=>'tenedor_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[propietario] = array(
		name	=>'propietario',
		id	=>'propietario',
		type	=>'text',
                size    =>'45',
		suggest => array(
			name	=>'tercero',
			setId	=>'propietario_hidden',
                        onclick => 'setDataPropietario')
	);
	
	$this -> Campos[propietario_id] = array(
		name	=>'propietario_id',
		id	=>'propietario_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);


	$this -> Campos[tipo_persona_propietario] = array(
		name	=>'tipo_persona_propietario',
		id	=>'tipo_persona_propietario',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',
		datatype=>array(
			type	=>'alpha'),
	);

	$this -> Campos[cedula_nit_propietario] = array(
		name	=>'cedula_nit_propietario',
		id	=>'cedula_nit_propietario',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type=>'integer'),
	);

	$this -> Campos[telefono_propietario] = array(
		name	=>'telefono_propietario',
		id	=>'telefono_propietario',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(type=>'integer'),
	);

	$this -> Campos[celular_propietario] = array(
		name	=>'celular_propietario',
		id	    =>'celular_propietario',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type	=>'integer'),
	);

	$this -> Campos[direccion_propietario] = array(
		name	=>'direccion_propietario',
		id	    =>'direccion_propietario',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type	=>'text'),
	);


	$this -> Campos[email_propietario] = array(
		name	=>'email_propietario',
		id	    =>'email_propietario',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		datatype=>array(
			type	=>'text'),
	);

	$this -> Campos[ciudad_propietario] = array(
		name	=>'ciudad_propietario',
		id	    =>'ciudad_propietario',
		type	=>'text',
		value	=>'',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes'		
	);
	

	$this -> Campos[cedula_nit_tenedor] = array(
		name	=>'cedula_nit_tenedor',
		id	    =>'cedula_nit_tenedor',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type	=>'integer'),
	);

	$this -> Campos[tipo_persona_tenedor] = array(
		name	=>'tipo_persona_tenedor',
		id	    =>'tipo_persona_tenedor',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type	=>'alpha'),
	);

	$this -> Campos[telefono_tenedor] = array(
		name	=>'telefono_tenedor',
		id	    =>'telefono_tenedor',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(type=>'integer'),
	);

	$this -> Campos[celular_tenedor] = array(
		name	=>'celular_tenedor',
		id	    =>'celular_tenedor',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type	=>'integer'),
	);

	$this -> Campos[direccion_tenedor] = array(
		name	=>'direccion_tenedor',
		id	    =>'direccion_tenedor',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		required=>'yes',		
		datatype=>array(
			type	=>'text'),
	);


	$this -> Campos[email_tenedor] = array(
		name	=>'email_tenedor',
		id   	=>'email_tenedor',
		type	=>'text',
        readonly=>'yes',
		disabled=>'yes',		
		datatype=>array(
			type	=>'text'),
	);

	$this -> Campos[ciudad_tenedor] = array(
		name	=>'ciudad_tenedor',
		id	    =>'ciudad_tenedor',
		type	=>'text',
		value	=>'',
		disabled=>'yes',		
		required=>'yes'
		
	);
	

	$this -> Campos[tipo_cuenta_tenedor] = array(
		name	=>'tipo_cuenta_tenedor',
		id	    =>'tipo_cuenta_tenedor',
		type	=>'text',
		disabled=>'yes',		
        readonly=>'readonly',
		datatype=>array(
			type	=>'text')
	);

	$this -> Campos[banco_cuenta_tenedor] = array(
		name	=>'banco_cuenta_tenedor',
		id	=>'banco_cuenta_tenedor',
		type	=>'text',
		disabled=>'yes',		
		datatype=>array(
			type	=>'text')
	);
	
		
	$this -> Campos[venc_seguridad_social] = array(
		name	=>'venc_seguridad_social',
		id	=>'venc_seguridad_social',
		type	=>'text',
		datatype=>array(
			type	=>'text')
	);
	
	$this -> Campos[rut] = array(
		name	=>'rut',
		id		=>'rut',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/tenedores/rut/',
		size	=>'70',	
		//disabled=>'true',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_rut')
	);	
	
	$this -> Campos[seguridad_social] = array(
		name	=>'seguridad_social',
		id		=>'seguridad_social',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/tenedores/seguridad_social/',
		size	=>'70',	
		//disabled=>'true',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_seguridad_social_'.date("m"))
	);	
	
	
	

	$this -> Campos[numero_cuenta_tenedor] = array(
		name	=>'numero_cuenta_tenedor',
		id	=>'numero_cuenta_tenedor',
		type	=>'text',
		disabled=>'yes',		
		datatype=>array(
			type	=>'text')
	);




	$this -> Campos[tecnomecanico_vehiculo] = array(
		name	=>'tecnomecanico_vehiculo',
		id		=>'tecnomecanico_vehiculo',
		type	=>'text',
		value	=>'',
		size	=>'15',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[vencimiento_tecno_vehiculo] = array(
		name	=>'vencimiento_tecno_vehiculo',
		id		=>'vencimiento_tecno_vehiculo',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	
	
	$this -> Campos[numero_soat] = array(
		name	=>'numero_soat',
		id		=>'numero_soat',
		type	=>'text',
		required=>'yes',
		value	=>'',
		size	=>'15',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'30'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[aseguradora_soat_id] = array(
		name	=>'aseguradora_soat_id',
		id	=>'aseguradora_soat_id',
		type	=>'select',
		required=>'yes',
                options => array(),
		datatype=>array(type =>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[vencimiento_soat] = array(
		name	=>'vencimiento_soat',
		id		=>'vencimiento_soat',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[numero_extra] = array(
		name	=>'numero_extra',
		id		=>'numero_extra',
		type	=>'text',
		value	=>'',
		size	=>'15',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'30'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	

	$this -> Campos[conductor] = array(
		name	=>'conductor',
		id	    =>'conductor',
		type	=>'text',
		value	=>'',
        size    =>'50',
		suggest=>array(
			name	=>'conductor',
			setId	=>'conductor_hidden',
			onclick =>'getReferenciasConductor'
		)
	);
	
	$this -> Campos[conductor_id] = array(
		name	=>'conductor_id',
		id	=>'conductor_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	
 	$this -> Campos[archivo_imagen_frontal] = array(
		name	=>'archivo_imagen_frontal',
		id	    =>'archivo_imagen_frontal',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_frontal'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
	);	
	
 	$this -> Campos[archivo_imagen_lateral] = array(
		name	=>'archivo_imagen_lateral',
		id	    =>'archivo_imagen_lateral',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',	
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_lateral'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
	);	
	
 	$this -> Campos[archivo_imagen_trasera] = array(
		name	=>'archivo_imagen_trasera',
		id	    =>'archivo_imagen_trasera',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_trasera'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
	);		
	

 	$this -> Campos[archivo_cedula_conductor] = array(
		name	=>'archivo_cedula_conductor',
		id	=>'archivo_cedula_conductor',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
//		required=>'yes',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'conductor',
			text	=>'_cedula')
	);

 	$this -> Campos[archivo_antecedentes_conductor] = array(
		name	=>'archivo_antecedentes_conductor',
		id	=>'archivo_antecedentes_conductor',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'conductor',
			text	=>'_antecedentes')
		
	);


 	$this -> Campos[archivo_licencia_conductor] = array(
		name	=>'archivo_licencia_conductor',
		id	=>'archivo_licencia_conductor',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'conductor',
			text	=>'_licencia')
	);

 	$this -> Campos[archivo_arp_conductor] = array(
		name	=>'archivo_arp_conductor',
		id	=>'archivo_arp_conductor',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'conductor',
			text	=>'_arp')
	);

 	$this -> Campos[archivo_pos_conductor] = array(
		name	=>'archivo_pos_conductor',
		id	=>'archivo_pos_conductor',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'conductor',
			text	=>'_pos')
	);

 	$this -> Campos[archivo_cedula_propietario] = array(
		name	=>'archivo_cedula_propietario',
		id	=>'archivo_cedula_propietario',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'cedula_nit_propietario',
			text	=>'_cedula_propietario')
	);

 	$this -> Campos[archivo_targeta_propiedad_vehiculo] = array(
		name	=>'archivo_targeta_propiedad_vehiculo',
		id	=>'archivo_targeta_propiedad_vehiculo',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
//		required=>'yes',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_tarjeta_propiedad')
	);

 	$this -> Campos[archivo_contrato_leasing] = array(
		name	=>'archivo_contrato_leasing',
		id	=>'archivo_contrato_leasing',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_contrato_leasing')
	);

 	$this -> Campos[archivo_rut_propietario] = array(
		name	=>'archivo_rut_propietario',
		id	=>'archivo_rut_propietario',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'cedula_nit_propietario',
			text	=>'_rut_propietario')
	);

 	$this -> Campos[archivo_registro_nacional_carga] = array(
		name	=>'archivo_registro_nacional_carga',
		id	=>'archivo_registro_nacional_carga',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
//		required=>'yes',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_registro_nal_carga')
	);

 	$this -> Campos[archivo_registro_nacional_remolque] = array(
		name	=>'archivo_registro_nacional_remolque',
		id	=>'archivo_registro_nacional_remolque',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_registro_nal_remolque')
	);



 	$this -> Campos[archivo_revision_tecnomecanica] = array(
		name	=>'archivo_revision_tecnomecanica',
		id	=>'archivo_revision_tecnomecanica',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_revision_tecnomecanica')
	);

 	$this -> Campos[archivo_afiliacion_empresa_transporte] = array(
		name	=>'archivo_afiliacion_empresa_transporte',
		id	=>'archivo_afiliacion_empresa_transporte',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_afiliacion_empresa_trans')
	);

 	$this -> Campos[archivo_soat] = array(
		name	=>'archivo_soat',
		id	=>'archivo_soat',
		type	=>'file',
		value	=>'',
		path	=>'../../../imagenes/transporte/vehiculos/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'placa',
			text	=>'_soat')
	);	


	$this -> Campos[responsable_verificacion1] = array(
		name	=>'responsable_verificacion1',
		id	=>'responsable_verificacion1',
		type	=>'text',
		required=>'yes',
		value	=> $this -> getUsuarioNombres(),
                size     => 30,
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[responsable_verificacion1_static] = array(
		name	=>'responsable_verificacion1_static',
		id	=>'responsable_verificacion1_static',
		type	=>'hidden',
		value	=> $this -> getUsuarioNombres(),
		datatype=>array(
			type	=>'text')
	);


	$this -> Campos[nombre_persona_atendio1] = array(
		name	=>'nombre_persona_atendio1',
		id	=>'nombre_persona_atendio1',
		type	=>'text',
		value	=>'',
        size    => 30,
		required=>'yes',		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
   
	$this -> Campos[ciudad_persona_atendio1] = array(
		name	=>'ciudad_persona_atendio1',
		id	    =>'ciudad_persona_atendio1',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_persona_atendio1_hidden'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
		
	$this -> Campos[ciudad_persona_atendio1_id] = array(
		name	=>'ciudad_persona_atendio1_id',
		id		=>'ciudad_persona_atendio1_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);  
	
	$this -> Campos[telefono_persona_atendio1] = array(
		name	=>'telefono_persona_atendio1',
		id	    =>'telefono_persona_atendio1',
		required=>'yes',		
		type	=>'text',
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);	 	

	$this -> Campos[tipo_verificacion1] = array(
		name	=>'tipo_verificacion1',
		id	=>'tipo_verificacion1',
		type	=>'select',
		required=>'yes',		
		options	=> array(array(value => 'E',text => 'Email'),array(value => 'I', text => 'Internet'),array(value => 'L',text => 'Llamada')),		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);



	$this -> Campos[responsable_verificacion2] = array(
		name	=>'responsable_verificacion2',
		id	=>'responsable_verificacion2',
		type	=>'text',
		required=>'yes',		
		value	=> $this -> getUsuarioNombres(),
                size     => 30,
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[responsable_verificacion2_static] = array(
		name	=>'responsable_verificacion2_static',
		id	=>'responsable_verificacion2_static',
		type	=>'hidden',
		value	=> $this -> getUsuarioNombres(),
		datatype=>array(
			type	=>'text')
	);


	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
        size    => 30,
		required=>'yes',		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[ciudad_persona_atendio2] = array(
		name	=>'ciudad_persona_atendio2',
		id	    =>'ciudad_persona_atendio2',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_persona_atendio2_hidden'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
		
	$this -> Campos[ciudad_persona_atendio2_id] = array(
		name	=>'ciudad_persona_atendio2_id',
		id		=>'ciudad_persona_atendio2_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);  
	
	$this -> Campos[telefono_persona_atendio2] = array(
		name	=>'telefono_persona_atendio2',
		id	    =>'telefono_persona_atendio2',
		required=>'yes',		
		type	=>'text',
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);	 	

	$this -> Campos[tipo_verificacion2] = array(
		name	=>'tipo_verificacion2',
		id	=>'tipo_verificacion2',
		type	=>'select',
		required=>'yes',		
		options	=> array(array(value => 'E',text => 'Email'),array(value => 'I', text => 'Internet'),array(value => 'L',text => 'Llamada')),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[responsable_verificacion3] = array(
		name	=>'responsable_verificacion3',
		id	=>'responsable_verificacion3',
		type	=>'text',
		required=>'yes',		
		value	=> $this -> getUsuarioNombres(),
                size     => 30,
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[responsable_verificacion3_static] = array(
		name	=>'responsable_verificacion3_static',
		id	=>'responsable_verificacion3_static',
		type	=>'hidden',
		value	=> $this -> getUsuarioNombres(),
		datatype=>array(
			type	=>'text')
	);

	$this -> Campos[nombre_persona_atendio3] = array(
		name	=>'nombre_persona_atendio3',
		id	=>'nombre_persona_atendio3',
		type	=>'text',
		value	=>'',
        size    => 30,
		required=>'yes',		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[ciudad_persona_atendio3] = array(
		name	=>'ciudad_persona_atendio3',
		id	    =>'ciudad_persona_atendio3',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_persona_atendio3_hidden'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
		
	$this -> Campos[ciudad_persona_atendio3_id] = array(
		name	=>'ciudad_persona_atendio3_id',
		id		=>'ciudad_persona_atendio3_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'30'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);  
	
	$this -> Campos[telefono_persona_atendio3] = array(
		name	=>'telefono_persona_atendio3',
		id	    =>'telefono_persona_atendio3',
		required=>'yes',		
		type	=>'text',
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);	 		

	$this -> Campos[tipo_verificacion3] = array(
		name	=>'tipo_verificacion3',
		id	=>'tipo_verificacion3',
		type	=>'select',
		required=>'yes',		
		options	=> array(array(value => 'E',text => 'Email'),array(value => 'I', text => 'Internet'),array(value => 'L',text => 'Llamada')),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_confirmacion] = array(
		name	=>'fecha_confirmacion',
		id	=>'fecha_confirmacion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[aprobacion] = array(
		name	=>'aprobacion',
		id	=>'aprobacion',
		type	=>'select',
		options	=>array(array(value => 1,text => 'SI',selected => 1),array(value => 2,text => 'NO', selected => 1)),
		selected=>'0',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[persona_aprobo] = array(
		name	=>'persona_aprobo',
		id		=>'persona_aprobo',
		type	=>'text',
                size    =>'45',
		suggest => array(
			name	=>'tercero',
			setId	=>'persona_aprobo_hidden')
	);
	
	$this -> Campos[persona_aprobo_id] = array(
		name	=>'persona_aprobo_id',
		id		=>'persona_aprobo_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[persona_reviso] = array(
		name	=>'persona_reviso',
		id		=>'persona_reviso',
		type	=>'text',
                size    =>'45',
		suggest => array(
			name	=>'tercero',
			setId	=>'persona_reviso_hidden')
	);
	
	$this -> Campos[persona_reviso_id] = array(
		name	=>'persona_reviso_id',
		id		=>'persona_reviso_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	=>'usuario_id',
		type	=>'hidden',
		value	=>$this -> getUsuarioId(),		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id	=>'oficina_id',
		type	=>'hidden',
		value	=>'',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_actual] = array(
		name	=>'fecha_actual',
		id	=>'fecha_actual',
		type	=>'hidden',
		value	=>date('Y-m-d H:m:s'),		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_ingreso] = array(
		name	=>'fecha_ingreso',
		id	=>'fecha_ingreso',
		type	=>'hidden',
		value	=>date('Y-m-d H:m:s'),		
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
		required =>'yes',
		options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
        selected => 'B',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);	
	
	$this -> Campos[kilometraje] = array(
		name	=>'kilometraje',
		id		=>'kilometraje',
		type	=>'text',
		value	=>'',
		size	=>'8',
		datatype=>array(
			type	=>'integer',
			length  =>'10'
		),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[gruptrabajo]  = array(
		name	=>'gruptrabajo',
		id		=>'gruptrabajo',
		type	=>'text',
		required=>'no',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[novedades]  = array(
		name	=>'novedades',
		id	=>'novedades',
		type	=>'textarea',
		datatype=>array(
			type	=>'text'
                ),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[general] = array(
		name	=>'general',
		id	=>'general',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[frenos] = array(
		name	=>'frenos',
		id	=>'frenos',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
	$this -> Campos[sincroni] = array(
		name	=>'sincroni',
		id	=>'sincroni',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);
	
		$this -> Campos[direccion] = array(
		name	=>'direccion',
		id	=>'direccion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	);

		$this -> Campos[alineacion] = array( 
		name	=>'alineacion',
		id	=>'alineacion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	); 
		$this -> Campos[venc_invima] = array( 
		name	=>'venc_invima',
		id	=>'venc_invima',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	); 
	
		$this -> Campos[fumigacion] = array( 
		name	=>'fumigacion',
		id	=>'fumigacion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('vehiculo'),
			type	=>array('column'))
	); 

	
	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'VehiculoOnSaveUpdate'
			)
	);
	  
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'VehiculoOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'VehiculoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'vehiculoReset(this.form)');
		
		
   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	        displayoptions => array(
                  beforeprint => 'beforePrint',
                  form        => 0,
		  title       => 'Impresion Vehiculo',
		  width       => '700',
		  height      => '600'
		)

	);		
		
	//BUSQUEDA
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=> '1',
		suggest=>array(
			name	=>'busca_vehiculo',
			setId	=>'placa_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new Vehiculos();

?>