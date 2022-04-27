<?php



ini_set("memory_limit","2048M");



require_once("../../../framework/clases/ControlerClass.php");



final class reporteKardex extends Controler{



  public function __construct(){

    parent::__construct(3);	      

  }

  //DEFINICION CAMPOS DE FORMULARIO

  protected function setCampos(){  

  

	$this -> Campos[fecha_inicio] = array(

		name	=>'fecha_inicio',

		id		=>'fecha_inicio',

		type	=>'text',

		required=>'yes',

		datatype=>array(type=>'date')

	);

	

	$this -> Campos[fecha_final] = array(

		name	=>'fecha_final',

		id		=>'fecha_final',

		type	=>'text',

		required=>'yes',

		datatype=>array(type=>'date')

	);	

	

	

	

	$this -> Campos[opciones_producto] = array(

		name	=>'opciones_producto',

		id		=>'opciones_producto',

		type	=>'select',

		options => array(array(value => 'U', text => 'UNO'),array(value => 'T', text => 'TODOS')),

		selected=>'T',

		required=>'yes',

		datatype=>array(type=>'text')

	);	

	

	$this -> Campos[producto] = array(

		name	=>'producto',

		id		=>'producto',

		type	=>'text',

		disabled=>'true',

		suggest=>array(

			name	=>'producto_inv_activo',

			setId	=>'producto_id_hidden'

			)

	);

		

	$this -> Campos[producto_id] = array(

		name	=>'producto_id',

		id	    =>'producto_id_hidden',

		type	=>'hidden',

		datatype=>array(type=>'integer')

	);	

	

	

  }



  public function Main(){

  

    $this -> noCache();



    require_once("reporteKardexLayoutClass.php");

    require_once("reporteKardexModelClass.php");



    $Layout   = new reporteKardexLayout($this -> getTitleTab(),$this -> getTitleForm());

    $Model    = new reporteKardexModel();



    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

	

    $Layout -> setCampos($this -> Campos);	

	

	//LISTA MENU

    
	$Layout -> RenderMain();

    

  }

  

  protected function generateReport(){

	

    require_once("reporteKardexLayoutClass.php");

    require_once("reporteKardexModelClass.php");

	

    $Layout   = new reporteKardexLayout($this -> getTitleTab(),$this -> getTitleForm());

    $Model    = new reporteKardexModel();

			

    $Layout -> setCssInclude("/talpa/framework/css/reset.css");	 	 	 

    $Layout -> setCssInclude("/talpa/framework/css/general.css");	 	 	 	 

    $Layout -> setCssInclude("/talpa/framework/css/generalDetalle.css");	

   


    $Layout -> setJsInclude("/talpa/framework/js/funciones.js");	 	 	 	
	$Layout -> setJsInclude("/talpa/framework/js/jquery.js");	 	 	 		
	$Layout -> setJsInclude("/talpa/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 	 	 		
	$Layout -> setJsInclude("/talpa/framework/js/jqueryform.js");	 	 	 		
	$Layout -> setJsInclude("/talpa/framework/js/funciones.js");	
	$Layout -> setJsInclude("/talpa/framework/js/ajax-list.js");
	$Layout -> setJsInclude("/talpa/framework/js/ajax-dynamic-list.js");
	$Layout -> setJsInclude("/talpa/inventarios/reportes/js/reporteKardex.js");
	$Layout -> setJsInclude("/talpa/framework/js/funcionesDetalle.js");
	$Layout -> setJsInclude("/talpa/framework/js/jquery.alerts.js"); 	 	 		

	

    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	



	$data = $Model -> selectInformacionProductos($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());



    $Layout -> setVar("DATA",$data);	
	
	$download = $_REQUEST['download'];
	
	if($download == 'true'){
	    $Layout -> exportToExcel('ReporteKardexResult.tpl'); 		
	}else{	
		  $Layout	-> RenderLayout('ReporteKardexResult.tpl');	
	  }		

    //$Layout	-> RenderLayout('ReporteKardexResult.tpl');	

  

  }

     

  protected function generateFile(){

  

    require_once("reporteKardexModelClass.php");

	

    $Model = new reporteKardexModel();	

	$data  = $Model -> selectInformacionProductos($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());	

    $ruta  = $this -> arrayToExcel("reporteKardex","Reporte Productos",$data);

	

    $this -> ForceDownload($ruta);

		  

  }

	

}



new reporteKardex();



?>