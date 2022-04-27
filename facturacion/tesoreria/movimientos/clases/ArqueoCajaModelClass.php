<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ArqueoCajaModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosArqueoCajaId($arqueo_caja_id,$Conex){
	$select = "SELECT * FROM arqueo_caja WHERE arqueo_caja_id=$arqueo_caja_id";     
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;  
  }


  public function Save($Campos,$Conex,$usuario_id,$oficina_id){

	$arqueo_caja_id = $this -> DbgetMaxConsecutive("arqueo_caja","arqueo_caja_id",$Conex,false,1);		
	$this -> assignValRequest('arqueo_caja_id',$arqueo_caja_id);	

	$select = "SELECT MAX(consecutivo) AS cons FROM  arqueo_caja WHERE oficina_id=$oficina_id";
	$result = $this -> DbFetchAll($select,$Conex);	
	$consecutivo= $result[0][cons]>0 ? ($result[0][cons]+1):1;		
	$this -> assignValRequest('consecutivo',$consecutivo);

	$this -> Begin($Conex);	
		$this -> DbInsertTable("arqueo_caja",$Campos,$Conex,true,false);
		
		if($this -> GetNumError() > 0){ 
			$this -> RollBack($Conex);	
			return false;
		}else{		
			if(is_array($_REQUEST['monedas'])){
				$monedas = $_REQUEST['monedas'];
			 	for($i = 0; $i < count($monedas); $i++){
					$tipo_dinero_id = $monedas[$i]['tipo_dinero_id'];
					$cantidad = $monedas[$i]['cantidad'];
					$cantidad = $cantidad=='' ? 0 : $cantidad;
					$total = $monedas[$i]['total'];
					$total = $total=='' ? 0 : $this -> removeFormatCurrency($total);
					
					$deta_arqueo_caja_id = $this -> DbgetMaxConsecutive("detalles_arqueo_caja","deta_arqueo_caja_id",$Conex,false,1);		
					
					$insert = "INSERT INTO detalles_arqueo_caja (deta_arqueo_caja_id,arqueo_caja_id,tipo_dinero_id,cantidad,valor,estado_deta) 
					VALUES ($deta_arqueo_caja_id,$arqueo_caja_id,$tipo_dinero_id,$cantidad,$total,1)";
					//echo $insert;
					$this -> query($insert,$Conex,true);						  
				}
			}
			if(is_array($_REQUEST['billetes'])){
				$billetes = $_REQUEST['billetes'];
			 	for($i = 0; $i < count($billetes); $i++){
					$tipo_dinero_id = $billetes[$i]['tipo_dinero_id'];
					$cantidad = $billetes[$i]['cantidad'];
					$cantidad = $cantidad=='' ? 0 : $cantidad;
					$total = $billetes[$i]['total'];
					$total = $total=='' ? 0 : $this -> removeFormatCurrency($total);
					
					
					$deta_arqueo_caja_id = $this -> DbgetMaxConsecutive("detalles_arqueo_caja","deta_arqueo_caja_id",$Conex,false,1);		
					
					$insert = "INSERT INTO detalles_arqueo_caja (deta_arqueo_caja_id,arqueo_caja_id,tipo_dinero_id,cantidad,valor,estado_deta) 
					VALUES ($deta_arqueo_caja_id,$arqueo_caja_id,$tipo_dinero_id,$cantidad,$total,1)";
					//echo $insert;
					$this -> query($insert,$Conex,true);						  
				}
			}
			
			$this -> Commit($Conex);	
			return $arqueo_caja_id;	
		}	
  }
	
  public function Update($Campos,$Conex){
	  
	$this -> Begin($Conex);	
	    $arqueo_caja_id = $_REQUEST['arqueo_caja_id'];	
		$this -> DbUpdateTable("arqueo_caja",$Campos,$Conex,true,false);

		if($this -> GetNumError() > 0){
			$this -> RollBack($Conex);	
			return false;
		}else{		
			if(is_array($_REQUEST['monedas'])){
				$monedas = $_REQUEST['monedas'];
			 	for($i = 0; $i < count($monedas); $i++){
					$tipo_dinero_id = $monedas[$i]['tipo_dinero_id'];
					$cantidad = $monedas[$i]['cantidad'];
					$cantidad = $cantidad=='' ? 0 : $cantidad;
					$total = $monedas[$i]['total'];
					$total = $total=='' ? 0 : $total;
					
					$select = "SELECT deta_arqueo_caja_id FROM  detalles_arqueo_caja WHERE arqueo_caja_id=$arqueo_caja_id AND tipo_dinero_id='".$tipo_dinero_id."'";
					$result = $this -> DbFetchAll($select,$Conex);	

					
					if($result[0][deta_arqueo_caja_id]>0){
						$update = "UPDATE detalles_arqueo_caja SET cantidad=$cantidad, valor=$total WHERE arqueo_caja_id=$arqueo_caja_id AND tipo_dinero_id='".$tipo_dinero_id."'";
						$this -> query($update,$Conex,true);						  
						
					}else{
						$deta_arqueo_caja_id = $this -> DbgetMaxConsecutive("deta_arqueo_caja","deta_arqueo_caja_id",$Conex,false,1);		
						
						$insert = "INSERT INTO detalles_arqueo_caja (deta_arqueo_caja_id,arqueo_caja_id,tipo_dinero_id,cantidad,valor,estado_deta) 
						VALUES ($deta_arqueo_caja_id,$arqueo_caja_id,$tipo_dinero_id,$cantidad,$total,'A');";
						$this -> query($insert,$Conex,true);						  
					}
				}
			}
			if(is_array($_REQUEST['billetes'])){
				$billetes = $_REQUEST['billetes'];
			 	for($i = 0; $i < count($billetes); $i++){
					$tipo_dinero_id = $billetes[$i]['tipo_dinero_id'];
					$cantidad = $billetes[$i]['cantidad'];
					$cantidad = $cantidad=='' ? 0 : $cantidad;
					$total = $billetes[$i]['total'];
					$total = $total=='' ? 0 : $total;
					
					$select = "SELECT deta_arqueo_caja_id FROM  detalles_arqueo_caja WHERE arqueo_caja_id=$arqueo_caja_id AND tipo_dinero_id='".$tipo_dinero_id."'";
					$result = $this -> DbFetchAll($select,$Conex);	

					
					if($result[0][deta_arqueo_caja_id]>0){
						$update = "UPDATE detalles_arqueo_caja SET cantidad=$cantidad, valor=$total WHERE arqueo_caja_id=$arqueo_caja_id AND tipo_dinero_id='".$tipo_dinero_id."'";
						$this -> query($update,$Conex,true);						  
						
					}else{
						$deta_arqueo_caja_id = $this -> DbgetMaxConsecutive("deta_arqueo_caja","deta_arqueo_caja_id",$Conex,false,1);		
						
						$insert = "INSERT INTO detalles_arqueo_caja (deta_arqueo_caja_id,arqueo_caja_id,tipo_dinero_id,cantidad,valor,estado_deta) 
						VALUES ($deta_arqueo_caja_id,$arqueo_caja_id,$tipo_dinero_id,$cantidad,$total,'A');";
						$this -> query($insert,$Conex,true);						  
					}
				}
			}
		
			$this -> Commit($Conex);
		}
	  
  }  
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"arqueo_caja",$Campos);
	 return $Data -> GetData();
   }

  
  public function cancellation($Conex){
	$this -> Begin($Conex);

      $arqueo_caja_id 		  		= $this -> requestDataForQuery('arqueo_caja_id','integer');
      $causal_anulacion_id  		= $this -> requestDataForQuery('causal_anulacion_id','integer');
      $fecha_anul   	  			= $this -> requestDataForQuery('fecha_anul','text');
	  $desc_anul_arqueo  			= $this -> requestDataForQuery('desc_anul_arqueo','text');
	  $anul_usuario_id          	= $this -> requestDataForQuery('anul_usuario_id','integer');	
	  $anul_oficina_id          	= $this -> requestDataForQuery('anul_oficina_id','integer');	

	  $update = "UPDATE arqueo_caja SET estado_arqueo= 'A',
	  causal_anulacion_id = $causal_anulacion_id,
	  fecha_anul=$fecha_anul,
	  desc_anul_arqueo =$desc_anul_arqueo,
	  anul_usuario_id=$anul_usuario_id,
	  anul_oficina_id=$anul_oficina_id
	  WHERE arqueo_caja_id=$arqueo_caja_id";	
      $this -> query($update,$Conex);		  
	
	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex);
	  }else{		
      	$this -> Commit($Conex);			
	  }  
	  
  }

  public function getCausalesAnulacion($Conex){	
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getParametrosCaja($oficina_id,$Conex){	  
	$select = "SELECT parametros_legalizacion_arqueo_id AS value, nombre_puc AS text,  
	(SELECT parametros_legalizacion_arqueo_id FROM  parametros_legalizacion_arqueo WHERE oficina_id=$oficina_id LIMIT 1) AS selected
	FROM parametros_legalizacion_arqueo 
	WHERE oficina_id = $oficina_id";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getParametrosCaja1($parametros_legalizacion_arqueo_id,$Conex){	  
	$select = "SELECT *
	FROM parametros_legalizacion_arqueo 
	WHERE parametros_legalizacion_arqueo_id = $parametros_legalizacion_arqueo_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	return $result;		
  }


  public function getParametros($oficina_id,$Conex){	
	$select = "SELECT * FROM  parametros_legalizacion_arqueo WHERE oficina_id=$oficina_id";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getDocumentos($Conex){	
	$select = "SELECT GROUP_CONCAT(tipo_documento_id) AS documentos FROM    tipo_de_documento WHERE de_cierre=0";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }
  public function getDocumentos1($Conex){	
	$select = "SELECT GROUP_CONCAT(tipo_documento_id) AS documentos FROM    tipo_de_documento WHERE de_cierre=0";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result[0][documentos];		
  }

  public function getCentros($oficina_id,$Conex){	
	$select = "SELECT centro_de_costo_id  FROM    centro_de_costo WHERE oficina_id=$oficina_id";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getMonedas($Conex){	
	$select = "SELECT tipo_dinero_id,valor_dinero  FROM tipo_dinero WHERE estado_dinero ='A' AND tipo='M' ORDER BY valor_dinero ASC ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getBilletes($Conex){	
	$select = "SELECT tipo_dinero_id,valor_dinero  FROM tipo_dinero WHERE estado_dinero ='A' AND tipo='B' ORDER BY valor_dinero ASC ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getMonedasArqueo($arqueo_caja_id,$Conex){	

	$select = "SELECT t.tipo_dinero_id,t.valor_dinero, d.cantidad, d.valor as total  FROM tipo_dinero t, detalles_arqueo_caja d 
	WHERE d.arqueo_caja_id=$arqueo_caja_id AND t.tipo_dinero_id=d.tipo_dinero_id AND t.tipo='M' ORDER BY t.valor_dinero ASC ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getBilletesArqueo($arqueo_caja_id,$Conex){	
	$select = "SELECT t.tipo_dinero_id,t.valor_dinero, d.cantidad, d.valor as total  FROM tipo_dinero  t, detalles_arqueo_caja d 
	WHERE d.arqueo_caja_id=$arqueo_caja_id AND t.tipo_dinero_id=d.tipo_dinero_id AND t.tipo='B' ORDER BY t.valor_dinero ASC ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }

  public function getCheques($fecha,$oficina_id,$Conex){	
	$select = "SELECT GROUP_CONCAT(CONCAT_WS('','No Cheque: ',a.num_cheque,'\nValor: ', a.valor_neto_factura,'\nCliente: ' ,
	(SELECT TRIM(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) FROM  tercero t, cliente c WHERE c.cliente_id=a.cliente_id AND t.tercero_id=c.tercero_id )),'\n\n') AS cheques  
	FROM abono_factura a WHERE a.estado_cheque ='E' AND a.estado_abono_factura!='I' AND oficina_id=$oficina_id AND fecha<='$fecha'  ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result[0][cheques];		
  }

  public function getValCheques($fecha,$oficina_id,$Conex){	
	$select = "SELECT SUM(a.valor_neto_factura)  AS valor
	FROM abono_factura a WHERE a.estado_cheque ='E' AND a.estado_abono_factura!='I' AND oficina_id=$oficina_id AND fecha<='$fecha'  ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result[0][valor];		
  }

  public function getConsecutivo($arqueo_caja_id,$Conex){	
	$select = "SELECT consecutivo
	FROM arqueo_caja  WHERE arqueo_caja_id =$arqueo_caja_id ";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result[0][consecutivo];		
  }

  public function getComprobar($parametros_legalizacion_arqueo_id,$fecha,$oficina_id,$Conex){	
	$select = "SELECT arqueo_caja_id  FROM arqueo_caja WHERE estado_arqueo !='A' AND oficina_id=$oficina_id AND fecha_arqueo='$fecha' AND parametros_legalizacion_arqueo_id=$parametros_legalizacion_arqueo_id ";
	$result = $this -> DbFetchAll($select,$Conex);	//echo $select;
	return $result[0][arqueo_caja_id];		
  }

  public function getCerrar($arqueo_caja_id,$Conex){	

	$update = "UPDATE arqueo_caja SET estado_arqueo='C' WHERE arqueo_caja_id=$arqueo_caja_id";
	$this -> query($update,$Conex,true);						  
	
	if($this -> GetNumError() > 0){
		return false;
	}else{		
		return true;
	}
  }

  public function GetQueryArqueoCajaGrid($oficina_id){  	   
   $Query = "SELECT a.consecutivo,a.fecha_arqueo,a.total_efectivo,a.total_cheque,a.total_caja,a.saldo_auxiliar,a.diferencia,
   CASE a.estado_arqueo WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' ELSE 'EDICION' END AS estado
   FROM arqueo_caja a WHERE oficina_id=$oficina_id";		 
   return $Query;
   }
}

?>