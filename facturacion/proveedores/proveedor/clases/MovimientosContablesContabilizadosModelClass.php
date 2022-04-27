<?php



require_once("../../../framework/clases/DbClass.php");

require_once("../../../framework/clases/PermisosFormClass.php");



final class MovimientosContablesContabilizadosModel extends Db{



  private $Permisos;

  

  



//// GRID ////

  public function getQueryMovimientosContablesContabilizadosGrid(){

	

	$oficinaId = $_REQUEST['OFICINAID'];

		

	$Query = "SELECT CONCAT('<a href=\"/rotterdan/contabilidad/clases/MovimientosContablesClass.php?ACTIVIDADID=77&OFICINAID=$oficinaId&encabezado_registro_id=',encabezado_registro_id,'\">-></a>') AS encabezado_registro_id,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = e.empresa_id)) AS empresa,(SELECT codigo_centro FROM oficina WHERE oficina_id = e.oficina_id) AS oficina_codigo,(SELECT nombre FROM oficina WHERE oficina_id = e.oficina_id) AS oficina_nombre,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS documento,consecutivo,(SELECT nombre FROM forma_pago WHERE forma_pago_id = e.forma_pago_id) AS forma_pago,(SELECT CONCAT(numero_identificacion,'-',IF(razon_social IS NULL,CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido),razon_social)) FROM tercero WHERE tercero_id = e.tercero_id) AS tercero,(SELECT codigo_puc FROM puc WHERE puc_id = e.puc_id) AS codigo_puc,e.fecha,DATE(e.fecha_registro) as fecha_creacion,e.modifica FROM encabezado_de_registro e WHERE estado = 'C' ORDER BY e.fecha DESC";

   

     return $Query;

   }

   

}







?>