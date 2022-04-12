<?php

require_once("../../../framework/clases/ViewClass.php");

final class faseLayout extends View{

	private $fields;
	private $Guardar;
	private $Actualizar;
	private $Borrar;
	private $Limpiar;

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

	public function setCerrar($Permiso){
		$this -> cerrar = $Permiso;
	}  

	public function setCampos($campos){

		require_once("../../../framework/clases/FormClass.php");

		$Form1      = new Form("faseClass.php","faseForm","faseForm");

		$this -> fields = $campos;

		$this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
		$this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
		$this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css"); 

		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");

		$this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
   //$this -> TplInclude -> IncludeJs("/talpaprueba/framework/js/generalterceros.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");

		$this -> TplInclude -> IncludeJs("../../../errores/movimientos/js/fase.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");

		$this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
		$this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
		$this -> assign("FORM1",$Form1 -> FormBegin());
		$this -> assign("FORM1END",$Form1 -> FormEnd());
		$this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
		$this -> assign("FASEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[fase_id]));
		$this -> assign("FECHAINICIOPROGRAMADA",      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio_programada]));
		$this -> assign("FECHAFINPROGRAMADA",      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_fin_programada])); 
		$this -> assign("FECHAINICIOREAL",      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio_real])); 
		$this -> assign("FECHAFINREAL",      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_fin_real]));  
		$this -> assign("FECHAREGISTRO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));
		$this -> assign("FECHAACTUALIZA",  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza]));
		$this -> assign("ABIERTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[abierta]));
		$this -> assign("CERRADA",$this -> objectsHtml -> GetobjectHtml($this -> fields[cerrada]));
		$this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre])); 
		$this -> assign("PROYECTOID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[proyecto_id]));    
		$this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id])); 
		$this -> assign("USUARIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario]));
		$this -> assign("USUARIOACTUALIZAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id])); 
		$this -> assign("USUARIOCIERREID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_cierre_id])); 
		/*$this -> assign("USUARIOACTUALIZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza]));
		$this -> assign("USUARIOCIERRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_cierre]));*/ 
		$this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));  
		$this -> assign("FECHASTATIC",      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static])); 
		//$this -> assign("USUARIOIDSTATIC",  $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id_static])); 
		$this -> assign("USUARIOSTATIC",  $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_static]));   

		if($this -> Guardar)
			$this -> assign("GUARDAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

		if($this -> Borrar)
			$this -> assign("BORRAR",  $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

		if($this -> cerrar)
			$this -> assign("CERRAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[cerrar]));
	}


	public function SetProyecto($proyecto){
		$this -> fields[proyecto_id]['options'] = $proyecto;
		$this -> assign("PROYECTOID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[proyecto_id]));
	}

	/*public function SetUsuarioId($usuario_id){
		$this -> fields[usuario_id]['value'] = $usuario_id;
		$this -> fields[usuario_cierre_id]['value'] = $usuario_id;
		$this -> fields[usuario_actualiza_id]['value'] = $usuario_id;
		$this -> assign("USUARIOID", $this -> getObjectHtml($this -> fields[usuario_id]));
		$this -> assign("USUARIOACTUALIZAID", $this -> getObjectHtml($this -> fields[usuario_actualiza_id]));
		$this -> assign("USUARIOCIERREID", $this -> getObjectHtml($this -> fields[usuario_cierre_id]));
	}*/

	public function SetUsuario($usuario){
		$this -> fields[usuario]['value'] = $usuario;
		$this -> fields[usuario_static]['value'] = $usuario;
		/*$this -> fields[usuario_cierre]['value'] = $usuario;
		$this -> fields[usuario_actualiza]['value'] = $usuario;*/
		$this -> assign("USUARIO", $this -> getObjectHtml($this -> fields[usuario]));
		$this -> assign("USUARIOSTATIC", $this -> getObjectHtml($this -> fields[usuario_static]));
		/*$this -> assign("USUARIOACTUALIZA", $this -> getObjectHtml($this -> fields[usuario_actualiza]));
		$this -> assign("USUARIOCIERRE", $this -> getObjectHtml($this -> fields[usuario_cierre]));*/
	}

	public function SetGridfase($Attributes,$Titles,$Cols,$Query){
		require_once("../../../framework/clases/grid/JqGridClass.php");
		$TableGrid = new JqGrid();
		$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
		$this -> assign("GRIDFASE",$TableGrid -> RenderJqGrid());
		$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
		$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
	}


	public function RenderMain(){
		$this ->RenderLayout('fase.tpl');
	}

}

?>