<?php
require_once("../../../framework/clases/ControlerClass.php");
final class DetallesLiqGuia extends Controler{

	public function __construct(){
	parent::__construct(3);
	}

	public function Main(){

		$this -> noCache();
		require_once("DetallesLiqGuiaLayoutClass.php");
		require_once("DetallesLiqGuiaModelClass.php");

		$Layout = new DetallesLiqGuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model  = new DetallesLiqGuiaModel();
		$Layout -> setIncludes();
		if($_REQUEST[previsual]=='si'){
			if($_REQUEST[guias_id]=='todas'){
				$Layout -> setDetallesGuiasVisual($Model -> getDetallesGuiasVisual($_REQUEST[cliente_id],$_REQUEST[desde],$_REQUEST[hasta],$this -> getConex()));
			}else{
				$Layout -> setDetallesGuiasVisual($Model -> getDetallesGuiasVisualGuia($_REQUEST[guias_id],$_REQUEST[cliente_id],$_REQUEST[desde],$_REQUEST[hasta],$this -> getConex()));
				
			}
		}else{
			$Layout -> setDetallesGuias($Model -> getDetallesGuias($_REQUEST[liquidacion_guias_cliente_id],$this -> getConex()));
			
		}
		$Layout -> RenderMain();
	}
}

$DetallesLiqGuia = new DetallesLiqGuia();
?>