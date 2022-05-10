<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosArqueoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$oficina_id,$Conex){	
    
	$parametros_legalizacion_arqueo_id = $this -> DbgetMaxConsecutive("parametros_legalizacion_arqueo","parametros_legalizacion_arqueo_id",$Conex,false,1);		
	$this -> assignValRequest('parametros_legalizacion_arqueo_id',$parametros_legalizacion_arqueo_id);	
	$this -> Begin($Conex);	
		$this -> DbInsertTable("parametros_legalizacion_arqueo",$Campos,$Conex,true,false);
		
		if($this -> GetNumError() > 0){
			$this -> RollBack($Conex);	
			return false;
		}else{		
			$this -> Commit($Conex);	
			return true;	
		
		}	
		
  }
	
  public function Update($Campos,$Conex){			
	$this -> Begin($Conex);	
	    $parametros_legalizacion_arqueo_id = $_REQUEST['parametros_legalizacion_arqueo_id'];	
		$this -> DbUpdateTable("parametros_legalizacion_arqueo",$Campos,$Conex,true,false);

		if($this -> GetNumError() > 0){
			$this -> RollBack($Conex);	
			return false;
		}else{		   
			$this -> Commit($Conex);
		}
  }
	
  public function Delete($Campos,$Conex){  
  	$this -> DbDeleteTable("parametros_legalizacion_arqueo",$Campos,$Conex,true,false);	
  }	
			 	
   public function getEmpresas($usuario_id,$Conex){   
     $select = "SELECT e.empresa_id AS value,CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text 
	 FROM empresa e,tercero t WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 	 
	 return $result;   
   }				
				
	   
   public function selectParametrosArqueo($parametros_legalizacion_arqueo_id,$Conex){	   	   	  
	$dataParametros = array();    				
    $select = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS contrapartida,
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.ini_puc_id) AS inicontrapartida,
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.ini2_puc_id) AS ini2contrapartida,
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.ini3_puc_id) AS ini3contrapartida,	
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.ini4_puc_id) AS ini4contrapartida,		
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.ini5_puc_id) AS ini5contrapartida,			
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.ini6_puc_id) AS ini6contrapartida,				
	p.* FROM parametros_legalizacion_arqueo p WHERE parametros_legalizacion_arqueo_id = $parametros_legalizacion_arqueo_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	$dataParametros[0]['parametros_legalizacion_arqueo'] = $result;	
	return $dataParametros;   		   
   }
   
   public function selectOficinasEmpresa($empresa_id,$oficina_id,$Conex){   
     $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);   
     return $result;   
   }
   
   public function getQueryParametrosArqueoGrid(){	   	   
	$Query = "SELECT 
	(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,
	(SELECT nombre FROM oficina WHERE oficina_id = p.oficina_id) AS oficina,
	(SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS codigo_puc,
	p.nombre_puc
	FROM parametros_legalizacion_arqueo p ORDER BY oficina";   
     return $Query;
   }  

}

?>