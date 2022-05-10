<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reportesNovedadesFijasModel extends Db {

    private $UserId;
    private $Permisos;

    public function SetUsuarioId($UserId, $CodCId) {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($UserId, $CodCId);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex) {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function GetSi_Pro($Conex) {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }

    public function GetSi_Pro2($Conex) {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }
	  //Generar exel todos los empleados

	  public function getReporteMC1($desde,$hasta,$Conex){ 									

	    $select = "SELECT n.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e, contrato c
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id AND c.contrato_id = n.contrato_id)AS contrato_id,
				 
				 (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = n.tercero_id ) as numero_identificacion,
				  
				  CASE n.tipo_novedad WHEN 'v' THEN 'DEVENGADO' WHEN 'D' THEN 'DEDUCIDO'  END AS tipo_novedad,
				 
				 CASE n.periodicidad WHEN 'M' THEN 'MENSUAL' WHEN 'Q' THEN 'QUINCENAL' WHEN 'S' THEN 'SEMANAL' END AS periodicidad,
				     CASE n.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO'  END AS estado,
				  
				  CASE n.concepto_area_id WHEN '3' THEN 'BONIFICACION' WHEN '1' THEN 'DESCUENTO DE PAGO PRONTO' WHEN '4' THEN 'PRESTAMOS A EMPLEADOS' WHEN '2' THEN 'VIATICOS' END AS concepto_area_id
				 
				 From novedad_fija n";
		//exit($select);
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(novedad_fija_id=>$items[novedad_fija_id],concepto=>$items[concepto],fecha_novedad=>$items[fecha_novedad],fecha_inicial=>$items[fecha_inicial],fecha_final=>$items[fecha_final],cuotas=>$items[cuotas],valor=>$items[valor],valor_cuota=>$items[valor_cuota],periodicidad=>$items[periodicidad],tipo_novedad=>$items[tipo_novedad],estado=>$items[estado],contrato_id=>$items[contrato_id],tercero_id=>$items[tercero_id],concepto_area_id=>$items[concepto_area_id],encabezado_registro_id=>$items[encabezado_registro_id],factura_proveedor_id=>$items[factura_proveedor_id],documento_anexo=>$items[documento_anexo],numero_identificacion=>$items[numero_identificacion]);
		$i++;
		}
		
		return $result;
  } 
  
	public function getReporteMC2($empleado_id,$desde,$hasta,$Conex){ 

	     $select = "SELECT n.*,(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e, contrato c
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id AND c.contrato_id = n.contrato_id )AS contrato_id, (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = n.tercero_id ) as numero_identificacion,
				 
				  CASE n.tipo_novedad WHEN 'v' THEN 'DEVENGADO' WHEN 'D' THEN 'DEDUCIDO'  END AS tipo_novedad,
				 
				 CASE n.periodicidad WHEN 'M' THEN 'MENSUAL' WHEN 'Q' THEN 'QUINCENAL' WHEN 'S' THEN 'SEMANAL' END AS periodicidad,
				     CASE n.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO'  END AS estado,
				  
				  CASE n.concepto_area_id WHEN '3' THEN 'BONIFICACION' WHEN '1' THEN 'DESCUENTO DE PAGO PRONTO' WHEN '4' THEN 'PRESTAMOS A EMPLEADOS' WHEN '2' THEN 'VIATICOS' END AS concepto_area_id
				 
				  From  novedad_fija n WHERE n.contrato_id = (SELECT contrato_id FROM contrato WHERE empleado_id =$empleado_id AND estado ='A') AND n.fecha_inicial >= DATE('$desde') AND n.fecha_final <= DATE('$hasta') ";
				  
				 
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(novedad_fija_id=>$items[novedad_fija_id],concepto=>$items[concepto],fecha_novedad=>$items[fecha_novedad],fecha_inicial=>$items[fecha_inicial],fecha_final=>$items[fecha_final],cuotas=>$items[cuotas],valor=>$items[valor],valor_cuota=>$items[valor_cuota],periodicidad=>$items[periodicidad],tipo_novedad=>$items[tipo_novedad],estado=>$items[estado],contrato_id=>$items[contrato_id],tercero_id=>$items[tercero_id],concepto_area_id=>$items[concepto_area_id],encabezado_registro_id=>$items[encabezado_registro_id],factura_proveedor_id=>$items[factura_proveedor_id],documento_anexo=>$items[documento_anexo],numero_identificacion=>$items[numero_identificacion]);
		$i++;
		}
		
		return $result;
  } 


    public function getReporteMC3($cargo_id, $desde, $hasta, $Conex) {

        $select = "SELECT 
				 c.numero_contrato,
				 c.fecha_inicio,
				 c.fecha_terminacion,
				 c.fecha_terminacion_real,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion,
				c.sueldo_base,
				c.subsidio_transporte,
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE  c.cargo_id IN ($cargo_id) AND c.fecha_inicio BETWEEN '$desde' AND '$hasta' ORDER BY c.numero_contrato";

        //echo $select;		  
        $results = $this->DbFetchAll($select, $Conex, true);
        return $results;
    }

    public function getReporteMC4($empleado_id, $cargo_id, $desde, $hasta, $Conex) {

        $select = "SELECT
				 c.numero_contrato,
				 c.fecha_inicio,
				 c.fecha_terminacion,
				 c.fecha_terminacion_real,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion,
				c.sueldo_base,
				c.subsidio_transporte,
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE c.empleado_id IN ($empleado_id) AND c.cargo_id IN ($cargo_id) AND c.fecha_inicio BETWEEN '$desde' AND '$hasta' ORDER BY c.numero_contrato";

        //echo $select;		  
        $results = $this->DbFetchAll($select, $Conex, true);
        return $results;
    }

}

?>