<?php

require_once("../../../framework/clases/ControlerClass.php");

final class InscripcionCuentas extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("InscripcionCuentasLayoutClass.php");
	require_once("InscripcionCuentasModelClass.php");
	
	$Layout   = new InscripcionCuentasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new InscripcionCuentasModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	

	//// GRID ////
	$Attributes = array(
	  id		=>'terceros',
	  title		=>'Listado de Proveedores',
	  sortname	=>'numcuenta_proveedor',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'nombre_proveedor',		index=>'nombre_proveedor',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'150',	align=>'center'),
	  array(name=>'numcuenta_proveedor',	index=>'numcuenta_proveedor',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'tip_cuenta',				index=>'tip_cuenta',			sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'titular_cuenta',			index=>'titular_cuenta',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'banco',					index=>'banco',					sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'documento_titular',		index=>'documento_titular',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',sorttype=>'text',	width=>'150',	align=>'center'),
	  
	  
	  
	  
	  
	
	);
	  
    $Titles = array('NOMBRE PROVEEDOR',
					'DOCUMENTO PROVEEDOR',
					'NUMERO DE CUENTA',
					'TIPO CUENTA',
					'NOMBRE TITULAR',
					'BANCO',
					'DOCUMENTO TITULAR',
					'TIPO DE DOCUMENTO'
					
	);
	
	$Layout -> SetGridProveedores($Attributes,$Titles,$Cols,$Model -> GetQueryProveedoresGrid());
	
	$Layout -> RenderMain();
  
  }

protected function generateFile(){
	require_once("InscripcionCuentasModelClass.php");
	
    $Model     = new InscripcionCuentasModel();	
 
	$data  = $Model -> GetReporteCuentas($this -> getConex());	
		
    $ruta  = $this -> arrayToExcel("InscripcionCuentas","Inscripcion Cuentas ",$data,null,"string");
	$this -> ForceDownload($ruta);
	
	$actualizacion  = $Model -> updateInscripcion($this -> getConex());	
}



  protected function SetCampos(){
  
	
	 	  
	/**********************************
 	             Botones
	**********************************/
	 
   
	$this -> Campos[descargar] = array(
    name   =>'descargar',
    id   =>'descargar',
    type   =>'button',
    value   =>'Descargar Excel',
	onclick =>'descargarexcel()'
    );

     $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
 	onclick =>'beforePrint(this.form)'
    );
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$InscripcionCuentas = new InscripcionCuentas();

?>