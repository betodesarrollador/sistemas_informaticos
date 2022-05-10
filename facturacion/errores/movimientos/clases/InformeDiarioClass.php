<?php

require_once "../../../framework/clases/ControlerClass.php";

final class InformeDiario extends Controler
{

    public function __construct()
    {
        parent::__construct(2);
    }

    public function Main()
    {
       
        $this->noCache();

        require_once "InformeDiarioLayoutClass.php";
        require_once "InformeDiarioModelClass.php";
        
        $Layout = new InformeDiarioLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new InformeDiarioModel();
        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());
        
        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));
        $Layout->setActualizar($Model->getPermiso($this->getActividadId(), 'UPDATE', $this->getConex()));
        $Layout->setBorrar($Model->getPermiso($this->getActividadId(), 'DELETE', $this->getConex()));
        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));
        
        $Layout->setCampos($this->Campos);
        $Layout->setNovedades($Model -> getNovedades($this -> getConex()));
        
        $Layout->RenderMain();
        

    }

    protected function onclickValidateRow()
    {

        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), "Pqr", $this->Campos);
        print $Data->GetData();

    }


    protected function getusuario()
    {
        $usuario = $this->getUsuarioNombres();

        $this->getArrayJSON($usuario);

    }
    

    protected function onclickSave(){
        

        require_once "InformeDiarioModelClass.php";
        $Model = new InformeDiarioModel();

        $data = $Model->Save($this->Campos,$this->getUsuarioId(),$this->getConex());

        

        if($Model->GetNumError()>0){
            exit('Ocurrio una inconsistencia al guardar');
        }else{            

            exit("Se ingreso su informe diario");
        }

    }


    protected function onclickFind(){

        require_once "InformeDiarioModelClass.php";
        $Model = new InformeDiarioModel();

        $informe_id = $this->requestData('informe_id');

        $data = $Model->SelectInforme($informe_id,$this->getConex());


        $this->getArrayJSON($data);

    }


        protected function onclickUpdate()
    {

        require_once "InformeDiarioModelClass.php";
        $Model = new InformeDiarioModel();



        $data = $Model->Update($this->Campos,$this->getUsuarioId(),$this->getConex());

    
        if ($Model->GetNumError() > 0) {
            exit('Ocurrio una inconsistencia');
        } else {
            exit('¡Se actualizo correctamente la tarea!');
        }

    }


    protected function setCampos()
    {

    $this->Campos[informe_id] = array(
        name => 'informe_id',
        id => 'informe_id',
        type => 'text',
        Boostrap => 'si',
        disabled => 'true',
        datatype => array(
        type => 'autoincrement'),
        transaction => array(
        table => array('informe_diario'),
        type => array('primary_key')),
    );

    $this -> Campos[novedad_informe_diario_id] = array(
		name	=>'novedad_informe_diario_id',
		id		=>'novedad_informe_diario_id',
		type	=>'select',
		multiple =>'multiple',
		size     =>'15',
        Boostrap => 'si',
		options	=>array(),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer')
	);
    

    $this->Campos[usuario_id] = array(
    name => 'usuario_id',
    id => 'usuario_id',
    type => 'hidden',
    datatype => array(
        type => 'integer'),
    transaction => array(
        table => array('informe_diario'),
        type => array('column')),
    );



    $this->Campos[usuario] = array(
    name => 'usuario',
    id => 'usuario',
    type => 'text',
    Boostrap => 'si',
    disabled => 'true',
    datatype => array(
    type => 'integer'),
    transaction => array(
    table => array('informe_diario'),
    type => array('column')),
    );


    $this->Campos[quehicehoy] = array(
    name => 'quehicehoy',
    id => 'quehicehoy',
    type => 'textarea',
    cols => '150',
    rows => '5',
    required => 'yes',
    datatype => array(
    type => 'text'),
    transaction => array(
    table => array('informe_diario'),
    type => array('column')),
    );

    $this->Campos[dotomorrow] = array(
    name => 'dotomorrow',
    id => 'dotomorrow',
    type => 'textarea',
    cols => '150',
    rows => '5',
    required => 'yes',
    datatype => array(
    type => 'text'),
    transaction => array(
    table => array('informe_diario'),
    type => array('column')),
    );

    $this->Campos[novedades] = array(
    name => 'novedades',
    id => 'novedades',
    type => 'textarea',
    cols => '150',
    rows => '5',
    datatype => array(
    type => 'text'),
    transaction => array(
    table => array('informe_diario'),
    type => array('column')),
    );



    
    $this->Campos[busqueda] = array(
    name => 'busqueda',
    id => 'busqueda',
    type => 'text',
    size => '85',
    Boostrap => 'si',
    placeholder => 'ESCRIBA EL CODIGO O NOMBRE DEL INFORME',
    suggest => array(
    name => 'informe_diario',
    setId => 'informe_id',
    onclick => 'setDataFormWithResponse'),
    );


    //botones
    $this->Campos[guardar] = array(
    name => 'guardar',
    id => 'guardar',
    type => 'button',
    value => 'Guardar',
    property => array(
    name => 'save_ajax',
    onsuccess => 'InformeDiarioOnSaveOnUpdateonDelete'),

    );

    $this->Campos[actualizar] = array(
    name => 'actualizar',
    id => 'actualizar',
    type => 'button',
    value => 'Actualizar',
    disabled => 'disabled',
    property => array(
    name => 'update_ajax',
    onsuccess => 'InformeDiarioOnSaveOnUpdateonDelete'),
    );



    $this->Campos[limpiar] = array(
    name => 'limpiar',
    id => 'limpiar',
    type => 'reset',
    value => 'Limpiar',
    onclick => 'InformeDiarioOnReset(this.form)',
    );

    $this->SetVarsValidate($this->Campos);



    }


}

$InformeDiario = new InformeDiario();
