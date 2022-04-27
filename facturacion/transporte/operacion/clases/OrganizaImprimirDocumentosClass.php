<?php

require_once("../../../framework/clases/ControlerClass.php");

final class OrganizaImprimir extends Controler{
	
	public function __construct(){
		parent::__construct(2);	
	}
  	
	public function manifiestosCarga(){
  
		$this -> noCache();
		require_once("OrganizaImprimirDocumentosLayoutClass.php");
		require_once("OrganizaImprimirDocumentosModelClass.php");
		$Layout 		= new OrganizaImprimirLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model 			= new OrganizaImprimirModel();
		$Conex			= $this ->getConex();
		$manifiesto_id	= $_REQUEST['manifiesto_id'];

		$remesas 	= $Model ->getRemesasManifiesto($manifiesto_id,$Conex);
		$anticipos 	= $Model ->getAnticiposManifiesto($manifiesto_id,$Conex);

		for ($i=0; $i < count($remesas); $i++) { 
			$data= $Model ->getOrdenesCompra($remesas[$i][remesas_id],$Conex);
			$ordenes=$data;
		}

		$Model  	-> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setCampos($this -> Campos);

		$Layout -> setVar('MANIFIESTO',$manifiesto_id);
		$Layout -> setVar('REMESAS',$remesas);
		$Layout -> setVar('ANTICIPOS',$anticipos);
		$Layout -> setVar('ORDENCOMPRA',$ordenes);
		$Layout -> RenderLayout('OrganizaImprimirManifiestos.tpl');
	}


	public function despachosUrbanos(){
  
		$this -> noCache();
		require_once("OrganizaImprimirDocumentosLayoutClass.php");
		require_once("OrganizaImprimirDocumentosModelClass.php");
		$Layout 		= new OrganizaImprimirLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model 			= new OrganizaImprimirModel();
		$Conex			= $this ->getConex();
		$despachos_urbanos_id	= $_REQUEST['despachos_urbanos_id'];
		$remesas 	= $Model ->getRemesasDespachos($despachos_urbanos_id,$Conex);
		$anticipos 	= $Model ->getAnticiposDespachos($despachos_urbanos_id,$Conex);
		for ($i=0; $i < count($remesas); $i++) { 
			$data= $Model ->getOrdenesCompra($remesas[$i][remesas_id],$Conex);
			$ordenes=$data;
		}

		$Model  	-> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setCampos($this -> Campos);

		$Layout 	-> setVar('DESPACHO',$despachos_urbanos_id);
		$Layout 	-> setVar('REMESAS',$remesas);
		$Layout 	-> setVar('ANTICIPOS',$anticipos);
		$Layout 	-> setVar('ORDENCOMPRA',$ordenes);
		$Layout -> RenderLayout('OrganizaImprimirDespachos.tpl');
	}
}

$OrganizaImprimir = new OrganizaImprimir();

?>