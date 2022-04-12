<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($abono_factura_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($abono_factura_id)){
	
	  $select  = "SELECT i.*,(SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,
	  (SELECT concat(codigo_puc,' - ',nombre)  FROM puc WHERE puc_id = i.puc_id) AS puc,
	  (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,
	  (SELECT CONCAT_WS(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social,sigla) FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,
	  (SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,
	  (SELECT requiere_tercero FROM puc WHERE puc_id = i.puc_id) AS requiere_tercero,	  
  	  (SELECT requiere_centro_costo FROM puc WHERE puc_id = i.puc_id) AS requiere_centro_costo,	
  	  (SELECT COUNT(*) AS requiere_base_ofi FROM impuesto_oficina io, impuesto im WHERE im.puc_id = i.puc_id AND im.empresa_id=$empresa_id AND io.impuesto_id=im.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id) AS requiere_base_ofi,
  	  (SELECT COUNT(*) AS requiere_base_emp FROM impuesto WHERE puc_id = i.puc_id AND empresa_id=$empresa_id AND estado='A') AS requiere_base_emp,	  
	  (SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo,
	  (SELECT valor FROM factura WHERE factura_id=r.factura_id) AS valor_total,
	  (SELECT SUM(ia.deb_item_abono) FROM item_abono ia, relacion_abono ra, abono_factura ab 
	  WHERE ra.factura_id=r.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_id=ra.relacion_abono_id) AS abonos
	  FROM item_abono  i, relacion_abono r  WHERE i.abono_factura_id = $abono_factura_id AND r.relacion_abono_id=i.relacion_abono_id";

	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
  
  public function Save($Campos,$Conex){

  	$this -> Begin($Conex);
	
      $item_abono_id 	 = $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);
      $abono_factura_id  = $this -> requestDataForQuery('abono_factura_id','integer');
	  $puc_id        	 = $this -> requestDataForQuery('puc_id','integer');
      $tercero_id        = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id= $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_abono    	 = $this -> requestDataForQuery('desc_abono','text');	  
      $deb_item_abono	 = $this -> requestDataForQuery('deb_item_abono','numeric');
      $cre_item_abono	 = $this -> requestDataForQuery('cre_item_abono','numeric');
	  $base_abono    	 = $this -> requestDataForQuery('base_abono','numeric');
	
	//exit($item_abono_id);
	
	$select_rel ="SELECT MAX(relacion_abono_id) as relacion_abono_id FROM relacion_abono WHERE  abono_factura_id=$abono_factura_id";
	$result_rel=$this -> DbFetchAll($select_rel,$Conex);
	
	$relacion_abono_id=$result_rel[0]['relacion_abono_id'];
	
	
	
	$select_centro = "SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id=$centro_de_costo_id";
	$result_centro = $this -> DbFetchAll($select_centro,$Conex);
	
	$codigo_centro_costo = $result_centro[0]['codigo'];	
	
	$select_req_puc ="SELECT p.requiere_centro_costo,p.requiere_tercero FROM puc p WHERE puc_id=$puc_id";
	$result_req_puc = $this -> DbFetchAll($select_req_puc,$Conex);
	
	if($result_req_puc[0][requiere_tercero]==1){
		$select_tercero = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero_id";
		$result_tercero =  $this -> DbFetchAll($select_tercero,$Conex);
	
		$digito_verificacion = $result_tercero[0]['digito_verificacion']>0 ? $result_tercero[0]['digito_verificacion']>0 : 'NULL';
		$numero_identificacion = $result_tercero[0]['numero_identificacion'];	
	}else{
		
		$digito_verificacion = 'NULL';
		$numero_identificacion = 'NULL';	
	}
	
	$tercero_des		 = $result_req_puc[0][requiere_tercero]==1 ? $tercero_id:'NULL';
	$numero_iden_des		 = $result_req_puc[0][requiere_tercero]==1 ? $numero_identificacion:'NULL';
	$digito_iden_des		 = $result_req_puc[0][requiere_tercero]==1 ? $digito_verificacion:'NULL';
	$centro_des			 = $result_req_puc[0][requiere_centro_costo]==1 ? $centro_de_costo_id:'NULL';
	$codigo_centro_costo =  $result_req_puc[0][requiere_centro_costo]==1 ? $codigo_centro_costo:'NULL';
	
	  $insert = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
												relacion_abono_id,
												puc_id,
												tercero_id,
												numero_identificacion,
												digito_verificacion,
												centro_de_costo_id,
												codigo_centro_costo,
												porcentaje_abono,
												formula_abono,
												base_abono,
												desc_abono,
												deb_item_abono,
												cre_item_abono) 
										VALUES (
												$item_abono_id,
												$abono_factura_id,
												$relacion_abono_id,
												$puc_id,
												$tercero_des,
												$numero_iden_des,
												$digito_iden_des,
												$centro_des,
												'$codigo_centro_des',
												NULL,
												NULL,
												$base_abono,
												$desc_abono,
												'$deb_item_abono',
												'$cre_item_abono'
										)"; 
										
	
      $this -> query($insert,$Conex);
	  $this -> Commit($Conex);
	
	  if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{
			return $item_abono_id;
		}

  }
    

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_abono_id 	 = $this -> requestDataForQuery('item_abono_id','integer');
      $tercero_id        = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id= $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_abono    	 = $this -> requestDataForQuery('desc_abono','text');	  
      $base_abono    	 = $this -> requestDataForQuery('base_abono','numeric');
      $deb_item_abono	 = $this -> requestDataForQuery('deb_item_abono','numeric');
      $cre_item_abono	 = $this -> requestDataForQuery('cre_item_abono','numeric');
	
      $update = "UPDATE item_abono  SET 
	  				tercero_id=$tercero_id,
					centro_de_costo_id=$centro_de_costo_id,
					desc_abono=$desc_abono,
					base_abono=$base_abono,
					deb_item_abono = $deb_item_abono,
					cre_item_abono = $cre_item_abono 
					WHERE  item_abono_id = $item_abono_id";
					//echo $update;
	
      $this -> query($update,$Conex);
	
	$this -> Commit($Conex);
	
	if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{
			return $item_abono_id;
		}
	
  }

	 public function Delete($Campos,$Conex){

    $item_abono_id = $_REQUEST['item_abono_id'];
	
    $insert = "DELETE FROM item_abono WHERE item_abono_id = $item_abono_id";
	
    $this -> query($insert,$Conex,true);	

  }
  
  
  public function selectCuentaPuc($puc_id,$abono_factura_id,$Conex){
	  
	 $select   = "SELECT requiere_centro_costo,requiere_tercero FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex);
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE empresa_id = (SELECT o.empresa_id FROM abono_factura a, oficina o WHERE 
																   a.abono_factura_id = $abono_factura_id AND o.oficina_id=a.oficina_id)
	            AND oficina_id = (SELECT oficina_id FROM abono_factura WHERE 
																   abono_factura_id = $abono_factura_id)
				AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
				
      $impuesto = $this -> DbFetchAll($select,$Conex);				
	  
	  if(!count($impuesto) > 0){
		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex);						  
		  
      }
	  
	  $requiere_centro_costo = $requires[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	  $requiere_tercero      = $requires[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	  $require_base          = count($impuesto) > 0                       ? 'true' : 'false';
	  
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,
							 require_base=>$require_base);
	  
	  return $requieresCuenta;	 
      
	  
  }
  
  public function selectImpuesto($puc_id,$base_abono,$abono_factura_id,$Conex){
	  
	 /* $select = "SELECT * FROM impuesto WHERE empresa_id = (SELECT o.empresa_id FROM abono_factura a, oficina o WHERE 
														a.abono_factura_id = $abono_factura_id AND o.oficina_id=a.oficina_id)AND  puc_id = $puc_id";*/
	     $select = "SELECT ip.naturaleza,imp.* FROM  impuesto ip, impuesto_periodo_contable imp WHERE imp.periodo_contable_id = (SELECT periodo_contable_id FROM encabezado_de_registro WHERE encabezado_registro_id = ) AND imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id) and imp.impuesto_id = ip.impuesto_id";
		 
	  //echo $select;
      $impuesto = $this -> DbFetchAll($select,$Conex);				
	  		  
	  $porcentaje    = $impuesto[0]['porcentaje'];
	  $impuesto_id   = $impuesto[0]['impuesto_id'];
	  $naturaleza    = $impuesto[0]['naturaleza'];
	  $formula       = $impuesto[0]['formula'];
		  
      $calculo = str_replace("BASE",$base_abono,$formula);
	  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
		  
	  $select     = "SELECT $calculo AS valor_total";
      $result     = $this -> DbFetchAll($select ,$Conex);
	  $valorTotal = $result[0]['valor_total'];
		  
      return array(valor => $valorTotal, naturaleza =>$naturaleza);	  
		  	
	  
  }

   
}



?>