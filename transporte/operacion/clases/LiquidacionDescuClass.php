<?php

require_once("../../../framework/clases/ControlerClass.php");

final class LiquidacionDescu extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){ 
  
    $this -> noCache();

	require_once("LiquidacionDescuLayoutClass.php");
	require_once("LiquidacionDescuModelClass.php");
	
	$Layout   = new LiquidacionDescuLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LiquidacionDescuModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);		
	
	$Layout -> setOficinas($Model -> selectOficinas($this -> getEmpresaId(),$this -> getConex()));			
	
	//// GRID ////
	$Attributes = array(
	  id=>'LiquidacionDescuManifiestos',
	  title=>'Solicitud Servicio de Transporte',
	  sortname=>'manifiesto',
	  width=>'auto',
	  height=>'250'
	);
	
	$Cols           = array();	
	$colsImpuestos  = $Model -> getColumnsImpGridLiquidacionDescu($this -> getConex()); 	
	$colsDescuentos = $Model -> getColumnsDesGridLiquidacionDescu($this -> getConex()); 	
    $cont           = 0;
	
	$Cols[$cont]['name']     = 'manifiesto';
    $Cols[$cont]['index']    = 'manifiesto';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;
	
	$Cols[$cont]['name']     = 'fecha_manifiesto';
    $Cols[$cont]['index']    = 'fecha_mc';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;
	
	$Cols[$cont]['name']     = 'fecha_liquidacion';
    $Cols[$cont]['index']    = 'fecha';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;
	
	$Cols[$cont]['name']     = 'lugar_autorizado_pago';
    $Cols[$cont]['index']    = 'lugar_autorizado_pago';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';				
	
	$cont++;	
	
	$Cols[$cont]['name']     = 'placa';
    $Cols[$cont]['index']    = 'placa';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;
	
	$Cols[$cont]['name']     = 'numero_identificacion_tenedor';
    $Cols[$cont]['index']    = 'numero_identificacion_tenedor';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;
	
	$Cols[$cont]['name']     = 'tenedor';
    $Cols[$cont]['index']    = 'tenedor';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;
	
	$Cols[$cont]['name']     = 'valor_total';
    $Cols[$cont]['index']    = 'valor_total';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';	
	
	$cont++;	
	
	$Cols[$cont]['name']     = 'anticipos';
    $Cols[$cont]['index']    = 'anticipos';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';					

	for($i = 0; $i < count($colsImpuestos); $i++){
	
	   $cont++;
	
	   $Cols[$cont]['name']     = $colsImpuestos[$i]['nombre'];
	   $Cols[$cont]['index']    = $colsImpuestos[$i]['nombre'];
       $Cols[$cont]['sorttype'] = 'text';
       $Cols[$cont]['width']    = '200';
       $Cols[$cont]['align']    = 'center';
	   
	   
	}
		
	for($i = 0; $i < count($colsDescuentos); $i++){
	
	   $cont++;
	   
	   $Cols[$cont]['name']     = $colsDescuentos[$i]['nombre'];
	   $Cols[$cont]['index']    = $colsDescuentos[$i]['nombre'];
       $Cols[$cont]['sorttype'] = 'text';
       $Cols[$cont]['width']    = '200';
       $Cols[$cont]['align']    = 'center';
	   	   
	}
	
    $cont++;	
	
	$Cols[$cont]['name']     = 'saldo_por_pagar';
    $Cols[$cont]['index']    = 'saldo_por_pagar';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';		
			
	$Titles  = array();
	
	for($i = 0; $i < count($Cols); $i++){	
	  $Titles[$i] = strtoupper($Cols[$i]['name']);
	}
	
	//$Layout -> SetGridManifiestos($Attributes,$Titles,$Cols,$Model -> getQueryManifiestosGrid($this -> getOficinaId(),$colsImpuestos,$colsDescuentos));	

	$Layout -> RenderMain();
  
  }
  
  protected function getDataManifiesto(){
  
    require_once("ValidacionesManifiestoModelClass.php");  
  	require_once("LiquidacionDescuModelClass.php");
	
    $Model         = new LiquidacionDescuModel();
	$Validaciones  = new ValidacionesManifiestoModel();		    
	$manifiesto    = $this -> requestData('manifiesto');			
	$manifiesto_id = $this -> requestData('manifiesto_id');				
    $oficina_id    = $this -> getOficinaId();	
		
	if($Validaciones -> manifiestoExiste($manifiesto_id,$this -> getConex())){			
		
	  //if($Validaciones  -> manifiestoEsOficinaLegalizar($manifiesto,$oficina_id,$this -> getConex())){
	
		if($Validaciones -> manifiestoEstaManifestado($manifiesto_id,$this -> getConex())){
		
			if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
			
			   if($Validaciones -> anticiposGeneroEgreso($manifiesto_id,$this -> getConex())){
			   			   
	            if($Model -> existeLiquidacionDescu($manifiesto_id,$this -> getConex())){

	             $estado = $Model -> getEstadoLiquidacionDescu($manifiesto_id,$this -> getConex());	

	             if($estado == 'L'){
	               exit("El manifiesto [ $manifiesto ] ya se liquido y se encuentra pendiente de causar!! ");
	             }else if($estado == 'C'){
      	            exit("El manifiesto [ $manifiesto ] ya se encuentra liquidado y causado!! ");
	               }else if($estado == 'A'){
        	         exit("El manifiesto [ $manifiesto ] ya se encuentra anulado!! ");		
		              }
	
	             }else{				 
				 
	    			  	$data = $Model -> selectManifiesto($manifiesto_id,$this -> getConex());
				
				       if($Model -> GetNumError() > 0){
				        exit('Ocurrio una inconsistencia');
				       }else{
					      $this -> getArrayJSON($data);
				         }	
						 
	                } 			   
				  
		  
				  
				}else{
				  
				       exit("<div align='center'>No se ha generado egreso para uno de los anticipos de este despacho,<br>por favor ingrese por la opcion : <br><br><b>Modulo Tranporte -> Operacion -> Despachar -> Generar Anticipos.</b></div>");
				  
				  }			

			
			}else{
			
                 exit(utf8_encode("Para los despachos realizados por vehiculos propios<br>debe ingresar por la opcion [ Legalizacion Propios ]"));
			
			
			  }
	
		
		}else{
	   
			 exit("El manifiesto aun no esta planillado!!");	
		
		  }
	  
	  
	 // }else{
	 //     exit("El manifiesto se despacho por otra oficina!!");
	 //   }
	  
	  
	}else{
	     
		 exit("El manifiesto no existe!!");
	
	  }
	

	
  
  }
  
  protected function getLiquidacionDescuManifiesto(){
  
  	require_once("LiquidacionDescuModelClass.php");
    $Model = new LiquidacionDescuModel();
    
	$manifiesto_id = $this -> requestData('manifiesto_id');	
	$data          = $Model -> selectLiquidacionDescuManifiesto($manifiesto_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
		exit('Ocurrio una inconsistencia');
	}else{	
		$this -> getArrayJSON($data);
	  }
  
  }
  
  protected function onclickSave(){
	  
	  require_once("LiquidacionDescuModelClass.php");
	  require_once("ValidacionesManifiestoModelClass.php");
	  require_once("UtilidadesContablesModelClass.php");
	  
	  $Model               = new LiquidacionDescuModel();
	  $Validaciones        = new ValidacionesManifiestoModel();	
	  $UtilidadesContables = new UtilidadesContablesModel();	
	  
	  $empresa_id    = $this -> getEmpresaId();
	  $oficina_id    = $this -> getOficinaId();
	  $manifiesto    = $this -> requestData('manifiesto');
	  $manifiesto_id = $this -> requestData('manifiesto_id');
	  
	if($Model -> existeLiquidacionDescu($manifiesto_id,$this -> getConex())){
		
	  $estado = $Model -> getEstadoLiquidacionDescu($manifiesto_id,$this -> getConex());	
	   
	  if($estado == 'L'){
	    exit("El despacho [ $manifiesto ] ya se liquido y se encuentra pendiente de causar!! ");
	  }else if($estado == 'C'){
      	  exit("El despacho [ $manifiesto ] ya se encuentra liquidado y causado!! ");
	    }else if($estado == 'A'){
        	  exit("El despacho [ $manifiesto ] se encuentra anulado!! ");		
		   }
	
	}else{
		if($Validaciones -> manifiestoEstaManifestado($manifiesto_id,$this -> getConex())){
			
			if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
				

				$Model -> Save($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
				
				if($Model -> GetNumError() > 0){
	                exit('Ocurrio una inconsistencia');
	              }else{
	                  exit("<p align='center'>Se liquido correctamente el despacho</p><p align='center'>Proceda a Contabilizar!!!!</p>");
	                }										
			        			   		   

				}else{
					exit("Este despacho fue realizado por un vehiculo propio, ingrese por legalizacion propios!!");		   
		     }
		
			}else{
				exit("Este despacho no se puede liquidar!!!");
			}
			
		}
		
	}
	
	
	protected function onclickUpdate(){
		
  	require_once("LiquidacionDescuModelClass.php");
    $Model = new LiquidacionDescuModel();
		
    $Model -> Update($this -> Campos,$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit("<p align='center'>Se liquido correctamente los descuentos del manifiesto</p><p align='center'>Proceda a Contabilizar!!!!</p>");
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("LiquidacionDescuModelClass.php");
    $Model = new LiquidacionDescuModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el manifiesto');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){  

  	require_once("LiquidacionDescuModelClass.php");
	
    $Model                   = new LiquidacionDescuModel();
	$liquidacion_despacho_descu_id = $_REQUEST['liquidacion_despacho_descu_id'];
				
	$Data  = $Model -> selectLiquidacionDescu($liquidacion_despacho_descu_id,$this -> getConex());
		
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  
  
  
  protected function onclickPrint(){
    	
    require_once("Imp_LiquidacionDescuClass.php");

    $print = new Imp_LiquidacionDescu();

    $print -> printOut($this -> getConex());            	
	
  }
  
  protected function cumplirManifiestoCargaMinisterio(){ //aca
    
      require_once("LiquidacionDescuModelClass.php");
	  include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	  $Model         = new LiquidacionDescuModel();	  
	  $webService    = new WebServiceMinTransporte($this -> getConex());
	  
	  $manifiesto_id = $this -> requestData('manifiesto_id');
	  $liquidacion_despacho_id = $this -> requestData('liquidacion_despacho_id');
	  $remesas       = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> getConex());		  		  
	  
	  			 
	  if($manifiesto_id>0){
		  $data = array(	  
		
			manifiesto_id                        => $manifiesto_id,	
			liquidacion_despacho_id              => $liquidacion_despacho_id,	
			manifiesto                           => $this -> requestData('manifiesto'),	
			tipo_identificacion_conductor_codigo => $this -> requestData('tipo_identificacion_conductor_codigo'),	
			conductor_id                         => $this -> requestData('conductor_id'),			
			numero_identificacion                => $this -> requestData('numero_identificacion'),	
			placa_id                             => $this -> requestData('placa_id'),			
			placa                                => $this -> requestData('placa'),		
			placa_remolque_id                    => $this -> requestData('placa_remolque_id'),			
			placa_remolque                       => $this -> requestData('placa_remolque'),			
			origen_id                            => $this -> requestData('origen_id'),			
			destino_id                           => $this -> requestData('destino_id'),			
			valor_flete                          => $valor_flete,		
			remesas                              => $remesas
		
		  );
		  
		  $webService -> cumplirManifiestoCargaMinisterio($data,true);	  	 
		  
	  }else{
			exit('No ha escogido un manifiesto');  
	  }
	  //mientras
	  /*$man_pend       = $Model -> selectManifiestos($this -> getConex());
	  //$man_pend       = $Model -> selectManifiestosPropios($this -> getConex());
	  for($l=0; $l<count($man_pend); $l++){ 
		  $manifiesto_id = $man_pend[$l]['manifiesto_id'];
		  //$liquidacion_despacho_id = $man_pend[$l]['liquidacion_despacho_id'];
		  $legalizacion_manifiesto_id = $man_pend[$l]['legalizacion_manifiesto_id'];
		  $remesas       = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> getConex());		  		  
		  
					 
		  if($manifiesto_id>0){
			  $data = array(	  
			
				manifiesto_id                        => $manifiesto_id,	
				legalizacion_manifiesto_id              => $legalizacion_manifiesto_id,	
				manifiesto                           => $man_pend[$l]['manifiesto'],	
				tipo_identificacion_conductor_codigo => $man_pend[$l]['tipo_identificacion_conductor_codigo'],	
				conductor_id                         => $man_pend[$l]['conductor_id'],			
				numero_identificacion                => $man_pend[$l]['numero_identificacion'],	
				placa_id                             => $man_pend[$l]['placa_id'],			
				placa                                => $man_pend[$l]['placa'],		
				placa_remolque_id                    => $man_pend[$l]['placa_remolque_id'],			
				placa_remolque                       => $man_pend[$l]['placa_remolque'],			
				origen_id                            => $man_pend[$l]['origen_id'],			
				destino_id                           => $man_pend[$l]['destino_id'],			
				valor_flete                          => $man_pend[$l]['valor_despacho'],		
				remesas                              => $remesas
			
			  );
			  
			  $webService -> cumplirManifiestoCargaMinisterio($data,true);	 

				echo '<script type="text/javascript">
				function redireccionar(){
				  window.location.href="http://192.254.167.235/rotterdan/transporte/operacion/clases/LiquidacionDescuClass.php?rand=943466877&ACTIONCONTROLER=cumplirManifiestoCargaMinisterio";
				} 
				setTimeout (redireccionar(), 30000); 
				</script>';
		  }else{
				exit('No ha escogido un manifiesto');  
		  }
		  
	  }*/
	  //mientras fin
	  
  
  }

  protected function onclickContabilizar(){
	
  	require_once("LiquidacionDescuModelClass.php");
    $Model = new LiquidacionDescuModel();
	$liquidacion_despacho_descu_id 	 = $_REQUEST['liquidacion_despacho_descu_id'];
	$fecha = $_REQUEST['fecha'];

	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	$debito_credito = $Model -> sumadebitocredito($liquidacion_despacho_descu_id,$this -> getConex());	
	
    if($mesContable && $periodoContable){
		if($debito_credito[0]['debito']==$debito_credito[0]['credito'] && $debito_credito[0]['credito']>0){
			$return=$Model -> getContabilizarReg($liquidacion_despacho_descu_id,$empresa_id,$oficina_id,$usuario_id,$this -> getConex());
			if($return==true){
				exit("true");
			}else{
				exit("Error : ".$Model -> GetError());
			}	
		}elseif($debito_credito[0]['debito']!=$debito_credito[0]['credito'] && ($debito_credito[0]['credito']>0 || $debito_credito[0]['debito']>0)){
			exit('No existen sumas Iguales');
		}else{
			exit('No existen descuentos, No se requiere Contabilizar');
		}
	}else{
			 
		if(!$mesContable && !$periodoContable){
			exit("No se permite Contabilizar en el periodo y mes seleccionado");
		}elseif(!$mesContable){
 		    exit("No se permite Contabilizar en el mes seleccionado");				 
		}else if(!$periodoContable){
		    exit("No se permite Contabilizar en el periodo seleccionado");				   
		}
	}
	  
  }


  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[liquidacion_despacho_descu_id] = array(
		name	=>'liquidacion_despacho_descu_id',
		id		=>'liquidacion_despacho_descu_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('column'))
	);	
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('column'))
	);		
	
	$this -> Campos[estado_liquidacion] = array(
		name	 =>'estado_liquidacion',
		id		 =>'estado_liquidacion',
		type	 =>'select',
		options  =>array(array(value => 'L', text => 'LIQUIDADO'),array(value => 'C', text => 'CONTABILIZADO')),
		disabled =>'true',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('column'))
	);		

	$this -> Campos[manifiesto] = array(
		name  =>'manifiesto',
		id	  =>'manifiesto',
		type  =>'text',
		required =>'yes',
	 	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('column')),
		suggest=>array(
			name	=>'manifiestos_sin_liquidar',
			setId	=>'manifiesto_id',
			onclick =>'getDataManifiesto'
			)
	);	
	
		
	$this -> Campos[manifiesto_id] = array(
		name	   =>'manifiesto_id',
		id	       =>'manifiesto_id',
		type	   =>'hidden',
		required   =>'yes',
	 	datatype=>array(
			type	=>'autoincrement')
	);	
	
	$this -> Campos[forma_pago_id] = array(
		name	   =>'forma_pago_id',
		id	       =>'forma_pago_id',
		type	   =>'select',
		disabled   =>'true',
		required   =>'yes',
		options    =>array(),
	 	datatype=>array(
			type	=>'integer')
	);	
	
	$this -> Campos[concepto] = array(
		name	   =>'concepto',
		id	       =>'concepto',
		type	   =>'text',
		size       =>'35',
		readonly   =>'true',
		value      =>'LIQUIDACION MC:  ',
	 	datatype=>array(
			type	=>'text')
	);				
	  
	$this -> Campos[fecha_static] = array(
		name	=>'fecha_static',
		id		=>'fecha_static',
		type	=>'hidden',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'text')
	);	  	
		
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('column'))
	);
	
	$this -> Campos[tenedor] = array(
		name	 =>'tenedor',
		id       =>'tenedor',
		type	 =>'text',
		size     =>'30',
		required =>'yes',
		readonly   =>'true',		
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('liquidacion_despacho_descu'),
			type	=>array('column'))
	);		
	
	$this -> Campos[tenedor_id] = array(
		name	 =>'tenedor_id',
		id       =>'tenedor_id',
		type	 =>'hidden',
		required =>'yes',	
	 	datatype=>array(type=>'integer')
	);	
	
	
	$this -> Campos[placa] = array(
		name	 =>'placa',
		id       =>'placa',
		type	 =>'text',
		required =>'yes',
		readonly =>'true',		
	 	datatype=>array(type=>'text')
	);		
	
	$this -> Campos[placa_id] = array(
		name	 =>'placa_id',
		id       =>'placa_id',
		type	 =>'hidden',
		required =>'yes',		
	 	datatype=>array(type=>'integer')
	);
	

	$this -> Campos[origen] = array(
		name	 =>'origen',
		id       =>'origen',
		type	 =>'text',
		required =>'yes',
		readonly =>'true',		
		datatype=>array(type=>'text')
	);		
	
	$this -> Campos[origen_id] = array(
		name	 =>'origen_id',
		id       =>'origen_id',
		type	 =>'hidden',
		required =>'yes',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[destino] = array(
		name	 =>'destino',
		id       =>'destino',
		type	 =>'text',
		required =>'yes',
		readonly =>'true',		
	 	datatype=>array(type=>'text')
	);		
	
	$this -> Campos[destino_id] = array(
		name	 =>'destino_id',
		id       =>'destino_id',
		type	 =>'hidden',
	 	datatype=>array(type=>'integer')
	);	


	$this -> Campos[cantidad_galon] = array(
		name	=>'cantidad_galon',
		id	    =>'cantidad_galon',
		type	=>'text',
		size	=>'5',
		readonly=>'yes',
		datatype=>array(type=>'numeric')
	);

	$this -> Campos[cantidad_peso] = array(
		name	=>'cantidad_peso',
		id	    =>'cantidad_peso',
		type	=>'text',
		size	=>'5',
		readonly=>'yes',		
		datatype=>array(type=>'numeric')
	);

	$this -> Campos[cantidad_volu] = array(
		name	=>'cantidad_volu',
		id	    =>'cantidad_volu',
		type	=>'text',
		size	=>'5',
		readonly=>'yes',		
		datatype=>array(type=>'numeric')
	);

	$this -> Campos[valor_galon] = array(
		name	=>'valor_galon',
		id	    =>'valor_galon',
		type	=>'text',
		size	=>'9',
		datatype=>array(type=>'numeric')
	);

	$this -> Campos[doc_contable] = array(
		name	=>'doc_contable',
		id	    =>'doc_contable',
		type	=>'text',
		datatype=>array(type=>'text')
	);

	
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id	    =>'observaciones',
		type	=>'textarea',
		cols    =>40,
		rows    =>2,
		datatype=>array(type=>'text')
	);			
	
	
	$this -> Campos[valor_descuentos] = array(
		name	=>'valor_descuentos',
		id	    =>'valor_descuentos',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);		
	
	
		
	
	$this -> Campos[elaboro] = array(
		name	=>'elaboro',
		id	=>'elaboro',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioNombres()
	);	
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioId()
	);	
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id	    =>'valor',
		type	=>'hidden',
		datatype=>array(type=>'numeric')
	);		
	

	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
	);

 	$this -> Campos[reportar] = array(
		name	=>'reportar',
		id		=>'reportar',
		type	=>'button',
		value	=>'Reportar Cumplido'
	);

      $this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'print',
		disabled=>'disabled',
		value   =>'Imprimir',
		displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion LiquidacionDescu',
		  width       => '900',
		  height      => '600'
		)

    );
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'LiquidacionDescuManifiestoOnReset(this.form)'
	);

   	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		onclick	=>'Contabilizar(this.form)'
	);

	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'liquidacion_despacho_descu',
			setId	=>'liquidacion_despacho_descu_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$LiquidacionDescu = new LiquidacionDescu();

?>