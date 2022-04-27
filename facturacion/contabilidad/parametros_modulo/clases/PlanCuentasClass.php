<?php
require_once("../../../framework/clases/ControlerClass.php");
  
final class PlanCuentas extends Controler{
	
  private $HTMLcode;
  private $puc;
	
  public function __construct(){
	parent::__construct(3);
  }
  	
  public function Main(){
    
    $this -> noCache();
	require_once("PlanCuentasLayoutClass.php");
	require_once("PlanCuentasModelClass.php");	  
	
	$Layout   = new PlanCuentasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PlanCuentasModel();	  
	
	$Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex());	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
    $Layout -> setCampos($this -> Campos);
	$Layout -> setVarSuggets($this -> getUsuarioId()); 			
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex())); 
		
	$Layout -> RenderMain();
		
	$this -> getPlanCuentasTree();	
  
  }
  protected function onclickValidateRow(){
	  
	require_once("PlanCuentasModelClass.php");	    
	
    $Model      = new PlanCuentasModel();
	$codigo_puc = $_REQUEST['codigo_puc']; 
	  
    $result = $Model ->selectCuentaPuc($codigo_puc,$this -> getEmpresaId(),$this -> getConex());
	
	print $result;
	
  }
/*************************************************************************************** */
  // validar campo superior 
  
  protected function sugerirNivelSuperior() {
	  
	require_once("PlanCuentasModelClass.php");	    
	
    $Model      = new PlanCuentasModel();
	$codigo_puc = $_REQUEST['codigo_puc']; 
	$nivelSuperior = intval($_REQUEST['nivel']) -1;
	 
	  
    $result = $Model ->selectNivelSuperior($codigo_puc,$nivelSuperior,$this -> getEmpresaId(),$this -> getConex()); // selectNivelSuperior funcion de consulta planCuentasModelClass.php
	
	print $result;
	
  }

  protected function validasuperior(){
  
	require_once("PlanCuentasModelClass.php");	    
	
    $Model  = new PlanCuentasModel();
	$codigo_puc = $_REQUEST['codigo_puc']; 
	  
    $result = $Model -> selectValidaCuentaSuperior($codigo_puc,$this -> getEmpresaId(),$this -> getConex());
	
	$this -> getArrayJSON($result);      
  
  }

   protected function validarNivel(){
  
	require_once("PlanCuentasModelClass.php");	    
	
    $Model  = new PlanCuentasModel();
	$puc_id = $_REQUEST['puc_id']; 
	  
    $result = $Model -> selectValidarNivel($puc_id,$this -> getConex());
	
	echo json_encode($result, JSON_NUMERIC_CHECK);   
  
  }
  
  protected function getDataCuentaPuc(){
  
	require_once("PlanCuentasModelClass.php");	    
	
    $Model  = new PlanCuentasModel();
	$puc_id = $_REQUEST['puc_id']; 
	
	  
    $result = $Model -> selectDataCuentaPuc($puc_id,$this -> getEmpresaId(),$this -> getConex());
	
	$this -> getArrayJSON($result);      
  
  }

   protected function getPucSuperior(){
  
	require_once("PlanCuentasModelClass.php");	    
	
    $Model  = new PlanCuentasModel();
	$puc_id = $_REQUEST['puc_id']; 
	  // se llama la funcion selectPucSuperior en el modelo
	$result = $Model ->selectPucSuperior($puc_id,$this -> getEmpresaId(),$this -> getConex());
	
	
	$this -> getArrayJSON($result);      
  
  }
	  	  
  protected function onclickFind(){
	      	
    require_once("../../../framework/clases/FindRowClass.php");
	require_once("PlanCuentasModelClass.php");	    
    $Model  = new PlanCuentasModel();	 
	$puc_id = $_REQUEST['puc_id'];
    $result = $Model -> selectPlanCuentas($puc_id,$this -> getConex());
		 		
	$this -> getArrayJSON($result);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("PlanCuentasModelClass.php");	    
    $Model = new PlanCuentasModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente la PlanCuentas');
	 }	
		
  }
  protected function onclickUpdate(){
  	require_once("PlanCuentasModelClass.php");	    
    $Model = new PlanCuentasModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente la PlanCuentas');
	 }		
		
  }
	  
  protected function onclickDelete(){
  	require_once("PlanCuentasModelClass.php");	    
    $Model = new PlanCuentasModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente la PlanCuentas');
	 }		
		
  }
     
  
  protected function getPlanCuentasTree(){
  
  	require_once("PlanCuentasLayoutClass.php");
	require_once("PlanCuentasModelClass.php");	  
	
	$Layout      = new PlanCuentasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new PlanCuentasModel();	
	$empresas    = $Model -> getEmpresasPuc($this -> getUsuarioId(),$this -> getConex());
	$empresa_id  = strlen(trim($_REQUEST['empresa_id'])) > 0 ? $_REQUEST['empresa_id'] : $empresas[0]['empresa_id'] ;
	$this -> puc = array();	
	
    $Cuentas = $Model -> getCuentasTree($empresa_id,$this -> getConex());	
	
	$j = 0;
		
	for($i = 0; $i < count($Cuentas); $i++){
	  
	  $this -> puc = array_merge($this -> puc,array($Cuentas[$i]));	  	  
	  $this -> getNodesTree($Cuentas[$i]['puc_id']);
	
	}
		
    $Layout -> setVar('sectionPlanCuentasTree',1);	
    $Layout -> setVar('print',0);		
    $Layout -> setVar('empresas',$empresas);	
    $Layout -> setVar('empresa_id',$empresa_id);	
    $Layout -> setVar('puc',$this -> puc);
		
    $Layout -> RenderLayout('plancuentas.tpl');
  }
  
  
 protected function getPlanCuentasPrint(){
	  
  	require_once("PlanCuentasLayoutClass.php");
	require_once("PlanCuentasModelClass.php");	  
	
	$Layout      = new PlanCuentasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new PlanCuentasModel();	
	$empresas    = $Model -> getEmpresasPuc($this -> getUsuarioId(),$this -> getConex());
	$empresa_id  = strlen(trim($_REQUEST['empresa_id'])) > 0 ? $_REQUEST['empresa_id'] : $empresas[0]['empresa_id'] ;
	$this -> puc = array();	
	
    $Cuentas = $Model -> getCuentasTree($empresa_id,$this -> getConex());	
	
	$j = 0;
		
	for($i = 0; $i < count($Cuentas); $i++){
	  
	  $this -> puc = array_merge($this -> puc,array($Cuentas[$i]));	  	  
	  $this -> getNodesTree($Cuentas[$i]['puc_id']);
	
	}
		
    $Layout -> setVar('sectionPlanCuentasTree',1);	
    $Layout -> setVar('print',1);			
    $Layout -> setVar('puc',$this -> puc);
		
	//$this -> HTMLcode = $Layout -> fetch('plancuentas.tpl');		
	
	//$Layout -> htmlToPdf($this -> HTMLcode,"plan de cuentas");
	
    $Layout -> RenderLayout('plancuentas.tpl');	
	  
	  
  }  
  
  protected function PlanCuentasOnPrint(){
		require_once("PlanCuentasModelClass.php");	  
	
    	$Model    = new PlanCuentasModel();	
		
		$data = $Model -> getPlan($this -> getConex());
		
		$ruta  = $this -> arrayToExcel("Reportes","Plan_cuentas",$data,null,"string");
	
   		$this -> ForceDownload($ruta,"PLAN_CUENTAS".'.xls');
	}
    
  protected function getNodesTree($IdParent){
  
	require_once("PlanCuentasModelClass.php");	  
	
    $Model    = new PlanCuentasModel();	
	
	$children = $Model -> getChildren($IdParent,$this -> getConex());
		
	if(count($children) > 0){
	
	   $j = 0;
	   
	   for($i = 0; $i < count($children); $i++){
		 		 
   	     $this -> puc = array_merge($this -> puc,array($children[$i]));		
		 		 
	     $this -> getNodesTree($children[$i]['puc_id']);
	   }
	   
	}else{
	     return false;
	  }
  
  } 
  
  protected function setCampos(){
 
	$this -> Campos[puc_id]  = array(type=>'hidden',name=>'puc_id',id=>'puc_id',transaction=>array(table=>array('puc')
    ,type=>array('primary_key')),datatype=>array(type=>'autoincrement'));
	
	
	$this -> Campos[empresa_id]  = array(
		type=>'select',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(type=>'integer'),name=>'empresa_id',
	id=>'empresa_id',tabindex =>'2',transaction=>array(table=>array('puc'),type=>array('column')));	
	

	$this -> Campos[codigo_puc]  = array(type=>'text',required=>'yes',Boostrap => 'si',datatype=>array(type=>'integer',length	=>'8'),
	name=>'codigo_puc',id=>'codigo_puc',tabindex=> '3',transaction=>array(table=>array('puc'),type=>array('column')));
	
	$this -> Campos[nombre]  = array(type=>'text',required=>'yes',Boostrap => 'si',datatype=>array(type=>'text'),
    name=>'nombre',id=>'nombre',tabindex=> '4',transaction=>array(table=>array('puc'),type=>array('column')));
	
	$this -> Campos[puc_puc] = array(
		type=>'text',
		name=>'puc_puc',
		id=>'puc_puc',
		Boostrap => 'si',
		suggest=>array(name=>'cuentas_mayores',
    setId=>'puc_puc_id',form=>'0'),tabindex=>'5');	
	$this -> Campos[puc_puc_id] = array(type=>'hidden',name=>'puc_puc_id',id=>'puc_puc_id',
    transaction=>array(table=>array('puc'),type=>array('column')),datatype=> array(type=>'integer'));	
	
	$this -> Campos[naturaleza]  = array(
		type=>'select',
		name=>'naturaleza',
		id=>'naturaleza',
		Boostrap => 'si',
    options=> array(array(value=>'D',text=>'DEBITO',selected=>'D'),array(value=>'C',text=>'CREDITO')),
	tabindex => '6',transaction=>array(table=>array('puc'),type=>array('column')),datatype=> array(type=>'alpha'),required=>'yes');	
	  	 		
	$this -> Campos[nivel]  = array(
		type=>'text',
		name=>'nivel',
		id=>'nivel',
		Boostrap => 'si',
		tabindex => '7',disabled=>'yes',transaction=>array(table=>array('puc'),
    type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');			
		
	$this -> Campos[movimiento]  = array(
		type=>'select',
		name=>'movimiento',
		id=>'movimiento',
		disabled=>'yes',
		Boostrap => 'si',
    options=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),tabindex => '8',
	transaction=>array(table=>array('puc'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');		 			
	
	$this -> Campos[requiere_centro_costo]  = array(
		type=>'select',
		disabled=>'yes',
		Boostrap => 'si',
		datatype=>array(type=>'integer',length=>'1')
    ,name=>'requiere_centro_costo',id=>'requiere_centro_costo',options=>array(array(value=>'0',text=>'NO',selected=>'0'),
	array(value=>'1',text=>'SI')),tabindex => '9',transaction=>array(table=>array('puc'),type=>array('column')));
		 	
	$this -> Campos[requiere_tercero]  = array(type=>'select',disabled=>'yes',Boostrap => 'si',datatype=>array(type=>'integer',length=>'1'),
    name=>'requiere_tercero',id=>'requiere_tercero',options=>array(array(value=>'0',text=>'NO',selected=>'0'),
    array(value=>'1',text=>'SI')),tabindex => '10',transaction=>array(table=>array('puc'),type=>array('column')));
	
	$this -> Campos[requiere_sucursal]  = array(
		type=>'select',
		disabled=>'yes',
		datatype=>array(type=>'integer',length=>'1'),
		name=>'requiere_sucursal',
		Boostrap => 'si',
		id=>'requiere_sucursal',
		required => 'yes',
		options=>array(array(value=>'0',text=>'NO',selected=>'0'), array(value=>'1',text=>'SI')),
		tabindex => '11',
		transaction=>array(table=>array('puc'),type=>array('column'))
	);	

	$this -> Campos[corriente]  = array(
		type=>'select',
		name=>'corriente',id=>'corriente',
		Boostrap => 'si',
    options=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),tabindex => '12',
	transaction=>array(table=>array('puc'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');		
	
	$this -> Campos[contrapartida]  = array(
		type=>'select',
		name=>'contrapartida',id=>'contrapartida',
		Boostrap => 'si',
    options=> array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),tabindex => '12',
	transaction=>array(table=>array('puc'),type=>array('column')),datatype=> array(type=>'integer'),required=>'yes');		
	
	
	$this -> Campos[activo] = array(
		name	=>'estado',
		id		=>'activo',
		type	=>'radio',
		 value	=>'A',
		checked	=>'checked',
		tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('puc'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado',
		id		=>'inactivo',
		type	=>'radio',
		 value	=>'I',
		tabindex=>'14',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('puc'),
			type	=>array('column'))
	);
		
 
	$this -> Campos[guardar] = array(type=>'button',name=>'guardar',id=>'guardar',tabindex => 
	 '15',value=>'Guardar','property'=>array(name=>'save_ajax',onsuccess=>'PlanCuentasOnSaveUpdate'));
	 
 	$this -> Campos[actualizar] = array(type=>'button',name=>'actualizar',id=>'actualizar',tabindex => 
	 '16','property'=>array(name=>'update_ajax',onsuccess=>'PlanCuentasOnSaveUpdate'),value=>'Actualizar','disabled'=>'true');
	 
  	$this -> Campos[borrar] = array(type=>'button',name=>'borrar',id=>'borrar',tabindex => 
	 '17','property'=>array(name=>'delete_ajax',onsuccess=>'PlanCuentasOnDelete'),value=>'Borrar','disabled'=>'true');
	
	$this -> Campos[imprimir] = array(type=>'button',name=>'imprimir',id=>'imprimir',tabindex => 
	 '18',value=>'Descargar',onclick=>'PlanCuentasOnPrint()');
	 
   	$this -> Campos[limpiar] = array(type=>'reset',name=>'limpiar',id=>'limpiar',tabindex => 
	 '20',value=>'Limpiar',onclick=>'PlanCuentasOnClear()');


   	$this -> Campos[busqueda] = array(type=>'text',name=>'busqueda',Boostrap => 'si',id=>'busqueda',tabindex => 
	 '1',value=>'',size=>'85',placeholder=>'ESCRIBA EL C&Oacute;DIGO O NOMBRE DE LA CUENTA CONTABLE',suggest=>array(name=>'cuentas_puc',onclick=>'LlenarFormPlanCuentas',setId=>'puc_id'));
	
		 
	$this -> SetVarsValidate($this -> Campos);
	}

}
$PlanCuentas = new PlanCuentas();
?>