"use strict";

var ProgressBar = {

incrementHandler: null,
delayHandler: null,

init: function(container) {
	var main, wrapper;
	wrapper = $("<div>", {
		"id":"progressbar-wrapper"
	});

	$("<div>", {
		"id":"progressbar-bar"
	})
		.width("0%")
		.appendTo(wrapper);

	$("<p>", {
		"id":"progressbar-text"
	})
		.text("0%")
		.appendTo(wrapper);

	main = $("<div>", {
		"class":"progressbar-main"
	});

	wrapper.appendTo(main);
	main.appendTo($(container));
},

display: function(show, delay, index) {
	var id, wrapper;
	
	clearTimeout(this.delayHandler);
	
	id = "progressbar-wrapper";
	if (index) {
		id += "-" + index;
	}
	
	wrapper = document.getElementById(id);
	
	if (show) {
		delay = delay || 0;
		this.delayHandler = setTimeout(function() {
			wrapper.style.display = "block";
		}, delay);
	} else {
		wrapper.style.display = "none";
	}
},

change: function(percent, index) {
	var bar, text, pText;

	clearInterval(this.incrementHandler);

	bar = "progressbar-bar";
	text = "progressbar-text";
	if (index) {
		bar += "-" + index;
		text = "-" + index;
	}

	(document.getElementById(bar)).style.width = percent + "%";
	(document.getElementById(text)).innerHTML = percent + "%";

/* Esto sirve si hay saltos grandes entre changes
	pText = document.getElementById(text);
	this.incrementHandler = setInterval(function() {
		var current = parseInt(pText.innerHTML);
		if (current < percent) {
			pText.innerHTML = (current+1) + "%";
		} else if (current > percent) {
			pText.innerHTML = (current-1) + "%";
		} else {
			clearInterval(ProgressBar.incrementHandler);
		}
	}, 1);
*/
}

}