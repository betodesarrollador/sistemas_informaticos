<?php

require_once "../../../framework/clases/ControlerClass.php";

final class protocolo extends Controler
{

    public function __construct()
    {
        parent::__construct(2);
    }

    public function Main()
    {

        $this->noCache();

        require_once "ProtocolosLayoutClass.php";
        require_once "ProtocolosModelClass.php";

        $Layout = new ProtocolosLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new ProtocolosModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));
        $Layout->setActualizar($Model->getPermiso($this->getActividadId(), 'UPDATE', $this->getConex()));
        $Layout->setBorrar($Model->getPermiso($this->getActividadId(), 'DELETE', $this->getConex()));
        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));

        $Layout->setCampos($this->Campos);

        $Layout->RenderMain();

    }

    protected function onclickSave()
    {

        require_once "ProtocolosModelClass.php";
        $Model = new ProtocolosModel();

        if (isset($_FILES["video"])) {

          $ruta_video = $this->getRuta("video");

        }

        if (isset($_FILES["archivo"])) {

          $ruta_archivo = $this->getRuta("archivo");

        }

        $data = $Model->Save($this->getConex(),$ruta_video,$ruta_archivo);

        print $data;

    }

    protected function getRuta($nombre){

        $archivo = $_FILES["$nombre"];
        $nomarchivo = $_FILES["$nombre"]['name'];

        if ($nomarchivo != '') {

            $ruta = "../../../archivos/protocolos";

            $extension = substr(strrchr($nomarchivo, '.'), 1);

            $nomarchivo = preg_replace('([^A-Za-z0-9])', '', $nomarchivo);
            $nomarchivo = utf8_decode($nomarchivo);
            $nombreArchivo = $nombre."_".rand();

            $dir_file = $this->moveUploadedFile($archivo, $ruta, $nombreArchivo);

            $ruta_video = "../../../archivos/protocolos/" . $nombreArchivo . "." . $extension;

            return $ruta_video;

        }

        return "";

    }

    protected function onclickUpdate()
    {

        require_once "ProtocolosModelClass.php";
        $Model = new ProtocolosModel();

        if (isset($_FILES["video"])) {

          $ruta_video = $this->getRuta("video");

        }

        if (isset($_FILES["archivo"])) {

          $ruta_archivo = $this->getRuta("archivo");

        }

        $Model->Update($this->getConex(),$ruta_video,$ruta_archivo);

        print 'true';

    }

    protected function setCampos()
    {

    }

}

$clientes_db = new protocolo();
