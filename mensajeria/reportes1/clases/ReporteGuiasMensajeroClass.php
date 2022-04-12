<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class ReporteGuiasMensajero extends Controler{

		public function __construct(){
			parent::__construct(3);
		}


		public function Main(){

			$this -> noCache();
			require_once("ReporteGuiasMensajeroLayoutClass.php");
			require_once("ReporteGuiasMensajeroModelClass.php");

			$Layout   = new ReporteGuiasMensajeroLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new ReporteGuiasMensajeroModel();
			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
			$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
			$Layout -> setCampos($this -> Campos);
			//LISTA MENU
			$Layout -> SetSi_Me ($Model -> GetSi_Me ($this -> getConex()));
			$Layout -> SetSi_Usu ($Model -> GetSi_Usu ($this -> getConex()));
			$Layout -> SetEstado ($Model -> GetEstado ($this -> getConex()));
			$Layout -> SetServicio ($Model -> GetServicio ($this -> getConex()));			
			$Layout -> SetOficina($Model -> GetOficina($this -> getOficinaId(),$this -> getEmpresaId(),$this -> getConex()));

			$Layout -> RenderMain();
		}


		protected function generateReport(){

			require_once("ReporteGuiasMensajeroLayoutClass.php");
			require_once("ReporteGuiasMensajeroModelClass.php");

			$Layout					= new ReporteGuiasMensajeroLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model					= new ReporteGuiasMensajeroModel();

			$Conex					= $this -> getConex();
			$guia_id				= $_REQUEST['guia_id'];
			$allguia				= $_REQUEST['allguia'];
			$allreexpedido			= $_REQUEST['allreexpedido'];
			$reexpedido				= $_REQUEST['reexpedido'];
			$consolidado			= $_REQUEST['consolidado'];
			$download				= $_REQUEST['download'];
			$formato				= $_REQUEST['formato'];
			$peso					= $_REQUEST['peso'];

			if ($allguia=='N' AND $allreexpedido=='N'){

				$desde							= $_REQUEST['desde'];
				$hasta							= $_REQUEST['hasta'];
				$origen							= $_REQUEST['origen'];
				$origen_id						= $_REQUEST['origen_id'];
				$destino						= $_REQUEST['destino'];
				$destino_id						= $_REQUEST['destino_id'];
				$estado_id						= $_REQUEST['estado_id'];
				$tipo_servicio_mensajeria_id	= $_REQUEST['tipo_servicio_mensajeria_id'];				
				$mensajero_id					= $_REQUEST['mensajero_id'];
				$usuario_id						= $_REQUEST['usuario_id'];
				$oficina						= $_REQUEST['oficina_id'];

				$si_mensajero			= $_REQUEST['si_mensajero'];
				$si_usuario				= $_REQUEST['si_usuario'];				
				$all_estado				= $_REQUEST['all_estado'];
				$all_servicio			= $_REQUEST['all_servicio'];
				
				

				// $Layout -> setIncludes();
				if ($origen=='' || $origen=='NULL' || $origen==NULL){
					$consulta_origen=" ";
				}else{
					$consulta_origen=" AND g.origen_id=".$origen_id;
				} 

				if ($destino=='' || $destino=='NULL' || $destino==NULL){
					$consulta_destino=" ";
				}else{
					$consulta_destino=" AND g.destino_id=".$destino_id;
				}
				if ($si_mensajero=='' || $si_mensajero=='NULL' || $si_mensajero==NULL || $si_mensajero=='ALL'){
					$consulta_mensajero=" ";
				}else {
					$consulta_mensajero=" AND g.guia_id IN (SELECT dd.guia_id FROM reexpedido r, detalle_despacho_guia dd WHERE  r.proveedor_id =".$mensajero_id." AND dd.reexpedido_id=r.reexpedido_id)";
				}
				if ($si_usuario=='' || $si_usuario=='NULL' || $si_usuario==NULL || $si_usuario=='ALL'){
					$consulta_usuario=" ";
				}else {
					$consulta_usuario=" AND g.usuario_id =".$usuario_id;
				}

				//$arrayReporte=$Model -> getReporte1($desde,$hasta,$oficina,$estado_id,$tipo_servicio_mensajeria_id,$consulta_origen,$consulta_destino,$consulta_usuario,$consulta_peso,$consulta_mensajero,$this -> getConex());

			}
			if ($allreexpedido=='S' || $allguia=='S') {

				if ($allguia=='S') {
					$guia_ids = str_replace(",","','",$guia_id);
					$documento=" CONCAT_WS('',g.prefijo,g.numero_guia) IN ('".$guia_ids."')";
					$arrayReporte=$Model -> getReporte3($documento,$Conex); 
				}elseif ($allreexpedido=='S') {
					if($consolidado=='S'){
						$documento="g.guia_id=dg.guia_id AND g.estado_mensajeria_id=4 AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido;
						$transito=$Model -> getReporte4($documento,$Conex);
						
						$documento="g.guia_id=dg.guia_id AND g.estado_mensajeria_id=6 AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido;
						$entregado=$Model -> getReporte4($documento,$Conex);
						
						$documento="g.guia_id=dg.guia_id AND g.estado_mensajeria_id=7 AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido;
						$devuelto=$Model -> getReporte4($documento,$Conex);
					}else{
						$documento="g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido;
						$arrayReporte=$Model -> getReporte2($documento,$Conex);
					}
				}
			}
			
			if($peso=='N'){
				$consulta_peso=" AND g.peso <= 5000";
				}elseif($peso=='T'){
					$consulta_peso=" ";
					}else{
						$consulta_peso=" AND g.peso > 5000";
						}
					
			$arrayReporte=$Model -> getReporte1($desde,$hasta,$oficina,$estado_id,$tipo_servicio_mensajeria_id,$consulta_origen,$consulta_destino,$consulta_usuario,$consulta_peso,$consulta_mensajero,$this -> getConex());

			$Layout -> setCssInclude("/velotax/framework/css/reset.css");
			$Layout -> setCssInclude("/velotax/mensajeria/reportes/css/reportes.css");
			$Layout -> setCssInclude("/velotax/mensajeria/reportes/css/detalles.css");
			$Layout -> setCssInclude("/velotax/mensajeria/reportes/css/reportes.css","print");
			$Layout -> setJsInclude("/velotax/framework/js/jquery-1.4.4.min.js");
			$Layout -> setJsInclude("/velotax/framework/js/funciones.js");
			$Layout -> setJsInclude("/velotax/mensajeria/reportes/js/ReporteGuiasMensajero.js");
			$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
			$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
			$Layout -> setVar('EMPRESA',$empresa);
			$Layout -> setVar('NIT',$nitEmpresa);

			$Layout -> setVar('DESDE',$desde);
			$Layout -> setVar('HASTA',$hasta);
			$Layout -> setVar('ORIGEN',$origen);
			$Layout -> setVar('ESTADO', $estado_id);
			$Layout -> setVar('SERVICIO', $tipo_servicio_mensajeria_id);			
			$Layout -> setVar('DESTINO', $destino_id);
			$Layout -> setVar('MENSAJERO', $mensajero_id);
			$Layout -> setVar('USUARIO', $usuario_id);
			$Layout -> setVar('TRANSITO', $transito);
			$Layout -> setVar('ENTREGADO', $entregado);
			$Layout -> setVar('DEVUELTO', $devuelto);
			$Layout -> setVar('DETALLES', $arrayReporte); 
			$Layout -> setVar('PESO', $peso);

			if($download == 'true'){
				if($formato=='SI'){
					if($_REQUEST['filtrado']=='SI'){
						$Layout -> exportToExcel('DetallesReporteGuiasMensajero1filtro.tpl');
					}else{
						$Layout -> exportToExcel('DetallesReporteGuiasMensajero1.tpl');						
					}
				}else{
				  $Layout -> exportToExcel('DetallesReporteGuiasMensajero.tpl');
				}
			}else{ 
				$Layout -> RenderLayout('DetallesReporteGuiasMensajero.tpl');
			}
		}

		// protected function generateFile(){

		// require_once("ReporteGuiasMensajeroModelClass.php");

		// $Model     = new ReporteGuiasMensajeroModel();	

		// $desde					= $_REQUEST['desde'];
		// $hasta					= $_REQUEST['hasta'];
		// $origen  				= $_REQUEST['origen'];
		// $origen_id				= $_REQUEST['origen_id'];
		// $destino  				= $_REQUEST['destino'];
		// $destino_id				= $_REQUEST['destino_id'];
		// $estado_id				= $_REQUEST['estado_id'];
		// $mensajero_id				= $_REQUEST['mensajero_id'];

		// $si_mensajero				= $_REQUEST['si_mensajero'];
		// $all_estado				= $_REQUEST['all_estado'];


		// if ($origen=='' || $origen=='NULL' || $origen==NULL){
		// $consulta_origen="";
		// }
		// else $consulta_origen=" AND g.origen_id=".$origen_id;

		// if ($destino=='' || $destino=='NULL' || $destino==NULL){
		// $consulta_destino="";
		// }
		// else $consulta_destino=" AND g.destino_id=".$destino_id;

		// if ($si_mensajero=='' || $si_mensajero=='NULL' || $si_mensajero==NULL || $si_mensajero=='ALL'){
		// $consulta_mensajero="";
		// }
		// else $consulta_mensajero=" AND g.mensajero_id =".$mensajero_id;

		// $data  = $Model -> getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$consulta_mensajero,$this -> getConex());


		// $Layout -> setCssInclude("../../framework/css/reset.css");
		// $Layout -> setCssInclude("../css/reportes.css");
		// $Layout -> setCssInclude("../css/reportes.css","print");
		// $Layout -> setJsInclude("../../framework/js/jquery-1.4.4.min.js");
		// $Layout -> setJsInclude("../../framework/js/funciones.js");
		// $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		// $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		// $Layout -> setVar('NIVEL',$nivel);
		// $Layout -> setVar('EMPRESA',$empresa);
		// $Layout -> setVar('NIT',$nitEmpresa);
		// $Layout -> setVar('CENTROS',$centrosTxt);
		// $Layout -> setVar('HASTA',$hasta);
		// $Layout -> setVar('parametros',$parametros);
		// $Layout -> setVar('arrayResult',$arrayReporte);
		// $Layout -> setVar('documentos',$this -> getTiposDocumentoContable($utilidadesContables,$Conex));
		// $Layout -> setVar('centro_de_costo_id',$centro_de_costo_id);
		// $Layout -> setVar('opciones_centros',$opciones_centros);
		// $Layout -> setVar('opciones_tercero','T');
		// $Layout -> setVar('EMPRESAID',$empresa_id);
		// $Layout -> setVar('hasta',$hasta);







		// $ruta  = $this -> arrayToExcel("ReporGuias","Reporte Guias",$data,null);

		// if($_REQUEST['download'] == 'SI'){
		// $this -> ForceDownload($ruta);	
		// }else{
		// print json_encode(array(ruta => $ruta, errores => $data[0]['validaciones']));	
		// }  
		// }

		/*
		protected function onclickPrint(){
		require_once("Imp_DocumentoClass.php");
		$print = new Imp_Documento($this -> getConex());
		$print -> printOut();

		} */ 

		//DEFINICION CAMPOS DE FORMULARIO
		protected function setCampos(){

			$this -> Campos[desde] = array(
				name	=>'desde',
				id		=>'desde',
				type	=>'text',
				required=>'yes',
				datatype=>array(
				type	=>'date',
				length	=>'10')
			);
			$this -> Campos[hasta] = array(
				name	=>'hasta',
				id		=>'hasta',
				type	=>'text',
				required=>'yes',
				datatype=>array(
				type	=>'date',
				length	=>'10')
			);

			$this -> Campos[estado_id] = array(
				name	=>'estado_id',
				id		=>'estado_id',
				type	=>'select',
				required=>'yes',
				multiple=>'yes'
			);	
			$this -> Campos[all_estado] = array(
				name	=>'all_estado',
				id		=>'all_estado',
				type	=>'checkbox',
				onclick =>'all_estados();',
				value	=>'NO'
			);	

			$this -> Campos[tipo_servicio_mensajeria_id] = array(
				name	=>'tipo_servicio_mensajeria_id',
				id		=>'tipo_servicio_mensajeria_id',
				type	=>'select',
				required=>'yes',
				multiple=>'yes'
			);	
			$this -> Campos[all_servicio] = array(
				name	=>'all_servicio',
				id		=>'all_servicio',
				type	=>'checkbox',
				onclick =>'all_servicios();',
				value	=>'NO'
			);
			
			$this -> Campos[si_mensajero] = array(
				name	=>'si_mensajero',
				id		=>'si_mensajero',
				type	=>'select',
				options	=>null,
				selected=>0,
				required=>'yes',
				onchange=>'Mensajero_si();'
			);

			$this -> Campos[peso] = array(
				name	=>'peso',
				id		=>'peso',
				type	=>'select',
				selected=>'T',
				//required=>'yes',
				options =>array(array(value=>'N',text=>'MENOR A 5000grs'),array(value=>'S',text=>'MAYOR A 5000grs'),array(value=>'T',text=>'TODOS'))
			);
			
			$this -> Campos[mensajero_id] = array(
				name	=>'mensajero_id',
				id		=>'mensajero_id',
				type	=>'hidden',
				value	=>'',
				datatype=>array(
				type	=>'integer',
				length	=>'20')
			);
			
			$this -> Campos[mensajero] = array(
				name	=>'mensajero',
				id		=>'mensajero',
				type	=>'text',
				disabled=>'disabled',
				suggest=>array(
				name	=>'mensajero',
				setId	=>'mensajero_id')
			);	

			$this -> Campos[si_usuario] = array(
				name	=>'si_usuario',
				id		=>'si_usuario',
				type	=>'select',
				options	=>null,
				selected=>0,
				required=>'yes',
				onchange=>'Usuario_si();'
			);
			$this -> Campos[usuario_id] = array(
				name	=>'usuario_id',
				id		=>'usuario_id',
				type	=>'hidden',
				value	=>'',
				datatype=>array(
				type	=>'integer',
				length	=>'20')
			);
			$this -> Campos[usuario] = array(
				name	=>'usuario',
				id		=>'usuario',
				type	=>'text',
				disabled=>'disabled',
				suggest=>array(
				name	=>'usuario_disponible',
				setId	=>'usuario_id')
			);	


			$this -> Campos[origen] = array(
				name=>'origen',
				id=>'origen',
				type=>'text',
				size=>16,
				suggest=>array(
					name=>'ciudad',
					setId=>'origen_id')
			); 
			$this -> Campos[origen_id] = array(
				name=>'origen_id',
				id=>'origen_id',
				type=>'hidden',
				// required=>'yes',	
				datatype=>array(
					type=>'integer',
					length=>'20')
			);



			$this -> Campos[guia_id] = array(
				name=>'guia_id',
				id=>'guia_id',
				// required=>'yes',
				type=>'text',
				disabled=>'true'
			); 
			$this -> Campos[allguia] = array(
				name	=>'allguia',
				id		=>'allguia',
				type	=>'select',
				onchange=>'sologuia();',
				selected=>'N',
				required=>'yes',
				options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO'))
			);



			$this -> Campos[reexpedido] = array(
				name=>'reexpedido',
				id=>'reexpedido',
				// required=>'yes',
				type=>'text',
				disabled=>'true',
				datatype=>array(
					type=>'integer',
					length=>'20')
			); 
			
			$this -> Campos[allreexpedido] = array(
				name	=>'allreexpedido',
				id		=>'allreexpedido',
				type	=>'select',
				onchange=>'soloreexpedido();',
				selected=>'N',
				required=>'yes',
				options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO'))
			); 
			
			$this -> Campos[consolidado] = array(
				name	=>'consolidado',
				id		=>'consolidado',
				type	=>'select',
				selected=>'N',
				required=>'yes',
				disabled=>'true',
				options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO'))
			);	



			$this -> Campos[destino] = array(
				name=>'destino',
				id=>'destino',
				type=>'text',
				size=>16,
				suggest=>array(
					name=>'ciudad',
					setId=>'destino_id')
			);
			$this -> Campos[destino_id] = array(
				name=>'destino_id',
				id=>'destino_id',
				type=>'hidden',
				value=>'',
				// required=>'yes',
				datatype=>array(
					type=>'integer',
					length=>'20')
			);

			$this -> Campos[oficina_id] = array(
				name	=>'oficina_id',
				id		=>'oficina_id',
				type	=>'select',
				required=>'yes',
				multiple=>'yes'
			);	

			$this -> Campos[all_oficina] = array(
				name	=>'all_oficina',
				id		=>'all_oficina',
				type	=>'checkbox',
				onclick =>'all_oficce();',
				value	=>'NO'
			);	



			/////// BOTONES 

			$this -> Campos[generar] = array(
			name	=>'generar',
			id		=>'generar',
			type	=>'button',
			value	=>'Generar',
			onclick =>'OnclickGenerar(this.form)'
			);		

			$this -> Campos[generar_excel] = array(
			name	=>'generar_excel',
			id		=>'generar_excel',
			type	=>'button',
			value	=>'Generar Excel',
			onclick =>'OnclickGenerarExcel(this.form)'
			);
			
			$this -> Campos[excel_formato1] = array(
				name	=>'excel_formato1',
				id		=>'excel_formato1',
				type	=>'button',
				value	=>'Generar Excel Filtrado',
				onclick =>'OnclickGenerarExcelFiltrado(this.form)'
			);


			$this -> Campos[imprimir] = array(
			name   =>'imprimir',
			id   =>'imprimir',
			type   =>'button',
			value   =>'Imprimir',
			onclick =>'beforePrint(this.form)'
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$ReporteGuiasMensajero = new ReporteGuiasMensajero();
?>