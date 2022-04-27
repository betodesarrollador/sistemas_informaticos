<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Anticipos extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("AnticiposLayoutClass.php");
    require_once("AnticiposModelClass.php");
	
    $Layout   = new AnticiposLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AnticiposModel();	
		
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setImprimir ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));
	
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
	
	$this -> Campos[tipo_anticipo] = array(
		name	=>'tipo_anticipo',
		id		=>'tipo_anticipo',
		type	=>'select',
		options => array(array(value => 'M', text => 'MANIFIESTO', selected => 'M'),array(value => 'D',text => 'DESPACHO', selected => 'M'))
	);		
	
	$this -> Campos[manifiesto] = array(
		name	=>'manifiesto',
		id		=>'manifiesto',
		type	=>'text',
	 	datatype=>array(type=>'integer'),
		suggest=>array(
			name	=>'anticipos_manifiesto',
			setId	=>'manifiesto_id_hidden',
			onclick =>'getAnticiposManifiesto'
			)
	);	
	
	$this -> Campos[manifiesto_id] = array(
		name	=>'manifiesto_id',
		id		=>'manifiesto_id_hidden',
		type	=>'hidden',
		value   => $_REQUEST['manifiesto_id'],
	 	datatype=>array(
			type	=>'integer')
	);		
	
	$this -> Campos[despacho] = array(
		name	=>'despacho',
		id		=>'despacho',
		type	=>'text',
	 	datatype=>array(type=>'integer'),
		suggest=>array(
			name	=>'anticipos_despacho',
			setId	=>'despachos_urbanos_id_hidden',
			onclick =>'getAnticiposDespacho'
			)
	);	
	
	$this -> Campos[despachos_urbanos_id] = array(
		name	=>'despachos_urbanos_id',
		id		=>'despachos_urbanos_id_hidden',
		type	=>'hidden',
	 	datatype=>array(type=>'integer')
	);		
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer')
	);		
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular'
	);	
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'AnticiposOnReset(this.form)'
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
		  title       => 'Impresion Anticipos',
		  width       => '700',
		  height      => '600'
		)

	);			
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  protected function validaAnticiposManifiesto(){
  
     require_once("AnticiposModelClass.php"); 
	 
	 $Model         = new AnticiposModel();
	 $manifiesto_id = $this -> requestData('manifiesto_id');

	 if($Model -> manifiestoTieneAnticipos($manifiesto_id,$this -> getConex())){
	     exit('true');
	 }else{
	      exit("Manifiesto no tiene anticipos !!");
	  }
	 
  
  }
  
  protected function validaAnticiposDespacho(){
  
     require_once("AnticiposModelClass.php"); 
	 
	 $Model                = new AnticiposModel();
	 $despachos_urbanos_id = $this -> requestData('despachos_urbanos_id');
	 
	 if($Model -> despachoTieneAnticipos($despachos_urbanos_id,$this -> getConex())){
	     exit('true');
	 }else{
	      exit("Despacho no tiene anticipos !!");
	   }
	 
  
  }  
  
  protected function viewDocAnticipo(){
  
    require_once("View_DocumentClass.php");

    $print = new View_Document($this -> getConex());

    $print -> printOut(); 
  
  }


}

$Anticipos = new Anticipos();

?>