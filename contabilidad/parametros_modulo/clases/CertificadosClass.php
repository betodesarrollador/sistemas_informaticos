<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Certificados extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();
    require_once("CertificadosLayoutClass.php");
    require_once("CertificadosModelClass.php");
	
    $Layout   = new CertificadosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CertificadosModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("CertificadosLayoutClass.php");
    require_once("CertificadosModelClass.php");
	
    $Layout   = new CertificadosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CertificadosModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'certificados',
		title		=>'Certificados',
		sortname	=>'nombre',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
		array(name=>'nombre', index=>'nombre',width=>'200',	align=>'center'),
		array(name=>'entidad',index=>'entidad',width=>'100',	align=>'center'),	  	  
		array(name=>'decreto',index=>'decreto',width=>'200',	align=>'center'),	  	  	  
		array(name=>'cuenta', index=>'cuenta',width=>'200',	align=>'center'),	  	  	  	  
		array(name=>'puc',    index=>'puc',width=>'100',	align=>'center')
	  
	  );
		
	  $Titles = array('NOMBRE',
					  'ENTIDAD',
					  'DECRETO',
					  'CUENTA',
					  'PUC');
		  
	 $html = $Layout -> SetGridCertificados($Attributes,$Titles,$Cols,$Model -> getQueryCertificadosGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("CertificadosModelClass.php");
    $Model = new CertificadosModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit("Registro guardado exitosamente!");
	 }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("CertificadosModelClass.php");
    $Model = new CertificadosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Registro actualizado exitosamente!');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("CertificadosModelClass.php");
    $Model = new CertificadosModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Registro eliminado exitosamente!');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("CertificadosModelClass.php");
    $Model = new CertificadosModel();
	$Data  = $Model -> selectCertificados($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[certificados_id] = array(
		name	=>'certificados_id',
		id	    =>'certificados_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('certificados'),
			type	=>array('primary_key'))
	);
		  	
	$this -> Campos[numero_certificado] = array(
		name	=>'numero_certificado',
		id		=>'numero_certificado',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('certificados'),
			type	=>array('column'))
	);	  
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('certificados'),
			type	=>array('column'))
	);	
	$this -> Campos[entidad] = array(
		name	=>'entidad',
		id	    =>'entidad',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('certificados'),
			type	=>array('column'))
	);	
	
	$this -> Campos[decreto] = array(
		name	=>'decreto',
		id	    =>'decreto',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('certificados'),
			type	=>array('column'))
	);	
	
			
	$this -> Campos[activo] = array(
		name	=>'estado',
		id		=>'activo',
		type	=>'radio',
	 	value	=>'1',
		checked	=>'checked',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('certificados'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado',
		id		=>'inactivo',
		type	=>'radio',
	 	value	=>'0',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('certificados'),
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
			onsuccess=>'CertificadosOnSave')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CertificadosOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CertificadosOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CertificadosOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'certificados',
			setId	=>'certificados_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
new Certificados();
?>