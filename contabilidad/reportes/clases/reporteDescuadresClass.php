<?php
require_once("../../../framework/clases/ControlerClass.php");
final class reporteDescuadres extends Controler{
	public function __construct(){
		parent::__construct(3);	      
	}  
  
	public function Main(){
		$this -> noCache();
		require_once("reporteDescuadresLayoutClass.php");
		require_once("reporteDescuadresModelClass.php");
		$Layout   = new reporteDescuadresLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new reporteDescuadresModel();
		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
		$Layout -> setCampos($this -> Campos);	
		//LISTA MENU
		$Layout -> SetTrazabilidad	($Model -> GetTrazabilidad($this -> getConex()));	
		$Layout -> RenderMain(); 
	}  
  
	protected function OnclickGenerar(){
		require_once("reporteDescuadresLayoutClass.php");
		require_once("reporteDescuadresModelClass.php");
		$Layout                 = new reporteDescuadresLayout();
		$Model                  = new reporteDescuadresModel();	
		$download           	= $this -> requestData('download');
		$empresa_id 			= $this -> getEmpresaId();
		$empresa 				= $this -> getEmpresaNombre();
		$nitEmpresa				= $this -> getEmpresaIdentificacion();
		$desde					= $_REQUEST['desde'];
		$hasta					= $_REQUEST['hasta'];
		$trazabilidad_id		= $_REQUEST['trazabilidad_id'];
		$Conex 	= $this ->getConex();
		$array= array();
			if ($trazabilidad_id=='DD') {
					$array = $Model -> getReporte1($desde,$hasta,$Conex);
			}				
			elseif ($trazabilidad_id=='DA') {
					$array = $Model -> getReporte2($desde,$hasta,$Conex);
			}
			elseif ($trazabilidad_id=='MC') {
					$array = $Model -> getReporte3($desde,$hasta,$Conex);
			}
			elseif ($trazabilidad_id=='MT') {
					$array = $Model -> getReporte4($desde,$hasta,$Conex);
			}
			elseif ($trazabilidad_id=='MM') {
					$array = $Model -> getReporte5($desde,$hasta,$Conex);
			}
			elseif ($trazabilidad_id=='DM') {
					$array = $Model -> getReporte6($desde,$hasta,$Conex);
			}
			elseif ($trazabilidad_id=='MS'){
					$array = $Model -> getReporte7($desde,$hasta,$Conex);
					
			}elseif ($trazabilidad_id=='MP'){
					$array = $Model -> getReporte8($desde,$hasta,$Conex);
			}

		$Layout -> setCssInclude("../../../framework/css/reset.css");			
		$Layout -> setCssInclude("../css/reportes.css");						
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
		$Layout -> setJsInclude("../../../framework/js/funciones.js");
		$Layout -> setJsInclude("/gmtprueba/contabilidad/js/detalles.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());		
	
		$Layout -> setVar('EMPRESA',$empresa);	
		$Layout -> setVar('NIT',$nitEmpresa);	
		$Layout -> setVar('CENTROS',$centrosTxt);													
		$Layout -> setVar('DESDE',$desde);															
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('TRAZABILIDAD',$trazabilidad_id);		
		$Layout -> setVar('parametros',$parametros); 
		$Layout -> setVar('DETALLESDESCUADRES',$array); 
		$Layout -> setVar('USUARIO',$this -> getUsuarioNombres());		  	  	  	  	  

		if($download == 'true'){
				$Layout -> exportToExcel('ReporteDescuadresResultado.tpl');
		}else{
				//echo 'Prieba de entrar';
				$Layout -> RenderLayout('ReporteDescuadresResultado.tpl');
		}
	}

  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    
	
	$this -> Campos[trazabilidad_id] = array(
		name	=>'trazabilidad_id',
		id		=>'trazabilidad_id',
		Boostrap =>'si',
		type	=>'select',
		required=>'yes'
	);
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
/////// BOTONES 
	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		
	$this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'button',
		value   =>'Imprimir',
		onclick =>'beforePrint(this.form)'
	);	
	$this -> Campos[excel] = array(
		name    =>'excel',
		id      =>'excel',
		type    =>'button',
		value   =>'Exportar a Excel',
		onclick =>'descargarexcel(this.form)'
	);
	 
	$this -> SetVarsValidate($this -> Campos);	
  }  
  
 }
$reporteDescuadres = new reporteDescuadres();
?>