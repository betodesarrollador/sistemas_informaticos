<?php

require_once("../../../framework/clases/ControlerClass.php");

final class AnticiposProveedor extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("AnticiposProveedorLayoutClass.php");
    require_once("AnticiposProveedorModelClass.php");
	
    $Layout   = new AnticiposProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AnticiposProveedorModel();	
		
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setImprimir ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
	$Layout -> setCampos($this -> Campos);
	$Layout -> RenderMain();	
  } 
  
   protected function setDataProveedor(){

    require_once("AnticiposProveedorModelClass.php");
    $Model = new AnticiposProveedorModel();    
    $proveedor_id = $_REQUEST['proveedor_id'];
    $data = $Model -> getDataProveedor($proveedor_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function onclickPrint(){
    
    require_once("../../proveedor/clases/Imp_DocumentoClass.php");

    $print = new Imp_Documento($this -> getConex());

    $print -> printOut();   
  
  }    

  protected function setCampos(){
  
	//campos formulario
	
$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);
	  
	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		size	=>45,
		suggest=>array(
			name	=>'proveedor',
			setId	=>'proveedor_hidden',
			onclick => 'setDataProveedor')
	);
	
	$this -> Campos[proveedor_nit] = array(
		name	=>'proveedor_nit',
		id		=>'proveedor_nit',
		type	=>'text',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
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
		onclick =>'AnticiposProveedorOnReset(this.form)'
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
  
    require_once("AnticiposProveedorModelClass.php");
    $Model = new AnticiposProveedorModel();
  
    $proveedor_id = $this -> requestData('proveedor_id');
    $data     = $Model -> selectVehiculo($proveedor_id,$this -> getConex());

    $this -> getArrayJSON($data);
  
  }

  protected function setDataConductor(){
  
    require_once("AnticiposProveedorModelClass.php");
	
    $Model        = new AnticiposProveedorModel();  
    $conductor_id = $_REQUEST['conductor_id'];
    $data         = $Model -> selectConductor($conductor_id,$this -> getConex()); 

    $this -> getArrayJSON($data); 
  
  }

  protected function setDataTenedor(){
  
    require_once("AnticiposProveedorModelClass.php");
	
    $Model        = new AnticiposProveedorModel();  
    $tenedor_id = $_REQUEST['tenedor_id'];
    $data         = $Model -> selectTenedor($tenedor_id,$this -> getConex()); 

    $this -> getArrayJSON($data); 
  
  }

  protected function validaAnticiposProveedor(){
  
     require_once("AnticiposProveedorModelClass.php"); 
	 
	 $Model         = new AnticiposProveedorModel();
	 $proveedor_id = $this -> requestData('proveedor_id');

	 if($Model -> TieneAnticiposProveedor($proveedor_id,$this -> getConex())){
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
$AnticiposProveedor = new AnticiposProveedor();

?>