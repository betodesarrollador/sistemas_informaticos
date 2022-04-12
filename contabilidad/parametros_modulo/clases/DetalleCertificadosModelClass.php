<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DetalleCertificadosModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){
	$this -> DbInsertTable("cuentas_certificado",$Campos,$Conex,true,false); 
	
	return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
     $this -> DbUpdateTable("cuentas_certificado",$Campos,$Conex,true,false);  		
		
  }
  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("cuentas_certificado",$Campos,$Conex,true,false);  
  }
      
  public function getDetallesCertificados($Conex){
  
	$certificados_id = $this -> requestDataForQuery('certificados_id','integer');
	
	if(is_numeric($certificados_id)){
	
		$select  = "SELECT 
		              cuentas_certificado.cuentas_certificado_id,
					  cuentas_certificado.certificados_id,
					  cuentas_certificado.puc_id,
					  CONCAT_WS(' - ',puc.codigo_puc,puc.nombre) AS nombre
		            FROM 
					 cuentas_certificado
					INNER JOIN 
					 puc ON cuentas_certificado.puc_id = puc.puc_id 
					WHERE
					 cuentas_certificado.certificados_id = $certificados_id
					ORDER BY 
					 puc.nombre ASC";	
					
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
   
}

?>