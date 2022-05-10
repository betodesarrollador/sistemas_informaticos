<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TablaDescuentosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	$this -> DbInsertTable("tabla_descuentos",$Campos,$Conex,true,false);

	echo $this -> DbInsertTable();
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("tabla_descuentos",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tabla_descuentos",$Campos,$Conex,true,false);
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
		$select = "(SELECT descuento_id AS value, descuento AS text FROM tabla_descuentos WHERE empresa_id = $empresa_id AND 
		estado = 'A' ORDER BY descuento) UNION (SELECT descuento_id AS value, descuento AS text FROM tabla_descuentos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento)";
	}elseif(isset($_REQUEST['OFICINAID'])){
		$oficina_id = $_REQUEST['OFICINAID'];
		$select = "(SELECT descuento_id AS value, descuento AS text FROM tabla_descuentos WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = $oficina_id) AND 
		estado = 'A' ORDER BY descuento) UNION (SELECT descuento_id AS value, descuento AS text FROM 
		tabla_descuentos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento)";
	}else{
		$select = "SELECT descuento_id AS value, descuento AS text FROM tabla_descuentos WHERE empresa_id IS NULL AND estado = 'A' ORDER BY descuento";		
	}

	return $this -> DbFetchAll($select,$Conex);
}


//BUSQUEDA
   public function selectTablaDescuentos($Conex){
	 
	 $descuento_id = $this -> requestDataForQuery('descuento_id','integer');
	 
     $Query = "SELECT t.*,(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
						 FROM puc 
						 WHERE puc_id=t.puc_id) 
					AS puc FROM tabla_descuentos t WHERE t.descuento_id=$descuento_id";
     $result =  $this -> DbFetchAll($Query,$Conex);
   
     return $result;
   }
   
   public function selectDataDescuento($usuario_id,$Conex){

	 $descuento_id = $this -> requestDataForQuery('descuento_id','integer');	   
	 $select       = "SELECT * FROM tabla_descuentos WHERE descuento_id = $descuento_id";
	   
     $result       =  $this -> DbFetchAll($select,$Conex);
   
     return $result;
	   
   }


//// GRID ////
  public function getQueryTablaDescuentosGrid(){
	   	   
     $Query = "SELECT 
     	t.descuento,
     	p.codigo_puc AS puc,
     	IF(t.naturaleza='C','CREDITO','DEBITO')AS naturaleza,
     	o.nombre AS agencia,
     	IF(t.calculo='A','VR. ABSOLUTO','VR. PORCENTUAL')AS calculo,
     	t.porcentaje,
     	IF(t.visible_en_impresion = 0,'NO','SI') AS visible_en_impresion,
     	IF(t.estado='I','INACTIVO','ACTIVO')AS estado,
     	IF(t.descuento_anticipos = 0,'NO','SI') AS descuento_anticipos FROM tabla_descuentos t,puc p,oficina o  WHERE t.puc_id = p.puc_id AND t.oficina_id = o.oficina_id";
   
     return $Query;
   }
   
}



?>