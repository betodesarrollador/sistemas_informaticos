<?php
require_once("../../../../framework/clases/DbClass.php");
require_once("../../../../framework/clases/PermisosFormClass.php");
final class ParametrosModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosParametrosId($cuenta_tipo_pago_id,$Conex){
     $select    = "SELECT 	c.cuenta_tipo_pago_id,
	 						c.forma_pago_id,
							c.puc_id,
							(SELECT CONCAT_WS(' - ',codigo_puc,nombre) AS puc_tot FROM puc  WHERE puc_id = c.puc_id) AS puc,
							c.cuenta_tipo_pago_natu
					FROM cuenta_tipo_pago c  
	                WHERE c.cuenta_tipo_pago_id = $cuenta_tipo_pago_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	
    $this -> Begin($Conex);
					
	  $cuenta_tipo_pago_id    = $this -> DbgetMaxConsecutive("cuenta_tipo_pago","cuenta_tipo_pago_id",$Conex,true,1);
	
      $this -> assignValRequest('cuenta_tipo_pago_id',$cuenta_tipo_pago_id);
      $this -> DbInsertTable("cuenta_tipo_pago",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['cuenta_tipo_pago_id'] == 'NULL'){
	    $this -> DbInsertTable("cuenta_tipo_pago",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("cuenta_tipo_pago",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("cuenta_tipo_pago",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"cuenta_tipo_pago",$Campos);
	 return $Data -> GetData();
   }
	public function getFormasPago($Conex){
		
		$select = "SELECT forma_pago_id AS value,nombre AS text FROM forma_pago ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);
		
		return $result;
		
	}
   public function GetQueryParametrosGrid(){
	   	   
   $Query = "SELECT 
			c.cuenta_tipo_pago_id,
			(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id) AS forma,
			(SELECT CONCAT_WS(' - ',codigo_puc,nombre) AS puc_tot FROM puc  WHERE puc_id = c.puc_id) AS puc,
			IF(c.cuenta_tipo_pago_natu='C','CREDITO','DEBITO') AS cuenta_tipo_pago_natu
		FROM cuenta_tipo_pago  c ";
   return $Query;
   }
}
?>