<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DescuadresModel extends Db{
  public function selectRelacionMovimientos($Conex){
                       
    $fecha_inicial = $this ->requestData('fecha_inicial');
    $fecha_final   = $this ->requestData('fecha_final');
    $condicion     = null;
    
    if(!empty($fecha_inicial) && !empty($fecha_final)){
      $condicion = " AND e.fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ";   
    }else if(!empty($fecha_inicial) && empty($fecha_final)){
        $condicion = " AND e.fecha >= '$fecha_inicial' ";  
     }else if(empty($fecha_inicial) && !empty($fecha_final)){
          $condicion = " AND e.fecha <= '$fecha_final' ";  
     }                           
                       
    $select = "SELECT  o.nombre AS oficina,td.nombre AS tipo_documento,e.consecutivo AS documento,e.fecha,(SELECT SUM(debito) AS debito FROM imputacion_contable WHERE 
    encabezado_registro_id = e.encabezado_registro_id) AS total_debito,(SELECT SUM(credito) AS credito FROM imputacion_contable WHERE 
    encabezado_registro_id = e.encabezado_registro_id) AS total_credito,d.saldo AS descuadre FROM  encabezado_de_registro e, tipo_de_documento td,
    oficina o,(SELECT e.encabezado_registro_id,abs(sum(debito)- sum(credito)) AS saldo FROM encabezado_de_registro e, imputacion_contable i WHERE
    e.encabezado_registro_id = i.encabezado_registro_id GROUP BY e.encabezado_registro_id HAVING abs(sum(debito)- sum(credito)) > 0) d WHERE 
    d.encabezado_registro_id = e.encabezado_registro_id AND e.tipo_documento_id = td.tipo_documento_id AND e.oficina_id = o.oficina_id 
    $condicion
    ORDER BY e.fecha ASC";
        
    $relacion = $this -> DbFetchAll($select,$Conex,true);  
    
    return $relacion;    
    
  }  
   
   
}
?>