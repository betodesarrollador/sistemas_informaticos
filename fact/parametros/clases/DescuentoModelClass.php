<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DescuentoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosDescuentoId($parametros_descuento_factura_id,$Conex){
     $select    = "SELECT p.*,
	 				(SELECT CONCAT_WS('-',codigo_puc,nombre) FROM puc WHERE puc_id=p.puc_id) AS puc
					FROM parametros_descuento_factura  p
	                WHERE p.parametros_descuento_factura_id = $parametros_descuento_factura_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $parametros_descuento_factura_id    = $this -> DbgetMaxConsecutive("parametros_descuento_factura","parametros_descuento_factura_id",$Conex,true,1);
	
      $this -> assignValRequest('parametros_descuento_factura_id',$parametros_descuento_factura_id);
      $this -> DbInsertTable("parametros_descuento_factura",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['parametros_descuento_factura_id'] == 'NULL'){
	    $this -> DbInsertTable("parametros_descuento_factura",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("parametros_descuento_factura",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("parametros_descuento_factura",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"parametros_descuento_factura",$Campos);
	 return $Data -> GetData();
   }

  public function GetEstado($Conex){
	$opciones = array ( 0 => array ( 'value' => '0', 'text' => 'INACTIVO' ), 1 => array ( 'value' => '1', 'text' => 'ACTIVO' ) );
	return  $opciones;
  }

  public function GetNaturaleza($Conex){
	$opciones = array ( 0 => array ( 'value' => 'C', 'text' => 'CREDITO' ), 1 => array ( 'value' => 'D', 'text' => 'DEBITO' ) );
	return  $opciones;
  }


  public function GetTipooficina($Conex){
	return $this  -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }

   public function GetQueryDescuentoGrid(){
	   	   
   $Query = "SELECT 
			(SELECT nombre FROM oficina WHERE oficina_id=p.oficina_id) AS oficina_id,
			(SELECT CONCAT_WS('-',codigo_puc,nombre) AS pucs FROM puc WHERE puc_id=p.puc_id) AS puc,
			IF(p.naturaleza='C','CREDITO','DEBITO') AS naturaleza,
			p.nombre,
			IF(p.estado=1,'ACTIVO','INACTIVO') AS estado
		FROM parametros_descuento_factura p ";
   return $Query;
   }
}

?>