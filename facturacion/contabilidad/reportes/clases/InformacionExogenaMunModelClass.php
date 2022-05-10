<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InformacionExogenaMunModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function selectFormato($formato_exogena_id,$Conex){
  
     $select = "SELECT tipo_formato FROM formato_exogena WHERE formato_exogena_id=$formato_exogena_id";
	 
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result[0][tipo_formato];	  	 
  
  }    

  public function selectPeriodo($periodo_contable_id,$Conex){
  
     $select = "SELECT anio FROM periodo_contable WHERE periodo_contable_id=$periodo_contable_id";
	 
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result[0][anio];	  	 
  
  }    


  public function getFormato($Conex){
  
     $select = "SELECT formato_exogena_id AS value,CONCAT('Resolucion: ',resolucion,' - Formato: ',tipo_formato,' A&ntilde;o Gravable: ',ano_gravable) AS text FROM formato_exogena WHERE tipo='M'";
	 
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result;	  	 
  
  }    
  
  public function getPeriodo($Conex){
  
     $select = "SELECT periodo_contable_id AS value, anio AS text  FROM periodo_contable ORDER BY anio ASC ";
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result;		 
  
  }
  
  public function selectDataExogena($periodo_contable_id,$formato_exogena_id,$Conex){
  
     $select = "SELECT * FROM periodo_contable  WHERE periodo_contable_id = $periodo_contable_id";
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 $anio      = 	$result[0]['anio'];

     $select = "SELECT * FROM formato_exogena f, cuenta_concepto_exogena c  
	 WHERE f.formato_exogena_id = $formato_exogena_id AND c.formato_exogena_id=f.formato_exogena_id ORDER BY c.cod_concepto ASC";
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 $cont=0; 
	 if(count($result) > 0){
	 	   
	   $dataExogena = array();
	 
	   for($i = 0; $i < count($result); $i++){
		  $cuantia_minima= $result[$i][cuantia_minima]; 
		  $cuantias_menores= $result[$i][cuantias_menores]; 
		  $nombre_tercero= $result[$i][nombre_tercero]; 
		  $tipo_formato= $result[$i][tipo_formato]; 
		  $cod_concepto= $result[$i][cod_concepto]; 
	   	  $puc_id=$result[$i][puc_id];
		  $naturaleza_puc=$result[$i][naturaleza_puc];
		  $puc_id_no_deducible=$result[$i][puc_id_no_deducible];
		  $naturaleza_no_deducible=$result[$i][naturaleza_no_deducible];
		  $puc_id_iva_descon=$result[$i][puc_id_iva_descon];
		  $naturaleza_iva_descontable=$result[$i][naturaleza_iva_descontable];
		  $puc_id_iva_no_descontable=$result[$i][puc_id_iva_no_descontable];
		  $naturaleza_iva_no_descontable=$result[$i][naturaleza_iva_no_descontable];
		  $puc_id_rtfe_renta=$result[$i][puc_id_rtfe_renta];
		  $naturaleza_rtfe_renta=$result[$i][naturaleza_rtfe_renta];
		  $puc_id_rtfe_asumida=$result[$i][puc_id_rtfe_asumida];
		  $naturaleza_rtfe_asumida=$result[$i][naturaleza_rtfe_asumida];
		  $puc_id_iva_comun=$result[$i][puc_id_iva_comun];
		  $naturaleza_iva_comun=$result[$i][naturaleza_iva_comun];
		  $puc_id_iva_simple=$result[$i][puc_id_iva_simple];
		  $naturaleza_iva_simple=$result[$i][naturaleza_iva_simple];
		  $puc_id_iva_no_domiciliado=$result[$i][puc_id_iva_no_domiciliado];
		  $naturaleza_iva_no_domiciliado=$result[$i][naturaleza_iva_no_domiciliado];
		  $puc_id_timbre=$result[$i][puc_id_timbre];
		  $naturaleza_timbre=$result[$i][naturaleza_timbre];
		  $puc_id_practi_cree=$result[$i][puc_id_practi_cree];
		  $naturaleza_practi_cree=$result[$i][naturaleza_practi_cree];
		  $puc_id_asumidas_cree=$result[$i][puc_id_asumidas_cree];
		  $naturaleza_asumidas_cree=$result[$i][naturaleza_asumidas_cree];
		  
		  $anio_ant=($anio-1);	
		  $fecha_fin_saldo =$anio_ant."-12-31";
		  
		  if($tipo_formato=='2001' || $tipo_formato=='5001'){
			  $select = "SELECT 
			  (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_documento,
			  t.numero_identificacion,
			  t.digito_verificacion,
			  t.primer_apellido,
			  t.segundo_apellido,
			  t.primer_nombre,
			  t.segundo_nombre,
			  t.razon_social,
			  t.direccion,
			  t.telefono,
			  t.tercero_id,
			 (SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			 (SELECT divipola FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			 (SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS nom_muni,
			 (SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,
			  IF('$naturaleza_puc'='D',SUM(i.debito),SUM(i.credito)) AS cuenta_deducible,
			  SUM(i.base) AS base,
			  SUM(i.debito) AS sum_debitos,
			  SUM(i.credito) AS sum_creditos,
			  (SELECT IF('$naturaleza_no_deducible'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1 WHERE i1.puc_id='$puc_id_no_deducible' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_no_deducible,
			  (SELECT IF('$naturaleza_iva_descontable'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_iva_descon' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_iva_descontable,
			  (SELECT IF('$naturaleza_iva_no_descontable'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_iva_no_descontable' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_iva_no_descontable,
			  (SELECT IF('$naturaleza_rtfe_renta'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_rtfe_renta' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_rtfe_renta,
			  (SELECT IF('$naturaleza_rtfe_asumida'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_rtfe_asumida' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_rtfe_asumida,
			  (SELECT IF('$naturaleza_iva_comun'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_iva_comun' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_iva_comun,
			  (SELECT IF('$naturaleza_iva_simple'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_iva_simple' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_iva_simple,
			  (SELECT IF('$naturaleza_iva_no_domiciliado'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_iva_no_domiciliado' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_iva_no_domiciliado,
			  (SELECT IF('$naturaleza_timbre'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_timbre' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_timbre,
			  (SELECT IF('$naturaleza_practi_cree'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_practi_cree' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_practi_cree,
			  (SELECT IF('$naturaleza_asumidas_cree'='D',SUM(i1.debito),SUM(i1.credito))  FROM imputacion_contable i1, encabezado_de_registro e1  WHERE i1.puc_id='$puc_id_asumidas_cree' AND i1.tercero_id=i.tercero_id AND e1.encabezado_registro_id=i1.encabezado_registro_id AND YEAR(e1.fecha)='$anio') AS cuenta_asumidas_cree
			  FROM encabezado_de_registro e, imputacion_contable i, tercero t 
			  WHERE  i.puc_id=$puc_id AND (i.credito>0 OR i.debito>0) AND e.encabezado_registro_id=i.encabezado_registro_id AND YEAR(e.fecha)='$anio' AND t.tercero_id=i.tercero_id
			  GROUP BY i.tercero_id";
			  

		  }
          $result2 = $this -> DbFetchAll($select,$Conex);		  
		
		  
		  for($j = 0; $j < count($result2); $j++){

			  $tercero_id=$result2[$j]['tercero_id'];
			  $select1 = "SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo 
			  FROM encabezado_de_registro e, imputacion_contable i,puc p 
			  WHERE   i.puc_id = $puc_id AND i.tercero_id=$tercero_id AND e.encabezado_registro_id  = i.encabezado_registro_id AND i.puc_id = p.puc_id AND
			   e.fecha <='$fecha_fin_saldo' GROUP BY i.puc_id";   
			  
			 $result1 = $this -> DbFetchAll($select1,$Conex,true);    
			 $saldo= strlen(trim($result1[0]['saldo'])) > 0 ? $result1[0]['saldo'] : 0;	        

		  	  if($tipo_formato=='2001' || $tipo_formato=='5001'){	 
			  	  if(intval($result2[$j]['cuenta_deducible'])>0 || intval($result2[$j]['cuenta_deducible'])<0){
					  $dataExogena[$cont]['cod_concepto']             = substr($cod_concepto,0,4);		  			  
					  $dataExogena[$cont]['tipo_documento']           = substr($result2[$j]['tipo_documento'],0,2);		  
					  $dataExogena[$cont]['numero_identificacion']    = substr($result2[$j]['numero_identificacion'],0,20);		  
					  $dataExogena[$cont]['dv']         			   = substr($result2[$j]['digito_verificacion'],0,1);		  
					  $dataExogena[$cont]['primer_apellido']		   = substr(utf8_decode($result2[$j]['primer_apellido']),0,60);		  
					  $dataExogena[$cont]['segundo_apellido']		   = substr(utf8_decode($result2[$j]['segundo_apellido']),0,60);		  
					  $dataExogena[$cont]['primer_nombre']			   = substr(utf8_decode($result2[$j]['primer_nombre']),0,60);		  
					  $dataExogena[$cont]['otros_nombres']			   = substr(utf8_decode($result2[$j]['segundo_nombre']),0,60);		  
					  $dataExogena[$cont]['razon_social']			   = substr(utf8_decode($result2[$j]['razon_social']),0,450);		  
					  $dataExogena[$cont]['direccion']			   	   = substr(utf8_decode($result2[$j]['direccion']),0,200);	
					  $dataExogena[$cont]['telefono']			   	   = substr(utf8_decode($result2[$j]['telefono']),0,10);	
					  $dataExogena[$cont]['cod_dpto']			   	   = substr($result2[$j]['cod_depto'],0,2);		  
					  $dataExogena[$cont]['cod_mcp']			   	   = substr($result2[$j]['cod_muni'],-3);	
					  $dataExogena[$cont]['nom_mcp']			   	   = substr($result2[$j]['nom_muni'],0,40);	
					  $dataExogena[$cont]['valor_reteica']		   = intval($result2[$j]['cuenta_deducible']);		  
					  $cont++;
				  }
			  }
		 } 
	   
	   }

	   	   
	   return $dataExogena;		   
	   
	 }else{
	      exit('No existen Registros en este periodo!!!!');
	 } 
	     
  
  }  
   
}


?>