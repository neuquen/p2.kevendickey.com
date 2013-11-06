	// Prevents empty fields in signup form
	window.onload = function(){
	    var inp = document.getElementById("signup");
	    inp.onkeydown = preventSpace;
	    inp.onpaste = preventPaste;
	};

	function preventSpace(e){
	    var e = e || event;
	    if (e.keyCode == 32) return false;  
	}

	function preventPaste(e){
	    var e = e || event;
	    var data = e.clipboardData.getData("text/plain");
	    if (data.match(/\s/g)) return false;    
	}