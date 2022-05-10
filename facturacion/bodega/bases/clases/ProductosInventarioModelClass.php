<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ProductosInventarioModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosProductosInventarioId($producto_id,$Conex){
     $select    = "SELECT pi.*,/*(SELECT nombre FROM linea_producto WHERE linea_producto_id = pi.linea_producto_id)AS linea_producto,*/ (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) AS proveedor FROM proveedor p, tercero t WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=pi.proveedor_id) AS proveedor
					FROM wms_producto_inv  pi
	                WHERE pi.producto_id = $producto_id";
     $result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;					  			
	  
  }

  public function buscaCodigo($Conex){

  	$linea_producto_id = $_REQUEST['linea_producto_id'];

     $select    = "SELECT cp.codigo AS cod1,gp.codigo AS cod2,lp.codigo AS cod3, (SELECT COALESCE(MAX(consecutivo+1),01) FROM wms_producto_inv WHERE linea_producto_id=$linea_producto_id )AS consecutivo FROM clase_producto cp, grupo_producto gp, linea_producto lp WHERE cp.clase_producto_id=gp.clase_producto_id AND gp.grupo_producto_id = lp.grupo_producto_id AND lp.linea_producto_id = $linea_producto_id";

     $result    = $this -> DbFetchAll($select,$Conex,true);

     $codigo = $result[0]['cod1'].$result[0]['cod2'].$result[0]['cod3'].str_pad($result[0]['consecutivo'], 2,0,STR_PAD_LEFT);

     return $codigo;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
    $producto_id    = $this -> DbgetMaxConsecutive("wms_producto_inv","producto_id",$Conex,true,1);
	  /*$linea_producto_id = $_REQUEST['linea_producto_id'];*/

	  /*$select = "SELECT COALESCE(MAX(consecutivo+1),1)as consecutivo FROM wms_producto_inv WHERE linea_producto_id=$linea_producto_id";
    $result    = $this -> DbFetchAll($select,$Conex,true);
    $this -> assignValRequest('consecutivo',$result[0]['consecutivo']);*/
	
      $this -> assignValRequest('producto_id',$producto_id);
       
      $this -> DbInsertTable("wms_producto_inv",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex); 
	  
	  $arrayReturn[0]['producto_id']=$producto_id;
	  
	  return  $arrayReturn;
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['producto_id'] == 'NULL'){
	    $this -> DbInsertTable("wms_producto_inv",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("wms_producto_inv",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("wms_producto_inv",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"wms_producto_inv",$Campos);
	 return $Data -> GetData();
   }

  public function GetLineaProducto($Conex){
	return $this  -> DbFetchAll("SELECT linea_producto_id AS value,nombre AS text FROM linea_producto  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }

  public function GetImpuestos($Conex){
	return $this  -> DbFetchAll("SELECT impuesto_id AS value,nombre AS text FROM impuesto  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }

  public function GetMedida($Conex){
	return $this  -> DbFetchAll("SELECT m.medida_id AS value, m.wms_medida  AS text FROM  wms_medida m WHERE m.ministerio=1  ORDER BY m.wms_medida ASC",$Conex,$ErrDb = false);
  }

  public function GetEmpaque($Conex){
	return $this  -> DbFetchAll("SELECT tipo_empaque_inv_id AS value,nombre AS text FROM    wms_tipo_empaque_inv          ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }

   public function GetQueryProductosInventarioGrid(){
	   	   
   $Query = "SELECT 
			p.producto_id, p.nombre,
			IF(p.estado='A','ACTIVO','INACTIVO')AS estado,
			/*(SELECT nombre FROM linea_producto WHERE linea_producto_id=p.linea_producto_id) AS linea_producto_id,*/
			p.referencia,p.tipo_valuacion,
			(SELECT  m.wms_medida FROM  wms_medida m  WHERE m.medida_id=p.medida_id) AS medida_id,
			p.codigo_barra,
			(SELECT nombre FROM    wms_tipo_empaque_inv         WHERE tipo_empaque_inv_id=p.tipo_empaque_inv_id) AS tipo_empaque_inv_id,
			IF(p.procesado='S','SI','NO')AS procesado,
			p.stock_min, p.stock_max, p.descripcion,
			IF(p.iva='S','SI','NO')AS iva,
			IF(p.impuesto_id!=NULL,p.impuesto_id,'N/A')AS impuesto_id			
		FROM wms_producto_inv p ";
   return $Query;
   }
}

?>