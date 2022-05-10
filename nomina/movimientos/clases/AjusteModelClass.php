<?php

require_once("../../../framework/clases/DbClass.php");

require_once("../../../framework/clases/PermisosFormClass.php");

final class AjusteModel extends Db{

    private $Permisos;

    //DATOS FORMULARIO

    public function SetUsuarioId($usuario_id,$oficina_id){

        $this -> Permisos = new PermisosForm();

        $this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);

    }

    public function getPermiso($ActividadId,$Permiso,$Conex){

        return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);

    }

    //LLENAR FORMULARIO

    public function buscaliquidacionNovedadId($consecutivo_nom, $Conex){

        $select = "SELECT ln.liquidacion_novedad_id,CONCAT('LIQ. ',ln.consecutivo,' fecha: ',ln.fecha_inicial,'-',ln.fecha_final) AS descripcion 
                    FROM liquidacion_novedad ln 
                    WHERE ln.consecutivo_nom = $consecutivo_nom";

        $result = $this -> DbFetchAll($select,$Conex,true);

        return $result;

    }

    //VALIDACION DATOS

    public function validaDatos($liquidacion_novedad_id, $Conex){

        //valida liquidacion_novedad_id
        
        if ($liquidacion_novedad_id == '') {
            
            $result = [
                "result" => "false",
                "message" => "No ha seleccionado ninguna liquidacion."
            ];
            
        }else{
            
            $datos_liquidacion_novedad = $this -> getLiquidacionNovedad($liquidacion_novedad_id, $Conex);
            
            $fecha_inicial = $datos_liquidacion_novedad[0][fecha_inicial];
            $fecha_final = $datos_liquidacion_novedad[0][fecha_final];

            $contrato_id = $datos_liquidacion_novedad[0][contrato_id];
            
            $anio = $this -> getYearOfDate($fecha_final);

            

            //valida fechas

            $result = $this -> validDate($fecha_inicial, $fecha_final);
            
            //valida contrato
            
            $result = $this -> validaContrato($contrato_id, $fecha_inicial, $fecha_final, $Conex);
            
            //valida parametrizacion nomina
            
            $result = $this -> validaParametrizacionNomina($anio, $Conex);
            
        }

        return $result;

    }

    public function validaParametrizacionNomina($anio, $Conex){

        $parametrizacion_nomina = $this -> getParametrizacionNomina($anio, $Conex);

        if (count($parametrizacion_nomina) > 1  || count($parametrizacion_nomina) < 1) {
            
            $result = [
                "result" => "false",
                "message" => "Los registros en parametros de ley no son correctos."
            ];

        }

    }

    public function getLiquidacionNovedad($liquidacion_novedad_id, $Conex){

        $select = "SELECT * FROM liquidacion_novedad WHERE liquidacion_novedad_id = $liquidacion_novedad_id";

        $result = $this -> DbFetchAll($select, $Conex, true);
        
        return $result;

    }

    public function validDate($initial_date, $final_date){

        $result = [];

        $year_initial_date = $this -> getYearOfDate($initial_date);
        $year_final_date = $this -> getYearOfDate($final_date);

        $month_initial_date = $this -> getMonthOfDate($initial_date);
        $month_final_date = $this -> getMonthOfDate($final_date);

        $initial_date_integer = $this -> convertDateToInteger($initial_date);
        $final_date_integer = $this -> convertDateToInteger($final_date);

        if($year_initial_date != $year_final_date){

            $result = [
                "result" => "false",
                "message" => "Las fechas deben ser del mismo año."
            ];
        }elseif ($month_initial_date != $month_final_date) {
            
            $result = [
                "result" => "false",
                "message" => "Las fechas deben ser del mismo mes."
            ];
        }elseif ($initial_date_integer > $final_date_integer) {
            
            $result = [
                "result" => "false",
                "message" => "La fecha inicial no puede ser mayor a la fecha final."
            ];
        }else {
            $result = [
                "result" => "true",
                "message" => "La validación fue exitosa."
            ];
        }

        return $result;

    }

    protected function getMonthOfDate($date){

        $original_date = $date;
        $timestamp = strtotime($original_date); 
        $month = date("m", $timestamp );

        return $month;

    }

    protected function getCantDays($fecha_inicial, $fecha_final){
        
        $days = $this -> restaFechasCont($fecha_inicial, $fecha_final);
        
        return $days;

    }

    protected function convertDateToInteger($date){

        $timestamp = strtotime($date); 

        return $timestamp;

    }

    public function consultaContrato($contrato_id, $Conex){
        
        $select = "SELECT c.numero_contrato, c.fecha_terminacion, c.estado, CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) nombre_empleado
                FROM contrato c
                INNER JOIN empleado e ON c.empleado_id = e.empleado_id
                INNER JOIN tercero t ON e.tercero_id = t.tercero_id
                WHERE c.contrato_id = $contrato_id";

        $result = $this -> DbFetchAll($select, $Conex, true);

        return $result;

    }

    protected function validaContrato($contrato_id, $fecha_inicial, $fecha_final, $Conex){
          
        $consulta_contrato = $this -> consultaContrato($contrato_id, $Conex);
        
        $numero_contrato = $consulta_contrato[0][numero_contrato];
        $nombre_empleado = $consulta_contrato[0][nombre_empleado];
        $fecha_terminacion = $consulta_contrato[0][fecha_terminacion];
        $estado = $consulta_contrato[0][estado];

        $fecha_terminacion_to_integer = $this -> convertDateToInteger($fecha_terminacion);
        $fecha_final_to_integer = $this -> convertDateToInteger($fecha_terminacion);
        

        if ($fecha_terminacion != '' && $fecha_terminacion_to_integer <= $fecha_final_to_integer) {
            
            $result = [
                "result" => "false",
                "message" => 'No se puede ajustar la Nomina de este contrato, ya que este fue <strong>Terminado</strong>
                            <br><br>
                            <strong> N° Contrato: </strong>' . $numero_contrato . '<br>
                            <strong>Empleado:</strong> ' . $nombre_empleado . '<br>
                            <strong>Fecha terminacion:</strong> <b style="color:#ed121a">' . $fecha_terminacion. '</b>
                            <br><br>'
            ];
        }elseif ($estado != 'A') {

            switch ($estado) {
                case 'A':
                    $descripcion_estado = 'Activo';
                break;
                case 'R':
                    $descripcion_estado = 'Retirado';
                break;
                case 'F':
                    $descripcion_estado = 'Finalizado';
                break;
                case 'AN':
                    $descripcion_estado = 'Anulado';
                break;
            }

            $result = [
                "result" => "false",
                "message" => 'No se puede ajustar la Nomina de este contrato, ya que este se encuentra en estado <strong>'.$descripcion_estado.'</strong>.
                            <br><br>
                            <strong> N° Contrato: </strong>' . $numero_contrato . '<br>
                            <strong>Empleado:</strong> ' . $nombre_empleado . '<br>
                            <br><br>'
            ];
        }else {
            
            $result = [
                "result" => "true",
                "message" => "Validacion Exitosa"
            ];
        }

        return $result;

    }

    //SAVE 

    public function Save($liquidacion_novedad_id, $Conex){
        
        
            
            $this -> Begin($Conex);
            
            $datos_liquidacion_novedad = $this -> getLiquidacionNovedad($liquidacion_novedad_id, $Conex);
            
            $save_liquidacion_novedad = $this -> saveLiquidacionNovedad($datos_liquidacion_novedad, $Conex);
            
            $save_detalle_liquidacion_novedad = $this -> saveDetalleLiquidacionNovedad($datos_liquidacion_novedad, $Conex);

            $this -> Commit($Conex);

       
    }

    public function saveLiquidacionNovedad($datos_liquidacion_novedad, $Conex){

        $liquidacion_novedad_id = $this -> DbgetMaxConsecutive("liquidacion_novedad","liquidacion_novedad_id",$Conex,false,1);
        $consecutivo = $this -> DbgetMaxConsecutive("liquidacion_novedad","consecutivo",$Conex,false,1);

        $consecutivo_nom = 'null';
        $param_nom_electronica_id =  $datos_liquidacion_novedad[0][param_nom_electronica_id];
        $empleados = 'U'; //el ajuste de nomina se realiza individual
        $fecha_inicial = $datos_liquidacion_novedad[0][fecha_inicial];
        $fecha_final =  $datos_liquidacion_novedad[0][fecha_final];
        $periodicidad = $datos_liquidacion_novedad[0][periodicidad];
        $area_laboral = $datos_liquidacion_novedad[0][area_laboral];
        $estado = 'E'; 
        $contrato_id = $datos_liquidacion_novedad[0][contrato_id];
        $contrato_id = $datos_liquidacion_novedad[0][contrato_id];
        $usuario_id =  $datos_liquidacion_novedad[0][usuario_id];
        $fecha_registro = date("Y-m-d H:i:s");
        $centro_de_costo_id  = $datos_liquidacion_novedad[0][centro_de_costo_id];
        $liquidacion_novedad_ajustada = $datos_liquidacion_novedad[0][liquidacion_novedad_id];
        $tipo_liquidacion = 'AJ'; //identificador de ajuste nomina

    
        $insert = "INSERT INTO liquidacion_novedad (liquidacion_novedad_id, consecutivo, consecutivo_nom, param_nom_electronica_id, 
                    empleados, fecha_inicial, fecha_final, periodicidad, area_laboral, estado, contrato_id, usuario_id, fecha_registro, centro_de_costo_id, tipo_liquidacion)
                    VALUES ($liquidacion_novedad_id, $consecutivo, $consecutivo_nom, $param_nom_electronica_id, '$empleados', '$fecha_inicial', '$fecha_final', '$periodicidad',
                    '$area_laboral', '$estado', $contrato_id, $usuario_id, '$fecha_registro', $centro_de_costo_id, '$tipo_liquidacion')";

        $this -> query($insert,$Conex,true);

        $update = "UPDATE liquidacion_novedad SET nomina_ajustada = 1, liquidacion_novedad_id_ajuste = $liquidacion_novedad_id WHERE liquidacion_novedad_id = $liquidacion_novedad_ajustada";

        $this -> query($update,$Conex,true);

        

    	return $liquidacion_novedad_id;

	}


    public function saveDetalleLiquidacionNovedad($datos_liquidacion_novedad, $Conex){
        
        $fecha_inicial = $datos_liquidacion_novedad[0][fecha_inicial];

        $fecha_final = $datos_liquidacion_novedad[0][fecha_final];

        $contrato_id = $datos_liquidacion_novedad[0][contrato_id];
               
        $anio = $this -> getYearOfDate($fecha_final);
        
        
        $cantidad_dias = $this -> getCantDays($fecha_inicial, $fecha_final);
        
        
        
        //obtiene datos empleado
        
        $datos_empleado = $this -> getDatosEmpleado($fecha_inicial, $fecha_final, $contrato_id, $Conex);

        $area_laboral       =  $datos_empleado[0]['area_laboral']; 
        $contrato_id        =  $datos_empleado[0]['contrato_id'];
		$sueldo_base        =  $datos_empleado[0]['sueldo_base'];
		$subsidio_transporte=  $datos_empleado[0]['subsidio_transporte'];
		$ingreso_no_salarial =  $datos_empleado[0]['ingreso_nosalarial'];

		$tercero_id            =  $datos_empleado[0]['tercero_id'];
		$numero_identificacion =  $datos_empleado[0]['numero_identificacion'];
		$digito_verificacion   =  $datos_empleado[0]['digito_verificacion']!='' ? $datos_empleado[0]['digito_verificacion'] : 'NULL';		

		$tercero_eps_id            =  $datos_empleado[0]['tercero_eps_id'];
		$numero_identificacion_eps =  $datos_empleado[0]['numero_identificacion_eps'];
		$digito_verificacion_eps   =  $datos_empleado[0]['digito_verificacion_eps']!='' ? $datos_empleado[0]['digito_verificacion_eps'] : 'NULL';		

		$tercero_pension_id            =  $datos_empleado[0]['tercero_pension_id'];
		$numero_identificacion_pension =  $datos_empleado[0]['numero_identificacion_pension'];
		$digito_verificacion_pension   =  $datos_empleado[0]['digito_verificacion_pension']!='' ? $datos_empleado[0]['digito_verificacion_pension'] : 'NULL';	
        
        $dias_descontar_inicio_contrato = $datos_empleado[0]['dias_descontar_inicio_contrato'];

        $prestaciones_sociales = $datos_empleado[0]['prestaciones_sociales'];

        
        //obtiene parametrizacion nomina
        
        $parametrizacion_nomina = $this -> getParametrizacionNomina($anio, $Conex);
        
        $limite_subsidio            = $parametrizacion_nomina[0]['limite_subsidio'];
        $limite_fondo	            = $parametrizacion_nomina[0]['limite_fondo'];
        $salario			            = $parametrizacion_nomina[0]['salrio'];
        $salario_minimo_diario      = intval($parametrizacion_nomina[0]['salrio']/30);
        $limite_salario 	            = $salario*$limite_subsidio;
        $limite_fondopen            = $salario*$limite_fondo;
        $horas_dia		            = $parametrizacion_nomina[0]['horas_dia'];
        $val_hr_ext_diurna          = $parametrizacion_nomina[0]['val_hr_ext_diurna'];	
        $val_hr_ext_nocturna        = $parametrizacion_nomina[0]['val_hr_ext_nocturna'];	
        $val_hr_ext_festiva_diurna  = $parametrizacion_nomina[0]['val_hr_ext_festiva_diurna'];	
        $val_hr_ext_festiva_nocturna= $parametrizacion_nomina[0]['val_hr_ext_festiva_nocturna'];	
        $val_recargo_nocturna       = $parametrizacion_nomina[0]['val_recargo_nocturna'];
        $descuento_empleado_salud       = $parametrizacion_nomina[0]['desc_emple_salud'];

        switch ($area_laboral) {

            case 'A':
                
                $puc_sal   = $parametrizacion_nomina[0]['puc_admon_sal_id'];
                $puc_sub   = $parametrizacion_nomina[0]['puc_admon_trans_id'];
                $puc_nos   = $parametrizacion_nomina[0]['puc_admon_nos_id'];
                $puc_salud = $parametrizacion_nomina[0]['puc_contra_salud_id'];
                $puc_pens  = $parametrizacion_nomina[0]['puc_contra_pension_id'];
                $puc_penfon= $parametrizacion_nomina[0]['puc_contra_fonpension_id'];

                $puc_extradiu= $parametrizacion_nomina[0]['puc_admon_extradiu_id'];
                $puc_extranoc= $parametrizacion_nomina[0]['puc_admon_extranoc_id'];			
                $puc_fesdiu  = $parametrizacion_nomina[0]['puc_admon_fesdiu_id'];			
                $puc_fesnoc  = $parametrizacion_nomina[0]['puc_admon_fesnoc_id'];
                $puc_recnoc  = $parametrizacion_nomina[0]['puc_admon_recnoc_id'];	

                break;

            case 'O':
                
                $puc_sal    = $parametrizacion_nomina[0]['puc_produ_sal_id'];
                $puc_sub    = $parametrizacion_nomina[0]['puc_produ_trans_id'];
                $puc_nos    = $parametrizacion_nomina[0]['puc_produ_nos_id'];
                $puc_salud  = $parametrizacion_nomina[0]['puc_contra_salud_id'];
                $puc_pens   = $parametrizacion_nomina[0]['puc_contra_pension_id'];
                $puc_penfon = $parametrizacion_nomina[0]['puc_contra_fonpension_id'];			

                $puc_extradiu= $parametrizacion_nomina[0]['puc_produ_extradiu_id'];
                $puc_extranoc= $parametrizacion_nomina[0]['puc_produ_extranoc_id'];			
                $puc_fesdiu  = $parametrizacion_nomina[0]['puc_produ_fesdiu_id'];			
                $puc_fesnoc  = $parametrizacion_nomina[0]['puc_produ_fesnoc_id'];						
                $puc_recnoc  = $parametrizacion_nomina[0]['puc_produ_recnoc_id'];	

                break;
            
            case 'C':
                
                $puc_sal   = $parametrizacion_nomina[0]['puc_ventas_sal_id'];
                $puc_sub   = $parametrizacion_nomina[0]['puc_ventas_trans_id'];
                $puc_nos   = $parametrizacion_nomina[0]['puc_ventas_nos_id'];
                $puc_salud = $parametrizacion_nomina[0]['puc_contra_salud_id'];
                $puc_pens  = $parametrizacion_nomina[0]['puc_contra_pension_id'];
                $puc_penfon= $parametrizacion_nomina[0]['puc_contra_fonpension_id'];			

                $puc_extradiu= $parametrizacion_nomina[0]['puc_ventas_extradiu_id'];
                $puc_extranoc= $parametrizacion_nomina[0]['puc_ventas_extranoc_id'];			
                $puc_fesdiu  = $parametrizacion_nomina[0]['puc_ventas_fesdiu_id'];			
                $puc_fesnoc  = $parametrizacion_nomina[0]['puc_ventas_fesnoc_id'];						
                $puc_recnoc  = $parametrizacion_nomina[0]['puc_ventas_recnoc_id'];

                break;

            default:
                
                $puc_sal     ='';
                $puc_sub     ='';
                $puc_nos     ='';
                $puc_salud   ='';
                $puc_pens    ='';
                $puc_penfon  ='';

                $puc_extradiu='';
                $puc_extranoc='';			
                $puc_fesdiu  ='';			
                $puc_fesnoc  ='';						
                $puc_recnoc  ='';		

                exit('No Ha parametrizado Area para el contrato No '.$result[$i]['numero_contrato']);

                break;
        }

        $puc_sueldo_pagar = $parametrizacion_nomina[0]['puc_contra_sal_id'];
		$puc_nosalarial   = $parametrizacion_nomina[0]['puc_contra_nos_id'];


        // ********* establece valores pertinentes para liquidar el salario *********

        
        //licencias

        $dias_remunerados = $this -> getDiasLicencia($fecha_inicial, $fecha_final, $contrato_id, "remunerado", $Conex);
        
        $arreglo_licencia_id_remunerado = $this -> getLicenciaId($fecha_inicial, $fecha_final, $contrato_id, "remunerado", $Conex);


        $dias_no_remunerados = $this -> getDiasLicencia($fecha_inicial, $fecha_final, $contrato_id, "no_remunerado", $Conex);
        
        $arreglo_licencia_id_no_remunerado = $this -> getLicenciaId($fecha_inicial, $fecha_final, $contrato_id, "no_remunerado", $Conex);

        
        //vacaciones

        $get_dias_vacaciones = $this -> getDiasVacaciones($fecha_inicial, $fecha_final, $contrato_id, $Conex);

		$dias_vacaciones = $get_dias_vacaciones[0]['diferencia'] > 0 ? ($get_dias_vacaciones[0]['diferencia']) : 0;

		$dias_vacaciones = ($dias_vacaciones == 29) ? ($dias_vacaciones + 1) : $dias_vacaciones;


        //incapacidades

        //revisar dias incapacidad para su posterior calculo en caso de que tenga un descuento y aplique un porcentaje.

        $datos_incapacidad = $this -> getIncapacidad($fecha_inicial, $fecha_final, $contrato_id, $Conex);


        $dias_incapacidad = 0;
        $dias_resta_subsidio_transporte = 0;
        $diferencia_dias_incapacidad = 0;
        $salario_dia = intval($sueldo_base / 30);
        $descuento_saldo_incapacidad  = 0;

        $array_licencia = array();
        $licencia_id = '';


        for($cont_incapacidad = 0; $cont_incapacidad < count($datos_incapacidad); $cont_incapacidad++){

            $dias_incapacidad = $datos_incapacidad[$cont_incapacidad]['dias_incapacidad'];
            $dias_pago_empleador = $datos_incapacidad[$cont_incapacidad]['dias_pago_empleador'];
            $descuento = $datos_incapacidad[$cont_incapacidad]['descuento'];
            $porcentaje = $datos_incapacidad[$cont_incapacidad]['porcentaje'];

            if($dias_incapacidad >= $dias_pago_empleador && $descuento == 'S'){

                $diferencia_dias_incapacidad = (($dias_incapacidad - $dias_pago_empleador) + 1);

                $saldo_descuento_dia = intval(($salario_dia * $porcentaje) / 100);

                $porcentaje_descuento = (100 - $porcentaje);

                if($saldo_descuento_dia > $salario_minimo_diario){ //valida que el descuento no sea mayor al salario minimo

                    $operacion = intval((($salario_dia * $diferencia_dias_incapacidad) * $porcentaje_descuento) / 100);

                    $descuento_saldo_incapacidad = $descuento_saldo_incapacidad + $operacion;

                }else{

                    $operacion = intval(($salario_dia - $salario_minimo_diario) * $diferencia_dias_incapacidad);

                    $descuento_saldo_incapacidad = $descuento_saldo_incapacidad + $operacion;

                } 

            }

            $dias_resta_subsidio_transporte = $dias_resta_subsidio_transporte + $dias_incapacidad;//añade los días a restar a el subsidio de transporte.



            $array_licencia[] = array(

                "licencia_id" 		=>	$datos_incapacidad[$cont_incapacidad]['licencia_id'],

                "valorDescuento" 	=>	$operacion,

                "diasIncapacidad"	=>	$dias_incapacidad,

                "fecha_inicial"		=>	$datos_incapacidad[$cont_incapacidad]['fecha_inicial'], 

                "fecha_final"		=>	$datos_incapacidad[$cont_incapacidad]['fecha_final']

            );

        }



        $dias_subsidio_transporte = $dias_subsidio_transporte - $dias_resta_subsidio_transporte; //resta los dias incapacidad al subsidio

        $dias_liquidacion = $dias_liquidacion - $dias_resta_subsidio_transporte; //resta los dias incapacidad a los dias


        
        //establece dias de liquidacion

		if($cantidad_dias <= $dias_no_remunerados){ // todo el periodo en licencia no remunerada, no hay dias de pago

			$dias_liquidacion     = 0;
			$dias_subsidio_transporte = 0;

		}elseif($cantidad_dias <= $dias_remunerados){ //todo el periodo en licencia remunerada, no hay subsidio y resta dias de diferencia en contrato, no remunerado y vacaciones

			$dias_liquidacion     = $cantidad_dias - $dias_vacaciones - $dias_descontar_inicio_contrato - $dias_no_remunerados;
			$dias_subsidio_transporte = 0;

		}else{ //La mas comun a la cantidad de dias resta vacaciones, diferencia entre contrato , dias no remunerados, dias remunerados

			$dias_liquidacion = $cantidad_dias - $dias_vacaciones - $dias_descontar_inicio_contrato - $dias_no_remunerados - $dias_remunerados;
			$dias_subsidio_transporte = $cantidad_dias - $dias_vacaciones - $dias_descontar_inicio_contrato - $dias_no_remunerados - $dias_remunerados;

		}

        //*********** liquida detalle salario **********

		$debito = intval($salario_dia * $dias_liquidacion);		

		$credito = 0;

		$deb_total = $deb_total + $debito;

		$cre_total = $cre_total + $credito;

		$dias_salario = $dias_subsidio_transporte;


        $detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);


		$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

		VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias_sal,'$observacion','SALARIO',$tercero_id,$numero_identificacion,$digito_verificacion)";

		//$this -> query($insert,$Conex,true);


        // ********** liquida detalle incapacidades **********

		$debito   = intval(($dias_resta_subsidio_transporte * $salario_dia) - $descuento_saldo_incapacidad);	
		$credito  = 0;
		$deb_total= $deb_total + $debito;
		$cre_total= $cre_total + $credito;

		if($dias_inca_sub>0){

			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

			VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$dias_inca_sub,'$observacion','INCAPACIDADES',$tercero_id,$numero_identificacion,$digito_verificacion)";

			//$this -> query($insert,$Conex,true);

			for ($inc=0; $inc < count($array_licencia); $inc++) { 

				$valor_liquida = intval(($array_licencia[$inc][diasIncapacidad]*$sal_dia_cont)-$array_licencia[$inc][valorDescuento]);
				$licencia_id = $array_licencia[$inc][licencia_id];
				$dias_incapacidad = $array_licencia[$inc][diasIncapacidad];
				$fechaInicialIncapacidad = $array_licencia[$inc][fecha_inicial];
				$fechaFinalIncapacidad = $array_licencia[$inc][fecha_final];

				$insert = "INSERT INTO detalle_liquidacion_licencia (detalle_liquidacion_novedad_id,licencia_id,fecha_inicial,fecha_final,dias_liquida,valor_liquida) 
                
                VALUES ($detalle_liquidacion_novedad_id,$licencia_id,'$fechaInicialIncapacidad','$fechaFinalIncapacidad',$dias_incapacidad,$valor_liquida)";

                //$this -> query($insert,$Conex,true);

			}
		}


        // ********** liquida detalle licencias **********

        $datos_licencia = $this -> getDatosLicencia($fecha_inicial, $fecha_final, $contrato_id, $Conex);


		$debito   = intval($dias_remunerados * $salario_dia);	
		$credito  = 0;
		$deb_total= $deb_total + $debito;
		$cre_total= $cre_total + $credito;
	

		if($dias_remunerados > 0){

			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

			VALUES ($detalle_liquidacion_novedad_id,$puc_sal,$liquidacion_novedad_id, $debito,$credito,'$fecha_inicial','$fecha_final',$diasRe,'$observacion','LICENCIAS',$tercero_id,$numero_identificacion,$digito_verificacion)";

			$this -> query($insert,$Conex,true);


			for ($lic=0; $lic < count($datos_licencia); $lic++) { 

				$valor_liquida  =   intval($datos_licencia[$lic][dias_licencia]*$sal_dia_cont);

				$licencia_id    =   $datos_licencia[$lic][licencia_id];

				$dias_licencia  =   $datos_licencia[$lic][dias_licencia];

				$fechaInicialLicencia   =   $datos_licencia[$lic][fecha_inicial];

				$fechaFinalLicencia =   $datos_licencia[$lic][fecha_final];


				$insert = "INSERT INTO detalle_liquidacion_licencia (detalle_liquidacion_novedad_id,licencia_id,fecha_inicial,fecha_final,dias_liquida,valor_liquida) VALUES ($detalle_liquidacion_novedad_id,$licencia_id,'$fechaInicialLicencia','$fechaFinalLicencia',$dias_licencia,$valor_liquida)";

				$this -> query($insert,$Conex,true);

			}
		}


        // ********** liquida detalle auxilio transporte **********

        if($sueldo_base <= $limite_salario){

			$debito    = intval(($subsidio_transporte / 30) * $dias_subsidio_transporte);

			$credito   = 0;

			$deb_total = $deb_total + $debito;

			$cre_total = $cre_total + $credito;

			

			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

			VALUES ($detalle_liquidacion_novedad_id,$puc_sub,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias_sub,'$observacion','AUX TRANSPORTE',$tercero_id,$numero_identificacion,$digito_verificacion)";

			$this -> query($insert, $Conex, true);

		}


        // ********** liquida detalle ingresos no salariales **********

        if($ingreso_no_salarial > 0){

			$debito    = intval(($ingreso_no_salarial / 30) * $dias_liquidacion);

			$credito   = 0;

			$deb_total = $deb_total + $debito;

			$cre_total = $cre_total + $credito;


			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

			VALUES ($detalle_liquidacion_novedad_id,$puc_nos,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias_sub,'$observacion','INGRESO NO SALARIAL',$tercero_id,$numero_identificacion,$digito_verificacion)";

			$this -> query($insert, $Conex, true);

		}


        // ********** liquida detalle prestaciones sociales (salud, pension, retencion, fondo pensional)


        if($prestaciones_sociales == 1){

			//sumatoria novedades devengadas

			$selectdeve = "SELECT  SUM(n.valor_cuota) AS valor_deven
                        FROM novedad_fija n, concepto_area c
                        WHERE n.contrato_id=$contrato_id AND n.tipo_novedad='V'  AND n.estado='A' AND '$fecha_final' BETWEEN  n.fecha_inicial AND n.fecha_final AND c.concepto_area_id=n.concepto_area_id AND c.base_salarial='SI'";

			$resultdeve = $this -> DbFetchAll($selectdeve,$Conex,true);

			$valor_deven = $resultdeve[0]['valor_deven']>0 ? $resultdeve[0]['valor_deven'] : 0;

			

			$selectext = "SELECT  
					h.vr_horas_diurnas AS valor_diurnas,
					h.vr_horas_nocturnas AS valor_nocturnas,
					h.vr_horas_diurnas_fes AS valor_diurnas_fes,
					h.vr_horas_nocturnas_fes AS valor_nocturnas_fes,
					h.vr_horas_recargo_noc AS valor_recargo_noc
					FROM 	hora_extra h
					WHERE h.contrato_id=$contrato_id AND h.estado='P' AND h.fecha_inicial>='$fecha_inicial' AND h.fecha_final<='$fecha_final' ";	



			$resultext           = $this -> DbFetchAll($selectext,$Conex,true); 

			$valor_diurnas       = $resultext[0]['valor_diurnas']>0 ? $resultext[0]['valor_diurnas'] : 0;

			$valor_nocturnas     = $resultext[0]['valor_nocturnas']>0 ? $resultext[0]['valor_nocturnas'] : 0;			

			$valor_diurnas_fes   = $resultext[0]['valor_diurnas_fes']>0 ? $resultext[0]['valor_diurnas_fes'] : 0;

			$valor_nocturnas_fes = $resultext[0]['valor_nocturnas_fes']>0 ? $resultext[0]['valor_nocturnas_fes'] : 0;			

			$valor_recargo_noc   = $resultext[0]['valor_recargo_noc']>0 ? $resultext[0]['valor_recargo_noc'] : 0;			

			

			$total_base=$valor_deven+$valor_diurnas+$valor_nocturnas+$valor_diurnas_fes+$valor_nocturnas_fes+$valor_recargo_noc-$des_val_inc;		

			

			/* //Liquidacion Retenciones

			$selectext = "SELECT  

					lr.ingreso_gravado,

					lr.uvt

					

					FROM 	liquidacion_retencion lr

					WHERE lr.contrato_id=$contrato_id AND lr.estado='L' AND lr.fecha_inicial>='$fecha_inicial' AND lr.fecha_final<='$fecha_final' ";	



			$resultext           = $this -> DbFetchAll($selectext,$Conex,true); 

			$ingreso_gravado     = $resultext[0]['ingreso_gravado']>0 ? $resultext[0]['ingreso_gravado'] : 0;

			$uvt     			 = $resultext[0]['uvt']>0 ? $resultext[0]['uvt'] : 0;			

			$valor_retencion = ($ingreso_gravado*$uvt);		

			

			$total_base=$total_base+$valor_retencion;	 */	

			

			//salud



			$debito    = 0;

			$credito   = intval((intval(($salario_dia * ($dias_liquidacion + $dias_remunerados)) + $total_base) * $descuento_empleado_salud) / 100);

			$deb_total = $deb_total + $debito;

			$cre_total = $cre_total + $credito;

			

			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

			VALUES ($detalle_liquidacion_novedad_id,$puc_salud,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','SALUD',$tercero_eps_id,$numero_identificacion_eps,$digito_verificacion_eps)";

			$this -> query($insert,$Conex,true);

	

			//pension

			$debito=0;

			$credito=intval((intval(((($sueldo_base)/30)*($dias+$diasRe))+$total_base)*$result_per[0]['desc_emple_pension'])/100);

			$deb_total=$deb_total+$debito;

			$cre_total=$cre_total+$credito;

			

			$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

			$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

			VALUES ($detalle_liquidacion_novedad_id,$puc_pens,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','PENSION',$tercero_pension_id,$numero_identificacion_pension,$digito_verificacion_pension)";

			$this -> query($insert,$Conex,true);

			

			

			//fondo pensional

			$rango_salario=intval($sueldo_base/$salrio);

			$selectfondo = "SELECT  f.porcentaje,f.rango_ini,f.rango_fin

					FROM 	fondo_pensional f

					WHERE f.periodo_contable_id = (SELECT p.periodo_contable_id FROM periodo_contable p WHERE anio=$anio) AND '$rango_salario' BETWEEN rango_ini AND rango_fin  ";

			$resultfondo = $this -> DbFetchAll($selectfondo,$Conex,true); 

			$porcen_fondo=$resultfondo[0]['porcentaje'];

			if($porcen_fondo>0){



				$debito    = 0;

				$credito   = intval((intval((($sueldo_base/30)*$dias)+$total_base)*$porcen_fondo)/100);

				$deb_total = $deb_total+$debito;

				$cre_total = $cre_total+$credito;

				

				$detalle_liquidacion_novedad_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_novedad","detalle_liquidacion_novedad_id",$Conex,false,1);

				$insert = "INSERT INTO 	detalle_liquidacion_novedad (detalle_liquidacion_novedad_id,puc_id,liquidacion_novedad_id,debito,credito,fecha_inicial,fecha_final,dias,observacion,concepto,tercero_id,numero_identificacion,digito_verificacion) 

				VALUES ($detalle_liquidacion_novedad_id,$puc_penfon,$liquidacion_novedad_id,$debito,$credito,'$fecha_inicial','$fecha_final',$dias,'$observacion','FONDO PENSIONAL',$tercero_pension_id,$numero_identificacion_pension,$digito_verificacion_pension)";

				$this -> query($insert,$Conex,true);



			}

		}


        exit("dias_liquidacion: ".$dias_liquidacion."<br>dias_subsidio_transporte: ".$dias_subsidio_transporte."<br>cantidad_dias: ".$cantidad_dias."<br>diasNoRe: ".$dias_no_remunerados."<br>diasRe: ".$dias_remunerados."<br>debito: ".$deb_total."<br>credito: ".$cre_total."<br>salario_dia: ".$salario_dia);

    }

    public function getDatosLicencia($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT (DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1) AS dias_licencia,l.licencia_id,
                IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial') fecha_inicial,IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final) fecha_final

                FROM licencia l, tipo_incapacidad ti 
                WHERE  l.contrato_id=$contrato_id AND l.estado!='I' AND ti.tipo_incapacidad_id=l.tipo_incapacidad_id AND ti.tipo='L'  
                    AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final') ";

		$result  = $this -> DbFetchAll($select, $Conex, true); 

        return $result;
    }

    public function getIncapacidad($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT (DATEDIFF(IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final),IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial'))+1) AS dias_incapacidad, 
                ti.dia AS dias_pago_empleador, ti.porcentaje AS porcentaje_pago_empleador, ti.descuento,l.licencia_id,
                IF(l.fecha_inicial>'$fecha_inicial',l.fecha_inicial,'$fecha_inicial') fecha_inicial,
                IF(l.fecha_final>'$fecha_final','$fecha_final',l.fecha_final) fecha_final 

                FROM licencia l
                INNER JOIN tipo_incapacidad ti  ON ti.tipo_incapacidad_id=l.tipo_incapacidad_id 
                WHERE l.contrato_id=$contrato_id 
                    AND l.estado!='I' AND ti.tipo='I'  
                    AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final 
                    OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final 
                    OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final')";

        $result  = $this -> DbFetchAll($select, $Conex, true); 

        return $result;

    }

    public function getDiasVacaciones($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT  
                    SUM(DATEDIFF(IF(fecha_reintegro>'$fecha_final','$fecha_final',fecha_reintegro),IF(fecha_dis_inicio>'$fecha_inicial',fecha_dis_inicio,'$fecha_inicial'))) AS diferencia
                    FROM 	liquidacion_vacaciones c
                    WHERE c.estado = 'C' AND c.contrato_id=$contrato_id AND inicial=0 AND (('$fecha_inicial' BETWEEN  fecha_dis_inicio 
                        AND fecha_reintegro OR '$fecha_final' BETWEEN  fecha_dis_inicio AND fecha_reintegro) OR ('$fecha_inicial' < fecha_dis_inicio 
                        AND fecha_reintegro < '$fecha_final'))";

		

		$result = $this -> DbFetchAll($select,$Conex,true);

        return $result;

    }

    public function getDatosEmpleado($fecha_inicial, $fecha_final, $contrato_id, $Conex){

            $select = "SELECT  c.*, tc.prestaciones_sociales, tc.salud,tc.pension,

                    IF(c.fecha_inicio BETWEEN '$fecha_inicial'  AND '$fecha_final',DATEDIFF(CONCAT_WS(' ',c.fecha_inicio,'23:59:59'),'$fecha_inicial'),0) AS dias_descontar_inicio_contrato,
                    (SELECT e.tercero_id  FROM empresa_prestaciones e WHERE e.empresa_id=c.empresa_eps_id ) AS tercero_eps_id,	
                    (SELECT t.numero_identificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id) AS numero_identificacion_eps,
                    (SELECT t.digito_verificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_eps_id AND t.tercero_id=e.tercero_id) AS digito_verificacion_eps,			
                    (SELECT e.tercero_id  FROM empresa_prestaciones e WHERE e.empresa_id=c.empresa_pension_id ) AS tercero_pension_id,	
                    (SELECT t.numero_identificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id) AS numero_identificacion_pension,
                    (SELECT t.digito_verificacion  FROM empresa_prestaciones e, tercero t WHERE e.empresa_id=c.empresa_pension_id AND t.tercero_id=e.tercero_id) AS digito_verificacion_pension		

                FROM contrato c
                INNER JOIN tipo_contrato tc ON c.tipo_contrato_id = tc.tipo_contrato_id
                INNER JOIN empleado e ON c.empleado_id = e.empleado_id
                INNER JOIN tercero t ON e.tercero_id = t.tercero_id

                WHERE c.estado='A' AND (tc.prestaciones_sociales=1 OR (tc.salud=1 AND tc.prestaciones_sociales=0)) AND c.fecha_inicio <= '$fecha_final'
                    AND c.contrato_id = $contrato_id";

	    $result = $this -> DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getLicenciaId($fecha_inicial, $fecha_final, $contrato_id, $tipo, $Conex){

        $arreglo_licencia_id = [];


        if ($tipo == "remunerado") {
            
            $fechas_licencia_por_contrato = $this -> getLicenciaIdRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex);

        }elseif ($tipo == "no_remunerado") {
            
            $fechas_licencia_por_contrato = $this -> getLicenciaIdNoRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex);
        }
        

        for ($contLicencia = 0; $contLicencia < count($fechas_licencia_por_contrato); $contLicencia++) { 
            
            array_push($arreglo_licencia_id, $fechas_licencia_por_contrato[$contLicencia]);

        }

        return $arreglo_licencia_id;

    }

    public function getDiasLicencia($fecha_inicial, $fecha_final, $contrato_id, $tipo, $Conex){
        
        if ($tipo == "remunerado") {
            
            $fechas_licencia_por_contrato = $this -> FechasLicenciaRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex);

        }elseif ($tipo == "no_remunerado") {
            
            $fechas_licencia_por_contrato = $this -> FechasLicenciaNoRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex);
        }

        $fechas_agrupa = $this -> groupArrayDias($fechas_licencia_por_contrato, 'contrato_id');
        
        $array_dias_licencia = $this -> calculaDiasEntreFechas($fechas_agrupa);
        
        $result = ($array_dias_licencia[0][dias] == '') ? 0 : $array_dias_licencia[0][dias];

        return $result;

    }


    protected function calculaDiasEntreFechas($fechas_agrupa){

        $arrayDias = [];
        $contador = 0;

        for ($i = 0; $i < count($fechas_agrupa); $i++) {

            $countDias = 0;//se inicializa dias

            for ($j = 0; $j < count($fechas_agrupa[$i]['groupeddata']); $j++) {

            
                $countDias += $this->restaFechasCont($fechas_agrupa[$i]['groupeddata'][$j]['fecha_inicial'],$fechas_agrupa[$i]['groupeddata'][$j]['fecha_final']);//Se acumulan la cantidad dias restados de los respectivas licencias por separado

                $contrato_id_array = $fechas_agrupa[$i]['contrato_id'];//Se le agrega el contrato ID en el Array para diferenciar los dias
                
            }

            if($return[$i]['contrato_id']==230){
                $countDias=$countDias+1;
            }
           
            $arrayDias[$contador]['dias']       =$countDias;//Aqui se Alimentan los Dias
            $arrayDias[$contador]['contrato_id']=$contrato_id_array;//Aqui se Alimentan los Contratos
            $contador ++;
            
        }
        
        return $arrayDias;
        
    }

    protected function groupArrayDias($array, $groupkey){
	   
		$contador = 0;//se inicializa un contador	
		if (count($array) > 0) {
            $keys = array_keys($array[0]);
            $removekey = array_search($groupkey, $keys);if ($removekey === false) {
                return array("Clave \"$groupkey\" no existe");
            } else {
                unset($keys[$removekey]);
            }

            $groupcriteria = array();
            $return = array();
            foreach ($array as $value) {
                $item = null;
                foreach ($keys as $key) {
                    $item[$key] = $value[$key];
                }
                $busca = array_search($value[$groupkey], $groupcriteria);
                if ($busca === false) {
                    $groupcriteria[] = $value[$groupkey];
                    $return[] = array($groupkey => $value[$groupkey], 'groupeddata' => array());
                    $busca = count($return) - 1;
                }
                $return[$busca]['groupeddata'][] = $item;
            }
			
            return $return;

        } else {
            return array();
        }

    }
    

    

    public function FechasLicenciaRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT l.fecha_inicial, l.fecha_final, c.contrato_id 
        FROM licencia l
        INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
        INNER JOIN contrato c ON l.contrato_id = c.contrato_id
        WHERE
        l.remunerado=1  AND l.estado!='I' AND ti.tipo='L' AND c.contrato_id = $contrato_id
        AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final')"; 

        $result = $this->DbFetchAll($select,$Conex,true);

        return $result;

    }

    public function FechasLicenciaNoRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT l.fecha_inicial, l.fecha_final, c.contrato_id 
        FROM licencia l
        INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
        INNER JOIN contrato c ON l.contrato_id = c.contrato_id
        WHERE
        l.remunerado=1  AND l.estado!='I' AND ti.tipo='L' AND c.contrato_id = $contrato_id
        AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final')"; 


        $result = $this->DbFetchAll($select,$Conex,true);

        return $result;

    }

    public function getLicenciaIdRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT l.licencia_id 
        FROM licencia l
        INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
        INNER JOIN contrato c ON l.contrato_id = c.contrato_id
        WHERE
        l.remunerado=1  AND l.estado!='I' AND ti.tipo='L' AND c.contrato_id = $contrato_id
        AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final')";

        $result = $this->DbFetchAll($select,$Conex,true);

        return $result;

    }

    public function getLicenciaIdNoRemunerada($fecha_inicial, $fecha_final, $contrato_id, $Conex){

        $select = "SELECT l.licencia_id 
        FROM licencia l
        INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
        INNER JOIN contrato c ON l.contrato_id = c.contrato_id
        WHERE
        l.remunerado=0  AND l.estado!='I' AND ti.tipo='L' AND c.contrato_id = $contrato_id
        AND ('$fecha_inicial' BETWEEN  l.fecha_inicial AND l.fecha_final OR '$fecha_final'  BETWEEN  l.fecha_inicial AND l.fecha_final OR l.fecha_inicial BETWEEN '$fecha_inicial' AND '$fecha_final')";

        $result = $this->DbFetchAll($select,$Conex,true);

        return $result;

    }

    public function GetCosto($Conex){

		return $this -> DbFetchAll("SELECT centro_de_costo_id  AS value, nombre AS text FROM centro_de_costo ORDER BY nombre ASC",$Conex,

		$ErrDb = false);

	}
    

    public function getYearOfDate($date){

        $timestamp = strtotime($date); 
        $year = date("Y", $timestamp );
        
        return $year;

    }

    public function getParametrizacionNomina($anio, $Conex){

        $select = "SELECT * FROM datos_periodo dp
                    INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
                    WHERE pc.anio = $anio";

	    $result = $this -> DbFetchAll($select, $Conex, true);

        return $result;

    }
    

    //BUSQUEDA

    public function selectLiquidacion($liquidacion_novedad_id,$Conex){

        $select = "SELECT ln.*,CONCAT_WS(' ',c.numero_contrato,'-',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS contrato
        FROM liquidacion_novedad ln
        INNER JOIN contrato c ON ln.contrato_id = c.contrato_id
        INNER JOIN empleado e ON c.empleado_id = e.empleado_id
        INNER JOIN tercero t ON e.tercero_id = t.tercero_id
        WHERE ln.liquidacion_novedad_id = $liquidacion_novedad_id AND reportado = 1";

        $result = $this -> DbFetchAll($select,$Conex,true);

        return $result;

    }


}

?>