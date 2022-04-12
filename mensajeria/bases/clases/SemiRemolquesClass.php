<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SemiRemolques extends Controler{

  public function __construct(){
	 parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
		
	require_once("SemiRemolquesLayoutClass.php");
	require_once("SemiRemolquesModelClass.php");
	
	$Layout   = new SemiRemolquesLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model    = new SemiRemolquesModel();
		
	$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	$Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
	$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setCambioEstado  ($Model -> getPermiso($this -> getActividadId(),'STATUS',$this -> getConex()));		
	
	$Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetConfig		($Model -> GetConfig		($this -> getConex()));
	$Layout -> SetCarroceria	($Model -> GetCarroceria	($this -> getConex()));
    $Layout -> setEstado        ();	 		
	
	
	//// GRID ////
	$Attributes = array(
		id		=>'placa_remolque_hijodeputa',
		title	=>'Listado de Remolques',
		//sortname=>'placa_remolque',
		width	=>'auto',
		height	=>250
	);
	$Cols = array(		
		array(name=>'placa_remolque',	        index=>'placa_remolque',	       sorttype=>'text',	width=>'100',	align=>'center'),

		array(name=>'modelo_remolque',	        index=>'modelo_remolque',	       sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'tipo_remolque',	        index=>'tipo_remolque',	           sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'carroceria',	            index=>'carroceria',	           sorttype=>'text',	width=>'100',	align=>'center'),		
		array(name=>'peso_vacio_remolque',      index=>'peso_vacio_remolque',      sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'capacidad_carga_remolque',	index=>'capacidad_carga_remolque', sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'marca',	                index=>'marca',	       sorttype=>'text',	width=>'100',	align=>'center'),		
		array(name=>'propietario',	            index=>'propietario',	           sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'tenedor',	                index=>'tenedor',	               sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'estado',	                index=>'estado',	               sorttype=>'text',	width=>'100',	align=>'center')		
	);
	$Titles = array('PLACA REMOLQUE','MODELO','TIPO','CARROCERIA','PESO VACIO','CAPACIDAD CARGA','MARCA','PROPIETARIO','TENEDOR','ESTADO');
	
	$Layout -> SetGridRemolques($Attributes,$Titles,$Cols,$Model -> getQueryRemolquesGrid());	  
	
	$Layout -> RenderMain();
		
  }
	
	
  
  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
	$Data = new ValidateRow($this -> getConex(),"remolque",$this ->Campos);
	print $Data  -> GetData();
  }
	
  protected function onclickSave(){
  
    require_once("SemiRemolquesModelClass.php");
    $Model = new SemiRemolquesModel();
		
				
	$peso_vacio       = $this -> requestData('peso_vacio_remolque');
	$propietario_id   = $this -> requestData('propietario_id');
	$tenedor_id       = $this -> requestData('tenedor_id');	
	$configuracion    = $this -> requestData('tipo_remolque_id');	
	$capacidad        = $this -> requestData('capacidad_carga_remolque');	
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
	  	
	
/*	if($Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex()) && $Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){*/
	
		
	if($peso_vacio > 200 && $peso_vacio < 53000){	
		
		$Model -> Save($this -> Campos,$this -> getConex());
		
		if($Model -> GetNumError() > 0){
		  exit('Ocurrio una inconsistencia');
		}else{
		  exit('true');
		}	
	
		 
	 }else{
	       exit("El peso vacio reportado debe ser mayor a 200 kilogramos y menor a 53000 kilogramos.");
      } 		
		
/*   }else{
	

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
  
    require_once("SemiRemolquesModelClass.php");
    $Model = new SemiRemolquesModel();
						
	$peso_vacio       = $this -> requestData('peso_vacio_remolque');
	$propietario_id   = $this -> requestData('propietario_id');
	$tenedor_id       = $this -> requestData('tenedor_id');	
	$configuracion    = $this -> requestData('tipo_remolque_id');	
	$capacidad        = $this -> requestData('capacidad_carga_remolque');	
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
			
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
		  exit('Ocurrio una inconsistencia');
		}else{
		  exit('true');
		  }
						  
		}else{
	       exit("El peso vacio reportado debe ser mayor a 200 kilogramos y menor a 53000 kilogramos.");
         } 		
		
/*     }else{
	

       if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex()) && !$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){
	   
	     exit("<div align='center'>El tenedor y propietario asignados al vehiculo no han sido reportados al ministerio<br><br>debe reportar primero al tenedor y propietario para poder guardar el vehiculo</div>");
	   
	   }else if(!$Model -> tenedorFueReportadoMinisterio($tenedor_id,$this -> getConex())){
		 
		   exit("<div align='center'>El tenedor asignado al vehiculo no ha sido reportado al ministerio<br>debe reportar primero el tenedor para poder guardar el vehiculo</div>");
		 		 
		 }else if(!$Model -> propietarioFueReportadoMinisterio($propietario_id,$this -> getConex())){
		 
		      		   exit("<div align='center'>El propietario asignado al vehiculo no ha sido reportado al ministerio<br>debe reportar primero el propietario para poder guardar el vehiculo</div>");
		 
		   }
	
	
	  }*/
	

  }
  
  protected function sendRemolqueMintransporte(){
        
	include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	$webService = new WebServiceMinTransporte($this -> getConex());	  
	  
	$data = array(	  
	    placa_remolque_id        => $this -> requestData('placa_remolque_id'),	
	    placa_remolque           => $this -> requestData('placa_remolque'),
		tipo_remolque_id         => $this -> requestData('tipo_remolque_id'),
	    marca_remolque_id        => $this -> requestData('marca_remolque_id'),
		carroceria_remolque_id   => $this -> requestData('carroceria_remolque_id'),
		modelo_remolque          => $this -> requestData('modelo_remolque'),
		peso_vacio_remolque      => $this -> requestData('peso_vacio_remolque'),
		capacidad_carga_remolque => $this -> requestData('capacidad_carga_remolque'),
		unidad_capacidad_carga   => $this -> requestData('unidad_capacidad_carga'),
		propietario_id           => $this -> requestData('propietario_id'),											
		tenedor_id               => $this -> requestData('tenedor_id')
	);
	  	  
    $webService -> sendRemolqueMintransporte($data);	      
  
  }    
	  
  protected function onclickDelete(){
  	require_once("SemiRemolquesModelClass.php");
    $Model = new SemiRemolquesModel();
    $Model -> Delete($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	  exit('Se elimino correctamente el Semiremolque');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
   
  	require_once("SemiRemolquesModelClass.php");
    $Model = new SemiRemolquesModel();
    $Placa = $_REQUEST['placa_remolque'];
    $Data =  $Model -> selectSemiremolques($Placa,$this -> getConex());
	
    $this -> getArrayJSON($Data);
	
  }



  protected function setCampos(){
  
	//FORMULARIO
	
	$this -> Campos[placa_remolque_id] = array(
		name	=>'placa_remolque_id',
		id		=>'placa_remolque_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'6'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('primary_key'))
	);	
	
	$this -> Campos[placa_remolque] = array(
		name	=>'placa_remolque',
		id		=>'placa_remolque',
		type	=>'text',
		required=>'yes',
		value	=>'',
		size	=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'6'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	$this -> Campos[marca_remolque] = array(
		name	=>'marca_remolque',
		id		=>'marca_remolque',
		type	=>'text',
		suggest=>array(
			name	=>'marca_remolque',
			setId	=>'marca_remolque_hidden')
	);
	
	$this -> Campos[marca_remolque_id] = array(
		name	=>'marca_remolque_id',
		id		=>'marca_remolque_hidden',
		required=>'yes',
		type	=>'hidden',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	
	
	/*$this -> Campos[color] = array(
		name	=>'color',
		id		=>'color',
		type	=>'text',
		suggest=>array(
			name	=>'color_vehiculo',
			setId	=>'color_hidden')
	);
	
	$this -> Campos[color_id] = array(
		name	=>'color_id',
		id		=>'color_hidden',
		required=>'yes',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);	*/	
	
	
	$this -> Campos[modelo_remolque] = array(
		name	=>'modelo_remolque',
		id		=>'modelo_remolque',
		type	=>'text',
		size	=>'4',
		datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_remolque_id] = array(
		name	=>'tipo_remolque_id',
		id		=>'tipo_remolque_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		selected=>'0',
		datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction	=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	$this -> Campos[carroceria_remolque_id] = array(
		name	=>'carroceria_remolque_id',
		id		=>'carroceria_remolque_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		selected=>'0',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_vacio_remolque] = array(
		name	=>'peso_vacio_remolque',
		id		=>'peso_vacio_remolque',
		type	=>'text',
		value	=>'',
		size	=>'5',
		datatype=>array(
			type	=>'integer',
			length	=>'5'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	$this -> Campos[capacidad_carga_remolque] = array(
		name	=>'capacidad_carga_remolque',
		id		=>'capacidad_carga_remolque',
		type	=>'text',
		value	=>'',
		size	=>'5',
		datatype=>array(
			type	=>'integer',
			length	=>'5'),
		transaction=>array(
			table	=>array('remolque'),
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
			table	=>array('remolque'),
			type	=>array('column'))
	);		
	
 	$this -> Campos[archivo_imagen_lateral] = array(
		name	=>'archivo_imagen_lateral',
		id	=>'archivo_imagen_lateral',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/semiremolques/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('remolque'),
			type	=>array('column')),
		namefile=>array(
		  text	=>'_lateral',
		  namefield=>'placa_remolque',
		),
		settings=>array(
		  width => 480,
		  height=> 320
		)
	);
	
 	$this -> Campos[archivo_imagen_atras] = array(
		name	=>'archivo_imagen_atras',
		id	=>'archivo_imagen_atras',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/semiremolques/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('remolque'),
			type	=>array('column')),
		namefile=>array(
			text	=>'_atras',
		    namefield=>'placa_remolque'			
			),
		settings=>array(
		  width => 480,
		  height=> 320
		)
	);		
	
	
	$this -> Campos[tenedor] = array(
		name	=>'tenedor',
		id		=>'tenedor',
		type	=>'text',
		size    =>'50',
		suggest=>array(
			name	=>'tenedor',
			setId	=>'tenedor_hidden')
	);
	
	$this -> Campos[tenedor_id] = array(
		name	=>'tenedor_id',
		id		=>'tenedor_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remolque'),
			type	=>array('column'))
	);
	
	$this -> Campos[propietario] = array(
		name	=>'propietario',
		id		=>'propietario',
		type	=>'text',
		size    =>'50',
		required=>'yes',
		suggest=>array(
			name	=>'tercero',
			setId	=>'propietario_hidden')
	);
	
	$this -> Campos[propietario_id] = array(
		name	=>'propietario_id',
		id		=>'propietario_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remolque'),
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
			table	=>array('remolque'),
			type	=>array('column'))
	);	
	
	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	  =>'save_ajax',
			onsuccess =>'RemolqueOnSaveUpdate')
	);
	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'RemolqueOnSaveUpdate')
	);
	
	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'RemolqueOnDelete')
	);
	
	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick => 'remolqueOnReset(this.form)'
	);
	
	
	//BUSQUEDA
	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		suggest=>array(
			name	=>'busca_remolque',
			setId	=>'placa_remolque',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
  
	
	
}

new SemiRemolques();

?>