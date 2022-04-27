<?php
require_once("../../../framework/clases/ControlerClass.php");

final class InicialManifiestos extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("InicialManifiestosLayoutClass.php");
	require_once("InicialManifiestosModelClass.php");
	
	$Layout = new InicialManifiestosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new InicialManifiestosModel();
    
     $Layout -> setIncludes();
	 
	//// GRID MANIFIESTOS PENDIENTES POR APROBAR ////
	$Attributes = array(
	  id        =>'Manifiestos',
	  title     =>'Manifiestos Pendientes Por Reportar',
	  sortname  =>'manifiesto',
	   width	=>'550',
	  height	=>'200'
	);
	
	$Cols = array(
	  array(name=>'manifiesto',      		index=>'manifiesto',      		sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'fecha_mc',        		index=>'fecha_mc',        		sorttype=>'text', width=>'120', align=>'center'),
	  array(name=>'estado',          		index=>'estado',          		sorttype=>'text', width=>'100', align=>'center'),	  
	  array(name=>'origen',          		index=>'origen',          		sorttype=>'text', width=>'150', align=>'center'),
	  array(name=>'destino',         		index=>'destino',         		sorttype=>'text', width=>'80',  align=>'center'),
	  array(name=>'placa',           		index=>'placa',           		sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'placa_remolque',  		index=>'placa_remolque',  		sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'valor_flete',     		index=>'valor_flete',     		sorttype=>'text', width=>'100', align=>'center')	  
	);
	

    $Titles = array('MANIFIESTO','FECHA','ESTADO','ORIGEN','DESTINO','PLACA','REMOLQUE','FLETE');

	$Layout -> SetGridManifiestos($Attributes,$Titles,$Cols,$Model -> getQueryManifiestosGrid());
	
	
	//// GRID MANIFIESTOS PENDIENTES POR CUMPLIR ////

	$Attributes = array(
	  id		=>'Manifiestos1',
	  title     =>'Manifiestos Pendientes Por Cumplir',
	  sortname  =>'manifiesto',
	   width	=>'550',
	  height    =>'200'
	);
	
	$Cols = array(
	  array(name=>'manifiesto',      		index=>'manifiesto',      		sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'fecha_mc',        		index=>'fecha_mc',        		sorttype=>'text', width=>'120', align=>'center'),
	  array(name=>'estado',          		index=>'estado',          		sorttype=>'text', width=>'100', align=>'center'),	  
	  array(name=>'origen',          		index=>'origen',          		sorttype=>'text', width=>'150', align=>'center'),
	  array(name=>'destino',         		index=>'destino',         		sorttype=>'text', width=>'80',  align=>'center'),
	  array(name=>'placa',           		index=>'placa',           		sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'placa_remolque',  		index=>'placa_remolque',  		sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'valor_flete',     		index=>'valor_flete',     		sorttype=>'text', width=>'100', align=>'center')	  
	);
	

    $Titles = array('MANIFIESTO','FECHA','ESTADO','ORIGEN','DESTINO','PLACA','REMOLQUE','FLETE');

	$Layout -> SetGridManifiestos1($Attributes,$Titles,$Cols,$Model -> getQueryManifiestosGrid1());


	//// GRID MANIFIESTOS MANIPULACION DE ALIMENTOS ////

	$Attributes = array(
	  id		=>'conductores',
	  title     =>'Vencimiento Carnet Manipulacion de Alimentos Para Conductores',
	  sortname	=>'numero_identificacion',
	   width	=>'550',
	  height    =>'200'
	);
	
	$Cols = array(
      array(name=>'carnet_manipulacion_alimentos', index=>'carnet_manipulacion_alimentos', sorttype=>'date',	width=>'100',	align=>'center'),
      array(name=>'numero_identificacion',		   index=>'numero_identificacion',		   sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'primer_apellido',			   index=>'primer_apellido',			   sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'segundo_apellido',			   index=>'segundo_apellido',			   sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'primer_nombre',				   index=>'primer_nombre',				   sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'segundo_nombre',				   index=>'segundo_nombre',			       sorttype=>'text',	width=>'100',	align=>'center'),
     
    );
    $Titles = array('VENC. MANIPULACION DE ALIMENTOS',
				    'IDENTIFICACION',
				    'PRIMER APELLIDO',
				    'SEGUNDO APELLIDO',
				    'PRIMER NOMBRE',
				    'SEGUNDO NOMBRE'
    );
    $Layout -> SetGridVencimientoManipulacionAlimentos($Attributes,$Titles,$Cols,$Model -> getQueryVencimientoManipulacionAlimentosGrid());

	
	$Layout -> RenderMain();    
  }  
  
	protected function ProximosVencer(){

		require_once("InicialManifiestosModelClass.php");
		$Model = new InicialManifiestosModel();
		
		$result = $Model -> SelectVencimientos($this -> getConex());
		
		if($Model -> GetNumError() > 0){
		exit("false");
		}else{
		$this -> getArrayJSON($result);
		}	
	}
  
  
}

new InicialManifiestos();

?>