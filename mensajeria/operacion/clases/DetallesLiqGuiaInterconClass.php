<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesLiqGuiaIntercon extends Controler{

	public function __construct(){
	parent::__construct(3);
	}

	public function Main(){

		$this -> noCache();
		require_once("DetallesLiqGuiaInterconLayoutClass.php");
		require_once("DetallesLiqGuiaInterconModelClass.php");

		$Layout = new DetallesLiqGuiaInterconLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new DetallesLiqGuiaInterconModel();
		$Layout -> setIncludes();
		if($_REQUEST[previsual]=='si'){
			if($_REQUEST[guias_interconexion_id]=='todas'){
				$Layout -> setDetallesGuiasVisual($Model -> getDetallesGuiasVisual($_REQUEST[cliente_id],$_REQUEST[desde],$_REQUEST[hasta],$this -> getConex()));
			}else{
				$Layout -> setDetallesGuiasVisual($Model -> getDetallesGuiasVisualGuia($_REQUEST[guias_interconexion_id],$_REQUEST[cliente_id],$_REQUEST[desde],$_REQUEST[hasta],$this -> getConex()));
				
			}
		}else{
			$Layout -> setDetallesGuias($Model -> getDetallesGuias($_REQUEST[liquidacion_guias_interconexion_id],$this -> getConex()));
			
		}
		$Layout -> RenderMain();
	}
}

$DetallesLiqGuiaIntercon = new DetallesLiqGuiaIntercon();
?>