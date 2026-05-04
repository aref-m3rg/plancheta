function mask(str,textbox,loc,delim){
		var locs = loc.split(',');
		for (var i = 0; i <= locs.length; i++){
				for (var k = 0; k <= str.length; k++){
						if (k == locs[i]){
								if (str.substring(k, k+1) != delim){
										str = str.substring(0,k) + delim + str.substring(k,str.length)
								}
						}
				}
		}
  textbox.value = str
}