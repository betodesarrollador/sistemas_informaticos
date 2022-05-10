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
  
  public function selectDatosTarifasId($tarifa_proveedor_id,$Conex){
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
					FROM tarifa_proveedor t 
	                WHERE t.tarifa_proveedor_id = $tarifa_proveedor_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tarifa_proveedor_id    = $this -> DbgetMaxConsecutive("tarifa_proveedor","tarifa_proveedor_id",$Conex,true,1);
  	  $origen_ubicacion_id 	  = $this -> requestDataForQuery('origen_ubicacion_id','integer');
	  $destino_ubicacion_id   = $this -> requestDataForQuery('destino_ubicacion_id','integer');
	  $configuracion		  = $this -> requestDataForQuery('configuracion','integer');	  
	  $periodo_proveedor 	  = $this -> requestDataForQuery('periodo_proveedor','integer');		  

	  $select_tot="SELECT COUNT(*) AS movimientos
				FROM tarifa_proveedor 
				WHERE origen_ubicacion_id=$origen_ubicacion_id AND destino_ubicacion_id=$destino_ubicacion_id AND configuracion=$configuracion AND periodo_proveedor=$periodo_proveedor";
	  $result_tot = $this -> DbFetchAll($select_tot,$Conex,false);
	  
	  if($result_tot[0]['movimientos']==0){
		  $this -> assignValRequest('tarifa_proveedor_id',$tarifa_proveedor_id);
		  $this -> DbInsertTable("tarifa_proveedor",$Campos,$Conex,true,false);  
		  $this -> Commit($Conex);  
	  }else{
		
		return 'Tarifa previamente Ingresada';
	  }
	  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	  if($_REQUEST['tarifa_proveedor_id'] == 'NULL'){
	    $this -> DbInsertTable("tarifa_proveedor",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("tarifa_proveedor",$Campos,$Conex,true,false);
	    }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tarifa_proveedor",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tarifa_proveedor",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function GetTipoConfig($Conex){
	return $this  -> DbFetchAll("SELECT tipo_vehiculo_id AS value,descripcion AS text FROM tipo_vehiculo ORDER BY descripcion ASC",$Conex,$ErrDb = false);
  }
	
  public function GetCarga($configuracion,$Conex){

     $select = "SELECT IF(capacidad_carga>0,capacidad_carga,peso_maximo) as capacidad_carga FROM configuracion WHERE configuracion = '$configuracion'";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }
	

   public function GetQueryTarifasGrid(){
	   	   
   $Query = "SELECT 
			(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.origen_ubicacion_id) AS origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.destino_ubicacion_id) AS destino, 
			(SELECT descripcion FROM tipo_vehiculo WHERE tipo_vehiculo_id = t.tipo_vehiculo_id) AS configuracion,
			capacidad_carga,
			periodo_proveedor,
			cupo_proveedor,
			cupofin_proveedor,
			cant_proveedor,
			cantfin_proveedor,
			tone_proveedor,
			tonefin_proveedor,
			vol_proveedor,
			volfin_proveedor,
			ant_proveedor,
			antfin_proveedor,
			antpropio_proveedor,
			antfinpropio_proveedor
		FROM tarifa_proveedor t ";
   return $Query;
   }
}

?>