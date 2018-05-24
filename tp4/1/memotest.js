"use_strict";

var Memotest = {
	container: "",		// Id del div contenedor

	prepare: 0,			// <
	playing: 1,			//  |- Posibles estados del juego
	finished: 2,		// <
	currentState: 2,	// Estado actual del juego

	players: [],		// Jugadores
	currentPlayer: 0,	// Jugador actual
	level: 1,			// Nivel de la ronda

	cardTypes: 12,		// Cantidad de tipos de tarjetas
	cards: [],			// Tarjetas jugables
	found: [],			// Tarjetas encontradas
	flipped: [],		// Tarjetas dadas vuelta en el turno actual

	roundTime: 60,		// Un minuto de duración de ronda
	timer: null,		// Handler que decrementa el tiempo

	Player: function() {
		var timeLeft = 0, 		// Tiempo restante
			flipped = 0;		// Cantidad de tarjetas dadas vuelta en el turno actual
			found = 0,			// Pares encontrados
			playing = false;	// Jugando o no jugando
	},


	init: function(container) {
		var main = document.getElementById(container);
		this.container = container;

		if (main.hasChildNodes()) {
			main.removeChild(main.firstChild);
		}

		if (this.currentState == this.prepare) {
			main.appendChild(this.createGameScreen());
			this.startGame();
		} else {
			main.appendChild(this.createSelectScreen());
		}
	},

	createSelectScreen: function() {
		var screen = document.createElement("div"),
			h1 = document.createElement("h1"),
			p = document.createElement("p"),
			label = document.createElement("label"),
			input = document.createElement("input"),
			button = document.createElement("button");

		screen.setAttribute("id", "select-screen");
		
		h1.appendChild(document.createTextNode("¡Jugar al Memotest!"));
		
		label.appendChild(document.createTextNode("Elija la cantidad de jugadores"));
		label.setAttribute("for", "q-players");
		
		input.setAttribute("type",	"text");
		input.setAttribute("id", "q-players");
		
		button.appendChild(document.createTextNode("Jugar"));
		button.addEventListener("click", function() {
			var amount = document.getElementById("q-players").value;
			Memotest.selectPlayers(amount);
		});

		p.appendChild(label);
		p.appendChild(input);
		p.appendChild(button);

		screen.appendChild(h1);
		screen.appendChild(p);

		return screen;
	},

	createGameScreen: function() {
		var screen = document.createElement("div");

		return screen;
	},

	setupBoard: function() {
		var size = Math.pow(this.level + 2, 2);

		this.cards = [];

		for (var i = 0; i < size; i + 2) {
			var card = this.generateCard();
			this.cards[i] = card;
			this.cards[i + 1] = card;
		}

		// En matrices impares queda un lugar por cubrir
		if ()
	},

	/**
	 *	Devuelve un número entre 1 y cardTypes,
	 *	ya que 0 es el comodín
	 */
	generateCard: function() {
		return Math.trunc(Math.random() * (this.cardTypes - 1)) + 1;
	},

	randomizeCards: function() {

	},

	selectPlayers: function(amount) {
		for (var i = 0; i < amount; i++) {
			this.players[i] = new this.Player();
		}

		this.currentState = this.prepare;
		this.level = 1;
		this.init(this.container);
	},

	startGame: function() {
		this.players.forEach(function(element, index) {
			element.timeLeft = Memotest.roundTime;
			element.flipped = 0;
			element.found = 0;
			element.playing = true;
		});

		this.timer = setInterval(function() {
			if (Memotest.currentState == Memotest.playing) {
				var player = Memotest.players[Memotest.currentPlayer];

				if (player.timeLeft <= 0) {
					player.playing = false;
					Memotest.nextTurn();
				}
			}
		}, 1000);

		this.currentState = this.playing;
	},

	endGame: function(win) {
		if (win) {

		} else {

		}

		clearInterval(this.timer);
		this.currentState = this.finished;
	},

	play: function(playerIndex, cardIndex) {

		// Se dieron vuelta todas las cartas
		if (this.cards.length == this.found.length) {
			this.endGame(true);
			return;
		}


	},

	nextTurn: function() {
		// Pasar de turno
		this.currentPlayer = (this.currentPlayer + 1) % this.players.length;
		
		// Chequear que el jugador está en juego
		var player = this.players[this.currentPlayer],
			i = 0;
		while (i < this.players.length && !player.playing) {
			i++;
			this.currentPlayer = (this.currentPlayer + 1) % this.players.length;
			player = this.players[this.currentPlayer];
		}

		// Si ningún jugador está en juego
		if (i >= this.players.length) {
			this.endGame(false);
			return;
		}

		// Dar vuelta las tarjetas del turno
		this.faceDown();
	},

	faceDown: function() {

	}
}