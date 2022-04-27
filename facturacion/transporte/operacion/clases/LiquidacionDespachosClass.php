<?php

require_once("../../../framework/clases/ControlerClass.php");

final class LiquidacionDespachos extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("LiquidacionDespachosLayoutClass.php");
	require_once("LiquidacionDespachosModelClass.php");
	
	$Layout   = new LiquidacionDespachosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LiquidacionDespachosModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> setAnular     ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));
	$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);		
	
	//LISTA MENU
	$Layout -> setOficinas   ($Model -> selectOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));

	$Attributes = array(
	  id=>'LiquidacionDespachos',
	  title=>'Solicitud Servicio de Transporte',
	  sortname=>'despacho',
	  width=>'auto',
	  height=>'250'
	);
	
	$Cols           = array();	
	$colsImpuestos  = $Model -> getColumnsImpGridLiquidacion($this -> getConex()); 	
	$colsDescuentos = $Model -> getColumnsDesGridLiquidacion($this -> getConex()); 	
    $cont           = 0;
	
	$Cols[$cont]['name']     = 'despacho';
    $Cols[$cont]['index']    = 'despacho';
    $Cols[$cont]['sorttype'] = 'text';
    $Cols[$cont]['width']    = '200';
    $Cols[$cont]['align']    = 'center';
	
	$cont++;
	
	$Cols[$cont]['name']     = 'fecha_despacho';
    $Cols[$cont]['index']    = 'fecha_du';
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
  
  protected function getDataDespacho(){
 
    require_once("ValidacionesDespachoModelClass.php"); 
  	require_once("LiquidacionDespachosModelClass.php");
	
    $Model        = new LiquidacionDespachosModel();
	$Validaciones = new ValidacionesDespachoModel();		
    
	$despacho             = $this -> requestData('despacho');	
	$despachos_urbanos_id = $this -> requestData('despachos_urbanos_id');	
    $oficina_id = $this -> getOficinaId();				
	
	//if($Validaciones -> despachoExiste($despacho,$this -> getConex())){
					
	  //if($Validaciones  -> despachoEsOficinaLegalizar($despacho,$oficina_id,$this -> getConex())){
	
		if($Validaciones -> despachoEstaManifestado($despachos_urbanos_id,$this -> getConex())){
		
			if($Validaciones -> esDespachoTercerizado($despachos_urbanos_id,$this -> getConex())){
						
			  if($Validaciones -> anticiposGeneroEgreso($despachos_urbanos_id,$this -> getConex())){				  
				  
				if($Model -> existeLiquidacionDespachos($despachos_urbanos_id,$this -> getConex())){ 
			
				  $estado = $Model -> getEstadoLiquidacionDespachos($despachos_urbanos_id,$this -> getConex());	

				  if($estado == 'L'){
					exit("El despacho [ $despacho ] ya se liquido y se encuentra pendiente de causar!! ");
				  }else if($estado == 'C'){
					  exit("El despacho [ $despacho ] ya se encuentra liquidado y causado!! ");
					}else if($estado == 'A'){
						  exit("El despacho [ $despacho ] ya se encuentra anulado!! ");		
					   }
				
				}else{	
				
			  	    $data = $Model -> selectDespacho($despachos_urbanos_id,$this -> getConex());
				
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
	   
			 exit("El despacho aun no esta planillado!!");	
		
		  }
	  
	  
	 // }else{
	 //     exit("El despacho se despacho por otra oficina!!");
	 //   }
	  
	  
	//}else{
	     
		// exit("El despacho no existe!!");
	
	  //}

  
  }
  
  protected function getLiquidacionDespachos(){
  
  	require_once("LiquidacionDespachosModelClass.php");
    $Model = new LiquidacionDespachosModel();
    
	$despachos_urbanos_id = $this -> requestData('despachos_urbanos_id');	
	$data                 = $Model -> selectLiquidacionDespachosManifiesto($despachos_urbanos_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{	
	    $this -> getArrayJSON($data);
	  }
  
  }
      
  protected function onclickSave(){
       
  	require_once("LiquidacionDespachosModelClass.php");
    require_once("ValidacionesDespachoModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
		
    $Model               = new LiquidacionDespachosModel();
	$Validaciones        = new ValidacionesDespachoModel();	
	$UtilidadesContables = new UtilidadesContablesModel();			
    
	$empresa_id           = $this -> getEmpresaId();
	$oficina_id           = $this -> getOficinaId();
	$despacho             = $this -> requestData('despacho');
	$despachos_urbanos_id = $this -> requestData('despachos_urbanos_id');	
	
	if($Model -> existeLiquidacionDespachos($despachos_urbanos_id,$this -> getConex())){

	  $estado = $Model -> getEstadoLiquidacionDespachos($despachos_urbanos_id,$this -> getConex());	
	   
	  if($estado == 'L'){
	    exit("El despacho [ $despacho ] ya se liquido y se encuentra pendiente de causar!! ");
	  }else if($estado == 'C'){
      	  exit("El despacho [ $despacho ] ya se encuentra liquidado y causado!! ");
	    }else if($estado == 'A'){
        	  exit("El despacho [ $despacho ] ya se encuentra anulado!! ");		
		   }
	
	}else{
	
	  if($Validaciones -> despachoExiste($despachos_urbanos_id,$this -> getConex())){
	
	    //if($Validaciones -> despachoEsOficinaLegalizar($despacho,$this -> getOficinaId(),$this -> getConex())){
	    
	      if($Validaciones -> despachoEstaManifestado($despachos_urbanos_id,$this -> getConex())){
		
		   if($Validaciones -> esDespachoTercerizado($despachos_urbanos_id,$this -> getConex())){
		   		   
		       if($Validaciones -> existeLiquidacionDespachos($despachos_urbanos_id,$this -> getConex())){
			     exit("Este despacho ya se encuentra liquidado!!!");
			   }else{	
	
	              $Model -> Save($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	              if($Model -> GetNumError() > 0){
	                exit('Ocurrio una inconsistencia');
	              }else{
	                  exit("<p align='center'>Se liquido correctamente el despacho</p><p align='center'>Proceda a causar en el modulo deproveedores!!!!</p>");
	                }	
	
	            }
				
		   }else{
		        exit("Este despacho fue realizado por un vehiculo propio, ingrese por legalizacion propios!!");		   
		     }
		
		}else{
		    exit("Este despacho no se puede liquidar!!!");
		  }
	  
	 // }else{
	     // exit("Este despacho se genero desde otra oficina!!!");
	   // }
	
	}else{
	    exit("Despacho no existe!!");
	  }				
			
	}
	
  }

  protected function onclickUpdate(){
 	  
  	require_once("LiquidacionDespachosModelClass.php");
    $Model = new LiquidacionDespachosModel();
	
    $Model -> Update($this -> Campos,$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit("<p align='center'>Se liquido correctamente el despacho</p><p align='center'>Proceda a causar en el modulo deproveedores!!!!</p>");
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("LiquidacionDespachosModelClass.php");
    $Model = new LiquidacionDespachosModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el despacho');
	  }
  }
  
     protected function onclickCancellation(){
  
     require_once("LiquidacionDespachosModelClass.php");
	 
	 //$Model                 = new ManifiestoModel(); 
     $Model                 = new LiquidacionDespachosModel(); 
 	 $despachos_urbanos_id  = $this -> requestDataForQuery('despachos_urbanos_id','integer');
	 $liquidacion_despacho_id         = $this -> requestDataForQuery('liquidacion_despacho_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($liquidacion_despacho_id,$despachos_urbanos_id ,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }
	
  }  


//BUSQUEDA
  protected function onclickFind(){  
	  
  	require_once("LiquidacionDespachosModelClass.php");
	
    $Model                   = new LiquidacionDespachosModel();
	$liquidacion_despacho_id = $_REQUEST['liquidacion_despacho_id'];
			
	$Data  = $Model -> selectLiquidacionDespachos($liquidacion_despacho_id,$this -> getConex());
	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  
  
  
  protected function onclickPrint(){
    	
    require_once("Imp_LiquidacionClass.php");

    $print = new Imp_Liquidacion();

    $print -> printOut($this -> getConex());          	
	
  }
  
  protected function calcularFlete(){
  
     require_once("DespachosUrbanosModelClass.php");
     $Model = new DespachosUrbanosModel();  
    
	 $arrayResponse    = array();
	 $tenedor_id       = $this -> requestData('tenedor_id');		 
     $impuestos        = $_REQUEST['impuestos']; 
	 $descuentos       = $_REQUEST['descuentos'];
	 $anticipo         = $_REQUEST['anticipo'];	 	 
	 $valor_flete      = str_replace(",",".",str_replace(".","",$_REQUEST['valor_flete']));	  
	 $valor_sobre_flete = str_replace(",",".",str_replace(".","",$_REQUEST['valor_sobre_flete']));	
	 $observacion_sobre_flete = $_REQUEST['observacion_sobre_flete'];  	 	 
	 $total_impuestos  = 0;
	 $total_descuentos = 0;
	 $valor_neto_pagar = 0;
	 
	 if($valor_sobre_flete > 0) $valor_flete += $valor_sobre_flete;	 
	 		 
	 for($i = 0; $i < count($impuestos); $i++){	 

       $impuesto_id  = $impuestos[$i]['impuesto_id'];
	   $dataImpuesto = $Model -> calcularImpuesto($tenedor_id,$valor_flete,$impuesto_id,$arrayResponse['impuestos'],$this -> getConex());
	   
	   $valor        = round($dataImpuesto['valor']);
	   $base         = $dataImpuesto['base'];
	   
	   $arrayResponse['impuestos'][$i]['impuesto_id'] = $impuesto_id;
	   $arrayResponse['impuestos'][$i]['valor']       = number_format($valor,0,',','.');	
	   $arrayResponse['impuestos'][$i]['base']        = $base;		   
	   	   
	   $total_impuestos += $valor;
	   	 
	 }
	 	 
	 $arrayResponse['valor_neto_pagar'] = number_format(($valor_flete - $total_impuestos),0,',','.');
	 $valor_neto_pagar                  = ($valor_flete - $total_impuestos);
	 
	 for($i = 0; $i  < count($descuentos); $i++){
	 	   	   
	   $descuento_id = $descuentos[$i]['descuento_id'];
	   $valor        = str_replace(",",".",str_replace(".","",$descuentos[$i]['valor']));	    
       $valor        = $Model -> calcularDescuento($valor,$valor_flete,$descuento_id,$this -> getConex());
	   $valor        = round($valor);
	   
	   $arrayResponse['descuentos'][$i]['descuento_id'] = $descuento_id;
       $arrayResponse['descuentos'][$i]['valor']        = number_format($valor,0,',','.');		   
	   	   
	   $total_descuentos += $valor;
	 
	 }
	 
	 $total_anticipos = 0;
	 
	 for($i = 0; $i  < count($anticipo); $i++){
	   $total_anticipos += str_replace(",",".",str_replace(".","",$anticipo[$i]['valor']));
	 }	 
	 
	 $arrayResponse['saldo_por_pagar'] = number_format(($valor_neto_pagar - ($total_descuentos + $total_anticipos)),0,',','.');
	 
	 exit(trim(json_encode($arrayResponse)));	 
	 
  
  }

  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[liquidacion_despacho_id] = array(
		name	=>'liquidacion_despacho_id',
		id		=>'liquidacion_despacho_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('liquidacion_despacho'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho'),
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
			table	=>array('liquidacion_despacho'),
			type	=>array('column'))
	);			
	
	$this -> Campos[estado_liquidacion] = array(
		name	 =>'estado_liquidacion',
		id		 =>'estado_liquidacion',
		type	 =>'select',
		options  =>array(array(value => 'L', text => 'LIQUIDADO'),array(value => 'C', text => 'CAUSADO'),array(value => 'A', text => 'ANULADO')),
		disabled =>'true',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('liquidacion_despacho'),
			type	=>array('column'))
	);		

	$this -> Campos[despacho] = array(
		name  =>'despacho',
		id	  =>'despacho',
		type  =>'text',
		required =>'yes',
	 	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho'),
			type	=>array('column')),
		suggest=>array(
			name	=>'despachos_sin_liquidar',
			setId	=>'despachos_urbanos_id',
			onclick =>'getDataDespacho'
			)
	);	
	
		
	$this -> Campos[despachos_urbanos_id] = array(
		name	       =>'despachos_urbanos_id',
		id	           =>'despachos_urbanos_id',
		type	       =>'hidden',
		required       =>'yes',
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
		value      =>'LIQUIDACION DU:  ',
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
		//readonly=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'date'),
		transaction=>array(
			table	=>array('liquidacion_despacho'),
			type	=>array('column'))
	);

	$this -> Campos[vencimiento] = array(
		name	=>'vencimiento',
		id		=>'vencimiento',
		type	=>'text',
		required=>'yes',
    	datatype=>array(type=>'date')
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
			table	=>array('liquidacion_despacho'),
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

	$this -> Campos[valor_flete] = array(
		name	=>'valor_flete',
		id	    =>'valor_flete',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);	
	
	$this -> Campos[valor_sobre_flete] = array(
		name	=>'valor_sobre_flete',
		id	    =>'valor_sobre_flete',
		type	=>'text',
		datatype=>array(type=>'numeric')
	);	
	
	$this -> Campos[observacion_sobre_flete] = array(
		name	=>'observacion_sobre_flete',
		id	    =>'observacion_sobre_flete',
		type	=>'textarea',
		cols    =>40,
		rows    =>2,
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
	
	$this -> Campos[valor_neto_pagar] = array(
		name	=>'valor_neto_pagar',
		id	=>'valor_neto_pagar',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);	
	
	$this -> Campos[saldo_por_pagar] = array(
		name	=>'saldo_por_pagar',
		id	    =>'saldo_por_pagar',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);		
	
	$this -> Campos[total_anticipos] = array(
		name	=>'total_anticipos',
		id	=>'total_anticipos',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);
	
	$this -> Campos[total_costos_viaje] = array(
		name	=>'total_costos_viaje',
		id	=>'total_costos_viaje',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);	
		
	
		
	$this -> Campos[diferencia] = array(
		name	=>'diferencia',
		id	    =>'diferencia',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);
	
	$this -> Campos[elaboro] = array(
		name	=>'elaboro',
		id	    =>'elaboro',
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
	
	$this -> Campos[autoriza_pago] = array(
		name	 =>'autoriza_pago',
		id		 =>'autoriza_pago',
		type	 =>'select',
		options  =>array(array(value => 'S', text => 'SI'),array(value => 'N', text => 'NO')),
		required =>'yes',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('liquidacion_despacho'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id	    =>'valor',
		type	=>'hidden',
		datatype=>array(type=>'numeric')
	);
	
	//ANULACION
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);		
	
	
	$this -> Campos[observacion_anulacion] = array(
		name	=>'observacion_anulacion',
		id		=>'observacion_anulacion',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text')
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
	
		$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation(this.form)'
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
		  title       => 'Impresion Liquidacion Despachos',
		  width       => '900',
		  height      => '600'
		)

    );
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'LiquidacionDespachosOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'liquidacion_despacho',
			setId	=>'liquidacion_despacho_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$LiquidacionDespachos = new LiquidacionDespachos();

?>