<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosModuloModel extends Db{
   
   public function getCuentasTree($empresa_id,$Conex){
   
     $select = "SELECT p.*, CONCAT(p.codigo_puc,' - ',p.nombre)  AS puc_puc 
     FROM puc p WHERE 	 puc_puc_id IS NOT NULL AND estado LIKE 'A' AND empresa_id = $empresa_id AND movimiento=1 AND SUBSTRING(p.codigo_puc,1,1)IN (4,5,6,7) ORDER BY codigo_puc";
	 
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }   
   
   public function getChildren($IdParent,$Conex){
   
     $select = "SELECT p.*,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_id) AS puc_puc FROM puc p WHERE 
	 puc_puc_id = $IdParent AND estado = 'A'";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }  
   
   public function marcarCuentaPresupuestar($puc_id,$presupuestar,$Conex){
    
      $update = "UPDATE puc SET presupuestar = $presupuestar WHERE puc_id = $puc_id";
      $this->query($update,$Conex);
      
    
   } 
      
}

?>