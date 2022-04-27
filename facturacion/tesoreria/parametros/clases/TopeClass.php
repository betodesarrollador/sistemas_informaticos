<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Tope extends Controler{
	
  public function __construct(){  
	//// -> setCampos();  	
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("TopeModelClass.php");
	require_once("TopeLayoutClass.php");
//		echo 'FUNCIONA...';
		
	$Layout   = new TopeLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TopeModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
	
	//// GRID ////
	$Attributes = array(
	  id		=>'tope',
	  title		=>'Tope Reembolsos Caja Menor',
	  sortname	=>'oficina',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(	
	  array(name=>'oficina', 		index=>'oficina',		sorttype=>'text',	width=>'140',	align=>'rigth'),
	  array(name=>'anio',	 		index=>'anio',	  		sorttype=>'int',	width=>'50',	align=>'center'),
	  array(name=>'valor',     		index=>'valor',	  		sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'porcentaje', 	index=>'porcentaje',	sorttype=>'int',	width=>'100',	align=>'center'),	  
	  array(name=>'fecha_inicio',	index=>'fecha_inicio',	sorttype=>'text',	width=>'80',	align=>'center'),	  
  	  array(name=>'fecha_final', 	index=>'fecha_final',	sorttype=>'text',	width=>'80',	align=>'center'),	  
	  array(name=>'estado',	 		index=>'estado', 		sorttype=>'text',	width=>'90',	align=>'center')	
	);
	  
    $Titles = array('OFICINA','A&Ntilde;O','VALOR','PORCENTAJE (%)','FECHA INICIO','FECHA FINAL','ESTADO');	
	$Layout -> SetGridTope($Attributes,$Titles,$Cols,$Model -> GetQueryTopeGrid());	
	$Layout -> RenderMain();  
  }
	  	  
  protected function onclickFind(){   // REVISAR
	      	
	require_once("../../../framework/clases/FindRowClass.php");	    

    $Find = new FindRow($this -> getConex(),"tope_reembolso",$this -> Campos);
	$data = $Find -> GetData();	 		
	$this -> getArrayJSON($data);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("TopeModelClass.php");	    
    $Model = new TopeModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el Tope Reembolso');
	 }			
  }

  protected function onclickUpdate(){

  	require_once("TopeModelClass.php");	    
    $Model = new TopeModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el Tope Reembolso');
	 }			
  }
	  
  protected function onclickDelete(){

  	require_once("TopeModelClass.php");	    
    $Model = new TopeModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el Tope Reembolso');
	 }			
  }
  
  protected function onchangeSetOptionList(){
	  
    require_once("../../../framework/clases/ListaDependiente.php");
		
	if($_REQUEST['listChild'] == 'oficina_id'){
 	  $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
	  'codigo_centro,nombre',concat=>'-',order=>'codigo_centro,nombre'),$this -> Campos);	
	}else{
  	    $list = new ListaDependiente($this -> getConex(),'periodo_contable_id',array(table=>'periodo_contable',
        value=>'periodo_contable_id',text=>'anio',concat=>''),$this -> Campos);		
	   }	
	$list -> getList();	  
  }
  
  protected function setCampos(){

// CAMPOS

	$this -> Campos[tope_reembolso_id]  = array(
    type=>'hidden',
	name=>'tope_reembolso_id',
	id=>'tope_reembolso_id',
    datatype=>array(
		type=>'autoincrement'),
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('primary_key')));
	  
	$this -> Campos[empresa_id]  = array(
	type=>'select',
	required=>'yes',
	name=>'empresa_id',
	id=>'empresa_id',
	options=> array(),
	//tabindex => '1',
	transaction=>array(
    	table=>array('tope_reembolso'),
    	type=>array('column')),
	datatype=> array(
		type=>'integer'),
	setoptionslist=>array(
    	childId=>'oficina_id,periodo_contable_id'));

	$this -> Campos[oficina_id]  = array(
    type=>'select',
    required=>'yes',
    name=>'oficina_id',
    id=>'oficina_id',
	options=> array(),
	//tabindex => '2',
	transaction=>array(
 	   table=>array('tope_reembolso'),
       type=>array('column')),
	datatype=> array(type=>'integer'));

	$this -> Campos[periodo_contable_id]  = array(
	type=>'select',
	required=>'yes',
	name=>'periodo_contable_id',
    id=>'periodo_contable_id',
	options=> array(),
	//tabindex => '3',
	transaction=>array(
		table=>array('tope_reembolso'),
    	type=>array('column')),
	datatype=> array(type=>'integer'));
	
	$this -> Campos[valor]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'integer'),
	name=>'valor',
    id=>'valor',
	//tabindex => '4',
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('column')));
	
	$this -> Campos[porcentaje]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'integer'),
	name=>'porcentaje',
    id=>'porcentaje',
	//tabindex => '4',
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('column')));
	
	$this -> Campos[fecha_inicio]  = array(
  	type=>'text',
   	required=>'yes',
   	datatype=>array(
		type=>'date'),
   	name=>'fecha_inicio',
    id=>'fecha_inicio',
	//tabindex => '5',
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('column')));
	
	$this -> Campos[fecha_final]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'date'),
	name=>'fecha_final',
    id=>'fecha_final',
	//tabindex => '6',
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('column')));	
	
	$this -> Campos[descripcion]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'alphanum'),
	name=>'descripcion',
    id=>'descripcion',
	//tabindex => '7',
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('column')));	
	
	$this -> Campos[estado]  = array(
	type=>'select',
	required=>'yes',
	datatype=>array(
		type=>'integer'),
	name=>'estado',
    id=>'estado',
	//tabindex => '8',
	transaction=>array(
		table=>array('tope_reembolso'),
		type=>array('column')),
	options=>array(array(
		value=>'1',text=>'DISPONIBLE'),array(value=>'0',text=>'BLOQUEADO',selected=>'0')));	
	
// BOTONES

	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'TopeOnSaveOnUpdateonDelete')		
	);	
	
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'TopeOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TopeOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TopeOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'tope_reembolso',
			setId	=>'tope_reembolso_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$Tope = new Tope();

?>