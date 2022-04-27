<?php

require_once("../../../framework/clases/ControlerClass.php");

final class OrdenCargueToGuia extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   	
    require_once("OrdenCargueToGuiaLayoutClass.php");
    require_once("OrdenCargueToGuiaModelClass.php");
	
    $Layout = new OrdenCargueToGuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new OrdenCargueToGuiaModel();
	
    $Layout -> setIncludes();	
    $Layout -> setCampos($this -> Campos);
	
//// GRID ////
    $Attributes = array(
      id	    =>'OrdenCargueToGuia',
      title	    =>'Ordenes Cargue',
      sortname	=>'orden',
      width	    =>'800',
      height	=>'200'
    );

    $Cols = array(
      array(name=>'link',           index=>'link',      		sorttype=>'text',	width=>'20',	align=>'center'),
      array(name=>'cliente',        index=>'cliente',      		sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'nit',            index=>'nit',      			sorttype=>'text',	width=>'70',	align=>'center'),
      array(name=>'orden',          index=>'orden',      		sorttype=>'text',	width=>'60',	align=>'center'),
      array(name=>'origen_id',      index=>'origen_id',      	sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'destino_id',     index=>'destino_id',      	sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'remitente',      index=>'remitente',      	sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'destinatario',   index=>'destinatario',      sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'producto',       index=>'producto',      	sorttype=>'text',	width=>'150',	align=>'center'),
      array(name=>'cantidad',       index=>'cantidad',      	sorttype=>'text',	width=>'50',	align=>'center'),
      array(name=>'peso',           index=>'peso',     			sorttype=>'text',	width=>'50',	align=>'center' ),
      array(name=>'peso_volumen',   index=>'peso_volumen',      sorttype=>'text',	width=>'50',	align=>'center' , format => 'currency')
    );

    $Titles =  array('&nbsp;','CLIENTE','NIT','ORDEN','ORIGEN','DESTINO','REMITENTE','DESTINATARIO','PRODUCTO','CANTIDAD','PESO','VOLUMEN');
	
    $Layout -> SetGridOrdenCargueToGuia($Attributes,$Titles,$Cols,$Model -> getQueryOrdenCargueToGuiaGrid($this -> getOficinaId()));
	
    $Layout -> RenderMain();
    
  }
  
  protected function setOrdenCargue(){
  
    require_once("OrdenCargueToGuiaModelClass.php");
	
    $Model            = new OrdenCargueToGuiaModel();		
    $orden_cargue_id  = $_REQUEST['orden_cargue_id'];
		
    $return = $Model -> SelectOrdenCargue($orden_cargue_id,$this -> getConex());
		
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

new OrdenCargueToGuia();

?>