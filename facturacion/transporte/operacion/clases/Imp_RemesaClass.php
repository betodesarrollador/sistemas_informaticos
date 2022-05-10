<?php

final class Imp_Remesa
{

    private $Conex;

    public function __construct($Conex)
    {
        $this->Conex = $Conex;
    }

    public function printOut($usuario, $empresa_id, $oficina_id, $nit_empresa)
    {

        //require_once("Imp_RemesaLayoutClass.php");
        require_once "Imp_RemesaModelClass.php";
        require_once "../../../framework/clases/fpdf/fpdf.php";
        require_once "../../../framework/clases/barcode.php";

        //  $Layout  = new Imp_RemesaLayout();
        $Model = new Imp_RemesaModel();
        $barcode = new barcode();

        $remesas = $Model->getRemesas($oficina_id, $this->Conex);

        for ($i = 0; $i < count($remesas); $i++) {

            foreach ($remesas[$i] as $llave => $valor) {

                if ($llave == 'numero_remesa') {
                    $barcode->setParams("$valor");
                    $remesas[$i]['codbar'] = $barcode->getUrlImageCodBar();
                }

            }

        }

//      $Layout -> setRemesas($remesas,$usuario);
        //    $Layout -> setOficinas($Model -> getOficinas($empresa_id,$this -> Conex));

        //$Layout -> RenderMain();

        $pdf = new FPDF(); // Crea un objeto de la clase fpdf()
        $pdf->AddPage('P', 'Letter', 'mm'); // Agrega una hoja al documento.
        $pdf->SetFont('Arial', 'B', 10); //Establece la fuente a utilizar, el formato Negrita y el tama�o

        #Establecemos los m�rgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 5, 5);

        #Establecemos el margen inferior:
        $pdf->SetAutoPageBreak(true, 1);
        $salto_ini = 85;
        for ($i = 0; $i < count($remesas); $i++) {

            if ($i > 0) {
                $pdf->AddPage('P', 'Letter', 'mm');
            }

            for ($j = 0; $j < 3; $j++) {

                $salto = ($salto_ini * $j);

                $pdf->SetDash(0, 0);
                // Copia 1
                $pdf->SetX(40);
                $pdf->SetY(15 + $salto);
                $pdf->Image($remesas[$i]['logo'], 15, 13 + $salto, 28, 13);
                // $pdf->Image('../../../framework/media/images/varios/basc.jpg', 90, 3, 18, 18);
                $pdf->RotatedImage('../../../framework/media/images/varios/supertransporte.png', 1, 71 + $salto, 35, 13, 90);

                // Cuadro de fecha color
                $pdf->SetFillColor(232, 232, 232);
                $pdf->RoundedRect(43, 15 + $salto, 25, 4, 2, '1234', 'DF');
                // Cuadro de fecha color

                $pdf->Ln(0.5);
                $pdf->Cell(34, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(25, 4, 'Fecha: ' . utf8_decode($remesas[$i]['fecha_remesa']), 0, 0, 'L');

                $pdf->Ln(3.5);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(34, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 6);
                $pdf->Cell(42, 4, 'NIT: ' . $remesas[$i]['numero_identificacion'], 0, 0, 'L');
                $pdf->Cell(50, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(23, 8, 'REMESA DE CARGA', 0, 0, 'R');

                $pdf->Ln(2);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(34, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 6);
                $pdf->Cell(42, 4, utf8_decode($remesas[$i]['direccion']) . ' - ' . utf8_decode($remesas[$i]['ciudad']), 0, 0, 'L');

                $pdf->Ln(2);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(34, 4, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 6);
                $pdf->Cell(42, 4, utf8_decode($remesas[$i]['email']), 0, 0, 'L');
                $pdf->Image($remesas[$i]['codbar'], 165, 16 + $salto, 40, 7);
                $pdf->Cell(79, 4, null, 0, 0, 'C');
                $pdf->SetTextColor(255, 0, 0);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(40, 4, /* $remesas[$i]['tipo_remesa'] . " - " . $remesas[$i]['prefijo_rm'] .  */$remesas[$i]['numero_remesa'], 0, 0, 'C');
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', '', 6);

                // Cuadro 1
                $pdf->SetFillColor(255);
                $pdf->RoundedRect(15, 28 + $salto, 93, 17, 2, '1234', 'DF');
                $pdf->RoundedRect(112, 28 + $salto, 93, 17, 2, '1234', 'DF');
                $pdf->SetFillColor(230, 230, 230);
                $pdf->RoundedRect(112, 28 + $salto, 4, 16.9, 2, '14', 'DF');
                $pdf->RoundedRect(14.9, 28 + $salto, 4, 16.9, 2, '14', 'DF');
                $pdf->SetFillColor(240, 240, 240);
                $pdf->RoundedRect(116, 28 + $salto, 22, 16.9, 2, '', 'F');
                $pdf->RoundedRect(19, 28 + $salto, 22, 16.9, 2, '', 'F');
                $pdf->SetFont('Helvetica', 'B', 7);
                $pdf->TextWithRotation(18, 43.5 + $salto, "REMITENTE", 90, 0);
                $pdf->SetFont('Helvetica', 'B', 6);
                $pdf->TextWithRotation(115, 44.5 + $salto, "DESTINATARIO", 90, 0);

                // Fila 1 Cuadro 1

                $pdf->Ln(6);
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(9, 3, null, 0, 0, 'C');
                $pdf->Cell(22, 3, "Origen :", 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['origen']), 0, 34), 0, 0, 'L');
                $pdf->Cell(8, 3, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(22, 3, "Destino :", 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['destino']), 0, 26), 0, 0, 'L');

                // Fila 2 Cuadro 1

                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(9, 3, null, 0, 0, 'C');
                $pdf->Cell(22, 3, "Remitente :", 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['remitente']), 0, 50), 0, 0, 'L');
                $pdf->Cell(8, 3, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(22, 3, "Destinatario :", 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['destinatario']), 0, 50), 0, 0, 'L');

                // Fila 3 Cuadro 1

                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(9, 3, null, 0, 0, 'C');
                $pdf->Cell(22, 3, utf8_decode("Dirección :"), 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['direccion_remitente']), 0, 34), 0, 0, 'L');
                $pdf->Cell(8, 3, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(22, 3, utf8_decode("Dirección :"), 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['direccion_destinatario']), 0, 26), 0, 0, 'L');

                // Fila 4 Cuadro 1

                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(9, 3, null, 0, 0, 'C');
                $pdf->Cell(22, 3, utf8_decode("Teléfono :"), 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['telefono_remitente']), 0, 34), 0, 0, 'L');
                $pdf->Cell(8, 3, null, 0, 0, 'C');
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(22, 3, utf8_decode("Teléfono :"), 0, 0, 'L');
                $pdf->SetFont('Helvetica', '', 6);
                $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['telefono_destinatario']), 0, 26), 0, 0, 'L');

                if ($remesas[$i]['manifiesto'] != '') {

                    // Fila 5 Cuadro 1

                    $pdf->Ln(3);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(9, 3, null, 0, 0, 'C');
                    $pdf->Cell(22, 3, utf8_decode("Planilla :"), 0, 0, 'L');
                    $pdf->SetFont('Helvetica', '', 6);
                    $pdf->Cell(28, 3, substr(utf8_decode('# ' . $remesas[$i]['manifiesto']), 0, 34), 0, 0, 'L');
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(11, 3, utf8_decode("Placa :"), 0, 0, 'L');
                    $pdf->SetFont('Helvetica', '', 6);
                    $pdf->Cell(28, 3, substr(utf8_decode($remesas[$i]['placa']), 0, 34), 0, 0, 'L');
                    $pdf->Cell(8, 3, null, 0, 0, 'C');
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(22, 3, utf8_decode("Conductor :"), 0, 0, 'L');
                    $pdf->Cell(67, 3, substr(utf8_decode($remesas[$i]['conductor']), 0, 40), 0, 0, 'L');
                } else {
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(9, 3, null, 0, 0, 'C');
                }

                // Cuadro 2

                $tamaño = (strlen($remesas[$i]['descripcion_producto'])) / 47;


                if ($tamaño > 1 && $tamaño < 2 || $tamaño < 1) {
                    $tamaño = (((intval($tamaño)+1) * 4) + 4);
                    $l=5.5;
                }else{
                    $tamaño = 16;
                    $l = 5.5;
                }

                // exit($tamaño.' - '.$l.'si');

                $pdf->SetFillColor(255);
                $pdf->RoundedRect(15, 46 + $salto, 190, $tamaño, 2, '1234', 'DF');
                $pdf->SetFillColor(232, 232, 232);
                $pdf->RoundedRect(15, 46 + $salto, 190, 4, 2, '12', 'DF');

                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'BI', 7);
                $pdf->Cell(5, 4, null, 0, 0, 'L');
                $pdf->Cell(16, 4, utf8_decode('Código'), 0, 0, 'C');
                $pdf->Cell(88, 4, utf8_decode('Descripción'), 1, 0, 'C');
                $pdf->Cell(22, 4, utf8_decode('Naturaleza'), 1, 0, 'C');
                $pdf->Cell(18, 4, utf8_decode('U. Empaque'), 1, 0, 'C');
                $pdf->Cell(16, 4, utf8_decode('U. Medida'), 1, 0, 'C');
                $pdf->Cell(14, 4, utf8_decode('Peso'), 1, 0, 'C');
                $pdf->Cell(16, 4, utf8_decode('Cantidad'), 0, 0, 'C');
                $pdf->Ln(4.5);
                $pdf->SetFont('Arial', '', 7);
                if (strlen($remesas[$i]['descripcion_producto']) > 58 && strlen($remesas[$i]['descripcion_producto']) < 116) {
                    $pdf->Cell(21, 4, null, 0, 0, 'C');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 0, 58), 0, 0, 'L');
                    $pdf->Ln(4);
                    $pdf->Cell(5, 4, null, 0, 0, 'L');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['codigo']), 0, 0, 'C');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 58, 58), 0, 0, 'L');
                    $pdf->Cell(22, 4, utf8_decode($remesas[$i]['naturaleza']), 0, 0, 'C');
                    $pdf->Cell(18, 4, utf8_decode($remesas[$i]['empaque']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['medida']), 0, 0, 'C');
                    $pdf->Cell(14, 4, utf8_decode($remesas[$i]['peso']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['cantidad']), 0, 0, 'C');
                } elseif (strlen($remesas[$i]['descripcion_producto']) > 116 && strlen($remesas[$i]['descripcion_producto']) < 174) {
                    $pdf->Cell(21, 4, null, 0, 0, 'C');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 0, 58), 0, 0, 'L');
                    $pdf->Ln(4);
                    $pdf->Cell(5, 4, null, 0, 0, 'L');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['codigo']), 0, 0, 'C');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 58, 58), 0, 0, 'L');
                    $pdf->Cell(22, 4, utf8_decode($remesas[$i]['naturaleza']), 0, 0, 'C');
                    $pdf->Cell(18, 4, utf8_decode($remesas[$i]['empaque']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['medida']), 0, 0, 'C');
                    $pdf->Cell(14, 4, utf8_decode($remesas[$i]['peso']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['cantidad']), 0, 0, 'C');
                    $pdf->Ln(4);
                    $pdf->Cell(21, 4, null, 0, 0, 'L');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 116, 58), 0, 0, 'L');
                } elseif (strlen($remesas[$i]['descripcion_producto']) > 174 ) {
                    $pdf->Cell(21, 4, null, 0, 0, 'C');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 0, 58), 0, 0, 'L');
                    $pdf->Ln(4);
                    $pdf->Cell(5, 4, null, 0, 0, 'L');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['codigo']), 0, 0, 'C');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 58, 58), 0, 0, 'L');
                    $pdf->Cell(22, 4, utf8_decode($remesas[$i]['naturaleza']), 0, 0, 'C');
                    $pdf->Cell(18, 4, utf8_decode($remesas[$i]['empaque']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['medida']), 0, 0, 'C');
                    $pdf->Cell(14, 4, utf8_decode($remesas[$i]['peso']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['cantidad']), 0, 0, 'C');
                    $pdf->Ln(4);
                    $pdf->Cell(21, 4, null, 0, 0, 'L');
                    $pdf->Cell(88, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 116, 58), 0, 0, 'L');
                } else {
                    $pdf->Cell(25, 4, utf8_decode($remesas[$i]['codigo']), 0, 0, 'C');
                    $pdf->Cell(83, 4, substr(utf8_decode($remesas[$i]['descripcion_producto']), 0, 46), 0, 0, 'L');
                    $pdf->Cell(22, 4, utf8_decode($remesas[$i]['naturaleza']), 0, 0, 'C');
                    $pdf->Cell(18, 4, utf8_decode($remesas[$i]['empaque']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['medida']), 0, 0, 'C');
                    $pdf->Cell(14, 4, utf8_decode($remesas[$i]['peso']), 0, 0, 'C');
                    $pdf->Cell(16, 4, utf8_decode($remesas[$i]['cantidad']), 0, 0, 'C');
                }
                if ($values != 'S') {
                    // Cuadro 3

                    $pdf->SetFillColor(255);
                    $pdf->RoundedRect(15, 47 + $tamaño + $salto, 93, 20, 2, '1234', 'DF');
                    $pdf->RoundedRect(112, 47 + $tamaño + $salto, 93, 20, 2, '1234', 'DF');

                    $pdf->SetFillColor(232, 232, 232);
                    $pdf->RoundedRect(15, 47 + $tamaño + $salto, 27, 4, 2, '13', 'DF');

                    $pdf->Ln($l);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(5, 3, null, 0, 0, 'L');
                    $pdf->Cell(25, 3, utf8_decode('Observaciones :'), 0, 0, 'L');
                    
                    $pdf->Ln(4);
                    $pdf->SetFont('Arial', '', 6);
                    $pdf->Cell(5, 3, null, 0, 0, 'L');
                    $pdf->Cell(90, 3, substr(utf8_decode($remesas[$i]['observaciones']), 0, 60), 0, 0, 'L');
                    
                    $pdf->Ln(4);
                    $pdf->SetFont('Arial', '', 6);
                    $pdf->Cell(5, 3, null, 0, 0, 'L');
                    $pdf->Cell(90, 3, substr(utf8_decode($remesas[$i]['observaciones']), 60, 60), 0, 0, 'L');
                  
                    $pdf->Ln(4);
                    $pdf->SetFont('Arial', '', 6);
                    $pdf->Cell(5, 3, null, 0, 0, 'L');
                    $pdf->Cell(90, 3, substr(utf8_decode($remesas[$i]['observaciones']), 120, 60), 0, 0, 'L');

                    $pdf->Ln(3.5);
                    $pdf->SetFont('Arial', '', 6);
                    $pdf->Cell(107, 4, null, 0, 0, 'L');
                    $pdf->Cell(35, 1, utf8_decode('Recibe y Acepta Conforme'), 0, 0, 'C');
                    $pdf->Cell(13, 4, null, 0, 0, 'L');
                    $pdf->Cell(35, 1, utf8_decode('Firma/Huella Conductor'), 0, 0, 'C');
                    $pdf->Cell(5, 4, null, 0, 0, 'L');

                    $pdf->Ln(3.5);
                    $pdf->SetFont('Arial', '', 5);
                    $pdf->Cell(125.5, 4, null, 0, 0, 'L');
                    $pdf->Cell(70, 2, utf8_decode('Realizado por: Sistemas Informáticos & Soluciones Integrales S.A.S. - SI&SI.'), 0, 0, 'R');

                    // Marca de Agua
                    $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png', 80, 34.5 + $salto, 60, 40);
                    //FIN Marca de Agua

                    // Linea Firma
                    $pdf->Line(117, 61 + $salto+$tamaño, 152, 61 + $salto+$tamaño);
                    $pdf->Line(165, 61 + $salto+$tamaño, 200, 61 + $salto+$tamaño);
                    // Linea Firma
                    // Linea punteada
                    $pdf->SetDash(1, 1);
                    if ($j < 2) {
                        $pdf->Image('../../../framework/media/images/varios/tijeras.png', 5, 88.5 + $salto, 4, 3);
                        $pdf->Line(1, 90 + $salto, 215, 90 + $salto);
                    }
                    // Linea punteada
                    if ($j == 0) {
                        $pdf->Ln(0.1);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(5, 3, null, 0, 0, 'C');
                        $pdf->Cell(190, 3, "EMPRESA", 0, 0, 'C');
                    } else if ($j == 1) {
                        $pdf->Ln(0.1);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(5, 3, null, 0, 0, 'C');
                        $pdf->Cell(190, 3, "CLIENTE", 0, 0, 'C');
                    } else if ($j == 2) {
                        $pdf->Ln(0.1);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(5, 3, null, 0, 0, 'C');
                        $pdf->Cell(190, 3, "TRANSPORTADORA", 0, 0, 'C');
                    }

                } else {
                    // Cuadro 3

                    $pdf->SetFillColor(255);
                    $pdf->RoundedRect(15, 47 + $tamaño + $salto, 46.5, 20, 2, '1234', 'DF');
                    $pdf->RoundedRect(63.5, 47 + $tamaño + $salto, 93, 20, 2, '1234', 'DF');
                    $pdf->RoundedRect(158.5, 47 + $tamaño + $salto, 46.5, 20, 2, '1234', 'DF');

                    $pdf->SetFillColor(232, 232, 232);
                    $pdf->RoundedRect(15, 47 + $tamaño + $salto, 22, 4, 2, '13', 'DF');

                    $pdf->Ln($l);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(5, 3, null, 0, 0, 'L');
                    $pdf->Cell(25, 3, utf8_decode('Observaciones :'), 0, 0, 'L');
                    $pdf->Cell(165, 3, null, 0, 0, 'L');

                    $pdf->Ln(7.8);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(155, 3, null, 0, 0, 'L');
                    $pdf->Cell(20, 3, utf8_decode('Valor Declarado :'), 0, 0, 'R');
                    $pdf->Cell(20, 3, number_format($remesas[$i]['valor'], 0, ',', '.'), 0, 0, 'R');

                    $pdf->Ln(2.8);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(155, 3, null, 0, 0, 'L');
                    $pdf->Cell(20, 3, utf8_decode('Valor Flete :'), 0, 0, 'R');
                    $pdf->Cell(20, 3, number_format($remesas[$i]['valor_liq_flete1'], 0, ',', '.'), 0, 0, 'R');

                    $pdf->Ln(2.8);
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(155, 3, null, 0, 0, 'L');
                    $pdf->Cell(20, 3, utf8_decode('Valor Seguro :'), 0, 0, 'R');
                    $pdf->Cell(20, 3, number_format($remesas[$i]['valor_liq_seguro1'], 0, ',', '.'), 0, 0, 'R');

                    $pdf->Ln(2.8);
                    $pdf->SetFont('Arial', '', 6);
                    $pdf->Cell(58, 4, null, 0, 0, 'L');
                    $pdf->Cell(35, 4, utf8_decode('Recibe y Acepta Conforme'), 0, 0, 'C');
                    $pdf->Cell(13, 4, null, 0, 0, 'L');
                    $pdf->Cell(35, 4, utf8_decode('Firma/Huella Conductor'), 0, 0, 'C');
                    $pdf->Cell(14, 4, null, 0, 0, 'L');
                    $pdf->SetFont('Arial', 'BI', 7);
                    $pdf->Cell(20, 3, utf8_decode('Valor Total :'), 0, 0, 'R');
                    $pdf->Cell(20, 3, number_format($remesas[$i]['valor_liq_total1'], 0, ',', '.'), 0, 0, 'R');

                    $pdf->Ln(3.5);
                    $pdf->SetFont('Arial', '', 5);
                    $pdf->Cell(125.5, 4, null, 0, 0, 'L');
                    $pdf->Cell(70, 2, utf8_decode('Realizado por: Sistemas Informáticos & Soluciones Integrales S.A.S. - SI&SI.'), 0, 0, 'R');

                    // Marca de Agua
                    $pdf->Image('../../../framework/media/images/varios/logoMarcaAguaTransAlejandria.png', 80, 34.5 + $salto, 60, 40);
                    //FIN Marca de Agua

                    // Linea Firma
                    $pdf->Line(68, 64 + $salto+$tamaño, 103, 64 + $salto+$tamaño);
                    $pdf->Line(116, 64 + $salto+$tamaño, 151, 64 + $salto+$tamaño);
                    // $pdf->Line(167, 72 + $salto, 202, 72 + $salto);
                    // Linea Firma
                    // Linea punteada
                    $pdf->SetDash(1, 1);
                    if ($j < 2) {
                        $pdf->Image('../../../framework/media/images/varios/tijeras.png', 5, 88.5 + $salto, 4, 3);
                        $pdf->Line(1, 90 + $salto, 215, 90 + $salto);
                    }
                    // Linea punteada
                    if ($j == 0) {
                        $pdf->Ln(0.1);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(5, 3, null, 0, 0, 'C');
                        $pdf->Cell(190, 3, "EMPRESA", 0, 0, 'C');
                    } else if ($j == 1) {
                        $pdf->Ln(0.1);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(5, 3, null, 0, 0, 'C');
                        $pdf->Cell(190, 3, "CLIENTE", 0, 0, 'C');
                    } else if ($j == 2) {
                        $pdf->Ln(0.1);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(5, 3, null, 0, 0, 'C');
                        $pdf->Cell(190, 3, "TRANSPORTADORA", 0, 0, 'C');
                    }
                }

                // fin copia 1
            }

        }

        $pdf->Output(); //Env�a como salida del documento

    }

}

new Imp_Remesa();
