$(document).ready(function(){
  
  var numCodBar = $.trim($("#bcTarget").text());
  
  $("#bcTarget").barcode(numCodBar, "code39",{barWidth:2, barHeight:30});     
  
  
});