<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Cierres extends Controler{

	public function __construct(){
		parent::__construct(3);    
	}

	public function Main(){
		
		$this -> noCache();
		
		require_once("CierresLayoutClass.php");
		require_once("CierresModelClass.php");
		require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
		
		$Layout              = new CierresLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model               = new CierresModel();
		$utilidadesContables = new UtilidadesContablesModel();  
		
		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());		
		$Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> SetAnular		($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
		$Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);
		
	//LISTA MENU
		$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
		$Layout -> setDocumentos($Model -> getDocumentos($this -> getConex()));		
		$Layout -> RenderMain();	  
		
	}
	/************************************************************************** */
   //BUSQUEDA
	protected function onclickFind(){
		$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
		if($encabezado_registro_id>0){
			$this->viewDocument($encabezado_registro_id); 
		}
	}   /*********************************************************************** */

	/******* onclickDelete ******** */
	protected function onclickDelete(){

		require_once("CierresModelClass.php");
		$Model = new CierresModel();
		
		$Model -> Delete($this -> Campos,$this -> getConex());
		
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se elimino correctamente el Cierre.<br> Recuerde que al borrar un Cierre se Habilitan los meses y el periodo correspondiente al documento.');
		}
	}
	/*********************************************************************************** */

	protected function onclickGenerarAuxiliar(){

		require_once("CierresLayoutClass.php");
		require_once("CierresModelClass.php");
		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
		
		$Layout = new CierresLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model = new CierresModel();	
		$utilidadesContables = new UtilidadesContablesModel();	

		$Layout -> setCssInclude("../../../framework/css/reset.css");			
		$Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
		$Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
		$Layout -> setJsInclude("../../../framework/js/funciones.js");					
		$Layout -> setJsInclude("../js/librosauxiliaresReporte.js");				

		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
		
		$empresa_id          = $this -> getEmpresaId();
		$oficina_id          = $this -> getOficinaId();
		$usuario_id          = $this -> getUsuarioId();
		$documentos          = $this -> requestData('documentos');
		$desde               = $this -> requestData('desde');
		$hasta               = $this -> requestData('hasta');	
		$fecha_doc           = $this -> requestData('fecha_doc');	
		$anio   			 = substr($fecha_doc,0,4);
		$opciones_tercero    = $this -> requestData('opciones_tercero');		
		$opciones_centro     = $this -> requestData('opciones_centro');	
		$centro_de_costo     = $this -> requestData('centro_de_costo');	
		$centro_de_costo_id  = $this -> requestData('centro_de_costo_id');	
		$empresa             = $this -> getEmpresaNombre();
		$nitEmpresa          = $this -> getEmpresaIdentificacion();
		$fechaProcesado      = date("Y-m-d");
		$horaProcesado       = date("H:i:s");
		
		
		
		$parametrosreportes = $utilidadesContables -> getParametrosReportes($this  -> getConex());
		
		if(count($parametrosreportes)>0){
			$utilidad_puc = $parametrosreportes[0][utilidad_cierre_id];
			$perdida_puc = $parametrosreportes[0][perdida_cierre_id];		
			
		}else{
			exit('No existe Parametros de Reportes Contables.<br>Por favor configure los parametros.');	
		}

		$cierre_anterior= $utilidadesContables -> getCierreAnterior($desde,$hasta,$this  -> getConex());
		if($cierre_anterior>0){
			if(is_array($cierre_anterior)){

				$periodo_contable_id= $cierre_anterior[0]['periodo_contable_id'];
				$sum_deb_cre= $utilidadesContables -> getSumDebCre($periodo_contable_id,$desde,$hasta,$this  -> getConex());
				if($sum_deb_cre>0){
					for($i=0;$i<count($sum_deb_cre);$i++){
						$consecutivoDoc = $sum_deb_cre[$i]['consecutivo'];
						$documento      = $sum_deb_cre[$i]['tipo_documento'];
						$dif            = $sum_deb_cre[$i]['diferencia'];
						$docs.= "<br> Consecutivo: <b style='color:#f21010'>".$consecutivoDoc."</b> Tipo documento: <b style='color:#f21010'>".$documento."</b> Diferencia: <b style='color:#f21010'>".$dif."</b><br>";
						
					}
					exit('Por favor Revise los siguientes documentos del cierre anterior ya que presentan anomalias.<br>'.$docs);
				}
				
			}
		}else{
			exit("¡Atención no se a realizado el cierre del año anterior, por favor revise!");
		}
		
		$periodo_contable_ini= $utilidadesContables -> getPeriodoContableId($desde,$this  -> getConex());
		$mes_contable_ini= $utilidadesContables -> getMesContableId($desde,$periodo_contable_ini,$this  -> getConex());
		
		$mes_estado_ini= $utilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$desde,$this  -> getConex());
		if($mes_estado_ini==0) exit('Mes contable Inicial esta Cerrado o Inhabilitado');

		
		$periodo_contable_fin= $utilidadesContables -> getPeriodoContableId($hasta,$this  -> getConex());
		$mes_contablefin= $utilidadesContables -> getMesContableId($hasta,$periodo_contable_fin,$this  -> getConex());
		$mes_estado_fin= $utilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$hasta,$this  -> getConex());

		if($mes_estado_fin==0) exit('Mes contable Final esta Cerrado o Inhabilitado');

		$periodo_contable_id= $utilidadesContables -> getPeriodoContableId($fecha_doc,$this  -> getConex());
		$mes_contable_id= $utilidadesContables -> getMesContableId($fecha_doc,$periodo_contable_id,$this  -> getConex());
		$mes_estado_doc= $utilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$fecha_doc,$this  -> getConex());
		
		if($mes_estado_doc==0) exit('Mes contable del documento esta Cerrado o Inhabilitado');

		$estado_documentos = $utilidadesContables -> getEstDocumentos($desde,$hasta,$this->getConex());
		$consecutivoDoc = $estado_documentos[0]['consecutivo'];

		if($consecutivoDoc>0){
			for($i=0;$i<count($estado_documentos);$i++){
				$consecutivoDoc = $estado_documentos[$i]['consecutivo'];
				$documento = $estado_documentos[$i]['tipo_documento'];
				$estadoDoc = $estado_documentos[$i]['estado'];
				$docs.= "<br> Consecutivo: <b style='color:#f21010'>".$consecutivoDoc."</b> Tipo documento: <b style='color:#f21010'>".$documento."</b><br>";
			}
			exit('Estos documentos se encuentran en estado <b style="color:#f21010">'.$estadoDoc.'</b> por favor reviselos o anulelos.<br>'.$docs);
		}
		
		$dif_documentos = $utilidadesContables -> getDifDocumentos($desde,$hasta,$this->getConex());
		if($dif_documentos>0){
			for($i=0;$i<count($dif_documentos);$i++){
				$consecutivoDif = $dif_documentos[$i]['consecutivo'];
				$documento = $dif_documentos[$i]['tipo_documento'];
				$dif = $dif_documentos[$i]['diferencia'];
				$docsDif.= "<br>Consecutivo: <b style='color:#f21010'>".$consecutivoDif."</b> Tipo documento: <b style='color:#f21010'>".$documento."</b> Diferencia: <b style='color:#f21010'>".$dif."</b><br>";
			}
			exit('Estos documentos cuentan con diferencias entre el <b>DEBITO</b> y el <b>CREDITO</b> por favor reviselos o anulelos.<br>'.$docsDif);
		}

		$mes_trece=  $utilidadesContables -> getMesContableTrece($periodo_contable_id,$this  -> getConex());
		$consecutivo= $utilidadesContables -> getConsecutivo($oficina_id,$documentos,$periodo_contable_id,$this  -> getConex());


		$tercero_enc= $Model -> getEmpTercero($empresa_id,$this  -> getConex());
		
		$auditoria = $utilidadesContables -> getAuditoria($periodo_contable_id,$this  -> getConex());

		if($opciones_centro=='T' && $opciones_tercero=='T'){
			$arrayResult= $Model -> selectSaldoCuentaTercero($desde,$hasta,$this  -> getConex());
		}elseif($opciones_centro=='U' && $opciones_tercero=='T'){
			$arrayResult= $Model -> selectSaldoCuentaTerceroUnCentro($centro_de_costo_id,$desde,$hasta,$this  -> getConex());
		}elseif($opciones_centro=='U' && $opciones_tercero=='U'){
			$arrayResult= $Model -> selectSaldoCuentasinTerceroUnCentro($centro_de_costo_id,$desde,$hasta,$this  -> getConex());
		}elseif($opciones_centro=='T' && $opciones_tercero=='U'){		
			$arrayResult= $Model -> selectSaldoCuentasinTercero($desde,$hasta,$this  -> getConex());
		}
		$saldo_total=0;
		$insert_enc='';
		$insert=array();
		$insert1='';
		$acumula=0;
		$acumula_deb=0;
		$acumula_cre=0;
		if(count($arrayResult)>0){  
			
			$encabezado_registro_id = $Model ->DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$this  -> getConex(),true,1);

			for($i = 0; $i < count($arrayResult); $i++){
				if($opciones_tercero=='T'){
					$tercero_ori = $arrayResult[$i][tercero_id];
					$identificacion_ori= $utilidadesContables->getNumeroIdentificacionTercero($tercero_ori,$this  -> getConex());
					$digito_ori= $utilidadesContables->getDigitoVerificacionTercero($tercero_ori,$this  -> getConex());		
					$digito_ori= $digito_ori!='' ? $digito_ori:'NULL';		
					
				}else{
					$tercero_ori = 'NULL';
					$identificacion_ori= 'NULL';
					$digito_ori= 'NULL';
					
				}
				$centro_de_costo_id = $arrayResult[$i][centro_de_costo_id];
				$codigo_centro_costo = $arrayResult[$i][codigo_centro_costo]!='' ? "'".$arrayResult[$i][codigo_centro_costo]."'" : "(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id=$centro_de_costo_id)";
				$valor=$arrayResult[$i][saldo];
				$acumula=$acumula+$arrayResult[$i][saldo];
				$cuenta_desde_id=$arrayResult[$i][puc_id];
				
				$natuorigen= $Model -> naturalezaorigen($arrayResult[$i][puc_id],$this  -> getConex());

				if($natuorigen=='D' && $arrayResult[$i][saldo]>=0 ){
					$acumula_cre=$acumula_cre+$arrayResult[$i][saldo];
					$credito=$arrayResult[$i][saldo];
					$debito = 0;
					
				}elseif($natuorigen=='C' && $arrayResult[$i][saldo]>=0 ){
					$acumula_deb=$acumula_deb+$arrayResult[$i][saldo];
					$credito= 0;
					$debito =$arrayResult[$i][saldo];
					
				}elseif($natuorigen=='D' && $arrayResult[$i][saldo]<0 ){

					$acumula_deb=$acumula_deb+abs($arrayResult[$i][saldo]);
					$credito= 0;
					$debito =abs($arrayResult[$i][saldo]);

				}elseif($natuorigen=='C' && $arrayResult[$i][saldo]<0 ){
					$acumula_cre=$acumula_cre+ abs($arrayResult[$i][saldo]);
					$credito=abs($arrayResult[$i][saldo]);
					$debito = 0;
					
				}
				
				$insert[$i]="$tercero_ori,$identificacion_ori,$digito_ori,
				$cuenta_desde_id,'CIERRE A&Ntilde;O ".$anio."',$encabezado_registro_id,$centro_de_costo_id,$codigo_centro_costo,
				'$valor','$debito','$credito');";
				
			}
			
			$diferencia=$acumula_cre-$acumula_deb; 
			
			
			if($diferencia>0){
				$insert1="NULL,NULL,NULL,$perdida_puc,'PERDIDA DEL EJERCIO ".$anio."',$encabezado_registro_id,$centro_de_costo_id,$codigo_centro_costo,
				'$valor','".abs($diferencia)."','0');";			
			}elseif($diferencia<0){
				$insert1="NULL,NULL,NULL,$utilidad_puc,'UTILIDAD DEL EJERCICIO ".$anio."',$encabezado_registro_id,$centro_de_costo_id,$codigo_centro_costo,
				'$valor','0','".abs($diferencia)."');";
			}else{
				$insert1='';			
			}
			$insert_enc="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,tercero_id,
			periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,
			modifica,usuario_id )
			VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$documentos,$acumula,$tercero_enc,$periodo_contable_id,$mes_trece,$consecutivo,
			'$fecha_doc','CIERRE  A&Ntilde;O ".$anio."','C','$fechaProcesado $horaProcesado','".$this -> getUsuarioNombres()."',$usuario_id);";
			
			$result = $Model -> Save($periodo_contable_id,$desde,$hasta,$encabezado_registro_id,$insert_enc,$insert,$insert1,$this  -> getConex());
			
			if($result>0){
				$this->viewDocument($result); 
			}
			
		}else{
			exit('Cuenta Origen sin Registros durante el Periodo Seleccionado'); 
		}

		

	}  
	
	
	protected function Preimpresion(){
		$encabezado_registro_id    = $this -> requestData('encabezado_registro_id');
		if($encabezado_registro_id>0){
			$this->viewDocument($encabezado_registro_id); 
		}	  
		
	}
	
	protected function viewDocument($encabezado_registro_id){
		
		require_once("View_DocumentClass.php");
		
		$print   = new View_Document();  	
		$print -> printOut1($encabezado_registro_id,$this -> getConex()); 	  
		
	}
	
	protected function onclickPrint(){

		require_once("Imp_DocumentoClass.php");

		$print = new Imp_Documento();

		$print -> printOut($this -> getConex());  

	}  
	
	protected function onclickExport(){

		$agrupar = $this -> requestData('agrupar');	
		
		if($agrupar == 'defecto'){
			$this -> getAuxiliarDefecto(false,true);
		}else if($agrupar == 'cuenta'){
			$this -> getAuxiliarCuenta(false,true);
		}

	}

	/****** getEstadoEncabezadoRegistro ***** */
	protected function getEstadoEncabezadoRegistro($Conex=''){
		
		require_once("CierresModelClass.php");
		
		$Model = new CierresModel();
		$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];	
		
		$Estado = $Model ->selectEstadoEncabezadoRegistro($encabezado_registro_id,$this -> getConex());
		
		exit("$Estado");
		
	} 
	/**** onclickCancellation ***** */
	protected function onclickCancellation(){
		
		require_once("CierresModelClass.php");
		
		$Model = new CierresModel();
	    $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];

		$data_periodo = $Model->validarPeriodo($encabezado_registro_id,$this->getConex());

		$periodo_contable_id = $data_periodo[0]["periodo_contable_id"];

  // metodo validarCierreFin en el model se la envia la variable ncabezado_registro_id
		$data = $Model->validarCierreFin($periodo_contable_id, $this->getConex());
 // validar si la data es mayor a 0
		if(count($data )> 0){
			exit("Se debe anular los documentos de los años posteriores");
		}
		
		$Model -> cancellation($this -> getConex());
		
		if(strlen($Model -> GetError()) > 0){
			exit('false');
		}else{
			exit('true');
		}
		
	}
	/***************************************************** */
	
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
            	 
            	 
            	 
            	 
            	 $this -> Campos[desde] = array(
            	 	name	=>'desde',
            	 	id		=>'desde',
            	 	type	=>'text',
            	 	Boostrap=>'si',
            	 	required=>'yes',
            	 	value   =>'',
            	 	datatype=>array(
            	 		type	=>'date')
            	 );
            	 
            	 $this -> Campos[hasta] = array(
            	 	name	=>'hasta',
            	 	id		=>'hasta',
            	 	type	=>'text',
            	 	Boostrap=>'si',
            	 	required=>'yes',
            	 	value   =>'',
            	 	datatype=>array(
            	 		type	=>'date')
            	 );	

            	 $this -> Campos[fecha_doc] = array(
            	 	name	=>'fecha_doc',
            	 	id		=>'fecha_doc',
            	 	type	=>'text',
            	 	Boostrap=>'si',
            	 	required=>'yes',
            	 	readonly=>'yes',
            	 	value   =>'',
            	 	datatype=>array(
            	 		type	=>'text')
            	 );	

            	 
            	 $this -> Campos[opciones_tercero] = array(
            	 	name	=>'opciones_tercero',
            	 	id		=>'opciones_tercero',
            	 	type	=>'select',
            	 	Boostrap=>'si',
            	 	required=>'yes',
            	 	options =>array(array(value=>'T',text=>'SI'),array(value=>'U',text=>'NO')),
            	 	selected=>'T',		
            	 	datatype=>array(
            	 		type	=>'alpha')
            	 );	

            	 $this -> Campos[opciones_centro] = array(
            	 	name	=>'opciones_centro',
            	 	id		=>'opciones_centro',
            	 	type	=>'select',
            	 	Boostrap=>'si',
            	 	required=>'yes',
            	 	options =>array(array(value=>'T',text=>'SI'),array(value=>'U',text=>'NO')),
            	 	selected=>'T',		
            	 	datatype=>array(
            	 		type	=>'alpha')
            	 );	

            	 $this -> Campos[centro_de_costo] = array(
            	 	name	=>'centro_de_costo',
            	 	id		=>'centro_de_costo',
            	 	type	=>'text',
            	 	Boostrap=>'si',
            	 	disabled=>'yes',
            	 	suggest=>array(
            	 		name	=>'centro_costo',
            	 		setId	=>'centro_de_costo_id')
            	 );
            	 
            	 $this -> Campos[centro_de_costo_id] = array(
            	 	name	=>'centro_de_costo_id',
            	 	id		=>'centro_de_costo_id',
            	 	type	=>'hidden',
            	 	datatype=>array(
            	 		type	=>'integer')
            	 );
            	 
            	 $this -> Campos[documentos] = array(
            	 	name	=>'documentos',
            	 	id		=>'documentos',
            	 	type	=>'select',
            	 	Boostrap=>'si',
            	 	required=>'yes',		
            	 	selected=>'NULL',
            	 	options =>array(),
            	 	datatype=>array(
            	 		type	=>'integer')
            	 );	
            	 
            	 

            	 $this -> Campos[encabezado_registro_id] = array(
            	 	name	=>'encabezado_registro_id',
            	 	id		=>'encabezado_registro_id',
            	 	type	=>'hidden',
            	 	transaction=>array(
            	 		table	=>array('encabezado_de_registro'),
            	 		type	=>array('primary_key')
            	 	)

            	 );				
            	 
            	 

	/*****************************************
	        Campos Anulacion Registro
	        *****************************************/
	        
	        
	        $this -> Campos[fecha_log] = array(
	        	name	=>'fecha_log',
	        	id		=>'fecha_log',
	        	type	=>'text',
	        	Boostrap=>'si',
	        	size    =>'17',
	        	value   =>date("Y-m-d H:m"),
	        	datatype=>array(
	        		type	=>'text')
	        );	
	        
	        $this -> Campos[causal_anulacion_id] = array(
	        	name	=>'causal_anulacion_id',
	        	id		=>'causal_anulacion_id',
	        	type	=>'select',
	        	Boostrap=>'si',
	        	required=>'yes',
	        	options	=>array(),
	        	datatype=>array(
	        		type	=>'integer')
	        );		
	        
	        
	        $this -> Campos[observaciones] = array(
	        	name	=>'observaciones',
	        	id		=>'observaciones',
	        	type	=>'textarea',
	        	value	=>'',
	        	required=>'yes',
	        	datatype=>array(
	        		type	=>'text')
	        );	
	        

	//botones
	        
	        $this -> Campos[generar] = array(
	        	name	=>'generar',
	        	id		=>'generar',
	        	type	=>'button',
	        	value	=>'Generar',
	        	onclick =>'onclickGenerarAuxiliar(this.form)'
	        );		
	        
	        $this -> Campos[imprimir] = array(
	        	name    =>'imprimir',
	        	id      =>'imprimir',
	        	type    =>'print',
	        	value   =>'Imprimir',
	        	disabled=>'yes',
	        	displayoptions => array(
	        		form        => 0,
	        		beforeprint => 'beforePrint',
	        		title       => 'Impresion Cierre',
	        		width       => '900',
	        		height      => '600'
	        	)

	        );	

	        $this -> Campos[borrar] = array(
	        	name	=>'borrar',
	        	id		=>'borrar',
	        	type	=>'button',
	        	value	=>'Borrar',
	        	disabled=>'disabled',
	        	onclick =>'onclickDelete(this.form)'
	        );
	        /****** boton anular ******* */
	        $this -> Campos[anular] = array(
	        	name	=>'anular',
	        	id		=>'anular',
	        	type	=>'button',
	        	value	=>'Anular',
		//disabled=>'disabled',
	        	onclick =>'onclickCancellation(this.form)'
	        );	


	        $this -> Campos[limpiar] = array(
	        	name	=>'limpiar',
	        	id		=>'limpiar',
	        	type	=>'reset',
	        	value	=>'Limpiar',
	        	onclick => 'MovimientosContablesOnReset()'
	        );	
	        
	        $this -> Campos[export] = array(
	        	name    =>'export',
	        	id      =>'export',
	        	type    =>'button',
	        	value   =>'Exportar a Excel'
	        );	

	//busqueda
	        $this -> Campos[busqueda] = array(
	        	name	=>'busqueda',
	        	id		=>'busqueda',
	        	type	=>'text',
	        	Boostrap=>'si',
	        	size	=>'85',
		//tabindex=>'1',
	        	suggest=>array(
	        		name	=>'movimientos_contables_cierre',
	        		setId	=>'encabezado_registro_id',
	        		onclick	=>'setDataFormWithResponse')
	        );	

	        $this -> SetVarsValidate($this -> Campos);
	    }
	    
	    
	}

	new Cierres();

	?>