<?php
	require_once("../../../framework/clases/ControlerClass.php");

		final class Ubicacion extends Controler{

		public function __construct(){

			$this -> setCampos();
			parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();

			require_once("UbicacionLayoutClass.php");
			require_once("UbicacionModelClass.php");

			$Layout   = new UbicacionLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model    = new UbicacionModel();

			$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

			$Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
			$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
			$Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
			$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
			// echo "string";

			$Layout -> setCampos($this -> Campos);

			//LISTA MENU
			$Layout -> SetTipoEnvio		($Model -> GetTipoEnvio($this -> getConex()));

			//// GRID ////
			$Attributes = array(
				id		=>'Ubicacion',
				title		=>'Ubicaciones',
				sortname	=>'ubicacion_id',
				width		=>'auto',
				height	=>250
			);
			$Cols = array(
				array(name=>'ubicacion_id',		index=>'ubicacion_id',	sorttype=>'text',	width=>'80',	align=>'center'),
				array(name=>'nombre',			index=>'nombre',		sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'depto',			index=>'depto',			sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'pais',				index=>'pais',			sorttype=>'text',	width=>'150',	align=>'center'),
				array(name=>'x',				index=>'x',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'y',				index=>'y',				sorttype=>'text',	width=>'100',	align=>'center'),
				array(name=>'metropolitana',	index=>'metropolitana',		sorttype=>'text',	width=>'150',	align=>'left'),
				array(name=>'estado_mensajeria',	index=>'estado_mensajeria',		sorttype=>'text',	width=>'140',	align=>'left')
			);
			$Titles = array('UBICACION ID',
				'NOMBRE UBICACION',
				'DEPARTAMENTO',
				'PAIS',
				'X',
				'Y',
				'AREA METROPOLITANA',
				'ESTADO MENSAJERIA'
			);
			$Layout -> SetGridUbicacion($Attributes,$Titles,$Cols,$Model -> getQueryUbicacionGrid());
			$Layout -> RenderMain();
		}

		protected function onclickValidateRow(){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($this -> getConex(),"ubicacion",$this ->Campos);
			$this -> getArrayJSON($Data  -> GetData());
		}

		protected function onclickSave(){
			require_once("UbicacionModelClass.php");
			$Model = new UbicacionModel();
			$Model -> Save($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se ingreso correctamente la Ubicacion');
			}	
		}

		protected function onclickUpdate(){
			require_once("UbicacionModelClass.php");
			$Model = new UbicacionModel();
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('Se actualizo correctamente la Ubicacion');
			}
		}

		//BUSQUEDA
		protected function onclickFind(){
			require_once("UbicacionModelClass.php");
			$Model       = new UbicacionModel();
			$UbicacionId = $_REQUEST['ubicacion_id'];
			$Data        = $Model -> selectUbicacion($UbicacionId,$this -> getConex());
			$this -> getArrayJSON($Data);
		}

		protected function setCampos(){

			//campos formulario
			$this -> Campos[ubicacion_id] = array(
				name	=>'ubicacion_id',
				id		=>'ubicacion_id',
				type	=>'hidden',
				//		required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'20'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('primary_key'))
			);

			$this -> Campos[pais] = array(
				name	=>'pais',
				id		=>'pais',
				type	=>'text',
				value	=>'',
				readonly=>'readonly',
				//		tabindex=>'2',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'100')	
			);

			$this -> Campos[depto] = array(
				name	=>'depto',
				id		=>'depto',
				type	=>'text',
				value	=>'',
				readonly=>'readonly',
				//		tabindex=>'2',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'100')	
			);

			$this -> Campos[nombre] = array(
				name	=>'nombre',
				id		=>'nombre',
				type	=>'text',
				//		required=>'yes',
				value	=>'',
				readonly=>'readonly',
				//		tabindex=>'1',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'100'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('column'))
			);

			$this -> Campos[x] = array(
				name	=>'x',
				id		=>'x',
				type	=>'text',
				//required=>'yes',
				value	=>'',
				//		tabindex=>'1',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'50'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('column'))
			);

			$this -> Campos[y] = array(
				name	=>'y',
				id		=>'y',
				type	=>'text',
				//required=>'yes',
				value	=>'',
				//		tabindex=>'1',
				datatype=>array(
					type	=>'alpha_upper',
					length	=>'50'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('column'))
			);

			$this -> Campos[tipo_envio_id] = array(
				name	=>'tipo_envio_id',
				id		=>'tipo_envio_id',
				type	=>'select',
				required=>'yes',
				datatype=>array(
					type	=>'integer',
					length	=>'15'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('column'))
			);
			$this -> Campos[metropolitana] = array(
				name	=>'metropolitana',
				id	    =>'metropolitana',
				type	=>'text',
				suggest=>array(
					name	=>'ciudad',
					setId	=>'metropolitana_id')
			);
				
			$this -> Campos[metropolitana_id] = array(
				name	=>'metropolitana_id',
				id		=>'metropolitana_id',
				type	=>'hidden',
				value	=>'',
				datatype=>array(
					type	=>'integer',
					length	=>'20'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('column'))
			);

			$this -> Campos[estado_mensajeria] = array(
				name	=>'estado_mensajeria',
				id		=>'estado_mensajeria',
				type	=>'select',
				required=>'yes',
				options	=> array(
				array(value => '1', text => 'ACTIVO', selected => '1'),
				array(value => '0', text => 'INACTIVO', selected => '1')),
				datatype=>array(type =>'integer'),
				transaction=>array(
					table	=>array('ubicacion'),
					type	=>array('column'))
				
			);			

			//botones
			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Guardar',
				'disabled'=>'disabled'
			);

			$this -> Campos[actualizar] = array(
				name	=>'actualizar',
				id		=>'actualizar',
				type	=>'button',
				value	=>'Actualizar',
				'disabled'=>'disabled',
				property=>array(
					name	=>'update_ajax',
					onsuccess=>'UbicacionOnSaveUpdate')
			);

			$this -> Campos[borrar] = array(
				name	=>'borrar',
				id		=>'borrar',
				type	=>'button',
				value	=>'Borrar',
				'disabled'=>'disabled'
			);

			$this -> Campos[limpiar] = array(
				name	=>'limpiar',
				id		=>'limpiar',
				type	=>'reset',
				value	=>'Limpiar',
				'disabled'=>'disabled',
				onclick => 'UbicacionOnReset()'
			);

			//busqueda
			$this -> Campos[busqueda] = array(
				name	=>'busqueda',
				id		=>'busqueda',
				type	=>'text',
				value	=>'',
				size	=>'85',
				tabindex=>'1',
				suggest=>array(
					name	=>'ubicacion',
					setId	=>'ubicacion_id',
					onclick	=>'setDataFormWithResponse')
			);

			$this -> SetVarsValidate($this -> Campos);
		}
	}
	$Ubicacion = new Ubicacion();
?>