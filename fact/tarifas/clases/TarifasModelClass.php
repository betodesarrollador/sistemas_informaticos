<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TarifasModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosTarifasId($tarifa_cliente_id,$Conex){
     $select    = "SELECT
	 					t.*,
							(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=t.origen_ubicacion_id) 
						AS origen_ubicacion, 
							(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=t.destino_ubicacion_id) 
						AS destino_ubicacion 
					FROM tarifa_cliente  t 
	                WHERE t.tarifa_cliente_id = $tarifa_cliente_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tarifa_cliente_id      = $this -> DbgetMaxConsecutive("tarifa_cliente","tarifa_cliente_id",$Conex,true,1);
  	  $origen_ubicacion_id 	  = $this -> requestDataForQuery('origen_ubicacion_id','integer');
	  $destino_ubicacion_id   = $this -> requestDataForQuery('destino_ubicacion_id','integer');
	  $tipo_vehiculo_id		  = $this -> requestDataForQuery('tipo_vehiculo_id','integer');	  
	  $periodo_cliente 	  	  = $this -> requestDataForQuery('periodo_cliente','integer');		  

	  $select_tot="SELECT COUNT(*) AS movimientos
				FROM tarifa_cliente 
				WHERE origen_ubicacion_id=$origen_ubicacion_id AND destino_ubicacion_id=$destino_ubicacion_id AND tipo_vehiculo_id=$tipo_vehiculo_id AND periodo_cliente=$periodo_cliente";
	  $result_tot = $this -> DbFetchAll($select_tot,$Conex,false);
	  
	  if($result_tot[0]['movimientos']==0){
		  $this -> assignValRequest('tarifa_cliente_id',$tarifa_cliente_id);
		  $this -> DbInsertTable("tarifa_cliente",$Campos,$Conex,true,false);  
		  $this -> Commit($Conex);  
	  }else{
		
		return 'Tarifa previamente Ingresada';
	  }
	  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tarifa_cliente_id'] == 'NULL'){
	    $this -> DbInsertTable("tarifa_cliente",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("tarifa_cliente",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tarifa_cliente",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tarifa_cliente",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function GetTipoCarroceria($Conex){
	return $this  -> DbFetchAll("SELECT tipo_vehiculo_id AS value,descripcion AS text FROM tipo_vehiculo  ORDER BY descripcion ASC",$Conex,$ErrDb = false);
  }
	

   public function GetQueryTarifasGrid(){
	   	   
   $Query = "SELECT 
   				(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.origen_ubicacion_id) 
			AS origen,
   				(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.destino_ubicacion_id) 
			AS destino, 
				(SELECT descripcion FROM tipo_vehiculo WHERE tipo_vehiculo_id=t.tipo_vehiculo_id)
			AS carroceria,
			periodo_cliente,
			cupo_cliente,
			cupofin_cliente,
			tone_cliente,
			tonefin_cliente,
			vol_cliente,
			volfin_cliente
		FROM tarifa_cliente t ";
   return $Query;
   }
}

?>