<?php
	require_once("../../../framework/clases/ControlerClass.php");
	error_reporting(1);

		final class TarifasEncomienda extends Controler{

			public function __construct(){
				parent::__construct(2);
			}

			public function Main(){

				$this -> noCache();

				require_once("TarifasEncomiendaLayoutClass.php");
				require_once("TarifasEncomiendaModelClass.php");
				$Layout   = new TarifasEncomiendaLayout($this -> getTitleTab(),$this -> getTitleForm());
				$Model    = new TarifasEncomiendaModel();
	
				$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				$Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
				$Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
				$Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
				$Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
				$Layout -> SetDuplicar  ($Model -> getPermiso($this -> getActividadId(),DUPLICAR,$this -> getConex()));	

				$Layout -> setCampos($this -> Campos);
				//LISTA MENU
				$Layout -> SetTipoEnvio($Model -> GetTipoEnvio($this -> getConex()));
				$Layout ->  SetTipoServicio($Model -> GetTipoServicio($this -> getConex()));
				$Layout -> SetPeriodo($Model -> GetPeriodo($this -> getConex()));	
				//// GRID ////
				$Attributes = array(
					id			=>'TarifasEncomiendas',
					title		=>'Listado de Tarifas Especiales',
					//sortname	=>'periodo',
					width		=>'1000',
					height		=>'250'
				);

				$Cols = array(
					
					array(name=>'tipo_envio',	index=>'tipo_envio',	sorttype=>'text',	width=>'100',	align=>'center'),
					
					array(name=>'vr_min_declarado',	index=>'vr_min_declarado',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_min_declarado_paq',	index=>'vr_min_declarado_paq',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_max_declarado',	index=>'vr_max_declarado',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_max_declarado_paq',	index=>'vr_max_declarado_paq',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_kg_inicial_min',	index=>'vr_kg_inicial_min',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_kg_inicial_max',	index=>'vr_kg_inicial_max',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_kg_adicional_min',	index=>'vr_kg_adicional_min',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'vr_kg_adicional_max',	index=>'vr_kg_adicional_max',	sorttype=>'text',	width=>'150',	align=>'center'),
					
					array(name=>'periodo',	index=>'periodo',	sorttype=>'text',	width=>'100',	align=>'center'),
					
					array(name=>'porcentaje_seguro',	index=>'porcentaje_seguro',	sorttype=>'text',	width=>'150',	align=>'center')
					
				);

				$Titles = array(
					'TIPO ENVIO',
					'VALOR MINIMO DECLARADO',
					'VALOR MINIMO DECLARADO PAQUETE',
					'VALOR MAXIMO DECLARADO',			
					'VALOR MAXIMO DECLARADO PAQUETE',
					'VALOR KG INICIAL MINIMO',
					'VALOR KG INICIAL MAXIMO',
					'VALOR KG ADICIONAL MINIMO',
					'VALOR KG ADICIONAL MAXIMO',
					'PERIODO',
					'PORCENTAJE SEGURO'
				);

				$Layout -> SetGridTarifasEncomiendaes($Attributes,$Titles,$Cols,$Model -> getQueryTarifasEncomiendaesGrid());
				$Layout -> RenderMain();
			}

			protected function onclickValidateRow(){
				require_once("../../../framework/clases/ValidateRowClass.php");
				$Data = new ValidateRow($this -> getConex(),"tarifas_encomienda",$this ->Campos);
				print $Data  -> GetData();
			}
			
		  protected function setDivipolaOrigen(){      
			require_once("../../operacion/clases/ManifiestoModelClass.php");	
			$Model        = new ManifiestoModel();
			$ubicacion_id = $_REQUEST['ubicacion_id'];	
			$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());  
			exit("$divipola");  
		  }

		  protected function setDivipolaDestino(){      
			require_once("../../operacion/clases/ManifiestoModelClass.php");	
			$Model        = new ManifiestoModel();
			$ubicacion_id = $_REQUEST['ubicacion_id'];	
			$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());  
			exit("$divipola");  
		  }   

			protected function OnClickSave(){
				
				require_once("TarifasEncomiendaModelClass.php");
				$Model = new TarifasEncomiendaModel();
				
				$result = $Model -> Save($this -> getUsuarioId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
				
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit('save');
				}
			}

			protected function OnClickUpdate(){
				require_once("TarifasEncomiendaModelClass.php");
				$Model = new TarifasEncomiendaModel();
				$result = $Model -> Update($this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit('update');
				}
			}

			protected function onclickDelete(){
				require_once("TarifasEncomiendaModelClass.php");
				$Model = new TarifasEncomiendaModel();
				$Model -> Delete($this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit('delete');
				}
			}


			//BUSQUEDA

			protected function OnClickFind(){
				require_once("TarifasEncomiendaModelClass.php");
				$Model = new TarifasEncomiendaModel();

				$tarifas_encomienda_id = $this -> requestDataForQuery("tarifas_encomienda_id");
				$Data  = $Model -> selectTarifasEncomiendaes($tarifas_encomienda_id,$this -> getConex());
				$this -> getArrayJSON($Data);
			}

			protected function setCampos(){

				//campos formulario
				$this -> Campos[tarifas_encomienda_id] = array(
					name	=>'tarifas_encomienda_id',
					id		=>'tarifas_encomienda_id',
					type	=>'hidden',
					datatype=>array(
						type	=>'autoincrement',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('primary_key'))
				);
		
				
				$this -> Campos[tipo_servicio_mensajeria_id] = array(
					name	=>'tipo_servicio_mensajeria_id',
					id	=>'tipo_servicio_mensajeria_id',
					type	=>'select',
					options	=>array(),
					required=>'yes',
					datatype=>array(type=>'integer'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
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
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[vr_max_declarado] = array(
					name	=>'vr_max_declarado',
					id		=>'vr_max_declarado',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);

				
				$this -> Campos[vr_min_declarado_paq] = array(
					name	=>'vr_min_declarado_paq',
					id		=>'vr_min_declarado_paq',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[vr_max_declarado_paq] = array(
					name	=>'vr_max_declarado_paq',
					id		=>'vr_max_declarado_paq',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[vr_kg_inicial_min] = array(
					name	=>'vr_kg_inicial_min',
					id		=>'vr_kg_inicial_min',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[vr_kg_inicial_max] = array(
					name	=>'vr_kg_inicial_max',
					id		=>'vr_kg_inicial_max',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[vr_kg_adicional_min] = array(
					name	=>'vr_kg_adicional_min',
					id		=>'vr_kg_adicional_min',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[vr_kg_adicional_max] = array(
					name	=>'vr_kg_adicional_max',
					id		=>'vr_kg_adicional_max',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[usuario] = array(
					name	=>'usuario',
					id		=>'usuario',
					type	=>'hidden',
					datatype=>array(
						type	=>'text',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[oficina] = array(
					name	=>'oficina',
					id		=>'oficina',
					type	=>'hidden',
					datatype=>array(
						type	=>'text',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[porcentaje_seguro] = array(
					name	=>'porcentaje_seguro',
					id		=>'porcentaje_seguro',
					type	=>'text',
					required=>'yes',
					onkeypress=>"return NumCheck(event, this)",
					datatype=>array(
						type	=>'text',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
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
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);
				
				$this -> Campos[periodo] = array(
					name	=>'periodo',
					id		=>'periodo',
					type	=>'select',
					options	=>null,
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_encomienda'),
						type	=>array('column'))
				);




				//botones
				$this -> Campos[guardar] = array(
					name	=>'guardar',
					id		=>'guardar',
					type	=>'button',
					value	=>'Guardar',
					property=>array(
						name	=>'save_ajax',
						onsuccess=>'EncomiendaOnSaveOnUpdateonDelete')
				);

				$this -> Campos[actualizar] = array(
					name	=>'actualizar',
					id		=>'actualizar',
					type	=>'button',
					value	=>'Actualizar',
					disabled=>'disabled',
					property=>array(
						name	=>'update_ajax',
						onsuccess=>'EncomiendaOnSaveOnUpdateonDelete')
				);

				$this -> Campos[borrar] = array(
					name	=>'borrar',
					id		=>'borrar',
					type	=>'button',
					value	=>'Borrar',
					disabled=>'disabled',
					property=>array(
						name	=>'delete_ajax',
						onsuccess=>'EncomiendaOnSaveOnUpdateonDelete')
				);

				$this -> Campos[limpiar] = array(
					name	=>'limpiar',
					id		=>'limpiar',
					type	=>'reset',
					value	=>'Limpiar',
					onclick	=>'TarifasMensajeriaOnReset()'
				);

				//busqueda
				$this -> Campos[busqueda] = array(
					name	=>'busqueda',
					id		=>'busqueda',
					type	=>'text',
					size	=>'85',
					suggest=>array(
						name	=>'tarifas_encomienda',
						setId	=>'tarifas_encomienda_id',
						onclick	=>'setDataFormWithResponse')
				);	
				$this -> SetVarsValidate($this -> Campos);
			}
		}
	new TarifasEncomienda();
?>