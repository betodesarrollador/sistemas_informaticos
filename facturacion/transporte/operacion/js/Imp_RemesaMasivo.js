$(document).ready(function(){
						   
	 $("div[name=codigo]").each(function(){					   
		
		var numCodBar = $.trim($(this).text());
		$(this).barcode(numCodBar, "code39",{barWidth:2, barHeight:30});  
  
  	});
	 
	// var numCodBar = $.trim($("#bcTarget").text());
    
    //$("div[id=bcTarget]").barcode(numCodBar, "code39",{barWidth:2, barHeight:30});  
});