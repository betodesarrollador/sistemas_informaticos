<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RemitenteDestinatario extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("RemitenteDestinatarioLayoutClass.php");
    require_once("RemitenteDestinatarioModelClass.php");
	
    $Layout   = new RemitenteDestinatarioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RemitenteDestinatarioModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setCambioEstado($Model -> getPermiso($this -> getActividadId(),'STATUS',$this -> getConex()));		
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetTiposId($Model -> GetTipoId($this -> getConex()));
    $Layout -> setClientes($Model -> getClientes($this -> getOficinaId(),$this -> getConex()));  
    $Layout -> setEstado        ();	 		

	//// GRID ////
	$Attributes = array(
	  id		=>'remitente_destinatario',
	  title		=>'Listado Destinatarios',
	  sortname	=>'nombre',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'cliente',	        	index=>'cliente',               sorttype=>'text',	width=>'150',	align=>'center'),	
	  array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'digito_verificacion',	index=>'digito_verificacion',	sorttype=>'int',	width=>'22',	align=>'center'),
	  array(name=>'nombre',	                index=>'nombre',				sorttype=>'text',	width=>'250',	align=>'left'),
	  array(name=>'direccion',	        	index=>'direccion',				sorttype=>'text',	width=>'250',	align=>'left'),
	  array(name=>'telefono',	        	index=>'telefono',				sorttype=>'text',	width=>'250',	align=>'left'),	  
	  array(name=>'ubicacion',	            index=>'ubicacion',				sorttype=>'left',	width=>'250',	align=>'center'),
      array(name=>'aprobacion_ministerio',	index=>'aprobacion_ministerio',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'100',	align=>'center')
	
	);
	  
    $Titles = array('CLIENTE',
	                'TIPO ID',
					'IDENTIFICACION',
					'DV',
					'DESTINATARIO',
					'DIRECCION',
					'TELEFONO',
					'CIUDAD',
					'APROBACION MIN.',
					'ESTADO'
	);
	
	$Layout -> SetGridRemitenteDestinatario($Attributes,$Titles,$Cols,$Model -> getQueryRemitenteDestinatarioGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
  }
  
  
	protected function onclickSave(){
	
		require_once("RemitenteDestinatarioModelClass.php");
		$Model = new RemitenteDestinatarioModel();
		
		$nombre     = $_REQUEST['nombre'];
		$cliente_id = $_REQUEST['cliente_id'];
		$telefono	= $_REQUEST['telefono'];
		$ubicacion_id = $_REQUEST['ubicacion_id'];
		$numero_identificacion = $_REQUEST['numero_identificacion'];
		
		if(strlen($telefono) < 7 ){
			exit("Debe digitar minimo 7 caracteres en el campo Telefono. !!");
		}elseif(strlen($telefono) > 10 ){
			exit("Debe digitar maximo 10 caracteres en el campo Telefono. !!");
		}elseif(!is_numeric($telefono)){
			exit("Debe digitar solo caracteres numericos en el campo Telefono. !!");	
		}else{
			if($Model -> destinatarioExists($nombre,$cliente_id,$ubicacion_id,$numero_identificacion,$this -> getConex())){
				exit("Ya existe un destinatario con esta ciudad para el cliente !!");
			}else{
				$id = $Model -> Save($this -> Campos,$this -> getConex());
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					exit("$id");
				}
			}
		}
	}

	protected function onclickUpdate(){
	
		require_once("RemitenteDestinatarioModelClass.php");
		$Model = new RemitenteDestinatarioModel();
		
		$telefono	= $_REQUEST['telefono'];
		
		if(strlen($telefono) < 7 ){
			exit("Debe digitar minimo 7 caracteres en el campo Telefono. !!");
		}elseif(strlen($telefono) > 10 ){
			exit("Debe digitar maximo 10 caracteres en el campo Telefono. !!");
		}elseif(!is_numeric($telefono)){
			exit("Debe digitar solo caracteres numericos en el campo Telefono. !!");	
		}else{
			$Model -> Update($this -> Campos,$this -> getConex());
			if($Model -> GetNumError() > 0){
				exit('Ocurrio una inconsistencia');
			}else{
				exit('true');
			}
		}	
	}
  
  protected function sendRemitenteDestinatarioMintransporte(){
      
	include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	$webService = new WebServiceMinTransporte($this -> getConex());	  
	  
	$data = array(	  
	    remitente_destinatario_id => $this -> requestData('remitente_destinatario_id'),
		tipo_identificacion_id    => $this -> requestData('tipo_identificacion_id'),
	    numero_identificacion     => $this -> requestData('numero_identificacion').$this -> requestData('digito_verificacion'),
		nombre                    => $this -> requestData('nombre').' '.$this -> requestData('razon_social'),		
		nombre_sede               => $this -> requestData('nombre').' '.$this -> requestData('razon_social'),		
		primer_apellido           => $this -> requestData('primer_apellido'),
		segundo_apellido          => $this -> requestData('segundo_apellido'),
		telefono                  => $this -> requestData('telefono'),
	    direccion                 => $this -> requestData('direccion'),
		ubicacion_id              => $this -> requestData('ubicacion_id')
	  );
	  
    $webService -> sendRemitenteDestinatarioMintransporte($data);	  
    
  
  } 
  
  protected function onclickDelete(){

  	require_once("RemitenteDestinatarioModelClass.php");
    $Model = new RemitenteDestinatarioModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el destinatario');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("RemitenteDestinatarioModelClass.php");
        $Model = new RemitenteDestinatarioModel();
	$Data  = $Model -> selectRemitenteDestinatario($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[remitente_destinatario_id] = array(
		name	=>'remitente_destinatario_id',
		id	=>'remitente_destinatario_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('primary_key'))
	);
	
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		size 	=>'50',
		suggest=>array(
			name	=>'cliente_disponible',
			setId	=>'cliente_hidden')
	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);
	  
	$this -> Campos[tipo_identificacion_id] = array(
		name	=> 'tipo_identificacion_id',
		id	=> 'tipo_identificacion_id',
		type	=> 'select',
		options	=> array(),
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);
	  	
	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id		=>'numero_identificacion',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20',
			precision=>'0'),
		transaction=>array(
			table	=>array('remitente_destinatario','tercero'),
			type	=>array('column','column'))
	);
	 
	$this -> Campos[digito_verificacion] = array(
		name	=>'digito_verificacion',
		id		=>'digito_verificacion',
		type	=>'text',
		readonly=>'readonly',
		size	=>'1',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);
	 
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		required=>'yes',
		size    =>'27',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);	
	
	$this -> Campos[primer_apellido] = array(
		name	=>'primer_apellido',
		id		=>'primer_apellido',
		type	=>'text',
		//tabindex=>'4',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);
	 
    $this -> Campos[segundo_apellido] = array(
		type=>'text',
		datatype=>array(
			type=>'alpha_upper',
			length=>'100'),
		name=>'segundo_apellido',
		id=>'segundo_apellido',
		value=>'',
		//tabindex=>'5',
		transaction=>array(
			table=>array('remitente_destinatario'),
			type=>array('column'))
	);	
	
	$this -> Campos[direccion] = array(
		name	=>'direccion',
		id	    =>'direccion',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono] = array(
		name	=>'telefono',
		id	    =>'telefono',
		type	=>'text',
		datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);		
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ubicacion_hidden')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);	
	
	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id	    =>'tipo',
		type	=>'hidden',
		value   =>'D',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
			type	=>array('column'))
	);		
	
		
	$this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
		required =>'yes',
		options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
        selected => 'D',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('remitente_destinatario'),
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
			onsuccess=>'RemitenteDestinatarioOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'RemitenteDestinatarioOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'RemitenteDestinatarioOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'RemitenteDestinatarioOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'destinatario',
			setId	=>'remitente_destinatario_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$remitente_destinatario = new RemitenteDestinatario();

?>