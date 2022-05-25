<?php



require_once("../../../framework/clases/ControlerClass.php");



final class dataBase extends Controler{

	

  public function __construct(){

    parent::__construct(2);	

  }

  	

  public function Main(){

  

    $this -> noCache();



    require_once("dataBaseLayoutClass.php");

    require_once("dataBaseModelClass.php");

	

    $Layout   = new dataBaseLayout($this -> getTitleTab(),$this -> getTitleForm());

    $Model    = new dataBaseModel();



    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

				

    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));

    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));

    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));

    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

	

    $Layout -> setCampos($this -> Campos);	



    //LISTA MENU





//// GRID ////

	$Attributes = array(



	  id	    =>'clientes_db',		

	  title		=>'Listado bases de datos',

	  sortname	=>'usuario',

	  width		=>'600',

	  height	=>'250'

	);



	$Cols = array(



	  array(name=>'ip',					index=>'ip',					width=>'140',	align=>'center'),

	  array(name=>'usuario',		    index=>'usuario',			    width=>'150',	align=>'center'),

	  array(name=>'estado',		        index=>'estado',			    width=>'104',	align=>'center'),

	  array(name=>'db',		            index=>'db',			        width=>'150',	align=>'center')

	

	);

	  

    $Titles = array('IP',

					'USUARIO',																

					'ESTADO',

					'DATABASE'

	);

		

	$Layout -> SetGriddataBase($Attributes,$Titles,$Cols,$Model -> getQuerydataBaseGrid());









	$Layout -> RenderMain();

  

  }



  protected function onclickValidateRow(){

  

	 require_once("../../../framework/clases/ValidateRowClass.php");

	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 

	 print $Data  -> GetData();

	 

  }

  

  

  protected function onclickSave(){

    

  	require_once("dataBaseModelClass.php");

    $Model = new dataBaseModel();

    	

    $Model -> Save($this -> Campos,$this -> getConex());



    if($Model -> GetNumError() > 0){

	 exit('Ocurrio una inconsistencia '.$Model -> GetNumError());

    }else{

	  exit('save');

	 }

	

  }





  protected function onclickUpdate(){

	  

  	require_once("dataBaseModelClass.php");

    $Model = new dataBaseModel();

	

    $Model -> Update($this -> Campos,$this -> getConex());

	

	exit('update');

	  

  }

  

  

  protected function onclickDelete(){



  	require_once("dataBaseModelClass.php");

    $Model = new dataBaseModel();

	

	$Model -> Delete($this -> Campos,$this -> getConex());

	

	if($Model -> GetNumError() > 0){

	  exit('Ocurrio una inconsistencia '.$Model -> GetNumError());

	}else{

	    exit('delete');

	  }

  }





//BUSQUEDA

  protected function onclickFind(){

  	require_once("dataBaseModelClass.php");

    $Model = new dataBaseModel();

	$Data  = $Model -> selectdataBase($this -> getConex());

	$this -> getArrayJSON($Data);

  }



  protected function setCampos(){

  

	//campos formulario

	$this -> Campos[cliente_id] = array(

		name	=>'cliente_id',

		id	    =>'cliente_id',

		type	=>'hidden',

	 	datatype=>array(

			type	=>'autoincrement'),

		transaction=>array(

			table	=>array('clientes_db'),

			type	=>array('primary_key'))

	);

	

	$this -> Campos[ip] = array(

		name	=>'ip',

		id	=>'ip',

		type	=>'text',

		required=>'yes',

		text_uppercase => 'no',

		size    =>'35',

		datatype=>array(

			type	=>'text'),

		transaction=>array(

			table	=>array('clientes_db'),

			type	=>array('column'))

	);	



	$this -> Campos[usuario] = array(

		name	=>'usuario',

		id	=>'usuario',

		type	=>'text',

		text_uppercase => 'no',

		required=>'yes',

		size    =>'35',

		datatype=>array(

			type	=>'text'),

		transaction=>array(

			table	=>array('clientes_db'),

			type	=>array('column'))

	);	



	$this -> Campos[db] = array(

		name	=>'db',

		id	=>'db',

		type	=>'text',

		text_uppercase => 'no',

		required=>'yes',

		size    =>'35',

		datatype=>array(

			type	=>'text'),

		transaction=>array(

			table	=>array('clientes_db'),

			type	=>array('column'))

	);	



	$this -> Campos[contrasena] = array(

		name	=>'contrasena',

		id	=>'contrasena',

		type	=>'password',

		text_uppercase => 'no',

		required=>'yes',

		size    =>'35',

		datatype=>array(

			type	=>'text'),

		transaction=>array(

			table	=>array('clientes_db'),

			type	=>array('column'))

	);	



	$this -> Campos[activo] = array(

		name	=>'estado',

		id		=>'activo',

		type	=>'radio',

	 	value	=>'1',

		checked	=>'checked',

		datatype=>array(

			type	=>'alpha',

			length	=>'1'),

		transaction=>array(

			table	=>array('clientes_db'),

			type	=>array('column'))

	);

	 

	$this -> Campos[inactivo] = array(

		name	=>'estado',

		id		=>'inactivo',

		type	=>'radio',

	 	value	=>'0',

		datatype=>array(

			type	=>'alpha',

			length	=>'1'),

		transaction=>array(

			table	=>array('clientes_db'),

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

			onsuccess=>'dataBaseOnSaveOnUpdateonDelete')

		

	);

	 

 	$this -> Campos[actualizar] = array(

		name	=>'actualizar',

		id		=>'actualizar',

		type	=>'button',

		value	=>'Actualizar',

		disabled=>'disabled',

		property=>array(

			name	=>'update_ajax',

			onsuccess=>'dataBaseOnSaveOnUpdateonDelete')

	);

	 

  	$this -> Campos[borrar] = array(

		name	=>'borrar',

		id		=>'borrar',

		type	=>'button',

		value	=>'Borrar',

		disabled=>'disabled',

		property=>array(

			name	=>'delete_ajax',

			onsuccess=>'dataBaseOnSaveOnUpdateonDelete')

	);

	 

   	$this -> Campos[limpiar] = array(

		name	=>'limpiar',

		id		=>'limpiar',

		type	=>'reset',

		value	=>'Limpiar',

		onclick	=>'dataBaseOnReset(this.form)'

	);

	

	//busqueda

    	$this -> Campos[busqueda] = array(

		name	=>'busqueda',

		id		=>'busqueda',

		type	=>'text',

		size	=>'85',

		text_uppercase => 'no',

		suggest=>array(

			name	=>'clientes_db',

			setId	=>'cliente_id',

			onclick	=>'setDataFormWithResponse')

	);

	

	 

	$this -> SetVarsValidate($this -> Campos);

  }





}



$clientes_db = new dataBase();



?>