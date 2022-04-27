<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Acta extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();
    require_once("ActaLayoutClass.php");
    require_once("ActaModelClass.php");
	
    $Layout   = new ActaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ActaModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	
	//Campos Opciones
	$Layout -> setPQR($Model -> getPQR($this -> getConex()));	
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("ActaLayoutClass.php");
    require_once("ActaModelClass.php");
	
    $Layout   = new ActaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ActaModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'forma_pago',
		title		=>'Listado Formas Pago',
		sortname	=>'nombre',
		width		=>'auto',
		height	=>'250'
	  );
	  $Cols = array(
		array(name=>'codigo',index=>'codigo',width=>'50',	align=>'center'),
		array(name=>'nombre',index=>'nombre',width=>'200',	align=>'center'),
		array(name=>'requiere_soporte',index=>'requiere_soporte',width=>'100',	align=>'center'),	  	  
		array(name=>'puc',index=>'puc',width=>'200',	align=>'center'),	  	  	  
		array(name=>'naturaleza',index=>'naturaleza',width=>'100',	align=>'center'),	  	  	  	  
		array(name=>'banco',index=>'banco',width=>'200',	align=>'center'),	  	  	  	  
		array(name=>'estado',index=>'estado',width=>'100',	align=>'center')
	  
	  );
		
	  $Titles = array('CODIGO',
					  'NOMBRE',
					  'SOPORTE REQUERIDO',
					  'PUC',
					  'NATURALEZA',
					  'BANCO',
					  'ESTADO'
	  );
		  
	 $html =  $Layout -> SetGridActa($Attributes,$Titles,$Cols,$Model -> getQueryActaGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }

  protected function onclickPrint(){
	require_once("Imp_ActaClass.php");

	   $print = new Imp_Acta($this -> getConex());
	   $download = 'false';
	   $print -> printOut($acta_id,$download,''); 
   } 


   


   protected function onclickEnviarMail(){
		
	require_once("../../../framework/clases/MailClass.php");
	require_once("ActaLayoutClass.php");
	require_once("ActaModelClass.php");
	require_once("Imp_ActaClass.php");
	
	$Layout     = new ActaLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model      = new ActaModel();
	$imp_acta      = new Imp_Acta($this -> getConex());
	$enviar_mail = new Mail();

	$acta_id = $_REQUEST['acta_id'];
	$data       =$Model -> selectActa($acta_id,$this -> getConex());
	$cliente = $data[0]['cliente'];
	$cliente_id = $data[0]['cliente_id'];
	$nombre_acta = $data[0]['nombre_acta'];
	$fecha_acta = $data[0]['fecha_acta'];
	$asunto = $data[0]['asunto'];
	$ubicacion = $data[0]['ubicacion'];
	$pqr_id = $data[0]['pqr_id'];

	$correo = $Model -> selectCorreo($cliente_id,$this -> getConex());

	if ($pqr_id!='') {
		$mail_subject = "Se ha registrado una nueva ACTA DE REUNION NUMERO: $acta_id, con el ticket numero: $pqr_id, ASUNTO: $asunto";
	}else {
		$mail_subject = "Se ha registrado una nueva ACTA DE REUNION NUMERO: $acta_id, ASUNTO: $asunto";
	}

	
	$nombre_pdf    = '../../../archivos/errores/actas/'.$data[0]['acta_id'].'_'.$data[0]['nombre_acta'].'.pdf';
	$download = 'true';
	$ruta    	= '../../../archivos/errores/actas/';
	$imp_acta -> printOut($acta_id,$download,$nombre_pdf);
	//$pdf = $this -> exportToPdf('Imp_Actapdf.tpl',$nombre,$ruta);

	

	$body = utf8_decode('


	Se ha registrado una nueva acta solicitada por el cliente '.$cliente.', con fecha '.$fecha_acta.'<br /><br />

	Nombre de Acta: '.$nombre_acta.'.<br /><br />

	Adjunto se envía el acta en pdf para poder visualizarla, Por favor firmarla y enviarla firmada.<br /><br />
	
	Cordialmente,<br /><br />

	<img src="https://siandsi1.co/sistemas_informaticos/framework/media/images/varios/logosiandsi.jpg" alt="logo" width="125" /><br>
	<strong>Sistemas Informaticos y Soluciones Integrales');


	


	$enviar_mail->sendMail("liderdesarrollo@siandsi.co", $mail_subject, $body,$nombre_pdf,$data[0]['acta_id'].'_'.$data[0]['nombre_acta'].'.pdf');
	$enviar_mail->sendMail("lidersoporte@siandsi.co", $mail_subject, $body,$nombre_pdf,$data[0]['acta_id'].'_'.$data[0]['nombre_acta'].'.pdf');
	$enviar_mail->sendMail(strval("$correo"), $mail_subject, $body,$nombre_pdf,$data[0]['acta_id'].'_'.$data[0]['nombre_acta'].'.pdf');

	if (!$enviar_mail) {
		die('error enviando correo :' . $enviar_mail);
	}else {
		die('Correo enviado exitosamente a: <br> liderdesarrollo@siandsi.co. <br> lidersoporte@siandsi.co. <br> '.$correo.'.');
	}

}
  
  
  protected function onclickSave(){
    
  	require_once("ActaModelClass.php");
    $Model = new ActaModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex(),$this -> getUsuarioId());
    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la acta');
	 }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("ActaModelClass.php");
    $Model = new ActaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex(),$this -> getUsuarioId());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la acta');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("ActaModelClass.php");
    $Model = new ActaModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la acta');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("ActaModelClass.php");
    $Model = new ActaModel();
	$Data  = $Model -> selectActa($acta_id,$this -> getConex());
	$this -> getArrayJSON($Data);
  }
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[acta_id] = array(
		name	=>'acta_id',
		id	    =>'acta_id',
		type	=>'text',
		// required=>'yes',
		Boostrap => 'si',
		size => '10',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('actas'),
			type	=>array('primary_key'))
	);
		  	
	$this->Campos[fecha_acta] = array(
		name => 'fecha_acta',
		id => 'fecha_acta',
		type => 'text',
		Boostrap => 'si',
		required => 'yes',
		size => '20',
		datatype => array(
			type => 'date'),
		transaction => array(
			table => array('actas'),
			type => array('column')),
	);	  
	
	$this -> Campos[nombre_acta] = array(
		name	=>'nombre_acta',
		id	=>'nombre_acta',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('actas'),
			type	=>array('column'))
	);
	
	$this->Campos[cliente] = array(
		name => 'cliente',
		id => 'cliente',
		type => 'text',
		required => 'yes',
		Boostrap => 'si',
		size => 40,
		suggest => array(
			name => 'cliente',
			setId => 'cliente_hidden'),
	);

	$this -> Campos[pqr_id] = array(
		name	=>'pqr_id',
		id      =>'pqr_id',
		type	=>'select',
		Boostrap => 'si',
		// required => 'yes',
		options =>array(),
		transaction=>array(
			table	=>array('actas'),
			type	=>array('column'))
	);

	$this->Campos[cliente_id] = array(
		name => 'cliente_id',
		id => 'cliente_hidden',
		type => 'hidden',
		datatype => array(
			type => 'integer',
			length => '20'),
		transaction => array(
			table => array('actas'),
			type => array('column')),
	);

	$this->Campos[ubicacion] = array(
		name => 'ubicacion',
		id => 'ubicacion',
		type => 'text',
		// required => 'yes',
		Boostrap => 'si',
		size => 20,
		suggest => array(
			name => 'ubicacion',
			setId => 'ubicacion_hidden'),
	);

	$this -> Campos[usuario_registra] = array(
		name  =>'usuario_registra',
		id    =>'usuario_registra',
		type  =>'hidden',
		// value =>0,
		datatype=>array(
			type=>'integer'),
		transaction=>array(
			table=>array('actas'),
			type=>array('column'))
	);	

	$this -> Campos[usuario_actualiza] = array(
		name  =>'usuario_actualiza',
		id    =>'usuario_actualiza',
		type  =>'hidden',
		// value =>0,
		datatype=>array(
			type=>'integer'),
		transaction=>array(
			table=>array('actas'),
			type=>array('column'))
	);	

	$this->Campos[ubicacion_id] = array(
		name => 'ubicacion_id',
		id => 'ubicacion_hidden',
		type => 'hidden',
		datatype => array(
			type => 'integer',
			length => '20'),
		transaction => array(
			table => array('actas'),
			type => array('column')),
	);
	
	$this -> Campos[asunto] = array(
		name	=>'asunto',
		id	=>'asunto',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size    =>'45',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('actas'),
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
			onsuccess=>'ActaOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ActaOnSaveOnUpdateonDelete')
	);

	$this -> Campos[envio_mail] = array(
		name	=>'envio_mail',
		id		=>'envio_mail',
		type	=>'button',
		Clase   =>'btn btn-warning',
		value	=>'Enviar Email',
		tabindex=>'14',
		onclick =>'onclickEnviarMail(this.form)'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ActaOnSaveOnUpdateonDelete')
	);

	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
		displayoptions => array(
			form        => 0,
			beforeprint => 'beforePrint',
			title       => 'Impresion Acta de Reunion',
			width       => '900',
			height      => '600'
		)
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ActaOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder=>'ESCRIBA EL N&Uacute;MERO O NOMBRE DEL ACTA',												
		//tabindex=>'1',
		suggest=>array(
			name	=>'actas',
			setId	=>'acta_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
$forma_pago = new Acta();
?>