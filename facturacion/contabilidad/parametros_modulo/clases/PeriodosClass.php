<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Periodos extends Controler{
	
  public function __construct(){  
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("PeriodosLayoutClass.php");
	require_once("PeriodosModelClass.php");	  
	
	$Layout   = new PeriodosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PeriodosModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
	
	//// GRID ////
	$Attributes = array(
	  id		=>'periodo_contable',
	  title		=>'Periodos Contables',
	  sortname	=>'anio,fecha_cierre',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'empresa',      index=>'empresa',sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'fecha_cierre', index=>'fecha_cierre',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'anio',	      index=>'anio',	sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'estado',	      index=>'estado',	sorttype=>'text',	width=>'100',	align=>'center')	  
	  
	
	);
	  
    $Titles = array('EMPRESA',
					'FECHA CIERRE',
					'A&NtildeO',
					'ESTADO'
	);
	
	$Layout -> SetGridCentrosCosto($Attributes,$Titles,$Cols,$Model -> GetQueryEmpresasGrid());	

	$Layout -> RenderMain();
	
  
  }
  
  
  protected function showGrid(){
	  
	require_once("PeriodosLayoutClass.php");
	require_once("PeriodosModelClass.php");	  
	
	$Layout   = new PeriodosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PeriodosModel();
	  
	//// GRID ////
	$Attributes = array(
		id		=>'periodo_contable',
		title		=>'Periodos Contables',
		sortname	=>'anio,fecha_cierre',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'empresa',      index=>'empresa',sorttype=>'text',	width=>'200',	align=>'center'),
		array(name=>'fecha_cierre', index=>'fecha_cierre',	sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'anio',	      index=>'anio',	sorttype=>'int',	width=>'100',	align=>'center'),
		array(name=>'estado',	      index=>'estado',	sorttype=>'text',	width=>'100',	align=>'center')	  
		
	  
	  );
		
	  $Titles = array('EMPRESA',
					  'FECHA CIERRE',
					  'A&NtildeO',
					  'ESTADO'
	  );
	  
	$html =  $Layout -> SetGridCentrosCosto($Attributes,$Titles,$Cols,$Model -> GetQueryEmpresasGrid());	 
	 
	 print $html;
	  
  }
	  	  
  protected function onclickFind(){
	      	
	require_once("../../../framework/clases/FindRowClass.php");	    

    $Find = new FindRow($this -> getConex(),"periodo_contable",$this -> Campos);
	$data = $Find -> GetData();
	 		
	$this -> getArrayJSON($data);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("PeriodosModelClass.php");	    
    $Model = new PeriodosModel();
		
	$anio          		= $_REQUEST['anio']; 
	$Model -> Save($this -> Campos,$this -> getConex(),$anio);  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el Periodo');
	 }	
		
  }

  protected function onclickCrearMeses(){

		require_once("PeriodosModelClass.php");

		$Model = new PeriodosModel();

		 $periodo_contable_id          		= $_REQUEST['periodo_contable_id'];  
		 $empresa_id          		= $_REQUEST['empresa_id'];  
		 $anio          		= $_REQUEST['anio'];  

		$return = $Model -> CrearMeses($this -> Campos,$this -> getConex(),$periodo_contable_id,$empresa_id,$anio);

		exit($return);		

	}

  protected function onclickUpdate(){

  	require_once("PeriodosModelClass.php");	    
    $Model = new PeriodosModel();
	
	$periodo_contable_id = $_REQUEST['periodo_contable_id'];
	$estado = $_REQUEST['estado'];

	$data = $Model -> validarCierre($periodo_contable_id,$this -> getConex());

	$encabezado_registro_id = $data[0]['encabezado_registro_id'];
	
	if(count($data)>0 && $estado == 1){
		exit("No se puede actualizar el <strong>Periodo Contable</strong> seleccionado <br>Ya existe un Documento de Cierre de Año. <strong>(CONSECUTIVO: ".$data[0]['consecutivo'].")</strong> <br>Debe Anular el Documento por el formulario <a href=\"javascript:void(0)\" onClick=\"viewCierre('$encabezado_registro_id')\" ><strong>Cierre Fin</strong></a> para poder cambiar el estado del Periodo Contable");
	}

    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el Periodo');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("PeriodosModelClass.php");	    
    $Model = new PeriodosModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el Periodo');
	 }		
		
  }
  

  protected function setCampos(){
  
	$this -> Campos[periodo_contable_id]  = array(type=>'hidden',name=>'periodo_contable_id',id=>'periodo_contable_id',value=>$_REQUEST['periodo_contable_id'], datatype=>array(type=>'autoincrement'),transaction=>array(table=>array('periodo_contable'),type=>array('primary_key')));
	  
	$this -> Campos[empresa_id]  = array(type=>'select',Boostrap=>'si',required=>'yes',name=>'empresa_id',id=>'empresa_id',options=> array(),
	tabindex => '1',transaction=>array(table=>array('periodo_contable'),type=>array('column')),datatype=> array(type=>'integer'));

	$this -> Campos[fecha_cierre]  = array(type=>'text',Boostrap=>'si',readonly=>'readonly',datatype=>array(type=>'text'),name=>'fecha_cierre',
    id=>'fecha_cierre',tabindex => '2',transaction=>array(table=>array('periodo_contable'),type=>array('column')));
	
	$this -> Campos[anio]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'integer'),name=>'anio',
    id=>'anio',tabindex => '3',transaction=>array(table=>array('periodo_contable'),type=>array('column')));
	
	$this -> Campos[estado]  = array(type=>'select',Boostrap=>'si',required=>'yes',datatype=>array(type=>'integer'),name=>'estado',
    id=>'estado',tabindex => '3',transaction=>array(table=>array('periodo_contable'),type=>array('column')),options=>array(array(value=>'1',text=>'DISPONIBLE'),array(value=>'0',text=>'CERRADO',selected=>'0')));	
 
	$this -> Campos[guardar] = array(type=>'button',name=>'guardar',id=>'guardar',tabindex => 
	 '4',value=>'Guardar','property'=>array(name=>'save_ajax',onsuccess=>'PeriodoOnSaveOnUpdateonDelete'));

	$this -> Campos[replicar] = array(type=>'button',name=>'replicar',id=>'replicar',tabindex => 
	 '4',value=>'Crear Meses',onclick=>'ReplicarMeses(this.form)');
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar',tabindex => 
	 '5','property'=>array(name=>'update_ajax',onsuccess=>'PeriodoOnSaveOnUpdateonDelete'),value=>'Actualizar','disabled'=>'disabled');
	 
  	$this -> Campos[borrar] = array(type=>'button',name=>'borrar',id=>'borrar',tabindex => 
	 '6','property'=>array(name=>'delete_ajax',onsuccess=>'PeriodoOnSaveOnUpdateonDelete'),value=>'Borrar','disabled'=>'disabled');
	 
   	$this -> Campos[limpiar] = array(type=>'reset',name=>'limpiar',id=>'limpiar',tabindex => 
	 '7',value=>'Limpiar',onclick=>'PeriodoOnReset(this.form)');
	 
   	$this -> Campos[busqueda] = array(type=>'text',Boostrap=>'si',name=>'busqueda',id=>'busqueda',tabindex => 
	 '1',value=>'',size=>'85',suggest=>array(name=>'periodo_contable',onclick=>'LlenarFormPeriodo',setId=>'periodo_contable_id'));
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$Periodos = new Periodos();

?>