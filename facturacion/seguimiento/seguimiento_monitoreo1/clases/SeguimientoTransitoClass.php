<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SeguimientoTransito extends Controler{

  public function __construct(){
  
	
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("SeguimientoTransitoLayoutClass.php");
    require_once("SeguimientoTransitoModelClass.php");
		
	$Layout = new SeguimientoTransitoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new SeguimientoTransitoModel();	
	
    $Layout -> setIncludes();
	
	
	//// GRID ////
	$Attributes = array(
	  id		     =>'Seguimiento',
	  title		     =>'puestos de control',
	  sortname	     =>'seguimiento_id',
	  width		     =>'auto',
	  height	     =>'auto',
	  rowList        =>'20,40,60,80', // numero de registros que podra ver el usuario por pagina segun seleccione  de la lista que se genera a partir de este parametro
	  rowNum         =>'10'//, // numero maximo de registros por pagina en el grid
	  //multiSelect    => 'true',//atributo que genera automaticamente los checkbox con los que se seleccionan los registros
	  //getRowSelected => 'getSeguimientoSelected', // funcion definida por el usuario para obtener los valores de las filas seleccionadas [ver seguimientotransito.js]
	  //rowId          =>'seguimiento_id'	 // nombre del campo en el select cuyo valor sera asignado al ID de cada una de las filas del jqGrid 
	);
	$Cols = array(
	  array(name=>'link',           index=>'link',           sorttype=>'text',	width=>'20',	align=>'center'),				  
	  array(name=>'seguimiento_id', index=>'seguimiento_id', sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'cliente',        index=>'cliente',        sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'placa',          index=>'placa',          sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'conductor',      index=>'conductor',      sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'origen',         index=>'origen',         sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'destino',        index=>'destino',        sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'estado',         index=>'estado',         sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('NV','IR',
					'CLIENTE',
					'VEHICULO',
					'CONDUCTOR',
					'ORIGEN',
					'DESTINO',
					'ESTADO'
	);
	
	$Layout -> SetGridSeguimientoTransito($Attributes,$Titles,$Cols,$Model -> getQuerySeguimientoTransitoGrid());
	
		
	$Layout -> RenderMain();
    
  }


	
}

$SeguimientoTransito = new SeguimientoTransito();

?>