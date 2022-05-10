<?php

final class Imp_Manifiesto
{

    private $Conex;

    public function __construct($Conex)
    {
        $this->Conex = $Conex;
    }

    public function printOut()
    {

        require_once "Imp_ManifiestoLayoutClass.php";
        require_once "Imp_ManifiestoModelClass.php";
        require_once "../../../framework/clases/fpdf/fpdf.php";

        $Layout = new Imp_ManifiestoLayout();
        $Model = new Imp_ManifiestoModel();
        $manifiesto_id = $_REQUEST['manifiesto_id'];
        $ruta_id = $_REQUEST['ruta_id'];

        //   $Layout -> setIncludes();

        $manifiesto = $Model->getManifiesto($manifiesto_id, $this->Conex);
        $remesas = $Model->getRemesas($manifiesto_id, $this->Conex);
        $impuestos = $Model->getImpuestos($manifiesto_id, $this->Conex);
        $trafico = $Model->getTrafico($manifiesto_id, $this->Conex);
        $detalles = $Model->getDetalles($manifiesto_id, $ruta_id, $this->Conex);
        $hoja_tiempos = $Model->getHojadeTiempos($manifiesto_id, $this->Conex);
        $tiempos_cargue = $Model->getTiemposCargue($manifiesto_id, $this->Conex);

        //********************************************************************//
        //*************** Codigo para generar codigo QR inicio ***************//
        //********************************************************************//

        $Datos = $Model->getCodigoQR($manifiesto_id, $this->Conex);

        require_once "../../../framework/clases/QRcode/phpqrcode/phpqrcode.php";

        //Carpeta para guardar las imagenes
        $dir = "../../../imagenes/transporte/QRmanifiestos/";

        //el nombre de la imagen va a ser el numero de manifiesto
        $filename = $dir . $Datos[0]['manifiesto'] . '.png';

        //configuración de l aimagen

        $tamaño = 10; //Tamaño de Pixel
        $level = 'L'; //Precisión Baja
        $framSize = 3; //Tamaño en blanco

        $fecha = 'Fecha:' . str_replace("-", "/", $Datos[0]['fecha_mc']) . "\r\n";

        $remolque = strlen($Datos[0]['remolque']) > 0 ? 'Remolque:' . substr($Datos[0]['remolque'], 0, 6) . "\r\n" : '';

        $origen = 'Orig:' . substr($Datos[0]['origen'], 0, 20) . "\r\n";
        $destino = 'Dest:' . substr($Datos[0]['destino'], 0, 20) . "\r\n";

        $mercancia = 'Mercancia:' . substr($Datos[0]['producto'], 0, 30) . "\r\n" .

        $observaciones = strlen($Datos[0]['observacionesqr']) > 0 ? 'Obs:' . substr($Datos[0]['observacionesqr'], 0, 120) . "\r\n" : '';

        $empresa = 'Empresa:' . substr($Datos[0]['empresa'], 0, 30) . "\r\n";

        $contenido = 'MEC:' . $Datos[0]['aprobacion_ministerio2'] . "\r\n" .
            $fecha .
            'Placa:' . $Datos[0]['placa'] . "\r\n" .
            $remolque .
            'Config:' . $Datos[0]['configuracion'] . "\r\n" .
            $origen .
            $destino .
            $mercancia .
            'Conductor:' . $Datos[0]['id_conductor'] . "\r\n" .
            $empresa .
            $observaciones .
            'Seguro:' . $Datos[0]['seguridadqr'] . "\r\n";
        //Datos que debe llevar el QR

        /*$contenido = 'MEC:'.$Datos[0]['aprobacion_ministerio2']."\r\n".
        'Fecha:'.$Datos[0]['fecha_mc']."\r\n".
        'Placa:'.$Datos[0]['placa']."\r\n".
        $remolque.
        'Orig:'.$Datos[0]['origen']."\r\n".
        'Dest:'.$Datos[0]['destino']."\r\n".
        'Mercancia:'.$Datos[0]['producto']."\r\n".
        'Conductor:'.$Datos[0]['id_conductor']."\r\n".
        'Empresa:'.$Datos[0]['empresa']."\r\n".
        'Obs:'.$Datos[0]['observacionesqr']."\r\n".
        'Codigo:'.$Datos[0]['seguridadqr']."\r\n"
        ;*///Datos que debe llevar el QR

        //Creamos objeto de la clase QRCode
        $QRcode = new QRcode();
        //llamammos la función para generar la imagen
        $QRcode->png($contenido, $filename, $level, $tamaño, $framSize);

        //Asignamos la ruta de la imagen al layout
        $Layout->setCodigoQR($dir . basename($filename));

        //********************************************************************//
        //*************** Codigo para generar codigo QR final ****************//
        //********************************************************************//

        $numCodBar = str_pad($manifiesto[0]['manifiesto'], 8, "0", STR_PAD_LEFT);

        $pdf = new FPDF();
        $pdf->AddPage('L', 'A4', 'mm');
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetMargins(7, 5, 5);
        $pdf->SetAutoPageBreak(true, 1);
        $pdf->SetX(40);
        $pdf->SetY(10);

        $pdf->Image($manifiesto[0]['logo'], 18, 13, 38, 23);
        // $pdf->Image('../../../framework/media/images/varios/basc.jpg', 214, 22, 18, 18);
        $pdf->Image('../../../framework/media/images/varios/supertransporte.png', 13, 38, 50, 12);
        $pdf->Image('../../../framework/media/images/general/ministerioo.jpg', 169, 36, 35, 13);
        $pdf->Image($dir . basename($filename), 240, 14, 40, 40);
        // $pdf->RotatedImage('../../../framework/media/images/varios/supertransporte.png',1,68,35,13,90);

        // Cuadro Titulo
        $pdf->SetFillColor(255, 255, 255);

        $pdf->Ln(9);
        $pdf->Cell(123, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(75, 4, utf8_decode('"La impresión en soporte cartular (papel) de este acto administrativo'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(58, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 4, 'MANIFIESTO ELECTRONICO DE CARGA', 0, 0, 'C');
        $pdf->Cell(5, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(75, 4, utf8_decode('producido por medios electrónicos en cumplimiento de la ley 527 de 1999'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(123, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(75, 4, utf8_decode('(Articulos 6 al13) y de la ley 962 de 2005 (Articulo 6), es una reproducción'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(123, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(75, 4, utf8_decode('del documento original que se encuentra en formato electrónico firmado'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(123, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(75, 4, utf8_decode('digitalmente, cuya representación digital goza de autenticidad,'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(66, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4, 'Oficina: ' . utf8_decode($manifiesto[0]['oficina']) . ' - ' . 'Ciudad: ' . utf8_decode($manifiesto[0]['ciudad']), 0, 0, 'L');
        $pdf->Cell(11, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(75, 4, utf8_decode('integridad y no repudio."'), 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->Cell(66, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4, 'NIT: ' . $manifiesto[0]['numero_identificacion_empresa'], 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->Cell(66, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4, 'Dir :' . utf8_decode($manifiesto[0]['direccion']), 0, 0, 'L');
        $pdf->Cell(11, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(75, 4, 'Manifiesto: ' . $numCodBar, 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->Cell(66, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4, 'Tel :' . utf8_decode($manifiesto[0]['telefono']), 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->Cell(66, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(46, 4, 'Email :' . utf8_decode($manifiesto[0]['email']), 0, 0, 'L');
        $pdf->Cell(11, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 7);
        if ($manifiesto[0]['aprobacion_ministerio2'] != '') {
            $pdf->Cell(75, 4, utf8_decode('Autorización: ' . $manifiesto[0]['aprobacion_ministerio2']), 0, 0, 'L');
            if ($manifiesto[0]['id_mobile'] != '') {
                $pdf->Ln(3);
                $pdf->Cell(66, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', '', 6);
                $pdf->Cell(57, 4, 'ID MOBILE :' . utf8_decode($manifiesto[0]['id_mobile']), 0, 0, 'L');
            }
        } else {
            $pdf->SetFont('Arial', 'BI', 7);
            $pdf->Cell(75, 4, utf8_decode('ART. 10 DEL TITULO VII'), 0, 0, 'L');
            if ($manifiesto[0]['id_mobile'] != '') {
                $pdf->Ln(3);
                $pdf->Cell(66, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', '', 6);
                $pdf->Cell(57, 4, 'ID MOBILE :' . utf8_decode($manifiesto[0]['id_mobile']), 0, 0, 'L');
            } else {
                $pdf->Ln(3);
                $pdf->Cell(123, 4, null, 0, 0, 'C');
            }
            $pdf->SetFont('Arial', 'BI', 7);
            $pdf->Cell(75, 4, utf8_decode('RESOL. 0377 DE 2013'), 0, 0, 'L');
            $pdf->Ln(3);
            $pdf->Cell(60, 4, null, 0, 0, 'C');
            $pdf->SetFont('Arial', 'BIU', 7);
            $pdf->Cell(138, 4, substr(utf8_decode($manifiesto[0]['ultimo_error_reportando_ministario2']), 0, 108), 0, 0, 'L');
            $pdf->Ln(3);
            $pdf->Cell(60, 4, null, 0, 0, 'C');
            $pdf->Cell(138, 4, substr(utf8_decode($manifiesto[0]['ultimo_error_reportando_ministario2']), 108, 108), 0, 0, 'L');
            $pdf->Ln(3);
            $pdf->Cell(60, 4, null, 0, 0, 'C');
            $pdf->Cell(138, 4, substr(utf8_decode($manifiesto[0]['ultimo_error_reportando_ministario2']), 216, 108), 0, 0, 'L');
        }

        // Cuadro Titulo
        $ancho_gen = (count($remesas) * 4) + 60;
        //Cuadro 1
        // Fila 1
        $pdf->RoundedRect(10, 57, 268, $ancho_gen, 01, '', 'DF');

        $pdf->SetX(40);
        $pdf->SetY(57);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Fecha de Expedición'), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Tipo de Manifiesto'), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Origen del Viaje'), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Destino del Viaje'), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['fecha_mc']), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['tipo_manifiesto']), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['origen']), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['destino']), 1, 0, 'C');

        //Fila 2

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(268, 4, utf8_decode('INFORMACIÓN DEL VEHÍCULO Y CONDUCTOR'), 1, 0, 'C', 'true');

        //Fila 3

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Titular Manifiesto'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Identificación'), 1, 0, 'C');
        $pdf->Cell(100.5, 4, utf8_decode('Dirección'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Teléfono'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Ciudad'), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['titular_manifiesto']), 1, 0, 'L');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['numero_identificacion_titular_manifiesto']), 1, 0, 'C');
        $pdf->Cell(100.5, 4, substr(utf8_decode($manifiesto[0]['direccion_titular_manifiesto']), 0, 58), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['telefono_titular_manifiesto']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['ciudad_titular_manifiesto']), 1, 0, 'C');

        //Fila 4

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Placa'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Marca'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Semirremolque'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Configuración'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Peso Vacío'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Cia. de Seguros SOAT'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('No. Póliza'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Fecha Vence SOAT'), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['placa']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['marca']), 1, 0, 'C');
        if ($manifiesto[0]['placa_remolque'] != '') {
            $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['placa_remolque']), 1, 0, 'C');
        } else {
            $pdf->Cell(33.5, 4, utf8_decode('N/A'), 1, 0, 'C');
        }
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['configuracion']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['peso_vacio']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, substr(utf8_decode($manifiesto[0]['nombre_aseguradora']), 0, 20), 1, 0, 'L');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['numero_soat']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['vencimiento_soat']), 1, 0, 'C');

        /* if (strlen($manifiesto[0]['nombre_aseguradora']) > 40 && strlen($manifiesto[0]['nombre_aseguradora']) < 60) {

            $pdf->Ln(4);
            $pdf->Cell(3, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, substr(utf8_decode($manifiesto[0]['nombre_aseguradora']), 20, 21), 0, 0, 'L');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');

        } else if (strlen($manifiesto[0]['nombre_aseguradora']) > 60) {

            $pdf->Ln(4);
            $pdf->Cell(3, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, substr(utf8_decode($manifiesto[0]['nombre_aseguradora']), 21, 20), 0, 0, 'L');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Ln(4);
            $pdf->Cell(3, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, substr(utf8_decode($manifiesto[0]['nombre_aseguradora']), 41, 20), 0, 0, 'L');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');
            $pdf->Cell(33.5, 4, null, 0, 0, 'C');

        } */

        // Fila 5

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Conductor'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Identificación'), 1, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Dirección'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Teléfono'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Licencia'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Ciudad'), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['nombre']), 1, 0, 'L');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['numero_identificacion_conductor']), 1, 0, 'C');
        $pdf->Cell(67, 4, substr(utf8_decode($manifiesto[0]['direccion_conductor']), 0, 58), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['telefono_conductor']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['numero_licencia_cond']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['ciudad_conductor']), 1, 0, 'C');

        // Fila 6

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('Tenedor'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Identificación'), 1, 0, 'C');
        $pdf->Cell(100.5, 4, utf8_decode('Dirección'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Teléfono'), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Ciudad'), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode($manifiesto[0]['tenedor']), 1, 0, 'L');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['numero_identificacion_tenedor']), 1, 0, 'C');
        $pdf->Cell(100.5, 4, substr(utf8_decode($manifiesto[0]['direccion_tenedor']), 0, 58), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['telefono_tenedor']), 1, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode($manifiesto[0]['ciudad_tenedor']), 1, 0, 'C');

        //Fila 7

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(268, 4, utf8_decode('INFORMACIÓN DE LA MERCANCÍA TRANSPORTADA'), 1, 0, 'C', 'true');

        $pdf->SetFillColor(255, 255, 255);
        /* $ancho_remesas = (count($remesas) * 4) + 4;
        $pdf->RoundedRect(10, 113, 268, $ancho_remesas, 0, '', 'DF'); */

        //Fila 8

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(148, 4, utf8_decode('Información de la Mercancía'), 1, 0, 'C');
        $pdf->Cell(50, 4, utf8_decode('Información Remitente'), 1, 0, 'C');
        $pdf->Cell(50, 4, utf8_decode('Información Destintario'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Dueño Póliza'), 1, 0, 'C');

        //Fila 9
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'BI', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Nro. Remesa'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Und. Medida'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Cantidad'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Naturaleza'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('Empaque'), 1, 0, 'C');
        $pdf->Cell(28, 4, utf8_decode('P. Transportado'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('NIT/CC'), 1, 0, 'C');
        $pdf->Cell(30, 4, utf8_decode('Nre/R.Social'), 1, 0, 'C');
        $pdf->Cell(20, 4, utf8_decode('NIT/CC'), 1, 0, 'C');
        $pdf->Cell(30, 4, utf8_decode('Nre/R.Social'), 1, 0, 'C');
        $pdf->Cell(20, 4, null, 0, 0, 'C');
        $pdf->SetFillColor(255, 255, 255);

        if (count($remesas) <= 3) {

            for ($i = 0; $i < count($remesas); $i++) {

                //Fila 10
                $pdf->Ln(4);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(3, 4, null, 0, 0, 'C');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['numero_remesa']), 1, 0, 'C');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['medida']), 1, 0, 'C');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['peso']), 1, 0, 'C');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['cantidad']), 1, 0, 'C');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['naturaleza']), 1, 0, 'C');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['empaque']), 1, 0, 'C');
                $pdf->Cell(28, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 0, 15), 1, 0, 'L');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['doc_remitente']), 1, 0, 'C');
                $pdf->Cell(30, 4, substr(utf8_decode($remesas[$i]['remitente']), 0, 15), 1, 0, 'L');
                $pdf->Cell(20, 4, utf8_decode($remesas[$i]['doc_destinatario']), 1, 0, 'C');
                $pdf->Cell(30, 4, substr(utf8_decode($remesas[$i]['destinatario']), 0, 15), 1, 0, 'L');
                $pdf->Cell(20, 4, substr(utf8_decode($remesas[$i]['dueno_poliza']), 0, 12), 0, 0, 'L');

            }

        } else {

            // for ($i = 0; $i < count($remesas); $i++) {
            //Fila 10
            $pdf->Ln(4);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(3, 4, null, 0, 0, 'C');
            $pdf->Cell(268, 4, utf8_decode($remesas[0]['numero_remesa'] . ' - ' . $remesas[1]['numero_remesa'] . ' - ' . $remesas[2]['numero_remesa'] . ' - ' . $remesas[3]['numero_remesa'] . ' - ' . $remesas[4]['numero_remesa'] . ' - ' . $remesas[5]['numero_remesa'] . ' - ' . $remesas[6]['numero_remesa'] . ' - ' . $remesas[7]['numero_remesa'] . ' - ' . $remesas[8]['numero_remesa'] . ' - ' . $remesas[9]['numero_remesa'] . ' - ' . $remesas[10]['numero_remesa']), 1, 0, 'C');

            // }
        }

        //Cuadro 1

        //Cuadro 2
        $ancho = (count($impuestos) * 4) + 16;
        $ancho_cuadro = (count($remesas) * 4) + 117;
        $pdf->RoundedRect(10, $ancho_cuadro, 67, $ancho, 0, '', 'DF');
        $pdf->RoundedRect(77, $ancho_cuadro, 67, $ancho, 0, '', 'DF');
        $pdf->RoundedRect(144, $ancho_cuadro, 67, $ancho, 0, '', 'DF');
        $pdf->RoundedRect(211, $ancho_cuadro, 67, $ancho, 0, '', 'DF');

        //Fila 1

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, utf8_decode('VALORES'), 1, 0, 'C', 'true');
        $pdf->Cell(67, 4, utf8_decode('DETALLES DEL PAGO'), 1, 0, 'C', 'true');
        $pdf->Cell(67, 4, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 'true');
        $pdf->Cell(67, 4, utf8_decode('FOTOS'), 1, 0, 'C', 'true');
        $pdf->SetFillColor(255, 255, 255);

        //Fila 2

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Valor a Pagar Pactado'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33.5, 4, '$' . number_format($manifiesto[0]['valor_flete'], 0, ',', '.'), 0, 0, 'R');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 4, utf8_decode('Lugar Pago del Saldo'), 0, 0, 'L');
        $pdf->Cell(4, 4, null, 0, 0, 'C');
        $pdf->Cell(30, 4, utf8_decode('Fecha Pago del Saldo'), 0, 0, 'L');
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(67, 4, substr(utf8_decode($manifiesto[0]['observaciones']), 0, 38), 0, 0, 'L');

        //Fila 3

        for ($i = 0; $i < count($impuestos); $i++) {

            if ($i == 0) {
                $pdf->Ln(4);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(3, 4, null, 0, 0, 'C');
                $pdf->Cell(33.5, 4, utf8_decode($impuestos[$i]['nombre']), 0, 0, 'L');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(33.5, 4, '$' . number_format($impuestos[$i]['valor'], 0, ',', '.'), 0, 0, 'R');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(30, 4, substr(utf8_decode($manifiesto[0]['lugar_pago_saldo']), 0, 38), 0, 0, 'C');
                $pdf->Cell(4, 4, null, 0, 0, 'C');
                $pdf->Cell(30, 4, substr(utf8_decode($manifiesto[0]['fecha_pago_saldo']), 0, 38), 0, 0, 'C');
            } else {
                $pdf->Ln(4);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(3, 4, null, 0, 0, 'C');
                $pdf->Cell(33.5, 4, utf8_decode($impuestos[$i]['nombre']), 0, 0, 'L');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(33.5, 4, '$' . number_format($impuestos[$i]['valor'], 0, ',', '.'), 0, 0, 'R');
            }
        }

        //Fila 4

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Valor Neto a Pagar'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33.5, 4, '$' . number_format($manifiesto[0]['valor_neto_pagar'], 0, ',', '.'), 0, 0, 'R');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 4, utf8_decode('Cargue Pagado Por'), 0, 0, 'L');
        $pdf->Cell(4, 4, null, 0, 0, 'C');
        $pdf->Cell(30, 4, utf8_decode('Descargue Pagado Por'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, substr(utf8_decode('LA EMPRESA, NO AUTORIZA EXCEDER LA CAPACIDAD DEL VEHÍCULO'), 0, 45), 0, 0, 'L');

        //Fila 5

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Valor Anticipo'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33.5, 4, '$' . number_format($manifiesto[0]['valor_anticipo'], 0, ',', '.'), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(30, 4, substr(utf8_decode($manifiesto[0]['cargue_pagado_por']), 0, 38), 0, 0, 'C');
        $pdf->Cell(4, 4, null, 0, 0, 'C');
        $pdf->Cell(30, 4, substr(utf8_decode($manifiesto[0]['descargue_pagado_por']), 0, 38), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(67, 4, substr(utf8_decode('LA EMPRESA, NO AUTORIZA EXCEDER LA CAPACIDAD DEL VEHÍCULO'), 45, 38), 0, 0, 'L');

        //Fila 6

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(33.5, 4, utf8_decode('Saldo a Pagar'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33.5, 4, '$' . number_format($manifiesto[0]['saldo_por_pagar'], 0, ',', '.'), 0, 0, 'R');

        $ancho_imagenes = 11;
        $alto_imagenes = 15;
        $pos_imagenes = 117.5;
        for ($i = 0; $i < count($impuestos); $i++) {
            $ancho_imagenes += 4;
            $alto_imagenes += 4;
        }
        for ($i = 0; $i < count($remesas); $i++) {
            $pos_imagenes += 4;
        }

        if ($manifiesto[0]['foto_conductor'] != '') {
            $pdf->Image($manifiesto[0]['foto_conductor'], 220, $pos_imagenes, $ancho_imagenes, $alto_imagenes);
        } else {
            $pdf->Image('../../../framework/media/images/varios/noimageavailable.jpg', 220, $pos_imagenes, $ancho_imagenes, $alto_imagenes);
        }

        if ($manifiesto[0]['foto_vehiculo'] != '') {
            $pdf->Image($manifiesto[0]['foto_vehiculo'], 250, $pos_imagenes, $ancho_imagenes, $alto_imagenes);
        } else {
            $pdf->Image('../../../framework/media/images/varios/noimageavailable.jpg', 250, $pos_imagenes, $ancho_imagenes, $alto_imagenes);
        }

        //Cuadro 2

        //Cuadro 3

        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(118, 4, utf8_decode('Valor a Pagar Pactado en Letras'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(150, 4, $Layout->num2letras($manifiesto[0]['valor_flete']) . ' Pesos M/CTE', 1, 0, 'L');

        //Cuadro 3

        //Cuadro 4
        $ancho_cuadro = (count($remesas) * 4) + (count($impuestos) * 4) + 141;
        $pdf->RoundedRect(10, $ancho_cuadro, 53.6, 24, 0, '', 'DF');
        $pdf->RoundedRect(63.6, $ancho_cuadro, 53.6, 24, 0, '', 'DF');
        $pdf->RoundedRect(117.2, $ancho_cuadro, 53.6, 24, 0, '', 'DF');
        $pdf->RoundedRect(170.8, $ancho_cuadro, 53.6, 24, 0, '', 'DF');
        $pdf->RoundedRect(224.4, $ancho_cuadro, 53.6, 24, 0, '', 'DF');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Si es victima de algún fraude o conoce de alguna'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('irregularidaden  el  registro  nacional  de  despachos'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('de  carga  RNDC,denúncielo a la Superintendencia de'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Puertos y Transporte, enla línea gratuita nacional'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('018000 915615 ya través del correoelectrónico'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella titular del manifiesto'), 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella coductor'), 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella despachador'), 0, 0, 'C');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(3, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('atencionciudadano@supertransporte.gov.co'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, null, 0, 0, 'L');
        $pdf->Cell(53.6, 4, utf8_decode('CC:'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, utf8_decode('CC:'), 0, 0, 'L');
        $pdf->Cell(53.6, 4, utf8_decode('CC:'), 0, 0, 'L');

        $ancho_cuadro = (count($remesas) * 4) + (count($impuestos) * 4) + 161;
        $pdf->Line(126, $ancho_cuadro, 161, $ancho_cuadro);
        $pdf->Line(181, $ancho_cuadro, 214, $ancho_cuadro);
        $pdf->Line(234, $ancho_cuadro, 269, $ancho_cuadro);

        //Cuadro 4

        $pdf->Ln(4.5);
        $pdf->SetFont('Arial', '', 5);
        $pdf->Cell(2, 4, null, 0, 0, 'C');
        $pdf->Cell(298, 4, utf8_decode('reportese oportunamente en los puestos de control, de lo contrario se genera una multa de $ 50.000 por cada uno, ver anexo en hoja de control de ruta. favor regresar los cumplidos y/o comodatos firmados, maximo cinco (05) dias despues de iniciado el viaje; de no hacerlo se multara con el 3% del valor del flete. autorizacion de consulta y'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(2, 4, null, 0, 0, 'C');
        $pdf->Cell(298, 4, utf8_decode('verificacion de la informacion: autorizo expresamente a ' . $manifiesto[0]['razon_social'] . '. PARA QUE LA INFORMACION SUMINISTRADA POR EL BANCO DE DATOS, QUE TIENE CARACTER ESTRICTAMENTE PERSONAL Y COMERCIAL, SEA CONSULTADA Y VERIFICADA CON TERCERAS PERSONAS'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(2, 4, null, 0, 0, 'C');
        $pdf->Cell(298, 4, utf8_decode('INCLUYENDO LOS BANCOS DE DATOS, IGUALMENTE PARA QUE LA MISMA SEA USADA Y PUESTA EN CIRCULACIÓN CON FINES ESTRICTAMENTE COMERCIALES Y LABORALES. TAMBIEN AUTORIZO EXPRESAMENTE PARA QUE EN CASO DE INCUMPLIMIENTO DE LAS OBLIGACIONES SEA REPORTADO'), 0, 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell(2, 4, null, 0, 0, 'C');
        $pdf->Cell(298, 4, utf8_decode('AL BANCO DE DATOS DE DATASERVIP, COLFECAR Y CUALQUIER OTRO.'), 0, 0, 'L');

        // Marca de Agua
        $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png', 92, 85, 100, 80);
        //FIN Marca de Agua

        ////////////////Siguiente Hoja/////////////////////////////

        $pdf->AddPage('L', 'A4', 'mm');
        $pdf->SetFont('Arial', '', 5);
        $pdf->SetMargins(10, 5, 10);
        $pdf->SetAutoPageBreak(true, 1);

        //version
        $pdf->Cell(45, 4, 'SGCS - PESV', 0, 0, 'C');
        $pdf->Cell(45, 4, 'F - OPS - 008', 0, 0, 'C');
        $pdf->Cell(45, 4, utf8_decode('V3 - 15/01/2018'), 0, 0, 'C');

        //Titulo
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(110, 3, 'CONTRATO DE VINCULACION TEMPORAL PARA EL SERVICIO DE TRANSPORTE TERRESTRE DECARGA', 0, 'L');

        //Primer columna de texto
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Multicell(135, 3, utf8_decode('Entre los suscritos ' . $manifiesto[0]['razon_social'] . ' identificada con ' . $manifiesto[0]['numero_identificacion'] . ' en adelante LA EMPRESA y el señor ' . $manifiesto[0]['nombre'] . ' identificado con Cedula de Ciudadanía número ' . $manifiesto[0]['numero_identificacion_conductor'] . ' PLACA DEL VEHÍCULO  ' . $manifiesto[0]['placa'] . ' PLACA DEL TRÁILER O REMOLQUE ' . $manifiesto[0]['placa_remolque'] . ' en adelante EL CONTRATISTA se ha celebrado el siguiente contrato. *PRIMERO-OBJETO; El CONTRATISTA se compromete a prestar el servicio de transporte terrestre de carga en la ruta asignada y su vinculación será transitoria desde el momento del cargue de la mercancía hasta su entrega en el destino según los términos, tiempos y condiciones económicas definidas en el manifiesto de carga expedido por LA EMPRESA. *SEGUNDO- ALCANCE: EL CONTRATISTA se compromete a cumplir estrictamente con las políticas, protocolos y buenas prácticas de seguridad vial y la operación en la cadena de suministro definidas en los numerales I), II), III) y IV) del presente contrato. *TERCERO-FORMA DE PAGO; LA EMPRESA se compromete a realizar los pagos acordados en los términos definidos en el manifiesto de carga expedido por LA EMPRESA. *CUARTO-INCUMPLIMIENTO Y SANCIONES: LA EMPRESA podrá exigir al CONTRATISTA el pago de los valores económicos resultantes de Averías y Faltantes a la carga que sean causadas por negligencia o malas prácticas en la prestación del servicio objeto del contrato. *QUINTO-AUTONOMIA TECNICA Y  ADMINISTRATIVA: EL CONTRATISTA manifiesta tener autonomía técnica y administrativa para el desarrollo del CONTRATO en la ruta definida por el manifiesto de carga. *SEXTO-DECLARACIONES Y AUTORIZACIONES: EL CONTRATISTA Autoriza a LA EMPRESA de manera expresa, voluntaria y permanente a consultar, solicitar, reportar, divulgar y transmitir a las bases o bancos de datos y centrales de riesgos y demás entidades públicas y privadas con funciones de vigilancia y control cuyo fin sea proveer información referente al comportamiento e historial en los contratos, relaciones comerciales, infracciones de tránsito, accidentes e incidentes de tránsito, así como mis hábitos de entrega, cuidado, prevención y manejo de dineros o bienes en los contratos y el manejo de la información personal necesaria para el estudio, análisis y eventual celebración de contratos con LA EMPRESA o terceros relacionados con el objeto social de LA EMPRESA de acuerdo a lo establecido en su política de tratamiento de datos.'), 0, 'J');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(110, 3, 'I. CONDICIONES PARA EL CONDUCTOR CONTRATISTA', 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Multicell(135, 3, utf8_decode('a) EL CONTRATISTA manifiesta encontrarse en óptimas condiciones físicas y mentales para el desarrollo de la RUTA CONTRATADA. En caso de modificación o alteración de su estado de salud lo reportara con oportunidad a LA EMPRESA.' . "\n" . 'b) EL CONTRATISTA permite la Toma de Pruebas de Alcoholemia y sustancias psicoactivas cuando LA EMPRESA estime conveniente, como mecanismo de control de la seguridad de las operaciones y la seguridad vial.' . "\n" . 'c) EL CONTRATISTA realizará a su costo una vez al año la toma de exámenes de control PSICOMETRICOS; Audiometría, Visiometria, Examen de coordinaciónmotriz, examen de psicología y los entregara a LA EMPRESA cuando sean requeridos.' . "\n" . 'd) EL CONTRATISTA portará los pagos vigentes de afiliación al sistema general de salud, riesgos laborales y pensiones y los presentará en caso de ser solicitados.'), 0, 'J');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(110, 3, utf8_decode('II. CONDICIONES PARA EL VEHÍCULO O EQUIPO CONTRATISTA'), 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Multicell(135, 3, utf8_decode('a) Garantizar que las condiciones tecnicomecanicas del vehículo son óptimas para desarrollo de la RUTA CONTRATADA Y declara desarrollar un Plan de Mantenimiento como mínimo BIMENSUAL de forma PREVENTIVA y CORRECTIVO de acuerdo a la necesidad en talleres idóneos de acuerdo a las características del vehículo (Ficha técnica del fabricante) y naturaleza de los mantenimientos efectuados y presentara los registros de su ejecución a LA EMPRESA. En caso de ser solicitado en su inspección y auditoria. Así mismo El Contratista se compromete a mantener vigentes los permisos, pólizas de responsabilidad civil extracontractual,SOAT, licencias necesarias para desarrollar la Ruta contratada.' . "\n" . 'b) EL CONTRATISTA Permitirá que funcionarios de LA EMPRESA realicen la inspección PREOPERACIONAL del vehículo y del tráiler con el objetivo degarantizar sus condiciones técnicas y mecánicas que prevengan Accidentes de tránsito y contaminación del despacho con mercancías o cargas de sustancias ilícitas.' . "\n" . 'c) El Contratista NO El Contratista NO debe manipular o alterar el dispositivo GPS del vehículo durante el trayecto contratado.'), 0, 'J');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(110, 3, 'III. CONDICIONES PARA LA RUTA CONTRATADA', 0, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Multicell(135, 3, utf8_decode('a) Reportarse personalmente en los puestos de control asignados durante la ruta contratada.' . "\n" . 'b) El Contratista se compromete a usar el equipo de comunicación celular UNICAMENTE con dispositivo MANOS LIBRES y contestar las llamadas demonitoreo, Está prohibido TEXTEAR (CHAT, e-mail, otros medios   "Redes sociales") durante la actividad de conducción.' . "\n" . 'c) El Contratista se compromete a Cumplir con las normas y código de tránsito aplicables en la legislación nacional y local (pico y placa, otros) incluido el uso de cinturón de seguridad y los límites de velocidad definidos en la Vía tanto en trayectos urbanos y nacionales, así mismo reportar cualquier infracción de tránsito que le haya sido impuesta en el transcurso de la Ruta contratada.'), 0, 'J');

        $pdf->SetX(150);
        $pdf->SetY(22);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->Multicell(135, 3, utf8_decode('d) Pernoctar y realizar las paradas en los sitios autorizados por Control Tráfico Los sitios de parada y pernoctada deben ser confiables para garantizar la integridad personal, la de la Carga y la del vehículo.' . "\n" . 'e) Realizar por lo menos cada tres (3) horas paradas de descanso que permitan mantener su concentración, estado físico y mental, que garanticen su atención en la vía transitada contribuyendo de esta manera con la prevención de accidentes detránsito.' . "\n" . 'f) No está permitido lavar el vehículo durante la ruta.' . "\n" . 'g) El Contratista es responsable por verificar que el vehículo sea cargado con elpeso máximo permitido por el Ministerio de Transporte, en caso contrario reportar la novedad a LA EMPRESA antes de iniciar la ruta.' . "\n" . 'h) Cumplir con el retorno de la documentación (Remesa, manifiesto, hoja detiempos, factura cliente, otros) máximo 24 horas después del descargue para despachos URBANOS y 48 horas para despachos NACIONALES. Toda novedad,faltante o avería debe ser reportada en los documentos soporte del despacho.' . "\n" . 'i) NOVEDADES CON ACCIDENTES DE TRANSITO; En caso de presentarse,reportar inmediatamente a la Policía y brindar atención a las víctimas o afectados dela misma, realizar los reportes solicitados y conservar copia de los mismos en caso de ser requeridos por LA EMPRESA. NOVEDADES con la RUTA; en casos de retrasos en la vía (accidentes - cierres de vía, asonada, paros, otros); El cambio de ruta solo se da con autorización de la empresa al igual que: NOVEDADES con el CONDUCTOR Cambio de conductor debido a cambios en su estado de salud que afecten la continuidad del viaje. NOVEDADES con el EQUIPO Cambio debido a Fallas mecánicas, varadas, etc. NOVEDADES con la CARGA, Faltantes, mermas, averías, hurto o saqueo.' . "\n" . 'j) Se compromete a realizar antes, durante y en las zonas de parqueo y paradas, rondas de inspección del vehículo con el fin de garantizar la integridad de la carga, verificando los precintos de seguridad, el estado de la carga, intrusión de materialeso carga no autorizados o ilícitos y revisar que el vehículo no haya sufrido alteraciones mecánicas e informar inmediatamente cualquier irregularidad detectada.'), 0, 'J');

        $pdf->Ln(10);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(110, 3, utf8_decode('IV. CONDICIONES DE PRESERVACIÓN DE LA CARGA'), 0, 'L');

        $pdf->Ln(3);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Multicell(135, 3, utf8_decode('a) Presentarse en los sitios de cargue y descargue en la fecha y hora señalada y realizar la salida a ruta según las instrucciones de LA EMPRESA.' . "\n" . 'b) No transportar cargas diferentes a las relacionadas en los documentos soportes entregados por LA EMPRESA y el Generador de carga. Mantener siempre contacto visual con el vehículo y no abandonar la carga.'), 0, 'J');

        $pdf->Ln(17);
        $pdf->Cell(210, 4, null, 0, 0, 'C');
        $pdf->Cell(20, 25, null, 1, 0, 'C');

        $pdf->Ln(17);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella del Contratista.'), 0, 0, 'C');

        $pdf->Line(156, 141, 210, 141);

        // Marca de Agua
        $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png', 92, 75, 100, 80);
        //FIN Marca de Agua

        ////////////////Siguiente Hoja/////////////////////////////

        $pdf->AddPage('L', 'A4', 'mm');
        $pdf->SetFont('Arial', '', 5);
        $pdf->SetMargins(10, 5, 10);
        $pdf->SetAutoPageBreak(true, 1);

        //version
        $pdf->Cell(45, 4, 'SGCS - PESV', 0, 0, 'C');
        $pdf->Cell(45, 4, 'F - OPS - 008', 0, 0, 'C');
        $pdf->Cell(45, 4, utf8_decode('V3 - 15/01/2018'), 0, 0, 'C');

        //Titulo
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(110, 3, 'POLITICA DE SEGURIDAD EN RUTA DE ' . $manifiesto[0]['razon_social'] . ' ACUERDO DE COMPROMISO PARA CONDUCTORES', 0, 'J');

        //Primer columna de texto
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(36, 4, utf8_decode('MANIFIESTO DE CARGA N°'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(16, 4, $manifiesto[0]['manifiesto'], 0, 0, 'L');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(14, 4, utf8_decode('ORIGEN'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(20, 4, $manifiesto[0]['origen'], 0, 0, 'L');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(14, 4, utf8_decode('DESTINO'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(20, 4, $manifiesto[0]['destino'], 0, 0, 'L');
        $pdf->SetTextColor(0);

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Multicell(110, 3, utf8_decode('Yo, ' . $manifiesto[0]['nombre'] . ' Identificado con c.c N° ' . $manifiesto[0]['numero_identificacion_conductor'] . '' . "\n" . 'Me comprometo a cumplir con las normas establecidas por la ' . $manifiesto[0]['razon_social'] . ' relacionadas :'), 0, 'J');

        $pdf->Ln(5);
        $pdf->Multicell(135, 3, utf8_decode('COMPROMISOS (Sección 1):'), 0, 'L');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('1)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Cuando sea necesario realizar una parada no programada se debe  garantizar que el sitio ofrezca las condiciones de seguridad para el vehículo y la carga.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('2)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Pernoctar y parquear en lugares indicados por Control Tráfico.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('3)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('No lavar el vehículo durante la ruta establecida.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('4)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Seguir los horarios establecidos por la empresa.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('5)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('No llevar acompañantes ni a los escoltas en la cabina.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('6)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Comunicar inmediatamente a la oficina que gener&oacute; el despacho cualquier cambio de conductor'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('7)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Informar a control tráfico el inicio, y termino del recorrido, informar si hay novedades durante el recorrido ó entrega de la mercancía.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('8)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Reportarme personalmente en los puestos de control establecidos en el plan de ruta (ver sanciones).'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('9)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Portar un celular encendido con minutos disponibles, en caso de cambio de numero actualizarlo.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('10)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('No ingerir bebidas embriagantes ni sustancias alucinógenas durante la ruta, y en los lugares de pernoctada'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('11)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Entregar los cumplidos máximo 24 horas despacho urbano y 48 horas nacional, después de la entrega al responsable o enviarlos por correo a las oficinas.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('12)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Portar documentos de servicio de salud al cual me encuentro afiliado (EPS y ARP).'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('13)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Garantizar que las puertas de la cabina permanezcan siempre aseguradas durante todo el recorrido.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('14)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('De presentarse devolución por averia ó faltante de producto y sea registrado en la remesa o manifiesto, responderé por los valores económicos declarados en los documentos de la carga.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 3, utf8_decode('15)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Regresar el material de amarre proporcionado por ' . $manifiesto[0]['razon_social'] . ': lazos,    tablas, estibas, kits.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('16)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('El conductor es responsable de verificar que su vehículo sea cargado con el peso máximo permitido por el Ministerio de Transporte.'), 0, 'J');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 6, utf8_decode('17)'), 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(130, 3, utf8_decode('Al cargar contenedores vacíos el conductor debe realizar la respectiva inspección para descartar compartimentos ocultos y el transporte de mercancías ilícitas.'), 0, 'J');

        $pdf->Ln(8);
        $pdf->Multicell(130, 3, utf8_decode('Declaro que al vehículo se le ha efectuado el mantenimiento tecno-mecánico requerido para quepermanezca operando con normalidad durante el trayecto  asignado.'), 0, 'J');
        $pdf->Ln(3);
        $pdf->Multicell(130, 3, utf8_decode('Me comprometo a iniciar viaje a las ' . $manifiesto[0]['hora_estimada_salida'] . ' del día ' . $manifiesto[0]['hora_estimada_salida'] . ' y a permanecer con la caravana.'), 0, 'J');

        $pdf->Ln(17);
        $pdf->Cell(80, 4, null, 0, 0, 'C');
        $pdf->Cell(20, 25, null, 1, 0, 'C');

        $pdf->Ln(15);
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella.'), 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->Cell(7, 4, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Celular:'), 0, 0, 'L');

        $pdf->Line(10, 177, 64, 177);
        $pdf->Line(28, 187, 55, 187);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Multicell(135, 4, utf8_decode('FAVOR TENER EN CUENTA LAS RECOMENDACIONES DE LA CARTILLA DE INDUCCION A TRANSPORTISTAS'), 0, 'C');

        // Marca de Agua
        $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png', 92, 75, 100, 80);
        //FIN Marca de Agua

        $pdf->SetX(150);
        $pdf->SetY(20);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(126, 4, utf8_decode($manifiesto[0]['razon_social']), 0, 'C');

        $pdf->Ln(3);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 3, utf8_decode('Fecha: '), 1, 0, 'L');
        $pdf->Cell(24, 3, utf8_decode($trafico[0]['fecha_inicial_salida']), 1, 0, 'C');
        $pdf->Cell(14, 3, utf8_decode('Hora: '), 1, 0, 'L');
        $pdf->Cell(18, 3, utf8_decode($trafico[0]['hora_inicial_salida']), 1, 0, 'C');
        $pdf->Cell(32, 3, utf8_decode($trafico[0]['tipo_doc']), 1, 0, 'L');
        $pdf->Cell(20, 3, utf8_decode($trafico[0]['num_doc']), 1, 0, 'C');

        $pdf->Ln(3);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 4, utf8_decode('Placa: '), 1, 0, 'L');
        $pdf->Cell(24, 4, utf8_decode($trafico[0]['placa']), 1, 0, 'C');
        $pdf->Cell(14, 4, utf8_decode('Tipo: '), 1, 0, 'L');
        $pdf->Cell(18, 4, utf8_decode($trafico[0]['configuracion']), 1, 0, 'C');
        $pdf->Cell(32, 4, utf8_decode('Caracteristicas'), 1, 0, 'L');
        $pdf->Cell(20, 4, utf8_decode($trafico[0]['linea_vehiculo']), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 4, utf8_decode('Conductor: '), 1, 0, 'L');
        $pdf->Cell(108, 4, utf8_decode($manifiesto[0]['nombre']), 1, 0, 'L');

        $pdf->Ln(4);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(63, 4, utf8_decode('Nombre del Conductor: '), 1, 0, 'L');
        $pdf->Cell(63, 4, utf8_decode('Firma: '), 1, 0, 'L');

        $pdf->Ln(4);
        $pdf->Cell(145, 8, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(63, 8, utf8_decode($manifiesto[0]['nombre']), 1, 0, 'L');
        $pdf->Cell(63, 8, null, 1, 0, 'L');

        $pdf->Ln(8);
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[0]['tipo_punto']), 1, 'L');
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[2]['tipo_punto']), 1, 'L');
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[4]['tipo_punto']), 1, 'L');
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[6]['tipo_punto']), 1, 'L');
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[8]['tipo_punto']), 1, 'L');
        $pdf->Cell(145, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[10]['tipo_punto']), 1, 'L');

        $pdf->SetX(163);
        $pdf->SetY(50);
        $pdf->Cell(208, 4, null, 0, 0, 'C');
        $pdf->Multicell(63, 4, utf8_decode($detalles[1]['tipo_punto']), 1, 'L');
        $pdf->Cell(208, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[3]['tipo_punto']), 1, 'L');
        $pdf->Cell(208, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[5]['tipo_punto']), 1, 'L');
        $pdf->Cell(208, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[7]['tipo_punto']), 1, 'L');
        $pdf->Cell(208, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[9]['tipo_punto']), 1, 'L');
        $pdf->Cell(208, 4, null, 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(63, 4, utf8_decode($detalles[11]['tipo_punto']), 1, 'L');

        ////////////////Siguiente Hoja/////////////////////////////

        $pdf->AddPage('L', 'A4', 'mm');
        $pdf->SetFont('Arial', '', 5);
        $pdf->SetMargins(10, 5, 10);
        $pdf->SetAutoPageBreak(true, 1);

        //version
        $pdf->Cell(45, 4, 'SGCS - PESV', 0, 0, 'C');
        $pdf->Cell(45, 4, 'F - OPS - 008', 0, 0, 'C');
        $pdf->Cell(45, 4, utf8_decode('V3 - 15/01/2018'), 0, 0, 'C');

        $pdf->RoundedRect(16, 12, 92, 24, 0, '', 'DF');
        $pdf->RoundedRect(100, 12, 92, 24, 0, '', 'DF');
        $pdf->RoundedRect(184, 12, 92, 24, 0, '', 'DF');
        $pdf->RoundedRect(234, 48, 42, 12, 0, '', 'DF');
        $pdf->RoundedRect(192, 52, 42, 8, 0, '', 'DF');

        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(6, 8, null, 0, 0, 'C');
        $pdf->Cell(84, 8, null, 0, 0, 'C');
        $pdf->Cell(84, 8, null, 0, 0, 'C');
        $pdf->Cell(92, 8, utf8_decode('Número Eletrónico Manifiesto de Carga'), 1, 0, 'C');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(6, 8, null, 0, 0, 'C');
        $pdf->Cell(84, 8, null, 0, 0, 'C');
        $pdf->Cell(84, 8, 'Hoja de Tiempos', 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(92, 8, utf8_decode($manifiesto[0]['manifiesto']), 1, 0, 'C');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(6, 8, null, 0, 0, 'C');
        $pdf->Cell(84, 8, null, 0, 0, 'C');
        $pdf->Cell(84, 8, null, 0, 0, 'C');
        $pdf->Cell(92, 8, utf8_decode('COD. EMPRESA (4 DIGITOS) CONSECUTIVO (8 DIGITOS)'), 1, 0, 'C');

        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(176, 4, utf8_decode('Datos de la Empresa'), 1, 0, 'C');
        $pdf->Cell(42, 4, utf8_decode('Tipo de Manifiesto'), 1, 0, 'C');
        $pdf->Cell(42, 4, utf8_decode('Número Interno '), 0, 'L');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(18, 4, utf8_decode('Empresa: '), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(66, 4, utf8_decode($manifiesto[0]['razon_social']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(15, 4, utf8_decode('Sigla: '), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(37, 4, utf8_decode($manifiesto[0]['sigla']), 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(15, 4, utf8_decode('Nit: '), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 4, utf8_decode($manifiesto[0]['numero_identificacion_empresa']), 1, 0, 'C');
        $pdf->Cell(42, 4, utf8_decode($manifiesto[0]['tipo_manifiesto']), 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(42, 3, utf8_decode('Empresa Transporte'), 0, 'L');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(18, 4, utf8_decode('Dirección: '), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(66, 4, utf8_decode($manifiesto[0]['direccion']), 1, 0, 'L');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(15, 4, utf8_decode('Ciudad: '), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(37, 4, utf8_decode($manifiesto[0]['ciudad']), 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(15, 4, utf8_decode('Teléfono: '), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 4, utf8_decode($manifiesto[0]['telefono']), 1, 0, 'C');
        $pdf->Cell(42, 4, null, 0, 0, 'C');
        $pdf->Cell(42, 3, utf8_decode($manifiesto[0]['codigo_empresa']), 0, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(260, 4, utf8_decode('PLAZOS Y TIEMPOS'), 1, 0, 'C', 'true');

        $tam = 72;
        for ($i = 0; $i < count($tiempos_cargue); $i++) {

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(260, 4, utf8_decode('No. Remesa ' . ' #' . $remesas[$i]['numero_remesa']), 1, 0, 'C', 'true');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(130, 4, utf8_decode('Cargue'), 1, 0, 'C');
        $pdf->Cell(130, 4, utf8_decode('Descargue'), 1, 0, 'C');

        $pdf->SetFillColor(255, 255, 255);
        $pdf->RoundedRect(16, $tam, 33.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(49.2, $tam, 25.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(74.4, $tam, 25.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(99.6, $tam, 22.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(121.8, $tam, 24.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(146, $tam, 33.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(179.2, $tam, 25.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(204.4, $tam, 25.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(229.6, $tam, 22.2, 12, 0, '', 'DF');
        $pdf->RoundedRect(251.8, $tam, 24.2, 12, 0, '', 'DF');

        $tam+=28;

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(33.2, 4, utf8_decode('Plazo Horas'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Llegada Al'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Salida Del'), 0, 0, 'C');
        $pdf->Cell(22.2, 4, null, 0, 0, 'C');
        $pdf->Cell(24.2, 4, null, 0, 0, 'C');
        $pdf->Cell(32.2, 4, utf8_decode('Plazo Horas'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Llegada Al'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Salida Del'), 0, 0, 'C');
        $pdf->Cell(23.2, 4, null, 0, 0, 'C');
        $pdf->Cell(24.2, 4, null, 0, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(33.2, 4, utf8_decode('Pactadas Cargue'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Lugar Descargue'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Lugar Descargue'), 0, 0, 'C');
        $pdf->Cell(22.2, 4, utf8_decode('Conductor'), 0, 0, 'C');
        $pdf->Cell(24.2, 4, utf8_decode('Quién entrega'), 0, 0, 'C');
        $pdf->Cell(32.2, 4, utf8_decode('Pactadas Cargue'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Lugar Descargue'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, utf8_decode('Lugar Descargue'), 0, 0, 'C');
        $pdf->Cell(23.2, 4, utf8_decode('Conductor'), 0, 0, 'C');
        $pdf->Cell(24.2, 4, utf8_decode('Quién recibe'), 0, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(33.2, 4, utf8_decode('(Incluye tiempo de espera)'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, null, 0, 0, 'C');
        $pdf->Cell(25.2, 4, null, 0, 0, 'C');
        $pdf->Cell(22.2, 4, null, 0, 0, 'C');
        $pdf->Cell(24.2, 4, null, 0, 0, 'C');
        $pdf->Cell(32.2, 4, utf8_decode('(Incluye tiempo de espera)'), 0, 0, 'C');
        $pdf->Cell(25.2, 4, null, 0, 0, 'C');
        $pdf->Cell(25.2, 4, null, 0, 0, 'C');
        $pdf->Cell(23.2, 4, null, 0, 0, 'C');
        $pdf->Cell(24.2, 4, null, 0, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(33.2, 4, null, 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Fecha'), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Hora'), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Fecha'), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Hora'), 1, 0, 'C');
        $pdf->Cell(22.2, 4, utf8_decode('Firma'), 1, 0, 'C');
        $pdf->Cell(24.2, 4, utf8_decode('Firma'), 1, 0, 'C');
        $pdf->Cell(33.2, 4, null, 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Fecha'), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Hora'), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Fecha'), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode('Hora'), 1, 0, 'C');
        $pdf->Cell(22.2, 4, utf8_decode('Firma'), 1, 0, 'C');
        $pdf->Cell(24.2, 4, utf8_decode('Firma'), 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(231, 231, 231);
        $pdf->Cell(6, 4, null, 0, 0, 'C');
        $pdf->Cell(33.2, 4, $tiempos_cargue[$i]['horas_pactadas_cargue'], 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['fecha_llegada_lugar_cargue']), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['hora_llegada_lugar_cargue']), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['fecha_salida_lugar_cargue']), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['hora_salida_lugar_cargue']), 1, 0, 'C');
        $pdf->Cell(22.2, 4, null, 1, 0, 'C');
        $pdf->Cell(24.2, 4, null, 1, 0, 'C');
        $pdf->Cell(33.2, 4, $tiempos_cargue[$i]['horas_pactadas_descargue'], 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['fecha_llegada_lugar_descargue']), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['hora_llegada_lugar_descargue']), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['fecha_salida_lugar_descargue']), 1, 0, 'C');
        $pdf->Cell(12.6, 4, utf8_decode($tiempos_cargue[$i]['hora_salida_lugar_descargue']), 1, 0, 'C');
        $pdf->Cell(22.2, 4, null, 1, 0, 'C');
        $pdf->Cell(24.2, 4, null, 1, 0, 'C');

        }

        
        $pdf->SetX(40);
        $pdf->SetY(183);
        $pdf->Cell(110, 4, null, 0, 0, 'C');
        $pdf->Cell(15, 20, null, 1, 0, 'C');
        $pdf->Cell(110, 4, null, 0, 0, 'C');
        $pdf->Cell(15, 20, null, 1, 0, 'C');

        $pdf->Ln(16);
        $pdf->Cell(42, 6, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella del Conductor.'), 0, 0, 'C');
        $pdf->Cell(70, 6, null, 0, 0, 'C');
        $pdf->Cell(53.6, 4, utf8_decode('Firma y Huella de la Empresa.'), 0, 0, 'C');

        $pdf->Line(51, 198, 105, 198);
        $pdf->Line(175, 198, 228, 198);

        // Marca de Agua
        $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png', 92, 75, 100, 80);
        //FIN Marca de Agua
        $pdf->Image($manifiesto[0]['logo'], 37, 13, 36, 21);

        $pdf->Output();

    }

}

new Imp_Manifiesto();
?>