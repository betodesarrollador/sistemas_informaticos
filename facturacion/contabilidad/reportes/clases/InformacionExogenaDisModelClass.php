<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class InformacionExogenaDisModel extends Db{
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
  
     $select = "SELECT formato_exogena_id AS value,CONCAT('Resolucion: ',resolucion,' - Formato: ',tipo_formato,' A&ntilde;o Gravable: ',ano_gravable) AS text FROM formato_exogena WHERE tipo='D'";
	 
     $result = $this -> DbFetchAll($select,$Conex);
	  
	 return $result;	  	 
  
  }    
  
  public function getPeriodo($Conex){
  
     $select = "SELECT periodo_contable_id AS value, anio AS text  FROM periodo_contable  WHERE estado=1 ORDER BY anio ASC ";
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
	   $caracteres = array(",", "&", "/", "*", "#", "-", "_",";","?","�","�","!","|","%","(",")","$",".");
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
		  
		  $select = "SELECT 
		  (SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_documento,
		  t.numero_identificacion,
		  t.digito_verificacion,
		  t.primer_apellido,
		  t.segundo_apellido,
		  t.primer_nombre,
		  t.segundo_nombre,
		  t.razon_social,
		  t.direccion,
		  t.telefono,
		  t.email,
		 (SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
		 (SELECT divipola FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
		 (SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,
		  IF('$naturaleza_puc'='D',SUM(i.debito),SUM(i.credito)) AS cuenta_deducible,
		  SUM(i.base) AS base,
		  SUM(i.debito) AS sum_debitos,
		  SUM(i.credito) AS sum_creditos,
	  
		  (SELECT ipc.porcentaje FROM impuesto im, impuesto_periodo_contable ipc, periodo_contable pc 
		   WHERE im.puc_id=i.puc_id AND ipc.impuesto_id=im.impuesto_id AND pc.periodo_contable_id=ipc.periodo_contable_id  AND pc.anio='$anio' LIMIT 1) AS tarifas_retencion,		  
		  
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
		  
          $result2 = $this -> DbFetchAll($select,$Conex);		  
		  
		  
		  for($j = 0; $j < count($result2); $j++){
		  	  if($tipo_formato=='2'){	 
			  	  if(intval($result2[$j]['cuenta_deducible'])>0 || intval($result2[$j]['cuenta_deducible'])<0){
					  $dataExogena[$cont]['vigencia']             	= substr($anio,0,4); //ok	  			  
					  $dataExogena[$cont]['tipo_documento']         = substr($result2[$j]['tipo_documento'],0,3); //ok		  
					  $dataExogena[$cont]['numero_identificacion']  = substr($result2[$j]['numero_identificacion'],0,11); //ok		  
					  $dataExogena[$cont]['nombre']					= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_nombre'])),0,70); //ok		  
					  $dataExogena[$cont]['otro_nombre']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_nombre'])),0,70); //ok		  					  
					  $dataExogena[$cont]['primer_apellido']		= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_apellido'])),0,70); //ok		  					  
					  $dataExogena[$cont]['otro_apellido']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_apellido'])),0,70); //ok		  					  

					  $dataExogena[$cont]['razon_social']			= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['razon_social']))),0,70); //ok		  
					  $dataExogena[$cont]['direccion']			   	= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['direccion']))),0,70);//ok		  
					  $dataExogena[$cont]['telefono']  				= substr($result2[$j]['telefono'],0,10); //ok	
					  $dataExogena[$cont]['email']  				= substr($result2[$j]['email'],0,70); //ok	
					  $dataExogena[$cont]['cod_mcp']			   	= substr($result2[$j]['cod_muni'],0,5);	//ok	  
					  $dataExogena[$cont]['cod_dpto']			   	= substr($result2[$j]['cod_depto'],0,2);	//ok	  
					  $dataExogena[$cont]['concepto_pago']		   	= substr($cod_concepto,0,1);	//ok	  
					  $dataExogena[$cont]['valor_compras']		   	= substr(intval($result2[$j]['cuenta_deducible']),0,20); //ok	
				   	  $dataExogena[$cont]['valor_devoluciones']		= substr(intval($result2[$j]['devol']),0,20); //ojo
					  $cont++;
				  }
			  }elseif($tipo_formato=='3'){
				  if(intval($result2[$j]['cuenta_deducible'])>0 || intval($result2[$j]['cuenta_deducible'])<0){
					  $dataExogena[$cont]['vigencia']             	= substr($anio,0,4); //ok	  			  
					  $dataExogena[$cont]['tipo_documento']         = substr($result2[$j]['tipo_documento'],0,3); //ok		  
					  $dataExogena[$cont]['numero_identificacion']  = substr($result2[$j]['numero_identificacion'],0,11); //ok		  
					  $dataExogena[$cont]['nombre']					= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_nombre'])),0,70); //ok		  
					  $dataExogena[$cont]['otro_nombre']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_nombre'])),0,70); //ok		  					  
					  $dataExogena[$cont]['primer_apellido']		= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_apellido'])),0,70); //ok		  					  
					  $dataExogena[$cont]['otro_apellido']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_apellido'])),0,70); //ok		  					  

					  $dataExogena[$cont]['razon_social']			= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['razon_social']))),0,70); //ok		  
					  $dataExogena[$cont]['direccion']			   	= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['direccion']))),0,70);//ok		  
					  $dataExogena[$cont]['telefono']  				= substr($result2[$j]['telefono'],0,10); //ok	
					  $dataExogena[$cont]['email']  				= substr($result2[$j]['email'],0,70); //ok	
					  $dataExogena[$cont]['cod_mcp']			   	= substr($result2[$j]['cod_muni'],0,5);	//ok	  
					  $dataExogena[$cont]['cod_dpto']			   	= substr($result2[$j]['cod_depto'],0,2);	//ok	  
					  $dataExogena[$cont]['concepto_pago']		   	= substr($cod_concepto,0,1);	//ok	  
					  $dataExogena[$cont]['monto_pago']		   		= substr(intval($result2[$j]['cuenta_deducible']),0,20); //ok	
				   	  $dataExogena[$cont]['valor_devoluciones']		= substr(intval($result2[$j]['devol']),0,20); //ojo
					  $cont++;
				  }
			  }elseif($tipo_formato=='4'){
 				  if(intval($result2[$j]['cuenta_deducible'])>0 || intval($result2[$j]['cuenta_deducible'])<0){
					  $dataExogena[$cont]['vigencia']             	= substr($anio,0,4); //ok	  			  
					  $dataExogena[$cont]['tipo_documento']         = substr($result2[$j]['tipo_documento'],0,3); //ok		  
					  $dataExogena[$cont]['numero_identificacion']  = substr($result2[$j]['numero_identificacion'],0,11); //ok		  
					  $dataExogena[$cont]['nombre']					= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_nombre'])),0,70); //ok		  
					  $dataExogena[$cont]['otro_nombre']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_nombre'])),0,70); //ok		  					  
					  $dataExogena[$cont]['primer_apellido']		= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_apellido'])),0,70); //ok		  					  
					  $dataExogena[$cont]['otro_apellido']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_apellido'])),0,70); //ok		  					  

					  $dataExogena[$cont]['razon_social']			= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['razon_social']))),0,70); //ok		  
					  $dataExogena[$cont]['direccion']			   	= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['direccion']))),0,70);//ok		  
					  $dataExogena[$cont]['telefono']  				= substr($result2[$j]['telefono'],0,10); //ok	
					  $dataExogena[$cont]['email']  				= substr($result2[$j]['email'],0,70); //ok	
					  $dataExogena[$cont]['cod_mcp']			   	= substr($result2[$j]['cod_muni'],0,5);	//ok	  
					  $dataExogena[$cont]['cod_dpto']			   	= substr($result2[$j]['cod_depto'],0,2);	//ok	  
					  $dataExogena[$cont]['base_retencion']		   	= substr(intval($result2[$j]['base']),0,20);	//ok	  
					  $dataExogena[$cont]['tarifas_retencion']		= substr($result2[$j]['tarifas_retencion'],0,20); //ojo
				   	  $dataExogena[$cont]['retencion_anual']		= substr(intval($result2[$j]['cuenta_deducible']),0,20); //ok	
					  $cont++;
				  }
			  }elseif($tipo_formato=='6'){
  				  if(intval($result2[$j]['cuenta_deducible'])>0 || intval($result2[$j]['cuenta_deducible'])<0){
					  $dataExogena[$cont]['vigencia']             	= substr($anio,0,4); //ok	  			  
					  $dataExogena[$cont]['tipo_documento']         = substr($result2[$j]['tipo_documento'],0,3); //ok		  
					  $dataExogena[$cont]['numero_identificacion']  = substr($result2[$j]['numero_identificacion'],0,11); //ok		  
					  $dataExogena[$cont]['nombre']					= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_nombre'])),0,70); //ok		  
					  $dataExogena[$cont]['otro_nombre']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_nombre'])),0,70); //ok		  					  
					  $dataExogena[$cont]['primer_apellido']		= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_apellido'])),0,70); //ok		  					  
					  $dataExogena[$cont]['otro_apellido']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_apellido'])),0,70); //ok		  					  

					  $dataExogena[$cont]['razon_social']			= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['razon_social']))),0,70); //ok		  
					  $dataExogena[$cont]['direccion']			   	= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['direccion']))),0,70);//ok		  
					  $dataExogena[$cont]['telefono']  				= substr($result2[$j]['telefono'],0,10); //ok	
					  $dataExogena[$cont]['email']  				= substr($result2[$j]['email'],0,70); //ok	
					  $dataExogena[$cont]['cod_mcp']			   	= substr($result2[$j]['cod_muni'],0,5);	//ok	  
					  $dataExogena[$cont]['cod_dpto']			   	= substr($result2[$j]['cod_depto'],0,2);	//ok	  
					  $dataExogena[$cont]['monto_pago']		   		= substr(intval($result2[$j]['base']),0,20);	//ojo	  
					  $dataExogena[$cont]['tarifas_retencion']		= substr($result2[$j]['tarifas_retencion'],0,20); //ojo
				   	  $dataExogena[$cont]['retencion_anual']		= substr(intval($result2[$j]['cuenta_deducible']),0,20); //ok	
					  
					  $cont++;
				  }
			  }elseif($tipo_formato=='10'){
  				  if(intval($result2[$j]['cuenta_deducible'])>0 || intval($result2[$j]['cuenta_deducible'])<0){
					  $dataExogena[$cont]['vigencia']             	= substr($anio,0,4); //ok	  			  
					  $dataExogena[$cont]['tipo_documento']         = substr($result2[$j]['tipo_documento'],0,3); //ok		  
					  $dataExogena[$cont]['numero_identificacion']  = substr($result2[$j]['numero_identificacion'],0,11); //ok		  
					  $dataExogena[$cont]['nombre']					= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_nombre'])),0,70); //ok		  
					  $dataExogena[$cont]['otro_nombre']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_nombre'])),0,70); //ok		  					  
					  $dataExogena[$cont]['primer_apellido']		= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['primer_apellido'])),0,70); //ok		  					  
					  $dataExogena[$cont]['otro_apellido']			= substr(str_replace($caracteres," ",str_replace("�","N",$result2[$j]['segundo_apellido'])),0,70); //ok		  					  

					  $dataExogena[$cont]['razon_social']			= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['razon_social']))),0,70); //ok		  
					  $dataExogena[$cont]['direccion']			   	= substr(str_replace($caracteres," ",str_replace("�","N",utf8_decode($result2[$j]['direccion']))),0,70);//ok		  
					  $dataExogena[$cont]['telefono']  				= substr($result2[$j]['telefono'],0,10); //ok	
					  $dataExogena[$cont]['email']  				= substr($result2[$j]['email'],0,70); //ok	
					  $dataExogena[$cont]['cod_mcp']			   	= substr($result2[$j]['cod_muni'],0,5);	//ok	  
					  $dataExogena[$cont]['cod_dpto']			   	= substr($result2[$j]['cod_depto'],0,2);	//ok	  
					  $dataExogena[$cont]['pais_domicilio']			= substr($result2[$j]['pais_domicilio'],0,20);	//ok	
					   $dataExogena[$cont]['concepto_ingreso']		= substr($cod_concepto,0,1);	//ok	  
					  $dataExogena[$cont]['valor_ingreso']			= substr(intval($result2[$j]['cuenta_deducible']),0,20); //ok	
					  $cont++;
				  }
			  }
		 } 
	   
	   }
	   if($tipo_formato=='1001'){
		   $dataExogena1=array();
		   $dataExogena = $this -> sortResultByField($dataExogena,'numero_identificacion',SORT_ASC);
		   $dataExogena = $this -> sortResultByField($dataExogena,'cod_concepto',SORT_ASC);
		   
		   $identificacion='';
		   $concepto='';
		   $tipo_documento='';
		   $digito_verificacion='';
		   $primer_apellido='';		  
		   $segundo_apellido='';		  
		   $primer_nombre='';		  
		   $segundo_nombre='';		  
		   $razon_social='';		  
		   $direccion='';		  
		   $cod_depto='';		  
		   $cod_muni='';		  
		   $pais_domicilio='';		  
		   
			$cuenta_deducible = 0;		  
			$cuenta_no_deducible= 0;
			$cuenta_iva_descontable=0;
			$cuenta_iva_no_descontable=0;
			$cuenta_rtfe_renta=0;
			$cuenta_rtfe_asumida=0;
			$cuenta_iva_comun=0;
			$cuenta_iva_simple=0;
			$cuenta_iva_no_domiciliado=0;
			$cuenta_timbre=0;		  
			$cuenta_practi_cree=0;
			$cuenta_asumidas_cree=0;
			$cuenta_deducible_menor = 0;		  
			$cuenta_no_deducible_menor= 0;
			$cuenta_iva_descontable_menor=0;
			$cuenta_iva_no_descontable_menor=0;
			$cuenta_rtfe_renta_menor=0;
			$cuenta_rtfe_asumida_menor=0;
			$cuenta_iva_comun_menor=0;
			$cuenta_iva_simple_menor=0;
			$cuenta_iva_no_domiciliado_menor=0;
			$cuenta_timbre_menor=0;		  
			$cuenta_practi_cree_menor=0;
			$cuenta_asumidas_cree_menor=0;
			$cont1=0;
		   for($j=0;$j< count($dataExogena); $j++){
			   if($identificacion=='' && $concepto==''){
					$identificacion =  $dataExogena[$j]['numero_identificacion'];
					$concepto =  $dataExogena[$j]['cod_concepto'];	
					$tipo_documento=$dataExogena[$j]['tipo_documento'];	
					$digito_verificacion=$dataExogena[$j]['digito_verificacion'];	
					$primer_apellido=$dataExogena[$j]['primer_apellido'];	
					$segundo_apellido=$dataExogena[$j]['segundo_apellido'];	
					$primer_nombre=$dataExogena[$j]['primer_nombre'];	
					$segundo_nombre=$dataExogena[$j]['otros_nombres'];	
					$razon_social=$dataExogena[$j]['razon_social'];	
					$direccion=$dataExogena[$j]['direccion'];	
					$cod_depto=$dataExogena[$j]['cod_dpto'];	
					$cod_muni=$dataExogena[$j]['cod_mcp'];	
					$pais_domicilio=$dataExogena[$j]['pais_domicilio'];	
				   
			   }
			   
			   if($identificacion!=$dataExogena[$j]['numero_identificacion'] || $concepto!=$dataExogena[$j]['cod_concepto'] ){
					  if($cuenta_deducible>=$cuantia_minima){
						  $dataExogena1[$cont1]['cod_concepto']             = $concepto;		  			  
						  $dataExogena1[$cont1]['tipo_documento']           = $tipo_documento;		  
						  $dataExogena1[$cont1]['numero_identificacion']    = $identificacion;		  
						  $dataExogena1[$cont1]['dv']         			   = $digito_verificacion;		  
						  $dataExogena1[$cont1]['primer_apellido']		   = $primer_apellido;		  
						  $dataExogena1[$cont1]['segundo_apellido']		   = $segundo_apellido;		  
						  $dataExogena1[$cont1]['primer_nombre']			   = $primer_nombre;		  
						  $dataExogena1[$cont1]['otros_nombres']			   = $segundo_nombre;		  
						  $dataExogena1[$cont1]['razon_social']			   = $razon_social;		  
						  $dataExogena1[$cont1]['direccion']			   	   = $direccion;		  
						  $dataExogena1[$cont1]['cod_dpto']			   	   = $cod_depto;		  
						  $dataExogena1[$cont1]['cod_mcp']			   	   = $cod_muni;		  
						  $dataExogena1[$cont1]['pais_domicilio']		   = $pais_domicilio;		  
						  $dataExogena1[$cont1]['cuenta_deducible']		   = $cuenta_deducible;		  
						  $dataExogena1[$cont1]['cuenta_no_deducible']	   = $cuenta_no_deducible;		  
						  $dataExogena1[$cont1]['cuenta_iva_descontable']   = $cuenta_iva_descontable;		  
						  $dataExogena1[$cont1]['cuenta_iva_no_descontable']= $cuenta_iva_no_descontable;		  
						  $dataExogena1[$cont1]['cuenta_rtfe_renta']= $cuenta_rtfe_renta;		  
						  $dataExogena1[$cont1]['cuenta_rtfe_asumida']= $cuenta_rtfe_asumida;		  
						  $dataExogena1[$cont1]['cuenta_iva_comun']= $cuenta_iva_comun;		  
						  $dataExogena1[$cont1]['cuenta_iva_simple']= $cuenta_iva_simple;		  
						  $dataExogena1[$cont1]['cuenta_iva_no_domiciliado']= $cuenta_iva_no_domiciliado;		  
						  $dataExogena1[$cont1]['cuenta_timbre']= $cuenta_timbre;		  
						  $dataExogena1[$cont1]['cuenta_practi_cree']= $cuenta_practi_cree;		  
						  $dataExogena1[$cont1]['cuenta_asumidas_cree']= $cuenta_asumidas_cree;	
						  $cont1++;
					  }else{
						  $dataExogena1[$cont1]['cod_concepto']             = $concepto;		  			  
						  $dataExogena1[$cont1]['tipo_documento']           = 43;		  
						  $dataExogena1[$cont1]['numero_identificacion']    = $cuantias_menores;		  
						  $dataExogena1[$cont1]['dv']         			   = '';		  
						  $dataExogena1[$cont1]['primer_apellido']		   = '';		  
						  $dataExogena1[$cont1]['segundo_apellido']		   = '';		  
						  $dataExogena1[$cont1]['primer_nombre']		   = '';		  
						  $dataExogena1[$cont1]['otros_nombres']		   = '';		  
						  $dataExogena1[$cont1]['razon_social']			   = $nombre_tercero;		  
						  $dataExogena1[$cont1]['direccion']			   = '';		  
						  $dataExogena1[$cont1]['cod_dpto']			   	   = '';		  
						  $dataExogena1[$cont1]['cod_mcp']			   	   = '';		  
						  $dataExogena1[$cont1]['pais_domicilio']		   = '169';		  
						  $dataExogena1[$cont1]['cuenta_deducible']		   = $cuenta_deducible;		  
						  $dataExogena1[$cont1]['cuenta_no_deducible']	   = $cuenta_no_deducible;		  
						  $dataExogena1[$cont1]['cuenta_iva_descontable']   = $cuenta_iva_descontable;		  
						  $dataExogena1[$cont1]['cuenta_iva_no_descontable']= $cuenta_iva_no_descontable;		  
						  $dataExogena1[$cont1]['cuenta_rtfe_renta']= $cuenta_rtfe_renta;		  
						  $dataExogena1[$cont1]['cuenta_rtfe_asumida']= $cuenta_rtfe_asumida;		  
						  $dataExogena1[$cont1]['cuenta_iva_comun']= $cuenta_iva_comun;		  
						  $dataExogena1[$cont1]['cuenta_iva_simple']= $cuenta_iva_simple;		  
						  $dataExogena1[$cont1]['cuenta_iva_no_domiciliado']= $cuenta_iva_no_domiciliado;		  
						  $dataExogena1[$cont1]['cuenta_timbre']= $cuenta_timbre;		  
						  $dataExogena1[$cont1]['cuenta_practi_cree']= $cuenta_practi_cree;		  
						  $dataExogena1[$cont1]['cuenta_asumidas_cree']= $cuenta_asumidas_cree;	
						  $cont1++;
						  
					  }
						$identificacion =  $dataExogena[$j]['numero_identificacion'];
						$concepto =  $dataExogena[$j]['cod_concepto'];	
						$tipo_documento=$dataExogena[$j]['tipo_documento'];	
						$digito_verificacion=$dataExogena[$j]['dv'];	
						$primer_apellido=$dataExogena[$j]['primer_apellido'];	
						$segundo_apellido=$dataExogena[$j]['segundo_apellido'];	
						$primer_nombre=$dataExogena[$j]['primer_nombre'];	
						$segundo_nombre=$dataExogena[$j]['otros_nombres'];	
						$razon_social=$dataExogena[$j]['razon_social'];	
						$direccion=$dataExogena[$j]['direccion'];	
						$cod_depto=$dataExogena[$j]['cod_dpto'];	
						$cod_muni=$dataExogena[$j]['cod_mcp'];	
						$pais_domicilio=$dataExogena[$j]['pais_domicilio'];	
						
						$cuenta_deducible = 0;		  
						$cuenta_no_deducible= 0;
						$cuenta_iva_descontable=0;
						$cuenta_iva_no_descontable=0;
						$cuenta_rtfe_renta=0;
						$cuenta_rtfe_asumida=0;
						$cuenta_iva_comun=0;
						$cuenta_iva_simple=0;
						$cuenta_iva_no_domiciliado=0;
						$cuenta_timbre=0;		  
						$cuenta_practi_cree=0;
						$cuenta_asumidas_cree=0;

						$cuenta_deducible = $cuenta_deducible+$dataExogena[$j]['cuenta_deducible'];		  
						$cuenta_no_deducible= $cuenta_no_deducible+$dataExogena[$j]['cuenta_no_deducible'];
						$cuenta_iva_descontable= $cuenta_iva_descontable+$dataExogena[$j]['cuenta_iva_descontable'];
						$cuenta_iva_no_descontable= $cuenta_iva_no_descontable+$dataExogena[$j]['cuenta_iva_no_descontable'];
						$cuenta_rtfe_renta= $cuenta_rtfe_renta+$dataExogena[$j]['cuenta_rtfe_renta'];
						$cuenta_rtfe_asumida= $cuenta_rtfe_asumida+$dataExogena[$j]['cuenta_rtfe_asumida'];
						$cuenta_iva_comun= $cuenta_iva_comun+$dataExogena[$j]['cuenta_iva_comun'];
						$cuenta_iva_simple= $cuenta_iva_simple+$dataExogena[$j]['cuenta_iva_simple'];
						$cuenta_iva_no_domiciliado= $cuenta_iva_no_domiciliado+$dataExogena[$j]['cuenta_iva_no_domiciliado'];
						$cuenta_timbre= $cuenta_timbre+$dataExogena[$j]['cuenta_timbre'];	  
						$cuenta_practi_cree= $cuenta_practi_cree+$dataExogena[$j]['cuenta_practi_cree'];	  
						$cuenta_asumidas_cree= $cuenta_asumidas_cree+$dataExogena[$j]['cuenta_asumidas_cree'];	  
			   }else{
					$cuenta_deducible = $cuenta_deducible+$dataExogena[$j]['cuenta_deducible'];		  
					$cuenta_no_deducible= $cuenta_no_deducible+$dataExogena[$j]['cuenta_no_deducible'];
					$cuenta_iva_descontable= $cuenta_iva_descontable+$dataExogena[$j]['cuenta_iva_descontable'];
					$cuenta_iva_no_descontable= $cuenta_iva_no_descontable+$dataExogena[$j]['cuenta_iva_no_descontable'];
					$cuenta_rtfe_renta= $cuenta_rtfe_renta+$dataExogena[$j]['cuenta_rtfe_renta'];
					$cuenta_rtfe_asumida= $cuenta_rtfe_asumida+$dataExogena[$j]['cuenta_rtfe_asumida'];
					$cuenta_iva_comun= $cuenta_iva_comun+$dataExogena[$j]['cuenta_iva_comun'];
					$cuenta_iva_simple= $cuenta_iva_simple+$dataExogena[$j]['cuenta_iva_simple'];
					$cuenta_iva_no_domiciliado= $cuenta_iva_no_domiciliado+$dataExogena[$j]['cuenta_iva_no_domiciliado'];
					$cuenta_timbre= $cuenta_timbre+$dataExogena[$j]['cuenta_timbre'];	  
					$cuenta_practi_cree= $cuenta_practi_cree+$dataExogena[$j]['cuenta_practi_cree'];	  
					$cuenta_asumidas_cree= $cuenta_asumidas_cree+$dataExogena[$j]['cuenta_asumidas_cree'];	  
				   
			   }
			   
		   }
		  //cuantias menores
		  $dataExogena2 = array();
		  $dataExogena1 = $this -> sortResultByField($dataExogena1,'numero_identificacion',SORT_ASC);
		  $dataExogena1 = $this -> sortResultByField($dataExogena1,'cod_concepto',SORT_ASC);
		   $identificacion1='';
		   $concepto1='';
		   $tipo_documento1='';
		   $digito_verificacion1='';
		   $primer_apellido1='';		  
		   $segundo_apellido1='';		  
		   $primer_nombre1='';		  
		   $segundo_nombre1='';		  
		   $razon_social1='';		  
		   $direccion1='';		  
		   $cod_depto1='';		  
		   $cod_muni1='';		  
		   $pais_domicilio1='';		  
		   
			$cuenta_deducible1 = 0;		  
			$cuenta_no_deducible1= 0;
			$cuenta_iva_descontable1=0;
			$cuenta_iva_no_descontable1=0;
			$cuenta_rtfe_renta1=0;
			$cuenta_rtfe_asumida1=0;
			$cuenta_iva_comun1=0;
			$cuenta_iva_simple1=0;
			$cuenta_iva_no_domiciliado1=0;
			$cuenta_timbre1=0;		  
			$cuenta_practi_cree1=0;
			$cuenta_asumidas_cree1=0;
			$cont2=0;
		   for($j=0;$j< count($dataExogena1); $j++){
			   if($identificacion1=='' && $concepto1==''){
					$identificacion1 =  $dataExogena1[$j]['numero_identificacion'];
					$concepto1 =  $dataExogena1[$j]['cod_concepto'];	
					$tipo_documento1=$dataExogena1[$j]['tipo_documento'];	
					$digito_verificacion1=$dataExogena1[$j]['dv'];	
					$primer_apellido1=$dataExogena1[$j]['primer_apellido'];	
					$segundo_apellido1=$dataExogena1[$j]['segundo_apellido'];	
					$primer_nombre1=$dataExogena1[$j]['primer_nombre'];	
					$segundo_nombre1=$dataExogena1[$j]['otros_nombres'];	
					$razon_social1=$dataExogena1[$j]['razon_social'];	
					$direccion1=$dataExogena1[$j]['direccion'];	
					$cod_depto1=$dataExogena1[$j]['cod_dpto'];	
					$cod_muni1=$dataExogena1[$j]['cod_mcp'];	
					$pais_domicilio1=$dataExogena1[$j]['pais_domicilio'];	
				   
			   }
			   
			   if($identificacion1!=$dataExogena1[$j]['numero_identificacion'] || $concepto1!=$dataExogena1[$j]['cod_concepto'] ){
						  $dataExogena2[$cont2]['cod_concepto']             = $concepto1;		  			  
						  $dataExogena2[$cont2]['tipo_documento']           = $tipo_documento1;		  
						  $dataExogena2[$cont2]['numero_identificacion']    = $identificacion1;		  
						  $dataExogena2[$cont2]['dv']         			   = $digito_verificacion1;		  
						  $dataExogena2[$cont2]['primer_apellido']		   = $primer_apellido1;		  
						  $dataExogena2[$cont2]['segundo_apellido']		   = $segundo_apellido1;		  
						  $dataExogena2[$cont2]['primer_nombre']			   = $primer_nombre1;		  
						  $dataExogena2[$cont2]['otros_nombres']			   = $segundo_nombre1;		  
						  $dataExogena2[$cont2]['razon_social']			   = $razon_social1;		  
						  $dataExogena2[$cont2]['direccion']			   	   = $direccion1;		  
						  $dataExogena2[$cont2]['cod_dpto']			   	   = $cod_depto1;		  
						  $dataExogena2[$cont2]['cod_mcp']			   	   = $cod_muni1;		  
						  $dataExogena2[$cont2]['pais_domicilio']		   = $pais_domicilio1;		  
						  $dataExogena2[$cont2]['cuenta_deducible']		   = $cuenta_deducible1;		  
						  $dataExogena2[$cont2]['cuenta_no_deducible']	   = $cuenta_no_deducible1;		  
						  $dataExogena2[$cont2]['cuenta_iva_descontable']   = $cuenta_iva_descontable1;		  
						  $dataExogena2[$cont2]['cuenta_iva_no_descontable']= $cuenta_iva_no_descontable1;		  
						  $dataExogena2[$cont2]['cuenta_rtfe_renta']= $cuenta_rtfe_renta1;		  
						  $dataExogena2[$cont2]['cuenta_rtfe_asumida']= $cuenta_rtfe_asumida1;		  
						  $dataExogena2[$cont2]['cuenta_iva_comun']= $cuenta_iva_comun1;		  
						  $dataExogena2[$cont2]['cuenta_iva_simple']= $cuenta_iva_simple1;		  
						  $dataExogena2[$cont2]['cuenta_iva_no_domiciliado']= $cuenta_iva_no_domiciliado1;		  
						  $dataExogena2[$cont2]['cuenta_timbre']= $cuenta_timbre1;		  
						  $dataExogena2[$cont2]['cuenta_practi_cree']= $cuenta_practi_cree1;		  
						  $dataExogena2[$cont1]['cuenta_asumidas_cree']= $cuenta_asumidas_cree1;	
						  $cont2++;
						$identificacion1 =  $dataExogena1[$j]['numero_identificacion'];
						$concepto1 =  $dataExogena1[$j]['cod_concepto'];	
						$tipo_documento1=$dataExogena1[$j]['tipo_documento'];	
						$digito_verificacion1=$dataExogena1[$j]['dv'];	
						$primer_apellido1=$dataExogena1[$j]['primer_apellido'];	
						$segundo_apellido1=$dataExogena1[$j]['segundo_apellido'];	
						$primer_nombre1=$dataExogena1[$j]['primer_nombre'];	
						$segundo_nombre1=$dataExogena1[$j]['otros_nombres'];	
						$razon_social1=$dataExogena1[$j]['razon_social'];	
						$direccion1=$dataExogena1[$j]['direccion'];	
						$cod_depto1=$dataExogena1[$j]['cod_dpto'];	
						$cod_muni1=$dataExogena1[$j]['cod_mcp'];	
						$pais_domicilio1=$dataExogena1[$j]['pais_domicilio'];	
						
						$cuenta_deducible1 = 0;		  
						$cuenta_no_deducible1= 0;
						$cuenta_iva_descontable1=0;
						$cuenta_iva_no_descontable1=0;
						$cuenta_rtfe_renta1=0;
						$cuenta_rtfe_asumida1=0;
						$cuenta_iva_comun1=0;
						$cuenta_iva_simple1=0;
						$cuenta_iva_no_domiciliado1=0;
						$cuenta_timbre1=0;		  
						$cuenta_practi_cree1=0;
						$cuenta_asumidas_cree1=0;

						$cuenta_deducible1 = $cuenta_deducible1+$dataExogena1[$j]['cuenta_deducible'];		  
						$cuenta_no_deducible1= $cuenta_no_deducible1+$dataExogena1[$j]['cuenta_no_deducible'];
						$cuenta_iva_descontable1= $cuenta_iva_descontable1+$dataExogena1[$j]['cuenta_iva_descontable'];
						$cuenta_iva_no_descontable1= $cuenta_iva_no_descontable1+$dataExogena1[$j]['cuenta_iva_no_descontable'];
						$cuenta_rtfe_renta1= $cuenta_rtfe_renta1+$dataExogena1[$j]['cuenta_rtfe_renta'];
						$cuenta_rtfe_asumida1= $cuenta_rtfe_asumida1+$dataExogena1[$j]['cuenta_rtfe_asumida'];
						$cuenta_iva_comun1= $cuenta_iva_comun1+$dataExogena1[$j]['cuenta_iva_comun'];
						$cuenta_iva_simple1= $cuenta_iva_simple1+$dataExogena1[$j]['cuenta_iva_simple'];
						$cuenta_iva_no_domiciliado1= $cuenta_iva_no_domiciliado1+$dataExogena1[$j]['cuenta_iva_no_domiciliado'];
						$cuenta_timbre1= $cuenta_timbre1+$dataExogena1[$j]['cuenta_timbre'];	  
						$cuenta_practi_cree1= $cuenta_practi_cree1+$dataExogena1[$j]['cuenta_practi_cree'];	  
						$cuenta_asumidas_cree1= $cuenta_asumidas_cree1+$dataExogena1[$j]['cuenta_asumidas_cree'];	  
			   }else{
					$cuenta_deducible1 = $cuenta_deducible1+$dataExogena1[$j]['cuenta_deducible'];		  
					$cuenta_no_deducible1= $cuenta_no_deducible1+$dataExogena1[$j]['cuenta_no_deducible'];
					$cuenta_iva_descontable1= $cuenta_iva_descontable1+$dataExogena1[$j]['cuenta_iva_descontable'];
					$cuenta_iva_no_descontable1= $cuenta_iva_no_descontable1+$dataExogena1[$j]['cuenta_iva_no_descontable'];
					$cuenta_rtfe_renta1= $cuenta_rtfe_renta1+$dataExogena1[$j]['cuenta_rtfe_renta'];
					$cuenta_rtfe_asumida1= $cuenta_rtfe_asumida1+$dataExogena1[$j]['cuenta_rtfe_asumida'];
					$cuenta_iva_comun1= $cuenta_iva_comun1+$dataExogena1[$j]['cuenta_iva_comun'];
					$cuenta_iva_simple1= $cuenta_iva_simple1+$dataExogena1[$j]['cuenta_iva_simple'];
					$cuenta_iva_no_domiciliado1= $cuenta_iva_no_domiciliado1+$dataExogena1[$j]['cuenta_iva_no_domiciliado'];
					$cuenta_timbre1= $cuenta_timbre1+$dataExogena1[$j]['cuenta_timbre'];	  
					$cuenta_practi_cree1= $cuenta_practi_cree1+$dataExogena1[$j]['cuenta_practi_cree'];	  
					$cuenta_asumidas_cree1= $cuenta_asumidas_cree1+$dataExogena1[$j]['cuenta_asumidas_cree'];	  
				   
			   }
			   
		   }
		 //cuantias menores fin
		 
		  $dataExogena= $dataExogena2;
	   }
	   	   
	   return $dataExogena;		   
	   
	 }else{
	      exit('No existen Registros en este periodo!!!!');
	 } 
	     
  
  }  
   
}

?>