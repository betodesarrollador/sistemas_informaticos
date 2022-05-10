<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleRemesasModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){

    $remesa_id            = $this -> requestDataForQuery('remesa_id','integer'); 
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
   
	$detalle_remesa_id = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,true,true);	
	
    $insert = "INSERT INTO detalle_remesa (detalle_remesa_id,remesa_id,detalle_ss_id,descripcion_producto,referencia_producto,
	largo,ancho,alto,peso_volumen,peso,cantidad,valor,guia_cliente,observaciones) VALUES    
	($detalle_remesa_id,$remesa_id,$detalle_ss_id,$descripcion_producto,$referencia_producto,$largo,$ancho,$alto,$peso_volumen,
	$peso,$cantidad,$valor,$guia_cliente,$observaciones)";
	
    $this -> query($insert,$Conex);

	return $detalle_remesa_id;

  }

  public function Update($Campos,$Conex){
  

    $detalle_remesa_id    = $this -> requestDataForQuery('detalle_remesa_id','integer'); 
    $remesa_id            = $this -> requestDataForQuery('remesa_id','integer'); 
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
    

    $update = "UPDATE detalle_remesa SET remesa_id = $remesa_id,detalle_ss_id = $detalle_ss_id,descripcion_producto = $descripcion_producto, 
	referencia_producto = $referencia_producto,	largo = $largo,ancho = $ancho,alto = $alto,peso_volumen = $peso_volumen,peso = $peso,
	cantidad = $cantidad,valor = $valor,guia_cliente = $guia_cliente,observaciones = $observaciones WHERE detalle_remesa_id = $detalle_remesa_id";
	
    $this -> query($update,$Conex);

  }

  public function Delete($Campos,$Conex){
	 	 
  	$this -> DbDeleteTable("detalle_remesa",$Campos,$Conex,false,false);
  
  }
  
  public function GetNaturaleza($Conex){
	return $this -> DbFetchAll("SELECT naturaleza_id AS value,naturaleza AS text FROM naturaleza ORDER BY naturaleza",$Conex,$ErrDb = false);
  }
  
  public function GetTipoEmpaque($Conex){
	return $this -> DbFetchAll("SELECT empaque_id AS value,empaque AS text FROM empaque ORDER BY empaque",$Conex,$ErrDb = false);
  }  
  
  public function getUnidades($Conex){

    $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE ministerio = 1 ORDER BY medida ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }

  public function getUnidadesVolumen($Conex){

    $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE tipo_unidad_medida_id = 11 ORDER BY medida ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }
    
  public function getDetallesRemesas($Conex){
  
	$remesa_id = $this -> requestDataForQuery('remesa_id','integer');
	
	if(is_numeric($remesa_id)){
	
		$select  = "SELECT (SELECT codigo FROM producto WHERE producto_id = d.producto_id) AS codigo,d.* FROM detalle_remesa d WHERE remesa_id = $remesa_id ORDER BY detalle_remesa_id ASC";
	
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
 

   
}



?>