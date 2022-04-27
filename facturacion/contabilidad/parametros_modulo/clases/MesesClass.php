<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Meses extends Controler{
	
  public function __construct(){
  
	//// -> setCampos();  	
	parent::__construct(3);
	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("MesesLayoutClass.php");
	require_once("MesesModelClass.php");	  
	
	$Layout   = new MesesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new MesesModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));

	$Layout -> RenderMain();
	
  
  }
  
  
  
  protected function showGrid(){
	  
	require_once("MesesLayoutClass.php");
	require_once("MesesModelClass.php");	  
	
	$Layout   = new MesesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new MesesModel();	
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'mes_contable',
		title		=>'Meses Contables',
		sortname	=>'empresa,anio,mes',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'empresa', index=>'empresa',sorttype=>'text',	width=>'280',	align=>'center'),
		array(name=>'oficina', index=>'oficina',	  sorttype=>'text',	width=>'120',	align=>'left'),
		array(name=>'anio',	 index=>'anio',	  sorttype=>'int',	width=>'100',	align=>'center'),
		array(name=>'mes',     index=>'mes',	  sorttype=>'int',	width=>'100',	align=>'center'),	  
		array(name=>'fecha_inicio',index=>'fecha_inicio',	  sorttype=>'text',	width=>'100',	align=>'center'),	  
		  array(name=>'fecha_final', index=>'fecha_final',	  sorttype=>'text',	width=>'100',	align=>'center'),	  
		array(name=>'estado',	 index=>'estado', sorttype=>'text',	width=>'100',	align=>'center')	  
	  
	  );
		
	  $Titles = array('EMPRESA',
					  'OFICINA',
					  'A&Ntilde;O',
					  'MES',
					  'FECHA INICIO',
					  'FECHA FINAL',
					  'ESTADO'
	  );
	  
	 $html = $Layout -> SetGridCentrosCosto($Attributes,$Titles,$Cols,$Model -> GetQueryMesesGrid());	
	 
	 print $html;
	  
  }
	  	  
  protected function onclickFind(){
	      	
	require_once("../../../framework/clases/FindRowClass.php");	    

    $Find = new FindRow($this -> getConex(),"mes_contable",$this -> Campos);
	$data = $Find -> GetData();
	 		
	$this -> getArrayJSON($data);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("MesesModelClass.php");	    
    $Model = new MesesModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el Mes Contable');
	 }	
		
  }

  protected function onclickUpdate(){

  	require_once("MesesModelClass.php");	    
	$Model = new MesesModel();

	$mes_contable_id = $_REQUEST['mes_contable_id'];
	$estado = $_REQUEST['estado'];
	
	$data = $Model -> validarPeriodo($mes_contable_id,$this->getConex());

	$periodo_contable_id = $data[0]['periodo_contable_id'];
	
	if($data[0]['estado'] == 0 && $estado !=2 ){
		exit("No se puede actualizar el <strong>Mes Contable</strong> seleccionado. <br>El Periodo Contable del mes <strong>".$data[0]['nombre']." DEL ".$data[0]['anio']."</strong> esta cerrado. <br>Debe cambiar el estado del Periodo Contable a Disponible desde el formulario <a href=\"javascript:void(0)\" onClick=\"viewPeriodo('$periodo_contable_id')\" ><strong>Periodos Contables</strong></a> para poder cambiar el estado del Mes Contable.");
	}

    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el Mes Contable');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("MesesModelClass.php");	    
    $Model = new MesesModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el Mes Contable');
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
  
	$this -> Campos[mes_contable_id]  = array(type=>'hidden',name=>'mes_contable_id',id=>'mes_contable_id',
    datatype=>array(type=>'autoincrement'),transaction=>array(table=>array('mes_contable'),type=>array('primary_key')));
	  
	$this -> Campos[empresa_id]  = array(type=>'select',Boostrap=>'si',required=>'yes',name=>'empresa_id',id=>'empresa_id',options=> array(),
	tabindex => '1',transaction=>array(table=>array('mes_contable'),type=>array('column')),datatype=> array(type=>'integer'),setoptionslist=>array(childId=>'oficina_id,periodo_contable_id'));

	$this -> Campos[oficina_id]  = array(type=>'select',Boostrap=>'si',required=>'yes',name=>'oficina_id',
    id=>'oficina_id',options=> array(),tabindex => '2',transaction=>array(table=>array('mes_contable'),
    type=>array('column')),datatype=> array(type=>'integer'));

	$this -> Campos[periodo_contable_id]  = array(type=>'select',Boostrap=>'si',required=>'yes',name=>'periodo_contable_id',
    id=>'periodo_contable_id',options=> array(),tabindex => '3',transaction=>array(table=>array('mes_contable'),
    type=>array('column')),datatype=> array(type=>'integer'));
	
	$this -> Campos[mes]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'integer'),name=>'mes',
    id=>'mes',tabindex => '4',transaction=>array(table=>array('mes_contable'),type=>array('column')));
	
	$this -> Campos[fecha_inicio]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'date'),name=>'fecha_inicio',
    id=>'fecha_inicio',tabindex => '5',transaction=>array(table=>array('mes_contable'),type=>array('column')));
	
	$this -> Campos[fecha_final]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'date'),name=>'fecha_final',
    id=>'fecha_final',tabindex => '6',transaction=>array(table=>array('mes_contable'),type=>array('column')));	
	
	$this -> Campos[nombre]  = array(type=>'text',Boostrap=>'si',required=>'yes',datatype=>array(type=>'alphanum'),name=>'nombre',
    id=>'nombre',tabindex => '7',transaction=>array(table=>array('mes_contable'),type=>array('column')));	
	
	$this -> Campos[estado]  = array(type=>'select',Boostrap=>'si',required=>'yes',datatype=>array(type=>'integer'),name=>'estado',
    id=>'estado',tabindex => '8',transaction=>array(table=>array('mes_contable'),type=>array('column')),options=>array(array(value=>'1',text=>'DISPONIBLE'),array(value=>'0',text=>'BLOQUEADO',selected=>'0'),array(value=>'2',text=>'CERRADO')));

	$this -> Campos[mes_trece]  = array(type=>'select',Boostrap=>'si',required=>'yes',datatype=>array(type=>'integer'),name=>'mes_trece',
    id=>'mes_trece',tabindex => '9',transaction=>array(table=>array('mes_contable'),type=>array('column')),options=>array(array(value=>'1',text=>'SI'),array(value=>'0',text=>'NO',selected=>'0')));	

	$this -> Campos[guardar] = array(type=>'button',name=>'guardar',id=>'guardar',tabindex => 
	 '9',value=>'Guardar','property'=>array(name=>'save_ajax',onsuccess=>'MesOnSaveOnUpdateonDelete'));
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar',tabindex => 
	 '10','property'=>array(name=>'update_ajax',onsuccess=>'MesOnSaveOnUpdateonDelete'),value=>'Actualizar','disabled'=>'disabled');
	 
  	$this -> Campos[borrar] = array(type=>'button',name=>'borrar',id=>'borrar',tabindex => 
	 '11','property'=>array(name=>'delete_ajax',onsuccess=>'MesOnSaveOnUpdateonDelete'),value=>'Borrar','disabled'=>'disabled');
	 
   	$this -> Campos[limpiar] = array(type=>'reset',name=>'limpiar',id=>'limpiar',tabindex => 
	 '12',value=>'Limpiar',onclick=>'MesOnReset(this.form)');
	 
   	$this -> Campos[busqueda] = array(type=>'text',Boostrap=>'si',name=>'busqueda',id=>'busqueda',tabindex => 
	 '1',value=>'',size=>'85',placeholder=>'ESCRIBA EL NOMBRE O N&Uacute;MERO DEL MES CONTABLE',suggest=>array(name=>'mes_contable',onclick=>'LlenarFormPeriodo',setId=>'mes_contable_id'));
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$Meses = new Meses();

?>