<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ParametroReporte extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();
    require_once("ParametroReporteLayoutClass.php");
    require_once("ParametroReporteModelClass.php");
    $Layout   = new ParametroReporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametroReporteModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("ParametroReporteLayoutClass.php");
    require_once("ParametroReporteModelClass.php");
    
	$Layout   = new ParametroReporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametroReporteModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'parametro_reporte_contable_id',
		title		=>'Listado Parametros',
		sortname	=>'utilidad_id',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
		array(name=>'utilidad_id',	index=>'utilidad_id',width=>'100',	align=>'center'),
		array(name=>'perdida_id',index=>'perdida_id', width=>'200',	align=>'center'),
		array(name=>'utilidad_cierre_id',index=>'utilidad_cierre_id',	width=>'100',	align=>'center'),
		array(name=>'perdida_cierre_id',index=>'perdida_cierre_id',	width=>'100',	align=>'center'),	  	  
		array(name=>'contador_nombres',index=>'contador_nombres',	width=>'100',	align=>'center'),	  	  	  
		array(name=>'contador_cargo',index=>'contador_cargo',	width=>'100',	align=>'center'),	  	  	  	  
		array(name=>'contador_cedula',index=>'contador_cedula',	width=>'100',	align=>'center'),	  	  	  	  
		array(name=>'contador_tarjeta_profesional',index=>'contador_tarjeta_profesional',	width=>'100',	align=>'center'),	  	  	  	  
		array(name=>'revisor_nombres',index=>'revisor_nombres',	width=>'100',	align=>'center'),	  	  	  	  
		array(name=>'revisor_cargo',index=>'revisor_cargo',	width=>'100',	align=>'center'),	  	  	  	  
		array(name=>'revisor_cedula',index=>'revisor_cedula',	width=>'100',	align=>'center'),	  	  	  	  	 	  
		array(name=>'revisor_tarjeta_profesional',index=>'revisor_tarjeta_profesional',	width=>'100',	align=>'center'),	  	  	  	  	  	  
		array(name=>'representante_nombres',index=>'representante_nombres',	width=>'100',	align=>'center'),	  	  	  	  	  	  	  
		array(name=>'representante_cargo',index=>'representante_cargo',	width=>'100',	align=>'center'),	  	  	  	  	  	  	  	  
		array(name=>'representante_cedula',index=>'representante_cedula',	width=>'100',	align=>'center')	  
	  
	  );
		
	  $Titles = array(
	  
  'UTILIDAD'
  ,'PERDIDA'
  ,'UTILIDAD CIERRE'
  ,'PERDIDA CIERRE'
  ,'CONTADOR'
  ,'CARGO'
  ,'CEDULA'
  ,'N. TARJETA'
  ,'REVISOR'
  ,'CARGO'
  ,'CEDULA'
  ,'N. TARJETA'
  ,'REPRESENTANTE'
  ,'CARGO'
  ,'CEDULA'
	  
	  
	  );
	  
	 $html = $Layout -> SetGridParametroReporte($Attributes,$Titles,$Cols,$Model -> getQueryParametroReporteGrid());
	 
	 print $html;
	  
  }
  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("ParametroReporteModelClass.php");
    $Model = new ParametroReporteModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente los datos!');
	 }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("ParametroReporteModelClass.php");
    $Model = new ParametroReporteModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente los datos!');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("ParametroReporteModelClass.php");
    $Model = new ParametroReporteModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente los datos!');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("ParametroReporteModelClass.php");
    $Model = new ParametroReporteModel();
	$Data  = $Model -> selectParametroReporte($this -> getConex());
	$this -> getArrayJSON($Data);
  }
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[parametro_reporte_contable_id] = array(
		name	=>'parametro_reporte_contable_id',
		id	    =>'parametro_reporte_contable_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('primary_key'))
	);
		  	
	$this -> Campos[utilidad] = array(
		name	=>'utilidad',
		id		=>'utilidad',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento_activas',
			setId	=>'utilidad_id_hidden')
	);	  
	
	$this -> Campos[utilidad_id] = array(
		name	=>'utilidad_id',
		id	    =>'utilidad_id_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
		
		
	$this -> Campos[perdida] = array(
		name	=>'perdida',
		id		=>'perdida',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento_activas',
			setId	=>'perdida_id_hidden')
	);	  
	
	$this -> Campos[perdida_id] = array(
		name	=>'perdida_id',
		id	    =>'perdida_id_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[utilidad_cierre] = array(
		name	=>'utilidad_cierre',
		id		=>'utilidad_cierre',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento_activas',
			setId	=>'utilidad_cierre_id_hidden')
	);	  
	
	$this -> Campos[utilidad_cierre_id] = array(
		name	=>'utilidad_cierre_id',
		id	    =>'utilidad_cierre_id_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
		
		
	$this -> Campos[perdida_cierre] = array(
		name	=>'perdida_cierre',
		id		=>'perdida_cierre',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento_activas',
			setId	=>'perdida_cierre_id_hidden')
	);	  
	
	$this -> Campos[perdida_cierre_id] = array(
		name	=>'perdida_cierre_id',
		id	    =>'perdida_cierre_id_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	
	
	
	$this -> Campos[contador_nombres] = array(
		name	=>'contador_nombres',
		id		=>'contador_nombres',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[contador_cargo] = array(
		name	=>'contador_cargo',
		id		=>'contador_cargo',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[contador_cedula] = array(
		name	=>'contador_cedula',
		id		=>'contador_cedula',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);		
	
	$this -> Campos[contador_tarjeta_profesional] = array(
		name	=>'contador_tarjeta_profesional',
		id		=>'contador_tarjeta_profesional',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[revisor_nombres] = array(
		name	=>'revisor_nombres',
		id		=>'revisor_nombres',
		type	=>'text',
		// required=>'yes',
		Boostrap =>'si',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);		
		
	$this -> Campos[revisor_cargo] = array(
		name	=>'revisor_cargo',
		id		=>'revisor_cargo',
		type	=>'text',
		// required=>'yes',
		Boostrap =>'si',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);		
	$this -> Campos[revisor_cedula] = array(
		name	=>'revisor_cedula',
		id		=>'revisor_cedula',
		type	=>'text',
		// required=>'yes',
		Boostrap =>'si',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	$this -> Campos[revisor_tarjeta_profesional] = array(
		name	=>'revisor_tarjeta_profesional',
		id		=>'revisor_tarjeta_profesional',
		type	=>'text',
		// required=>'yes',
		Boostrap =>'si',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	$this -> Campos[representante_nombres] = array(
		name	=>'representante_nombres',
		id		=>'representante_nombres',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	$this -> Campos[representante_cargo] = array(
		name	=>'representante_cargo',
		id		=>'representante_cargo',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
			type	=>array('column'))
	);	
	$this -> Campos[representante_cedula] = array(
		name	=>'representante_cedula',
		id		=>'representante_cedula',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'text'),	
		transaction=>array(
			table	=>array('parametro_reporte_contable'),
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
			onsuccess=>'ParametroReporteOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ParametroReporteOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ParametroReporteOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ParametroReporteOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		placeholder => 'BUSQUE POR FAVOR BUSQUE POR NUMERO',
		//tabindex=>'1',
		suggest=>array(
			name	=>'parametro_reporte_contable',
			setId	=>'parametro_reporte_contable_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
new ParametroReporte();
?>