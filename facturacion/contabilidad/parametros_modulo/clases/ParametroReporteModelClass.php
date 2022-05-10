<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ParametroReporteModel extends Db{
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
    $this -> DbInsertTable("parametro_reporte_contable",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("parametro_reporte_contable",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("parametro_reporte_contable",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectParametroReporte($Conex){
      
      $parametro_reporte_contable_id = $this -> requestDataForQuery('parametro_reporte_contable_id','integer');
      $select         = "SELECT p.*,
	  
	  (SELECT nombre FROM puc WHERE puc_id = p.utilidad_id) as utilidad
,(SELECT nombre FROM puc WHERE puc_id = p.perdida_id) as perdida
,(SELECT nombre FROM puc WHERE puc_id = p.utilidad_cierre_id) as utilidad_cierre
,(SELECT nombre FROM puc WHERE puc_id = p.perdida_cierre_id) as perdida_cierre
	  
	   FROM parametro_reporte_contable p WHERE parametro_reporte_contable_id = $parametro_reporte_contable_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryParametroReporteGrid(){
	   	   
     $Query = "SELECT 
(SELECT nombre FROM puc WHERE puc_id = p.utilidad_id) as utilidad_id
,(SELECT nombre FROM puc WHERE puc_id = p.perdida_id) as perdida_id
,(SELECT nombre FROM puc WHERE puc_id = p.utilidad_cierre_id) as utilidad_cierre_id
,(SELECT nombre FROM puc WHERE puc_id = p.perdida_cierre_id) as perdida_cierre_id
,contador_nombres
,contador_cargo
,contador_cedula
,contador_tarjeta_profesional
,revisor_nombres
,revisor_cargo
,revisor_cedula
,revisor_tarjeta_profesional
,representante_nombres
,representante_cargo
,representante_cedula
 FROM parametro_reporte_contable p ORDER BY parametro_reporte_contable_id ASC";
     return $Query;
	 
   }
   
}

?>