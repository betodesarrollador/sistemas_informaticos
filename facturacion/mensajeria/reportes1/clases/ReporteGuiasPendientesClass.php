<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class ReporteGuiasPendientes extends Controler{

	public function __construct(){
		parent::__construct(3);
	}  

	public function Main(){

		$this -> noCache();

		require_once("ReporteGuiasPendientesLayoutClass.php");
		require_once("ReporteGuiasPendientesModelClass.php");

		$Layout   = new ReporteGuiasPendientesLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ReporteGuiasPendientesModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);

		
		//$cliente_id=$resultado[0]['cliente_id'];
		//$cliente=$resultado[0]['cliente'];
		//echo $cliente_id;
		//LISTA MENU

		//$Layout -> SetSi_Cli ($Model -> GetSi_Cli ($this -> getConex()));
		/*$Layout -> SetSi_Rem ($Model -> GetSi_Rem ($this -> getConex()));
		$Layout -> SetSi_Des ($Model -> GetSi_Des ($this -> getConex()));
		$Layout -> SetSi_Usu ($Model -> GetSi_Usu ($this -> getConex()));
		$Layout -> SetEstado ($Model -> GetEstado ($this -> getConex()));
		$Layout -> SetServicio($Model -> GetServicio ($this -> getConex()));	*/	
		$Layout -> SetOficina($Model -> GetOficina($this -> getOficinaId(),	$this -> getEmpresaId(),$this -> getConex()));
		//$Layout -> setCliente($Model  -> SetCliente($this -> getUsuarioId(),$this -> getConex()));

		$Layout -> RenderMain();
		}

		protected function generateFile(){

			require_once("ReporteGuiasPendientesLayoutClass.php");
			require_once("ReporteGuiasPendientesModelClass.php");

			$Model     = new ReporteGuiasPendientesModel();
			$Layout    = new ReporteGuiasPendientesLayout();

			$desde					= $_REQUEST['desde'];
			$hasta					= $_REQUEST['hasta'];

			$data  = $Model -> getReporte1($desde,$hasta,$this -> getConex());

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

			$this -> Campos[excel_formato] = array(
				name	=>'excel_formato',
				id		=>'excel_formato',
				type	=>'button',
				value	=>'Generar Excel Formato',
				onclick =>'OnclickGenerarExcelFormato(this.form)'
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
	$ReporteGuiasPendientes = new ReporteGuiasPendientes();
?>