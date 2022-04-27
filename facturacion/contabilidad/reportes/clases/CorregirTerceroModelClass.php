<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class CorregirTerceroModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
    
	
  public function Update($Campos,$Conex){	
   
	  if($_REQUEST['tercero_id'] > 0 && $_REQUEST['tercero_id1'] > 0){
		   $this -> Begin($Conex);
		  	$tercero_id=$_REQUEST['tercero_id'];
			$tercero_id1=$_REQUEST['tercero_id1'];
			//MODULO CONTABLE 
			$update = "UPDATE  encabezado_de_registro SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE imputacion_contable SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  encabezado_de_registro_anulado SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE imputacion_contable_anulada SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   forma_pago_tercero SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			//FIN MODULO CONTABLE
			
			//INICIO MODULO NIIF
			$update = "UPDATE  encabezado_de_registro_niif SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE  imputacion_contable_niif SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   encabezado_de_registro_anulado_niif SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE  imputacion_contable_anulada_niif SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			//FIN MODULO NIIF
			//INICIO MODULO TESORERIA
			
			$update = "UPDATE   codpuc_bien_servicio_teso SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   costos_legalizacion_caja SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   item_plantilla_tesoreria SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
		    $select1 = "SELECT   proveedor_id FROM proveedor WHERE tercero_id=$tercero_id1";
			$relacion = $this -> DbFetchAll($select1,$Conex,true);  
			if($relacion[0][proveedor_id]>0){
				$update = "UPDATE   plantilla_tesoreria SET proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id1) 
				WHERE proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id)";
				$this -> query($update,$Conex,true);
			}
			//FIN MODULO TESORERIA
			//INICIO MODULO PROVEEDORES
			if($relacion[0][proveedor_id]>0){
				$update = "UPDATE  abono_factura_proveedor SET proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id1) 
				WHERE proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id)";
				$this -> query($update,$Conex,true);
			}
			
			$update = "UPDATE  item_abono_factura SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			
			if($relacion[0][proveedor_id]>0){
				$update = "UPDATE  factura_proveedor SET proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id1) 
				WHERE proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id)";
				$this -> query($update,$Conex,true);
			}
			
			$update = "UPDATE  item_factura_proveedor SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  orden_compra SET proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id1) 
			WHERE proveedor_id = (SELECT proveedor_id FROM proveedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$delete = "DELETE FROM proveedor WHERE  tercero_id=$tercero_id";
			$this -> query($delete,$Conex,true);
			//FIN MODULO PROVEEDORES
			//INICIO MODULO FACTURACION
			
			$update = "UPDATE  abono_factura SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1) 
			WHERE cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE  item_abono SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  factura SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1) 
			WHERE cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  detalle_factura_puc SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  orden_servicio SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1) 
			WHERE cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  cliente_factura_operativa SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1)  
			WHERE 	cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  cliente_factura_socio SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1) 
			WHERE 	cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$delete = "DELETE FROM cliente WHERE  tercero_id=$tercero_id";
			$this -> query($delete,$Conex,true);
			//FIN MODULO FACTURACION
/*
			//INICIO MODULO AFILIADOS
			
			$update = "UPDATE   abono_factura_afiliacion SET afiliados_id = (SELECT afiliados_id FROM afiliados WHERE tercero_id=$tercero_id1) 
			WHERE afiliados_id = (SELECT afiliados_id FROM afiliados WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE   item_abono_afiliacion SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  factura_afiliacion SET afiliados_id = (SELECT afiliados_id FROM afiliados WHERE tercero_id=$tercero_id1) 
			WHERE afiliados_id = (SELECT afiliados_id FROM afiliados WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  detalle_factura_afiliacion_puc SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  registro_afiliacion SET afiliados_id = (SELECT afiliados_id FROM afiliados WHERE tercero_id=$tercero_id1) 
			WHERE afiliados_id = (SELECT afiliados_id FROM afiliados WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  detalle_afiliacion SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1) 
			WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$delete = "DELETE FROM afiliados WHERE  tercero_id=$tercero_id";
			$this -> query($delete,$Conex,true);
			//FIN MODULO AFILIADOS

*/

			//INICIO MODULO TRANSPORTE
			
			$update = "UPDATE  remesa SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1)
			WHERE cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id) ";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  remesa SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  remesa SET propietario_mercancia_id = $tercero_id1
			WHERE  propietario_mercancia_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  despachos_urbanos SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  despachos_urbanos SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  despachos_urbanos SET titular_despacho_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE  titular_despacho_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  manifiesto SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  manifiesto SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  manifiesto SET 	titular_manifiesto_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE  titular_manifiesto_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  anticipos_despacho SET 	conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)	";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  anticipos_despacho SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id) ";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  anticipos_manifiesto SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id) ";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  anticipos_manifiesto SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)	";
			$this -> query($update,$Conex,true);
			
			$update = "UPDATE  orden_cargue SET cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1)
			WHERE cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id) 	";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  orden_cargue SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1)
			WHERE  	tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id) 	";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  orden_cargue SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)	";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  servicio_transporte SET 	conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1)
			WHERE  conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)	";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  solicitud_servicio SET 	cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1)
			WHERE  cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id)	";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   detalle_liquidacion_despacho SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   liquidacion_despacho SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   costos_viaje_despacho SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   costos_viaje_manifiesto SET tercero_id = $tercero_id1 WHERE 	tercero_id = $tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   legalizacion_despacho SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1) 
			WHERE conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   legalizacion_manifiesto SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1) 
			WHERE conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   legalizacion_manifiesto SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1) 
			WHERE conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);

			$update = "UPDATE  remitente_destinatario  SET 	cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id1)
			WHERE  cliente_id = (SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id) ";
			$this -> query($update,$Conex,true);
			$update = "UPDATE  remitente_destinatario  SET 	tercero_id=$tercero_id1
			WHERE   tercero_id=$tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   remolque SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1) WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   remolque SET  propietario_id=$tercero_id1 WHERE  propietario_id=$tercero_id";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   vehiculo SET conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id1) WHERE conductor_id = (SELECT conductor_id FROM conductor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   vehiculo SET tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id1) WHERE tenedor_id = (SELECT tenedor_id FROM tenedor WHERE tercero_id=$tercero_id)";
			$this -> query($update,$Conex,true);
			$update = "UPDATE   vehiculo SET  propietario_id=$tercero_id1 WHERE  propietario_id=$tercero_id";
			$this -> query($update,$Conex,true);

			$delete = "DELETE FROM conductor WHERE tercero_id=$tercero_id";
			$this -> query($delete,$Conex,true);
			$delete = "DELETE FROM tenedor WHERE  tercero_id=$tercero_id";
			$this -> query($delete,$Conex,true);
			//FIN MODULO TRANSPORTE
			$delete = "DELETE FROM tercero WHERE  tercero_id=$tercero_id";
			$this -> query($delete,$Conex,true);
			$this -> Commit($Conex);
	  }else{
		 exit("Debe seleccionar El tercero Incorrecto y el Correcto");  
	  }
	
  }
  
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"corregirtercero",$Campos);
	 return $Data -> GetData();
   }
  
}
?>