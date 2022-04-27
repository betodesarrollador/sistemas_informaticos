<?php
require_once "../../../framework/clases/ControlerClass.php";

final class tablaProtocolos extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main()
    {

        require_once "ProtocolosModelClass.php";

        $Model = new ProtocolosModel();

        $Data = $Model->selectProtocolos($this->getConex());

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Data); $i++) {

            $descripcion = "<input type='hidden' name='protocolo_id' id='protocolo_id' value=" . $Data[$i]["protocolo_id"] . "><textarea placeholder='Descripcion' class='form-control' name='descripcion' id='descripcion'>" . $Data[$i]["descripcion"] . "</textarea>";

            $nombre = "<textarea placeholder='Nombre' class='form-control' name='nombre' id='nombre'>" . $Data[$i]["nombre"] . "</textarea>";

            if ($Data[$i]["archivo"] != '') {

                $archivo = "<a class='badge badge-info' href=" . $Data[$i]["archivo"] . " target='_blank'>Ver Adjunto</a>&emsp;<input type='file' class='form-control' name='archivo' id='archivo' >";

            } else {

                $archivo = "<input type='file' class='form-control' name='archivo' id='archivo' >";

            }

            if ($Data[$i]["video"] != '') {

                $video = "<a class='badge badge-info' href=" . $Data[$i]["video"] . " target='_blank'>Ver Video</a>&emsp;<input type='file' class='form-control' name='video' id='video' >";

            } else {

                $video = "<input type='file' class='form-control' name='video' id='video' >";

            }

            $button = "<button type='button' class='btn btn-success btn-sm' onclick='save(this)'><i class='fa fa-check-circle'></i>&emsp;Guardar</button>";

            $datosJson .= '[
                "' . $nombre . '",
                "' . $descripcion . '",
                "' . $archivo . '",
                "' . $video . '",
                "' . $button . '"
              ],
              ';

        }

        
        $nombre = "<textarea placeholder='Nombre' class='form-control' name='nombre' id='nombre'></textarea>";
        $descripcion = "<input type='hidden' name='protocolo_id' id='protocolo_id' ><textarea placeholder='Descripcion' class='form-control' name='descripcion' id='descripcion'></textarea>";
        $archivo = "<input type='file' class='form-control' name='archivo' id='archivo' >";
        $video = "<input type='file' class='form-control' name='video' id='video' >";
        $button = "<button type='button' class='btn btn-success btn-sm' onclick='save(this)'><i class='fa fa-check-circle'></i>&emsp;Guardar</button>";


        $datosJson .= '[
            "' . $nombre . '",
            "' . $descripcion . '",
            "' . $archivo . '",
            "' . $video . '",
            "' . $button . '"
          ]
          ]}';

        echo $datosJson;

    }



}

new tablaProtocolos();
