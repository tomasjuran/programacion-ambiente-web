"use strict";

var Carousel = {
imgFolder: "images/",	// Carpeta de imágenes
images: [	// Imágenes del carrusel
	"1.png",
	"2.gif",
	"3.png",
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
	var main, progressbar, sectionImg, ulImg, sectionDot, ulDot, prev, next;

	main = document.createElement("div");
	main.className = "carousel-main";
		
	progressbar = document.createElement("div");
	progressbar.id = "carousel-progressbar";
	main.appendChild(progressbar);
	ProgressBar.init(progressbar);

	sectionImg = document.createElement("section");
	sectionImg.id = "carousel-section-img";
	main.appendChild(sectionImg);

	ulImg = document.createElement("ul");
	sectionImg.appendChild(ulImg);

	for (var i = 0; i < this.images.length; i++) {
		let li, img, currentIndex;

		img = document.createElement("img");
		img.className = "carousel-img";
		img.addEventListener("click", function() {
			Carousel.showImage(1, true);
		});
		img.addEventListener("loadstart", function() {
			currentIndex = Carousel.slideIndex;
			this.style.display = "none";
			// Esperar un poco antes de mostrar la barra de progreso
			ProgressBar.display(true, 500);
		});
		img.addEventListener("progress", function(event) {
			// No actuar si la imagen cambió
			if (currentIndex === Carousel.slideIndex) {
				ProgressBar.change(Math.trunc(event.loaded / event.total * 100));
			}
		});
		img.addEventListener("loadend", function() {
			if (currentIndex === Carousel.slideIndex) {
				this.style.display = "block";
				ProgressBar.display(false);
				Carousel.autoHandler = setTimeout(function() {
					Carousel.showImage(1, true)
				}, 3000);
			}
		});

		li = document.createElement("li");
		li.appendChild(img);
		ulImg.appendChild(li);
	}

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
		.appendTo(main)
		.get(0);

	ulDot = document.createElement("ul");
	sectionDot.appendChild(ulDot);

	for (let i = 0; i < this.images.length; i++) {
		$("<li>", {
			"class":"carousel-dot",
			click: function() {
				Carousel.showImage(i);
			}
		})
			.appendTo(ulDot);
	}

	document.getElementById(container).appendChild(main);

	this.showImage(0);
},

/**
 *	Muestra la imagen número <em>index</em>.
 *	Si <em>add</em> es <b>true</b>, suma al índice actual en lugar de cambiarlo.
 */
showImage: function(index, add) {
	var lastIndex, ani,
		imageList, imgTop, imgBot;

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

	// Cambiar el botón activo
	$(".carousel-dot-active").each(function() {
		$(this).removeClass("carousel-dot-active");
	});
	$(".carousel-dot").eq(this.slideIndex).addClass("carousel-dot-active");

	imageList = $("#carousel-section-img img");

	// Animar la imagen anterior
	ani = Math.trunc(Math.random() * this.animations.length);
	imgTop = imageList.eq(lastIndex)[0];
	imgTop.className = "carousel-img carousel-img-top " + this.animations[ani];
	
	// Cargar la nueva imagen
	imgBot = imageList.eq(this.slideIndex)[0];
	imgBot.className = "carousel-img";
	imgBot.src = this.imgFolder + this.images[this.slideIndex];
}

}