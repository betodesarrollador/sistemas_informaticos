<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicServToOrden extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
   	
    require_once("SolicServToOrdenLayoutClass.php");
    require_once("SolicServToOrdenModelClass.php");
	
    $Layout = new SolicServToOrdenLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new SolicServToOrdenModel();
	
    $Layout -> setIncludes();	
    $Layout -> setCampos($this -> Campos);
	
//// GRID ////
    $Attributes = array(
      id	=>'SolicServToOrden',
      title	=>'Solicitudes de Servicio',
      sortname	=>'fecha',
	  sortorder =>'desc',
      width	=>'800',
      height	=>'200'
    );

    $Cols = array(
      array(name=>'link',           index=>'link',      sorttype=>'text',	width=>'20',	align=>'center'),
      array(name=>'proveedor',      index=>'proveedor',      sorttype=>'text',	width=>'170',	align=>'center'),
      array(name=>'nit',            index=>'nit',      sorttype=>'text',	width=>'90',	align=>'center'),
      array(name=>'fecha',      	index=>'fecha',      sorttype=>'date',	width=>'80',	align=>'center'),
      array(name=>'orden_compra', 	index=>'orden_compra',      sorttype=>'text',	width=>'40',	align=>'center'),
      array(name=>'desc_item_pre_orden_compra',     index=>'desc_item_pre_orden_compra',      sorttype=>'text',	width=>'170',	align=>'center' ),
	  array(name=>'cant_item_pre_orden_compra',     index=>'cant_item_pre_orden_compra',      sorttype=>'int',	width=>'40',	align=>'center'),
      array(name=>'valoruni_item_pre_orden_compra', index=>'valoruni_item_pre_orden_compra',      sorttype=>'text',	width=>'90',	align=>'center', format =>'currency')
    );

    $Titles =  
      array('&nbsp;','PROVEEDOR','NIT','FECHA','SOLICITUD','ITEM','CANT','VALOR'
    );
	
    $Layout -> SetGridSolicServToOrden($Attributes,$Titles,$Cols,$Model -> getQuerySolicServToOrdenGrid($this -> getOficinaId()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function setSolicitud(){
  
    require_once("SolicServToOrdenModelClass.php");
	
    $Model          = new SolicServToOrdenModel();		
    $solicitud_id   = $_REQUEST['solicitud_id'];
    $detalles_ss_id = $_REQUEST['detalles_ss_id'];
		
    $return = $Model -> SelectSolicitud($detalles_ss_id,$solicitud_id,$this -> getConex());
	
    if(count($return) > 0){		
      $this -> getArrayJSON($return);	
    }else{
	     exit('false');
       }
  
  }
  

  protected function setCampos(){
		
	//botones
	$this -> Campos[remesar] = array(
		name	=>'remesar',
		id		=>'remesar',
		type	=>'button',
		value=>'Importar',
	);
	
	
	$this -> Campos[catidad] = array(
		name	=>'catidad',
		id		=>'catidad',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'integer')
	);		
	
	$this -> Campos[peso] = array(
		name	=>'peso',
		id		=>'peso',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', precision=>'2')
	);	
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		id		=>'peso_volumen',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', precision=>'3')
	);			
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicServToOrden = new SolicServToOrden();

?>