<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Personalizado extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("PersonalizadoLayoutClass.php");
	require_once("PersonalizadoModelClass.php");
	
	$Layout   = new PersonalizadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PersonalizadoModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetTipo_nov($Model -> GetTipo_nov($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	


	$Layout -> RenderMain();
  
  }


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
		required=>'yes'
	);

	$this -> Campos[tipo_doc] = array(
		name	=>'tipo_doc',
		id		=>'tipo_doc',
		type	=>'select',
		options	=>null,
		required=>'yes',
		options	=>array(0 => array ( 'value' => 'ALL', 'text' => 'TODOS' ), 1 => array ( 'value' => 'MF', 'text' => 'MANIFIESTOS'), 2 => array ( 'value' => 'DU', 'text' => 'DESPACHOS URBANOS'), 3 => array ( 'value' => 'DP', 'text' => 'DESPACHO PARTICULAR') )
	);

	$this -> Campos[tipo_nov] = array(
		name	=>'tipo_nov',
		id		=>'tipo_nov',
		type	=>'select',
		options	=>null,
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[desde_h] = array(
		name	=>'desde_h',
		id		=>'desde_h',
		type	=>'text',
		value	=>'00:00',
	 	datatype=>array(
			type	=>'time',
			length	=>'10')
	);
	
	$this -> Campos[hasta_h] = array(
		name	=>'hasta_h',
		id		=>'hasta_h',
		type	=>'text',
		value	=>'23:59',
	 	datatype=>array(
			type	=>'time',
			length	=>'10')
	);

	$this -> Campos[opciones_conductor] = array(
		name	=>'opciones_conductor',
		id		=>'opciones_conductor',
		type	=>'select',
		options => array(array(value => 'U', text => 'UNO'),array(value => 'T', text => 'TODOS')),
		selected=>'T',
		required=>'yes',
		datatype=>array(type=>'text')
	);		


	$this -> Campos[conductor] = array(
		name	 =>'conductor',
		id		 =>'conductor',
		type	 =>'text',
		size     =>'35',
		disabled =>'true',
		suggest=>array(
			name	=>'conductor',
			setId	=>'conductor_hidden'
			)
	);
		
	$this -> Campos[conductor_id] = array(
		name	=>'conductor_id',
		id	    =>'conductor_hidden',
		type	=>'hidden',
		datatype=>array(type=>'integer')
	);

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Cliente_si();'
	);

	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);


	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_id')
	);

	$this -> Campos[si_placa] = array(
		name	=>'si_placa',
		id		=>'si_placa',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Placa_si();'
	);

	$this -> Campos[placa_id] = array(
		name	=>'placa_id',
		id		=>'placa_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);


	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'vehiculo',
			setId	=>'placa_id')
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);


	$this -> Campos[solouno] = array(
		name	=>'solouno',
		id		=>'solouno',
		type	=>'checkbox',
		value	=>0
			
	);		

	/**********************************
 	             Botones
	**********************************/
	 
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
    );

    $this -> Campos[descargar] = array(
    name   =>'descargar',
    id   =>'descargar',
    type   =>'button',
    value   =>'Descargar Excel con Formato',
	onclick =>'descargarexcel(this.form)'
    );

    $this -> Campos[descargar_csv] = array(
    name   =>'descargar_csv',
    id   =>'descargar_csv',
    type   =>'button',
    value   =>'Descargar Excel sin Formato',
	onclick =>'descargarcsv(this.form)'
    );

	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

new Personalizado();

?>