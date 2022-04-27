<?php

require_once("../../../framework/clases/ControlerClass.php");
require_once("../../../framework/clases/MailClass.php");

final class Reportes extends Controler{

  public function __construct(){
    
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("ReportesLayoutClass.php");
	require_once("ReportesModelClass.php");
	
	$Layout = new ReportesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ReportesModel();
    $data	= $Model -> setDetalles($this -> getConex());
	$html	= '';
	$comodin= 0;
	$con_reg= 0;
	
	foreach($data as $details){

		$html	= '';
		$comodin= 0;
		$con_reg= 0;

		if($details[minuto]=='UV' && date('i')=='00'){
		    $fecha_reg = date('Y-m-d');
			$desde=(date('H')-1).':00:00';
			$hasta=date('H').':00:00';
			
			if((date('H')-1)<0){
				$calculo = strtotime("-1 days");
				$fecha_reg = date('Y-m-d',$calculo);
				$desde='23:00:00';
				$hasta='23:59:00';
			
			}
			$con_reg=1;
			
		}elseif($details[minuto]=='CQ' && (date('i')=='00' || date('i')=='15' || date('i')=='30' || date('i')=='45')){

		    $fecha_reg = date('Y-m-d');
			$desde = strtotime ( '-15 minute' , strtotime ( date('H:i').':00' ) ) ;
			$desde = date ( 'H:i:s' , $desde );
			$hasta=date('H:i').':00';
			
			if((date('H')-1)<0){
				$calculo = strtotime("-1 days");
				$fecha_reg = date('Y-m-d',$calculo);
				$desde='23:45:00';
				$hasta='23:59:00';
			
			}
			$con_reg=1;			

		}elseif($details[minuto]=='CT' && (date('i')=='00' || date('i')=='30')){
																	
		    $fecha_reg = date('Y-m-d');
			$desde = strtotime ( '-30 minute' , strtotime ( date('H:i').':00' ) ) ;
			$desde = date ( 'H:i:s' , $desde );
			$hasta=date('H:i').':00';
			
			if((date('H')-1)<0){
				$calculo = strtotime("-1 days");
				$fecha_reg = date('Y-m-d',$calculo);
				$desde='23:30:00';
				$hasta='23:59:00';
			
			}
			$con_reg=1;
																										  
	  	}
		
		$return =$Model -> comprobar_archivo($details[cliente_id],$fecha_reg,$hasta,$desde,$this -> getConex());
		
		if($con_reg==1 && (!$return[0][reporte_historial_nov_id]>0)){ 
		
			$correos_cliente = $Model -> getcorreos_cliente($details[cliente_id],$this -> getConex());	
			$registros_rem = $Model -> getRegistros_rem($details[cliente_id],$fecha_reg,$desde,$hasta,$this -> getConex());	
			
			
		foreach($registros_rem as $registers_rem){	
		
		$rem_id = $registers_rem[remesa_id];
			
			$html.='<table border="1" cellspacing="1" cellpadding="1">';
				$html.='<tr><td colspan="5">&nbsp;</td> </tr>';	
				$html.='<tr><td colspan="2"><b>CLIENTE</b></td><td colspan="3">'.$registers_rem[cliente].' </td></tr>';
				$html.='<tr><td colspan="2"><b>REMESA</b></td><td colspan="3">'.$registers_rem[numero_remesa].' </td></tr>';	
				$html.='<tr><td colspan="2"><b>REMISION CLIENTE</b></td><td colspan="3">'.$registers_rem[orden_despacho].' </td></tr>';	
				$html.='<tr><td colspan="2"><b>ORIGEN</b></td><td colspan="3">'.$registers_rem[origen].' </td></tr>';	
				$html.='<tr><td colspan="2"><b>DESTINO</b></td><td colspan="3">'.$registers_rem[destino].' </td></tr>';
				
				$html.='<tr><td><b>CUIDAD</b></td><td><b>FECHA</b></td><td><b>HORA</b></td><td><b>NOVEDAD</b></td><td><b>OBSERVACION</b></td></tr>';
				
				
				$registros_man = $Model -> getRegistros_man($details[cliente_id],$fecha_reg,$desde,$hasta,$rem_id,$this -> getConex());	
					
				foreach($registros_man as $registers_man){				
					$html.='<tr><td>'.$registers_man[punto_referencia].'</td><td>'.$registers_man[fecha_reporte].'</td><td>'.$registers_man[hora_reporte].'</td><td>'.$registers_man[novedad].'</td><td>'.$registers_man[obser_deta].'</td></tr>';	
					$comodin=1;
				}
				$html.='<tr><td colspan="5">&nbsp;</td></tr>';	
				
				
				
				$registros_des = $Model -> getRegistros_des($details[cliente_id],$fecha_reg,$desde,$hasta,$this -> getConex());	
			
				foreach($registros_des as $registers_des){				
					$html.='<tr><td>'.$registers_des[punto_referencia].'</td><td>'.$registers_des[fecha_reporte].'</td><td>'.$registers_des[hora_reporte].'</td><td>'.$registers_des[novedad].'</td><td>'.$registers_des[obser_deta].'</td></tr>';	
					$comodin=1;
				}
	
				$html.='<tr><td colspan="5">&nbsp;</td></tr>';	
				
				$registros_seg = $Model -> getRegistros_seg($details[cliente_id],$fecha_reg,$desde,$hasta,$this -> getConex());	
			
				foreach($registros_seg as $registers_seg){				
					$html.='<tr><td>'.$registers_seg[punto_referencia].'</td><td>'.$registers_seg[fecha_reporte].'</td><td>'.$registers_seg[hora_reporte].'</td><td>'.$registers_seg[novedad].'</td><td>'.$registers_seg[obser_deta].'</td></tr>';		
					$comodin=1;
				}
	
			$html.='</table>';		
			
		}
			$scarpeta="../../../archivos/seguimiento"; 
			$sarchivo=$details[cliente_id]."_".date('Y_m_d_H_i')."_".rand(10,99).".xls";
			$sfile=$scarpeta."/".$sarchivo; 
			$fp=fopen($sfile,"w");
			fwrite($fp,$html);
			fclose($fp);
			$fecha_registro= date('Y-m-d H:i:s');

			
			if($comodin==1){
				$mail_subject='<strong> Novedades '.$fecha_reg.' '.$desde.' - '.$hasta.'</strong>';
			$mensaje='Registro de Novedades Fecha '.$fecha_reg;
			$mensaje.='En el archivo adjunto podra encontrar la información de su mercancia: <br /> Numero de remesa con la que se despacha<br />';
			$mensaje.='Origen y destino de la mercancia<br />';
			$mensaje.='Ciudad, fecha, hora y las novedades que tiene el vehiculo durante su recorrido<br />';
			$mensaje.='Asi como las observaciones que se presenten<br />';
				foreach($correos_cliente as $correos_clients){
					$enviar_mail=new Mail();
					//$enviado = $enviar_mail->sendMail(trim($correos_clients[correo]),$mail_subject,$mensaje,'../../../archivos/seguimiento/'.$return[0][archivo],$return[0][archivo]);
					$enviado = $enviar_mail->sendMail(trim($correos_clients[correo]),$mail_subject,$mensaje,$sfile,$sarchivo);
				}
			}else{
				
				$mail_subject='No existe Novedades '.$fecha_reg.' '.$desde.' - '.$hasta;
				$mensaje='No existe Registro de Novedades Fecha'.$fecha_reg.'  Rango de horarios:'.$desde.' - '.$hasta;
				foreach($correos_cliente as $correos_clients){
					$enviar_mail=new Mail();				  
					$enviado = $enviar_mail->sendMail(trim($correos_clients[correo]),$mail_subject,$mensaje);
				}
			}
			$enviado=$enviado==true ? $enviado=1:$enviado=0;
			$return =$Model -> Save($details[cliente_id],$details[minuto],$details[horas],$details[dias],$fecha_reg,$hasta,$fecha_registro,$sarchivo,$comodin,$enviado,$this -> getConex());
		}
	}
    $Layout -> setIncludes();
	
	
	
   
	//// GRID ////
	$Attributes = array(
	  id		=>'Reportes',
	  title		=>'Reportes Por Enviar',
	  sortname	=>'hora',
	  width		=>'1020',
	  height	=>380
	);
	$Cols = array(
	  array(name=>'fecha',			index=>'fecha',			sorttype=>'text',	width=>'70',	align=>'center'),
	  array(name=>'hora',			index=>'hora',			sorttype=>'text',	width=>'60',	align=>'center'),
	  array(name=>'cliente',		index=>'cliente',		sorttype=>'text',	width=>'320',	align=>'left'),
	  array(name=>'minuto',			index=>'minuto',		sorttype=>'text',	width=>'160',	align=>'center'),
      array(name=>'horas',			index=>'horas',			sorttype=>'text',	width=>'120',	align=>'center'),
      array(name=>'dias',			index=>'dias',			sorttype=>'text',	width=>'120',	align=>'center'),	  
      array(name=>'archivo',		index=>'archivo',		sorttype=>'text',	width=>'60',	align=>'center'),	  
      array(name=>'enviar',			index=>'enviar',		sorttype=>'text',	width=>'60',	align=>'center')	  
	);
    $Titles = array('FECHA',
					'HORA',
					'CLIENTE',
					'MINUTO',
					'HORAS',
					'DIAS',
					'ARCHIVO',
					'ENVIAR'
	);
	$Layout -> SetGridReportes($Attributes,$Titles,$Cols,$Model -> getQueryReportesGrid());
	$Layout -> RenderMain();
    
  }
  

  protected function onclickCrear(){
    
    require_once("ReportesModelClass.php");
	
    $Model  = new ReportesModel();
	$cliente_id=$_REQUEST['cliente_id'];
	$fecha_reg=$_REQUEST['fecha_reg'];
	$desde=$_REQUEST['desde'];
	$hasta=$_REQUEST['hasta'];
	
    $data	= $Model -> setDetallesCliente($cliente_id,$this -> getConex());
	$html	= '';
	$comodin= 0;
	$con_reg= 0;
	
	foreach($data as $details){

		$return =$Model -> comprobar_archivo($details[cliente_id],$fecha_reg,$hasta,$desde,$this -> getConex());
		
		if(!$return[0][reporte_historial_nov_id]>0){
			
			$correos_cliente = $Model -> getcorreos_cliente($details[cliente_id],$this -> getConex());	
			$registros_rem = $Model -> getRegistros_rem($details[cliente_id],$fecha_reg,$desde,$hasta,$this -> getConex());	
			
			
		foreach($registros_rem as $registers_rem){	
		
		$rem_id = $registers_rem[remesa_id];
			
			$html.='<table border="1" cellspacing="1" cellpadding="1">';
				$html.='<tr><td colspan="5">&nbsp;</td> </tr>';	
				$html.='<tr><td colspan="2"><b>CLIENTE</b></td><td colspan="3">'.$registers_rem[cliente].' </td></tr>';
				$html.='<tr><td colspan="2"><b>REMESA</b></td><td colspan="3">'.$registers_rem[numero_remesa].' </td></tr>';	
				$html.='<tr><td colspan="2"><b>REMISION CLIENTE</b></td><td colspan="3">'.$registers_rem[orden_despacho].' </td></tr>';	
				$html.='<tr><td colspan="2"><b>ORIGEN</b></td><td colspan="3">'.$registers_rem[origen].' </td></tr>';	
				$html.='<tr><td colspan="2"><b>DESTINO</b></td><td colspan="3">'.$registers_rem[destino].' </td></tr>';
				
				$html.='<tr><td><b>CUIDAD</b></td><td><b>FECHA</b></td><td><b>HORA</b></td><td><b>NOVEDAD</b></td><td><b>OBSERVACION</b></td></tr>';
				
				
				$registros_man = $Model -> getRegistros_man($details[cliente_id],$fecha_reg,$desde,$hasta,$rem_id,$this -> getConex());	
					
				foreach($registros_man as $registers_man){				
					$html.='<tr><td>'.$registers_man[punto_referencia].'</td><td>'.$registers_man[fecha_reporte].'</td><td>'.$registers_man[hora_reporte].'</td><td>'.$registers_man[novedad].'</td><td>'.$registers_man[obser_deta].'</td></tr>';	
					$comodin=1;
				}
				$html.='<tr><td colspan="5">&nbsp;</td></tr>';	
				$html.='<tr><td><b>CUIDAD</b></td><td><b>FECHA</b></td><td><b>HORA</b></td><td><b>NOVEDAD</b></td><td><b>OBSERVACION</b></td></tr>';
				
				
				$registros_des = $Model -> getRegistros_des($details[cliente_id],$fecha_reg,$desde,$hasta,$this -> getConex());	
			
				foreach($registros_des as $registers_des){				
					$html.='<tr><td>'.$registers_des[punto_referencia].'</td><td>'.$registers_des[fecha_reporte].'</td><td>'.$registers_des[hora_reporte].'</td><td>'.$registers_des[novedad].'</td><td>'.$registers_des[obser_deta].'</td></tr>';	
					$comodin=1;
				}
	
				$html.='<tr><td colspan="5">&nbsp;</td></tr>';	
				$html.='<tr><td><b>CUIDAD</b></td><td><b>FECHA</b></td><td><b>HORA</b></td><td><b>NOVEDAD</b></td><td><b>OBSERVACION</b></td></tr>';
				
				
				$registros_seg = $Model -> getRegistros_seg($details[cliente_id],$fecha_reg,$desde,$hasta,$this -> getConex());	
			
				foreach($registros_seg as $registers_seg){				
					$html.='<tr><td>'.$registers_seg[punto_referencia].'</td><td>'.$registers_seg[fecha_reporte].'</td><td>'.$registers_seg[hora_reporte].'</td><td>'.$registers_seg[novedad].'</td><td>'.$registers_seg[obser_deta].'</td></tr>';		
					$comodin=1;
				}
	
			$html.='</table>';	
			
		}
			$scarpeta="../../../archivos/seguimiento"; 
			$sarchivo=$details[cliente_id]."_".date('Y_m_d_H_i')."_".rand(10,99).".xls";
			$sfile=$scarpeta."/".$sarchivo; 
			$fp=fopen($sfile,"w");
			fwrite($fp,$html);
			fclose($fp);
			$fecha_registro= date('Y-m-d H:i:s');
			echo '<script>descargar_file(\''.$sfile.'\');</script>';
	
			$enviado=0;
			$return =$Model -> Save($details[cliente_id],$details[minuto],$details[horas],$details[dias],$fecha_reg,$hasta,$fecha_registro,$sarchivo,$comodin,$enviado,$this -> getConex());
			if($return>0)	exit("Archivo Generado Exitosamente");	else exit("Error: No se ha Generado El Archivo");
		}else{
			echo '<script>descargar_file(\'../../../archivos/seguimiento/'.$return[0][archivo].'\');</script>';
			exit("El Archivo ya se ha Generado Previamente");	
			
		}
	}
  }


  protected function onclickEnviar(){
    
    require_once("ReportesModelClass.php");
	
    $Model  = new ReportesModel();
	$cliente_id=$_REQUEST['cliente_id'];
	$fecha_reg=$_REQUEST['fecha_reg'];
	$desde=$_REQUEST['desde'];
	$hasta=$_REQUEST['hasta'];
	
    $data	= $Model -> setDetallesCliente($cliente_id,$this -> getConex());
	$html	= '';
	$comodin= 0;
	$con_reg= 0;
	
	foreach($data as $details){
		
		$correos_cliente = $Model -> getcorreos_cliente($details[cliente_id],$this -> getConex());	
		$return =$Model -> comprobar_archivo($details[cliente_id],$fecha_reg,$hasta,$desde,$this -> getConex());
		
		if($return[0][con_registros]==1 && $return[0][archivo]!='' && $return[0][enviado]==0){
			
			$mail_subject='<strong> Novedades '.$fecha_reg.' '.$desde.' - '.$hasta.'</strong>';
			$mensaje='Registro de Novedades Fecha '.$fecha_reg;
			$mensaje.='En el archivo adjunto podra encontrar la información de su mercancia: <br /> Numero de remesa con la que se despacha<br />';
			$mensaje.='Origen y destino de la mercancia<br />';
			$mensaje.='Ciudad, fecha, hora y las novedades que tiene el vehiculo durante su recorrido<br />';
			$mensaje.='Asi como las observaciones que se presenten<br />';
			/*$mensaje.='Cualquier inquietud por favor comuniquela';*/
			foreach($correos_cliente as $correos_clients){
				$enviar_mail=new Mail();
				
				$enviado = $enviar_mail->sendMail(trim($correos_clients[correo]),$mail_subject,$mensaje,'../../../archivos/seguimiento/'.$return[0][archivo],$return[0][archivo]);
				//echo 'Novedades '.$fecha_reg.' '.$desde.' - '.$hasta;
			}
			$mensaje_alert="Correo Enviado con Registros";
		}elseif($return[0][con_registros]==0 && $return[0][archivo]!=''  && $return[0][enviado]==0){
			
			$mail_subject='No existe Novedades '.$fecha_reg.' '.$desde.' - '.$hasta;
			$mensaje='No existe Registro de Novedades Fecha'.$fecha_reg.'  Rango de horarios:'.$desde.' - '.$hasta;
			foreach($correos_cliente as $correos_clients){
				$enviar_mail=new Mail();				  
				$enviado = $enviar_mail->sendMail(trim($correos_clients[correo]),$mail_subject,$mensaje);
			}
			$mensaje_alert="Correo Enviado sin Registros";
			
			
		}elseif($return[0][con_registros]==0 && $return[0][archivo]!='' && $return[0][enviado]==1 ){
			$mensaje_alert="El Correo ya se ha Enviado previamente sin Registros";
			$enviado=0;
		}elseif($return[0][con_registros]==1 && $return[0][archivo]!='' && $return[0][enviado]==1 ){
			$mensaje_alert="El Correo ya se ha Enviado previamente con Registros";
			$enviado=0;
			
		}elseif($return[0][archivo]==''  ){
			$mensaje_alert="El Archivo no se ha Generado";
			$enviado=0;
		
		}
		
		$enviado=$enviado==true ? $enviado=1:$enviado=0;
		
		if($enviado==1) $Model -> Update($return[0][reporte_historial_nov_id],$this -> getConex());

		exit($mensaje_alert);	
		
	}
  }

}

$Reportes = new Reportes();

?>