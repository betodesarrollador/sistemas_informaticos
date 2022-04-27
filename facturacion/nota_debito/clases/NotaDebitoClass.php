<?php

require_once "../../../framework/clases/ControlerClass.php";

final class NotaDebito extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "NotaDebitoLayoutClass.php";
        require_once "NotaDebitoModelClass.php";

        $Layout = new NotaDebitoLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new NotaDebitoModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->SetGuardar($Model->getPermiso($this->getActividadId(), INSERT, $this->getConex()));
        $Layout->SetActualizar($Model->getPermiso($this->getActividadId(), UPDATE, $this->getConex()));
        $Layout->SetAnular($Model->getPermiso($this->getActividadId(), ANULAR, $this->getConex()));
        $Layout->SetLimpiar($Model->getPermiso($this->getActividadId(), CLEAR, $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));

        $Layout->SetCampos($this->Campos);
        //LISTA MENU
        $Layout->SetTipoDoc($Model->GetTipoDoc($this->getConex()));
        $Layout->setUsuarioId($this->getUsuarioId(), $this->getOficinaId());
        $Layout->setCausalesAnulacion($Model->getCausalesAnulacion($this->getConex()));
        $Layout->SetServi($Model->GetServi($this->getConex()));

        $factura_id = $_REQUEST['factura_id'];

        if ($factura_id > 0) {
            $Layout->setFactura($factura_id);
        }

        
        $Layout->RenderMain();

    }
    
    protected function showGrid(){
	  
        require_once "NotaDebitoLayoutClass.php";
        require_once "NotaDebitoModelClass.php";

        $Layout = new NotaDebitoLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new NotaDebitoModel();
          
         //// GRID ////
        $Attributes = array(
            id => 'Factura',
            title => 'Listado de Facturas',
            sortname => 'fecha',
            sortorder => 'desc',
            width => 'auto',
            rowList => '500,800,1000,2000,2500',
            height => '250',
        );

        $Cols = array(

            array(name => 'consecutivo_factura', index => 'consecutivo_factura', sorttype => 'int', width => '145', align => 'left'),
            array(name => 'cliente', index => 'cliente', sorttype => 'text', width => '180', align => 'left'),
            array(name => 'fecha', index => 'fecha', sorttype => 'date', width => '80', align => 'left'),
            array(name => 'valor', index => 'valor', sorttype => 'int', width => '100', align => 'left'),
            array(name => 'tipo_servicio', index => 'tipo_servicio', sorttype => 'text', width => '180', align => 'left'),
            array(name => 'estado_nota', index => 'estado_nota', sorttype => 'text', width => '120', align => 'center'),
        );

        $Titles = array('FACTURA / NOTA DEBITO',
            'CLIENTE',
            'FECHA',
            'VALOR',
            'TIPO SERVICIO',
            'ESTADO',
        );

        $html = $Layout->SetGridFactura($Attributes, $Titles, $Cols, $Model->GetQueryFacturaGrid());
         
         print $html;
          
      }

    protected function onclickValidateRow()
    {
        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        echo $Model->ValidateRow($this->getConex(), $this->Campos);
    }

    protected function onclickSave()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();

        $return = $Model->Save($empresa_id, $oficina_id, $this->Campos, $this->getConex());

        $previsual = $_REQUEST['previsual'];

        if ($previsual == 1) {

            $this->previsualizar($return);

        } else if ($previsual == 0) {

            if (strlen(trim($Model->GetError())) > 0) {
                $this->getArrayJSON(array(factura_id => 0, error => $Model->GetError()));
            } elseif (is_array($return)) {
                $this->getArrayJSON($return);
            } else {
                $this->getArrayJSON(array(factura_id => 0, error => $return));

            }

        }
    }

    protected function onclickUpdate()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();

        $Model->Update($this->getEmpresaId(), $this->getOficinaId(), $this->getUsuarioId(), $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function onclickCancellation()
    {

        require_once "NotaDebitoModelClass.php";

        $Model = new NotaDebitoModel();

        $Model->cancellation($this->getConex());

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

//BUSQUEDA
    protected function onclickFind()
    {
        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();

        $Data = array();
        $nota_debito_id = $_REQUEST['nota_debito_id'];

        if (is_numeric($nota_debito_id)) {

            $Data = $Model->selectDatosNotaId($nota_debito_id, $this->getConex());
        }
        if ($Data[0]['oficina_id'] != $this->getOficinaId()) {
            exit('Esta Factura fue Realizada por la oficina  ' . $Data[0]['oficina'] . '</br> Por favor consultela por la oficina de Creacion');
        }

        $this->getArrayJSON($Data);

    }

    protected function mostrarResultados()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();

        $nota_debito_id = $_REQUEST['nota_debito_id'];

        $return = $Model->previsualizar($nota_debito_id, $this->getConex());
        $this->previsualizar($return);

    }

    protected function onclickPrint()
    {
        require_once "Imp_DocumentoClass.php";
        $print = new Imp_Documento();
        $print->printOut($this -> getConex());
    }

    protected function previsualizar($return)
    {

        require_once 'NotaDebitoLayoutClass.php';
        $Layout = new NotaDebitoLayout();

        $Layout->setDetallesRegistrar($return);
        $Layout->setIncludes();
        $Layout->RenderMainDetalle();

    }

    protected function setDataFactura()
    {
        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $factura_id = $_REQUEST['factura_id'];

        $data = $Model->getDataFactura($factura_id, $this->getConex());
        $this->getArrayJSON($data);

    }

    protected function setDataClienteOpe()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();

        $sede_id = $_REQUEST['sede_id'];
        $cliente_id = $_REQUEST['cliente_id'];

        $data = $Model->getDataClienteOpe($sede_id, $cliente_id, $this->getConex());
        $this->getArrayJSON($data);

    }

    protected function setDataNota()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $factura_id = $_REQUEST['factura_id'];
        $data = $Model->getDataNota($factura_id, $this->getConex());
        $this->getArrayJSON($data);

    }

    protected function setSolicitud()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $detalle_id = $_REQUEST['detalle_id'];
        $fuente_facturacion_cod = $_REQUEST['fuente_facturacion_cod'];
        $return = $Model->SelectSolicitud($detalle_id, $fuente_facturacion_cod, $this->getConex());

        if (count($return) > 0) {
            print json_encode($return);

        } else {
            exit('false');
        }

    }

    protected function setValidaIca()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();

        $consecutivo_rem = $_REQUEST['consecutivo_rem'];
        $tipo_bien_servicio_factura_rm = $_REQUEST['tipo_bien_servicio_factura_rm'];

        $return = $Model->ValidaIca($consecutivo_rem, $tipo_bien_servicio_factura_rm, $this->getConex());

        if ($return > 0) {
            echo json_encode($return);
        } else {
            exit('false');
        }

    }

    protected function setValidaDist()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();

        $consecutivo_rem = $_REQUEST['consecutivo_rem'];
        $tipo_bien_servicio_factura_rm = $_REQUEST['tipo_bien_servicio_factura_rm'];

        $return = $Model->ValidaDist($consecutivo_rem, $tipo_bien_servicio_factura_rm, $this->getConex());

        if ($return > 0) {
            echo json_encode($return);
        } else {
            exit('false');
        }

    }

    protected function ComprobarTercero($Conex)
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $tipo_bien_servicio_factura_id = $_REQUEST['tipo_bien_servicio_factura_id'];
        $numero = $Model->getComprobarTercero($tipo_bien_servicio_factura_id, $this->getConex());
        exit("$numero");

    }

    protected function getEstadoEncabezadoRegistro($Conex='')
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $factura_id = $_REQUEST['factura_id'];
        $Estado = $Model->selectEstadoEncabezadoRegistro($factura_id, $this->getConex());
        exit("$Estado");

    }

    protected function getTotalDebitoCredito()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $nota_debito_id = $_REQUEST['nota_debito_id'];
        $data = $Model->getTotalDebitoCredito($nota_debito_id, $this->getConex());
        print json_encode($data);

    }
    protected function getContabilizar()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $nota_debito_id = $_REQUEST['nota_debito_id'];
        $fecha_nota = $_REQUEST['fecha_nota'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();
        $usuario_id = $this->getUsuarioId();

        $mesContable = $Model->mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha_nota, $this->getConex());
        $periodoContable = $Model->PeriodoContableEstaHabilitado($this->getConex());

        if ($mesContable && $periodoContable) {
            $return = $Model->getContabilizarReg($nota_debito_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $this->getConex());
            if ($return == true) {
                exit("true");
            } else {
                exit("Error : " . $Model->GetError());
            }

        } else {

            if (!$mesContable && !$periodoContable) {
                exit("No se permite Contabilizar en el periodo y mes seleccionado");
            } elseif (!$mesContable) {
                exit("No se permite Contabilizar en el mes seleccionado");
            } else if (!$periodoContable) {
                exit("No se permite Contabilizar en el periodo seleccionado");
            }
        }

    }

    protected function getreContabilizar()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        $factura_id = 8082;
        $fecha = $_REQUEST['fecha'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();
        $usuario_id = $this->getUsuarioId();

        $return = $Model->getreContabilizarReg($factura_id, $empresa_id, $oficina_id, $usuario_id, $this->getConex());
        if ($return == true) {
            exit("true");
        } else {
            exit("Error : " . $Model->GetError());
        }

    }
    //validacion posterior
    protected function OnclickReportar()
    {

        require_once "NotaDebitoModelClass.php";
        $Model = new NotaDebitoModel();
        require_once "procesar.php";
        $FacturaElec = new FacturaElectronica();

        $factura_id = $_REQUEST['factura_id'];
        $data_fac = $Model->getDataFactura_total($factura_id, $this->getConex());
        $deta_fac = $Model->getDataFactura_detalle($factura_id, $this->getConex());
        $deta_puc = $Model->getDataFactura_puc($factura_id, $this->getConex());
        if ($data_fac[0]['reportada'] == 1) {exit("La Factura " . $data_fac[0]['consecutivo_factura'] . ", previamente ya fue enviada.");}
        $resultado = $FacturaElec->sendFactura(4, $data_fac, $deta_fac, $deta_puc);

        if (trim($resultado["codigo"]) == 200 || trim($resultado["codigo"]) == 201) {
            $Model->setMensajeFactura($factura_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $resultado["cufe"], $resultado["xml"], $this->getConex());
            exit("La factura electr&oacute;nica ha sido generada satisfactoriamente!!! <br>En breves momentos llegara la factura al correo del cliente");
        } else {
            if ($resultado["codigo"] == 117) {
                $Model->setMensajeNOFactura($factura_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $this->getConex());
                //exit("La fecha u hora de emisi&oacute;n de la factura no debe ser mayor a la fecha del sistema: ". $data_fac[0]['fecha']." ".date("H:i:s").'-'.$resultado["resultado"].'-'.$resultado["mensaje"]);
                exit($resultado["resultado"] . "-" . $resultado["mensaje"]);

            } else if ($resultado["codigo"] == 115) {
                $Model->setMensajeNOFactura($factura_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $this->getConex());
                exit("El n&uacute;mero consecutivo de la factura ya se encuentra registrada en el sistema");

            } else {
                print_r(var_export($resultado, true));
                $Model->setMensajeNOFactura($factura_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $this->getConex());
                exit();
            }
        }

    }

    //validacion previa test
    protected function OnclickReportarVP()
    {

        require_once "../../factura/clases/FacturaModelClass.php";
        $Model = new FacturaModel();

        require_once "NotaDebitoModelClass.php";
        $ModelNota = new NotaDebitoModel();

        $tokens = $ModelNota->getTokens($this->getConex());

        require_once "../../factura/clases/ProcesarVP.php";
        $FacturaElec = new FacturaElectronica();

        $nota_debito_id = $_REQUEST['nota_debito_id'];

        $data_facturas = $ModelNota->selectFacturasAbonos($nota_debito_id, $this->getConex());
        $data_abo = $ModelNota->selectDatosPagoId($nota_debito_id, $this->getConex());
        $deta_abo_puc = $ModelNota->getDataAbono_puc($nota_debito_id, $this->getConex());

        $factura_id = $data_facturas[0]['factura_id'];
        $data_fac = $Model->getDataFactura_total($factura_id, $this->getConex());
        $deta_fac = $Model->getDataFactura_detalle($factura_id, $this->getConex());
        $deta_puc = $Model->getDataFactura_puc($factura_id, $this->getConex());
        $deta_puc_con = $Model->getDataFactura_puc_con($factura_id, $this->getConex());

        if ($data_abo[0]['nota_debito'] == 0) {exit("El documento Actual no es una Nota Débito, no se puede reportar.");}
        if ($data_fac[0]['reportada'] == 0) {exit("La Factura " . $data_fac[0]['consecutivo_factura'] . ", no se ha reportado previamente.");}
        if ($tokens[0]['tokenenterprise'] == '' || $tokens[0]['tokenenterprise'] == null || $tokens[0]['tokenautorizacion'] == '' || $tokens[0]['tokenautorizacion'] == null) {exit("No se han parametrizado correctamente los tokens, por favor realice este proceso en el formulario Parametros Facturacion Electronica");}

        $resultado = $FacturaElec->sendFactura(9,'ND',$tokens, $data_fac, $deta_fac, $deta_puc, $data_abo, $deta_abo_puc, $deta_puc_con);

        if ($resultado["codigo"] == 200 || $resultado["codigo"] == 201) {
            $ModelNota->setMensajeAbono($nota_debito_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $resultado["cufe"], $resultado["xml"], $this->getConex());
            
            //inicio bloque factura anexo representacion grafica
            require_once("Imp_DocumentoClass.php");		
            $print = new Imp_Documento($this -> getConex());
            $print -> printOut($data_abo[0]['encabezado_registro_id'],$data_abo[0]['numero_soporte'].'_'.$data_abo[0]['nota_debito_id']);	
            $resultado = $FacturaElec -> sendFactura(11,'ND',$tokens, $data_fac, $deta_fac, $deta_puc, $data_abo, $deta_abo_puc, $deta_puc_con);		
            //fin bloque factura anexo representacion grafica
           
            exit("La Nota Debito ha sido ha sido generada satisfactoriamente!!! <br>En breves momentos llegara la Nota al correo del cliente");
        } else {
            if ($resultado["codigo"] == 117) {
                $ModelNota->setMensajeNOAbono($nota_debito_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $this->getConex());
                exit("La fecha u hora de emisi&oacute;n de la factura no debe ser mayor a la fecha del sistema: " . $data_fac[0]['fecha'] . " " . date("H:i:s"));

            } else if ($resultado["codigo"] == 115) {
                $ModelNota->setMensajeNOAbono($nota_debito_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $this->getConex());
                exit("El n&uacute;mero consecutivo ya se encuentra registrada en el sistema");

            } else {
                print_r(var_export($resultado, true));
                $ModelNota->setMensajeNOAbono($nota_debito_id, date("Y-m-d H:i"), $resultado["codigo"] . '-' . $resultado["resultado"] . '-' . $resultado["mensaje"], $this->getConex());
                exit();
            }
        }

    }

    protected function onclickEnviarMail()
    {
        require_once "../../../framework/clases/MailClass.php";
        require_once "NotaDebitoLayoutClass.php";
        require_once "NotaDebitoModelClass.php";

        $mes = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $Layout = new NotaDebitoLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new NotaDebitoModel();
        $nota_debito_id = $_REQUEST['nota_debito_id'];

        $data = $Model->selectDatosPagoId($nota_debito_id, $this->getConex());
        $dataEmpresa = $Model->selectEmpresa($this->getEmpresaId(), $this->getConex());
        //$data[0]['cliente_email']='johnatanleyva@gmail.com';
        if ($data[0]['cliente_email'] != '' && $data[0]['cliente_email'] != 'NULL' && $data[0]['nota_debito_id'] > 0) {
            require_once "Imp_DocumentoClass.php";
            $print = new Imp_Documento();
            $print->printOut($data[0]['encabezado_registro_id'],$data[0]['numero_soporte'].'_'.$data[0]['nota_debito_id']);//$data[0]['consecutivo_factura'] . '_' . $data[0]['factura_id']
            $adjunto = $data[0]['adjunto'];
            $adjunto_nombre = str_replace("../../../archivos/facturacion/adjuntos/", "", $adjunto);

            $fecha = $data[0]['fecha'];
            $fechafin = explode('-', $fecha);

            $mensaje_texto = 'Estimado Cliente ' . $data[0]['cliente'] . ',<br><br>

						Adjuntamos Nota Debito del mes ' . $mes[intval($fechafin[1])] . ' de ' . $fechafin[0] . ', con Numero  ' . $data[0]['prefijo'] . '-' . $data[0]['consecutivo_factura'] . ', quedamos atentos a cualquier inquietud.<br><br>
						Por favor no responder a este correo, cualquier inquietud enviar correo a <a href="mailto:' . $dataEmpresa[0]['email'] . '">' . $dataEmpresa[0]['email'] . '</a><br><br>

						Cordialmente,<br><br>

						FACTURACION ' . $dataEmpresa[0]['nombre'];
            $enviar_mail = new Mail(); //$data[0]['cliente_email']
            $mensaje_exitoso = $enviar_mail->sendMail(trim($dataEmpresa[0]['email']), 'Se ha generado la Nota Debito referente a la Factura ' . $data[0]['prefijo'] . '-' . $data[0]['consecutivo_factura'], $mensaje_texto, '../../../archivos/facturacion/notas/' . $data[0]['numero_soporte'] . '_' . $data[0]['nota_debito_id'] . '.pdf', $data[0]['numero_soporte'] . '_' . $data[0]['nota_debito_id'] . '.pdf', $adjunto, $adjunto_nombre);

            $mensaje_exitoso = $enviar_mail->sendMail(trim($data[0]['cliente_email']), 'Se ha generado la Nota Debito referente a la Factura ' . $data[0]['prefijo'] . '-' . $data[0]['consecutivo_factura'], $mensaje_texto, '../../../archivos/facturacion/notas/' . $data[0]['numero_soporte'] . '_' . $data[0]['nota_debito_id'] . '.pdf', $data[0]['numero_soporte'] . '_' . $data[0]['nota_debito_id'] . '.pdf');
            if ($mensaje_exitoso) {
                exit('Correo Enviado Satisfactoriamente');

            } else {
                exit('Correo No pudo ser Enviado');

            }
        } elseif ($data[0]['cliente_email'] == '' && $data[0]['factura_id'] > 0) {
            exit('El cliente no tiene Email configurado');

        } else {
            exit('No existe Factura');
        }

    }

    protected function uploadFileAutomatically()
    {

        require_once "NotaDebitoModelClass.php";

        $Model = new NotaDebitoModel();
        $factura_id = $_REQUEST['factura_id'];
        $consecutivo_factura = $_REQUEST['consecutivo_factura'];
        $ruta = "../../../archivos/facturacion/adjuntos/";
        $archivo = $_FILES['adjunto'];
        $nombreArchivo = "adjunto_factura_" . $consecutivo_factura;
        $dir_file = $this->moveUploadedFile($archivo, $ruta, $nombreArchivo);

        $Model->seAdjunto($factura_id, $dir_file, $this->getConex());

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function SetCampos()
    {

        /********************
        Campos Factura
         ********************/

        $this->Campos[consecutivo_factura] = array(
            name => 'consecutivo_factura',
            id => 'consecutivo_factura',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            suggest => array(
                name => 'factura_contabilizada',
                setId => 'factura_hidden',
                onclick => 'setDataFactura'),
        );

        $this->Campos[factura_id] = array(
            name => 'factura_id',
            id => 'factura_hidden',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[nota_debito_id] = array(
            name => 'nota_debito_id',
            id => 'nota_debito_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[cliente] = array(
            name => 'cliente',
            id => 'cliente',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            size => 83,
        );

        $this->Campos[cliente_id] = array(
            name => 'cliente_id',
            id => 'cliente_hidden',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[numero_documento] = array(
            name => 'numero_documento',
            id => 'numero_documento',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            size => 83,
        );

        $this->Campos[encabezado_registro_id] = array(
            name => 'encabezado_registro_id',
            id => 'encabezado_registro_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[consecutivo_contable] = array(
            name => 'consecutivo_contable',
            id => 'consecutivo_contable',
            Boostrap => 'si',
            type => 'text',
            disabled => 'yes',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[fecha] = array(
            name => 'fecha',
            id => 'fecha',
            type => 'text',
            Boostrap => 'si',
            disabled => 'yes',
            datatype => array(
                type => 'text',
                length => '10'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[fecha_nota] = array(
            name => 'fecha_nota',
            id => 'fecha_nota',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[tipo_de_documento_id] = array(
            name => 'tipo_de_documento_id',
            id => 'tipo_de_documento_id',
            type => 'select',
            Boostrap => 'si',
            options => null,
            required => 'yes',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),

        );

        $this->Campos[concepto] = array(
            name => 'concepto',
            id => 'concepto',
            type => 'text',
            Boostrap => 'si',
            size => 81,
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '350'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[motivo_nota] = array(
            name => 'motivo_nota',
            id => 'motivo_nota',
            type => 'select',
            Boostrap => 'si',
            required => 'yes',
            options => array(
                array(value => 1, text => 'INTERESES'),
                array(value => 4, text => 'OTROS / REVERSAR NOTA CRÉDITO')),
            datatype => array(
                type => 'integer',
                length => '950'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),

        );

        $this->Campos[tipo_bien_servicio_factura] = array(
            name => 'tipo_bien_servicio_factura',
            id => 'tipo_bien_servicio_factura',
            type => 'select',
            Boostrap => 'si',
            options => null,
            required => 'yes',
            onchange => 'ComprobarTercero(this.value)',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),

        );

        $this->Campos[usuario_id] = array(
            name => 'usuario_id',
            id => 'usuario_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '10'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );
        $this->Campos[oficina_id] = array(
            name => 'oficina_id',
            id => 'oficina_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[ingreso_factura] = array(
            name => 'ingreso_factura',
            id => 'ingreso_factura',
            type => 'hidden',
            value => date("Y-m-d h:i:s"),
            datatype => array(
                type => 'alphanum',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[valor] = array(
            name => 'valor',
            id => 'valor',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),

        );

        $this->Campos[valor_nota] = array(
            name => 'valor_nota',
            id => 'valor_nota',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'numeric',
                length => '20'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),

        );

        $this->Campos[estado] = array(
            name => 'estado',
            id => 'estado',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            options => array(
                array(value => 'A', text => 'EDICION'),
                array(value => 'I', text => 'ANULADA'),
                array(value => 'C', text => 'CONTABILIZADA')),
            selected => 'A',
            datatype => array(
                type => 'alphanum',
                length => '1'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),

        );

        $this->Campos[adjunto] = array(
            name => 'adjunto',
            id => 'adjunto',
            type => 'upload',
            title => 'Carga Adjunto',
            parameters => 'factura_id',
            beforesend => 'validaSeleccionFactura',
            onsuccess => 'onSendFile',
        );

        /*****************************************
        Campos Anulacion Registro
         *****************************************/

        $this->Campos[anul_usuario_id] = array(
            name => 'anul_usuario_id',
            id => 'anul_usuario_id',
            type => 'hidden',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[anul_oficina_id] = array(
            name => 'anul_oficina_id',
            id => 'anul_oficina_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
        );

        $this->Campos[anul_factura] = array(
            name => 'anul_factura',
            id => 'anul_factura',
            type => 'text',
            Boostrap => 'si',
            size => '17',
            value => date("Y-m-d H:m"),
            datatype => array(
                type => 'date'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[causal_anulacion_id] = array(
            name => 'causal_anulacion_id',
            id => 'causal_anulacion_id',
            type => 'select',
            Boostrap => 'si',
            //required=>'yes',
            options => array(),
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        $this->Campos[desc_anul_factura] = array(
            name => 'desc_anul_factura',
            id => 'desc_anul_factura',
            type => 'textarea',
            value => '',
            //required=>'yes',
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('nota_debito'),
                type => array('column')),
        );

        /**********************************
        campos div ica
         ************************************/

        $this->Campos[impuesto] = array(
            name => 'impuesto',
            id => 'impuesto',
            type => 'select',
            Boostrap => 'si',
            Boostrap => 'si',
            //required=>'yes',
            options => array(),
            datatype => array(
                type => 'integer'),
        );

        $this->Campos[impuesto_id] = array(
            name => 'impuesto_id',
            id => 'impuesto_id',
            type => 'hidden',
            datatype => array(
                type => 'integer',
                length => '11'),
        );

        /**********************************
        Botones
         **********************************/

        $this->Campos[guardar] = array(
            name => 'guardar',
            id => 'guardar',
            type => 'button',
            value => 'Guardar',
            //tabindex=>'19',
            onclick => 'NotaOnSave(this.form)',
        );

        $this->Campos[actualizar] = array(
            name => 'actualizar',
            id => 'actualizar',
            type => 'button',
            value => 'Actualizar',
            disabled => 'disabled',
            //tabindex=>'20',
            onclick => 'NotaOnUpdate(this.form)',
        );
        $this->Campos[anular] = array(
            name => 'anular',
            id => 'anular',
            type => 'button',
            value => 'Anular',
            disabled => 'true',
            tabindex => '14',
            onclick => 'onclickCancellation(this.form)',
        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            //tabindex=>'22',
            onclick => 'NotaOnReset(this.form)',
        );

        $this->Campos[contabilizar] = array(
            name => 'contabilizar',
            id => 'contabilizar',
            type => 'button',
            value => 'Contabilizar',
            disabled => 'yes',
            tabindex => '16',
            onclick => 'OnclickContabilizar()',
        );

        $this->Campos[recontabilizar] = array(
            name => 'recontabilizar',
            id => 'recontabilizar',
            type => 'button',
            value => 'reasignacion',
            tabindex => '16',
            onclick => 'OnclickReContabilizar()',
        );

        $this->Campos[reportarvp] = array(
            name => 'reportarvp',
            id => 'reportarvp',
            type => 'button',
            Clase => 'btn btn-success',
            disabled => 'yes',
            value => 'Enviar Nota Debito',
            tabindex => '16',
            onclick => 'OnclickReportarVP()',
        );

        $this->Campos[reportar] = array(
            name => 'reportar',
            id => 'reportar',
            type => 'button',
            disabled => 'yes',
            value => 'Enviar Factura de Venta',
            tabindex => '16',
            onclick => 'OnclickReportar()',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'print',
            value => 'Imprimir',
            displayoptions => array(
                form => 0,
                beforeprint => 'beforePrint',
                title => 'Impresion Nota Credito',
                width => '900',
                height => '600',
            ),
        );

        $this->Campos[imprimir_pdf] = array(
            name => 'imprimir_pdf',
            id => 'imprimir_pdf',
            type => 'button',
            disabled => 'disabled',
            value => 'Imprimir PDF',
            onclick => 'beforePdf();',
        );

        $this->Campos[imprimir1] = array(
            name => 'imprimir1',
            id => 'imprimir1',
            type => 'print',
            disabled => 'true',
            value => 'Imprimir sin formato',
            id_prin => 'factura_id',
            displayoptions => array(
                form => 0,
                beforeprint => 'beforePrint',
                title => 'Impresion Factura sin formato',
                width => '800',
                height => '600',
            ));

        $this->Campos[envio_factura] = array(
            name => 'envio_factura',
            id => 'envio_factura',
            type => 'button',
            Clase => 'btn btn-info',
            value => 'Envio Mail',
            disabled => 'true',
            tabindex => '14',
            onclick => 'onclickEnviarMail(this.form)',
        );

        $this->Campos[confirmar] = array(
            name => 'confirmar',
            id => 'confirmar',
            type => 'button',
            value => 'Confirmar',
        );

        $this->Campos[busqueda] = array(
            name => 'busqueda',
            id => 'busqueda',
            type => 'text',
            Boostrap => 'si',
            size => '85',
            //tabindex=>'1',
            suggest => array(
                name => 'nota_debito',
                setId => 'nota_debito_id',
                onclick => 'setDataFormWithResponse'),
        );

        $this->SetVarsValidate($this->Campos);
    }

}

$nota_debito_id = new NotaDebito();
