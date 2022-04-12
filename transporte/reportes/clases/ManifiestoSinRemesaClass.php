<?php

require_once("../../../framework/clases/ControlerClass.php");

final class MovimientosContablesContabilizados extends Controler{

  public function __construct(){
  
	
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("ManifiestoSinRemesaLayoutClass.php");
    require_once("ManifiestoSinRemesaModelClass.php");
		
	$Layout = new MovimientosContablesContabilizadosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new MovimientosContablesContabilizadosModel();	
	
    $Layout -> setIncludes();
	
	
	//// GRID ////
	$Attributes = array(
	  id		     =>'manifiestos_sin_remesa_id',
	  title		     =>'Manifiestos/Despachos Urbanos sin Remesas',
	  sortname	     =>'fecha',
	  sortorder      =>'desc',
	  width		     =>'auto',
	  height	     =>'500',
	  rowList        =>'20,40,60,80', // numero de registros que podra ver el usuario por pagina segun seleccione  de la lista que se genera a partir de este parametro
	  rowNum         =>'10'//, // numero maximo de registros por pagina en el grid
	  //multiSelect    => 'true',//atributo que genera automaticamente los checkbox con los que se seleccionan los registros
	  //getRowSelected => 'getSeguimientoSelected', // funcion definida por el usuario para obtener los valores de las filas seleccionadas [ver MovimientosContablesContabilizados.js]
	  //rowId          =>'seguimiento_id'	 // nombre del campo en el select cuyo valor sera asignado al ID de cada una de las filas del jqGrid 
	);
	
	$Cols = array(
	  //array(name=>'despachos_urbanos_id',  	index=>'despachos_urbanos_id',	sorttype=>'text',	width=>'50',	align=>'center'),				  
	  array(name=>'numero_planilla',        			index=>'numero_planilla',      				sorttype=>'text',	width=>'130',	align=>'center'),
	  array(name=>'tipo',        						index=>'tipo',      						sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'oficina',        					index=>'oficina',        					sorttype=>'text',	width=>'140',	align=>'center'),
	  array(name=>'conductor',        					index=>'conductor',        					sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'numero_identificacion_conductor',	index=>'numero_identificacion_conductor',   sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'tenedor',           					index=>'tenedor',          					sorttype=>'text',	width=>'200',	align=>'center'),	  
	  array(name=>'numero_identificacion_tenedor',      index=>'numero_identificacion_tenedor',     sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'propio',               				index=>'propio',               				sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'estado',            					index=>'estado',            				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'fecha',                 				index=>'fecha',                 			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'origen',                 			index=>'origen',                 			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',              				index=>'destino',	              			sorttype=>'text',	width=>'110',	align=>'center'),	  
	  array(name=>'numero_anticipos',              		index=>'numero_anticipos',	       			sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array(
					//'EDITAR',
	                'NUMERO PLANILLA',
	                'TIPO',
					'OFICINA',
					'CONDUCTOR',
					'CEDULA CONDUCTOR',
					'TENEDOR',
					'CEDULA TENEDOR',
					'PROPIO',
					'ESTADO',
					'FECHA',
					'ORIGEN',
					'DESTINO',
					'ANTICIPOS'
	);
	
	$Layout -> SetGridQueryManifiestoSinRemesa($Attributes,$Titles,$Cols,$Model -> getQueryManifiestoSinRemesaGrid());
	
		
	$Layout -> RenderMain();
    
  }


	
}

$MovimientosContablesContabilizados = new MovimientosContablesContabilizados();

?>