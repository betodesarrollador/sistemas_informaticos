<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TipoServicioModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosTipoServicioId($tipo_bien_servicio_factura_id,$Conex){
     $select    = "SELECT tipo_bien_servicio_factura_id,
	                      nombre_bien_servicio_factura,
						   fuente_facturacion_cod,
						    tipo_documento_id,
							tipo_documento_dev_id,
							 estado,
							 reporta_cartera
	 				
					FROM  tipo_bien_servicio_factura  
	                WHERE tipo_bien_servicio_factura_id = $tipo_bien_servicio_factura_id";
     $result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;					  			
	  
  }
  
  
  public function Save($agencia,$Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tipo_bien_servicio_factura_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_factura","tipo_bien_servicio_factura_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_bien_servicio_factura_id',$tipo_bien_servicio_factura_id);
      $this -> DbInsertTable("tipo_bien_servicio_factura",$Campos,$Conex,true,false);  

	  if(!strlen(trim($this -> GetError())) > 0){
		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_factura_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_factura_oficina","tipo_bien_factura_oficina_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_factura_oficina (tipo_bien_factura_oficina_id, tipo_bien_servicio_factura_id,oficina_id) 
			 				VALUES($tipo_bien_factura_oficina_id,$tipo_bien_servicio_factura_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}
	  	$this -> Commit($Conex);		 
	  }

	  if(!strlen(trim($this -> GetError())) > 0){
	  	$this -> Commit($Conex);		 
  	  	return $tipo_bien_servicio_factura_id;
	  }
  }
	
  public function Update($agencia,$Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_bien_servicio_factura_id'] == 'NULL'){
		$tipo_bien_servicio_factura_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_factura","tipo_bien_servicio_factura_id",$Conex,true,1);		  
	    $this -> DbInsertTable("tipo_bien_servicio_factura",$Campos,$Conex,true,false);		

		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_factura_oficina","tipo_bien_factura_oficina_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_factura_oficina (tipo_bien_factura_oficina_id,tipo_bien_servicio_factura_id,oficina_id) 
			 				VALUES($tipo_bien_factura_oficina_id,$tipo_bien_servicio_factura_id,$agencias)";
			$this -> query($insert_agencia,$Conex,true);	
		}

      }else{
            $this -> DbUpdateTable("tipo_bien_servicio_factura",$Campos,$Conex,true,false);
		    $tipo_bien_servicio_factura_id=$_REQUEST['tipo_bien_servicio_factura_id'];
			$delete = "DELETE FROM tipo_bien_factura_oficina WHERE tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id ";
			$this -> query($delete,$Conex);	
			
			$agencia=explode(',',$agencia);
			foreach($agencia as $agencias){
						  
				 $tipo_bien_factura_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_factura_oficina","tipo_bien_factura_oficina_id",$Conex,true,1);
				 $insert_agencia="INSERT INTO tipo_bien_factura_oficina (tipo_bien_factura_oficina_id,tipo_bien_servicio_factura_id,oficina_id) 
								VALUES($tipo_bien_factura_oficina_id,$tipo_bien_servicio_factura_id,$agencias)";
				$this -> query($insert_agencia,$Conex,true);	
			}
		  
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tipo_bien_servicio_factura",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_bien_servicio_factura",$Campos);
	 return $Data -> GetData();
   }
	 	

   public function GetFuente($Conex){
	return $this -> DbFetchAll("SELECT fuente_facturacion_cod AS value, fuente_facturacion_nom AS text FROM fuente_facturacion",$Conex,
	$ErrDb = false);
   }
   public function GetDocumento($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento",$Conex,
	$ErrDb = false);
   }
   public function GetAgencia($oficina_id,$Conex){
	return $this -> DbFetchAll("SELECT oficina_id  AS value,nombre AS text FROM oficina WHERE empresa_id=(SELECT empresa_id FROM oficina WHERE oficina_id=$oficina_id) ",$Conex,
	$ErrDb = false);
   }
  public function getAgencias($tipo_bien_servicio_factura_id,$Conex){
	  $select = "SELECT oficina_id FROM tipo_bien_factura_oficina  WHERE tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id";
      $result = $this -> DbFetchAll($select,$Conex);
	  return $result; 
  }

   public function GetQueryTipoServicioGrid(){
	   	   
   $Query = "SELECT t.tipo_bien_servicio_factura_id, 
   			t.nombre_bien_servicio_factura,
			(SELECT fuente_facturacion_nom FROM fuente_facturacion WHERE fuente_facturacion_cod=t.fuente_facturacion_cod) AS fuente_servicio,
			(SELECT nombre  FROM tipo_de_documento  WHERE tipo_documento_id=t.tipo_documento_id) AS documento
		FROM tipo_bien_servicio_factura t";
   return $Query;
   }
}

?>