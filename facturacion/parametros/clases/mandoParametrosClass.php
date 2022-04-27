<?php
require_once("../../../framework/clases/ControlerClass.php");

final class mandoParametros extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
   
	require_once("mandoParametrosLayoutClass.php");
	require_once("mandoParametrosModelClass.php");
	
	$Layout = new mandoParametrosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new mandoParametrosModel();
    
    $Layout -> setIncludes();		
	//// GRID ////
	$Attributes = array(
	  id		=>'parametros_factura_id',
	  title		=>'RESOLUCIONES Y RANGOS DE FACTURACION',
	  sortname	=>'dias',	  	  
	  width		=>'auto',
	  height	=>'auto'
	);
	$Cols = array(
	  array(name=>'parametros_factura_id',  index=>'parametros_factura_id',         sorttype=>'text',	width=>'60',	align=>'left'), 
	  array(name=>'resolucion_dian',	    index=>'resolucion_dian',			    sorttype=>'text',   width=>'150',	align=>'left'), 
	  array(name=>'fecha_resolucion_dian',	index=>'fecha_resolucion_dian',	        sorttype=>'text',	width=>'160',	align=>'left'),
      array(name=>'tipo_factura',			index=>'tipo_factura',			        sorttype=>'text',	width=>'140',   align=>'left'),
      array(name=>'rango_inicial',	        index=>'rango_inicial',	                sorttype=>'text',	width=>'120',   align=>'left'),
      array(name=>'rango_final',	        index=>'rango_final',	                sorttype=>'text',	width=>'120',	align=>'left'), 	  
      array(name=>'dias',	                index=>'dias',	                        sorttype=>'text',	width=>'60',	align=>'left'),
      array(name=>'estado',	                index=>'estado',	                    sorttype=>'text',	width=>'120',	align=>'left'),
    );

    $Titles = array(
		            'ID', 
					'RESOLUCION', 
					'FECHA RESOLUCION',
                    'TIPO FACTURA',
                    'RANGO INICIAL',
                    'RANGO FINAL',
                    'DIAS',	
                    'ESTADO',				
	);
   
	
	$Layout -> SetGridMandoParametros($Attributes,$Titles,$Cols,$Model -> getQueryMandoParametrosGrid());
	
	$Layout -> RenderMain();
   
  }
  
  protected function ProximosVencerElectronica(){

    require_once("mandoParametrosModelClass.php");
    $Model = new mandoParametrosModel();
	
    $result = $Model -> SelectVencimientosElectronica($this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       $this -> getArrayJSON($result);
	 }	
  }

    protected function ProximosVencerDigital(){

    require_once("mandoParametrosModelClass.php");
    $Model = new mandoParametrosModel();
	
    $result = $Model -> SelectVencimientosDigital($this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       $this -> getArrayJSON($result);
	 }	
  }
  
}

new mandoParametros();



?>