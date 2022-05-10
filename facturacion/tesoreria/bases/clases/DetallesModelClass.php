<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getDetalles($tipo_bien_servicio_teso_id,$Conex){
	   	
	if(is_numeric($tipo_bien_servicio_teso_id)){
	
	  $select  = "SELECT c.puc_id AS puc_id, c.codpuc_bien_servicio_teso_id, (SELECT codigo_puc FROM puc WHERE puc_id =c.puc_id) AS codigo_puc,  
	  (SELECT CONCAT_WS(' - ',codigo_puc,nombre) FROM puc WHERE puc_id =c.puc_id) AS puc, (SELECT nombre FROM puc WHERE puc_id =c.puc_id) AS descripcion,  
      c.natu_bien_servicio_teso, c.contra_bien_servicio_teso, 
	  (SELECT CONCAT_WS(' ',numero_identificacion,' - ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id =c.tercero_id) AS tercero,
	  (SELECT nombre FROM centro_de_costo WHERE centro_de_costo_id =c.centro_costo_id) AS centro_de_costo
	  FROM codpuc_bien_servicio_teso c WHERE tipo_bien_servicio_teso_id =$tipo_bien_servicio_teso_id";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }	
	return $result;  
  }  
    
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tipo_bien_servicio_teso_id 		= $this -> requestDataForQuery('tipo_bien_servicio_teso_id','integer');
      $codpuc_bien_servicio_teso_id 	= $this -> DbgetMaxConsecutive("codpuc_bien_servicio_teso","codpuc_bien_servicio_teso_id",$Conex,true,1);
      $puc_id                 			= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio_teso     		= $this -> requestDataForQuery('natu_bien_servicio_teso','alphanum');
      $contra_bien_servicio_teso    	= $this -> requestDataForQuery('contra_bien_servicio_teso','integer');
      $tercero_id             			= $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     			= $this -> requestDataForQuery('centro_de_costo_id','integer');	  	  

      $insert = "INSERT INTO codpuc_bien_servicio_teso 
	  (codpuc_bien_servicio_teso_id ,tipo_bien_servicio_teso_id,puc_id,natu_bien_servicio_teso,contra_bien_servicio_teso,tercero_id,centro_costo_id) 
	  VALUES ($codpuc_bien_servicio_teso_id,$tipo_bien_servicio_teso_id,$puc_id,$natu_bien_servicio_teso,$contra_bien_servicio_teso, $tercero_id,$centro_de_costo_id)";

    $this -> query($insert,$Conex);	
	$this -> Commit($Conex);	
	return $codpuc_bien_servicio_teso_id;
  }
  
  public function selectCuentaPuc($puc_id,$Conex){
	
	 $select   = "SELECT requiere_centro_costo,requiere_tercero FROM puc WHERE puc_id = $puc_id";
	 $requiere = $this -> DbFetchAll($select,$Conex,true);	 
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
	 $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  
	  if(!count($impuesto) > 0){		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex,true);						  		  
      }
	  
	  $requiere_centro_costo = $requiere[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	  $requiere_tercero      = $requiere[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	  $requiere_base         = count($impuesto) > 0                       ? 'true' : 'false';
	  
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,requiere_base=>$requiere_base);	
	  return $requieresCuenta;   
  }
  
  public function selectImpuesto($puc_id,$base,$Conex){
	  
      $select = "SELECT ip.naturaleza,imp.* FROM impuesto ip, impuesto_periodo_contable imp 
		  imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id) and imp.impuesto_id = ip.impuesto_id";

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

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $codpuc_bien_servicio_teso_id 	= $this -> requestDataForQuery('codpuc_bien_servicio_teso_id','integer');
      $puc_id                 			= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio_teso       	= $this -> requestDataForQuery('natu_bien_servicio_teso','alphanum');
      $contra_bien_servicio_teso    	= $this -> requestDataForQuery('contra_bien_servicio_teso','integer');
      $tercero_id             			= $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     			= $_REQUEST['centro_de_costo_id'];	  
	
      $update = "UPDATE codpuc_bien_servicio_teso SET puc_id = $puc_id, natu_bien_servicio_teso = $natu_bien_servicio_teso, 
	  contra_bien_servicio_teso = $contra_bien_servicio_teso, tercero_id = $tercero_id, centro_costo_id = $centro_de_costo_id 
	  WHERE codpuc_bien_servicio_teso_id = $codpuc_bien_servicio_teso_id";
	
      $this -> query($update,$Conex);	
	  $this -> Commit($Conex);
  }

  public function Delete($Campos,$Conex){
    $codpuc_bien_servicio_teso_id = $_REQUEST['codpuc_bien_servicio_teso_id'];	
    $insert = "DELETE FROM codpuc_bien_servicio_teso WHERE codpuc_bien_servicio_teso_id = $codpuc_bien_servicio_teso_id";
    $this -> query($insert,$Conex);	
  }
  
}

?>