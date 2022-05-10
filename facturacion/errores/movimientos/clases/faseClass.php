<?php

require_once("../../../framework/clases/ControlerClass.php");

final class fase extends Controler{
	
	public function __construct(){
		parent::__construct(2);	
	}

	public function Main(){

		$this -> noCache();

		require_once("faseLayoutClass.php");
		require_once("faseModelClass.php");

		$Layout   = new faseLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new faseModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
		$Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
		$Layout -> setCerrar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

		$Layout -> setCampos($this -> Campos);	

		/*LISTA MENU*/
		$Layout -> SetProyecto($Model -> GetProyecto($this -> getConex()));
		$Layout -> SetUsuario($Model -> GetUsuario($this -> getUsuarioId(),$this -> getConex()));
		//$Layout -> SetUsuarioId($this -> getUsuarioId());

		/*GRID */
		$Attributes = array(

			id	=>'fase',		
			title		=>'Listado de fase',
			sortname	=>'nombre',
			width		=>'1250',
			height	=>'250'
		);

		$Cols = array(

			array(name=>'fase_id',	index=>'fase_id',			width=>'50',	align=>'center'),
			array(name=>'nombre',				index=>'nombre',			        width=>'230',	align=>'center'),

			array(name=>'estado',				index=>'estado',			        width=>'70',	align=>'center'),
			array(name=>'proyecto',				index=>'proyecto',			        width=>'200',	align=>'center'),
			array(name=>'fecha_inicio_programada',				index=>'fecha_inicio_programada',			        width=>'100',	align=>'center'),
			array(name=>'fecha_fin_programada',				index=>'fecha_fin_programada',			        width=>'100',	align=>'center'),
			array(name=>'fecha_inicio_real',				index=>'fecha_inicio_real',			        width=>'100',	align=>'center'),
			array(name=>'fecha_fin_real',				index=>'fecha_fin_real',			        width=>'100',	align=>'center'),
			array(name=>'fecha_registro',				index=>'fecha_registro',			        width=>'130',	align=>'center'),
			array(name=>'fecha_actualiza',				index=>'fecha_actualiza',			        width=>'130',	align=>'center'),
			array(name=>'usuario',				index=>'usuario',			        width=>'130',	align=>'center'),
			array(name=>'usuario_actualiza',				index=>'usuario_actualiza',			        width=>'130',	align=>'center'),
			array(name=>'usuario_cierre',				index=>'usuario_cierre',			        width=>'130',	align=>'center'),
		);

		$Titles = array('FASE ID',
			'NOMBRE',
			'ESTADO',
			'PROYECTO',
			'FECHA INICIO PROGRAMADA',
			'FECHA FIN PROGRAMADA',
			'FECHA INICIO REAL',
			'FECHA FIN REAL',
			'FECHA REGISTRO',
			'FECHA ACTUALIZA',
			'USUARIO REGISTRA',
			'USUARIO ACTUALIZA',
			'USUARIO CIERRE'

		);
		
		$Layout -> SetGridfase($Attributes,$Titles,$Cols,$Model -> getQueryfaseGrid());




		$Layout -> RenderMain();

	}

	protected function onclickValidateRow(){

		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
		print $Data  -> GetData();

	}


	/*protected function setUsuarios(){
		require_once("faseLayoutClass.php");
		require_once("faseModelClass.php");
		$Model    = new faseModel();	
		$Layout -> setCampos($this -> Campos);
		$Layout -> SetUsuarioId($this -> getUsuarioId());
		$Layout -> SetUsuario($Model -> GetUsuario($this -> getUsuarioId(),$this -> getConex()));
		$Layout -> RenderMain();
	}*/


	protected function onclickSave(){

		require_once("faseModelClass.php");
		$Model = new faseModel();

		$Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('fase registrada correctamente');
		}

	}


	protected function onclickUpdate(){

		require_once("faseModelClass.php");
		$Model = new faseModel();
		$fase_id = $this->requestData('fase_id');
		$Model -> Update($fase_id,$this -> Campos,$this -> getUsuarioId(),$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente la fase');
		}

	}

	protected function cerrarFase(){

		require_once("faseModelClass.php");
		$Model = new faseModel();
		$fase_id = $_REQUEST['fase_id'];
		
		$Model -> cerrarFase($fase_id,$this -> getUsuarioId(),$this -> getConex());

		if($Model -> GetNumError() > 0){
			echo ('Ocurrio una inconsistencia');
		}else{
			echo ('Se cerro correctamente la fase');
		}
	}


	protected function onclickDelete(){

		require_once("faseModelClass.php");
		$Model = new faseModel();

		$Model -> Delete($this -> Campos,$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se elimino correctamente la fase');
		}
	}


	/*BUSQUEDA*/
	protected function onclickFind(){
		require_once("faseModelClass.php");
		$Model = new faseModel();
		$Data  = $Model -> selectfase($this -> getConex());
		$this -> getArrayJSON($Data);
	}

	protected function setCampos(){

		/*campos formulario*/
		date_default_timezone_set('America/Bogota');

		$this -> Campos[fase_id] = array(
			name	=>'fase_id',
			id	    =>'fase_id',
			type	=>'text',
			disabled=>'true',
			size    =>'10',
			required=>'no',
			datatype=>array(
				type	=>'autoincrement'),
			transaction=>array(
				table	=>array('fase'),
				type	=>array('primary_key'))
		);

		$this -> Campos[fecha_inicio_programada] = array(
			name       => 'fecha_inicio_programada',
			id         => 'fecha_inicio_programada',
			type       => 'text',
			required   => 'yes',
			value      => '',
			datatype   => array(
				type       => 'date'),
			transaction=> array(
				table      => array('fase'),
				type       => array('column'))
		);

		$this -> Campos[fecha_fin_programada] = array(
			name       => 'fecha_fin_programada',
			id         => 'fecha_fin_programada',
			type       => 'text',
			required   => 'yes',
			value      => '',
			datatype   => array(
				type       => 'date'),
			transaction=> array(
				table      => array('fase'),
				type       => array('column'))
		);

		$this -> Campos[fecha_inicio_real] = array(
			name       => 'fecha_inicio_real',
			id         => 'fecha_inicio_real',
			type       => 'text',
			size    =>'15',
			value      => '',
			datatype   => array(
				type       => 'date'),
			transaction=> array(
				table      => array('fase'),
				type       => array('column'))
		);

		$this -> Campos[fecha_fin_real] = array(
			name       => 'fecha_fin_real',
			id         => 'fecha_fin_real',
			type       => 'text',
			size    =>'15',
			value      => '',
			datatype   => array(
				type       => 'date'),
			transaction=> array(
				table      => array('fase'),
				type       => array('column'))
		);

		$this -> Campos[fecha_actualiza] = array(
			name       => 'fecha_actualiza',
			id         => 'fecha_actualiza',
			type       => 'hidden',
			required   => 'yes',
			datatype   => array(
				type       => 'date'),
			transaction=> array(
				table      => array('fase'),
				type       => array('column'))
		);

		$this -> Campos[fecha_registro] = array(
			name=>'fecha_registro',
			id=>'fecha_registro',
			type=>'text',
			required=>'yes',
			size    =>'15',
			disabled=>'true',
			value=>date("Y-m-d H:i"),
			datatype=>array(
				type=>'text'),
			transaction=>array(
				table=>array('fase'),
				type=>array('column'))
		);

		$this -> Campos[fecha_static] = array(
			name=>'fecha_static',
			id=>'fecha_static',
			type=>'hidden',
			value   => date("Y-m-d")
		);

		$this -> Campos[nombre] = array(
			name	=>'nombre',
			id	=>'nombre',
			type	=>'text',
			required=>'yes',
			size    =>'25',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('fase'),
				type	=>array('column'))
		);	


		$this -> Campos[abierta] = array(
			name	=>'estado',
			id		=>'abierta',
			type	=>'radio',
			value	=>'1',
			disabled=>'disabled',
			checked	=>'checked',
			datatype=>array(
				type	=>'alpha',
				length	=>'1'),
			transaction=>array(
				table	=>array('fase'),
				type	=>array('column'))
		);

		$this -> Campos[cerrada] = array(
			name	=>'estado',
			id		=>'cerrada',
			type	=>'radio',
			value	=>'0',
			disabled=>'disabled',
			datatype=>array(
				type	=>'alpha',
				length	=>'1'),
			transaction=>array(
				table	=>array('fase'),
				type	=>array('column'))
		);

		$this -> Campos[proyecto_id] = array(
			name=>'proyecto_id',
			id=>'proyecto_id',
			type=>'select',
			required=>'yes',
			options=>array(),
			datatype=>array(
				type=>'integer',
				length=>'11'),
			transaction=>array(
				table=>array('fase'),
				type=>array('column'))
		);

		/*usuario_id*/

		$this -> Campos[usuario] = array(
			name=>'usuario',
			id=>'usuario',
			type=>'text',
			size    =>'30',
			disabled=>'true'
		); 

		$this -> Campos[usuario_static] = array(
			name=>'usuario_static',
			id=>'usuario_static',
			type=>'hidden'
		); 

		$this -> Campos[usuario_id] = array(
			name=>'usuario_id',
			id=>'usuario_id',
			type=>'hidden',
			datatype=>array(
				type=>'integer',
				length=>'20'),
			transaction=>array(
				table=>array('fase'),
				type=>array('column'))
		);

		/*$this -> Campos[usuario_id_static] = array(
			name=>'usuario_id_static',
			id=>'usuario_id_static',
			type=>'hidden',
			value => $this -> getUsuarioId(),
			required=>'yes',
			datatype=>array(
				type=>'integer')
		);*/

		/*usuario_actualiza*/

		/*$this -> Campos[usuario_actualiza] = array(
			name=>'usuario_actualiza',
			id=>'usuario_actualiza',
			type=>'text',
			size    =>'30',
			disabled=>'true'
		); */

		$this -> Campos[usuario_actualiza_id] = array(
			name=>'usuario_actualiza_id',
			id=>'usuario_actualiza_id',
			type=>'hidden',
			datatype=>array(
				type=>'integer',
				length=>'20'),
			transaction=>array(
				table=>array('fase'),
				type=>array('column'))
		);

		/*usuario_cierre*/

		/*$this -> Campos[usuario_cierre] = array(
			name=>'usuario_cierre',
			id=>'usuario_cierre',
			type=>'text',
			size    =>'30',
			disabled=>'true'
		); */

		$this -> Campos[usuario_cierre_id] = array(
			name=>'usuario_cierre_id',
			id=>'usuario_cierre_id',
			type=>'hidden',
			datatype=>array(
				type=>'integer',
				length=>'20'),
			transaction=>array(
				table=>array('fase'),
				type=>array('column'))
		);


		/*botones*/
		$this -> Campos[guardar] = array(
			name	=>'guardar',
			id		=>'guardar',
			type	=>'button',
			value	=>'Guardar',
			property=>array(
				name	=>'save_ajax',
				onsuccess=>'faseOnSaveOnUpdateonDelete')

		);

		$this -> Campos[actualizar] = array(
			name	=>'actualizar',
			id		=>'actualizar',
			type	=>'button',
			value	=>'Actualizar',
			disabled=>'disabled',
			property=>array(
				name	=>'update_ajax',
				onsuccess=>'faseOnSaveOnUpdateonDelete')
		);

		$this -> Campos[borrar] = array(
			name	=>'borrar',
			id		=>'borrar',
			type	=>'button',
			value	=>'Borrar',
			disabled=>'disabled',
			property=>array(
				name	=>'delete_ajax',
				onsuccess=>'faseOnSaveOnUpdateonDelete')
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			onclick	=>'faseOnReset(this.form)'
		);

		$this -> Campos[cerrar] = array(
			name	=>'cerrar',
			id		=>'cerrar',
			type	=>'button',
			value	=>'cerrar',
			disabled=>'disabled',
			onclick	=>'cerrarFase(this.form);'
		);

		/*busqueda*/
		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			size	=>'85',
			placeholder=>'DIGITE EL NUMERO O NOMBRE DE LA FASE',
			suggest=>array(
				name	=>'fase',
				setId	=>'fase_id',
				onclick	=>'setDataFormWithResponse')
		);


		$this -> SetVarsValidate($this -> Campos);
	}


}

$fase = new fase();

?>