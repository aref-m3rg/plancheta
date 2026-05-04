function show_reloj(){
	if (!document.layers&&!document.all&&!document.getElementById)
	return

	 var Digital=new Date()
	 var hours=Digital.getHours()
	 var minutes=Digital.getMinutes()
	 var seconds=Digital.getSeconds()

	var dn="PM"
	if (hours<12)
	dn="AM"
	if (hours>12)
	hours=hours-12
	if (hours==0)
	hours=12

	 if (minutes<=9)
	 minutes="0"+minutes
	 if (seconds<=9)
	 seconds="0"+seconds
	//change font size here to your desire
	myclock="<font size='2' face='Arial' ><b><font size='1'></font></br>"+hours+":"+minutes+":"
	 +seconds+" "+dn+"</b></font>"
	if (document.layers){
	document.layers.liveclock.document.write(myclock)
	document.layers.liveclock.document.close()
	}
	else if (document.all)
	liveclock.innerHTML=myclock
	else if (document.getElementById)
	document.getElementById("liveclock").innerHTML=myclock
	setTimeout("show_reloj()",1000)
}

function gup( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return "";
	else
		return results[1];
}

function abre_popup(url,w,h){
	var w_left = Math.ceil(screen.width/2-w/2);
	var w_top = Math.ceil(screen.height/2-h/2);
	window.open(url,'v1','width='+w+',height='+h+',left='+w_left+',top='+w_top+',center:yes,resizesable=0,scrollbars=1').focus();
}
