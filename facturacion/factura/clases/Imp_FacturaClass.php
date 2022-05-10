<?php

final class Imp_Factura{

  private $Conex;
  
  public function __construct(){
  
  }

  public function printOut($factura_id,$Conex){

    $this -> Conex = $Conex;
    	
      require_once("Imp_FacturaLayoutClass.php");
      require_once("Imp_FacturaModelClass.php");
		
      $Layout = new Imp_FacturaLayout();
      $Model  = new Imp_FacturaModel();		
	
      $Layout -> setIncludes();
	  $fuente = $Model -> getFactura($this -> Conex);
    $Layout -> setParametros($Model -> getParametros($this -> Conex));
    $Layout -> setFactura($Model -> getFactura($this -> Conex));	
	  $Layout -> setitemFactura($Model -> getitemFactura($this -> Conex));	
	  $Layout -> set_pucFactura($Model -> get_pucFactura($fuente[0]['fuente_facturacion_cod'],$this -> Conex));
	  $Layout -> set_valor_letras($Model -> get_valor_letras($this -> Conex));
	  $Layout -> set_valor_letras_deta($Model -> get_valor_detalles($this -> Conex));
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($this -> Conex));	

    $parametros = $Model -> getParametros($this -> Conex);
    $formato_impresion = $parametros[0]['formato_impresion'];
    $cabecera_por_pagina = $parametros[0]['cabecera_por_pagina'];
    
    //********************************************************************//
    //*************** Codigo para generar codigo QR inicio ***************//
    //********************************************************************//
        
        $Datos = $Model->getCodigoQR($factura_id, $this -> Conex);

        if($Datos[0]['ValIva']== ''){
          $Datos[0]['ValIva']=0;
        }
        
        require_once "../../../framework/clases/QRcode/phpqrcode/phpqrcode.php";
        
        //Carpeta para guardar las imagenes
        $dir = "../../../archivos/facturacion/QRfacturas/";
        
        //el nombre de la imagen va a ser el numero de factura
        $filename = $dir . $Datos[0]['consecutivo_factura'] . '.png';
        //configuración de la imagen
        $tamaño = 8; //Tamaño de Pixel
        $level = 'L'; //Precisión Baja
        $framSize = 2; //Tamaño en blanco
        
            $contenido = 'NumFac:'.$Datos[0]['NumFac']."\r\n".
                         'FecFac:'.$Datos[0]['FecFac']."\r\n".
                         'NitFac:'.$Datos[0]['NitFac']."\r\n".
                         'DocAdq:'.$Datos[0]['DocAdq']."\r\n".
                         'ValFac:'.$Datos[0]['ValFac']."\r\n".
                         'ValIva:'.$Datos[0]['ValIva']."\r\n".
                         'ValOtroIm:'.$Datos[0]['ValOtroIm']."\r\n".
                         'ValFacIm:'.$Datos[0]['ValFacIm']."\r\n".
                         'CUFE:'.$Datos[0]['CUFE']."\r\n";
            //Datos que debe llevar el QR
            
            //Creamos objeto de la clase QRCode
            $QRcode = new QRcode();
            //llamammos la función para generar la imagen
        $QRcode->png($contenido, $filename, $level, $tamaño, $framSize);
        
        //Asignamos la ruta de la imagen al layout
        $Layout->setCodigoQR($dir . basename($filename));
        
        //********************************************************************//
        //*************** Codigo para generar codigo QR final ****************//
        //********************************************************************//

        if($formato_impresion == 1){
          $Layout -> RenderMainFormato();
        }elseif($cabecera_por_pagina == 1){
           $Layout -> RenderMainFormatoCabecera();
        }else{
          $Layout -> RenderMain();
        }

    
  }

  public function printOutPDF($nombre){
    	
      require_once("Imp_FacturaLayoutClass.php");
      require_once("Imp_FacturaModelClass.php");
		
      $Layout = new Imp_FacturaLayout();
      $Model  = new Imp_FacturaModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setFactura($Model -> getFactura($this -> Conex));	
	  $Layout -> setitemFactura($Model -> getitemFactura($this -> Conex));	
	  $Layout -> set_pucFactura($Model -> get_pucFactura($this -> Conex));
	  $Layout -> set_valor_letras($Model -> get_valor_letras($this -> Conex));
	  $Layout -> set_valor_letras_deta($Model -> get_valor_detalles($this -> Conex));
	  $Layout -> setImputacionesContables($Model -> getImputacionesContables($this -> Conex));	

      $Layout -> RenderMainpdf($nombre);
    
  }

}

new Imp_Factura();

?>