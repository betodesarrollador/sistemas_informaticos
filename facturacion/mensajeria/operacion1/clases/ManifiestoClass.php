<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Manifiesto extends Controler{

  public function __construct(){  
	$this -> setCampos();
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("ManifiestoLayoutClass.php"); 
	require_once("ManifiestoModelClass.php");
	
    $Layout   = new ManifiestoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ManifiestoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU   	
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
    $Layout ->  setCiudad   ($Model -> GetCiudad($this -> getOficinaId(),$this -> getConex()));			
	
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Reexpedidos',
	  title		=>'Listado de Manifiestos Mensajeria',
	  sortname	=>'reexpedido',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(

	  array(name=>'reexpedido',		index=>'reexpedido',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'fecha_rxp',		index=>'fecha_rxp',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'proveedor',		index=>'proveedor',		sorttype=>'text',	width=>'180',	align=>'left'),
	  array(name=>'origen',			index=>'origen',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',		index=>'destino',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',			index=>'estado',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'obser_rxp',		index=>'obser_rxp',		sorttype=>'text',	width=>'100',	align=>'center')  
	);
    $Titles = array('MANIFIESTO','FECHA','PROVEEDOR','ORIGEN','DESTINO','ESTADO','OBSERVACIONES');	
	$Layout -> SetGridManifiesto($Attributes,$Titles,$Cols,$Model -> getQueryManifiestoGrid());	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"reexpedido",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

/////
  protected function asignoGuiaReexpedido(){
  
    require_once("ManifiestoModelClass.php");
	
    $Model         = new ManifiestoModel();  
	$reexpedido_id = $_REQUEST['reexpedido_id'];
	
	if($Model -> reexpedidoTieneGuias($reexpedido_id,$this -> getConex())){		
	  exit('true');
	}else{
	     exit('false');
	  }  
  }
  protected function setDivipolaOrigen(){      
    require_once("ManifiestoModelClass.php");	
    $Model        = new ManifiestoModel();
	$ubicacion_id = $_REQUEST['ubicacion_id'];	
	$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());  
    exit("$divipola");  
  }
  
  protected function setDivipolaDestino(){      
    require_once("ManifiestoModelClass.php");	
    $Model        = new ManifiestoModel();
	$ubicacion_id = $_REQUEST['ubicacion_id'];	
	$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());  
    exit("$divipola");  
  }   
  
  
  protected function onclickSave(){    
    require_once("ManifiestoModelClass.php");
	
    $Model                         = new ManifiestoModel();
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
    require_once("ManifiestoModelClass.php");
	$Model = new ManifiestoModel();
	$usuario_id                    = $this -> getUsuarioId();
	$oficina_id                    = $this -> getOficinaId();
	$empresa_id                    = $this -> getEmpresaId();
	$usuarioNombres                = $this -> getUsuarioNombres();
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();		
	$Model -> Update($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
  }  
  
	  
  protected function onclickDelete(){
  	require_once("ManifiestoModelClass.php");
    $Model = new ManifiestoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Manifiesto');
	}
  }
  
  protected function onclickPrint(){  
    require_once("Imp_ReexpedidoClass.php");
	
	$reexpedido_id 	= $_REQUEST['reexpedido_id'];
	$tipo_impre 	= $_REQUEST['tipo_impre'];
    $print = new Imp_Reexpedido($this -> getConex());
    $print -> printOut();  
  } 
  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("ManifiestoModelClass.php");
    $Model = new ManifiestoModel();
	
    $reexpedido_id = $_REQUEST['reexpedido_id'];
	
    $Data =  $Model -> selectReexpedidos($reexpedido_id,$this -> getConex());	
    $this -> getArrayJSON($Data);
}

protected function setSolicitud(){      
    require_once("ManifiestoModelClass.php");	
    $Model        	= new ManifiestoModel();
	$solicitud 		= $_REQUEST['solicitud'];
	$reexpedido_id 	= $_REQUEST['reexpedido_id'];
	$arreglo     = $Model -> SelectSolicitud($solicitud,$this -> getConex());  
	$errorlog = '';
	$total_guias=count($arreglo);
	$total_ingresadas=0;
	$total_noingresadas=0;
	$totales='';
	
	if(count($arreglo)>0){
		for($i=0;$i<count($arreglo);$i++){
			if($arreglo[$i]['guia_id']>0 && $arreglo[$i]['estado_mensajeria_id']==1){
				$result = '';
				$result = $Model -> seleccionar_remesa($arreglo[$i]['guia_id'],$reexpedido_id,$this -> getConex());  
				
				if($result!=''){ $errorlog.=$result."\n"; $total_noingresadas++; }else{ $total_ingresadas++; }
				
			}elseif($arreglo[$i]['guia_id']>0 && $arreglo[$i]['estado_mensajeria_id']!=1){
				$errorlog.="La guia ".$arreglo[$i]['numero_guia']." No esta en Alistamiento \n";
				$total_noingresadas++;
			}
		}
		$totales= "Total Guias: ".$total_guias.", Total Asignadas: ".$total_ingresadas.", Total NO Asignadas: ".$total_noingresadas."\n";
	}else{
		$errorlog .= 'No existe la Solicitud o No esta tiene ninguna Guia';
	}
	$errorlog = $totales.$errorlog;
    exit("$errorlog");  
  }   
 protected function setLeerCodigobar() {
 	require_once("ManifiestoModelClass.php");
 	$Model= new ManifiestoModel();

 	$guia = $_REQUEST['guia'];
    $reexpedido_id = $_REQUEST['reexpedido_id'];

 	$Data = $Model -> setLeerCodigobar($guia,$reexpedido_id, $this -> getConex());
 	$Data1 = $Model -> setLeerCodigobar2($guia,$reexpedido_id, $this -> getConex());
 	$Data2 = $Model -> setLeerCodigobar4($guia,$reexpedido_id, $this -> getConex());		
 	$estado = $Model -> getEstadoReex($reexpedido_id, $this -> getConex());	
	$estadodis = $Model -> getEstadoDisReex($reexpedido_id, $this -> getConex());
	$estadodis1 = $Model -> getEstadoDis1Reex($reexpedido_id, $this -> getConex());	
	$estadodis2 = $Model -> getEstadoDis2Reex($reexpedido_id, $this -> getConex());		
	if($estado!='A' && $estado!='L' && $estadodis==0 && $estadodis1==0 && $estadodis2==0){
		if($Data[0]['numero_guia']>0 || $Data1[0]['numero_guia']>0 || $Data2[0]['numero_guia']>0 || $Data[0]['numero_guia']!=NULL || $Data1[0]['numero_guia']!=NULL || $Data2[0]['numero_guia']!=NULL || $Data[0]['numero_guia']!='NULL' || $Data1[0]['numero_guia']!='NULL' || $Data2[0]['numero_guia']!='NULL'){
			if(($Data[0]['numero_guia']>0 || $Data[0]['numero_guia']!=NULL || $Data[0]['numero_guia']!='NULL')  &&  ($Data[0]['estado_mensajeria_id']==1 || $Data[0]['estado_mensajeria_id']==9)){//&& ($Data[0][reexped]=='' || $Data[0][reexped]==NULL)
				 $Model -> seleccionar_remesa($Data[0][guia_id],$reexpedido_id, $this -> getConex());
				 $this -> getArrayJSON($Data);
			}elseif (($Data1[0]['numero_guia']>0 || $Data1[0]['numero_guia']!=NULL || $Data1[0]['numero_guia']!='NULL')  &&  $Data1[0]['estado_mensajeria_id']==1){
				 $Model -> seleccionar_remesa_inter($Data1[0][guia_interconexion_id],$reexpedido_id, $this -> getConex());
				 $this -> getArrayJSON($Data1);				 
			}elseif(($Data2[0]['numero_guia']>0 || $Data2[0]['numero_guia']!=NULL || $Data2[0]['numero_guia']!='NULL')  &&  ($Data2[0]['estado_mensajeria_id']==1 || $Data2[0]['estado_mensajeria_id']==9)){//&& ($Data[0][reexped]=='' || $Data[0][reexped]==NULL)
				 $Model -> seleccionar_remesa_encomienda($Data2[0][guia_encomienda_id],$reexpedido_id, $this -> getConex());
				 $this -> getArrayJSON($Data);
			}
	
		}else{
			exit('No ha sido creada la guia '.$guia.'');	
		}
	}elseif($estado=='A'){
		exit('No se Puede adicionar Guias a Este Manifiesto,<br>ya que esta Anulado');
	}elseif($estado=='L'){
		exit('No se Puede adicionar Guias a Este Manifiesto,<br>ya que esta Legalizado');
	}elseif($estadodis>0){
		exit('No se Puede adicionar Guias a Este Manifiesto,<br>ya que una de las guias Relacionadas a este manifiesto ha cambiado de estado');
	}elseif($estadodis1>0){
		exit('No se Puede adicionar Guias a Este Manifiesto,<br>ya que una de las guias Relacionadas a este manifiesto ha cambiado de estado');
	}elseif($estadodis2>0){
		exit('No se Puede adicionar Guias a Este Manifiesto,<br>ya que una de las guias Relacionadas a este manifiesto ha cambiado de estado');
		
	}
 } 

 protected function setLeerCodigobar1() {
 	require_once("ManifiestoModelClass.php");
 	$Model= new ManifiestoModel();

 	$guia 			= $_REQUEST['guia'];
    $reexpedido_id 	= $_REQUEST['reexpedido_id'];

 	$Data = $Model -> setLeerCodigobar1($guia,$reexpedido_id, $this -> getConex());
 	$Data1 = $Model -> setLeerCodigobar3($guia,$reexpedido_id, $this -> getConex());
 	$Data2 = $Model -> setLeerCodigobar5($guia,$reexpedido_id, $this -> getConex());		
 	$estado = $Model -> getEstadoReex($reexpedido_id, $this -> getConex());	
	if($estado!='A' && $estado!='L'){
		if($Data[0]['numero_guia']>0 || $Data1[0]['numero_guia']>0 || $Data2[0]['numero_guia']>0 || $Data[0]['numero_guia']!=NULL || $Data1[0]['numero_guia']!=NULL || $Data2[0]['numero_guia']!=NULL || $Data[0]['numero_guia']!='NULL' || $Data1[0]['numero_guia']!='NULL' || $Data2[0]['numero_guia']!='NULL'){
			if(($Data[0]['numero_guia']>0 || $Data[0]['numero_guia']!=NULL || $Data[0]['numero_guia']!='NULL') && $Data[0][reexped]!=''  &&  $Data[0]['estado_mensajeria_id']==4){ 
				 $Model -> retirar_remesa($Data[0][guia_id],$reexpedido_id, $this -> getConex());
	             $this -> getArrayJSON($Data);				 
			}elseif(($Data1[0]['numero_guia']>0 || $Data1[0]['numero_guia']!=NULL || $Data1[0]['numero_guia']!='NULL') && $Data1[0][reexped]!=''  &&  $Data1[0]['estado_mensajeria_id']==4){ 
				 $Model -> retirar_remesa_inter($Data1[0][guia_interconexion_id],$reexpedido_id, $this -> getConex());
	  			 $this -> getArrayJSON($Data1);
			}elseif(($Data2[0]['numero_guia']>0 || $Data2[0]['numero_guia']!=NULL || $Data2[0]['numero_guia']!='NULL') && $Data2[0][reexped]!=''  &&  $Data2[0]['estado_mensajeria_id']==4){ 
				 $Model -> retirar_remesa_encomienda($Data2[0][guia_encomienda_id],$reexpedido_id, $this -> getConex());
	             $this -> getArrayJSON($Data);				 
			}
	
		}else{
			exit('No ha sido creada la guia '.$guia.'');	
		}
	}elseif($estado=='A'){
		exit('No se Puede Eliminar Guias a Este Manifiesto,<br>ya que esta Anulado');
	}elseif($estado=='L'){
		exit('No se Puede Eliminar Guias a Este Manifiesto,<br>ya que esta Legalizado');
	}elseif($estadodis>0){
		exit('No se Puede adicionar Guias a Este Manifiesto,<br>ya que una de las guias Relacionadas a este manifiesto No estan en TRANSITO.');
		
	}
 } 

  protected function onclickCancellation(){  
     require_once("ManifiestoModelClass.php");
	 
     $Model                 = new ManifiestoModel(); 
	 $reexpedido_id         = $this -> requestDataForQuery('reexpedido_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($reexpedido_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }	
  }  


  protected function setCampos(){  
	//FORMULARIO
	$this -> Campos[reexpedido_id] = array(
		name	=>'reexpedido_id',
		id		=>'reexpedido_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('primary_key'))
	);

	$this -> Campos[reexpedido] = array(
		name	=>'reexpedido',
		id		=>'reexpedido',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);

	
	$this -> Campos[fecha_rxp] = array(
		name	=>'fecha_rxp',
		id		=>'fecha_rxp',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);	

	$this -> Campos[hora_salida] = array(
		name	=>'hora_salida',
		id		=>'hora_salida',
		type	=>'text',
		required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);	

	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		required=>'yes',
		suggest=>array(
			name	=>'mensajero',
			setId	=>'proveedor_id'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
		
	);	
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'11'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);	

	/*$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
//		tabindex=>'8',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_hidden')
	);*/

	$this -> Campos[origencopia] = array(
		name	 =>'origencopia',
		id	     =>'origencopia',
		type	 =>'hidden'
		);
		
		$this -> Campos[origencopia_id] = array(
		name	=>'origencopia_id',
		id		=>'origencopia_id',
		type	=>'hidden'
		);	

	$this -> Campos[origen] = array(
		name	 =>'origen',
		id	     =>'origen',
		type	 =>'text',
		readonly =>'yes'
		/*,
		suggest=>array(
		name	=>'ciudad',
		setId	=>'origen_hidden',
		vars	=>3,
		onclick =>'setObservaciones')*/
		);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'destino_hidden')
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);


	$this -> Campos[interno] = array(
		name	=>'interno',
		id		=>'interno',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);

	$this -> Campos[obser_rxp] = array(
		name	=>'obser_rxp',
		id		=>'obser_rxp',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);

	$this -> Campos[n_guias] = array(
		name	=>'n_guias',
		id		=>'n_guias',
		type	=>'text',
		readonly=>'yes'
	);
    
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		required=>'yes',
		disabled=>'yes',
		options =>array(array(value => 'P', text => 'PENDIENTE', selected => 'M'), array(value => 'M', text => 'MANIFESTADO' , selected => 'M'), 
		array(value => 'L', text => 'LEGALIZADO', selected => 'M'),array(value=>'A',text=>'ANULADO',selected=>'M')),
		datatype=>array(
			type	=>'alpha_upper'),
		transaction=>array(
		table=>array('reexpedido'),
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
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );			
	
	
    $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );	
	
    $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
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
    table=>array('reexpedido'),
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
    table=>array('reexpedido'),
    type=>array('column'))
    ); 
	
    $this -> Campos[fecha_registro] = array(
    name=>'fecha_registro',
    id=>'fecha_registro',
    type=>'hidden',
     value   => date("Y-m-d"),
    datatype=>array(
    type=>'text'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );

    $this -> Campos[fecha_static] = array(
    name=>'fecha_static',
    id=>'fecha_static',
    type=>'hidden',
    value   => date("Y-m-d")
    );
	
	$this -> Campos[tipo_impre] = array(
		name	=>'tipo_impre',
		id		=>'tipo_impre',
		type	=>'hidden',
		//value	=>'F'
	);


	
	//BOTONES
    $this -> Campos[guardar] = array(
    name=>'guardar',
    id=>'guardar',
    type=>'button',
    value=>'Guardar'
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
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ManifiestoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'ManifiestoOnReset()'
	);
		
    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Consolidado',
	onclick =>'beforePrint(this.form,this.id)'
	/*id_prin =>'reexpedido_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Manifiesto',
      width       => '900',
      height      => '600'
    )*/
    );
	
	 $this -> Campos[imprimir1] = array(
    name   =>'imprimir1',
    id   =>'imprimir1',
    type   =>'button',
    value   =>'Detallado',
	onclick =>'beforePrint(this.form,this.id)'
	/*id_prin =>'reexpedido_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Manifiesto Consolidado',
      width       => '900',
      height      => '600'
    )*/
    );
	 
    $this -> Campos[excel] = array(
    name   =>'excel',
    id   =>'excel',
    type   =>'button',
	disabled=>'disabled',
    value   =>'Formato Excel',
	onclick =>'Descargar_excel(this.form)'
	
    );
	
	
	
	//BUSQUEDA
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_reexpedido',
			setId	=>'reexpedido_id',
			onclick	=>'setDataFormWithResponse')
	);
	
  $this -> SetVarsValidate($this -> Campos);
  }
}

$Manifiesto = new Manifiesto();

?>