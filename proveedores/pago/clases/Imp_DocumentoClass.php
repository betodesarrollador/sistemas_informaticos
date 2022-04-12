<?php

final class Imp_Documento
{

    private $Conex;

    public function __construct()
    {
        
    }

    public function printOut($Conex)
    {
        $this->Conex = $Conex;

        require_once "Imp_DocumentoLayoutClass.php";
        require_once "../../../framework/clases/fpdf/fpdf.php";
        require_once "Imp_DocumentoModelClass.php";

        $Layout = new Imp_DocumentoLayout();
        $Model = new Imp_DocumentoModel();

        $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];

        $encabezado = $Model->getEncabezado($encabezado_registro_id, $this->Conex);
        $imputaciones = $Model->getimputaciones($encabezado_registro_id, $this->Conex);
        $total = $Model->getTotal($encabezado_registro_id, $this->Conex);
        $valor_letras = $Model->getTotales($encabezado_registro_id, $this->Conex);

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter', 'mm');
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetMargins(7, 5, 5);
        $pdf->SetAutoPageBreak(true, 1);

        //if (trim($encabezado[0]['formapago']) == "CHEQUE") {

            $pdf->Ln(4);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(15, 5, null, 0, 0, 'R');
            $pdf->Cell(80, 5, null, 0, 0, 'L');
            $pdf->Cell(40, 5, str_replace('-', '   ', $encabezado[0]['fecha']), 0, 0, 'L');
            $pdf->Cell(30, 5, number_format($valor_letras[0]['total'], 2, ',', '.'), 0, 0, 'R');

            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(15, 5, null, 0, 0, 'R');
            $pdf->Cell(70, 10, utf8_decode($encabezado[0]['razon_social'] . ' ' . $encabezado[0]['primer_nombre'] . ' ' . $encabezado[0]['segundo_nombre'] . ' ' . $encabezado[0]['primer_apellido'] . ' ' . $encabezado[0]['segundo_apellido']), 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(15, 5, null, 0, 0, 'R');
            $pdf->Cell(200, 10, '' . strtoupper($Layout->num2letras($valor_letras[0]['total'])) . ' PESOS M/CTE', 0, 0, 'L');

            $pdf->SetX(40);
            $pdf->SetY(100);
            $pdf->Image($encabezado[0]['logo'], 8, 98, 40, 20);
        /*} else {
            $pdf->SetX(40);
            $pdf->SetY(10);
            $pdf->Image($encabezado[0]['logo'], 8, 8, 40, 20);

        }*/

        $pdf->Cell(45, 5, null, 0, 0, 'R');
        $pdf->SetFont('Arial', 'B', 7);

        $pdf->Cell(85, 5, utf8_decode($encabezado[0]['razon_social_emp']), 0, 0, 'C');
        $pdf->Cell(50, 5, utf8_decode($encabezado[0]['tipo_documento']), 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, $encabezado[0]['consecutivo'], 1, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 5, null, 0, 0, 'R');
        $pdf->Cell(85, 5, utf8_decode($encabezado[0]['nom_oficina']), 0, 0, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 5, null, 0, 0, 'R');
        $pdf->Cell(85, 5, $encabezado[0]['tipo_identificacion_emp'] . ':' . $encabezado[0]['numero_identificacion_emp'], 0, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 5, 'Fecha :', 1, 0, 'L');
        $pdf->Cell(65, 5, $encabezado[0]['fecha'], 1, 0, 'L');
        $pdf->Cell(25, 5, 'Ciudad :', 1, 0, 'L');
        $pdf->Cell(50, 5, $encabezado[0]['ciudad_ofi'], 1, 0, 'L');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 5, $encabezado[0]['texto_tercero'], 1, 0, 'L');
        $pdf->Cell(65, 5, utf8_decode($encabezado[0]['primer_nombre'] . ' ' . $encabezado[0]['segundo_nombre'] . ' ' . $encabezado[0]['primer_apellido'] . ' ' . $encabezado[0]['segundo_apellido'] . ' ' . $encabezado[0]['razon_social']), 1, 0, 'L');
        $pdf->Cell(25, 5, $encabezado[0]['tipo_identificacion_emp'], 1, 0, 'L');
        $pdf->Cell(50, 5, $encabezado[0]['numero_identificacion'], 1, 0, 'L');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 5, 'Concepto :', 1, 0, 'L');
        $pdf->Cell(140, 5, substr($encabezado[0]['concepto'], 0, 65), 1, 0, 'L');

        if (substr($encabezado[0]['concepto'], 65, 99) != '') {
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(200, 5, substr($encabezado[0]['concepto'], 65, 94), 1, 0, 'L');
        }
        if (substr($encabezado[0]['concepto'], 159, 94) != '') {
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(200, 5, substr($encabezado[0]['concepto'], 159, 94), 1, 0, 'L');
        }
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 5, 'Forma Pago :', 1, 0, 'L');
        $pdf->Cell(65, 5, $encabezado[0]['formapago'], 1, 0, 'L');
        $pdf->Cell(36, 5, $encabezado[0]['texto_soporte'], 1, 0, 'L');
        $pdf->Cell(39, 5, $encabezado[0]['numero_soporte'], 1, 0, 'L');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 5, 'Observaciones :', 1, 0, 'L');
        $pdf->Cell(140, 5, $encabezado[0]['observaciones'], 1, 0, 'L');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'CODIGO', 1, 0, 'C');
        $pdf->Cell(25, 5, 'TERCERO', 1, 0, 'C');
        $pdf->Cell(10, 5, 'CC', 1, 0, 'C');
        $pdf->Cell(89, 5, 'DETALLE', 1, 0, 'C');
        $pdf->Cell(28, 5, 'DEBITO', 1, 0, 'C');
        $pdf->Cell(28, 5, 'CREDITO', 1, 0, 'C');

        for ($i = 0; $i < count($imputaciones); $i++) {

            if (strlen($imputaciones[$i]['descripcion']) >= 80) {

                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 15, '', 1, 0, 'C');
                $pdf->Cell(25, 15, '', 1, 0, 'C');
                $pdf->Cell(10, 15, '', 1, 0, 'C');
                $pdf->Cell(89, 15, '', 1, 0, 'L');
                $pdf->Cell(28, 15, '', 1, 0, 'R');
                $pdf->Cell(28, 15, '', 1, 0, 'R');

                $pdf->Ln(0);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 5, $imputaciones[$i]['puc_cod'], 0, 0, 'C');
                $pdf->Cell(25, 5, $imputaciones[$i]['identificacion_tercero'], 0, 0, 'C');
                $pdf->Cell(10, 5, $imputaciones[$i]['codigo_cento'], 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(89, 5, substr($imputaciones[$i]['descripcion'], 0, 40), 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(28, 5, number_format($imputaciones[$i]['debito'], 2, ',', '.'), 0, 0, 'R');
                $pdf->Cell(28, 5, number_format($imputaciones[$i]['credito'], 2, ',', '.'), 0, 0, 'R');

                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 5, '', 0, 0, 'C');
                $pdf->Cell(25, 5, '', 0, 0, 'C');
                $pdf->Cell(10, 5, '', 0, 0, 'C');
                $pdf->Cell(89, 5, substr($imputaciones[$i]['descripcion'], 40, 44), 0, 0, 'L');
                $pdf->Cell(28, 5, '', 0, 0, 'R');
                $pdf->Cell(28, 5, '', 0, 0, 'R');

                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 5, '', 0, 0, 'C');
                $pdf->Cell(25, 5, '', 0, 0, 'C');
                $pdf->Cell(10, 5, '', 0, 0, 'C');
                $pdf->Cell(89, 5, substr($imputaciones[$i]['descripcion'], 84, 40), 0, 0, 'L');
                $pdf->Cell(28, 5, '', 0, 0, 'R');
                $pdf->Cell(28, 5, '', 0, 0, 'R');

            } elseif (strlen($imputaciones[$i]['descripcion']) > 40 && strlen($imputaciones[$i]['descripcion']) <= 79) {

                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 10, '', 1, 0, 'C');
                $pdf->Cell(25, 10, '', 1, 0, 'C');
                $pdf->Cell(10, 10, '', 1, 0, 'C');
                $pdf->Cell(89, 10, '', 1, 0, 'L');
                $pdf->Cell(28, 10, '', 1, 0, 'R');
                $pdf->Cell(28, 10, '', 1, 0, 'R');

                $pdf->Ln(0);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 5, $imputaciones[$i]['puc_cod'], 0, 0, 'C');
                $pdf->Cell(25, 5, $imputaciones[$i]['identificacion_tercero'], 0, 0, 'C');
                $pdf->Cell(10, 5, $imputaciones[$i]['codigo_cento'], 0, 0, 'C');
                $pdf->Cell(89, 5, substr($imputaciones[$i]['descripcion'], 0, 40), 0, 0, 'L');
                $pdf->Cell(28, 5, number_format($imputaciones[$i]['debito'], 2, ',', '.'), 0, 0, 'R');
                $pdf->Cell(28, 5, number_format($imputaciones[$i]['credito'], 2, ',', '.'), 0, 0, 'R');

                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 5, '', 0, 0, 'C');
                $pdf->Cell(25, 5, '', 0, 0, 'C');
                $pdf->Cell(10, 5, '', 0, 0, 'C');
                $pdf->Cell(89, 5, substr($imputaciones[$i]['descripcion'], 40, 40), 0, 0, 'L');
                $pdf->Cell(28, 5, '', 0, 0, 'R');
                $pdf->Cell(28, 5, '', 0, 0, 'R');

            } elseif (strlen($imputaciones[$i]['descripcion']) <= 40) {
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(20, 5, $imputaciones[$i]['puc_cod'], 1, 0, 'C');
                $pdf->Cell(25, 5, $imputaciones[$i]['identificacion_tercero'], 1, 0, 'C');
                $pdf->Cell(10, 5, $imputaciones[$i]['codigo_cento'], 1, 0, 'C');
                $pdf->Cell(89, 5, substr($imputaciones[$i]['descripcion'], 0, 40), 1, 0, 'L');
                $pdf->Cell(28, 5, number_format($imputaciones[$i]['debito'], 2, ',', '.'), 1, 0, 'R');
                $pdf->Cell(28, 5, number_format($imputaciones[$i]['credito'], 2, ',', '.'), 1, 0, 'R');

            }

        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, 'SUMAS IGUALES', 1, 0, 'C');
        $pdf->Cell(28, 5, number_format($total[0]['total_debito'], 2, ',', '.'), 1, 0, 'R');
        $pdf->Cell(28, 5, number_format($total[0]['total_credito'], 2, ',', '.'), 1, 0, 'R');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(200, 10, 'Valor en Letras : ' . $Layout->num2letras($valor_letras[0]['total']) . ' Pesos M/CTE', 1, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, 'Recibi', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');

        $elaboro = explode(" ", $encabezado[0]['modifica']);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 8, $elaboro[0], 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 8, $elaboro[1], 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 8, $elaboro[2], 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');
        $pdf->Cell(40, 8, '', 'LR', 0, 'C');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 8, 'Elaboro', 'LRB', 0, 'C');
        $pdf->Cell(40, 8, 'Reviso', 'LRB', 0, 'C');
        $pdf->Cell(40, 8, 'Aprobo', 'LRB', 0, 'C');
        $pdf->Cell(40, 8, 'C.C / NIT', 'LRB', 0, 'C');
        $pdf->Cell(40, 8, 'Huella', 'LRB', 0, 'C');

        $pdf->Output();

    }

}
new Imp_Documento();
