<?php
require_once("../../../framework/clases/ControlerClass.php");

final class InicialMensajeria extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("InicialMensajeriaLayoutClass.php");
	require_once("InicialMensajeriaModelClass.php");
	
	$Layout = new InicialMensajeriaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new InicialMensajeriaModel();
    
     $Layout -> setIncludes();
	 
	//// GRID MANIFIESTOS PENDIENTES POR APROBAR ////
	$Attributes = array(
	  id=>'Mensajeria',
	  title=>'Guias Pendientes Por Entregar',
	  sortname=>'numero_guia DESC',
	  width=>'auto',
	  rowNum=>'40',
	  rowList=>'50,100,150',
	  height=>'400'
	);
	
	$Cols = array(
	  array(name=>'numero_guia',      	index=>'numero_guia',      		sorttype=>'text', width=>'80', align=>'center'),
	  array(name=>'fecha_guia',        	index=>'fecha_guia',        	sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'remitente',        	index=>'remitente',        		sorttype=>'text', width=>'120', align=>'left'),	  
	  array(name=>'origen',        		index=>'origen',        		sorttype=>'text', width=>'120', align=>'center'),
	  array(name=>'destinatario',       index=>'destinatario',        	sorttype=>'text', width=>'120', align=>'left'),	  	  
	  array(name=>'destino',        	index=>'destino',        		sorttype=>'text', width=>'120', align=>'center'),
	  array(name=>'oficina',        	index=>'oficina',        		sorttype=>'text', width=>'120', align=>'center'),	  
	  array(name=>'estado',        		index=>'estado',        		sorttype=>'text', width=>'120', align=>'center')	  
	);
	

    $Titles = array('NO. GUIA','FECHA','REMITENTE','ORIGEN','DESTINATARIO','DESTINO','OFICINA','ESTADO');

    $Layout -> SetGridMensajeria($Attributes,$Titles,$Cols,$Model -> getQueryMensajeriaGrid($this -> getOficinaId()));

	$Layout -> RenderMain();    
  }  
  
}

new InicialMensajeria();

?>