<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AsuntoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosAsuntoId($asunto_id,$Conex){
     $select    = "SELECT *
					FROM asunto   
	                WHERE asunto_id = $asunto_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $asunto_id    = $this -> DbgetMaxConsecutive("asunto","asunto_id",$Conex,true,1);
	
      $this -> assignValRequest('asunto_id',$asunto_id);
      $this -> DbInsertTable("asunto",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	$asunto_id = $this -> requestData('asunto_id');
	  if($_REQUEST['asunto_id'] == 'NULL'){
	    $this -> DbInsertTable("asunto",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("asunto",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("asunto",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"asunto",$Campos);
	 return $Data -> GetData();
   }

  /*public function GetTipofactura($Conex){
	return $this  -> DbFetchAll("SELECT tipo_factura_id AS value,nombre_tipo_factura AS text FROM tipo_factura  ORDER BY nombre_tipo_factura ASC",$Conex,$ErrDb = false);
  }
  public function GetTipodocumento($Conex){
	return $this  -> DbFetchAll("SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  public function GetTipooficina($Conex){
	return $this  -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }*/

   public function GetQueryAsuntoGrid(){
	   	   
   $Query = "SELECT *
		FROM asunto ";
   return $Query;
   }
}

?>