<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InicialFacturacionModel extends Db{

  private $Permisos;  

  public function GetValorFacturado($Conex){
	   	   
      $select    = "SELECT SUM(d.valor_liquida)AS facturado FROM detalle_factura_puc d, factura f WHERE d.factura_id=f.factura_id AND d.contra_factura=1 AND f.estado='C' AND YEAR (f.fecha) = YEAR (NOW()) AND MONTH (f.fecha) = MONTH (NOW())";
	  $result    = $this -> DbFetchAll($select,$Conex,true);
     
	  $factura = $result[0]['facturado'];
	  $facturado = number_format($factura, 0, ',', '.');
	  if($facturado>0){
		  return $facturado;	
	  }else{
		  return 0;
	  }
   }
	
  public function GetValorSaldo($Conex){
	   	   
     $select    = "SELECT SUM(d.valor_liquida)AS saldo FROM detalle_factura_puc d, factura f 
	              WHERE d.factura_id=f.factura_id AND d.contra_factura=1 AND f.estado='C' 
				  AND f.factura_id NOT IN(SELECT r.factura_id FROM relacion_abono r,abono_factura a
		                                   WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_id)
				  AND YEAR (f.fecha) = YEAR (NOW()) AND MONTH (f.fecha) = MONTH (NOW())";
	 $result    = $this -> DbFetchAll($select,$Conex,true);
     $saldos = $result[0]['saldo'];
	  $saldo = number_format($saldos, 0, ',', '.');
	  if($saldo>0){
		  return $saldo;	
	  }else{
		  return 0;
	  }	
   }


    public function GetValorPagado($Conex){
	   	   
    $select    = "SELECT SUM(d.valor_liquida)AS pagado 
	              FROM detalle_factura_puc d, factura f, abono_factura a, relacion_abono r
	              WHERE d.factura_id=f.factura_id AND f.factura_id = r.factura_id  AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura = 'C' AND d.contra_factura=1 AND f.estado='C' AND YEAR (a.fecha) = YEAR (NOW()) AND MONTH (a.fecha) BETWEEN  MONTH (NOW())-1 AND MONTH (NOW())";

    $result    = $this -> DbFetchAll($select,$Conex,true);
     $pago = $result[0]['pagado'];
	  $pagado = number_format($pago, 0, ',', '.');
	  if($pagado>0){
		  return $pagado;	
	  }else{
		  return 0;
	  }		
   } 

     public function selectMayorSaldo($Conex){
		 
     $sql = "SELECT 
	            (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=c.tercero_id)AS cliente,

				((SELECT SUM(valor_liquida) FROM detalle_factura_puc WHERE factura_id IN (SELECT f1.factura_id FROM factura f1 WHERE f1.estado = 'C' AND c.cliente_id = f1.cliente_id  ) AND contra_factura = 1)-SUM(r.rel_valor_abono))AS saldo 

			 FROM cliente c, detalle_factura_puc d, factura f, relacion_abono r, abono_factura a WHERE  r.factura_id=f.factura_id AND r.abono_factura_id=a.abono_factura_id AND f.cliente_id = c.cliente_id AND d.factura_id =f.factura_id  
			 AND d.contra_factura=1 AND f.estado='C' AND c.estado = 'D' AND a.estado_abono_factura != 'I' GROUP BY c.cliente_id ORDER BY saldo DESC LIMIT 5";
	 
      $result  = $this -> DbFetchAll($sql,$Conex,true);
    
      return $result;	
      
	 }

	public function selectValores($Conex){

		$data = array();
		 
		$select    = "SELECT SUM(d.valor_liquida)AS facturado FROM detalle_factura_puc d, factura f WHERE d.factura_id=f.factura_id AND d.contra_factura=1 AND f.estado='C' AND YEAR (f.fecha) = YEAR (NOW())";
	    $result    = $this -> DbFetchAll($select,$Conex,true);
        $data[0]['factura'] = $result;

		$select    = "SELECT SUM(d.valor_liquida)AS saldo FROM detalle_factura_puc d, factura f 
	              WHERE d.factura_id=f.factura_id AND d.contra_factura=1 AND f.estado='C' 
				  AND f.factura_id NOT IN(SELECT r.factura_id FROM relacion_abono r,abono_factura a
		                                   WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_id)
				  AND YEAR (f.fecha) = YEAR (NOW())";
	    $result    = $this -> DbFetchAll($select,$Conex,true);
		$data[0]['saldos'] = $result;
		
	    $select    = "SELECT SUM(d.valor_liquida)AS pagado FROM detalle_factura_puc d, factura f 
	              WHERE d.factura_id=f.factura_id AND d.contra_factura=1 AND f.estado='C' 
				  AND f.factura_id IN(SELECT r.factura_id FROM relacion_abono r, abono_factura a, detalle_factura_puc d
		                                WHERE r.factura_id=f.factura_id AND f.factura_id = d.factura_id
										AND r.abono_factura_id IS NOT NULL AND r.abono_factura_id = a.abono_factura_id
										AND a.estado_abono_factura != 'I' AND r.rel_valor_abono = d.valor_liquida GROUP BY r.factura_id)
				  AND YEAR (f.fecha) = YEAR (NOW())";
  
        $result    = $this -> DbFetchAll($select,$Conex,true);
		$data[0]['pago'] = $result;
		
		return $data;
	 }
   
      
}

?>