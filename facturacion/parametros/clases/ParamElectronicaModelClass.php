<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParamElectronicaModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosParamElectronicaId($param_fac_electronica_id,$Conex){
     $select    = "SELECT *
					FROM param_factura_electronica  
	                WHERE param_fac_electronica_id = $param_fac_electronica_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $param_fac_electronica_id    = $this -> DbgetMaxConsecutive("param_factura_electronica","param_fac_electronica_id",$Conex,true,1);
	
      $this -> assignValRequest('param_fac_electronica_id',$param_fac_electronica_id);
      $this -> DbInsertTable("param_factura_electronica",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['param_fac_electronica_id'] == 'NULL'){
	    $this -> DbInsertTable("param_factura_electronica",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("param_factura_electronica",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("param_factura_electronica",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"param_factura_electronica",$Campos);
	 return $Data -> GetData();
   }

   public function GetEstado($Conex){
    $opciones = array ( 0 => array ( 'value' => '0', 'text' => 'INACTIVO' ), 1 => array ( 'value' => '1', 'text' => 'ACTIVO' ) );
    return  $opciones;
    }

    public function GetAmbiente($Conex){
    $opciones = array ( 0 => array ( 'value' => 'P', 'text' => 'PRODUCCION' ), 1 => array ( 'value' => 'D', 'text' => 'DEMO' ) );
    return  $opciones;
    }

  /* public function GetTipofactura($Conex){
	return $this  -> DbFetchAll("SELECT tipo_factura_id AS value,nombre_tipo_factura AS text FROM tipo_factura  ORDER BY nombre_tipo_factura ASC",$Conex,$ErrDb = false);
  }
  public function GetTipodocumento($Conex){
	return $this  -> DbFetchAll("SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  public function GetTipooficina($Conex){
	return $this  -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  } */

   public function GetQueryParamElectronicaGrid(){
	   	   
   $Query = "SELECT 
			p.param_fac_electronica_id,
			p.wsdl,
			p.wsanexo,
      p.wsdl_prueba,
      p.wsanexo_prueba,
      p.tokenenterprise,
      p.tokenautorizacion,
      p.correo,
      p.correo_segundo,
      IF(p.estado=1,'ACTIVO','INACTIVO') AS estado
		FROM param_factura_electronica p ";
   return $Query;
   }
}

?>