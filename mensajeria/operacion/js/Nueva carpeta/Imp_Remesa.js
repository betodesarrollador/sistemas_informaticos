function renderBarCode(remesa_numero){

  var numCodBar = $.trim($("#bcTarget_"+remesa_numero).text());
    
  $("div[id=bcTarget_"+remesa_numero+"]").barcode(numCodBar, "code39",{barWidth:2, barHeight:30});       
  
}