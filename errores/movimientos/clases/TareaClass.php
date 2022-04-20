<?php



require_once "../../../framework/clases/ControlerClass.php";



final class Tarea extends Controler

{



    public function __construct()

    {

        parent::__construct(2);

    }



    public function Main()

    {



        $this->noCache();



        require_once "TareaLayoutClass.php";

        require_once "TareaModelClass.php";



        $Layout = new TareaLayout($this->getTitleTab(), $this->getTitleForm());

        $Model = new TareaModel();



        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());



        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));

        $Layout->setActualizar($Model->getPermiso($this->getActividadId(), 'UPDATE', $this->getConex()));

        $Layout->setBorrar($Model->getPermiso($this->getActividadId(), 'DELETE', $this->getConex()));

        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));



        $Layout->setCampos($this->Campos);



        //LISTA MENU

        $Layout->SetCliente($Model->GetCliente($this->getConex()));

        $Layout->SetTipo($Model->GetTipo($this->getConex()));



        $actividad_programada_id = $_REQUEST['actividad_programada_id'];

        if ($actividad_programada_id > 0) {

            $Layout->setActividadProgramadaId($actividad_programada_id);

        }



        //// GRID ////

        $Attributes = array(



            id => 'actividad_programada_id',

            title => 'Listado  de Tareas',

            sortname => 'nombre',

            width => '1300',

            height => '250',

        );



        $Cols = array(



            array(name => 'actividad_programada_id', index => 'actividad_programada_id', width => '80', align => 'center'),

            array(name => 'tipo_tarea', index => 'tipo_tarea', width => '100', align => 'center'),

            array(name => 'nombre', index => 'nombre', width => '600', align => 'center'),

            array(name => 'cliente', index => 'cliente', width => '400', align => 'center'),

            array(name => 'fecha_inicial', index => 'fecha_inicial', width => '100', align => 'center'),

            array(name => 'fecha_final', index => 'fecha_final', width => '100', align => 'center'),

            array(name => 'fecha_inicial_real', index => 'fecha_inicial_real', width => '150', align => 'center'),

            array(name => 'fecha_final_real', index => 'fecha_final_real', width => '150', align => 'center'),

            array(name => 'fecha_cierre', index => 'fecha_cierre', width => '150', align => 'center'),

            array(name => 'estado', index => 'estado', width => '100', align => 'center'),

        );



        $Titles = array('CODIGO',

            'TIPO',

            'NOMBRE',

            'CLIENTE',

            'FECHA INICIO',

            'FECHA FINAL',

            'FECHA INICIO REAL',

            'FECHA FINAL REAL',

            'FECHA CIERRE',

            'ESTADO',

        );



        $Layout->SetGridTarea($Attributes, $Titles, $Cols, $Model->getQueryTareaGrid());



        $Layout->RenderMain();



    }



    protected function onclickValidateRow()

    {



        require_once "../../../framework/clases/ValidateRowClass.php";

        $Data = new ValidateRow($this->getConex(), "Tarea", $this->Campos);

        print $Data->GetData();



    }



    protected function getCorreosCliente()

    {



        require_once "TareaModelClass.php";

        $Model = new TareaModel();



        $Data = $Model->getCorreosCliente($this->getConex());



        $this->getArrayJSON($Data);



    }



    protected function sendCorreosCliente()

    {



        $correos = explode(";", $_REQUEST['email_cliente']);

        $acta_id = $_REQUEST['acta_id'];

        $descripcion = $_REQUEST['descripcion'];

        $tipo = $_REQUEST['tipo'];

        $fecha_final = $_REQUEST['fecha_final'];



        if($acta_id==''){

            exit("Por favor asociar la tarea a un acta para poder enviar el correo.");

        }



        require_once "../../parametros_errores/clases/Imp_ActaClass.php";

        require_once "../../parametros_errores/clases/ActaModelClass.php";

        require_once "TareaModelClass.php";

        require_once "../../../framework/clases/MailClass.php";



        $imp_acta = new Imp_Acta($this->getConex());



        $Model = new ActaModel();



        $data = $Model->selectActa($acta_id, $this->getConex());





        $nombre_acta = $data[0]['nombre_acta'];



        $nombre_pdf = '../../../archivos/errores/actas/' . $acta_id . '_' . $nombre_acta . '.pdf';



        $download = 'true';



        $imp_acta->printOut($acta_id, $download, $nombre_pdf);



        if($tipo == 'F'){



            $encabezado = "Se ha finalizado el siguiente punto de la acta";

            $asunto = "Avances";

            

        }else{

            

            $encabezado = "Se ha dado inicio al siguiente punto del acta para entregar la fecha : $fecha_final";

            $asunto = "Inicio de requerimiento";



        }

        

        $body = utf8_decode(



        $encabezado.'<br /><br />



        Nombre de Acta : ' . $nombre_acta . '.<br /><br />



        Descripcion : ' . $descripcion . '.<br /><br />



        Adjunto se envía el acta en pdf para poder visualizarla.<br /><br />



        Cordialmente,<br /><br />



        <img src="https://siandsi1.co/sistemas_informaticos/framework/media/images/varios/logosiandsi.jpg" alt="logo" width="125" /><br>

        <strong>Sistemas Informaticos y Soluciones Integrales');



        for ($i = 0; $i < count($correos); $i++) {



            $enviar_mail = new Mail();



            $enviar_mail->sendMail($correos[$i],$asunto,$body,$nombre_pdf,$acta_id.'_'.$nombre_acta.'.pdf');  

        

            if (!$enviar_mail) {

                die("error enviando correo : $enviar_mail <br> correo : ".$correos[$i]);

            }



        }



        for ($i = 0; $i < count($correos); $i++) {



            $Model = new TareaModel();

            $Model->save_envio_correo_cliente($correos[$i], $this->getConex());



        }



        exit("Correo enviado de manera exitosa !");



    }

    



    protected function sendCorreos($codigo, $correo, $enviar_mail)

    {



        $asignada = $_REQUEST['creador'];

        $responsable = $_REQUEST['responsable'] == 'NULL' ? 'POR ASIGNAR' : $_REQUEST['responsable'];

        $descripcion = $_REQUEST['descripcion'];

        $fecha_inicial = $_REQUEST['fecha_inicial'];

        $fecha_final = $_REQUEST['fecha_final'];

        $nombre = $_REQUEST['nombre'];

        $tipo_tarea_id = $_REQUEST['tipo_tarea_id'];

        $all_clientes = $_REQUEST['all_clientes'];

        $cadena_clientes = '';



        if ($all_clientes == 'SI') {

            $cadena_clientes = 'TODOS';

        } else {

            require_once "TareaModelClass.php";

            $Model = new TareaModel();

            $clientes = $Model->getClientes($codigo, $this->getConex());

            foreach ($clientes as $cliente) {

                $cadena_clientes .= $cliente['cliente'] . '<br>';

            }

        }



        switch ($tipo_tarea_id) {

            case '1': //Desarrollo

                $tipo_tarea = 'Desarrollo';

                break;

            case '2': //Soporte

                $tipo_tarea = 'Soporte';

                break;

            case '3': //Administrativa

                $tipo_tarea = 'Administrativa';

                break;

            case '4': //Marketing

                $tipo_tarea = 'Marketing';

                break;



            default:

                $tipo_tarea = 'por definir area';

                break;

        }



        $mail_subject = "Se ingreso una nueva tarea, codigo $codigo";



        $body = '

		<table width="95%"   cellspacing="1">



			<tr>

				<td  align="left" colspan="2">



					Informacion general de la tarea.<br><br>



				</td>

			</tr>



			<tr>

				<td  align="left">Area :</td>

				<td  align="left">' . $tipo_tarea . '</td>

		 	</tr>



			<tr>

				<td  align="left">Asiganada por :</td>

				<td  align="left">' . $asignada . '</td>

			</tr>

			<tr>

				<td  align="left">Responsable :</td>

				<td  align="left">' . $responsable . '</td>

			</tr>

			<tr>

				<td  align="left">Cliente(s) :</td>

				<td  align="left">' . $cadena_clientes . '</td>

			</tr>

			<tr>

				<td  align="left">Nombre :</td>

				<td  align="left">' . $nombre . '</td>

			</tr>

			<tr>

				<td  align="left">Descripcion :</td>

				<td  align="left">' . $descripcion . '</td>

			</tr>

			<tr>

				<td  align="left">Fecha inicial :</td>

				<td  align="left">' . $fecha_inicial . '</td>

			</tr>

			<tr>

				<td  align="left">Fecha final :</td>

				<td  align="left">' . $fecha_final . '</td>

			</tr>



			<tr>

				<td  align="left">

					<br><br>

					Cordialmente,<br /><br />

					<img src="https://siandsi1.co/sistemas_informaticos/framework/media/images/varios/logosiandsi.jpg" alt="logo" width="125" /><br>

					<strong>Sistemas informaticos y soluciones integrales</strong>



				</td>

			</tr>

		 </table>';



        $enviar_mail->sendMail(strval("$correo"), $mail_subject, $body); /* soporte@siandsi.co */



        if (!$enviar_mail) {

            die('error enviando correo :' . $enviar_mail);

        }



    }



    protected function sendCorreosUpdate($data, $enviar_mail)

    {



        $codigo = $_REQUEST['actividad_programada_id'];

        $descripcion = $_REQUEST['descripcion'];

        $fecha_inicial = $_REQUEST['fecha_inicial'];

        $fecha_final = $_REQUEST['fecha_final'];

        $nombre = $_REQUEST['nombre'];

        $tipo_tarea_id = $_REQUEST['tipo_tarea_id'];

        $correo = $data[0]['email_lider'];



        switch ($tipo_tarea_id) {

            case '1': //Desarrollo

                $tipo_tarea = 'Desarrollo';

                break;

            case '2': //Soporte

                $tipo_tarea = 'Soporte';

                break;

            case '3': //Administrativa

                $tipo_tarea = 'Administrativa';

                break;

            case '4': //Marketing

                $tipo_tarea = 'Marketing';

                break;



            default:

                $tipo_tarea = 'por definir area';

                break;

        }



        $mail_subject = "Se actualizo tarea, codigo $codigo";



        $body = '

		<table width="95%"   cellspacing="1">



			<tr>

				<td  align="left" colspan="2">



					Informacion general de la tarea DESPUES .<br><br>



				</td>

			</tr>



			<tr>

				<td  align="left">Area :</td>

				<td  align="left">' . $tipo_tarea . '</td>

		 	</tr>



			<tr>

				<td  align="left">Nombre :</td>

				<td  align="left">' . $nombre . '</td>

			</tr>

			<tr>

				<td  align="left">Descripcion :</td>

				<td  align="left">' . $descripcion . '</td>

			</tr>

			<tr>

				<td  align="left">Fecha inicial :</td>

				<td  align="left">' . $fecha_inicial . '</td>

			</tr>

			<tr>

				<td  align="left">Fecha final :</td>

				<td  align="left">' . $fecha_final . '</td>

			</tr>



		 </table>

		 <br><br>

		 <table width="95%"   cellspacing="1">



			<tr>

				<td  align="left" colspan="2">



					Informacion general de la tarea ANTES .<br><br>



				</td>

			</tr>



			<tr>

				<td  align="left">Area :</td>

				<td  align="left">' . $tipo_tarea . '</td>

		 	</tr>



			<tr>

				<td  align="left">Nombre :</td>

				<td  align="left">' . $data[0]['nombre'] . '</td>

			</tr>

			<tr>

				<td  align="left">Descripcion :</td>

				<td  align="left">' . $data[0]['descripcion'] . '</td>

			</tr>

			<tr>

				<td  align="left">Fecha inicial :</td>

				<td  align="left">' . $data[0]['fecha_inicial'] . '</td>

			</tr>

			<tr>

				<td  align="left">Fecha final :</td>

				<td  align="left">' . $data[0]['fecha_final'] . '</td>

			</tr>



			<tr>

				<td  align="left">

					<br><br>

					Cordialmente,<br /><br />

					<img src="https://siandsi1.co/sistemas_informaticos/framework/media/images/varios/logosiandsi.jpg" alt="logo" width="125" /><br>

					<strong>Sistemas informaticos y soluciones integrales</strong>



				</td>

			</tr>

		 </table>';



        $enviar_mail->sendMail(strval("$correo"), $mail_subject, $body); /* soporte@siandsi.co */



        if (!$enviar_mail) {

            die('error enviando correo :' . $enviar_mail);

        }



    }



    protected function onclickSave()

    {



        require_once "TareaModelClass.php";

        $Model = new TareaModel();



        $data = $Model->Save($this->Campos, $this->getUsuarioId(), $this->getConex());



        if ($Model->GetNumError() > 0) {

            exit('Ocurrio una inconsistencia');

        } else {



            require_once "../../../framework/clases/MailClass.php";



            for ($i = 0; $i < count($data); $i++) {



                if ($data[$i]['email'] != '') {



                    $enviar_mail = new Mail();

                    $this->sendCorreos(strval($data[$i]['codigo']), $data[$i]['email'], $enviar_mail);



                }



            }



            exit(" Se ingreso correctamente la tarea !! <br>Codigo : <b>" . $data[0]['codigo'] . "</b>");

        }



    }



    protected function onclickUpdate()

    {



        require_once "TareaModelClass.php";

        $Model = new TareaModel();

        $actividad_programada_id = $this->requestData('actividad_programada_id');



        $data = $Model->Update($actividad_programada_id, $this->Campos, $this->getUsuarioId(), $this->getConex());



        require_once "../../../framework/clases/MailClass.php";



        $enviar_mail = new Mail();



        $this->sendCorreosUpdate($data, $enviar_mail);



        if ($Model->GetNumError() > 0) {

            exit('Ocurrio una inconsistencia');

        } else {

            exit('¡Se actualizo correctamente la tarea!');

        }



    }



    protected function onclickDelete()

    {



        require_once "TareaModelClass.php";

        $Model = new TareaModel();



        $Model->Delete($this->Campos, $this->getConex());



        if ($Model->GetNumError() > 0) {

            exit('Ocurrio una inconsistencia');

        } else {

            exit('Se elimino correctamente el Tarea');

        }

    }



    protected function getClientes()

    {

        require_once "TareaModelClass.php";

        $Model = new TareaModel();

        $actividad_programada_id = $_REQUEST['actividad_programada_id'];

        $data = $Model->getClientes($actividad_programada_id, $this->getConex());

        print json_encode($data);

    }



//BUSQUEDA

    protected function onclickFind()

    {

        require_once "TareaModelClass.php";

        $Model = new TareaModel();

        $Data = $Model->selectTarea($this->getConex());

        $this->getArrayJSON($Data);

    }



    protected function guardarCierre()

    {



        require_once "TareaModelClass.php";

        $Model = new TareaModel();



        $actividad_programada_id = $_REQUEST['actividad_programada_id'];

        $fecha_cierre = date("Y-m-d H:i:s");

        $fecha_cierre_real = $_REQUEST['fecha_cierre_real'];

        $observacion_cierre = htmlentities($_REQUEST["observacion_cierre"]);



        $Model->SaveCierre($actividad_programada_id, $fecha_cierre, $fecha_cierre_real, $observacion_cierre, $this->getUsuarioId(), $this->getConex());



        if ($Model->GetNumError() > 0) {

            exit('Ocurrio una inconsistencia');

        } else {

            exit("¡Tarea cerrada exitosamente!");

        }



    }



    protected function uploadFileAutomatically()

    {

        require_once "TareaModelClass.php";



        $Model = new TareaModel();

        $actividad_programada_id = $_REQUEST['actividad_programada_id'];

        $ruta = "../../../archivos/errores/tareas/";

        $archivo = $_FILES['archivo'];

        $nombreArchivo = "adjunto_tarea_" . $actividad_programada_id;

        $dir_file = $this->moveUploadedFile($archivo, $ruta, $nombreArchivo);



        $Model->setAdjunto($actividad_programada_id, $dir_file, $this->getConex());



        if (strlen($Model->GetError()) > 0) {

            exit('false');

        } else {

            exit('true');

        }



    }



    protected function setCampos()

    {



        //campos formulario

        $this->Campos[actividad_programada_id] = array(

            name => 'actividad_programada_id',

            id => 'actividad_programada_id',

            type => 'text',

            Boostrap => 'si',

            disabled => 'true',

            //required=>'no',

            datatype => array(

                type => 'autoincrement'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('primary_key')),

        );



        $this->Campos[all_clientes] = array(

            name => 'all_clientes',

            id => 'all_clientes',

            type => 'checkbox',

            onclick => 'all_cliente();',

            value => 'NO',

            datatype => array(

                type => 'text'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[cliente_id] = array(

            name => 'cliente_id[]',

            id => 'cliente_id',

            type => 'select',

            onchange => 'cambioCliente()',

            Boostrap => 'si',

            required => 'yes',

            multiple => 'yes',

        );



        $this->Campos[responsable] = array(

            name => 'responsable',

            id => 'responsable',

            type => 'text',

            Boostrap => 'si',

            size => 40,

            suggest => array(

                name => 'usuario',

                setId => 'responsable_hidden'),

        );



        $this->Campos[email_cliente] = array(

            name => 'email_cliente',

            id => 'email_cliente',

            type => 'text',

            Boostrap => 'si',

            datatype => array(

                type => 'text',

                length => '100'),

        );



        $this->Campos[responsable_id] = array(

            name => 'responsable_id',

            id => 'responsable_hidden',

            type => 'hidden',

            datatype => array(

                type => 'integer',

                length => '20'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[acta_id] = array(

            name => 'acta_id',

            id => 'acta_id',

            type => 'hidden',

            datatype => array(

                type => 'integer',

                length => '20'),

        );



        $this->Campos[creador] = array(

            name => 'creador',

            id => 'creador',

            type => 'text',

            required => 'yes',

            Boostrap => 'si',

            size => 40,

            suggest => array(

                name => 'usuario',

                setId => 'creador_hidden'),

        );



        $this->Campos[creador_id] = array(

            name => 'creador_id',

            id => 'creador_hidden',

            type => 'hidden',

            datatype => array(

                type => 'integer',

                length => '20'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[nombre] = array(

            name => 'nombre',

            id => 'nombre',

            type => 'text',

            Boostrap => 'si',

            required => 'yes',

            size => '20',

            datatype => array(

                type => 'text'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[descripcion] = array(

            name => 'descripcion',

            id => 'descripcion',

            type => 'textarea',

            text_uppercase    =>'no',

            cols => '150',

            rows => '5',

            datatype => array(

                type => 'text'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[observacion_cierre] = array(

            name => 'observacion_cierre',

            id => 'observacion_cierre',

            type => 'textarea',

            text_uppercase    =>'no',

            cols => '150',

            rows => '5',

            datatype => array(

                type => 'text'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_inicial] = array(

            name => 'fecha_inicial',

            id => 'fecha_inicial',

            type => 'text',

            Boostrap => 'si',

            required => 'yes',

            size => '20',

            datatype => array(

                type => 'date'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_final] = array(

            name => 'fecha_final',

            id => 'fecha_final',

            type => 'text',

            Boostrap => 'si',

            required => 'yes',

            size => '20',

            datatype => array(

                type => 'date'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_inicial_real] = array(

            name => 'fecha_inicial_real',

            id => 'fecha_inicial_real',

            type => 'text',

            Boostrap => 'si',

            size => '20',

            datatype => array(

                type => 'date'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_final_real] = array(

            name => 'fecha_final_real',

            id => 'fecha_final_real',

            type => 'text',

            Boostrap => 'si',

            size => '20',

            datatype => array(

                type => 'date'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[archivo] = array(

            name => 'archivo',

            id => 'archivo',

            type => 'file',

            path => '/sistemas_informaticos/archivos/errores/tareas/',

            datatype => array(type => 'file'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

            namefile => array(

                field => 'yes',

                namefield => 'actividad_programada_id',

                text => '_archivo'),

        );



        $this->Campos[tipo_tarea_id] = array(

            name => 'tipo_tarea_id',

            id => 'tipo_tarea_id',

            type => 'select',

            Boostrap => 'si',

            required => 'yes',

            options => array(),

            datatype => array(

                type => 'integer',

                length => '11'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[prioridad] = array(

            name => 'prioridad',

            id => 'prioridad',

            type => 'select',

            Boostrap => 'si',

            options => array(array(value => '1', text => 'ALTA', selected => '1'), array(value => '2', text => 'MEDIA'), array(value => '3', text => 'BAJA')),

            required => 'yes',

            datatype => array(

                type => 'integer'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_registro] = array(

            name => 'fecha_registro',

            id => 'fecha_registro',

            type => 'hidden',

            //required=>'yes',

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[estado] = array(

            name => 'estado',

            id => 'estado',

            type => 'select',

            Boostrap => 'si',

            options => array(array(value => '1', text => 'ACTIVO', selected => '1'), array(value => '0', text => 'INACTIVO'), array(value => '2', text => 'CERRADO'), array(value => '3', text => 'FINALIZADA/PENDIENTE POR ENTREGAR')),

            required => 'yes',

            datatype => array(

                type => 'integer'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[usuario_id] = array(

            name => 'usuario_id',

            id => 'usuario_id',

            type => 'hidden',

            //disabled=>'true',

            datatype => array(

                type => 'integer'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_actualiza] = array(

            name => 'fecha_actualiza',

            id => 'fecha_actualiza',

            type => 'hidden',

            //required=>'yes',

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[usuario_actualiza_id] = array(

            name => 'usuario_actualiza_id',

            id => 'usuario_actualiza_id',

            type => 'hidden',

            //disabled=>'true',

            //required=>'no',

            datatype => array(

                type => 'integer'),

            transaction => array(

                table => array('actividad_programada'),

                type => array('column')),

        );



        $this->Campos[fecha_cierre] = array(

            name => 'fecha_cierre',

            id => 'fecha_cierre',

            type => 'text',

            Boostrap => 'si',

            //required=>'yes',

            size => '20',

            datatype => array(

                type => 'date'),

        );



        $this->Campos[fecha_cierre_real] = array(

            name => 'fecha_cierre_real',

            id => 'fecha_cierre_real',

            type => 'text',

            Boostrap => 'si',

            //required=>'yes',

            size => '20',

            datatype => array(

                type => 'date'),

        );





        $this->Campos[usuario_cierre_id] = array(

            name => 'usuario_cierre_id',

            id => 'usuario_cierre_id',

            type => 'hidden',

            //disabled=>'true',

            datatype => array(

                type => 'integer'),

        );



        //botones

        $this->Campos[guardar] = array(

            name => 'guardar',

            id => 'guardar',

            type => 'button',

            value => 'Guardar',

            property => array(

                name => 'save_ajax',

                onsuccess => 'TareaOnSaveOnUpdateonDelete'),



        );



        $this->Campos[actualizar] = array(

            name => 'actualizar',

            id => 'actualizar',

            type => 'button',

            value => 'Actualizar',

            disabled => 'disabled',

            property => array(

                name => 'update_ajax',

                onsuccess => 'TareaOnSaveOnUpdateonDelete'),

        );



        $this->Campos[borrar] = array(

            name => 'borrar',

            id => 'borrar',

            type => 'button',

            value => 'Borrar',

            Clase => 'btn btn-danger',

            disabled => 'disabled',

            property => array(

                name => 'delete_ajax',

                onsuccess => 'TareaOnSaveOnUpdateonDelete'),

        );



        $this->Campos[limpiar] = array(

            name => 'limpiar',

            id => 'limpiar',

            type => 'reset',

            value => 'Limpiar',

            onclick => 'TareaOnReset(this.form)',

        );



        $this->Campos[cerrar] = array(

            name => 'cerrar',

            id => 'cerrar',

            type => 'button',

            value => 'Cerrar',

            Clase => 'btn btn-success',

            tabindex => '14',

            onclick => 'Cierre(this.form)',

        );



        $this->Campos[enviar_email_finalizacion] = array(

            name => 'enviar_email_finalizacion',

            id => 'enviar_email_finalizacion',

            type => 'button',

            value => 'Enviar email de finalizacion',

            Clase => 'btn btn-warning',

            tabindex => '14',

            onclick => "enviarEmail('F')",

        );

        



        $this->Campos[enviar_email_inicio] = array(

            name => 'enviar_email_inicio',

            id => 'enviar_email_inicio',

            type => 'button',

            value => 'Enviar email de inicio',

            Clase => 'btn btn-warning',

            tabindex => '14',

            onclick => "enviarEmail('I')",

        );



        //busqueda

        $this->Campos[busqueda] = array(

            name => 'busqueda',

            id => 'busqueda',

            type => 'text',

            size => '85',

            Boostrap => 'si',

            placeholder => 'ESCRIBA EL CODIGO O NOMBRE DE LA TAREA',

            //tabindex=>'1',

            suggest => array(

                name => 'actividad_programada',

                setId => 'actividad_programada_id',

                onclick => 'setDataFormWithResponse'),

        );



        $this->SetVarsValidate($this->Campos);

    }



}



$Tarea = new Tarea();

