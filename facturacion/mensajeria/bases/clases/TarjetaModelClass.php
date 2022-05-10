<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TarjetaModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
 
   public function setInsertDetalleSolicitud($rowInsert,$oficina_id,$usuario_id,$Conex){
        
	  $this -> Begin($Conex);							
		
	  $guia_encomienda_id = $this -> DbgetMaxConsecutive("guia_encomienda","guia_encomienda_id",$Conex,false,1);
	  
	  $fecha_registro              	= date('Y-m-d H:I');
	  $CODIGO   	              	= trim($rowInsert[CODIGO]);
	  $DOCUMENTO               		= trim($rowInsert[DOCUMENTO]);
      $NOMBRES		             	= trim($rowInsert[NOMBRES]);
	  $APELLIDOS                	= trim($rowInsert[APELLIDOS]);
	  

	  $select_guia = "SELECT tarjeta_descuento_id FROM tarjeta_descuento WHERE codigo='$CODIGO'";
	  $result_guia = $this -> DbFetchAll($select_guia,$Conex);
	  
	  if($result_guia[0][tarjeta_descuento_id]>0){
		  return "Tarjeta No ".$CODIGO." Ya existente";
	  }else{


		  $insert = "INSERT INTO tarjeta_descuento (codigo,documento,nombres,apellidos,estado,fecha_registro) 
		  VALUES ('$CODIGO','$DOCUMENTO','$NOMBRES','$APELLIDOS',1,'$fecha_registro');";
		  
		  $this -> query($insert,$Conex,true);
	
	  }
	 $this -> Commit($Conex);
   }
  
}


?>