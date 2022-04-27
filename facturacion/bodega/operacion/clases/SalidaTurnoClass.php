<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SalidaTurno extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	require_once("SalidaTurnoLayoutClass.php");
	require_once("SalidaTurnoModelClass.php");
	
	$Layout = new SalidaTurnoLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new SalidaTurnoModel();
	
	$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    
	$Layout -> SetCampos($this -> Campos);		
	
	//LISTA MENU
	
		//$Layout -> setMuelle($Model -> getMuelle ($this -> getConex()));


	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'SalidaTurno',
	  title		=>'Asignar Muelle',
	  sortname	=>'enturnamiento_id', 
	  sortorder=>'DESC',
	  width		=>'auto',
	  height	=>'auto',
	  rowList =>'200,400,600,800',
	  rowNum =>'200',
	  downloadExcel => 'true',
  	  rownumbers => 'true'
	);
	$Cols = array(
	  array(name=>'enturnamiento_id',		index=>'enturnamiento_id',			sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'enturnamiento',		index=>'enturnamiento',			        sorttype=>'int',	width=>'150',	align=>'center'),
	  array(name=>'wms_vehiculo_id',		index=>'wms_vehiculo_id',			sorttype=>'int',	width=>'70',	align=>'center'),	 	  
	  array(name=>'muelle_id',				index=>'muelle_id',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',					index=>'estado',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'usuario_id',				index=>'usuario_id',				sorttype=>'text',	width=>'180',	align=>'left'),	 		
	  array(name=>'fecha_registro',			index=>'fecha_registro',			sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'usuario_actualiza_id',	index=>'usuario_actualiza_id',		sorttype=>'text',	width=>'180',	align=>'left'),
	  array(name=>'fecha_actualiza',		index=>'fecha_actualiza',			sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'usuario_salida_id',		index=>'usuario_salida_id',			sorttype=>'text',	width=>'180',	align=>'left'),
	  array(name=>'fecha_salida_turno',		index=>'fecha_salida_turno',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'usuario_muelle_id',		index=>'usuario_muelle_id',			sorttype=>'text',	width=>'180',	align=>'left'),
	  array(name=>'fecha_actualiza_muelle',	index=>'fecha_actualiza_muelle',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'observacion',			index=>'observacion',				sorttype=>'text',	width=>'200',	align=>'left')
	   
	);
	$Titles = array('<span style="font-size: 9px;">ENTURNAMIENTO</span>',
	                'OPCION',
					'VEHICULO',
					'MUELLE',
					'ESTADO',
					'USUARIO', 
					'FECHA REGISTRO',
					'USUARIO ACTUALIZA',
					'FECHA ACTUALIZA',
					'USUARIO SALIDA',
					'FECHA SALIDA',
					'USUARIO ASIGNA MUELLE',
					'FECHA ASIGNA MUELLE',
					'OBSERVACION ASIGNA MUELLE'
					
					
	);
	
	$Layout -> SetGridSalidaTurno($Attributes,$Titles,$Cols,$Model -> getQuerySalidaTurnoGrid());
	
	$Layout -> RenderMain();
    
  }

 function generateFileexcel(){
	 
   //$ruta  = $this -> arrayToExcel("Seg",str_replace($invalidCharacters, '', $data),null,"string");
    require_once("SalidaTurnoModelClass.php");
	
    $Model      	= new SalidaTurnoModel();	
	
	//$invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
	 $nombre = 'SalidaTurno_mora'.date('Y-m-d');
	
	$data = $Model -> getQuerySalidaTurnoGrid1($this -> getConex()); 
	//$data1 = str_replace($invalidCharacters, '', $data);
    $ruta  = $this -> arrayToExcel($nombre,"Seg",$data,null);
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }

   protected function onclickSave(){
    
  	require_once("SalidaTurnoModelClass.php");
    $Model = new SalidaTurnoModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se Finalizo correctamente el turno.');
	 }
	
  }


  /////// CAMPOS //////////
  
  function SetCampos(){
	  
	$this -> Campos[enturnamiento_id] = array(
		  	name	=>'enturnamiento_id',
			id		=>'enturnamiento_id',
			type	=>'text',
			disabled=>'yes',
			datatype=>array(
				type	=>'integer'),
				transaction=>array(
				table	=>array('wms_enturnamiento'),
				type	=>array('primary_key'))
	);

	$this -> Campos[fecha_salida_turno] = array(
		name	=>'fecha_salida_turno',
		id	=>'fecha_salida_turno',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);

	$this -> Campos[usuario_salida_id] = array(
		name	=>'usuario_salida_id',
		id	=>'usuario_salida_id',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		//size    =>'35',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);	

	$this -> Campos[observacion_salida] = array(
			name	=>'observacion_salida',
			id		=>'observacion_salida',
			type	=>'textarea',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('wms_enturnamiento'),
				type	=>array('column'))
	);

	$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'hidden',
			value =>'F',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('wms_enturnamiento'),
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
				value	=>'Salida',
				property=>array(
					name	=>'save_ajax',
					onsuccess=>'SalidaTurnoOnSaveOnUpdateonDelete')
		
			);
			
			$this -> SetVarsValidate($this -> Campos);
		}
		
 

}



new SalidaTurno();

?>