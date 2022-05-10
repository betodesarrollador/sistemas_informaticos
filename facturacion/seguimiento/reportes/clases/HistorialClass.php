<?php

require_once("../../../framework/clases/ControlerClass.php");
require_once("../../../framework/clases/MailClass.php");

final class Reportes extends Controler{

  public function __construct(){
    
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("HistorialLayoutClass.php");
	require_once("HistorialModelClass.php");
	
	$Layout = new ReportesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ReportesModel();
    $Layout -> setIncludes();
	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'Reportes',
	  title		=>'Historial de Reportes',
	  sortname	=>'fecha',
	  width		=>'1020',
	  height	=>380
	);
	$Cols = array(
	  array(name=>'fecha',			index=>'fecha',			sorttype=>'text',	width=>'70',	align=>'center'),
	  array(name=>'hora',			index=>'hora',			sorttype=>'text',	width=>'70',	align=>'center'),
	  array(name=>'cliente',		index=>'cliente',		sorttype=>'text',	width=>'340',	align=>'center'),
	  array(name=>'minuto',			index=>'minuto',		sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'horas',			index=>'horas',			sorttype=>'text',	width=>'110',	align=>'center'),
      array(name=>'dias',			index=>'dias',			sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'con_registros',	index=>'con_registros',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'enviado',		index=>'enviado',		sorttype=>'text',	width=>'80',	align=>'center'),
      array(name=>'archivo',		index=>'archivo',		sorttype=>'text',	width=>'80',	align=>'center')
	);
    $Titles = array('FECHA',
					'HORA',
					'CLIENTE',
					'MINUTO',
					'HORAS',
					'DIAS',
					'POSEE REGISTROS',
					'ENVIADO',
					'ARCHIVO'
	);
	$Layout -> SetGridReportes($Attributes,$Titles,$Cols,$Model -> getQueryReportesGrid());
	$Layout -> RenderMain();
    
  }
  
  
}

$Reportes = new Reportes();

?>