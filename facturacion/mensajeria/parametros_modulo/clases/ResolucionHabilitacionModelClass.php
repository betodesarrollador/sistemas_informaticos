<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ResolucionHabilitacionModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("resolucion_habilitacion_men",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("resolucion_habilitacion_men",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("resolucion_habilitacion_men",$Campos,$Conex,true,false);
  }
  
  public function selectResolucionHabilitacion($Conex){
	  
	 $empresa_id = $_REQUEST['empresa_id']; 
	 
	 $select = "SELECT * FROM resolucion_empresa WHERE empresa_id = $empresa_id"; 
	 $result = $this -> DbFetchAll($select,$Conex,false); 

     return count($result);	  
	  
  }
  
  public function selectResolucionHabilitacionModel($Conex){
	  
	  $habilitacion_id = $_REQUEST['habilitacion_id'];
	  $select          = "SELECT * FROM resolucion_habilitacion_men WHERE habilitacion_id =   
	                      $habilitacion_id";
   	  $resolucion      = $this -> DbFetchAll($select,$Conex,false);
	  
	  if(count($resolucion) > 0){
		 		 
            $empresa_id  = $resolucion[0]['empresa_id'];
            $select      = "SELECT SUM(total_rango_manif) AS total FROM rango_manifiesto WHERE  
		                 empresa_id = $empresa_id";
     	    $result      = $this -> DbFetchAll($select,$Conex,false);
		 
	    $rango_manif_fin = $resolucion[0]['rango_manif_fin'] ;
		 
	    if(count($result) > 0){
  	       $resolucion[0]['asignado_rango_manif']  = $result[0]['total'];			 
   	       $resolucion[0]['saldo_rango_manif']     = $rango_manif_fin - $result[0]['total'];			 	
             }else{
 		   $resolucion[0]['asignado_rango_manif']  = 0;
   		   $resolucion[0]['saldo_rango_manif']     = $rango_manif_fin;			 			   	
                 }
		 
		  
		 		 
            $empresa_id  = $resolucion[0]['empresa_id'];
            $select      = "SELECT SUM(total_rango_despacho_urbano) AS total FROM rango_despacho_urbano WHERE  
		                 empresa_id = $empresa_id";
     	    $result      = $this -> DbFetchAll($select,$Conex,false);
		 
	    $rango_despacho_urbano_fin = $resolucion[0]['rango_despacho_urbano_fin'] ;
		 
	    if(count($result) > 0){
  	       $resolucion[0]['asignado_rango_despacho_urbano']  = $result[0]['total'];			 
   	       $resolucion[0]['saldo_rango_despacho_urbano']     = $rango_despacho_urbano_fin - $result[0]['total'];		 	
             }else{
 		   $resolucion[0]['asignado_rango_despacho_urbano']  = 0;
   		   $resolucion[0]['saldo_rango_despacho_urbano']     = $rango_despacho_urbano_fin;			 			   	
                 }
		 
		 		 
            $empresa_id  = $resolucion[0]['empresa_id'];
            $select      = "SELECT SUM(total_rango_remesa) AS total FROM rango_remesa WHERE  
		                 empresa_id = $empresa_id";
     	    $result      = $this -> DbFetchAll($select,$Conex,false);
		 
	    $rango_remesa_fin = $resolucion[0]['rango_remesa_fin'] ;
		 
	    if(count($result) > 0){
  	       $resolucion[0]['asignado_rango_remesa']  = $result[0]['total'];			 
   	       $resolucion[0]['saldo_rango_remesa']     = $rango_remesa_fin - $result[0]['total'];		 	
             }else{
 		   $resolucion[0]['asignado_rango_remesa']  = 0;
   		   $resolucion[0]['saldo_rango_remesa']     = $rango_remesa_fin;			 			   	
                 }
		 
		  
          }
	  	 		 
   	  return $resolucion;  
	  
  }
	 	
  public function getEmpresas($usuario_id,$Conex){
   
    $select = "SELECT 
	 			e.empresa_id AS value,
	 				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				AS text 
				FROM empresa e,tercero t 
	 			WHERE t.tercero_id = e.tercero_id 
				AND e.empresa_id IN 
					(SELECT empresa_id 
					 FROM oficina 
					 WHERE oficina_id IN 
					 	(SELECT oficina_id 
						 FROM opciones_actividad 
						 WHERE usuario_id = $usuario_id)
					)";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
	return $result;
  }
	 	
  public function getCodRegional($Conex){
   
    $select = "SELECT 
				ubicacion_id AS value,
				nombre AS text
				FROM ubicacion
				WHERE tipo_ubicacion_id=2
				ORDER BY nombre";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
	return $result;
  }
 

//BUSQUEDA


//// GRID ////
  public function getQueryResolucionHabilitacionGrid(){
	   	   
     $Query = "SELECT 
	 				(SELECT razon_social FROM tercero t, empresa e WHERE r.empresa_id=e.empresa_id AND e.tercero_id=t.tercero_id) 
				AS empresa,
				habilitacion,
				fecha_habilitacion,
					(SELECT nombre FROM ubicacion u WHERE r.codigo_regional=u.ubicacion_id)
				AS regional,
				codigo_empresa
	 			FROM resolucion_habilitacion_men r";
   
     return $Query;
   }
   
}



?>