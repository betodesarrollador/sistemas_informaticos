// JavaScript Document


$(document).ready(function() {

    cargarDatos();


    tinymce.init({
        selector: '#observacion_encabezado',
        entity_encoding: "raw"

    });

    tinymce.init({
        selector: '#pie_pagina',
        entity_encoding: "raw"
    });


    $("#actualizar").click(function() {

        tinyMCE.triggerSave();
        var formulario = document.getElementById('ParamImpresionForm');

        if (ValidaRequeridos(formulario)) {

            var remesa = $("input[name=remesa]").is(":checked") ? 1 : 0;
            var fecha_remesa = $("input[name=fecha_remesa]").is(":checked") ? 1 : 0;
            var peso = $("input[name=peso]").is(":checked") ? 1 : 0;
            var placa = $("input[name=placa]").is(":checked") ? 1 : 0;
            var descripcion_remesa = $("input[name=descripcion_remesa]").is(":checked") ? 1 : 0;
            var origen = $("input[name=origen]").is(":checked") ? 1 : 0;
            var pasador_vial = $("input[name=pasador_vial]").is(":checked") ? 1 : 0;
            var destino = $("input[name=destino]").is(":checked") ? 1 : 0;
            var doc_cliente = $("input[name=doc_cliente]").is(":checked") ? 1 : 0;
            var manifiesto = $("input[name=manifiesto]").is(":checked") ? 1 : 0;
            var valor_tonelada = $("input[name=valor_tonelada]").is(":checked") ? 1 : 0;
            var descripcion_producto = $("input[name=descripcion_producto]").is(":checked") ? 1 : 0;
            var observacion_uno = $("input[name=observacion_uno]").is(":checked") ? 1 : 0;
            var observacion_dos = $("input[name=observacion_dos]").is(":checked") ? 1 : 0;
            var valor_declarado = $("input[name=valor_declarado]").is(":checked") ? 1 : 0;
            var cantidad_cargada = $("input[name=cantidad_cargada]").is(":checked") ? 1 : 0;
            var cantidad_producto = $("input[name=cantidad_producto]").is(":checked") ? 1 : 0;
            var valor_unitario_remesa = $("input[name=valor_unitario_remesa]").is(":checked") ? 1 : 0;
            var orden = $("input[name=orden]").is(":checked") ? 1 : 0;
            var fecha_orden = $("input[name=fecha_orden]").is(":checked") ? 1 : 0;
            var descripcion_orden = $("input[name=descripcion_orden]").is(":checked") ? 1 : 0;
            var formato_impresion = $("#formato_impresion").val();
            var impuestos_visibles = $("#impuestos_visibles").val();
            var detalles_visibles = $("#detalles_visibles").val();
            var cabecera_por_pagina = $("#cabecera_por_pagina").val();
            var observacion_encabezado = $("#observacion_encabezado").val();
            var pie_pagina = $("#pie_pagina").val();
            var parametro_impresion_id = 1;

            var QueryString = "ACTIONCONTROLER=onclickUpdate&parametro_impresion_id=" + parametro_impresion_id + "&remesa=" +
                remesa + "&fecha_remesa=" + fecha_remesa + "&peso=" + peso + "&placa=" + placa + "&descripcion_remesa=" + descripcion_remesa + "&origen=" + origen + "&pasador_vial=" + pasador_vial +
                "&destino=" + destino + "&doc_cliente=" + doc_cliente + "&manifiesto=" + manifiesto + "&valor_tonelada=" + valor_tonelada + "&descripcion_producto=" + descripcion_producto + "&observacion_uno=" +
                observacion_uno + "&observacion_dos=" + observacion_dos + "&valor_declarado=" + valor_declarado + "&cantidad_cargada=" + cantidad_cargada + "&cantidad_producto=" + cantidad_producto + "&valor_unitario_remesa=" + valor_unitario_remesa + "&orden=" + orden + "&fecha_orden=" + fecha_orden + "&descripcion_orden=" + descripcion_orden + "&formato_impresion=" + formato_impresion + "&impuestos_visibles=" + impuestos_visibles + "&cabecera_por_pagina=" + cabecera_por_pagina + "&detalles_visibles=" + detalles_visibles + "&observacion_encabezado=" + observacion_encabezado + "&pie_pagina=" + pie_pagina;

            $.ajax({

                url: "ParamImpresionClass.php",
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                },
                success: function(response) {

                    if ($.trim(response) == 'true') {

                        alertJquery("¡ Parametros impresión actualizados exitosamente !");

                        cargarDatos();

                    } else {
                        alertJquery(response);
                    }

                    removeDivLoading();
                }

            });
        }

    });

});


function onSendFile(response) {

    if ($.trim(response) == 'false') {
        alertJquery('No se ha podido adjuntar el logo !!');
    } else {

        alertJquery("¡Se ha cargado el logo!", "Validacion logo");
        cargarDatos();
    }

}

function cargarDatos() {

    var parametro_impresion_id = 1;

    var QueryString = "ACTIONCONTROLER=onclickFind&parametro_impresion_id=" + parametro_impresion_id;

    $.ajax({

        url: "ParamImpresionClass.php",
        data: QueryString,
        beforeSend: function() {
            showDivLoading();
        },
        success: function(response) {

            try {
                var data = $.parseJSON(response);

                var remesa = data[0]['remesa'];
                var fecha_remesa = data[0]['fecha_remesa'];
                var peso = data[0]['peso'];
                var placa = data[0]['placa'];
                var descripcion_remesa = data[0]['descripcion_remesa'];
                var origen = data[0]['origen'];
                var pasador_vial = data[0]['pasador_vial'];
                var destino = data[0]['destino'];
                var doc_cliente = data[0]['doc_cliente'];
                var manifiesto = data[0]['manifiesto'];
                var valor_tonelada = data[0]['valor_tonelada'];
                var descripcion_producto = data[0]['descripcion_producto'];
                var observacion_uno = data[0]['observacion_uno'];
                var observacion_dos = data[0]['observacion_dos'];
                var valor_declarado = data[0]['valor_declarado'];
                var cantidad_cargada = data[0]['cantidad_cargada'];
                var cantidad_producto = data[0]['cantidad_producto'];
                var valor_unitario_remesa = data[0]['valor_unitario_remesa'];
                var orden = data[0]['orden'];
                var fecha_orden = data[0]['fecha_orden'];
                var descripcion_orden = data[0]['descripcion_orden'];
                var formato_impresion = data[0]['formato_impresion'];
                var impuestos_visibles = data[0]['impuestos_visibles'];
                var detalles_visibles = data[0]['detalles_visibles'];
                var cabecera_por_pagina = data[0]['cabecera_por_pagina'];
                var observacion_encabezado = data[0]['observacion_encabezado'];
                var pie_pagina = data[0]['pie_pagina'];
                var logo = data[0]['logo'];

                if (logo != '' && logo != 'NULL' && logo != 'null' && logo != null) {
                    $("#adjuntover").html('<a href="' + logo + '" target="_blank">Ver logo</a>');
                } else {
                    $("#adjuntover").html('&nbsp;');
                }

                if (remesa == 1) {
                    $("input:checkbox[name=remesa]").attr('checked', true);
                } else {
                    $("input:checkbox[name=remesa]").attr('checked', false);
                }

                if (fecha_remesa == 1) {
                    $("input:checkbox[name=fecha_remesa]").attr('checked', true);
                } else {
                    $("input:checkbox[name=fecha_remesa]").attr('checked', false);
                }

                if (peso == 1) {
                    $("input:checkbox[name=peso]").attr('checked', true);
                } else {
                    $("input:checkbox[name=peso]").attr('checked', false);
                }

                if (placa == 1) {
                    $("input:checkbox[name=placa]").attr('checked', true);
                } else {
                    $("input:checkbox[name=placa]").attr('checked', false);
                }

                if (descripcion_remesa == 1) {
                    $("input:checkbox[name=descripcion_remesa]").attr('checked', true);
                } else {
                    $("input:checkbox[name=descripcion_remesa]").attr('checked', false);
                }

                if (origen == 1) {
                    $("input:checkbox[name=origen]").attr('checked', true);
                } else {
                    $("input:checkbox[name=origen]").attr('checked', false);
                }

                if (pasador_vial == 1) {
                    $("input:checkbox[name=pasador_vial]").attr('checked', true);
                } else {
                    $("input:checkbox[name=pasador_vial]").attr('checked', false);
                }

                if (destino == 1) {
                    $("input:checkbox[name=destino]").attr('checked', true);
                } else {
                    $("input:checkbox[name=destino]").attr('checked', false);
                }

                if (doc_cliente == 1) {
                    $("input:checkbox[name=doc_cliente]").attr('checked', true);
                } else {
                    $("input:checkbox[name=doc_cliente]").attr('checked', false);
                }

                if (manifiesto == 1) {
                    $("input:checkbox[name=manifiesto]").attr('checked', true);
                } else {
                    $("input:checkbox[name=manifiesto]").attr('checked', false);
                }

                if (valor_tonelada == 1) {
                    $("input:checkbox[name=valor_tonelada]").attr('checked', true);
                } else {
                    $("input:checkbox[name=valor_tonelada]").attr('checked', false);
                }

                if (descripcion_producto == 1) {
                    $("input:checkbox[name=descripcion_producto]").attr('checked', true);
                } else {
                    $("input:checkbox[name=descripcion_producto]").attr('checked', false);
                }

                if (observacion_uno == 1) {
                    $("input:checkbox[name=observacion_uno]").attr('checked', true);
                } else {
                    $("input:checkbox[name=observacion_uno]").attr('checked', false);
                }

                if (observacion_dos == 1) {
                    $("input:checkbox[name=observacion_dos]").attr('checked', true);
                } else {
                    $("input:checkbox[name=observacion_dos]").attr('checked', false);
                }

                if (valor_declarado == 1) {
                    $("input:checkbox[name=valor_declarado]").attr('checked', true);
                } else {
                    $("input:checkbox[name=valor_declarado]").attr('checked', false);
                }

                if (cantidad_cargada == 1) {
                    $("input:checkbox[name=cantidad_cargada]").attr('checked', true);
                } else {
                    $("input:checkbox[name=cantidad_cargada]").attr('checked', false);
                }

                if (cantidad_producto == 1) {
                    $("input:checkbox[name=cantidad_producto]").attr('checked', true);
                } else {
                    $("input:checkbox[name=cantidad_producto]").attr('checked', false);
                }

                if (valor_unitario_remesa == 1) {
                    $("input:checkbox[name=valor_unitario_remesa]").attr('checked', true);
                } else {
                    $("input:checkbox[name=valor_unitario_remesa]").attr('checked', false);
                }


                if (orden == 1) {
                    $("input:checkbox[name=orden]").attr('checked', true);
                } else {
                    $("input:checkbox[name=orden]").attr('checked', false);
                }

                if (fecha_orden == 1) {
                    $("input:checkbox[name=fecha_orden]").attr('checked', true);
                } else {
                    $("input:checkbox[name=fecha_orden]").attr('checked', false);
                }

                if (descripcion_orden == 1) {
                    $("input:checkbox[name=descripcion_orden]").attr('checked', true);
                } else {
                    $("input:checkbox[name=descripcion_orden]").attr('checked', false);
                }

                $("#formato_impresion").val(formato_impresion);
                $("#impuestos_visibles").val(impuestos_visibles);
                $("#detalles_visibles").val(detalles_visibles);
                $("#cabecera_por_pagina").val(cabecera_por_pagina);

                tinymce.get('observacion_encabezado').setContent(observacion_encabezado);
                tinymce.get('pie_pagina').setContent(pie_pagina);


            } catch (e) {
                console.log(e);
            }

            removeDivLoading();
        }

    });

}