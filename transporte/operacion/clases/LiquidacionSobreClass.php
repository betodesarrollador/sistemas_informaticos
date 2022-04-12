<?php

require_once("../../../framework/clases/ControlerClass.php");

final class LiquidacionSobre extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("LiquidacionSobreLayoutClass.php");
	require_once("LiquidacionSobreModelClass.php");
	
	$Layout   = new LiquidacionSobreLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LiquidacionSobreModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);		
	
	$Layout -> setOficinas($Model -> selectOficinas($this -> getEmpresaId(),$this -> getConex()));			
	
	//// GRID ////
	$Attributes = array(
	  id=>'LiquidacionSobreManifiestos',
	  title=>'Solicitud Servicio de Transporte',
	  sortname=>'manifiesto',
	  width=>'auto',
	  height=>'250'
	);
	
	$Cols           = array();	
	$colsImpuestos  = $Model -> getColumnsImpGridLiquidacionSobre($this -> getConex()); 	
	$colsDescuentos = $Model -> getColumnsDesGridLiquidacionSobre($this -> getConex()); 	
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
  	require_once("LiquidacionSobreModelClass.php");
	
    $Model         = new LiquidacionSobreModel();
	$Validaciones  = new ValidacionesManifiestoModel();		    
	$manifiesto    = $this -> requestData('manifiesto');			
	$manifiesto_id = $this -> requestData('manifiesto_id');				
    $oficina_id    = $this -> getOficinaId();	
		
	if($Validaciones -> manifiestoExiste($manifiesto_id,$this -> getConex())){			
		
	  //if($Validaciones  -> manifiestoEsOficinaLegalizar($manifiesto,$oficina_id,$this -> getConex())){
	
		//if($Validaciones -> manifiestoEstaCausado($manifiesto_id,$this -> getConex())){
		
			if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
			
			   if($Validaciones -> anticiposGeneroEgreso($manifiesto_id,$this -> getConex())){
			   		   
	            if($Model -> existeLiquidacionSobre($manifiesto_id,$this -> getConex())){
		               if($Model -> existeLiquidacionSobreFlete($manifiesto_id,$this -> getConex())){					
					   		exit("El manifiesto [ $manifiesto ] ya tiene Un Sobre Flete EN EDICION o CONTABILIZADO.<br> Por favor realice la busqueda en la parte superior !! ");
					   }

					   $data = $Model -> selectManifiesto($manifiesto_id,$this -> getConex());
				
					   if($Model -> GetNumError() > 0){
						exit('Ocurrio una inconsistencia');
					   }else{
						  $this -> getArrayJSON($data);
					   }	

	
	             }else{				 
		             $estado = $Model -> getEstadoLiquidacionSobre($manifiesto_id,$this -> getConex());	
					 $estado_man = $Model -> getEstadoMani($manifiesto_id,$this -> getConex());	
	   
		             if($estado == 'L'){
	      		         exit("El manifiesto [ $manifiesto ] se encuentra liquidado. Por favor debe causar!! ");
	               	 }else if($estado == 'A'){
        	         	exit("La liquidaci&oacute;n del manifiesto [ $manifiesto ] ya se encuentra anulado!! ");		
		             }
					 if($estado_man=='A'){
						 exit("El manifiesto [ $manifiesto ] se encuentra anulado!! ");	
					 }
	              } 			   
				  
		  
				  
				}else{
				  
				       exit("<div align='center'>No se ha generado egreso para uno de los anticipos de este despacho,<br>por favor ingrese por la opcion : <br><br><b>Modulo Tranporte -> Operacion -> Despachar -> Generar Anticipos.</b></div>");
				  
				  }			

			
			}else{
			
                 exit(utf8_encode("Para los despachos realizados por vehiculos propios<br>debe ingresar por la opcion [ Legalizacion Propios ]"));
			
			
			  }
	
		
		//}else{
//	   
//			 exit("El manifiesto aun no esta planillado!!");	
//		
//		  }
//	  
	  
	 // }else{
	 //     exit("El manifiesto se despacho por otra oficina!!");
	 //   }
	  
	  
	}else{
	     
		 exit("El manifiesto no existe!!");
	
	  }
	

	
  
  }
  
  protected function getLiquidacionSobreManifiesto(){
  
  	require_once("LiquidacionSobreModelClass.php");
    $Model = new LiquidacionSobreModel();
    
	$manifiesto_id = $this -> requestData('manifiesto_id');	
	$data          = $Model -> selectLiquidacionSobreManifiesto($manifiesto_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{	
	    $this -> getArrayJSON($data);
	  }
  
  }
    
  protected function onclickSave(){
       
  	require_once("LiquidacionSobreModelClass.php");
    require_once("ValidacionesManifiestoModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
		
    $Model               = new LiquidacionSobreModel();
	$Validaciones        = new ValidacionesManifiestoModel();	
	$UtilidadesContables = new UtilidadesContablesModel();	
    
	$empresa_id    = $this -> getEmpresaId();
	$oficina_id    = $this -> getOficinaId();
	$manifiesto    = $this -> requestData('manifiesto');
	$manifiesto_id = $this -> requestData('manifiesto_id');
	
	if($Model -> existeLiquidacionSobre($manifiesto_id,$this -> getConex())){
		if($Validaciones -> esViajeTercerizado($manifiesto_id,$this -> getConex())){
	    	$Model -> Save($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
			  if($Model -> GetNumError() > 0){
				  exit('Ocurrio una inconsistencia');
			  }else{
				  exit("<p align='center'>Se liquido correctamente sobre flete del Manifiesto</p><p align='center'>Proceda a contabilizar!!!!</p>");
			  }										
	    }else{
			exit("Este despacho fue realizado por un vehiculo propio, ingrese por legalizacion propios!!");		   
		}
	}else{

	  $estado = $Model -> getEstadoLiquidacionSobre($manifiesto_id,$this -> getConex());	
	   
	  if($estado == 'L'){
	    exit("El Manifiesto [ $manifiesto ] ya se liquido.<br> Se debe causar!! ");
      }else if($estado == 'A'){
        exit("El Manifiesto [ $manifiesto ] se encuentra anulado!! ");		
	  }

					 
   }
	
  }


  protected function onclickUpdate(){
 	  
  	require_once("LiquidacionSobreModelClass.php");
    $Model = new LiquidacionSobreModel();
		
    $Model -> Update($this -> Campos,$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit("<p align='center'>Se liquido correctamente el manifiesto</p><p align='center'>Proceda a causar en el modulo deproveedores!!!!</p>");
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("LiquidacionSobreModelClass.php");
    $Model = new LiquidacionSobreModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el manifiesto');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){  

  	require_once("LiquidacionSobreModelClass.php");
	
    $Model                   = new LiquidacionSobreModel();
	$liquidacion_despacho_sobre_id = $_REQUEST['liquidacion_despacho_sobre_id'];
				
	$Data  = $Model -> selectLiquidacionSobre($liquidacion_despacho_sobre_id,$this -> getConex());
		
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  
  
  
  protected function onclickPrint(){
    	
    require_once("Imp_LiquidacionSobreClass.php");

    $print = new Imp_LiquidacionSobre();

    $print -> printOut($this -> getConex());            	
	
  }
  


  protected function calcularFlete(){
  
     require_once("ManifiestosModelClass.php");
     $Model = new ManifiestosModel();  
    
	 $arrayResponse     = array();
	 $tenedor_id        = $this -> requestData('tenedor_id');	 
     $impuestos         = $_REQUEST['impuestos']; 
	 $descuentos        = $_REQUEST['descuentos'];
	 $anticipo          = $_REQUEST['anticipo'];	 	 
	 $valor_flete       = str_replace(",",".",str_replace(".","",$_REQUEST['valor_flete']));	  
	 $valor_sobre_flete = str_replace(",",".",str_replace(".","",$_REQUEST['valor_sobre_flete']));	
	 $observacion_sobre_flete = $_REQUEST['observacion_sobre_flete'];  	 
	 $total_impuestos   = 0;
	 $total_descuentos  = 0;
	 $valor_neto_pagar  = 0;
	 	 
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

  protected function onclickContabilizar(){
	
  	require_once("LiquidacionSobreModelClass.php");
    $Model = new LiquidacionSobreModel();
	$liquidacion_despacho_sobre_id 	 = $_REQUEST['liquidacion_despacho_sobre_id'];
	$fecha = $_REQUEST['fecha'];

	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($liquidacion_despacho_sobre_id,$empresa_id,$oficina_id,$usuario_id,$this -> getConex());
		if($return==true){
			exit("true");
		}else{
			exit("Error : ".$Model -> GetError());
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
	
	$this -> Campos[liquidacion_despacho_sobre_id] = array(
		name	=>'liquidacion_despacho_sobre_id',
		id		=>'liquidacion_despacho_sobre_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('liquidacion_despacho_sobre'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho_sobre'),
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
			table	=>array('liquidacion_despacho_sobre'),
			type	=>array('column'))
	);		
	
	$this -> Campos[estado_liquidacion] = array(
		name	 =>'estado_liquidacion',
		id		 =>'estado_liquidacion',
		type	 =>'select',
		options  =>array(array(value => 'L', text => 'LIQUIDADO'),array(value => 'C', text => 'CAUSADO')),
		disabled =>'true',
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('liquidacion_despacho_sobre'),
			type	=>array('column'))
	);		

	$this -> Campos[manifiesto] = array(
		name  =>'manifiesto',
		id	  =>'manifiesto',
		type  =>'text',
		required =>'yes',
	 	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('liquidacion_despacho_sobre'),
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
		value      =>'LIQUIDACION SOBRE FLETE MC:  ',
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
			table	=>array('liquidacion_despacho_sobre'),
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
			table	=>array('liquidacion_despacho_sobre'),
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
	$this -> Campos[doc_contable] = array(
		name	=>'doc_contable',
		id	    =>'doc_contable',
		type	=>'text',
		datatype=>array(type=>'text')
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
		id	    =>'total_costos_viaje',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'numeric')
	);				
		
	$this -> Campos[diferencia] = array(
		name	=>'diferencia',
		id	=>'diferencia',
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


      $this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'print',
		disabled=>'disabled',
		value   =>'Imprimir',
		displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion LiquidacionSobre',
		  width       => '900',
		  height      => '600'
		)

    );
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'LiquidacionSobreManifiestoOnReset(this.form)'
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
			name	=>'liquidacion_despacho_sobre',
			setId	=>'liquidacion_despacho_sobre_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$LiquidacionSobre = new LiquidacionSobre();

?>