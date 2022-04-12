<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_OrdenCompraModel extends Db{

  
  public function getOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
		
	
	if(is_numeric($orden_compra_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];
				
        $select = "SELECT (SELECT logo  FROM empresa WHERE empresa_id = of.empresa_id) AS logo,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social,(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla, (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad,
		t.*,
		p.*,
		(SELECT  nombre_bien_servicio FROM  tipo_bien_servicio WHERE tipo_bien_servicio_id=o.tipo_bien_servicio_id ) AS servicio,
		(SELECT  nombre FROM  forma_compra_venta WHERE forma_compra_venta_id =o.forma_compra_venta_id ) AS forma_compra,
		(SELECT  nombre FROM  centro_de_costo WHERE centro_de_costo_id =o.centro_de_costo_id ) AS centro_costo,
		(SELECT  nombre FROM  ubicacion WHERE ubicacion_id =t.ubicacion_id ) AS ciudad,		
		of.nombre AS nom_oficina,
		o.fecha_orden_compra,
		o.descrip_orden_compra,
		o.observ_orden_compra,
		o.consecutivo,
		o.estado_orden_compra 
        FROM orden_compra o, oficina of, proveedor p, tercero t WHERE o.orden_compra_id = $orden_compra_id AND of.oficina_id=o.oficina_id AND p.proveedor_id=o.proveedor_id  AND t.tercero_id=p.tercero_id";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getitemOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
				
        $select = "SELECT *
         FROM item_orden_compra  WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getliqOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
	
        $select = "SELECT *
         FROM item_liquida_orden  WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function get_num_itemOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
				
        $select = "SELECT COUNT(*) AS total_item
         FROM item_orden_compra  WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function get_num_liqOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
	
        $select = "SELECT COUNT(*) AS total_liq
         FROM item_liquida_orden  WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }



  public function get_val_itemOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
				
        $select = "SELECT SUM(cant_item_orden_compra*valoruni_item_orden_compra) AS valor_item
         FROM item_orden_compra  WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function get_val_liqOrdenCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
	
        $select = "SELECT SUM(cant_item_liquida_orden*valoruni_item_liquida_orden) AS valor_liq
         FROM item_liquida_orden  WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }




  public function get_tot_pucCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
	
        $select = "SELECT COUNT(*) AS total_puc
         FROM  item_puc_liquida_orden   WHERE orden_compra_id = $orden_compra_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function get_pucCompra($Conex){
  
        $orden_compra_id = $this -> requestData('orden_compra_id','integer');
	
	if(is_numeric($orden_compra_id)){
	
        $select = "SELECT c.despuc_bien_servicio, c.contra_bien_servicio, c.natu_bien_servicio, (i.deb_item_puc_liquida+i.cre_item_puc_liquida) AS valor
         FROM  item_puc_liquida_orden i, orden_compra o,  codpuc_bien_servicio c  
		 WHERE o.orden_compra_id = $orden_compra_id AND i.orden_compra_id=o.orden_compra_id AND c.tipo_bien_servicio_id=o.tipo_bien_servicio_id AND c.puc_id=i.puc_id
		 ORDER BY i.item_puc_liquida_id";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

}


?>