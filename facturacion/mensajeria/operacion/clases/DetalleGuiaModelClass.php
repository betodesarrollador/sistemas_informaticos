<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleGuiaModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){

    $guia_id           	  = $this -> requestDataForQuery('guia_id','integer'); 
    $detalle_ss_id        = $this -> requestDataForQuery('detalle_ss_id','integer'); 
    $descripcion_producto = $this -> requestDataForQuery('descripcion_producto','text'); 
    $referencia_producto  = $this -> requestDataForQuery('referencia_producto','text'); 	
    $largo                = $this -> requestDataForQuery('largo','numeric'); 
    $ancho                = $this -> requestDataForQuery('ancho','numeric'); 
    $alto                 = $this -> requestDataForQuery('alto','numeric'); 
    $peso_volumen         = $this -> requestDataForQuery('peso_volumen','numeric'); 
    $peso                 = $this -> requestDataForQuery('peso','numeric'); 
    $cantidad             = $this -> requestDataForQuery('cantidad','numeric'); 
    $valor                = $this -> requestDataForQuery('valor','numeric'); 
    $guia_cliente         = $this -> requestDataForQuery('guia_cliente','text'); 
    $observaciones        = $this -> requestDataForQuery('observaciones','text'); 
   
	$detalle_guia_id = $this -> DbgetMaxConsecutive("detalle_guia","detalle_guia_id",$Conex,true,true);	
	
    $insert = "INSERT INTO detalle_guia (detalle_guia_id,guia_id,detalle_ss_id,descripcion_producto,referencia_producto,
	largo,ancho,alto,peso_volumen,peso,cantidad,valor,guia_cliente,observaciones) VALUES    
	($detalle_guia_id,$guia_id,$detalle_ss_id,$descripcion_producto,$referencia_producto,$largo,$ancho,$alto,$peso_volumen,
	$peso,$cantidad,$valor,$guia_cliente,$observaciones)";	
    $this -> query($insert,$Conex);
	return $detalle_guia_id;
  }

  public function Update($Campos,$Conex){

    $detalle_guia_id      = $this -> requestDataForQuery('detalle_guia_id','integer'); 
    $guia_id              = $this -> requestDataForQuery('guia_id','integer'); 
    $detalle_ss_id        = $this -> requestDataForQuery('detalle_ss_id','integer'); 
    $descripcion_producto = $this -> requestDataForQuery('descripcion_producto','text'); 
    $referencia_producto  = $this -> requestDataForQuery('referencia_producto','text'); 	
    $largo                = $this -> requestDataForQuery('largo','numeric'); 
    $ancho                = $this -> requestDataForQuery('ancho','numeric'); 
    $alto                 = $this -> requestDataForQuery('alto','numeric'); 
    $peso_volumen         = $this -> requestDataForQuery('peso_volumen','numeric'); 
    $peso                 = $this -> requestDataForQuery('peso','numeric'); 
    $cantidad             = $this -> requestDataForQuery('cantidad','numeric'); 
    $valor                = $this -> requestDataForQuery('valor','numeric'); 
    $guia_cliente         = $this -> requestDataForQuery('guia_cliente','text'); 
    $observaciones        = $this -> requestDataForQuery('observaciones','text'); 
    
    $update = "UPDATE detalle_guia SET guia_id = $guia_id,detalle_ss_id = $detalle_ss_id,descripcion_producto = $descripcion_producto, 
	referencia_producto = $referencia_producto,	largo = $largo,ancho = $ancho,alto = $alto,peso_volumen = $peso_volumen,peso = $peso,
	cantidad = $cantidad,valor = $valor,guia_cliente = $guia_cliente,observaciones = $observaciones WHERE detalle_guia_id = $detalle_guia_id";	
    $this -> query($update,$Conex);
  }

  public function Delete($Campos,$Conex){	 	 
  	$this -> DbDeleteTable("detalle_guia",$Campos,$Conex,false,false);  
  }
    
  public function getDetallesGuia($Conex){  
	$guia_id = $this -> requestDataForQuery('guia_id','integer');	
	if(is_numeric($guia_id)){	
		$select  = "SELECT d.* FROM detalle_guia d WHERE guia_id = $guia_id ORDER BY detalle_guia_id ASC";
	  	$result = $this -> DbFetchAll($select,$Conex,true);	  
	}else{
   	    $result = array();
	  }
	return $result;
  }   
}

?>