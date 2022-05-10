<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportesModel extends Db{

  private $Permisos;
  

//// GRID ////

  public function getQueryReportesGrid(){
	
		
	$Query = "SELECT 
		r.fecha,
		r.hora,
	  	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS clien FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) AS cliente,
		CASE r.minuto WHEN 'UV' THEN 'UNA VEZ CADA HORA' WHEN 'CQ' THEN 'CADA QUINCE MINUTOS' ELSE 'CADA TREINTA MINUTOS' END AS minuto,
		CASE r.horas WHEN 'CH' THEN 'CADA HORA' WHEN 'C2' THEN 'CADA DOS HORAS' WHEN 'C3' THEN 'CADA TRES HORAS' WHEN 'C4' THEN 'CADA CUATRO HORAS' ELSE 'CADA OCHO HORAS' END AS horas,
		CASE r.dias WHEN 'TD' THEN 'TODOS LOS DIAS' WHEN 'LV' THEN 'LUNES A VIERNES'  ELSE 'LUNES A SABADO' END AS dias,
		IF(r.con_registros=1,'SI','NO') AS con_registros,
		IF(r.enviado=1,'SI','NO') AS enviado,
		CONCAT('<a href=\"../../../archivos/seguimiento/',r.archivo,'\" target=\"_blank\">',r.archivo,'</a>') AS archivo
		
	  FROM reporte_historial_novedad  r  
	  ORDER BY r.fecha_registro DESC";
   
     return $Query;
   }

   
}



?>