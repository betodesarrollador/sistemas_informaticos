<?php

require_once("../../../framework/clases/ControlerClass.php");

final class GuiaToDU extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   	
	require_once("GuiaToDULayoutClass.php");
    require_once("GuiaToDUModelClass.php");
	
	$Layout = new GuiaToDULayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new GuiaToDUModel();
	
    $Layout -> setIncludes();	
	$Layout -> setCampos($this -> Campos);
	
//// GRID ////
	$Attributes = array(
	  id		=>'GuiaToDU',
	  title		=>'Guia',
	  sortname	=>'guia',
	  width		=>'725',
	  height	=>'200',
	  rowList	=>'50,100,150,200,250,300', // numero de registros que podra ver el usuario por pagina segun seleccione  de la lista que se genera a partir de este parametro
	  rowNum	=>'50'//, // numero maximo de registros por pagina en el grid
	  //multiSelect    => 'true',//atributo que genera automaticamente los checkbox con los que se seleccionan los registros
	  //getRowSelected => 'getSeguimientoSelected', // funcion definida por el usuario para obtener los valores de las filas seleccionadas [ver seguimientotransito.js]
	  //rowId          =>'seguimiento_id'	 // nombre del campo en el select cuyo valor sera asignado al ID de cada una de las filas del jqGrid 
	);
	$Cols = array(
	  array(name=>'link',      index=>'link',      sorttype=>'text',	width=>'30',	align=>'center'),
	  array(name=>'guia',      index=>'guia',      sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'cliente',   index=>'cliente',   sorttype=>'text',	width=>'180',	align=>'center'),
	  array(name=>'destino',   index=>'destino',   sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'mercancia', index=>'mercancia', sorttype=>'text',	width=>'160',	align=>'center'),
	  array(name=>'fecha',     index=>'fecha',     sorttype=>'text',	width=>'80',	align=>'center')
	);
    $Titles = array('&nbsp;',
					'GUIA',
					'CLIENTE',
					'DESTINO',
					'DESC MERCANCIA',
					'FECHA GUIA'
	);
	
	$Layout -> SetGridGuiaToDU($Attributes,$Titles,$Cols,$Model -> getQueryGuiaToDUGrid($this -> getOficinaId()));
	
	$Layout -> RenderMain();    
  }  

  protected function onclickSave(){  
    require_once("GuiaToDUModelClass.php");
    $Model = new GuiaToDUModel();
	
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

  protected function setCampos(){
  
	//FORMULARIO
	$this -> Campos[despachos_urbanos_id] = array(
		name	=>'despachos_urbanos_id',
		id		=>'despachos_urbanos_id',
		type	=>'hidden',
//		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	
	$this -> Campos[guia_id] = array(
		name	=>'guia_id',
		id		=>'guia_id',
		type	=>'hidden',
//		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
		
	//botones
	$this -> Campos[despachar] = array(
		name	=>'despachar',
		id		=>'despachar',
		type	=>'button',
		value   =>'SELECCIONAR',
	);
			
	$this -> SetVarsValidate($this -> Campos);
  }
}

$GuiaToDU = new GuiaToDU();

?>