<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class FaqModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosFaqId($errores_id,$Conex){
     $select    = "SELECT e.*,
	 				(SELECT CONCAT_WS('-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS cliente FROM tercero t, cliente c	WHERE t.tercero_id = c.tercero_id AND c.cliente_id=e.cliente_id)AS cliente
					FROM errores e 
	                WHERE errores_id = $errores_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  public function Save($Campos,$Conex){	
    $this -> Begin($Conex);


	  $errores_id    = $this -> DbgetMaxConsecutive("errores","errores_id",$Conex,true,1);
	
      $this -> assignValRequest('errores_id',$errores_id);
      $this -> DbInsertTable("errores",$Campos,$Conex,true,false);  
	  
	 	$update = "UPDATE errores SET estado = 'F' WHERE errores_id = $errores_id AND solucion IS NOT NULL";
		$this -> query($update,$Conex,true);
	  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	$errores_id             = $this -> requestData('errores_id');
	  if($_REQUEST['errores_id'] == 'NULL'){
	    $this -> DbInsertTable("errores",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("errores",$Campos,$Conex,true,false);
	    }
		
	$update = "UPDATE errores SET estado = 'F' WHERE errores_id = $errores_id AND solucion!=NULL";
	$this -> query($update,$Conex,true);	
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("errores",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"errores",$Campos);
	 return $Data -> GetData();
   }

  public function GetAsunto($Conex){
	return $this  -> DbFetchAll("SELECT asunto_id AS value,descripcion AS text FROM asunto ORDER BY descripcion ASC",$Conex,$ErrDb = false);
  }

  public function GetModulo($Conex){
	return $this  -> DbFetchAll("SELECT consecutivo AS value,descripcion AS text FROM actividad WHERE modulo=1  ORDER BY descripcion ASC",$Conex,$ErrDb = false);
  }
  /*public function GetTipooficina($Conex){
	return $this  -> DbFetchAll("estado ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }*/

   public function GetQueryFaqGrid(){
	   	   
   $Query = "SELECT e.errores_id,
   			(SELECT descripcion FROM asunto  WHERE asunto_id=e.asunto_id)AS asunto,
			e.fecha_ingreso_error,
			e.fecha_solucion,
			(SELECT CONCAT_WS('-',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS cliente FROM tercero t, cliente c	WHERE t.tercero_id = c.tercero_id AND c.cliente_id=e.cliente_id)AS cliente,
			(SELECT descripcion FROM actividad WHERE consecutivo=e.modulos_codigo)AS modulos_codigo,
			IF(e.estado ='E','EN ESPERA','FINALIZADO')AS estado,
			(SELECT CONCAT_WS('-',t.numero_identificacion,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)AS usuario_modifica FROM tercero t, usuario u WHERE t.tercero_id = u.tercero_id AND u.usuario_id=e.usuario_modifica)AS usuario_modifica,
			e.descripcion,
			e.solucion
		FROM errores e";
   return $Query;
   }
}

?>