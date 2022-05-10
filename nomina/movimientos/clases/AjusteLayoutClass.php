<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class AjusteLayout extends View{

    private $fields;

    public function setGuardar($Permiso){
        $this -> Guardar = $Permiso;
    }

    public function setActualizar($Permiso){
        $this -> Actualizar = $Permiso;
    }

    public function SetImprimir($Permiso){
        $this -> Imprimir = $Permiso;
    } 

    public function setAnular($Permiso){
        $this -> Anular = $Permiso;
    }     

    public function setLimpiar($Permiso){
        $this -> Limpiar = $Permiso;
    }
   
    public function setCampos($campos){

        require_once("../../../framework/clases/FormClass.php");
        
        $Form1 = new Form("AjusteClass.php","AjusteForm","AjusteForm");
        
        $this -> fields = $campos; 
        
        $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
        $this -> TplInclude -> IncludeCss("../../../framework/css/general.css"); 
        $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
        $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 	

        $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/swfobject.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
        $this -> TplInclude -> IncludeJs("../js/Ajuste.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
        
        $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
        $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
        $this -> assign("FORM1",			$Form1 -> FormBegin());
        $this -> assign("FORM1END",		$Form1 -> FormEnd());
        $this -> assign("BUSQUEDAEMPLEADO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda_empleado]));
        
        $this -> assign("LISTALIQUIDACIONNOVEDAD",	$this -> objectsHtml -> GetobjectHtml($this -> fields[lista_liquidacion_novedad_id]));
        $this -> assign("LIQUIDACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_novedad_id]));
        $this -> assign("CONSECUTIVONOM",	$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo_nom]));
        $this -> assign("CONSECUTIVO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));
        $this -> assign("FECHAINI",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicial]));
        $this -> assign("FECHAFIN",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));
        $this -> assign("CONTRATOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));	 
        $this -> assign("CONTRATO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));	 
        $this -> assign("EMPLEADOS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[empleados]));	 	 
        $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
        $this -> assign("USUARIO_ID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
        $this -> assign("FECHAREG",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));
        $this -> assign("PERIODICIDAD",		$this -> objectsHtml -> GetobjectHtml($this -> fields[periodicidad]));	 	 
        $this -> assign("AREAS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[area_laboral]));	 	 
        $this -> assign("PARAMETRONOMINAELECTRONICA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[param_nom_electronica_id]));
        

        if($this -> Guardar){
        $this -> assign("AJUSTAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[ajustar]));
        $this -> assign("PREVISUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[previsual]));
        }
        if($this -> Actualizar){
        //$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
        $this -> assign("CONTABILIZARDIF",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar_diferencia]));
        }
        
        if($this -> Limpiar)
        $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
        
    }

    public function SetCosto($centro_de_costo_id){
		$this -> fields[centro_de_costo_id]['options'] = $centro_de_costo_id;
		$this -> assign("CENTRO_DE_COSTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));
	}

    public function RenderMain(){
   
        $this -> RenderLayout('Ajuste.tpl');
	 
    }

}    

?>