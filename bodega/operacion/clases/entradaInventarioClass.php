<?php

require_once("../../../framework/clases/ControlerClass.php");

final class entradaInventario extends Controler{

	public function __construct(){

		$this -> setCampos();
		parent::__construct(3);

	}


	public function Main(){

		$this -> noCache();

		require_once("entradaInventarioLayoutClass.php");
		require_once("entradaInventarioModelClass.php");

		$Layout   = new entradaInventarioLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new entradaInventarioModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setAnular        ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
		$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

		$Layout -> setCampos($this -> Campos);

	//LISTA MENU



	//// GRID ////
		$Attributes = array(
			id		    =>'entrada',
			title		=>'entradas a Inventario',
			sortname	=>'usuario',
			width		=>'auto',
			height	=>250
		);
		$Cols = array(
			array(name=>'entrada_id',			        index=>'entrada_id',				sorttype=>'text',	width=>'200',	align=>'center'),	
			array(name=>'recepcion',				    index=>'recepcion',			        sorttype=>'text',	width=>'200',	align=>'center'),
			array(name=>'estado',						index=>'estado',			        sorttype=>'text',	width=>'150',	align=>'center'),			  
			array(name=>'usuario',			            index=>'usuario',				    sorttype=>'text',	width=>'200',	align=>'center'),
			array(name=>'fecha',						index=>'fecha',						sorttype=>'date',	width=>'150',	align=>'center'),
			array(name=>'fecha_registro',				index=>'fecha_registro',		    sorttype=>'date',	width=>'150',	align=>'center'),
			array(name=>'usuario_actualiza',			index=>'usuario_actualiza',		   	sorttype=>'text',	width=>'200',	align=>'center'),
			array(name=>'fecha_actualiza',	            index=>'fecha_actualiza',			sorttype=>'date',	width=>'150',	align=>'center')
		);
		$Titles = array('NUMERO ENTRADA',
			'RECEPCION',
			'ESTADO',
			'USUARIO',
			'FECHA',
			'FECHA REGISTRO',
			'USUARIO ACTUALIZA',
			'FECHA ACTUALIZA'
			
		);

		$Layout -> SetGridentradaInventario($Attributes,$Titles,$Cols,$Model -> getQueryentradaInventarioGrid());



		$Layout -> RenderMain();

	}

	protected function onclickValidateRow(){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"novedad_seguimiento",$this -> Campos);
		$this -> getArrayJSON($Data  -> GetData());
	}


	protected function onclickSave(){

		require_once("entradaInventarioModelClass.php");
		$Model = new entradaInventarioModel();
		
        $recepcion_id = $_REQUEST['recepcion_id'];
		$return = $Model -> Save($recepcion_id,$this -> Campos,$this -> getUsuarioId(),$this -> getConex());

		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
		print json_encode($return);	 
		}
	}

	protected function onclickUpdate(){

		require_once("entradaInventarioModelClass.php");
		$Model = new entradaInventarioModel();

		$return = $Model -> Update($this -> Campos,$this -> getConex(),$this -> getUsuarioId());

		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
		   print json_encode($return); 
		}

	}

	protected function onclickAnular(){
	  
  	require_once("entradaInventarioModelClass.php");
	$Model = new entradaInventarioModel();

    $return = $Model -> Cancellation($this -> getUsuarioId(),$this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	    exit("true");
	}
	  
  }

	protected function onclickDelete(){
		require_once("entradaInventarioModelClass.php");
		$Model = new entradaInventarioModel();

		$entrada_id = $_REQUEST['entrada_id'];
		$return = $Model -> Delete($entrada_id,$this -> Campos,$this -> getConex());
		
		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
		print json_encode($return); 
		}
	}


//BUSQUEDA
	protected function onclickFind(){
		require_once("entradaInventarioModelClass.php");

    	$Model = new entradaInventarioModel();

		$entrada_id = $this -> requestData('entrada_id');

		$Data =  $Model -> selectEntrada($entrada_id,$this -> getConex());

		$this -> getArrayJSON($Data);
	}




	protected function setCampos(){

	/* campos formulario */

		$this -> Campos[entrada_id] = array(
			name	=>'entrada_id',
			id		=>'entrada_id',
			type	=>'text',
			readonly =>'yes',
			Boostrap =>'si',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'11'),
			transaction=>array(
				table	=>array('wms_entrada'),
				type	=>array('primary_key'))
		);

/* 		$this -> Campos[fecha] = array(
			name	=>'fecha',
			id		=>'fecha',
			type	=>'text',
			size 	=>'auto',
			value 	=>date('Y-m-d H:i:s'),
			Boostrap=>'si',
			datatype=>array(type=>'text'),
			transaction=>array(
				table	=>array('wms_entrada'),
				type	=>array('column'))
		); */

		 $this -> Campos[fecha] = array(
			name	=>'fecha',
			id		=>'fecha',
			type	=>'text',
			Boostrap =>'si',
			required=>'yes',
			value   =>'',
			datatype=>array(type=>'date'),
			transaction=>array(
				table	=>array('wms_entrada'),
				type	=>array('column'))
		); 

		$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'select',
			Boostrap =>'si',
			disabled =>'yes',
			required =>'yes',
			options	=>array(array(value=>'P',text=>'PENDIENTE',selected=>'P'),array(value=>'I',text=>'INGRESADA'),array(value=>'IN',text=>'INVENTARIO'),array(value=>'A',text=>'ANULADA')),
			datatype=>array(
				type	=>'text',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_entrada'),
				type	=>array('column'))
		);

			$this -> Campos[recepcion_id] = array(
			name	=>'recepcion_id',
			id		=>'recepcion_id',
			type	=>'hidden',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('wms_entrada'))
		);

		$this -> Campos[recepcion] = array(
			name	=>'recepcion',
			id		=>'recepcion',
			type	=>'text',
			Boostrap =>'si',
			placeholder =>'Digite Codigo de la Legalización',
			size	=>'20',
			suggest=>array(
				name	=>'recepcion',
				setId	=>'recepcion_id')
		);


		$this -> Campos[usuario_id] = array(
			name	=>'usuario_id',
			id		=>'usuario_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('wms_entrada'))
		);

		$this -> Campos[fecha_registro] = array(
			name	=>'fecha_registro',
			id		=>'fecha_registro',
			type	=>'hidden',
			datatype=>array(
				type	=>'text',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_entrada'))
		);

		$this -> Campos[usuario_actualiza_id] = array(
			name	=>'usuario_actualiza_id',
			id		=>'usuario_actualiza_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'integer',
				length	=>'11'),
			transaction=>array(
				table	=>array('wms_entrada'))
		);

		$this -> Campos[fecha_actualiza] = array(
			name	=>'fecha_actualiza',
			id		=>'fecha_actualiza',
			type	=>'hidden',
			datatype=>array(
				type	=>'text',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_entrada'))
		);

		$this -> Campos[fecha_anula_entrada] = array(
		name	=>'fecha_anula_entrada',
		id		=>'fecha_anula_entrada',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		size =>'20',
    	datatype=>array(
			type	=>'date',
			length  =>'20'),
		transaction=>array(
			table	=>array('wms_entrada'),
			type	=>array('column'))
	);
	$this -> Campos[usuario_anula_id] = array(
		name	=>'usuario_anula_id',
		id   	=>'usuario_anula_id',
		value   => $this -> getUsuarioId(),
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric')
	);	

	$this -> Campos[observacion_anulacion] = array(
		name	=>'observacion_anulacion',
		id		=>'observacion_anulacion',
		type	=>'textarea',
		//Boostrap =>'si',
		value	=>'',
		//required=>'yes',
    	datatype=>array(
			type	=>'text')
	);

	//botones
		$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);

	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
	);

	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick => 'onclickAnular(this.form)'
	);

	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'entradaInventarioOnDelete')
	);

	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'entradaInventarioOnReset(this.form)'
	);

	//busqueda
		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			value	=>'',
			size	=>'85',
			tabindex=>'1',
			Boostrap =>'si',
			placeholder=>'Debe digitar el codigo de la entrada',
			suggest=>array(
				name	=>'wms_entrada',
				setId	=>'entrada_id',
				onclick	=>'setDataFormWithResponse')
		);


		$this -> SetVarsValidate($this -> Campos);
	}
	
	
}

$entradaInventario = new entradaInventario();

?>