<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_LiquidacionPrimaLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../css/Imp_Extras.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../css/Imp_Extras.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
  public function setLiquidacion($con_deb1,$con_cre1,$con_debExt1,$con_creExt1,$con_sal1,$liquidacion){

	 $this -> assign("DETALLES",$liquidacion);  
	 $this -> assign("TIPOIMPRE",$_REQUEST['tipo_impresion']);
     $this -> assign("DESPREND",$_REQUEST['desprendibles']); 
	 $this -> assign("FECHALIQ",$liquidacion[0]['fecha_liquidacion']); 
	 $this -> assign("FECHA_FIN",$liquidacion[0]['fecha_final']); 	 

	 $this -> assign("LOGO",$liquidacion[0]['logo']); 	 
	 $this -> assign("NOMBREEMPRESA",$liquidacion[0]['nombre_empresa']); 	 
	 $this -> assign("NITEMPRESA",$liquidacion[0]['nit_empresa']); 	 

	 $this -> assign("CONCDEBITO1",$con_deb1); 
	 $this -> assign("CONCCREDITO1",$con_cre1); 

	 $this -> assign("CONCDEBITOEXT1",$con_debExt1); 
	 $this -> assign("CONCCREDITOEXT1",$con_creExt1); 

	 $this -> assign("CONCSALDO1",$con_sal1); 	 
   
   }

  public function setLiquidacion1($liquidacion){

	 $this -> assign("DETALLES",$liquidacion);
	 $this -> assign("TIPOIMPRE",$_REQUEST['tipo_impresion']);
     $this -> assign("DESPREND",$_REQUEST['desprendibles']); 
	 $this -> assign("FECHA_INI",$liquidacion[0]['fecha_inicial']); 
	 $this -> assign("FECHA_FIN",$liquidacion[0]['fecha_final']); 	
	 
	 $this -> assign("FECHALIQ",$liquidacion[0]['fecha_liquidacion']);  

	 $this -> assign("LOGO",$liquidacion[0]['logo']); 	 
	 $this -> assign("NOMBREEMPRESA",$liquidacion[0]['nombre_empresa']); 	 
	 $this -> assign("NITEMPRESA",$liquidacion[0]['nit_empresa']); 	 

   
   }

  public function setConceptoDebito($concepto){
	 $this -> assign("CONCDEBITO",$concepto);
  }

  public function setConceptoCredito($concepto){
	 $this -> assign("CONCCREDITO",$concepto);
  }

  public function setConceptoDebitoExt($concepto){
	 $this -> assign("CONCDEBITOEXT",$concepto);
  }

  public function setConceptoCreditoExt($concepto){
	 $this -> assign("CONCCREDITOEXT",$concepto);
  }

  public function setConceptoSaldo($concepto){

	 $this -> assign("CONCSALDO",$concepto);
   }

   public function RenderMain(){

      $this -> RenderLayout('Imp_LiquidacionPrima.tpl');

   }


}

?>