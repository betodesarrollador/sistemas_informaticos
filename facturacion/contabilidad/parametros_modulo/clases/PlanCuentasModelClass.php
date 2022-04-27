<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class PlanCuentasModel extends Db{
	
  private $cuentasMovimientoId;
  private $cuentasMenoresId;
  public function SetUsuarioId($usuario_id,$oficina_id){	    
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getPlan($Conex){
		
		$select="SELECT codigo_puc, 
		                nombre,
						naturaleza,
						nivel,
						IF(requiere_centro_costo=1,'SI','NO')as requiere_centro,
						IF(requiere_sucursal=1,'SI','NO')as requiere_sucursal,
						IF(requiere_tercero=1,'SI','NO')as requiere_tercero,
						IF(area=1,'SI','NO')as requiere_area,
						IF(departamento=1,'SI','NO')as requiere_departamento,
						IF(unidadnegocio=1,'SI','NO')as requiere_unidadnegocio,
						IF(contrapartida=1,'SI','NO')as contrapartida,
						CASE estado WHEN 'A' THEN 'ACTIVA' WHEN 'I' THEN 'INACTIVA' END AS estado
						FROM puc	
						
						ORDER BY codigo_puc ASC";
						
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}
  
  		
  public function Save($Campos,$Conex){	
    
	$codigo_puc   = $this -> requestData('codigo_puc');
    $empresa_id   = $this -> requestData('empresa_id');		
    $codigoCuenta = $this -> selectCuentaPuc($codigo_puc,$empresa_id,$Conex);
	
	if($codigoCuenta > 0){
	  exit('Codigo ya existe para la empresa seleccionada');
    }else{
        $this -> DbInsertTable("puc",$Campos,$Conex,true,false);  
	 }
	
  }
  
  public function cuentaTieneMovimientos($puc_id,$Conex){
	  
	  $puc_id = $this -> getCuentasMenores($puc_id,$Conex);
	  $select = "SELECT * FROM imputacion_contable WHERE puc_id IN ($puc_id)";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  if(count($result)  > 0){
        return true;
      }else{
		  return false;
	   }
	  
  }
  
  private function getEmpresaCuenta($puc_id,$Conex){
	  
	  $select = "SELECT empresa_id FROM puc WHERE puc_id = $puc_id";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result[0]['empresa_id'];
  }
  
	
  public function Update($Campos,$Conex){	
  
    $this -> Begin($Conex);
  
      $this -> DbUpdateTable("puc",$Campos,$Conex,true,false);
      $empresa_id = $this -> requestDataForQuery("empresa_id","integer");
      $puc_id     = $this -> requestDataForQuery("puc_id","integer");
      $estado     = $this -> requestDataForQuery("estado","char");	
	
	  if(!$this -> GetNumError() > 0){
		$empresaActualId = $this -> getEmpresaCuenta($puc_id,$Conex);
        $cuentasMenores  = $this -> getCuentasMenores($puc_id,$Conex);		
		if($this -> cuentaTieneMovimientos($puc_id,$Conex) && $empresaActualId != $empresa_id){
          $this -> RollBack($Conex);
		  exit('No se permite cambiar cuenta de empresa');
			
        }
		
	  
	  }
	  
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
	  
    $this -> Begin($Conex);	  
 
      if($this -> cuentaTieneMovimientos($puc_id,$Conex)){
		  exit('No se Permite Borrar esta Cuenta ! Tiene Movimiento ');
      }else{
		  
		  $cuentasMenores  = $this -> getCuentasMenores($puc_id,$Conex);		
		  
		  if(strlen(trim($cuentasMenores)) > 0){
			exit('Debe Borrar Primero las cuentas Menores');
		  }else{
   	          $this -> DbDeleteTable("puc",$Campos,$Conex,true,false);		  			  
			}
		  
         }
	
	$this -> Commit($Conex);	
	
  }	
  
  public function getEmpresas($usuario_id,$Conex){
	  
    $select = "SELECT empresa.empresa_id AS value,tercero.razon_social AS text 
				   FROM tercero,empresa  WHERE tercero.tercero_id = empresa.tercero_id AND empresa_id IN (SELECT empresa_id FROM 
                   empresa_usuario WHERE usuario_id = $usuario_id)";
	$result = $this -> DbFetchAll($select,$Conex);
		 
	return $result;
	  
  }
		
  public function selectCuentaPuc($codigo_puc,$empresa_id,$Conex){
   
	   $select = "SELECT * FROM puc WHERE TRIM(codigo_puc) LIKE TRIM('$codigo_puc') AND empresa_id = $empresa_id ";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   if(count($result) > 0){
	     return $result[0]['puc_id'];
	   }else{
	       return 0;
	    }
	   
   }
   /************************************************************************************* */ 
   // funcion selectNivelSuperior
	
   public function selectNivelSuperior($codigo_puc,$nivelSuperior,$empresa_id,$Conex){ // funcion que consulta a la tabla puc
   
	   $select = "SELECT puc_id FROM puc WHERE codigo_puc LIKE ('$codigo_puc') AND empresa_id = $empresa_id AND nivel=$nivelSuperior";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   if(count($result) > 0){
	     return $result[0]['puc_id'];
	   }else{
	       return 0;
	    }
	   
   }
 
   
    public function selectDataCuentaPuc($puc_id,$empresa_id,$Conex){
   
	   $select = "SELECT p.*,(SELECT nombre FROM puc WHERE puc_id = p.puc_id) AS nombre,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_puc_id) AS puc_puc 
	   FROM puc p WHERE puc_id LIKE $puc_id AND empresa_id = $empresa_id ";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
       return $result;
	   
   }   
   
   // funcion selectPucSuperior
   public function selectPucSuperior($puc_id,$empresa_id,$Conex){
   
	   $select = "SELECT CONCAT(p.codigo_puc,' - ',p.nombre) AS puc_puc, puc_id AS puc_puc_id FROM puc p WHERE puc_id LIKE $puc_id AND empresa_id = 1 ";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
       return $result;
	   
   }   

    public function selectValidaCuentaSuperior($codigo_puc,$empresa_id,$Conex){
   
	   $select = "SELECT p.nivel
	   FROM puc p WHERE codigo_puc LIKE $codigo_puc AND empresa_id = $empresa_id ";
	   
	   $result = $this -> DbFetchAll($select,$Conex,true);
	   
       return $result;
	   
   } 

   public function selectValidarNivel($puc_id,$Conex){
   
	   $select = "SELECT p.nivel FROM puc p WHERE p.puc_id=$puc_id";
	  
	   $result = $this -> DbFetchAll($select,$Conex,true);
	   
       return $result;
	   
   } 
   
   public function selectPlanCuentas($puc_id,$Conex){
	   
	   $select = "SELECT p.*,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_puc_id) AS puc_puc FROM puc p 
	   WHERE puc_id = $puc_id ";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
   
   public function getEmpresasPuc($usuario_id,$Conex){
	   
	  $select = "SELECT empresa.empresa_id,tercero.razon_social FROM empresa,tercero WHERE tercero.tercero_id = empresa.tercero_id
	  AND empresa.empresa_id IN (SELECT empresa_id FROM puc) AND empresa.empresa_id IN (SELECT empresa_id FROM empresa_usuario WHERE      usuario_id = $usuario_id)"; 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;
	   
   }
   
   public function getCuentasTree($empresa_id,$Conex){
   
     $select = "SELECT p.*,
	           (SELECT CONCAT(codigo_puc,' - ',nombre)FROM puc WHERE puc_id = p.puc_id) AS puc_puc,
			   (CASE p.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
			    FROM puc p WHERE 
	            puc_puc_id IS NULL AND estado LIKE 'A' AND empresa_id = $empresa_id  ORDER BY codigo_puc ASC";
	 
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }
   
   
   public function getChildren($IdParent,$Conex){
   
     $select = "SELECT p.*,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_id) AS puc_puc,
	           (CASE p.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
	           FROM puc p WHERE 
	 puc_puc_id = $IdParent AND estado = 'A' ORDER BY codigo_puc ASC";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 return $result;
   
   }   
   
   public function getCuentasMovimiento($cuentaSuperiorId,$Conex){
	  $this -> cuentasMovimientoId = null;
	  $this -> setCuentasInferiores($cuentaSuperiorId,$Conex);
	  
	  return substr($this -> cuentasMovimientoId,1,strlen($this -> cuentasMovimientoId));	   
	   
   }
   
   public function getCuentasMenores($cuentaSuperiorId,$Conex){
	   
   	  $this -> cuentasMenoresId = null;
	  $this -> setCuentasInferiores($cuentaSuperiorId,$Conex);
	  
	  if(strlen(trim($this -> cuentasMenoresId)) > 0){
	    return substr($this -> cuentasMenoresId,1,strlen($this -> cuentasMenoresId));	   
	  }else{
		  return $cuentaSuperiorId;	   
        }
	   
   }
   
   private function setCuentasInferiores($cuentaSuperiorId,$Conex){
	   
	   $select = "SELECT * FROM puc WHERE puc_puc_id = $cuentaSuperiorId ORDER BY codigo_puc ASC";
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   for($i = 0; $i < count($result); $i++){
		   
		   $cuentaMayorId             = $result[$i]['puc_id'];
		   $movimiento                = $result[$i]['movimiento'];
		   $this -> cuentasMenoresId .= ','.$cuentaMayorId;
		   
		   if($movimiento == 1){
			 $this -> cuentasMovimientoId .= ','.$cuentaMayorId;
		   }else{
               $this -> setCuentasInferiores($cuentaMayorId,$Conex);
		    }
		   
       }
	   
   }
   
}
?>