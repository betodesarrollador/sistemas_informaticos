<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DocumentosModel extends Db{
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
    $this -> DbInsertTable("tipo_de_documento",$Campos,$Conex,true,false);
    $tipo_documento_id = $this -> getConsecutiveInsert();
    return $tipo_documento_id;
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("tipo_de_documento",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("tipo_de_documento",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"tipo_de_documento",$Campos);
	 
	 return $Data -> GetData();
   }
   
   public function selectDocumentos($tipo_documento_id,$Conex){
	   
	   $select = "SELECT * FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
	 	   
    public function GetQueryEmpresasGrid(){
	   	   
   $Query = "SELECT codigo,nombre,consecutivo,IF(consecutivo_periodo = 1,'SI','NO') AS consecutivo_periodo,texto_tercero,texto_soporte,
   			IF(requiere_soporte = 1,'SI','NO') AS requiere_soporte,
   			IF(de_cierre = 1,'SI','NO') AS de_cierre,
   			IF(de_traslado = 1,'SI','NO') AS de_traslado,
   			IF(de_anticipo = 1,'SI','NO') AS de_anticipo,
   			IF(de_devolucion = 1,'SI','NO') AS de_devolucion,
   			IF(pago_factura = 1,'SI','NO') AS pago_factura,
   			IF(pago_proveedor = 1,'SI','NO') AS pago_proveedor FROM tipo_de_documento";
   
   return $Query;
   }
   
   
 
}


?>