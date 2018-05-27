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
animations: [	// Nombres de las clases de animaciones
	"fade",
	"move-right", 
	"move-left",
	"move-top",
	"move-bottom"
],
slideIndex: 0,	// Índice actual del carrusel
auto: null,	// Handler del timeout

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
		"id":"carousel-img-top",
		click: function() {
			Carousel.showImage(1, true);
		}
	})
		.appendTo(main);

	$("<img>", {
		"id":"carousel-img-bot",
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
				Carousel.showImage(i);
			}
		})
			.appendTo(sectionDot);
	}

	this.showImage(0);
},

/**
 *	Muestra la imagen número <em>index</em>.
 *	Si <em>add</em> es <b>true</b>, suma al índice actual en lugar de cambiarlo.
 */
showImage: function(index, add) {
	var lastIndex, ani, urlImg;

	// Detener las animaciones
	clearTimeout(this.auto);

	// Cambiar de índice
	lastIndex = this.slideIndex;
	if (add) {
		this.slideIndex = (this.slideIndex +
			 index + this.images.length) % this.images.length;
	} else {
		this.slideIndex = index;
	}

	// Cambiar el botón activo
	$(".carousel-dot-active").each(function() {
		$(this).removeClass("carousel-dot-active");
	});
	$(".carousel-dot").eq(this.slideIndex).addClass("carousel-dot-active");

	// Animar la imagen anterior
	ani = this.slideIndex % this.animations.length;
	$("#carousel-img-top")
		.attr("src", Carousel.imgFolder + Carousel.images[lastIndex])
		.removeClass();
	$("#carousel-img-top").addClass(Carousel.animations[ani]);
	
	// Petición asíncrona para cambiar la imagen
	urlImg = this.imgFolder + this.images[this.slideIndex];
	$.ajax({
		url: urlImg,
		context: $("#carousel-img-bot")
	})
		.done(function() {
			$(this).attr("src", urlImg);
			Carousel.auto = setTimeout(function() {
				Carousel.showImage(1, true)
			}, 3000);
		});
}

}