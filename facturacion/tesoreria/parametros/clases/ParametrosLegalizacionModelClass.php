<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosLegalizacionModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$oficina_id,$Conex){	
    
	$parametros_legalizacion_caja_id = $this -> DbgetMaxConsecutive("parametros_legalizacion_caja","parametros_legalizacion_caja_id",$Conex,false,1);		
	$this -> assignValRequest('parametros_legalizacion_caja_id',$parametros_legalizacion_caja_id);	
	$this -> Begin($Conex);	
		$this -> DbInsertTable("parametros_legalizacion_caja",$Campos,$Conex,true,false);
		
		if($this -> GetNumError() > 0){
			return false;
		}else{		
		    if($this -> GetNumError() > 0){
			  return false;
			}else{
			
			  if(is_array($_REQUEST['detalle_parametros_legalizacion_caja'])){
               for($i = 0; $i < count($_REQUEST['detalle_parametros_legalizacion_caja']); $i++){
								
				 $detalle_parametros_legalizacion_caja_id=$this->DbgetMaxConsecutive("detalle_parametros_legalizacion_caja","detalle_parametros_legalizacion_caja_id",$Conex,false,1);	
				 $puc_id             = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['puc_id'];				  
				 $nombre_cuenta      = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['nombre_cuenta'];
				 $naturaleza         = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['naturaleza'];				  
				 $insert = "INSERT INTO detalle_parametros_legalizacion_caja (parametros_legalizacion_caja_id,puc_id,nombre_cuenta,
				 naturaleza) VALUES ($parametros_legalizacion_caja_id,$puc_id,'$nombre_cuenta','$naturaleza')";
				  
				  $this -> query($insert,$Conex,true);
					
				  if($this -> GetNumError() > 0){
					return false;
				  }			  
			  
			     }				  
			  }			
		   }			
		}	
		
	$this -> Commit($Conex);	
	return true;	
  }
	
  public function Update($Campos,$Conex){			
	$this -> Begin($Conex);	
	    $parametros_legalizacion_caja_id = $_REQUEST['parametros_legalizacion_caja_id'];	
		$this -> DbUpdateTable("parametros_legalizacion_caja",$Campos,$Conex,true,false);

		if($this -> GetNumError() > 0){
			return false;
		}else{		   
		    if($this -> GetNumError() > 0){
			  return false;
			}else{
			
			  if(is_array($_REQUEST['detalle_parametros_legalizacion_caja'])){			  
			    $detalles_remesa_id = null;

                for($i = 0; $i < count($_REQUEST['detalle_parametros_legalizacion_caja']); $i++){				
				  $detalle_parametros_legalizacion_caja_id = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['detalle_parametros_legalizacion_caja_id'];				  
				  				  
				  if(is_numeric($detalle_parametros_legalizacion_caja_id) > 0){				  
				  
					 $puc_id                               = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['puc_id'];				  
					 $nombre_cuenta                        = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['nombre_cuenta'];
					 $naturaleza                           = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['naturaleza'];					  
                     $insert = "UPDATE detalle_parametros_legalizacion_caja SET puc_id='$puc_id',nombre_cuenta='$nombre_cuenta',naturaleza='$naturaleza'
					 WHERE detalle_parametros_legalizacion_caja_id=$detalle_parametros_legalizacion_caja_id";
				  
				  }else{				  
					 $detalle_parametros_legalizacion_caja_id=$this->DbgetMaxConsecutive("detalle_parametros_legalizacion_caja","detalle_parametros_legalizacion_caja_id",$Conex,false,1);	
					 $puc_id             = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['puc_id'];				  
					 $nombre_cuenta      = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['nombre_cuenta'];
					 $naturaleza         = $_REQUEST['detalle_parametros_legalizacion_caja'][$i]['naturaleza'];						  
					 $insert = "INSERT INTO detalle_parametros_legalizacion_caja (detalle_parametros_legalizacion_caja_id,parametros_legalizacion_caja_id,puc_id,
					 nombre_cuenta,naturaleza) VALUES ($detalle_parametros_legalizacion_caja_id,$parametros_legalizacion_caja_id,$puc_id,'$nombre_cuenta','$naturaleza')";					  

				    }

				  $this -> query($insert,$Conex);					
				  if($this -> GetNumError() > 0){
					return false;				  }				  
			  
			      $detalles_parametros_legalizacion_caja_id .= "$detalle_parametros_legalizacion_caja_id,";			  
			    }
				
				$detalles_parametros_legalizacion_caja_id = substr($detalles_parametros_legalizacion_caja_id,0,strlen($detalles_parametros_legalizacion_caja_id) - 1);				
				$delete = "DELETE FROM detalle_parametros_legalizacion_caja WHERE parametros_legalizacion_caja_id = $parametros_legalizacion_caja_id 
				AND detalle_parametros_legalizacion_caja_id NOT IN ($detalles_parametros_legalizacion_caja_id)";				
				$this -> query($delete,$Conex);					
				if($this -> GetNumError() > 0){
				  return false;
				}	
			  }
		   }	
		}
	$this -> Commit($Conex);
  }
	
  public function Delete($Campos,$Conex){  
  	$this -> DbDeleteTable("parametros_legalizacion_caja",$Campos,$Conex,true,false);	
  }	
			 	
   public function getEmpresas($usuario_id,$Conex){   
     $select = "SELECT e.empresa_id AS value,CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text 
	 FROM empresa e,tercero t WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 	 
	 return $result;   
   }				
				
  public function getTiposDocumentoContable($Conex){	  
	$select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY nombre ASC";
	$result = $this  -> DbFetchAll($select,$Conex);	
	return $result;
  }
	   
   public function selectParametrosLegalizacion($parametros_legalizacion_caja_id,$Conex){	   	   	  
	$dataParametros = array();    				
    $select = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id = p.contrapartida_id) AS contrapartida,
	p.* FROM parametros_legalizacion_caja p WHERE parametros_legalizacion_caja_id = $parametros_legalizacion_caja_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	$dataParametros[0]['parametros_legalizacion_caja'] = $result;	
    $select = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id = d.puc_id) AS puc,
	d.* FROM detalle_parametros_legalizacion_caja d WHERE d.parametros_legalizacion_caja_id = $parametros_legalizacion_caja_id";	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);					
	$dataParametros[0]['detalle_parametros_legalizacion_caja'] = $result;		
	return $dataParametros;   		   
   }
   
   public function selectOficinasEmpresa($empresa_id,$oficina_id,$Conex){   
     $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);   
     return $result;   
   }
   
   public function getQueryParametrosLegalizacionGrid(){	   	   
	$Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,
	(SELECT nombre FROM oficina WHERE oficina_id = p.oficina_id) AS oficina,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = p.tipo_documento_id) AS tipo_documento 
	FROM parametros_legalizacion_caja p ORDER BY tipo_documento";   
     return $Query;
   }  

}

?>