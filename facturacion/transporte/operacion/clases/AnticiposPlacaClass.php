<?php

require_once("../../../framework/clases/ControlerClass.php");

final class AnticiposPlaca extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("AnticiposPlacaLayoutClass.php");
    require_once("AnticiposPlacaModelClass.php");
	
    $Layout   = new AnticiposPlacaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AnticiposPlacaModel();	
		
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setImprimir ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));

	$Layout -> setCampos($this -> Campos);
	
	$Layout -> RenderMain();	
  } 
  
  protected function onclickPrint(){
    
    require_once("Imp_DocumentoClass.php");

    $print = new Imp_Documento($this -> getConex());

    $print -> printOut();   
  
  }    

  protected function setCampos(){
  
	//campos formulario
	
	
	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
	 	datatype=>array(type=>'alphanum'),
		suggest=>array(
			name	=>'vehiculo_disponible',
			setId	=>'placa_id_hidden',
			onclick =>'getAnticiposPlaca'
			)
	);	
	
	$this -> Campos[placa_id] = array(
		name	=>'placa_id',
		id		=>'placa_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer')
	);		

    $this -> Campos[tenedor] = array(
    name=>'tenedor',
    id=>'tenedor',
    type=>'text',
	required=>'yes',
    datatype=>array(type=>'text'),
    suggest=>array(
    name=>'tenedor',
    setId=>'tenedor_id',
    onclick=>'separaNombreTenedor')
	
    );
	
    $this -> Campos[tenedor_id] = array(
    name=>'tenedor_id',
    id=>'tenedor_id',
    type=>'hidden',
	required=>'yes',	
    datatype=>array(type=>'text')
    );		

    $this -> Campos[numero_identificacion_tenedor] = array(
    name=>'numero_identificacion_tenedor',
    id=>'numero_identificacion_tenedor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text')
    );

    //conductor
    $this -> Campos[conductor_id] = array(
    name=>'conductor_id',
    id=>'conductor_hidden',
    type=>'hidden',
    value=>'',
    required=>'yes',
    datatype=>array(type=>'integer')
    );

    $this -> Campos[numero_identificacion] = array(
    name=>'numero_identificacion',
    id=>'numero_identificacion',
    readonly=>'true',
	required=>'yes',	
    type=>'text'
    );

    $this -> Campos[nombre] = array(
    name=>'nombre',
    id=>'nombre',
    type=>'text',
	required=>'yes',	
    suggest=>array(
    name=>'conductor_disponible',
    setId=>'conductor_hidden',
    onclick=>'separaNombre')
    );

    $this -> Campos[propio] = array(
    name=>'propio',
    id=>'propio',
    type=>'hidden',
    value=>'0',
    );	

	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer')
	);		
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'AnticiposPlacaOnReset(this.form)'
	);			

   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular'
	);	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar'
	);

   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
		disabled   =>'yes',
	    displayoptions => array(
                  form        => 0,
                  beforeprint => 'beforePrint',
		  title       => 'Impresion Anticipos Placa',
		  width       => '700',
		  height      => '600'
		)

	);			
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }

  protected function setDataVehiculo(){
  
    require_once("AnticiposPlacaModelClass.php");
    $Model = new AnticiposPlacaModel();
  
    $placa_id = $this -> requestData('placa_id');
    $data     = $Model -> selectVehiculo($placa_id,$this -> getConex());

    $this -> getArrayJSON($data);
  
  }

  protected function setDataConductor(){
  
    require_once("AnticiposPlacaModelClass.php");
	
    $Model        = new AnticiposPlacaModel();  
    $conductor_id = $_REQUEST['conductor_id'];
    $data         = $Model -> selectConductor($conductor_id,$this -> getConex()); 

    $this -> getArrayJSON($data); 
  
  }

  protected function setDataTenedor(){
  
    require_once("AnticiposPlacaModelClass.php");
	
    $Model        = new AnticiposPlacaModel();  
    $tenedor_id = $_REQUEST['tenedor_id'];
    $data         = $Model -> selectTenedor($tenedor_id,$this -> getConex()); 

    $this -> getArrayJSON($data); 
  
  }

  protected function validaAnticiposPlaca(){
  
     require_once("AnticiposPlacaModelClass.php"); 
	 
	 $Model         = new AnticiposPlacaModel();
	 $placa_id = $this -> requestData('placa_id');

	 if($Model -> TieneAnticiposPlaca($placa_id,$this -> getConex())){
	     exit('true');
	 }else{
	      exit("Placa no existe !!");
	  }
  }
  
  protected function viewDocAnticipo(){
    require_once("View_DocumentClass.php");
    $print = new View_Document($this -> getConex());
    $print -> printOut(); 
  }
}
$AnticiposPlaca = new AnticiposPlaca();

?>