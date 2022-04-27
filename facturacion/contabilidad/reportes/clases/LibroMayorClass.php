<?php
require_once("../../../framework/clases/ControlerClass.php");
final class LibroMayor extends Controler{
  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }

  public function Main(){
	     
    $this -> noCache();
    
	require_once("LibroMayorLayoutClass.php");
	require_once("LibroMayorModelClass.php");
	
	$Layout = new LibroMayorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new LibroMayorModel();
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	
			
	$Layout -> RenderMain();	  
	  
  }
  
  protected function getEmpresas(){
  
	require_once("LibroMayorLayoutClass.php");
	require_once("LibroMayorModelClass.php");
	
	$Layout  = new LibroMayorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model   = new LibroMayorModel();	
	$reporte = trim($_REQUEST['reporte']);
	
	if($reporte == 'E'){
  	  $field[empresa_id] = array(
		  name	=>'empresa_id',
		  id		=>'empresa_id',
		  type	=>'select',
		  required=>'yes',
		  options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		  tabindex=>'2',
	      datatype=>array(
			 type	=>'integer',
			  length	=>'9')
	  );
	  
	}else if($reporte == 'O'){
	
	  $field[empresa_id] = array(
		  name	=>'empresa_id',
		  id		=>'empresa_id',
		  type	=>'select',
		  required=>'yes',
		  options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		  tabindex=>'2',
	      datatype=>array(
			  type	=>'integer',
			  length	=>'9'),
          setoptionslist=>array(childId=>'oficina_id')
	  );	
	  
	 }else if($reporte == 'C'){
	 
	     $field[empresa_id] = array(
		   name	=>'empresa_id',
		   id		=>'empresa_id',
		   type	=>'select',
		   required=>'yes',
		   options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		   tabindex=>'2',
	       datatype=>array(
			  type	=>'integer',
			  length	=>'9'),
          setoptionslist=>array(childId=>'centro_de_costo')
	     );	 
	 
	   }
	
	print $Layout -> getObjectHtml($field[empresa_id]);
  
  }
  
   
  protected function onchangeSetOptionList(){
  
   
	require_once("LibroMayorModelClass.php");
    require_once("../../../framework/clases/ListaDependiente.php");
		
    $Model     = new LibroMayorModel();  
    $listChild = $_REQUEST['listChild'];
	
	if($listChild == 'oficina_id'){
  	  $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
                                   'codigo_centro,nombre',concat=>'-',order=>'codigo_centro,nombre'),$this -> Campos,
								   $Model -> getConditionOficina($this -> getUsuarioId()));		
    }else{
  	     $list = new ListaDependiente($this -> getConex(),'centro_de_costo_id',array(table=>'centro_de_costo',value=>'centro_de_costo_id',text=>
                                   'codigo,nombre',concat=>'-',order=>'codigo,nombre'),$this -> Campos,
								   $Model -> getConditionCentroCosto($this -> getUsuarioId()));			
	  }
	
	$list -> getList();
	  
  }   
  
  protected function onclickGenerarBalance(){
  
	require_once("LibroMayorLayoutClass.php");
	require_once("LibroMayorModelClass.php");
	
	$Layout  = new LibroMayorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model   = new LibroMayorModel();	
	
	$this -> puc = array();	
	
    $Cuentas = $Model -> getCuentasTree($this -> getConex());	
	
	$j = 0;
		
	for($i = 0; $i < count($Cuentas); $i++){
	  
	  $this -> puc = $i == 0 ? array($Cuentas[$i]) : array_merge($this -> puc,array($Cuentas[$i]));	  	  
	  $this -> getNodesTree($Cuentas[$i]['puc_id']);
	
	}
			
    $Layout -> setVar('sectionReporte',1);	
    $Layout -> setVar('empresas',$empresas);	
    $Layout -> setVar('empresa_id',$empresa_id);	
    $Layout -> setVar('puc',$this -> puc);
		
    $Layout -> RenderLayout('LibroMayorReporte.tpl');
  }  
  
 protected function getNodesTree($IdParent,$indice = null){
  
	require_once("LibroMayorModelClass.php");
	
    $Model    = new LibroMayorModel();		
	$children = $Model -> getChildren($IdParent,$this -> getConex());
		
	if(count($children) > 0){
	
	   $j = 0;
	   
	   for($i = 0; $i < count($children); $i++){
		 		 
   	     $this -> puc = array_merge($this -> puc,array($children[$i]));		
		 	 		 
		 $num = count($this -> puc) - 1;		 
				 
	     $this -> getNodesTree($children[$i]['puc_id'],$num);
	   }
	   
	}else{
		 	 
         if(is_numeric($indice)) $this -> puc[$indice] = $Model -> getCuentaMovimiento($IdParent,$this -> getConex());
	
	     return false;
	  }
  
  }   
  
  protected function setCampos(){
    /*****************************************
            	 datos sesion
	*****************************************/  
	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		tabindex=>'2',
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		tabindex=>'3',
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	
	
	
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		tabindex=>'3',
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
	
	
	$this -> Campos[reporte] = array(
		name	=>'reporte',
		id		=>'reporte',
		type	=>'select',
		required=>'yes',
        options =>array(array(value=>'E',text=>'EMPRESA',selected=>'E'),array(value=>'O',text=>'OFICINA'),array(value=>'C',text=>'CENTRO COSTO')),
		datatype=>array(
			type	=>'alpha')
	);
	
	$this -> Campos[corte] = array(
		name	=>'corte',
		id		=>'corte',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'select',
		required=>'yes',
        options  =>array(array(value=>'1',text=>'CLASE'),array(value=>'2',text=>'GRUPO'),array(value=>'3',text=>'CUENTA'),array(value=>'4',text=>'SUBCUENTA')),
		datatype=>array(
			type	=>'integer')
	);	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'select',
		required=>'yes',
        options =>array(array(value=>'S',text=>'SI',selected=>'S'),array(value=>'N',text=>'NO')),
		datatype=>array(
			type	=>'alpha')
	);
	
	
	//botones
	
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'onclickGenerarBalance(this.form)'
	);		
	
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}
$MovimientosContables = new LibroMayor();
?>