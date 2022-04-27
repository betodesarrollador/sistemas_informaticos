<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_DTAModel extends Db{

  
	public function getDTA($dta_id,$empresa_id,$Conex){
				
        $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,d.* FROM dta d WHERE dta_id = $dta_id";
		
		$result = $this -> DbFetchAll($select,$Conex);
		
		return $result;
		
    }

  
   
}


?>