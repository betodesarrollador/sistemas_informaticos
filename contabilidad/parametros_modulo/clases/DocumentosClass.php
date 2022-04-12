<?php
require_once("../../../framework/clases/ControlerClass.php");
  
final class Documentos extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();
	require_once("DocumentosLayoutClass.php");
	require_once("DocumentosModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");		  
	
	$Layout              = new DocumentosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new DocumentosModel();	  
	$UtilidadesContables = new UtilidadesContablesModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($UtilidadesContables -> getEmpresas($this -> getConex()));	
		
	$Layout -> RenderMain();
	
  
  }
  
  protected function showGrid(){
	  
	require_once("DocumentosLayoutClass.php");
	require_once("DocumentosModelClass.php");
	
    $Layout              = new DocumentosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new DocumentosModel();	
	  
	 	//// GRID ////
	$Attributes = array(
		id		=>'tipo_de_documento',
		title		=>'Documentos',
		sortname	=>'nombre',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
	  
		array(name=>'codigo',            index=>'codigo', sorttype=>'text',	         width=>'100',	align=>'center'),
		array(name=>'nombre',	           index=>'nombre', sorttype=>'text',	         width=>'100',	align=>'center'),
		array(name=>'consecutivo',       index=>'consecutivo', sorttype=>'text',	     width=>'150',	align=>'center'),
		array(name=>'consecutivo_periodo', index=>'consecutivo_periodo', sorttype=>'text', width=>'150',	align=>'center'),
		array(name=>'texto_tercero'    , index=>'texto_tercero', sorttype=>'text',     width=>'150',	align=>'center'),
		array(name=>'texto_soporte'    , index=>'texto_soporte', sorttype=>'text',     width=>'150',	align=>'center'),
		array(name=>'requiere_soporte' , index=>'requiere_soporte', sorttype=>'text',     width=>'150',	align=>'center'),
		array(name=>'de_cierre' , 		index=>'de_cierre', 			sorttype=>'text',     	width=>'150',	align=>'center'),	  
		array(name=>'de_traslado' , 		index=>'de_traslado', 			sorttype=>'text',     	width=>'150',	align=>'center'),	  
		array(name=>'de_anticipo' , 		index=>'de_anticipo', 			sorttype=>'text',     	width=>'150',	align=>'center'),	  
		array(name=>'de_devolucion' , 	index=>'de_devolucion', 		sorttype=>'text',     	width=>'150',	align=>'center'),	  
		array(name=>'pago_factura' , 		index=>'pago_factura',	 		sorttype=>'text',     	width=>'150',	align=>'center'),
		array(name=>'pago_proveedor' , 	index=>'pago_proveedor',	 	sorttype=>'text',     	width=>'150',	align=>'center')
		
	  
	  );
		
	  $Titles = array('CODIGO',
					  'NOMBRE',
					  'CONSECUTIVO',
					  'CONSECUTIVO ANUAL',
					  'TEXTO TERCERO',
					  'TEXTO SOPORTE',
					  'REQUIERE SOPORTE',
					  'DOC. CIERRE',
					  'DOC. TRASLADO',
					  'DOC. ANTICIPO',
					  'DOC. DEVOLUCION',
					  'PAGO FACTURA',
					  'PAGO PROVEEDORES'	
	  );
	  
	  $html = $Layout -> SetGridCentrosCosto($Attributes,$Titles,$Cols,$Model -> GetQueryEmpresasGrid());	
	 
	 print $html;
	  
  }
	  	  
  protected function onclickFind(){
	      				
	require_once("DocumentosModelClass.php");	    
    $Model             = new DocumentosModel();	 
	$tipo_documento_id = $_REQUEST['tipo_documento_id'];
    $result            = $Model -> selectDocumentos($tipo_documento_id,$this -> getConex());
	 		
	$this -> getArrayJSON($result);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("DocumentosModelClass.php");	    
    $Model = new DocumentosModel();
		
	$result = $Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
		$this -> getArrayJSON($result);
	    // exit('Se ingreso Exitosamente la Documentos');
	 }	
		
  }
  protected function onclickUpdate(){
  	require_once("DocumentosModelClass.php");	    
    $Model = new DocumentosModel();
			
	$Model -> Update($this -> Campos,$this -> getConex());  
	
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente la Documentos');
	 }		
		
  }
	  
  protected function onclickDelete(){
  	require_once("DocumentosModelClass.php");	    
    $Model = new DocumentosModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente la Documentos');
	 }		
		
  }
  
  protected function setCampos(){
  
	$this -> Campos[tipo_documento_id]  = array(type=>'hidden',name=>'tipo_documento_id',id=>'tipo_documento_id',
    datatype=>array(type=>'autoincrement'),transaction=>array(table=>array('tipo_de_documento'),type=>array('primary_key')));
	
	$this -> Campos[empresa_id]  = array(type=>'select',Boostrap =>'si',options => array(),name=>'empresa_id',id=>'empresa_id',
    datatype=>array(type=>'integer'),transaction=>array(table=>array('tipo_de_documento'),type=>array('column')));	
	  
	$this -> Campos[codigo]  = array(type=>'text',Boostrap =>'si',required=>'yes',datatype=>array(type=>'alphanum_space'),name=>'codigo',
    id=>'codigo',transaction=>array(table=>array('tipo_de_documento'),type=>array('column')));
	
	$this -> Campos[nombre]  = array(type=>'text',Boostrap =>'si',required=>'yes',datatype=>array(type=>'alphanum_space'),name=>'nombre',
    id=>'nombre',transaction=>array(table=>array('tipo_de_documento'),type=>array('column')));
	
	$this -> Campos[consecutivo]  = array(type=>'text',Boostrap =>'si',required=>'yes',datatype=>array(type=>'alphanum_space'),name=>'consecutivo',
    id=>'consecutivo',transaction=>array(table=>array('tipo_de_documento'),type=>array('column')));
	
	$this -> Campos[consecutivo_por]  = array(type=>'select',Boostrap =>'si',options => array(array(value => 'E', text => 'EMPRESA'),array(value => 'O', text => 'OFICINA')),selected => 'E',required=>'yes',datatype=>array(type=>'text'),name=>'consecutivo_por',
    id=>'consecutivo_por',transaction=>array(table=>array('tipo_de_documento'),type=>array('column')));	
	
	$this -> Campos[consecutivo_periodo]  = array(type=>'select',Boostrap =>'si',required=>'yes',datatype=>array(type=>'integer'),
    name=>'consecutivo_periodo',id=>'consecutivo_periodo',options=>array(array(value=>'0',text=>'NO',selected=>'0'),
    array(value=>'1',text=>'SI')),required=>'yes',transaction=>array(table=>array('tipo_de_documento'),
	type=>array('column')));	
	
	$this -> Campos[texto_tercero]  = array(type=>'text',required=>'yes',Boostrap =>'si',datatype=>array(type=>'text'),name=>
    'texto_tercero',id=>'texto_tercero',transaction=>array(table=>array('tipo_de_documento'),type=>array('column')))
	;
	
	$this -> Campos[texto_soporte]  = array(type=>'text',required=>'yes',Boostrap =>'si',datatype=>array(type=>'text'),name=>
    'texto_soporte',id=>'texto_soporte',transaction=>array(table=>array('tipo_de_documento'),type=>array('column')))
	;	
	$this -> Campos[requiere_soporte]  = array(type=>'select',Boostrap =>'si',name=>'requiere_soporte',id=>'requiere_soporte',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'1',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');
	
	
	$this -> Campos[de_cierre]  = array(type=>'select',Boostrap =>'si',name=>'de_cierre',id=>'de_cierre',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');	
	
	$this -> Campos[de_traslado]  = array(type=>'select',Boostrap =>'si',name=>'de_traslado',id=>'de_traslado',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');		
	$this -> Campos[de_anticipo]  = array(type=>'select',Boostrap =>'si',name=>'de_anticipo',id=>'de_anticipo',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');		
 
	$this -> Campos[de_devolucion]  = array(type=>'select',Boostrap =>'si',name=>'de_devolucion',id=>'de_devolucion',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');
	
	$this -> Campos[pago_factura]  = array(type=>'select',Boostrap =>'si',name=>'pago_factura',id=>'pago_factura',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');	
	
	$this -> Campos[pago_proveedor]  = array(type=>'select',Boostrap =>'si',name=>'pago_proveedor',id=>'pago_proveedor',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');

	$this -> Campos[nota_credito]  = array(type=>'select',Boostrap =>'si',name=>'nota_credito',id=>'nota_credito',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');	

	$this -> Campos[nota_debito]  = array(type=>'select',Boostrap =>'si',name=>'nota_debito',id=>'nota_debito',
    options=> array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI')),selected=>'0',
	transaction=>array(table=>array('tipo_de_documento'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');		
	
 
	$this -> Campos[guardar] = array(type=>'button',name=>'guardar',id=>'guardar',value=>'Guardar','property'=>
	array(name=>'save_ajax',onsuccess=>'DocumentosOnSaveOnUpdateonDelete'));
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar','property'=>
	array(name=>'update_ajax',onsuccess=>'DocumentosOnSaveOnUpdateonDelete'),value=>'Actualizar','disabled'=>'disabled');
	 
  	$this -> Campos[borrar] = array(type=>'button',name=>'borrar',id=>'borrar','property'=>
	array(name=>'delete_ajax',onsuccess=>'DocumentosOnSaveOnUpdateonDelete'),value=>'Borrar','disabled'=>'disabled');
	 
   	$this -> Campos[limpiar] = array(type=>'reset',name=>'limpiar',id=>'limpiar',value=>'Limpiar',onclick=>'DocumentosOnReset(this.form)');
	 
   	$this -> Campos[busqueda] = array(type=>'text',Boostrap =>'si',name=>'busqueda',id=>'busqueda',value=>'',size=>'85',placeholder=>'ESCRIBA EL C&Oacute;DIGO O NOMBRE DEL DOCUMENTO',suggest=>
	array(name=>'tipo_de_documento',onclick=>'LlenarFormDocumentos',setId=>'tipo_documento_id'));
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}
$Documentos = new Documentos();
?>