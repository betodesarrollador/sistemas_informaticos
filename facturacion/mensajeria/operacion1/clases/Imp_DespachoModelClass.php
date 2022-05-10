<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_DespachoModel extends Db{

  
  public function getDespacho($despachos_urbanos_id,$Conex){
	
	if(is_numeric($despachos_urbanos_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];
				
       $select = "SELECT d.*, m.* FROM (SELECT (SELECT logo FROM empresa WHERE empresa_id = m.empresa_id) AS logo,(SELECT nombre FROM oficina WHERE oficina_id = m.oficina_id) AS oficina, (SELECT direccion FROM oficina WHERE oficina_id = m.oficina_id) AS direccion_oficina,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS razon_social,(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS sigla, (SELECT concat(numero_identificacion,'-',digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS  numero_identificacion_empresa,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id))) AS ciudad,
        
         			(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS telefono,(SELECT codigo_regional FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS codigo_regional,(SELECT codigo_empresa FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS codigo_empresa,
					(SELECT codigo_regional FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS habilitacion,(SELECT rango_manif_ini FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS rango_manif_ini,(SELECT rango_manif_fin FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS rango_manif_fin,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) 
	               AS destino,m.numero_identificacion AS numero_identificacion_conductor,
	               
	               (IF(cargue_pagado_por = 'RE','REMITENTE',IF(cargue_pagado_por = 'DE','DESTINATARIO',IF(cargue_pagado_por = 'CO','CONDUCTOR',IF(cargue_pagado_por = 'CI','CLIENTE','TRANSPORTADORA'))))) AS cargue_pagado_por,
	               
	               (IF(descargue_pagado_por = 'RE','REMITENTE',IF(descargue_pagado_por = 'DE','DESTINATARIO',IF(descargue_pagado_por = 'CO','CONDUCTOR',IF(descargue_pagado_por = 'CI','CLIENTE','TRANSPORTADORA'))))) AS descargue_pagado_por,(SELECT SUM(valor) FROM anticipos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id) AS valor_anticipo,despachos_urbanos_id,empresa_id,oficina_id,despacho ,modalidad,origen_id,destino_id ,aseguradora 	,poliza 	,vencimiento_poliza 	,titular_despacho_id 	,ciudad_titular_despacho_divipola 	,titular_despacho 	,numero_identificacion_titular_despacho 	,direccion_titular_despacho 	,telefono_titular_despacho 	,ciudad_titular_despacho 	,placa_id 	,placa 	,propio 	,placa_remolque_id 	,fecha_du 	,fecha_entrega_mcia_du 	,hora_entrega 	,valor_flete 	,preliquido 	,marca 	,linea 	,modelo 	,modelo_repotenciado 	,serie 	,color 	,carroceria 	,registro_nacional_carga ,configuracion,peso_vacio ,numero_soat ,nombre_aseguradora ,vencimiento_soat,placa_remolque,propietario,
				   numero_identificacion_propietario 	,direccion_propietario 	,telefono_propietario 	,ciudad_propietario 	,tenedor 	,tenedor_id 	,numero_identificacion_tenedor 	,direccion_tenedor 	,telefono_tenedor 	,ciudad_tenedor 	,conductor_id 	,conductor 	,numero_identificacion 	,numero_licencia_cond 	,nombre 	,direccion_conductor 	,telefono_conductor 	,ciudad_conductor 	,categoria_licencia_conductor 	,fecha_pago_saldo 	,oficina_pago_saldo_id 	,lugar_pago_saldo 	,saldo_por_pagar 	,valor_neto_pagar 	,numero_precinto 	,observaciones 	,usuario_id 	,usuario_registra 	,usuario_registra_numero_identificacion,estado,id_mobile
	               
	               FROM despachos_urbanos m WHERE m.despachos_urbanos_id = $despachos_urbanos_id) m LEFT JOIN dta d 
				   ON m.despachos_urbanos_id = d.despachos_urbanos_id ";		
					
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  public function getRemesas($despachos_urbanos_id,$Conex){

    $select  = "SELECT r.*,r.numero_remesa,(SELECT m.medida FROM medida m WHERE medida_id = r.medida_id) AS medida,r.cantidad,r.peso,(SELECT n.naturaleza_id FROM naturaleza n WHERE naturaleza_id = r.naturaleza_id) AS naturaleza,(SELECT e.codigo FROM empaque e WHERE  empaque_id = r.empaque_id) AS empaque,(SELECT p.codigo FROM producto p WHERE producto_id = r.producto_id) AS producto,substring(r.descripcion_producto,1,40) AS descripcion_producto,r.remitente,r.destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
    
    (SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = r.aseguradora_id) AS aseguradora,
    
    (SELECT nit_aseguradora FROM aseguradora WHERE aseguradora_id = r.aseguradora_id) AS nit_aseguradora,r.numero_poliza,r.direccion_remitente,(SELECT replace(naturaleza,' ','<br>') FROM naturaleza WHERE naturaleza_id = r.naturaleza_id) AS naturaleza,(SELECT empaque FROM empaque WHERE empaque_id = r.empaque_id) AS empaque
    
    FROM detalle_despacho d, remesa r  WHERE d.despachos_urbanos_id = $despachos_urbanos_id  AND d.remesa_id=r.remesa_id AND r.remesa_id = d.remesa_id ORDER BY r.numero_remesa ASC";

    $result = $this -> DbFetchAll($select,$Conex);  

    return $result;  
  
  }
  
  
  public function getImpuestos($despachos_urbanos_id,$Conex){
  
     $select = "SELECT * FROM impuestos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
	 
     $result = $this -> DbFetchAll($select,$Conex);  

     return $result;    
  
  }  
  
   
}


?>