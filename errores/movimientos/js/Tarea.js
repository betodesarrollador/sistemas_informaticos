// JavaScript Document



$(document).ready(function () {



    tinymce.init({

        selector: '#descripcion,#observacion_cierre',

        entity_encoding: "raw",

        height : "500",

        plugins: 'image code'



    });



    var actividad_programada_id = $("#actividad_programada_id").val();

    if (parseInt(actividad_programada_id) > 0) {

        setDataFormWithResponse();

    }



});



function setDataFormWithResponse() {



    RequiredRemove();



    FindRow([{ campos: "actividad_programada_id", valores: $('#actividad_programada_id').val() }], document.forms[0], 'TareaClass.php', null,

        function (resp) {



            try {



                var data = $.parseJSON(resp);

                var actividad_programada_id = data[0]['actividad_programada_id'];

                var archivo = data[0]['archivo'];

                var estado = data[0]['estado'];

                var descripcion = data[0]['descripcion'];

                var observacion_cierre = data[0]['observacion_cierre'];



                tinymce.get('descripcion').setContent(descripcion);

                tinymce.get('observacion_cierre').setContent(observacion_cierre);



                var all_clientes = data[0]['all_clientes'];



                if (all_clientes == 'SI') {

                    document.getElementById('all_clientes').checked = true;

                    $('#all_clientes').val('SI');

                }



                var QueryString = "ACTIONCONTROLER=getClientes&actividad_programada_id=" + actividad_programada_id;



                $.ajax({

                    url: "TareaClass.php",

                    data: QueryString,

                    async: false,

                    success: function (response) {



                        var clientes = $.parseJSON(response);



                        for (i = 0; i < clientes.length; i++) {

                            $("#cliente_id option").each(function () {

                                if (this.value == 'NULL') {

                                    this.selected = false;

                                }

                                if (this.value == clientes[i]['cliente_id']) {

                                    this.selected = true;

                                }



                            });

                        }

                    }



                });



                if (archivo != '' && archivo != 'NULL' && archivo != 'null' && archivo != null) {

                    $("#adjuntover").html('<a  class="badge badge-info" href="' + archivo + '" target="_blank">Ver Adjunto</a>');

                } else {

                    $("#adjuntover").html('');

                }



                if (estado == 2) {



                    if ($('#guardar')) $('#guardar').attr("disabled", "true");

                    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");

                    if ($('#borrar')) $('#borrar').attr("disabled", "");

                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

                    if ($('#cerrar')) $('#cerrar').attr("disabled", "true");



                } else {



                    if ($('#guardar')) $('#guardar').attr("disabled", "true");

                    if ($('#actualizar')) $('#actualizar').attr("disabled", "");

                    if ($('#borrar')) $('#borrar').attr("disabled", "");

                    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

                    if ($('#cerrar')) $('#cerrar').attr("disabled", "");

                }



                cambioCliente(true);



            } catch (e) {

                alertJquery(resp, "Error :" + e);

            }



        });



}



function onSendFile(response) {



    if ($.trim(response) == 'false') {

        alertJquery('No se ha podido adjuntar el archivo !!');

    } else {



        alertJquery("Se ha Cargado el adjunto", "Validacion Adjunto");

    }



}



function validaSeleccionTarea() {



    /* var actividad_programada_id = $("#actividad_programada_id").val();



    if (parseInt(actividad_programada_id) > 0) {

        return true;

    } else {

        alertJquery('Debe cargar primero una tarea, Luego adjunte de nuevo el archivo!!', 'Validacion');

        return false;

    } */



}



function Cierre() {





    if ($("#divCierre").is(":visible")) {





        var actividad_programada_id = $("#actividad_programada_id").val();

        var fecha_cierre_real = $('#fecha_cierre_real').val();

        var observacion_cierre = $('#observacion_cierre').val();



        var QueryString = "ACTIONCONTROLER=guardarCierre&actividad_programada_id=" + actividad_programada_id + "&fecha_cierre_real=" + fecha_cierre_real + "&observacion_cierre=" + observacion_cierre + "&rand=" + Math.random();

        $.ajax({

            url: "TareaClass.php",

            data: QueryString,

            success: function (resp) {



                try {

                    alertJquery(resp, 'Tarea Cerrada');

                    formSubmitted = false;

                    setDataFormWithResponse();



                } catch (e) {

                    alertJquery(e, 'Tarea Cerrada');

                    formSubmitted = false;

                }



                $("#divCierre").dialog('close');

            }

        });



    } else {



        $("#divCierre").dialog({

            title: 'Cierre tarea',

            width: 450,

            height: 300,

            closeOnEscape: true

        });



    }



}



function TareaOnSaveOnUpdateonDelete(formulario, resp) {



    TareaOnReset(formulario);



    alertJquery(resp, "Tarea");



}



function TareaOnReset(formulario) {



    Reset(formulario);

    clearFind();

    resetDetalle('detalleTarea');

    $("#refresh_QUERYGRID_Tarea").click();



    tinymce.get('descripcion').setContent('');

    tinymce.get('observacion_cierre').setContent('');



    if ($('#guardar')) $('#guardar').attr("disabled", "");

    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");

    if ($('#borrar')) $('#borrar').attr("disabled", "true");

    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

    $("#estado").val("1");

    $("#prioridad").val("1");

    $("#adjuntover").html('&nbsp;');



}



function all_cliente() {



    if (document.getElementById('all_clientes').checked == true) {

        $('#all_clientes').val('SI');

        var objSelect = document.getElementById('cliente_id');

        var numOp = objSelect.options.length - 1;



        for (var i = numOp; i > 0; i--) {



            if (objSelect.options[i].value != 'NULL') {

                objSelect.options[i].selected = true;

            } else {

                objSelect.options[i].selected = false;

            }



        }

    } else {



        $('#all_clientes').val('NO');

        var objSelect = document.getElementById('cliente_id');

        var numOp = objSelect.options.length - 1;



        for (var i = numOp; i > 0; i--) {



            if (objSelect.options[i].value != 'NULL') {

                objSelect.options[i].selected = false;

            } else {

                objSelect.options[i].selected = true;

            }



        }



    }



    cambioCliente(false);



}



function enviarEmail(tipo) {



    var email_cliente = $("#email_cliente").val();

    var estado = $("#estado").val();

    var acta_id = $("#acta_id").val();

    var descripcion = $("#descripcion").val();

    var actividad_programada_id = $("#actividad_programada_id").val();

    var fecha_final = $("#fecha_final").val();



    if (tipo == 'F' && estado != '2') {



        alertJquery("La tarea debe de estar en estado <b>CERRADO</b> para poder enviar email al cliente !!", "Validacion");



        return false;



    }



    if (tipo == 'I' && estado != '1') {



        alertJquery("La tarea debe de estar en estado <b>ACTIVO</b> para poder enviar email al cliente !!", "Validacion");



        return false;



    }



    if (email_cliente != '') {



        $("#email_cliente").css("boxShadow", "none");



        jConfirm("Esta seguro que desea enviar email al cliente", "Validacion",



            function (r) {

                if (r) {



                    var QueryString = "ACTIONCONTROLER=sendCorreosCliente&email_cliente=" + email_cliente + "&descripcion="+descripcion+ "&actividad_programada_id="+actividad_programada_id+"&acta_id="+acta_id+"&tipo="+tipo+"&fecha_final="+fecha_final+"&rand=" + Math.random();



                    $.ajax({

                        url: "TareaClass.php",

                        data: QueryString,

                        type: 'POST',

                        async: false,

                        beforeSend: function () {

                            showDivLoading();

                        },

                        success: function (resp) {



                            alertJquery(resp);



                            removeDivLoading();

                        }

                    });







                } else {

                    return false;

                }

            });





    } else {



        $("#email_cliente").css("boxShadow", "0 0 5px 1px red");



    }



}



function cambioCliente(bandera) {



    if(bandera){



        if (document.getElementById('all_clientes').checked == true) {

            document.getElementById('all_clientes').checked = false;

            $('#all_clientes').val('NO');

        }



    }



    var cliente_id = $("#cliente_id").val();



    if (cliente_id != 'NULL' && cliente_id != '' && cliente_id != null) {



        var QueryString = "ACTIONCONTROLER=getCorreosCliente&cliente_id=" + cliente_id + "&rand=" + Math.random();



        $.ajax({

            url: "TareaClass.php",

            data: QueryString,

            async: false,

            beforeSend: function () {

                showDivLoading();

            },

            success: function (resp) {



                var data = $.parseJSON(resp);



                for (var i = 0; i < data.length; i++) {



                    var email = email == null ? data[i]['email'] : email + ";" + data[i]['email'];



                }



                $("#email_cliente").val(email);



                removeDivLoading();

            }

        });



    }





}