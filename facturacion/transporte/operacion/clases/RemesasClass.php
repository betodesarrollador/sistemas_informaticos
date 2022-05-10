<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Remesas extends Controler{

  public function __construct(){
   	parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout   = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RemesasModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar     ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular     ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
    $Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout ->  setProductos	   ($Model -> getProductos    ($this -> getConex()));	
    $Layout ->  SetTiposRemesa	   ($Model -> GetTiposRemesa  ($this -> getConex()));
    $Layout ->  SetNaturaleza	   ($Model -> GetNaturaleza   ($this -> getConex()));
//    $Layout ->  SetTipoEmpaque	   ($Model -> GetTipoEmpaque  ($this -> getConex()));
    $Layout ->  SetUnidadMedida	   ($Model -> GetUnidadMedida ($this -> getConex()));	
    $Layout -> 	setRangoDesde      ($Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()));
    $Layout -> 	setRangoHasta      ($Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()));	
    $Layout -> 	setDataSeguroPoliza($Model -> getDataSeguroPoliza($this -> getConex(),$this -> getEmpresaId()));
	$Layout ->  setAseguradoras    ($Model -> getAseguradoras($this -> getConex(),$this -> getEmpresaId()));
    $Layout ->  setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));	
    	
	//// GRID ////
	/*
	$Attributes = array(
	  id		=>'RemesasPaqueteo',
	  title		=>'Listado de Remesas Oficina',
	  sortname	=>'numero_remesa',
	  sortorder =>'DESC',
	  rowId		=>'remesa_id',
	  width		=>'auto',
	  height	=>'250',
	  rowList	=>'10,20,30,40,60,80,160,320,640',
	  rowNum	=>'10'
	  
	);
	
	$Cols = array(

	  array(name=>'planilla',		       index=>'planilla',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 	
	  array(name=>'placa',		           index=>'placa',	                sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  
	  array(name=>'conductor',		       index=>'conductor',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  	  
	  array(name=>'fecha_planilla',		   index=>'fecha_planilla',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  	  
	  array(name=>'numero_remesa',		   index=>'numero_remesa',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      
	  array(name=>'fecha_remesa',		   index=>'fecha_remesa',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  
	  array(name=>'cliente',			   index=>'cliente',		        sorttype=>'text',	width=>'200',	align=>'center' , format => 'none'),	
	  array(name=>'origen',				   index=>'origen',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'remitente',		       index=>'remitente',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'), 
	  array(name=>'destino',			   index=>'destino',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'destinatario',	       index=>'destinatario',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),  
	  array(name=>'orden_despacho'        ,index=>'orden_despacho',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'referencia_producto'   ,index=>'referencia_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'cantidad',		       index=>'cantidad',		        sorttype=>'text',	width=>'100',	align=>'center' ),
	  array(name=>'codigo',				   index=>'codigo',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'descripcion_producto',  index=>'descripcion_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'naturaleza',			   index=>'naturaleza',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'empaque',			   index=>'empaque',			    sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'medida',				   index=>'medida',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'peso_volumen',	       index=>'tipo_remesa',		    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'peso',		           index=>'peso',		            sorttype=>'text',	width=>'100',	align=>'center' )
	    
	  
	  
	);
			
    $Titles = array(
	    'PLANILLA',
		'PLACA',
		'CONDCUTOR',
		'FECHA PLANILLA',
		'REMESA',
		'FECHA REMESA',
		'CLIENTE',					
		'ORIGEN',
		'REMITENTE',
		'DESTINO',
		'DESTINATARIO',
		'ORDEN DESPACHO',
		'REFERENCIA',				
		'CANTIDAD',		
		'COD PRODUCTO',
		'DESCR PRODUCTO',
		'NATURALEZA',
		'EMPAQUE',
		'MEDIDA',
		'PESO VOLUMEN',
		'PESO NETO'
	);
		*/
	//$Layout -> SetGridRemesasOficinas($Attributes,$Titles,$Cols,$Model -> getQueryRemesasOficinasGrid($this -> getOficinaId()),$SubAttributes,$SubTitles,$SubCols,null);	
	$Layout -> RenderMain();    
  }
  
  protected function setContactos(){

    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();
	
    $contacto_id = $_REQUEST['contacto_id'];
    $contactos   = $Model -> getContactos($contacto_id,$this -> getConex());
	
    if(!count($contactos) > 0){
	  $contactos = array();
	}

    $field = array(
	  name	 =>'contacto_id',
	  id	 =>'contacto_id',
	  type	 =>'select',
	  options  => $contactos,		
	  datatype => array(
		type	=>'integer'
	  ),
	  transaction=>array(
		table	=>array('remesa'),
		type	=>array('column'))
   );
	  
	print $Layout -> getObjectHtml($field);
  }
  
  protected function selectedContactos(){

	require_once("RemesasModelClass.php");
    $Model     = new RemesasModel();
	
	$return = $Model -> SelectContactosRemesa($this -> getConex());
	
	if(count($return) > 0){
	  $this -> getArrayJSON($return);
	}else{
	    exit('false');
	  }
  }
  
  protected function updateRangoDesde(){
  
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();  
  
	$field[rango_desde] = array(
		name	=>'rango_desde',
		id		=>'rango_desde',
		type	=>'select',
		options	=> $Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()),
		datatype=>array(type =>'integer')
	); 
			
	print $Layout -> getObjectHtml($field[rango_desde]);		
  
  }
  
  
  protected function updateRangoHasta(){
  
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();  
  
	$field[rango_hasta] = array(
		name	=>'rango_hasta',
		id		=>'rango_hasta',
		type	=>'select',
		options	=> $Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()),
		datatype=>array(type =>'integer')
	); 
			
	print $Layout -> getObjectHtml($field[rango_hasta]);	
  
  }  

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"remesa",$this ->Campos);
    print $Data  -> GetData();
  }

  protected function getTipoEmpaque(){
  
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();  
	
	$tipo_remesa_id = $this -> requestData('tipo_remesa_id');
	$data           = $Model -> getTipoEmpaque($this -> getConex(),$tipo_remesa_id);
	
	$field = array(
		name	=>'empaque_id',
		id		=>'empaque_id',
		type	=>'select',
		options	=> $data,
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);    
	
	print $Layout -> getObjectHtml($field);
  
  }

  protected function getPesoVacioMinimoContenedor(){
  
    require_once("RemesasMasivoModelClass.php");
    $Model = new RemesasMasivoModel();
	  
    $empaque_id        = $this -> requestData('empaque_id');	
	$peso_vacio_minimo = $Model -> selectPesoVacioMinimoContenedor($empaque_id,$this -> getConex());
	
	if(is_numeric($peso_vacio_minimo)){
	  exit("$peso_vacio_minimo");
	}else{
	    exit("0");
	  }
  
  }

  protected function onclickSave(){
    	
    require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
		
    $nacional          = $this -> requestData('nacional');		
    $valor             = $this -> requestData('valor');
	$peso              = $this -> removeFormatCurrency($this -> requestData('peso'));
    $valorMaximoPoliza = $Model -> validaValorMaximoPoliza($this -> getEmpresaId(),$valor,$this -> getConex());
	$tipo_remesa_id    = $this -> requestData('tipo_remesa_id');	
	$codTipoRemesa     = $Model -> getCodTipoRemesa($tipo_remesa_id,$this -> getConex());
	$naturaleza_id     = $this -> requestData('naturaleza_id');	
	$codTipoRemesa     = $Model -> getCodTipoRemesa($tipo_remesa_id,$this -> getConex());
	$remitente_id      = $this -> requestData('remitente_id');
	$destinatario_id   = $this -> requestData('destinatario_id');
	$cliente_id        = $this -> requestData('cliente_id');
	
	$origen_id         = $Model -> getCiudadIdRemitenteDestinatario($remitente_id,$this -> getConex());
	$destino_id        = $Model -> getCiudadIdRemitenteDestinatario($destinatario_id,$this -> getConex());
	
	if($nacional == 1 && ($codTipoRemesa == 'C' || $codTipoRemesa == 'V')){
	
	  if(!is_numeric($peso)){
	    exit("<div align='center'>Debe reportar el peso !!<br>Cuando el tipo de remesa sea Contendor Cargado o Contenedor Vacio.</div>");
	  }
	
	}
		
    if($valorMaximoPoliza == null){
    
      print 'No existe una poliza activa para la empresa<br>No se permite remesar !!!';
    
    }else{
    			
	  if($nacional == 1 && $origen_id == $destino_id){
	  
		if($naturaleza_id != 5 && $codTipoRemesa != 'V'){				
		  exit("El codigo de la ciudad de origen del remitente y de destino del destinatario deben ser diferentes. Solamente pueden ser iguales cuando en la Naturaleza se haya registrado como Desechos Peligrosos o cuando el codigo de la Operacion de Transporte sea Contenedor Vacio");
		}    
		
	  }			    

	$result = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());
	    
	if($Model -> GetNumError() > 0){
	  exit('false');
	}else{
	     print $result;
	    }	  
            
      
     }
	
	
  }


  protected function onclickUpdate(){
    
    require_once("RemesasModelClass.php");
	$Model = new RemesasModel();
	
	$numero_remesa     = $this -> requestData('numero_remesa');
	$clase_remesa      = $this -> requestData('clase_remesa');
    $nacional          = $this -> requestData('nacional');		
    $valor             = $this -> requestData('valor');
	$peso              = $this -> removeFormatCurrency($this -> requestData('peso'));
    $valorMaximoPoliza = $Model -> validaValorMaximoPoliza($this -> getEmpresaId(),$valor,$this -> getConex());
	$tipo_remesa_id    = $this -> requestData('tipo_remesa_id');	
	$codTipoRemesa     = $Model -> getCodTipoRemesa($tipo_remesa_id,$this -> getConex());
	$naturaleza_id     = $this -> requestData('naturaleza_id');	
	$codTipoRemesa     = $Model -> getCodTipoRemesa($tipo_remesa_id,$this -> getConex());
	$remitente_id      = $this -> requestData('remitente_id');
	$destinatario_id   = $this -> requestData('destinatario_id');
	$cliente_id        = $this -> requestData('cliente_id');
	
	$origen_id         = $Model -> getCiudadIdRemitenteDestinatario($remitente_id,$this -> getConex());
	$destino_id        = $Model -> getCiudadIdRemitenteDestinatario($destinatario_id,$this -> getConex());
	
	if($nacional == 1 && ($codTipoRemesa == 'C' || $codTipoRemesa == 'V')){
	
	  if(!is_numeric($peso)){
	    exit("<div align='center'>Debe reportar el peso !!<br>Cuando el tipo de remesa sea Contendor Cargado o Contenedor Vacio.</div>");
	  }
	
	}
		
    if($valorMaximoPoliza == null){
    
      print 'No existe una poliza activa para la empresa<br>No se permite remesar !!!';
    
    }else{
    			
	  if($nacional == 1 && $origen_id == $destino_id){
	  
		if($naturaleza_id != 5 && $codTipoRemesa != 'V'){				
		  exit("El codigo de la ciudad de origen del remitente y de destino del destinatario deben ser diferentes. Solamente pueden ser iguales cuando en la Naturaleza se haya registrado como Desechos Peligrosos o cuando el codigo de la Operacion de Transporte sea Contenedor Vacio");
		}    
		
	  }		
	
	
	if($clase_remesa == 'CP' && $Model -> esRemesaPrincipal($numero_remesa,$this -> getConex())){
	
	  print "<p align='center'>Esta remesa es principal para otros complemento ingresados<br>No se puede marcar como remesa de complemento!!!</p>";
	
	}else{
	
		$Model -> Update($this -> Campos,$this -> getConex());
	
		if($Model -> GetNumError() > 0){
		  exit("false");
		}else{
		   exit("true");
		  }
	  
	  }
	  
	 } 
	  
	  
  }
	
	  
  protected function onclickDelete(){
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la remesa');
	}
  }
  
  protected function onclickCancellation(){
    
     require_once("RemesasModelClass.php");
	 
     $Model                 = new RemesasModel(); 
	 $remesa_id             = $this -> requestDataForQuery('remesa_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($remesa_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }
	
  }
  
  protected function anularRemesaMinisterio(){
  
	include_once("../../webservice/WebServiceMinTranporteClass.php");

	$webService = new WebServiceMinTransporte($this -> getConex());	 
	 
	$data = array(	  
	    remesa_id           => $this -> requestData('remesa_id'),		
	    numero_remesa       => $this -> requestData('numero_remesa'),	
		causal_anulacion_id => $this -> requestData('causal_anulacion_id')
	  );
	  
    $webService -> anularRemesaMinisterio($data);	     
  
  }   


//BUSQUEDA
  protected function onclickFind(){
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
	
    $Data =  $Model -> selectRemesa($this -> getConex());
	
    $this -> getArrayJSON($Data);
  }
  
  protected function onclickPrint(){
      
    require_once("Imp_RemesaClass.php");
	
    $print   = new Imp_Remesa();  	
    $Remesas = $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getEmpresaIdentificacion(),$this -> getConex());     
  
  }
  
  protected function getDataClienteRemitente(){
            
  	require_once("RemesasModelClass.php");
	
        $Model      = new RemesasModel();
	$cliente_id = $_REQUEST['cliente_id'];	
	$data       = $Model -> selectDataClienteRemitente($cliente_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	
	    if(count($data) > 0){
	      $this -> getArrayJSON($data);
		}else{
		    print 'false';
		  }
	}
  
  } 
  
    protected function getDataRemitente(){
              
  	 require_once("RemesasModelClass.php");
	
     $Model                     = new RemesasModel();
	 $remitente_destinatario_id = $_REQUEST['remitente_destinatario_id'];
	 $data  = $Model -> selectDataRemitente($remitente_destinatario_id,$this -> getConex());
	
	 if(is_array($data)){
	  $this -> getArrayJSON($data);
	 }else{
	    print 'false';
	  }    
  
  }


    protected function getDataDestinatario(){
              
  	 require_once("RemesasModelClass.php");
	
     $Model                     = new RemesasModel();
	 $remitente_destinatario_id = $_REQUEST['remitente_destinatario_id'];
	 $data  = $Model -> selectDataDestinatario($remitente_destinatario_id,$this -> getConex());
	
	 if(is_array($data)){
	  $this -> getArrayJSON($data);
	 }else{
	    print 'false';
	  }    
  
  }

  
  protected function getDataPropietario(){
  
  	require_once("RemesasModelClass.php");
	
        $Model      = new RemesasModel();
	$tercero_id = $_REQUEST['tercero_id'];	
	$data       = $Model -> selectDataPropietario($tercero_id,$this -> getConex());
	
	$this -> getArrayJSON($data);
  
  }
  
  protected function getDataClientePropietario(){
  
  	require_once("RemesasModelClass.php");
	
    $Model      = new RemesasModel();
	$cliente_id = $_REQUEST['cliente_id'];	
	$data       = $Model -> selectDataPropietarioCliente($cliente_id,$this -> getConex());
	
	$this -> getArrayJSON($data);   
  
  }
  
  protected function getRemesaComplemento(){
  
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
	
	$numero_remesa = $_REQUEST['numero_remesa'];
	
    $Data =  $Model -> selectRemesaComplemento($numero_remesa,$this -> getConex());
		
	if(count($Data) > 0){
      $this -> getArrayJSON($Data);	
	}else{
        print 'false';
	  }
  
  }

  protected function informacionCargaFueReportada(){
  
    require_once("RemesasModelClass.php");
    $Model     = new RemesasModel();
	
	$remesa_id = $this -> requestData('remesa_id');   
	
	if($Model -> informacionCargaFueReportada($remesa_id,$this -> getConex())){
	  exit('true');
    }else{
	    exit('false');
      } 
  
  }
  
  protected function reloadListProductos(){
  
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
		
	$opciones = $Model -> getProductos($this -> getConex());  
		
	$this -> getArrayJSON($opciones);
  
  }
  
  
  
  protected function sendInformacionCarga(){

	include_once("../../webservice/WebServiceMinTranporteClass.php");

	$webService = new WebServiceMinTransporte($this -> getConex());		 
		 
	$data = array(	  

	    remesa_id                           => $this -> requestData('remesa_id'),	
	    numero_remesa                       => $this -> requestData('numero_remesa'),
	    tipo_remesa_id                      => $this -> requestData('tipo_remesa_id'),
		fecha_recogida_ss                   => $this -> requestData('fecha_recogida_ss'),
		hora_recogida_ss                    => $this -> requestData('hora_recogida_ss'),
		empaque_id                          => $this -> requestData('empaque_id'),
		naturaleza_id                       => $this -> requestData('naturaleza_id'),
		descripcion_producto                => $this -> requestData('descripcion_producto'),
		producto_id                         => $this -> requestData('producto_id'),
	    cantidad                            => $this -> requestData('cantidad'),
	    peso                                => $this -> requestData('peso'),		
		medida_id                           => $this -> requestData('medida_id'),
        remitente_id                        => $this -> requestData('remitente_id'),
        destinatario_id                     => $this -> requestData('destinatario_id'),
		observaciones                       => $this -> requestData('observaciones')

	  );

    $webService -> sendInformacionCarga($data,NULL,true);				    
            	
  } 
  
  protected function setCampos(){
  
//FORMULARIO

	$this -> Campos[remesa_id] = array(
		name	=>'remesa_id',
		id	=>'remesa_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('primary_key'))
	);
	
	
	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id	    =>'fecha_registro',
		type	=>'hidden',
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[nacional] = array(
		name	=>'nacional',
		id	    =>'nacional',
		type	=>'select',
		options => array(array(value => 0, text => 'NO'), array(value => 1, text => 'SI')),
		selected=>'1',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[orden_despacho] = array(
		name    =>'orden_despacho',
		id	    =>'orden_despacho',
		type	=>'text',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id	    =>'oficina_id',
		type	=>'hidden',
		value   => $this -> getOficinaId(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[oficina_id_static] = array(
		name	=>'oficina_id_static',
		id	    =>'oficina_id_static',
		type	=>'hidden',
		value   => $this -> getOficinaId(),
	);		
		
	$this -> Campos[tipo_remesa_id] = array(
		name	=>'tipo_remesa_id',
		id	    =>'tipo_remesa_id',
		required=>'yes',
		type	=>'select',
		options	=>array(),
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[clase_remesa] = array(
		name	=>'clase_remesa',
		id	    =>'clase_remesa',
		type	=>'select',
		options	=>array(array(value => 'NN', text => 'NORMAL', selected => 'NN'),array(value => 'DV', text => 'DEVOLUCION', selected => 'NN'),
		array(value => 'CP', text => 'COMPLEMENTO', selected => 'NN'),array(value => 'SM', text => 'SUMINISTRO', selected => 'NN')),
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[planilla] = array(
		name	=>'planilla',
		id	    =>'planilla',
		type	=>'select',
		options	=>array(array(value => '1', text => 'SI'),array(value => '0', text => 'NO')),
		selected=>1,
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[numero_remesa] = array(
		name	=>'numero_remesa',
		id		=>'numero_remesa',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[solicitud_id] = array(
		name	=>'solicitud_id',
		id	=>'solicitud_id',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);

	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id	=>'fecha',
		type	=>'hidden',
		value	=>date("Y-m-d")
	);
	
	$this -> Campos[fecha_remesa] = array(
		name	=>'fecha_remesa',
		id		=>'fecha_remesa',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_recogida_ss] = array(
		name	=>'fecha_recogida_ss',
		id		=>'fecha_recogida_ss',
		type	=>'text',
		value	=>'',
		size	=>'10',
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[hora_recogida_ss] = array(
		name	=>'hora_recogida_ss',
		id		=>'hora_recogida_ss',
		type	=>'text',
		value	=>'',
		size	=>'10',
		required=>'yes',		
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		size     =>'35',
		suggest=>array(
			name	=>'cliente_disponible',
			setId	=>'cliente_hidden',
			onclick =>'getDataClienteRemitente'
			)
	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id	=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[propietario_mercancia] = array(
		name	=>'propietario_mercancia',
		id	=>'propietario_mercancia',
		type	=>'text',
		size     =>'35',
		required =>'yes',
		suggest=>array(
		  name	=>'tercero_disponible',
		  setId	=>'propietario_mercancia_hidden',
		  onclick =>'getDataPropietario'
		),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[propietario_mercancia_txt] = array(
		name	=>'propietario_mercancia_txt',
		id	=>'propietario_mercancia_txt',
		type	=>'hidden',
	);	
		
	$this -> Campos[propietario_mercancia_id] = array(
		name	=>'propietario_mercancia_id',
		id	=>'propietario_mercancia_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[tipo_identificacion_propietario_mercancia] = array(
		name	=>'tipo_identificacion_propietario_mercancia',
		id	=>'tipo_identificacion_propietario_mercancia',
		type	=>'hidden',
		value	=>'',
		required=>'true',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_identificacion_propietario_mercancia] = array(
		name	=>'numero_identificacion_propietario_mercancia',
		id	=>'numero_identificacion_propietario_mercancia',
		type	=>'hidden',
		value	=>'',
		required=>'true',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[numero_remesa_padre] = array(
		name	=>'numero_remesa_padre',
		id	    =>'numero_remesa_padre',
		type	=>'text',
        value   =>'',
		size    =>'10',
		disabled => 'true',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[contacto_id] = array(
		name	 =>'contacto_id',
		id	 =>'contacto_id',
		type	 =>'select',
		options  => array(),		
		datatype => array(
			type	=>'integer'
		 ),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[amparada_por] = array(
		name	 =>'amparada_por',
		id	 =>'amparada_por',
		type	 =>'select',
		options  => array(array(value => 'E', text => 'Empresa Transporte',selected => 'E'),array(value => 'G', text => 'Generador de Carga',selected => 'E'),array(value => 'R', text => 'Remitente',selected => 'E'),array(value => 'D', text => 'Destinatario',selected => 'E'),array(value => 'N', text => 'No Posee',selected => 'E')),		
		datatype => array(
			type	=>'alpha'
		 ),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[aseguradora_id] = array(
		name	 =>'aseguradora_id',
		id	     =>'aseguradora_id',
		type	 =>'select',
        options  => array(),	
		disabled => 'disabled',	
		datatype => array(type	=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[aseguradora_id_static] = array(
		name	 =>'aseguradora_id_static',
		id	     =>'aseguradora_id_static',
		type	 =>'hidden',
        value    => ''
	);	
	
	$this -> Campos[numero_poliza] = array(
		name	 =>'numero_poliza',
		id	     =>'numero_poliza',
		type	 =>'text',
        value    => '',		
		required => 'yes',
		readonly => 'true',		
		datatype => array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[numero_poliza_static] = array(
		name	 =>'numero_poliza_static',
		id	     =>'numero_poliza_static',
		type	 =>'hidden',
        value    => ''
	);	
	
	$this -> Campos[fecha_vencimiento_poliza] = array(
		name	 =>'fecha_vencimiento_poliza',
		id	     =>'fecha_vencimiento_poliza',
		type	 =>'text',
		readonly => 'true',	
		required => 'yes',				
		datatype => array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);			
	
	$this -> Campos[fecha_vencimiento_poliza_static] = array(
		name	 =>'fecha_vencimiento_poliza_static',
		id	     =>'fecha_vencimiento_poliza_static',
		type	 =>'hidden'
	);		
	
	$this -> Campos[origen] = array(
		name	 =>'origen',
		id	     =>'origen',
		type	 =>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_hidden',
			onclick =>'setObservaciones')
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id	=>'origen_hidden',
		type	=>'hidden',
		required=>'yes',
		value=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[remitente] = array(
		name	=>'remitente',
		id	=>'remitente',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column')),
		suggest=>array(
			name	=>'remitente_disponible',
			setId	=>'remitente_hidden',
			onclick =>'setDataRemitente'
		)
	);
	
	$this -> Campos[remitente_id] = array(
		name    =>'remitente_id',
		id	    =>'remitente_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[doc_remitente] = array(
		name	=>'doc_remitente',
		id		=>'doc_remitente',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_remitente_id] = array(
		name	=>'tipo_identificacion_remitente_id',
		id		=>'tipo_identificacion_remitente_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[direccion_remitente] = array(
		name	=>'direccion_remitente',
		id		=>'direccion_remitente',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_remitente] = array(
		name	=>'telefono_remitente',
		id		=>'telefono_remitente',
		type	=>'text',
		value	=>'',	
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id	=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'destino_hidden')
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id	=>'destino_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[destinatario] = array(
		name	=>'destinatario',
		id		=>'destinatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column')),
		suggest=>array(
			name	=>'destinatario_disponible',
			setId	=>'destinatario_hidden',
			onclick =>'setDataDestinatario')
	);
	
	$this -> Campos[destinatario_id] = array(
		name	=>'destinatario_id',
		id		=>'destinatario_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[doc_destinatario] = array(
		name	=>'doc_destinatario',
		id		=>'doc_destinatario',
		type	=>'text',
		value	=>'',
		required =>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_destinatario_id] = array(
		name	=>'tipo_identificacion_destinatario_id',
		id		=>'tipo_identificacion_destinatario_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[direccion_destinatario] = array(
		name	=>'direccion_destinatario',
		id		=>'direccion_destinatario',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_destinatario] = array(
		name	=>'telefono_destinatario',
		id		=>'telefono_destinatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
		
	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id	    =>'producto_id',
		type	=>'select',
		required=>'yes',
		options =>array(),
		datatype=>array(type =>'integer'),
		onchange   =>'separaCodigoDescripcion()',
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		id		=>'descripcion_producto',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[naturaleza_id] = array(
		name	=>'naturaleza_id',
		id	=>'naturaleza_id',
		type	=>'select',
		options	=> array(),
		required=>'yes',		
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[empaque_id] = array(
		name	=>'empaque_id',
		id		=>'empaque_id',
		type	=>'select',
		options	=> array(),
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[medida_id] = array(
		name	=>'medida_id',
		id	=>'medida_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		id		=>'cantidad',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'numeric',
			length	=>'11'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[catidad_detalle] = array(
		name	=>'catidad_detalle',
		id		=>'catidad_detalle',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'integer')
	);		
	
	$this -> Campos[peso_detalle] = array(
		name	=>'peso_detalle',
		id		=>'peso_detalle',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[valor_detalle] = array(
		name	=>'valor_detalle',
		id		=>'valor_detalle',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', precision=>'2')
	);	
	
	$this -> Campos[peso_volumen_detalle] = array(
		name	=>'peso_volumen_detalle',
		id		=>'peso_volumen_detalle',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', precision=>'3')
	);		
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id	=>'valor',
		type	=>'text',
		size	=>'20',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'18',
			precision=>'2'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);

	$this -> Campos[peso] = array(
		name	=>'peso',
		id		=>'peso',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		id	=>'peso_volumen',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[tipo_liquidacion] = array(
		name	=>'tipo_liquidacion',
		id	    =>'tipo_liquidacion',
		type	=>'select',
		options=>array(array(value => 'P', text => 'Peso'),array(value => 'V', text => 'Volumen'),array(value =>'C',text => 'Cupo')),
		datatype=>array(type=>'alpha'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[valor_facturar] = array(
		name	=>'valor_facturar',
		id	    =>'valor_facturar',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[valor_unidad_facturar] = array(
		name	=>'valor_unidad_facturar',
		id	    =>'valor_unidad_facturar',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);			
	
    $this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id	    =>'observaciones',
		type	=>'textarea',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[rango_desde] = array(
		name	=>'rango_desde',
		id		=>'rango_desde',
		type	=>'select',
		options	=> array(),
		datatype=>array(type =>'integer')
	);
	
	$this -> Campos[rango_hasta] = array(
		name	=>'rango_hasta',
		id		=>'rango_hasta',
		type	=>'select',
		options	=> array(),
		datatype=>array(type =>'integer')
	);	
		
	$this -> Campos[formato] = array(
		name	=>'formato',
		id		=>'formato',
		type	=>'select',
		options	=> array(array(value => 'SI', text => 'SI', selected => 'SI'),array(value => 'NO', text => 'NO', selected => 'SI')),
		datatype=>array(type =>'integer')
	);			
				
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		value	=>'',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_remesa_paqueteo',
			setId	=>'remesa_id',
			onclick	=>'setDataFormWithResponse')
	);
		     	
    $this -> Campos[estado] = array(
    name    =>'estado',
    id      =>'estado',
    type    =>'select',
	disabled => 'yes',
	options =>array(array(value => 'PD', text => 'PENDIENTE', selected => 'PD'),array(value => 'PC', text => 'PROCESANDO', selected => 'PD'), 
	array(value => 'MF', text => 'MANIFESTADO' , selected => 'PD'), array(value=>'AN',text=>'ANULADO',selected=>'PD'),
	array(value => 'LQ', text => 'LIQUIDADA', selected => 'PD'),array(value => 'FT', text => 'FACTURADA', selected => 'PD')),
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('remesa'),
    type=>array('column'))
    );					
	
    $this -> Campos[manifiestos] = array(
     name     =>'manifiestos',
     id       =>'manifiestos',
     type     =>'text',
	 readonly => 'yes',
     datatype=>array(type=>'text')
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


	$this -> Campos[importSolcitud] = array(
		name	=>'importSolcitud',
		id		=>'importSolcitud',
		type	=>'button',
		value	=>'Importar Solicitud'
	);	
	
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
		disabled=>'true',
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
			onsuccess=>'RemesasOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'RemesasOnReset()'
	);
	
	
   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	    displayoptions => array(
                  form        => 0,
                  beforeprint => 'beforePrint',
		  title       => 'Impresion Remesas Carga',
		  width       => '700',
		  height      => '600'
		)

	);	
	
   	$this -> Campos[print_out] = array(
		name	   =>'print_out',
		id		   =>'print_out',
		type	   =>'button',
		value	   =>'OK'

	);	
	
   	$this -> Campos[print_cancel] = array(
		name	   =>'print_cancel',
		id		   =>'print_cancel',
		type	   =>'button',
		value	   =>'CANCEL'

	);			
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$remesas = new Remesas();

?>