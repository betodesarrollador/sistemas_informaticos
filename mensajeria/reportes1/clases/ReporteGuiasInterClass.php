<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class ReporteGuiasInter extends Controler{

	public function __construct(){
		parent::__construct(3);
	}  

	public function Main(){

		$this -> noCache();

		require_once("ReporteGuiasInterLayoutClass.php");
		require_once("ReporteGuiasInterModelClass.php");

		$Layout   = new ReporteGuiasInterLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ReporteGuiasInterModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);

		
		$cliente_id=$resultado[0]['cliente_id'];
		$cliente=$resultado[0]['cliente'];
		echo $cliente_id;
		//LISTA MENU

		$Layout -> SetSi_Cli ($Model -> GetSi_Cli ($this -> getConex()));
		$Layout -> SetEstado ($Model -> GetEstado ($this -> getConex()));
		$Layout -> SetServicio($Model -> GetServicio ($this -> getConex()));		
		$Layout -> SetOficina($Model -> GetOficina($this -> getOficinaId(),	$this -> getEmpresaId(),$this -> getConex()));
		$Layout -> setCliente($Model  -> SetCliente($this -> getUsuarioId(),$this -> getConex()));

		$Layout -> RenderMain();
		}

		protected function generateFile(){

			require_once("ReporteGuiasInterLayoutClass.php");
			require_once("ReporteGuiasInterModelClass.php");

			$Model     = new ReporteGuiasInterModel();
			$Layout    = new ReporteGuiasInterLayout();

			$destino_id				= $_REQUEST['destino_id'];
			$estado_id				= $_REQUEST['estado_id'];
			$desde					= $_REQUEST['desde'];
			$hasta					= $_REQUEST['hasta'];
			$si_cliente				= $_REQUEST['si_cliente'];
			$cliente_id				= $_REQUEST['cliente_id'];
			$all_estado 			= $_REQUEST['all_estado'];
			$all_clase 			    = $_REQUEST['all_clase'];
			$origen_id				= $_REQUEST['origen_id'];

			if($all_estado == 'SI'){
				$estado = str_replace(',',"','",$estado_id);
			}else{	 
				$estado = str_replace(',',"','",$estado_id);
			}

			if($all_clase == 'SI'){
				$clase = str_replace(',',"','",$origen_id);
			}else{	 
				$clase = str_replace(',',"','",$origen_id);
			}	

			if($si_cliente=='ALL') $consulta_cliente=""; else $consulta_cliente=" AND r.cliente_id =".$cliente_id;

			$data  = $Model -> getReporte1($destino_id,$estado,$desde,$hasta,$consulta_cliente,$clase,$this -> getConex());

			$ruta  = $this -> arrayToExcel("ReporRemesas","Reporte Remesas",$data,null);

			if($_REQUEST['download'] == 'SI'){
				$this -> ForceDownload($ruta);
			}else{
				print json_encode(array(ruta => $ruta, errores => $data[0]['validaciones']));
			}
		}

		/*
		protected function onclickPrint(){
		require_once("Imp_DocumentoClass.php");
		$print = new Imp_Documento($this -> getConex());
		$print -> printOut();

		}*/  

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

			$this -> Campos[si_cliente] = array(
				name	=>'si_cliente',
				id		=>'si_cliente',
				type	=>'select',
				options	=>null,
				selected=>0,
				required=>'yes',
				onchange=>'Cliente_si();'
			);

			$this -> Campos[cliente_id] = array(
				name	=>'cliente_id',
				id		=>'cliente_id',
				type	=>'hidden',
				value	=>$cliente_id,
				datatype=>array(
					type	=>'integer',
					length	=>'20')
			);

			$this -> Campos[cliente] = array(
				name	=>'cliente',
				id		=>'cliente',
				type	=>'text',
				disabled=>'disabled',
				value	=>$cliente,
				suggest=>array(
					name	=>'cliente',
					setId	=>'cliente_id')
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
				datatype=>array(
					type=>'integer',
					length=>'20')
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
				datatype=>array(
					type=>'integer',
					length=>'20')
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

			$this -> Campos[excel_formato] = array(
				name	=>'excel_formato',
				id		=>'excel_formato',
				type	=>'button',
				value	=>'Generar Excel Formato',
				onclick =>'OnclickGenerarExcelFormato(this.form)'
			);

			$this -> Campos[fotos] = array(
				name	=>'fotos',
				id		=>'fotos',
				type	=>'button',
				value	=>'Generar Zip Fotos',
				onclick =>'OnclickGenerarFotos(this.form)'
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
	$ReporteGuiasInter = new ReporteGuiasInter();
?>