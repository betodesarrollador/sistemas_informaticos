<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class SolicServToGuiaPaqueteo extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("SolicAnulToSolicitudLayoutClass.php");
			require_once("SolicAnulToSolicitudModelClass.php");

			$Layout = new SolicAnulToSolicitudLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new SolicAnulToSolicitudModel();

			$Layout -> setIncludes();
			$Layout -> setCampos($this -> Campos);

			//// GRID ////
			$Attributes = array(
				id			=>'SolicAnulToSolicitud',
				title		=>'SolicAnulToSolicitud',
				sortname	=>'link',
				width		=>'800',
				height		=>'250'
			);

			$Cols = array(
				array(name=>'solicitud_id',	index=>'solicitud_id',	sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'fecha_ss',		index=>'fecha_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'cliente',		index=>'cliente',		sorttype=>'text',	width=>'350',	align=>'center'),
				array(name=>'numero_guias',			index=>'guia',			sorttype=>'text',	width=>'90',	align=>'center')
			);

			$Titles =
			array('&nbsp;','SOLICITUD','FECHA','CLIENTE','GUIAS'
			);
			$solicitud_id	= $_REQUEST['solicitud_id'];
			$desde		= $_REQUEST['fecha_inicial'];
			$hasta		= $_REQUEST['fecha_final'];
			$Layout -> SetGridSolicAnulToSolicitud($Attributes,$Titles,$Cols,$Model -> getQuerySolicAnulToSolicitudGrid($solicitud_id,$desde,$hasta));
			$Layout -> RenderMain();
		}

		protected function setSolicitud(){

			require_once("SolicAnulToSolicitudModelClass.php");
			$Model          = new SolicAnulToSolicitudModel();
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
				value	=>'Importar',
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}

	$SolicAnulToSolicitud= new SolicAnulToSolicitud();

?>