<?php
require_once("../../../framework/clases/ControlerClass.php");
final class CategoriaExogena extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();
    require_once("CategoriaExogenaLayoutClass.php");
    require_once("CategoriaExogenaModelClass.php");
	
    $Layout   = new CategoriaExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CategoriaExogenaModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	
	//// GRID ////
	$Attributes = array(
	  id		=>'CategoriaExogena',
	  title		=>'Listado Categoria Exogena',
	  sortname	=>'codigo',
	  width		=>'600',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'codigo',index=>'codigo',width=>'300',	align=>'center'),
	  array(name=>'descripcion',index=>'descripcion',width=>'100',	align=>'center'),	  
	  array(name=>'estado',index=>'estado',width=>'100',	align=>'center')	  
	
	);
	  
    $Titles = array('CODIGO',
					'DESCRIPCION',
					'ESTADO'					
	);
		
	$Layout -> SetGridCategoriaExogena($Attributes,$Titles,$Cols,$Model -> getQueryCategoriaExogenaGrid());
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("CategoriaExogenaLayoutClass.php");
    require_once("CategoriaExogenaModelClass.php");
	
    $Layout   = new CategoriaExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CategoriaExogenaModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'CategoriaExogena',
		title		=>'Listado Categoria Exogena',
		sortname	=>'codigo',
		width		=>'600',
		height	=>'250'
	  );
	  $Cols = array(
		array(name=>'codigo',index=>'codigo',width=>'300',	align=>'center'),
		array(name=>'descripcion',index=>'descripcion',width=>'100',	align=>'center'),	  
		array(name=>'estado',index=>'estado',width=>'100',	align=>'center')	  
	  
	  );
		
	  $Titles = array('CODIGO',
					  'DESCRIPCION',
					  'ESTADO'					
	  );
		  
	 $html =  $Layout -> SetGridCategoriaExogena($Attributes,$Titles,$Cols,$Model -> getQueryCategoriaExogenaGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("CategoriaExogenaModelClass.php");
    $Model = new CategoriaExogenaModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la categoria');
	 }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("CategoriaExogenaModelClass.php");
    $Model = new CategoriaExogenaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la categoria');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("CategoriaExogenaModelClass.php");
    $Model = new CategoriaExogenaModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la categoria');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("CategoriaExogenaModelClass.php");
    $Model = new CategoriaExogenaModel();	
	$Data  = $Model -> selectCategoriaExogena($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[categoria_exogena_id] = array(
		name	=>'categoria_exogena_id',
		id	    =>'categoria_exogena_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('categoria_exogena'),
			type	=>array('primary_key'))
	);
		  	
	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id		=>'codigo',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('categoria_exogena'),
			type	=>array('column'))
	);
	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'textarea',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('categoria_exogena'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[estado]  = array(type=>'select',Boostrap=>'si',datatype=>array(type=>'text'),name=>'estado',required=>'yes',options => array(
	array(value => 'A', text => 'ACTIVO',selected=>'A'),
	array(value => 'I', text => 'INACTIVO',selected=>'A')),id=>'estado',transaction=>array(table=>array('concepto_exogena'),type=>array('column')));
			
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'CategoriaExogenaOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CategoriaExogenaOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CategoriaExogenaOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CategoriaExogenaOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		placeholder=>'ESCRIBA EL CODIGO DE LA CATEGORIA',												
		//tabindex=>'1',
		suggest=>array(
			name	=>'CategoriaExogena',
			setId	=>'categoria_exogena_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
$CategoriaExogena = new CategoriaExogena();
?>