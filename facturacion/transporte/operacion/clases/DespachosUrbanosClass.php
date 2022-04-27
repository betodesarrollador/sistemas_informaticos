<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DespachosUrbanos extends Controler{

  public function __construct(){      
    parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("DespachosUrbanosLayoutClass.php");
    require_once("DespachosUrbanosModelClass.php");

    $Layout   = new DespachosUrbanosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DespachosUrbanosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);

//LISTA MENU

    $Layout -> setImpuestos($Model -> getImpuestos($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));	
    $Layout -> setDescuentos($Model -> GetDescuentos($this -> getOficinaId(),$this -> getConex()));
    $Layout -> setLugaresPagoSaldo($Model -> getLugaresSaldoPago($this -> getOficinaId(),$this -> getEmpresaId(),$this -> getConex()));	
    $Layout -> setFormasPago($Model -> getFormasPago($this -> getConex()));	
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
    $Layout -> setImpuestosica($Model -> getImpuestosica($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));

	//// GRID ////
    $Attributes = array(
     id=>'DespachosUrbanos',
     title=>'Solicitud Servicio de Transporte',
     sortname=>'fecha_du',
     sortorder=>'desc',
     width=>'auto',
     height=>'250'
   );
    
    $Cols = array(
     array(name=>'despacho',        index=>'despacho',        sorttype=>'text', width=>'100', align=>'center'),
     array(name=>'propio',          index=>'propio',          sorttype=>'text', width=>'80',  align=>'center'),  
     array(name=>'estado',          index=>'estado',          sorttype=>'text', width=>'100', align=>'center'),
     array(name=>'fecha_du',        index=>'fecha_du',        sorttype=>'text', width=>'120', align=>'center'),
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
    

    $Titles = array('DESPACHO','PROPIO','ESTADO','FECHA','ORIGEN','DESTINO','CONDUCTOR','PLACA','REMOLQUE',
      'FLETE','No ANTICIPOS','ANTICIPOS','IMPUESTOS');

    $Layout -> SetGridDespachosUrbanos($Attributes,$Titles,$Cols,$Model -> getQueryDespachosUrbanosGrid($this -> getOficinaId()));

    $Layout -> RenderMain();
    
  }


  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"despachos_urbanos_id",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }
  
  protected function asignoRemesasManifiesto(){
    
    require_once("DespachosUrbanosModelClass.php");
    
    $Model         = new DespachosUrbanosModel();  
    $despachos_urbanos_id = $_REQUEST['despachos_urbanos_id'];
    
    if($Model -> manifiestoTieneRemesas($despachos_urbanos_id,$this -> getConex())){
     exit('true');
   }else{
    exit('false');
  }
  
}

protected function setDivipolaOrigen(){
  
  require_once("DespachosUrbanosModelClass.php");
  
  $Model        = new DespachosUrbanosModel();
  $ubicacion_id = $_REQUEST['ubicacion_id'];
  
  $divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());
  
  exit("$divipola");
  
}

protected function setDivipolaDestino(){
  
  require_once("DespachosUrbanosModelClass.php");
  
  $Model        = new DespachosUrbanosModel();
  $ubicacion_id = $_REQUEST['ubicacion_id'];
  
  $divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());
  
  exit("$divipola");
  
}  

   protected function getContabilizar(){
	
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();
	$despachos_urbanos_id 	= $_REQUEST['despachos_urbanos_id'];
	$fecha_du 		= $_REQUEST['fecha_du'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
    $mesContable     	= $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_du,$this -> getConex());
    $periodoContable 	= $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	  $result_antic 		= $Model -> ValidaAnticipo($despachos_urbanos_id,$this -> getConex()); 

	if(!$result_antic){
		if($mesContable && $periodoContable ){
	
			$return=$Model -> getContabilizarReg($despachos_urbanos_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
			if($return==true){
				exit("true");
			}else{
				exit("Error : ".$Model -> GetError());
			}	
			
		}else{
				 
			if(!$mesContable && !$periodoContable){
				exit("No se permite Contabilizar en el periodo y mes seleccionado.");
			}elseif(!$mesContable){
				exit("No se permite Contabilizar en el mes seleccionado.");				 
			}else if(!$periodoContable){
				exit("No se permite Contabilizar en el periodo seleccionado.");				   
			}
		}
	}else{
		echo("Por favor contablice el anticipo en el formulario <a href='javascript:frameAnticipo()'> GENERAR ANTICIPOS</a>");
	}
	  
}

protected function onclickSave(){
  
  require_once("DespachosUrbanosModelClass.php");
  
  $Model                         = new DespachosUrbanosModel();
  $usuario_id                    = $this -> getUsuarioId();
  $empresa_id                    = $this -> getEmpresaId();
  $oficina_id                    = $this -> getOficinaId();
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
  
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();
  
  $Model -> Delete($this -> Campos,$this -> getConex());
  
  if($Model -> GetNumError() > 0){
    exit('Ocurrio una inconsistencia');
  }else{
    exit('Se elimino correctamente la Solicitud');  
  }
  
}


//BUSQUEDA
protected function onclickFind(){
  
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();

  $despachos_urbanos_id = $_REQUEST['despachos_urbanos_id'];

  $Data =  $Model -> selectDespacho($despachos_urbanos_id,$this -> getConex());
  
  $this -> getArrayJSON($Data);

}

protected function validaPreliquido(){

  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();

  $preliquido = $Model -> selectPreliquido($despachos_urbanos_id,$this -> getConex());

  if($preliquido){
    exit('true');
  }else{
    exit('false');
  }

}

protected function onclickPrint(){
  
  require_once("Imp_DespachoClass.php");

  $print = new Imp_Despacho($this -> getConex());

  $print -> printOut();
  
}

protected function setDataVehiculo(){
  
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();
  
  $placa_id = $_REQUEST['placa_id'];
  $data     = $Model -> selectVehiculo($placa_id,$this -> getConex());

  $this -> getArrayJSON($data);
  
}

protected function setDataIca(){
  
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();
  
  $impuesto_id = $_REQUEST['impuesto_id'];
  $data     = $Model -> selectIca($impuesto_id,$this -> getConex());

  if(is_array($data)){
   $this -> getArrayJSON($data);
 }else{
   $this -> getArrayJSON(array(array(error=>$data)));
 }
 
}  

protected function setDataIcaoficina(){
  
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();
  
  $data     = $Model -> selectIcaOficina( $this -> getOficinaId(),$this -> getConex());

  if(is_array($data)){
   $this -> getArrayJSON($data);
 }else{
   $this -> getArrayJSON(array(array(error=>$data)));
 }
 
}

protected function setDataRemolque(){
  
  require_once("ManifiestosModelClass.php");
  $Model = new ManifiestosModel();
  
  $placa_remolque_id = $_REQUEST['placa_remolque_id'];
  $data     = $Model -> selectRemolque($placa_remolque_id,$this -> getConex());

  $this -> getArrayJSON($data);
  
}   

protected function setDataConductor(){
  
  require_once("DespachosUrbanosModelClass.php");
  
  $Model        = new DespachosUrbanosModel();  
  $conductor_id = $_REQUEST['conductor_id'];
  $data         = $Model -> selectConductor($conductor_id,$this -> getConex()); 

  $this -> getArrayJSON($data); 
  
}

protected function setDataTitular(){
  
  require_once("DespachosUrbanosModelClass.php");
  
  $Model       = new DespachosUrbanosModel();  
  $tenedor_id  = $_REQUEST['tenedor_id'];
  $data        = $Model -> selectDataTitular($tenedor_id,$this -> getConex()); 

  $this -> getArrayJSON($data); 
  
  
}

protected function setManifiesto(){
 
  require_once("DespachosUrbanosModelClass.php");
  $Model = new DespachosUrbanosModel();
  
  $Model                         = new DespachosUrbanosModel();
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
  
 require_once("DespachosUrbanosModelClass.php");
 $Model = new DespachosUrbanosModel();  
 
 $arrayResponse    = array();
 $tenedor_id       = $this -> requestData('tenedor_id');	 
 $impuestos        = $_REQUEST['impuestos']; 
 $impuestos1        = $_REQUEST['impuestos1'];
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
   
   $arrayResponse['impuestos'][$i]['impuesto_id'] = $impuesto_id;
   $arrayResponse['impuestos'][$i]['valor']       = number_format($valor,0,',','.');	
   $arrayResponse['impuestos'][$i]['base']        = $base;		   
   
   $total_impuestos += $valor;
   
 }
 
 for($i = 0; $i < count($impuestos1); $i++){	 

   $impuesto_id  = $impuestos1[$i]['impuesto_id'];
   $dataImpuesto = $Model -> calcularImpuesto($tenedor_id,$valor_flete,$impuesto_id,$arrayResponse['impuestos'],$this -> getConex());
   
   $valor        = round($dataImpuesto['valor']);
   $base         = $dataImpuesto['base'];
   
   $arrayResponse['impuestos1'][$i]['impuesto_id'] = $impuesto_id;
   $arrayResponse['impuestos1'][$i]['valor']       = number_format($valor,0,',','.');	
   $arrayResponse['impuestos1'][$i]['base']        = $base;		   		   	   
   
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
  
 require_once("DespachosUrbanosModelClass.php");
 $Model = new DespachosUrbanosModel();  
 
 $numero_formulario = $_REQUEST['numero_formulario'];
 
 if($Model -> existeFormulario($numero_formulario,$this -> getConex())){
  exit('true');
}else{
  exit('false');	 
}

}

protected function onclickCancellation(){
  
 require_once("DespachosUrbanosModelClass.php");
 
 $Model                 = new DespachosUrbanosModel(); 
 $despachos_urbanos_id  = $this -> requestDataForQuery('despachos_urbanos_id','integer');
 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
 $usuario_anulo_id      = $this -> getUsuarioId();
 
 $Model -> cancellation($despachos_urbanos_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
 
 if(strlen($Model -> GetError()) > 0){
   exit('false');
 }else{
   exit('true');
 }
 
}  

protected function setCampos(){
  
    //FORMULARIO
  $this -> Campos[despachos_urbanos_id] = array(
    name=>'despachos_urbanos_id',
    id=>'despachos_urbanos_id',
    type=>'hidden',
    datatype=>array(
      type=>'integer',
      length=>'20'),
    transaction=>array(
      table=>array('despachos_urbanos','servicio_transporte','dta'),
      type=>array('primary_key','column','primary_key'))
  );
  
  $this -> Campos[updateManifiesto] = array(
    name=>'updateManifiesto',
    id=>'updateManifiesto',
    type=>'hidden',
    value =>'false'
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
    datatype=>array(
      type=>'numeric',
      length=>'20'),
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
      table=>array('despachos_urbanos'),
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
      table=>array('despachos_urbanos'),
      type=>array('column'))
  ); 

  $this -> Campos[despacho] = array(
    name=>'despacho',
    id=>'despacho',
    type=>'text',
    required=>'no',
    //size=>'7',
    readonly=>'readonly',
    datatype=>array(
      type=>'alphanum',
      length=>'20'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[fecha_du] = array(
    name=>'fecha_du',
    id=>'fecha_du',
    type=>'text',
    required=>'yes',
	//disabled=>'true',
    value=>date("Y-m-d"),
    datatype=>array(
      type=>'date'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[fecha_entrega_mcia_du] = array(
    name=>'fecha_entrega_mcia_du',
    id=>'fecha_entrega_mcia_du',
    type=>'text',
    required=>'yes',
    value=>date("Y-m-d"),
    datatype=>array(
      type=>'date'),
    transaction=>array(
      table=>array('despachos_urbanos'),
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
     table      => array('despachos_urbanos'),
     type       => array('column'))
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
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[origen_divipola] = array(
    name =>'origen_divipola',
    id   =>'origen_divipola',
    type =>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
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
    id      =>'destino_hidden',
    type=>'hidden',
    required=>'yes',
    value=>'',
    datatype=>array(
      type=>'integer',
      length=>'20'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[destino_divipola] = array(
    name    =>'destino_divipola',
    id      =>'destino_divipola',
    type    =>'hidden',
    value   =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
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
     table=>array('despachos_urbanos'),
     type=>array('column'))
 );	
  

  $this -> Campos[cargue_pagado_por] = array(
   name    =>'cargue_pagado_por',
   id      =>'cargue_pagado_por',
   type    =>'select',
   options =>array(array(value => 'RE',text => 'Remitente',selected => 'ET'),array(value => 'DE',text => 'Destinatario',selected => 'ET'),array(value => 'CO',
    text    => 'Conductor',selected => 'ET'),array(value => 'CL',text => 'Cliente',selected => 'ET'),array(value => 'ET', text => 'Transportadora',selected => 'ET')),
   datatype=>array(type =>'alpha'),
   transaction=>array(
     table=>array('despachos_urbanos'),
     type=>array('column'))
 );

  $this -> Campos[descargue_pagado_por] = array(
    name    =>'descargue_pagado_por',
    id      =>'descargue_pagado_por',
    type    =>'select',
    options=>array(array(value => 'RE',text => 'Remitente',selected => 'CO'),array(value => 'DE',text => 'Destinatario',selected => 'CO'),
     array(value => 'CO',text => 'Conductor',selected => 'CO'),array(value => 'CL',text => 'Cliente',selected => 'CO'),array(value => 'ET', text => 'Transportadora',selected => 
       'CO')),
    datatype=>array(type=>'alpha'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[titular_despacho] = array(
   name     =>'titular_despacho',
   id       =>'titular_despacho',
   type     =>'text',
   required => 'true',
   transaction =>array(
     table   =>array('despachos_urbanos'),
     type    =>array('column')),
   suggest =>array(
     name  =>'tenedor_disponible',
     setId =>'titular_despacho_hidden',
     onclick =>'setDataTitular')
 );

  $this -> Campos[titular_despacho_id] = array(
    name=>'titular_despacho_id',
    id=>'titular_despacho_hidden',
    required=>'yes',	
    type=>'hidden',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[numero_identificacion_titular_despacho] = array(
    name=>'numero_identificacion_titular_despacho',
    id=>'numero_identificacion_titular_despacho',
    type=>'text',
    readonly   => 'true',	
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[direccion_titular_despacho] = array(
    name=>'direccion_titular_despacho',
    id=>'direccion_titular_despacho',

    type=>'text',
    readonly   => 'true',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[telefono_titular_despacho] = array(
    name=>'telefono_titular_despacho',
    id=>'telefono_titular_despacho',
    type=>'text',
    readonly   => 'true',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[ciudad_titular_despacho] = array(
    name=>'ciudad_titular_despacho',
    id=>'ciudad_titular_despacho',
    type=>'text',
    readonly=> 'true',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[ciudad_titular_despacho_divipola] = array(
    name=>'ciudad_titular_despacho_divipola',
    id=>'ciudad_titular_despacho_divipola',
    type=>'hidden',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[observaciones] = array(
    name   =>'observaciones',
    id     =>'observaciones',
    type   =>'textarea',
    value  =>'NINGUNA',
    transaction => array(
      table => array('despachos_urbanos'),
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
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[marca] = array(
    name=>'marca',
    id=>'marca',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[linea] = array(
    name=>'linea',
    id=>'linea',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[modelo] = array(
    name=>'modelo',
    id=>'modelo',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[modelo_repotenciado] = array(
    name=>'modelo_repotenciado',
    id=>'modelo_repotenciado',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[serie] = array(
    name=>'serie',
    id=>'serie',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[color] = array(
    name=>'color',
    id=>'color',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[carroceria] = array(
    name=>'carroceria',
    id=>'carroceria',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[registro_nacional_carga] = array(
    name=>'registro_nacional_carga',
    id=>'registro_nacional_carga',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[configuracion] = array(
    name=>'configuracion',
    id=>'configuracion',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[peso_vacio] = array(
    name=>'peso_vacio',
    id=>'peso_vacio',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[numero_soat] = array(
    name=>'numero_soat',
    id=>'numero_soat',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[nombre_aseguradora] = array(
    name=>'nombre_aseguradora',
    id=>'nombre_aseguradora',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[vencimiento_soat] = array(
    name=>'vencimiento_soat',
    id=>'vencimiento_soat',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
      table=>array('despachos_urbanos'),
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
      table=>array('despachos_urbanos','servicio_transporte'),
      type=>array('column','column'))
  );
  
  $this -> Campos[propio] = array(
    name=>'propio',
    id=>'propio',
    type=>'hidden',
    value=>'0',
    transaction=>array(
      table=>array('despachos_urbanos'),
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
      table=>array('despachos_urbanos'),
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
      table=>array('despachos_urbanos','servicio_transporte'),
      type=>array('column','column'))
  );

  $this -> Campos[tipo_identificacion_propietario_remolque_codigo] = array(
    name=>'tipo_identificacion_propietario_remolque_codigo',
    id=>'tipo_identificacion_propietario_remolque_codigo',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );	
  
  $this -> Campos[numero_identificacion_propietario_remolque] = array(
    name=>'numero_identificacion_propietario_remolque',
    id=>'numero_identificacion_propietario_remolque',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );			
  
  $this -> Campos[propietario_remolque] = array(
    name=>'propietario_remolque',
    id=>'propietario_remolque',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		


  $this -> Campos[propietario] = array(
    name=>'propietario',
    id=>'propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type =>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[tipo_identificacion_propietario_codigo] = array(
    name=>'tipo_identificacion_propietario_codigo',
    id=>'tipo_identificacion_propietario_codigo',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );	

  $this -> Campos[numero_identificacion_propietario] = array(
    name=>'numero_identificacion_propietario',
    id=>'numero_identificacion_propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[direccion_propietario] = array(
    name=>'direccion_propietario',
    id=>'direccion_propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[telefono_propietario] = array(
    name=>'telefono_propietario',
    id=>'telefono_propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[ciudad_propietario] = array(
    name=>'ciudad_propietario',
    id=>'ciudad_propietario',
    readonly=>'true',
    type=>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[tenedor] = array(
    name=>'tenedor',
    id=>'tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[tenedor_id] = array(
    name=>'tenedor_id',
    id=>'tenedor_id',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		
  
  $this -> Campos[tipo_identificacion_tenedor_codigo] = array(
    name=>'tipo_identificacion_tenedor_codigo',
    id=>'tipo_identificacion_tenedor_codigo',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		

  $this -> Campos[numero_identificacion_tenedor] = array(
    name=>'numero_identificacion_tenedor',
    id=>'numero_identificacion_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[direccion_tenedor] = array(
    name=>'direccion_tenedor',
    id=>'direccion_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[telefono_tenedor] = array(
    name=>'telefono_tenedor',
    id=>'telefono_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[ciudad_tenedor] = array(
    name=>'ciudad_tenedor',
    id=>'ciudad_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );




    //conductor
  $this -> Campos[conductor_id] = array(
    name=>'conductor_id',
    id=>'conductor_hidden',
    type=>'hidden',
    value=>'',
    required=>'yes',
    datatype=>array(
      type=>'numeric',
      length=>'20'),
    transaction=>array(
      table=>array('servicio_transporte','despachos_urbanos'),
      type=>array('column','column'))
  );

  $this -> Campos[numero_identificacion] = array(
    name=>'numero_identificacion',
    id=>'numero_identificacion',
    readonly=>'true',
    type=>'text',
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[nombre] = array(
    name=>'nombre',
    id=>'nombre',
    type=>'text',
    suggest=>array(
      name=>'conductor_disponible',
      setId=>'conductor_hidden',
      onclick=>'separaNombre'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[direccion_conductor] = array(
    name=>'direccion_conductor',
    id=>'direccion_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[categoria_licencia_conductor] = array(
    name=>'categoria_licencia_conductor',
    id=>'categoria_licencia_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[numero_licencia_cond] = array(
    name=>'numero_licencia_cond',
    id=>'numero_licencia_cond',
    type=>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );	
  
  

  $this -> Campos[telefono_conductor] = array(
    name=>'telefono_conductor',
    id=>'telefono_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );

  $this -> Campos[ciudad_conductor] = array(
    name=>'ciudad_conductor',
    id=>'ciudad_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );
  
  $this -> Campos[valor_flete] = array(
    name=>'valor_flete',
    id=>'valor_flete',
    type=>'text',
    value => 0,
    datatype=>array(type=>'numeric', length => '18',presicion => '2'),
    transaction=>array(
      table=>array('despachos_urbanos'),
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
      table=>array('despachos_urbanos'),
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
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		
  
  $this -> Campos[fecha_pago_saldo] = array(
    name=>'fecha_pago_saldo',
    id=>'fecha_pago_saldo',
    type=>'text',
    value => date("Y-m-d"),
    datatype=>array(type=>'date'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		
  
  $this -> Campos[oficina_pago_saldo_id] = array(
    name=>'oficina_pago_saldo_id',
    id=>'oficina_pago_saldo_id',
    type=>'select',
    options=>array(),
    datatype=>array(type=>'integer'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		
  
  $this -> Campos[lugar_pago_saldo] = array(
    name  =>'lugar_pago_saldo',
    id    =>'lugar_pago_saldo',
    type  =>'hidden',
    value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );		
  
  $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
    value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );			
  
  $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
    value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );			
  
  $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
    value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );	
  
  $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
    value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
      type=>array('column'))
  );	
  
  $this -> Campos[estado] = array(
    name    =>'estado',
    id      =>'estado',
    type    =>'select',
    disabled => 'yes',
    options =>array(array(value => 'P', text => 'PENDIENTE', selected => 'P'), array(value => 'M', text => 'MANIFESTADO' , selected => 'P'), array(value => 'E', text => 'ENTREGAGO', selected => 'P'),array(value=>'A',text=>'ANULADO',selected=>'P'),array(value=>'L',text=>'LIQUIDADO',selected=>'P')),
    datatype=>array(type=>'text'),
    transaction=>array(
      table=>array('despachos_urbanos'),
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
	//required=>'yes',
                      datatype=>array(type=>'text'),
                      transaction=>array(
                        table=>array('despachos_urbanos','dta'),
                        type=>array('column','column'))
                    );		
                    
                    $this -> Campos[foto_precinto_normal] = array(
                      name  =>'foto_precinto_normal',
                      id    =>'foto_precinto_normal',
                      type  =>'file',
                      path	=>'../../../imagenes/transporte/despacho/',	
                      datatype=>array(type=>'file'),
                      transaction=>array(
                        table=>array('despachos_urbanos'),
                        type=>array('column')),
                      namefile=>array(
                       field	=>'yes',
                       namefield=>'despacho',
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
                      path	=>'../../../imagenes/transporte/despacho/',	
                      datatype=>array(type=>'file'),
                      transaction=>array(
                        table=>array('despachos_urbanos'),
                        type=>array('column')),
                      namefile=>array(
                       field	=>'yes',
                       namefield=>'despacho',
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
                        table=>array('despachos_urbanos'),
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
                        onsuccess=>'DespachosUrbanosOnDelete')
                    );

                    $this -> Campos[limpiar] = array(
                      name=>'limpiar',
                      id=>'limpiar',
                      type=>'reset',
                      value=>'Limpiar',
                      onclick => 'DespachosUrbanosOnReset(this.form)'
                    );

                    //boton causar inicio
	
                    $this -> Campos[causar] = array(
                      name=>'causar',
                      id=>'causar',
                      type=>'button',
                      value=>'Causar',
                      onclick => 'Contabilizar()'
                    );
	
	                  //boton causar fin

                    $this -> Campos[imprimir] = array(
                      name   =>'imprimir',
                      id   =>'imprimir',
                      type   =>'print',
                      disabled=>'disabled',
                      value   =>'Imprimir',
                      displayoptions => array(
                        form        => 0,
                        beforeprint => 'beforePrint',
                        title       => 'Impresion despachos_urbanos Carga',
                        width       => '900',
                        height      => '600'
                      )

                    );


                    $this -> Campos[manifestar] = array(
                      name=>'manifestar',
                      id=>'manifestar',
                      type=>'button',
                      value=>'Despachar'
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
                        name=>'busca_despachos_urbanos',
                        setId=>'despachos_urbanos_id',
                        onclick=>'setDataFormWithResponse')
                    );

                    $this -> SetVarsValidate($this -> Campos);
                  }


                }

                $DespachosUrbanos = new DespachosUrbanos();

                ?>