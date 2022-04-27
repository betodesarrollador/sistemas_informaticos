<?php



require_once("../../../framework/clases/ViewClass.php"); 



final class reporteSQLLayout extends View{



	private $fields;



	public function setGuardar($Permiso){

		$this -> Guardar = $Permiso;

	}



	public function setActualizar($Permiso){

		$this -> Actualizar = $Permiso;

	}



	public function setBorrar($Permiso){

		$this -> Borrar = $Permiso;

	}



	public function setLimpiar($Permiso){

		$this -> Limpiar = $Permiso;

	}



	public function setCampos($campos){



		require_once("../../../framework/clases/FormClass.php");



		$Form1 = new Form("reporteSQLClass.php","reporteSQLForm","reporteSQLForm");



		$this -> fields = $campos; 



		$this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");

		$this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");

		$this -> TplInclude -> IncludeCss("../../../framework/css/general.css");

		$this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");

		$this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");

		$this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 

		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");	 

		$this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 

		$this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");

		$this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");

		$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");

		$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");

		$this -> TplInclude -> IncludeJs("../js/reporteSQL.js"); 

		$this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 

		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");		 



		$this -> assign("CSSSYSTEM",	   	$this -> TplInclude -> GetCssInclude());

		$this -> assign("JAVASCRIPT",	   	$this -> TplInclude -> GetJsInclude());

		$this -> assign("FORM1",		   	$Form1 -> FormBegin());

		$this -> assign("FORM1END",	   	    $Form1 -> FormEnd()); 

		$this -> assign("FECHAINICIO",    	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));	 

		$this -> assign("FECHAFINAL",     	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));

		$this -> assign("CLIENTE",          $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));  

		$this -> assign("USUARIOID",        $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
			 	  	 	 	 	 	 	 	 	 	 
		$this -> assign("DB",               $this -> objectsHtml -> GetobjectHtml($this -> fields[db]));  
		
		$this -> assign("ESTADO",           $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));  

		$this -> assign("CLIENTEID",        $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 	  	 	 	 	 	 	 	 	 	 

		$this -> assign("LISTAR",           $this -> objectsHtml -> GetobjectHtml($this -> fields[listar]));

		$this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));

	}


//LISTA MENU

	public function RenderMain(){   

		$this -> RenderLayout('reporteSQL.tpl');	 

	}



}





?>