<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ReporteElectronica extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("ReporteElectronicaLayoutClass.php");
    require_once("ReporteElectronicaModelClass.php");
	
    $Layout   = new ReporteElectronicaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReporteElectronicaModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    //$Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));   
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	
	$Layout -> SetSi_Pro2($Model -> GetSi_Pro2($this -> getConex()));
	$Layout -> RenderMain();    
  }  
  
/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento($this -> getConex());
    $print -> printOut();  
  }*/

  protected function generateView(){
    require_once("ReporteElectronicaLayoutClass.php");
    require_once("ReporteElectronicaModelClass.php");
      
    $Layout         = new ReporteElectronicaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model      	= new ReporteElectronicaModel();	
    $desde			= $_REQUEST['desde'];
    $hasta			= $_REQUEST['hasta'];
    $si_empleado	= $_REQUEST['si_empleado'];
    $empleado_id	= $_REQUEST['empleado_id']>0 ? $_REQUEST['empleado_id'] : '';	
    $empresa_id     = $this->getEmpresaId();

	$data = $Model -> getReporte($desde,$hasta,$empresa_id,$empleado_id,$this -> getConex());

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/reportes.css");						
    $Layout -> setCssInclude("../css/reportes.css","print");
    $Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
    $Layout -> setJsInclude("../../../framework/js/funciones.js");
    $Layout -> setJsInclude("../../../transporte/reportes/js/detalles.js");
    $Layout -> setJsInclude("../../../nomina/reportes/js/ReporteElectronica.js");
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());		

    $Layout -> setVar('EMPRESA',$empresa);	
    $Layout -> setVar('NIT',$nitEmpresa);	
    $Layout -> setVar('CENTROS',$centrosTxt);													
    $Layout -> setVar('DESDE',$desde);															
    $Layout -> setVar('HASTA',$hasta);

    $Layout -> setVar('parametros',$parametros); 
    $Layout -> setVar('DETALLES',$data); 
    $Layout -> setVar('USUARIO',$this -> getUsuarioNombres());		  	  	  	  	  
	$download = $this -> requestData('download');
	
	if($download == 'true'){
	    $Layout -> exportToExcel('ReporteElectronicaResultado.tpl'); 		
    }else{
        $Layout -> RenderLayout('ReporteElectronicaResultado.tpl');	
    }
  }    
    
  protected function generateFileexcel(){
  
    require_once("ReporteElectronicaModelClass.php");
	
	$Model      	        = new ReporteElectronicaModel();	
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
    $si_empleado			= $_REQUEST['si_empleado'];
	$empleado_id	        = $_REQUEST['empleado_id']>0 ? $_REQUEST['empleado_id'] : '';
    $empresa_id             = $this->getEmpresaId(); 
	
	$nombre = 'Rep_NomElec'.date('Ymd_Hi');  
    $data = $Model -> getReporte($desde,$hasta,$empresa_id,$empleado_id,$this -> getConex());
   	$ruta  = $this -> arrayToExcel("Rep_NomElec",$nombre,$data,null,"string");	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }

  	protected function procesaJson($itemPadre,$itemHijo,$itemValue,$extraNom,$tipoValidacion,$jsonSeparator){

		$cadena = '"'.$itemPadre.'":[';

		switch ($tipoValidacion) {
			case 'agrupado':

				$cadena .= ($jsonSeparator == true or $jsonSeparator == "true") ? "" : "{" ;
				
				$valida = $this -> validaAgrupado($itemValue);
				
				if ($valida[result] == "true") {

					if ($jsonSeparator == true or $jsonSeparator == 'true') {

						$cadena .= $this -> jsonSeparator($itemHijo,$itemValue);

					}else {
						
						for ($contValida=0; $contValida < count($itemValue); $contValida++) { 
							
							$cadena .= '"'.$itemHijo[$contValida].'":"'.$itemValue[$contValida].'",';

						}

					}


				}else {
					
					$cadena = '';
					return $cadena;
					exit;

				}

				if ($extraNom == true or $extraNom == "true") {
						
					$cadena .= '"extrasNom":null,';
					$cadena = substr($cadena, 0, -1);
				}

				$cadena .= ($jsonSeparator == true or $jsonSeparator == "true") ? "" : "}" ;

				break;
			
			case 'combinado':

				$cadena .= '{';
				
				$valida = $this -> validaCombinado($itemHijo,$itemValue);

				if ($valida[result] == "true") {

					for ($contValida=0; $contValida < count($valida[arreglo]); $contValida++) { 
						
						$cadena .= '"'.$valida[arreglo][$contValida][0].'":"'.$valida[arreglo][$contValida][1].'",';
	
					}

				}else {
					
					$cadena = '';
					return $cadena;
					exit;

				}

								

				if ($extraNom == true or $extraNom == "true") {
						
					$cadena .= '"extrasNom":null,';
					$cadena = substr($cadena, 0, -1);
				}

				$cadena .= '}';

				break;

				default:

				exit("el tipo: ".$tipoValidacion." de agrupamiento no esta definido");

				break;
		}

		

		$cadena .= '],';
		
		return $cadena;

	}

  	protected function validaCombinado($arrayItem,$arrayValue){

		$arrayReturn = array(

			"result" => "false",
			"arreglo" => array()

		);

		for ($contArray=0; $contArray < count($arrayItem); $contArray++) { 
			
			if ($arrayValue[$contArray] > 0) {

				array_push($arrayReturn[arreglo],array(
					$arrayItem[$contArray] , $arrayValue[$contArray]
				));

			}	

		}

		if (count($arrayReturn[arreglo])>0) {
			$arrayReturn[result] = "true";
		}else {
			$arrayReturn[result] = "false";
		}

		return $arrayReturn;

	}

  	protected function validaAgrupado($arrayValue){
		
		$retornar = array("result" => "false");

		for ($contArray=0; $contArray < count($arrayValue); $contArray++) { 

			if ($arrayValue[$contArray] <= 0) {
				$retornar = array("result" => "false");
			}else {
				$retornar = array("result" => "true");
				return $retornar;
				exit;
			}
		}

		return $retornar;

	}

  	protected function validaUnitario($value){

		if ($value == 0) {
			return false;
		}else{
			return true;
		}

	}

	protected function comillado($valor){

		if ($valor != 'null') {
			$valor = '"'.$valor.'"';
		}

		return $valor;

	}

	protected function jsonSeparator($arrayItem,$arrayValue){
		
		//print_r($arrayItem);
		//print_r($arrayValue);

		$separatedItem = [];
		$separatedValue = [];
		$json = '';

		$separatedItem = $arrayItem;
		$separatedValue = explode("&",$arrayValue[0]);
		
		//print_r($separatedItem);
		//print_r($separatedValue);

		
		if (count($separatedItem)<count($separatedValue)) {
		//echo "uno";	
		
			for ($contItem=0; $contItem < count($separatedItem); $contItem++) { 

				for ($contValue=0; $contValue < count($separatedValue); $contValue++) { 

					$json .= '{';

					$json .=' "'.$separatedItem[$contItem].'":'.$this -> comillado($separatedValue[$contValue]).',';

					$json .= '"extrasNom":null
						},';

				}
			}

			$json = substr($json, 0, -1);

		}else {
			//echo "dos";
			
			$separatedItem = $arrayItem;	
			$separatedValue = explode("&",$arrayValue[0]);

			$arrayValueGroup = [];

			for ($contValue=0; $contValue < count($arrayValue); $contValue++) { 
				
				array_push($arrayValueGroup,explode("&",$arrayValue[$contValue]));

			}
			
//print_r($separatedItem);
//print_r($arrayValueGroup);

			$amount = count($separatedValue);

			

			for ($i=0; $i < $amount; $i++) { 
				
				$json .= '{';
					
				for ($cant=0; $cant < count($separatedItem); $cant++) { 
					$json .=' "'.$separatedItem[$cant].'":'.$this -> comillado($arrayValueGroup[$cant][$i]).',';
				}

				$json .= '"extrasNom":null },';		
			}

			
			$json = substr($json, 0, -1);
			
		}
		
		
		return $json;

  	}
  
  	protected function enviarReporte(){
		

		require_once("ReporteElectronicaModelClass.php");

		$arrayIdentificacion = explode(",", $_REQUEST['arrayIdentificacion']);
		$desde					= $_REQUEST['desde'];
		$hasta					= $_REQUEST['hasta'];
    	$empresa_id             = $this->getEmpresaId(); 
		$validaFecha			= $_REQUEST['validaFecha'];
		
		if ($validaFecha == false || $validaFecha == 'false') {
			exit("Las fechas seleccionadas son invalidas para el reporte");
		}
		
		$Model = new ReporteElectronicaModel();
		
		$token = $Model -> getToken($this -> getConex());
		$empresa = $Model -> getNitEmpresa($empresa_id,$this -> getConex());

		for ($i=0; $i < count($arrayIdentificacion); $i++) {
			
			$empleado = $Model -> getEmpleado($arrayIdentificacion[$i],$this -> getConex());
			
			//echo $empleado_id[0][empleado_id];

			$tokenEnterprise = $token[0][tokenenterprise];
			$tokenPassword = $token[0][tokenautorizacion];
			$nitEmpresa = $empresa[0][numero_identificacion];
			$empleado_id = $empleado[0][empleado_id];
			$idSoftware = "900836174";

			

			//echo "empleado_is: ".$empleado_id;

			$data = $Model -> getReporteEnviar($desde,$hasta,$empresa_id,$empleado_id,$this -> getConex());
			//exit($this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago","tipo"),array($data[0][dias_incapacidadGen],$data[0][fecha_inicio_IncapacidadGen],$data[0][fecha_final_incapacidadGen],$data[0][valor_incapacidadGen],$data[0][tipo_incapacidadGen])));
			
			$request = '{
				"tokenEnterprise":"'.$tokenEnterprise.'",
				"tokenPassword":"'.$tokenPassword.'",
				"idSoftware":"'.$idSoftware.'",
				"nitEmpleador":"'.$nitEmpresa.'",
				"objNomina":{
					"consecutivoDocumentoNom":"'.$data[0][prefijo_rango].$data[0][num_rango].'",
					"deducciones":{';
			$request.= ($this -> validaUnitario($data[0][afc])) ? '"afc":"'.$data[0][afc].'",' : '';
			$request.= $this -> procesaJson("anticipos",array("montoanticipo"),array($data[0][anticipo_nomina]),true,"agrupado",true);
			$request.=	($this -> validaUnitario($data[0][cooperativa])) ? '"cooperativa":"'.$data[0][cooperativa].'",' : '';
			$request.=	($this -> validaUnitario($data[0][deuda])) ? '"deuda":"'.$data[0][deuda].'",' : '';
			$request.=	($this -> validaUnitario($data[0][educacion])) ? '"educacion":"'.$data[0][educacion].'",' : '';
			$request.=	'"extrasNom":null,';
			$request.=	($this -> validaUnitario($data[0][embargo])) ? '"embargoFiscal":"'.$data[0][embargo].'",' : '';
			$request.=	$this -> procesaJson("fondosPensiones",array("deduccion","porcentaje"),array($data[0][deduccion_pension],$data[0][porcentaje_pension]),true,"agrupado",false);
			$request.=	$this -> procesaJson("fondosSP",array("deduccionSP","deduccionSub","porcentaje","porcentajeSub"),array(0,0,0,0),true,"agrupado",false);
			$request.= $this -> procesaJson("libranzas",array("deduccion","descripcion"),array($data[0][deduccion_libranza],$data[0][descripcion_libranza]),true,"agrupado",true);
			$request.= $this -> procesaJson("otrasDeducciones",array("montootraDeduccion"),array($data[0][otra_deduccion]),true,"agrupado",true);
			$request.= $this -> procesaJson("pagosTerceros",array("montopagotercero"),array($data[0][valor_pago_tercero_dev]),true,"agrupado",true);
			
			$request.=	($this -> validaUnitario(0)) ? '"pensionVoluntaria":"0",' : '';
			$request.=	($this -> validaUnitario($data[0][plan_complementario_salud])) ? '"planComplementarios":"'.$data[0][plan_complementario_salud].'",' : '';
			$request.=	($this -> validaUnitario($data[0][reintegro_de_trabajador])) ? '"reintegro":"'.$data[0][reintegro_de_trabajador].'",' : '';
			$request.=	($this -> validaUnitario(0)) ? '"retencionFuente":"0",' : '';
			
			$request.= $this -> procesaJson("salud",array("deduccion","porcentaje"),array($data[0][deduccion_salud],$data[0][porcentaje_salud]),true,"agrupado",false);
			
			$request.= $this -> procesaJson("sanciones",array("sancionPublic","sancionPriv"),array($data[0][sancion_publica],$data[0][sancion_privada]),true,"combinado",false);

			$request.=	$this -> procesaJson("sindicatos",array("deduccion","porcentaje"),array($data[0][pago_sindicato],$data[0][porcentaje_sindicato]),true,"agrupado",true);

			$request = substr($request, 0, -1);

			$request.= '},';

			$request.=	'"devengados":{';
			
				$request.=	($this -> validaUnitario($data[0][montoAnticipo])) ? '"anticipos":[
				'.$this -> jsonSeparator(array("montoanticipo"),array($data[0][montoAnticipo])).'
			],' : '';

			$request.= $this -> procesaJson("auxilios",array("auxilioNS","auxilioS"),array($data[0][auxilioNS],$data[0][auxilioS]),true,"combinado",false);
			
			$request.=	($this -> validaUnitario($data[0][apoyo_sostenimiento])) ? '"apoyoSost":"'.$data[0][apoyo_sostenimiento].'",' : '';
			$request.=	$this -> procesaJson("basico",array("diasTrabajados","sueldoTrabajado"),array($data[0][dias],$data[0][sueldo_trabajado]),true,"agrupado",false);
			
			$request.=	$this -> procesaJson("bonificaciones",array("bonificacionNS","bonificacionS"),array($data[0][bonificacion_no_salarial],$data[0][bonificacionS]),true,"combinado",false);
			 
			$request.=	'"bonifRetiro":"'.$data[0][bonificacion_retiro].'",';
			$request.=	$this -> procesaJson("bonoEPCTVs",array("pagoAlimentacionNS","pagoAlimentacionS","pagoNS","pagoS"),array($data[0][pAlimentacionNs],$data[0][pAlimentacionS],$data[0][pagosNs],$data[0][pagosS]),true,"combinado",false);
			
			$request.=	$this -> procesaJson("cesantias",array("pago","pagoIntereses","porcentaje"),array($data[0][pago_cesantias],$data[0][valor_intereses_cesantias],$data[0][porcentaje_intereses_cesantias]),true,"agrupado",false);
			$request.=	$this -> procesaJson("comisiones",array("montocomision"),array($data[0][monto_comision]),true,"agrupado",true);
			$request.= $this -> procesaJson("compensaciones",array("compensacionE","compensacionO"),array($data[0][compensacion_extraordinaria],$data[0][compensacion_ordinaria]),true,"combinado",true);			
						
			$request.=	($this -> validaUnitario($data[0][dotacion])) ? '"dotacion":"'.$data[0][dotacion].'",' : '' ;			
			$request.=	'"extrasNom":null,';

			if ($data[0][valor_horasE_diurnas]+$data[0][valor_horasE_nocturno]+$data[0][valor_horasR_nocturno]+$data[0][valor_horasE_diurnofes]+$data[0][valor_horasR_diurnofes]+$data[0][valor_horasE_nocturnofes] > 0) {

				$request.=	'"horasExtras":[';
				$request.=	($this -> validaUnitario($data[0][valor_horasE_diurnas])) ? '{
							"cantidad":"'.$data[0][cantidad_horasE_diurnas].'",
							"extrasNom":null,
							"horaInicio":"'.$data[0][horaInicio_extra_diurno].'",
							"horaFin":"'.$data[0][horaFin_extra_diurno].'",
							"pago":"'.$data[0][valor_horasE_diurnas].'",
							"porcentaje":"'.$data[0][porcentaje_extra_diurno].'",
							"tipoHorasExtra":"0"
						},' : '' ;	
				
				$request.=	($this -> validaUnitario($data[0][valor_horasE_nocturno])) ? '{
							"cantidad":"'.$data[0][cantidad_horasE_nocturno].'",
							"extrasNom":null,
							"horaInicio":"'.$data[0][horaInicio_extra_nocturno].'",
							"horaFin":"'.$data[0][horaFin_extra_nocturno].'",
							"pago":"'.$data[0][valor_horasE_nocturno].'",
							"porcentaje":"'.$data[0][porcentaje_extra_nocturno].'",
							"tipoHorasExtra":"1"
						},' : '' ;				
				$request.=	($this -> validaUnitario($data[0][valor_horasR_nocturno])) ? '{
							"cantidad":"'.$data[0][cantidad_horasR_nocturno].'",
							"extrasNom":null,
							"horaInicio":"'.$data[0][horaInicio_recargo_nocturno].'",
							"horaFin":"'.$data[0][horaFin_recargo_nocturno].'",
							"pago":"'.$data[0][valor_horasR_nocturno].'",
							"porcentaje":"'.$data[0][porcentaje_recargo_nocturno].'",
							"tipoHorasExtra":"2"
						},' : '' ;				
				$request.=	($this -> validaUnitario($data[0][valor_horasE_diurnofes])) ? '{
							"cantidad":"'.$data[0][cantidad_horasE_diurnofes].'",
							"extrasNom":null,
							"horaInicio":"'.$data[0][horaInicio_Extra_diurnofes].'",
							"horaFin":"'.$data[0][horaFin_extra_diurnofes].'",
							"pago":"'.$data[0][valor_horasE_diurnofes].'",
							"porcentaje":"'.$data[0][porcentaje_extra_diurnofes].'",
							"tipoHorasExtra":"3"
						},' : '' ;  
				$request.=	($this -> validaUnitario($data[0][valor_horasR_diurnofes])) ? '{
							"cantidad":"'.$data[0][cantidad_horasR_diurnofes].'",
							"extrasNom":null,
							"horaInicio":"'.$data[0][horaInicio_recargo_diurnofes].'",
							"horaFin":"'.$data[0][horaFin_recargo_diurnofes].'",
							"pago":"'.$data[0][valor_horasR_diurnofes].'",
							"porcentaje":"'.$data[0][porcentaje_recargo_diurnofes].'",
							"tipoHorasExtra":"4"
						},' : '' ;				
				$request.=	($this -> validaUnitario($data[0][valor_horasE_nocturnofes])) ? '{
							"cantidad":"'.$data[0][cantidad_horasE_nocturnofes].'",
							"extrasNom":null,
							"horaInicio":"'.$data[0][horaInicio_Extra_nocturnofes].'",
							"horaFin":"'.$data[0][horaFin_extra_nocturnofes].'",
							"pago":"'.$data[0][valor_horasE_nocturnofes].'",
							"porcentaje":"'.$data[0][porcentaje_extra_nocturnofes].'",
							"tipoHorasExtra":"5"
						},' : '' ;				  

				$request = substr($request, 0, -1);		
				$request.=	'],';
			}

			
				$request.=	($this -> validaUnitario($data[0][cantidad_huelga])) ? '"huelgasLegales":[
					{
					   "cantidad":'.$this -> comillado($data[0][cantidad_huelga]).',
					   "extrasNom":null,
					   "fechaInicio":'.$this -> comillado($data[0][inicio_huelga]).',
					   "fechaFin":'.$this -> comillado($data[0][fin_huelga]).'
					}
				 ],' : '';
				$request.=	($this -> validaUnitario($data[0][valor_indemnizacion])) ? '"indemnizacion":"'.$data[0][valor_indemnizacion].'",' : '' ;
				
				if ($data[0][valor_incapacidadGen]+$data[0][valor_incapacidadProf]+$data[0][valor_incapacidadLab] > 0) {
				
					$request.=	'"incapacidades":[';
							
					$request.= ($this -> validaUnitario($data[0][valor_incapacidadGen])) ? $this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago","tipo"),array($data[0][dias_incapacidadGen],$data[0][fecha_inicio_IncapacidadGen],$data[0][fecha_final_incapacidadGen],$data[0][valor_incapacidadGen],$data[0][tipo_incapacidadGen])).',' : '' ; 

					$request.= ($this -> validaUnitario($data[0][valor_incapacidadProf])) ? $this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago","tipo"),array($data[0][dias_incapacidadProf],$data[0][fecha_inicio_IncapacidadProf],$data[0][fecha_final_incapacidadProf],$data[0][valor_incapacidadProf],$data[0][tipo_incapacidadProf])).',' : '' ;

					$request.= ($this -> validaUnitario($data[0][valor_incapacidadLab])) ? $this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago","tipo"),array($data[0][dias_incapacidadLab],$data[0][fecha_inicio_IncapacidadLab],$data[0][fecha_final_incapacidadLab],$data[0][valor_incapacidadLab],$data[0][tipo_incapacidadLab])).',' : '' ;

					$request = substr($request, 0, -1);

					$request.=	'],';

				}
				
				if ($data[0][valor_licenciaR]+$data[0][valor_licenciaNR]+$data[0][valor_licenciaM] > 0) {
					$request.=	'"licencias":{
							"extrasNom":null,';
					$request.=	($this -> validaUnitario($data[0][valor_licenciaM])) ? '"licenciaMP":[
								'.$this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago"),array($data[0][dias_licenciaM],$data[0][fecha_inicio_licenciaM],$data[0][fecha_final_licenciaM],$data[0][valor_licenciaM])).'
							],' : '';
					$request.=	($this -> validaUnitario($data[0][valor_licenciaNR])) ? '"licenciaNR":[
								'.$this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago"),array($data[0][dias_licenciaNR],$data[0][fecha_inicio_licenciaNR],$data[0][fecha_final_licenciaNR],$data[0][valor_licenciaNR])).'
							],' : '' ;
					$request.=	($this -> validaUnitario($data[0][valor_licenciaR])) ? '"licenciaR":[
								'.$this -> jsonSeparator(array("cantidad","fechaInicio","fechaFin","pago"),array($data[0][dias_licenciaR],$data[0][fecha_inicio_licenciaR],$data[0][fecha_final_licenciaR],$data[0][valor_licenciaR])).'
							],' : '' ;

					$request = substr($request, 0, -1);		
					$request.=	'},';
				}

				
				$request .=	$this -> procesaJson("otrosConceptos",array("conceptoNS","conceptoS","descripcionConcepto"),array($data[0][concepto_no_salarial],$data[0][concepto_salarial],$data[0][descripcion_concepto]),true,"combinado",false); 
						 
				
				$request .=	$this -> procesaJson("pagosTerceros",array("montopagotercero"),array($data[0][pago_a_tercero]),true,"agrupado",true);
						 
				$request .=	$this -> procesaJson("primas",array("cantidad","pago","pagoNS"),array($data[0][dias_prima],$data[0][pago_prima],$data[0][prima_no_salarial]),true,"combinado",false);
						 
				$request .=	($this -> validaUnitario($data[0][valor_teletrabajo])) ? '"reintegro":"'.$data[0][reintegro_de_empresa].'",' : '';	$request .= ($this -> validaUnitario($data[0][valor_teletrabajo])) ? '"teletrabajo":"'.$data[0][valor_teletrabajo].'",' : '' ;	 
				
				$request .= $this -> procesaJson("transporte",array("auxilioTransporte","viaticoManuAlojS","viaticoManuAlojNS"),array($data[0][auxilio_transporte],$data[0][viatico_manu_alo_s],$data[0][viatico_manu_alo_ns]),true,"combinado",false);
						 
				if ($data[0][valor_liquidacion_vacaciones]+$data[0][valor_vacaciones_compensadas] > 0) {
					
					$request .=  '"vacaciones":{
						"extrasNom":null,';

					$request .=	($this -> validaUnitario($data[0][valor_liquidacion_vacaciones])) ? '"vacacionesComunes":[
								{
								"cantidad":"'.$data[0][dias_vacaciones].'",
								"extrasNom":null,
								"fechaInicio":'.$this -> comillado($data[0][fecha_inicio_vacaciones]).',
								"fechaFin":'.$this -> comillado($data[0][fecha_final_vacaciones]).',
								"pago":"'.$data[0][valor_liquidacion_vacaciones].'"
								}
							],' : '' ;	
						

					//procesaJson($itemPadre,$itemHijo,$itemValue,$extraNom,$tipoValidacion,$jsonSeparator)	

					$request .=	($this -> validaUnitario($data[0][valor_vacaciones_compensadas])) ? '"vacacionesCompensadas":[
								{
								"cantidad":"'.$data[0][dias_compensados_vacaciones].'",
								"extrasNom":null,
								"fechaInicio":null,
								"fechaFin":null,
								"pago":"'.$data[0][valor_vacaciones_compensadas].'"
								}
							],' : '' ;

					$request = substr($request, 0, -1);		
						
					$request .=  '}';
				}		 

				$request = substr($request, 0, -1);
						 
				$request .=	'},';
				$request .=	'"documentosReferenciados":[
						{
							"cunePred":"'.$data[0][cune_pred].'",
							"extrasNom":null,
							"fechaGenPred":'.$this -> comillado($data[0][fecha_gen_pred]).',
							"numeroPred":"'.$data[0][numero_pred].'"
						}
						 ],
						 "extrasNom":null,
						 "fechaEmisionNom":'.$this -> comillado($data[0][fechaEmision]).',
						 "notas":null,
						 "novedad":"'.$data[0][novedad].'",
						 "novedadCUNE":"'.$data[0][novedad_cune].'",
						 "lugarGeneracionXML":{
							"departamentoEstado":"11",
							"extrasNom":null,
							"idioma":"es",
							"municipioCiudad":"11001",
							"pais":"CO"
						 },
						 "pagos":[
							{
							   "extrasNom":null,
							   "fechasPagos":[
									'.$this -> jsonSeparator(array("fechapagonomina"),array($data[0][pagos_nomina])).'  
							   ],
							   "metodoDePago":"1",
							   "medioPago":"'.$data[0][metododePago].'",
							   "nombreBanco":"'.$this -> RemoveSpecialChar($data[0][nombreBanco]).'",
							   "tipoCuenta":"'.$this -> RemoveSpecialChar($data[0][tipoCuenta]).'",
							   "numeroCuenta":"'.$this -> RemoveSpecialChar($data[0][numeroCuenta]).'"
							}
						 ],
						 "periodoNomina": "5",
						 "periodos": [
							{
								"extras" : null,
								"fechaIngreso": "'.$data[0][fechaingreso].'",
								"fechaLiquidacionInicio": "'.$desde.'",
								"fechaLiquidacionFin": "'.$hasta.'",
								"fechaRetiro": "'.$data[0][fecharetiro].'",
								"tiempoLaborado": "'.$data[0][dias_trabajados].'"
							}
						 ],
						 "rangoNumeracionNom":"'.$data[0][prefijo_rango].'-'.$data[0][numini_rango].'",
						 "redondeo":"'.$data[0][redondeo].'",
						 "tipoDocumentoNom":"'.$data[0][tipo_documento].'",
						 "tipoMonedaNom":"'.$data[0][tipoMoneda].'",
						 "tipoNota":"'.$data[0][tipo_nota].'",
						 "totalComprobante":"'.$data[0][total_comprobante].'",
						 "totalDeducciones":"'.$data[0][total_deduccion].'",
						 "totalDevengados":"'.$data[0][total_devengado].'",
						 "trm":"'.$data[0][trm].'",
						 "trabajador":{
							"altoRiesgoPension":"'.$data[0][altoRiesgopension].'",
							"codigoTrabajador":"'.$data[0][codtrabajador].'",
							"email":"'.$this -> RemoveSpecialChar($data[0][email_trabajador]).'",
							"extrasNom":null,
							"lugarTrabajoDepartamentoEstado":"'.$data[0][departamento].'",
							"lugarTrabajoDireccion":"'.trim($data[0][lugar_trabajo]).'",
							"lugarTrabajoMunicipioCiudad":"'.$data[0][municipio].'",
							"lugarTrabajoPais":"CO",
							"numeroDocumento":"'.$data[0][identificacion].'",
							"otrosNombres":"'.trim($data[0][otros_nombres]).'",
							"primerApellido":"'.trim($data[0][primer_apellido]).'",
							"primerNombre":"'.trim($data[0][primer_nombre]).'",
							"salarioIntegral":"'.$data[0][salariointegral].'",
							"segundoApellido":"'.$data[0][segundo_apellido].'",
							"subTipoTrabajador":"'.$data[0][subtipoTrabajador].'",
							"sueldo":"'.$data[0][sueldo_base].'",
							"tipoContrato":"'.$data[0][tipocontrato].'",
							"tipoIdentificacion":"'.$data[0][tipoidentificacion].'",
							"tipoTrabajador":"'.$data[0][tipoTrabajador].'"
						 }
				}
			}';

			

			$url = $Model -> getUrlNominaElectronica($this -> getConex());

			$curl = curl_init();

			//echo "url: ".$url."\n";
			//exit($data[0][liquidacion_novedad_id]);
			//echo $request;
			//echo("--------------------------------------------------------------------------");
			
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>$request,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json'
					),
				));
				
				$response = curl_exec($curl);
				
				curl_close($curl);

				//exit("prueba: ".$response);

				$respuesta = json_decode($response);

				$mensaje .= $Model -> actualizaDatosReporte($respuesta,$data[0][fechaEmision],$desde,$hasta,$data[0][contrato_id],$data[0][num_rango],$data[0][liquidacion_novedad_id],$this -> getConex());

				

			//---------------------------------------------------------------------------------------------------

			if ($respuesta -> codigo == "200") {
				
				$curl = curl_init();

				curl_setopt_array($curl, array(

					CURLOPT_URL => 'http://demonominaelectronica.thefactoryhka.com.co/DescargarPDF',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS =>'{
					"tokenEnterprise": "'.$tokenEnterprise.'",
					"tokenPassword": "'.$tokenPassword.'",
					"consecutivoDocumentoNom": "'.$data[0][prefijo_rango].$data[0][num_rango].'"
					}',
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json'
					),

				));

				$response = curl_exec($curl);

				$respuesta = json_decode($response);

				curl_close($curl);


				if ($respuesta -> codigo == 200) {

					$docBase64 = $respuesta -> documento;
					$nombreArchivo = $respuesta -> nombre;

					$carpeta = '../../../archivos/nomina/nominaE';

					if (!file_exists($carpeta)) {
						mkdir($carpeta, 0777, true);
					}

					$rutaDocumentoSalida = "../../.."."/archivos/nomina/nominaE/".$nombreArchivo;

					$documentoBinaria = base64_decode($docBase64);
					$bytes = file_put_contents($rutaDocumentoSalida, $documentoBinaria);
				}

			} 

		}

		echo $mensaje;

  	}

	protected function RemoveSpecialChar($str){
		$result = preg_replace('/[0-9\@\.\;\""]+/', '', $str);
		$result = trim($result);

		return $result;
	}

	  protected function showGrid(){
	  
        require_once "ReporteElectronicaLayoutClass.php";
        require_once "ReporteElectronicaModelClass.php";

        $Layout = new ReporteElectronicaLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new ReporteElectronicaModel();
          
          //// GRID ////
        $Attributes = array(
            id => 'Novedad',
            title => 'Novedades Nomima Enviadas',
            //sortname => 'consecutivo',
            //sortorder => 'desc',
            //rowId => 'consecutivo',
            width => 'auto',
            height => '250',
        );

        $Cols = array(
            array(name => 'consecutivo', index => 'consecutivo', sorttype => 'text', width => '90', align => 'center'),
            array(name => 'numero_identificacion', index => 'numero_identificacion', sorttype => 'text', width => '140', align => 'center'),
            array(name => 'nombre', index => 'nombre', sorttype => 'text', width => '250', align => 'left'),
            array(name => 'fecha_inicial', index => 'fecha_inicial', sorttype => 'date', width => '100', align => 'left'),
            array(name => 'fecha_final', index => 'fecha_final', sorttype => 'date', width => '100', align => 'left'),
            array(name => 'cune', index => 'cune', sorttype => 'text', width => '500', align => 'left')
        );

        $Titles = array(
			'CONSECUTIVO',
            'NUMERO IDENTIFICACON',
            'NOMBRE',
            'FECHA INICIAL',
            'FECHA FINAL',
            'CUNE'
        );

        $html = $Layout->SetGridNominaElectronica($Attributes, $Titles, $Cols, $Model->getQueryNominaElectronicaGrid());
         
         print $html;
          
      }

 
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_empleado] = array(
		name	=>'si_empleado',
		id		=>'si_empleado',
		type	=>'select',
		Boostrap => 'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'empleado_si();'
	);
	
		$this -> Campos[si_cargo] = array(
		name	=>'si_cargo',
		id		=>'si_cargo',
		type	=>'select',
		Boostrap => 'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'cargo_si();'
	);



	$this -> Campos[cargo_id] = array(
		name	=>'cargo_id',
		id		=>'cargo_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[cargo] = array(
		name	=>'cargo',
		id		=>'cargo',
		type	=>'text',
		Boostrap => 'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cargo',
			setId	=>'cargo_id')
	);	
	
	  $this -> Campos[empleado_id] = array(
	  name	=>'empleado_id',
	  id	=>'empleado_id',
	  type	=>'hidden',
	  value	=>'',
	  datatype=>array(
		  type	=>'integer',
		  length	=>'20')
	);

	$this -> Campos[empleado] = array(
		name	=>'empleado',
		id		=>'empleado',
		type	=>'text',
		Boostrap => 'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'empleado',
			setId	=>'empleado_id')
	);	

    /////// BOTONES 

	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
	/*displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Reporte',
      width       => '800',
      height      => '600'*/
    );
	
	$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				// tabindex=>'22',
				onclick	=>'ContratoOnReset()'
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  }

$ReporteElectronica = new ReporteElectronica();



?>