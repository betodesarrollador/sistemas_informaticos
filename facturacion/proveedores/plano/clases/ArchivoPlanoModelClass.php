<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ArchivoPlanoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
   public function GetOficina($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,
	$ErrDb = false);
   }

	
   public function GetTipo($Conex){
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes' ));
	return $opciones;
   }
   
public function getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$Conex){

		
			$dias="DATEDIFF('$hasta',f.vence_factura_proveedor) AS dias,";		
		

		$results = $this -> DbFetchAll($select,$Conex);



		return $results;
  
  }
  
  public function generarPlano($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$Conex){
	
	$select="";
	
	$results = $this -> DbFetchAll($select,$Conex);

		return $results;
	
  
  
  
  
  }

    	
  
 
  public function GetQueryProveedoresGrid(){
	   	   
	   $Query = "SELECT 

			CONCAT_WS(' ', t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) as nombre_proveedor,numero_identificacion,
            
            p.numcuenta_proveedor, 
            
            (SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE 	tipo_cta_id=p.tipo_cta_id)
			AS tip_cuenta,
            
            IF( nombre_tercero IS NULL,CONCAT_WS(' ', t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido),nombre_tercero) as titular_cuenta,
			
            (SELECT nombre_banco FROM banco WHERE banco_id=p.banco_id) 
			AS banco, 
		
           IF ( documento_tercero IS NULL,numero_identificacion,documento_tercero )as documento_titular,

   			(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) 
			AS tipo_identificacion_id
                
                
                FROM tercero t,proveedor p 	WHERE (t.tercero_id = p.tercero_id and p.inscripcion=1 ) AND (numcuenta_proveedor is not null and  (p.banco_id is not null and p.tipo_cta_id is not null ))ORDER BY tip_cuenta desc";
   return $Query;
   }
     
}

?>