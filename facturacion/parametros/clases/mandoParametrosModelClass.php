<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class mandoParametrosModel extends Db{
  private $Permisos;

//// GRID ////
  public function getQueryMandoParametrosGrid(){

	$Query = "SELECT p.parametros_factura_id AS parametros_factura_id,
	         p.resolucion_dian AS resolucion_dian,
	         DATE_FORMAT(p.fecha_resolucion_dian,'%m-%d-%Y') AS fecha_resolucion_dian,
             (SELECT t.nombre_tipo_factura FROM tipo_factura t WHERE t.tipo_factura_id=p.tipo_factura_id)AS tipo_factura,
             p.rango_inicial,
             p.rango_final,
	         (SELECT TIMESTAMPDIFF(DAY,(p.fecha_resolucion_dian),NOW())) AS dias,
             (CASE p.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado 
         
     FROM parametros_factura p WHERE p.estado = 'A' ORDER BY p.fecha_resolucion_dian ASC";
    
     return $Query;
     
   }

   public function SelectVencimientosElectronica($Conex){

	$select = "SELECT p.parametros_factura_id, 
                      p.resolucion_dian,
	                  p.rango_inicial,
                      p.rango_final
                      
     FROM parametros_factura p WHERE p.estado = 'A' AND p.tipo_factura_id=3 ORDER BY p.fecha_resolucion_dian DESC LIMIT 1";
	 $result = $this -> DbFetchAll($select,$Conex);
     $dataFactura[0]['parametro'] = $result;
     

     $select = "SELECT f.consecutivo_factura FROM factura f WHERE f.tipo_factura_id=3 ORDER BY consecutivo_factura DESC LIMIT 1";
     $result = $this -> DbFetchAll($select,$Conex);
     $dataFactura[0]['consecutivo'] = $result;

	 if($dataFactura>0){
       return $dataFactura;
	 }
     
     
   }

public function SelectVencimientosDigital($Conex){

	$select = "SELECT p.parametros_factura_id, 
                      p.resolucion_dian,
	                  p.rango_inicial,
                      p.rango_final
                      
     FROM parametros_factura p WHERE p.estado = 'A' AND p.tipo_factura_id=2 ORDER BY p.fecha_resolucion_dian DESC LIMIT 1";
	 $result = $this -> DbFetchAll($select,$Conex);
     $dataFactura[0]['parametroDigital'] = $result;
     

     $select = "SELECT f.consecutivo_factura FROM factura f WHERE f.tipo_factura_id=2 ORDER BY consecutivo_factura DESC LIMIT 1";
     $result = $this -> DbFetchAll($select,$Conex);
     $dataFactura[0]['consecutivoDigital'] = $result;

	 if($dataFactura>0){
       return $dataFactura;
	 }
     
     
   }

}
?>