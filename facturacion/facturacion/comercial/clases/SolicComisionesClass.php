<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicComisiones extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicComisionesLayoutClass.php");
    require_once("SolicComisionesModelClass.php");
	
	$Layout = new SolicComisionesLayout();
    $Model  = new SolicComisionesModel();
    $comercial_id 					= $_REQUEST['comercial_id'];
		
	$Layout -> setIncludes();

	
	$Layout -> SetCampos($this -> Campos);
	
//// GRID ////

	$Attributes = array(
	  id		=>'SolicComisiones',
	  title		=>'Comisiones',
	  sortname	=>'fecha_inicio',
	  width		=>'800',
	  height	=>'170',
	  rowList	=>'500,800,1000,2000,2500',
	  rowNum	=>'100'//, // numero maximo de registros por pagina en el grid
	);
	$Cols = array(
	  array(name=>'link',      		        index=>'link',      		        sorttype=>'text',	width=>'20',	align=>'center'),
      array(name=>'fecha_inicio',      		index=>'fecha_inicio',      		sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'fecha_final',      		index=>'fecha_final',      			sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'cliente',      	        index=>'cliente',      		        sorttype=>'text',	width=>'250',	align=>'left'),
	  array(name=>'valor_neto_pagar',		index=>'valor_neto_pagar',  		sorttype=>'int',	width=>'120',	align=>'right', format => 'currency'),
      array(name=>'tipo',      	            index=>'tipo',      		        sorttype=>'text',	width=>'60',	align=>'left')
 
	);
	$Titles =  array('','FECHA INICIO','FECHA FINAL','CLIENTE','VALOR A PAGAR', 'TIPO');
	  
    
	$Layout -> SetGridSolicComisiones($Attributes,$Titles,$Cols,$Model -> getQuerySolicComisionesGrid($comercial_id));
    $Layout -> RenderMain();
    
  }
  

  protected function SetCampos(){


	//botones
	$this -> Campos[adicionar] = array(
		name	=>'adicionar',
		id		=>'adicionar',
		type	=>'button',
		value=>'ADICIONAR',
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicComisiones = new SolicComisiones();

?>