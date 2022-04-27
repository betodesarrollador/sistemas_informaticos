<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ParametrosArqueo extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){  
    $this -> noCache();

	require_once("ParametrosArqueoLayoutClass.php");
	require_once("ParametrosArqueoModelClass.php");
	
	$Layout   = new ParametrosArqueoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosArqueoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	


	//// GRID ////
	$Attributes = array(
	  id		=>'parametros_legalizacion',
	  title		=>'Listado de Parametros',
	  sortname	=>'oficina',
	  width		=>'auto',
	  height	=>'250'
	);	

	$Cols = array(
	  array(name=>'empresa',	            index=>'empresa',               sorttype=>'text',	width=>'270',	align=>'center'),
	  array(name=>'oficina',                index=>'oficina',               sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'codigo_puc',	        	index=>'codigo_puc',	    	sorttype=>'text',	width=>'200',	align=>'center'),	
	  array(name=>'nombre_puc',	        	index=>'nombre_puc',	    	sorttype=>'text',	width=>'200',	align=>'left')		  
	);
	  
    $Titles = array('EMPRESA','OFICINA','CODIGO','NOMBRE CUENTA');
	
	$Layout -> SetGridParametrosArqueo($Attributes,$Titles,$Cols,$Model -> getQueryParametrosArqueoGrid());
	$Layout -> RenderMain();  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"ParametrosArqueo",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }  
  
  protected function onclickSave(){      
  	require_once("ParametrosArqueoModelClass.php");
    $Model = new ParametrosArqueoModel();    
	$oficina_id = $this -> getOficinaId();	
	$Model -> Save($this -> Campos,$oficina_id,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }	
  }

  protected function onclickUpdate(){	  
  	require_once("ParametrosArqueoModelClass.php");
    $Model = new ParametrosArqueoModel();	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }	  
  }  
  
  protected function onclickDelete(){
  	require_once("ParametrosArqueoModelClass.php");
    $Model = new ParametrosArqueoModel();	
	$Model -> Delete($this -> Campos,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){	  
  	require_once("ParametrosArqueoModelClass.php");	
    $Model                  = new ParametrosArqueoModel();
	$parametros_legalizacion_arqueo_id = $_REQUEST['parametros_legalizacion_arqueo_id'];			
	$Data  = $Model -> selectParametrosArqueo($parametros_legalizacion_arqueo_id,$this -> getConex());	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){  	  
    require_once("../../../framework/clases/ListaDependiente.php");	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);		
	$list -> getList();	  
  }  
  
  protected function setOficinasCliente(){  
	require_once("ParametrosArqueoLayoutClass.php");
	require_once("ParametrosArqueoModelClass.php");	
	$Layout     = new ParametrosArqueoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model      = new ParametrosArqueoModel();
	$empresa_id = $_REQUEST['empresa_id'];
	$oficina_id = $_REQUEST['oficina_id'];	
	$oficinas = $Model -> selectOficinasEmpresa($empresa_id,$oficina_id,$this -> getConex());	

	if(!count($oficinas) > 0){
	  $oficinas = array();
	}

      $field = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		options  => $oficinas,
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	  );
	  
	print $Layout -> getObjectHtml($field);
	 
  }

  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[parametros_legalizacion_arqueo_id] = array(
		name	=>'parametros_legalizacion_arqueo_id',
		id		=>'parametros_legalizacion_arqueo_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('primary_key'))
	);

		
	$this -> Campos[empresa_id] = array(
		name	       =>'empresa_id',
		id		       =>'empresa_id',
		type	       =>'select',
		required       =>'yes',
		datatype=>array(
			type	=>'integer'),		
		options        => array(),
        setoptionslist => array(childId=>'oficina_id'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))		
	);		
	  	
		
	$this -> Campos[oficina_id] = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		disabled =>'true',
		options  => array(),
		datatype=>array(
			type	=>'integer'),		
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	
	
		
		
	$this -> Campos[contrapartida] = array(
		name	=>'contrapartida',
		id		=>'contrapartida',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'puc_id',
			onclick =>'setNombreCuentaContrapartida'
			)
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	

	$this -> Campos[inicontrapartida] = array(
		name	=>'inicontrapartida',
		id		=>'inicontrapartida',
		type	=>'text',
		size	=>'45',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'ini_puc_id'
			)
	);
	
	$this -> Campos[ini_puc_id] = array(
		name	=>'ini_puc_id',
		id		=>'ini_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	

	$this -> Campos[ini2contrapartida] = array(
		name	=>'ini2contrapartida',
		id		=>'ini2contrapartida',
		type	=>'text',
		size	=>'45',
		//required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'ini2_puc_id'
			)
	);
	
	$this -> Campos[ini2_puc_id] = array(
		name	=>'ini2_puc_id',
		id		=>'ini2_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	

	$this -> Campos[ini3contrapartida] = array(
		name	=>'ini3contrapartida',
		id		=>'ini3contrapartida',
		type	=>'text',
		size	=>'45',
		//required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'ini3_puc_id'
			)
	);
	
	$this -> Campos[ini3_puc_id] = array(
		name	=>'ini3_puc_id',
		id		=>'ini3_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	

	$this -> Campos[ini4contrapartida] = array(
		name	=>'ini4contrapartida',
		id		=>'ini4contrapartida',
		type	=>'text',
		size	=>'45',		
		//required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'ini4_puc_id'
			)
	);
	
	$this -> Campos[ini4_puc_id] = array(
		name	=>'ini4_puc_id',
		id		=>'ini4_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	

	$this -> Campos[ini5contrapartida] = array(
		name	=>'ini5contrapartida',
		id		=>'ini5contrapartida',
		type	=>'text',
		size	=>'45',		
		//required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'ini5_puc_id'
			)
	);
	
	$this -> Campos[ini5_puc_id] = array(
		name	=>'ini5_puc_id',
		id		=>'ini5_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	

	$this -> Campos[ini6contrapartida] = array(
		name	=>'ini6contrapartida',
		id		=>'ini6contrapartida',
		type	=>'text',
		size	=>'45',
		//required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'ini6_puc_id'
			)
	);
	
	$this -> Campos[ini6_puc_id] = array(
		name	=>'ini6_puc_id',
		id		=>'ini6_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);	


	$this -> Campos[nombre_puc] = array(
		name	=>'nombre_puc',
		id		=>'nombre_puc',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
			
	);	
	
	$this ->Campos[naturaleza_puc] = array(
		name	 =>'naturaleza_puc',
		id		 =>'naturaleza_puc',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
			type	=>array('column'))
	);			

	$this ->Campos[centro_costo] = array(
		name	 =>'centro_costo',
		id		 =>'centro_costo',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => '1', text => 'TODOS LOS CENTROS'),array(value => '0', text => 'OFICINA ACTUAL')),
		transaction=>array(
			table	=>array('parametros_legalizacion_arqueo'),
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
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'parametrosLegalizacionOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'parametrosLegalizacionOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'parametros_legalizacion_arqueo',
			setId	=>'parametros_legalizacion_arqueo_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}

$ParametrosArqueo = new ParametrosArqueo();

?>