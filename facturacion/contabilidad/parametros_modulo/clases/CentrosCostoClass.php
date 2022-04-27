<?php
require_once "../../../framework/clases/ControlerClass.php";

final class CentroCosto extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main()
    {

        $this->noCache();
        require_once "CentroCostoLayoutClass.php";
        require_once "CentroCostoModelClass.php";

        $Layout = new CentroCostoLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new CentroCostoModel();
        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));
        $Layout->setActualizar($Model->getPermiso($this->getActividadId(), 'UPDATE', $this->getConex()));
        $Layout->setBorrar($Model->getPermiso($this->getActividadId(), 'DELETE', $this->getConex()));
        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));

        $Layout->setCampos($this->Campos);

        $Layout->setEmpresas($Model->getEmpresas($this->getUsuarioId(), $this->getConex()));
        $Layout->setOficinas($Model->getOficinas($this->getEmpresaId(), $this->getConex()));
        $Layout->setVehiculos($Model->getVehiculos($this->getEmpresaId(), $this->getConex()));

        $Layout->RenderMain();

    }
    
    protected function showGrid(){
	  
        require_once "CentroCostoLayoutClass.php";
        require_once "CentroCostoModelClass.php";

        $Layout = new CentroCostoLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new CentroCostoModel();
          
         //// GRID ////
        $Attributes = array(
            id => 'centro_costo',
            title => 'Centros de Costo',
            sortname => 'empresa,nombre',
            width => 'auto',
            height => '250',
        );
        $Cols = array(

            array(name => 'empresa', index => 'empresa', sorttype => 'text', width => '300', align => 'center'),
            array(name => 'codigo', index => 'codigo', sorttype => 'text', width => '100', align => 'center'),
            array(name => 'nombre', index => 'nombre', sorttype => 'text', width => '250', align => 'center'),
            array(name => 'estado', index => 'estado', sorttype => 'text', width => '100', align => 'center'),

        );

        $Titles = array('EMPRESA',
            'CODIGO',
            'NOMBRE',
            'ESTADO',
        );

        $html = $Layout->SetGridCentrosCosto($Attributes, $Titles, $Cols, $Model->GetQueryEmpresasGrid());
         
         print $html;
          
      }

    protected function onclickFind()
    {

        require_once "CentroCostoModelClass.php";
        $Model = new CentroCostoModel();
        $CentroCostoId = $_REQUEST['centro_costo_id'];
        $result = $Model->selectCentroCosto($CentroCostoId, $this->getConex());

        $this->getArrayJSON($result);

    }

    protected function onclickSave()
    {

        require_once "CentroCostoModelClass.php";
        $Model = new CentroCostoModel();

        $codigo = $_REQUEST['codigo'];

        $resp = $Model->Save($this->Campos, $this->getConex());

        if ($resp == 1) {
            exit('ya existe un centro de costo con el mismo codigo, por favor verifique!');
        } else if ($Model->GetNumError() > 0) {
            exit('Error : ' . $Model->GetError());
        } else {
            exit('Se ingreso exitosamente el centro de costo!');
        }

    }
    protected function onclickUpdate()
    {
        require_once "CentroCostoModelClass.php";
        $Model = new CentroCostoModel();

        $Model->Update($this->Campos, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('Error : ' . $Model->GetError());
        } else {
            exit('Se actualizo exitosamente el centro de costo!');
        }

    }

    protected function onclickDelete()
    {
        require_once "CentroCostoModelClass.php";
        $Model = new CentroCostoModel();

        $Model->Delete($this->Campos, $this->getConex());

        if ($Model->GetNumError() > 0) {
            exit('Error : ' . $Model->GetError());
        } else {
            exit('Se borro exitosamente el centro de costo!');
        }

    }

    protected function setCampos()
    {

        $this->Campos[centro_de_costo_id] = array(type => 'hidden', name => 'centro_de_costo_id', id => 'centro_de_costo_id',
            datatype => array(type => 'autoincrement'), transaction => array(table => array('centro_de_costo'), type => array('primary_key')));

        $this->Campos[empresa_id] = array(type => 'select', Boostrap => 'si', required => 'yes', name => 'empresa_id', id => 'empresa_id', options => array(),
            transaction => array(table => array('centro_de_costo'), type => array('column')), datatype => array(type => 'integer'));
        $this->Campos[codigo] = array(type => 'text', Boostrap => 'si', required => 'yes', datatype => array(type => 'alphanum_space'), name => 'codigo',
            id => 'codigo', transaction => array(table => array('centro_de_costo'), type => array('column')));

        $this->Campos[nombre] = array(type => 'text', Boostrap => 'si', required => 'yes', datatype => array(type => 'alphanum_space'), name => 'nombre',
            id => 'nombre', transaction => array(table => array('centro_de_costo'), type => array('column')));
        $this->Campos[tipo] = array(type => 'select', Boostrap => 'si', datatype => array(type => 'text'), name => 'tipo', required => 'yes', options => array(
            array(value => 'V', text => 'VEHICULO'),
            array(value => 'O', text => 'OFICINA'),
            array(value => 'A', text => 'ALIADO')), id => 'tipo', transaction => array(table => array('centro_de_costo'), type => array('column')));

        $this->Campos[estado] = array(
            type => 'select',
            datatype => array(
                type => 'text'),
            name => 'estado',
            required => 'yes',
			Boostrap => 'si',
            options => array(
                array(value => 'A',
                    text => 'ACTIVO'),
                array(value => 'I',
                    text => 'INACTIVO')),
            id => 'estado',
            transaction => array(
                table => array('centro_de_costo'),
                type => array('column')));

        $this->Campos[placa_id] = array(type => 'select', Boostrap => 'si', datatype => array(type => 'integer'), name => 'placa_id', options => array(),
            id => 'placa_id', transaction => array(table => array('centro_de_costo'), type => array('column')));

        $this->Campos[oficina_id] = array(type => 'select', Boostrap => 'si', datatype => array(type => 'integer'), name => 'oficina_id', options => array(),
            id => 'oficina_id', transaction => array(table => array('centro_de_costo'), type => array('column')));

        $this->Campos[guardar] = array(type => 'button', name => 'guardar', id => 'guardar', value => 'Guardar', 'property' => array(
            name => 'save_ajax', onsuccess => 'CentroCostoOnSaveOnUpdateonDelete'));

        $this->Campos[actualizar] = array(type => 'button', name => 'actualizar', id => 'actualizar',
            'property' => array(name => 'update_ajax', onsuccess => 'CentroCostoOnSaveOnUpdateonDelete'), value => 'Actualizar', 'disabled' => 'disabled');

        $this->Campos[borrar] = array(type => 'button', name => 'borrar', id => 'borrar',
            'property' => array(name => 'delete_ajax', onsuccess => 'CentroCostoOnSaveOnUpdateonDelete'), value => 'Borrar', 'disabled' => 'disabled');

        $this->Campos[limpiar] = array(type => 'reset', name => 'limpiar', id => 'limpiar', value => 'Limpiar', onclick => 'CentroCostoOnReset(this.form)');

        $this->Campos[busqueda] = array(type => 'text', Boostrap => 'si', name => 'busqueda', id => 'busqueda', value => '', size => '85', placeholder => 'ESCRIBA EL C&Oacute;DIGO O NOMBRE DEL CENTRO DE COSTO', suggest => array(
            name => 'centro_costo', onclick => 'LlenarFormCentroCosto', setId => 'centro_de_costo_id'));

        $this->SetVarsValidate($this->Campos);
    }

}
$CentroCosto = new CentroCosto();
