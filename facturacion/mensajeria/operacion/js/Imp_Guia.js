function renderBarCode(guia_numero){

  var numCodBar = $.trim($("#bcTarget_"+guia_numero).text());
    
  $("div[id=bcTarget_"+guia_numero+"]").barcode(numCodBar, "code39",{barWidth:2, barHeight:30});       
  
}