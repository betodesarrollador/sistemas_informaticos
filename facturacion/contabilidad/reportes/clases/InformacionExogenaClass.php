<?php
require_once("../../../framework/clases/ControlerClass.php");
final class InformacionExogena extends Controler{
  public function __construct(){
    parent::__construct(3);	      
  }  
  public function Main(){
  
    $this -> noCache();  
    
    require_once("InformacionExogenaLayoutClass.php");
    require_once("InformacionExogenaModelClass.php");
	
    $Layout   = new InformacionExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new InformacionExogenaModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    $Layout -> setFormatos($Model -> getFormato($this -> getConex()));    
    $Layout -> setPeriodo($Model -> getPeriodo($this -> getConex()));    	
	
	$Layout -> RenderMain();
    
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[formato_exogena_id] = array(
		name	=>'formato_exogena_id',
		id		=>'formato_exogena_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'integer')
	);
	
	$this -> Campos[periodo_contable_id] = array(
		name	=>'periodo_contable_id',
		id		=>'periodo_contable_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		datatype=>array(type=>'integer')
	);	
	
  }

  protected function onclickGenerarAuxiliarExogena(){ 

	require_once("LibrosAuxiliaresLayoutClass.php");
	require_once("LibrosAuxiliaresModelClass.php");
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new LibrosAuxiliaresLayout($this -> getTitleTab(),$this -> getTitleForm());
	require_once("InformacionExogenaModelClass.php");
	$Model1    = new InformacionExogenaModel();

    $Model               = new LibrosAuxiliaresModel();	
	$utilidadesContables = new UtilidadesContablesModel();	

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
    $Layout -> setJsInclude("../../../framework/js/funciones.js");					
    $Layout -> setJsInclude("../js/librosauxiliaresReporte.js");				
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	

	$concepto = $_REQUEST['concepto'];
	$periodo  = $_REQUEST['periodo'];
	$formato  = $_REQUEST['formato'];
	$formato_exogena_id  = $_REQUEST['formato_exogena_id'];

	
	$empresa_id          = $this -> getEmpresaId();
	$reporte             = $this -> requestData('reporte');
	$opciones_centros    = 'T';	

	$centro_array    = $utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this -> getConex());

	$centro_de_costo_id='';
	for($i=0;$i<count($centro_array);$i++){
		$centro_de_costo_id.=$centro_array[$i]['value'].',';
	}
	$centro_de_costo_id = substr($centro_de_costo_id,0,-1);
	$opciones_documentos = 'T';		
	$documentos_array    = $utilidadesContables -> getDocumentos($this -> getConex());
	$documentos='';
	for($i=0;$i<count($documentos_array);$i++){
		$documentos.=$documentos_array[$i]['value'].',';
	}
	$documentos = substr($documentos,0,-1);

	$opciones_tercero    = 'U';
 	$numero_identificacion = $_REQUEST['numero_identificacion'];
	$tercero_id 		 = $Model1 -> selecttercero($numero_identificacion,$this -> getConex());
	$desde               = $periodo.'-01-01';
	$hasta               = $periodo.'-12-31';		
	$empresa             = $this -> getEmpresaNombre();
	$nitEmpresa          = $this -> getEmpresaIdentificacion();
	$centrosTxt          = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
	$fechaProcesado      = date("Y-m-d");
	$horaProcesado       = date("H:i:s");
	$agrupar	         = 'defecto';

	$cuenta_desde_id     = $Model1 -> getCuentamin($concepto,$formato_exogena_id,$this -> getConex());
	$cuenta_hasta_id     = $Model1 -> getCuentamAX($concepto,$formato_exogena_id,$this -> getConex());

	$tipo_reporte        = $this -> requestData('tipo_reporte');	

	 
	

	$arrayReport = array();
	$Conex       = $this  -> getConex();
	
	if($opciones_tercero == 'T'){
		$arrayResult  = $Model -> selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$cuenta_desde_id,$cuenta_hasta_id,$desde,$hasta,$agrupar,$consul_estado,$Conex);																 																
    }else{
		$arrayResult = $Model -> selectAuxiliarCentrosTercero($tercero_id,$empresa_id,$opciones_centros,$centro_de_costo_id,$tercero_id,$documentos,$cuenta_desde_id,$cuenta_hasta_id,$desde,$hasta,$agrupar,$consul_estado,$Conex);	  	   
																
																
	}																 
						
	if(count(arrayResult) > 0){
		
		$tercero       = null;
		$codigoPuc     = null;
		$terceroTmp    = null;
		$codigoPucTmp  = null;
		$contTercero   = -1;
		$contRegistros = 0;
		$j             = 0;
		
		for($i = 0; $i < count($arrayResult); $i++){
			
			$tercero    = $arrayResult[$i]['tercero'];
			$codigoPuc  = $arrayResult[$i]['codigo_puc'];
			$naturaleza = $Model -> getNaturalezaCodigoPuc($arrayResult[$i]['puc_id'],$Conex);
			
			if($tercero != $terceroTmp || $codigoPuc != $codigoPucTmp){
				
				if($contTercero >= 0){ 
					
					$arrayReport[$contTercero]['total_debito']  = $total_debito;	
					$arrayReport[$contTercero]['total_credito'] = $total_credito;		
					
					if($naturaleza == 'D'){
						$saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_debito) - $total_credito; 													
						$arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;				 			  
					}else{
						$saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_credito) - $total_debito; 													
						$arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;				 			  			  
					}
				}
				
				$contTercero++;
				$contRegistros = 0;			 			 			 
				$total_debito  = 0;
				$total_credito = 0;			 
				$saldoAnterior = 0;
				$nuevoSaldo    = 0;	
				$tercero_id    = $arrayResult[$i]['tercero_id'];
				$puc_id        = $arrayResult[$i]['puc_id'];
				
				$saldoAnteriorCentrosTercero = 0;
				$saldoTotalCentrosTercero    = 0;		 			 
				
				if(!strlen(trim($arrayResult[$i]['saldo'])) > 0){
					$saldo = $Model->selectSaldoCentrosTercero($tercero_id,$puc_id,$empresa_id,$opciones_centros,$centro_de_costo_id, $documentos,$puc_id,$desde,$consul_estado,$Conex);			
					$saldoAnteriorCentrosTercero = $saldo;
				}else{
					$saldo                       = $arrayResult[$i]['saldo'];
					$saldoAnteriorCentrosTercero = $arrayResult[$i]['saldo'];				 
				}
				
				$arrayReport[$contTercero]['tercero']       = strlen(trim($arrayResult[$i]['tercero']))    > 0 ? $arrayResult[$i]['tercero']    : 0;
				$arrayReport[$contTercero]['codigo_puc']    = strlen(trim($arrayResult[$i]['codigo_puc'])) > 0 ? $arrayResult[$i]['codigo_puc'] : 0;	
				$arrayReport[$contTercero]['saldo']         = $saldo;	
				
				
				$saldoAnterior  = $saldo;			 
				$arrayRegistros = $arrayResult[$i];						
				$debito         = strlen(trim($arrayRegistros['debito']))  > 0? $arrayRegistros['debito']  : 0;
				$credito        = strlen(trim($arrayRegistros['credito'])) > 0? $arrayRegistros['credito'] : 0;			 
				
				if($naturaleza == 'D'){
					$nuevoSaldo = ($saldoAnterior + $debito) - $credito;
				}else{
					$nuevoSaldo = ($saldoAnterior + $credito) - $debito;
				}
				
				$arrayRegistros['saldo'] = $nuevoSaldo;				   
				$saldoAnterior           = $nuevoSaldo;				
				
				$arrayReport[$contTercero]['registros'][$contRegistros] = $arrayRegistros;  			 
				
				$terceroTmp   = $arrayResult[$i]['tercero'];	
				$codigoPucTmp = $arrayResult[$i]['codigo_puc'];	
				
				$total_debito  += $arrayResult[$i]['debito'];	
				$total_credito += $arrayResult[$i]['credito'];	
				
				$arrayReport[$contTercero]['total_debito']  = $total_debito;	
				$arrayReport[$contTercero]['total_credito'] = $total_credito;				 
				
				if($naturaleza == 'D'){
					$saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_debito) - $total_credito; 													
					$arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;			 			 			 
				}else{
					$saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_credito) - $total_debito; 													
					$arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;			 			 			 
				}
				 
								  
			}else{
				
				$contRegistros++;			
				$arrayRegistros = $arrayResult[$i];				
				$nuevoSaldo     = 0;			
				$debito         = strlen(trim($arrayRegistros['debito']))  > 0? $arrayRegistros['debito']  : 0;
				$credito        = strlen(trim($arrayRegistros['credito'])) > 0? $arrayRegistros['credito'] : 0;			 
					
				if($naturaleza == 'D'){
					$nuevoSaldo     = ($saldoAnterior + $debito) - $credito;
				}else{
					$nuevoSaldo = ($saldoAnterior + $credito) - $debito;
				}
												
				$arrayRegistros['saldo'] = $nuevoSaldo;				   
				$saldoAnterior           = $nuevoSaldo;				
				
				$arrayReport[$contTercero]['registros'][$contRegistros] = $arrayRegistros;
				
				$total_debito  += $arrayResult[$i]['debito'];	
				$total_credito += $arrayResult[$i]['credito'];					
				$arrayReport[$contTercero]['total_debito']  = $total_debito;	
				$arrayReport[$contTercero]['total_credito'] = $total_credito;	
				if($naturaleza == 'D'){
					$saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_debito) - $total_credito; 													
					$arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;														
				}else{
					$saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_credito) - $total_debito; 													
					$arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;																		
				}
			}
		}
	}else{
		$arrayReport = array();
	}		  
	$Layout -> setVar('EMPRESA',$empresa);
	$Layout -> setVar('NIT',$nitEmpresa);	  		
	$Layout -> setVar('CENTROS',$centrosTxt);				  
	$Layout -> setVar('DESDE',$this -> mesNumericoAtexto($desde));				  
	$Layout -> setVar('HASTA',$this -> mesNumericoAtexto($hasta));				  	  	  
	$Layout -> setVar('USUARIO',$this -> getUsuarioNombres());				  	  	  	  
	$Layout -> setVar('FECHA',$fechaProcesado);				  	  	  
	$Layout -> setVar('HORA',$horaProcesado);				  	  	  	  	  
	$Layout -> setVar('REPORTE',$arrayReport);	
	
	$Layout -> RenderLayout('librosauxiliaresReporte.tpl');
	  	
	
  }
  
  protected function consul_categoria($anio,$formato_exogena_id,$categoria_exogena_id,$concepto_exogena_id){ 
 
 
	  require_once("InformacionExogenaModelClass.php");
	  $Model    = new InformacionExogenaModel();
  	  

	  $cuentas_cate = $Model -> getcuentasCategConcep($formato_exogena_id,$categoria_exogena_id,$concepto_exogena_id,$this -> getConex()); 
	  if(count($cuentas_cate)>0){ 
		 $puc_categoria='';
		 for($m=0;$m<count($cuentas_cate);$m++){
				$puc_categoria .= $cuentas_cate[$m]['puc_id'].',';		  
		 }

		//SDP - SUMA DEBITO PERIODO,SCP - SUMA CREDITO PERIODO, DCP - DEBITO - CREDITO PERIODO, CDP - CREDITO -DEBITO PERIODO, SC - SALDO AL CORTE ,  SCC - SUMA CREDITO AL CORTE, DCC - DEBITO - CREDITO AL CORTE , CDC - CREDITO -DEBITO AL CORTE 
		switch ($cuentas_cate[0]['tipo_sumatoria']){
			//SDP - SUMA DEBITO PERIODO  ok
			case 'SDP':	
				$suma1="i.debito";
				//$suma="SUM(i.debito)";
				$suma="ic.debito";
				$periodo=" AND YEAR(e.fecha)='$anio' ";
				$periodom=" AND YEAR(edc.fecha)='$anio' ";				
				break;
			//	SCP - SUMA CREDITO PERIODO  ok
			case 'SCP':
				$suma1="i.credito";			
				//$suma='SUM(i.credito)';
				$suma='ic.credito';				
				$periodo=" AND YEAR(e.fecha)='$anio' ";
				$periodom=" AND YEAR(edc.fecha)='$anio' ";				
				break;
			//DCP - DEBITO - CREDITO PERIODO	ok
			case 'DCP':
				$suma1="(i.debito-i.credito)";			
				//$suma="(SUM(i.debito)-SUM(i.credito))";
				$suma="(ic.debito-ic.credito)";
				$periodo=" AND YEAR(e.fecha)='$anio' ";
				$periodom=" AND YEAR(edc.fecha)='$anio' ";
				break;
			//CDP - CREDITO -DEBITO PERIODO  ok
			case 'CDP':
				$suma1="(i.credito-i.debito)";
				//$suma="(SUM(i.credito)-SUM(i.debito))";
				$suma="(ic.credito-ic.debito)";
				$periodo=" AND YEAR(e.fecha)='$anio' ";
				$periodom=" AND YEAR(edc.fecha)='$anio' ";
				break;
			// SCC - SUMA CREDITO AL CORTE   ok
			case 'SCC':
				$suma1="i.credito";		
				//$suma="SUM(i.credito)";
				$suma="ic.credito";				
				$periodo=" AND YEAR(e.fecha)<='$anio' ";
				$periodom=" AND YEAR(edc.fecha)<='$anio' ";
				break;
			//DCC - DEBITO - CREDITO AL CORTE   ok
			case 'DCC':
				$suma1="(i.debito-i.credito)";	
				//$suma="(SUM(i.debito)-SUM(i.credito))";
				$suma="(ic.debito-ic.credito)";
				$periodo=" AND YEAR(e.fecha)<='$anio' ";
				$periodom=" AND YEAR(edc.fecha)<='$anio' ";				
				break;
			//CDC - CREDITO -DEBITO AL CORTE  ok
			case 'CDC':
				$suma1="(i.credito-i.debito)";
				//$suma="(SUM(i.credito)-SUM(i.debito))";
				$suma="(ic.credito-ic.debito)";
				$periodo=" AND YEAR(e.fecha)<='$anio' ";
				$periodom=" AND YEAR(edc.fecha)<='$anio' ";				
				break;
		
			default:
				$suma1="(i.debito-i.credito)";	
				//$suma="(SUM(i.debito)-SUM(i.credito))";
				$suma="(ic.debito-ic.credito)";
				$periodo=" AND YEAR(e.fecha)='$anio' ";
				$periodom=" AND YEAR(edc.fecha)='$anio' ";
				
		  }

		  return array("SUM(IF(ic.puc_id IN (".substr($puc_categoria, 0, -1)."), ROUND($suma),0) )",
						"SUM(IF( i.puc_id IN (".substr($puc_categoria, 0, -1)."),ROUND($suma1),0))");		  
	  }else{
		  $cuentas_cate = $Model -> getcuentasSubCategConcep($formato_exogena_id,$categoria_exogena_id,$concepto_exogena_id,$this -> getConex()); 
		  
		  if(count($cuentas_cate)>0){

			 $puc_categoria='';
			 for($m=0;$m<count($cuentas_cate);$m++){
					$puc_categoria .= $cuentas_cate[$m]['puc_id'].',';		  
			 }
	
			//SDP - SUMA DEBITO PERIODO,SCP - SUMA CREDITO PERIODO, DCP - DEBITO - CREDITO PERIODO, CDP - CREDITO -DEBITO PERIODO, SC - SALDO AL CORTE ,  SCC - SUMA CREDITO AL CORTE, DCC - DEBITO - CREDITO AL CORTE , CDC - CREDITO -DEBITO AL CORTE 
			//$suma="SUM(i.base)";
			$suma="ic.base";
			$suma1="i.base";
			switch ($cuentas_cate[0]['tipo_sumatoria']){
				//SDP - SUMA DEBITO PERIODO  ok
				case 'SDP':	
					$periodo=" AND YEAR(e.fecha)='$anio' ";
					$periodom=" AND YEAR(edc.fecha)='$anio' ";				
					break;
				//	SCP - SUMA CREDITO PERIODO  ok
				case 'SCP':
					$periodo=" AND YEAR(e.fecha)='$anio' ";
					$periodom=" AND YEAR(edc.fecha)='$anio' ";				
					break;
				//DCP - DEBITO - CREDITO PERIODO	ok
				case 'DCP':
					$periodo=" AND YEAR(e.fecha)='$anio' ";
					$periodom=" AND YEAR(edc.fecha)='$anio' ";
					break;
				//CDP - CREDITO -DEBITO PERIODO  ok
				case 'CDP':
					$periodo=" AND YEAR(e.fecha)='$anio' ";
					$periodom=" AND YEAR(edc.fecha)='$anio' ";
					break;
				// SCC - SUMA CREDITO AL CORTE   ok
				case 'SCC':
					$periodo=" AND YEAR(e.fecha)<='$anio' ";
					$periodom=" AND YEAR(edc.fecha)<='$anio' ";
					break;
				//DCC - DEBITO - CREDITO AL CORTE   ok
				case 'DCC':
					$suma="(SUM(i.debito)-SUM(i.credito))";
					$periodo=" AND YEAR(e.fecha)<='$anio' ";
					$periodom=" AND YEAR(edc.fecha)<='$anio' ";				
					break;
				//CDC - CREDITO -DEBITO AL CORTE  ok
				case 'CDC':
					$periodo=" AND YEAR(e.fecha)<='$anio' ";
					$periodom=" AND YEAR(edc.fecha)<='$anio' ";				
					break;
			
				default:
					$periodo=" AND YEAR(e.fecha)='$anio' ";
					$periodom=" AND YEAR(edc.fecha)='$anio' ";
					
			  }
	
			  return array("SUM(IF(ic.puc_id IN (".substr($puc_categoria, 0, -1)."), ROUND($suma),0) )",
						"SUM(IF( i.puc_id IN (".substr($puc_categoria, 0, -1)."),ROUND($suma1),0))");		  
		  
		  }else{
			  return "";
		  }
	  }
  }

  protected function consul_puc_concepto($formato_exogena_id,$concepto_exogena_id){ 

    require_once("InformacionExogenaModelClass.php");
    $Model            = new InformacionExogenaModel();	
	$cuentas_concep = $Model -> getcuentasConcepto($formato_exogena_id,$concepto_exogena_id,$this -> getConex()); 
	$puc_all='';
	 for($m=0;$m<count($cuentas_concep);$m++){
			$puc_all .= $cuentas_concep[$m]['puc_id'].',';		  
	 }
	return $puc_all;

  }
  protected function generateFile(){

    require_once("InformacionExogenaLayoutClass.php");
    require_once("InformacionExogenaModelClass.php");

	$Layout   = new InformacionExogenaLayout($this -> getTitleTab(),$this -> getTitleForm());	
    $Model            = new InformacionExogenaModel();	
	$formato_exogena_id  = $_REQUEST['formato_exogena_id'];
	$periodo_contable_id = $_REQUEST['periodo_contable_id'];
	$download         = $_REQUEST['download'] > 0 ? true : false;
	
	$formato  = $Model -> selectFormato($formato_exogena_id,$this -> getConex()); 
	$dataformato  = $Model -> selectdataFormato($formato_exogena_id,$this -> getConex()); 
	$periodo  = $Model -> selectPeriodo($periodo_contable_id,$this -> getConex()); 
    $direccion = $Model -> getDatosEmpresa($this -> getEmpresaId(),$this -> getConex());
	$anio     = $periodo;	
	$anio_ant=($anio-1);	
	$fecha_fin_saldo =$anio_ant."-12-31";
	$cuantia_minima = $dataformato['cuantia_minima'];
	$cuantias_menores = $dataformato['cuantias_menores'];
	$nombre_tercero = $dataformato['nombre_tercero'];	
	$tipo_doc = $dataformato['tipo_doc'];		
	
	$categoriaExogena  = $Model -> getcategoriaExogena($formato,$this -> getConex()); 
	$conceptoExogena  = $Model -> getconceptoExogena($formato_exogena_id,$this -> getConex()); 

	if(count($conceptoExogena)>0){ 
	
	
		if($formato=='1001' || $formato=='1056'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Concepto</th>
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>		
			<th class="borderLeft borderTop borderRight">Direcci&oacute;n</th>	
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>	
			<th class="borderLeft borderTop borderRight">Pa&iacute;s domicilio</th>	';
			

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) divipola FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,";

			
		}elseif($formato=='1003'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Concepto</th>
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">DV</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>		
			<th class="borderLeft borderTop borderRight">Direcci&oacute;n</th>	
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.digito_verificacion AS DV,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,";

		

		}elseif($formato=='1004'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Concepto</th>
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>		
			<th class="borderLeft borderTop borderRight">Direcci&oacute;n</th>	
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>
			<th class="borderLeft borderTop borderRight">Pa&iacute;s domicilio</th>
			<th class="borderLeft borderTop borderRight">Correo</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,
			t.email AS correo,";


		}elseif($formato=='1005' || $formato=='1006'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">DV</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.digito_verificacion AS DV,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,";

		


		}elseif($formato=='1007'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Concepto</th>
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>		
			<th class="borderLeft borderTop borderRight">Pa&iacute;s domicilio</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,";

			
		}elseif($formato=='1008' || $formato=='1009' || $formato=='1010'){
			
			$campostpl = $formato=='1010' ? '' : '<th class="borderLeft borderTop borderRight">Concepto</th>';
			$campostpl .= '
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">DV</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>		
			<th class="borderLeft borderTop borderRight">Direcci&oacute;n</th>	
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>
			<th class="borderLeft borderTop borderRight">Pa&iacute;s domicilio</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.digito_verificacion AS DV,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,";

			
		}elseif($formato=='1647'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Concepto</th>
			<th class="borderLeft borderTop borderRight">Tipo Documento de quien se recibe ingreso</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion de quien se recibe ingreso</th>
			<th class="borderLeft borderTop borderRight">DV</th>			
			<th class="borderLeft borderTop borderRight">Primer Apellido de quien se recibe ingreso</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido de quien se recibe ingreso</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre de quien se recibe ingreso</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres de quien se recibe ingreso</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social de quien se recibe ingreso</th>		
			<th class="borderLeft borderTop borderRight">Pais de residencia o domicilio de quien se recibe ingreso</th>';

			$campostpl_1 = '
			<th class="borderLeft borderTop borderRight">Tipo Documento para  quien se recibio ingreso</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion para  quien se recibio ingreso</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido para  quien se recibio ingreso</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido para  quien se recibio ingreso</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre para  quien se recibio ingreso</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres para  quien se recibio ingreso</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social para  quien se recibio ingreso</th>
			<th class="borderLeft borderTop borderRight">direccion</th>
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>
			<th class="borderLeft borderTop borderRight">Pais de residencia o domicilio para  quien se recibio ingreso</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=te.tipo_identificacion_id) AS tipo_de_documento_de_quien_se_recibe_ingreso,
			te.numero_identificacion AS numero_identificacion_de_quien_se_recibe_ingreso,
			te.digito_verificacion AS DV,
			te.primer_apellido AS primer_apellido_de_quien_se_recibe_ingreso,
			te.segundo_apellido AS segundo_apellido_de_quien_se_recibe_ingreso,
			te.primer_nombre AS primer_nombre_de_quien_se_recibe_ingreso,
			te.segundo_nombre  AS otros_nombres_de_quien_se_recibe_ingreso,
			te.razon_social AS razon_social_de_quien_se_recibe_ingreso,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=te.ubicacion_id))) AS pais_domicilio_de_quien_se_recibe_ingreso,";

			$campos_1 = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento_para_quien_se_recibio_ingreso,
			t.numero_identificacion AS numero_identificacion_para_quien_se_recibio_ingreso,
			t.primer_apellido AS primer_apellido_para_quien_se_recibio_ingreso,
			t.segundo_apellido AS segundo_apellido_para_quien_se_recibio_ingreso,
			t.primer_nombre AS primer_nombre_para_quien_se_recibio_ingreso,
			t.segundo_nombre  AS otros_nombres_para_quien_se_recibio_ingreso,
			t.razon_social AS razon_social_para_quien_se_recibio_ingreso,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio";


		}elseif($formato=='1011'){
			$campostpl = '<th class="borderLeft borderTop borderRight">Concepto</th>';
			$campostpl_1 = '';
			$campos = "";

		}elseif($formato=='2276'){

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Direcci&oacute;n</th>	
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>
			<th class="borderLeft borderTop borderRight">Pa&iacute;s domicilio</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,";

			
		}else{

			$campostpl = '
			<th class="borderLeft borderTop borderRight">Concepto</th>
			<th class="borderLeft borderTop borderRight">Tipo Documento</th>
			<th class="borderLeft borderTop borderRight">Numero identificacion</th>
			<th class="borderLeft borderTop borderRight">DV</th>
			<th class="borderLeft borderTop borderRight">Primer Apellido</th>				
			<th class="borderLeft borderTop borderRight">Segundo Apellido</th>				
			<th class="borderLeft borderTop borderRight">Primer Nombre</th>		
			<th class="borderLeft borderTop borderRight">Otros Nombres</th>		
			<th class="borderLeft borderTop borderRight">Raz&oacute;n Social</th>		
			<th class="borderLeft borderTop borderRight">Direcci&oacute;n</th>	
			<th class="borderLeft borderTop borderRight">Cod depto</th>	
			<th class="borderLeft borderTop borderRight">Cod Muni</th>
			<th class="borderLeft borderTop borderRight">Pa&iacute;s domicilio</th>';

			$campos = "
			(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_de_documento,
			t.numero_identificacion,
			t.digito_verificacion AS DV,
			t.primer_apellido AS primer_apellido_del_informado,
			t.segundo_apellido AS segundo_apellido_del_informado,
			t.primer_nombre AS primer_nombre_del_informado,
			t.segundo_nombre  AS otros_nombres_del_informado,
			t.razon_social AS razon_social_informado,
			t.direccion,
			(SELECT SUBSTR(divipola, 1, 2) FROM ubicacion WHERE ubicacion_id = (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id)) AS cod_depto,
			(SELECT SUBSTR(divipola,3,4) FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS cod_muni,
			(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id= (SELECT  ubi_ubicacion_id FROM ubicacion WHERE  ubicacion_id=t.ubicacion_id))) AS pais_domicilio,";

	

		}
		
		$select = '';
		$select_c = '';
		$cadena='';
		$concepto='';
		$cate_array=array();

		for($i=0;$i<count($conceptoExogena);$i++){
			$validar_periodo = $Model -> getValPeriodo($formato_exogena_id,$conceptoExogena[$i]['concepto_exogena_id'],$this -> getConex()); 
			$periodo_todos= count($validar_periodo)>0 ? " AND YEAR(er.fecha)<='$anio' " : " AND YEAR(er.fecha)='$anio' ";
			$periodo_todos1= count($validar_periodo)>0 ? " AND YEAR(e.fecha)<='$anio' " : " AND YEAR(e.fecha)='$anio' ";
			
			$concepto = $conceptoExogena[$i]['concepto'];
			$cadena =  '';
			$puc_todos = $this->consul_puc_concepto($formato_exogena_id,$conceptoExogena[$i]['concepto_exogena_id']);

						
			for($l=0;$l<count($categoriaExogena);$l++){
				if($i==0){ $cate_tpl .= '<th class="borderLeft borderTop borderRight">'.$categoriaExogena[$l]['categoria_nombre'].'</th>'; }
				$categoria = strtolower(str_replace(array(' ',',','.','/','*','-','+',')','('),'_',$categoriaExogena[$l]['categoria_nombre']));
				$cate_array[$l]=$categoria;
				$subcon_cate = $this->consul_categoria($anio,$formato_exogena_id,$categoriaExogena[$l]['categoria_exogena_id'],$conceptoExogena[$i]['concepto_exogena_id']);
				$cadena.= $subcon_cate!='' ? "IFNULL(".$subcon_cate[0].",0) AS  $categoria," :  "'0' AS $categoria,";
				
			}
			
			if($formato=='1001'  || $formato=='1003' || $formato=='1004' || $formato=='1007' || $formato=='1008' || $formato=='1009' || $formato=='1011' || $formato=='1056' || $formato=='1647' ){
				$concepto_final= "'$concepto' AS concepto, ";
			}elseif($formato=='1005' || $formato=='1006' || $formato=='1010' || $formato=='2276'){
				$concepto_final= "";	
			}else{
				$concepto_final= "'$concepto' AS concepto, ";
			}

			if($formato==1647){
				$select_c = "(SELECT $concepto_final
				$campos
				".$cadena."
				$campos_1
				FROM  imputacion_contable ic, encabezado_de_registro er, tercero t, tercero te,  tipo_de_documento td   
				WHERE ic.puc_id IN (".substr($puc_todos, 0, -1).") 
				AND t.tercero_id=ic.tercero_id AND  er.encabezado_registro_id=ic.encabezado_registro_id AND er.estado='C' $periodo_todos 
				AND td.tipo_documento_id=er.tipo_documento_id AND td.de_cierre='0' AND te.tercero_id=er.tercero_id
				
				GROUP BY te.tercero_id, t.tercero_id )";
				
				$select = $select=='' ?  $select_c  :$select.' UNION ALL '.$select_c;

			}elseif($formato==1011){
				//cuantias totales por concepto
				$select_c = "(SELECT $concepto_final
				".substr($cadena, 0, -1)."
	
				FROM  imputacion_contable ic, encabezado_de_registro er,   tipo_de_documento td   
				WHERE ic.puc_id IN (".substr($puc_todos, 0, -1).") 
				AND  er.encabezado_registro_id=ic.encabezado_registro_id AND er.estado='C' $periodo_todos 
				AND td.tipo_documento_id=er.tipo_documento_id AND td.de_cierre='0')";
				
				$select = $select=='' ?  $select_c  :$select.' UNION ALL '.$select_c;

			}else{
				//cuantias totales por tercero
				$consul_iden = $formato==2276 ? " AND t.tipo_identificacion_id!=2 " : "";
				$select_c = "(SELECT $concepto_final
				$campos
				".substr($cadena, 0, -1)."
	
				FROM  imputacion_contable ic, encabezado_de_registro er, tercero t,  tipo_de_documento td   
				WHERE ic.puc_id IN (".substr($puc_todos, 0, -1).") 
				AND t.tercero_id=ic.tercero_id AND  er.encabezado_registro_id=ic.encabezado_registro_id AND er.estado='C' $periodo_todos 
				AND td.tipo_documento_id=er.tipo_documento_id AND td.de_cierre='0' $consul_iden 
				
				GROUP BY t.tercero_id )";
				
				$select = $select=='' ?  $select_c  :$select.' UNION ALL '.$select_c;
			}

		}
		//echo $select;
		//exit();
		
	}else{
		exit('No existen Par&aacute;metros Configurados para Este Formato');	
	}
	$data  = $Model -> selectDataExogena($select,$this -> getConex());   
	$canti_cate= count($cate_array);
	$dataf=array();
	$data_men=array();	
	$x=0;
	$z=0;
	foreach($data as $datos){
		$superior='no';	
		//cuando exite cuantia minima configurada
		if($cuantia_minima>0){
			for($y=0;$y<$canti_cate;$y++){
				if($datos[$cate_array[$y]]>=$cuantia_minima){
					$superior='si';
				}
				
			}
			if($superior=='si'){
				$dataf[$x]=$datos;
				$x++;
			}else{
				for($y=0;$y<$canti_cate;$y++){
					if($datos[$cate_array[$y]]>0 &&  $datos[$cate_array[$y]]<$cuantia_minima){
						$superior='si';
					}
				}
				if($superior=='si'){
					$posicion  = array_search($datos['concepto'], array_column($data_men, 'concepto'));
					if(is_numeric($posicion)){

						for($y=0;$y<$canti_cate;$y++){
							if($datos[$cate_array[$y]]>0 &&  $datos[$cate_array[$y]]<$cuantia_minima){
								$data_men[$posicion][$cate_array[$y]]=($datos[$cate_array[$y]]+$data_men[$posicion][$cate_array[$y]]);
							}
						}


					}else{


						$data_men[$z]=$datos;
						$data_men[$z]['tipo_de_documento']=$tipo_doc;
						$data_men[$z]['numero_identificacion']=$cuantias_menores;
						$data_men[$z]['primer_apellido_del_informado']='';
						$data_men[$z]['segundo_apellido_del_informado']='';
						$data_men[$z]['primer_nombre_del_informado']='';
						$data_men[$z]['otros_nombres_del_informado']='';
						$data_men[$z]['razon_social_informado']=$nombre_tercero;
						if($data_men[$z]['direccion']!=''){  $data_men[$z]['direccion']=$direccion;  }
						if($data_men[$z]['cod_depto']!=''){  $data_men[$z]['cod_depto']='25';  }						
						if($data_men[$z]['cod_muni']!=''){  $data_men[$z]['cod_muni']='001';  }						
						if($data_men[$z]['pais_domicilio']!=''){  $data_men[$z]['pais_domicilio']='169';  }	
						if($data_men[$z]['DV']!=''){  $data_men[$z]['DV']='';  }							
						
						for($y=0;$y<$canti_cate;$y++){
							if($datos[$cate_array[$y]]>0 &&  $datos[$cate_array[$y]]<$cuantia_minima){
								$data_men[$z][$cate_array[$y]]=($datos[$cate_array[$y]]+$data_men[$z][$cate_array[$y]]);
								
							}
						}
						$z++;
						
					}
				}
				
			}
		//cuando no exite cuantia minima configurada
		}else{
			for($y=0;$y<$canti_cate;$y++){
				if($datos[$cate_array[$y]]>=0){
					$superior='si';
				}
			}
			
			if($superior=='si'){
				$dataf[$x]=$datos;
				$x++;
			}
		}
	}
	$datafin = array_merge($dataf, $data_men);
	if($download){
    	$ruta  = $this -> arrayToExcel("archivoReporteExogena","Exogena ".$formato,$datafin,null,"string");
    	$this -> ForceDownload($ruta,"Exogena_F".$formato.'_Periodo_'.$periodo.'_Creado'.date('Y-m-d').".xls");
		echo 'Generado Exitosamente';
	}else{

		$Layout -> setCssInclude("../../../framework/css/reset.css");			
		$Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
		$Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
		$Layout -> setJsInclude("../../../framework/js/funciones.js");					
		$Layout -> setJsInclude("../js/librosauxiliaresReporte.js");				
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
		
		$Layout -> setVar('DATA',$datafin);
		$Layout -> setVar('ANIO',$anio);
		$Layout -> setVar('FORMATO',$formato);
		$Layout -> setVar('FORMATOID',$formato_exogena_id);		
		$Layout -> setVar('campostpl',$campostpl);
		$Layout -> setVar('campostpl_1',$campostpl_1);
		
		
		$Layout -> setVar('cate_tpl',$cate_tpl);	
		
		$Layout -> RenderLayout('ResultExogena.tpl');
	}
	  
  }

}
new InformacionExogena();
?>