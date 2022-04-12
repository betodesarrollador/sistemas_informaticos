<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TablaImpuestosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	$this -> Begin($Conex);
		
		$tabla_impuestos_id = $this -> DbgetMaxConsecutive("tabla_impuestos","tabla_impuestos_id",$Conex,true,1);
		$this -> assignValRequest('tabla_impuestos_id',$tabla_impuestos_id);
		$this -> DbInsertTable("tabla_impuestos",$Campos,$Conex,true,false);

		
	$this -> Commit($Conex);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("tabla_impuestos",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tabla_impuestos",$Campos,$Conex,true,false);
  }
  
  
//LISTA MENU
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
  
  public function getBases($usuario_id,$Conex){

	  
	if(isset($_REQUEST['empresa_id'])){
		
	  $empresa_id = $this -> requestDataForQuery('empresa_id','integer');
		 
      $select = "(SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id = $empresa_id AND 
	             estado = 'A' ORDER BY descuento) UNION (SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento)";		
	}elseif(isset($_REQUEST['OFICINAID'])){
		 $oficina_id = $_REQUEST['OFICINAID'];
         $select = "(SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = $oficina_id) AND 
	             estado = 'A' ORDER BY descuento) UNION (SELECT tabla_impuestos_id AS value, descuento AS text FROM 
				 tabla_impuestos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento)";				
		}else{
         $select = "SELECT tabla_impuestos_id AS value, descuento AS text FROM tabla_impuestos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento";		
	  }    
	
	return $this -> DbFetchAll($select,$Conex);
  }
 

//BUSQUEDA
   public function selectTablaImpuestos($Conex){
	 
	 $tabla_impuestos_id = $this -> requestDataForQuery('tabla_impuestos_id','integer');	 
     $Query              = "SELECT * FROM tabla_impuestos WHERE tabla_impuestos_id=$tabla_impuestos_id";
     $result             =  $this -> DbFetchAll($Query,$Conex);
   
     return $result;
   }
   
   public function selectDataDescuento($usuario_id,$Conex){

	 $tabla_impuestos_id = $this -> requestDataForQuery('tabla_impuestos_id','integer');	   
	 $select       = "SELECT * FROM tabla_impuestos WHERE tabla_impuestos_id = $tabla_impuestos_id";
	   
     $result       =  $this -> DbFetchAll($select,$Conex);
   
     return $result;
	   
   }
   
   public function getImpuestos($empresa_id,$oficina_id,$Conex){

     $impuesto_id = $this -> requestData('selected');	  		 
	 
	 if(is_numeric($impuesto_id)){
	     $select = "SELECT impuesto_id AS value,nombre AS text,$impuesto_id AS selected FROM impuesto WHERE empresa_id = $empresa_id AND impuesto_id IN (SELECT impuesto_id 
		 FROM impuesto_oficina WHERE oficina_id = $oficina_id)";   
	 }else{
	       $select = "SELECT impuesto_id AS value,nombre AS text FROM impuesto WHERE empresa_id = $empresa_id AND impuesto_id IN (SELECT impuesto_id 
		   FROM impuesto_oficina WHERE oficina_id = $oficina_id)";   	 
	   }
   
     $result =  $this -> DbFetchAll($select,$Conex);
   
     return $result;  
   
   }

//// GRID ////
  public function getQueryTablaImpuestosGrid(){
	   	   
     $Query = "SELECT t.nombre AS impuesto,(SELECT codigo_puc FROM puc WHERE puc_id = (SELECT puc_id FROM impuesto WHERE impuesto_id = t.impuesto_id)) AS  puc,o.nombre AS  agencia,IF(t.base = 'F','VALOR DEL FLETE','IMPUESTO') AS base,(SELECT nombre FROM impuesto WHERE impuesto_id = t.base_impuesto_id) AS base_impuesto_id,t.orden,IF(t.visible_en_impresion = 0,'NO','SI') AS visible_en_impresion,t.estado FROM tabla_impuestos t,oficina o  WHERE t.oficina_id = o.oficina_id";
   
     return $Query;
   }
   
}



?>