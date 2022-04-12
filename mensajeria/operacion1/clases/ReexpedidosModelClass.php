<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReexpedidosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDivipolaUbicacion($ubicacion_id,$Conex){  
    $select = "SELECT divipola FROM ubicacion WHERE ubicacion_id = $ubicacion_id";
	$result = $this -> DbFetchAll($select,$Conex,true);		
	return $result[0]['divipola'];  
  }
  
/////  
  public function Delete($Campos,$Conex){
	$this -> Begin($Conex);

 	  $this -> DbDeleteTable("reexpedido_id",$Campos,$Conex,true,false);	
  	  $this -> DbDeleteTable("reexpedido",$Campos,$Conex,true,false);	
	
	$this -> Commit($Conex);
  } 
  
  public function reexpedidoTieneGuias($reexpedido_id,$Conex){  
    $select = "SELECT COUNT(*) AS num_guia FROM detalle_despacho_guia WHERE reexpedido_id = $reexpedido_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0]['num_guia'] > 0){
	  return true;
	}else{
	     return false;
	  }	  
  }  
 
  public function cancellation($reexpedido_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){ 
  
	$select = "SELECT d.guia_id FROM detalle_despacho_guia d 
	WHERE d.reexpedido_id = $reexpedido_id AND 
	(d.guia_id IN (SELECT dd.guia_id FROM detalle_devolucion dd, devolucion dv WHERE dv.estado='D' AND dd.devolucion_id=dv.devolucion_id )
     OR d.guia_id IN (SELECT dd.guia_id FROM detalle_entrega dd, entrega dv WHERE dv.estado='E' AND dd.entrega_id=dv.entrega_id ))";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0][guia_id]>0){
		exit('No puede Anular el manifiesto, <br>debido a que una o varias de las guias estan relacionadas<br> en una devoluci&oacute;n o entrega Activa');
	}
  
   $this -> Begin($Conex);  
     $update = "UPDATE reexpedido SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE reexpedido_id = $reexpedido_id";	 
	 $this -> query($update,$Conex,true);	
	 
	 $update = "UPDATE guia SET estado_mensajeria_id=1 WHERE guia_id IN (SELECT guia_id FROM detalle_despacho_guia WHERE reexpedido_id = $reexpedido_id)";
	 $this -> query($update,$Conex,true);	
   $this -> Commit($Conex);
  }   
  
	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
    }	  

  public function getConsecutivoDespacho($oficina_id,$Conex){	  
	    
	$select     = "SELECT MAX(reexpedido) AS reexpedido FROM reexpedido WHERE oficina_id = $oficina_id";
	$result     = $this -> DbFetchAll($select,$Conex,true);    
	$reexpedido = $result[0]['reexpedido'];

    if(is_numeric($reexpedido)){	
	
	        $select  = "SELECT rango_rxp_fin FROM rango_rxp WHERE oficina_id = $oficina_id AND estado = 'A'";
	        $result           = $this -> DbFetchAll($select,$Conex,true);
		    $rango_rxp_fin  = $result[0]['rango_rxp_fin'];	
					
 		    $reexpedido += 1;
		  		  
		    if($reexpedido > $rango_rxp_fin){
			   print 'El numero de reexpedido para esta oficina a superado el limite definido<br>debe actualizar el rango de reexpedidos asignado para esta oficina !!!';
			   return false;
		    }	  		  
	      }
		    else{			
	             $select           = "SELECT rango_rxp_ini FROM rango_rxp WHERE oficina_id = $oficina_id AND estado = 'A'";				 
	             $result           = $this -> DbFetchAll($select,$Conex,true);
		         $rango_rxp_ini  = $result[0]['rango_rxp_ini'];
				 		
		         if(is_numeric($rango_rxp_ini)){
		            $reexpedido += 1;
		         }else{		
		              print 'Debe Definir un rango de reexpedidos para la oficina!!!';
		              return false;		   		
		            }
			  }
						  
  return $reexpedido;
  }
  
  
  public function Update($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){ 

    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);	
    $this -> assignValRequest('estado','M');

    $this -> Begin($Conex);
	
     $this -> DbUpdateTable("reexpedido",$Campos,$Conex,true,false);
	 	 
     $reexpedido_id  = $this -> requestData('reexpedido_id');
	
	
    $this -> Commit($Conex);	 
  }
  

/////    
   public function Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){
			
    $reexpedido_id = $this -> DbgetMaxConsecutive("reexpedido","reexpedido_id",$Conex,true,1);	
    $reexpedido    = $this -> getConsecutivoDespacho($oficina_id,$Conex);
	
    $this -> assignValRequest('empresa_id',$empresa_id);
    $this -> assignValRequest('oficina_id',$oficina_id);
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
    $this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
	
    $this -> assignValRequest('reexpedido_id',$reexpedido_id);
    $this -> assignValRequest('reexpedido',$reexpedido);
				
	 	
    $this -> Begin($Conex);    
	  
	$this -> assignValRequest('estado','M');		    					
	$this -> DbInsertTable("reexpedido",$Campos,$Conex,true,false);

	$this -> Commit($Conex);
	
    return array(array(reexpedido_id=>$reexpedido_id,reexpedido=>$reexpedido));
  }

//LISTA MENU

//BUSQUEDA
  public function selectReexpedidos($reexpedido_id,$Conex){
    				
   $select = "SELECT r.*, 
   r.fecha_rxp,r.proveedor_id,(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) 
   FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor, r.origen_id,
   (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,r.destino_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino 
   FROM reexpedido r WHERE r.reexpedido_id=$reexpedido_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	return $result;
  }

//// GRID ////
  public function getQueryReexpedidosGrid(){
	   	   
	$Query = "SELECT r.reexpedido,r.fecha_rxp,
	(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) FROM tercero t, proveedor p 
	WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'M' THEN 'MANIFESTADO' WHEN 'L' THEN 'LEGALIZADO' ELSE 'ANULADO' END AS estado,
	obser_rxp
	FROM reexpedido r";
	
   
     return $Query;
   }   
}

?>