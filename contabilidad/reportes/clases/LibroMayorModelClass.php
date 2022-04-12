<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class LibroMayorModel extends Db{
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
  
//LISTA MENU
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
   
   
   public function getConditionOficina($usuario_id){
   
     return $condition = " AND oficina_id IN (SELECT oficina_id FROM opciones_actividad WHERE usuario_id = $usuario_id)";	 
   
   }
   
   public function getConditionCentroCosto($usuario_id){
   
     return $condition = " AND centro_de_costo_id IN (SELECT centro_de_costo_id FROM centro_de_costo WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";	 
   
   }
   
   public function getCuentasTree($Conex){
	 
	 require_once("PlanCuentasModelClass.php");
	  
	 $PlanCuentas = new PlanCuentasModel();
	 
     $reporte            = $_REQUEST['reporte'];
     $empresa_id         = $_REQUEST['empresa_id'];
     $oficina_id         = $_REQUEST['oficina_id'];	
     $centro_de_costo_id = $_REQUEST['centro_de_costo_id'];		
     $nivel              = $_REQUEST['nivel'];
     $tercero            = $_REQUEST['tercero'];
     $corte              = $_REQUEST['corte'];   
   
     $select = "SELECT p.*,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_id) AS puc_puc FROM puc p WHERE 
	 puc_puc_id IS NULL AND estado LIKE 'A' AND empresa_id = $empresa_id AND codigo_puc IN (1,2,3) ORDER BY codigo_puc";
	 
	 $cuentas = $this -> DbFetchAll($select,$Conex);
	 
	 for($i = 0; $i < count($cuentas); $i++){
	 
	   $puc_id            = $cuentas[$i]['puc_id'];
	   $operacion         = $cuentas[$i]['naturaleza'] == 'D' ? "ABS(debito) - ABS(credito)" : "ABS(credito) - ABS(debito)";
	   $cuentasMovimiento = $PlanCuentas -> getCuentasMovimiento($puc_id,$Conex);
	 
       switch($reporte){
	   
	     case "E":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id IN ($cuentasMovimiento) AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte')";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];
		 
		 break;
		 
		 case "O":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id IN ($cuentasMovimiento) AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id AND 
		   fecha <= '$corte')";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];		 
		 
		 break;
		 
		 case "C":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id IN ($cuentasMovimiento) AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte') AND 
		   centro_de_costo_id = $centro_de_costo_id";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];		 		 
		 
		 break;		 
	   
	   }
	   
	  $cuentas[$i]['saldo'] = $saldo;
	 
	 
	 }
	  
	 return $cuentas;	 
   
   }
   
  public function getChildren($IdParent,$Conex){
	 
	 require_once("PlanCuentasModelClass.php");
	  
	 $PlanCuentas = new PlanCuentasModel();
	 
     $reporte            = $_REQUEST['reporte'];
     $empresa_id         = $_REQUEST['empresa_id'];
     $oficina_id         = $_REQUEST['oficina_id'];	
     $centro_de_costo_id = $_REQUEST['centro_de_costo_id'];		
     $nivel              = $_REQUEST['nivel'];
     $tercero            = $_REQUEST['tercero'];
     $corte              = $_REQUEST['corte'];   
   
     $select = "SELECT p.*,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_id) AS puc_puc FROM puc p WHERE 
	 puc_puc_id = $IdParent AND estado = 'A' AND nivel <= $nivel";
	 
	 $cuentas = $this -> DbFetchAll($select,$Conex);
	 
	 for($i = 0; $i < count($cuentas); $i++){
	 
	   $puc_id            = $cuentas[$i]['puc_id'];
	   $operacion         = $cuentas[$i]['naturaleza'] == 'D' ? "ABS(debito) - ABS(credito)" : "ABS(credito) - ABS(debito)";
	   $cuentasMovimiento = $PlanCuentas -> getCuentasMovimiento($puc_id,$Conex);
	 
       switch($reporte){
	   
	     case "E":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id IN ($cuentasMovimiento) AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte')";
		   		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];
		 
		 break;
		 
		 case "O":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id IN ($cuentasMovimiento) AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id AND 
		   fecha <= '$corte')";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];		 
		 
		 break;
		 
		 case "C":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id IN ($cuentasMovimiento) AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte') 
		   AND centro_de_costo_id = $centro_de_costo_id";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];		 		 
		 
		 break;		 
	   
	   }
	   
	  $cuentas[$i]['saldo'] = $saldo;
	 
	 
	 }
	 
	 return $cuentas;		 
   
   }   
   
 public function getCuentaMovimiento($IdParent,$Conex){
	 
	 require_once("PlanCuentasModelClass.php");
	  
	 $PlanCuentas = new PlanCuentasModel();
	 
     $reporte            = $_REQUEST['reporte'];
     $empresa_id         = $_REQUEST['empresa_id'];
     $oficina_id         = $_REQUEST['oficina_id'];	
     $centro_de_costo_id = $_REQUEST['centro_de_costo_id'];		
     $nivel              = $_REQUEST['nivel'];
     $tercero            = $_REQUEST['tercero'];
     $corte              = $_REQUEST['corte'];   
   
     $select = "SELECT p.*,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.puc_id) AS puc_puc FROM puc p WHERE 
	 puc_id = $IdParent AND estado = 'A'";
	 
	 $cuentas = $this -> DbFetchAll($select,$Conex);
	  
	 $puc_id            = $cuentas[0]['puc_id'];
	 $operacion         = $cuentas[0]['naturaleza'] == 'D' ? "ABS(debito) - ABS(credito)" : "ABS(credito) - ABS(debito)";
	 $cuentasMovimiento = $cuentas[0]['puc_id'];
	 
       switch($reporte){
	   
	     case "E":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id = $puc_id AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte')";
		   		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];
		   	   
		   if($tercero == 'S'){
	  
	         $select = "SELECT (SELECT CONCAT_WS(' ',IF(length(razon_social) > 0,razon_social,CONCAT(primer_nombre,' ',segundo_nombre,
			 ' ',primer_apellido,' ',segundo_apellido)),numero_identificacion) FROM tercero WHERE tercero_id =  i.tercero_id) AS 
			 tercero,SUM($operacion) AS saldo FROM 
			 imputacion_contable i WHERE puc_id = $puc_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro 
			 WHERE empresa_id = $empresa_id AND fecha <= '$corte') GROUP BY tercero HAVING ABS(saldo) > 0";
			 
			 $saldoTerceros = $this -> DbFetchAll($select,$Conex);
			 
			 if(count($saldoTerceros) > 0){
			   $cuentas[0]['saldo_terceros'] = $saldoTerceros;
			 }
	  
	       }
		 
		 break;
		 
		 case "O":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id = $puc_id AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id AND 
		   fecha <= '$corte')";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];		
		   
		   if($tercero == 'S'){
	  
	         $select = "SELECT (SELECT CONCAT_WS(' ',IF(length(razon_social) > 0,razon_social,CONCAT(primer_nombre,' ',segundo_nombre,
			 ' ',primer_apellido,' ',segundo_apellido)),numero_identificacion) FROM tercero WHERE tercero_id =  i.tercero_id) AS 
			 tercero,SUM($operacion) AS saldo FROM imputacion_contable i WHERE puc_id = $puc_id AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id AND 
		   fecha <= '$corte') GROUP BY tercero HAVING ABS(saldo) > 0";
			 
			 $saldoTerceros = $this -> DbFetchAll($select,$Conex);
			 
			 if(count($saldoTerceros) > 0){
			   $cuentas[0]['saldo_terceros'] = $saldoTerceros;
			 }
	  
	       }		    
		 
		 break;
		 
		 case "C":
		 
           $select = "SELECT SUM($operacion) AS saldo FROM imputacion_contable WHERE puc_id = $puc_id AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte') 
		   AND centro_de_costo_id = $centro_de_costo_id";
		   
		   $saldo = $this -> DbFetchAll($select,$Conex);
		   $saldo = $saldo[0]['saldo'];	
		   
		   if($tercero == 'S'){
	  
	         $select = "SELECT (SELECT CONCAT_WS(' ',IF(length(razon_social) > 0,razon_social,CONCAT(primer_nombre,' ',segundo_nombre,
			 ' ',primer_apellido,' ',segundo_apellido)),numero_identificacion) FROM tercero WHERE tercero_id =  i.tercero_id) AS 
			 tercero,SUM($operacion) AS saldo FROM imputacion_contable i WHERE puc_id = $puc_id AND encabezado_registro_id IN (
		   SELECT encabezado_registro_id FROM encabezado_de_registro WHERE empresa_id = $empresa_id AND fecha <= '$corte') 
		   AND centro_de_costo_id = $centro_de_costo_id GROUP BY tercero HAVING ABS(saldo) > 0";
			 
			 $saldoTerceros = $this -> DbFetchAll($select,$Conex);
			 
			 if(count($saldoTerceros) > 0){
			   $cuentas[0]['saldo_terceros'] = $saldoTerceros;
			 }
	  
	       }			   	 		 
		 
		 break;		 
	   
	   }
	   
	  $cuentas[0]['saldo'] = $saldo;
	  	 
	  return $cuentas[0];		 
   
   }      
      
   
}

?>