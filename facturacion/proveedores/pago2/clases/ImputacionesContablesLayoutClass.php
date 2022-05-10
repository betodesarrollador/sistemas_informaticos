<?php



require_once("../../../framework/clases/ViewClass.php"); 



final class ImputacionContableLayout extends View{



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

   

   public function setImputacionesContables($imputaciones){

   

     $this -> assign("IMPUTACIONES",$imputaciones);	  

   

   }   

   

   public function setIncludes(){

	 

     $this -> TplInclude -> IncludeCss("/rotterdan/framework/css/reset.css");

     $this -> TplInclude -> IncludeCss("/rotterdan/framework/css/general.css");

     $this -> TplInclude -> IncludeCss("/rotterdan/contabilidad/css/imputacionescontables.css");	 

     $this -> TplInclude -> IncludeCss("/rotterdan/framework/css/jquery.autocomplete.css");	 	 

     $this -> TplInclude -> IncludeCss("/rotterdan/framework/css/jquery.alerts.css");		 	 

	 

     $this -> TplInclude -> IncludeJs("/rotterdan/framework/js/jquery.js");

     $this -> TplInclude -> IncludeJs("/rotterdan/framework/js/jquery.autocomplete.js");	

     $this -> TplInclude -> IncludeJs("/rotterdan/framework/js/funciones.js");

     $this -> TplInclude -> IncludeJs("/rotterdan/framework/js/funcionesDetalle.js");

     $this -> TplInclude -> IncludeJs("/rotterdan/contabilidad/js/imputacionescontables.js");
	 
	 //$this	->	TplInclude	->	IncludeJs("/rotterdan/activos/bases/js/CrearActivo.js");

     $this -> TplInclude -> IncludeJs("/rotterdan/framework/js/jquery.alerts.js");	 		   	 

     $this -> TplInclude -> IncludeJs("/rotterdan/framework/js/jquery.hotkeys.js");	 

	  	  

     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());

     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());

     $this -> assign("encabezado_registro_id",$_REQUEST['encabezado_registro_id']);	 



   }

   

   public function setEstadoEncabezado($estado){

     $this -> assign("ESTADO",$estado);	    

   }



   public function RenderMain(){

   

        $this -> RenderLayout('imputacionescontables.tpl');

	 

   }





}





?>