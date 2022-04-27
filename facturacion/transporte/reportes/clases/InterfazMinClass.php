<?php

require_once("../../../framework/clases/ControlerClass.php");

final class InterfazMin extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'date')
	);	
	
	$this -> Campos[tipo] = array(
  		name  =>'tipo',
  		id   =>'tipo',
 		type  =>'select',
  		required =>'yes',
  		options  =>array(array(value => 'P', text => 'PERSONAS'),array(value => 'E', text => 'EMPRESAS'),
						 array(value => 'V', text => 'VEHICULOS'),array(value => 'R', text => 'REMESAS'),
						 array(value => 'M', text => 'MANIFIESTOS'),array(value => 'T', text => 'TIEMPOS')),
  		datatype =>array(type=>'text')  		
	 );	
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("InterfazMinLayoutClass.php");
    require_once("InterfazMinModelClass.php");
	
    $Layout   = new InterfazMinLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new InterfazMinModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU 
	
	$Layout -> RenderMain();    
  }
   
  protected function generateFile(){
  
    require_once("InterfazMinModelClass.php");
	
    $Model     = new InterfazMinModel();	
	$desde     = $_REQUEST['desde'];
	$hasta     = $_REQUEST['hasta'];
	$tipo      = $_REQUEST['tipo'];
	
	if($tipo == 'P'){
      $nombre = '0878'.str_replace('-','',$desde).'per';	  
    }elseif($tipo == 'E'){
		$nombre = '0878'.str_replace('-','',$desde).'emp';	
	}elseif($tipo == 'V'){
	  	$nombre = '0878'.str_replace('-','',$desde).'veh';	
	}elseif($tipo == 'R'){
		$nombre = '0878'.str_replace('-','',$desde).'rem';	
	}elseif($tipo == 'M'){
	  	$nombre = '0878'.str_replace('-','',$desde).'man';	
	}elseif($tipo == 'T'){
	   $nombre = '0878'.str_replace('-','',$desde).'tie';	
	}
			  
	
	$data  = $Model -> selectAnticiposRangoFecha($desde,$hasta,$tipo,$this -> getConex());   
	
	if($tipo == 'P'){
   	  $cadena = '';
		foreach($data as $datos){
			$cadena.=$datos['pertipid']."\t"
					.$datos['periden']."\t"
					.$datos['perapell1']."\t"
		    	    .$datos['perapell2']."\t"
					.$datos['pernombre']."\t"
					.$datos['pertelefono']."\t"
					.$datos['perdireccion']."\t"
					.$datos['perciudad']."\t"
					.$datos['percateglice']."\t"
					.$datos['pernumerolice'].chr(13).chr(10);		
		} // fin foreach personas
    } // fin personas
	  elseif($tipo == 'E'){	
	    $cadena = '';
			foreach($data as $datos){
			  $cadena.=$datos['emptipid']."\t"
					  .$datos['empident']."\t"
					  .$datos['empnombr']."\t"
					  .$datos['emptelefono']."\t"
					  .$datos['empdireccion']."\t"
					  .$datos['empciudad']."\t"
					  .$datos['empnumautoriza'].chr(13).chr(10);
			}// fin foreach	empresas	
	  } // fin empresas
		elseif($tipo == 'V'){			
			$cadena = '';
				foreach($data as $datos){
				  $cadena.=$datos['vehplaca']."\t"
				  		  .$datos['vehmarca']."\t"
				  		  .$datos['vehlinea']."\t"
						  .$datos['vehmodelo']."\t"
						  .$datos['vehmodelotransf']."\t"
						  .$datos['vehcolor']."\t"
						  .$datos['vehtipocarrocer']."\t"
						  .$datos['vehconfiguraci']."\t"
						  .$datos['vehpeso']."\t"
						  .$datos['vehnro_poliza']."\t"
						  .$datos['vehtipidasegur']."\t"
						  .$datos['vehidenasegur']."\t"
						  .$datos['vehfechvenci']."\t"
						  .$datos['vehcapacidad']."\t."
						  .$datos['vehnroejes']."\t"
						  .$datos['vehtipocombus']."\t"
						  .$datos['vehtipidpropiet']."\t"
						  .$datos['vehidentprop']."\t"
						  .$datos['vehtipidtenenc']."\t"
						  .$datos['vehidentenenc'].chr(13).chr(10);	
	    		}// fin foreach	vehiculos
		 } // fin vehiculos
		  elseif($tipo == 'R'){
			$cadena = '';
				foreach($data as $datos){
				  $cadena.=$datos['nitempresa']."\t"
				  		  .$datos['remnumero']."\t"
				  		  .$datos['remnroremempresa']."\t"
						  .$datos['remunida_medida']."\t"
						  .$datos['remcantidad']."\t"
						  .$datos['remnaturaleza']."\t"
						  .$datos['remunida_empaq']."\t"
						  .$datos['remcontenedorvacio']."\t"
						  .$datos['remcodproducto2']."\t"
						  .$datos['remdescr_produ']."\t"
						  .$datos['remtipidremitente']."\t"
						  .$datos['remidenremitente']."\t"
						  .$datos['remciudad_orig']."\t"
						  .$datos['remtipiddestinatario']."\t."
						  .$datos['remidendestinatario']."\t"
						  .$datos['remciudad_desti']."\t"
						  .$datos['remdirecciondestino']."\t"
						  .$datos['remtipidpropietario']."\t"
						  .$datos['remidenpropietario']."\t"
						  .$datos['remduenopoliza']."\t"
						  .$datos['rempoliza']."\t"
						  .$datos['remaseguradora']."\t"
						  .$datos['remvencimiento'].chr(13).chr(10);	
	    		}// fin foreach	remesa			
		  } // fin remesa
			elseif($tipo == 'M'){
			  $cadena = '';
				foreach($data as $datos){
				  $cadena.=$datos['nitempresa']."\t"
				  		  .$datos['mannumero']."\t"
				  		  .$datos['manfechexped']."\t"
						  .$datos['manciud_origen']."\t"
						  .$datos['manciud_destin']."\t"
						  .$datos['manplaca']."\t"
						  .$datos['mantipidconduc']."\t"
						  .$datos['manidenconduc']."\t"
						  .$datos['manplacsemir']."\t"
						  .$datos['manvlrtoviaje']."\t"
						  .$datos['manretefuente']."\t"
						  .$datos['mandescu_ley']."\t"
						  .$datos['manvlr_anticip']."\t"
						  .$datos['manlugar_pago']."\t."
						  .$datos['manfechpagsal']."\t"
						  .$datos['manpago_cargue']."\t"
						  .$datos['manpago_descar']."\t"
						  .$datos['manobservacion']."\t"
						  .$datos['mantipidtitular']."\t"
						  .$datos['manidentitular']."\t"
						  .$datos['manfechaentrega']."\t"
						  .$datos['mantipomanifiesto']."\t"
						  .$datos['manestado'].chr(13).chr(10);
	    		}// fin foreach	manifiestos		
		  } // fin manifiesto
			elseif($tipo == 'T'){
			  $cadena = '';
				foreach($data as $datos){
				  $cadena.=$datos['Mannumero']."\t"
				  		  .$datos['Remnumero']."\t"
				  		  .$datos['Remhoraspactocargue']."\t"
						  .$datos['Remhoraspactodescargue']."\t"
						  .$datos['Remfechallegacargue']."\t"
						  .$datos['Remhorallegacargue']."\t"
						  .$datos['Remfechafincargue']."\t"
						  .$datos['Remhorafincargue']."\t"
						  .$datos['Remfechainiciodescargue']."\t"
						  .$datos['Remhorainiciodescargue']."\t"
						  .$datos['Remfechafindescargue']."\t"
						  .$datos['Remhorafindescargue'].chr(13).chr(10);
	    		}// fin foreach	tiempos		
				
		} // fin tiempos
	
	
    //$ruta  = $this -> arrayToExcel("InterfazMin",$tipo,$data,null,"string");
	$ruta  = $this -> arrayToTxt($nombre,$cadena,null);
	
    $this -> ForceDownload($ruta,$nombre.'.txt');
	  
  }

  protected function generateFileexcel(){
  
    require_once("InterfazMinModelClass.php");
	
    $Model     = new InterfazMinModel();	
	$desde     = $_REQUEST['desde'];
	$hasta     = $_REQUEST['hasta'];
	$tipo      = $_REQUEST['tipo'];
	
	if($tipo == 'P'){
      $nombre = '0878'.date('Ymd').'per';	  
    }elseif($tipo == 'E'){
		$nombre = '0878'.date('Ymd').'emp';	
	}elseif($tipo == 'V'){
	  	$nombre = '0878'.date('Ymd').'veh';	
	}elseif($tipo == 'R'){
		$nombre = '0878'.date('Ymd').'rem';	
	}elseif($tipo == 'M'){
	  	$nombre = '0878'.date('Ymd').'man';	
	}elseif($tipo == 'T'){
	   $nombre = '0878'.date('Ymd').'TIE';	
	}
			  
	
	$data  = $Model -> selectAnticiposRangoFecha($desde,$hasta,$tipo,$this -> getConex());   
	
    $ruta  = $this -> arrayToExcel("InterfazMin",$tipo,$data,null,"string");
	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }

}

new InterfazMin();

?>