<?php

require_once("../../../framework/clases/ControlerClass.php");

final class LegalizacionDespachos extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("LegalizacionDespachosLayoutClass.php");
	require_once("LegalizacionDespachosModelClass.php");
	
	$Layout   = new LegalizacionDespachosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LegalizacionDespachosModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	$Layout -> setCostosViaje($Model -> selectCostosDeViaje($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);		


	$Layout -> RenderMain();
  
  }
  
  protected function getDataManifiesto(){
    
  	require_once("LegalizacionDespachosModelClass.php");
    require_once("ValidacionesDespachoModelClass.php");
	
		
    $Model        = new LegalizacionDespachosModel();
	$Validaciones = new ValidacionesDespachoModel();		
    
	$despacho             = $this -> requestData('despacho');	
	$despachos_urbanos_id = $this -> requestData('despachos_urbanos_id');	
    $oficina_id = $this -> getOficinaId();		
	
	if($Validaciones -> despachoExiste($despachos_urbanos_id,$this -> getConex())){

//	  if($Validaciones  -> despachoEsOficinaLegalizar($despachos_urbanos_id,$oficina_id,$this -> getConex())){
	
		if($Validaciones -> despachoEstaManifestado($despachos_urbanos_id,$this -> getConex())){
		
			if($Validaciones -> esDespachoTercerizado($despachos_urbanos_id,$this -> getConex())){
			
			  exit(utf8_encode("Para los despachos realizados por vehiculos que no son de la compañia<br>debe ingresar por la opcion [ Liquidacion Terceros ]"));
			
			}else{
			
		       if($Validaciones -> despachoEstaLegalizado($despachos_urbanos_id,$this -> getConex())){
			     exit("Este despacho ya se encuentra legalizado!!!");
			   }else{	
			   
			      if($Validaciones -> despachoTieneAnticipos($despachos_urbanos_id,$this -> getConex())){
				  
			        if($Model -> anticiposGeneroEgreso($despachos_urbanos_id,$this -> getConex())){
				  
				      $data = $Model -> selectManifiesto($despachos_urbanos_id,$this -> getConex());
				
				      if($Model -> GetNumError() > 0){
				        exit('Ocurrio una inconsistencia');
				      }else{				
					      $this -> getArrayJSON($data);
				        }				  
				  
				    }else{
				  
				       exit("<div align='center'>No se ha generado egreso para uno de los anticipos de este despacho,<br>por favor ingrese por la opcion : <br><br><b>Modulo Tranporte -> Operacion -> Despachar -> Generar Anticipos.</b></div>");
				  
				     }				  
				  
				  }else{
				       exit("Este despacho no tiene anticipos!!!");
				    }
			   		
							  
			    }
			
			
			  }
	
		
		}else{
	   
			 exit("El despacho aun no esta planillado!!");	
		
		  }
	  
	  
	 /* }else{
	      exit("El despacho se despacho por otra oficina!!");
	    }*/
	  
	  
	}else{
	     
		 exit("El despacho no existe!!");
	
	  }
	

	
  
  }
  
  protected function getAnticiposManifiesto(){
  
  	require_once("LegalizacionDespachosModelClass.php");
    $Model = new LegalizacionDespachosModel();
    
	$despachos_urbanos_id = $this -> requestData('despachos_urbanos_id');	
	$data          = $Model -> selectAnticiposManifiesto($despachos_urbanos_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    $this -> getArrayJSON($data);
	  }
  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"LegalizacionDespachos",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }
  
  
  protected function onclickSave(){
     
  	require_once("LegalizacionDespachosModelClass.php");
    require_once("ValidacionesDespachoModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
		
    $Model               = new LegalizacionDespachosModel();
	$Validaciones        = new ValidacionesDespachoModel();	
	$UtilidadesContables = new UtilidadesContablesModel();	
    
	$empresa_id             = $this -> getEmpresaId();
	$oficina_id             = $this -> getOficinaId();	
	$despacho               = $this -> requestData('despacho');
	$despachos_urbanos_id   = $this -> requestData('despachos_urbanos_id');	
	$fecha                  = $this -> requestData('fecha');
	
	if($Validaciones -> despachoExiste($despachos_urbanos_id,$this -> getConex())){
	
	  if($Validaciones -> despachoEsOficinaLegalizar($despachos_urbanos_id,$this -> getOficinaId(),$this -> getConex())){
	  
	    if($Validaciones -> despachoEstaManifestado($despachos_urbanos_id,$this -> getConex())){
		
		   if($Validaciones -> esDespachoTercerizado($despachos_urbanos_id,$this -> getConex())){
		     exit("Este despacho fue realizado por un tercero, ingrese por liquidacion terceros!!");
		   }else{
		   
		       if($Validaciones -> despachoEstaLegalizado($despachos_urbanos_id,$this -> getConex())){
			     exit("Este despacho ya se encuentra legalizado!!!");
			   }else{
			   
			        if($UtilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$fecha,$this -> getConex())){
					
					  if($UtilidadesContables-> periodoContableEstaHabilitado($this -> getEmpresaId(),$fecha,$this -> getConex())){			   
			   
			            $response = $Model -> Save($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),
					    $this -> getConex());
					
					    if($Model -> GetNumError() > 0){
					      exit('Ocurrio una inconsistencia');
					    }else{
						   exit('true');
					      }	
					  
					  }else{
					       exit("<div align='center'>El periodo contable correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del periodo para realizar el registro</b>!!!</div>");					  
					    }
						
					 }else{
					    exit("<div align='center'>El mes correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del mes para realizar el registro</b>!!!</div>");
					  }
					  
					 		   
			        			   
			     }
		   
		     }
		
		}else{
		    exit("Este despacho aun esta en elaboracion!!!");
		  }
	  
	  }else{
	      exit("Este despacho se genero desde otra oficina!!!");
	    }
	
	}else{
	    exit("despacho no existe!!");
	  }
	

  }


  protected function onclickUpdate(){
     
  	require_once("LegalizacionDespachosModelClass.php");
    require_once("ValidacionesDespachoModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
		
    $Model               = new LegalizacionDespachosModel();
	$Validaciones        = new ValidacionesDespachoModel();	
	$UtilidadesContables = new UtilidadesContablesModel();	
    
	$empresa_id             = $this -> getEmpresaId();
	$oficina_id             = $this -> getOficinaId();	
	$despacho               = $this -> requestData('despacho');
	$despachos_urbanos_id   = $this -> requestData('despachos_urbanos_id');	
	$fecha                  = $this -> requestData('fecha');
	
	if($Validaciones -> despachoExiste($despachos_urbanos_id,$this -> getConex())){
	
	  if($Validaciones -> despachoEsOficinaLegalizar($despachos_urbanos_id,$this -> getOficinaId(),$this -> getConex())){

		
		   if($Validaciones -> esDespachoTercerizado($despachos_urbanos_id,$this -> getConex())){
		     exit("Este despacho fue realizado por un tercero, ingrese por liquidacion terceros!!");
		   }else{
		   
			   
			        if($UtilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$fecha,$this -> getConex())){
					
					  if($UtilidadesContables-> periodoContableEstaHabilitado($this -> getEmpresaId(),$fecha,$this -> getConex())){			   
			   
			            $response = $Model -> Update($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
					
					    if($Model -> GetNumError() > 0){
					      exit('Ocurrio una inconsistencia');
					    }else{
						   exit('true');
					      }	
					  
					  }else{
					       exit("<div align='center'>El periodo contable correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del periodo para realizar el registro</b>!!!</div>");					  
					    }
						
					 }else{
					    exit("<div align='center'>El mes correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del mes para realizar el registro</b>!!!</div>");
					  }
					  
					 		   
			        			   

		   
		     }
		

	  
	  }else{
	      exit("Este despacho se genero desde otra oficina!!!");
	    }
	
	}else{
	    exit("despacho no existe!!");
	  }
	

  }
  
  protected function OnclickContabilizar(){

  	require_once("LegalizacionDespachosModelClass.php");
    $Model = new LegalizacionDespachosModel();
	
	$response = $Model -> contabilizar($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	     exit('true');
	  }
    
  }
    
  protected function onclickDelete(){

  	require_once("LegalizacionDespachosModelClass.php");
    $Model = new LegalizacionDespachosModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  
  	require_once("LegalizacionDespachosModelClass.php");
	
    $Model                    = new LegalizacionDespachosModel();
	$legalizacion_despacho_id = $this -> requestData('legalizacion_despacho_id');
			
	$Data  = $Model -> selectLegalizacionDespachos($legalizacion_despacho_id,$this -> getConex());
	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  
  
  
  protected function onclickPrint(){
    
    require_once("Imp_DocumentoClass.php");

    $print = new Imp_Documento();

    $print -> printOut($this -> getConex());         
  
  }
  
  protected function getTotalDebitoCredito(){
	  
  	require_once("LegalizacionDespachosModelClass.php");
    $Model = new LegalizacionDespachosModel();
	$legalizacion_despacho_id = $_REQUEST['legalizacion_despacho_id'];
	$data = $Model -> getTotalDebitoCredito($this -> getEmpresaId(),$this -> getOficinaId(),$legalizacion_despacho_id,$this -> getConex());
	print json_encode($data);  
	
	  
  }


  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[legalizacion_despacho_id] = array(
		name	=>'legalizacion_despacho_id',
		id		=>'legalizacion_despacho_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	

	$this -> Campos[despacho] = array(
		name	       =>'despacho',
		id	           =>'despacho',
		type	       =>'text',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column')),
		suggest=>array(
			name	=>'despachos_sin_legalizar',
			setId	=>'despachos_urbanos_id',
			onclick =>'getDataManifiesto'
			)
	);	
	
		
	$this -> Campos[despachos_urbanos_id] = array(
		name	       =>'despachos_urbanos_id',
		id	           =>'despachos_urbanos_id',
		type	       =>'hidden',
		required       =>'yes',
	 	datatype=>array(
			type	=>'autoincrement'),		
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	
		
	$this -> Campos[concepto] = array(
		name	   =>'concepto',
		id	       =>'concepto',
		type	   =>'text',
		size       =>'35',
		readonly   =>'true',
		value      =>'LEGALIZACION ANTICIPOS DU: ',
	 	datatype=>array(
			type	=>'text'),		
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);				
	  	
	$this -> Campos[fecha_static] = array(
		name	=>'fecha_static',
		id		=>'fecha_static',
		type	=>'hidden',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'text')
	);		
		
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		required=>'yes',
		readonly=>'true',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);
	
	$this -> Campos[conductor] = array(
		name	 =>'conductor',
		id       =>'conductor',
		type	 =>'text',
		size     =>'30',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);		
	
	$this -> Campos[conductor_id] = array(
		name	 =>'conductor_id',
		id       =>'conductor_id',
		type	 =>'hidden',
		required =>'yes',	
	 	datatype=>array(type=>'integer'),		
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[placa] = array(
		name	 =>'placa',
		id       =>'placa',
		type	 =>'text',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);		
	
	$this -> Campos[placa_id] = array(
		name	 =>'placa_id',
		id       =>'placa_id',
		type	 =>'hidden',
		required =>'yes',		
	 	datatype=>array(type=>'integer'),		
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);
	

	$this -> Campos[origen] = array(
		name	 =>'origen',
		id       =>'origen',
		type	 =>'text',
		required =>'yes',
		datatype=>array(type=>'text')
	);		
	
	$this -> Campos[origen_id] = array(
		name	 =>'origen_id',
		id       =>'origen_id',
		type	 =>'hidden',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	
	
	$this -> Campos[destino] = array(
		name	 =>'destino',
		id       =>'destino',
		type	 =>'text',
	 	datatype=>array(type=>'text')
	);		
	
	$this -> Campos[destino_id] = array(
		name	 =>'destino_id',
		id       =>'destino_id',
		type	 =>'hidden',
	 	datatype=>array(type=>'integer'),		
		required =>'yes',
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id	    =>'valor',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);	
	
	$this -> Campos[total_anticipos] = array(
		name	=>'total_anticipos',
		id	=>'total_anticipos',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);
	
	$this -> Campos[total_costos_viaje] = array(
		name	=>'total_costos_viaje',
		id	=>'total_costos_viaje',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	
		
	
		
	$this -> Campos[diferencia] = array(
		name	=>'diferencia',
		id	=>'diferencia',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);
	
	$this -> Campos[elaboro] = array(
		name	=>'elaboro',
		id	=>'elaboro',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioNombres(),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioId(),
		transaction=>array(
			table	=>array('legalizacion_despacho'),
			type	=>array('column'))
	);	


	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
	);
	
 	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		disabled=>'disabled',
		onclick =>'OnclickContabilizar(this.form)'
	);		
	 
      $this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'print',
		disabled=>'disabled',
		value   =>'Imprimir',
		displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion LegalizacionDespachos',
		  width       => '900',
		  height      => '600'
		)

    );
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'legalizacionManifiestoOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'legalizacion_despacho',
			setId	=>'legalizacion_despacho_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$LegalizacionDespachos = new LegalizacionDespachos();

?>