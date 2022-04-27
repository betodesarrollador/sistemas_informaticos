<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class ReporteTotal extends Controler{

	public function __construct(){
		parent::__construct(3);
	}  

	public function Main(){

		$this -> noCache();

		require_once("ReporteTotalLayoutClass.php");
		require_once("ReporteTotalModelClass.php");

		$Layout   = new ReporteTotalLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ReporteTotalModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);

		
		$cliente_id=$resultado[0]['cliente_id'];
		$cliente=$resultado[0]['cliente'];
		echo $cliente_id;
		//LISTA MENU

		$Layout -> SetSi_Cli ($Model -> GetSi_Cli ($this -> getConex()));
		$Layout -> setCliente($Model  -> SetCliente($this -> getUsuarioId(),$this -> getConex()));

		$Layout -> RenderMain();
		}

		protected function generateFile(){

			require_once("ReporteTotalLayoutClass.php");
			require_once("ReporteTotalModelClass.php");

			$Model     = new ReporteTotalModel();
			$Layout    = new ReporteTotalLayout();

			$desde					= $_REQUEST['desde'];
			$hasta					= $_REQUEST['hasta'];
			$si_cliente				= $_REQUEST['si_cliente'];
			$cliente_id				= $_REQUEST['cliente_id'];


			if($si_cliente=='ALL') $consulta_cliente=""; else $consulta_cliente=" AND c.cliente_id =".$cliente_id;

			$data  = $Model -> getReporte1($desde,$hasta,$consulta_cliente,$this -> getConex());

			$ruta  = $this -> arrayToExcel("ReporConsolidado","Reporte Consolidado",$data,null);

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
	$ReporteTotal = new ReporteTotal();
?>