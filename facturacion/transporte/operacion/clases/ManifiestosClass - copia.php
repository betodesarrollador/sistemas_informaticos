<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Manifiestos extends Controler{

  public function __construct(){      
    parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("ManifiestosLayoutClass.php");
    require_once("ManifiestosModelClass.php");

    $Layout   = new ManifiestosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ManifiestosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);

//LISTA MENU

    $Layout -> SetTiposManifiesto($Model -> GetTiposManifiesto($this -> getConex()));
    $Layout -> setImpuestos($Model -> getImpuestos($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));	
    $Layout -> setDescuentos($Model -> GetDescuentos($this -> getOficinaId(),$this -> getConex()));
    $Layout -> setLugaresPagoSaldo($Model -> getLugaresSaldoPago($this -> getOficinaId(),$this -> getEmpresaId(),$this -> getConex()));	
    $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));	
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));			

	//// GRID ////
	$Attributes = array(
	  id=>'Manifiestos',
	  title=>'Solicitud Servicio de Transporte',
	  sortname=>'manifiesto',
	  width=>'auto',
	  height=>'250'
	);
	
	$Cols = array(
	  array(name=>'manifiesto',      index=>'manifiesto',      sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'propio',          index=>'propio',          sorttype=>'text', width=>'80',  align=>'center'),  
	  array(name=>'estado',          index=>'estado',          sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'fecha_mc',        index=>'fecha_mc',        sorttype=>'text', width=>'120', align=>'center'),
	  array(name=>'origen',          index=>'origen',          sorttype=>'text', width=>'150', align=>'center'),
	  array(name=>'destino',         index=>'destino',         sorttype=>'text', width=>'80',  align=>'center'),
	  array(name=>'conductor',       index=>'conductor',       sorttype=>'text', width=>'200',  align=>'center'),	  
	  array(name=>'placa',           index=>'placa',           sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'placa_remolque',  index=>'placa_remolque',  sorttype=>'text', width=>'100', align=>'center'),
	  array(name=>'valor_flete',     index=>'valor_flete',     sorttype=>'text', width=>'100', align=>'center'),	  
	  array(name=>'numero_anticipos',index=>'numero_anticipos',sorttype=>'text', width=>'100', align=>'center'),	  	  
	  array(name=>'anticipos',       index=>'anticipos',       sorttype=>'text', width=>'100', align=>'center'),	  	  
	  array(name=>'impuestos',       index=>'impuestos',       sorttype=>'text', width=>'100', align=>'center')
	);
	

    $Titles = array('MANIFIESTO','PROPIO','ESTADO','FECHA','ORIGEN','DESTINO','CONDUCTOR','PLACA','REMOLQUE',
                    'FLETE','No ANTICIPOS','ANTICIPOS','IMPUESTOS');

    $Layout -> SetGridManifiestos($Attributes,$Titles,$Cols,$Model -> getQueryManifiestosGrid($this -> getOficinaId()));

    $Layout -> RenderMain();
    
  }


  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"despachos_urbanos_id",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }
  
  protected function asignoRemesasManifiesto(){
  
    require_once("ManifiestosModelClass.php");
	
    $Model         = new ManifiestosModel();  
	$manifiesto_id = $this -> requestData('manifiesto_id');
	
	if($Model -> manifiestoTieneRemesas($manifiesto_id,$this -> getConex())){
	  exit('true');
	}else{
	     exit('false');
	  }
  
  }
  
  protected function setDivipolaOrigen(){
      
    require_once("ManifiestosModelClass.php");
	
    $Model        = new ManifiestosModel();
	$ubicacion_id = $_REQUEST['ubicacion_id'];
	
	$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());
  
    exit("$divipola");
  
  }
  
  protected function setDivipolaDestino(){
      
    require_once("ManifiestosModelClass.php");
	
    $Model        = new ManifiestosModel();
	$ubicacion_id = $_REQUEST['ubicacion_id'];
	
	$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());
  
    exit("$divipola");
  
  }  
  
  protected function setRuta(){
  

  	require_once("ManifiestosLayoutClass.php");
    require_once("ManifiestosModelClass.php");
	
	$Layout = new ManifiestosLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new ManifiestosModel();
	
    $origen_id  = $this -> requestData('origen_id');
    $destino_id = $this -> requestData('destino_id');	
    $ruta_id    = $this -> requestData('ruta_id');		
	
    $rutas      = $Model -> getRutas($origen_id,$destino_id,$this -> getConex());
	
    if(!count($rutas) > 0){
	  $rutas = array();
	}

    $field = array(
	  name	 =>'ruta_id',
	  id	 =>'ruta_id',
	  type	 =>'select',
	  options  => $rutas,
	  selected => is_numeric($ruta_id) ? $ruta_id : 'NULL',
      datatype=>array(type=>'integer')
	);
	  
	print $Layout -> getObjectHtml($field);
  
  }  

  protected function onclickSave(){
    
    require_once("ManifiestosModelClass.php");
	
    $Model                         = new ManifiestosModel();
	$usuario_id                    = $this -> getUsuarioId();
	$oficina_id                    = $this -> getOficinaId();
	$empresa_id                    = $this -> getEmpresaId();
	$usuarioNombres                = $this -> getUsuarioNombres();
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();
	
    $result = $Model -> Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
       $this -> getArrayJSON($result);
     }
	 
  }

  protected function onclickUpdate(){
    
  
  }
  
  protected function onclickDelete(){
  
    require_once("ManifiestosModelClass.php");
    $Model = new ManifiestosModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
        exit('Se elimino correctamente la Solicitud');  
       }
	   
  }
  
//BUSQUEDA
  protected function onclickFind(){
      
    require_once("ManifiestosModelClass.php");
    $Model = new ManifiestosModel();

    $manifiesto_id = $this -> requestData('manifiesto_id');

    $Data =  $Model -> selectManifiesto($manifiesto_id,$this -> getConex());
		
    $this -> getArrayJSON($Data);

  }

  protected function validaPreliquido(){

    require_once("ManifiestosModelClass.php");
    $Model = new ManifiestosModel();

    $preliquido = $Model -> selectPreliquido($manifiesto_id,$this -> getConex());

    if($preliquido){
      exit('true');
    }else{
        exit('false');
       }

  }
  
  protected function onclickPrint(){
    
    require_once("Imp_ManifiestoClass.php");

    $print = new Imp_Manifiesto($this -> getConex());

    $print -> printOut();
  
  }
  
  protected function setDataVehiculo(){
  
    require_once("ManifiestosModelClass.php");
    $Model = new ManifiestosModel();
  
    $placa_id = $this -> requestData('placa_id');
    $data     = $Model -> selectVehiculo($placa_id,$this -> getConex());

    $this -> getArrayJSON($data);
  
  }
  
  protected function setDataRemolque(){
  
    require_once("ManifiestosModelClass.php");
    $Model = new ManifiestosModel();
  
    $placa_remolque_id = $_REQUEST['placa_remolque_id'];
    $data     = $Model -> selectRemolque($placa_remolque_id,$this -> getConex());

    $this -> getArrayJSON($data);
  
  }  
  
  
  protected function setDataConductor(){
  
    require_once("ManifiestosModelClass.php");
	
    $Model        = new ManifiestosModel();  
    $conductor_id = $_REQUEST['conductor_id'];
    $data         = $Model -> selectConductor($conductor_id,$this -> getConex()); 

    $this -> getArrayJSON($data); 
  
  }
  
  protected function setDataTitular(){
  
    require_once("ManifiestosModelClass.php");
	
    $Model       = new ManifiestosModel();  
    $tenedor_id  = $_REQUEST['tenedor_id'];
    $data        = $Model -> selectDataTitular($tenedor_id,$this -> getConex()); 

    $this -> getArrayJSON($data); 
  
  
  }
  
  protected function setManifiesto(){
     
    require_once("ManifiestosModelClass.php");
    $Model = new ManifiestosModel();
	
    $Model                         = new ManifiestosModel();
	$usuario_id                    = $this -> getUsuarioId();
	$usuarioNombres                = $this -> getUsuarioNombres();	
	$actualizar                    = $this -> requestData('updateManifiesto');
	
	if($actualizar == 'true'){
	   $oficina_id           = $this -> requestData('oficina_id');		
	   $oficina_anticipo_id  = $this -> getOficinaId();		
	}else{
		 $oficina_id          = $this -> getOficinaId();	
	     $oficina_anticipo_id = $this -> getOficinaId();		
	  }

	$empresa_id                    = $this -> getEmpresaId();	
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();		
					
    $Model -> Update($usuario_id,$oficina_id,$oficina_anticipo_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
      }
  
  }
  
  protected function calcularFlete(){
  
     require_once("ManifiestosModelClass.php");
     $Model = new ManifiestosModel();  
    
	 $arrayResponse    = array();
	 $tenedor_id       = $this -> requestData('tenedor_id');
     $impuestos        = $_REQUEST['impuestos']; 
	 $descuentos       = $_REQUEST['descuentos'];
	 $anticipo         = $_REQUEST['anticipo'];	 	 
	 $valor_flete      = str_replace(",",".",str_replace(".","",$_REQUEST['valor_flete']));	  
	 $total_impuestos  = 0;
	 $total_descuentos = 0;
	 $valor_neto_pagar = 0;
	 		 
	 for($i = 0; $i < count($impuestos); $i++){	 

       $impuesto_id  = $impuestos[$i]['impuesto_id'];
	   $dataImpuesto = $Model -> calcularImpuesto($tenedor_id,$valor_flete,$impuesto_id,$arrayResponse['impuestos'],$this -> getConex());
	   
	   $valor        = round($dataImpuesto['valor']);
	   $base         = $dataImpuesto['base'];
	   $porcentaje   = $dataImpuesto['porcentaje'];
	   
	   $arrayResponse['impuestos'][$i]['impuesto_id'] = $impuesto_id;
	   $arrayResponse['impuestos'][$i]['valor']       = number_format($valor,0,',','.');	
	   $arrayResponse['impuestos'][$i]['base']        = $base;		   
	   $arrayResponse['impuestos'][$i]['porcentaje']  = $porcentaje;		   	   
	   	   
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
  
  protected function validaNumeroFormulario(){
  
     require_once("ManifiestosModelClass.php");
     $Model = new ManifiestosModel();  
	 
	 $numero_formulario = $_REQUEST['numero_formulario'];
	 
	// if($Model -> existeFormulario($numero_formulario,$this -> getConex())){
	   exit('false');
	 //}else{
	   //  exit('false');	 
	   //}
  
  }
  
  protected function onclickCancellation(){
  
     require_once("ManifiestosModelClass.php");
	 
     $Model                 = new ManifiestosModel(); 
	 $manifiesto_id         = $this -> requestDataForQuery('manifiesto_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($manifiesto_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }
	
  }  
  
  protected function anularManifiestoMinisterio(){
  
	include_once("../../webservice/WebServiceMinTranporteClass.php");

	$webService = new WebServiceMinTransporte($this -> getConex());	 
	 
	$data = array(	  
	    manifiesto_id       => $this -> requestData('manifiesto_id'),		
	    manifiesto          => $this -> requestData('manifiesto'),	
		causal_anulacion_id => $this -> requestData('causal_anulacion_id')
	  );
	  
    $webService -> anularManifiestoMinisterio($data);	     
  
  }    
  
  protected function sendInformacionViaje(){
    
      require_once("ManifiestosModelClass.php");
	  include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	  $Model         = new ManifiestosModel();	  
	  $webService    = new WebServiceMinTransporte($this -> getConex());	 
	  $manifiesto_id = $this -> requestData('manifiesto_id');	
	  $remesas       = $Model -> selectRemesasManifiesto($manifiesto_id,$this -> getConex());		  		  
	  $valor_flete   = $this -> requestData('valor_flete');
	  			 
	  $data = array(	  
	
		manifiesto_id                        => $manifiesto_id,	
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
	  
	  $webService -> sendInformacionViaje($data);	  	 
  
  }

  protected function setCampos(){
      
    //FORMULARIO
    $this -> Campos[manifiesto_id] = array(
    name=>'manifiesto_id',
    id=>'manifiesto_id',
    type=>'hidden',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('manifiesto','servicio_transporte','dta'),
    type=>array('primary_key','column','primary_key'))
    );
	
    $this -> Campos[updateManifiesto] = array(
    name=>'updateManifiesto',
    id=>'updateManifiesto',
    type=>'hidden',
	value =>'false'
    );	
	
    $this -> Campos[fecha_registro] = array(
    name  =>'fecha_registro',
    id    =>'fecha_registro',
    type  =>'hidden',
    transaction  =>array(
    table =>array('manifiesto'),
    type=>array('column'))
    );	

    $this -> Campos[fecha_static] = array(
    name=>'fecha_static',
    id=>'fecha_static',
    type=>'hidden',
    value   => date("Y-m-d")
    );
      
    $this -> Campos[servicio_transporte_id] = array(
    name=>'servicio_transporte_id',
    id=>'servicio_transporte_id',
    type=>'hidden',
    required=>'no',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('servicio_transporte'),
    type=>array('primary_key'))
    );

    $this -> Campos[empresa_id_static] = array(
    name=>'empresa_id_static',
    id=>'empresa_id_static',
    type=>'hidden',
    value   => $this -> getEmpresaId(),
    datatype=>array(
    type=>'integer')
    ); 

    $this -> Campos[oficina_id_static] = array(
    name=>'oficina_id_static',
    id=>'oficina_id_static',
    type=>'hidden',
    value   => $this -> getOficinaId(),
    datatype=>array(
    type=>'integer')
    );

    $this -> Campos[empresa_id] = array(
    name=>'empresa_id',
    id=>'empresa_id',
    type=>'hidden',
    value   => $this -> getEmpresaId(),
    datatype=>array(
    type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[oficina_id] = array(
    name=>'oficina_id',
    id=>'oficina_id',
    type=>'hidden',
    value   => $this -> getOficinaId(),
    datatype=>array(
    type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    ); 

    $this -> Campos[manifiesto] = array(
    name=>'manifiesto',
    id=>'manifiesto',
    type=>'text',
    required=>'no',
    //size=>'7',
    readonly=>'readonly',
    datatype=>array(
    type=>'alphanum',
    length=>'20'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[tipo_manifiesto_id] = array(
    name=>'tipo_manifiesto_id',
    id=>'tipo_manifiesto_id',
    type=>'select',
    required=>'yes',
    options=>array(),
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[fecha_mc] = array(
    name=>'fecha_mc',
    id=>'fecha_mc',
    type=>'text',
    required=>'yes',
	disabled=>'true',
    value=>date("Y-m-d"),
	datatype=>array(
    type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[fecha_entrega_mcia_mc] = array(
    name=>'fecha_entrega_mcia_mc',
    id=>'fecha_entrega_mcia_mc',
    type=>'text',
    required=>'yes',
    value=>date("Y-m-d"),
	datatype=>array(
    type=>'date'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[hora_entrega] = array(
     name       => 'hora_entrega',
     id         => 'hora_entrega',
     type       => 'text',
     required   => 'yes',
     value      => '',
	 datatype   => array(
     type       => 'time'),
     transaction=> array(
     table      => array('manifiesto'),
     type       => array('column'))
    );	
	
	
    $this -> Campos[fecha_estimada_salida] = array(
     name       => 'fecha_estimada_salida',
     id         => 'fecha_estimada_salida',
     type       => 'text',
     required   => 'yes',
     value      => '',
	 datatype   => array(
     type       => 'date'),
     transaction=> array(
     table      => array('manifiesto'),
     type       => array('column'))
    );
	
    $this -> Campos[hora_estimada_salida] = array(
     name       => 'hora_estimada_salida',
     id         => 'hora_estimada_salida',
     type       => 'text',
     required   => 'yes',
     value      => '',
	 datatype   => array(
     type       => 'time'),
     transaction=> array(
     table      => array('manifiesto'),
     type       => array('column'))
    );		
	
    $this -> Campos[numero_contenedor] = array(
    name  =>'numero_contenedor',
    id    =>'numero_contenedor',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );			

    $this -> Campos[origen] = array(
    name=>'origen',
    id=>'origen',
    type=>'text',
    suggest=>array(
    name=>'ciudad',
    setId=>'origen_hidden',
	onclick=>'setDivipolaOrigen'
	)
    ); 

    $this -> Campos[origen_id] = array(
    name=>'origen_id',
    id=>'origen_hidden',
    type=>'hidden',
    required=>'yes',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[origen_divipola] = array(
    name =>'origen_divipola',
    id   =>'origen_divipola',
    type =>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	

    $this -> Campos[destino] = array(
    name=>'destino',
    id=>'destino',
    type=>'text',
    suggest=>array(
    name=>'ciudad',
    setId=>'destino_hidden',
	onclick=>'setDivipolaDestino')
    );

    $this -> Campos[destino_id] = array(
    name=>'destino_id',
    id  =>'destino_hidden',
    type=>'hidden',
    required=>'yes',
    value=>'',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[ruta_id] = array(
    name     =>'ruta_id',
    id       =>'ruta_id',
    type     =>'select',
    options  =>array(),
    datatype =>array(type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
	
    $this -> Campos[destino_divipola] = array(
    name    =>'destino_divipola',
    id      =>'destino_divipola',
    type    =>'hidden',
    value   =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
	
    $this -> Campos[modalidad] = array(
     name    =>'modalidad',
     id      =>'modalidad',
     type    =>'select',
	 required=>'yes',
     options =>array(array(value => 'N', text => 'NORMAL', selected => 'N'),array(value => 'D', text => 'DTA', selected => 'N')),
     datatype=>array(type =>'alpha'),
     transaction=>array(
     table=>array('manifiesto'),
     type=>array('column'))
    );	
	

    $this -> Campos[cargue_pagado_por] = array(
     name    =>'cargue_pagado_por',
     id      =>'cargue_pagado_por',
     type    =>'select',
     options =>array(array(value => 'R',text => 'Remitente'),array(value => 'D',text => 'Destinatario'),array(value => 'C',
	 text    => 'Conductor'),array(value => 'E', text => 'Empresa de Transporte')),
	 selected => 'E',
     datatype=>array(type =>'alpha'),
     transaction=>array(
     table=>array('manifiesto'),
     type=>array('column'))
    );

    $this -> Campos[descargue_pagado_por] = array(
    name    =>'descargue_pagado_por',
    id      =>'descargue_pagado_por',
    type    =>'select',
    options =>array(array(value => 'R',text => 'Remitente'),array(value => 'D',text => 'Destinatario'),array(value => 'C',
	text    => 'Conductor'),array(value => 'E', text => 'Empresa de Transporte')),
	selected => 'C',
    datatype=>array(type=>'alpha'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[titular_manifiesto] = array(
     name     =>'titular_manifiesto',
     id       =>'titular_manifiesto',
     type     =>'text',
	 required => 'true',
     transaction =>array(
     table   =>array('manifiesto'),
     type    =>array('column')),
     suggest =>array(
       name  =>'tenedor_disponible',
       setId =>'titular_manifiesto_hidden',
			    onclick =>'setDataTitular')
    );

    $this -> Campos[titular_manifiesto_id] = array(
    name=>'titular_manifiesto_id',
    id=>'titular_manifiesto_hidden',
	required=>'yes',	
    type=>'hidden',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[numero_identificacion_titular_manifiesto] = array(
    name=>'numero_identificacion_titular_manifiesto',
    id=>'numero_identificacion_titular_manifiesto',
    type=>'text',
    readonly   => 'true',	
	required=>'yes',	
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[direccion_titular_manifiesto] = array(
    name=>'direccion_titular_manifiesto',
    id=>'direccion_titular_manifiesto',
    type=>'text',
    readonly   => 'true',
	required=>'yes',	
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[telefono_titular_manifiesto] = array(
    name=>'telefono_titular_manifiesto',
    id=>'telefono_titular_manifiesto',
    type=>'text',
    readonly   => 'true',
	required=>'yes',	
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_titular_manifiesto] = array(
    name=>'ciudad_titular_manifiesto',
    id=>'ciudad_titular_manifiesto',
    type=>'text',
    readonly=> 'true',
	required=>'yes',	
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_titular_manifiesto_divipola] = array(
    name=>'ciudad_titular_manifiesto_divipola',
    id=>'ciudad_titular_manifiesto_divipola',
    type=>'hidden',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[observaciones] = array(
      name   =>'observaciones',
      id     =>'observaciones',
      type   =>'textarea',
	  value  =>'NINGUNA',
      transaction => array(
        table => array('manifiesto'),
        type  => array('column')
	  )
    );	
	
    $this -> Campos[stiker] = array(
      name   =>'stiker',
      id     =>'stiker',
      type   =>'text',
	  value  =>'',
      transaction => array(
        table => array('manifiesto'),
        type  => array('column')
	  )
    );		


    $this -> Campos[aseguradora_static] = array(
    name=>'aseguradora_static',
    id=>'aseguradora_static',
    type=>'hidden'
    );

    $this -> Campos[poliza_static] = array(
    name=>'poliza_static',
    id=>'poliza_static',
    type=>'hidden'
    );

    $this -> Campos[vencimiento_poliza_static] = array(
    name=>'vencimiento_poliza_static',
    id=>'vencimiento_poliza_static',
    type=>'hidden'
    );


    //vehiculo
    $this -> Campos[placa] = array(
    name=>'placa',
    id=>'placa',
    type=>'text',
    value=>'',
    size=>'7',
    suggest=>array(
    name=>'vehiculo_disponible',
    setId=>'placa_hidden',
    onclick => 'setDataVehiculo'
    ),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[marca] = array(
    name=>'marca',
    id=>'marca',
    type=>'text',
    readonly=>'true',
    value=>'',
	required=>'yes',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[linea] = array(
    name=>'linea',
    id=>'linea',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[modelo] = array(
    name=>'modelo',
    id=>'modelo',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[modelo_repotenciado] = array(
    name=>'modelo_repotenciado',
    id=>'modelo_repotenciado',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[serie] = array(
    name=>'serie',
    id=>'serie',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[color] = array(
    name=>'color',
    id=>'color',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[carroceria] = array(
    name=>'carroceria',
    id=>'carroceria',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[registro_nacional_carga] = array(
    name=>'registro_nacional_carga',
    id=>'registro_nacional_carga',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[configuracion] = array(
    name=>'configuracion',
    id=>'configuracion',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[peso_vacio] = array(
    name=>'peso_vacio',
    id=>'peso_vacio',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[numero_soat] = array(
    name=>'numero_soat',
    id=>'numero_soat',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[nombre_aseguradora] = array(
    name=>'nombre_aseguradora',
    id=>'nombre_aseguradora',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[vencimiento_soat] = array(
    name=>'vencimiento_soat',
    id=>'vencimiento_soat',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    value=>'',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );



    $this -> Campos[placa_id] = array(
    name=>'placa_id',
    id=>'placa_hidden',
    type=>'hidden',
    required=>'yes',
    datatype=>array(
    type=>'integer',
    length=>'11'),
    transaction=>array(
    table=>array('manifiesto','servicio_transporte'),
    type=>array('column','column'))
    );
		
    $this -> Campos[propio] = array(
    name=>'propio',
    id=>'propio',
    type=>'hidden',
    value=>'0',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	

    $this -> Campos[remolque] = array(
      name  => 'remolque',
      id    => 'remolque',
      type  => 'hidden',
      value => '0'
    );

    //remolque
    $this -> Campos[placa_remolque] = array(
    name=>'placa_remolque',
    id=>'placa_remolque',
    type=>'text',
    value=>'',
    size=>'7',
    suggest=>array(
    name=>'remolque_disponible',
    setId=>'placa_remolque_hidden',
	onclick=>'setDataRemolque'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[placa_remolque_id] = array(
    name=>'placa_remolque_id',
    id=>'placa_remolque_hidden',
    type=>'hidden',
    datatype=>array(
    type=>'integer',
    length=>'11'),
    transaction=>array(
    table=>array('manifiesto','servicio_transporte'),
    type=>array('column','column'))
    );
			
    $this -> Campos[tipo_identificacion_propietario_remolque_codigo] = array(
    name=>'tipo_identificacion_propietario_remolque_codigo',
    id=>'tipo_identificacion_propietario_remolque_codigo',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
	
    $this -> Campos[numero_identificacion_propietario_remolque] = array(
    name=>'numero_identificacion_propietario_remolque',
    id=>'numero_identificacion_propietario_remolque',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );			
	
    $this -> Campos[propietario_remolque] = array(
    name=>'propietario_remolque',
    id=>'propietario_remolque',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
    $this -> Campos[propietario] = array(
    name=>'propietario',
    id=>'propietario',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type =>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[tipo_identificacion_propietario_codigo] = array(
    name=>'tipo_identificacion_propietario_codigo',
    id=>'tipo_identificacion_propietario_codigo',
    type=>'hidden',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	

    $this -> Campos[numero_identificacion_propietario] = array(
    name=>'numero_identificacion_propietario',
    id=>'numero_identificacion_propietario',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[direccion_propietario] = array(
    name=>'direccion_propietario',
    id=>'direccion_propietario',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[telefono_propietario] = array(
    name=>'telefono_propietario',
    id=>'telefono_propietario',
    type=>'text',
    readonly=>'true',
	required=>'yes',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_propietario] = array(
    name=>'ciudad_propietario',
    id=>'ciudad_propietario',
    readonly=>'true',
    type=>'text',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[tenedor] = array(
    name=>'tenedor',
    id=>'tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[tenedor_id] = array(
    name=>'tenedor_id',
    id=>'tenedor_id',
    type=>'hidden',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
    $this -> Campos[tipo_identificacion_tenedor_codigo] = array(
    name=>'tipo_identificacion_tenedor_codigo',
    id=>'tipo_identificacion_tenedor_codigo',
    type=>'hidden',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		

    $this -> Campos[numero_identificacion_tenedor] = array(
    name=>'numero_identificacion_tenedor',
    id=>'numero_identificacion_tenedor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[direccion_tenedor] = array(
    name=>'direccion_tenedor',
    id=>'direccion_tenedor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[telefono_tenedor] = array(
    name=>'telefono_tenedor',
    id=>'telefono_tenedor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_tenedor] = array(
    name=>'ciudad_tenedor',
    id=>'ciudad_tenedor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );




    //conductor
    $this -> Campos[conductor_id] = array(
    name=>'conductor_id',
    id=>'conductor_hidden',
    type=>'hidden',
    value=>'',
    required=>'yes',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('servicio_transporte','manifiesto'),
    type=>array('column','column'))
    );

    $this -> Campos[numero_identificacion] = array(
    name=>'numero_identificacion',
    id=>'numero_identificacion',
    readonly=>'true',
	required=>'yes',	
    type=>'text',
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[tipo_identificacion_conductor_codigo] = array(
    name=>'tipo_identificacion_conductor_codigo',
    id=>'tipo_identificacion_conductor_codigo',
    type=>'hidden',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );			

    $this -> Campos[nombre] = array(
    name=>'nombre',
    id=>'nombre',
    type=>'text',
	required=>'yes',	
    suggest=>array(
    name=>'conductor_disponible',
    setId=>'conductor_hidden',
    onclick=>'separaNombre'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[direccion_conductor] = array(
    name=>'direccion_conductor',
    id=>'direccion_conductor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[categoria_licencia_conductor] = array(
    name=>'categoria_licencia_conductor',
    id=>'categoria_licencia_conductor',
    type=>'text',
	size=>'1',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[numero_licencia_cond] = array(
    name=>'numero_licencia_cond',
    id=>'numero_licencia_cond',
    type=>'text',
    readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		

    $this -> Campos[telefono_conductor] = array(
    name=>'telefono_conductor',
    id=>'telefono_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_conductor] = array(
    name=>'ciudad_conductor',
    id=>'ciudad_conductor',
    type=>'text',
    readonly=>'true',
	required=>'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );
	
    $this -> Campos[valor_flete] = array(
    name=>'valor_flete',
    id=>'valor_flete',
    type=>'text',
	value => 0,
    datatype=>array(type=>'numeric', length => '18',presicion => '2'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
	
    $this -> Campos[valor_neto_pagar] = array(
    name=>'valor_neto_pagar',
    id=>'valor_neto_pagar',
    type=>'text',
	value => 0,	
    readonly=>'true',
    datatype=>array(type=>'numeric', length => '18',presicion => '2'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
	
    $this -> Campos[valor] = array(
    name=>'valor',
    id=>'valor',
    type=>'text',
	value => 0,	
    readonly=>'true',
    datatype=>array(type=>'numeric', length => '18',presicion => '2')
    );		
	
    $this -> Campos[saldo_por_pagar] = array(
    name=>'saldo_por_pagar',
    id=>'saldo_por_pagar',
    type=>'text',
    readonly=>'true',
	value => 0,	
    datatype=>array(type=>'numeric', length => '18',presicion => '2'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
    $this -> Campos[fecha_pago_saldo] = array(
    name=>'fecha_pago_saldo',
    id=>'fecha_pago_saldo',
    type=>'text',
	value => date("Y-m-d"),
    datatype=>array(type=>'date'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
    $this -> Campos[oficina_pago_saldo_id] = array(
    name=>'oficina_pago_saldo_id',
    id=>'oficina_pago_saldo_id',
    type=>'select',
	options=>array(),
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
    $this -> Campos[lugar_pago_saldo] = array(
    name  =>'lugar_pago_saldo',
    id    =>'lugar_pago_saldo',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );			
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );			
	
    $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
	
    $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );	
		
    $this -> Campos[estado] = array(
    name    =>'estado',
    id      =>'estado',
    type    =>'select',
	disabled => 'yes',
	options =>array(array(value => 'P', text => 'PENDIENTE'), array(value => 'M', text => 'MANIFESTADO'), 
	array(value => 'E', text => 'ENTREGAGO'),array(value=>'L',text=>'LIQUIDADO'),array(value=>'A',text=>'ANULADO')),
	selected=>'P',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
    );		
	
	/*************************************************
	                  Campos DTA
	*************************************************/
	
    $this -> Campos[dta_id] = array(
    name=>'dta_id',
    id=>'dta_id',
    type=>'hidden',
    datatype=>array(type=>'autoincrement'),
    transaction=>array(
    table=>array('dta'),
    type=>array('primary_key'))
    );
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		size     =>'35',
		suggest=>array(
			name	=>'cliente_disponible',
			setId	=>'cliente_hidden'
			),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id	=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',	
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);
		
	
    $this -> Campos[numero_formulario] = array(
    name  =>'numero_formulario',
    id    =>'numero_formulario',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
    $this -> Campos[imagen_formulario] = array(
    name  =>'imagen_formulario',
    id    =>'imagen_formulario',
    type  =>'file',
	path	=>'../../../imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_imagen_formulario'),
		settings => array(
		  width  => '400',
		  height => '420'
		)
    );	
	
    $this -> Campos[fecha_consignacion] = array(
    name  =>'fecha_consignacion',
    id    =>'fecha_consignacion',
    type  =>'text',
    datatype=>array(type=>'date'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
	
    $this -> Campos[fecha_entrega_dta] = array(
    name  =>'fecha_entrega_dta',
    id    =>'fecha_entrega_dta',
    type  =>'text',
    datatype=>array(type=>'date'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
    $this -> Campos[numero_contenedor_dta] = array(
    name  =>'numero_contenedor_dta',
    id    =>'numero_contenedor_dta',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );
	
    $this -> Campos[naviera] = array(
    name  =>'naviera',
    id    =>'naviera',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );
	
	$this -> Campos[tara] = array(
    name  =>'tara',
    id    =>'tara',
    type  =>'text',
	size  => '5',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[tipo] = array(
    name  =>'tipo',
    id    =>'tipo',
    type  =>'select',
	options=>array(array(value => 20,text => 20),array(value => 40,text => 40)),
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );				
	
	$this -> Campos[foto_posterior] = array(
    name  =>'foto_posterior',
    id    =>'foto_posterior',
    type  =>'file',
	path	=>'../../../imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_foto_posterior'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );	
	
	$this -> Campos[foto_anterior] = array(
    name  =>'foto_anterior',
    id    =>'foto_anterior',
    type  =>'file',
	path	=>'../../../imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_foto_anterior'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );				
	
	$this -> Campos[foto_lateral_derecha] = array(
    name  =>'foto_lateral_derecha',
    id    =>'foto_lateral_derecha',
    type  =>'file',
	path	=>'../../../imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_foto_lateral_derecha'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );	
	
	$this -> Campos[foto_lateral_izquierda] = array(
    name  =>'foto_lateral_izquierda',
    id    =>'foto_lateral_izquierda',
    type  =>'file',
	path	=>'../../../imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_foto_lateral_izquierda'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );		
	
	$this -> Campos[numero_precinto] = array(
    name  =>'numero_precinto',
    id    =>'numero_precinto',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('manifiesto','dta'),
    type=>array('column','column'))
    );		
	
	$this -> Campos[foto_precinto_normal] = array(
    name  =>'foto_precinto_normal',
    id    =>'foto_precinto_normal',
    type  =>'file',
	path	=>'../../../imagenes/transporte/manifiesto/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'manifiesto',
			text	=>'_foto_precinto'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );	
	
	$this -> Campos[foto_amarres] = array(
    name  =>'foto_amarres',
    id    =>'foto_amarres',
    type  =>'file',
	path	=>'../../../imagenes/transporte/manifiesto/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'manifiesto',
			text	=>'_foto_amarres'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );			
	
	
	$this -> Campos[foto_precinto] = array(
    name  =>'foto_precinto',
    id    =>'foto_precinto',
    type  =>'file',
	path	=>'../../../imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_foto_precinto'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );		
	
	
	$this -> Campos[numero_identificacion_cliente] = array(
    name  =>'numero_identificacion_cliente',
    id    =>'numero_identificacion_cliente',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );			
	
	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id	    =>'codigo',
		type	=>'text',
		size    =>4,
		datatype=>array(type => 'text'),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column')),
		suggest=>array(
			name	=>'producto',
			setId	=>'producto_hidden',
			onclick =>'setDataProducto'),
	);	
	
	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id	    =>'producto_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);		

	$this -> Campos[producto] = array(
		name	=>'producto',
		id	    =>'producto',
		type	=>'text',
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);	
	
	$this -> Campos[peso] = array(
    name  =>'peso',
    id    =>'peso',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[responsable_dian] = array(
    name  =>'responsable_dian',
    id    =>'responsable_dian',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
	
	$this -> Campos[responsable_empresa] = array(
    name  =>'responsable_empresa',
    id    =>'responsable_empresa',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );				
	
	$this -> Campos[observaciones_dta] = array(
    name  =>'observaciones_dta',
    id    =>'observaciones_dta',
    type  =>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[estado_dta] = array(
    name  =>'estado_dta',
    id    =>'estado_dta',
    type  =>'hidden',
	value =>'A',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	

	$this -> Campos[id_mobile] = array(
    name  =>'id_mobile',
    id    =>'id_mobile',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'hidden'),
    transaction=>array(
    table=>array('manifiesto'),
    type=>array('column'))
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
	
    //BOTONES
    $this -> Campos[guardar] = array(
    name=>'guardar',
    id=>'guardar',
    type=>'button',
    value=>'Continuar'
    );
    
    $this -> Campos[actualizar] = array(
    name=>'actualizar',
    id=>'actualizar',
    type=>'button',
    value=>'Actualizar',
    disabled=>'disabled'
    );
	
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation(this.form)'
	);
	
    $this -> Campos[borrar] = array(
    name=>'borrar',
    id=>'borrar',
    type=>'button',
    value=>'Borrar',
    disabled=>'disabled',
	property=>array(
    name=>'delete_ajax',
    onsuccess=>'ManifiestosOnDelete')
    );

      $this -> Campos[limpiar] = array(
    name=>'limpiar',
    id=>'limpiar',
    type=>'reset',
    value=>'Limpiar',
    onclick => 'ManifiestosOnReset(this.form)'
    );

    $this -> Campos[imprimir] = array(
     name   =>'imprimir',
     id   =>'imprimir',
     type   =>'print',
	 disabled=>'disabled',
     value   =>'Imprimir',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Manifiesto Carga',
      width       => '900',
      height      => '600'
    )

    );


    $this -> Campos[manifestar] = array(
    name=>'manifestar',
    id=>'manifestar',
    type=>'button',
    value=>'Manifestar'
    );

    $this -> Campos[importRemesas] = array(
    name=>'importRemesas',
    id=>'importRemesas',
	disabled=>'yes',
    type=>'button',
    value=>'Seleccionar Remesas'
    );

    //BUSQUEDA
      $this -> Campos[busqueda] = array(
    name=>'busqueda',
    id=>'busqueda',
    type=>'text',
    size=>'85',
    value=>'',
    suggest=>array(
    name=>'busca_manifiesto',
    setId=>'manifiesto_id',
    onclick=>'setDataFormWithResponse')
    );




  $this -> SetVarsValidate($this -> Campos);
  }


}

new Manifiestos();

?>