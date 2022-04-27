<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CierreDTAModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getZonasFrancas($Conex){
  
      $select = "SELECT zonas_francas_id AS value,nombre AS text FROM zonas_francas ORDER BY nombre ASC";
      $result = $this -> DbFetchAll($select,$Conex,true);
   
      return $result;  
  }
  		
  public function Update($Campos,$Conex){	   
    $this -> assignValRequest('estado_dta','C');  	  
    $this -> DbUpdateTable("dta",$Campos,$Conex,true,false);	
  }
				 	
   public function selectCierreDTA($busqueda,$valor,$Conex){
      
	  if($busqueda == 'numero_formulario'){
	  
        $select = "SELECT d.*,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = d.manifiesto_id) AS manifiesto,(SELECT despacho FROM  
		despachos_urbanos WHERE despachos_urbanos_id = d.despachos_urbanos_id) AS despacho FROM dta d WHERE TRIM(numero_formulario) 
		 = TRIM('$valor')";	 
        $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	  	  
	  
	  }else if($busqueda == 'manifiesto'){
	  
          $select = "SELECT d.*,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = d.manifiesto_id) AS manifiesto,(SELECT despacho FROM  
		  despachos_urbanos WHERE despachos_urbanos_id = d.despachos_urbanos_id) AS despacho FROM dta d WHERE manifiesto_id  = (
		  SELECT manifiesto_id FROM manifiesto WHERE TRIM(manifiesto) = TRIM('$valor'))";	 
          $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	  	  
	  
	   }else if($busqueda == 'despacho'){
	   
            $select = "SELECT d.*,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = d.manifiesto_id) AS manifiesto,
			(SELECT despacho FROM  despachos_urbanos WHERE despachos_urbanos_id = d.despachos_urbanos_id) AS despacho FROM 
			dta d WHERE  despachos_urbanos_id  = (SELECT despachos_urbanos_id FROM despachos_urbanos  WHERE TRIM(despacho) = TRIM('$valor'))";	 
            $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	  	  	   	   
	   
	     }
	  
   
      return $result;
      
   }
    
   
   public function getQueryCierreDTAGrid(){
	   	   
     $Query = "SELECT cliente,numero_formulario,estado_dta,fecha_consignacion,fecha_entrega_dta,numero_contenedor_dta,naviera,tara,tipo,(SELECT nombre FROM zonas_francas WHERE   
	 zonas_francas_id = d.zonas_francas_id) AS zonas_francas_id,numero_precinto,codigo,producto,peso,responsable_dian ,responsable_empresa,observaciones_dta,
	 fecha_cierre,responsable_dian_entrega,responsable_empresa_entrega,novedades FROM dta d ORDER BY numero_formulario ASC";
   
     return $Query;
   }
   

}


?>