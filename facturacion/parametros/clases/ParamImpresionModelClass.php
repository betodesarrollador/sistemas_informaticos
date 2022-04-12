<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParamImpresionModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
	
    public function Update($Conex){

  	$this -> Begin($Conex);

      $parametro_impresion_id 	= $this -> requestDataForQuery('parametro_impresion_id','integer');
      $remesa                 	= $this -> requestDataForQuery('remesa','integer');	  
      $fecha_remesa             = $this -> requestDataForQuery('fecha_remesa','integer');
      $peso                     = $this -> requestDataForQuery('peso','integer');
	  $placa                    = $this -> requestDataForQuery('placa','integer');
	  $descripcion_remesa   	= $this -> requestDataForQuery('descripcion_remesa','integer');	  
	  $origen                   = $this -> requestDataForQuery('origen','integer');
	  $pasador_vial             = $this -> requestDataForQuery('pasador_vial','integer');
	  $destino	                = $this -> requestDataForQuery('destino','integer');
	  $doc_cliente	            = $this -> requestDataForQuery('doc_cliente','integer');
	  $manifiesto               = $this -> requestDataForQuery('manifiesto','integer');
	  $valor_tonelada	        = $this -> requestDataForQuery('valor_tonelada','integer');
	  $descripcion_producto	    = $this -> requestDataForQuery('descripcion_producto','integer');
	  $observacion_uno	        = $this -> requestDataForQuery('observacion_uno','integer');
	  $observacion_dos	        = $this -> requestDataForQuery('observacion_dos','integer');
	  $valor_declarado          = $this -> requestDataForQuery('valor_declarado','integer');
	  $cantidad_cargada	        = $this -> requestDataForQuery('cantidad_cargada','integer');
	  $cantidad_producto	    = $this -> requestDataForQuery('cantidad_producto','integer');
	  $valor_unitario_remesa    = $this -> requestDataForQuery('valor_unitario_remesa','integer');
	  $orden	                = $this -> requestDataForQuery('orden','integer');
	  $fecha_orden	            = $this -> requestDataForQuery('fecha_orden','integer');
	  $descripcion_orden	    = $this -> requestDataForQuery('descripcion_orden','integer');
	  $formato_impresion	    = $this -> requestDataForQuery('formato_impresion','integer');
	  $impuestos_visibles	    = $this -> requestDataForQuery('impuestos_visibles','integer');
	  $detalles_visibles	    = $this -> requestDataForQuery('detalles_visibles','integer');
	  $cabecera_por_pagina	    = $this -> requestDataForQuery('cabecera_por_pagina','integer');
	  $observacion_encabezado	= $this -> requestDataForQuery('observacion_encabezado','alphanum');
	  $pie_pagina	            = $this -> requestDataForQuery('pie_pagina','alphanum');

	  $select="SELECT parametro_impresion_id FROM parametro_impresion_factura WHERE parametro_impresion_id = $parametro_impresion_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  $parametro_id = $result[0]['parametro_impresion_id'];
	  
	  if($parametro_id>0){

		  $update = "UPDATE parametro_impresion_factura SET remesa = $remesa, fecha_remesa=$fecha_remesa, peso = $peso,placa = $placa,descripcion_remesa = $descripcion_remesa,
					origen=$origen, pasador_vial=$pasador_vial, destino=$destino , doc_cliente=$doc_cliente, manifiesto=$manifiesto, valor_tonelada=$valor_tonelada , descripcion_producto=$descripcion_producto, observacion_uno = $observacion_uno, 
					observacion_dos = $observacion_dos, valor_declarado = $valor_declarado, cantidad_producto = $cantidad_producto, cantidad_cargada = $cantidad_cargada, valor_unitario_remesa = $valor_unitario_remesa, orden = $orden, fecha_orden=$fecha_orden,
					descripcion_orden=$descripcion_orden, formato_impresion=$formato_impresion, impuestos_visibles=$impuestos_visibles, detalles_visibles=$detalles_visibles, cabecera_por_pagina=$cabecera_por_pagina, observacion_encabezado=$observacion_encabezado, pie_pagina=$pie_pagina
					WHERE parametro_impresion_id = $parametro_impresion_id";
		
		  $this -> query($update,$Conex,true);

	  }else{

		   $insert="INSERT INTO parametro_impresion_factura (parametro_impresion_id,remesa,fecha_remesa,peso,placa,descripcion_remesa,origen,pasador_vial,destino,doc_cliente,manifiesto,valor_tonelada,descripcion_producto,observacion_uno,observacion_dos,valor_declarado,cantidad_cargada,cantidad_producto,valor_unitario_remesa,orden,fecha_orden,descripcion_orden,formato_impresion,impuestos_visibles,detalles_visibles,cabecera_por_pagina,observacion_encabezado,pie_pagina) 
		           VALUES ($parametro_impresion_id,$remesa,$fecha_remesa,$peso,$placa,$descripcion_remesa,$origen,$pasador_vial,$destino,$doc_cliente,$manifiesto,$valor_tonelada,$descripcion_producto,$observacion_uno,$observacion_dos,$valor_declarado,$cantidad_cargada,$cantidad_producto,$valor_unitario_remesa,$orden,$fecha_orden,$descripcion_orden,$formato_impresion,$impuestos_visibles,$detalles_visibles,$cabecera_por_pagina,'$observacion_encabezado','$pie_pagina')";
		   $this -> query($insert,$Conex,true);

	  }
	
	$this -> Commit($Conex);

   }

   public function selectParametros($parametro_impresion_id,$Conex){
	 $select    = "SELECT * FROM  parametro_impresion_factura WHERE parametro_impresion_id = $parametro_impresion_id";
     $result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;					  			
	  
  }

    public function setAdjunto($dir_file,$Conex){

	  $select="SELECT parametro_impresion_id FROM parametro_impresion_factura WHERE parametro_impresion_id = 1";
	  $result = $this -> DbFetchAll($select,$Conex,true);

	  $parametro_impresion_id = $result[0]['parametro_impresion_id'];

	    if($parametro_impresion_id > 0){
			$update    = "UPDATE parametro_impresion_factura SET logo='$dir_file' WHERE parametro_impresion_id= $parametro_impresion_id";
			$result    = $this -> query($update,$Conex,true);
		}else{
			$insert="INSERT INTO parametro_impresion_factura (parametro_impresion_id,remesa,fecha_remesa,peso,placa,descripcion_remesa,origen,pasador_vial,destino,doc_cliente,manifiesto,valor_tonelada,descripcion_producto,observacion_uno,observacion_dos,valor_declarado,cantidad_cargada,cantidad_producto,valor_unitario_remesa,orden,fecha_orden,descripcion_orden,formato_impresion,impuestos_visibles,detalles_visibles,cabecera_por_pagina,observacion_encabezado,pie_pagina) 
		           VALUES (1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,NULL)";
		   $this -> query($insert,$Conex,true);
		}
		
		return $result;					  			

  }
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tipo_bien_servicio_factura",$Campos);
	 return $Data -> GetData();
   }
	 	

   public function GetQueryParamImpresionGrid(){
	   	   
   $Query = "SELECT t.tipo_bien_servicio_factura_id, 
   			t.nombre_bien_servicio_factura,
			(SELECT fuente_facturacion_nom FROM fuente_facturacion WHERE fuente_facturacion_cod=t.fuente_facturacion_cod) AS fuente_servicio,
			(SELECT nombre  FROM tipo_de_documento  WHERE tipo_documento_id=t.tipo_documento_id) AS documento
		FROM tipo_bien_servicio_factura t";
   return $Query;
   }
}

?>