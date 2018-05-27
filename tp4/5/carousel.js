"use strict";

var Carousel = {
imgFolder: "images/",	// Carpeta de imágenes
images: [	// Imágenes del carrusel
	"1.png",
	"2.gif",
	"3.png",
	"4.jpg",
	"5.jpeg"
],
slideIndex: 0,	// Índice actual del carrusel

init: function(container) {
	var main, sectionDot, prev, next;

	main = $("<div>", {
		"class":"carousel-main"
	})
		.appendTo($("#" + container));

	prev = $("<a>", {
		"class":"carousel-prev",
		click: function() {
				Carousel.showImage(-1, true);
		}
	})
		.appendTo(main);

	$("<span>", {
		"class":"carousel-left",
		"html":"&#10094;"
	})
		.appendTo(prev);

	next = $("<a>", {
		"class":"carousel-next",
		click: function() {
			Carousel.showImage(1, true);
		}
	})
		.appendTo(main);

		$("<span>", {
		"class":"carousel-right",
		"html":"&#10095;"
	})
		.appendTo(next);
		
	$("<img>", {
		"id":"carousel-img",
		click: function() {
			Carousel.showImage(1, true);
		}
	})
		.appendTo(main);

	sectionDot = $("<section>", {
		"class":"carousel-section-dot"
	})
		.appendTo(main);

	for (let i = 0; i < this.images.length; i++) {
		$("<div>", {
			"class":"carousel-dot",
			click: function() {
				$(this).toggleClass("carousel-dot-active");
				Carousel.showImage(i);
			}
		})
			.appendTo(sectionDot);
	}
},

/**
 *	Muestra la imagen número <em>index</em>.
 *	Si <em>add</em> es <b>true</b>, suma al índice actual en lugar de cambiarlo.
 */
showImage: function(index, add) {
	$(".carousel-dot-active").first

	if (add) {
		this.slideIndex = (this.slideIndex + index) % this.images.length;
	} else {
		this.slideIndex = index;
	}
	$("#carousel-img").attr("src", this.imgFolder + this.images[this.slideIndex]);
}

}