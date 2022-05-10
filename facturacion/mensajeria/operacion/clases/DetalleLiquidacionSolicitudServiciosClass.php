<?php

	require_once("../../../framework/clases/ControlerClass.php");

	final class DetalleLiquidacionSolicitudServicios extends Controler{

		public function __construct(){
		parent::__construct(3);
		}

		public function Main(){

			$this -> noCache();
			require_once("DetalleLiquidacionSolicitudServiciosLayoutClass.php");
			require_once("DetalleLiquidacionSolicitudServiciosModelClass.php");

			$Layout = new DetalleLiquidacionSolicitudServiciosLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new DetalleLiquidacionSolicitudServiciosModel();
			$Layout -> setIncludes();
			$Layout -> setDetallesSolicitudServicios($Model -> getDetallesSolicitudServicios($this -> getConex()));
			$Layout -> RenderMain();
		}

		protected function OnClickSave(){
			
			$this -> noCache();
			require_once("DetalleLiquidacionSolicitudServiciosModelClass.php");
			$Model  = new DetalleLiquidacionSolicitudServiciosModel();
			require_once("LiquidacionGuiasClienteModelClass.php");
			$Model1 = new LiquidacionGuiasClienteModel();



			$Conex = $this -> getConex();

			//INICIO LIQUIDACION
			$solicitud_id		=	$_REQUEST['solicitud_id'];

			$result =  $Model -> getGuiasLiqtodasSSol($solicitud_id,$this -> getOficinaId(),$this -> getConex());
			
			$mensaje='';
			for($i=0;$i<count($result);$i++){
				$guia_id1=$result[$i]['guia_id'];
				$numero_guia=$result[$i]['numero_guia'];
				$valor_total=$result[$i]['valor_total'];
				$origen_id=$result[$i]['origen_id'];
				$destino_id=$result[$i]['destino_id'];
				$cliente_id=$result[$i]['cliente_id'];
				$year  		= substr($result[$i]['fecha_guia'],0,4);	
				$tipo_servicio_mensajeria_id=$result[$i]['tipo_servicio_mensajeria_id'];
				//$tipo_envio_id=$result[$i]['tipo_envio_id'];
	
				//inicio calculo tarifa
				$peso=$result[$i]['peso']/1000;
				
				$peso_volumen=$result[$i]['peso_volumen'];
				
				if($peso>=$peso_volumen){
					$pesoreal=$peso; 
				}else{
					$pesoreal=$peso_volumen; 
				}
			
				$peso_adicional=$pesoreal-1;
				$valor=$result[$i]['valor'];
				$valor_otros=$result[$i]['valor_otros']>0?$result[$i]['valor_otros']:'0';
				$total=0;
				
				if($origen_id==$destino_id){ 
					$tipo_envio_id=2;
				}else{
					$tipo_envio_id=$Model1 -> getTipoEnvio1($destino_id,$this -> getConex());
				}
				
				if($Model1 -> getTipoEnvioMetro($origen_id,$destino_id,$this -> getConex()) ) $tipo_envio_id=2;	
				
				if($tipo_envio_id=='' || $tipo_envio_id=='NULL' || $tipo_envio_id==NULL || $tipo_envio_id=='null') exit('El destino '.$Model1 -> getNombre_destino($destino_id,$this -> getConex()).' no tiene asociado el tipo de envio');
				
				$tabla_esc = $Model1 -> getTabla($tipo_servicio_mensajeria_id,$this -> getConex());
				
				if($tabla_esc[0]['tabla']=='tarifas_mensajeria'){
					$resultado = $Model1 -> getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());
					if(!count($resultado)>0){
						$resultado = $Model1 -> getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());	
					}
				}else{
					$resultado = $Model1 -> getCalcularTarifaMasivoCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());	
					if(!count($resultado)>0){
						$resultado = $Model1 -> getCalcularTarifaMasivo($tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,$year,$this -> getConex(),$this -> getOficinaId());	
					}
					
				}
				if(!count($resultado)>0){ exit('No existe Tarifas configuradas, Por favor verifique');	}
				
				$valor_decla=($valor*$resultado[0][porcentaje_seguro])/100;
			
				//$manejo = $Model1 -> getCalcularCosto($destino_id,date('Y'),$this -> getConex(),$this -> getOficinaId());
				$manejo = 0;
				//poner validacion en de tarifa masivo aqui y guiaclass y guiacrm
				if($tabla_esc[0]['tabla']=='tarifas_mensajeria'){
					if($pesoreal<1){
						$valorinicial=$resultado[0]['vr_kg_inicial_min'];
						
					}else{
						$valorinicial=$resultado[0]['vr_kg_inicial_max'];
					}
					$valorkilo_adi=$resultado[0]['vr_kg_adicional_min'];
					
					if($pesoreal<=1){
						$valor_kilos_adi=0;
					}else{
						$peso_adicional = ceil($peso_adicional);
						$valor_kilos_adi=$valorkilo_adi*$peso_adicional;
					}
					$valorinicial= $valorinicial+$valor_kilos_adi;
					$total=$valor_decla+$valorinicial+$manejo+$valor_otros;
				}else{//tarifa masivo
					$valorinicial=$resultado[0]['valor_min'];
					$total=$valor_decla+$valorinicial+$manejo+$valor_otros;
				}
				//fin calculo tarifa
				
				
				if($valor_total>0 && $total!=$valor_total){
					$resultado = $Model1 -> getActualizarValor($guia_id1,$tipo_envio_id, $total,$valor_decla,$valorinicial,$manejo,$valor_otros,$this -> getConex());	
					if($resultado>0){
						$mensaje.="Guia ".$numero_guia." Actualizada<br>";				
					}else{
						$mensaje.="Guia NO".$numero_guia." Actualizada<br>";				
					}
						
				}elseif($valor_total=='' || $valor_total==NULL || $valor_total==0){
					$resultado = $Model1 -> getActualizarValor($guia_id1,$tipo_envio_id, $total,$valor_decla,$valorinicial,$manejo,$valor_otros,$this -> getConex());	
					if($resultado>0){
						$mensaje.="Guia ".$numero_guia." Actualizada<br>";				
					}else{
						$mensaje.="Guia NO".$numero_guia." Actualizada<br>";	
					}
				}
				
			}
			//FIN LIQUIDACION

			$guardando = $Model -> Save($Conex);
			exit("$guardando");
		}

		protected function cargaDatosAnular(){
			

			$this -> noCache();
			require_once("DetalleLiquidacionSolicitudServiciosLayoutClass.php");
			require_once("DetalleLiquidacionSolicitudServiciosModelClass.php");

			$Layout = new DetalleLiquidacionSolicitudServiciosLayout($this -> getTitleTab(),$this -> getTitleForm());
			$Model  = new DetalleLiquidacionSolicitudServiciosModel();
			$Layout -> setIncludes();
			$Layout -> setDetallesSolicitudServicios($Model -> getDetallesSolicitudServiciosAnular($this -> getConex()));
			$Layout -> RenderMain();
		}
	}
	
	$DetalleLiquidacionSolicitudServicios = new DetalleLiquidacionSolicitudServicios();
?>