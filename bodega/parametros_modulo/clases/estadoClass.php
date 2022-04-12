<?php

require_once("../../../framework/clases/ControlerClass.php");

final class estado extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("estadoLayoutClass.php");
    require_once("estadoModelClass.php");
	
    $Layout   = new estadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new estadoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	
	//LISTA MENU

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'estado_producto_id',
	  title		=>'Estados Producto',
	  sortname	=>'estado_producto_id',
	  width		=>'1300',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'estado_producto_id',         index=>'estado_producto_id',          sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'nombre',                     index=>'nombre',                      sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'codigo',                     index=>'codigo',	                  sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'descripcion',                index=>'descripcion',	              sorttype=>'text',	width=>'100',	align=>'center'),	  
      array(name=>'estado',                     index=>'estado',	                  sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'usuario',                    index=>'usuario',	                  sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'fecha_registro',             index=>'fecha_registro',	          sorttype=>'text',	width=>'160',	align=>'center'),
	  array(name=>'usuario_actualiza',          index=>'usuario_actualiza',	          sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'fecha_actualiza',             index=>'fecha_actualiza',	          sorttype=>'text',	width=>'160',	align=>'center')	  	  	  	  	  
	);
    $Titles = array('NUMERO','NOMBRE','CODIGO','DESCRIPCION','ESTADO','USUARIO REGISTRA','FECHA REGISTRO','USUARIO ACTUALIZA','FECHA ACTUALIZA');
	$Layout -> SetGridestado($Attributes,$Titles,$Cols,$Model -> getQueryestadoGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"wms_estado_producto",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("estadoModelClass.php");
    $Model = new estadoModel();
    $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente el Estado');
    }	
  }

  protected function onclickUpdate(){
    require_once("estadoModelClass.php");
	$Model = new estadoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el Estado');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("estadoModelClass.php");
    $Model = new estadoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Estado');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("../../../framework/clases/FindRowClass.php");
    $Data1 = new FindRow($this -> getConex(),"wms_estado_producto",$this ->Campos);
    $this -> getArrayJSON($Data1 -> GetData());
  }



  protected function setCampos(){
		//campos formulario
	$this->Campos[estado_producto_id]=array(
		name =>'estado_producto_id',
		id => 'estado_producto_id',
		type => 'hidden',
		datatype => array(
			type=> 'autoincrement',
			length =>'20'
		),
	transaction =>array(
		table => array('wms_estado_producto'),
		type  => array('primary_key')
		)	
	);


	$this->Campos[nombre] = array(
		name	=> 'nombre',
		id		=> 'nombre',
		type	=> 'text',
		Boostrap => 'si',
		datatype => array(
			type	=> 'text',
			length	=> '30'
		),
		transaction => array(
			table	=> array('wms_estado_producto'),
			type	=> array('column')
			)
	);

		$this->Campos[codigo] = array(
			name	=> 'codigo',
			id		=> 'codigo',
            type	=> 'text',
            title =>'Digite el codigo que se identificará como estado del producto',
			Boostrap => 'si',
			datatype => array(
				type	=> 'text',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			)
		);

		$this->Campos[descripcion] = array(
			name	=> 'descripcion',
			id		=> 'descripcion',
			type	=> 'textarea',
			datatype => array(
				type	=> 'text',
				length	=> '40'
			),
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			)
		);

		$this->Campos[estado] = array(
			name	=> 'estado',
			id		=> 'estado',
			type	=> 'select',
			required => 'yes',
			Boostrap => 'si',
			options => array(array(value => 'A', text => 'ACTIVA', selected => 'A'), array(value => 'I', text => 'INACTIVA', selected => 'A')),
			datatype => array(type => 'alpha'),
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			)
		);

		$this->Campos[fecha_registro] = array(
			name => 'fecha_registro',
			id => 'fecha_registro',
			type => 'hidden',
			value => '',
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			),
			datatype => array(
				type => 'text',
				length => '10'
			)
		);

		$this->Campos[fecha_actualiza] = array(
			name => 'fecha_actualiza',
			id => 'fecha_actualiza',
			type => 'hidden',
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			),
			datatype => array(
				type => 'text',
				length => '10'
			)
		);

		$this->Campos[usuario_id] = array(
			name	=> 'usuario_id',
			id		=> 'usuario_id',
			type	=> 'hidden',
			datatype => array(
				type	=> 'autoincrement',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			)
		);

		$this->Campos[usuario_actualiza_id] = array(
			name	=> 'usuario_actualiza_id',
			id		=> 'usuario_actualiza_id',
			type	=> 'hidden',
			datatype => array(
				type	=> 'autoincrement',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_estado_producto'),
				type	=> array('column')
			)
		);
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'estadoOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'estadoOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'estadoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'estadoOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'60',
		Boostrap => 'si',
		placeholder=>'Escriba el código, ó nombre del Estado',						
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_estado_producto',
			setId	=>'estado_producto_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$estado = new estado();

?>