<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RemesaToDU extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   	
	require_once("RemesaToDULayoutClass.php");
    require_once("RemesaToDUModelClass.php");
	
	$Layout = new RemesaToDULayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesaToDUModel();
	
    $Layout -> setIncludes();
	
	$Layout -> setCampos($this -> Campos);
	
//// GRID ////
	$Attributes = array(
	  id		=>'RemesaToDU',
	  title		=>'Remesas',
	  sortname	=>'remesa',
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
	  array(name=>'remesa',    index=>'remesa',    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'cliente',   index=>'cliente',   sorttype=>'text',	width=>'180',	align=>'center'),
	  array(name=>'destino',   index=>'destino',   sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'mercancia', index=>'mercancia', sorttype=>'text',	width=>'160',	align=>'center'),
	  array(name=>'fecha',     index=>'fecha',     sorttype=>'text',	width=>'80',	align=>'center')
	);
    $Titles = array('&nbsp;',
					'REMESA',
					'CLIENTE',
					'DESTINO',
					'DESC MERCANCIA',
					'FECHA REMESA'
	);
	
	$Layout -> SetGridRemesaToDU($Attributes,$Titles,$Cols,$Model -> getQueryRemesaToDUGrid($this -> getOficinaId()));
	
	$Layout -> RenderMain();
    
  }
  

  protected function onclickSave(){
  
    require_once("RemesaToDUModelClass.php");
    $Model = new RemesaToDUModel();
	
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
	
	$this -> Campos[remesa_id] = array(
		name	=>'remesa_id',
		id		=>'remesa_id',
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

$RemesaToDU = new RemesaToDU();

?>