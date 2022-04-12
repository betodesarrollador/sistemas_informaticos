<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class SolicServToGuiaPaqueteo extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("SolicServToGuiaPaqueteoLayoutClass.php");
			require_once("SolicServToGuiaPaqueteoModelClass.php");

			$Layout = new SolicServToGuiaPaqueteoLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new SolicServToGuiaPaqueteoModel();

			$Layout -> setIncludes();
			$Layout -> setCampos($this -> Campos);

			//// GRID ////
			$Attributes = array(
				id			=>'SolicServToGuiaPaqueteo',
				title		=>'Solicitudes de Servicio',
				sortname	=>'link',
				width		=>'800',
				height		=>'250'
			);

			$Cols = array(
				array(name=>'link',			index=>'link',			sorttype=>'text',	width=>'20',	align=>'center'),
				array(name=>'solicitud_id',	index=>'solicitud_id',	sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'fecha',		index=>'fecha',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'cliente',		index=>'cliente',		sorttype=>'text',	width=>'350',	align=>'center'),
				array(name=>'nit',			index=>'nit',			sorttype=>'text',	width=>'70',	align=>'center'),
				array(name=>'guia',			index=>'guia',			sorttype=>'text',	width=>'90',	align=>'center')
			);

			$Titles =
			array('&nbsp;','SOLICITUD','FECHA','CLIENTE','NIT','GUIAS'
			);
			$cliente_id	= $_REQUEST['cliente_id'];
			$desde		= $_REQUEST['fecha_inicial'];
			$hasta		= $_REQUEST['fecha_final'];
			$Layout -> SetGridSolicServToGuiaPaqueteo($Attributes,$Titles,$Cols,$Model -> getQuerySolicServToGuiaPaqueteoGrid($cliente_id,$desde,$hasta));
			$Layout -> RenderMain();
		}

		protected function setSolicitud(){

			require_once("SolicServToGuiaPaqueteoModelClass.php");
			$Model          = new SolicServToGuiaPaqueteoModel();
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

	$SolicServToGuiaPaqueteo = new SolicServToGuiaPaqueteo();

?>