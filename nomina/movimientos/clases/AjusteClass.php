<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Ajuste extends Controler{
    
    public function __construct(){

        parent::__construct(3);
        
    }

    public function Main(){
            
        $this -> noCache();
          
        require_once("AjusteLayoutClass.php");
        require_once("AjusteModelClass.php");
        
        $Layout   = new AjusteLayout($this -> getTitleTab(),$this -> getTitleForm());
        $Model    = new AjusteModel();
    
        $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
        
        $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
        $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
        $Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
        $Layout -> setAnular     	($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
        $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
        
        $Layout -> SetCampos($this -> Campos);
        $Layout->SetCosto($Model->GetCosto($this->getConex()));
        
        $Layout -> RenderMain();
    }

    protected function OnclickAjustar(){

        require_once("AjusteModelClass.php");

        $Model = new AjusteModel();
        $Conex = $this -> getConex();
        
        $Liquidacion_novedad_id = $_REQUEST['liquidacion_novedad_id'];
        
        $validacionDatos = $Model -> validaDatos($Liquidacion_novedad_id, $Conex);
        
        if ($validacionDatos[result] == "false") {
        
            exit($validacionDatos[message]);

        }

        //save
        
        $save = $Model -> Save($Liquidacion_novedad_id, $Conex);


    }



    

    protected function validaConsecutivoNomina(){

        require_once("AjusteModelClass.php");

        $Model = new AjusteModel();

        $consecutivo_nom = $_REQUEST['consecutivo_nom'];

        $liquidacion_novedad_agrupado = $Model -> buscaliquidacionNovedadId($consecutivo_nom, $this -> getConex());

        print_r(json_encode($liquidacion_novedad_agrupado));

    }

    //BUSQUEDA
    protected function onclickFind()
    {
        require_once "AjusteModelClass.php";
        
        $Model = new AjusteModel();
        $Liquidacion  = $_REQUEST['liquidacion_novedad_id'];
          
        $Data = $Model->selectLiquidacion($Liquidacion, $this->getConex());
       
        $this->getArrayJSON($Data);

    }

    protected function SetCampos(){


        //LIQUIDACION NOMINA

        
        $this->Campos[liquidacion_novedad_id] = array(
            name => 'liquidacion_novedad_id',
            id => 'liquidacion_novedad_id',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('primary_key')),
        );

        $this->Campos[consecutivo] = array(
            name => 'consecutivo',
            id => 'consecutivo',
            type => 'text',
            Boostrap => 'si',
            required => 'no',
            readonly => 'readonly',
            size => '10',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[consecutivo_nom] = array(
            name => 'consecutivo_nom',
            id => 'consecutivo_nom',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('primary_key')),
        );

        $this->Campos[param_nom_electronica_id] = array(
            name => 'param_nom_electronica_id',
            id => 'param_nom_electronica_id',
            type => 'hidden',
            required => 'no',
            datatype => array(
                type => 'integer',
                length => '11'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('primary_key')),
        );

        $this->Campos[empleados] = array(
            name => 'empleados',
            id => 'empleados',
            type => 'select',
            Boostrap => 'si',
            options => array(
                array(value => 'U', text => 'UNO', selected => 'U'), 
                array(value => 'T', text => 'TODOS')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),

        );

        $this->Campos[fecha_inicial] = array(
            name => 'fecha_inicial',
            id => 'fecha_inicial',
            type => 'text',
            required => 'yes',
            value => '',
            //tabindex=>'3',
            datatype => array(
                type => 'date'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[fecha_final] = array(
            name => 'fecha_final',
            id => 'fecha_final',
            type => 'text',
            disabled => 'yes',
            required => 'yes',
            value => '',
            datatype => array(
                type => 'date'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[periodicidad] = array(
            name => 'periodicidad',
            id => 'periodicidad',
            type => 'select',
            Boostrap => 'si',
            options => array(
                array(value => 'S', text => 'SEMANAL'), 
                array(value => 'Q', text => 'QUINCENAL'), 
                array(value => 'M', text => 'MENSUAL'), 
                array(value => 'T', text => 'TODOS', selected => 'T')),
            //required=>'yes',
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),

        );

        $this->Campos[area_laboral] = array(
            name => 'area_laboral',
            id => 'area_laboral',
            type => 'select',
            Boostrap => 'si',
            options => array(
                array(value => 'T', text => 'TODOS', selected => 'T'), 
                array(value => 'A', text => 'ADMINISTRATIVO'), 
                array(value => 'O', text => 'OPERATIVO'), 
                array(value => 'C', text => 'COMERCIAL')),
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[estado] = array(
            name => 'estado',
            id => 'estado',
            type => 'select',
            Boostrap => 'si',
            disabled => 'yes',
            options => array(
                array(value => 'A', text => 'ANULADO', selected => 'E'), 
                array(value => 'E', text => 'EDICION', selected => 'E'), 
                array(value => 'C', text => 'CONTABILIZADO', selected => 'E')),
            required => 'yes',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[contrato_id] = array(
            name => 'contrato_id',
            id => 'contrato_id',
            type => 'hidden',
            required => 'yes',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[usuario_id] = array(
            name => 'usuario_id',
            id => 'usuario_id',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'integer'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[fecha_registro] = array(
            name => 'fecha_registro',
            id => 'fecha_registro',
            type => 'hidden',
            //required=>'yes',
            datatype => array(
                type => 'text'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        $this->Campos[centro_de_costo_id] = array(
            name => 'centro_de_costo_id',
            id => 'centro_de_costo_id',
            type => 'select',
            Boostrap => 'si',
            options => array(),
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
            transaction => array(
                table => array('liquidacion_novedad'),
                type => array('column')),
        );

        

        $this->Campos[contrato] = array(
            name => 'contrato',
            id => 'contrato',
            Boostrap => 'si',
            type => 'text',
            size => '20',
            suggest => array(
                name => 'contrato',
                setId => 'contrato_id'),

        );

        $this->Campos[lista_liquidacion_novedad_id] = array(
            name => 'lista_liquidacion_novedad_id',
            id => 'lista_liquidacion_novedad_id',
            type => 'select',
            Boostrap => 'si',
            options => array(),
            disabled => 'disabled',
            datatype => array(
                type => 'text',
                length => '2'),
        );
        

        //BOTONES
        $this->Campos[ajustar] = array(
            name => 'ajustar',
            id => 'ajustar',
            type => 'button',
            value => 'Ajustar',
            disabled => 'disabled',
            onclick => 'OnclickAjustar()',
        );

        $this->Campos[contabilizar_diferencia] = array(
            name => 'contabilizar_diferencia',
            id => 'contabilizar_diferencia',
            type => 'button',
            value => 'Contabilizar Diferencia',
            disabled => 'disabled',
            tabindex => '16',
            onclick => 'OnclickContabilizar()',
        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            onclick => 'AjusteOnReset()',
        );

        $this->Campos[previsual] = array(
            name => 'previsual',
            id => 'previsual',
            Clase => 'btn btn-success',
            type => 'button',
            value => 'Previsual',
            disabled => 'disabled',
            onclick => 'Previsual(this.form)',
        );

        //BUSQUEDA

        $this->Campos[busqueda_empleado] = array(
            name => 'busqueda_empleado',
            id => 'busqueda_empleado',
            type => 'text',
            Boostrap => 'si',
            size => '85',
            value => '',
            placeholder => 'Por favor digite el numero de identificacion, nombre del empleado o el consecutivo de nomina reportado',
            suggest => array(
                name => 'nomina_reportada',
                setId => 'consecutivo_nom',
                onclick => 'getListaLiquidacion'),
        );


        $this->SetVarsValidate($this->Campos);

    }

}

$Ajuste = new Ajuste();

?>