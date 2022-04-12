<?php
require_once("../../../framework/clases/ControlerClass.php");

final class SolicCierreToGuia extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){

		$this -> noCache();

		require_once("SolicCierreToGuiaLayoutClass.php");
		require_once("SolicCierreToGuiaModelClass.php");

		$Layout = new SolicCierreToGuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new SolicCierreToGuiaModel();

		$Layout -> setIncludes();
		$Layout -> setCampos($this -> Campos);

		//// GRID ////
		$Attributes = array(
			id			=>'SolicCierreToGuia',
			title		=>'Guias entregadas o en Transito',
			sortname	=>'link',
			width		=>'900',
			height		=>'230',
			rowNum =>'300',
			downloadExcel => 'false'
		);

		$Cols = array(
			array(name=>'link',			index=>'link',			sorttype=>'text',	width=>'20',	align=>'center'),
			array(name=>'numero_guia',	index=>'numero_guia',	sorttype=>'text',	width=>'70',	align=>'center'),
			array(name=>'fecha_guia',	index=>'fecha_guia',	sorttype=>'text',	width=>'70',	align=>'center'),
			array(name=>'estado_mensajeria',	index=>'estado_mensajeria',	sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'origen',	index=>'origen',	sorttype=>'text',	width=>'70',	align=>'center'),
			array(name=>'destino',	index=>'destino',	sorttype=>'text',	width=>'70',	align=>'center'),				
			array(name=>'cliente',	index=>'cliente',	sorttype=>'text',	width=>'300',	align=>'left'),
			array(name=>'nit',		index=>'nit',		sorttype=>'text',	width=>'70',	align=>'center')
		);

		$Titles =
		array('','No GUIA','FECHA','ESTADO','ORIGEN','DESTINO','CLIENTE','NIT');
		$desde		= $_REQUEST['desde'];
		$hasta		= $_REQUEST['hasta'];
		$Layout -> SetGridSolicCierreToGuia($Attributes,$Titles,$Cols,$Model -> getQuerySolicCierreToGuiaGrid($this -> getOficinaId(),$desde,$hasta));
		$Layout -> RenderMain();
	}

	  protected function onclickSave(){  
		require_once("SolicCierreToGuiaModelClass.php");
		$Model = new SolicCierreToGuiaModel();	
		$return = $Model -> Save($this -> Campos,$this -> getConex());	
		if(strlen(trim($Model -> GetError())) > 0){
		  exit("Error : ".$Model -> GetError());
		}else{
			if(is_numeric($return)){
			  exit("$return");
			}
		  }	
	  }  


	protected function setCampos(){
	//botones
		$this -> Campos[guiar] = array(
			name	=>'guiar',
			id		=>'guiar',
			type	=>'button',
			value	=>'Importar',
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}

$SolicCierreToGuia = new SolicCierreToGuia();

?>