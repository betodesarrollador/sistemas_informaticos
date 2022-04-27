<?php

require_once("../../../framework/clases/ControlerClass.php");

final class AsignarTurnoSalida extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("AsignarTurnoSalidaLayoutClass.php");
	require_once("AsignarTurnoSalidaModelClass.php");
	
	$Layout = new AsignarTurnoSalidaLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new AsignarTurnoSalidaModel();
	
	$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    
	$Layout -> SetCampos($this -> Campos);		
	
	//LISTA MENU
	
		
		$Layout -> setMuelle($Model -> getMuelle ($this -> getConex()));


	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'AsignarTurnoSalida',
	  title		=>'Asignar Turno',
	  sortname	=>'alistamiento_salida_id',	  
	  width		=>'auto',
	  height	=>'400',
	  rowList =>'200,400,600,800',
	  rowNum =>'200',
	  downloadExcel => 'true',
  	  rownumbers => 'true'
	);
	$Cols = array(
	  array(name=>'alistamiento_salida_id',		index=>'alistamiento_salida_id',    	sorttype=>'int',	width=>'50',	align=>'center'),
	  array(name=>'alistamiento_salida_id1',	index=>'alistamiento_salida_id1',    	sorttype=>'int',	width=>'120',	align=>'center'),
	  array(name=>'alistamiento_salida_id2',	index=>'alistamiento_salida_id2',    	sorttype=>'int',	width=>'120',	align=>'center'),
	  array(name=>'fecha',		                index=>'fecha',			                sorttype=>'int',	width=>'150',	align=>'center'),	 	  
	  array(name=>'estado',				        index=>'estado',					    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'turno',					    index=>'turno',					        sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'muelle',				        index=>'muelle',				        sorttype=>'text',	width=>'180',	align=>'left'),	 		
	  array(name=>'fecha_registro',			    index=>'fecha_registro',			    sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'usuario_id',	                index=>'usuario_id',		            sorttype=>'text',	width=>'60',	align=>'center'),
	  array(name=>'fecha_actualiza',		    index=>'fecha_actualiza',			    sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'usuario_actualiza_id',		index=>'usuario_actualiza_id',			sorttype=>'text',	width=>'60',	align=>'left'),
	  array(name=>'observacion',			    index=>'observacion',				    sorttype=>'text',	width=>'200',	align=>'left'),
	  array(name=>'observacion_muelle',			index=>'observacion_muelle',		    sorttype=>'text',	width=>'200',	align=>'left')
	   
	);
	$Titles = array('N° ALISTAMIENTO',
		            '<span style="font-size: 12px;">OPCION 1</span>',
	                '<span style="font-size: 12px;">OPCION 2</span>',
					'FECHA',
					'ESTADO',
					'TURNO',
					'MUELLE', 
					'FECHA REGISTRO',
					'USUARIO',
					'FECHA ACTUALIZA',
					'USUARIO ACTUALIZA',
					'OBSERVACION ASIGNA TURNO',
					'OBSERVACION ASIGNA MUELLE'				
	);
	
	$Layout -> SetGridAsignarTurnoSalida($Attributes,$Titles,$Cols,$Model -> getQueryAsignarTurnoSalidaGrid($this -> getConex()));
	
	$Layout -> RenderMain();
    
  }

 function generateFileexcel(){
	 
   //$ruta  = $this -> arrayToExcel("Seg",str_replace($invalidCharacters, '', $data),null,"string");
    require_once("AsignarTurnoSalidaModelClass.php");
	
    $Model      	= new AsignarTurnoSalidaModel();	
	
	//$invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
	 $nombre = 'AsignarTurnoSalida_mora'.date('Y-m-d');
	
	$data = $Model -> getQueryAsignarTurnoSalidaGrid($this -> getConex()); 
	//$data1 = str_replace($invalidCharacters, '', $data);
    $ruta  = $this -> arrayToExcel($nombre,"Seg",$data,null);
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }

   protected function onclickSave(){
    
  	require_once("AsignarTurnoSalidaModelClass.php");
	$Model = new AsignarTurnoSalidaModel();
	
	$alistamiento_salida_id = $_REQUEST['alistamiento_salida_id'];
	$alistamiento_salida_id1 = $_REQUEST['alistamiento_salida_id1'];
	$turno = $_REQUEST['turno'];
	$muelle_id = $_REQUEST['muelle_id'];
	$observacion = $_REQUEST['observacion'];
	$observacion_muelle = $_REQUEST['observacion_muelle'];
	$usuario_id = $_REQUEST['usuario_id'];
    
    $Model -> Save($alistamiento_salida_id,$alistamiento_salida_id1,$turno,$observacion,$observacion_muelle,$muelle_id,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Asignacion Exitosa.');
	 }
	
  }


  /////// CAMPOS //////////
  
  function SetCampos(){
	  
	$this -> Campos[alistamiento_salida_id] = array(
		  	name	=>'alistamiento_salida_id',
			id		=>'alistamiento_salida_id',
			type	=>'text',
			disabled=>'yes',
			datatype=>array(
				type	=>'integer')
	);

	$this -> Campos[alistamiento_salida_id1] = array(
		  	name	=>'alistamiento_salida_id1',
			id		=>'alistamiento_salida_id1',
			type	=>'text',
			disabled=>'yes',
			datatype=>array(
				type	=>'integer')
	);

	$this -> Campos[turno] = array(
		    name	=>'turno',
			id		=>'turno',
			type	=>'text',
			required=>'yes',
			disabled=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'3'),
				transaction=>array(
				table	=>array('wms_alistamiento_salida'),
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
				table	=>array('wms_alistamiento_salida'),
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
			table	=>array('wms_alistamiento_salida'),
			type	=>array('column'))
	);	

    $this -> Campos[observacion] = array(
			name	=>'observacion',
			id		=>'observacion',
			type	=>'textarea',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('wms_alistamiento_salida'),
				type	=>array('column'))
	);

	$this -> Campos[observacion_muelle] = array(
			name	=>'observacion_muelle',
			id		=>'observacion_muelle',
			type	=>'textarea',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('wms_alistamiento_salida'),
				type	=>array('column'))
	);

	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	=>'fecha_actualiza',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_alistamiento_salida'),
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
				value	=>'Asignar',
				property=>array(
					name	=>'save_ajax',
					onsuccess=>'AsignarTurnoSalidaOnSaveOnUpdateonDelete')
		
			);
			
			$this -> SetVarsValidate($this -> Campos);
		}
		
 

}



new AsignarTurnoSalida();

?>