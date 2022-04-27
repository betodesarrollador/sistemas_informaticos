<?php

require_once("../../../framework/clases/ControlerClass.php");

final class AsignarMuelle extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("AsignarMuelleLayoutClass.php");
	require_once("AsignarMuelleModelClass.php");
	
	$Layout = new AsignarMuelleLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new AsignarMuelleModel();
	
	$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    
	$Layout -> SetCampos($this -> Campos);		
	
	//LISTA MENU
	
		$Layout -> setMuelle($Model -> getMuelle ($this -> getConex()));


	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'AsignarMuelle',
	  title		=>'Asignar Muelle',
	  sortname	=>'enturnamiento_id',	  
	  width		=>'auto',
	  height	=>'auto',
	  rowList =>'200,400,600,800',
	  rowNum =>'200',
	  downloadExcel => 'true',
  	  rownumbers => 'true'
	);
	$Cols = array(
	  array(name=>'enturnamiento_id',		index=>'enturnamiento_id',			sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'enturnamiento',		    index=>'enturnamiento',			    sorttype=>'int',	width=>'130',	align=>'center'),
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
	
	$Layout -> SetGridAsignarMuelle($Attributes,$Titles,$Cols,$Model -> getQueryAsignarMuelleGrid());
	
	$Layout -> RenderMain();
    
  }

 function generateFileexcel(){
	 
   //$ruta  = $this -> arrayToExcel("Seg",str_replace($invalidCharacters, '', $data),null,"string");
    require_once("AsignarMuelleModelClass.php");
	
    $Model      	= new AsignarMuelleModel();	
	
	//$invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
	 $nombre = 'AsignarMuelle_mora'.date('Y-m-d');
	
	$data = $Model -> getQueryAsignarMuelleGrid1($this -> getConex()); 
	//$data1 = str_replace($invalidCharacters, '', $data);
    $ruta  = $this -> arrayToExcel($nombre,"Seg",$data,null);
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }

   protected function onclickSave(){
    
  	require_once("AsignarMuelleModelClass.php");
    $Model = new AsignarMuelleModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se asigno correctamente el muelle.');
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
				table	=>array('wms_enturnamiento'),
				type	=>array('column'))
	);

	$this -> Campos[usuario_muelle_id] = array(
		name	=>'usuario_muelle_id',
		id	=>'usuario_muelle_id',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		//size    =>'35',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);	

	$this -> Campos[observacion] = array(
			name	=>'observacion',
			id		=>'observacion',
			type	=>'textarea',
			datatype=>array(
				type	=>'text'),
			transaction=>array(
				table	=>array('wms_enturnamiento'),
				type	=>array('column'))
	);

	$this -> Campos[fecha_actualiza_muelle] = array(
		name	=>'fecha_actualiza_muelle',
		id	=>'fecha_actualiza_muelle',
		type	=>'hidden',
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
				value	=>'Asignar',
				property=>array(
					name	=>'save_ajax',
					onsuccess=>'AsignarMuelleOnSaveOnUpdateonDelete')
		
			);
			
			$this -> SetVarsValidate($this -> Campos);
		}
		
 

}



new AsignarMuelle();

?>