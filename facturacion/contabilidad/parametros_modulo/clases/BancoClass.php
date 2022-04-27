<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Banco extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();
    require_once("BancoLayoutClass.php");
    require_once("BancoModelClass.php");
	
    $Layout   = new BancoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new BancoModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("BancoLayoutClass.php");
    require_once("BancoModelClass.php");
	
    $Layout   = new BancoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new BancoModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'banco',
		title		=>'Listado bancos',
		sortname	=>'nombre_banco',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
		array(name=>'nombre_banco',index=>'nombre_banco',width=>'300',	align=>'center'),
		array(name=>'nit_banco',index=>'nit_banco',width=>'100',	align=>'center'),	  
		array(name=>'codigo_interno',index=>'codigo_interno',width=>'100',	align=>'center'),	  
		array(name=>'codigo_entidad',index=>'codigo_entidad',width=>'100',	align=>'center'),
		array(name=>'estado',index=>'estado',width=>'100',	align=>'center')	  
	  
	  );
		
	  $Titles = array('NOMBRE',
					  'NIT',
					  'COD INTERNO',
					  'COD BANCO',
					  'ESTADO'					
	  );
		  
	  $html =  $Layout -> SetGridBanco($Attributes,$Titles,$Cols,$Model -> getQueryBancoGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("BancoModelClass.php");
	$Model = new BancoModel();
	
	$codigo_entidad = $_REQUEST['codigo_entidad'];
    	
	$resp = $Model -> Save($this -> Campos,$this -> getConex());
	
    if($resp != ''){
        exit('ya existe el banco '.$resp.' con el mismo codigo, por favor verifique!');
	}elseif($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente el banco');
	 }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("BancoModelClass.php");
    $Model = new BancoModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el banco');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("BancoModelClass.php");
    $Model = new BancoModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el banco');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("BancoModelClass.php");
    $Model = new BancoModel();	
	$Data  = $Model -> selectBanco($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[banco_id] = array(
		name	=>'banco_id',
		id	    =>'banco_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('primary_key'))
	);
		  	
	$this -> Campos[nit_banco] = array(
		name	=>'nit_banco',
		id		=>'nit_banco',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('column'))
	);
	$this -> Campos[codigo_interno] = array(
		name	=>'codigo_interno',
		id		=>'codigo_interno',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('column'))
	);
	
	$this -> Campos[codigo_entidad] = array(
		name	=>'codigo_entidad',
		id		=>'codigo_entidad',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('column'))
	);		  
	
	$this -> Campos[nombre_banco] = array(
		name	=>'nombre_banco',
		id	=>'nombre_banco',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('column'))
	);	
	
	$this -> Campos[activo] = array(
		name	=>'estado',
		id		=>'activo',
		type	=>'radio',
	 	value	=>'1',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado',
		id		=>'inactivo',
		type	=>'radio',
	 	value	=>'0',
		checked	=>'checked',		
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('banco'),
			type	=>array('column'))
	);	
			
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'BancoOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'BancoOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'BancoOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'BancoOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		placeholder=>'ESCRIBA EL NOMBRE DEL BANCO',												
		//tabindex=>'1',
		suggest=>array(
			name	=>'banco',
			setId	=>'banco_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
$banco = new Banco();
?>