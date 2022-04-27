<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class Correo24horasClientes extends Controler{

		public function __construct(){
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("Correo24horasClientesLayoutClass.php");
			require_once("Correo24horasClientesModelClass.php");
			$Layout = new Correo24horasClientesLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new Correo24horasClientesModel();

			$Layout -> setIncludes();

			$cliente_id        = $_REQUEST['cliente_id'];
			$Layout -> SetTipoEnvio($Model -> GetTipoEnvio($cliente_id,$this -> getConex()));
			$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));
			$Layout -> SetCliente($cliente_id);
			$Layout -> RenderMain();
		}

		protected function onclickSave(){

			require_once("Correo24horasClientesModelClass.php");
			$Model = new Correo24horasClientesModel();
			$return = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
			// echo "$return";
			if(strlen(trim($Model -> GetError())) > 0){
				exit("Error : ".$Model -> GetError());
			}else{
				exit("$return");
			}
		}

		protected function onclickUpdate(){

			require_once("Correo24horasClientesModelClass.php");
			$Model = new Correo24horasClientesModel();
			$return = $Model -> Update($this -> Campos,$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
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
			// echo "string";
			$this -> getArrayJSON($Data);
			// for ($i=0; $i < count($Data); $i++) {
			// 	echo "<br>";
			// 	print_r($Data[$i]);
			// }
		}

		//CAMPOS
		protected function setCampos(){

		}
	}
	$Correo24horasClientes = new Correo24horasClientes();
?>