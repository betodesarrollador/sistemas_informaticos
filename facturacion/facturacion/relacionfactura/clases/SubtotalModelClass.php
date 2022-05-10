<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SubtotalModel extends Db{

  private $Permisos;
  
 /* public function getDetalles($factura_id,$empresa_id,$oficina_id,$Conex){
	    	
	 if(is_numeric($factura_id)){
		  $total_pagar=0;
		  $parcial='';
		  $contra=0;
		  $subtotal=0;
		  $i=0;
		  $select  = "SELECT  c.despuc_bien_servicio_factura,
					  c.natu_bien_servicio_factura,
					  c.contra_bien_servicio_factura,
					  c.tercero_bien_servicio_factura,
					  c.ret_tercero_bien_servicio_factura,
					   c.aplica_ingreso,
					  c.puc_id,
					  d.formula_factura,
					  IF(d.valor_liquida>0,d.valor_liquida,(d.deb_item_factura+d.cre_item_factura)) AS total 
					 FROM detalle_factura_puc d, factura f, codpuc_bien_servicio_factura c
					 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id AND c.tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id AND c.puc_id= d.puc_id  ORDER BY c.contra_bien_servicio_factura";

	     $result = $this -> DbFetchAll($select,$Conex);

		 foreach($result as $resultado){

			 $parcial		= $resultado['total'];
			 $parcial		= number_format($parcial,2,'.','');
			 $descripcion	= $resultado[despuc_bien_servicio_factura];
			 $result[$i]	= array(despuc_bien_servicio_factura=>$descripcion,valor=>$parcial,aplica_ingreso=>$resultado[aplica_ingreso],natu_bien_servicio_factura=>$resultado[natu_bien_servicio_factura],puc_id=>$resultado[puc_id],contra_bien_servicio_factura=>$resultado[contra_bien_servicio_factura],tercero_bien_servicio_factura=>$resultado[tercero_bien_servicio_factura],ret_tercero_bien_servicio_factura=>$resultado[ret_tercero_bien_servicio_factura]);	
		 	$i++;
		 }
		 
		 return $result;
	}else{
   	    $result = array();
	}
  
  }*/

 public function getDetalles($factura_id,$empresa_id,$oficina_id,$Conex){
	    	
	 if(is_numeric($factura_id)){
		  $total_pagar=0;
		  $parcial='';
		  $contra=0;
		  $subtotal=0;
		  $i=0;

		 $select1  = "SELECT  fuente_facturacion_cod
					 FROM  factura  WHERE factura_id=$factura_id";
	     $result1 = $this -> DbFetchAll($select1,$Conex,true);
		 
		 if($result1[0]['fuente_facturacion_cod']!='SA'){ 
			  $select  = "SELECT  d.desc_factura AS despuc_bien_servicio_factura,
						  IF(d.deb_item_factura>0,'D','C') AS natu_bien_servicio_factura,
						  d.contra_factura AS contra_bien_servicio_factura,
						  '0' AS tercero_bien_servicio_factura,
						  '0' AS ret_tercero_bien_servicio_factura,
						  '0' AS aplica_ingreso,
						  d.puc_id,
						  d.formula_factura,
						  f.fuente_facturacion_cod,
						  IF(d.valor_liquida>0,d.valor_liquida,(d.deb_item_factura+d.cre_item_factura)) AS total 
						 FROM detalle_factura_puc d, factura f
						 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id ORDER BY contra_bien_servicio_factura,detalle_factura_puc_id";
		 }else{
			  $select  = "SELECT  d.desc_factura AS despuc_bien_servicio_factura,
						  IF(d.deb_item_factura>0,'D','C') AS natu_bien_servicio_factura,
						  d.contra_factura AS contra_bien_servicio_factura,
						  '0' AS tercero_bien_servicio_factura,
						  '0' AS ret_tercero_bien_servicio_factura,
						  '0' AS aplica_ingreso,
						  d.puc_id,
						  d.formula_factura,
						  f.fuente_facturacion_cod,						  
						  IF(d.valor_liquida>0,d.valor_liquida,(d.deb_item_factura+d.cre_item_factura)) AS total 
						 FROM detalle_factura_puc d, factura f
						 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id   ORDER BY d.contra_factura";
			 
		 }
	     $result = $this -> DbFetchAll($select,$Conex,true);

		 foreach($result as $resultado){

			 $parcial		= $resultado['total'];
			 $parcial		= number_format($parcial,2,'.','');
			 $descripcion	= $resultado[despuc_bien_servicio_factura];
			 $result[$i]	= array(fuente_facturacion_cod=>$resultado[fuente_facturacion_cod],despuc_bien_servicio_factura=>$descripcion,valor=>$parcial,aplica_ingreso=>$resultado[aplica_ingreso],natu_bien_servicio_factura=>$resultado[natu_bien_servicio_factura],puc_id=>$resultado[puc_id],contra_bien_servicio_factura=>$resultado[contra_bien_servicio_factura],tercero_bien_servicio_factura=>$resultado[tercero_bien_servicio_factura],ret_tercero_bien_servicio_factura=>$resultado[ret_tercero_bien_servicio_factura]);	
		 	$i++;
		 }
		 
		 return $result;
	}else{
   	    $result = array();
	}
  
  }

}



?>
