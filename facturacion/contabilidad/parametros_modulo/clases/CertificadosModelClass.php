<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class CertificadosModel extends Db{
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
    $this -> DbInsertTable("certificados",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("certificados",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("certificados",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectCertificados($Conex){
      
      $certificados_id = $this -> requestDataForQuery('certificados_id','integer');
      $select         = "SELECT * FROM certificados WHERE certificados_id = $certificados_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryCertificadosGrid(){
	   	   
     $Query = "SELECT 
	            certificados.nombre,
				certificados.entidad,
				certificados.decreto,
				puc.nombre AS cuenta,
				puc.codigo_puc AS puc 
			   FROM 
			    certificados 
			   LEFT JOIN
			    cuentas_certificado ON cuentas_certificado.certificados_id = certificados.certificados_id
			   LEFT JOIN 
			    puc ON puc.puc_id = cuentas_certificado.puc_id			   
			   ORDER BY certificados.nombre ASC";
   
     return $Query;
	 
   }
   
}

?>