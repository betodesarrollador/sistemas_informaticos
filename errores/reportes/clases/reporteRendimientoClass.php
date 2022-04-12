<?php



ini_set("memory_limit","2048M");



require_once("../../../framework/clases/ControlerClass.php");



final class reporteRendimiento extends Controler{



	public function __construct(){

		parent::__construct(3);	      

	}



  //DEFINICION CAMPOS DE FORMULARIO

	protected function setCampos(){  

		$this -> Campos[fecha_inicio] = array(
			name	=>'fecha_inicio',
			id		=>'fecha_inicio',
			type	=>'text',
			datatype=>array(type=>'date')

		);



		$this -> Campos[fecha_final] = array(
			name	=>'fecha_final',
			id		=>'fecha_final',
			type	=>'text',
			datatype=>array(type=>'date')

		);	

		$this -> Campos[cliente] = array(
			name	=>'cliente',
			id		=>'cliente',
			type	=>'text',
			size    => '40',
			suggest=>array(
				name	=>'desarrollador',
				setId	=>'usuario_id')
		);
		
		$this -> Campos[usuario_id] = array(
			name	=>'usuario_id',
			id		=>'usuario_id',
			type	=>'hidden',
			value	=>'',
			datatype=>array(
				type	=>'integer',
				length	=>'20')
		);	

		
		$this -> Campos[estado] = array(
			name	=>'estado',
			id		=>'estado',
			type	=>'select',
			multiple=>'multiple',
			options	 =>array(array(value => '1',text => 'ACTIVA'),array(value => '0', text => 'INACTIVA')),
			datatype=>array(
				type	=>'integer',
				length	=>'1')
		);		
		

		$this -> Campos[listar] = array(
			name=>'listar',
			id=>'listar',
			type=>'button',
			value=>'Listar',
			onclick => 'Listar(this.form)'
		);

		$this -> Campos[generar] = array(
			name=>'generar',
			id=>'generar',
			type=>'button',
			value=>'Generar Excel',
			onclick => 'Generar(this.form)'
		);

	}


	public function Main(){

		$this -> noCache();

		require_once("reporteRendimientoLayoutClass.php");
		require_once("reporteRendimientoModelClass.php");

		$Layout   = new reporteRendimientoLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new reporteRendimientoModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setCampos($this -> Campos);	



	//LISTA MENU			

		$Layout -> RenderMain(); 

	}



	protected function generateReport(){

		require_once("reporteRendimientoLayoutClass.php");
		require_once("reporteRendimientoModelClass.php");

		$Layout   = new reporteRendimientoLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new reporteRendimientoModel();


		$Layout -> setCssInclude("../../../framework/css/reset.css");	 	 	 
		$Layout -> setCssInclude("../../../framework/css/general.css");	 	 	 	 
		$Layout -> setCssInclude("../../../framework/css/generalDetalle.css");	 	 	 	
		$Layout -> setJsInclude("../../../framework/js/funciones.js");	 	 	 	
		$Layout -> setJsInclude("../js/reporteRendimiento.js");	 	 	 		
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	

		$fecha_inicio  = $this ->  requestData('fecha_inicio');
		$fecha_final   = $this ->  requestData('fecha_final');
		$usuario_id    = $this ->  requestData('usuario_id');
		



		$consul_fecha_inicio 	 = $fecha_inicio != 'NULL' ? " AND DATE(ap.fecha_cierre_real)>= '".$fecha_inicio."'"  : "";
		$consul_fecha_final 	 = $fecha_final != 'NULL'  ? " AND DATE(ap.fecha_cierre_real)<= '".$fecha_final."'"   : "";
		$consul_usuario_id	     = $usuario_id > 0         ? " AND ap.responsable_id = (SELECT u.tercero_id FROM usuario u WHERE u.usuario_id=$usuario_id)"  : "";
		
		
		$data = $Model -> selectInformacion($consul_fecha_inicio,$consul_fecha_final,$consul_usuario_id,$this -> getConex());

		if (count($data)== 0) die("<span style='font-size: 22pt; font-weight: bold; color: red; text-align: center;'>* NO EXISTE REPORTE PARA ESTE FILTRO !! *</span>");
		
		$Layout -> setVar("DATA",$data);			
		$Layout	-> RenderLayout('reporteRendimientoResult.tpl');	

}



protected function viewDocuments(){

	return true;

} 



protected function generateFile(){
	
		require_once("reporteRendimientoLayoutClass.php");

		require_once("reporteRendimientoModelClass.php");


		$Layout   = new reporteRendimientoLayout($this -> getTitleTab(),$this -> getTitleForm());

		$Model    = new reporteRendimientoModel();


		$Layout -> setCssInclude("../../../framework/css/reset.css");	 	 	 

		$Layout -> setCssInclude("../../../framework/css/general.css");	 	 	 	 

		$Layout -> setCssInclude("../../../framework/css/generalDetalle.css");	 	 	 	

		$Layout -> setJsInclude("../../../framework/js/funciones.js");	 	 	 	

		$Layout -> setJsInclude("../js/reporteRendimiento.js");	 	 	 		

		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	

		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());

	    $fecha_inicio  = $this ->  requestData('fecha_inicio');
		$fecha_final   = $this ->  requestData('fecha_final');
		$usuario_id    = $this ->  requestData('usuario_id');
		$cliente_id    = $this ->  requestData('cliente_id');
		/* $estado        = $this ->  requestData('estado');
		$estado        = str_replace(',',"','",$estado); */


		$consul_fecha_inicio 	 = $fecha_inicio != 'NULL' ? " AND DATE(ap.fecha_cierre_real)>= '".$fecha_inicio."'"  : "";

		$consul_fecha_final 	 = $fecha_final != 'NULL'  ? " AND DATE(ap.fecha_cierre_real)<= '".$fecha_final."'"   : "";

		$consul_usuario_id	     = $usuario_id > 0         ? " AND usuario_id = $usuario_id"      	   : "";

		$consul_cliente_id       = $cliente_id > 0         ? " AND l.db LIKE CONCAT( '%',(SELECT c.db FROM clientes_db c WHERE c.cliente_id = $cliente_id), '%' )"                    : ""; 

		/* $consul_estado 	         = $estado != 'NULL'       ? " AND estado IN ('$estado') "             : ""; */
		
		$data = $Model -> selectInformacion($consul_fecha_inicio,$consul_fecha_final,$consul_usuario_id,$consul_cliente_id,$this -> getConex());	

	    $Layout -> setVar("DATA",$data);	

		$Layout -> exportToExcel('reporteRendimientoResult.tpl');

}



}



new reporteRendimiento();



?>