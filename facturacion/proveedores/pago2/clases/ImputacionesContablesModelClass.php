<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ImputacionContableModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($encabezado_registro_id,$Conex){
	   	
	if(is_numeric($encabezado_registro_id)){
	
	  $select  = "SELECT i.*,(SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,(SELECT codigo_puc  FROM puc WHERE puc_id = i.puc_id) AS puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,(SELECT  codigo  FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo,(SELECT codigo FROM area WHERE area_id = i.area_id)as codigo_area, (SELECT codigo FROM departamento WHERE departamento_id = i.departamento_id)as codigo_dep,(SELECT unidad_negocio_id FROM unidad_negocio WHERE unidad_negocio_id = i.unidad_negocio_id)as nombre_unidad,(SELECT nombre FROM oficina WHERE oficina_id=i.sucursal_id ) as sucursal
	  
	  FROM imputacion_contable i WHERE encabezado_registro_id = $encabezado_registro_id";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
  public function getEstadoEncabezado($encabezado_registro_id,$Conex){
  
    $select = "SELECT estado FROM encabezado_de_registro WHERE encabezado_registro_id= $encabezado_registro_id";	
    $result = $this -> DbFetchAll($select,$Conex,true);	
	
	return $result[0]['estado'];
  
  }
  
  public function getImputacionesContablesAnuladas($encabezado_registro_id,$Conex){
	   	
	if(is_numeric($encabezado_registro_id)){
	
	  $select  = "SELECT i.*,(SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,(SELECT concat(codigo_puc,' - ',nombre)  FROM puc WHERE puc_id = i.puc_id) AS puc,(SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT CONCAT_WS(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social,sigla) FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo ,(SELECT CONCAT(codigo,' - ',nombre) FROM area WHERE area_id = i.area_id)as codigo_area, (SELECT CONCAT(codigo,' - ',nombre) FROM departamento WHERE departamento_id = i.departamento_id)as codigo_dep,(SELECT nombre FROM unidad_negocio WHERE unidad_negocio_id = i.unidad_negocio_id)as nombre_unidad,(SELECT nombre FROM oficina WHERE oficina_id=i.sucursal_id ) as sucursal
	  FROM imputacion_contable_anulada i WHERE encabezado_registro_anulado_id = $encabezado_registro_id";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }  
    
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');
      $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
      $puc_id                 = $this -> requestDataForQuery('puc_id','integer');	  
      $tercero_id             = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $descripcion            = $this -> requestDataForQuery('descripcion','text');	  
	  $sucursal_id            = $this -> requestDataForQuery('sucursal_id','text');	  
	  $area_id                = $this -> requestDataForQuery('area_id','text');	  
	  $departamento_id        = $this -> requestDataForQuery('departamento_id','text');	  
	  $unidad_negocio_id       = $this -> requestDataForQuery('unidad_negocio_id','text');	  
	  

	  $base   = str_replace(",",".",str_replace(".","",$_REQUEST['base']))   ;	  
	  $debito = str_replace(",",".",str_replace(".","",$_REQUEST['debito'])) ;
	  $credito= str_replace(",",".",str_replace(".","",$_REQUEST['credito']));	  
	  
	  $base   = $base    > 0 ? $base    : 0;
	  $debito = $debito  > 0 ? $debito  : 0;	  	  	  
	  $credito= $credito > 0 ? $credito : 0;

	
      $insert = "INSERT INTO imputacion_contable 
	            (imputacion_contable_id,encabezado_registro_id,puc_id,tercero_id,centro_de_costo_id,descripcion,base,debito,credito,sucursal_id,area_id,departamento_id,unidad_negocio_id) 
	            VALUES  
				($imputacion_contable_id,$encabezado_registro_id,$puc_id,$tercero_id,$centro_de_costo_id,$descripcion,$base,$debito,$credito,$sucursal_id,$area_id,$departamento_id,$unidad_negocio_id)";
	//echo $insert;
      $this -> query($insert,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $imputacion_contable_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $imputacion_contable_id = $this -> requestDataForQuery('imputacion_contable_id','integer');
      $puc_id                 = $this -> requestDataForQuery('puc_id','integer');	  
      $tercero_id             = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $descripcion            = $this -> requestDataForQuery('descripcion','text');
	  $sucursal_id            = $this -> requestDataForQuery('sucursal_id','text');	  
	  $area_id                = $this -> requestDataForQuery('area_id','text');	  
	  $departamento_id        = $this -> requestDataForQuery('departamento_id','text');	  
	  $unidad_negocio_id       = $this -> requestDataForQuery('unidad_negocio_id','text');	  

	  
	  $base   = str_replace(",",".",str_replace(".","",$_REQUEST['base']))   ;	  
	  $debito = str_replace(",",".",str_replace(".","",$_REQUEST['debito'])) ;
	  $credito= str_replace(",",".",str_replace(".","",$_REQUEST['credito']));	  
	  
	  $base   = $base    > 0 ? $base    : 0;
	  $debito = $debito  > 0 ? $debito  : 0;	  	  	  
	  $credito= $credito > 0 ? $credito : 0;	  
	
      $update = "UPDATE imputacion_contable SET puc_id = $puc_id,tercero_id = $tercero_id,centro_de_costo_id = 
	  $centro_de_costo_id,descripcion = $descripcion,base = $base,debito = $debito,credito = $credito, sucursal_id=$sucursal_id, area_id=$area_id,departamento_id=$departamento_id,unidad_negocio_id=$unidad_negocio_id
	  WHERE 
	  imputacion_contable_id = $imputacion_contable_id";
	
	//echo $update;
	
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $imputacion_contable_id;

  }

  public function Delete($Campos,$Conex){

    $imputacion_contable_id = $_REQUEST['imputacion_contable_id'];
	
    $insert = "DELETE FROM imputacion_contable WHERE imputacion_contable_id = $imputacion_contable_id";
	
    $this -> query($insert,$Conex,true);	

  }
  
  public function selectCuentaPuc($puc_id,$encabezado_registro_id,$Conex){
	  
	 $select   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex,true);
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE empresa_id = (SELECT empresa_id FROM encabezado_de_registro WHERE 
																   encabezado_registro_id = $encabezado_registro_id)
	            AND oficina_id = (SELECT oficina_id FROM encabezado_de_registro WHERE 
																   encabezado_registro_id = $encabezado_registro_id)
				AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
				
      $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  
	  if(!count($impuesto) > 0){
		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex,true);						  
		  
      }
	  
	$requiere_centro_costo = $requires[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	$requiere_tercero      = $requires[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	$requiere_sucursal     = $requires[0]['requiere_sucursal']      == 1 ? 'true' : 'false';
	$requiere_area      = $requires[0]['area']      == 1 ? 'true' : 'false';
	$requiere_departamento     = $requires[0]['departamento']      == 1 ? 'true' : 'false';
	$requiere_unidad      = $requires[0]['unidadnegocio']      == 1 ? 'true' : 'false';
	$requiere_base          = count($impuesto) > 0                       ? 'true' : 'false';
	  
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,
							 requiere_base=>$requiere_base,requiere_area=>$requiere_area,requiere_departamento=>$requiere_departamento,requiere_unidad=>$requiere_unidad,requiere_sucursal=>$requiere_sucursal);	  
	  
	  return $requieresCuenta;   
	  
  }
  
  public function selectImpuesto($puc_id,$base,$encabezado_registro_id,$Conex){
	  
          $select = "SELECT ip.naturaleza,imp.* FROM  impuesto ip, impuesto_periodo_contable imp WHERE imp.periodo_contable_id = (SELECT periodo_contable_id FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id) AND imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id) and imp.impuesto_id = ip.impuesto_id";
				
      $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  	  		  
	  $porcentaje    = $impuesto[0]['porcentaje'];
	  $impuesto_id   = $impuesto[0]['impuesto_id'];
	  $naturaleza    = $impuesto[0]['naturaleza'];
	  $formula       = $impuesto[0]['formula'];
	  $base          = str_replace(",",".",str_replace(".","",$base));	 
		  
      $calculo = str_replace("BASE",$base,$formula);
	  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
		  
	  $select     = "SELECT $calculo AS valor_total";
      $result     = $this -> DbFetchAll($select ,$Conex,true);
	  $valorTotal = round($result[0]['valor_total']);
		  
      return array(valor => $valorTotal, naturaleza =>$naturaleza);	  	
	  
  }

   
}



?>