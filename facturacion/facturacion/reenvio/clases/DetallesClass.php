<?php

require_once("../../../framework/clases/ControlerClass.php");
final class Detalles extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");
		
	$Layout                 = new DetallesLayout();
    $Model                  = new DetallesModel();	
    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	
	
	if($si_cliente==1){
		$cliente= " AND  f.cliente_id=$cliente_id ";
	}else{
		$cliente= " ";
	}

	if($tipo=='SR'){
		$tipo_c= " AND  f.acuse=0 ";

	}else if($tipo=='SA'){
		$tipo_c= " AND  f.cufe IS NULL ";

	}else if($tipo=='CR'){
		$tipo_c= " AND  f.acuse=1 ";

	}else if($tipo=='CA'){
		$tipo_c= " AND  f.cufe IS NOT NULL ";

	}else{
		$tipo_c= "  ";
	}

    $Layout -> setIncludes();
	$Layout -> setReporteRF($Model -> getReporteRF($oficina_id,$desde,$hasta,$cliente,$tipo_c,$this -> getConex()));
	
	if($_REQUEST['download'] == 'true'){
	    $Layout -> exportToExcel('detalles.tpl'); 		
	}else{	
		  $Layout -> RenderMain();
	  }

    
  }


  protected function OnclickReportar(){

  	require_once("../../factura/clases/FacturaModelClass.php");
    $Model = new FacturaModel();

	require_once("../../factura/clases/ProcesarVP.php");
	$FacturaElec = new FacturaElectronica();

    require_once("DetallesModelClass.php");
    $Model1                  = new DetallesModel();	
		 
	$tokens=$Model -> getTokens($this -> getConex());
	
	$factura_id 	= $_REQUEST['factura_id'];
	$data_fac=$Model -> getDataFactura_total($factura_id,$this -> getConex());
	$deta_fac=$Model -> getDataFactura_detalle($factura_id,$this -> getConex());
	$deta_puc=$Model -> getDataFactura_puc($factura_id,$this -> getConex());
	$deta_obli=$Model -> getDataFactura_Obligaciones($factura_id,$this -> getConex());
	$deta_puc_con=$Model -> getDataFactura_puc_con($factura_id,$this -> getConex());

	$factura=$data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];
	$factura_validacion=$data_fac[0]['consecutivo_factura'].'_'.$data_fac[0]['factura_id'];
    
	//$factura='TEMF'.$data_fac[0]['consecutivo_factura'];

	if($data_fac[0]['reportada']==0 && ($data_fac[0]['fecha_envio']=='' || $data_fac[0]['fecha_envio']==NULL)){ exit("La Factura ".$data_fac[0]['consecutivo_factura'].", no se ha reportado previamente."); }
	if($tokens[0]['tokenenterprise']=='' || $tokens[0]['tokenenterprise']== NULL || $tokens[0]['tokenautorizacion']=='' || $tokens[0]['tokenautorizacion']== NULL){ exit("No se han parametrizado correctamente los tokens, por favor realice este proceso en el formulario Parametros Facturacion Electronica"); }
	$resultado = $FacturaElec -> sendFactura(6,'',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);
	
	$resultado1 = $FacturaElec -> sendFactura(2,'',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);
	$resultado2 = $FacturaElec -> sendFactura(3,'',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);	
	$mensaje_com="";
	if($resultado1["codigo"]==200){ 
		$mensaje_com.="<br> Pdf Descargado!!"; 
		$Model1 -> ActualizarPDF($factura_id,$factura_validacion.'.pdf',$this -> getConex());
	}else{ 
		$mensaje_com.="<br> No se pudo Descargar Pdf!!"; 
	}
	if($resultado2["codigo"]==200){ 
		$mensaje_com.="<br> XML Descargado!!"; 
		$Model1 -> ActualizarXML($factura_id,$factura.'.xml',$this -> getConex());
		
	}else{ 
		$mensaje_com.="<br> No se pudo Descargar XML!!"; 
	}
	//print_r(var_export($resultado,true));
	if($resultado["codigo"]==200){ 
		$acuseEstatus = is_numeric($resultado["acuseEstatus"]) ? $resultado["acuseEstatus"] : '0';
		$acuseRespuesta = is_numeric($resultado["acuseRespuesta"]) ? $resultado["acuseRespuesta"] : '0';
		$cufe = $resultado["cufe"] ? $resultado["cufe"] : '';

		if($resultado["esValidoDIAN"]=="true" || $resultado["esValidoDIAN"]==true){
            $esValidoDIAN = "exitosa";
		}else{
            $esValidoDIAN = "";
		}

		$Model -> setEstadoFactura($factura_id,$acuseEstatus,date("Y-m-d H:i:s"),$acuseRespuesta,$cufe,$esValidoDIAN,$resultado["acuseComentario"],$this -> getConex());
		if($resultado["acuseRespuesta"]==0){
			$acuse_respuestas="A la espera";
		}elseif($resultado["acuseRespuesta"]==1){
			$acuse_respuestas="Aceptada";
		}elseif($resultado["acuseRespuesta"]==2){
			$acuse_respuestas="Rechazada";
		}elseif($resultado["acuseRespuesta"]==3){
			$acuse_respuestas="En Verificaci&oacute;n";
			
		}
		exit("La factura esta en Estado ".$acuse_respuestas."!!!<br> Comentario: ".$resultado["acuseComentario"]." ".$mensaje_com);
	}else{
		print_r(var_export($resultado,true));
		//$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
		exit();
	}
	 
  }


  protected function OnclickReenviar(){

  	require_once("../../factura/clases/FacturaModelClass.php");
    $Model = new FacturaModel();
	//require_once("../../factura/clases/procesar.php");
	$tokens=$Model -> getTokens($this -> getConex());
	
	require_once("../../factura/clases/ProcesarVP.php");
    $FacturaElec = new FacturaElectronica();	 
    require_once("DetallesModelClass.php");
    $Model1                  = new DetallesModel();	
  	
	$factura_id 	= $_REQUEST['factura_id'];
	$data_fac=$Model -> getDataFactura_total($factura_id,$this -> getConex());
	$deta_fac=$Model -> getDataFactura_detalle($factura_id,$this -> getConex());
	$deta_puc=$Model -> getDataFactura_puc($factura_id,$this -> getConex());
	$deta_obli=$Model -> getDataFactura_Obligaciones($factura_id,$this -> getConex());
	$deta_puc_con=$Model -> getDataFactura_puc_con($factura_id,$this -> getConex());

	$factura=$data_fac[0]['prefijo'].$data_fac[0]['consecutivo_factura'];

	$resultado1 = $FacturaElec -> sendFactura(5,'',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);
	if($resultado1["codigo"]==200){ 
		//inicio bloque factura anexo representacion grafica
		require_once("../../factura/clases/Imp_FacturaAdjuntoClass.php");		
		$print = new Imp_FacturaAdjunto();
		$print -> printOutPDF($this -> getConex(),$data_fac[0]['consecutivo_factura'].'_'.$data_fac[0]['factura_id']);	
		$resultado = $FacturaElec -> sendFactura(11,'FT',$tokens,$data_fac,$deta_fac,$deta_puc,'','',$deta_obli,$deta_puc_con);		
		//fin bloque factura anexo representacion grafica
		exit($resultado1["mensaje"]."!!!");
	}else{
		print_r(var_export($resultado,true));
		//$Model -> setMensajeNOFactura($factura_id,date("Y-m-d H:i"),$resultado["codigo"].'-'.$resultado["resultado"].'-'.$resultado["mensaje"],$this -> getConex());
		exit();
	}
	 
  }

}

$Detalles = new Detalles();

?>