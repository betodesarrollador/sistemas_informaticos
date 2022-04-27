<?php
	require_once("../../../framework/clases/ControlerClass.php");
	error_reporting(1);

		final class TarifasEspecial extends Controler{

			public function __construct(){
				parent::__construct(2);
			}

			public function Main(){

				$this -> noCache();

				require_once("TarifasEspecialLayoutClass.php");
				require_once("TarifasEspecialModelClass.php");
				$Layout   = new TarifasEspecialLayout($this -> getTitleTab(),$this -> getTitleForm());
				$Model    = new TarifasEspecialModel();
	
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
				//// GRID ////
				$Attributes = array(
					id			=>'TarifasEspeciales',
					title		=>'Listado de Tarifas Especiales',
					//sortname	=>'periodo',
					width		=>'1000',
					height		=>'250'
				);

				$Cols = array(
					array(name=>'tarifas_especiales_id',	index=>'tarifas_especiales_id',	sorttype=>'int',	width=>'150',	align=>'left'),
					array(name=>'origen',	index=>'origen',	sorttype=>'int',	width=>'150',	align=>'left'),
					array(name=>'destino',	index=>'destino',	sorttype=>'int',	width=>'150',	align=>'left'),
					array(name=>'valor_primerKg',	index=>'valor_primerKg',	sorttype=>'int',	width=>'150',	align=>'left'),
					array(name=>'valor_adicionalKg',	index=>'valor_adicionalkg',	sorttype=>'int',	width=>'150',	align=>'left'),
					array(name=>'tipo_envio',	index=>'tipo_envio',	sorttype=>'text',	width=>'150',	align=>'left'),
					
				);

				$Titles = array(
					'TARIFAS ESPECIALES',
					'ORIGEN',
					'DESTINO',
					'VALOR PRIMER KG',					
					'VALOR ADICIONAL KG',
					'TIPO ENVIO'
				);

				$Layout -> SetGridTarifasEspeciales($Attributes,$Titles,$Cols,$Model -> getQueryTarifasEspecialesGrid());
				$Layout -> RenderMain();
			}

			protected function onclickValidateRow(){
				require_once("../../../framework/clases/ValidateRowClass.php");
				$Data = new ValidateRow($this -> getConex(),"tarifas_especiales",$this ->Campos);
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
				require_once("TarifasEspecialModelClass.php");
				$Model = new TarifasEspecialModel();
				$result = $Model -> Save($this -> getUsuarioId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit($result);
				}
			}

			protected function OnClickUpdate(){
				require_once("TarifasEspecialModelClass.php");
				$Model = new TarifasEspecialModel();
				$result = $Model -> Update($this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit($result);
				}
			}

			protected function onclickDelete(){
				require_once("TarifasEspecialModelClass.php");
				$Model = new TarifasEspecialModel();
				$Model -> Delete($this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit($result);
				}
			}

		  protected function onclickDuplicar(){
			require_once("TarifasMensajeriaModelClass.php");			
			$Model = new TarifasMensajeriaModel();
			$Model -> duplicar($this -> getConex());
			if(strlen($Model -> GetError()) > 0){
			  exit('false');
			}else{
				exit('true');
			}
		  }


			//BUSQUEDA

			protected function OnClickFind(){
				require_once("TarifasEspecialModelClass.php");
				$Model = new TarifasEspecialModel();

				$tarifas_especiales_id = $this -> requestDataForQuery("tarifas_especiales_id");
				$Data  = $Model -> selectTarifasEspeciales($tarifas_especiales_id,$this -> getConex());
				$this -> getArrayJSON($Data);
			}

			protected function setCampos(){

				//campos formulario
				$this -> Campos[tarifas_especiales_id] = array(
					name	=>'tarifas_especiales_id',
					id		=>'tarifas_especiales_id',
					type	=>'hidden',
					datatype=>array(
						type	=>'autoincrement',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_especiales'),
						type	=>array('primary_key'))
				);
				
				$this -> Campos[origen] = array(
				name=>'origen',
				id=>'origen',
				type=>'text',
				suggest=>array(
				name=>'ciudad',
				setId=>'origen_hidden'
				)
				); 
				
				$this -> Campos[origen_id] = array(
				name=>'origen_id',
				id=>'origen_hidden',
				type=>'hidden',
				required=>'yes',
					datatype=>array(
					type=>'integer',
					length=>'20'),
					transaction=>array(
					table=>array('tarifas_especiales'),
					type=>array('column'))
				);
				
				$this -> Campos[destino] = array(
				name=>'destino',
				id=>'destino',
				type=>'text',
				suggest=>array(
				name=>'ciudad',
				setId=>'destino_hidden'
				)
				);
				
				$this -> Campos[tipo_servicio_mensajeria_id] = array(
					name	=>'tipo_servicio_mensajeria_id',
					id	=>'tipo_servicio_mensajeria_id',
					type	=>'select',
					options	=>array(),
					required=>'yes',
					datatype=>array(type=>'integer'),
					transaction=>array(
						table	=>array('tarifas_especiales'),
						type	=>array('column'))
				);
				
				$this -> Campos[destino_id] = array(
				name=>'destino_id',
				id=>'destino_hidden',
				type=>'hidden',
				required=>'yes',
				datatype=>array(
				type=>'integer',
				length=>'20'),
				transaction=>array(
				table=>array('tarifas_especiales'),
				type=>array('column'))
				);
				
				$this -> Campos[valor_primerKg] = array(
					name	=>'valor_primerKg',
					id		=>'valor_primerKg',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_especiales'),
						type	=>array('column'))
				);

				$this -> Campos[valor_adicionalkg] = array(
					name	=>'valor_adicionalkg',
					id		=>'valor_adicionalkg',
					type	=>'text',
					required=>'yes',
					datatype=>array(
						type	=>'integer',
						length	=>'20'),
					transaction=>array(
						table	=>array('tarifas_especiales'),
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
						table	=>array('tarifas_especiales'),
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

			/*	$this -> Campos[duplicar] = array(
					name	=>'duplicar',
					id		=>'duplicar',
					type	=>'button',
					value	=>'Duplicar',
					onclick =>'onclickDuplicar(this.form)'
				);*/	

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
					onclick	=>'TarifasMensajeriaOnReset()'
				);

				//busqueda
				$this -> Campos[busqueda] = array(
					name	=>'busqueda',
					id		=>'busqueda',
					type	=>'text',
					size	=>'85',
					suggest=>array(
						name	=>'tarifas_especiales',
						setId	=>'tarifas_especiales_id',
						onclick	=>'setDataFormWithResponse')
				);	
				$this -> SetVarsValidate($this -> Campos);
			}
		}
	new TarifasEspecial();
?>