<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class SolicServToGuiaInd extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("SolicServToGuiaIndLayoutClass.php");
			require_once("SolicServToGuiaIndModelClass.php");

			$Layout = new SolicServToGuiaIndLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new SolicServToGuiaIndModel();

			$Layout -> setIncludes();
			$Layout -> setCampos($this -> Campos);

			//// GRID ////
			$Attributes = array(
				id			=>'SolicServToGuiaInd',
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
			$cliente_id	= $_REQUEST['cliente_id'];
			$oficina_id	= $_REQUEST['oficina_id'];			
			$desde		= $_REQUEST['desde'];
			$hasta		= $_REQUEST['hasta'];
			$Layout -> SetGridSolicServToGuiaInd($Attributes,$Titles,$Cols,$Model -> getQuerySolicServToGuiaIndGrid($cliente_id,$desde,$hasta,$oficina_id));
			$Layout -> RenderMain();
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

	$SolicServToGuiaInd = new SolicServToGuiaInd();

?>