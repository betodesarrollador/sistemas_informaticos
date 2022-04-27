<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($abono_factura_proveedor_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($abono_factura_proveedor_id)){
	
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
	  (SELECT valor_factura_proveedor FROM factura_proveedor WHERE factura_proveedor_id=r.factura_proveedor_id) AS valor_total,
	  (SELECT SUM(ia.deb_item_abono_factura) FROM item_abono_factura ia, relacion_abono_factura ra, abono_factura_proveedor ab 
	  WHERE ra.factura_proveedor_id=r.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' AND ia.relacion_abono_factura_id=ra.relacion_abono_factura_id) AS abonos
	  FROM item_abono_factura  i, relacion_abono_factura r  WHERE i.abono_factura_proveedor_id = $abono_factura_proveedor_id AND r.relacion_abono_factura_id=i.relacion_abono_factura_id";

	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
  public function Save($Campos,$Conex){
  
	  $item_abono_factura_id 	 = $this -> DbgetMaxConsecutive("item_abono_factura","item_abono_factura_id",$Conex,true,1);	  
	  $relacion_abono_factura_id = $this -> requestDataForQuery('relacion_abono_factura_id','integer');
      $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_abono_factura    	 = $this -> requestDataForQuery('desc_abono_factura','text');	  
      $base_abono_factura    	     = $this -> requestDataForQuery('base_abono_factura','integer');
      $deb_item_abono_factura	     = $this -> requestDataForQuery('deb_item_abono_factura','numeric');
      $cre_item_abono_factura	     = $this -> requestDataForQuery('cre_item_abono_factura','numeric');
      $abono_factura_proveedor_id	 = $this -> requestDataForQuery('abono_factura_proveedor_id','integer');	
	  $puc_id                        = $this -> requestDataForQuery('puc_id','integer');	
	  
	  
	  if(!is_numeric($deb_item_abono_factura)) $deb_item_abono_factura = 0;
	  if(!is_numeric($cre_item_abono_factura)) $cre_item_abono_factura = 0;	  
	  
	  $insert = "INSERT INTO item_abono_factura (item_abono_factura_id,tercero_id,centro_de_costo_id,desc_abono_factura,base_abono_factura,deb_item_abono_factura,cre_item_abono_factura,relacion_abono_factura_id,abono_factura_proveedor_id,puc_id) VALUES ($item_abono_factura_id,$tercero_id,$centro_de_costo_id,$desc_abono_factura,$base_abono_factura,$deb_item_abono_factura,$cre_item_abono_factura,$relacion_abono_factura_id,$abono_factura_proveedor_id,$puc_id)";
	  
      $this -> query($insert,$Conex,true);	  
  
  
  }  

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_abono_factura_id 	 = $this -> requestDataForQuery('item_abono_factura_id','integer');
      $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_abono_factura    	 = $this -> requestDataForQuery('desc_abono_factura','text');	  
      $base_abono_factura    	 = $this -> requestDataForQuery('base_abono_factura','integer');
      $deb_item_abono_factura	 = $this -> requestDataForQuery('deb_item_abono_factura','numeric');
      $cre_item_abono_factura	 = $this -> requestDataForQuery('cre_item_abono_factura','numeric');
	
      $update = "UPDATE item_abono_factura  SET 
	  				tercero_id=$tercero_id,
					centro_de_costo_id=$centro_de_costo_id,
					desc_abono_factura=$desc_abono_factura,
					base_abono_factura=$base_abono_factura,
					deb_item_abono_factura = $deb_item_abono_factura,
					cre_item_abono_factura = $cre_item_abono_factura 
					WHERE  item_abono_factura_id = $item_abono_factura_id";
	
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $item_abono_factura_id;

  }

  
  public function selectCuentaPuc($puc_id,$abono_factura_proveedor_id,$Conex){
	  
	 $select   = "SELECT requiere_centro_costo,requiere_tercero FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex,true);
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE empresa_id = (SELECT o.empresa_id FROM abono_factura_proveedor a, oficina o WHERE 
																   a.abono_factura_proveedor_id = $abono_factura_proveedor_id AND o.oficina_id=a.oficina_id)
	            AND oficina_id = (SELECT oficina_id FROM abono_factura_proveedor WHERE 
																   abono_factura_proveedor_id = $abono_factura_proveedor_id)
				AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
				
      $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  
	  if(!count($impuesto) > 0){
		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex,true);						  
		  
      }
	  
	  $requiere_centro_costo = $requires[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	  $requiere_tercero      = $requires[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	  $require_base          = count($impuesto) > 0                       ? 'true' : 'false';
	  
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,
							 require_base=>$require_base);
	  
	  return $requieresCuenta;	 
      
	  
  }
  
  public function selectImpuesto($puc_id,$base_abono_factura,$abono_factura_proveedor_id,$Conex){
	  
	  $select = "SELECT * FROM impuesto WHERE empresa_id = (SELECT o.empresa_id FROM abono_factura_proveedor a, oficina o WHERE 
														a.abono_factura_proveedor_id = $abono_factura_proveedor_id AND o.oficina_id=a.oficina_id)AND  puc_id = $puc_id";
      $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  		  
	  $porcentaje    = $impuesto[0]['porcentaje'];
	  $impuesto_id   = $impuesto[0]['impuesto_id'];
	  $naturaleza    = $impuesto[0]['naturaleza'];
	  $formula       = $impuesto[0]['formula'];
		  
      $calculo = str_replace("BASE",$base_abono_factura,$formula);
	  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
		  
	  $select     = "SELECT $calculo AS valor_total";
      $result     = $this -> DbFetchAll($select,$Conex,true);
	  $valorTotal = $result[0]['valor_total'];
		  
      return array(valor => $valorTotal, naturaleza =>$naturaleza);	  
		  	
	  
  }

   
}



?>