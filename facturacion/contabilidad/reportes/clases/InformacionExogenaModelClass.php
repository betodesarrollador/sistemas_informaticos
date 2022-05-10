<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class InformacionExogenaModel extends Db{
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }

  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function getDatosEmpresa($empresa_id,$Conex){
  
     $select = "SELECT t.direccion FROM tercero t, empresa e WHERE e.empresa_id=$empresa_id AND t.tercero_id=e.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,true);
	 return $result[0]['direccion'];	  	 
  
  }    

  public function selecttercero($numero_identificacion,$Conex){
  
     $select = "SELECT tercero_id FROM tercero WHERE numero_identificacion=$numero_identificacion";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result[0][tercero_id];	  	 
  
  }    

  public function getCuentamin($concepto,$formato_exogena_id,$Conex){
  
     $select = "SELECT MIN(p.codigo_puc) AS cuenta_min
	 FROM formato_exogena f, cuenta_exogena c, puc p, concepto_exogena ce 
	 WHERE f.formato_exogena_id = $formato_exogena_id AND c.formato_exogena_id=f.formato_exogena_id AND p.puc_id=c.puc_id 
	 AND ce.concepto_exogena_id=c.concepto_exogena_id AND ce.codigo='$concepto'";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result[0][cuenta_min];	  	 
  
  }    

  public function getCuentamax($concepto,$formato_exogena_id,$Conex){
  
     $select = "SELECT MAX(p.codigo_puc) AS cuenta_max	
	 FROM formato_exogena f, cuenta_exogena c, puc p, concepto_exogena ce 
	 WHERE f.formato_exogena_id = $formato_exogena_id AND c.formato_exogena_id=f.formato_exogena_id AND p.puc_id=c.puc_id 
	 AND ce.concepto_exogena_id=c.concepto_exogena_id AND ce.codigo='$concepto'";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result[0][cuenta_max];	  	 
  
  }    

  public function selectFormato($formato_exogena_id,$Conex){
  
     $select = "SELECT tipo_formato FROM formato_exogena WHERE formato_exogena_id=$formato_exogena_id";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result[0][tipo_formato];	  	 
  
  }    

  public function selectdataFormato($formato_exogena_id,$Conex){
  
     $select = "SELECT * FROM formato_exogena WHERE formato_exogena_id=$formato_exogena_id";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result[0];	  	 
  
  }    

  public function selectPeriodo($periodo_contable_id,$Conex){
  
     $select = "SELECT anio FROM periodo_contable WHERE periodo_contable_id=$periodo_contable_id";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result[0][anio];	  	 
  
  }    

  public function getFormato($Conex){
  
     $select = "SELECT formato_exogena_id AS value,CONCAT('Resolucion: ',resolucion,' - Formato: ',tipo_formato,' A&ntilde;o Gravable: ',ano_gravable) AS text FROM formato_exogena WHERE tipo='N'";
     $result = $this -> DbFetchAll($select,$Conex);
	 return $result;	  	 
  
  }    
  
  public function getPeriodo($Conex){
  
     $select = "SELECT periodo_contable_id AS value, anio AS text  FROM periodo_contable   ORDER BY anio ASC ";
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result;		 
  
  }


  public function getValPeriodo($formato_exogena_id,$concepto_exogena_id,$Conex){

	 $select = "SELECT c.tipo_sumatoria
	 FROM formato_exogena f, cuenta_exogena c 
	 WHERE f.formato_exogena_id = $formato_exogena_id AND c.formato_exogena_id=f.formato_exogena_id 
	 AND c.concepto_exogena_id=$concepto_exogena_id AND c.tipo_sumatoria IN ('SCC','DCC','CDC') ";  
	 $result = $this -> DbFetchAll($select,$Conex,true);

	 return $result;		 
  }

  public function getcuentasConcepto($formato_exogena_id,$concepto_exogena_id,$Conex){

	 $select = "SELECT c.puc_id
	 FROM formato_exogena f, cuenta_exogena c 
	 WHERE f.formato_exogena_id = $formato_exogena_id AND c.formato_exogena_id=f.formato_exogena_id 
	 AND c.concepto_exogena_id=$concepto_exogena_id
	 GROUP BY c.puc_id
	 ORDER BY  c.puc_id "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);

	 return $result;		 
  }

  public function getcuentasCategConcep($formato_exogena_id,$categoria_exogena_id,$concepto_exogena_id,$Conex){

	 $select = "SELECT c.puc_id, c.tipo_sumatoria
	 FROM  cuenta_exogena c 
	 WHERE c.formato_exogena_id=$formato_exogena_id	AND c.categoria_exogena_id=$categoria_exogena_id AND c.concepto_exogena_id=$concepto_exogena_id
	 GROUP BY   c.puc_id
	 ORDER BY c.cuenta_exogena_id";  
	 $result = $this -> DbFetchAll($select,$Conex,true);

	 return $result;		 
  }

  public function getcuentasSubCategConcep($formato_exogena_id,$categoria_exogena_id,$concepto_exogena_id,$Conex){

	 $select = "SELECT c.puc_id, c.tipo_sumatoria
	 FROM  cuenta_exogena c 
	 WHERE c.formato_exogena_id=$formato_exogena_id	AND c.base_categoria_exogena_id=$categoria_exogena_id AND c.concepto_exogena_id=$concepto_exogena_id
	 GROUP BY   c.puc_id
	 ORDER BY c.cuenta_exogena_id";  
	 $result = $this -> DbFetchAll($select,$Conex,true);

	 return $result;		 
  }

  public function getcategoriaExogena($formato,$Conex){

	 $select = "SELECT ce.categoria_exogena_id, ce.codigo AS categoria, ce.descripcion AS categoria_nombre
	 FROM   categoria_exogena ce  
	 WHERE SUBSTR(ce.codigo, 1, 4) = '$formato'
	 GROUP BY ce.codigo
	 ORDER BY ce.codigo ASC "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);

	  
	 return $result;		 
  
  }

  public function getconceptoExogena($formato_exogena_id,$Conex){

	 $select = "SELECT ce.concepto_exogena_id, ce.codigo AS concepto, ce.nombre AS concepto_nombre
	 FROM   cuenta_exogena c, concepto_exogena ce  
	 WHERE c.formato_exogena_id=$formato_exogena_id AND ce.concepto_exogena_id=c.concepto_exogena_id AND c.estado='A' AND ce.estado='A'
	 GROUP BY ce.codigo
	 ORDER BY ce.codigo ASC "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);

	  
	 return $result;		 
  
  }

  public function selectDataExogena($consulta,$Conex){

	 $result = $this -> DbFetchAll($consulta,$Conex,true);
	 return $result;		 
  }  

   
}

?>