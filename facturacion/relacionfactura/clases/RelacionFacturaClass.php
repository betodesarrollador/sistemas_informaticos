<?php
	require_once("../../../framework/clases/ControlerClass.php");

	final class RelacionFactura extends Controler{

		public function __construct(){
			parent::__construct(2);	
		}

		public function Main(){

			$this -> noCache();

			require_once("RelacionFacturaLayoutClass.php");
			require_once("RelacionFacturaModelClass.php");

			$Layout	=	new	RelacionFacturaLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model	=	new	RelacionFacturaModel();

			$Model	->	SetUsuarioId($this	->	getUsuarioId(),$this	->	getOficinaId());

			$Layout -> setGuardar   	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
			$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
			$Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
			$Layout -> setLimpiar   	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

			$Layout -> setCampos($this -> Campos);
			
			$Layout -> RenderMain();
		}

		
		
		protected function onclickPrint(){
			require_once("Imp_DocumentoClass.php");
			$print = new Imp_Documento();
			$print -> printOut($this -> getConex());
		 }
		 
		protected function onclickAsociar(){

			require_once("RelacionFacturaModelClass.php");
			$Model = new RelacionFacturaModel();	
	
	
			$data = $Model -> Asociar($this -> getEmpresaId(),$this->getUsuarioId(),$this->getOficinaId(),$this -> getUsuarioNombres(),$this -> getConex());
			exit("$data");
		 }


		protected function generateReporte(){

			require_once("RelacionFacturaModelClass.php");
			require_once("RelacionFacturaLayoutClass.php");
			$Model	= new RelacionFacturaModel();
			$Layout	= new RelacionFacturaLayout();

			$solicitud_id = $_REQUEST['solicitud_id'];
			$numero_remesas = $_REQUEST['numero_remesas'];
			$fecha_inicio = $_REQUEST['fecha_inicio'];
			$fecha_final = $_REQUEST['fecha_final'];

			$Layout -> setCssInclude("../../../framework/css/reset.css");
			$Layout -> setCssInclude("../../../framework/css/general.css");
			$Layout -> setCssInclude("../../../framework/css/generalDetalle.css");
			$Layout -> setCssInclude("../../../framework/css/ajax-dynamic-list.css");
			$Layout	-> setJsInclude("../../../framework/js/jquery.js");
			$Layout	-> setJsInclude("../../../framework/js/ajax-list.js");
			$Layout	-> setJsInclude("../../../framework/js/ajax-dynamic-list.js");
			$Layout	-> setJsInclude("../../../framework/js/funciones.js");
			$Layout	-> setJsInclude("../../../framework/js/jquery-ui-1.8.2.custom.min.js");
			$Layout	-> setJsInclude("../../../facturacion/relacionfactura/js/DetallesRelacionFactura.js");
			$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
			$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());

			$data = $Model -> generateReporte($this -> getEmpresaId(),$fecha_inicio,$fecha_final,$solicitud_id,$numero_remesas,$this -> getConex());

			$Layout -> setVar("DATA",$data);
			$Layout -> setVar("PRINTERS",$_REQUEST['printers']);
			
			if($_REQUEST['download']=='SI'){
				$ruta  = $this -> arrayToExcel("Depreciaciones","Depreciaciones Pendientes",$data,null);
				$this -> ForceDownload($ruta);	
			}else{
				$Layout	-> RenderLayout('DetallesRelacionFactura.tpl');
			}
		}


		 

		//BUSQUEDA
		protected function onclickFind(){
			require_once("RelacionFacturaModelClass.php");
			$Model = new RelacionFacturaModel();

			$activo_id = $this -> requestDataForQuery("activo_id");
			$Data  = $Model -> selectDatos($activo_id,$this -> getConex());
			$this -> getArrayJSON($Data);
		}

		protected function setCampos(){

			//campos formulario
			$this -> Campos[remesa_id] = array(
				name	=>'remesa_id',
				id	    =>'remesa_id',
				type	=>'hidden',
				datatype=>array(
					type	=>'autoincrement'),
				transaction=>array(
					table	=>array('remesa'),
					type	=>array('primary_key'))
			);

			$this -> Campos[numero_remesas] = array(
				name	=>'numero_remesas',
				id		=>'numero_remesas',
				type	=>'textarea',
			 	datatype=>array(
					type	=>'integer',
					length	=>'10'),
				transaction=>array(
					table	=>array('remesa'),
					type	=>array('column'))
			);
			
			
			$this -> Campos[solicitud_id] = array(
				name	=>'solicitud_id',
				id		=>'solicitud_id',
				type	=>'text',
				size 	=>'10',
				datatype=>array(
					type	=>'integer',
					length	=>'20',
					precision=>'0'),
				transaction=>array(
					table	=>array('remesa'),
					type	=>array('column'))
			);
			
			
			$this -> Campos[fecha_inicio] = array(
				name	=>'fecha_inicio',
				id		=>'fecha_inicio',
				type	=>'text',
				//required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
			$this -> Campos[fecha_final] = array(
				name	=>'fecha_final',
				id		=>'fecha_final',
				type	=>'text',
				//required=>'yes',
				datatype=>array(
					type	=>'date',
					length	=>'10')
			);
			
	
			//botones
			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Guardar',
				onclick =>'OnSave(this.form)'
			);

			$this -> Campos[generar] = array(
				name	=>'generar',
				id		=>'generar',
				type	=>'button',
				value	=>'Consultar Pendientes',
				onclick =>'generateReporte(this.form)'
			);

			$this -> Campos[generar_excel] = array(
				name	=>'generar_excel',
				id		=>'generar_excel',
				type	=>'button',
				value	=>'Pendientes Excel',
				onclick =>'generateReporteExcel(this.form)'
			);


			$this -> Campos[renovar] = array(
				name	=>'renovar',
				id		=>'renovar',
				type	=>'button',
				value	=>'Renovar',
				//disabled=>'disabled',
				onclick =>'OnRenovar(this.form)'
			);

			$this -> Campos[imprimir] = array(
			  name    =>'imprimir',
			  id      =>'imprimir',
			  type    =>'button',
			  value   =>'Imprimir',
			  onclick =>'beforePrint(this.form)'

			);	
			
			$this -> Campos[contabilizar] = array(
				name	=>'contabilizar',
				id		=>'contabilizar',
				type	=>'button',
				value	=>'Asociar',
				onclick =>'asociar(this.form);'
			);


			$this -> Campos[finalizar] = array(
				name	=>'finalizar',
				id		=>'finalizar',
				type	=>'button',
				value	=>'Finalizar',
				//disabled=>'disabled',
				onclick =>'onclickFinalizar(this.form)'
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				onclick =>'ResetForm(this.form)'
			);

			//busqueda
			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				suggest=>array(
					name	=>'activo',
					setId	=>'activo_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$RelacionFactura = new RelacionFactura();
?>