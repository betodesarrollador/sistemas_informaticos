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
  
  public function selectDatosTipoServicioId($tipo_bien_servicio_teso_id,$Conex){
     $select    = "SELECT tipo_bien_servicio_teso_id, nombre_bien_servicio_teso, tipo_documento_id, valor_manual, puc_manual, tercero_manual, centro_manual, maneja_cheque 
					FROM tipo_bien_servicio_teso 
	                WHERE tipo_bien_servicio_teso_id = $tipo_bien_servicio_teso_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;	  
  }  
  
  public function Save($agencia,$Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tipo_bien_servicio_teso_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_teso","tipo_bien_servicio_teso_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_bien_servicio_teso_id',$tipo_bien_servicio_teso_id);
      $this -> DbInsertTable("tipo_bien_servicio_teso",$Campos,$Conex,true,false);  
	  if(!strlen(trim($this -> GetError())) > 0){
		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_teso_id  = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina_teso","tipo_bien_servicio_oficina_teso_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina_teso (tipo_bien_servicio_oficina_teso_id,tipo_bien_servicio_teso_id,oficina_id) 
			 VALUES($tipo_bien_servicio_oficina_teso_id,$tipo_bien_servicio_teso_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}
	  	$this -> Commit($Conex);		 
  	  	return $tipo_bien_servicio_teso_id;
	  }
  }
	
  public function Update($agencia,$Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_bien_servicio_teso_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_bien_servicio_teso",$Campos,$Conex,true,false);	

		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_teso_id  = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina_teso","tipo_bien_servicio_oficina_teso_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina_teso (tipo_bien_servicio_oficina_teso_id,tipo_bien_servicio_teso_id,oficina_id) 
			 				VALUES($tipo_bien_servicio_oficina_teso_id,$tipo_bien_servicio_teso_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}

      }else{
          $this -> DbUpdateTable("tipo_bien_servicio_teso",$Campos,$Conex,true,false);
		    $tipo_bien_servicio_teso_id=$_REQUEST['tipo_bien_servicio_teso_id'];
			$delete = "DELETE FROM tipo_bien_servicio_oficina_teso WHERE tipo_bien_servicio_teso_id=$tipo_bien_servicio_teso_id ";
			$this -> query($delete,$Conex);	
			
			$agencia=explode(',',$agencia);
			foreach($agencia as $agencias){
						  
				 $tipo_bien_servicio_oficina_teso_id  = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina_teso","tipo_bien_servicio_oficina_teso_id",$Conex,true,1);
				 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina_teso (tipo_bien_servicio_oficina_teso_id,tipo_bien_servicio_teso_id,oficina_id) 
								VALUES($tipo_bien_servicio_oficina_teso_id,$tipo_bien_servicio_teso_id,$agencias)";
				$this -> query($insert_agencia,$Conex);	
			}
		  
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tipo_bien_servicio_teso",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_bien_servicio_teso",$Campos);
	 return $Data -> GetData();
   }

   public function GetDocumento($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento",$Conex,
	$ErrDb = false);
   }
   
   public function GetAgencia($oficina_id,$Conex){
	return $this -> DbFetchAll("SELECT oficina_id  AS value,nombre AS text FROM oficina WHERE empresa_id=(SELECT empresa_id FROM oficina WHERE oficina_id=$oficina_id) ",$Conex,
	$ErrDb = false);
   }
   
  public function getAgencias($tipo_bien_servicio_teso_id,$Conex){
	  $select = "SELECT oficina_id FROM tipo_bien_servicio_oficina_teso WHERE tipo_bien_servicio_teso_id=$tipo_bien_servicio_teso_id";
      $result = $this -> DbFetchAll($select,$Conex);
	  return $result; 
  }

  public function GetManual($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'SI' ), 1 => array ( 'value' => '0', 'text' => 'NO' ));
	return  $opciones;
  }

   public function GetQueryTipoServicioGrid(){
	   	   
   $Query = "SELECT t.tipo_bien_servicio_teso_id, t.nombre_bien_servicio_teso,
	(SELECT nombre FROM tipo_de_documento  WHERE tipo_documento_id=t.tipo_documento_id) AS documento,
	IF(t.valor_manual=1,'SI','NO') AS valor_manual,			
	(SELECT COUNT(*) AS movimientos FROM codpuc_bien_servicio_teso WHERE tipo_bien_servicio_teso_id=t.tipo_bien_servicio_teso_id) AS cuentas_bien		
	FROM tipo_bien_servicio_teso t ";
   return $Query;
   }   

}

?>