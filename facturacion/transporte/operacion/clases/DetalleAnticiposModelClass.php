<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleAnticiposModel extends Db{

   public function getDataManifiesto($manifiesto_id,$Conex){
    
	  $select = "SELECT fecha_mc AS fecha,propio FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
      $data   = $this -> DbFetchAll($select,$Conex);	  
	  
	  return $data;   
   
   }
   
   public function getDataDespacho($despachos_urbanos_id,$Conex){
    
	  $select = "SELECT fecha_du AS fecha,propio FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
      $data   = $this -> DbFetchAll($select,$Conex);	  
	  
	  return $data;   
   
   }   

   public function getAnticipos($manifiesto_id,$Conex){
   
     $select    = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
     $anticipos = $this -> DbFetchAll($select,$Conex);
	 	 
     for($i = 0; $i < count($anticipos); $i++){
	 
	    $forma_pago_id    = $anticipos[$i]['forma_pago_id'];		
		
		if(is_numeric($forma_pago_id)){
		  $cuentasFormaPago = $this -> selectCuentasFormasPago($forma_pago_id,$Conex);		
		  $anticipos[$i]['cuentas_forma_pago'] = $cuentasFormaPago;		
		  
		  $terceroFormapago = $this -> selectTercerosFormasPago($forma_pago_id,$Conex);		
		  $anticipos[$i]['tercero_forma_pago'] = $terceroFormapago;				
		  
		}else{
		     $anticipos[$i]['cuentas_forma_pago'] = array();	
			  $anticipos[$i]['tercero_forma_pago'] = array();	
	    }
		
	 
	 }
	 
   return  $anticipos;  
   
   }

	public function getTipoDescuento($Conex){

		$select = "SELECT descuento_id AS value, descuento AS text FROM tabla_descuentos WHERE descuento_anticipos=1"; 
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}
   
   public function getAnticiposDespacho($despachos_urbanos_id,$Conex){
   
     $select    = "SELECT * FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
     $anticipos = $this -> DbFetchAll($select,$Conex);
	 	 
     for($i = 0; $i < count($anticipos); $i++){
	 
	    $forma_pago_id    = $anticipos[$i]['forma_pago_id'];		
		
		if(is_numeric($forma_pago_id)){
		  $cuentasFormaPago = $this -> selectCuentasFormasPago($forma_pago_id,$Conex);		
		  $anticipos[$i]['cuentas_forma_pago'] = $cuentasFormaPago;				

		  $terceroFormapago = $this -> selectTercerosFormasPago($forma_pago_id,$Conex);		
		  $anticipos[$i]['tercero_forma_pago'] = $terceroFormapago;				

		}else{
		     $anticipos[$i]['cuentas_forma_pago'] = array();	
			 $anticipos[$i]['tercero_forma_pago'] = array();	
		  }


	 
	 }
	 
   return  $anticipos;  
   
   }

	public function AnularAnticipoSinGenerar($anticipo_manifiesto_id,$Conex){
		$update="UPDATE anticipos_manifiesto am SET am.estado = 'A' WHERE am.anticipos_manifiesto_id =$anticipo_manifiesto_id";
		$query = $this -> query($update,$Conex,true);
	}

	public function getAnticiposManifiestoAnular($manifiesto_id,$Conex){

		$select    = "SELECT anticipos_manifiesto_id, encabezado_registro_id FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
		$anticipos = $this -> DbFetchAll($select,$Conex);
		return  $anticipos;
	}

	public function getAnticiposManifiestoAnular1($encabezado_registro_id,$Conex){

		$select    = "SELECT * FROM imputacion_contable WHERE encabezado_registro_id=$encabezado_registro_id";
		$anticipos = $this -> DbFetchAll($select,$Conex);
		return  $anticipos;
	}

	public function getAnticiposDespachoAnular($despachos_urbanos_id,$Conex){

		$select    = "SELECT anticipo_despacho_id, encabezado_registro_id FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
		$anticipos = $this -> DbFetchAll($select,$Conex);
		return  $anticipos;
	}
 
   public function getFormasPago($Conex){
  
    $select = "SELECT * FROM forma_pago WHERE estado=1 ORDER BY nombre ASC";
    $result = $this -> DbFetchAll($select,$Conex);	
	
	return $result;
  
  } 
	public function datosManifiesto($anticipos_manifiesto_id,$Conex){
		$select = "SELECT manifiesto_id FROM anticipos_manifiesto WHERE anticipos_manifiesto_id=$anticipos_manifiesto_id";
		$result = $this -> DbFetchAll($select,$Conex);
		$manifiesto = $result[0][manifiesto_id];
		$select = "SELECT estado FROM manifiesto WHERE manifiesto_id=$manifiesto";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result[0][estado];

	}

	public function datosDespacho($anticipos_despacho_id,$Conex){
		$select = "SELECT despachos_urbanos_id FROM anticipos_despacho WHERE anticipos_despacho_id=$anticipos_despacho_id";
		$result = $this -> DbFetchAll($select,$Conex);
		$despacho = $result[0][despachos_urbanos_id];
		$select = "SELECT estado FROM despachos_urbanos WHERE despachos_urbanos_id=$despacho";
		$result = $this -> DbFetchAll($select,$Conex);
		return $result[0][estado];
	}

	public function Anular($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){
		$this -> Begin($Conex);
		$anticipos_despacho_id       = $this -> requestData('anticipos_despacho_id');
		$anticipos_manifiesto_id     = $this -> requestData('anticipos_manifiesto_id');
		$encabezado_registro_id      = $this -> requestData('encabezado_registro_id');


		if($anticipos_manifiesto_id>0){
			$estado = $this -> datosManifiesto($anticipos_manifiesto_id,$Conex);
		}else{
			$estado = $this -> datosDespacho($anticipos_despacho_id,$Conex);
		}

		if($estado=='M' || $estado=='P'){

			if($anticipos_manifiesto_id>0){
				$update="UPDATE  anticipos_manifiesto SET estado='A' WHERE anticipos_manifiesto_id=$anticipos_manifiesto_id";
				$this -> query($update,$Conex,true);
			}else if($anticipos_despacho_id>0){
				$update="UPDATE  anticipos_despacho SET estado='A' WHERE anticipos_despacho_id=$anticipos_despacho_id";
				$this -> query($update,$Conex,true);   
			}

			if($this -> GetNumError() > 0){
				return false;
			}else{
				if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){

					$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
					encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
					forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
					fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,3 AS causal_anulacion_id,
					'ERROR DIGITACION' AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";

					$this -> query($insert,$Conex,true);

					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
					}else{
						$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
						imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
						encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito FROM 
						imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";

						$this -> query($insert,$Conex,true);

						if(strlen($this -> GetError()) > 0){
							$this -> Rollback($Conex);
						}else{
							$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
							$this -> query($update,$Conex,true);
							if(strlen($this -> GetError()) > 0){
								$this -> Rollback($Conex);
							}else{
								$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
								$this -> query($update,$Conex);
								if(strlen($this -> GetError()) > 0){
									$this -> Rollback($Conex);
								}else{
									$this -> Commit($Conex);
								}
							}
						}
					}
				}
			}
		}else{
			$this -> Rollback($Conex); 
			exit("No se puede anular este anticipo, si el manifiesto se encuentra en estado LIQUIDADO o ANULADO.");
		}
	}

	public function AnularAnticipos($anticipos_despacho_id,$anticipos_manifiesto_id,$encabezado_registro_id,$empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){
		$this -> Begin($Conex);
		/*if($anticipos_manifiesto_id>0){
			$select1     = "SELECT COUNT(*) AS movi FROM relacion_anticipos_abono  WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id";
			$result1     = $this -> DbFetchAll($select1,$Conex,true);
			$movimientos1 = $result1[0]['movi'];
		}else{
			$select1     = "SELECT COUNT(*) AS movi FROM relacion_anticipos_abono  WHERE anticipos_despacho_id = $anticipos_despacho_id";
			$result1     = $this -> DbFetchAll($select1,$Conex,true);
			$movimientos1 = $result1[0]['movi'];
		}

		if(!$movimientos1>0){*/

			if($anticipos_manifiesto_id>0){
				$update="UPDATE  anticipos_manifiesto SET estado='A' WHERE anticipos_manifiesto_id=$anticipos_manifiesto_id";
				$this -> query($update,$Conex,true);   
			}else{
				$update="UPDATE  anticipos_despacho SET estado='A' WHERE anticipos_despacho_id=$anticipos_despacho_id";
				$this -> query($update,$Conex,true);   
			}

			if($this -> GetNumError() > 0){
				return false;
			}else{
				if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){

					$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
					encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
					forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
					fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,3 AS causal_anulacion_id,
					'ERROR DIGITACION' AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";

					$this -> query($insert,$Conex,true);

					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
					}else{
						$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
						imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
						encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito FROM 
						imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";

						$this -> query($insert,$Conex,true);

						if(strlen($this -> GetError()) > 0){
							$this -> Rollback($Conex);
						}else{
							$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
							$this -> query($update,$Conex,true);
							if(strlen($this -> GetError()) > 0){
								$this -> Rollback($Conex);
							}else{
								$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
								$this -> query($update,$Conex);
								if(strlen($this -> GetError()) > 0){
									$this -> Rollback($Conex);
								}else{
									$this -> Commit($Conex);
								}
							}
						}
					}
				}
			}
		/*}else{
			$this -> Rollback($Conex); 
			exit('Este anticipo ya esta Cruzado en un Pago.<br> Por favor elimine o anule el pago primero.');
		}*/
	}


	public function save($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){

		require_once("UtilidadesContablesModelClass.php");

		$utilidadesContables = new UtilidadesContablesModel();

		$this -> Begin($Conex);

		$encabezado_registro_id		= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,false,1);	  
		$fecha						= date("Y-m-d");
		$anticipos_manifiesto_id	= $this -> requestData('anticipos_manifiesto_id');
		$anticipos_despacho_id		= $this -> requestData('anticipos_despacho_id');
		$forma_pago_id				= $this -> requestData('forma_pago_id');
		$numero_soporte				= $this -> requestData('numero_soporte');
		$tipo_descuento				= $this -> requestData('tipo_descuento');
		$tipo_descuento				= $tipo_descuento>0?$tipo_descuento:'NULL';
		$valor_descuento			= $this -> requestData('valor_descuento');
		$valor_descuento			= $valor_descuento>0?$valor_descuento:'NULL';
		$cuenta_tipo_pago			= $this -> requestData('cuenta_tipo_pago');
		$forma_pago_tercero			= $this -> requestData('forma_pago_tercero');
		$forma_pago_tercero			= $forma_pago_tercero>0?$forma_pago_tercero:'NULL';
		$numero						= $this -> requestData('numero');
		$valor						= $this -> requestData('valor');
		
		$a_conductor				= $this -> requestData('a_conductor');

		if(is_numeric($anticipos_manifiesto_id)){
			
			$select = "SELECT *	FROM manifiesto	WHERE manifiesto_id = (SELECT manifiesto_id FROM anticipos_manifiesto WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id)";
			$result = $this -> DbFetchAll($select,$Conex,true);	

			$manifiesto     = $result[0]['manifiesto'];	
			$placa          = $result[0]['placa'];			 
			$propio         = $result[0]['propio'];	
			$manifiesto_id  = $result[0]['manifiesto_id'];		
			//$conductor  	= $result[0]['conductor'];		
			$conductor_id  	= $result[0]['conductor_id'];		

			$update = "UPDATE anticipos_manifiesto SET	oficina_id = $oficina_id,forma_pago_id = $forma_pago_id,numero_soporte = '$numero_soporte',
			tipo_descuento_id = $tipo_descuento,valor_descuento = $valor_descuento,	cuenta_tipo_pago_id = $cuenta_tipo_pago,
			tercero_contrapartida=$forma_pago_tercero,conductor=(SELECT (SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, conductor c WHERE t.tercero_id = c.tercero_id AND c.conductor_id=$conductor_id)),
							conductor_id=$conductor_id,a_conductor=$a_conductor WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id";
			$result1 = $this -> DbFetchAll($update,$Conex,true);

			 

		}else{
			
			$select = "SELECT 
							* 
						FROM
							despachos_urbanos
						WHERE
							despachos_urbanos_id = (SELECT 
														despachos_urbanos_id
													FROM
														anticipos_despacho
													WHERE 
														anticipos_despacho_id = $anticipos_despacho_id
													)
						";
			$result = $this -> DbFetchAll($select,$Conex,true);	

			$despacho              = $result[0]['despacho'];	
			$placa                 = $result[0]['placa'];			  
			$propio                = $result[0]['propio'];	
			$despachos_urbanos_id  = $result[0]['despachos_urbanos_id'];		 
			$conductor                = $result[0]['conductor'];	
			$conductor_id             = $result[0]['conductor_id'];	


			$update = "UPDATE 
							anticipos_despacho
						SET
							oficina_id = $oficina_id,
							forma_pago_id = $forma_pago_id,
							numero_soporte = '$numero_soporte',
							cuenta_tipo_pago_id = $cuenta_tipo_pago,
							tercero_contrapartida=$forma_pago_tercero,
							conductor=(SELECT (SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, conductor c WHERE t.tercero_id = c.tercero_id AND c.conductor_id=$conductor_id)),
							conductor_id=$conductor_id,
							a_conductor=$a_conductor
						WHERE
							anticipos_despacho_id = $anticipos_despacho_id
						";
						
			$result1 = $this -> DbFetchAll($update,$Conex,true);

			
		}

		$numero_documento_fuente = is_numeric($anticipos_manifiesto_id) ? $manifiesto    : $despacho;	   		

		if($propio == 1){

			$conductor_id = $this -> requestData('conductor_id');
			$select     = "SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id";
			$result     = $this -> DbFetchAll($select,$Conex,true);	
			$tercero_id = $result[0]['tercero_id'];	
			if(!count($tercero_id) > 0){
				exit("Error al obtener datos del conductor !!");
			}	  	    

		}else{

			$tenedor_id = $this -> requestData('tenedor_id');
			if($a_conductor==1){
				$select = "SELECT tercero_id FROM tenedor  WHERE tenedor_id = $tenedor_id";
			}else{
				$select = "SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id";
			}
			
			$result = $this -> DbFetchAll($select,$Conex,true);		  		 
			$tercero_id = $result[0]['tercero_id'];		 
			if(!count($tercero_id) > 0){
				exit("Error al obtener datos del tenedor !!");
			}	  

		}

		$periodo_contable_id     = $utilidadesContables -> getPeriodoContableId($fecha,$Conex);
		$mes_contable_id         = $utilidadesContables -> getMesContableId($fecha,$periodo_contable_id,$Conex);	
		$concepto                = is_numeric($anticipos_manifiesto_id) ? "ANTICIPO MC : $numero_documento_fuente    VEHICULO PLACA : $placa " : "ANTICIPO DU : $numero_documento_fuente      VEHICULO PLACA : $placa";
		$estado                  = "C";
		$fecha_registro          = date("Y-m-d");
		$modifica                = $modifica;
		$usuario_id              = $usuario_id;
		$fuente_servicio_cod     = "MC";
		$id_documento_fuente     = is_numeric($anticipos_manifiesto_id) ? $manifiesto_id : $anticipos_despacho_id;
		$anulado                 = "0";

		if(is_numeric($anticipos_manifiesto_id)){
			
			$select = "SELECT * FROM parametros_anticipo WHERE propio = (SELECT propio FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id 
			FROM anticipos_manifiesto WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id)) AND oficina_id=$oficina_id"; 

			$result = $this -> DbFetchAll($select,$Conex,true);			

		}else{
			$select = "SELECT * FROM parametros_anticipo WHERE propio = (SELECT propio FROM despachos_urbanos WHERE despachos_urbanos_id = 
			(SELECT despachos_urbanos_id FROM anticipos_despacho WHERE anticipos_despacho_id = $anticipos_despacho_id)) AND oficina_id=$oficina_id"; 

			$result = $this -> DbFetchAll($select,$Conex,true);				

		}

		if(!count($result) > 0){
			exit("No se ha configurado el parametro anticipos a terceros!!");
		}

		$tipo_documento_id = $result[0]['tipo_documento_id'];		
		$consecutivo       = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);	

		$insert = "INSERT INTO  
						encabezado_de_registro (
							encabezado_registro_id,
							empresa_id,
							oficina_id,
							tipo_documento_id,
							forma_pago_id,
							valor,
							numero_soporte,
							tercero_id,
							periodo_contable_id,
							mes_contable_id,
							consecutivo,
							fecha,
							concepto,
							estado,
							fecha_registro,
							modifica,
							usuario_id,
							fuente_servicio_cod,
							numero_documento_fuente,
							id_documento_fuente,
							anulado
						)
						VALUES (
							$encabezado_registro_id,
							$empresa_id,
							$oficina_id,
							$tipo_documento_id,
							$forma_pago_id,
							$valor,
							'$numero_soporte',
							$tercero_id,
							$periodo_contable_id,
							$mes_contable_id,
							$consecutivo,
							'$fecha',
							'$concepto',
							'$estado',
							'$fecha_registro',
							'$modifica',
							$usuario_id,
							'$fuente_servicio_cod',
							'$numero_documento_fuente',
							$id_documento_fuente,
							0
						);
					";

		$this -> query($insert,$Conex,true);   


		if(is_numeric($anticipos_manifiesto_id)){

			$select = "SELECT * FROM parametros_anticipo WHERE propio = (SELECT propio FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id 
			FROM anticipos_manifiesto WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id)) AND oficina_id=$oficina_id "; 

		}else{

			$select = "SELECT * FROM parametros_anticipo WHERE propio = (SELECT propio FROM despachos_urbanos WHERE despachos_urbanos_id = 
			(SELECT despachos_urbanos_id FROM anticipos_despacho WHERE anticipos_despacho_id = $anticipos_despacho_id)) AND oficina_id=$oficina_id"; 			

		}				


		$result            = $this -> DbFetchAll($select,$Conex,true);			
		$tipo_documento_id = $result[0]['tipo_documento_id'];
		$puc_id            = $result[0]['puc_id'];	
		$naturaleza        = $result[0]['naturaleza'];	

		if($naturaleza == 'D'){
			$debito  = $valor;
			$credito = 0;
		}else{
			$debito  = 0;
			$credito = $valor;	
		}

		$select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
		$result = $this -> DbFetchAll($select,$Conex,true);	

		$centro_de_costo_id  = $result[0]['centro_de_costo_id'];	
		$codigo_centro_costo = "'".$result[0]['codigo']."'";			

		if(!count($centro_de_costo_id) > 0){
			exit("Esta oficina no tiene un centro de costo asignado aun !!");
		}


		if($utilidadesContables -> requiereTercero($puc_id,$Conex)){

			$select = "SELECT * FROM tercero WHERE tercero_id = $tercero_id";
			$result = $this  -> DbFetchAll($select,$Conex,true);			   

			$tercero_imputacion_id            = $result[0]['tercero_id'];					 
			$numero_identificacion_imputacion = $result[0]['numero_identificacion'];					 
			$digito_verificacion_imputacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';					

		}else{
			$tercero_imputacion_id            = 'NULL';					 
			$numero_identificacion_imputacion = 'NULL';					 
			$digito_verificacion_imputacion   = 'NULL';	
		}  					 

		if($utilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
			$centro_de_costo_imputacion_id  = $centro_de_costo_id ;
			$codigo_centro_costo_imputacion = $codigo_centro_costo;
		}else{
			$centro_de_costo_imputacion_id  = 'NULL';
			$codigo_centro_costo_imputacion = 'NULL';					 
		}	

		if(is_numeric($anticipos_manifiesto_id)){
			$descripcion = "ANTICIPO $numero MANIFIESTO $numero_documento_fuente";	
		}else{
			$descripcion = "ANTICIPO $numero DESPACHO $numero_documento_fuente";
		}

		$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				

		$insert = "INSERT INTO imputacion_contable (
				imputacion_contable_id,
				tercero_id,
				numero_identificacion,
				digito_verificacion,
				puc_id,
				encabezado_registro_id,
				centro_de_costo_id,
				codigo_centro_costo,
				base,
				valor,
				debito,
				credito,
				descripcion) 
			VALUES (
				$imputacion_contable_id,
				$tercero_imputacion_id,
				$numero_identificacion_imputacion,
				$digito_verificacion_imputacion,
				$puc_id,
				$encabezado_registro_id,
				$centro_de_costo_imputacion_id,
				$codigo_centro_costo_imputacion,
				0,
				$valor,
				$debito,
				$credito,
				'$descripcion');";

		$this -> query($insert,$Conex,true);

		if($this -> GetNumError() > 0){
			return false;
		}						  

		if ($tipo_descuento!='NULL' AND $tipo_descuento!='' AND $tipo_descuento>0 AND $valor_descuento!='NULL' AND $valor_descuento!='' AND $valor_descuento>0) {

			$debito = 0;
			$credito = abs($credito-$valor_descuento);
			$val = $debito+$credito;

			$select = "SELECT puc_id FROM tabla_descuentos WHERE descuento_id = $tipo_descuento";
			$result = $this -> DbFetchAll($select,$Conex,true);	
			$puc_id = $result[0][puc_id];


			if($utilidadesContables -> requiereTercero($puc_id,$Conex)){

				$select = "SELECT * FROM tercero WHERE tercero_id = $tercero_id";
				$result = $this  -> DbFetchAll($select,$Conex,true);			   

				$tercero_imputacion_id            = $result[0]['tercero_id'];					 
				$numero_identificacion_imputacion = $result[0]['numero_identificacion'];					 
				$digito_verificacion_imputacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';					

			}else{
				$tercero_imputacion_id            = 'NULL';					 
				$numero_identificacion_imputacion = 'NULL';					 
				$digito_verificacion_imputacion   = 'NULL';	
			}  					 

			if($utilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
				$centro_de_costo_imputacion_id  = $centro_de_costo_id ;
				$codigo_centro_costo_imputacion = $codigo_centro_costo;
			}else{
				$centro_de_costo_imputacion_id  = 'NULL';
				$codigo_centro_costo_imputacion = 'NULL';					 
			}	

			if(is_numeric($anticipos_manifiesto_id)){
				$descripcion = "DESCUENTO $numero MANIFIESTO $numero_documento_fuente";	
			}else{
				$descripcion = "DESCUENTO $numero DESPACHO $numero_documento_fuente";
			}

			$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				

			$insert = "INSERT INTO imputacion_contable (
					imputacion_contable_id,
					tercero_id,
					numero_identificacion,
					digito_verificacion,
					puc_id,
					encabezado_registro_id,
					centro_de_costo_id,
					codigo_centro_costo,
					base,
					valor,
					debito,
					credito,
					descripcion) 
				VALUES (
					$imputacion_contable_id,
					$tercero_imputacion_id,
					$numero_identificacion_imputacion,
					$digito_verificacion_imputacion,
					$puc_id,
					$encabezado_registro_id,
					$centro_de_costo_imputacion_id,
					$codigo_centro_costo_imputacion,
					0,
					$val,
					$debito,
					$credito,
					'$descripcion');";

			$this -> query($insert,$Conex,true);

			if($this -> GetNumError() > 0){
				return false;
			}

			$debito = 0;
			$credito = abs($valor-$credito);
			$valor	 = $debito+$credito;
		}else{

			$debito  = 0;
			$credito = $valor;
		}



		$select = "SELECT puc_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id = $cuenta_tipo_pago";
		$result = $this -> DbFetchAll($select,$Conex,true);	

		$puc_contrapartida_id = $result[0]['puc_id'];

		if(is_numeric($anticipos_manifiesto_id)){
			$descripcion = "ANTICIPO $numero MANIFIESTO $numero_documento_fuente";
		}else{
			$descripcion = "ANTICIPO $numero DESPACHO $numero_documento_fuente";
		}

		$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);

		$pago_tercero=$forma_pago_tercero>0?$forma_pago_tercero:$tercero_id;
		if($utilidadesContables -> requiereTercero($puc_contrapartida_id,$Conex)){

			$select = "SELECT * FROM tercero WHERE tercero_id = $pago_tercero";
			$result = $this  -> DbFetchAll($select,$Conex,true);			   

			$tercero_imputacion_id            = $result[0]['tercero_id'];					 
			$numero_identificacion_imputacion = $result[0]['numero_identificacion'];					 
			$digito_verificacion_imputacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';					 					 

		}else{
			$tercero_imputacion_id            = 'NULL';					 
			$numero_identificacion_imputacion = 'NULL';					 
			$digito_verificacion_imputacion   = 'NULL';	
		}  					 

		if($utilidadesContables -> requiereCentroCosto($puc_contrapartida_id,$Conex)){
			$centro_de_costo_imputacion_id  = $centro_de_costo_id ;
			$codigo_centro_costo_imputacion = $codigo_centro_costo;
		}else{
			$centro_de_costo_imputacion_id  = 'NULL';
			$codigo_centro_costo_imputacion = 'NULL';					 
		}	

		$insert = "INSERT INTO imputacion_contable (
					imputacion_contable_id,
					tercero_id,
					numero_identificacion,
					digito_verificacion,
					puc_id,
					encabezado_registro_id,
					centro_de_costo_id,
					codigo_centro_costo,
					base,
					valor,
					debito,
					credito,
					descripcion) 
				VALUES (
					$imputacion_contable_id,
					$tercero_imputacion_id,
					$numero_identificacion_imputacion,
					$digito_verificacion_imputacion,
					$puc_contrapartida_id,
					$encabezado_registro_id,
					$centro_de_costo_imputacion_id,
					$codigo_centro_costo_imputacion,
					0,
					$valor,
					$debito,
					$credito,
					'$descripcion')";

		$this -> query($insert,$Conex,true);

		if($this -> GetNumError() > 0){
			return false;
		}	

		$fecha_egreso = date("Y-m-d H:i:s");	

		if(is_numeric($anticipos_manifiesto_id)){

			$update = "UPDATE anticipos_manifiesto SET encabezado_registro_id = $encabezado_registro_id,consecutivo = $consecutivo,fecha_egreso = '$fecha_egreso'
			WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id";
			$this -> query($update,$Conex,true);			  		

		}else{

			$update = "UPDATE anticipos_despacho SET encabezado_registro_id = $encabezado_registro_id,consecutivo = $consecutivo,fecha_egreso = '$fecha_egreso'
			WHERE anticipos_despacho_id = $anticipos_despacho_id";
			$this -> query($update,$Conex,true);			  	

		}

		$this -> Commit($Conex);
		$select = "SELECT * FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
		$result = $this -> DbFetchAll($select,$Conex,true);		
		$tipo_de_documento = $result[0]['nombre'];
		return array(encabezado_registro_id => $encabezado_registro_id,tipo_de_documento => $tipo_de_documento,consecutivo => $consecutivo,fecha_egreso => $fecha_egreso);
	}
  
	public function selectCuentasFormasPago($forma_pago_id,$Conex){

		$select = "SELECT cuenta_tipo_pago_id AS value,(SELECT nombre FROM puc WHERE puc_id = c.puc_id) AS text FROM cuenta_tipo_pago c 
		WHERE forma_pago_id = $forma_pago_id AND cuenta_tipo_pago_natu = 'C'";
		$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

	}

	public function selectTercerosFormasPago($forma_pago_id,$Conex){

		$select = "SELECT c.tercero_id  AS value,(SELECT CONCAT_WS(' ',numero_identificacion,'-',primer_nombre, segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM forma_pago_tercero  c 
		WHERE c.forma_pago_id = $forma_pago_id ";
		$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

	}

}



?>