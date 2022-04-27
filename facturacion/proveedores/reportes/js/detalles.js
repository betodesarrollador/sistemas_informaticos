function viewDocument(encabezado_registro_id) {

    var QueryString = "../../../contabilidad/reportes/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=viewDocument&encabezado_registro_id=" + encabezado_registro_id;
    var title = "Visualizacion DOcumento Contable";
    var width = 900;
    var height = 600;

    popPup(QueryString, title, width, height);

}

function viewDocumentFactura(factura_proveedor_id) {
    /*ACTIONCONTROLER=onclickPrint& */
    var QueryString = "../../causar/clases/CausarClass.php?factura_proveedor_id=" + factura_proveedor_id;
    var title = "Impresion movimiento";
    var width = 1100;
    var height = 650;

    popPup(QueryString, title, width, height);

}