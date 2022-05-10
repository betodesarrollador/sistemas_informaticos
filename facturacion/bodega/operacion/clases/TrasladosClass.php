<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Traslados extends Controler{

	public function __construct(){

		$this -> setCampos();
		parent::__construct(3);

	}


	public function Main(){

		$this -> noCache();

		require_once("TrasladosLayoutClass.php");
		require_once("TrasladosModelClass.php");

		$Layout   = new TrasladosLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new TrasladosModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> SetAnular    	($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));
		$Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
		$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

		$Layout -> setCampos($this -> Campos);

	//LISTA MENU
	
		$Layout -> setProducto($Model -> getProducto($this -> getConex()));
		$Layout	->	setCausalesAnulacion	($Model -> getCausalesAnulacion	($this -> getConex()));



	//// GRID ////
		$Attributes = array(
			id		    =>'Traslados',
			title		=>'Traslados',
			sortname	=>'traslado_id',
			width		=>'auto',
			height	    =>'200'
		);
		$Cols = array(				  
			array(name=>'traslado_id',			        index=>'traslado_id',			sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'fecha',						index=>'fecha',					sorttype=>'text',	width=>'100',	align=>'center'),
			array(name=>'entrada_id',					index=>'entrada_id',		    sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'producto_id',					index=>'producto_id',		    sorttype=>'text',	width=>'80',	align=>'center'),
			array(name=>'cantidad',	            		index=>'cantidad',				sorttype=>'text',	width=>'70',	align=>'center'),
			array(name=>'serial',						index=>'serial',			    sorttype=>'text',	width=>'70',	align=>'center'),
			array(name=>'ubicacion_bodega_id',			index=>'ubicacion_bodega_id',	sorttype=>'text',	width=>'110',	align=>'center'),
			array(name=>'usuario_id',					index=>'usuario_id',	sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'fecha_registro',			index=>'fecha_registro',	sorttype=>'text',	width=>'130',	align=>'center'),
			array(name=>'usuario_actualiza_id',			index=>'usuario_actualiza_id',	sorttype=>'text',	width=>'150',	align=>'center'),
			array(name=>'fecha_actualiza',			index=>'fecha_actualiza',	sorttype=>'text',	width=>'130',	align=>'center'),
			array(name=>'estado',			index=>'estado',	sorttype=>'text',	width=>'80',	align=>'center')
		);
		$Titles = array(
			'<span style="font-size:10px;">No. TRASLADO</span>',
			'FECHA',
			'ENTRADA',
			'PRODUCTO',
			'CANTIDAD',
			'SERIAL',
			'<span style="font-size:10px;">UBICACION BODEGA</span>',
			'USUARIO',
			'FECHA REGISTRO',
			'USUARIO ACTUALIZA',
			'FECHA ACTUALIZA',
			'ESTADO'
		);

		$Layout -> SetGridTraslados($Attributes,$Titles,$Cols,$Model -> getQueryTrasladosGrid());



		$Layout -> RenderMain();

	}

	protected function onclickValidateRow(){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"novedad_seguimiento",$this -> Campos);
		$this -> getArrayJSON($Data  -> GetData());
	}

	protected function onclickSave(){
		require_once("TrasladosModelClass.php");
		$Model = new TrasladosModel();
		$Data = $Model -> Save($this -> Campos,$this -> getConex());

		$this -> getArrayJSON($Data);	
	}

	protected function onclickUpdate(){
		require_once("TrasladosModelClass.php");
		$Model = new TrasladosModel();
		$usuario_actualiza = $this -> getUsuarioId();
		$Model -> Update($this -> Campos,$usuario_actualiza,$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente la traslados');
		}
	}

	protected function onclickDelete(){
		require_once("TrasladosModelClass.php");
		$Model = new TrasladosModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se elimino correctamente la traslados');
		}
	}

	protected function onclickCancellation(){
  
			require_once("TrasladosModelClass.php");
			$Model                 = new TrasladosModel(); 

			$traslado_id         = $this -> requestDataForQuery('traslado_id','integer');
			$causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
			$observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
			$usuario_anulo_id      = $this -> getUsuarioId();
			
			$Model -> cancellation($traslado_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
			
			if(strlen($Model -> GetError()) > 0){
			exit('false');
			}else{
				exit('true');
			}
			
	}  


//BUSQUEDA
	protected function onclickFind(){
		require_once("TrasladosModelClass.php");

    	$Model = new TrasladosModel();

		$traslado_id = $this -> requestData('traslado_id');

		$Data =  $Model -> selectTraslados($traslado_id,$this -> getConex());

		$this -> getArrayJSON($Data);
	}




	protected function setCampos(){

	//campos formulario
		$this -> Campos[traslado_id] = array(
			name	=>'traslado_id',
			id		=>'traslado_id',
			type	=>'text',
			disabled=>'yes',
			size=>'6',
			Boostrap=>'si',
			datatype=>array(
				type	=>'autoincrement',
				length	=>'6'),
			transaction=>array(
				table	=>array('wms_traslado'),
				type	=>array('primary_key'))
		);


		$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'select',
			required =>'yes',
			Boostrap=>'si',
			options	=>array(array(value=>'A',text=>'ACTIVO'),array(value=>'I',text=>'ANULADO')),
			datatype=>array(
				type	=>'text',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_traslado'),
				type	=>array('column'))
		);

		$this -> Campos[fecha] = array(
			name	=>'fecha',
			id		=>'fecha',
			type	=>'text',
			Boostrap=>'si',
			datatype=>array(type=>'date'),
			transaction=>array(
				table	=>array('wms_traslado'),
				type	=>array('column'))
		);


		$this -> Campos[producto_id] = array(
			name	=>'producto_id',
			id		=>'producto_id',
			type	=>'select',
			options	=>null,
			required=>'yes',
			Boostrap=>'si',
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
			transaction=>array(
				table	=>array('wms_traslado'),
				type	=>array('column'))
		);

		$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	=>'usuario_id',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		//size    =>'35',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('wms_traslado'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_actualiza_id] = array(
		name	=>'usuario_actualiza_id',
		id	=>'usuario_actualiza_id',
		type	=>'hidden',
		//size    =>'35',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_traslado'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id	=>'fecha_registro',
		type	=>'hidden',
		//size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_traslado'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	=>'fecha_actualiza',
		type	=>'hidden',
		//size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_traslado'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[usuario_static] = array(
		name	=>'usuario_static',
		id	=>'usuario_static',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		datatype=>array(
			type	=>'integer')
	);	

		//ANULACION
	
			$this -> Campos[causal_anulacion_id] = array(
				name	=>'causal_anulacion_id',
				id		=>'causal_anulacion_id',
				type	=>'select',
				required=>'yes',
				options	=>array(),
				datatype=>array(
					type	=>'integer')
			);		
			
			
			$this -> Campos[observacion_anulacion] = array(
				name	=>'observacion_anulacion',
				id		=>'observacion_anulacion',
				type	=>'textarea',
				value	=>'',
				required=>'yes',
				datatype=>array(
					type	=>'text')
			);	



	//botones
		$this -> Campos[guardar] = array(
			name	=>'guardar',
			id		=>'guardar',
			type	=>'button',
			value	=>'Guardar',
			property=>array(
				name	=>'save_ajax',
				onsuccess=>'TrasladosOnSave')
		);

		$this -> Campos[actualizar] = array(
			name	=>'actualizar',
			id		=>'actualizar',
			type	=>'button',
			value	=>'Actualizar',
			'disabled'=>'disabled',
			property=>array(
				name	=>'update_ajax',
				onsuccess=>'TrasladosOnUpdate')
		);

		$this -> Campos[borrar] = array(
			name	=>'borrar',
			id		=>'borrar',
			type	=>'button',
			value	=>'Borrar',
			'disabled'=>'disabled',
			property=>array(
				name	=>'delete_ajax',
				onsuccess=>'TrasladosOnDelete')
		);

		$this -> Campos[anular] = array(
			name	=>'anular',
			id		=>'anular',
			type	=>'button',
			value	=>'Anular',
			onclick =>'onclickCancellation(this.form)'
		);

		$this -> Campos[limpiar] = array(
			type	=>'reset',
			name	=>'limpiar',
			id		=>'limpiar',
			value	=>'Limpiar',
			onclick	=>'TrasladosOnReset()'
		);

	//busqueda
		$this -> Campos[busqueda] = array(
			name	=>'busqueda',
			id		=>'busqueda',
			type	=>'text',
			value	=>'',
			Boostrap=>'si',
			placeholder=>'Debe digitar el nombre o codigo del traslado.',
			size	=>'85',
			tabindex=>'1',
			suggest=>array(
				name	=>'traslado',
				setId	=>'traslado_id',
				onclick	=>'setDataFormWithResponse')
		);


		$this -> SetVarsValidate($this -> Campos);
	}
	
	
}

$Traslados = new Traslados();

?>