<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicServToOrdenModel extends Db{

  private $Permisos;
  private $remesa_id;
  private $datalle_remesa_id;
  
  
  public function SelectSolicitud($detalles_ss_id,$solicitud_id,$Conex){
	
		
    $arraySolicitud = array();
    $arr_detalle_ss_id  = explode(",",$detalles_ss_id); 
    $detalle_ss_id1  = $arr_detalle_ss_id[0];
	
	
	
	$select ="SELECT s.fecha_pre_orden_compra as fecha_orden_compra,
					s.centro_de_costo_id,
					s.proveedor_id,
					s.area_id,
					s.departamento_id,
					s.unidad_negocio_id,
					CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) AS proveedor,
					t.telefono AS proveedor_tele,
					t.direccion AS proveedor_direccion,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS proveedor_ciudad,
					p.contac_proveedor AS proveedor_contacto,
					t.email AS proveedor_correo,
					s.observ_pre_orden_compra AS descrip_orden_compra,
					s.observ_pre_orden_compra AS observ_orden_compra,
					s.oficina_id as sucursal_id,
					s.placa_id,
					s.kilometraje,
					(SELECT placa FROM vehiculo WHERE placa_id = s.placa_id)as placa,
					d.item_pre_orden_compra_id,'$detalles_ss_id' as item_pre_orden_id
			
			  
			FROM pre_orden_compra s,proveedor p, tercero t,item_pre_orden_compra d
			
			 WHERE  s.pre_orden_compra_id = d.pre_orden_compra_id AND p.proveedor_id=s.proveedor_id AND t.tercero_id=p.tercero_id  AND d.item_pre_orden_compra_id =$detalle_ss_id1";
   
    $result = $this -> DbFetchAll($select,$Conex,true);
	
    $arraySolicitud[0]['solicitud'] = $result;



    return $arraySolicitud;  
  
  }

//// GRID ////
  public function getQuerySolicServToOrdenGrid($oficina_id){
	
//	$oficinaId = $_REQUEST['OFICINAID'];
		
    $Query = "SELECT CONCAT('<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',d.item_pre_orden_compra_id,'\" />') 
			 AS link,
			 (SELECT concat_ws(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE 
			 tercero_id = (SELECT tercero_id FROM proveedor WHERE proveedor_id = (SELECT proveedor_id FROM pre_orden_compra WHERE 
			 pre_orden_compra_id = d.pre_orden_compra_id))) AS proveedor,
			 (SELECT numero_identificacion  FROM tercero WHERE tercero_id =(SELECT tercero_id FROM proveedor WHERE proveedor_id = (SELECT proveedor_id FROM pre_orden_compra WHERE pre_orden_compra_id = d.pre_orden_compra_id)))AS  nit,
			 DATE(d.fecha_item_orden)as fecha,
			 (SELECT consecutivo FROM pre_orden_compra WHERE  pre_orden_compra_id = d.pre_orden_compra_id) AS orden_compra,
			  d.desc_item_pre_orden_compra,
			  d.cant_item_pre_orden_compra,
			 d.valoruni_item_pre_orden_compra
			  
			FROM pre_orden_compra s,item_pre_orden_compra d WHERE s.oficina_id = $oficina_id AND s.pre_orden_compra_id = d.pre_orden_compra_id  AND d.estado = 'D'";
   
     return $Query;
   }
   
}

?>