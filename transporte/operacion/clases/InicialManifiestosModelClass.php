<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InicialManifiestosModel extends Db{

  private $Permisos;  

  public function getQueryManifiestosGrid(){
	   	   
     $Query = "SELECT m.manifiesto, m.fecha_mc,IF(m.estado = 'P','PENDIENTE',IF(m.estado = 'M','MANIFESTADO',IF(
	 m.estado = 'L','LIQUIDADO','ANULADO'))) estado, (SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen, (SELECT 
	 nombre FROM ubicacion WHERE ubicacion_id =  m.destino_id) AS destino, m.placa,m.placa_remolque,m.valor_flete
	 FROM manifiesto m WHERE m.estado='M' AND m.aprobacion_ministerio2 IS NULL AND m.fecha_mc>='2016-01-01' ORDER BY m.manifiesto DESC LIMIT 0,300";
   
     return $Query;
   }
	
  public function getQueryManifiestosGrid1(){
	   	   
     $Query = "SELECT m.manifiesto,m.fecha_mc,IF(m.estado = 'P','PENDIENTE',IF(m.estado = 'M','MANIFESTADO',IF(
	 m.estado = 'L','LIQUIDADO','ANULADO'))) estado,  (SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen, (SELECT 
	 nombre FROM ubicacion WHERE ubicacion_id =  m.destino_id) AS destino, m.placa,m.placa_remolque,m.valor_flete
	 FROM manifiesto m WHERE m.estado IN ('L','M') AND m.aprobacion_ministerio2 IS NOT NULL AND m.aprobacion_ministerio3 IS NULL AND m.fecha_mc>='2016-01-01' ORDER BY m.manifiesto DESC LIMIT 0,300";
   
     return $Query;
   }


    public function getQueryVencimientoManipulacionAlimentosGrid(){
	   	   
     $Query = "SELECT c.carnet_manipulacion_alimentos,
	 				(SELECT nombre 
						FROM tipo_identificacion 
						WHERE tipo_identificacion_id = t.tipo_identificacion_id) 
					AS tipo_identificacion,
	 				t.numero_identificacion,
					t.primer_apellido,
					t.segundo_apellido,
					t.primer_nombre,
					t.segundo_nombre
	 			FROM tercero t,conductor c 
				WHERE t.tercero_id = c.tercero_id AND (DATEDIFF(c.carnet_manipulacion_alimentos,CURDATE())) < 15";
    
     return $Query;
   } 

      public function SelectVencimientos($Conex){

			$select = "SELECT v.placa_id FROM vehiculo v WHERE  (DATEDIFF(v.fumigacion,CURDATE())) < 15"; 
			$result = $this->DbFetchAll($select,$Conex,true);
			return $result;
			
   }
   
      
}

?>