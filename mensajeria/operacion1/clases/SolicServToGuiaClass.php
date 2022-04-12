<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicServToGuia extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   	
    require_once("SolicServToGuiaLayoutClass.php");
    require_once("SolicServToGuiaModelClass.php");
	
    $Layout = new SolicServToGuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new SolicServToGuiaModel();
	
    $Layout -> setIncludes();	
    $Layout -> setCampos($this -> Campos);
	
//// GRID ////
    $Attributes = array(
      id	=>'SolicServToGuia',
      title	=>'Solicitudes de Servicio',
      sortname	=>'orden_despacho',
      width	=>'800',
      height	=>'200'
    );

    $Cols = array(
      array(name=>'link',           index=>'link',      sorttype=>'text',	width=>'20',	align=>'center'),
      array(name=>'cliente',        index=>'cliente',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'nit',            index=>'nit',      sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'solicitud',      index=>'solicitud',      sorttype=>'text',	width=>'60',	align=>'center'),
      array(name=>'orden_despacho', index=>'orden_despacho',      sorttype=>'text',	width=>'90',	align=>'center'),
      array(name=>'origen_id',      index=>'origen_id',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'destino_id',     index=>'destino_id',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'remitente',      index=>'remitente',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'doc_remitente',  index=>'doc_remitente',      sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'destinatario',   index=>'destinatario',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'doc_destinatario',    index=>'doc_destinatario',      sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'referencia_producto', index=>'referencia_producto',      sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'descripcion_producto',index=>'descripcion_producto',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'cantidad',            index=>'cantidad',      sorttype=>'text',	width=>'50',	align=>'center'),
      array(name=>'peso',                index=>'peso',      sorttype=>'text',	width=>'50',	align=>'center' ),
      array(name=>'peso_volumen',        index=>'peso_volumen',      sorttype=>'text',	width=>'50',	align=>'center' , format => 'currency'),
      array(name=>'valor_unidad',        index=>'valor_unidad',      sorttype=>'text',	width=>'90',	align=>'center' , format => 'currency')
    );

    $Titles =  
      array('&nbsp;','CLIENTE','NIT','SOLICTUD','ORDEN CLIENTE','ORIGEN','DESTINO','REMITENTE','NIT','DESTINATARIO','NIT','REFERENCIA','DESCRIPCION', 
	  'CANT','PESO','VOL','VAL UNIDAD'
    );
	
    $Layout -> SetGridSolicServToGuia($Attributes,$Titles,$Cols,$Model -> getQuerySolicServToGuiaGrid($this -> getOficinaId()));	
    $Layout -> RenderMain();    
  }
  
  protected function setSolicitud(){
  
    require_once("SolicServToGuiaModelClass.php");
	
    $Model          = new SolicServToGuiaModel();		
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
	$this -> Campos[guiar] = array(
		name	=>'guiar',
		id		=>'guiar',
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

$SolicServToGuia = new SolicServToGuia();

?>