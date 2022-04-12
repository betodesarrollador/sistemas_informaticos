<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class CorreoMasivoClientes extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("CorreoMasivoClientesLayoutClass.php");
			require_once("CorreoMasivoClientesModelClass.php");
			$Layout = new CorreoMasivoClientesLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new CorreoMasivoClientesModel();

			$Layout -> setIncludes();

			$TData = $Model -> GetTarifasCliente($this -> getConex());
			$cliente_id				=	$_REQUEST['cliente_id'];
			$Layout -> SetTarifas($TData);
			$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));
			$Layout -> SetCliente($cliente_id);
			$Layout -> RenderMain();
		}

		protected function onclickSave(){

			require_once("CorreoMasivoClientesModelClass.php");
			$Model = new CorreoMasivoClientesModel();
			$return = $Model -> Save($this -> getOficinaId(),$this -> getUsuarioId(),$this -> getConex());
			// echo "$return";
			if(strlen(trim($Model -> GetError())) > 0){
				exit("Error : ".$Model -> GetError());
			}else{
				exit("$return");
			}
		}

		protected function onclickUpdate(){

			require_once("CorreoMasivoClientesModelClass.php");
			$Model = new CorreoMasivoClientesModel();
			$return = $Model -> Update($this -> getOficinaId(),$this -> getUsuarioId(),$this -> getConex());
			// echo "$return";
			if(strlen(trim($Model -> GetError())) > 0){
				exit("Error : ".$Model -> GetError());
			}else{
				exit("$return");
			}
		}

		protected function OnClickFind(){
			
			require_once("CorreoMasivoClientesModelClass.php");
			$Model = new CorreoMasivoClientesModel();

			$periodo_contable_id	=	$_REQUEST['periodo_contable_id'];
			$cliente_id				=	$_REQUEST['cliente_id'];
			$tipo_envio_id			=	$_REQUEST['tipo_envio_id'];
			$TData = $Model -> FindTarifa($tipo_envio_id,$cliente_id,$periodo_contable_id,$this -> getConex());
			$this -> getArrayJSON($TData);		}
	}
	$CorreoMasivoClientes = new CorreoMasivoClientes();
?>