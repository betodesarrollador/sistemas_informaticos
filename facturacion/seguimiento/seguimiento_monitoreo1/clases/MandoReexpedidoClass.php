<?php

require_once("../../../framework/clases/ControlerClass.php");

final class MandoTrafico extends Controler{

  public function __construct(){
    
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("MandoReexpedidoLayoutClass.php");
	require_once("MandoReexpedidoModelClass.php");
	
	$Layout = new MandoTraficoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new MandoTraficoModel();
    
     $Layout -> setIncludes();
	
	
	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'MandoManifiesto',
	  title		=>'Tr&aacute;fico Manifiesto',
	  sortname	=>'destino',	  
	  width		=>'auto',
	  height	=>'auto',
	  rowList =>'20,40,60,80,100,120,140,160,180,200',
	  rowNum =>'20',
	  downloadExcel => 'false',
  	  rownumbers => 'true'
	);
	$Cols = array(
	  array(name=>'indicador',		index=>'indicador',			sorttype=>'text',	width=>'25',	align=>'left'),	 
	  array(name=>'placa',			index=>'placa',				sorttype=>'text',	width=>'50',	align=>'left'),	 				  
	  array(name=>'trafico_id',		index=>'trafico_id',		sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'estado',			index=>'estado',			sorttype=>'text',	width=>'120',	align=>'left'),
	  array(name=>'origen',			index=>'origen',			sorttype=>'text',	width=>'120',	align=>'left'),
	  array(name=>'destino',		index=>'destino',			sorttype=>'text',	width=>'120',	align=>'left'),
   	  array(name=>'clientes',		index=>'clientes',			sorttype=>'text',	width=>'200',	align=>'left'),
	  array(name=>'ult_evento',		index=>'ult_evento',		sorttype=>'text',	width=>'120',	align=>'left'),
      array(name=>'ult_punto',		index=>'ult_punto',			sorttype=>'text',	width=>'300',	align=>'left'),
	  array(name=>'conductor',		index=>'conductor',			sorttype=>'text',	width=>'180',	align=>'left'),
      array(name=>'escolta_inicia',	index=>'escolta_inicia',	sorttype=>'text',	width=>'120',	align=>'left'),
      array(name=>'escolta_fin',	index=>'escolta_fin',		sorttype=>'text',	width=>'120',	align=>'left'),
	  array(name=>'ult_obse',		index=>'ult_obse',			sorttype=>'text',	width=>'120',	align=>'left')
	);
    $Titles = array('&nbsp;',
					'PLACA', 
					'NUMERO',
					'ESTADO',
					'ORIGEN',
					'DESTINO',
					'CLIENTES',
					'ULTIMO EVENTO',
					'ULTIMO UBICACION',
					'CONDUCTOR',
					'ESCOLTA RECIBE',
					'ESCOLTA ENTREGA',
					'ULT. OBSERVACION'
					
	);
	
	$Layout -> SetGridMandoTrafico($Attributes,$Titles,$Cols,$Model -> getQueryMandoTraficoGrid());
	
	$Layout -> RenderMain();
    
  }
  
  
}

$MandoTrafico = new MandoTrafico();

?>