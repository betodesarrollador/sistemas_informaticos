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
  
    

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_abono_id 	 = $this -> requestDataForQuery('item_abono_id','integer');
      $tercero_id        = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id= $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_abono    	 = $this -> requestDataForQuery('desc_abono','text');	  
      $base_abono    	 = $this -> requestDataForQuery('base_abono','integer');
      $deb_item_abono	 = $_REQUEST['deb_item_abono'];
      $cre_item_abono	 = $_REQUEST['cre_item_abono'];
	
      $update = "UPDATE item_abono  SET 
	  				tercero_id=$tercero_id,
					centro_de_costo_id=$centro_de_costo_id,
					desc_abono=$desc_abono,
					base_abono=$base_abono,
					deb_item_abono = $deb_item_abono,
					cre_item_abono = $cre_item_abono 
					WHERE  item_abono_id = $item_abono_id";

      $this -> query($update,$Conex);
	
	$this -> Commit($Conex);
	
	return $item_abono_id;

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
	  
	  $select = "SELECT * FROM impuesto WHERE empresa_id = (SELECT o.empresa_id FROM abono_factura a, oficina o WHERE 
														a.abono_factura_id = $abono_factura_id AND o.oficina_id=a.oficina_id)AND  puc_id = $puc_id";
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