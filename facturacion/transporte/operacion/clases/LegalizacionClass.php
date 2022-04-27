<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Legalizacion extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("LegalizacionLayoutClass.php");
	require_once("LegalizacionModelClass.php");
	
	$Layout   = new LegalizacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LegalizacionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	$Layout -> setCostosViaje($Model -> selectCostosDeViaje($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);		

	//// GRID ////
	$Attributes = array(
	  id		=>'legalizacion_manifiesto',
	  title		=>'Listado de Parametros Anticipo',
	  sortname	=>'nombre',
	  width		=>'auto',
	  height	=>'250'
	);
	

	$Cols = array(

	  array(name=>'empresa',	            index=>'empresa',               sorttype=>'text',	width=>'270',	align=>'center'),
	  array(name=>'oficina',                index=>'oficina',               sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'tipo_documento',	        index=>'tipo_documento',	    sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'puc',	                index=>'puc',	                sorttype=>'text',	width=>'150',	align=>'center'),	  
	  array(name=>'nombre',		            index=>'nombre',		        sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'naturaleza',			    index=>'naturaleza',		    sorttype=>'text',	width=>'150',	align=>'center')
	
	);
	  
        $Titles = array('EMPRESA',
					'OFICINA',
					'DOCUMENTO CONTABLE',
					'CODIGO CONTABLE',
					'NOMBRE',
					'NATUALEZA'
	);
	
	//$Layout -> SetGridLegalizacion($Attributes,$Titles,$Cols,$Model -> getQueryLegalizacionGrid());
	$Layout -> RenderMain();
  
  }
  
  protected function getDataManifiesto(){
   
    require_once("ValidacionesManifiestoModelClass.php");
  	require_once("LegalizacionModelClass.php");
	
    $Model         = new LegalizacionModel();
	$Validaciones  = new ValidacionesManifiestoModel();	
	$oficina_id    = $this -> getOficinaId();	    
	$manifiesto    = $this -> requestData('manifiesto');	
	$manifiesto_id = $this -> requestData('manifiesto_id');		
	
	if($Validaciones -> manifiestoExiste($manifiesto_id,$this -> getConex())){			
		
	  //if($Validaciones  -> manifiestoEsOficinaLegalizar($manifiesto_id,$oficina_id,$this -> getConex())){
	
		if($Validaciones -> manifiestoEstaManifestado($manifiesto_id,$this -> getConex())){
		
			if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
			
			  exit(utf8_encode("Para los despachos realizados por vehiculos que no son de la compa�ia<br>debe ingresar por la opcion [ Liquidacion Terceros ]"));
			
			}else{
			  
		       if($Validaciones -> manifiestoEstaLegalizado($manifiesto_id,$this -> getConex())){
			     exit("Este manifiesto ya se encuentra legalizado!!!");
			   }else{	
			   			   
			      if($Validaciones -> manifiestoTieneAnticipos($manifiesto_id,$this -> getConex())){				  
				  
			       if($Validaciones -> anticiposGeneroEgreso($manifiesto_id,$this -> getConex())){
				  
				     $data = $Model -> selectManifiesto($manifiesto_id,$this -> getConex());
				
				     if($Model -> GetNumError() > 0){
				       exit('Ocurrio una inconsistencia');
				     }else{				
					    $this -> getArrayJSON($data);
				       }			  
				  
				   }else{
				  
					   //exit("<div align='center'>No se ha generado egreso para uno de los anticipos de este despacho,<br>por favor ingrese por la opcion : <br><br><b>Modulo Tranporte -> Operacion -> Despachar -> Generar Anticipos.</b></div>");
					   echo ("Por favor contablice el anticipo en el formulario <a href='javascript:frameAnticipo($manifiesto_id)'> GENERAR ANTICIPOS</a>");

				  
				    }				  
				  
				  
				  }else{
				      exit("Este manifiesrto no tiene anticipos!!!");
				    }			   
				  				  
			     }
						
			  }
	
		
		}else{
	   
			 exit("El manifiesto aun no esta planillado!!");	
		
		  }
	  
	  
	 /* }else{
	      exit("El manifiesto se despacho por otra oficina!!");
	    }*/
	  
	  
	}else{
	     
		 exit("El manifiesto no existe!!");
	
	  }
	
  }
  
  protected function getAnticiposManifiesto(){
  
  	require_once("LegalizacionModelClass.php");
    $Model = new LegalizacionModel();
    
	$manifiesto_id = $this -> requestData('manifiesto_id');	
	$data          = $Model -> selectAnticiposManifiesto($manifiesto_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    $this -> getArrayJSON($data);
	  }
  
  }
 
  protected function onclickSave(){
     
  	require_once("LegalizacionModelClass.php");
    require_once("ValidacionesManifiestoModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
	
    $Model               = new LegalizacionModel();
	$Validaciones        = new ValidacionesManifiestoModel();	
	$UtilidadesContables = new UtilidadesContablesModel();
    
	$empresa_id = $this -> getEmpresaId();
	$oficina_id = $this -> getOficinaId();
	
	$manifiesto    = $this -> requestData('manifiesto');
	$manifiesto_id = $this -> requestData('manifiesto_id');	
	$fecha         = $this -> requestData('fecha');
	
	if($Validaciones -> manifiestoExiste($manifiesto_id,$this -> getConex())){
	
	  if($Validaciones -> manifiestoEsOficinaLegalizar($manifiesto_id,$this -> getOficinaId(),$this -> getConex())){
	  
	    if($Validaciones -> manifiestoEstaManifestado($manifiesto_id,$this -> getConex())){
		
		   if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
		     exit("Este manifiesto fue realizado por un tercero, ingrese por liquidacion terceros!!");
		   }else{
		   
		       if($Validaciones -> manifiestoEstaLegalizado($manifiesto_id,$this -> getConex())){
			     exit("Este manifiesto ya se encuentra legalizado!!!");
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
		    exit("Este manifiesto aun esta en elaboracion!!!");
		  }
	  
	  }else{
	      exit("Este manifiesto se genero desde otra oficina!!!");
	    }
	
	}else{
	    exit("Manifiesto no existe!!");
	  }
	

  }


  protected function onclickUpdate(){
     
  	require_once("LegalizacionModelClass.php");
    require_once("ValidacionesManifiestoModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
	
    $Model               = new LegalizacionModel();
	$Validaciones        = new ValidacionesManifiestoModel();	
	$UtilidadesContables = new UtilidadesContablesModel();
    
	$empresa_id = $this -> getEmpresaId();
	$oficina_id = $this -> getOficinaId();
	
	$manifiesto    = $this -> requestData('manifiesto');
	$manifiesto_id = $this -> requestData('manifiesto_id');	
	$fecha         = $this -> requestData('fecha');
	
	
	if($Validaciones -> manifiestoExiste($manifiesto_id,$this -> getConex())){
	
	  if($Validaciones -> manifiestoEsOficinaLegalizar($manifiesto_id,$this -> getOficinaId(),$this -> getConex())){
		
		   if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
		     exit("Este manifiesto fue realizado por un tercero, ingrese por liquidacion terceros!!");
           }else{
   
			if($UtilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$fecha,$this -> getConex())){
			
			  if($UtilidadesContables-> periodoContableEstaHabilitado($this -> getEmpresaId(),$fecha,$this -> getConex())){
			  
				$response = $Model -> Update($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),
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
		   
		
	  
	  }else{
	      exit("Este manifiesto se genero desde otra oficina!!!");
	    }
	
	}else{
	    exit("Manifiesto no existe!!");
	  }
	

  }
  
  protected function OnclickContabilizar(){

  	require_once("LegalizacionModelClass.php");
    $Model = new LegalizacionModel();
	
	$response = $Model -> contabilizar($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }
    
  }
  
  protected function onclickDelete(){

  	require_once("LegalizacionModelClass.php");
    $Model = new LegalizacionModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){  
  
  	require_once("LegalizacionModelClass.php");
	
    $Model                      = new LegalizacionModel();
	$legalizacion_manifiesto_id = $this -> requestData('legalizacion_manifiesto_id');
			
	$Data  = $Model -> selectLegalizacion($legalizacion_manifiesto_id,$this -> getConex());
		
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  
  
    	//bloque reporte cumplido
  protected function cumplirManifiestoCargaMinisterio(){ //aca
    
      require_once("LegalizacionModelClass.php");
	  include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	  $Model         = new LegalizacionModel();	  
	  $webService    = new WebServiceMinTransporte($this -> getConex());
	  
	  $manifiesto_id = $this -> requestData('manifiesto_id');
	  $legalizacion_manifiesto_id = $this -> requestData('legalizacion_manifiesto_id');
	  $remesas       = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> getConex());		  		  
	  
	  			 
	  if($manifiesto_id>0){
		  $data = array(	  
		
			manifiesto_id                        => $manifiesto_id,	
			legalizacion_manifiesto_id              => $legalizacion_manifiesto_id,	
			manifiesto                           => $this -> requestData('manifiesto'),	
			tipo_identificacion_conductor_codigo => $this -> requestData('tipo_identificacion_conductor_codigo'),	
			conductor_id                         => $this -> requestData('conductor_id'),			
			numero_identificacion                => $this -> requestData('numero_identificacion'),	
			placa_id                             => $this -> requestData('placa_id'),			
			placa                                => $this -> requestData('placa'),		
			placa_remolque_id                    => $this -> requestData('placa_remolque_id'),			
			placa_remolque                       => $this -> requestData('placa_remolque'),			
			origen_id                            => $this -> requestData('origen_id'),			
			destino_id                           => $this -> requestData('destino_id'),			
			valor_flete                          => $valor_flete,		
			remesas                              => $remesas
		
		  );
		  
		  $webService -> cumplirManifiestoCargaMinisterioPropio($data,true);	  	 
		  
	  }else{
			exit('No ha escogido un manifiesto');  
	  }
  
  }	//bloque reporte cumplido

  
  
  protected function onclickPrint(){
    
    require_once("Imp_DocumentoClass.php");

    $print = new Imp_Documento($this -> getConex());

    $print -> printOut();      
  
  }
  
  protected function getTotalDebitoCredito(){
	  
  	require_once("LegalizacionModelClass.php");
    $Model = new LegalizacionModel();
	$legalizacion_manifiesto_id = $_REQUEST['legalizacion_manifiesto_id'];
	$data = $Model -> getTotalDebitoCredito($this -> getEmpresaId(),$this -> getOficinaId(),$legalizacion_manifiesto_id,$this -> getConex());
	print json_encode($data);  
	
	  
  }


  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[legalizacion_manifiesto_id] = array(
		name	=>'legalizacion_manifiesto_id',
		id		=>'legalizacion_manifiesto_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);	

	$this -> Campos[manifiesto] = array(
		name	       =>'manifiesto',
		id	       =>'manifiesto',
		type	       =>'text',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column')),
		suggest=>array(
			name	=>'manifiestos_sin_legalizar',
			setId	=>'manifiesto_id',
			onclick =>'getDataManifiesto'
			)
	);	
	
		
	$this -> Campos[manifiesto_id] = array(
		name	       =>'manifiesto_id',
		id	       =>'manifiesto_id',
		type	       =>'hidden',
		required       =>'yes',
	 	datatype=>array(
			type	=>'autoincrement'),		
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);	
		
	$this -> Campos[concepto] = array(
		name	   =>'concepto',
		id	       =>'concepto',
		type	   =>'text',
		size       =>'35',
		readonly   =>'true',
		value      =>'LEGALIZACION ANTICIPOS MC: ',
	 	datatype=>array(
			type	=>'text'),		
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);				
	  	
	$this -> Campos[fecha_static] = array(
		name	=>'fecha_static',
		id		=>'fecha_static',
		type	=>'hidden',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'text')
	);	  		
		
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
    	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);
	
	$this -> Campos[conductor] = array(
		name	 =>'conductor',
		id       =>'conductor',
		type	 =>'text',
		size     =>'30',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);		
	
	$this -> Campos[conductor_id] = array(
		name	 =>'conductor_id',
		id       =>'conductor_id',
		type	 =>'hidden',
		required =>'yes',	
	 	datatype=>array(type=>'integer'),		
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[placa] = array(
		name	 =>'placa',
		id       =>'placa',
		type	 =>'text',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);		
	
	$this -> Campos[placa_id] = array(
		name	 =>'placa_id',
		id       =>'placa_id',
		type	 =>'hidden',
		required =>'yes',		
	 	datatype=>array(type=>'integer'),		
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
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
			table	=>array('legalizacion_manifiesto'),
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
			table	=>array('legalizacion_manifiesto'),
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
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);
	
	$this -> Campos[total_costos_viaje] = array(
		name	=>'total_costos_viaje',
		id	=>'total_costos_viaje',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);	
		
	
		
	$this -> Campos[diferencia] = array(
		name	=>'diferencia',
		id	=>'diferencia',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);
	
	$this -> Campos[elaboro] = array(
		name	=>'elaboro',
		id	=>'elaboro',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioNombres(),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
			type	=>array('column'))
	);	
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioId(),
		transaction=>array(
			table	=>array('legalizacion_manifiesto'),
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
	
	 	$this -> Campos[reportar] = array(
		name	=>'reportar',
		id		=>'reportar',
		type	=>'button',
		value	=>'Reportar Cumplido'
	);	//bloque reporte cumplido
		 
      $this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'print',
		disabled=>'disabled',
		value   =>'Imprimir',
		displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion Legalizacion',
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
			name	=>'legalizacion_manifiesto',
			setId	=>'legalizacion_manifiesto_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$Legalizacion = new Legalizacion();

?>