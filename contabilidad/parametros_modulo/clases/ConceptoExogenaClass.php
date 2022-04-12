<?php
require_once("../../../framework/clases/ControlerClass.php");
  
final class ConceptoExogena extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();
	require_once("ConceptoExogenaLayoutClass.php");
	require_once("ConceptoExogenaModelClass.php");	  
	
	$Layout   = new ConceptoExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ConceptoExogenaModel();	  
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
			
	
	$Layout -> RenderMain();
	
  
  }
  
  protected function showGrid(){
	  
	require_once("ConceptoExogenaLayoutClass.php");
	require_once("ConceptoExogenaModelClass.php");	  
	
	$Layout   = new ConceptoExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ConceptoExogenaModel();	 
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'concepto_exogena_id',
		title		=>'Concepto Exogena',
		sortname	=>'codigo,nombre',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
	  
		  array(name=>'codigo',	 index=>'codigo',	sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'nombre',	 index=>'nombre',	sorttype=>'text',	width=>'100',	align=>'center'),
		  array(name=>'descripcion',	 index=>'descripcion',	sorttype=>'text',	width=>'250',	align=>'center'),
		  array(name=>'estado', index=>'estado',sorttype=>'text',	width=>'300',	align=>'center')
		
	  
	  );
		
	  $Titles = array('CODIGO',
					  'NOMBRE',
					  'DESCRIPCION',
					  'EMPRESA'
	  );
	  
	 $html = $Layout -> SetGridCentrosCosto($Attributes,$Titles,$Cols,$Model -> GetQueryEmpresasGrid());	
	 
	 print $html;
	  
  }
  
	  	  
  protected function onclickFind(){
	      	
	require_once("ConceptoExogenaModelClass.php");	    
    $Model         = new ConceptoExogenaModel();	 
	$concepto_exogena_id = $_REQUEST['concepto_exogena_id'];
    $result        = $Model -> selectConceptoExogena($concepto_exogena_id,$this -> getConex());
	 		
	$this -> getArrayJSON($result);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("ConceptoExogenaModelClass.php");	    
    $Model = new ConceptoExogenaModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el Concepto Exogena');
	 }	
		
  }
  protected function onclickUpdate(){
  	require_once("ConceptoExogenaModelClass.php");	    
    $Model = new ConceptoExogenaModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el Concepto Exogena');
	 }		
		
  }
	  
  protected function onclickDelete(){
  	require_once("ConceptoExogenaModelClass.php");	    
    $Model = new ConceptoExogenaModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el Concepto Exogena');
	 }		
		
  }
  
  protected function setCampos(){
  
	$this -> Campos[concepto_exogena_id]  = array(type=>'hidden',name=>'concepto_exogena_id',id=>'concepto_exogena_id',
    datatype=>array(type=>'autoincrement'),transaction=>array(table=>array('concepto_exogena'),type=>array('primary_key')));
	$this -> Campos[codigo]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'alphanum_space'),name=>'codigo',
    id=>'codigo',transaction=>array(table=>array('concepto_exogena'),type=>array('column')));
	
	$this -> Campos[nombre]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'alphanum_space'),name=>'nombre',
    id=>'nombre',transaction=>array(table=>array('concepto_exogena'),type=>array('column')));
	$this -> Campos[estado]  = array(type=>'select',Boostrap=>'si',datatype=>array(type=>'text'),name=>'estado',required=>'yes',options => array(
	array(value => 'A', text => 'ACTIVO',selected=>'A'),
	array(value => 'I', text => 'INACTIVO',selected=>'A')),id=>'estado',transaction=>array(table=>array('concepto_exogena'),type=>array('column')));
	

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'textarea',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('concepto_exogena'),
			type	=>array('column'))
	);
 
	$this -> Campos[guardar] = array(type=>'button',name=>'guardar',id=>'guardar',value=>'Guardar','property'=>array(
	name=>'save_ajax',onsuccess=>'ConceptoExogenaOnSaveOnUpdateonDelete'));
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar',
	'property'=>array(name=>'update_ajax',onsuccess=>'ConceptoExogenaOnSaveOnUpdateonDelete'),value=>'Actualizar','disabled'=>'disabled');
	 
  	$this -> Campos[borrar] = array(type=>'button',name=>'borrar',id=>'borrar',
	'property'=>array(name=>'delete_ajax',onsuccess=>'ConceptoExogenaOnSaveOnUpdateonDelete'),value=>'Borrar','disabled'=>'disabled');
	 
   	$this -> Campos[limpiar] = array(type=>'reset',name=>'limpiar',id=>'limpiar',value=>'Limpiar',onclick=>'ConceptoExogenaOnReset(this.form)');
	 
   	$this -> Campos[busqueda] = array(type=>'text',Boostrap=>'si',name=>'busqueda',id=>'busqueda',value=>'',size=>'85',placeholder=>'ESCRIBA EL C&Oacute;DIGO O descripcion del CONCEPTO',suggest=>array(
	name=>'conceptoExogena',onclick=>'LlenarFormConceptoExogena',setId=>'concepto_exogena_id'));
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}
$ConceptoExogena = new ConceptoExogena();
?>