<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ImpuestosModel extends Db{
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
  
     $this -> Begin($Conex);
  
      $impuesto_id 	         = $this -> DbgetMaxConsecutive("impuesto","impuesto_id",$Conex,true,true);	
	  $puc_id 	             = $this -> requestData('puc_id');
	  $ubicacion_id 	     = $this -> requestData('ubicacion_id');
	  $nombre 	             = $this -> requestData('nombre');
	  $descripcion 	         = $this -> requestData('descripcion');
	  $naturaleza 	         = $this -> requestData('naturaleza');
	  $empresa_id 	         = $this -> requestData('empresa_id');
	  $exentos               = $this -> requestData('exentos');
	  $subcodigo             = $this -> requestData('subcodigo');
	  $ayuda 	             = $this -> requestData('ayuda');
	  $estado                = $this -> requestData('estado');
  	  $para_terceros         = $this -> requestData('para_terceros');
	
	  $insert   = "INSERT INTO impuesto (impuesto_id,puc_id,nombre,descripcion,naturaleza,empresa_id,ayuda,estado,exentos,para_terceros,subcodigo,ubicacion_id) VALUES 
	  ($impuesto_id,$puc_id,'$nombre','$descripcion','$naturaleza',$empresa_id,'$ayuda','$estado','$exentos',$para_terceros,'$subcodigo',$ubicacion_id)";
      $result   = $this -> query($insert,$Conex,true);  
	  
	  $oficinas = explode(",",$this -> requestData('oficina_id'));
	  
	  for($i = 0; $i < count($oficinas); $i++){
	  
         $impuesto_oficina_id = $this -> DbgetMaxConsecutive("impuesto_oficina","impuesto_oficina_id",$Conex,true,true);		  
	     $oficina_id          = $oficinas[$i];
	  
	  
    	 $insert     = "INSERT INTO impuesto_oficina  (impuesto_oficina_id,impuesto_id,oficina_id,empresa_id) 
		                VALUES ($impuesto_oficina_id,$impuesto_id,$oficina_id,$empresa_id)";	  
		 
         $result     = $this -> query($insert,$Conex,true);  		 
	  
	  }
	
	
    $this -> Commit($Conex);	
	
	return $impuesto_id;
	
  }
	
  public function Update($Campos,$Conex){	
  
    $this -> Begin($Conex);
  
      $impuesto_id 	         = $this -> requestData("impuesto_id");	
	  $puc_id 	             = $this -> requestData('puc_id');
	  $ubicacion_id 	     = $this -> requestData('ubicacion_id');
	  $nombre 	             = $this -> requestData('nombre');
	  $descripcion 	         = $this -> requestData('descripcion');
	  $naturaleza 	         = $this -> requestData('naturaleza');
	  $empresa_id 	         = $this -> requestData('empresa_id');
	  $exentos               = $this -> requestData('exentos');
	  $ayuda 	             = $this -> requestData('ayuda');
	  $estado                = $this -> requestData('estado');
	  $para_terceros         = $this -> requestData('para_terceros');
	  $subcodigo             = $this -> requestData('subcodigo');
	  $insert   = "UPDATE impuesto SET puc_id = $puc_id,nombre = '$nombre',descripcion = '$descripcion',naturaleza = '$naturaleza',
	  empresa_id = $empresa_id,ayuda = '$ayuda',estado = '$estado',exentos = '$exentos', para_terceros=$para_terceros, subcodigo = '$subcodigo', ubicacion_id = $ubicacion_id  WHERE impuesto_id = $impuesto_id";
      $result   = $this -> query($insert,$Conex,true);  
	  
	  $delete = "DELETE FROM impuesto_oficina WHERE impuesto_id = $impuesto_id";
      $result = $this -> query($delete,$Conex,true);  	  
	  
	  $oficinas = explode(",",$this -> requestData('oficina_id'));
	  
	  for($i = 0; $i < count($oficinas); $i++){
	  
         $impuesto_oficina_id = $this -> DbgetMaxConsecutive("impuesto_oficina","impuesto_oficina_id",$Conex,true,true);		  
	     $oficina_id          = $oficinas[$i];
	  
	  
    	 $insert     = "INSERT INTO impuesto_oficina  (impuesto_oficina_id,impuesto_id,oficina_id,empresa_id) 
		                VALUES ($impuesto_oficina_id,$impuesto_id,$oficina_id,$empresa_id)";	  
		 
         $result     = $this -> query($insert,$Conex,true);  		 
	  
	  }
	
	
    $this -> Commit($Conex);	
	
  }
	
  public function Delete($Campos,$Conex){
  
   $this -> Begin($Conex);
     $impuesto_id = $this -> requestData('impuesto_id');
	 
     $delete = "DELETE FROM impuesto_periodo_contable WHERE impuesto_id = $impuesto_id";
     $result = $this -> query($delete,$Conex,true);	 
     $delete = "DELETE FROM impuesto_oficina WHERE impuesto_id = $impuesto_id";
     $result = $this -> query($delete,$Conex,true);	 
     $delete = "DELETE FROM impuesto WHERE impuesto_id = $impuesto_id";
     $result = $this -> query($delete,$Conex,true);	 	 
   
   $this -> Commit($Conex);  
	
  }	
  
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM 
	 empresa e,tercero t WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE 
     empresa_id IN (SELECT empresa_id FROM opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	 return $result;
   
   }	  
   
   public function selectOficinasImpuesto($impuesto_id,$Conex){
   
      $select = "SELECT oficina_id FROM impuesto_oficina WHERE impuesto_id = $impuesto_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	  return $result;   
	  
   }   			    
   
   public function selectImpuestos($impuestoId,$Conex){
	   	   
     $Query = "SELECT i.empresa_id,
	                  i.impuesto_id,
					  (SELECT codigo_puc FROM puc WHERE puc_id = i.puc_id) AS puc,
					  i.puc_id,
					  (SELECT nombre FROM ubicacion WHERE ubicacion_id = i.ubicacion_id) AS ubicacion,
					  i.ubicacion_id,
					  i.nombre,
					  i.descripcion,
					  i.naturaleza,
					  i.estado,
					  i.ayuda,
					  i.exentos,
					  i.para_terceros,
					  i.subcodigo FROM impuesto i WHERE i.impuesto_id = $impuestoId";
     $result =  $this -> DbFetchAll($Query,$Conex);	 
   
     return $result;
   }
   
   public function selectImpuestoPuc($puc_id,$Conex){
   
     $select = "SELECT i.empresa_id,i.impuesto_id,(SELECT codigo_puc FROM puc WHERE puc_id = i.puc_id) 
	 AS puc,i.puc_id,i.nombre,i.descripcion,i.naturaleza,i.estado,i.exentos,i.ayuda,i.para_terceros,i.subcodigo FROM impuesto i 
	 WHERE puc_id = $puc_id";
	 
     $result = $this -> DbFetchAll($select,$Conex,true);
	
	 return $result;     
   
   }
   
   public function getQueryImpuestosGrid(){
	   	   
     $Query = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id = i.puc_id) AS puc_id,i.nombre,
	 CASE i.exentos WHEN 'NN' THEN 'NINGUNO'  WHEN 'RT' THEN 'RENTA' WHEN 'IC' THEN 'ICA'  
	 WHEN 'IV' THEN 'IVA'  WHEN 'RIV' THEN 'RETEIVA' WHEN 'RIC' THEN 'RETEICA' WHEN 'CR' THEN 'CREE' ELSE '' END AS exentos,
	 CASE i.subcodigo WHEN '3' THEN 'Compras'  WHEN '5' THEN 'Honorarios' WHEN '6' THEN 'Servicios Generales'  
	 WHEN '7' THEN 'Transporte Carga'  WHEN '21' THEN 'Otras Retenciones'  ELSE '' END AS subcodigo,
	 
	 i.naturaleza,i.estado FROM impuesto i";
   
     return $Query;
   }
   
}


?>