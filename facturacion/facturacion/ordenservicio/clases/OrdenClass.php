<?php

require_once "../../../framework/clases/ControlerClass.php";

final class Orden extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "OrdenLayoutClass.php";
        require_once "OrdenModelClass.php";

        $Layout = new OrdenLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new OrdenModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->SetGuardar($Model->getPermiso($this->getActividadId(), INSERT, $this->getConex()));
        $Layout->SetActualizar($Model->getPermiso($this->getActividadId(), UPDATE, $this->getConex()));
        $Layout->SetBorrar($Model->getPermiso($this->getActividadId(), DELETE, $this->getConex()));
        $Layout->SetLimpiar($Model->getPermiso($this->getActividadId(), CLEAR, $this->getConex()));
        $Layout->SetAnular($Model->getPermiso($this->getActividadId(), ANULAR, $this->getConex()));
        $Layout->SetLiquidar($Model->getPermiso($this->getActividadId(), LIQUIDAR, $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));

        $Layout->SetCampos($this->Campos);
        //LISTA MENU
        $Layout->SetTiposPago($Model->GetTipoPago($this->getConex()));
        $Layout->setCausalesAnulacion($Model->getCausalesAnulacion($this->getConex()));
        $Layout->setCentroCosto($Model->getCentroCosto($this->getConex()));
        $Layout->setUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->RenderMain();

    }

    protected function showGrid()
    {

        require_once "OrdenLayoutClass.php";
        require_once "OrdenModelClass.php";

        $Layout = new OrdenLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new OrdenModel();

        //// GRID ////
        $Attributes = array(
            id => 'ordenservicio',
            title => 'Listado de Ordenes de Servicio',
            sortname => 'orden_servicio_id',
            width => 'auto',
            height => '250',
        );

        $Cols = array(

            array(name => 'orden_servicio_id', index => 'orden_servicio_id', sorttype => 'int', width => '80', align => 'center'),
            array(name => 'oficina', index => 'oficina', sorttype => 'int', width => '80', align => 'center'),
            array(name => 'fecha_orden_servicio', index => 'fecha_orden_servicio', sorttype => 'text', width => '90', align => 'center'),
            array(name => 'cliente_nombre', index => 'cliente_nombre', sorttype => 'text', width => '220', align => 'center'),
            array(name => 'cliente_tele', index => 'cliente_tele', sorttype => 'int', width => '80', align => 'center'),
            array(name => 'cliente_ciudad', index => 'cliente_ciudad', sorttype => 'text', width => '100', align => 'center'),
            array(name => 'tiposervicio', index => 'tiposervicio', sorttype => 'text', width => '220', align => 'center'),
            array(name => 'nombre', index => 'nombre', sorttype => 'text', width => '80', align => 'center'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '60', align => 'center'),
        );

        $Titles = array('ORDEN No',
            'OFICINA',
            'FECHA',
            'CLIENTE',
            'TELEFONO',
            'CIUDAD',
            'BIEN/SERVICIO',
            'FORMA PAGO',
            'ESTADO',
        );

        $html = $Layout->SetGridOrden($Attributes, $Titles, $Cols, $Model->GetQueryOrdenGrid());

        print $html;

    }

    protected function onclickValidateRow()
    {
        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();
        echo $Model->ValidateRow($this->getConex(), $this->Campos);
    }

    protected function onclickLiquidar()
    {

        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();
        $Model->liquidar($empresa_id, $oficina_id, $this->getConex());

        if (strlen($Model->GetError()) > 0) {
            exit('false');
        } else {
            exit('true');
        }

    }

    protected function Checkconfig($Conex='')
    {

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();

        $Estado = $Model->Checkconfig($orden_servicio_id, $empresa_id, $oficina_id, $this->getConex());

        $this->getArrayJSON($Estado);

    }

    protected function onclickSave()
    {

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();

        $return = $Model->Save($this->Campos, $this->getConex());
        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            if (is_array($return)) {
                $this->getArrayJSON($return);
            } else {
                exit('false');
            }
        }
    }

    protected function onclickUpdate()
    {

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();

        $Model->Update($this->Campos, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('Ocurrio una inconsistencia');
        } else {
            exit('Se actualizo correctamente la Orden de Compra');
        }

    }

    protected function onclickDelete()
    {

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();

        $Model->Delete($this->Campos, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('no se puede borrar la Tarifa');
        } else {
            exit('Se borro exitosamente la Tarifa');
        }

    }

    protected function getTotal()
    {

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];
        $data = $Model->getTotal($orden_servicio_id, $this->getConex());
        $this->getArrayJSON($data);

    }

    protected function onclickCancellation()
    {

        require_once "OrdenModelClass.php";

        $Model = new OrdenModel();

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

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();

        $Data = array();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];

        if (is_numeric($orden_servicio_id)) {

            $Data = $Model->selectDatosOrdenId($orden_servicio_id, $this->getConex());

        }
        $this->getArrayJSON($Data);

    }

    protected function onclickPrint()
    {

        require_once "Imp_OrdenServicioClass.php";

        $print = new Imp_OrdenServicio();

        $print->printOut($this -> getConex());

    }

    protected function setDataCliente()
    {

        require_once "OrdenModelClass.php";
        $Model = new OrdenModel();
        $cliente_id = $_REQUEST['cliente_id'];
        $data = $Model->getDataCliente($cliente_id, $this->getConex());
        $this->getArrayJSON($data);

    }

    protected function getEstadoEncabezadoRegistro($Conex='')
    {

        require_once "OrdenModelClass.php";

        $Model = new OrdenModel();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];

        $Estado = $Model->selectEstadoEncabezadoRegistro($orden_servicio_id, $this->getConex());

        exit("$Estado");

    }

    protected function getItemliquida($Conex='')
    {

        require_once "OrdenModelClass.php";

        $Model = new OrdenModel();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];

        $totali = $Model->selectItemliquida($orden_servicio_id, $this->getConex());

        exit("$totali");

    }

    protected function SetCampos()
    {

        /********************
        Campos Tarifas Cliente
         ********************/

        $this->Campos[orden_servicio_id] = array(
            name => 'orden_servicio_id',
            id => 'orden_servicio_id',
            type => 'hidden',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('primary_key')),
        );

        $this->Campos[consecutivo] = array(
            name => 'consecutivo',
            id => 'consecutivo',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('primary_key')),
        );

        $this->Campos[fecha_orden_servicio] = array(
            name => 'fecha_orden_servicio',
            id => 'fecha_orden_servicio',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );
        $this->Campos[centro_de_costo_id] = array(
            name => 'centro_de_costo_id',
            id => 'centro_de_costo_id',
            type => 'select',
            Boostrap => 'si',
            options => null,
            required => 'yes',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[cliente_id] = array(
            name => 'cliente_id',
            id => 'cliente_hidden',
            type => 'hidden',
            value => '',
            required => 'yes',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[cliente] = array(
            name => 'cliente',
            id => 'cliente',
            type => 'text',
            Boostrap => 'si',
            suggest => array(
                name => 'cliente_orden',
                setId => 'cliente_hidden',
                onclick => 'setDataCliente'),
        );

        $this->Campos[cliente_tele] = array(
            name => 'cliente_tele',
            id => 'cliente_tele',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'integer',
                length => '200'),
        );
        $this->Campos[cliente_direccion] = array(
            name => 'cliente_direccion',
            id => 'cliente_direccion',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'alphanum',
                length => '200'),
        );
        $this->Campos[cliente_ciudad] = array(
            name => 'cliente_ciudad',
            id => 'cliente_ciudad',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'alphanum',
                length => '200'),
        );
        $this->Campos[cliente_contacto] = array(
            name => 'cliente_contacto',
            id => 'cliente_contacto',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'alphanum',
                length => '200'),
        );
        $this->Campos[cliente_correo] = array(
            name => 'cliente_correo',
            id => 'cliente_correo',
            type => 'text',
            Boostrap => 'si',
            readonly => 'yes',
            disabled => 'yes',
            datatype => array(
                type => 'alphanum',
                length => '200'),
        );

        $this->Campos[tiposervicio] = array(
            name => 'tiposervicio',
            id => 'tiposervicio',
            type => 'text',
            Boostrap => 'si',
            //tabindex=>'7',
            suggest => array(
                name => 'tiposervicioordenfactura',
                setId => 'tiposerviciofactura_hidden'),
        );

        $this->Campos[tipo_bien_servicio_factura_id] = array(
            name => 'tipo_bien_servicio_factura_id',
            id => 'tiposerviciofactura_hidden',
            type => 'hidden',
            required => 'yes',
            value => '',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[descrip_orden_servicio] = array(
            name => 'descrip_orden_servicio',
            id => 'descrip_orden_servicio',
            type => 'text',
            Boostrap => 'si',
            size => 89,
            //tabindex=>'11',
            datatype => array(
                type => 'text',
                length => '200'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );
        $this->Campos[forma_compra_venta_id] = array(
            name => 'forma_compra_venta_id',
            id => 'forma_compra_venta_id',
            type => 'select',
            Boostrap => 'si',
            options => null,
            required => 'yes',
            //tabindex=>'2',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[estado_orden_servicio] = array(
            name => 'estado_orden_servicio',
            id => 'estado_orden_servicio',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            options => array(array(value => 'A', text => 'EDICION'), array(value => 'I', text => 'ANULADA'), array(value => 'F', text => 'FACTURADA'), array(value => 'L', text => 'LIQUIDADA')),
            selected => 'A',
            datatype => array(
                type => 'alphanum',
                length => '1'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[usuario_id] = array(
            name => 'usuario_id',
            id => 'usuario_id',
            type => 'hidden',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('orden_servicio'),
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
                table => array('orden_servicio'),
                type => array('column')),
        );
        $this->Campos[ingreso_orden_servicio] = array(
            name => 'ingreso_orden_servicio',
            id => 'ingreso_orden_servicio',
            type => 'hidden',
            value => date("Y-m-d h:i:s"),
            datatype => array(
                type => 'alphanum',
                length => '20'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
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
                table => array('orden_servicio'),
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

        $this->Campos[anul_orden_servicio] = array(
            name => 'anul_orden_servicio',
            id => 'anul_orden_servicio',
            type => 'text',
            size => '17',
            value => date("Y-m-d H:m"),
            readonly => 'yes',
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[causal_anulacion_id] = array(
            name => 'causal_anulacion_id',
            id => 'causal_anulacion_id',
            type => 'select',
            required => 'yes',
            options => array(),
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[desc_anul_orden_servicio] = array(
            name => 'desc_anul_orden_servicio',
            id => 'desc_anul_orden_servicio',
            type => 'textarea',
            value => '',
            required => 'yes',
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        /**********************************
        Liquidacion
         **********************************/

        $this->Campos[liq_usuario_id] = array(
            name => 'liq_usuario_id',
            id => 'liq_usuario_id',
            type => 'hidden',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[fec_liq_orden_servicio] = array(
            name => 'fec_liq_orden_servicio',
            id => 'fec_liq_orden_servicio',
            type => 'text',
            size => '17',
            value => date("Y-m-d H:m"),
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        $this->Campos[descrip_liq_orden_servicio] = array(
            name => 'descrip_liq_orden_servicio',
            id => 'descrip_liq_orden_servicio',
            type => 'textarea',
            value => '',
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('orden_servicio'),
                type => array('column')),
        );

        /**********************************
        Botones
         **********************************/

        $this->Campos[guardar] = array(
            name => 'guardar',
            id => 'guardar',
            type => 'button',
            value => 'Guardar',
            //tabindex=>'19'
        );

        $this->Campos[actualizar] = array(
            name => 'actualizar',
            id => 'actualizar',
            type => 'button',
            value => 'Actualizar',
            disabled => 'disabled',
            //tabindex=>'20'
        );

        $this->Campos[borrar] = array(
            name => 'borrar',
            id => 'borrar',
            type => 'button',
            value => 'Borrar',
            disabled => 'disabled',
            //tabindex=>'21',
            property => array(
                name => 'delete_ajax',
                onsuccess => 'OrdenOnDelete'),
        );
        $this->Campos[anular] = array(
            name => 'anular',
            id => 'anular',
            type => 'button',
            value => 'Anular',
            tabindex => '14',
            onclick => 'onclickCancellation(this.form)',
        );

        $this->Campos[liquidar] = array(
            name => 'liquidar',
            id => 'liquidar',
            type => 'button',
            value => 'Liquidar',
            onclick => 'onclickLiquidar(this.form)',
            //tabindex=>'19'
        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            //tabindex=>'22',
            onclick => 'OrdenOnReset()',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'print',
            disabled => 'disabled',
            value => 'Imprimir',
            displayoptions => array(
                form => 0,
                beforeprint => 'beforePrint',
                title => 'Impresion Orden de Compra',
                width => '800',
                height => '600',
            ),

        );

        $this->Campos[busqueda] = array(
            name => 'busqueda',
            id => 'busqueda',
            type => 'text',
            Boostrap => 'si',
            size => '85',
            //tabindex=>'1',
            suggest => array(
                name => 'ordenservicio',
                setId => 'orden_servicio_id',
                onclick => 'setDataFormWithResponse'),
        );

        $this->SetVarsValidate($this->Campos);
    }

}

$orden_servicio_id = new Orden();
