<?php
	require_once("../../../framework/clases/ControlerClass.php");
	error_reporting(1);

		final class TarifasMasivo extends Controler{

			public function __construct(){
				parent::__construct(2);
			}

			public function Main(){

				$this -> noCache();

				require_once("TarifasMasivoLayoutClass.php");
				require_once("TarifasMasivoModelClass.php");
				$Layout   = new TarifasMasivoLayout($this -> getTitleTab(),$this -> getTitleForm());
				$Model    = new TarifasMasivoModel();
	
				$Model  -> SetUsuarioId	($this	-> getUsuarioId(),$this -> getOficinaId());
				$Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
				$Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
				$Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
				$Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
				$Layout -> SetDuplicar  ($Model -> getPermiso($this -> getActividadId(),DUPLICAR,$this -> getConex()));	
				
				$Layout -> setCampos($this -> Campos);
				//LISTA MENU
				$Layout -> SetTipoMensajeria($Model -> GetTipoMensajeria($this -> getConex()));
				$Layout -> SetTipoEnvio($Model -> GetTipoEnvio($this -> getConex()));				
				$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));
				//// GRID ////
				$Attributes = array(
					id			=>'TarifasMasivo',
					title		=>'Listado de Tarifas Para Correo Masivo',
					sortname	=>'periodo',
					width		=>'1000',
					height		=>'250'
				);

				$Cols = array(
					array(name=>'tipo_servicio_mensajeria_id',	index=>'tipo_servicio_mensajeria_id',	sorttype=>'int',	width=>'140',	align=>'left'),
					array(name=>'tipo_envio_id',				index=>'tipo_envio_id',					sorttype=>'int',	width=>'140',	align=>'left'),
					array(name=>'rango',						index=>'rango',							sorttype=>'int',	width=>'160',	align=>'center'),
					array(name=>'vr_min_declarado',				index=>'vr_min_declarado',				sorttype=>'int',	width=>'150',	align=>'center'),
					array(name=>'valor_min',					index=>'valor_min',						sorttype=>'int',	width=>'80',	align=>'center'),
					array(name=>'valor_max',					index=>'valor_max',						sorttype=>'int',	width=>'90',	align=>'center'),
					array(name=>'porcentaje_seguro',			index=>'porcentaje_seguro',				sorttype=>'int',	width=>'80',	align=>'center'),
					array(name=>'periodo',						index=>'periodo',						sorttype=>'int',	width=>'80',	align=>'center'),
				);

				$Titles = array(
					'TIPO SERVICIO',
					'TIPO ENVIO',
					'RANGO',
					'VR RANGO MIN',
					'VR RANGO MAX',
					'VR MIN DECLARADO',					
					'TASA SEGURO',
					'PERIODO',
				);

				$Layout -> SetGridTarifasMasivo($Attributes,$Titles,$Cols,$Model -> getQueryTarifasMasivoGrid());
				$Layout -> RenderMain();
			}

			protected function onclickValidateRow(){
				require_once("../../../framework/clases/ValidateRowClass.php");
				$Data = new ValidateRow($this -> getConex(),"tarifas_masivo",$this ->Campos);
				print $Data  -> GetData();
			}

			protected function OnClickSave(){
				require_once("TarifasMasivoModelClass.php");
				$Model = new TarifasMasivoModel();
				$result = $Model -> Save($this -> getUsuarioId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit($result);
				}
			}

			protected function OnClickUpdate(){
				require_once("TarifasMasivoModelClass.php");
				$Model = new TarifasMasivoModel();
				$result = $Model -> Update($this -> getUsuarioId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit($result);
				}
			}

			protected function onclickDelete(){
				require_once("TarifasMasivoModelClass.php");
				$Model = new TarifasMasivoModel();
				$Model -> Delete($this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit($result);
				}
			}

		  protected function onclickDuplicar(){
			require_once("TarifasMasivoModelClass.php");			
			$Model = new TarifasMasivoModel();
			$Model -> duplicar($this -> getConex());
			if(strlen($Model -> GetError()) > 0){
			  exit('false');
			}else{
				exit('true');
			}
		  }

			//BUSQUEDA

			protected function OnClickFind(){
				require_once("TarifasMasivoModelClass.php");
				$Model = new TarifasMasivoModel();

				$tarifas_masivo_id = $this -> requestDataForQuery("tarifas_masivo_id");
				$Data  = $Model -> selectTarifasMasivo($tarifas_masivo_id,$this -> getConex());
				$this -> getArrayJSON($Data);
			}

			protected function setCampos(){

				//campos formulario
				$this -> Campos[tarifas_masivo_id] = array(
					name	=>'tarifas_masivo_id',
					id		=>'tarifas_masivo_id',
					type	=>'hidden',
					datatype=>array(
						type	=>'autoincrement',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('primary_key'))
				);

				$this -> Campos[tipo_servicio_mensajeria_id] = array(
					name	=>'tipo_servicio_mensajeria_id',
					id		=>'tipo_servicio_mensajeria_id',
					type	=>'select',
					options	=>null,
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[tipo_envio_id] = array(
					name	=>'tipo_envio_id',
					id		=>'tipo_envio_id',
					type	=>'select',
					options	=>null,
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[rango_inicial] = array(
					name	=>'rango_inicial',
					id		=>'rango_inicial',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[rango_final] = array(
					name	=>'rango_final',
					id		=>'rango_final',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[vr_min_declarado] = array(
					name	=>'vr_min_declarado',
					id		=>'vr_min_declarado',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[valor_min] = array(
					name	=>'valor_min',
					id		=>'valor_min',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[valor_max] = array(
					name	=>'valor_max',
					id		=>'valor_max',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[periodo] = array(
					name	=>'periodo',
					id		=>'periodo',
					type	=>'select',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				$this -> Campos[periodo_final] = array(
					name	=>'periodo_final',
					id		=>'periodo_final',
					type	=>'select',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20')
				);

				$this -> Campos[porcentaje_seguro] = array(
					name	=>'porcentaje_seguro',
					id		=>'porcentaje_seguro',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'numeric',
						length	=>'4'),
					transaction=>array(
						table	=>array('tarifas_masivo'),
						type	=>array('column'))
				);

				//botones
				$this -> Campos[guardar] = array(
					name	=>'guardar',
					id		=>'guardar',
					type	=>'button',
					value	=>'Guardar',
					onclick	=>'OnClickSave(this.form)'
				);

				$this -> Campos[actualizar] = array(
					name	=>'actualizar',
					id		=>'actualizar',
					type	=>'button',
					value	=>'Actualizar',
					disabled=>'disabled',
					onclick=>'OnClickUpdate(this.form)'
				);

				$this -> Campos[duplicar] = array(
					name	=>'duplicar',
					id		=>'duplicar',
					type	=>'button',
					value	=>'Duplicar',
					onclick =>'onclickDuplicar(this.form)'
				);	

				$this -> Campos[borrar] = array(
					name	=>'borrar',
					id		=>'borrar',
					type	=>'button',
					value	=>'Borrar',
					disabled=>'disabled',
					onclick=>'OnClickDelete(this.form)'
				);

				$this -> Campos[limpiar] = array(
					name	=>'limpiar',
					id		=>'limpiar',
					type	=>'reset',
					value	=>'Limpiar',
					onclick	=>'TarifasMasivoOnReset()'
				);

				//busqueda
				$this -> Campos[busqueda] = array(
					name	=>'busqueda',
					id		=>'busqueda',
					type	=>'text',
					size	=>'85',
					suggest=>array(
						name	=>'tarifas_masivo',
						setId	=>'tarifas_masivo_id',
						onclick	=>'setDataFormWithResponse')
				);	
				$this -> SetVarsValidate($this -> Campos);
			}
		}
	new TarifasMasivo();
?>