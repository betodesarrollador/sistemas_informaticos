<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosParametrosId($parametros_factura_id,$Conex){
     $select    = "SELECT *
					FROM parametros_factura  
	                WHERE parametros_factura_id = $parametros_factura_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }

    public function getTokens($Conex){
	  $select="SELECT wsdl,
	                  wsanexo,
					  wsdl_prueba,
					  wsanexo_prueba,
					  tokenenterprise,
					  tokenautorizacion,
					  correo,
					  correo_segundo,
					  ambiente
				FROM param_factura_electronica WHERE estado = 1";
	   $result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);

    $fuente_facturacion = $_REQUEST['fuente_facturacion_cod'];
					
	  $parametros_factura_id    = $this -> DbgetMaxConsecutive("parametros_factura","parametros_factura_id",$Conex,true,1);
	
      $this -> assignValRequest('parametros_factura_id',$parametros_factura_id);
      $this -> DbInsertTable("parametros_factura",$Campos,$Conex,true,false);
      
      $update = "UPDATE parametros_factura SET fuente_facturacion_cod='$fuente_facturacion' WHERE parametros_factura_id=$parametros_factura_id";
      $this -> query($update,$Conex);

	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	    if($_REQUEST['parametros_factura_id'] == 'NULL'){

       $this -> DbInsertTable("parametros_factura",$Campos,$Conex,true,false);	
      
      
      }else{

          $this -> DbUpdateTable("parametros_factura",$Campos,$Conex,true,false);

      }

      $parametros_factura_id = $_REQUEST['parametros_factura_id'];
      
      $fuente_facturacion = $_REQUEST['fuente_facturacion_cod'];
      $update = "UPDATE parametros_factura SET fuente_facturacion_cod='$fuente_facturacion' WHERE parametros_factura_id=$parametros_factura_id";
      $this -> query($update,$Conex);

	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("parametros_factura",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"parametros_factura",$Campos);
	 return $Data -> GetData();
   }

  public function GetTipofactura($Conex){
	return $this  -> DbFetchAll("SELECT tipo_factura_id AS value,nombre_tipo_factura AS text FROM tipo_factura  ORDER BY nombre_tipo_factura ASC",$Conex,$ErrDb = false);
  }
  public function GetTipodocumento($Conex){
	return $this  -> DbFetchAll("SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  public function GetTipooficina($Conex){
	return $this  -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }

  public function GetFuente($Conex){

    $select = "SELECT fuente_facturacion_cod AS value,fuente_facturacion_nom AS text FROM fuente_facturacion ORDER BY fuente_facturacion_nom ASC";
    $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
    return $result;
  }

  public function getFuentesFacturacion($parametros_factura_id,$Conex){
	  $select = "SELECT fuente_facturacion_cod FROM parametros_factura  WHERE parametros_factura_id=$parametros_factura_id";
    $result = $this -> DbFetchAll($select,$Conex);
	  return $result; 
  }

   public function GetQueryParametrosGrid(){
	   	   
   $Query = "SELECT 
			fecha_resolucion_dian,
			resolucion_dian,
			(SELECT nombre_tipo_factura FROM tipo_factura  WHERE tipo_factura_id = p.tipo_factura_id) AS nombre_tipo_factura,
			IF (p.fact_electronica=1,'SI','NO') AS fact_electronica,
			(SELECT nombre FROM tipo_de_documento  WHERE tipo_documento_id = p.tipo_documento_id) AS nombre_tipo_documento,
			(SELECT nombre FROM oficina  WHERE oficina_id = p.oficina_id) AS nombre_oficina,
			prefijo,
			rango_inicial,
			rango_final
    FROM parametros_factura p ";
 
   return $Query;
   }
}

?>