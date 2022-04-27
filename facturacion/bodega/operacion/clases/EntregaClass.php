<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Entrega extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("EntregaLayoutClass.php");
	require_once("EntregaModelClass.php");
	
	$Layout = new EntregaLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new EntregaModel();
	
	$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    
	$Layout -> SetCampos($this -> Campos);		
	
	//LISTA MENU
	
		
		$Layout -> setMuelle($Model -> getMuelle ($this -> getConex()));


	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'Entrega',
	  title		=>'Despachos Para Entrega',
	  sortname	=>'turno',	  
	  width		=>'auto',
	  height	=>'400',
	  rowList =>'200,400,600,800',
	  rowNum =>'200',
	  downloadExcel => 'true',
  	  rownumbers => 'true'
	);
	$Cols = array(
	  array(name=>'despacho_id',		        index=>'despacho_id',    	sorttype=>'int',	width=>'70',	align=>'center'),
	  array(name=>'despacho_id1',	            index=>'despacho_id1',    	sorttype=>'int',	width=>'140',	align=>'center'),
	  array(name=>'turno',					    index=>'turno',					        sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'fecha',		                index=>'fecha',			                sorttype=>'int',	width=>'150',	align=>'center'),	 	  
	  array(name=>'estado',				        index=>'estado',					    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'muelle',				        index=>'muelle',				        sorttype=>'text',	width=>'180',	align=>'left'),	 		
	  array(name=>'fecha_registro',			    index=>'fecha_registro',			    sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'usuario_id',	                index=>'usuario_id',		            sorttype=>'text',	width=>'60',	align=>'center'),
	  array(name=>'fecha_actualiza',		    index=>'fecha_actualiza',			    sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'usuario_actualiza_id',		index=>'usuario_actualiza_id',			sorttype=>'text',	width=>'60',	align=>'left')
	   
	);
	$Titles = array('N° DESPACHO',
					'<span style="font-size: 12px;">OPCION</span>',
					'TURNO',
					'FECHA',
					'ESTADO',
					'MUELLE', 
					'FECHA REGISTRO',
					'USUARIO',
					'FECHA ACTUALIZA',
					'USUARIO ACTUALIZA',		
	);
	
	$Layout -> SetGridEntrega($Attributes,$Titles,$Cols,$Model -> getQueryEntregaGrid());
	
	$Layout -> RenderMain();
    
  }

 function generateFileexcel(){
	 
   //$ruta  = $this -> arrayToExcel("Seg",str_replace($invalidCharacters, '', $data),null,"string");
    require_once("EntregaModelClass.php");
	
    $Model      	= new EntregaModel();	
	
	//$invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
	 $nombre = 'Entregas'.date('Y-m-d');
	
	$data = $Model -> getQueryEntregaGrid($this -> getConex()); 
    $ruta  = $this -> arrayToExcel($nombre,"Seg",$data,null);
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }

   protected function onclickSave(){
    
  	require_once("EntregaModelClass.php");
	$Model = new EntregaModel();
	
	$despacho_id = $_REQUEST['despacho_id'];
	$despacho_id1 = $_REQUEST['despacho_id1'];
	$fecha_entrega = $_REQUEST['fecha_entrega'];
	$observacion_entrega = $_REQUEST['observacion_entrega'];
	$usuario_id = $_REQUEST['usuario_id'];
    
    $Model -> Save($despacho_id,$despacho_id1,$fecha_entrega,$observacion_entrega,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Entrega Exitosa.');
	 }
	
  }


  /////// CAMPOS //////////
  
  function SetCampos(){
	  
	$this -> Campos[despacho_id] = array(
		  	name	=>'despacho_id',
			id		=>'despacho_id',
			type	=>'text',
			disabled=>'yes',
			datatype=>array(
				type	=>'integer')
	);

	$this -> Campos[despacho_id1] = array(
		  	name	=>'despacho_id1',
			id		=>'despacho_id1',
			type	=>'text',
			disabled=>'yes',
			datatype=>array(
				type	=>'integer')
	);

	$this -> Campos[fecha_entrega] = array(
			name	=>'fecha_entrega',
			id		=>'fecha_entrega',
			type	=>'text',
			size 	=>'22',
			value 	=>date('Y-m-d H:i:s'),
			Boostrap=>'si',
			datatype=>array(type=>'text'),
			transaction=>array(
				table	=>array('wms_despacho'),
				type	=>array('column'))
		);

	$this -> Campos[muelle_id] = array(
		  name	=>'muelle_id',
			id		=>'muelle_id',
			type	=>'select',
			options	=>null,
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'1'),
				transaction=>array(
				table	=>array('wms_despacho'),
				type	=>array('column'))
	);

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	=>'usuario_id',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		//size    =>'35',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('wms_despacho'),
			type	=>array('column'))
	);	

    $this -> Campos[observacion_entrega] = array(
			name	=>'observacion_entrega',
			id		=>'observacion_entrega',
			type	=>'textarea',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('wms_despacho'),
				type	=>array('column'))
	);


	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	=>'fecha_actualiza',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_despacho'),
			type	=>array('column'))
	);	

		/////////* BOTONES  */////////
			
			$this -> Campos[generar_excel] = array(
				name   =>'generar_excel',
				id   =>'generar_excel',
				type   =>'button',
				value   =>'Descargar Excel Sin Formato'
			);
			
			$this -> Campos[guardar] = array(
				name	=>'guardar',
				id		=>'guardar',
				type	=>'button',
				value	=>'Finalizar Entrega',
				property=>array(
					name	=>'save_ajax',
					onsuccess=>'EntregaOnSaveOnUpdateonDelete')
		
			);
			
			$this -> SetVarsValidate($this -> Campos);
		}
		
 

}



new Entrega();

?>