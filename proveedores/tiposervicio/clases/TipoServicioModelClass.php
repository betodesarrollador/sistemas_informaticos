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
  
  public function selectDatosTipoServicioId($tipo_bien_servicio_id,$Conex){
     $select    = "SELECT tipo_bien_servicio_id, nombre_bien_servicio, tipo_documento_id, fuente_servicio_cod, valor_manual, puc_manual , codigo_tipo_servicio
					FROM tipo_bien_servicio 
	                WHERE tipo_bien_servicio_id = $tipo_bien_servicio_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  
  
  public function Save($agencia,$Campos,$Conex){/*	

    $this -> Begin($Conex);
					
	  $tipo_bien_servicio_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio","tipo_bien_servicio_id",$Conex,true,1);
	
      $this -> assignValRequest('tipo_bien_servicio_id',$tipo_bien_servicio_id);
      $this -> DbInsertTable("tipo_bien_servicio",$Campos,$Conex,true,false);  
	  if(!strlen(trim($this -> GetError())) > 0){
		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina","tipo_bien_servicio_oficina_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina (tipo_bien_servicio_oficina_id,tipo_bien_servicio_id,oficina_id) 
			 				VALUES($tipo_bien_servicio_oficina_id,$tipo_bien_servicio_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}
	  	$this -> Commit($Conex);		 
  	  	return $tipo_bien_servicio_id;
	  }
  */
  	

    $this -> Begin($Conex);
	
	$nombre_bien_servicio_factura				= $_REQUEST['nombre_bien_servicio_factura'];
	$codigo_tipo_servicio						= $_REQUEST['codigo_tipo_servicio'];
	
	$select="SELECT tipo_bien_servicio_id FROM tipo_bien_servicio WHERE nombre_bien_servicio_factura LIKE '%nombre_bien_servicio_factura%' OR codigo_tipo_servicio LIKE '%codigo_tipo_servicio%'";
	 $result    = $this -> DbFetchAll($select,$Conex);
	 
	 if($result[0]['tipo_bien_servicio_id']>0){exit("Ya existe un tipo de servicio creado con los mismos datos por favor verifique");}
	 
	  $tipo_bien_servicio_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio","tipo_bien_servicio_id",$Conex,true,1);
	
	
      $this -> assignValRequest('tipo_bien_servicio_id',$tipo_bien_servicio_id);
	 
	 // $this -> assignValRequest('codigo_tipo_servicio',$codigo_tipo_servicio);
      $this -> DbInsertTable("tipo_bien_servicio",$Campos,$Conex,true,false);  

	  if(!strlen(trim($this -> GetError())) > 0){
		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina","tipo_bien_servicio_oficina_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina (tipo_bien_servicio_oficina_id, tipo_bien_servicio_id,oficina_id) 
			 				VALUES($tipo_bien_servicio_oficina_id,$tipo_bien_servicio_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}
	  	$this -> Commit($Conex);		 
	  }

	  if(!strlen(trim($this -> GetError())) > 0){
	  	$this -> Commit($Conex);		 
  	  	return $tipo_bien_servicio_id;
	  }
  
  
  }
	
  public function Update($agencia,$Campos,$Conex){/*	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_bien_servicio_id'] == 'NULL'){
	    $this -> DbInsertTable("tipo_bien_servicio",$Campos,$Conex,true,false);	

		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina","tipo_bien_servicio_oficina_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina (tipo_bien_servicio_oficina_id,tipo_bien_servicio_id,oficina_id) 
			 				VALUES($tipo_bien_servicio_oficina_id,$tipo_bien_servicio_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}

      }else{
          $this -> DbUpdateTable("tipo_bien_servicio",$Campos,$Conex,true,false);
		    $tipo_bien_servicio_id=$_REQUEST['tipo_bien_servicio_id'];
			$delete = "DELETE FROM tipo_bien_servicio_oficina WHERE tipo_bien_servicio_id=$tipo_bien_servicio_id ";
			$this -> query($delete,$Conex);	
			
			$agencia=explode(',',$agencia);
			foreach($agencia as $agencias){
						  
				 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina","tipo_bien_servicio_oficina_id",$Conex,true,1);
				 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina (tipo_bien_servicio_oficina_id,tipo_bien_servicio_id,oficina_id) 
								VALUES($tipo_bien_servicio_oficina_id,$tipo_bien_servicio_id,$agencias)";
				$this -> query($insert_agencia,$Conex);	
			}
		  
	    }
	$this -> Commit($Conex);
  */
  	
    $this -> Begin($Conex);
	  if($_REQUEST['tipo_bien_servicio_id'] == 'NULL'){
		  
		  $select="SELECT tipo_bien_servicio_id FROM tipo_bien_servicio WHERE nombre_bien_servicio_factura LIKE '%nombre_bien_servicio_factura%' OR codigo_tipo_servicio LIKE '%codigo_tipo_servicio%'";
	 $result    = $this -> DbFetchAll($select,$Conex);
	 
	 if($result[0]['tipo_bien_servicio_id']>0){exit("Ya existe un tipo de servicio creado con los mismos datos por favor verifique");}
	 
		$tipo_bien_servicio_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio","tipo_bien_servicio_id",$Conex,true,1);		  
		
	  //$this -> assignValRequest('codigo_tipo_servicio',$codigo_tipo_servicio);
      $this -> DbInsertTable("tipo_bien_servicio",$Campos,$Conex,true,false);		

		$agencia=explode(',',$agencia);
		foreach($agencia as $agencias){
					  
			 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina","tipo_bien_servicio_oficina_id",$Conex,true,1);
			 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina (tipo_bien_servicio_oficina_id,tipo_bien_servicio_id,oficina_id) 
			 				VALUES($tipo_bien_servicio_oficina_id,$tipo_bien_servicio_id,$agencias)";
			$this -> query($insert_agencia,$Conex);	
		}

      }else{
		  
		  $select="SELECT tipo_bien_servicio_id FROM tipo_bien_servicio WHERE nombre_bien_servicio_factura LIKE '%$nombre_bien_servicio_factura%' OR codigo_tipo_servicio LIKE '%$codigo_tipo_servicio%'";
	 $result    = $this -> DbFetchAll($select,$Conex);
	
	 if($result[0]['tipo_bien_servicio_id']>0){exit("Ya existe un tipo de servicio creado con los mismos datos por favor verifique");}
	 
		  $tipo_bien_servicio_id=$_REQUEST['tipo_bien_servicio_id'];
			//$codigo_tipo_servicio="C".$tipo_bien_servicio_id;
			//$this -> assignValRequest('codigo_tipo_servicio',$codigo_tipo_servicio);
            $this -> DbUpdateTable("tipo_bien_servicio",$Campos,$Conex,true,false);
		    
			$delete = "DELETE FROM tipo_bien_servicio_oficina WHERE tipo_bien_servicio_id=$tipo_bien_servicio_id ";
			$this -> query($delete,$Conex);	 
			
			$agencia=explode(',',$agencia);
			foreach($agencia as $agencias){
						  
				 $tipo_bien_servicio_oficina_id    = $this -> DbgetMaxConsecutive("tipo_bien_servicio_oficina","tipo_bien_servicio_oficina_id",$Conex,true,1);
				 $insert_agencia="INSERT INTO tipo_bien_servicio_oficina (tipo_bien_servicio_oficina_id,tipo_bien_servicio_id,oficina_id) 
								VALUES($tipo_bien_servicio_oficina_id,$tipo_bien_servicio_id,$agencias)"; 
				$this -> query($insert_agencia,$Conex);	
			}
		  
	    }
	$this -> Commit($Conex);
  
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tipo_bien_servicio",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_bien_servicio",$Campos);
	 return $Data -> GetData();
   }
	 	
   public function GetFuente($Conex){
	return $this -> DbFetchAll("SELECT fuente_servicio_cod AS value,fuente_servicio_nom AS text FROM fuente_servicio WHERE fuente_servicio_cod!='MC' AND fuente_servicio_cod!='DU'",$Conex,
	$ErrDb = false);
   }

   public function GetDocumento($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento  WHERE de_cierre=0 AND de_traslado=0 AND pago_proveedor =1",$Conex,
	$ErrDb = false);
   }
   public function GetAgencia($oficina_id,$Conex){
	return $this -> DbFetchAll("SELECT oficina_id  AS value,nombre AS text FROM oficina WHERE empresa_id=(SELECT empresa_id FROM oficina WHERE oficina_id=$oficina_id) ",$Conex,
	$ErrDb = false);
   }
   
  public function getAgencias($tipo_bien_servicio_id,$Conex){
	  $select = "SELECT oficina_id FROM tipo_bien_servicio_oficina  WHERE tipo_bien_servicio_id=$tipo_bien_servicio_id";
      $result = $this -> DbFetchAll($select,$Conex);
	  return $result; 
  }

  public function GetManual($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'SI' ), 1 => array ( 'value' => '0', 'text' => 'NO' ));
	return  $opciones;
  }

   public function GetQueryTipoServicioGrid(){
	   	   
   $Query = "SELECT t.tipo_bien_servicio_id, 
   			t.nombre_bien_servicio,
			(SELECT nombre  FROM tipo_de_documento  WHERE tipo_documento_id=t.tipo_documento_id) AS documento,
			(SELECT fuente_servicio_nom FROM fuente_servicio WHERE fuente_servicio_cod=t.fuente_servicio_cod) AS fuente_servicio,
			IF(t.valor_manual=1,'SI','NO') AS valor_manual,			
			(SELECT COUNT(*) AS movimientos FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id=t.tipo_bien_servicio_id) AS cuentas_bien,
			(SELECT COUNT(*) AS movimientos FROM devpuc_bien_servicio WHERE tipo_bien_servicio_id=t.tipo_bien_servicio_id) AS cuentas_devo			
		FROM tipo_bien_servicio t ";
   return $Query;
   }
}

?>