<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class CentroCostoModel extends Db{
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	

    $codigo = $_REQUEST['codigo'];

    $select="SELECT centro_de_costo_id FROM centro_de_costo WHERE codigo = $codigo";
    $result = $this -> DbFetchAll($select,$Conex);

    $centro_de_costo_id = $result[0]['centro_de_costo_id'];

      if($centro_de_costo_id>0){
        return 1;
      }else{
       $this -> DbInsertTable("centro_de_costo",$Campos,$Conex,true,false);
      }
    

	
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("centro_de_costo",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("centro_de_costo",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"centro_de_costo",$Campos);
	 
	 return $Data -> GetData();
   }
   
   public function selectCentroCosto($CentroCostoId,$Conex){
	   
	   $select = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = c.empresa_id)) as empresa,c.* FROM centro_de_costo c WHERE c.centro_de_costo_id =  $CentroCostoId";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
	 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
   
   public function getOficinas($empresa_id,$Conex){
   
     $select = "SELECT oficina_id AS value, nombre AS text FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;	 
   
   }
   
   public function getVehiculos($empresa_id,$Conex){
   
     $select = "SELECT placa_id AS value, placa AS text FROM vehiculo WHERE empresa_id = $empresa_id ORDER BY placa ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;	   
   
   }
   
    public function GetQueryEmpresasGrid(){
	   	   
   $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = c.empresa_id)) as empresa,c.codigo,c.nombre, (CASE c.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END) AS estado FROM centro_de_costo c";
   
   return $Query;
   }
   
   
 
}


?>