<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class RutasEspeciales extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("RutasEspecialesLayoutClass.php");
			require_once("RutasEspecialesModelClass.php");
			$Layout = new RutasEspecialesLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new RutasEspecialesModel();

			$Layout -> setIncludes();

			$tercero_id        = $_REQUEST['tercero_id'];
			$periodo        = $_REQUEST['periodo'];
			if(!$periodo>0){ $periodo=date("Y"); }
			$Layout -> SetConvencion($Model -> GetConvencion($tercero_id,$this -> getConex()));
			$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()),$periodo);
			$Layout -> SetCliente($tercero_id,$Model -> GetCliente($tercero_id,$this -> getConex()));
			$Layout -> RenderMain();
		}

		protected function onclickSave(){

			require_once("RutasEspecialesModelClass.php");
			$Model = new RutasEspecialesModel();
			$return = $Model -> Save($this -> getConex());
			// echo "$return";
			if(strlen(trim($Model -> GetError())) > 0){
				exit("Error : ".$Model -> GetError());
			}else{
				exit("$return");
			}
		}

		protected function onclickUpdate(){

			require_once("RutasEspecialesModelClass.php");
			$Model = new RutasEspecialesModel();
			$return = $Model -> Update($this -> Campos,$this -> getConex());
			// echo "$return";
			if(strlen(trim($Model -> GetError())) > 0){
				exit("Error : ".$Model -> GetError());
			}else{
				exit("$return");
			}
		}

		protected function OnClickFind(){

			require_once("Correo24horasClientesModelClass.php");
			$Model = new Correo24horasClientesModel();

			$periodo_contable_id	=	$_REQUEST['periodo_contable_id'];
			$cliente_id				=	$_REQUEST['cliente_id'];
			$tipo_envio_id				=	$_REQUEST['tipo_envio_id'];
			$Data = $Model -> FindTarifa($tipo_envio_id,$cliente_id,$periodo_contable_id,$this -> getConex());
			$this -> getArrayJSON($Data);
		}
	}
	$RutasEspeciales = new RutasEspeciales();
?>