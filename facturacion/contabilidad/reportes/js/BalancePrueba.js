// JavaScript Document
$(document).ready(function () {
  setWidthFrameReporte();
  setReporte();

  $("#opciones_tercero").change(function () {
    if (this.value == "T") {
      $("#defecto").attr("checked", "true");
      $("input[name=agrupar]").removeAttr("disabled");
      $("#tercero_hidden").removeClass("obligatorio");
      $("#tercero").removeClass("requerido");
      $("#tercero").attr("disabled", "true");
      $("#tercero,#tercero_hidden").val("");
    }
    if (this.value == "U") {
      $("#defecto").attr("checked", "true");
      $("input[name=agrupar]").attr("disabled", "true");
      $("#tercero_hidden").addClass("obligatorio");
      $("#tercero").attr("disabled", "");
      $("#tercero").addClass("requerido");
    }
    if (this.value == "NN") {
      $("#defecto").attr("checked", "true");
      $("input[name=agrupar]").removeAttr("disabled");
      $("#tercero_hidden").removeClass("obligatorio");
      $("#tercero").removeClass("requerido");
      $("#tercero").attr("disabled", "true");
      $("#tercero,#tercero_hidden").val("");
    }
  });

  $("#nivel").change(function () {
    
    var nivel       = $("#nivel").val();
    var QueryString = "ACTIONCONTROLER=cambiarCuentas&nivel=" + nivel;

    $.ajax({
      
      url  : "BalancePruebaClass.php",
      async: false,
      data : QueryString,
     
      success: function (response) {
        $("#cuentas").parent().html(response);
      },
    });
    
    change_opciones();
  });

  $("#opciones_centros").click(function () {
    if (this.checked) {
      this.value = "T";
    } else {
      this.value = "U";
    }

    var objSelect = document.getElementById("centro_de_costo_id");
    var numOp = objSelect.options.length - 1;

    if (this.value == "T") {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = true;
        } else {
          objSelect.options[i].selected = false;
        }
      }
    } else {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = false;
        } else {
          objSelect.options[i].selected = true;
        }
      }
    }
  });

  $("#centro_de_costo_id").change(function () {
    $("#opciones_centros").attr("checked", "");
    $("#opciones_centros").val("U");
  });

  $("#opciones_oficinas").click(function () {
    if (this.checked) {
      this.value = "T";
    } else {
      this.value = "U";
    }

    var objSelect = document.getElementById("oficina_id");
    var numOp = objSelect.options.length - 1;
    objSelect.options[0].selected = false;
    if (this.value == "T") {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = true;
        } else {
          objSelect.options[i].selected = false;
        }
      }
    } else {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = false;
        } else {
          objSelect.options[i].selected = true;
        }
      }
    }
  });

  $("#all_subcuentas").click(function () {
    if (this.checked) {
      this.value = "T";
    } else {
      this.value = "U";
    }

    var objSelect = document.getElementById("subcuentas");
    var numOp = objSelect.options.length - 1;

    if (this.value == "T") {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = true;
        } else {
          objSelect.options[i].selected = false;
        }
      }
    } else {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = false;
        } else {
          objSelect.options[i].selected = true;
        }
      }
    }
  });
  
  
  $("#all_cuentas").click(function (){
    if (this.checked) {

      this.value = "T";

      $("#all_subcuentas").attr("checked", "checked");
      $("#all_subcuentas").val('T');

    } else {

      this.value = "U";

      $("input[name=all_subcuentas]").removeAttr("checked");
      $("#all_subcuentas").val('U');

    }

    var objSelect = document.getElementById("cuentas");
    var numOp = objSelect.options.length - 1;

    if (this.value == "T") {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = true;
        } else {
          objSelect.options[i].selected = false;
        }
      }
    } else {
      for (var i = numOp; i > 0; i--) {
        if (objSelect.options[i].value != "NULL") {
          objSelect.options[i].selected = false;
        } else {
          objSelect.options[i].selected = true;
        }
      }
    }
    listarSubcuentas(false);
    
  });
  

  $("#export").click(function () {
    var formulario = this.form;

    if (ValidaRequeridos(formulario)) {
      var QueryString =
        "BalancePruebaClass.php?ACTIONCONTROLER=onclickExport&" +
        FormSerialize(formulario);
      $("#frameReporte").attr("src", QueryString);
    }
  });

  $("input[name=nivel]").click(function () {
    listarSubcuentas(true,true);
  });
  
});

function change_opciones(){

  $("#all_subcuentas,#all_cuentas").removeAttr("checked");
  $("#all_subcuentas,#all_cuentas").val("U");
  
}

function listarSubcuentas(bandera,check) {
  
  var cuenta = $("#cuentas").val();
  var niveles = [];
  var nivel = $("#nivel").val();
  
  if(!check){
    $("input[name=nivel]:checked").each(function () {
      $(this).removeAttr("checked");
    });
  }
  
  $("#nivel"+nivel).attr("checked", "checked");
  
  $("input[name=nivel]:checked").each(function () {
    niveles.push(this.value);
  });

  var QueryString = "ACTIONCONTROLER=listarSubcuentas&cuenta=" + cuenta + "&niveles=" + niveles;

  $.ajax({
    async: false,
    type: 'POST',
    url: "BalancePruebaClass.php",
    data: QueryString,
    beforeSend: function () {},
    success: function (response) {
      $("#subcuentas").parent().html(response);
    },
  });
  
  if (bandera) change_opciones();
  
  seleccionarSubcuentas();
  
}

function seleccionarSubcuentas(){
  
    var all_cuentas = $("#all_cuentas").val(); 
  
    var cuentas     = $("#cuentas").text();
    
    var subcuentas = document.getElementById('subcuentas');
    
    if(all_cuentas == 'U'){
      
      for (var i = 1; i < subcuentas.options.length; i++) {
      
        if(cuentas.includes(subcuentas.options[i].text)){ 
        
        subcuentas.options[i].selected = true;
        }else{
          
          subcuentas.options[i].selected = false;
          
        }
      
      } 
      
    }else{
      
      for (var i = 1; i < subcuentas.options.length; i++) {
        
        subcuentas.options[i].selected = true;
      
      } 
      
    }

}

function MovimientosContablesOnReset(formulario) {
  $("#frameReporte").attr("src", "../../../framework/tpl/blank.html");
  Reset(formulario);
  $("#nivel1").val("1");
  $("#nivel2").val("2");
  $("#nivel3").val("3");
  $("#nivel4").val("4");
  $("#nivel5").val("5");
}

function setReporte() {
  //$("#oficina_id").css("display","none");

  $("#reporte").change(function () {
    if (this.value == "O") {
      $("#centro_de_costo_id").removeClass("obligatorio");
      $("#centro_de_costo_id").removeClass("requerido");
      $("#centro_de_costo_id").css("display", "none");

      $("#oficina_id").addClass("obligatorio");
      $("#oficina_id").css("display", "");

      document.getElementById("centro_de_costo_id").value = "NULL";
    } else {
      document.getElementById("reporte").value = "C";

      $("#oficina_id").removeClass("obligatorio");
      $("#oficina_id").removeClass("requerido");
      $("#oficina_id").css("display", "none");

      $("#centro_de_costo_id").addClass("obligatorio");
      $("#centro_de_costo_id").css("display", "");

      document.getElementById("oficina_id").value = "NULL";
    }
  });
}

function setWidthFrameReporte() {
  $("#frameReporte").css("height", $(parent.document.body).height() - 110);
}

function getReportParams() {
  $("#reporte").change(function () {
    if ($.trim(this.value) != "NULL") {
      getEmpresas(this.value);
    }
  });
}

function getEmpresas(reporte) {
  var QueryString = "ACTIONCONTROLER=getEmpresas&reporte=" + reporte;

  $.ajax({
    url: "BalancePruebaClass.php",
    data: QueryString,
    beforeSend: function () {},
    success: function (response) {
      if (reporte == "E") {
        $("#empresaReporte").html(response);
        $("#oficinaReporte").html("");
        $("#centroCostoReporte").html("");
      } else if (reporte == "O") {
        $("#empresaReporte").html(response);
        $("#oficinaReporte").html(
          "<select name='oficina_id' id='oficina_id' disabled><option value='NULL'>( Seleccione )</option></select>"
        );
        $("#centroCostoReporte").html("");
      } else if (reporte == "C") {
        $("#empresaReporte").html(response);
        $("#oficinaReporte").html("");
        $("#centroCostoReporte").html(
          "<select name='centro_de_costo' id='centro_de_costo' disabled><option value='NULL'>( Seleccione )</option></select>"
        );
      }
    },
  });
}

function onclickGenerarBalancePrueba(formulario) {
  if (ValidaRequeridos(formulario)) {
	  
    var desde              = $("#desde").val();
    var hasta 			       = $("#hasta").val();
    var opciones_tercero   = $("#opciones_tercero").val();
    var tercero 		       = $("#tercero").val();
    var opciones_centros   = $("#opciones_centros").val();
    var opciones_cierre    = $("#opciones_cierre").val();
    var tercero_id         = $("#tercero_hidden").val();
    var centro_de_costo_id = $("#centro_de_costo_id").val();
    var opciones_oficinas  = $("#opciones_oficinas").val();
    var all_subcuentas     = $("#all_subcuentas").val();
    var subCuentas 		     = all_subcuentas == 'T' ? null : $("#subcuentas").val();
    var all_cuentas        = $("#all_cuentas").val();
    var cuenta 		         = all_cuentas == 'T' ? null : $("#cuentas").val();
    var nivel              = $("#nivel").val();
    var niveles = [];
  
    $("input[name=nivel]:checked").each(function () {
      niveles.push(this.value);
    });
  
    if (niveles.length == 0) {
      $("#nivel5").attr("checked", "checked");
      niveles = 5;
    }

    var QueryString ="BalancePruebaClass.php?ACTIONCONTROLER=onclickGenerarBalancePrueba&desde=" +desde +"&hasta=" + hasta +"&opciones_tercero=" +
      opciones_tercero +"&tercero=" +tercero +"&tercero_id=" +tercero_id +"&opciones_centros=" +opciones_centros +"&centro_de_costo_id=" 
	  +centro_de_costo_id +"&opciones_oficinas=" +opciones_oficinas + "&nivel=" +nivel+"&all_subcuentas=" + all_subcuentas + "&subCuentas=" 
	  +subCuentas+"&niveles=" + niveles +"&all_cuentas="+all_cuentas+"&cuenta=" +cuenta+"&opciones_cierre="+opciones_cierre; 
  
    
    $("#frameReporte").attr("src", QueryString);
    showDivLoading();
    $("#frameReporte").load(function (response) {
      removeDivLoading();
    }); 
    
	
  }
}

function OnclickGenerarExcelFormato(formulario) {
  if (ValidaRequeridos(formulario)) {

    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var opciones_tercero = $("#opciones_tercero").val();
    var tercero = $("#tercero").val();
    var opciones_centros = $("#opciones_centros").val();
    var opciones_cierre = $("#opciones_cierre").val();
    var tercero_id = $("#tercero_hidden").val();
    var centro_de_costo_id = $("#centro_de_costo_id").val();
    var opciones_oficinas = $("#opciones_oficinas").val();
    var all_subcuentas = $("#all_subcuentas").val();
    var subCuentas = all_subcuentas == 'T' ? null : $("#subcuentas").val();
    var all_cuentas = $("#all_cuentas").val();
    var cuenta = all_cuentas == 'T' ? null : $("#cuentas").val();
    var nivel = $("#nivel").val();
    var niveles = [];

    $("input[name=nivel]:checked").each(function () {
      niveles.push(this.value);
    });

    if (niveles.length == 0) {
      $("#nivel5").attr("checked", "checked");
      niveles = 5;
    }

    var QueryString =
      "BalancePruebaClass.php?ACTIONCONTROLER=onclickGenerarBalancePrueba&desde=" + desde + "&hasta=" + hasta + "&opciones_tercero=" +
      opciones_tercero + "&tercero=" + tercero + "&tercero_id=" + tercero_id + "&opciones_centros=" + opciones_centros + "&centro_de_costo_id="
      + centro_de_costo_id + "&opciones_oficinas=" + opciones_oficinas + "&nivel=" + nivel + "&all_subcuentas=" + all_subcuentas + "&subCuentas="
      + subCuentas + "&niveles=" + niveles + "&all_cuentas=" + all_cuentas + "&cuenta=" + cuenta + "&opciones_cierre=" + opciones_cierre + "&download=SI&formato=SI&rand=" + Math.random();

    document.location.href = QueryString;
  }
}

function setCuentaHasta(Id, text, obj) {
  $("#cuenta_hasta").val(text);
  $("#cuenta_hasta_hidden").val(Id);
}

function beforePrint(formulario) {
  if (ValidaRequeridos(formulario)) {
    
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var opciones_tercero = $("#opciones_tercero").val();
    var tercero = $("#tercero").val();
    var opciones_centros = $("#opciones_centros").val();
    var opciones_cierre = $("#opciones_cierre").val();
    var tercero_id = $("#tercero_hidden").val();
    var centro_de_costo_id = $("#centro_de_costo_id").val();
    var opciones_oficinas = $("#opciones_oficinas").val();
    var all_subcuentas = $("#all_subcuentas").val();
    var subCuentas = all_subcuentas == 'T' ? null : $("#subcuentas").val();
    var all_cuentas = $("#all_cuentas").val();
    var cuenta = all_cuentas == 'T' ? null : $("#cuentas").val();
    var nivel = $("#nivel").val();
    var niveles = [];

    $("input[name=nivel]:checked").each(function () {
      niveles.push(this.value);
    });

    if (niveles.length == 0) {
      $("#nivel5").attr("checked", "checked");
      niveles = 5;
    }

    var QueryString =
      "BalancePruebaClass.php?ACTIONCONTROLER=onclickGenerarBalancePrueba&desde=" + desde + "&hasta=" + hasta + "&opciones_tercero=" +
      opciones_tercero + "&tercero=" + tercero + "&tercero_id=" + tercero_id + "&opciones_centros=" + opciones_centros + "&centro_de_costo_id="
      + centro_de_costo_id + "&opciones_oficinas=" + opciones_oficinas + "&nivel=" + nivel + "&all_subcuentas=" + all_subcuentas + "&subCuentas="
      + subCuentas + "&niveles=" + niveles + "&all_cuentas=" + all_cuentas + "&cuenta=" + cuenta + "&opciones_cierre=" + opciones_cierre ;
    popPup(QueryString, "Impresion Reporte", 800, 600);
  }
}
