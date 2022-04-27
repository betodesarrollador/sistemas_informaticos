<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DesbloquearRemesas extends Controler{

  public function __construct(){
   	parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("DesbloquearRemesasLayoutClass.php");
    require_once("DesbloquearRemesasModelClass.php");
	
    $Layout   = new DesbloquearRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DesbloquearRemesasModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar     ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular     ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
    $Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout ->  SetTiposRemesa	   ($Model -> GetTiposRemesa  ($this -> getConex()));
    $Layout ->  SetNaturaleza	   ($Model -> GetNaturaleza   ($this -> getConex()));
    $Layout ->  SetTipoEmpaque	   ($Model -> GetTipoEmpaque  ($this -> getConex()));
    $Layout ->  SetUnidadMedida	   ($Model -> GetUnidadMedida ($this -> getConex()));	
    $Layout -> 	setRangoDesde      ($Model -> getDesbloquearRemesasNumero($this -> getConex(),$this -> getOficinaId()));
    $Layout -> 	setRangoHasta      ($Model -> getDesbloquearRemesasNumero($this -> getConex(),$this -> getOficinaId()));	
    $Layout -> 	setDataSeguroPoliza($Model -> getDataSeguroPoliza($this -> getConex(),$this -> getEmpresaId()));
	$Layout ->  setAseguradoras    ($Model -> getAseguradoras($this -> getConex(),$this -> getEmpresaId()));
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));	
    	
	//// GRID ////
	$Attributes = array(
	  id		=>'remesas',
	  title		=>'Listado de Remesas',
	  sortname	=>'numero_remesa',
	  rowId		=>'remesa_id',
	  width		=>'auto',
	  height	=>'250'
	);
	
	$Cols = array(
	
	  array(name=>'numero_remesa',		   index=>'numero_remesa',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      array(name=>'estado',		           index=>'estado',	                sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 
	  array(name=>'tipo_remesa',		   index=>'tipo_remesa',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'fecha_remesa',		   index=>'fecha_remesa',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'cliente',			   index=>'cliente',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),	
	  array(name=>'origen',				   index=>'origen',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'remitente',		       index=>'remitente',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'doc_remitente',	       index=>'doc_remitente',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'direccion_remitente',   index=>'direccion_remitente',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'telefono_remitente',	   index=>'telefono_remitente',		sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),	  
	  array(name=>'destino',			   index=>'destino',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'destinatario',	       index=>'destinatario',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'doc_destinatario',      index=>'doc_destinatario',       sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'direccion_destinatario',index=>'direccion_destinatario',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'telefono_destinatario', index=>'telefono_destinatario',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),	  
	  array(name=>'codigo',				   index=>'codigo',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'descripcion_producto',  index=>'descripcion_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'naturaleza',			   index=>'naturaleza',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'empaque',			   index=>'empaque',			    sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'medida',				   index=>'medida',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'cantidad',		       index=>'cantidad',		        sorttype=>'text',	width=>'100',	align=>'center' ),
	  array(name=>'valor',	               index=>'valor',                  sorttype=>'text',	width=>'100',	align=>'center' , format => 'currency'),
	  array(name=>'peso_volumen',	       index=>'tipo_remesa',		    sorttype=>'text',	width=>'100',	align=>'center',  format => 'currency'),
	  array(name=>'peso',		           index=>'tipo_remesa',		    sorttype=>'text',	width=>'100',	align=>'center' )
	  
	);
			
    $Titles = array(
		'REMESA',
		'ESTADO',
		'TIPO REMESA',
		'FECHA',
		'CLIENTE',					
		'ORIGEN',
		'REMITENTE',
		'DOC REMITENTE',
		'DIR REMITENTE',
		'TEL REMITENTE',					
		'DESTINO',
		'DESTINATARIO',
		'DOC DETINATARIO',
		'DIR DESTINATARIO',
		'TEL DESTINATARIO',					
		'COD PRODUCTO',
		'DESCR PRODUCTO',
		'NATURALEZA',
		'EMPAQUE',
		'MEDIDA',
		'CANTIDAD',
		'VALOR DECLARADO',
		'PESO VOLUMEN',
		'PESO NETO'
	);
		
	$Layout -> SetGridDesbloquearRemesas($Attributes,$Titles,$Cols,$Model -> getQueryDesbloquearRemesasGrid(),$SubAttributes,$SubTitles,$SubCols,null);	
	$Layout -> RenderMain();
    
  }
  
  protected function setContactos(){

    require_once("DesbloquearRemesasLayoutClass.php");
    require_once("DesbloquearRemesasModelClass.php");
	
    $Layout = new DesbloquearRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DesbloquearRemesasModel();
	
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

	require_once("DesbloquearRemesasModelClass.php");
    $Model     = new DesbloquearRemesasModel();
	
	$return = $Model -> SelectContactosRemesa($this -> getConex());
	
	if(count($return) > 0){
	  $this -> getArrayJSON($return);
	}else{
	    exit('false');
	  }
  }
  
  protected function updateRangoDesde(){
  
    require_once("DesbloquearRemesasLayoutClass.php");
    require_once("DesbloquearRemesasModelClass.php");
	
    $Layout = new DesbloquearRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DesbloquearRemesasModel();  
  
	$field[rango_desde] = array(
		name	=>'rango_desde',
		id		=>'rango_desde',
		type	=>'select',
		options	=> $Model -> getDesbloquearRemesasNumero($this -> getConex(),$this -> getOficinaId()),
		datatype=>array(type =>'integer')
	); 
			
	print $Layout -> getObjectHtml($field[rango_desde]);		
  
  }
  
  
  protected function updateRangoHasta(){
  
    require_once("DesbloquearRemesasLayoutClass.php");
    require_once("DesbloquearRemesasModelClass.php");
	
    $Layout = new DesbloquearRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DesbloquearRemesasModel();  
  
	$field[rango_hasta] = array(
		name	=>'rango_hasta',
		id		=>'rango_hasta',
		type	=>'select',
		options	=> $Model -> getDesbloquearRemesasNumero($this -> getConex(),$this -> getOficinaId()),
		datatype=>array(type =>'integer')
	); 
			
	print $Layout -> getObjectHtml($field[rango_hasta]);	
  
  }  

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"remesa",$this ->Campos);
    print $Data  -> GetData();
  }


  protected function onclickSave(){
    
    require_once("DesbloquearRemesasModelClass.php");
    $Model = new DesbloquearRemesasModel();
		
    $valor             = $_REQUEST['valor'];
    $valorMaximoPoliza = $Model -> validaValorMaximoPoliza($this -> getEmpresaId(),$valor,$this -> getConex());
	
    if($valorMaximoPoliza == null){
    
      print 'No existe una poliza activa para la empresa<br>No se permite remesar !!!';
    
    }else{
    
      //if($valorMaximoPoliza > $valor){

	$result = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());
	    
	if($Model -> GetNumError() > 0){
	  exit('false');
	}else{
	  print $result;
	    }	  
            
     /* }else{
      
         print "El valor Remesado supera el maximo cubierto por la poliza actual !!!  $valorMaximoPoliza > $valor";               	  
      
	}*/
      
     }
	
	
  }


  protected function onclickUpdate(){
  
    require_once("DesbloquearRemesasModelClass.php");
	$Model = new DesbloquearRemesasModel();
	
	$numero_remesa = $_REQUEST['numero_remesa'];
	$complemento   = $_REQUEST['complemento'];
	
	if($complemento == 1 && $Model -> esRemesaPrincipal($numero_remesa,$this -> getConex())){
	
	  print "<p align='center'>Esta remesa es principal para otros complemento ingresados<br>No se puede marcar como remesa de complemento!!!</p>";
	
	}else{
	
		$Model -> Update($this -> getOficinaId(),$this -> Campos,$this -> getConex());
	
		if($Model -> GetNumError() > 0){
		  exit("false");
		}else{
		   exit("true");
		  }
	  
	  }
  }
	
	  
  protected function onclickDelete(){
  	require_once("DesbloquearRemesasModelClass.php");
    $Model = new DesbloquearRemesasModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la remesa');
	}
  }
  
  protected function onclickCancellation(){
    
     require_once("DesbloquearRemesasModelClass.php");
	 
     $Model                 = new DesbloquearRemesasModel(); 
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


//BUSQUEDA
  protected function onclickFind(){
  	require_once("DesbloquearRemesasModelClass.php");
    $Model = new DesbloquearRemesasModel();
	
    $Data =  $Model -> selectRemesa($this -> getConex());
	
    $this -> getArrayJSON($Data);
  }
  
  protected function onclickPrint(){
      
    require_once("Imp_RemesaClass.php");
	
    $print   = new Imp_Remesa($this -> getConex());  	
    $DesbloquearRemesas = $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId());     
  
  }
  
  protected function getDataClienteRemitente(){
            
  	require_once("DesbloquearRemesasMasivoModelClass.php");
	
        $Model      = new DesbloquearRemesasMasivoModel();
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
  
    protected function getDataRemitenteDestinatario(){
  
    require_once("DetalleSolicitudServiciosModelClass.php");
	
	$remitente_destinatario_id = $_REQUEST['remitente_destinatario_id'];
    $Model = new DetalleSolicitudServiciosModel();
	$data  = $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,$this -> getConex());
	
	if(is_array($data)){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
	  }    
  
  }
  
  protected function getDataPropietario(){
  
  	require_once("DesbloquearRemesasModelClass.php");
	
        $Model      = new DesbloquearRemesasModel();
	$tercero_id = $_REQUEST['tercero_id'];	
	$data       = $Model -> selectDataPropietario($tercero_id,$this -> getConex());
	
	$this -> getArrayJSON($data);
  
  }
  
  protected function getDataClientePropietario(){
  
  	require_once("DesbloquearRemesasModelClass.php");
	
    $Model      = new DesbloquearRemesasModel();
	$cliente_id = $_REQUEST['cliente_id'];	
	$data       = $Model -> selectDataPropietarioCliente($cliente_id,$this -> getConex());
	
	$this -> getArrayJSON($data);   
  
  }
  
  protected function getRemesaComplemento(){
  
  	require_once("DesbloquearRemesasModelClass.php");
    $Model = new DesbloquearRemesasModel();
	
	$numero_remesa = $_REQUEST['numero_remesa'];
	
    $Data =  $Model -> selectRemesaComplemento($numero_remesa,$this -> getConex());
		
	if(count($Data) > 0){
      $this -> getArrayJSON($Data);	
	}else{
        print 'false';
	  }
  
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
			table	=>array('remesa','hoja_de_tiempos'),
			type	=>array('primary_key','column'))
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
	
	$this -> Campos[oficina_desbloquea_id] = array(
		name	=>'oficina_desbloquea_id',
		id	    =>'oficina_desbloquea_id',
		type	=>'hidden',
		value   => $this -> getOficinaId(),
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);			
	
	$this -> Campos[desbloqueada] = array(
		name	=>'desbloqueada',
		id	    =>'desbloqueada',
		type	=>'hidden',
		datatype=>array(type=>'integer'),
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
		id	=>'tipo_remesa_id',
		type	=>'select',
		options	=>array(),
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
		
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
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
			name	=>'cliente',
			setId	=>'cliente_hidden',
			onclick =>'getDataClienteRemitente'
			)
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
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[propietario_mercancia] = array(
		name	=>'propietario_mercancia',
		id	=>'propietario_mercancia',
		type	=>'text',
		size     =>'35',
		
		suggest=>array(
		  name	=>'tercero',
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
	
	$this -> Campos[complemento] = array(
		name	=>'complemento',
		id	    =>'complemento',
		type	=>'select',
		options => array(array(value => 0,text => 'NO',selected => 0),array(value => 1,text => 'SI',selected => 0)),
		
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[control] = array(
		name	=>'control',
		id	    =>'control',
		type	=>'select',
		options => array(array(value => 0,text => 'NO',selected => 0),array(value => 1,text => 'SI',selected => 0)),
		
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
		options  => array(array(value => 'E', text => 'Empresa Transporte',selected => 'E'),array(value => 'R', text => 'Remitente',selected => 'E'),array(value => 'D', text => 'Destinatario',selected => 'E'),array(value => 'N', text => 'No Posee',selected => 'E')),		
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
	
	
	$this -> Campos[origen] = array(
		name	 =>'origen',
		id	     =>'origen',
		type	 =>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_hidden')
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id	=>'origen_hidden',
		type	=>'hidden',
		
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
			name	=>'remitente',
			setId	=>'remitente_hidden',
			onclick =>'setDataRemitente'
		)
	);
	
	$this -> Campos[remitente_id] = array(
		name    =>'remitente_id',
		id	    =>'remitente_hidden',
		type	=>'hidden',
		
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
			name	=>'destinatario',
			setId	=>'destinatario_hidden',
			onclick =>'setDataDestinatario')
	);
	
	$this -> Campos[destinatario_id] = array(
		name	=>'destinatario_id',
		id		=>'destinatario_hidden',
		type	=>'hidden',
		
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

	$this -> Campos[producto] = array(
		name	=>'producto',
		id	=>'producto',
		type	=>'text',
		size	=>'7',
		suggest=>array(
			name	=>'producto',
			setId	=>'producto_hidden',
			onclick	=>'separaCodigoDescripcion')
	);
		
	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id	=>'producto_hidden',
		type	=>'hidden',
		
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		id		=>'descripcion_producto',
		type	=>'text',
		
		size	=>'17',
		maxlength=>'17',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'17'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[naturaleza_id] = array(
		name	=>'naturaleza_id',
		id	=>'naturaleza_id',
		type	=>'select',
		options	=> array(),
				
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
		options	=> array(array(value => 'SI', text => 'SI', selected => 'NO'),array(value => 'NO', text => 'NO', selected => 'NO')),
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
	
	
   
  
    $this -> Campos[hoja_de_tiempos_id] = array(
		name	=>'hoja_de_tiempos_id',
		id	    =>'hoja_de_tiempos_id',
		type	=>'hidden',
		datatype=>array(type =>'autoincrement'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('primary_key'))
	);
	
    $this -> Campos[horas_pactadas_cargue] = array(
		name	=>'horas_pactadas_cargue',
		id	    =>'horas_pactadas_cargue',
		type	=>'text',
		value   => '12',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
    $this -> Campos[fecha_llegada_lugar_cargue] = array(
		name	=>'fecha_llegada_lugar_cargue',
		id	    =>'fecha_llegada_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);
	
    $this -> Campos[hora_llegada_lugar_cargue] = array(
		name	=>'hora_llegada_lugar_cargue',
		id	    =>'hora_llegada_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[fecha_salida_lugar_cargue] = array(
		name	=>'fecha_salida_lugar_cargue',
		id	    =>'fecha_salida_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[hora_salida_lugar_cargue] = array(
		name	=>'hora_salida_lugar_cargue',
		id	    =>'hora_salida_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
			
    $this -> Campos[conductor_cargue] = array(
		name	 =>'conductor_cargue',
		id	     =>'conductor_cargue',
		type	 =>'text',
		size     =>'35',		
		datatype=>array( type =>'text'),
		suggest=>array(
			name	=>'conductor',
			setId	=>'conductor_cargue_hidden'
			)
		
	);		
	
    $this -> Campos[conductor_cargue_id] = array(
		name	=>'conductor_cargue_id',
		id	    =>'conductor_cargue_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);				

    $this -> Campos[entrega] = array(
		name	=>'entrega',
		id	    =>'entrega',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);				
  
    $this -> Campos[cedula_entrega] = array(
		name	=>'cedula_entrega',
		id	    =>'cedula_entrega',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);				  
  
    $this -> Campos[horas_pactadas_descargue] = array(
		name	=>'horas_pactadas_descargue',
		id	    =>'horas_pactadas_descargue',
		type	=>'text',
		value   => '12',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);
	
    $this -> Campos[fecha_llegada_lugar_descargue] = array(
		name	=>'fecha_llegada_lugar_descargue',
		id	    =>'fecha_llegada_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
    $this -> Campos[hora_llegada_lugar_descargue] = array(
		name	=>'hora_llegada_lugar_descargue',
		id	    =>'hora_llegada_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
    $this -> Campos[fecha_salida_lugar_descargue] = array(
		name	=>'fecha_salida_lugar_descargue',
		id	    =>'fecha_salida_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);
	
    $this -> Campos[hora_salida_lugar_descargue] = array(
		name	=>'hora_salida_lugar_descargue',
		id	    =>'hora_salida_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
	
    $this -> Campos[conductor_descargue] = array(
		name	 =>'conductor_descargue',
		id	     =>'conductor_descargue',
		type	 =>'text',
		size     =>'35',		
		datatype=>array( type =>'text'),
		suggest=>array(
			name	=>'conductor',
			setId	=>'conductor_descargue_hidden'
			)
		
	);		
	
    $this -> Campos[conductor_descargue_id] = array(
		name	=>'conductor_descargue_id',
		id	    =>'conductor_descargue_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[recibe] = array(
		name	=>'recibe',
		id	    =>'recibe',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	

	
    $this -> Campos[cedula_recibe] = array(
		name	=>'cedula_recibe',
		id	    =>'cedula_recibe',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[estado] = array(
    name    =>'estado',
    id      =>'estado',
    type    =>'select',
	options =>array(array(value => 'PD', text => 'PENDIENTE', selected => 'PD'),array(value => 'PC', text => 'PROCESANDO', selected => 'PD'), 
	array(value => 'MF', text => 'MANIFESTADO' , selected => 'PD'), array(value=>'AN',text=>'ANULADO',selected=>'PD'),
	array(value => 'LQ', text => 'LIQUIDADA', selected => 'PD'),array(value => 'FT', text => 'FACTURADA', selected => 'PD')),
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('remesa'),
    type=>array('column'))
    );					
	
	
		//ANULACION
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);		
	
	
	$this -> Campos[observacion_anulacion] = array(
		name	=>'observacion_anulacion',
		id		=>'observacion_anulacion',
		type	=>'textarea',
		value	=>'',
		
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
			onsuccess=>'DesbloquearRemesasOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'DesbloquearRemesasOnReset()'
	);
	
	
   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	    displayoptions => array(
                  form        => 0,
                  beforeprint => 'beforePrint',
		  title       => 'Impresion DesbloquearRemesas Carga',
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

$DesbloquearRemesas = new DesbloquearRemesas();

?>