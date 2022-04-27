<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ResolucionModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }


  public function selectDatosResolucionId($parametros_equivalente_id,$Conex){
     $select    = "SELECT *
					FROM parametros_equivalente  
	                WHERE parametros_equivalente_id = $parametros_equivalente_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $parametros_equivalente_id    = $this -> DbgetMaxConsecutive("parametros_equivalente","parametros_equivalente_id",$Conex,true,1);
	
      $this -> assignValRequest('parametros_equivalente_id',$parametros_equivalente_id);
      $this -> DbInsertTable("parametros_equivalente",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['parametros_equivalente_id'] == 'NULL'){
	    $this -> DbInsertTable("parametros_equivalente",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("parametros_equivalente",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("parametros_equivalente",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"parametros_equivalente",$Campos);
	 return $Data -> GetData();
   }

  public function GetTipodocumento($Conex){
	return $this  -> DbFetchAll("SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  public function GetTipooficina($Conex){
	return $this  -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }

   public function GetQueryResolucionGrid(){
	   	   
   $Query = "SELECT 
			fecha_resolucion_dian,
			resolucion_dian,
			(SELECT nombre FROM tipo_de_documento  WHERE tipo_documento_id = p.tipo_documento_id) AS nombre_tipo_documento,
			(SELECT nombre FROM oficina  WHERE oficina_id = p.oficina_id) AS nombre_oficina,
			prefijo,
			rango_inicial,
			rango_final
    FROM parametros_equivalente p ";
 
   return $Query;
   }
}

?>