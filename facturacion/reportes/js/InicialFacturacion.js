
$(document).ready(function () {
  
  $('#mayor_saldo tbody tr').remove();
  var QueryString = "ACTIONCONTROLER=getMayorSaldo";

  $.ajax({
    url: "InicialFacturacionClass.php",
    data: QueryString,
    success: function (resp) {

      var data = $.parseJSON(resp);

      if (data != null) {

        for (i = 0; i < data.length; i++) {

          var htmlTags = '<tr>' +
            '<td>' + data[i]['cliente'] + '</td>' +
            '<td>' + new Intl.NumberFormat("de-DE").format(data[i]['saldo']) + '</td>' +
            '</tr>';

          $('#mayor_saldo tbody').append(htmlTags);
        }

      }
    }

  });

  $('#valor_anual tbody tr').remove();
  var QueryString = "ACTIONCONTROLER=getValores";

  $.ajax({
    url: "InicialFacturacionClass.php",
    data: QueryString,
    success: function (resp) {

      var data = $.parseJSON(resp);

      if (data != null) {

        var factura = data[0]['factura'];
        var saldos = data[0]['saldos'];
        var pago = data[0]['pago'];

          var htmlTags = '<tr>' +
            '<td>' + new Intl.NumberFormat("de-DE").format(factura[0]['facturado']) + '</td>' +
            '<td>' + new Intl.NumberFormat("de-DE").format(saldos[0]['saldo']) + '</td>' +
            '<td>' + new Intl.NumberFormat("de-DE").format(pago[0]['pagado']) + '</td>' +
            '</tr>';

          $('#valor_anual tbody').append(htmlTags);
        

      }
    }

  });

}); 


