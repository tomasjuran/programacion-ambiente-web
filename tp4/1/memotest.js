"use_strict";

var Memotest = {
container: "",		// Id del div contenedor principal
statusMsg: "",	 	// Id del p para mostrar el estado del juego
countdown: "",		// Id del p para mostrar el tiempo restante

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

roundTime: 10,		// Un minuto de duración de ronda
timer: null,		// Handler que decrementa el tiempo


Player: function() {
	var name = "",			// Nombre del jugador
		timeLeft = 0, 		// Tiempo restante
		flipped = 0;		// Cantidad de tarjetas dadas vuelta en el turno actual
		found = 0,			// Pares encontrados
		playing = false;	// Jugando o no jugando
},

/**
 *	Intercambia las pantallas del juego
 */
init: function(container) {
	var main = document.getElementById(container);
		
	this.container = container;

	while (main.firstChild) {
		main.removeChild(main.firstChild);
	}

	if (this.currentState == this.prepare) {
		main.appendChild(this.createGameScreen());
		this.startGame();
	} else {
		main.appendChild(this.createSelectScreen());
	}
},

/**
 *	Crea la pantalla principal donde se eligen los jugadores
 */
createSelectScreen: function() {
	var screen = document.createElement("div"),
		h1 = document.createElement("h1"),
		pPlayers = document.createElement("p"),
		label = document.createElement("label"),
		qPlayers = document.createElement("input"),
		pButton = document.createElement("p"),
		button = document.createElement("button"),
		playersNames = document.createElement("section");

	screen.setAttribute("id", "select-screen");
	
	h1.appendChild(document.createTextNode("¡Jugar al Memotest!"));
	
	label.appendChild(document
		.createTextNode("Elija la cantidad de jugadores"));
	label.setAttribute("for", "q-players");
	
	qPlayers.setAttribute("type", "number");
	qPlayers.setAttribute("id", "q-players");
	qPlayers.setAttribute("oninput", "Memotest.addPlayers()");
	qPlayers.setAttribute("value", "0");
	
	button.appendChild(document.createTextNode("Jugar"));
	button.addEventListener("click", function() {
		var amount = document.getElementById("q-players").value,
			names = [];
		if (amount != "" && amount > 0) {
			for (var i = 1; i <= amount; i++) {
				names.push(document.getElementById("player-name-" + i).value);
			}

			Memotest.selectPlayers(names);
		}
	});

	playersNames.setAttribute("id", "section-players-names");

	pPlayers.appendChild(label);
	pPlayers.appendChild(qPlayers);
	
	pButton.appendChild(button);

	screen.appendChild(h1);
	screen.appendChild(pPlayers);
	screen.appendChild(pButton);
	screen.appendChild(playersNames);

	return screen;
},

/**
 *	Añade input text en la vista para los nombres de los jugadores
 */
addPlayers: function() {
	var amount = document.getElementById("q-players").value,
		playersNames = document.getElementById("section-players-names");
	
	while (playersNames.firstChild) {
		playersNames.removeChild(playersNames.firstChild);
	}
	
	if (amount != "") {
		for (var i = 1; i <= amount; i++) {
			var p = document.createElement("p"),
				label = document.createElement("label"),
				name = document.createElement("input");

			label.appendChild(document
				.createTextNode("Nombre del jugador " + i));
			label.setAttribute("for", "player-name-" + i);

			name.setAttribute("type", "text");
			name.setAttribute("id", "player-name-" + i);

			p.appendChild(label);
			p.appendChild(name);

			playersNames.appendChild(p);
		}
	}
},

/**
 *	Crea la pantalla con el tablero para empezar a jugar
 */
createGameScreen: function() {
	var screen = document.createElement("div");
		[rows, cols] = this.setupBoard();



	return screen;
},

/**
 *	Inicializa el tablero
 *	y devuelve la cantidad de filas y columnas
 */
setupBoard: function() {
	var size = Math.pow(this.level + 2, 2);

	this.cards = [];
	this.found = [];
	this.flipped = [];

	for (var i = 0; i < size; i = i + 2) {
		var card = this.generateCard();
		this.cards.push(card, card);
	}

	// En matrices impares queda un lugar por cubrir,
	// se le asigna el comodín
	if (size % 2 != 0) {
		this.cards.push(0);
	}

	this.shuffle(this.cards);
	return [this.level + 2, this.level + 2];
},

/**
 *	Devuelve un número entre 1 y cardTypes,
 *	ya que 0 es el comodín.
 */
generateCard: function() {
	return Math.trunc(Math.random() * (this.cardTypes - 1)) + 1;
},

/**
 *	Mezcla aleatoriamente los elementos de un Array
 */
shuffle: function(array) {
	var aux, swap, len = array.length;
	for (var i = 0; i < len; i++) {
		swap = Math.random() * (len - 1);
		aux = array[i];
		array[i] = array[swap];
		array[swap] = aux;
	}
	return array;
},

/**
 *	Carga los jugadores en el juego y llama a cambiar la pantalla
 */
selectPlayers: function(names) {
	for (var i = 0; i < names.length; i++) {
		var player = new this.Player();
		player.name = names[i];
		this.players.push(player);
	}

	this.currentState = this.prepare;
	this.level = 1;
	this.init(this.container);
},

/**
 *	Inicializa los jugadores y comienza el juego
 */
startGame: function() {
	this.players.forEach(function(element, index) {
		element.timeLeft = Memotest.roundTime;
		element.flipped = 0;
		element.found = 0;
		element.playing = true;
	});

	this.currentPlayer = 0;

	this.timer = setInterval(function() {
		if (Memotest.currentState == Memotest.playing) {
			var player = Memotest.players[Memotest.currentPlayer];

			player.timeLeft--;
			console.log(player.name + " (" + Memotest.currentPlayer
				+ ") tiene " + player.timeLeft + " segundos.");

			if (player.timeLeft <= 0) {
				console.log("¡" + player.name + " (" 
					+ Memotest.currentPlayer + ") se quedó sin tiempo!");
				player.playing = false;
				Memotest.nextTurn();
			}
		}
	}, 1000);

	this.currentState = this.playing;
},

/**
 *	Termina el juego
 */
endGame: function(win) {
	if (win) {

	} else {

	}

	clearInterval(this.timer);
	this.currentState = this.finished;
},

/**
 *	Realiza una jugada (acción del jugador al hacer click en una tarjeta)
 */
play: function(cardIndex) {

	// Se dieron vuelta todas las tarjetas
	if (this.cards.length == this.found.length) {
		this.endGame(true);
		return;
	}


},

/**
 *	Pasa al siguiente turno
 */
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

/**
 *	Da vuelta boca abajo las tarjetas volteadas que no formaron pareja
 */
faceDown: function() {

}

}