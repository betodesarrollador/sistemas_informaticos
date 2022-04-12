// JavaScript Document
$(document).ready(function() {

    $("#tableDetalles tr").each(function() {
        $(this).find("#liberar1").hide();
        $(this).find("#revocar1").hide();
    });

    var remesas = [];
    var ordenes = [];

    parent.$("#motivo_nota").change(function() {

        parent.$("#subtotales").attr("src", "../../../framework/tpl/blank.html");
        var remesas = [];
        var ordenes = [];
        parent.$("#remesas").val("");
        parent.$("#ordenes").val("");

        // console.log("array remesas: " + remesas);
        parent.$("#valor_nota").val("");
        parent.$("#valor_nota").attr("disabled", "disabled");
        parent.$("#tipo_bien_servicio_factura").attr("disabled", "disabled");

        if ($(this).val() == 1 || $(this).val() == 5) {

            if ($(this).val() == 1) {
                parent.$("#valor_nota").removeAttr("disabled");
            }

            $("#tableDetalles tr").each(function() {
                $(this).find("#liberar").show();
                $(this).find("#revocar").hide();
                $(this).find("#liberar1").show();
                $(this).find("#revocar1").hide();


                $(this).find("#liberar").removeAttr("disabled");
                $(this).find("#revocar").removeAttr("disabled");
                $(this).find("#liberar1").removeAttr("disabled");
                $(this).find("#revocar1").removeAttr("disabled");
            });
        }

        if ($(this).val() == 2) {
            $("#tableDetalles").find("tbody").find("tr").each(function() {
                var detalle_factura_id = $(this).find("#detalle_factura_id").val();

                var QueryString = "ACTIONCONTROLER=setLiberar&detalle_factura_id=" + detalle_factura_id;

                $.ajax({
                    url: "DetallesClass.php?rand=" + Math.random(),
                    data: QueryString,
                    beforeSend: function() {},
                    success: function(resp) {
                        var data = $.parseJSON(resp);

                        var estado = data["estado"];
                        var valor = data["valor"];
                        var remesa_id = data["remesa_id"];
                        var orden_servicio_id = data["orden_servicio_id"];

                        var valor_nota_actual = parent.$("#valor_nota").val();
                        if (valor_nota_actual != "") {
                            var valor_nota = parseInt(valor_nota_actual.replace('.', "")) + parseInt(valor);
                        } else {
                            var valor_nota = parseInt(valor);
                        }
                        parent.$("#valor_nota").val(valor_nota);

                        if (remesa_id > 0) {
                            remesas.push(remesa_id);
                            remesas = [...new Set(remesas)];
                            parent.$("#remesas").val(remesas);
                        } else if (orden_servicio_id) {
                            ordenes.push(orden_servicio_id);
                            ordenes = [...new Set(ordenes)];
                            parent.$("#ordenes").val(ordenes);
                        }

                        var formulario = parent.document.getElementById("NotaCreditoForm");

                        if (parent.ValidaRequeridos(formulario)) {
                            previsualizar(0);
                        }
                        formSubmitted = false;
                    },
                });

                $(this).find("#liberar").hide();
                $(this).find("#liberar1").hide();
                $(this).find("#revocar").show();
                $(this).find("#revocar1").show();


                $(this).find("#liberar").attr("disabled", "disabled");
                $(this).find("#revocar").attr("disabled", "disabled");
                $(this).find("#liberar1").attr("disabled", "disabled");
                $(this).find("#revocar1").attr("disabled", "disabled");
            });
        }

        if ($(this).val() == 3 || $(this).val() == 4) {

            $("#tableDetalles").find("tbody").find("tr").each(function() {
                var detalle_factura_id = $(this).find("#detalle_factura_id").val();

                var QueryString = "ACTIONCONTROLER=setLiberar&detalle_factura_id=" + detalle_factura_id;

                $.ajax({
                    url: "DetallesClass.php?rand=" + Math.random(),
                    data: QueryString,
                    beforeSend: function() {},
                    success: function(resp) {
                        var data = $.parseJSON(resp);

                        var valor = data["valor"];
                        var remesa_id = data["remesa_id"];
                        var orden_servicio_id = data["orden_servicio_id"];

                        var valor_nota_actual = parent.$("#valor_nota").val();
                        if (valor_nota_actual != "") {
                            var valor_nota = parseInt(valor_nota_actual.replace('.', "")) + parseInt(valor);
                        } else {
                            var valor_nota = parseInt(valor);
                        }
                        parent.$("#valor_nota").val(valor_nota);

                        if (remesa_id > 0) {
                            remesas.push(remesa_id);
                            remesas = [...new Set(remesas)];
                            parent.$("#remesas").val(remesas);
                        } else if (orden_servicio_id) {
                            ordenes.push(orden_servicio_id);
                            ordenes = [...new Set(ordenes)];
                            parent.$("#ordenes").val(ordenes);
                        }

                        if (parent.$("#motivo_nota").val() == 4) {
                            parent.alertJquery("Por favor seleccione el tipo de servicio configurado para <b>DESCUENTO TOTAL</b>");
                            parent.$("#tipo_bien_servicio_factura").removeAttr("disabled");

                        } else {
                            var formulario = parent.document.getElementById("NotaCreditoForm");
                            if (parent.ValidaRequeridos(formulario)) {
                                previsualizar(0);
                            }
                            formSubmitted = false;
                        }
                    },
                });

                $(this).find("#liberar").show();
                $(this).find("#revocar").hide();
                $(this).find("#liberar1").show();
                $(this).find("#revocar1").hide();

                $(this).find("#liberar").attr("disabled", "disabled");
                $(this).find("#revocar").attr("disabled", "disabled");
                $(this).find("#liberar1").attr("disabled", "disabled");
                $(this).find("#revocar1").attr("disabled", "disabled");
            });
        }

    });

    parent.$("#valor_nota").blur(function() {

        if ($(this).val() > 0 || $(this).val() != '') {

            if (parent.$("#motivo_nota").val() == 1) {

                parent.$("#subtotales").attr("src", "../../../framework/tpl/blank.html");
                var remesas = [];
                var ordenes = [];
                parent.$("#remesas").val("");
                parent.$("#ordenes").val("");

                $("#tableDetalles").find("tbody").find("tr").each(function() {
                    var detalle_factura_id = $(this).find("#detalle_factura_id").val();

                    var QueryString = "ACTIONCONTROLER=setLiberar&detalle_factura_id=" + detalle_factura_id;

                    $.ajax({
                        url: "DetallesClass.php?rand=" + Math.random(),
                        data: QueryString,
                        beforeSend: function() {},
                        success: function(resp) {
                            var data = $.parseJSON(resp);

                            var formulario = parent.document.getElementById("NotaCreditoForm");

                            if (parent.ValidaRequeridos(formulario)) {
                                previsualizar(1);
                            }
                            formSubmitted = false;
                        },
                    });

                    $(this).find("#liberar").show();
                    $(this).find("#revocar").hide();

                    $(this).find("#liberar").removeAttr("disabled");
                    $(this).find("#revocar").removeAttr("disabled");
                });
            }
        }
    });

    parent.$("#tipo_bien_servicio_factura").blur(function() {

        var formulario = parent.document.getElementById("NotaCreditoForm");

        if (parent.ValidaRequeridos(formulario)) {
            previsualizar(0);
        }
        formSubmitted = false;


    });

    $("#tableDetalles").on("click", ".btn-success", function() {

        var motivo_nota = parent.$("#motivo_nota").val();
        var fuente = $(this).parents("tr").find("#fuente").val();
        var detalle_factura_id = $(this).parents("tr").find("#detalle_factura_id").val();

        if (motivo_nota == 1 || motivo_nota == 5) {

            var QueryString = "ACTIONCONTROLER=setLiberar&detalle_factura_id=" + detalle_factura_id;

            $.ajax({
                url: "DetallesClass.php?rand=" + Math.random(),
                data: QueryString,
                beforeSend: function() {

                },
                success: function(resp) {

                    var data = $.parseJSON(resp);

                    var valor = data['valor'];
                    var remesa_id = data["remesa_id"];
                    var orden_servicio_id = data["orden_servicio_id"];

                    var valor_nota_actual = parent.$("#valor_nota").val();

                    if (valor_nota_actual != "") {
                        var valor_nota = parseInt(valor_nota_actual.replace('.', "")) + parseInt(valor);
                    } else {
                        var valor_nota = parseInt(valor);
                    }
                    parent.$("#valor_nota").val(valor_nota);

                    if (remesa_id > 0) {

                        remesas.push(remesa_id);
                        remesas = [...new Set(remesas)];
                        parent.$("#remesas").val(remesas);

                        var rows = document.getElementById("tableDetalles").getElementsByTagName("tbody")[0].rows.length;
                        var num_rows = remesas.length;

                        if (rows == num_rows) {
                            parent.alertJquery("Esta liberando todos las remesas, se cambiará el motivo de la nota a <b>ANULACION FACTURA</b>");
                            parent.$("#motivo_nota").val(2);
                        }

                    } else if (orden_servicio_id) {

                        ordenes.push(orden_servicio_id);
                        ordenes = [...new Set(ordenes)];
                        parent.$("#ordenes").val(ordenes);

                        var rows = document.getElementById("tableDetalles").getElementsByTagName("tbody")[0].rows.length;
                        var num_rows = ordenes.length;

                        if (rows == num_rows) {
                            parent.alertJquery("Esta liberando todas las ordenes de servicio, se cambiará el motivo de la nota a <b>ANULACION FACTURA</b>");
                            parent.$("#motivo_nota").val(2);
                        }

                    }

                    var formulario = parent.document.getElementById("NotaCreditoForm");

                    if (parent.ValidaRequeridos(formulario)) {
                        previsualizar(0);
                    }
                    formSubmitted = false;

                }

            });

            $(this).parents("tr").find("#liberar").hide();
            $(this).parents("tr").find("#revocar").show();
            $(this).parents("tr").find("#liberar1").hide();
            $(this).parents("tr").find("#revocar1").show();
        } else {
            parent.alertJquery('¡Solo puede liberar la ' + fuente + ' seleccionando motivo nota DEVOLUCION PARCIAL Y OTROS!', 'Atención');
        }

    });

    $("#tableDetalles").on("click", ".btn-danger", function() {

        var motivo_nota = parent.$("#motivo_nota").val();
        var detalle_factura_id = $(this).parents("tr").find("#detalle_factura_id").val();
        var fuente = $(this).parents("tr").find("#fuente").val();

        if (motivo_nota == 1 || motivo_nota == 5) {

            var QueryString = "ACTIONCONTROLER=setRevocar&detalle_factura_id=" + detalle_factura_id;

            $.ajax({
                url: "DetallesClass.php?rand=" + Math.random(),
                data: QueryString,
                success: function(resp) {

                    var data = $.parseJSON(resp);

                    var valor = data["valor"];
                    var remesa_id = data["remesa_id"];
                    var orden_servicio_id = data["orden_servicio_id"];

                    var valor_nota_actual = parent.$("#valor_nota").val();


                    if (valor_nota_actual != "") {
                        var valor_nota = parseInt(valor_nota_actual.replace('.', "")) - parseInt(valor);
                    } else {
                        var valor_nota = "";
                    }

                    parent.$("#valor_nota").val(valor_nota);



                    if (remesa_id > 0) {

                        var pos = remesas.indexOf(remesa_id);
                        remesas.splice(pos, 1);
                        parent.$("#remesas").val(remesas);

                    } else if (orden_servicio_id) {

                        var pos = ordenes.indexOf(orden_servicio_id);
                        ordenes.splice(pos, 1);
                        parent.$("#ordenes").val(ordenes);

                    }

                    var formulario = parent.document.getElementById("NotaCreditoForm");

                    if (parent.ValidaRequeridos(formulario)) {
                        previsualizar(0);
                    }
                    formSubmitted = false;


                }
            });
            $(this).parents("tr").find("#liberar").show();
            $(this).parents("tr").find("#revocar").hide();
            $(this).parents("tr").find("#liberar1").show();
            $(this).parents("tr").find("#revocar1").hide();
        } else {
            parent.alertJquery('¡Solo puede revocar la ' + fuente + ' seleccionando motivo nota DEVOLUCION PARCIAL Y OTROS!', 'Atención');
        }
    });


});

function previsualizar(aplica_total_factura) {

    var previsual = 1;
    var remesas = parent.$("#remesas").val();
    var ordenes = parent.$("#ordenes").val();
    var tipo_servicio_id = parent.$("#tipo_bien_servicio_factura").val();
    var tipo_documento_id = parent.$("#tipo_de_documento_id").val();
    var cliente_id = parent.$("#cliente_hidden").val();
    var factura_id = parent.$("#factura_hidden").val();
    var fecha_nota = parent.$("#fecha_nota").val();
    var concepto = parent.$("#concepto").val();
    var motivo_nota = parent.$("#motivo_nota").val();
    var valor_nota = parent.$("#valor_nota").val();
    var valores_abono_factura = valor_nota + "=";
    var estado = parent.$("#estado").val();

    var QueryString = "ACTIONCONTROLER=previsualizar&previsual=" + previsual + "&remesas=" + remesas + "&ordenes=" + ordenes + "&tipo_bien_servicio_factura=" + tipo_servicio_id + "&factura_id=" +
        factura_id + "&tipo_de_documento_id=" + tipo_documento_id + "&cliente_id=" + cliente_id + "&fecha_nota=" + fecha_nota + "&concepto=" + concepto + "&motivo_nota=" + motivo_nota + "&valores_abono_factura=" + valores_abono_factura + "&estado=" + estado + "&valor_nota=" + valor_nota + "&aplica_total_factura=" + aplica_total_factura;

    var url = "SubtotalClass.php?" + QueryString; + "&rand=" + Math.random();
    parent.$("#subtotales").attr("src", url);



}