var console = console || {},
	document = document || {},

	LoaderIcon = {

		duration: 4000,
		intervals: 40,
		colors: [
			[251,226,104], /* #fbe268 yellow */
			[174,221,166], /* #aedda6 green */
			[231, 72, 58]  /* #e7483a red */
		],

		init: function (container) {
			"use strict";
			var loader = document.getElementById(container);
			this.transitionStart(loader);
		},

		transitionStart: function(loader) {
			var	duration = this.duration,
				intervals = this.intervals,
				colors = this.colors,
				
				changeColor = this.changeColor,
				getStep = this.getStep,
				
				currentIndex = 0,
				currentColor = [],
				
				targetIndex = 0,
				targetColor = [],
				
				step = [],
				stepCount = intervals + 1,

				handle = null;
		
			// Transición Gradiente
			handle = setInterval(function() {

				if (stepCount > intervals) {
					currentIndex = targetIndex;
					// slice() copia los contenidos sin mantener la referencia
					currentColor = colors[currentIndex].slice();
				
					targetIndex = currentIndex < colors.length - 1 
							? currentIndex + 1
							: 0;
					targetColor = colors[targetIndex].slice();
					
					step = getStep(currentColor, targetColor, intervals);
					stepCount = 1;
				}

				changeColor(loader, currentColor, step);

				stepCount++;

			}, duration / intervals);
		},
		
		/*
			Retornar cuánto debe cambiar un color entre cada
			intervalo para el efecto de transición gradiente
		 */
		getStep: function (currentColor, targetColor, intervals) {
			var step = [];
			for (var i = 0; i < currentColor.length; i++) {
				step[i] = (targetColor[i] - currentColor[i]) / intervals;
			}
			return step;
		},

		changeColor: function (loader, currentColor, step) {
			var border = "",
				truncColor = [],
				allColors = [];

			for (var i = 0; i < step.length; i++) {
				currentColor[i] = currentColor[i] + step[i];
				// Guardar en truncColor un valor sin decimales
				truncColor[i] = Math.trunc(currentColor[i]);
			}

			for (var k = 0; k < 4; k++) {
				allColors[k] = [];
				for (var i = 0; i < truncColor.length; i++) {
					allColors[k][i] = truncColor[i] + 20 * k;
				}
				border += "rgb(" + allColors[k].join(",") + ") ";
			}

			loader.style.borderColor = border;

			return currentColor;
		}

	}