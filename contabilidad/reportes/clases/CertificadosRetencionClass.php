<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CertificadosRetencion extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
	     
    $this -> noCache();
    
	require_once("CertificadosRetencionLayoutClass.php");
	require_once("CertificadosRetencionModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
	
	$Layout              = new CertificadosRetencionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new CertificadosRetencionModel();
    $utilidadesContables = new UtilidadesContablesModel();  
	  
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());		
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU

	$Layout -> setCertificados($Model -> getCertificados($this -> getConex()));		
	$Layout -> RenderMain();	  
	  
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("CertificadosRetencionModelClass.php");
    $Model = new CertificadosRetencionModel();
    $certificados_tercero_id = $_REQUEST['certificados_tercero_id'];
		
    $Data = $Model -> getCertificado($certificados_tercero_id,$this -> getConex());

    $this -> getArrayJSON($Data);
  }  

  protected function getCuentasReporte(){

	require_once("CertificadosRetencionModelClass.php");
		
    $Model           = new CertificadosRetencionModel();
    $certificados_id = $this->requestData('certificados_id');
    $cuentas         = $Model -> selectCuentasReporte($certificados_id,$this -> getConex());
		
	echo json_encode($cuentas);

  }
    
  protected function onclickGenerarCertificado(){
	  
	require_once("CertificadosRetencionModelClass.php");
	require_once("CertificadosRetencionLayoutClass.php");
			
    $Model            = new CertificadosRetencionModel();	  
	$Layout           = new CertificadosRetencionLayout($this -> getTitleTab(),$this -> getTitleForm());	
	
	  
    $certificados_id  = $this->requestData('certificados_id');
    $puc_id           = $this->requestData('puc_id');
    $opciones_tercero = $this->requestData('opciones_tercero');
    $tercero_id       = $this->requestData('tercero_id');
    $desde            = $this->requestData('desde');
    $hasta            = $this->requestData('hasta');
	

	
	if($opciones_tercero == 'T'){
	  $tercerosCuentas = $Model->selectTercerosCuentasCertificado($puc_id,$desde,$hasta,$this->getConex());		
	}else if($opciones_tercero == 'U'){
		$tercerosCuentas[0]['tercero_id'] = $tercero_id;
	 }
	 
	$certificados = array(); 
	$i            = 0;
	 
	for($j = 0; $j < count($tercerosCuentas); $j++){

        $tercero_id = $tercerosCuentas[$i]['tercero_id'];

        if(is_numeric($tercero_id)){
			
        $datos_certificado = $Model->getDatosCertificado($certificados_id,$this->getConex());		
		$totales = $Model->getTotalCuentas($tercero_id,$puc_id,$desde,$hasta,$this->getConex()); 
		$total   = $totales[0]['saldo'] ;
		$base    = $totales[0]['base'] ;
		
		$numero_certificado = $Model->getConsecutivoCertificado($this->getConex());		

		$certificados[$i]['numero']             = $numero_certificado;
		$certificados[$i]['nombre_certificado'] = $datos_certificado[0]['nombre'];
		$certificados[$i]['entidad']            = $datos_certificado[0]['entidad'];
		$certificados[$i]['decreto']            = $datos_certificado[0]['decreto'];				
		$certificados[$i]['oficina']            = $this->getOficina();		
		$logo 									= $Model->getDatosLogo($this->getOficinaId(),$this->getConex()); 
		$certificados[$i]['direccion']     		= $Model->selectDireccionOficina($this->getOficinaId(),$this->getConex());					
		$certificados[$i]['empresa']            = $this->getEmpresaNombre();						
		$certificados[$i]['nit_empresa']        = $this->getEmpresaIdentificacion();								
		$certificados[$i]['tercero']            = $Model->getNombresTercero($tercero_id,$this->getConex()); 
		$certificados[$i]['identificacion']     = $Model->getIdentificacionTercero($tercero_id,$this->getConex()); 
		$certificados[$i]['total']              = $total;		
		$certificados[$i]['base']               = $base;				
		$certificados[$i]['total_letras']       = $this->num2letras($total);
		
		//$Model->getTotalCuentas($tercero_id,$puc_id,$desde,$hasta,$this->getConex()); 
		$certificados[$i]['movimientos']        = $Model->getMovCuentas($tercero_id,$puc_id,$desde,$hasta,$this->getConex()); 
		
		for($l=0;$l<count($certificados[$i]['movimientos']);$l++){
			$porcen=$certificados[$i]['movimientos'][$l][porcen];
			$formu=$certificados[$i]['movimientos'][$l][formu];
			$por_mul=explode("/",$formu);
			//$base= ($certificados[$i]['movimientos'][$l][saldo]*$por_mul[1]/$porcen);
			$base= $certificados[$i]['movimientos'][$l][base];
			$certificados[$i]['movimientos'][$l][base]=$base;

			
		}
		
		$certificados[$i]['ciudad']        = $Model->selectCiudadOficina($this->getOficinaId(),$this->getConex());
		$certificados[$i]['fecha_texto']  = $this->mesNumericoAtexto(date("Y-m-d"));

        $Layout -> setVar('c',$certificados[$i]);
		$Layout -> setVar('desde',$desde);	
		$Layout -> setVar('hasta',$hasta);		
	    $certificado = $Layout -> fetch('CertificadoRetencionReporte.tpl');
		$Model->insertCertificado($tercero_id,$numero_certificado,$certificado,$desde,$hasta,$this->getConex());				
		
		$i++;
		}
		
	} 
	
	$Layout -> setVar('desde',$desde);	
	$Layout -> setVar('hasta',$hasta);
	$Layout -> setVar('logo',$logo);
    $Layout -> setVar('CERTIFICADOS',$certificados);	
    $Layout -> RenderLayout('CertificadosRetencionReporte.tpl');		
	  
  }  

  protected function onclickGenerarCertificado1(){
	  
	require_once("CertificadosRetencionModelClass.php");
	require_once("CertificadosRetencionLayoutClass.php");
			
    $Model            = new CertificadosRetencionModel();	  
	$Layout           = new CertificadosRetencionLayout($this -> getTitleTab(),$this -> getTitleForm());	
	
	  
    $certificados_tercero_id  = $this->requestData('certificados_tercero_id');
	
	$data		= $Model->getCertificado($certificados_tercero_id,$this->getConex());
	$logo 		= $Model->getDatosLogo($this->getOficinaId(),$this->getConex()); 	
	
	$Layout -> setVar('data',$data);
	$Layout -> setVar('logo',$logo);
	
	
    $Layout -> RenderLayout('CertificadosRetencionReporte1.tpl');		
	  
  }  

  protected function setCampos(){

    /*****************************************
            	 datos sesion
	*****************************************/  

	
	$this -> Campos[certificados_id] = array(
		name	=>'certificados_id',
		id		=>'certificados_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		size    =>'3',
        options =>array(),
		datatype=>array(type=>'integer'),
		onchange=>'getCuentasCertificado(this.value)'
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		multiple=>'true',
		size    =>'3',
        options =>array(),
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
        options =>array(array(value=>'T',text=>'TODOS'),array(value=>'U',text=>'UNO')),
        selected=>'U',		
		datatype=>array(
			type	=>'alpha')
	);	
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		Boostrap =>'si',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_hidden')
	);
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric')
	);
	
	
	$this -> Campos[opciones_certificados] = array(
		name	=>'opciones_certificados',
		id		=>'opciones_certificados',
		type	=>'checkbox',
		value   =>'U',
		datatype=>array(type=>'text')
	);					
			
	$this -> Campos[cuenta_desde] = array(
		name	=>'cuenta_desde',
		id		=>'cuenta_desde',
		type	=>'text',
		Boostrap =>'si',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'cuenta_desde_hidden',
			onclick =>'setCuentaHasta')		
			
	);	
	
	$this -> Campos[cuenta_desde_id] = array(
		name	=>'cuenta_desde_id',
		id		=>'cuenta_desde_hidden',
		type	=>'hidden',
		required=>'yes'			
	);				
	
	$this -> Campos[cuenta_hasta] = array(
		name	=>'cuenta_hasta',
		id		=>'cuenta_hasta',
		type	=>'text',
		Boostrap =>'si',	
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'cuenta_hasta_hidden')		
	);	
	
	$this -> Campos[cuenta_hasta_id] = array(
		name	=>'cuenta_hasta_id',
		id		=>'cuenta_hasta_hidden',
		type	=>'hidden',	
		required=>'yes'							
	);					
	
	$this -> Campos[certificados_tercero_id] = array(
		name	=>'certificados_tercero_id',
		id		=>'certificados_tercero_id',
		type	=>'hidden',	
		required=>'no'							
	);
	//botones
	
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'onclickGenerarCertificado(this.form)'
	);		
	
    $this -> Campos[imprimir] = array(
      name    =>'imprimir',
      id      =>'imprimir',
      type    =>'print',
      value   =>'Imprimir',
	  displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
              title       => 'Impresion Certificado de Retencion',
              width       => '900',
              height      => '600'
      )

    );	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'certificados_retencion',
			setId	=>'certificados_tercero_id',
			onclick	=>'setDataFormWithResponse')
	);		
	
	
	$this -> SetVarsValidate($this -> Campos);
	
  }
	
	
}

new CertificadosRetencion();

?>