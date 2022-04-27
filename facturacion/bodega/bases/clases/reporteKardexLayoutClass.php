<?php



require_once("../../../framework/clases/ViewClass.php"); 



final class reporteKardexLayout extends View{



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

	 

     $Form1 = new Form("reporteKardexClass.php","reporteKardexForm","reporteKardexForm");

	 

     $this -> fields = $campos; 

	 

     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");

     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");

     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");

     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/DatosBasicos.css");

     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");

     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");	 

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/bases/js/reporteKardex.js"); 

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");	 

     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");		 

	 

     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());

     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());

     $this -> assign("FORM1",		   $Form1 -> FormBegin());

     $this -> assign("FORM1END",	   $Form1 -> FormEnd());

     $this -> assign("FECHAINICIO",    $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));	 

     $this -> assign("FECHAFINAL",     $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));	 	 

     $this -> assign("OPCIONESPRODUCTO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_producto]));	 	 	 	 	 	 

     $this -> assign("PRODUCTO",          $this -> objectsHtml -> GetobjectHtml($this -> fields[producto]));	 	 	 	 

     $this -> assign("PRODUCTOID",        $this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));	 	 	 	 	 	 	 

     

   }

//LISTA MENU



   public function RenderMain(){   

     $this -> RenderLayout('ReporteKardex.tpl');	 

   }



}





?>