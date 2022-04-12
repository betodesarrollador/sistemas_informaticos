<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Alertas extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("AlertasLayoutClass.php");
    require_once("AlertasModelClass.php");
	
    $Layout   = new AlertasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AlertasModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));

	$Layout -> 	setDB($Model -> getDB ($this -> getConex()));	
	
	//LISTA MENU
	
	$Layout -> setCampos($this -> Campos);
	$Layout -> SetModulos($Model -> GetModulos($this -> getConex()));

	/// GRID ////

	$Layout -> RenderMain();
  
  }
  
  protected function onclickSave(){

	require_once("AlertasModelClass.php");
	
	$Model = new AlertasModel();
	
	$archivo        = $_FILES['archivo'];
	
	$rutaAlmacenar  = "../../../archivos/alertas/";
	
    $dir_file  = $this -> moveUploadedFile($archivo,$rutaAlmacenar,"Actualizacion - ".date("Y-m-d : H:i:s" ));  
	
	$data      = $Model -> Save($this -> getUsuarioId(),$dir_file,$this -> Campos,$this -> getConex());

  }

  protected function setCampos(){
  
	//campos formulario	
	
    $this -> Campos[mensaje] = array(
		name	=>'mensaje',
		id		=>'mensaje',
		type	=>'textarea',
		required=>'yes', 
		cols    =>"60",
		rows    =>"5",
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	
    $this -> Campos[fecha_inicio] = array(
		name	=>'fecha_inicio',
		id		=>'fecha_inicio',
		type	=>'text',
		required=>'yes', 
		datatype=>array(type=>'date'),
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	
    $this -> Campos[fecha_fin] = array(
		name	=>'fecha_fin',
		id		=>'fecha_fin',
		type	=>'text',
		required=>'yes', 
		datatype=>array(type=>'date'),
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	
    $this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	
    $this -> Campos[modulos] = array(
		name	=>'modulos',
		id		=>'modulos',
		type	=>'hidden',
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	
    $this -> Campos[empresas] = array(
		name	=>'empresas',
		id		=>'empresas',
		type	=>'hidden',
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	

	 $this -> Campos[select_modulos] = array(
        name=>'select_modulos',
        id=>'select_modulos',
		type=>'select',
		Boostrap=>'si',
		required=>'yes', 
		size => 7,
        multiple=>'yes',
        datatype=>array(
            type=>'text',
            length=>'50')
	
	);


	$this -> Campos[all_modulos] = array(
        name    =>'all_modulos',
        id      =>'all_modulos',
		type    =>'checkbox',
		Boostrap =>'si',
        onclick =>'all_modulo();',
        value   =>'NO'
	); 
	
	$this -> Campos[archivo]  = array(
		name	 =>'archivo',
		id		 =>'archivo',
		type	 =>'file',
		required =>'yes',
        title    =>'Carga de Archivo',
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);

	$this -> Campos[link_video] = array(
		name	=>'link_video',
		id		=>'link_video',
		type	=>'text',
		Boostrap=>'si',
		transaction=>array(
			table	=>array('alertas_desarrollo'),
			type	=>array('column'))
	);
	
	
	 $this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name=>'save_ajax',
			onsuccess=>'AlertaOnSave')
	); 


	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$tipo_campana = new Alertas();

?>