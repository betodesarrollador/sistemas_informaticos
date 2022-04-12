<?php

ini_set("memory_limit","1024M");

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CertificadosRetencionModel extends Db{

  private $Permisos;
  private $mes_contable_id;
  private $periodo_contable_id;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getCodigoPuc($puc_id,$Conex){
  
    $select = "SELECT codigo_puc FROM puc WHERE puc_id = $puc_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['codigo_puc'];  
  }
  
  public function selectCuentasReporte($certificados_id,$Conex){
	  
	 $select = "SELECT 
	               puc_id AS value,CONCAT_WS(' - ',codigo_puc,nombre) AS text 
				 FROM 
				   puc 
				 WHERE 
				   puc_id IN (SELECT puc_id FROM cuentas_certificado WHERE certificados_id = $certificados_id)
				 ORDER BY 
				   codigo_puc ASC";
				   
      $result = $this->DbFetchAll($select,$Conex,true);				   
	  
	  return $result;
	  
  }      
  
  public function getCertificados($Conex){
	  
	  $select = "
	    SELECT 
		 certificados_id AS value, nombre AS text 
		FROM 
		 certificados 
		WHERE 
		 estado = 1 ORDER BY nombre ASC";
		 
	  $result = $this->DbFetchAll($select,$Conex,true);
	  
	  return $result;
	  	  
  }
  
  public function selectTercerosCuentasCertificado($puc_id,$desde,$hasta,$Conex){
	   
	  $select = "SELECT 
	              DISTINCT imputacion_contable.tercero_id 
				 FROM 
				  imputacion_contable 
				 INNER JOIN 
				  encabezado_de_registro
				 ON encabezado_de_registro.encabezado_registro_id = imputacion_contable.encabezado_registro_id
				 WHERE 
				  encabezado_de_registro.fecha BETWEEN '$desde' AND '$hasta' AND imputacion_contable.puc_id 
				  IN ($puc_id)"; 
				  
	  $result = $this->DbFetchAll($select,$Conex,true);
	  
	  return $result;
	   
   }
   
   public function getDatosCertificado($certificado_id,$Conex){
	   
	   $select = "SELECT * FROM certificados WHERE certificados_id = $certificado_id";
	   $result = $this->DbFetchAll($select,$Conex,true);
	   
	   return $result;
	   
   }
 
   public function getDatosLogo($oficina_id,$Conex){
	   
	   $select = "SELECT logo FROM empresa e, oficina o WHERE o.oficina_id = $oficina_id AND e.empresa_id=o.empresa_id";
	   $result = $this->DbFetchAll($select,$Conex,true);
	   
	   return $result[0][logo];
	   
   }
 
   public function getNombresTercero($tercero_id,$Conex){
	   
	   $select = "SELECT 
	               CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) 
				   AS tercero FROM tercero WHERE tercero_id = $tercero_id";
	   
	   $result = $this->DbFetchAll($select,$Conex,true);
	   
	   return $result[0]['tercero'];
	   
   }
   
   public function getIdentificacionTercero($tercero_id,$Conex){
	   
	   $select = "SELECT 
	               CONCAT_WS('-',numero_identificacion,digito_verificacion) AS identificacion
				  FROM 
				   tercero 
				  WHERE tercero_id = $tercero_id";
	   
	   $result = $this->DbFetchAll($select,$Conex,true);
	   
	   return $result[0]['identificacion'];	   
	   
   }
   
   public function getTotalCuentas($tercero_id,$puc_id,$desde,$hasta,$Conex){
	   
     $select = "SELECT 
 	 SUM(i.base) AS base,
	 IF(im.para_terceros=0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE   SUM(credito - debito) END), (CASE WHEN p.naturaleza = 'D' THEN SUM(credito) ELSE   SUM(credito) END)) AS saldo 
	 FROM encabezado_de_registro e, imputacion_contable i, puc p, impuesto im 
	 WHERE e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id IN ($puc_id) AND e.fecha BETWEEN 
	 '$desde' AND '$hasta' AND (i.debito>0 OR i.credito>0) AND i.puc_id = p.puc_id AND im.puc_id=p.puc_id AND e.tipo_documento_id NOT IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_traslado=1) GROUP BY i.tercero_id";    
  	
     $result = $this -> DbFetchAll($select,$Conex,true); 
	 
	 return $result;
	   
   }
   
   public function getMovCuentas($tercero_id,$puc_id,$desde,$hasta,$Conex){
	   
     $select = "SELECT p.nombre,
	 (SELECT porcentaje FROM impuesto_periodo_contable WHERE impuesto_id=im.impuesto_id AND periodo_contable_id=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=YEAR(DATE(e.fecha)) LIMIT 1) LIMIT 1) AS porcen,
	 (SELECT formula FROM impuesto_periodo_contable WHERE impuesto_id=im.impuesto_id AND periodo_contable_id=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=YEAR(DATE(e.fecha)) LIMIT 1) LIMIT 1) AS formu,	 
	 IF(im.para_terceros=0,SUM(i.base),SUM(IF(i.credito>0,i.base,0))) AS base,
	 IF(im.para_terceros=0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE   SUM(credito - debito) END), (CASE WHEN p.naturaleza = 'D' THEN SUM(debito) ELSE   SUM(credito) END)) AS saldo 
	 FROM encabezado_de_registro e, imputacion_contable i, puc p, impuesto im,tipo_de_documento td
	 WHERE e.encabezado_registro_id  = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id IN ($puc_id) AND e.fecha BETWEEN 
	 '$desde' AND '$hasta' AND (i.debito>0 OR i.credito>0) AND i.puc_id = p.puc_id AND im.puc_id=p.puc_id AND e.tipo_documento_id = td.tipo_documento_id AND td.de_traslado = 0 AND td.de_cierre = 0 GROUP BY p.nombre ORDER BY p.nombre ASC";
	 
     $result = $this -> DbFetchAll($select,$Conex,true);  
	 
	 return $result;	   
	   
   }
 
  
   public function selectCiudadOficina($oficina_id,$Conex){
	   
	   $select = "SELECT nombre FROM ubicacion WHERE ubicacion_id = 
	               (SELECT ubicacion_id FROM oficina WHERE oficina_id = $oficina_id)";
				   
       $result = $this->DbFetchAll($select,$Conex,true);				   
	   
	   return $result[0]['nombre'];
	   	   
   }
   
    public function selectDireccionOficina($oficina_id,$Conex){
	   
	   $select = "SELECT direccion FROM oficina o WHERE oficina_id = $oficina_id";
				   
       $result = $this->DbFetchAll($select,$Conex,true);				   
	   
	   return $result[0]['direccion'];
	   	   
   }
   
   public function getConsecutivoCertificado($Conex){
	   
	   $select             = "SELECT numero_certificado FROM certificados";
	   $result             = $this->DbFetchAll($select,$Conex,true);
	   $numero_certificado = $result[0]['numero_certificado'];
	   
	   $select                    = "SELECT MAX(numero) AS numero FROM certificados_tercero";
	   $result                    = $this->DbFetchAll($select,$Conex,true);
	   $numero_certificado_actual = $result[0]['numero'];	   
	   	   
	   if(is_numeric($numero_certificado_actual)){
		  $numero = ($numero_certificado_actual+1); 
	   }else{
		   $numero = $numero_certificado;
		 }
		 
	   return $numero;
	   
   }

	public function getCertificado($certificados_tercero_id,$Conex){
				
        $select = "SELECT e.certificado FROM certificados_tercero e WHERE certificados_tercero_id = $certificados_tercero_id";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result[0]['certificado'];
		
    }

   public function insertCertificado($tercero_id,$numero,$certificado,$desde,$hasta,$Conex){
	   
	   $insert = "INSERT INTO 
	                certificados_tercero 
				  (tercero_id,numero,certificado,desde,hasta) 
				    VALUES 
				  ($tercero_id,'$numero','$certificado','$desde','$hasta')";
				  
       $this->query($insert,$Conex,true);				  
	   
   }
  
}


?>