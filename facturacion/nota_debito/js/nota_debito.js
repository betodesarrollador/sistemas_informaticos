// JavaScript Document
var formSubmitted = false;
$(document).ready(function() {

    $("#divIca").css("display", "none");

    var nota_debito_id = $("#nota_debito_id").val();

    if (nota_debito_id > 0 && nota_debito_id != '') {

        setDataFormWithResponse();
    }

    $("#saveDetallepuc").click(function() {
        window.frames[0].saveDetalles();
    });

    $("#Buscar").click(function() {
        cargardiv();

    });

    /*$("#guardar,#actualizar").click(function () {


        var formulario = document.getElementById('FacturaForm');

        if (ValidaRequeridos(formulario)) {
            if (this.id == 'guardar') {
                $('#guardar').attr("disabled", ""); //aca
                if (!formSubmitted) {
                    formSubmitted = true;
                    Send(formulario, 'onclickSave', null, NotaOnSave);
                }
            } else {
                Send(formulario, 'onclickUpdate', null, FacturaOnUpdate);
            }
        }
        formSubmitted = false;

    });*/

    $("#valor_nota,#tipo_bien_servicio_factura,#fecha_nota,#motivo_nota,#concepto").blur(function() {

        var previsual = 1;
        var valor_nota = removeFormatCurrency($('#valor_nota').val());
        var tipo_bien_servicio_factura = $('#tipo_bien_servicio_factura').val();
        var formulario = document.getElementById('NotaDebitoForm');
        var estado = $('#estado').val();
        var fecha_nota = $('#fecha_nota').val();
        var motivo_nota = $('#motivo_nota').val();
        var concepto = $('#concepto').val();

        if (fecha_nota != '' && fecha_nota != 'NULL' && fecha_nota != null && valor_nota != 0 && valor_nota != '' && motivo_nota != '' && motivo_nota != 'NULL' && motivo_nota != null && motivo_nota > 0 && concepto != '' && concepto != 'NULL' && concepto != null && tipo_bien_servicio_factura != 'NULL' && tipo_bien_servicio_factura != '' && tipo_bien_servicio_factura != null && tipo_bien_servicio_factura > 0 && estado == 'A') {

            if (ValidaRequeridos(formulario)) {

                previsualizar(previsual, valor_nota, tipo_bien_servicio_factura);

            }

        }

    });

    parent.$("#confirmar").click(function() {

        var impuesto = parent.document.getElementById('impuesto').value;
        $("#impuesto_id").val(impuesto);
        $("#divIca").dialog('close');

    });

});

function showTable(){
  
    var frame_grid =  document.getElementById('frame_grid');
    
      //Se valida que el iFrame no exista
      if(frame_grid == null ){
  
      var QueryString   = 'ACTIONCONTROLER=showGrid';
  
      $.ajax({
        url        : "NotaDebitoClass.php?rand="+Math.random(),
        data       : QueryString,
         async     : false,
        beforeSend : function(){
        showDivLoading();
        },
        success    : function(resp){
          console.log(resp);
          try{
            
            var iframe           = document.createElement('iframe');
            iframe.id            ='frame_grid';
            iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
            //iframe.scrolling   = 'no';
            
            document.body.appendChild(iframe); 
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(resp);
            iframe.contentWindow.document.close();
            
            $('#mostrar_grid').removeClass('btn btn-warning btn-sm');
            $('#mostrar_grid').addClass('btn btn-secondary btn-sm');
            $('#mostrar_grid').html('Ocultar tabla');
            
          }catch(e){
            
            console.log(e);
            
          }
          removeDivLoading();
        } 
      });
      
    }else{
      
        $('#frame_grid').remove();
        $('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
        $('#mostrar_grid').addClass('btn btn-warning btn-sm');
        $('#mostrar_grid').html('Mostrar tabla');
      
    }
    
  }

function previsualizar(previsual, valor_nota, tipo_bien_servicio_factura) {

    var formulario = document.getElementById('NotaDebitoForm');
    var url = "NotaDebitoClass.php?ACTIONCONTROLER=onclickSave&" + FormSerialize(formulario) + "&previsual=" + previsual + "&valor_nota=" + valor_nota + "&tipo_bien_servicio_factura=" + tipo_bien_servicio_factura;
    $("#subtotales").attr("src", url);

}

function beforePdf() {
    var factura_id = parseInt($("#factura_id").val());

    if (isNaN(factura_id)) {
        alertJquery("Debe seleccionar una Factura  !!!", "PDF Factura");
        return false;
    } else {
        var QueryString =
            "NotaDebitoClass.php?ACTIONCONTROLER=onclickPrint&tipo=PDF&factura_id=" +
            factura_id;
        popPup(QueryString, "Impresion factura", 800, 600);
    }
}

function setDataFormWithResponse() {

    var nota_debito_id = $('#nota_debito_id').val();
    console.log(nota_debito_id);
    var parametros = new Array({ campos: "nota_debito_id", valores: $('#nota_debito_id').val() });
    var forma = document.forms[0];
    var controlador = 'NotaDebitoClass.php';

    FindRow(parametros, forma, controlador, null, function(resp) {

        var data = $.parseJSON(resp);
        var estado = data[0]['estado'];
        var factura_id = data[0]['factura_id'];
        var tipo_bien_servicio_factura = data[0]['tipo_bien_servicio_factura'];

        if (estado == 'I') {

            $(forma).find("input,select,textarea").each(function() {
                this.disabled = true;
            });

        }



        //RequiredRemove();

        if ($('#guardar')) $('#guardar').attr("disabled", "true");
        if ($('#estado').val() == 'A') {
            if ($('#actualizar')) $('#actualizar').removeAttr("disabled");
            if ($('#contabilizar')) $('#contabilizar').removeAttr("disabled");
            if ($('#anular')) $('#anular').removeAttr("disabled");
        } else if ($('#estado').val() == 'C') {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#anular')) $('#anular').removeAttr("disabled");

        } else {
            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
            if ($('#estado')) $('#estado').attr("disabled", "true");
            if ($('#anular')) $('#anular').attr("disabled", "true");
        }
        if ($('#imprimir')) $('#imprimir').removeAttr("disabled");
        if ($('#imprimir_pdf')) $('#imprimir_pdf').removeAttr("disabled");
        if ($('#envio_factura')) $('#envio_factura').removeAttr("disabled");
        if ($('#reportarvp')) $('#reportarvp').removeAttr("disabled");
        if ($('#limpiar')) $('#limpiar').removeAttr("disabled");

        setDataFactura(factura_id, tipo_bien_servicio_factura);

        var url = "NotaDebitoClass.php?ACTIONCONTROLER=mostrarResultados&nota_debito_id=" + nota_debito_id;
        $("#subtotales").attr("src", url);

    });
}

function viewDoc(nota_debito_id) {
    $('#nota_debito_id').val(nota_debito_id);
    setDataFormWithResponse();
}

function NotaOnSave(formulario) {
    if (ValidaRequeridos(formulario)) {
        var previsual = 0;
        var valor_nota = removeFormatCurrency($('#valor_nota').val());
        var tipo_bien_servicio_factura = $('#tipo_bien_servicio_factura').val();
        var QueryString = "ACTIONCONTROLER=onclickSave&" + FormSerialize(formulario) + "&previsual=" + previsual + "&valor_nota=" + valor_nota + "&tipo_bien_servicio_factura=" + tipo_bien_servicio_factura;

        $.ajax({
            url: "NotaDebitoClass.php?rand=" + Math.random(),
            data: QueryString,
            type: 'POST',
            beforeSend: function() {

            },
            success: function(response) {

                try {

                    var responseArray = $.parseJSON(response);
                    var nota_debito_id = responseArray[0]['nota_debito_id'];
                    //console.log(nota_debito_id+' test '+responseArray[0]['nota_debito_id']);
                    $('#nota_debito_id').val(nota_debito_id);
                    if (responseArray.length > 0) {
                        alertJquery('¡La Nota Debito ha sido creada con Exito!', 'Nota Debito');

                        if ($('#guardar')) $('#guardar').attr("disabled", "true");
                        if ($('#estado').val() == 'A') {
                            if ($('#actualizar')) $('#actualizar').removeAttr("disabled");
                            if ($('#contabilizar')) $('#contabilizar').removeAttr("disabled");
                            if ($('#anular')) $('#anular').removeAttr("disabled");
                        } else if ($('#estado').val() == 'C') {
                            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
                            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
                            if ($('#anular')) $('#anular').removeAttr("disabled");

                        } else {
                            if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
                            if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
                            if ($('#estado')) $('#estado').attr("disabled", "true");
                            if ($('#anular')) $('#anular').attr("disabled", "true");
                        }
                        if ($('#imprimir')) $('#imprimir').removeAttr("disabled");
                        if ($('#imprimir1')) $('#imprimir1').removeAttr("disabled");
                        if ($('#limpiar')) $('#limpiar').removeAttr("disabled");

                    }

                } catch (e) {
                    alertJquery('Error: \n' + e, "Error");
                }

            }

        });
    }
}

function NotaOnUpdate(formulario) {

    if (ValidaRequeridos(formulario)) {

        jConfirm("Actualizar la Nota Débito hara que los <strong>detalles</strong> existentes se <strong>sobrescriban</strong>.\n\n<center>¿Está realmente seguro de que desea continuar?</center>", "ADVERTENCIA",

            function(r) {
                if (r) {
                    //Codigo si se le da ACEPTAR al Jconfirm.
                    var previsual = 0;
                    var valor_nota = removeFormatCurrency($('#valor_nota').val());
                    var tipo_bien_servicio_factura = $('#tipo_bien_servicio_factura').val();
                    var QueryString = "ACTIONCONTROLER=onClickUpdate&" + FormSerialize(formulario) + "&previsual=" + previsual + "&valor_nota=" + valor_nota + "&tipo_bien_servicio_factura=" + tipo_bien_servicio_factura;

                    $.ajax({
                        url: "NotaDebitoClass.php?rand=" + Math.random(),
                        data: QueryString,
                        type: 'POST',
                        beforeSend: function() {

                        },
                        success: function(response) {

                            try {

                                console.log('test' + response);
                                if (response == 'true') {

                                    setDataFormWithResponse();
                                    alertJquery('¡La Nota Debito ha sido Actualizada con Exito!', 'Nota Debito');

                                    if ($('#guardar')) $('#guardar').attr("disabled", "true");
                                    if ($('#estado').val() == 'A') {
                                        if ($('#actualizar')) $('#actualizar').removeAttr("disabled");
                                        if ($('#contabilizar')) $('#contabilizar').removeAttr("disabled");
                                        if ($('#anular')) $('#anular').removeAttr("disabled");
                                    } else if ($('#estado').val() == 'C') {
                                        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
                                        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
                                        if ($('#anular')) $('#anular').removeAttr("disabled");

                                    } else {
                                        if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
                                        if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
                                        if ($('#estado')) $('#estado').attr("disabled", "true");
                                        if ($('#anular')) $('#anular').attr("disabled", "true");
                                    }
                                    if ($('#imprimir')) $('#imprimir').removeAttr("disabled");
                                    if ($('#imprimir1')) $('#imprimir1').removeAttr("disabled");
                                    if ($('#limpiar')) $('#limpiar').removeAttr("disabled");

                                }

                            } catch (e) {
                                alertJquery('Error: \n' + e, "Error");
                            }

                        }

                    });
                } else {
                    alertJquery("La Nota Débito no se actualizará", "ATENCIÓN");
                }
            });

    }

}

function NotaOnReset(formulario) {

    $("#detalles").attr("src", "../../../framework/tpl/blank.html");
    $("#subtotales").attr("src", "../../../framework/tpl/blank.html");
    $("#detallesContables").attr("src", "../../../framework/tpl/blank.html");
    if ($('#guardar')) $('#guardar').removeAttr("disabled");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#contabilizar')) $('#contabilizar').attr("disabled", "true");
    if ($('#anular')) $('#anular').attr("disabled", "true");
    if ($('#imprimir')) $('#imprimir').attr("disabled", "true");
    if ($('#imprimir_pdf')) $('#imprimir_pdf').attr("disabled", "true");
    if ($('#envio_factura')) $('#envio_factura').attr("disabled", "true");
    if ($('#reportarvp')) $('#reportarvp').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').removeAttr("disabled");
    clearFind();

    document.getElementById('usuario_id').value = document.getElementById('anul_usuario_id').value;
    document.getElementById('ingreso_factura').value = document.getElementById('anul_factura').value;
    document.getElementById('oficina_id').value = document.getElementById('anul_oficina_id').value;
    if ($('#estado')) $('#estado').attr("disabled", "true");
    document.getElementById('estado').value = 'A';
}

function beforePrint(formulario, url, title, width, height) {

    var encabezado_registro_id = $('#encabezado_registro_id').val();

    if (encabezado_registro_id > 0) {
        return true;
    } else {
        alertJquery("Ninguna Nota Debito seleccionada", "Impresion Documento Contable");
        return false;
    }

}

/*function cargardiv() {
    var cliente_id = $('#cliente_hidden').val();
    var fuente_facturacion_cod = $('#fuente_facturacion_cod').val();
    var tipo_bien_servicio_factura_os = $('#tipo_bien_servicio_factura_os').val();
    var tipo_bien_servicio_factura_rm = $('#tipo_bien_servicio_factura_rm').val();
    var tipo_bien_servicio_factura_st = $('#tipo_bien_servicio_factura_st').val();

    if (parseInt(cliente_id) > 0 && fuente_facturacion_cod != '' && fuente_facturacion_cod != 'NULL' && (parseInt(tipo_bien_servicio_factura_os) > 0 || parseInt(tipo_bien_servicio_factura_rm) > 0 || parseInt(tipo_bien_servicio_factura_st) > 0)) {
        $("#iframeSolicitud").attr("src", "SolicFacturasClass.php?cliente_id=" + cliente_id + "&fuente_facturacion_cod=" + fuente_facturacion_cod + "&tipo_bien_servicio_factura_os=" + tipo_bien_servicio_factura_os + "&tipo_bien_servicio_factura_rm=" + tipo_bien_servicio_factura_rm + "&tipo_bien_servicio_factura_st=" + tipo_bien_servicio_factura_st + "&rand=" + Math.random());
        $("#divSolicitudFacturas").dialog({
            title: 'Remesas y Ordenes de Servicios Pendientes',
            width: 950,
            height: 395,
            closeOnEscape: true,
            show: 'scale',
            hide: 'scale'
        });
    } else {
        if (fuente_facturacion_cod == '' || fuente_facturacion_cod == 'NULL') {
            alertJquery("Por Favor Seleccione una Fuente", "Factura");
        } else if ((fuente_facturacion_cod == 'OS' && !parseInt(tipo_bien_servicio_factura_os) > 0) || (fuente_facturacion_cod == 'RM' && !parseInt(tipo_bien_servicio_factura_rm) > 0) || (fuente_facturacion_cod == 'ST' && !parseInt(tipo_bien_servicio_factura_st) > 0)) {
            alertJquery("Por Favor Seleccione un Tipo de Servicio", "Factura");
        } else if (!parseInt(cliente_id) > 0) {
            alertJquery("Por Favor Seleccione un Cliente", "Factura");

        }
    }
}*/

function closeDialog() {
    $("#divSolicitudFacturas").dialog('close');
}

function setDataFactura(factura_id, tipo_bien_servicio_factura_saved) {

    var QueryString = "ACTIONCONTROLER=setDataFactura&factura_id=" + factura_id;

    $.ajax({
        url: "NotaDebitoClass.php?rand=" + Math.random(),
        data: QueryString,
        type: 'POST',
        beforeSend: function() {

        },
        success: function(response) {

            try {

                var responseArray = $.parseJSON(response);
                var fecha = responseArray[0]['fecha'];
                var valor = responseArray[0]['valor'];
                var cliente = responseArray[0]['cliente'];
                var cliente_id = responseArray[0]['cliente_id'];
                var encabezado_registro_id = responseArray[0]['encabezado_registro_id'];
                var numero_documento = responseArray[0]['numero_documento'];
                var tipo_bien_servicio_factura = tipo_bien_servicio_factura_saved > 0 ? tipo_bien_servicio_factura_saved : responseArray[0]['tipo_bien_servicio_factura'];
                var tipo_de_documento_id = responseArray[0]['tipo_de_documento_id'];

                $("#fecha").val(fecha);
                $("#valor").val(valor);
                $("#cliente").val(cliente);
                $("#cliente_hidden").val(cliente_id);
                $("#numero_documento").val(numero_documento);
                $("#tipo_bien_servicio_factura").val(tipo_bien_servicio_factura);
                $("#tipo_de_documento_id").val(tipo_de_documento_id);

                var url = "DetallesClass.php?factura_id=" + factura_id + "&fuente_facturacion_cod=" + $('#fuente_facturacion_cod').val() + "&rand=" + Math.random();
                $("#detalles").attr("src", url);

                var url = "DetallesContablesClass.php?factura_id=" + factura_id + "&encabezado_registro_id=" + encabezado_registro_id + "&rand=" + Math.random();
                $("#detallesContables").attr("src", url);

            } catch (e) {
                alertJquery('Error: \n' + e, "Error");
            }

        }

    });

}

function onclickCancellation(formulario) {

    if ($("#divAnulacion").is(":visible")) {

        var causal_anulacion_id = $("#causal_anulacion_id").val();
        var desc_anul_factura = $("#desc_anul_factura").val();
        var anul_factura = $("#anul_factura").val();
        var oficina_id = $("#oficina_id").val();

        if (causal_anulacion_id != '' && desc_anul_factura != '') {
            if (ValidaRequeridos(formulario)) {

                var QueryString = "ACTIONCONTROLER=onclickCancellation&" + FormSerialize(formulario) + "&factura_id=" + $("#factura_id").val();

                $.ajax({
                    url: "NotaDebitoClass.php",
                    data: QueryString,
                    beforeSend: function() {
                        showDivLoading();
                    },
                    success: function(response) {

                        if ($.trim(response) == 'true') {
                            alertJquery('Causacion Anulada', 'Anulado Exitosamente');
                            $("#refresh_QUERYGRID_factura").click();
                            Reset(formulario);
                            FacturaOnReset(formulario);
                            $("#oficina_id").val(oficina_id);
                        } else {
                            alertJquery(response, 'Inconsistencia Anulando');
                        }

                        removeDivLoading();
                        $("#divAnulacion").dialog('close');

                    }

                });

            }
        } else {
            alertJquery('Debe seleccionar una causal y digitar una descripcion de anulacion.');
        }



    } else {

        var factura_id = $("#factura_id").val();
        var estado = $("#estado").val();

        if (parseInt(factura_id) > 0) {

            var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&factura_id=" + factura_id;

            $.ajax({
                url: "NotaDebitoClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    var estado = response;

                    if ($.trim(estado) == 'A' || $.trim(estado) == 'C') {

                        $("#divAnulacion").dialog({
                            title: 'Anulacion Causacion',
                            width: 450,
                            height: 280,
                            closeOnEscape: true
                        });

                    } else {
                        alertJquery('Solo se permite anular Facturas en estado : <b>ACTIVO/CONTABILIZADO</b>', 'Anulacion');
                    }

                    removeDivLoading();
                }

            });


        } else {
            alertJquery('Debe Seleccionar primero una Factura', 'Anulacion');
        }

    }
}


function OnclickContabilizar() {
    var nota_debito_id = $("#nota_debito_id").val();
    var fecha_nota = $("#fecha_nota").val();
    var valor_nota = removeFormatCurrency($("#valor_nota").val());
    var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&nota_debito_id=" + nota_debito_id;

    if (parseInt(nota_debito_id) > 0) {
        if (!formSubmitted) {
            formSubmitted = true;
            $.ajax({
                url: "NotaDebitoClass.php",
                data: QueryString,
                type: 'POST',
                success: function(response) {

                    try {
                        var totalDebitoCredito = $.parseJSON(response);
                        var totalDebito = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
                        var totalCredito = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;

                        $("#totalDebito").html(totalDebito);
                        $("#totalCredito").html(totalCredito);

                        if (parseFloat(totalDebito) == parseFloat(totalCredito) && parseFloat(valor_nota) > 0) {
                            var QueryString = "ACTIONCONTROLER=getContabilizar&nota_debito_id=" + nota_debito_id + "&fecha_nota=" + fecha_nota;

                            $.ajax({
                                url: "NotaDebitoClass.php",
                                data: QueryString,
                                type: 'POST',
                                success: function(response) {

                                    try {
                                        if ($.trim(response) == 'true') {
                                            alertJquery('Factura Contabilizada', 'Contabilizacion Exitosa');
                                            $("#refresh_QUERYGRID_factura").click();
                                            setDataFormWithResponse();
                                            formSubmitted = false;
                                        } else {
                                            alertJquery(response, 'Inconsistencia Contabilizando');
                                        }


                                    } catch (e) {
                                        alertJquery('Ha ocurrido una inconsistencia \n\n' + e, 'Error');
                                    }
                                }
                            });
                        } else {
                            alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>', 'Contabilizacion');
                        }
                    } catch (e) {
                        alertJquery('Ha ocurrido una inconsistencia \n\n' + e, 'Error');
                    }
                }

            });
            formSubmitted = false;
        }
    } else {
        alertJquery('Debe Seleccionar primero una Factura', 'Contabilizacion');
        formSubmitted = false;
    }
}

function ComprobarTercero(tipo_bien_servicio_factura_id) {

    var QueryString = "ACTIONCONTROLER=ComprobarTercero&tipo_bien_servicio_factura_id=" + tipo_bien_servicio_factura_id;

    $.ajax({
        url: "NotaDebitoClass.php?rand=" + Math.random(),
        data: QueryString,
        beforeSend: function() {

        },
        success: function(response) {

            try {
                if (parseInt($.trim(response)) > 0) {
                    alertJquery('El tipo de Servicio esta configurado con cuenta para terceros.\n La fuente de facturacion debe tener liquidado los costos', 'Tipo de Servicio');

                }


            } catch (e) {
                alertJquery(e);
            }

        }

    });

}

function OnclickReportar() {
    var factura_id = $("#factura_id").val();

    if (parseInt(factura_id) > 0) {
        $('#reportar').attr("disabled", "true");
        if (!formSubmitted) {
            formSubmitted = true;

            var QueryString = "ACTIONCONTROLER=OnclickReportar&factura_id=" + factura_id;

            $.ajax({
                url: "NotaDebitoClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },

                success: function(response) {
                    try {
                        alertJquery(response, 'Enviando Factura');
                        $('#reportar').attr("disabled", "");
                        formSubmitted = false;

                    } catch (e) {
                        alertJquery(e, 'Enviando Factura');
                        formSubmitted = false;
                    }
                    removeDivLoading();
                }
            });
        }

    } else {
        alertJquery('Debe Seleccionar primero una Factura', 'Reporte Factura Electronica');
    }
}

//validaciion previa
function OnclickReportarVP() {
    var nota_debito_id = $("#nota_debito_id").val();

    if (parseInt(nota_debito_id) > 0) {
        $('#reportar').attr("disabled", "true");
        if (!formSubmitted) {
            formSubmitted = true;

            var QueryString = "ACTIONCONTROLER=OnclickReportarVP&nota_debito_id=" + nota_debito_id;

            $.ajax({
                url: "NotaDebitoClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },

                success: function(response) {
                    try {
                        alertJquery(response, 'Enviando Nota Debito');
                        $('#reportar').attr("disabled", "");
                        formSubmitted = false;

                    } catch (e) {
                        alertJquery(e, 'Enviando Nota Debito');
                        formSubmitted = false;
                    }
                    removeDivLoading();
                }
            });
        }

    } else {
        alertJquery('Debe Seleccionar primero una Nota', 'Reporte Nota Debito Validacion Previa');
    }
}




function onclickEnviarMail() {
    //alertJquery("En construccion");

    var nota_debito_id = $("#nota_debito_id").val();
    if (parseInt(nota_debito_id) > 0) {
        var QueryString = "ACTIONCONTROLER=onclickEnviarMail&nota_debito_id=" + nota_debito_id;

        $.ajax({
            url: "NotaDebitoClass.php?rand=" + Math.random(),
            data: QueryString,
            beforeSend: function() {
                showDivLoading();
            },
            success: function(response) {
                removeDivLoading();
                alertJquery(response, "Validacion Envio");

            }

        });
    } else {
        alertJquery("Por favor seleccione una factura", "Validacion");

    }

}

function validaSeleccionFactura() {

    var factura_id = $("#factura_id").val();

    if (parseInt(factura_id) > 0) {
        return true;
    } else {
        alertJquery('Debe cargar primero una Factura!!', 'Validacion');
        return false;
    }

}

function onSendFile(response) {

    if ($.trim(response) == 'false') {
        alertJquery('No se ha podido adjuntar el archivo !!');
    } else {

        alertJquery("Se ha Cargado el adjunto", "Validacion Adjunto");
        setDataFormWithResponse();
    }



}