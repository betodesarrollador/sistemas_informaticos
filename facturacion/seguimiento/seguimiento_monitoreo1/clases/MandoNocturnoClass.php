<?php

require_once("../../../framework/clases/ControlerClass.php");

final class MandoNocturno extends Controler{

  public function __construct(){
    
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("MandoNocturnoLayoutClass.php");
	require_once("MandoNocturnoModelClass.php");
	
	$Layout = new MandoNocturnoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new MandoNocturnoModel();
    
     $Layout -> setIncludes();
	
	
	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'MandoNocturno',
	  title		=>'Tr&aacute;fico',
	  sortname	=>'destino',	  
	  width		=>'auto',
	  height	=>'auto',
	  rowList =>'20,40,60,80,100,120,140,160,180,200',
	  rowNum =>'20',
	  downloadExcel => 'false',
  	  rownumbers => 'true'
	);
	$Cols = array(
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
    $Titles = array('PLACA', 
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
	
	$Layout -> SetGridMandoNocturno($Attributes,$Titles,$Cols,$Model -> getQueryMandoNocturnoGrid());
	
	$Layout -> RenderMain();
    
  }
  
  
}

$MandoNocturno = new MandoNocturno();

?>