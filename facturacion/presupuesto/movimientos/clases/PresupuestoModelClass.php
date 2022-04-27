<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PresupuestoModel extends Db{

  public function getPeriodosContables($Conex){
    
    $select = "SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable 
               WHERE estado = 1";
               
    $result = $this->DbFetchAll($select,$Conex);
    
    return $result;                    
    
  }
  
  public function selectPresupuesto($presupuesto_id,$Conex){
    
    $select = "SELECT * FROM presupuesto WHERE presupuesto_id = $presupuesto_id";
    
    $result = $this -> DbFetchAll($select,$Conex,true);
    
    return $result;
    
  }
  
  public function Save($Campos,$conex){
    
    $result = $this -> DbInsertTable('presupuesto',$Campos,$conex,true,false);
    
    return $this -> getConsecutiveInsert();
    
  }
  
  public function Update($Campos,$Conex){
    
    $this -> DbUpdateTable('presupuesto',$Campos,$conex,true,false);    
    
  }
  
  public function Delete($Campos,$Conex){
    
    $presupuesto_id = $this -> requestData('presupuesto_id');
    $this -> Begin($Conex);
    
     $delete = "DELETE FROM detalle_presupuesto WHERE presupuesto_id = $presupuesto_id";
     
     $this -> query($delete,$Conex);
     
     $delete = "DELETE FROM presupuesto WHERE presupuesto_id = $presupuesto_id";
     
     $this -> query($delete,$Conex);
     
    $this -> Commit($Conex);
    
  }    
   
}


?>