<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ParametrosMovimientosModel extends Db{

  public function selectRelacionMovimientos($Conex){

    $fecha_inicial = $_REQUEST['fecha_inicial'];
    $fecha_final   = $_REQUEST['fecha_final']; 

    $opciones_centros = $this->requestData('opciones_centros');
    $centro_de_costo_id = $this->requestData('centro_de_costo_id');
    $condicion2 = '';
    if ($opciones_centros == 'T') {
        $condicion2 = '';
    } else {
        $condicion2 = " AND i.centro_de_costo_id=$centro_de_costo_id ";
    }
    
        
    $select = "SELECT o.nombre AS sucursal,e.fecha,e.consecutivo AS numero_documento,
    t.nombre AS tipo_documento,e.estado,p.codigo_puc,
    IF(p.requiere_centro_costo = 1,'SI','NO') AS requiere_centro_costo,IF(p.requiere_tercero = 1,'SI','NO') 
    AS requiere_tercero,IF(p.movimiento = 1,'SI','NO') AS es_de_movimiento,(IF(i.tercero_id is null,'',
    (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id ))) 
    AS numero_identificacion,(IF(i.centro_de_costo_id is null,'',(SELECT nombre FROM centro_de_costo WHERE 
    centro_de_costo_id = i.centro_de_costo_id))) as centro_costo,
    i.debito,i.credito FROM encabezado_de_registro e, tipo_de_documento t, imputacion_contable i,
    puc p,oficina o WHERE e.oficina_id = o.oficina_id 
    AND e.tipo_documento_id = t.tipo_documento_id AND e.encabezado_registro_id = i.encabezado_registro_id
    AND i.puc_id = p.puc_id AND e.fecha BETWEEN '$fecha_inicial' AND '$fecha_final' $condicion2";
                        
    $relacion = $this -> DbFetchAll($select,$Conex,true);  
    
    return $relacion;    
    
  }  
   
   
}
?>