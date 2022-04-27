<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportePresupuestoModel extends Db{
			
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }


  public function getReportePresupuestos($Conex){
    
    $select = "SELECT presupuesto.presupuesto_id AS value, periodo_contable.anio AS text 
               FROM presupuesto LEFT JOIN periodo_contable ON presupuesto.periodo_contable_id 
               = periodo_contable.periodo_contable_id ORDER BY periodo_contable.anio DESC";
               
    $result = $this->DbFetchAll($select,$Conex);
    
    return $result;                    
    
  }
    
   
}


?>