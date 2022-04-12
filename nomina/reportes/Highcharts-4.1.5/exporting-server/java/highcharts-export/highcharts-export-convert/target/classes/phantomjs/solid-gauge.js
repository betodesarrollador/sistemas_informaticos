/*
  Highcharts JS v4.1.1 (2015-02-17)
 Solid angular gauge module

 (c) 2010-2014 Torstein Honsi

 License: www.highcharts.com/license
*/
(function(a){var p=a.getOptions().plotOptions,q=a.pInt,r=a.pick,j=a.each,o;p.solidgauge=a.merge(p.gauge,{colorByPoint:!0});o={initDataClasses:function(b){var c=this,e=this.chart,d,n=0,i=this.options;this.dataClasses=d=[];j(b.dataClasses,function(h,f){var g,h=a.merge(h);d.push(h);if(!h.color)i.dataClassColor==="category"?(g=e.options.colors,h.color=g[n++],n===g.length&&(n=0)):h.color=c.tweenColors(a.Color(i.minColor),a.Color(i.maxColor),f/(b.dataClasses.length-1))})},initStops:function(b){this.stops=
b.stops||[[0,this.options.minColor],[1,this.options.maxColor]];j(this.stops,function(b){b.color=a.Color(b[1])})},toColor:function(b,c){var e,d=this.stops,a,i=this.dataClasses,h,f;if(i)for(f=i.length;f--;){if(h=i[f],a=h.from,d=h.to,(a===void 0||b>=a)&&(d===void 0||b<=d)){e=h.color;if(c)c.dataClass=f;break}}else{this.isLog&&(b=this.val2lin(b));e=1-(this.max-b)/(this.max-this.min);for(f=d.length;f--;)if(e>d[f][0])break;a=d[f]||d[f+1];d=d[f+1]||a;e=1-(d[0]-e)/(d[0]-a[0]||1);e=this.tweenColors(a.color,
d.color,e)}return e},tweenColors:function(b,c,a){var d=c.rgba[3]!==1||b.rgba[3]!==1;return b.rgba.length===0||c.rgba.length===0?"none":(d?"rgba(":"rgb(")+Math.round(c.rgba[0]+(b.rgba[0]-c.rgba[0])*(1-a))+","+Math.round(c.rgba[1]+(b.rgba[1]-c.rgba[1])*(1-a))+","+Math.round(c.rgba[2]+(b.rgba[2]-c.rgba[2])*(1-a))+(d?","+(c.rgba[3]+(b.rgba[3]-c.rgba[3])*(1-a)):"")+")"}};j(["fill","stroke"],function(b){HighchartsAdapter.addAnimSetter(b,function(c){c.elem.attr(b,o.tweenColors(a.Color(c.start),a.Color(c.end),
c.pos))})});a.seriesTypes.solidgauge=a.extendClass(a.seriesTypes.gauge,{type:"solidgauge",bindAxes:function(){var b;a.seriesTypes.gauge.prototype.bindAxes.call(this);b=this.yAxis;a.extend(b,o);b.options.dataClasses&&b.initDataClasses(b.options);b.initStops(b.options)},drawPoints:function(){var b=this,c=b.yAxis,e=c.center,d=b.options,n=b.radius=q(r(d.radius,100))*e[2]/200,i=b.chart.renderer;a.each(b.points,function(a){var f=a.graphic,g=c.startAngleRad+c.translate(a.y,null,null,null,!0),k=q(r(d.innerRadius,
60))*e[2]/200,l=c.toColor(a.y,a);l==="none"&&(l=a.color||b.color||"none");if(l!=="none")a.color=l;d.wrap===!1&&(g=Math.max(c.startAngleRad,Math.min(c.endAngleRad,g)));var g=g*180/Math.PI,m=g/(180/Math.PI),j=c.startAngleRad,g=Math.min(m,j),m=Math.max(m,j);m-g>2*Math.PI&&(m=g+2*Math.PI);a.shapeArgs=k={x:e[0],y:e[1],r:n,innerR:k,start:g,end:m,fill:l};f?(a=k.d,f.animate(k),k.d=a):a.graphic=i.arc(k).attr({stroke:d.borderColor||"none","stroke-width":d.borderWidth||0,fill:l,"sweep-flag":0}).add(b.group)})},
animate:function(b){this.center=this.yAxis.center;this.center[3]=2*this.radius;this.startAngleRad=this.yAxis.startAngleRad;a.seriesTypes.pie.prototype.animate.call(this,b)}})})(Highcharts);
