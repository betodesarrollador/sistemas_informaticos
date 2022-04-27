<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class FormaPagoModel extends Db{
  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
    $this -> DbInsertTable("forma_pago",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("forma_pago",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){  
  	$this -> DbDeleteTable("forma_pago",$Campos,$Conex,true,false);	
  }				 	
   
   public function selectFormaPago($Conex){      
      $forma_pago_id = $this -> requestDataForQuery('forma_pago_id','integer');
      $select         = "SELECT * FROM forma_pago WHERE forma_pago_id = $forma_pago_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);   
      return $result;      
   }      
   
   public function getQueryFormaPagoGrid(){	   	   
     $Query = "SELECT codigo,nombre,IF(requiere_soporte = 0,'NO','SI') AS requiere_soporte,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc 
	 WHERE puc_id = c.puc_id) AS puc,IF(c.cuenta_tipo_pago_natu = 'D','DEBITO','CREDITO') AS naturaleza,(SELECT nombre_banco FROM banco WHERE banco_id = c.banco_id) banco,IF(estado = 1,'ACTIVA','INACTIVA') AS 
	 estado FROM forma_pago f, cuenta_tipo_pago c WHERE f.forma_pago_id = c.forma_pago_id ORDER BY nombre ASC";   
     return $Query;	 
   }   
}
?>