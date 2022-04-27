<?php

final class Imp_FacturaAdjunto{

  private $Conex;
  
  public function __construct(){
    
  
  }

  public function printOutPDF($factura_id,$Conex){
      
    $factura = $factura_id;
    
    $factura_id = explode("_",$factura_id);
    $factura_id=$factura_id[1];
    
      require_once("Imp_FacturaAdjuntoLayoutClass.php");
      require_once("Imp_FacturaAdjuntoModelClass.php");
		
      $Layout = new Imp_FacturaAdjuntoLayout();
      $Model  = new Imp_FacturaAdjuntoModel();		
	
    $Layout -> setIncludes();
	  $fuente = $Model -> getFactura($factura_id,$Conex);
    $Layout -> setParametros($Model -> getParametros($Conex));
    $Layout -> setFactura($Model -> getFactura($factura_id,$Conex));	
	  $Layout -> setitemFactura($Model -> getitemFactura($factura_id,$Conex));	
	  $Layout -> set_pucFactura($Model -> get_pucFactura($factura_id,$fuente[0]['fuente_facturacion_cod'],$Conex));
	  $Layout -> set_valor_letras($Model -> get_valor_letras($factura_id,$Conex));
	  $Layout -> set_valor_letras_deta($Model -> get_valor_detalles($factura_id,$Conex));
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($factura_id,$Conex));	

     $parametros = $Model -> getParametros($Conex);
     $formato_impresion = $parametros[0]['formato_impresion'];
     $cabecera_por_pagina = $parametros[0]['cabecera_por_pagina'];
    
    //********************************************************************//
    //*************** Codigo para generar codigo QR inicio ***************//
    //********************************************************************//
        
        $Datos = $Model->getCodigoQR($factura_id, $Conex);

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
          $Layout -> RenderMainFormato($factura);
        }elseif($cabecera_por_pagina == 1){
          $Layout -> RenderMainFormatoCabecera($factura);
        }else{
          $Layout -> RenderMain($factura);
        }
    
  }

}

new Imp_FacturaAdjunto();

?>