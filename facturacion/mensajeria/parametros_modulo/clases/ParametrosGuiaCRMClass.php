<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class ParametrosGuiaCRM extends Controler{

		public function __construct(){
			parent::__construct(3);    
		}

		public function Main(){

			$this -> noCache();

			require_once("ParametrosGuiaCRMLayoutClass.php");
			require_once("ParametrosGuiaCRMModelClass.php");

			$Layout   = new ParametrosGuiaCRMLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new ParametrosGuiaCRMModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
			$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
			$Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
			$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

			$Layout -> setCampos($this -> Campos);
			//LISTA MENU
			$Layout -> setCRM($Model -> getCRM($this -> getUsuarioId(),$this -> getConex()));
			$Layout -> setServicio($Model -> getServicio($this -> getConex()));
			//// GRID ////
			$Attributes = array(
				id			=>'RangoGuia',
				title		=>'Rango Guias',
				sortname	=>'oficina',
				width		=>'auto',
				height		=>'250'
			);

			$Cols = array(
				array(name=>'oficina',					index=>'oficina',					sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'prefijo',					index=>'prefijo',					sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'fecha_rango_guia',			index=>'fecha_rango_guia',			sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'rango_guia_crm_ini',		index=>'rango_guia_crm_ini',		sorttype=>'text',	width=>'90',	align=>'center'),
				array(name=>'rango_guia_crm_fin',		index=>'rango_guia_crm_fin',		sorttype=>'text',	width=>'90',	align=>'center'),
				array(name=>'total_rango_guia',			index=>'total_rango_guia',			sorttype=>'text',	width=>'110',	align=>'center'),
				array(name=>'utilizado_rango_guia_crm',	index=>'utilizado_rango_guia_crm',	sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'saldo_rango_guia_crm',		index=>'saldo_rango_guia_crm',		sorttype=>'text',	width=>'60',	align=>'center'),
				array(name=>'numero_resolucion',		index=>'numero_resolucion',			sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'puc1',						index=>'puc1',						sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'puc2',						index=>'puc2',						sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'estado',					index=>'estado',					sorttype=>'text',	width=>'50',	align=>'center')
			);
			$Titles = array(
				'OFICINA',
				'PREFIJO',
				'FECHA',
				'RANGO INICIO',
				'RANGO FINAL',
				'TOTAL ASIGNADO',
				'UTILIZADOS',
				'SALDO',
				'NUMERO RESOLUCION',
				'PUC 1',
				'PUC 2',
				'ESTADO'
			);

			$Layout -> SetGridRangoGuia($Attributes,$Titles,$Cols,$Model -> getQueryRangoGuiaGrid());

			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($this -> getConex(),"rango_guia_crm",$this ->Campos);
			$this -> getArrayJSON($Data  -> GetData());
		}

		protected function onclickSave(){
			require_once("ParametrosGuiaCRMModelClass.php");
			$Model = new ParametrosGuiaCRMModel();
			$Data = $Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit("$Data");
			}
		}

		protected function onclickUpdate(){
			require_once("ParametrosGuiaCRMModelClass.php");
			$Model = new ParametrosGuiaCRMModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente la alerta');
			}
		}

		protected function onclickDelete(){
			require_once("ParametrosGuiaCRMModelClass.php");
			$Model = new ParametrosGuiaCRMModel();
			$Model -> Delete($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se elimino correctamente la alerta');
			}
		}

		/*se busca el consecutivo disponible para los rangos de manifiesto*/
		protected function setDisponibleRes(){
			require_once("ParametrosGuiaCRMModelClass.php");
			$Model = new ParametrosGuiaCRMModel();
			$Data  = $Model -> getDisponibleRes($this -> getConex());
			$this -> getArrayJSON($Data);
		}
	  
		/*se valida que no exista un rango activo para la agencia*/
		protected function validaAgencia(){
			require_once("ParametrosGuiaCRMModelClass.php");
			$Model = new ParametrosGuiaCRMModel();
			$rango_guia_id  = $Model -> validaAgencia($this -> getConex());
			print $rango_guia_id;
		}

		//BUSQUEDA
		protected function onclickFind(){
			require_once("ParametrosGuiaCRMModelClass.php");
			$Model = new ParametrosGuiaCRMModel();
			$Data  = $Model -> selectRangoGuia($this -> getConex());
			$this -> getArrayJSON($Data);
		}
	  
		protected function onchangeSetOptionList(){
			require_once("../../../framework/clases/ListaDependiente.php");
			$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
			$list -> getList();
		}

		protected function setCampos(){

			//campos formulario
			$this -> Campos[rango_guia_crm_id] = array(
				name	=>'rango_guia_crm_id',
				id		=>'rango_guia_crm_id',
				type	=>'hidden',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('primary_key'))
			);

			$this -> Campos[oficina_id] = array(
				name	=>'oficina_id',
				id		=>'oficina_id',
				type	=>'select',
				options  => array(),
				required=>'yes',
				onchange   =>'validaAgencia(this.value)',		
				datatype=>array(
					type => 'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);
			$this -> Campos[tipo_bien_servicio_factura_id] = array(
				name	=>'tipo_bien_servicio_factura_id',
				id		=>'tipo_bien_servicio_factura_id',
				type	=>'select',
				options  => array(),
				required=>'yes',
				// onchange   =>'validaAgencia(this.value)',
				datatype=>array(
					type => 'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);
			

			$this -> Campos[tipo] = array(
				name	=>'tipo',
				id		=>'tipo',
				type	=>'select',
				options	=>array(
					array(
						value=>'M',
						text=>'MANUAL',
						selected=>'C'
					),
					array(
						value=>'C',
						text=>'COMPUTADOR')
				),
				required=>'yes',
				datatype=>array(
					type	=>'alpha'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);	

			$this -> Campos[prefijo] = array(
				name	=>'prefijo',
				id		=>'prefijo',
				type	=>'text',
				required=>'yes',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[fecha_rango_guia] = array(
				name	=>'fecha_rango_guia',
				id		=>'fecha_rango_guia',
				type	=>'text',
				value	=>date("Y-m-d"),
				required=>'yes',
				readonly=>'yes',
				datatype=>array(
					type	=>'date'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[inicio_disponible_res] = array(
				name	=>'inicio_disponible_res',
				id		=>'inicio_disponible_res',
				type	=>'text',
				value	=>'0',
				required=>'yes',
				size	=>'6',
				datatype=>array(
					type=>'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[total_rango_guia] = array(
				name	=>'total_rango_guia',
				id		=>'total_rango_guia',
				type	=>'text',
				value	=>'0',
				required=>'yes',
				size	=>'6',
				datatype=>array(
					type=>'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[rango_guia_crm_ini] = array(
				name	=>'rango_guia_crm_ini',
				id		=>'rango_guia_crm_ini',
				type	=>'text',
				value	=>'0',
				required=>'yes',
				readonly=>'readonly',
				size	=>'6',
				datatype=>array(
					type=>'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[rango_guia_crm_fin] = array(
				name	=>'rango_guia_crm_fin',
				id		=>'rango_guia_crm_fin',
				type	=>'text',
				value	=>'0',
				required=>'yes',
				readonly=>'readonly',
				size	=>'6',
				datatype=>array(
					type=>'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[utilizado_rango_guia_crm] = array(
				name	=>'utilizado_rango_guia_crm',
				id		=>'utilizado_rango_guia_crm',
				type	=>'text',
				value	=>'0',
				required=>'yes',
				size	=>'6',
				datatype=>array(
					type=>'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[saldo_rango_guia] = array(
				name	=>'saldo_rango_guia',
				id		=>'saldo_rango_guia',
				type	=>'text',
				value	=>'0',
				required=>'yes',
				readonly=>'readonly',
				size	=>'6',
				datatype=>array(
					type=>'integer')
			);

			$this -> Campos[numero_resolucion] = array(
				name	=>'numero_resolucion',
				id		=>'numero_resolucion',
				type	=>'text',
				required=>'yes',
				size	=>'20',
				datatype=>array(
					type=>'integer'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[puc1] = array(
				name	=>'puc1',
				id		=>'puc1',
				type	=>'hidden',
				required=>'yes',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[codigo_puc1] = array(
				name	=>'codigo_puc1',
				id		=>'codigo_puc1',
				type	=>'text',
				required=>'yes',
				size	=>'15',
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc1')
			);

			$this -> Campos[puc2] = array(
				name	=>'puc2',
				id		=>'puc2',
				type	=>'hidden',
				//required=>'yes',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[codigo_puc2] = array(
				name	=>'codigo_puc2',
				id		=>'codigo_puc2',
				type	=>'text',
				//required=>'yes',
				size	=>'15',
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc2')
			);

			$this -> Campos[puc_costo] = array(
				name	=>'puc_costo',
				id		=>'puc_costo',
				type	=>'hidden',
				required=>'yes',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[codigo_puc3] = array(
				name	=>'codigo_puc3',
				id		=>'codigo_puc3',
				type	=>'text',
				required=>'yes',
				size	=>'15',
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc_costo')
			);

			$this -> Campos[puc_banco] = array(
				name	=>'puc_banco',
				id		=>'puc_banco',
				type	=>'hidden',
				required=>'yes',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[codigo_puc4] = array(
				name	=>'codigo_puc4',
				id		=>'codigo_puc4',
				type	=>'text',
				required=>'yes',
				size	=>'15',
				suggest=>array(
					name	=>'cuentas_movimiento',
					setId	=>'puc_banco')
			);

			$this -> Campos[estado] = array(
				name	=>'estado',
				id		=>'estado',
				type	=>'select',
				options	=>array(
					array(
						value=>'A',
						text=>'ACTIVO',
						selected=>'A'
					),
					array(
						value=>'I',
						text=>'INACTIVO')
				),
				required=>'yes',
				datatype=>array(
					type	=>'alpha'),
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);	

			$this -> Campos[tercero_id] = array(
				name	=>'tercero_id',
				id		=>'tercero_id',
				type	=>'hidden',
				required=>'yes',
				transaction=>array(
					table	=>array('rango_guia_crm'),
					type	=>array('column'))
			);

			$this -> Campos[tercero] = array(
				name	=>'tercero',
				id		=>'tercero',
				type	=>'text',
				required=>'yes',
				size	=>'20',
				suggest=>array(
					name	=>'tercero',
					setId	=>'tercero_id')
			);

			//botones
			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Guardar',
				onclick=>'OnclickSave(this.form)'
			);

			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Actualizar',
				disabled=>'disabled',
				property=>array(
					name	=>'update_ajax',
					onsuccess=>'RangoGuiaOnSaveUpdate')
			);

			$this -> Campos[borrar] = array(
				name	=>'borrar',
				id		=>'borrar',
				type	=>'button',
				value	=>'Borrar',
				disabled=>'disabled',
				property=>array(
					name	=>'delete_ajax',
					onsuccess=>'RangoGuiaOnDelete')
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				onclick	=>'RangoGuiaOnReset()'
			);

			//busqueda
			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				size	=>'85',
				suggest=>array(
					name	=>'busca_rango_guia_crm',
					setId	=>'rango_guia_crm_id',
					onclick	=>'setDataFormWithResponse')
			);
			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$ParametrosGuiaCRM = new ParametrosGuiaCRM();
?>