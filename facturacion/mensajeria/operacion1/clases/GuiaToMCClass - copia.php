<?php

require_once("../../../framework/clases/ControlerClass.php");

final class GuiaToMC extends Controler{

  public function __construct(){
    parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
   	
	require_once("GuiaToMCLayoutClass.php");
    require_once("GuiaToMCModelClass.php");
	
	$Layout = new GuiaToMCLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new GuiaToMCModel();
	
    $Layout -> setIncludes();
	
	$Layout -> setCampos($this -> Campos);
	
//// GRID ////
	$Attributes = array(
	  id		=>'GuiaToMC',
	  title		=>'Guias',
	  sortname	=>'destino',
	  width		=>'800',
	  height	=>'150',
	  rowList	=>'30,60,90,120,150,180,210,240,270,300', // numero de registros que podra ver el usuario por pagina segun seleccione  de la lista que se genera a partir de este parametro
	  rowNum	=>'30'//, // numero maximo de registros por pagina en el grid
	  //multiSelect    => 'true',//atributo que genera automaticamente los checkbox con los que se seleccionan los registros
	  //getRowSelected => 'getSeguimientoSelected', // funcion definida por el usuario para obtener los valores de las filas seleccionadas [ver seguimientotransito.js]
	  //rowId          =>'seguimiento_id'	 // nombre del campo en el select cuyo valor sera asignado al ID de cada una de las filas del jqGrid 
	);
	$Cols = array(
	  array(name=>'link',      		index=>'link',      	sorttype=>'text',	width=>'35',	align=>'center', sortable =>'false'),
	  array(name=>'guia',    		index=>'guia',   		sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'remitente',  	index=>'remitente',   	sorttype=>'text',	width=>'200',	align=>'rigth'),
	  array(name=>'destino',   		index=>'destino',   	sorttype=>'text',	width=>'210',	align=>'rigth'),
	  array(name=>'destinatario', 	index=>'destinatario', 	sorttype=>'text',	width=>'150',	align=>'rigth'),
	  array(name=>'fecha',     		index=>'fecha',     	sorttype=>'text',	width=>'80',	align=>'center')
	);
    $Titles = array('&nbsp;',
					'GUIA',
					'REMITENTE',
					'DESTINO',
					'DESTINATARIO',
					'FECHA GUIA'
	);
	
	$Layout -> SetGridGuiaToMC($Attributes,$Titles,$Cols,$Model -> getQueryGuiaToMCGrid($this -> getOficinaId()));	
	$Layout -> RenderMain();    
  }  

  protected function onclickSave(){  
    require_once("DetallesGuiaToMCModelClass.php");
    $Model = new DetallesGuiaToMCModel();	
    $return = $Model -> Save($this -> Campos,$this -> getConex());	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}
	  }	
  }  

////// PARA EL FILTRO
  protected function aplicarFiltro(){  
    require_once("GuiaToMCModelClass.php");
    $Model = new GuiaToMCModel();	
    $return = $Model -> aplicarFiltro($this -> Campos,$this -> getConex());
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}
	  }		
  }    

  protected function setCampos(){
  
	//FORMULARIO
	$this -> Campos[manifiesto_id] = array(
		name	=>'manifiesto_id',
		id		=>'manifiesto_id',
		type	=>'hidden',
//		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	
	$this -> Campos[guia_id] = array(
		name	=>'guia_id',
		id		=>'guia_id',
		type	=>'hidden',
//		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'destino_id')
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
		);
	
	$this -> Campos[departamento] = array(
		name	=>'departamento',
		id		=>'departamento',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'destino_id')
	);
	
	$this -> Campos[departamento_id] = array(
		name	=>'departamento_id',
		id		=>'departamento_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
		);	
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id	=>'fecha',
		type	=>'hidden',
		value	=>date("Y-m-d")
	);	
	
	$this -> Campos[fecha_guia] = array(
		name	=>'fecha_guia',
		id		=>'fecha_guia',
		type	=>'text',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date')
	);		
		
	//botones
	$this -> Campos[despachar] = array(
		name	=>'despachar',
		id		=>'despachar',
		type	=>'button',
		value	=>'SELECCIONAR',
	);	
	
	//botones
	$this -> Campos[aplicar_filtro] = array(
		name	=>'aplicar_filtro',
		id		=>'aplicar_filtro',
		type	=>'button',
		value	=>'APLICAR',
	);	
		
	$this -> SetVarsValidate($this -> Campos);
  }
}

$GuiaToMC = new GuiaToMC();

?>