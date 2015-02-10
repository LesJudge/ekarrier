function buttonfix(){
	var buttons = $('button:not(.no_fix)');
	for (var i=0; i<buttons.length; i++) {
		buttons[i].onclick = function () {
			for(j=0; j<this.form.elements.length; j++)
				if( this.form.elements[j].tagName == 'BUTTON' )
					this.form.elements[j].disabled = true;
			this.disabled=false;
			this.value = this.attributes.getNamedItem("value").nodeValue ;
		}
	}
}
window.attachEvent("onload", buttonfix);