<?php
set_time_limit(0);
require_once("../../../framework/clases/ControlerClass.php");
final class MayoryBalance extends Controler{
  private $reporte;
  private $nivelReporte;
  private $Model;
  public function __construct(){
	parent::__construct(3);    
  }
  public function Main(){
	     
    $this -> noCache();
    
	require_once("MayoryBalanceLayoutClass.php");
	require_once("MayoryBalanceModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
	
	$Layout              = new MayoryBalanceLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new MayoryBalanceModel();
    $utilidadesContables = new UtilidadesContablesModel();  
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this->getConex()));			
	$Layout -> setNivelesPuc($utilidadesContables -> getNivelesPuc($this -> getConex()));				
	$Layout -> RenderMain();	  
	  
  }  
  
  private function setMayoryBalance($puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$nivel){
	  
	 if($nivel <= $this->nivelReporte){
		  
		$Conex      = $this->getConex(); 
		$empresa_id = $this->getEmpresaId();
		$dataCuenta = $this->Model->getSaldoCuenta($puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$empresa_id,$Conex);  
		if((is_numeric($dataCuenta['debito']) && $dataCuenta['debito'] != 0) || (is_numeric($dataCuenta['credito']) && $dataCuenta['credito']!= 0)){
	     array_push($this->reporte,$dataCuenta); 
		 
		 if($this->Model->esCuentaMovimiento($puc_id,$Conex)){
			 
	         $dataCuenta = $this->Model->getSaldoCuentaTerceros($puc_id,$desde,$hasta,$centro_de_costo_id,$empresa_id,$Conex);  			 
             foreach($dataCuenta as $llave => $valor){
               if(is_array($valor))array_push($this->reporte,$valor);
			 }
													
			 
		 }else{
		 		 
	      $sub_cuentas = $this->Model->selectSubCuentas($puc_id,$Conex);
	      $nivel++;
		 
	      for($i = 0; $i < count($sub_cuentas); $i++){
		   $this->setMayoryBalance($sub_cuentas[$i]['puc_id'],$desde,$hasta,$centro_de_costo_id,$tercero_id,$nivel); 
	      }
		
		 }
		
	   }
		  
	 }
	  
  }  
	
	protected function onclickGenerarMayoryBalance(){
		require_once("MayoryBalanceLayoutClass.php");
		require_once("MayoryBalanceModelClass.php");
		require_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
		$Layout              = new MayoryBalanceLayout($this -> getTitleTab(),$this -> getTitleForm());
		$this->Model         = new MayoryBalanceModel();
		$utilidadesContables = new UtilidadesContablesModel();
		$download           = $this -> requestData('download');

		$empresa_id         = $this -> getEmpresaId();
		$opciones_centros   = $this -> requestData('opciones_centros');
		$opcierre			= $this -> requestData('opciones_cierre');
		$desde              = $this -> requestData('desde'); 
		$hasta              = $this -> requestData('hasta');
		$centro_de_costo_id = $this -> requestData('centro_de_costo_id');
		$oficina_id         = $this -> requestData('oficina_id');
		$tercero_id			= 'NULL';
		$opciones_tercero   = $this -> requestData('opciones_tercero');
		$nivel              = $this -> requestData('nivel');
		$this->reporte      = array();
		$fechaProcesado      = date("Y-m-d");
		$horaProcesado       = date("H:i:s");
		$Conex              = $this  -> getConex();	

		$parametros         = $utilidadesContables -> getParametrosReportes($Conex);
		$empresa            = $this -> getEmpresaNombre();
		$nitEmpresa         = $this -> getEmpresaIdentificacion();
		$centrosTxt         = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
		$cuentasniv1=$this->Model->getCuentasBalance($nivel,$Conex);
		$l=0;
		for($j = 0; $j < count($cuentasniv1); $j++){
			$dat_cuenta=$this->Model->getSaldoCuenta($opcierre,$cuentasniv1[$j][value],$desde,$hasta,$centro_de_costo_id,$tercero_id,$this->getEmpresaId(),$Conex);
			if (empty($dat_cuenta)) {
			}else{
				//for($l=0;$l<count($dat_cuenta);$l++){
					//$dat_cuenta['nombre_puc']=$cuentasniv1[$j][text];
					//$dat_cuenta['codigo_puc']=$cuentasniv1[$j][value];
				//}
				$this->reporte[$l]= $dat_cuenta;
				$l++;
			}
		}
		// for ($i=0; $i < count($this->reporte); $i++) { 
		// 	echo "<hr>";
		// 	print_r($this->reporte[$i]);
		// }
		$Layout -> setCssInclude("../../../framework/css/reset.css");			
		$Layout -> setCssInclude("../css/reportes.css");						
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
		$Layout -> setJsInclude("../../../framework/js/funciones.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());				
		$Layout -> setVar('NIVEL',$nivel);		
		$Layout -> setVar('EMPRESA',$empresa);	
		$Layout -> setVar('NIT',$nitEmpresa);	
		$Layout -> setVar('CENTROS',$centrosTxt);
		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('parametros',$parametros);
		$Layout -> setVar('USUARIO',$this -> getUsuarioNombres());
		$Layout -> setVar('FECHA',$fechaProcesado);
		$Layout -> setVar('HORA',$horaProcesado);
		$Layout -> setVar('REPORTE',$this->reporte);
		if($download == 'true'){
    		$Layout -> exportToExcel('MayoryBalanceReporte.tpl');   
 		}else{   
   			$Layout -> RenderLayout('MayoryBalanceReporte.tpl');
		}
	}
  protected function onclickPrint(){}  
  
  protected function onclickExport(){}
  
  protected function setCampos(){
    /*****************************************
            	 datos sesion
	*****************************************/  
	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	
	
	$this -> Campos[opciones_centros] = array(
		name	=>'opciones_centros',
		id		=>'opciones_centros',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);	
	
	
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
	
	
	$this -> Campos[reporte] = array(
		name	=>'reporte',
		id		=>'reporte',
		type	=>'select',
		required=>'yes',
		size    =>'3',
        options =>array(array(value=>'O',text=>'OFICINA'),array(value=>'C',text=>'CENTRO COSTO')),
		selected=>'C',
		datatype=>array(
			type	=>'alpha')
	);
	
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'select',
		selected=>'1',
		required=>'yes',
		size    =>'3',
		datatype=>array(type=>'integer')
	);		

	$this -> Campos[opciones_cierre] = array(
		name	=>'opciones_cierre',
		id		=>'opciones_cierre',
		type	=>'select',
		required=>'yes',
		size    =>'3',
		options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO')),
		selected=>'N',		
		datatype=>array(type=>'alpha')
	);	
	
					
		
	//botones
	
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'onclickGenerarMayoryBalance(this.form)'
	);		
	
    $this -> Campos[imprimir] = array(
      name    =>'imprimir',
      id      =>'imprimir',
      type    =>'button',
      value   =>'Imprimir',
	  onclick =>'beforePrint(this.form)'
    );	
	
	$this -> Campos[descargar] = array(
	  name   =>'descargar',
	  id   =>'descargar',
	  type   =>'button',
	  value   =>'Descargar Excel',
	  onclick =>'descargarexcel(this.form)'
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}
new MayoryBalance();
?>