<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RemesasOficinas extends Controler{

  public function __construct(){
   	parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("RemesasOficinasLayoutClass.php");
    require_once("RemesasOficinasModelClass.php");
	
    $Layout   = new RemesasOficinasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RemesasOficinasModel();
       	
	//// GRID ////
	$Attributes = array(
	  id		=>'consolidadoRemesas',
	  title		=>'Listado de Remesas Oficina',
	  sortname	=>'oficina,planilla,numero_remesa',
	  rowId		=>'remesa_id',
	  width		=>'auto',
	  height	=>'auto',
	  rowList	=>'20,40,60,120,240,480',
	  rowNum	=>'20'
	  
	);
	
	$Cols = array(

	  array(name=>'oficina',		       index=>'oficina',	            sorttype=>'text',	width=>'150',	align=>'center' , format => 'none'), 		
	  array(name=>'planilla',		       index=>'planilla',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 	
	  array(name=>'nacional',		       index=>'nacional',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 		  
	  array(name=>'propio',		           index=>'propio',	                sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 		  	  
	  array(name=>'placa',		           index=>'placa',	                sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  
	  array(name=>'conductor',		       index=>'conductor',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  	  
	  array(name=>'fecha_planilla',		   index=>'fecha_planilla',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  	  
	  array(name=>'numero_remesa',		   index=>'numero_remesa',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 
	  
      	  	  
	  array(name=>'estado',		   index=>'estado',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 	  
	  
	  
	  
	  array(name=>'clase_remesa',		   index=>'clase_remesa',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 	  
	       
	  array(name=>'fecha_remesa',		   index=>'fecha_remesa',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  
	  array(name=>'cliente',			   index=>'cliente',		        sorttype=>'text',	width=>'200',	align=>'center' , format => 'none'),	
	  array(name=>'origen',				   index=>'origen',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'remitente',		       index=>'remitente',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'), 
	  array(name=>'destino',			   index=>'destino',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'destinatario',	       index=>'destinatario',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),  
	  array(name=>'orden_despacho'        ,index=>'orden_despacho',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'referencia_producto'   ,index=>'referencia_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'cantidad',		       index=>'cantidad',		        sorttype=>'text',	width=>'100',	align=>'center' ),
	  array(name=>'codigo',				   index=>'codigo',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'descripcion_producto',  index=>'descripcion_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'naturaleza',			   index=>'naturaleza',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'empaque',			   index=>'empaque',			    sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'medida',				   index=>'medida',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'peso_volumen',	       index=>'tipo_remesa',		    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'peso',		           index=>'peso',		            sorttype=>'text',	width=>'100',	align=>'center' ),	
	  array(name=>'observaciones',		   index=>'observaciones',		    sorttype=>'text',	width=>'100',	align=>'center' ),	  
	  	  array(name=>'estado_cliente',		   index=>'estado_cliente',	        sorttype=>'text',	width=>'300',	align=>'center' , format => 'none'), 	  

	    
	  
	  
	);
			
    $Titles = array(
	    'OFICINA',	
	    'PLANILLA',
		'NACIONAL',
		'PROPIO',
		'PLACA',
		'CONDCUTOR',
		'FECHA PLANILLA',
		'REMESA',
		'ESTADO',
		'CLASE REMESA',
		'FECHA REMESA',
		'CLIENTE',					
		'ORIGEN',
		'REMITENTE',
		'DESTINO',
		'DESTINATARIO',
		'ORDEN DESPACHO',
		'REFERENCIA',				
		'CANTIDAD',		
		'COD PRODUCTO',
		'DESCR PRODUCTO',
		'NATURALEZA',
		'EMPAQUE',
		'MEDIDA',
		'PESO VOLUMEN',
		'PESO NETO',
		'ESTADO CLIENTE',		
		'OBSERVACIONES'
	);
		
	$Layout -> SetGridRemesasOficinas($Attributes,$Titles,$Cols,$Model -> getQueryRemesasOficinasGrid($this -> getOficinaId()),$SubAttributes,$SubTitles,$SubCols,null);	
	$Layout -> RenderMain();
    
  }
  	
	
}

new RemesasOficinas();

?>