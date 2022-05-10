<?php
/* 
final class Imp_OrdenCargue{

  private $Conex;
  
  public function __construct(){
    
     
  
  }

  public function printOut($Conex){  
    	
      require_once("Imp_OrdenCargueLayoutClass.php");
      require_once("Imp_OrdenCargueModelClass.php");
		
      $Layout = new Imp_OrdenCargueLayout();
      $Model  = new Imp_OrdenCargueModel();		
	
      $Layout -> setIncludes();
	
      $Layout -> setOrdenCargue($Model -> getOrdenCargue($this -> Conex));	
      $Layout -> RenderMain();
    
  }
	
}

new Imp_OrdenCargue();
 */

final class Imp_OrdenCargue
{

    private $Conex;

    public function __construct($Conex)
    {

        $this->Conex = $Conex;

    }

    public function printOut()
    {

        require_once "Imp_OrdenCargueLayoutClass.php";
        require_once "Imp_OrdenCargueModelClass.php";
        require_once "Imp_DocumentoLayoutClass.php";
        require_once "../../../framework/clases/fpdf/fpdf.php";
        require_once "Imp_DocumentoModelClass.php";

        $Layout = new Imp_OrdenCargueLayout();
        $Model = new Imp_OrdenCargueModel();

        $result = $Model->getOrdenCargue($this->Conex);

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter', 'mm');
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetMargins(7, 5, 5);
        $pdf->SetAutoPageBreak(true, 1);
        $pdf->SetX(40);
        $pdf->SetY(10);

        $ln =0;
        if (strlen($result[0]['producto']) > 55) {
            $ln = $ln+4;
        }elseif (strlen($result[0]['producto']) > 135) {
            $ln = $ln+8;
        }else {
          $ln =0;
        } 

        // Recuadros redondeados
        $pdf->SetFillColor(255);
        $pdf->RoundedRect(146, 6, 52, 24, 3, '1234', 'DF');
        $pdf->RoundedRect(8, 40, 190, 80+$ln, 2, '234', 'DF');
        

        // FIN Recuadros redondeados
        
        // Color al recuadro 1
        $pdf->RoundedRect(33, 36, 70, 4, 2, '2', 'DF');
        $pdf->SetFillColor(231, 238, 255);
        // $pdf->RoundedRect(8, 40, 25, 4, 2, '1', 'DF','true');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->RoundedRect(8, 36, 25, 4, 2, '1', 'DF', 'true');
        $pdf->RoundedRect(146, 6, 52, 8, 3, '12', 'DF', 'true');
        $pdf->SetFillColor(0);
        //FIN Color al recuadro 1
        
        $pdf->Image('../../../framework/media/images/general/supertransporte.png', 80, 10, 55, 18);
        $pdf->Image($result[0]['logo'], 30, 8, 40, 20);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->Cell(37, 4, 'ORDEN DE CARGUE No :', 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(15, 4, $result[0]['consecutivo'], 0, 0, 'C');
        $pdf->SetTextColor(0);

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(52, 4, utf8_decode($result[0]['direccion']), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(52, 4, 'Oficina: ' . utf8_decode($result[0]['nom_oficina']) . ' - ' . 'Ciudad: ' . utf8_decode($result[0]['ciudad_ofi']), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(52, 4, $result[0]['tipo_identificacion_emp'] . ':' . $result[0]['numero_identificacion_emp'], 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(130, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(70, 4, utf8_decode($result[0]['email']), 0, 0, 'C');

        // Fecha

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, 'Fecha :', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(70, 4, $result[0]['fecha_ingre'], 0, 0, 'L');

        //Fin fecha

        // Primer Recuadro

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(25, 4, 'Origen :', 0, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(70, 4, $result[0]['origen'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(25, 4, 'Destino :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(70, 4, $result[0]['destino'], 0, 0, 'L');

        // Recuadro REMITENTE y DESTINATARIO

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(95, 4, 'REMITENTE', 1, 0, 'C', 'true');
        $pdf->Cell(95, 4, 'DESTINATARIO', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, utf8_decode('Identificación :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['nit_remitente'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, 'Nombre :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, utf8_decode(substr($result[0]['nombre_remitente'], 0, 19)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Identificación :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['nit_destintario'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, 'Nombre :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, utf8_decode(substr($result[0]['nombre_destintario'], 0, 19)), 1, 0, 'L');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, $result[0]['direccion_remitente'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, utf8_decode('Teléfono :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['telefono_remitente'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, $result[0]['direccion_destintario'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Teléfono :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['telefono_destintario'], 1, 0, 'L');

        //FIN Recuadro REMITENTE y DESTINATARIO

        // Recuadro MERCANCIA

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DE LA MERCANCIA', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(12, 4, utf8_decode('Unidad :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 4, $result[0]['unidad_peso'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(13, 4, 'Peso :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(20, 4, $result[0]['peso'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Cantidad :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 4, $result[0]['cantidad_cargue'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Producto :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);

        if (strlen($result[0]['producto']) > 55) {
            $pdf->Cell(75, 4, utf8_decode(substr($result[0]['producto'], 0, 55)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['producto'], 55, 135)), 1, 0, 'L');
        }elseif (strlen($result[0]['producto']) > 135) {
            $pdf->Cell(75, 4, utf8_decode(substr($result[0]['producto'], 0, 55)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['producto'], 55, 135)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['producto'], 135, 135)), 1, 0, 'L');
        }else {
            $pdf->Cell(75, 4, utf8_decode(substr($result[0]['producto'], 0, 55)), 1, 0, 'L');
        } 

        //FIN Recuadro MERCANCIA
        // Recuadro CONDUCTOR

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DEL CONDUCTOR', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(13, 4, utf8_decode('Nombre :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4,utf8_decode(substr($result[0]['nombre'], 0, 30)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(8, 4,utf8_decode('Id. :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(13, 4, $result[0]['numero_identificacion'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(15, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(51, 4, utf8_decode($result[0]['direccion_conductor']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(8, 4, utf8_decode('Tel :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(14, 4, utf8_decode($result[0]['telefono_conductor']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(8, 4, utf8_decode('Cel :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(14, 4, utf8_decode($result[0]['movil_conductor']), 1, 0, 'L');

        //FIN Recuadro CONDUCTOR

        // Recuadro PROPIETARIO

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DEL PROPIETARIO', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(13, 4, utf8_decode('Nombre :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(48, 4,utf8_decode(substr($result[0]['propietario'], 0, 30)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4,utf8_decode('Identificación :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(13, 4, $result[0]['numero_identificacion_propietario'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(15, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(52, 4, utf8_decode($result[0]['direccion_propietario']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(15, 4, utf8_decode('Teléfono :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(14, 4, utf8_decode($result[0]['telefono_propietario']), 1, 0, 'L');

        //FIN Recuadro PROPIETARIO
        // Recuadro VEHICULO

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DEL VEHICULO', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(28, 4, utf8_decode('Placa :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(32, 4,utf8_decode(substr($result[0]['placa'], 0, 30)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(28, 4,utf8_decode('Modelo :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(32, 4, $result[0]['modelo'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(28, 4, utf8_decode('Marca :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(42, 4, utf8_decode($result[0]['marca']), 1, 0, 'L');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, utf8_decode('Color :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(42, 4, utf8_decode($result[0]['color']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(23, 4,utf8_decode('Linea :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(23, 4, $result[0]['linea'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(25, 4, utf8_decode('Motor :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(52, 4, utf8_decode($result[0]['serie']), 1, 0, 'L');

        //FIN Recuadro VEHICULO
        //Recuadro OBSERVACIONES

        $pdf->SetFillColor(255);
        $pdf->RoundedRect(8, $ln+92, 190, 12, 0, '0', 'DF');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->RoundedRect(8, $ln+92, 25, 4, 3, '3', 'DF');
        
        

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, utf8_decode('Observaciones :'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 6);
         /* if (strlen($result[0]['observaciones']) > 55) {
            $pdf->Cell(165, 4, utf8_decode(substr($result[0]['observaciones'], 0, 130)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['observaciones'], 130, 355)), 1, 0, 'L');
        }elseif (strlen($result[0]['observaciones']) > 355) {
            $pdf->Cell(165, 4, utf8_decode(substr($result[0]['observaciones'], 0, 130)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['observaciones'], 130, 355)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['observaciones'], 355, 355)), 1, 0, 'L');
        }else {
            $pdf->Cell(165, 4, utf8_decode(substr($result[0]['observaciones'], 0, 130)), 1, 0, 'L');
        }  */

        //FIN Recuadro OBSERVACIONES

        
        //Recuadro FIRMA     

        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(175, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, utf8_decode('ORIGINAL'), 0, 0, 'L');
        
        $pdf->Ln(12);
        $pdf->Cell(10, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 0.1, null, 1, 0, 'L');
        $pdf->Cell(20, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 0.1, null, 1, 0, 'L');
        $pdf->Cell(10, 4, null, 0, 0, 'L');
        
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(10, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 1, utf8_decode('Firma/Huella Conductor'), 0, 0, 'C');
        $pdf->Cell(20, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 1, utf8_decode('Firmar Empresa'), 0, 0, 'C');
        $pdf->Cell(10, 4, null, 0, 0, 'L');

        $texto = "SEÑOR GENERADOR DE CARGA: Antes de entregar su mercancía, verifique los datos del conductor, del vehículo y el estado del mismo.";
        $texto_dos = "SEÑOR CONDUCTOR: Al firmar esta orden usted es responsable de la mercancía descrita. CERCIORESE que este completa y en perfectas.";

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 5);
        $pdf->Cell(120, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 2, utf8_decode('Realizado por: Sistemas Informáticos & Soluciones Integrales S.A.S. - SI&SI.'), 0, 0, 'R');

        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(120, 2,utf8_decode(substr($texto, 0, 120)), 0, 0, 'L');
        
        $pdf->Ln(2.5);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(130, 2,utf8_decode(substr($texto_dos, 0, 130)), 0, 0, 'L');
        

        //FIN Recuadro FIRMA

        // Marca de Agua
        $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png',65,50,80,60);
        //FIN Marca de Agua

        //FIN Copia 1

        //Copia 2

        $pdf->Ln(20-$ln);

        // Recuadros redondeados
        $pdf->SetFillColor(255);
        $pdf->RoundedRect(146, 139.5, 52, 24, 3, '1234', 'DF');
        $pdf->RoundedRect(8, 173.5, 190, 80+$ln, 2, '234', 'DF');

        // FIN Recuadros redondeados
        
        // Color al recuadro 1
        $pdf->RoundedRect(33, 169.5, 70, 4, 2, '2', 'DF');
        $pdf->SetFillColor(231, 238, 255);
        // $pdf->RoundedRect(8, 40, 25, 4, 2, '1', 'DF','true');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->RoundedRect(8, 169.5, 25, 4, 2, '1', 'DF', 'true');
        $pdf->RoundedRect(146, 139.5, 52, 8, 3, '12', 'DF', 'true');
        $pdf->SetFillColor(0);
        //FIN Color al recuadro 1

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Image('../../../framework/media/images/general/supertransporte.png', 80, 142, 55, 18);
        $pdf->Image($result[0]['logo'], 30, 141.5, 40, 20);
        // $pdf->Image('../../../framework/media/images/varios/basc.jpg', 120, 141.5, 18, 18);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->Cell(37, 4, 'ORDEN DE CARGUE No :', 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(15, 4, $result[0]['consecutivo'], 0, 0, 'C');
        $pdf->SetTextColor(0);

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(52, 4, utf8_decode($result[0]['direccion']), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(52, 4, 'Oficina: ' . utf8_decode($result[0]['nom_oficina']) . ' - ' . 'Ciudad: ' . utf8_decode($result[0]['ciudad_ofi']), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(139, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(52, 4, $result[0]['tipo_identificacion_emp'] . ':' . $result[0]['numero_identificacion_emp'], 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(130, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(70, 4, utf8_decode($result[0]['email']), 0, 0, 'C');

        // Fecha

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, 'Fecha :', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(70, 4, $result[0]['fecha_ingre'], 0, 0, 'L');

        //Fin fecha

        // Primer Recuadro

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(25, 4, 'Origen :', 0, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(70, 4, $result[0]['origen'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(25, 4, 'Destino :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(70, 4, $result[0]['destino'], 0, 0, 'L');

        // Recuadro REMITENTE y DESTINATARIO

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(95, 4, 'REMITENTE', 1, 0, 'C', 'true');
        $pdf->Cell(95, 4, 'DESTINATARIO', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, utf8_decode('Identificación :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['nit_remitente'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, 'Nombre :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, utf8_decode(substr($result[0]['nombre_remitente'], 0, 19)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Identificación :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['nit_destintario'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, 'Nombre :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, utf8_decode(substr($result[0]['nombre_destintario'], 0, 19)), 1, 0, 'L');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, $result[0]['direccion_remitente'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(20, 4, utf8_decode('Teléfono :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['telefono_remitente'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(28, 4, $result[0]['direccion_destintario'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Teléfono :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(27, 4, $result[0]['telefono_destintario'], 1, 0, 'L');

        //FIN Recuadro REMITENTE y DESTINATARIO

        // Recuadro MERCANCIA

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DE LA MERCANCIA', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(12, 4, utf8_decode('Unidad :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 4, $result[0]['unidad_peso'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(13, 4, 'Peso :', 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(20, 4, $result[0]['peso'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Cantidad :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 4, $result[0]['cantidad_cargue'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4, utf8_decode('Producto :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        if (strlen($result[0]['producto']) > 55) {
            $pdf->Cell(75, 4, utf8_decode(substr($result[0]['producto'], 0, 55)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['producto'], 55, 135)), 1, 0, 'L');
        }elseif (strlen($result[0]['producto']) > 135) {
            $pdf->Cell(75, 4, utf8_decode(substr($result[0]['producto'], 0, 55)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['producto'], 55, 135)), 1, 0, 'L');
            $pdf->Ln(4);
            $pdf->Cell(1, 4, null, 0, 0, 'L');
            $pdf->Cell(190, 4, utf8_decode(substr($result[0]['producto'], 135, 135)), 1, 0, 'L');
        }else {
            $pdf->Cell(75, 4, utf8_decode(substr($result[0]['producto'], 0, 55)), 1, 0, 'L');
        } 

        //FIN Recuadro MERCANCIA
        // Recuadro CONDUCTOR

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DEL CONDUCTOR', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(13, 4, utf8_decode('Nombre :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4,utf8_decode(substr($result[0]['nombre'], 0, 30)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(8, 4,utf8_decode('Id. :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(13, 4, $result[0]['numero_identificacion'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(15, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(51, 4, utf8_decode($result[0]['direccion_conductor']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(8, 4, utf8_decode('Tel :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(14, 4, utf8_decode($result[0]['telefono_conductor']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(8, 4, utf8_decode('Cel :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(14, 4, utf8_decode($result[0]['movil_conductor']), 1, 0, 'L');

        //FIN Recuadro CONDUCTOR

        // Recuadro PROPIETARIO

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DEL PROPIETARIO', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(13, 4, utf8_decode('Nombre :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(48, 4,utf8_decode(substr($result[0]['propietario'], 0, 30)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(20, 4,utf8_decode('Identificación :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(13, 4, $result[0]['numero_identificacion_propietario'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(15, 4, utf8_decode('Dirección :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(52, 4, utf8_decode($result[0]['direccion_propietario']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(15, 4, utf8_decode('Teléfono :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(14, 4, utf8_decode($result[0]['telefono_propietario']), 1, 0, 'L');

        //FIN Recuadro PROPIETARIO
        // Recuadro VEHICULO

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(190, 4, 'DATOS DEL VEHICULO', 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->SetFillColor(231, 238, 255);
        $pdf->Cell(28, 4, utf8_decode('Placa :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(32, 4,utf8_decode(substr($result[0]['placa'], 0, 30)), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(28, 4,utf8_decode('Modelo :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(32, 4, $result[0]['modelo'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(28, 4, utf8_decode('Marca :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(42, 4, utf8_decode($result[0]['marca']), 1, 0, 'L');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, utf8_decode('Color :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(42, 4, utf8_decode($result[0]['color']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(23, 4,utf8_decode('Linea :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(23, 4, $result[0]['linea'], 1, 0, 'L');
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(25, 4, utf8_decode('Motor :'), 1, 0, 'L', 'true');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(52, 4, utf8_decode($result[0]['serie']), 1, 0, 'L');

        //FIN Recuadro VEHICULO
        //Recuadro OBSERVACIONES

        $pdf->SetFillColor(255);
        $pdf->RoundedRect(8, 225.5+$ln, 190, 12, 0, '0', 'DF');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->RoundedRect(8, 225.5+$ln, 25, 4, 3, '3', 'DF');
        

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, utf8_decode('Observaciones :'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 6);
  

        //FIN Recuadro OBSERVACIONES
        //Recuadro FIRMA     

        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(175, 4, null, 0, 0, 'L');
        $pdf->Cell(25, 4, utf8_decode('ORIGINAL'), 0, 0, 'L');
        
        $pdf->Ln(12);
        $pdf->Cell(10, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 0.1, null, 1, 0, 'L');
        $pdf->Cell(20, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 0.1, null, 1, 0, 'L');
        $pdf->Cell(10, 4, null, 0, 0, 'L');
        
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(10, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 1, utf8_decode('Firma/Huella Conductor'), 0, 0, 'C');
        $pdf->Cell(20, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 1, utf8_decode('Firmar Empresa'), 0, 0, 'C');
        $pdf->Cell(10, 4, null, 0, 0, 'L');

        
        $texto = "SEÑOR GENERADOR DE CARGA: Antes de entregar su mercancía, verifique los datos del conductor, del vehículo y el estado del mismo.";
        $texto_dos = "SEÑOR CONDUCTOR: Al firmar esta orden usted es responsable de la mercancía descrita. CERCIORESE que este completa y en perfectas.";

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 5);
        $pdf->Cell(120, 4, null, 0, 0, 'L');
        $pdf->Cell(70, 2, utf8_decode('Realizado por: Sistemas Informáticos & Soluciones Integrales S.A.S. - SI&SI.'), 0, 0, 'R');
        
        $pdf->Ln(1);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(190, 2,utf8_decode(substr($texto, 0, 180)), 0, 0, 'L');
        
        $pdf->Ln(2.5);
        $pdf->Cell(1, 4, null, 0, 0, 'L');
        $pdf->Cell(190, 2,utf8_decode(substr($texto_dos, 0, 180)), 0, 0, 'L');
        

        //FIN Recuadro FIRMA
    
        // Marca de Agua
        $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png',65,183.5,80,60);
        $pdf->Image('../../../framework/media/images/varios/tijeras.png',5,130.5,4,3);
        //FIN Marca de Agua

        //FIN Copia 2

        // Linea punteada
        $pdf->SetDash(1,1);
        $pdf->Line(1,132,215,132);
        //FIN Linea punteada 
     

        $pdf->Output();

    }

}

new Imp_OrdenCargue();

?>