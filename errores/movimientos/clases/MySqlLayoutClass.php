<?php



require_once("../../../framework/clases/ViewClass.php");



final class MySqlLayout extends View{



 private $fields;

 private $Guardar;

 

 public function setGuardar($Permiso){

   $this -> Guardar = $Permiso;

 }

 

 public function setCampos($campos){

   require_once("../../../framework/clases/FormClass.php");

   $Form1      = new Form("MySqlClass.php","MySqlForm","MySqlForm");

  
   $this -> fields = $campos;

   $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
   $this->TplInclude->IncludeCss("../../../framework/css/DatosBasicos.css");
   $this->TplInclude -> IncludeCss("../../../framework/css/general.css");
   $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
   $this->TplInclude->IncludeCss("../../../facturacion/reportes/css/Reporte.css");
   $this->TplInclude->IncludeCss("../../../framework/bootstrap-4.0.0/dist/css/bootstrap.min.css");
   $this->TplInclude->IncludeCss("../../../framework/bootstrap-4.0.0/dist/css/bootstrap.css");
   $this->TplInclude->IncludeCss("../../../framework/sweetalert2/dist/sweetalert2.min.css");
   $this->TplInclude->IncludeCss("../../../framework/css/font-awesome-4.7.0/css/font-awesome.min.css");
   $this->TplInclude->IncludeCss("../../../framework/DataTables/css/dataTables.bootstrap4.min.css");
   $this->TplInclude->IncludeCss("../../../framework/DataTables/css/responsive.dataTables.min.css");
   $this->TplInclude->IncludeCss("../../../framework/DataTables/buttons.dataTables.min.css");
   $this->TplInclude->IncludeCss("../../../framework/DataTables/buttons.bootstrap4.min.css");
   $this->TplInclude->IncludeCss("../../../framework/DataTables/fixedHeader.dataTables.min.css");

   $this->TplInclude->IncludeJs("../../../framework/jquery/jquery-3.5.1.min.js");
   $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
   $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
   $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
   $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
   $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
   $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
   $this->TplInclude -> IncludeJs("../js/MySql.js");
   $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
   $this->TplInclude->IncludeJs("../../../framework/bootstrap-4.0.0/dist/js/bootstrap.min.js");
   $this->TplInclude->IncludeJs("../../../framework/sweetalert2/dist/sweetalert2.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/js/jquery.dataTables.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/js/dataTables.bootstrap4.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/datatables.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/js/dataTables.responsive.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/dataTables.buttons.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/buttons.bootstrap4.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/jszip.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/pdfmake.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/vfs_fonts.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/buttons.colVis.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/dataTables.fixedHeader.min.js");
   $this->TplInclude->IncludeJs("../../../framework/DataTables/buttons.html5.min.js");
   

   $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());

   $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());

   $this -> assign("FORM1",$Form1 -> FormBegin());

   $this -> assign("FORM1END",$Form1 -> FormEnd());

   $this -> assign("QUERY",$this -> objectsHtml -> GetobjectHtml($this -> fields[query]));

   

   if($this -> Guardar)

     $this -> assign("EJECUTAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[ejecutar]));

 }



public function setDB($db){



  $this -> assign("DATABASES",$db);	  

 

 } 



public function RenderMain(){

 $this ->RenderLayout('MySql.tpl');

}



}



?>