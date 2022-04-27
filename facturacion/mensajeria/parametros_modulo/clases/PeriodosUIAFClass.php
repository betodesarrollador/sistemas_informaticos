<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class PeriodosUIAF extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("PeriodosUIAFLayoutClass.php");
	require_once("PeriodosUIAFModelClass.php");	  
	
	$Layout   = new PeriodosUIAFLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PeriodosUIAFModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
	
	//// GRID ////
	$Attributes = array(
	  id		=>'periodo_uiaf',
	  title		=>'PeriodosUIAF Contables',
	  sortname	=>'empresa,anio,numero',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'empresa', index=>'empresa',sorttype=>'text',	width=>'300',	align=>'center'),
	  array(name=>'anio',	 index=>'anio',	  sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'numero',     index=>'numero',	  sorttype=>'int',	width=>'100',	align=>'center'),	  
	  array(name=>'desde',index=>'desde',	  sorttype=>'text',	width=>'100',	align=>'center'),	  
  	  array(name=>'hasta', index=>'hasta',	  sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'mostrar', index=>'mostrar', sorttype=>'text',	width=>'100',	align=>'center'),	  	  
	  array(name=>'estado',	 index=>'estado', sorttype=>'text',	width=>'100',	align=>'center')	  
	
	);
	  
    $Titles = array('EMPRESA',
					'AÑO',
					'NUMERO',
					'DESDE',
					'HASTA',
					'MOSTRAR',
					'ESTADO'
	);
	
	$Layout -> SetGridPeriodo($Attributes,$Titles,$Cols,$Model -> GetQueryPeriodo());	

	$Layout -> RenderMain();
	
  
  }
	  	  
  protected function onclickFind(){
	      	
	require_once("../../../framework/clases/FindRowClass.php");	    

    $Find = new FindRow($this -> getConex(),"periodo_uiaf",$this -> Campos);
	$data = $Find -> GetData();
	 		
	$this -> getArrayJSON($data);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("PeriodosUIAFModelClass.php");	    
    $Model = new PeriodosUIAFModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el periodo');
	 }	
		
  }

  protected function onclickUpdate(){

  	require_once("PeriodosUIAFModelClass.php");	    
    $Model = new PeriodosUIAFModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el periodo');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("PeriodosUIAFModelClass.php");	    
    $Model = new PeriodosUIAFModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el periodo');
	 }		
		
  }
  
  protected function onchangeSetOptionList(){
	  
    require_once("../../../framework/clases/ListaDependiente.php");
		
	if($_REQUEST['listChild'] == 'oficina_id'){
 	  $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
                                   'codigo_centro,nombre',concat=>'-',order=>'codigo_centro,nombre'),$this -> Campos);	
	}else{
  	    $list = new ListaDependiente($this -> getConex(),'anio',array(table=>'periodo_contable',
        value=>'anio',text=>'anio',concat=>''),$this -> Campos);		
	   }
	
	$list -> getList();
	  
  }
  
  protected function setCampos(){
  
	$this -> Campos[periodo_uiaf_id]  = array(type=>'hidden',name=>'periodo_uiaf_id',id=>'periodo_uiaf_id',
    datatype=>array(type=>'autoincrement'),transaction=>array(table=>array('periodo_uiaf'),type=>array('primary_key')));
	  
	$this -> Campos[empresa_id]  = array(type=>'select',required=>'yes',name=>'empresa_id',id=>'empresa_id',options=> array(),
	tabindex => '1',transaction=>array(table=>array('periodo_uiaf'),type=>array('column')),datatype=> array(type=>'integer'));

	$this -> Campos[anio]  = array(type=>'text',required=>'yes',name=>'anio',
    id=>'anio',tabindex => '3',transaction=>array(table=>array('periodo_uiaf'),
    type=>array('column')),datatype=> array(type=>'integer'));
	
	$this -> Campos[numero]  = array(type=>'text',required=>'yes',datatype=>array(type=>'integer'),name=>'numero',
    id=>'numero',tabindex => '4',transaction=>array(table=>array('periodo_uiaf'),type=>array('column')));
	
	$this -> Campos[desde]  = array(type=>'text',required=>'yes',datatype=>array(type=>'date'),name=>'desde',
    id=>'desde',tabindex => '5',transaction=>array(table=>array('periodo_uiaf'),type=>array('column')));
	
	$this -> Campos[hasta]  = array(type=>'text',required=>'yes',datatype=>array(type=>'date'),name=>'hasta',
    id=>'hasta',tabindex => '6',transaction=>array(table=>array('periodo_uiaf'),type=>array('column')));			
	
	$this -> Campos[estado]  = array(type=>'select',required=>'yes',datatype=>array(type=>'text'),name=>'estado',
    id=>'estado',tabindex => '8',transaction=>array(table=>array('periodo_uiaf'),type=>array('column')),options=>array(array(value=>'P',text=>'PENDIENTE'),array(value=>'R',text=>'REPORTADO',selected=>'0')));	
	
	$this -> Campos[mostrar]  = array(type=>'select',required=>'yes',datatype=>array(type=>'integer'),name=>'mostrar',
    id=>'mostrar',tabindex => '8',transaction=>array(table=>array('periodo_uiaf'),type=>array('column')),options=>array(array(value=>'0',text=>'NO'),array(value=>'1',text=>'SI',selected=>'0')));		
 
	$this -> Campos[guardar] = array(type=>'button',name=>'guardar',id=>'guardar',tabindex => 
	 '9',value=>'Guardar','property'=>array(name=>'save_ajax',onsuccess=>'PeriodosUIAFOnSaveOnUpdateonDelete'));
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar',tabindex => 
	 '10','property'=>array(name=>'update_ajax',onsuccess=>'PeriodosUIAFOnSaveOnUpdateonDelete'),value=>'Actualizar','disabled'=>'disabled');
	 
  	$this -> Campos[borrar] = array(type=>'button',name=>'borrar',id=>'borrar',tabindex => 
	 '11','property'=>array(name=>'delete_ajax',onsuccess=>'PeriodosUIAFOnSaveOnUpdateonDelete'),value=>'Borrar','disabled'=>'disabled');
	 
   	$this -> Campos[limpiar] = array(type=>'reset',name=>'limpiar',id=>'limpiar',tabindex => 
	 '12',value=>'Limpiar',onclick=>'PeriodosUIAFOnReset(this.form)');
	 
   	$this -> Campos[busqueda] = array(type=>'text',name=>'busqueda',id=>'busqueda',tabindex => 
	 '1',value=>'',size=>'85',suggest=>array(name=>'periodo_uiaf',onclick=>'LlenarFormPeriodo',setId=>'periodo_uiaf_id'));
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$PeriodosUIAF = new PeriodosUIAF();

?>