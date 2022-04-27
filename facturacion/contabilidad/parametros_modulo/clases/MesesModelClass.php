<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class MesesModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
  

  	  $periodo_contable_id 			= $this -> requestDataForQuery('periodo_contable_id','text');
	  $mes 							= $this -> requestDataForQuery('mes','text');
	  $nombre						= $this -> requestDataForQuery('nombre','text');
	  $estado    					= $this -> requestDataForQuery('estado','integer');
	  $oficina_id    				= $this -> requestDataForQuery('oficina_id','integer');
	  
	  $select_con = "SELECT * FROM mes_contable  WHERE periodo_contable_id = $periodo_contable_id AND mes=$mes AND nombre=$nombre AND estado=1 AND oficina_id=$oficina_id";	  
	  $result_con = $this -> DbFetchAll($select_con,$Conex); 
	 
	 if($result_con > 1){
		 
			exit(' Ya existe un mes contable creado con las mismas caracteristicas, por favor revise. ');
		
		 }else{
			 
			 $this -> DbInsertTable("mes_contable",$Campos,$Conex,true,false);
			 
			 }
   
    
	
  }

  public function validarPeriodo($mes_contable_id,$Conex){
    
    $select = "SELECT pc.periodo_contable_id,pc.estado,mc.nombre,pc.anio FROM mes_contable mc, periodo_contable pc WHERE mc.periodo_contable_id = pc.periodo_contable_id AND mc.mes_contable_id = $mes_contable_id";
    
    $result = $this -> DbFetchAll($select,$Conex,true);

    return $result;
  }
	
  public function Update($Campos,$Conex){	

    $this -> DbUpdateTable("mes_contable",$Campos,$Conex,true,false);

  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("mes_contable",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"mes_contable",$Campos);
	 
	 return $Data -> GetData();
   }
   
	 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
     
    public function GetQueryMesesGrid(){
	   	   
   $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id  = p.empresa_id)) AS empresa,
   (SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina,
   p.anio,m.mes,fecha_inicio,fecha_final,
   (CASE m.estado WHEN 0 THEN 'BLOQUEADO' WHEN 1 THEN 'DISPONIBLE' ELSE 'CERRADO' END) AS estado 
   FROM mes_contable m, periodo_contable p WHERE m.periodo_contable_id = p.periodo_contable_id";
   
   return $Query;
   }
   
   
 
}





?>