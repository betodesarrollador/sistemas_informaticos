<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ParametrosExogena extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
    $this -> noCache();
	  
	require_once("ParametrosExogenaLayoutClass.php");
	require_once("ParametrosExogenaModelClass.php");
	
	$Layout   = new ParametrosExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosExogenaModel();
	$oficina_id = $this -> getOficinaId();	
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar    ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar ($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar     ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar    ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
    $Layout -> SetCampos($this -> Campos);
	$Layout -> setFormato($Model -> getFormato($this -> getConex()));	
	
	$Layout -> RenderMain();  
  }
  
  protected function showGrid(){
	  
	require_once("ParametrosExogenaLayoutClass.php");
	require_once("ParametrosExogenaModelClass.php");
	
	$Layout   = new ParametrosExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosExogenaModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'formato_exogena',
		title		=>'Listado Formatos',
		sortname	=>'resolucion',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
		array(name=>'resolucion',index=>'resolucion',width=>'100', align=>'center'),
		array(name=>'fecha_resolucion',index=>'fecha_resolucion',width=>'100', align=>'center'),	  	  	  	  
		array(name=>'ano_gravable',index=>'ano_gravable',width=>'100',	align=>'center'),
		  array(name=>'tipo_formato',index=>'tipo_formato',width=>'110', align=>'center'),
		   array(name=>'version',index=>'version',width=>'100', align=>'center'),
		   array(name=>'montos_ingresos',index=>'montos_ingresos',width=>'130', align=>'left'),  
		   array(name=>'montos_ingresospj',index=>'montos_ingresospj',width=>'130', align=>'left')
	  );
	  
	  $Titles = array('RESOLUCION','FECHA','A&Ntilde;O','FORMATO','VERSION','INGRESOS PN','INGRESOS PJ');
	  
	  $html = $Layout -> SetGridParametrosExogena($Attributes,$Titles,$Cols,$Model -> getQueryParametrosExogenaGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
	require_once("ParametrosExogenaModelClass.php");
    $Model = new ParametrosExogenaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
 	
  protected function onclickSave(){
	require_once("ParametrosExogenaModelClass.php");
	$Model = new ParametrosExogenaModel();
	$return = $Model -> Save($this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
		if(is_numeric($return)){
			exit("$return");
	  	}else{
	  		exit('false');
		}
	 }
  }
  protected function onclickUpdate(){
 
  	require_once("ParametrosExogenaModelClass.php");
    $Model = new ParametrosExogenaModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente El Concepto');
	  }	
  }
  protected function onclickDelete(){
  	require_once("ParametrosExogenaModelClass.php");
    $Model = new ParametrosExogenaModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar El Concepto');
	}else{
	    exit('Se borro exitosamente El Concepto');
	  }	
  }
  protected function onclickDuplicar(){
	require_once("ParametrosExogenaModelClass.php");			
	$Model = new ParametrosExogenaModel();
	$Model -> duplicar($this -> getConex());
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
		exit('true');
	}
  }
//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ParametrosExogenaModelClass.php");
    $Model = new ParametrosExogenaModel();
	
    $Data                 			= array();
	$formato_exogena_id	= $_REQUEST['formato_exogena_id'];
	 
	if(is_numeric($formato_exogena_id)){	  
	  $Data  = $Model -> selectDatosParametrosExogenaId($formato_exogena_id,$this -> getConex());	  
	} 
    echo json_encode($Data);	
  }  
  
  protected function generateFile(){

	require_once "DetallesParametrosModelClass.php";

	$Model  = new DetallesParametrosModel(); 		 	

	$data  = $Model->getDetallesExcel($_REQUEST['formato_exogena_id'],$this->getConex());
	
	$ruta  = $this -> arrayToExcel("parametrosExogena","Detalle parametros",$data);

	$this -> ForceDownload($ruta);

}
  
  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[formato_exogena_id] = array(
		name	=>'formato_exogena_id',
		id		=>'formato_exogena_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('primary_key'))
	);	  
	$this -> Campos[resolucion] = array(
		name	=>'resolucion',
		id		=>'resolucion',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);
	
	$this -> Campos[nombre_formato] = array(
		name	=>'nombre_formato',
		id		=>'nombre_formato',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_resolucion] = array(
		name	=>'fecha_resolucion',
		id		=>'fecha_resolucion',
		type	=>'text',
		Boostrap=>'si',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	
	$this -> Campos[ano_gravable] = array(
		name	=>'ano_gravable',
		id		=>'ano_gravable',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'150'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	$this -> Campos[nit_extranjeros] = array(
		name	=>'nit_extranjeros',
		id		=>'nit_extranjeros',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	$this -> Campos[tipo_formato] = array(
		name	=>'tipo_formato',
		id		=>'tipo_formato',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	

	$this -> Campos[version] = array(
		name	=>'version',
		id		=>'version',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	
	$this -> Campos[montos_ingresos] = array(
		name	=>'montos_ingresos',
		id		=>'montos_ingresos',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	$this -> Campos[montos_ingresospj] = array(
		name	=>'montos_ingresospj',
		id		=>'montos_ingresospj',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	
	$this -> Campos[cuantia_minima] = array(
		name	=>'cuantia_minima',
		id		=>'cuantia_minima',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);
	
	$this -> Campos[cuantias_menores] = array(
		name	=>'cuantias_menores',
		id		=>'cuantias_menores',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	
	$this -> Campos[tipo_doc] = array(
		name	=>'tipo_doc',
		id		=>'tipo_doc',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);	
	
	$this -> Campos[nombre_tercero] = array(
		name	=>'nombre_tercero',
		id		=>'nombre_tercero',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('formato_exogena'),
			type	=>array('column'))
	);		
	$this -> Campos[tipo]  = array(
		type=>'select',
		Boostrap=>'si',
		datatype=>array(
			type=>'alphanum',length=>'1'),
   	 	name=>'tipo',
		id=>'tipo',
		required => 'yes',
		options=>array(
			array(value=>'N',text=>'NACIONAL'),
    		array(value=>'D',text=>'DISTRITAL'),
			array(value=>'M',text=>'MUNICIPAL')),
		transaction=>array(
			table=>array('formato_exogena'),
			type=>array('column'))
	);	
	$this -> Campos[formato_base]  = array(
		type=>'select',
		Boostrap=>'si',
		datatype=>array(
			type=>'integer',length=>'3'),
   	 	name=>'formato_base',
		id=>'formato_base',
		options=>array()
	);	
	$this -> Campos[tipo_formato_n] = array(
		name	=>'tipo_formato_n',
		id		=>'tipo_formato_n',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'150')
	);	
	$this -> Campos[version_n] = array(
		name	=>'version_n',
		id		=>'version_n',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'integer')
	);	
	$this -> Campos[resolucion_n] = array(
		name	=>'resolucion_n',
		id		=>'resolucion_n',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'150')
	);
	
	$this -> Campos[cuantia_minima_n] = array(
		name	=>'cuantia_minima_n',
		id		=>'cuantia_minima_n',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'numeric')
	);
	$this -> Campos[fecha_resolucion_n] = array(
		name	=>'fecha_resolucion_n',
		id		=>'fecha_resolucion_n',
		type	=>'text',
		Boostrap=>'si',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[ano_gravable_n] = array(
		name	=>'ano_gravable_n',
		id		=>'ano_gravable_n',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'150')
	);	

	/**********************************
 	             Botones
	**********************************/	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
		//tabindex=>'20'
	);
	$this -> Campos[duplicar] = array(
		name	=>'duplicar',
		id		=>'duplicar',
		type	=>'button',
		value	=>'Duplicar',
		onclick =>'onclickDuplicar(this.form)'
	);	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		//tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ParametrosExogenaOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ParametrosExogenaOnReset()'
	);
	   
	$this -> Campos[generar] = array(
		name=>'generar',
		id=>'generar',
		type =>'button',
		Clase => 'btn btn-success', 
		value=>'Generar Excel',
		onclick => 'Generar(this.form)'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'formato_exogena',
			setId	=>'formato_exogena_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}
$formato_exogena = new ParametrosExogena();
?>