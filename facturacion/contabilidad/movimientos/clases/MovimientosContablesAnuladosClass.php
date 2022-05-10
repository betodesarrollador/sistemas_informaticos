<?php
require_once("../../../framework/clases/ControlerClass.php");
final class MovimientosContablesAnulados extends Controler{
  public function __construct(){
  
	
	parent::__construct(3);
    
  }

  public function Main(){
  
    $this -> noCache();
    	
	require_once("MovimientosContablesAnuladosLayoutClass.php");
    require_once("MovimientosContablesAnuladosModelClass.php");
		
	$Layout = new MovimientosContablesAnuladosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new MovimientosContablesAnuladosModel();	
	
    $Layout -> setIncludes();
	
	
	//// GRID ////
	$Attributes = array(
	  id		     =>'registros_contables_edicion_id',
	  title		     =>'Registros Contables Anulados',
	  sortname	     =>'fecha',
	  sortorder      =>'desc',
	  width		     =>'auto',
	  height	     =>'auto',
	  rowList        =>'20,40,60,80', 
	  rowNum         =>'10'
	);
	
	$Cols = array(
	  array(name=>'encabezado_registro_id',index=>'encabezado_registro_id',sorttype=>'text',	width=>'100',	align=>'center'),				
	  array(name=>'empresa',               index=>'empresa',               sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'oficina_codigo',        index=>'oficina_codigo',        sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'oficina_nombre',        index=>'oficina_nombre',        sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'documento',             index=>'documento',             sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'consecutivo',           index=>'consecutivo',           sorttype=>'text',	width=>'150',	align=>'center'),	  
	  array(name=>'forma_pago',            index=>'forma_pago',            sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'tercero',               index=>'tercero',               sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'codigo_puc',            index=>'codigo_puc',            sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'fecha',                 index=>'fecha',                 sorttype=>'text',	width=>'100',	align=>'center'),
  	  array(name=>'modifica',              index=>'modifica',              sorttype=>'text',	width=>'200',	align=>'center')	  
	);
    $Titles = array('VER ANULADO',			
	                'EMPRESA',
					'OF.COD',
					'OF. NOM',
					'DOC',
					'CONS',
					'F.PAGO',
					'TERCERO',
					'PUC',
					'FECHA',
					'USUARIO'
	);
	
	$Layout -> SetGridMovimientosContablesAnulados($Attributes,$Titles,$Cols,$Model -> getQueryMovimientosContablesAnuladosGrid());
	
		
	$Layout -> RenderMain();
    
  }
  
  
  protected function viewMovimientoContableAnulado(){
  
	require_once("MovimientosContablesLayoutClass.php");
	require_once("MovimientosContablesModelClass.php");
    require_once("ImputacionesContablesModelClass.php");
	
	$Layout   = new MovimientosContablesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model_1  = new MovimientosContablesModel();	 
    $Model_2  = new ImputacionContableModel();	
	
	$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	$encabezadoRegistro     = $Model_1 -> getEncabezadoRegistroAnulado($encabezado_registro_id,$this -> getConex());
	$movimientosContables   = $Model_2 -> getImputacionesContablesAnuladas($encabezado_registro_id,$this -> getConex());
	
    $Layout -> setCssInclude("../css/movimientoscontables.css");	 	 
	 	 
    $Layout -> assign("CSSSYSTEM",	  $Layout -> getCssInclude());	
    $Layout -> setVar("ENCABEZADOID", $encabezadoRegistro[0]['encabezado_registro_id']);
    $Layout -> setVar("CONSECUTIVO",  $encabezadoRegistro[0]['consecutivo']);
    $Layout -> setVar("EMPRESA",      $encabezadoRegistro[0]['empresa']);	
    $Layout -> setVar("OFICINA",      $encabezadoRegistro[0]['oficina']);		
    $Layout -> setVar("FECHA",		  $encabezadoRegistro[0]['fecha']);
	$Layout -> setVar("CONCEPTO",	  $encabezadoRegistro[0]['concepto']);
	$Layout -> setVar("ESTADO",	      $encabezadoRegistro[0]['estado']);
	$Layout -> setVar("FECHAREGISTRO",$encabezadoRegistro[0]['fecha']);
	$Layout -> setVar("DOCUMENTO"    ,$encabezadoRegistro[0]['documento']);	
	$Layout -> setVar("VALOR"        ,$encabezadoRegistro[0]['valor']);		
	$Layout -> setVar("FPAGO"        ,$encabezadoRegistro[0]['forma_pago']);			
	$Layout -> setVar("TEXTOSOPORTE" ,$encabezadoRegistro[0]['texto_soporte']);				
	$Layout -> setVar("NUMSOPORTE"   ,$encabezadoRegistro[0]['numero_soporte']);					
	$Layout -> setVar("TEXTOTERCERO" ,$encabezadoRegistro[0]['texto_tercero']);						
	$Layout -> setVar("TERCERO"      ,$encabezadoRegistro[0]['tercero']);							
	$Layout -> setVar("PUC"          ,$encabezadoRegistro[0]['puc']);									
	
    $Layout -> setVar("IMPUTACIONES", $movimientosContables);		
	
    $Layout	-> RenderLayout('preview.tpl');
  
  
  }

	
}
$MovimientosContablesAnulados = new MovimientosContablesAnulados();
?>