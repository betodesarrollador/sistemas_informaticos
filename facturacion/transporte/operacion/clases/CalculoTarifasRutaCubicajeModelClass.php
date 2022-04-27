<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CalculoTarifasRutaCubicajeModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	
    $solicitud_servicio_tarifar_id = $this -> DbgetMaxConsecutive("solicitud_servicio_tarifar","solicitud_servicio_tarifar_id",$Conex,false,1);
	$this -> assignValRequest('solicitud_servicio_tarifar_id',$solicitud_servicio_tarifar_id);
	
	$this -> Begin($Conex);
		
		$this -> DbInsertTable("solicitud_servicio_tarifar",$Campos,$Conex,true,false);
			
	$this -> Commit($Conex);
	
	return array(array(solicitud_servicio_tarifar_id=>$solicitud_servicio_tarifar_id));
  }
  
  

  public function Update($Campos,$Conex){
	$this -> DbUpdateTable("solicitud_servicio_tarifar",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
 
    $this -> Begin($Conex);		
	
	 $solicitud_servicio_tarifar_id = $_REQUEST['solicitud_servicio_tarifar_id'];	 
	 
	 $delete = "DELETE FROM tarifa_ruta_cubicaje_calculada WHERE solicitud_servicio_tarifar_id = $solicitud_servicio_tarifar_id ";
	 $this -> query($delete,$Conex,true);

	 $delete = "DELETE FROM detalle_solicitud_servicio_tarifar WHERE solicitud_servicio_tarifar_id = $solicitud_servicio_tarifar_id ";
	 $this -> query($delete,$Conex,true);

	 $delete = "DELETE FROM solicitud_servicio_tarifar WHERE solicitud_servicio_tarifar_id = $solicitud_servicio_tarifar_id ";
	 $this -> query($delete,$Conex,true);

    $this -> Commit($Conex);
   
  }


//LISTA MENU

  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  } 

//BUSQUEDA
  public function selectTarifasRutaCubicaje($solicitud_servicio_tarifar_id,$Conex){
    				
   $select = "SELECT s.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) 
 			  FROM tercero  WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,(SELECT nombre FROM oficina WHERE 
			  oficina_id = s.oficina_id) AS oficina  FROM solicitud_servicio_tarifar s  WHERE solicitud_servicio_tarifar_id=$solicitud_servicio_tarifar_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
  
  
  public function SelectContactosSeguimiento($solicitud_servicio_tarifar_id,$Conex){
  
        $select = "SELECT contacto_id FROM contacto_solicitud_servicio_tarifar WHERE solicitud_servicio_tarifar_id = $solicitud_servicio_tarifar_id";

	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;  
  
  }
  
   public function archivoEstaParametrizado($cliente_id,$camposArchivo,$Conex){     
     
     $select = "SELECT * FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id";
     $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
     
     if(count($result) > 0){
     
       $select = "SELECT nombre_campo FROM campos_archivo_solicitud WHERE requerido_tarifas = 1 AND campos_archivo_solicitud_id NOT IN 
	   (SELECT campos_archivo_solicitud_id FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id)";
       
       $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);       
       
       if(count($result) > 0){
       
         $camposNoParametrizados = '';
         
         for($i = 0; $i < count($result); $i++){
          $camposNoParametrizados .= "{$result[$i]['nombre_campo']},";
         }
         
         $camposNoParametrizados = substr($camposNoParametrizados,0,strlen($camposNoParametrizados) -1);
         
         exit("Los siguientes campos son obligatorios y no estan parametrizados : <br> $camposNoParametrizados");
       
       }else{
       
		     $select = "SELECT c.nombre_campo,(SELECT nombre_campo FROM campos_archivo_solicitud WHERE 
			 campos_archivo_solicitud_id = c.campos_archivo_solicitud_id) AS nombre_campo_sistema FROM 
			 campos_archivo_tarifas c WHERE cliente_id = $cliente_id";
			 
             $result = $this -> DbFetchAll($select,$Conex,true);       
			 			 			 
			 for($i = 0; $i < count($result); $i++){
			 
			    $campoCliente         = $result[$i]['nombre_campo'];
				$campoSistema         = $result[$i]['nombre_campo_sistema'];
				$archivoContieneCampo = false;
			 
			    for($j = 0; $j < count($camposArchivo[0]); $j++){
				
                  $campoArchivo = $camposArchivo[0][$j];
								
				  if(trim($campoArchivo) == trim($campoCliente)){
				    $archivoContieneCampo = true;
					break;
				  }
				
				}
								
				
				if(!$archivoContieneCampo){
				 exit("<p align='center'>El archivo no contiene el campo de titulo [ $campoCliente ] en la primera fila.\n
				 este campo fue parametrizado como [ $campoSistema ] !!!</p>");
				 }
			 
			 }
	   
             return true;
       
         }    
     
     
     }else{
         exit("Este cliente no tiene parametrizado archivo de carga masiva<br>Por favor parametrize el archivo !!");
       }
   
   
   }  
   
   public function esCampoParametrizado($campoTmp,$cliente_id,$Conex){
   
     $select = "SELECT * FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id AND  TRIM(nombre_campo) LIKE TRIM('$campoTmp')";
     $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);       
   
     if(count($result) > 0){
      return true;     
     }else{
         return false;
       }
   
   }
   
   public function getParametrosCampo($campoTmp,$cliente_id,$Conex){
   
     $select = "SELECT * FROM campos_archivo_solicitud WHERE  campos_archivo_solicitud_id = (SELECT campos_archivo_solicitud_id 
	 FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id AND TRIM(nombre_campo) = TRIM('$campoTmp') LIMIT 1)";	 
     
     $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);            
     
     return $result[0];
   
   }
   
   public function getValValidate($valor,$parametrosCampo){
   
     $tipo_dato = $parametrosCampo['tipo_dato'];
     $longitud  = $parametrosCampo['longitud'];
     
     if($tipo_dato == 'bigint' ||  $tipo_dato == 'integer' || $tipo_dato == 'int' || $tipo_dato == 'numeric'){
     
      if(!is_numeric($valor)){
      
        return "El tipo de dato para el campo [$campo] es  [ $tipo_dato ] ";
      
      }
      
      $longitudVal = strlen(trim($valor));
      
      if($longitudVal > $longitud){
      
        return "La longitud maxima para el campo [ $campo ] es [ $valor ]";
      
      }
      
     
     }else{
           
        $longitudVal = strlen(trim($valor));
      
        if($longitudVal > $longitud){
      
          return "La longitud maxima para el campo [ $campo ] es [ $valor ]";
      
        }     
     
     
       }
       

       return true;
   }
   
   public function getValInsert($valor,$parametrosCampo){
   
     $tipo_dato = $parametrosCampo['tipo_dato'];
     $longitud  = $parametrosCampo['longitud'];
     
     if($tipo_dato == 'bigint' ||  $tipo_dato == 'integer' || $tipo_dato == 'int' || $tipo_dato == 'numeric'){
     
       return $valor;
     
     }else{
           
          return "'$valor'";
     
       }
        
   }
   
   public function getValueForeign($valor,$campo,$parametrosCampo,$cliente_id,$Conex){
   
      $nombreTabla = $parametrosCampo['nombre_campo_tabla'];
	  
	  if($nombreTabla == 'destinatario'){
	  
	      $select = "SELECT * FROM remitente_destinatario WHERE cliente_id = $cliente_id AND TRIM(nombre) LIKE TRIM('$valor')";
		  $destinatario = $this -> DbFetchAll($select,$Conex,true); 		  
		  
		  if(count($destinatario) > 0){
		  
		     $select = "SELECT * FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id AND campos_archivo_solicitud_id = 
			 (SELECT campos_archivo_solicitud_id FROM campos_archivo_solicitud WHERE TRIM(nombre_campo_tabla) 
			 LIKE TRIM('direccion_destinatario'))";
			 
		     $direccion = $this -> DbFetchAll($select,$Conex,true);            

		     $select = "SELECT * FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id AND campos_archivo_solicitud_id = 
			 (SELECT campos_archivo_solicitud_id FROM campos_archivo_solicitud WHERE TRIM(nombre_campo_tabla) 
			 LIKE TRIM('telefono_destinatario'))";
			 
		     $telefono = $this -> DbFetchAll($select,$Conex,true);            


		     $select = "SELECT * FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id AND campos_archivo_solicitud_id = 
			 (SELECT campos_archivo_solicitud_id FROM campos_archivo_solicitud WHERE TRIM(nombre_campo_tabla) 
			 LIKE TRIM('destino_id'))";
			 
		     $destino = $this -> DbFetchAll($select,$Conex,true);            
			 
			$camposValores=array(campos=>"destinatario_id,destinatario,tipo_identificacion_destinatario_id,doc_destinatario,",valores=>"{$destinatario[0]['remitente_destinatario_id']},'$valor',{$destinatario[0]['tipo_identificacion_id']},'{$destinatario[0]['numero_identificacion']}',");
			 
			 if(!count($direccion) > 0){
               $camposValores['campos']  .= "direccion_destinatario,";				 
			   
			   $direccion_destinatario = strlen(trim($destinatario[0]['direccion'])) > 0 ? $destinatario[0]['direccion'] : 'NULL';
               $camposValores['valores'] .= "'$direccion_destinatario',";				 			   
			 }
			 
			 if(!count($telefono) > 0){
			   $telefono_destinatario = strlen(trim($destinatario[0]['telefono'])) > 0 ? $destinatario[0]['telefono'] : 'NULL';
               $camposValores['campos']  .= "telefono_destinatario,";				 
               $camposValores['valores'] .= "'$telefono_destinatario',";				 			   			 
			 }
			 
			 if(!count($destino) > 0){
               $camposValores['campos']  .= "destino_id,";				 
               $camposValores['valores'] .= "{$destinatario[0]['ubicacion_id']},";				 			   			 
			 }
			 
			 return $camposValores;		  
		  
		  }else{
		       return "No se encontro el destinatario [ $valor ] parametrizado.";
		    }
	  
	  
	  }else if($nombreTabla == 'tipo_identificacion_destinatario_id'){
	  
	     $select = "SELECT tipo_identificacion_id FROM tipo_identificacion_cliente WHERE cliente_id = $cliente_id AND 
		 TRIM(nombre) LIKE TRIM('$valor')";
		 
		 $result = $this -> DbFetchAll($select,$Conex,true); 		 
		 
         if(count($result) > 0){
		     return array(campos => "tipo_identificacion_destinatario_id,", valores => "{$result[0]['tipo_identificacion_id']},");		  		 
		 }else{
		      return "No se encontro el tipo de identificacion [ $valor ] parametrizado.";
		   }
	  
	  
	  }else if($nombreTabla == 'origen_id' || $nombreTabla == 'destino_id'){
	  		
		if($nombreTabla == 'origen_id'){
		
		 $select = "SELECT * FROM ubicacion_cliente_tarifa WHERE cliente_id = $cliente_id AND TRIM(nombre) LIKE TRIM('$valor')";
		  $result = $this -> DbFetchAll($select,$Conex,true);       			
		  
		  if(count($result) > 0){
		  		
		     return array(campos => "origen_id,", valores => "{$result[0]['ubicacion_id']},");		  
		  
		  }else{
		  
		       return "No se encontro la ubicacion [ $valor ] parametrizada.";
		  
		    }
		  	
		
		}else{
		
			  $select = "SELECT * FROM ubicacion_cliente_tarifa WHERE cliente_id = $cliente_id AND TRIM(nombre) LIKE TRIM('$valor')";
			  $result = $this -> DbFetchAll($select,$Conex,true);       			
			  
			  if(count($result) > 0){
					
				 return array(campos => "destino_id,", valores => "{$result[0]['ubicacion_id']},");		  
			  
			  }else{
			  
				   return "No se encontro la ubicacion [ $valor ] parametrizada.";
			  
				}
		
		  }

	  
	  }else if($nombreTabla == 'unidad_peso_id' || $nombreTabla == 'unidad_volumen_id'){
	  
	      if($nombreTabla == 'unidad_peso_id'){
		  
		     $select = "SELECT * FROM medida_cliente WHERE cliente_id = $cliente_id AND TRIM(medida) LIKE TRIM('$valor')";
             $result = $this -> DbFetchAll($select,$Conex,true);       			
			 
			 if(count($result) > 0){
			   return array(campos => "unidad_peso_id,", valores => $result[0]['medida_id'].",");			 
			 }else{
			      return "No se encontro la unidad [ $valor ] parametrizada. ";
			   }
			 
		  }else if($nombreTabla == 'unidad_volumen_id'){
		  
		        $select = "SELECT * FROM medida_cliente WHERE cliente_id = $cliente_id AND TRIM(medida) LIKE TRIM('$valor')";
                $result = $this -> DbFetchAll($select,$Conex,true);       			
				
				if(count($result) > 0){
			      return array(campos => "unidad_volumen_id,", valores => $result[0]['medida_id'].",");		  				
				}else{
				     return "No se encontro la unidad [ $valor ] parametrizada.";
				  }

		    }
	  
	    }
   
   
   
   }
   
   public function setInsertDetalleSolicitud($rowInsert,$solicitud_servicio_tarifar_id,$cliente_id,$Conex){
        
      $campos  = '';
      $valores = '';
      	  
      foreach($rowInsert as $campo => $valor){
      
        $campoTmp = $campo;		
		        
        if($this -> esCampoParametrizado($campoTmp,$cliente_id,$Conex)){
        
          $parametrosCampo = $this -> getParametrosCampo($campoTmp,$cliente_id,$Conex);
		  $campo           = $parametrosCampo['nombre_campo_tabla'];
		  
		  if(!strlen(trim($campo)) > 0) return "Error de configuracion del campo [ $campoTmp ] ";

          if($parametrosCampo['foreign_key'] == 1){
		            			
			$arrayCamposValores  = $this -> getValueForeign($valor,$campo,$parametrosCampo,$cliente_id,$Conex);
			
			
			
			if(is_array($arrayCamposValores )){
              $campos  .= $arrayCamposValores['campos'];  
              $valores .= $arrayCamposValores['valores'];			
			}else{
			    return $arrayCamposValores;
			  }
						
          
          }else{

		     $valorTmp = $this -> getValValidate($valor,$parametrosCampo); 
             
             if($valorTmp == true){
             
               $valor    = $this -> getValInsert($valor,$parametrosCampo);
               
               $campos  .= "$campo,";  
               $valores .= "$valor,";             
             
             }else{             
               return $valorTmp;
              }
          
            }
   
        
        }
            
      
      }
	  	        	  
      $campos  = substr($campos,0,strlen($campos) - 1);       
	  $valores = substr($valores,0,strlen($valores) - 1);
      
	  $detalle_solicitud_servicio_tarifar_id = $this -> DbgetMaxConsecutive("detalle_solicitud_servicio_tarifar","detalle_solicitud_servicio_tarifar_id",$Conex,false,1);
	  
	  $select = "SELECT * FROM remitente_destinatario WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE 
	             cliente_id = $cliente_id)";	  
				 
	  $dataRemitente = $this -> DbFetchAll($select,$Conex,true);  
	  	    
	  $remitente_id                     = $dataRemitente[0]['remitente_destinatario_id'];		
      $remitente                        = $dataRemitente[0]['nombre'];
	  $tipo_identificacion_remitente_id = $dataRemitente[0]['tipo_identificacion_id'];
	  $doc_remitente                    = $dataRemitente[0]['numero_identificacion'];
	  $direccion_remitente              = $dataRemitente[0]['direccion'];
	  $telefono_remitente               = $dataRemitente[0]['telefono'];
	  
      $insert = "INSERT INTO detalle_solicitud_servicio_tarifar (detalle_solicitud_servicio_tarifar_id,solicitud_servicio_tarifar_id,remitente_id,remitente,tipo_identificacion_remitente_id,doc_remitente,direccion_remitente,telefono_remitente,$campos) VALUES ($detalle_solicitud_servicio_tarifar_id,$solicitud_servicio_tarifar_id,$remitente_id,'$remitente',$tipo_identificacion_remitente_id,'$doc_remitente','$direccion_remitente','$telefono_remitente',$valores)";
	  
	  $result = $this -> query($insert,$Conex,true);
	  
   }
   
   public function selectDataOrdenCliente($solicitud_servicio_tarifar_id,$Conex){
   
      $select = "SELECT shipment,origen_id,destino_id,SUM(peso_volumen) AS cubicaje FROM detalle_solicitud_servicio_tarifar  WHERE 
	  solicitud_servicio_tarifar_id = $solicitud_servicio_tarifar_id GROUP BY shipment,origen_id,destino_id ORDER BY shipment";
	  
	  $dataOrdenCliente = $this -> DbFetchAll($select,$Conex,true);  	  
	  
	  return $dataOrdenCliente;   
   
   }
   
   public function clearTarifaOrdenCliente($solicitud_servicio_tarifar_id,$Conex){
   
      $delete = "DELETE FROM tarifa_ruta_cubicaje_calculada WHERE solicitud_servicio_tarifar_id = $solicitud_servicio_tarifar_id";
      $this -> query($delete,$Conex,true);	     
   
   }
   
   public function setTarifaOrdenCliente($solicitud_servicio_tarifar_id,$cliente_id,$ordenes_cliente_calcular,$Conex){
     
     $tarifa_ruta_cubicaje_id = $ordenes_cliente_calcular['tarifa_ruta_cubicaje_id'];
	 $shipment                = $ordenes_cliente_calcular['shipment'];	 
     $origen_id               = $ordenes_cliente_calcular['origen_id'];
	 $destino_id              = $ordenes_cliente_calcular['destino_id'];
	 $cubicaje                = $ordenes_cliente_calcular['cubicaje'];
	 
	 $this -> Begin($Conex);
	 
		 $select = "SELECT * FROM tarifa_ruta_cubicaje WHERE cliente_id = $cliente_id AND origen_id = $origen_id AND destino_id = $destino_id AND  
		 $cubicaje >= desde  AND $cubicaje <= hasta";
		 
		 $tarifaOrdenCliente = $this -> DbFetchAll($select,$Conex,true);  	 
		 
		 if(count($tarifaOrdenCliente) > 0){
		 
		    $tarifa_ruta_cubicaje_id = $tarifaOrdenCliente[0]['tarifa_ruta_cubicaje_id'];
		    $valor                   = $tarifaOrdenCliente[0]['valor'];
			$valorCalculado          = ($cubicaje * $valor);
		 
			$tarifa_ruta_cubicaje_calculada_id = $this -> DbgetMaxConsecutive("tarifa_ruta_cubicaje_calculada",
			"tarifa_ruta_cubicaje_calculada_id",$Conex,false,1);	 		 
			
			$insert = "INSERT INTO  tarifa_ruta_cubicaje_calculada (tarifa_ruta_cubicaje_calculada_id,solicitud_servicio_tarifar_id,shipment,
			origen_id,destino_id,tarifa_ruta_cubicaje_id,cubicaje,valor) VALUE ($tarifa_ruta_cubicaje_calculada_id,$solicitud_servicio_tarifar_id,
			'$shipment',$origen_id,$destino_id,$tarifa_ruta_cubicaje_id,$cubicaje,$valorCalculado) ";
			
		    $this -> query($insert,$Conex,true);
					 
		 }else{
		 		 
				$tarifa_ruta_cubicaje_calculada_id = $this -> DbgetMaxConsecutive("tarifa_ruta_cubicaje_calculada",
				"tarifa_ruta_cubicaje_calculada_id",$Conex,false,1);	 
			 
				$insert = "INSERT INTO  tarifa_ruta_cubicaje_calculada (tarifa_ruta_cubicaje_calculada_id,solicitud_servicio_tarifar_id,
				shipment,origen_id,destino_id,tarifa_ruta_cubicaje_id,cubicaje,valor) VALUE ($tarifa_ruta_cubicaje_calculada_id,
				$solicitud_servicio_tarifar_id,'$orden_cliente',$origen_id,$destino_id,NULL,$cubicaje,0) ";
				
				$this -> query($insert,$Conex,true);		 		 
		 
		   }
		 	 
	 $this -> Begin($Commit);	 
   
     return $tarifa_ruta_cubicaje_calculada_id;
   
   }
   
   
   public function selectOrdenesCalculadas($tarifas_ruta_cubicaje_calculada_id,$Conex){
   
     $select = "SELECT t.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE 
	 ubicacion_id = t.destino_id) AS destino FROM tarifa_ruta_cubicaje_calculada t WHERE tarifa_ruta_cubicaje_calculada_id 
	 IN ($tarifas_ruta_cubicaje_calculada_id) ORDER BY origen,destino ASC";
	 
     $result = $this -> DbFetchAll($select,$Conex,true);   	 
   
     return $result;
   
   }
         
   
}


?>