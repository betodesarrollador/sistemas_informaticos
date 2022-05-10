<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class vencimientoVehModel extends Db{

  private $Permisos;

    public function getQueryVencimiento(){			
      $Query = "(SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewVeh(',v.placa_id,')\">',v.placa,'</a>' ) AS placa,v.vencimiento_soat AS vencimiento, 'SOAT' AS tipo_vencimiento
      FROM vehiculo v WHERE v.placa_id = v.placa_id AND (DATEDIFF(v.vencimiento_soat,CURDATE())) < 15 ORDER BY v.vencimiento_soat ASC)
      
      UNION ALL
      
      (SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewVeh(',v.placa_id,')\">',v.placa,'</a>' ) AS placa,v.venc_invima AS vencimiento,'INVIMA' AS tipo_vencimiento
      FROM vehiculo v WHERE v.placa_id = v.placa_id AND (DATEDIFF(v.venc_invima,CURDATE())) < 15 ORDER BY v.venc_invima ASC)
      
      UNION ALL
      
      (SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewVeh(',v.placa_id,')\">',v.placa,'</a>' ) AS placa,v.vencimiento_tecno_vehiculo AS vencimiento,'TECNOMECANICA' AS tipo_vencimiento
      FROM vehiculo v WHERE v.placa_id = v.placa_id AND (DATEDIFF(v.vencimiento_tecno_vehiculo,CURDATE())) < 15 ORDER BY vencimiento_tecno_vehiculo ASC)
      
      UNION ALL
      
      (SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewVeh(',v.placa_id,')\">',v.placa,'</a>' ) AS placa,v.fumigacion AS vencimiento,'FUMIGACION' AS tipo_vencimiento
      FROM vehiculo v WHERE v.placa_id = v.placa_id AND (DATEDIFF(v.fumigacion,CURDATE())) < 10 ORDER BY fumigacion ASC)"; //echo($Query);
      
      return $Query;
  
	}   
}

?>