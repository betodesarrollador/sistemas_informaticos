<?php

require_once "../../../framework/clases/ControlerClass.php";

final class LiquidacionFinal extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "LiquidacionFinalLayoutClass.php";
        require_once "LiquidacionFinalModelClass.php";

        $Layout = new LiquidacionFinalLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new LiquidacionFinalModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->SetGuardar($Model->getPermiso($this->getActividadId(), INSERT, $this->getConex()));
        $Layout->SetActualizar($Model->getPermiso($this->getActividadId(), UPDATE, $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));
        $Layout->setAnular($Model->getPermiso($this->getActividadId(), 'ANULAR', $this->getConex()));
        $Layout->SetLimpiar($Model->getPermiso($this->getActividadId(), CLEAR, $this->getConex()));

        $Layout->SetCampos($this->Campos);

        //// LISTAS MENU ////
        $Layout->SetMotivoTer($Model->GetMotivoTer($this->getConex()));
        $Layout->SetCausalDes($Model->GetCausalDes($this->getConex()));
        $Layout->setCausalesAnulacion($Model->getCausalesAnulacion($this->getConex()));

        $Layout->RenderMain();

    }
    
    protected function showGrid(){
	  
        require_once "LiquidacionFinalLayoutClass.php";
        require_once "LiquidacionFinalModelClass.php";

        $Layout = new LiquidacionFinalLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new LiquidacionFinalModel();
          
         //// GRID ////
         $Attributes = array(
            id => 'liquidacion_definitiva',
            title => 'Listado de Liquidacion Nomina',
            sortname => 'liquidacion_definitiva_id',
            width => 'auto',
            height => '200',
        );

        $Cols = array(
            array(name => 'liquidacion_definitiva_id', index => 'liquidacion_definitiva_id', sorttype => 'text', width => '130', align => 'center'),
            array(name => 'fecha_inicio', index => 'fecha_inicio', sorttype => 'text', width => '130', align => 'center'),
            array(name => 'fecha_final', index => 'fecha_final', sorttype => 'text', width => '130', align => 'center'),
            array(name => 'contrato', index => 'contrato', sorttype => 'text', width => '300', align => 'left'),
            array(name => 'documento', index => 'documento', sorttype => 'text', width => '100', align => 'left'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '150', align => 'center'),
        );

        $Titles = array('LIQ No',
            'FECHA INICIAL',
            'FECHA FINAL',
            'CONTRATO',
            'DOCUMENTO',
            'ESTADO',
        );

        $html = $Layout->SetGridLiquidacionFinal($Attributes, $Titles, $Cols, $Model->GetQueryLiquidacionFinalGrid());
         
         print $html;
          
      }

    protected function onclickValidateRow()
    {
        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();
        echo $Model->ValidateRow($this->getConex(), $this->Campos);
    }

    protected function onclickSave()
    {    
        require_once 'LiquidacionFinalLayoutClass.php';
        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();
        $Layout = new LiquidacionFinalLayout();
        $contrato_id = $_REQUEST['contrato_id'];
        $blur = $_REQUEST['blur'];
        $liquidacion_definitiva_id = $_REQUEST['liquidacion_definitiva_id'];
    
        if ($contrato_id > 0 && ($liquidacion_definitiva_id == '' || $liquidacion_definitiva_id == 'NULL')) {
            $datosResult = $this -> previsualizar($contrato_id, $liquidacion_definitiva_id, $blur);
            
            $datos = $datosResult['first_array'];
            $datos_con = $datosResult['second_array'];
            
        }elseif($liquidacion_definitiva_id>0){
            
            $datos = $this -> setResultados($liquidacion_definitiva_id); 
            
        }

        if ($blur == 'false') {
            $return = $Model->Save($this->getUsuarioId(), $this->Campos, $datos, $datos_con, $this->getConex());
            if (strlen(trim($Model->GetError())) > 0) {
                exit("Error : " . $Model->GetError());
            } else {
                if (is_numeric($return)) {
                    exit("$return");
                } else {
                    exit('Ocurrio una inconsistencia');
                }
            }
        } else {
            $Layout->setDetallesRegistrar($datos);
            $Layout->setIncludes();
            $Layout->RenderMainDetalle();
        }
    }
    
    protected function previsualizar($contrato_id, $liquidacion_definitiva_id, $blur)
    {
        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();
        
        $valor_pagar = 0;
        $prestaciones = 0;
        $liquidacion = 0;
        $deducciones = 0;
        $devengados = 0;
        
        $fecha_final = $_REQUEST['fecha_final'];
        $fecha_inicio = $_REQUEST['fecha_inicio'];
        $periodo = substr($fecha_final, 0, 4);
        $datos_periodo = $Model->getDatosperiodo($periodo, $this->getConex());
        $salario_minimo = $datos_periodo[0]['salrio'];
        
        $dias = $this->restaFechasCont($_REQUEST['fecha_inicio'], $_REQUEST['fecha_final']);
        $data = $Model->getDetallesContrato($contrato_id, $dias, $this->getConex());
        
        $tercero_id = $data[0]['tercero_id'];
        $sueldo_base = $data[0]['sueldo_base'];
        $subsidio_transporte = $data[0]['subsidio_transporte'];
        $periodicidad = $data[0]['periodicidad'];
        
        $x = 0;
        $c = 0;
        $datos = array();
        $datos_con = array();
        
        
        //validación si se pagan prestaciones:
        if ($data[0]['prestaciones'] != 0) {
            //cesantias

            //Traer la ultima liquidación de cesantías.
            $ultima_cesan = $data[0]['ultima_cesan'];
            $data_ces = $Model->getDetallesCesantias($contrato_id, $fecha_final, $this->getConex());

            if($data_ces[0]['fecha_corte'] > 0){
                $fecha_ultima = $data_ces[0]['fecha_corte'];
            }else if($ultima_cesan > 0){
                $fecha_ultima = $ultima_cesan;
            }else{
                $fecha_ultima = $fecha_inicio;
            }

            if ($data_ces[0]['fecha_corte'] > 0 || $ultima_cesan > 0){
                $dias_ces = $this->restaFechasCont($fecha_ultima, $_REQUEST['fecha_final']);
            } else {
                $dias_ces = $dias;
            }

            //Traer todas las Novedades con Base Salarial Si en un Rango de Fechas
            $base_deven_cesan = $Model->getDevBaseSalarial($contrato_id, $fecha_ultima, $fecha_final, $this->getConex());
            //Traer todas las Horas Extras que esten liquidadas en un Rango de Fechas
            $horas_extra_cesan = $Model->getHorasExtra($contrato_id, $fecha_ultima, $fecha_final, $this->getConex());
            //Sumatoria de todo el valor devengado desde un rango de fechas definido para Aux. de Transporte y Salario.
            $sum_devengado = $Model->getPromedioSalario($contrato_id, $fecha_ultima, $fecha_final, $this->getConex());
            //Consulta para saber si ha tenido variación del salario en los ultimos 3 meses
            $variacion_sal = $Model->getDiferenciaSalario($contrato_id, $fecha_ultima, $fecha_final, $periodicidad, $this->getConex());
            
            $meses_ces = ($dias_ces/30);
            $valor_base_salarial = ($base_deven_cesan/$meses_ces) + ($horas_extra_cesan/$meses_ces);
            $valor_prom_devengado = ($sum_devengado/$meses_ces);
            if($variacion_sal == 1){
                if($valor_prom_devengado < $salario_minimo){
                    $valor_cesan = intval((($salario_minimo + $subsidio_transporte) * $dias_ces) / 360);
                    
                }else{
                    $valor_cesan = intval((($sueldo_base + $subsidio_transporte) * $dias_ces) / 360);
                }
            }else{
                $valor_cesan = intval((($sueldo_base + $subsidio_transporte) * $dias_ces) / 360);
            }

            // exit('SAL MIN: '.$salario_minimo. ' - SUBS: '.$subsidio_transporte. ' - DIAS: '.$dias_ces .' - BASE SAL'.$valor_base_salarial );
            

            $datos[$x]['concepto'] = 'CESANTIAS';
            $datos[$x]['dias'] = $dias_ces > 0 ? $dias_ces : $dias;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $_REQUEST['fecha_final'];
            $datos[$x]['valor'] = $valor_cesan;
            $datos[$x]['valor_base_salarial'] = $valor_base_salarial;
            $datos[$x]['tipo'] = 'P';
            $datos[$x]['fecha_inicio'] = $fecha_ultima;
            $datos[$x]['fecha_fin'] = $_REQUEST['fecha_final'];
            $datos[$x]['empresa_id'] = $data[0]['empresa_cesan_id'];
            $x++;

            //datos contabilizar cesantias
            $result_parametros = $Model->getParametroCesan($this->getOficinaId(), $this->getConex());
            //$puc_provision_cesantias = $result_parametros[0]['puc_cesantias_prov_id'];    $natu_puc_provision_cesantias = $result_parametros[0]['natu_puc_cesantias_prov'];
            $puc_consolidado_cesantias = $result_parametros[0]['puc_cesantias_cons_id'];
            $natu_puc_consolidado_cesantias = $result_parametros[0]['natu_puc_cesantias_cons'];
            $puc_contrapartida = $result_parametros[0]['puc_cesantias_contra_id'];
            $puc_admin = $result_parametros[0]['puc_admon_cesantias_id'];
            $natu_puc_admin = $result_parametros[0]['natu_puc_admon_cesantias'];
            $puc_venta = $result_parametros[0]['puc_ventas_cesantias_id'];
            $natu_puc_venta = $result_parametros[0]['natu_puc_ventas_cesantias'];
            $puc_operativo = $result_parametros[0]['puc_produ_cesantias_id'];
            $natu_puc_operativo = $result_parametros[0]['natu_puc_produ_cesantias'];
            $tipo_doc = $result_parametros[0]['tipo_documento_id'];

            $result_consolidado = $Model->getSaldosConsProv($puc_consolidado_cesantias, $tercero_id, $_REQUEST['fecha_final'], $this->getConex());
            $valor_consolidado = intval($result_consolidado[0]['neto']);
            $centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];

            if ($valor_consolidado > $valor_cesan) {
                $valor_consolidado = $valor_cesan;
            }

            //cesantias consolidada
            if ($valor_consolidado > 0 || $valor_consolidado < 0) {
                $datos_con[$c]['puc_id'] = $puc_consolidado_cesantias;
                $datos_con[$c]['concepto'] = 'CESANTIAS CONSOLIDADAS';
                $datos_con[$c]['valor'] = abs($valor_consolidado);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($valor_consolidado > 0) {
                    $datos_con[$c]['debito'] = abs($valor_consolidado);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($valor_consolidado);
                }
                $c++;
            }

            /*$result_provision=  $Model -> getSaldosConsProv($puc_provision_cesantias,$tercero_id,$_REQUEST['fecha_final'],$this -> getConex());
            $valor_provision = intval($result_provision[0]['neto']);
            $centro_costo_provision = $result_provision[0]['centro_de_costo_id'];

            //cesantias provisionada
            if($valor_provision>0 || $valor_provision<0){
            $datos_con[$c]['puc_id']= $puc_provision_cesantias;
            $datos_con[$c]['concepto']= 'CESANTIAS PROVISIONADAS';
            $datos_con[$c]['valor']= abs($valor_provision);
            $datos_con[$c]['tercero_id']= $tercero_id;
            if($valor_provision>0){
            $datos_con[$c]['debito']= abs($valor_provision);
            $datos_con[$c]['credito']= 0;
            }else{
            $datos_con[$c]['debito']=  0;
            $datos_con[$c]['credito']= abs($valor_provision);
            }
            $c++;
            }*/
            $valor_provision = 0;
            //diferencia cesantias
            $diferen_cesan = ($valor_cesan - (abs($valor_provision) + $valor_consolidado));
            if ($diferen_cesan > 0 || $diferen_cesan < 0) {
                if ($data[0]['area_laboral'] == 'A') {
                    $datos_con[$c]['puc_id'] = $puc_admin;
                } elseif ($data[0]['area_laboral'] == 'O') {
                    $datos_con[$c]['puc_id'] = $puc_operativo;
                } elseif ($data[0]['area_laboral'] == 'C') {
                    $datos_con[$c]['puc_id'] = $puc_venta;
                }
                $datos_con[$c]['concepto'] = 'DIFERENCIA CESANTIAS';
                $datos_con[$c]['valor'] = abs($diferen_cesan);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($diferen_cesan > 0) {
                    $datos_con[$c]['debito'] = abs($diferen_cesan);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($diferen_cesan);
                }
                $c++;
            }

            //int cesantias
            $ultima_intcesan = $data[0]['ultima_intcesan'];
            
            $data_ices = $Model->getDetallesIntCesantias($contrato_id, $_REQUEST['fecha_final'], $this->getConex());

            if($data_ices[0]['fecha_corte'] > 0){
                $fecha_ultima = $data_ices[0]['fecha_corte'];
            }else if($ultima_intcesan > 0){
                $fecha_ultima = $ultima_intcesan;
            }else{
                $fecha_ultima = $fecha_inicio;
            }
            
            if ($data_ices[0]['fecha_corte'] > 0 || $ultima_intcesan > 0){
                $dias_ices = $this->restaFechasCont($fecha_ultima, $_REQUEST['fecha_final']);
            } else {
                $dias_ices = $dias;
            }

            $valor_icesan = intval(($valor_cesan * 0.12));

            // exit('VALOR: '.$valor_cesan. ' - DIAS: '.$dias_ices);
            
            $datos[$x]['concepto'] = 'INT. CESANTIAS';
            $datos[$x]['dias'] = $dias_ices;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $_REQUEST['fecha_final'];
            $datos[$x]['valor'] = $valor_icesan;
            $datos[$x]['tipo'] = 'P';
            $datos[$x]['fecha_inicio'] = $fecha_ultima;
            $datos[$x]['fecha_fin'] = $_REQUEST['fecha_final'];
            $datos[$x]['empresa_id'] = $data[0]['empresa_cesan_id'];
            $x++;

            //datos contabilizar int cesantias
            //$puc_provision_int_cesantias = $result_parametros[0]['puc_int_cesantias_prov_id'];    $natu_puc_provision_int_cesantias = $result_parametros[0]['natu_puc_int_cesantias_prov'];
            $puc_consolidado_int_cesantias = $result_parametros[0]['puc_int_cesantias_cons_id'];
            $natu_puc_consolidado_int_cesantias = $result_parametros[0]['natu_puc_int_cesantias_cons'];
            $puc_contrapartida = $result_parametros[0]['puc_int_cesantias_contra_id'];
            $puc_admin = $result_parametros[0]['puc_admon_int_cesantias_id'];
            $natu_puc_admin = $result_parametros[0]['natu_puc_admon_int_cesantias'];
            $puc_venta = $result_parametros[0]['puc_ventas_int_cesantias_id'];
            $natu_puc_venta = $result_parametros[0]['natu_puc_ventas_int_cesantias'];
            $puc_operativo = $result_parametros[0]['puc_produ_int_cesantias_id'];
            $natu_puc_operativo = $result_parametros[0]['natu_puc_produ_int_cesantias'];

            $result_consolidado = $Model->getSaldosConsProv($puc_consolidado_int_cesantias, $tercero_id, $_REQUEST['fecha_final'], $this->getConex());
            $valor_consolidado = intval($result_consolidado[0]['neto']);
            $centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];

            if ($valor_consolidado > $valor_icesan) {
                $valor_consolidado = $valor_icesan;
            }

            //interes cesantias consolidada
            if ($valor_consolidado > 0 || $valor_consolidado < 0) {
                $datos_con[$c]['puc_id'] = $puc_consolidado_int_cesantias;
                $datos_con[$c]['concepto'] = 'INT. CESANTIAS CONSOLIDADAS';
                $datos_con[$c]['valor'] = abs($valor_consolidado);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($valor_consolidado > 0) {
                    $datos_con[$c]['debito'] = abs($valor_consolidado);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($valor_consolidado);
                }
                $c++;
            }

            $valor_provision = 0;
            //interes cesantias provisionada
            /*
            $result_provision=  $Model -> getSaldosConsProv($puc_provision_int_cesantias,$tercero_id,$_REQUEST['fecha_final'],$this -> getConex());
            $valor_provision = intval($result_provision[0]['neto']);
            $centro_costo_provision = $result_provision[0]['centro_de_costo_id'];
            if($valor_provision>0 || $valor_provision<0){
            $datos_con[$c]['puc_id']= $puc_provision_int_cesantias;
            $datos_con[$c]['concepto']= 'INT. CESANTIAS PROVISIONADAS';
            $datos_con[$c]['valor']= abs($valor_provision);
            $datos_con[$c]['tercero_id']= $tercero_id;
            if($valor_provision>0){
            $datos_con[$c]['debito']= abs($valor_provision);
            $datos_con[$c]['credito']= 0;
            }else{
            $datos_con[$c]['debito']=  0;
            $datos_con[$c]['credito']= abs($valor_provision);
            }
            $c++;
            }*/
            //interes diferencia cesantias
            $diferen_icesan = ($valor_icesan - (abs($valor_provision) + $valor_consolidado));
            if ($diferen_icesan > 0 || $diferen_icesan < 0) {
                if ($data[0]['area_laboral'] == 'A') {
                    $datos_con[$c]['puc_id'] = $puc_admin;
                } elseif ($data[0]['area_laboral'] == 'O') {
                    $datos_con[$c]['puc_id'] = $puc_operativo;
                } elseif ($data[0]['area_laboral'] == 'C') {
                    $datos_con[$c]['puc_id'] = $puc_venta;
                }
                $datos_con[$c]['concepto'] = 'DIFERENCIA INT. CESANTIAS';
                $datos_con[$c]['valor'] = abs($diferen_icesan);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($diferen_icesan > 0) {
                    $datos_con[$c]['debito'] = abs($diferen_icesan);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($diferen_icesan);
                }
                $c++;
            }

            // prima
            $ultima_prima = $data[0]['ultima_prima'];
            $data_prima = $Model->getDetallesPrima($contrato_id, $_REQUEST['fecha_final'], $this->getConex());

            if($data_prima[0]['fecha_liquidacion'] > 0){
                $fecha_ultima = $data_prima[0]['fecha_liquidacion'];
            }else if($ultima_prima > 0){                
                $fecha_ultima = $ultima_prima;
            }else{
                $fecha_ultima = $fecha_inicio;
            }
            
            if ($data_prima[0]['fecha_liquidacion'] > 0 || $ultima_prima > 0){
                $dias_prima = $this->restaFechasCont($fecha_ultima, $_REQUEST['fecha_final']);
                
            } else {
                $dias_prima = $dias;
            }

            //Traer todas las Novedades con Base Salarial Si en un Rango de Fechas
            $base_deven_prima = $Model->getDevBaseSalarial($contrato_id, $fecha_ultima, $fecha_final, $this->getConex());
            //Traer todas las Horas Extras que esten liquidadas en un Rango de Fechas
            $horas_extra_prima = $Model->getHorasExtra($contrato_id, $fecha_ultima, $fecha_final, $this->getConex());
            //Sumatoria de todo el valor devengado desde un rango de fechas definido para Aux. de Transporte y Salario.
            $sum_devengado = $Model->getPromedioSalario($contrato_id, $fecha_ultima, $fecha_final, $this->getConex());
            //Consulta para saber si ha tenido variación del salario en los ultimos 3 meses
            $variacion_sal = $Model->getDiferenciaSalario($contrato_id, $fecha_ultima, $fecha_final, $periodicidad, $this->getConex());

            $meses_prima = ($dias_prima/30);
            $valor_base_salarial = ($base_deven_prima/$meses_prima) + ($horas_extra_prima/$meses_prima);
            $valor_prom_devengado = ($sum_devengado/$meses_prima);

            if($variacion_sal == 1){
                if($valor_prom_devengado < $salario_minimo){
                    $valor_prima = intval((($salario_minimo + $subsidio_transporte + $valor_base_salarial) * $dias_prima) / 360);
                }else{
                    $valor_prima = intval(((($sueldo_base + $valor_base_salarial + $subsidio_transporte)) * $dias_prima) / 360);
                }
            }else{
                $valor_prima = intval(((($sueldo_base + $valor_base_salarial + $subsidio_transporte)) * $dias_prima) / 360);
            }

            $datos[$x]['concepto'] = 'PRIMA SERVICIOS';
            $datos[$x]['dias'] = $dias_prima;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $fecha_final;
            $datos[$x]['valor'] = $valor_prima;
            $datos[$x]['valor_base_salarial'] = $valor_base_salarial;
            $datos[$x]['tipo'] = 'P';
            $datos[$x]['fecha_inicio'] = $fecha_ultima;
            $datos[$x]['fecha_fin'] = $fecha_final;
            $datos[$x]['empresa_id'] = 'NULL';
            $x++;

            //datos contabilizar primas
            $puc_provision_prima = $result_parametros[0]['puc_prima_prov_id'];
            $puc_consolidado_prima = $result_parametros[0]['puc_prima_cons_id'];
            $puc_contrapartida = $result_parametros[0]['puc_prima_contra_id'];
            $puc_admin = $result_parametros[0]['puc_admon_prima_id'];
            $puc_venta = $result_parametros[0]['puc_ventas_prima_id'];
            $puc_operativo = $result_parametros[0]['puc_produ_prima_id'];

            $result_consolidado = $Model->getSaldosConsProv($puc_consolidado_prima, $tercero_id, $_REQUEST['fecha_final'], $this->getConex());
            $valor_consolidado = intval($result_consolidado[0]['neto']);
            $centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];

            if ($valor_consolidado > $valor_prima) {
                $valor_consolidado = $valor_prima;
            }

            //PRIMAS consolidada
            if ($valor_consolidado > 0 || $valor_consolidado < 0) {
                $datos_con[$c]['puc_id'] = $puc_consolidado_prima;
                $datos_con[$c]['concepto'] = 'PRIMAS CONSOLIDADAS';
                $datos_con[$c]['valor'] = abs($valor_consolidado);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($valor_consolidado > 0) {
                    $datos_con[$c]['debito'] = abs($valor_consolidado);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($valor_consolidado);
                }
                $c++;
            }
            $valor_provision = 0;
            /*
            $result_provision=  $Model -> getSaldosConsProv($puc_provision_prima,$tercero_id,$_REQUEST['fecha_final'],$this -> getConex());
            $valor_provision = intval($result_provision[0]['neto']);
            $centro_costo_provision = $result_provision[0]['centro_de_costo_id'];

            //PRIMA provisionada
            if($valor_provision>0 || $valor_provision<0){
            $datos_con[$c]['puc_id']= $puc_provision_prima;
            $datos_con[$c]['concepto']= 'PRIMAS PROVISIONADAS';
            $datos_con[$c]['valor']= abs($valor_provision);
            $datos_con[$c]['tercero_id']= $tercero_id;
            if($valor_provision>0){
            $datos_con[$c]['debito']= abs($valor_provision);
            $datos_con[$c]['credito']=0;
            }else{
            $datos_con[$c]['debito']=  0;
            $datos_con[$c]['credito']= abs($valor_provision);
            }
            $c++;
            }*/
            //PRIMA diferencia
            $diferen_prima = ($valor_prima - (abs($valor_provision) + $valor_consolidado));
            if ($diferen_prima > 0 || $diferen_prima < 0) {
                if ($data[0]['area_laboral'] == 'A') {
                    $datos_con[$c]['puc_id'] = $puc_admin;
                } elseif ($data[0]['area_laboral'] == 'O') {
                    $datos_con[$c]['puc_id'] = $puc_operativo;
                } elseif ($data[0]['area_laboral'] == 'C') {
                    $datos_con[$c]['puc_id'] = $puc_venta;
                }
                $datos_con[$c]['concepto'] = 'DIFERENCIA PRIMAS';
                $datos_con[$c]['valor'] = abs($diferen_prima);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($diferen_prima > 0) {
                    $datos_con[$c]['debito'] = abs($diferen_prima);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($diferen_prima);
                }
                $c++;
            }

            // vacaciones
            $data_vaca = $Model->getDetallesVacaciones($contrato_id, $_REQUEST['fecha_final'], $this->getConex());
            $fecha_ultima = $data_vaca[0]['fecha_ultima'];
            //$periodos = $dias / 360;
            //$dias_dis = intval(15 * $periodos);
            if ($data_vaca[0]['dias_va'] <= 0) {
                $dias_deb_vac = $dias;
            } else {
                //$per_disfru = $data_vaca[0]['dias_va'] / 15;
                $dias_deb_vac = $this->restaFechasCont($fecha_ultima, $_REQUEST['fecha_final']);
            }
            
            
            $valor_vacas = intval((($sueldo_base) * $dias_deb_vac) / 720);
            $desde_vacas = $data_vaca[0]['fecha_ultima'] != '' ? $data_vaca[0]['fecha_ultima'] : $_REQUEST['fecha_inicio'];
            $datos[$x]['concepto'] = 'PRIMA VACACIONES';
            $datos[$x]['dias'] = $dias_deb_vac;
            $datos[$x]['periodo'] = 'De: ' . $desde_vacas . ' Hasta: ' . $_REQUEST['fecha_final'];
            $datos[$x]['valor'] = $valor_vacas;
            $datos[$x]['tipo'] = 'P';
            $datos[$x]['fecha_inicio'] = $desde_vacas;
            $datos[$x]['fecha_fin'] = $_REQUEST['fecha_final'];
            $datos[$x]['empresa_id'] = 'NULL';
            $x++;


            //datos contabilizar vacaciones
            $puc_provision_vacaciones = $result_parametros[0]['puc_vac_prov_id'];
            $puc_consolidado_vacaciones = $result_parametros[0]['puc_vac_cons_id'];
            $puc_contrapartida = $result_parametros[0]['puc_vac_contra_id'];
            $puc_admin = $result_parametros[0]['puc_admon_vac_id'];
            $puc_venta = $result_parametros[0]['puc_ventas_vac_id'];
            $puc_operativo = $result_parametros[0]['puc_produ_vac_id'];
            $puc_salud = $result_parametros[0]['puc_salud_vac_id'];
            $puc_pension = $result_parametros[0]['puc_pension_vac_id'];

            $result_consolidado = $Model->getSaldosConsProv($puc_consolidado_vacaciones, $tercero_id, $_REQUEST['fecha_final'], $this->getConex());
            $valor_consolidado = intval($result_consolidado[0]['neto']);
            $centro_costo_consolidado = $result_consolidado[0]['centro_de_costo_id'];

            if ($valor_consolidado > $valor_vacas) {
                $valor_consolidado = $valor_vacas;
            }

            //vacaciones consolidada
            if ($valor_consolidado > 0 || $valor_consolidado < 0) {
                $datos_con[$c]['puc_id'] = $puc_consolidado_vacaciones;
                $datos_con[$c]['concepto'] = 'VACACIONES CONSOLIDADAS';
                $datos_con[$c]['valor'] = abs($valor_consolidado);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($valor_consolidado > 0) {
                    $datos_con[$c]['debito'] = abs($valor_consolidado);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($valor_consolidado);
                }
                $c++;
            }
            $valor_provision = 0;
           
            //vacaciones diferencia
            $diferen_vacas = ($valor_vacas - (abs($valor_provision) + $valor_consolidado));
            if ($diferen_vacas > 0 || $diferen_vacas < 0) {
                if ($data[0]['area_laboral'] == 'A') {
                    $datos_con[$c]['puc_id'] = $puc_admin;
                } elseif ($data[0]['area_laboral'] == 'O') {
                    $datos_con[$c]['puc_id'] = $puc_operativo;
                } elseif ($data[0]['area_laboral'] == 'C') {
                    $datos_con[$c]['puc_id'] = $puc_venta;
                }
                $datos_con[$c]['concepto'] = 'DIFERENCIA VACACIONES';
                $datos_con[$c]['valor'] = abs($diferen_vacas);
                $datos_con[$c]['tercero_id'] = $tercero_id;
                if ($diferen_vacas > 0) {
                    $datos_con[$c]['debito'] = abs($diferen_vacas);
                    $datos_con[$c]['credito'] = 0;
                } else {
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($diferen_vacas);
                }
                $c++;
            }
            if ($blur == 'true') {
                $prestaciones = $valor_cesan + $valor_icesan + $valor_prima + $valor_vacas;
                $datos[$x]['titulo'] = 'TOTAL PRESTACIONES SOCIALES';
                $datos[$x]['valor'] = $prestaciones;
                $datos[$x]['campo'] = 'prestaciones';
                $x++;
            }
            $prestaciones = $valor_cesan + $valor_icesan + $valor_prima + $valor_vacas;
        }
        //indemnizacion
        if ($_REQUEST['justificado'] == 'S') {

            $periodos = $dias / 360;

            if ($periodos > 1) {
                $periodo_otros = ($periodos - 1);
                $valor_otros = ((($sueldo_base / 30) * $datos_periodo[0]['dias_2anio_indem']) * $periodo_otros);
                $valor_indem = intval((($sueldo_base / 30) * $datos_periodo[0]['dias_anio_indem']) + $valor_otros);

            } elseif ($periodos <= 1) {
                $valor_indem = intval(($sueldo_base / 30) * $datos_periodo[0]['dias_anio_indem']);
            }

            $datos[$x]['concepto'] = 'INDEMNIZACION';
            $datos[$x]['dias'] = $dias;
            $datos[$x]['periodo'] = 'De: ' . $_REQUEST['fecha_inicio'] . ' Hasta: ' . $_REQUEST['fecha_final'];
            $datos[$x]['valor'] = $valor_indem;
            $datos[$x]['tipo'] = 'I';
            $datos[$x]['fecha_inicio'] = $_REQUEST['fecha_inicio'];
            $datos[$x]['fecha_fin'] = $_REQUEST['fecha_final'];
            $x++;

            //datos contabilizar indemnizacion
            if ($data[0]['area_laboral'] == 'A') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_admon_indem_id'];
            } elseif ($data[0]['area_laboral'] == 'O') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_produ_indem_id'];
            } elseif ($data[0]['area_laboral'] == 'C') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_ventas_indem_id'];
            }
            $datos_con[$c]['concepto'] = 'INDEMNIZACION';
            $datos_con[$c]['valor'] = abs($valor_indem);
            $datos_con[$c]['tercero_id'] = $tercero_id;
            $datos_con[$c]['debito'] = abs($valor_indem);
            $datos_con[$c]['credito'] = 0;
            $c++;

        }

        //salario
        $data_sal = $Model->getDetallesSalario($contrato_id, $this->getConex());
        $fecha_ultima = $data_sal[0]['fecha_liquidacion'];
        /* exit('Fecha ultima'.$fecha_ultima); */
        $dias = $this -> restaFechasCont($fecha_ultima,$fecha_final);
        if ($dias > 0) {

            $valor_salario = intval(($sueldo_base / 30) * $dias);
            $datos[$x]['concepto'] = 'SALARIO';
            $datos[$x]['dias'] = $dias;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $fecha_final;
            $datos[$x]['valor'] = $valor_salario;
            $datos[$x]['tipo'] = 'S';
            $datos[$x]['fecha_inicio'] = $fecha_ultima;
            $datos[$x]['fecha_fin'] = $fecha_final;
            $x++;

            //datos contabilizar salario
            if ($data[0]['area_laboral'] == 'A') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_admon_sal_id'];
            } elseif ($data[0]['area_laboral'] == 'O') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_produ_sal_id'];
            } elseif ($data[0]['area_laboral'] == 'C') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_ventas_sal_id'];
            }
            $datos_con[$c]['concepto'] = 'SALARIO';
            $datos_con[$c]['valor'] = abs($valor_salario);
            $datos_con[$c]['tercero_id'] = $tercero_id;
            $datos_con[$c]['debito'] = abs($valor_salario);
            $datos_con[$c]['credito'] = 0;
            $c++;

        } elseif ($data_sal[0]['dias_dif'] < 0) {

        } else {

        }
        //subsidio
        $data_sal = $Model->getDetallesSalario($contrato_id, $this->getConex());
        $fecha_ultima = $data_sal[0]['fecha_liquidacion'];
        $dias = $this -> restaFechasCont($fecha_ultima,$fecha_final);
        if ($dias > 0) {

            $valor_subsidio = intval(($subsidio_transporte / 30) * $dias);
            $datos[$x]['concepto'] = 'SUBSIDIO';
            $datos[$x]['dias'] = $dias;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $fecha_final;
            $datos[$x]['valor'] = $valor_subsidio;
            $datos[$x]['tipo'] = 'S';
            $datos[$x]['fecha_inicio'] = $fecha_ultima;
            $datos[$x]['fecha_fin'] = $fecha_final;
            $x++;

            //datos contabilizar salario
            if ($data[0]['area_laboral'] == 'A') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_admon_trans_id'];
            } elseif ($data[0]['area_laboral'] == 'O') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_produ_trans_id'];
            } elseif ($data[0]['area_laboral'] == 'C') {
                $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_ventas_trans_id'];
            }
            $datos_con[$c]['concepto'] = 'SUBSIDIO';
            $datos_con[$c]['valor'] = abs($valor_subsidio);
            $datos_con[$c]['tercero_id'] = $tercero_id;
            $datos_con[$c]['debito'] = abs($valor_subsidio);
            $datos_con[$c]['credito'] = 0;
            $c++;

        } elseif ($data_sal[0]['dias_dif'] < 0) {

        } else {

        }

        $liquidacion = $prestaciones + $valor_salario + $valor_indem + $valor_subsidio;

        if ($blur == 'true') {
            $datos[$x]['titulo'] = 'TOTAL LIQUIDACION';
            $datos[$x]['valor'] = $liquidacion;
            $datos[$x]['campo'] = 'liquidacion';
            $x++;
        }
        //deducciones parafiscales
        if ($dias > 0) {

            $valor_salud = intval(((($sueldo_base / 30) * $dias) * $datos_periodo[0]['desc_emple_salud']) / 100);
            $datos[$x]['concepto'] = 'APORTE SALUD';
            $datos[$x]['dias'] = $dias;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $fecha_final;
            $datos[$x]['valor'] = $valor_salud;
            $deducciones = $deducciones + $valor_salud;
            $datos[$x]['tipo'] = 'D';
            $datos[$x]['fecha_inicio'] = "'" . $fecha_ultima . "'";
            $datos[$x]['fecha_fin'] = "'" . $fecha_final . "'";
            $datos[$x]['concepto_area_id'] = 'NULL';
            $datos[$x]['empresa_id'] = $data[0]['empresa_eps_id'];
            $x++;

            //datos contabilizar salud
            $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_contra_salud_id'];
            $datos_con[$c]['concepto'] = 'SALUD';
            $datos_con[$c]['valor'] = abs($valor_salud);
            $datos_con[$c]['tercero_id'] = $data[0]['tercero_eps_id'];
            $datos_con[$c]['debito'] = 0;
            $datos_con[$c]['credito'] = abs($valor_salud);
            $c++;

            $valor_pension = intval(((($sueldo_base / 30) * $dias) * $datos_periodo[0]['desc_emple_pension']) / 100);
            $datos[$x]['concepto'] = 'APORTE PENSION';
            $datos[$x]['dias'] = $dias;
            $datos[$x]['periodo'] = 'De: ' . $fecha_ultima . ' Hasta: ' . $fecha_final;
            $datos[$x]['valor'] = $valor_pension;
            $deducciones = $deducciones + $valor_pension;
            $datos[$x]['tipo'] = 'D';
            $datos[$x]['fecha_inicio'] = "'" . $fecha_ultima . "'";
            $datos[$x]['fecha_fin'] = "'" . $fecha_final . "'";
            $datos[$x]['concepto_area_id'] = 'NULL';
            $datos[$x]['empresa_id'] = $data[0]['empresa_pension_id'];
            $x++;

            //datos contabilizar pension
            $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_contra_pension_id'];
            $datos_con[$c]['concepto'] = 'PENSION';
            $datos_con[$c]['valor'] = abs($valor_pension);
            $datos_con[$c]['tercero_id'] = $data[0]['tercero_pension_id'];
            $datos_con[$c]['debito'] = 0;
            $datos_con[$c]['credito'] = abs($valor_pension);
            $c++;

        }

        //deducciones
        $data_ded = $Model->getDetallesDeducciones($contrato_id, $fecha_inicio, $fecha_final, $this->getConex());
        if (count($data_ded) > 0) {

            for ($i = 0; $i < count($data_ded); $i++) {
                //$deta_ded = $Model->getDetallesDeduccionesDetalle($contrato_id, $data_ded[$i]['concepto_area_id'], $data_ded[$i]['fecha_novedad'], $fecha_inicio, $fecha_final, $this->getConex());

                //if ($data_ded[$i]['valor'] == $deta_ded[$i]['valor']) {
                //    $valor_debe = $data_ded[$i]['valor'] - $deta_ded[$i]['valor'];
                //} else {
                $valor_debe = $data_ded[$i]['valor'];
                //}

                if ($valor_debe > 0) { //si debe
                    $datos[$x]['concepto'] = 'DEBE ' . $data_ded[$i]['concepto'];
                    $datos[$x]['dias'] = 'NULL';
                    $datos[$x]['periodo'] = '';
                    $datos[$x]['valor'] = $valor_debe;
                    $deducciones = $deducciones + $valor_debe;
                    $datos[$x]['tipo'] = 'D';
                    $datos[$x]['fecha_inicio'] = 'NULL';
                    $datos[$x]['fecha_fin'] = 'NULL';
                    $datos[$x]['concepto_area_id'] = $data_ded[$i]['concepto_area_id'];
                    $datos[$x]['empresa_id'] = 'NULL';
                    $x++;

                    //datos contabilizar deducciones
                    $data_puc_con = $Model->getPucConcepto($data_ded[$i]['concepto_area_id'], $this->getConex());
                    if ($data[0]['area_laboral'] == 'A') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_admon_id'];
                    } elseif ($data[0]['area_laboral'] == 'O') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_prod_id'];
                    } elseif ($data[0]['area_laboral'] == 'C') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_ventas_id'];
                    }

                    $datos_con[$c]['concepto'] = 'DEBE ' . $data_ded[$i]['concepto'];
                    $datos_con[$c]['valor'] = abs($valor_debe);
                    $datos_con[$c]['tercero_id'] = $tercero_id;
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($valor_debe);
                    $c++;

                } elseif ($valor_debe < 0) { // si se le devuelve al empleado
                    $datos[$x]['concepto'] = 'A FAVOR ' . $data_ded[$i]['concepto'];
                    $datos[$x]['dias'] = 'NULL';
                    $datos[$x]['periodo'] = '';
                    $deducciones = $deducciones + $valor_debe;
                    $datos[$x]['valor'] = $valor_debe;
                    $datos[$x]['fecha_inicio'] = 'NULL';
                    $datos[$x]['fecha_fin'] = 'NULL';
                    $datos[$x]['concepto_area_id'] = $data_ded[$i]['concepto_area_id'];
                    $datos[$x]['empresa_id'] = 'NULL';
                    $x++;

                    //datos contabilizar deducciones
                    $data_puc_con = $Model->getPucConcepto($data_ded[$i]['concepto_area_id'], $this->getConex());
                    if ($data[0]['area_laboral'] == 'A') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_admon_id'];
                    } elseif ($data[0]['area_laboral'] == 'O') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_prod_id'];
                    } elseif ($data[0]['area_laboral'] == 'C') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_ventas_id'];
                    }

                    $datos_con[$c]['concepto'] = 'A FAVOR ' . $data_ded[$i]['concepto'];
                    $datos_con[$c]['valor'] = abs($valor_debe);
                    $datos_con[$c]['tercero_id'] = $tercero_id;
                    $datos_con[$c]['debito'] = abs($valor_debe);
                    $datos_con[$c]['credito'] = 0;
                    $c++;

                }
            }
            if ($blur == 'true') {
                $datos[$x]['titulo'] = 'TOTAL DEDUCCIONES';
                $datos[$x]['valor'] = $deducciones;
                $datos[$x]['campo'] = 'deduccion';
                $x++;
            }

        }

        //devengados
        $data_dev = $Model->getDetallesDevengado($contrato_id, $fecha_inicio, $fecha_final, $this->getConex());
        if (count($data_dev) > 0) {

            for ($i = 0; $i < count($data_dev); $i++) {
                //$deta_dev = $Model->getDetallesDevengadoDetalle($contrato_id, $data_dev[$i]['concepto_area_id'], $data_dev[$i]['fecha_novedad'], $fecha_inicio, $fecha_final, $this->getConex());

                //if ($data_dev[$i]['valor'] == $deta_dev[$i]['valor']) {
                //    $valor_debe = $data_dev[$i]['valor'] - $deta_dev[$i]['valor'];
                //} else {
                $valor_debe = $data_dev[$i]['valor'];
                //}

                if ($valor_debe > 0) { //si debe
                    $datos[$x]['concepto'] = 'A FAVOR ' . $data_dev[$i]['concepto'];
                    $datos[$x]['dias'] = 'NULL';
                    $datos[$x]['periodo'] = '';
                    $datos[$x]['valor'] = $valor_debe;
                    $devengados = $devengados + $valor_debe;
                    $datos[$x]['tipo'] = 'V';
                    $datos[$x]['fecha_inicio'] = 'NULL';
                    $datos[$x]['fecha_fin'] = 'NULL';
                    $datos[$x]['concepto_area_id'] = $data_dev[$i]['concepto_area_id'];
                    $datos[$x]['empresa_id'] = 'NULL';
                    $x++;

                    //datos contabilizar devengados
                    $data_puc_con = $Model->getPucConcepto($data_dev[$i]['concepto_area_id'], $this->getConex());
                    if ($data[0]['area_laboral'] == 'A') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_admon_id'];
                    } elseif ($data[0]['area_laboral'] == 'O') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_prod_id'];
                    } elseif ($data[0]['area_laboral'] == 'C') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_ventas_id'];
                    }

                    $datos_con[$c]['concepto'] = 'A FAVOR ' . $data_dev[$i]['concepto'];
                    $datos_con[$c]['valor'] = abs($valor_debe);
                    $datos_con[$c]['tercero_id'] = $tercero_id;
                    $datos_con[$c]['debito'] = abs($valor_debe);
                    $datos_con[$c]['credito'] = 0;
                    $c++;

                } elseif ($valor_debe < 0) { // si se le devuelve al empleado
                    $datos[$x]['concepto'] = 'DEBE ' . $data_dev[$i]['concepto'];
                    $datos[$x]['dias'] = 'NULL';
                    $datos[$x]['periodo'] = '';
                    $deducciones = $deducciones + $valor_debe;
                    $datos[$x]['valor'] = $valor_debe;
                    $datos[$x]['fecha_inicio'] = 'NULL';
                    $datos[$x]['fecha_fin'] = 'NULL';
                    $datos[$x]['concepto_area_id'] = $data_dev[$i]['concepto_area_id'];
                    $datos[$x]['empresa_id'] = 'NULL';
                    $x++;

                    //datos contabilizar devengados
                    $data_puc_con = $Model->getPucConcepto($data_dev[$i]['concepto_area_id'], $this->getConex());
                    if ($data[0]['area_laboral'] == 'A') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_admon_id'];
                    } elseif ($data[0]['area_laboral'] == 'O') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_prod_id'];
                    } elseif ($data[0]['area_laboral'] == 'C') {
                        $datos_con[$c]['puc_id'] = $data_puc_con[0]['puc_ventas_id'];
                    }

                    $datos_con[$c]['concepto'] = 'A FAVOR ' . $data_dev[$i]['concepto'];
                    $datos_con[$c]['valor'] = abs($valor_debe);
                    $datos_con[$c]['tercero_id'] = $tercero_id;
                    $datos_con[$c]['debito'] = 0;
                    $datos_con[$c]['credito'] = abs($valor_debe);
                    $c++;

                }
            }
            if ($blur == 'true') {
                $datos[$x]['titulo'] = 'TOTAL DEVENGADOS';
                $datos[$x]['valor'] = $devengados;
                $datos[$x]['campo'] = 'devengado';
                $x++;
            }
        }

        $valor_pagar = $liquidacion - $deducciones + $devengados;

        //datos contabilizar pagar
        if ($valor_pagar > 0) {
            $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_contra_sal_id'];
            $datos_con[$c]['concepto'] = 'VALOR A PAGAR';
            $datos_con[$c]['valor'] = abs($valor_pagar);
            $datos_con[$c]['tercero_id'] = $tercero_id;
            $datos_con[$c]['debito'] = 0;
            $datos_con[$c]['credito'] = abs($valor_pagar);
            $c++;
        } else {
            $datos_con[$c]['puc_id'] = $datos_periodo[0]['puc_contra_sal_id'];
            $datos_con[$c]['concepto'] = 'VALOR A PAGAR';
            $datos_con[$c]['valor'] = abs($valor_pagar);
            $datos_con[$c]['tercero_id'] = $tercero_id;
            $datos_con[$c]['debito'] = abs($valor_pagar);
            $datos_con[$c]['credito'] = 0;
            $c++;
        }
        $valor_pagar = $liquidacion + $devengados - $deducciones;
        if ($blur == 'true') {
            $valor_pagar = $liquidacion + $devengados - $deducciones;
            $datos[$x]['titulo'] = 'VALOR A PAGAR';
            $datos[$x]['valor'] = $valor_pagar;
            $datos[$x]['campo'] = 'valor_pagar';
            $x++;
        }
        $data = array('first_array' => $datos, 'second_array' => $datos_con);
        return $data;
    }

    protected function setResultados($liquidacion_definitiva_id){
        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();
        
        $data1 = $Model->getDetallesLiquidacionPres($liquidacion_definitiva_id, $this->getConex());
        $y = (count($data1) + 1);
        $prestaciones = $data1[0]['total'];
        $data1[$y]['titulo'] = 'TOTAL PRESTACIONES SOCIALES';
        $data1[$y]['valor'] = $prestaciones;
        $data1[$y]['campo'] = 'prestaciones';

        $data2 = $Model->getDetallesLiquidacionIndem($liquidacion_definitiva_id, $this->getConex());
        $data3 = $Model->getDetallesLiquidacionSala($liquidacion_definitiva_id, $this->getConex());

        $y = (count($data3) + 1);
        $liquidacion = $data1[0]['total'] + $data2[0]['total'] + $data3[0]['total'];
        $data3[$y]['titulo'] = 'TOTAL LIQUIDACION';
        $data3[$y]['valor'] = $liquidacion;
        $data3[$y]['campo'] = 'liquidacion';

        $data4 = $Model->getDetallesLiquidaciondeduc($liquidacion_definitiva_id, $this->getConex());
        $y = (count($data4) + 1);
        $deducciones = $data4[0]['total'];
        $data4[$y]['titulo'] = 'TOTAL DEDUCCIONES';
        $data4[$y]['valor'] = $deducciones;
        $data4[$y]['campo'] = 'deduccion';

        $data5 = $Model->getDetallesLiquidaciondeven($liquidacion_definitiva_id, $this->getConex());
        $y = (count($data5) + 1);
        $devengados = $data5[0]['total'];
        $data5[$y]['titulo'] = 'TOTAL DEVENGADOS';
        $data5[$y]['valor'] = $devengados;
        $data5[$y]['campo'] = 'devengado';
        $y++;

        $valor_pagar = $liquidacion + $devengados - $deducciones;
        $data5[$y]['titulo'] = 'VALOR A PAGAR';
        $data5[$y]['valor'] = $valor_pagar;
        $data5[$y]['campo'] = 'valor_pagar';

        $datos = array_merge($data1, $data2, $data3, $data4, $data5);

        return $datos;
    }

    protected function onclickUpdate()
    {

        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();

        $Model->Update($this->Campos, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('Ocurrio una inconsistencia');
        } else {
            exit('Se actualizo correctamente la Liquidacion Final');
        }

    }

    protected function setDataContrato()
    {
        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();

        $Data = array();
        $contrato_id = $_REQUEST['contrato_id'];
        $fecha_inicio = $_REQUEST['fecha_inicio'];
        $fecha_final = $_REQUEST['fecha_final'];

        if (is_numeric($contrato_id)) {

            $Data = $Model->selectContrato($contrato_id, $fecha_inicio, $fecha_final,$this->getConex());

        }
        print json_encode($Data);

    }

    protected function onclickCancellation()
    {

        require_once "LiquidacionFinalModelClass.php";

        $Model = new LiquidacionFinalModel();
        $liquidacion_definitiva_id = $this->requestDataForQuery('liquidacion_definitiva_id', 'integer');
        $causal_anulacion_id = $this->requestDataForQuery('causal_anulacion_id', 'integer');
        $observacion_anulacion = $this->requestDataForQuery('observacion_anulacion', 'text');
        $usuario_anulo_id = $this->getUsuarioId();

        $estado = $Model->comprobar_estado($liquidacion_definitiva_id, $this->getConex());

        if ($estado[0]['estado'] == 'A') {
            exit('No se puede Anular, La Liquidaci&oacute;n previamente estaba Anulada');

        } else if ($estado[0]['estado'] == 'C' && $estado[0]['estado_mes'] == 0) {

            exit('No se puede Anular, El mes contable de la Liquidaci&oacute;n esta Cerrado');

        } else if ($estado[0]['estado'] == 'C' && $estado[0]['estado_periodo'] == 0) {

            exit('No se puede Anular, El periodo contable de la Liquidaci&oacute;n esta Cerrado');

        }

        $Model->cancellation($liquidacion_definitiva_id, $estado[0]['encabezado_registro_id'], $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $this->getConex());

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function onclickPrint()
    {

        require_once "Imp_LiquidacionFinalClass.php";
        $print = new Imp_LiquidacionFinal();
        $print->printOut($this->getEmpresaId(), $this->getConex());

    }

    protected function getTotalDebitoCredito()
    {

        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();
        $liquidacion_definitiva_id = $_REQUEST['liquidacion_definitiva_id'];
        $data = $Model->getTotalDebitoCredito($liquidacion_definitiva_id, $this->getConex());
        print json_encode($data);

    }
    protected function getContabilizar()
    {

        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();
        include_once "UtilidadesContablesModelClass.php";
        $utilidadesContables = new UtilidadesContablesModel();

        $liquidacion_definitiva_id = $_REQUEST['liquidacion_definitiva_id'];
        $fecha_final = $_REQUEST['fecha_final'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();
        $usuario_id = $this->getUsuarioId();

        $mesContable = $utilidadesContables->mesContableEstaHabilitado($oficina_id, $fecha_final, $this->getConex());
        $periodoContable = $utilidadesContables->PeriodoContableEstaHabilitado($empresa_id, $fecha_final, $this->getConex());
        $estado = $Model->comprobar_estado($liquidacion_definitiva_id, $this->getConex());

        if ($estado[0]['estado'] == 'C') {
            exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Contabilizada.');
        } else if (is_numeric($estado[0]['encabezado_registro_id'])) {
            exit('No se puede Contabilizar. <br> La Liquidaci&oacute;n estaba previamente Relacionada con un Registro contable.');

        }

        if ($mesContable && $periodoContable) {

            $return = $Model->getContabilizarReg($liquidacion_definitiva_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $this->getConex()); //aca
            if ($return == true) {
                exit("true");
            } else {
                exit("Error : " . $Model->GetError());
            }

        } else {

            if (!$mesContable && !$periodoContable) {
                exit("No se permite Contabilizar en el periodo y mes seleccionado");
            } elseif (!$mesContable) {
                exit("No se permite Contabilizar en el mes seleccionado");
            } else if (!$periodoContable) {
                exit("No se permite Contabilizar en el periodo seleccionado");
            }
        }

    }

//BUSQUEDA
    protected function onclickFind()
    {
        require_once "LiquidacionFinalModelClass.php";
        $Model = new LiquidacionFinalModel();

        $Data = array();
        $liquidacion_definitiva_id = $_REQUEST['liquidacion_definitiva_id'];

        if (is_numeric($liquidacion_definitiva_id)) {

            $Data = $Model->selectDatosLiquidacionFinalId($liquidacion_definitiva_id, $this->getConex());

        }
        echo json_encode($Data);

    }

    protected function SetCampos()
    {

        /********************
        Campos concepto
         ********************/

        $this->Campos[liquidacion_definitiva_id] = array(
            name => 'liquidacion_definitiva_id',
            id => 'liquidacion_definitiva_id',
            type => 'text',
            Boostrap => 'si',
            required => 'no',
            readonly => 'readonly',
            size => '10',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('primary_key')),
        );

        $this->Campos[contrato_id] = array(
            name => 'contrato_id',
            id => 'contrato_id',
            type => 'hidden',
            required => 'yes',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[contrato] = array(
            name => 'contrato',
            id => 'contrato',
            type => 'text',
            Boostrap => 'si',
            size => '30',
            suggest => array(
                name => 'contrato',
                setId => 'contrato_id',
                onclick => 'setDataContrato'),
        );

        $this->Campos[fecha_inicio] = array(
            name => 'fecha_inicio',
            id => 'fecha_inicio',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '11'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );
        $this->Campos[fecha_final] = array(
            name => 'fecha_final',
            id => 'fecha_final',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '11'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[motivo_terminacion_id] = array(
            name => 'motivo_terminacion_id',
            id => 'motivo_terminacion_id',
            type => 'select',
            Boostrap => 'si',
            options => array(),
            required => 'yes',
            //tabindex=>'1',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[causal_despido_id] = array(
            name => 'causal_despido_id',
            id => 'causal_despido_id',
            type => 'select',
            Boostrap => 'si',
            options => array(),
            //tabindex=>'1',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[base_liquidacion] = array(
            name => 'base_liquidacion',
            id => 'base_liquidacion',
            type => 'text',
            disabled => 'yes',
            Boostrap => 'si',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );
        $this->Campos[base_salarial_deven] = array(
            name => 'base_salarial_deven',
            id => 'base_salarial_deven',
            type => 'text',
            disabled => 'yes',
            Boostrap => 'si',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column'))
        );
        $this->Campos[base_horas_extra] = array(
            name => 'base_horas_extra',
            id => 'base_horas_extra',
            type => 'text',
            disabled => 'yes',
            Boostrap => 'si',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column'))
        );
        $this->Campos[prom_ces] = array(
            name => 'prom_ces',
            id => 'prom_ces',
            type => 'text',
            disabled => 'yes',
            Boostrap => 'si',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column'))
        );
        $this->Campos[prom_pri] = array(
            name => 'prom_pri',
            id => 'prom_pri',
            type => 'text',
            disabled => 'yes',
            Boostrap => 'si',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column'))
        );
        $this->Campos[justificado] = array(
            name => 'justificado',
            id => 'justificado',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'S', text => 'SI'), array(value => 'N', text => 'NO')),
            selected => 'N',
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '1'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[encabezado_registro_id] = array(
            name => 'encabezado_registro_id',
            id => 'encabezado_registro_id',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
        );
        $this->Campos[blur] = array(
            name => 'blur',
            id => 'blur',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
        );
        $this->Campos[dias] = array(
            name => 'dias',
            id => 'dias',
            type => 'text',
            disabled => 'yes',
            Boostrap => 'si',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[estado] = array(
            name => 'estado',
            id => 'estado',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            options => array(array(value => 'E', text => 'EDICION', selected => 'E'), array(value => 'A', text => 'ANULADO'), array(value => 'C', text => 'CONTABILIZADO')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[usuario_id] = array(
            name => 'usuario_id',
            id => 'usuario_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        $this->Campos[fecha_registro] = array(
            name => 'fecha_registro',
            id => 'fecha_registro',
            type => 'hidden',
            datatype => array(
                type => 'text',
                length => '15'),
            transaction => array(
                table => array('liquidacion_definitiva'),
                type => array('column')),
        );

        //ANULACION
        $this->Campos[usuario_anulo_id] = array(
            name => 'usuario_anulo_id',
            id => 'usuario_anulo_id',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'integer'),
        );

        $this->Campos[fecha_anulacion] = array(
            name => 'fecha_anulacion',
            id => 'fecha_anulacion',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'text'),
        );

        $this->Campos[observacion_anulacion] = array(
            name => 'observacion_anulacion',
            id => 'observacion_anulacion',
            type => 'textarea',
            required => 'yes',
            datatype => array(
                type => 'tex'),
        );

        $this->Campos[causal_anulacion_id] = array(
            name => 'causal_anulacion_id',
            id => 'causal_anulacion_id',
            type => 'select',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
        );

        $this->Campos[print_out] = array(
            name => 'print_out',
            id => 'print_out',
            type => 'button',
            value => 'OK',

        );

        $this->Campos[tipo_impresion] = array(
            name => 'tipo_impresion',
            id => 'tipo_impresion',
            type => 'select',
            Boostrap => 'si',
            options => array(array(value => 'CL', text => 'DESPRENDIBLE LIQUIDACION'), array(value => 'DC', text => 'DOCUMENTO CONTABLE')),
            selected => 'C',
            required => 'yes',
            datatype => array(type => 'text'),
        );

        $this->Campos[print_cancel] = array(
            name => 'print_cancel',
            id => 'print_cancel',
            type => 'button',
            value => 'CANCEL',

        );

        /**********************************
        Botones
         **********************************/

        $this->Campos[guardar] = array(
            name => 'guardar',
            id => 'guardar',
            type => 'button',
            value => 'Guardar',
        );

        $this->Campos[actualizar] = array(
            name => 'actualizar',
            id => 'actualizar',
            type => 'button',
            value => 'Actualizar',
            disabled => 'disabled',
        );

        $this->Campos[anular] = array(
            name => 'anular',
            id => 'anular',
            type => 'button',
            value => 'Anular',
            disabled => 'disabled',
            onclick => 'onclickCancellation(this.form)',
        );

        $this->Campos[contabilizar] = array(
            name => 'contabilizar',
            id => 'contabilizar',
            type => 'button',
            value => 'Contabilizar',
            tabindex => '16',
            onclick => 'OnclickContabilizar()',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'print',
            value => 'Imprimir',
            displayoptions => array(
                form => 0,
                beforeprint => 'beforePrint',
                title => 'Impresion Liquidacion',
                width => '700',
                height => '600',
            ),

        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            onclick => 'LiquidacionFinalOnReset()',
        );

        $this->Campos[busqueda] = array(
            name => 'busqueda',
            id => 'busqueda',
            type => 'text',
            Boostrap => 'si',
            placeholder => 'Por favor digite el numero de identificación del empleado o el consecutivo',
            size => '85',
            suggest => array(
                name => 'liquidacion_definitiva',
                setId => 'liquidacion_definitiva_id',
                onclick => 'setDataFormWithResponse'),
        );

        $this->SetVarsValidate($this->Campos);
    }

}

$LiquidacionFinal = new LiquidacionFinal();
