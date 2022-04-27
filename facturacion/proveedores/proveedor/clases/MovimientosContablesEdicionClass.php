<?php

require_once("../../../framework/clases/ControlerClass.php");

final class MovimientosContablesEdicion extends Controler{

  public function __construct(){
  
	
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("MovimientosContablesEdicionLayoutClass.php");
    require_once("MovimientosContablesEdicionModelClass.php");
		
	$Layout = new MovimientosContablesEdicionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new MovimientosContablesEdicionModel();	
	
    $Layout -> setIncludes();
	
	
	//// GRID ////
	$Attributes = array(
	  id		     =>'registros_contables_edicion_id',
	  title		     =>'Registros Contables Edicion',
	  sortname	     =>'fecha',
	  sortorder      =>'desc',
	  width		     =>'auto',
	  height	     =>'auto',
	  rowList        =>'20,40,60,80', // numero de registros que podra ver el usuario por pagina segun seleccione  de la lista que se genera a partir de este parametro
	  rowNum         =>'10'//, // numero maximo de registros por pagina en el grid
	  //multiSelect    => 'true',//atributo que genera automaticamente los checkbox con los que se seleccionan los registros
	  //getRowSelected => 'getSeguimientoSelected', // funcion definida por el usuario para obtener los valores de las filas seleccionadas [ver MovimientosContablesEdicion.js]
	  //rowId          =>'seguimiento_id'	 // nombre del campo en el select cuyo valor sera asignado al ID de cada una de las filas del jqGrid 
	);
	
	$Cols = array(
	  array(name=>'encabezado_registro_id',index=>'encabezado_registro_id',sorttype=>'text',	width=>'50',	align=>'center'),				  
	  array(name=>'empresa',               index=>'empresa',               sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'oficina_codigo',        index=>'oficina_codigo',        sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'oficina_nombre',        index=>'oficina_nombre',        sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'documento',             index=>'documento',             sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'consecutivo',           index=>'consecutivo',           sorttype=>'text',	width=>'50',	align=>'center'),	  
	  array(name=>'forma_pago',            index=>'forma_pago',            sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'tercero',               index=>'tercero',               sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'codigo_puc',            index=>'codigo_puc',            sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'fecha',                 index=>'fecha',                 sorttype=>'text',	width=>'100',	align=>'center'),
  	  array(name=>'modifica',              index=>'modifica',              sorttype=>'text',	width=>'200',	align=>'center')	  
	);
    $Titles = array('EDITAR',
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
	
	$Layout -> SetGridMovimientosContablesEdicion($Attributes,$Titles,$Cols,$Model -> getQueryMovimientosContablesEdicionGrid());
	
		
	$Layout -> RenderMain();
    
  }


	
}

$MovimientosContablesEdicion = new MovimientosContablesEdicion();

?>