<?php

ini_set("memory_limit","1024M");

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TrasladosModel extends Db{

  private $Permisos;
  private $mes_contable_id;
  private $periodo_contable_id;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }


  public function getCodigoPuc($puc_id,$Conex){
  
    $select = "SELECT codigo_puc FROM puc WHERE puc_id = $puc_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['codigo_puc'];  
  }

  public function getEmpTercero($empresa_id,$Conex){
  
    $select = "SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['tercero_id'];  
  }

  public function getDocumentos($Conex){
  
    $select = "SELECT tipo_documento_id AS value, nombre AS text FROM tipo_de_documento WHERE de_traslado = 1";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result;  
  }

  public function naturalezaorigen($puc_id,$Conex){
  
    $select = "SELECT naturaleza FROM puc WHERE puc_id = $puc_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['naturaleza'];  
  }


  
  public function selectSaldoCuentaTercero($cuenta_desde_id,$desde,$hasta,$Conex){  
  
    include_once("UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
    $arrayResult         = array();   
  
     $select = "SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
	 i.centro_de_costo_id,i.codigo_centro_costo
	 FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
	  WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
	 AND  i.puc_id = $cuenta_desde_id AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id AND i.tercero_id NOT IN (SELECT tercero_id FROM parametro_traslados WHERE estado='A')
	 GROUP BY  i.tercero_id ORDER BY e.fecha ASC";    
  
     $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	 return  $result;	        
  
  }
  
  public function Save($encabezado_registro_id,$insert_enc,$insert,$insert1,$Conex){  
  
  	$this -> Begin($Conex); 
	$this -> query($insert_enc,$Conex,true);	

	if(!strlen(trim($this -> GetError())) > 0){
		
		for($i=0;$i<count($insert);$i++){
		 	$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);

			$insert_com="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,
														  puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,
														  valor,debito,credito
													  ) VALUES(
														  $imputacion_contable_id,";
			$this -> query($insert_com.$insert[$i],$Conex,true);		

			if($this -> GetNumError() > 0){
				return false;
			}

		 	$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			$insert1_com="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,
														  puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,
														  valor,debito,credito
													  ) VALUES(
														  $imputacion_contable_id,";
			
			$this -> query($insert1_com.$insert1[$i],$Conex,true);
			if($this -> GetNumError() > 0){
				return false;
			}
				
		}
		$this -> Commit($Conex);		
		
		return $encabezado_registro_id;
	}
	
  
  }
  

  
}


?>