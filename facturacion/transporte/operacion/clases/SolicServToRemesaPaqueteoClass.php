<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicServToRemesaPaqueteo extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
   	
    require_once("SolicServToRemesaPaqueteoLayoutClass.php");
    require_once("SolicServToRemesaPaqueteoModelClass.php");
	
    $Layout = new SolicServToRemesaPaqueteoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new SolicServToRemesaPaqueteoModel();
	
    $Layout -> setIncludes();	
    $Layout -> setCampos($this -> Campos);
	
//// GRID ////
    $Attributes = array(
      id	=>'SolicServToRemesaPaqueteo',
      title	=>'Solicitudes de Servicio',
      sortname	=>'orden_despacho',
      width	=>'800',
      height	=>'200'
    );

    $Cols = array(
      array(name=>'link',                  index=>'link',      sorttype=>'text',	width=>'20',	align=>'center'),
      array(name=>'cliente',               index=>'cliente',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'nit',                   index=>'nit',      sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'solicitud',             index=>'solicitud',      sorttype=>'text',	width=>'60',	align=>'center'),
      array(name=>'orden_despacho',        index=>'orden_despacho',      sorttype=>'text',	width=>'90',	align=>'center'),
      array(name=>'origen_id',             index=>'origen_id',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'destino_id',            index=>'destino_id',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'remitente',             index=>'remitente',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'doc_remitente',         index=>'doc_remitente',      sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'destinatario',          index=>'destinatario',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'doc_destinatario',      index=>'doc_destinatario',      sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'referencia_producto',   index=>'referencia_producto',      sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'descripcion_producto',  index=>'descripcion_producto',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'cantidad',          index=>'cantidad',      sorttype=>'text',	width=>'50',	align=>'center'),
      array(name=>'peso',              index=>'peso',      sorttype=>'text',	width=>'50',	align=>'center'),
      array(name=>'peso_volumen',      index=>'peso_volumen',      sorttype=>'text',	width=>'50',	align=>'center' , format => 'currency'),
      array(name=>'valor_unidad',      index=>'valor_unidad',      sorttype=>'text',	width=>'90',	align=>'center' , format => 'currency')
    );

    $Titles =  
      array('&nbsp;','CLIENTE','NIT','SOLICTUD','ORDEN CLIENTE','ORIGEN','DESTINO','REMITENTE','NIT','DESTINATARIO','NIT','REFERENCIA',
	  'DESCRIPCION','CANT','PESO','VOL','VAL UNIDAD'
    );
	
    $Layout -> SetGridSolicServToRemesaPaqueteo($Attributes,$Titles,$Cols,$Model -> getQuerySolicServToRemesaPaqueteoGrid($this -> getOficinaId()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function setSolicitud(){
  
    require_once("SolicServToRemesaPaqueteoModelClass.php");
	
    $Model          = new SolicServToRemesaPaqueteoModel();		
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
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicServToRemesaPaqueteo = new SolicServToRemesaPaqueteo();

?>