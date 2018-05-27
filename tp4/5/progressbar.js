"use strict";

var ProgressBar = {

incrementHandler: null,
delayHandler: null,

init: function(container) {
	var wrapper = $("<div>", {
		"id":"progressbar-wrapper"
	})
		.appendTo($(container));

	$("<div>", {
		"id":"progressbar-bar"
	})
		.appendTo(wrapper);

	$("<p>", {
		"id":"progressbar-text",
		"text":"0%"
	})
		.appendTo(wrapper);
},

display: function(show, delay, index) {
	var wrapper = index 
		? "#progressbar-wrapper-" + index
		: "#progressbar-wrapper";
	
	if (show) {
		delay = delay || 0;
		this.delayHandler = setTimeout(function() {
			$(wrapper).show();
		}, delay);
	} else {
		clearTimeout(this.delayHandler);
		$(wrapper).hide();
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
		} else if (current > percent) {
			$(text).text((current-1) + "%");
		} else {
			clearInterval(ProgressBar.incrementHandler);
		}
	}, 1);
}

}