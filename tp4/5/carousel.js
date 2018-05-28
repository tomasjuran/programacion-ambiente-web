"use strict";

var Carousel = {
imgTop: "carousel-img-top",	// Id de la imagen anterior
imgBot: "carousel-img-bot",	// Id de la imagen actual

imgFolder: "images/",	// Carpeta de imágenes
images: [	// Imágenes del carrusel
	"1.png",
	"2.gif",
	//"3.png",
	"4.jpg",
	"5.jpeg",
	"6.gif"
],
animations: [	// Nombres de las clases de animaciones
	"fade",
	"move-right", 
	"move-left",
	"move-top",
	"move-bottom"
],
slideIndex: 0,	// Índice actual del carrusel
autoHandler: null,	// Handler del slide

init: function(container) {
	var main, progressbar, sectionDot, prev, next;

	main = $("<div>", {
		"class":"carousel-main"
	});
		
	progressbar = $("<div>", {
		"id":"carousel-progressbar"
	})
		.appendTo(main);

	ProgressBar.init(progressbar);

	$("<img>", {
		"id":Carousel.imgTop,
		click: function() {
			Carousel.showImage(1, true);
		}
	})
		.appendTo(main);

	$("<img>", {
		"id":Carousel.imgBot,
		click: function() {
			Carousel.showImage(1, true);
		}
	})
		.appendTo(main);

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

	main.appendTo($(container));

	this.showImage(0);
},

/**
 *	Muestra la imagen número <em>index</em>.
 *	Si <em>add</em> es <b>true</b>, suma al índice actual en lugar de cambiarlo.
 */
showImage: function(index, add) {
	var lastIndex, currentIndex, ani, urlImg,
		imgTop, imgBot;

	// Detener las animaciones
	clearTimeout(this.autoHandler);

	// Cambiar de índice
	lastIndex = this.slideIndex;
	if (add) {
		this.slideIndex = (this.slideIndex +
			 index + this.images.length) % this.images.length;
	} else {
		this.slideIndex = index;
	}
	currentIndex = this.slideIndex;

	// Cambiar el botón activo
	$(".carousel-dot-active").each(function() {
		$(this).removeClass("carousel-dot-active");
	});
	$(".carousel-dot").eq(this.slideIndex).addClass("carousel-dot-active");

	// Animar la imagen anterior
	ani = this.slideIndex % this.animations.length;
	
	imgTop = document.getElementById(this.imgTop);
	imgTop.src = this.imgFolder + this.images[lastIndex];
	imgTop.className = this.animations[ani];
	
	// Ocultar mientras se carga la nueva imagen
	imgBot = document.getElementById(this.imgBot);
	imgBot.style.display = "none";
	
	// Petición asíncrona para cambiar la imagen
	urlImg = this.imgFolder + this.images[this.slideIndex];
	$.ajax({
		url: urlImg,
		//cache: false,
		xhr: function() {
			var xhr = $.ajaxSettings.xhr();

			xhr.onloadstart = function(event) {
				// Esperar un poco antes de mostrar la barra de progreso
				ProgressBar.display(true, 500);
			};

			xhr.onprogress = function(event) {
				if (currentIndex === Carousel.slideIndex) {
					if (event.loaded !== event.total) {
						ProgressBar.change(Math.trunc(event.loaded / event.total * 100));
					}
				}
			};

			return xhr;
		}
	})
		.done(function() {
			// No intentar cambiar la imagen si ya no es la actual
			if (currentIndex === Carousel.slideIndex) {
				imgBot.src = urlImg;
				// El navegador tarda un rato en mostrar la imagen nueva
				setTimeout(function() {
					imgBot.style.display = "block";
				}, 500);
			}
		})
		.always(function() {
			if (currentIndex === Carousel.slideIndex) {
				ProgressBar.display(false);
				Carousel.autoHandler = setTimeout(function() {
					Carousel.showImage(1, true)
				}, 3000);
			}
		});
}

}