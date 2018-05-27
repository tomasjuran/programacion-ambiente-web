"use strict";

var ProgressBar = {

incrementHandler: null,

display: function(boolean, index) {
	var wrapper = index 
		? "#progressbar-wrapper-" + index
		: "#progressbar-wrapper";
	
	if (boolean) {
		$(wrapper).attr("display", "inherit");
	} else {
		$(wrapper).attr("display", "none");
	}
},

change: function(percent, index) {
	var bar, text;
	if (index) {
		bar = "#progressbar-bar-" + index;
		text = "#progressbar-text-" + index;
	} else {
		bar = "#progressbar-bar";
		text = "#progressbar-text";
	}

	$(bar).width(percent + "%");

	clearInterval(this.incrementHandler);
	this.incrementHandler = setInterval(function() {
		var current = parseInt($(text).text());
		if (current < percent) {
			$(text).text((current+1) + "%");
		} else {
			clearInterval(ProgressBar.incrementHandler);
		}
	}, 1);
}

}