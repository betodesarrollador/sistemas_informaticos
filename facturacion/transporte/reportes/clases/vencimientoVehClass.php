<?php
require_once("../../../framework/clases/ControlerClass.php");

final class vencimientoVeh extends Controler{
	
	public function __construct(){
		parent::__construct(3);    
	}
	
	
	public function Main(){
		
		$this -> noCache();
		
		require_once("vencimientoVehLayoutClass.php");
		require_once("vencimientoVehModelClass.php");
		
		
		$Layout   = new vencimientoVehLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new vencimientoVehModel();

    $Layout->setIncludes();

	
		//// GRID VENCIMIENTO DE VEHICULOS ////
		$Attributes = array(
			id => 'VencimientoSoat',
			title => 'Vencimiento SOAT',
			sortname => 'tipo_vencimiento',
			width => '500',
			height => '300',
		);

		$Cols = array(
			array(name => 'placa', index => 'placa', sorttype => 'text', width => '100', align => 'center'),
			array(name => 'vencimiento', index => 'vencimiento', sorttype => 'text', width => '160', align => 'center'),
			array(name => 'tipo_vencimiento', index => 'tipo_vencimiento', sorttype => 'text', width => '160', align => 'center')
		);

		$Titles = array(
						'PLACA',
						'VENCIMIENTO',
						'TIPO VENCIMIENTO'

		);

		$Layout->SetGridVencimiento($Attributes, $Titles, $Cols, $Model->getQueryVencimiento());


    $Layout->RenderMain();

  }

	
}

$vencimientoVeh = new vencimientoVeh();

?>