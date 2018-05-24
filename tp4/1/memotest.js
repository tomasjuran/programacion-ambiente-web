"use_strict";

var Memotest = {
container:	"",				// Id del div contenedor principal
board:		"tbl-board",	// Id del tablero de juego
navGame:	"nav-game",		// Id del nav para ir al menú, pasar de nivel, etc.
btnNext:	"btn-next", 	// Id del botón "siguiente nivel"
statusMsg:	"p-status-msg",	// Id del p para mostrar el estado del juego
turnName:	"p-turn-name", 	// Id del p para mostrar el nombre del jugador
turnTimer:	"p-turn-timer",	// Id del p para mostrar el tiempo restante

prepare: 0,			// <
playing: 1,			//  |- Posibles estados del juego
finished: 2,		// <
currentState: 2,	// Estado actual del juego

players: [],		// Jugadores
currentPlayer: 0,	// Jugador actual
level: 0,			// Nivel de la ronda

cardTypes: 12,		// Cantidad de tipos de tarjetas
cards: [],			// Tarjetas jugables
cardsFlipped: [],	// Tarjetas boca arriba actualmente
cardsFound: [],		// Tarjetas que encontraron par

roundTime: 10,		// Duración de la ronda en segundos
timer: null,		// Handler que decrementa el tiempo

Card: function() {
	this.type = 0;
	this.found = false;		// Encontraron su par
	this.flipped = false;	// Está dada vuelta
},

Player: function() {
	this.name = "",			// Nombre del jugador
	this.timeLeft = 0, 		// Tiempo restante
	this.flipped = 0;		// Cantidad de tarjetas dadas vuelta en el turno actual
	this.found = 0,			// Pares encontrados
	this.playing = false;	// Jugando o no jugando
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
		this.nextLevel();
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
 *	Carga los jugadores en el juego y llama a cambiar la pantalla
 */
selectPlayers: function(names) {
	for (var i = 0; i < names.length; i++) {
		var player = new this.Player();
		player.name = names[i];
		this.players.push(player);
	}

	this.currentState = this.prepare;
	this.init(this.container);
},

/**
 *	Crea la pantalla con el tablero para empezar a jugar
 */
createGameScreen: function() {
	var screen = document.createElement("div"),
		secTurn = document.createElement("section"),
		pTurnName = document.createElement("p"),
		pTurnTimer = document.createElement("p"),
		secStatus = document.createElement("section"),
		pStatus = document.createElement("p"),
		artBoard = document.createElement("article"),
		board = document.createElement("table"),
		navGame = document.createElement("nav"),
		butBack = document.createElement("button");

	pTurnName.setAttribute("id", this.turnName);
	pTurnTimer.setAttribute("id", this.turnTimer);
	secTurn.appendChild(pTurnName);
	secTurn.appendChild(pTurnTimer);

	pStatus.setAttribute("id", this.statusMsg);
	secStatus.appendChild(pStatus);

	board.setAttribute("id", this.board);
	artBoard.appendChild(board);

	butBack.appendChild(document.createTextNode("Volver al menú"));
	butBack.addEventListener("click", function() {
		Memotest.currentState = Memotest.finished;
		Memotest.init(Memotest.container);
	});
	navGame.appendChild(butBack);
	navGame.setAttribute("id", this.navGame);

	screen.appendChild(secTurn);
	screen.appendChild(secStatus);
	screen.appendChild(artBoard);
	screen.appendChild(navGame);

	this.level = 0;
	return screen;
},

nextLevel: function() {
	var rows, cols,
		board = document.getElementById(this.board),
		navGame = document.getElementById(this.navGame),
		btnNext = document.getElementById(this.btnNext);

	// Quitar el botón de siguiente nivel
	if (btnNext) {
		navGame.removeChild(btnNext);
	}

	this.level++;
	[rows, cols] = this.setupBoard();

	for (var i = 0; i < rows; i++) {
		var tr = document.createElement("tr");
		for (var j = 0; j < cols; j++) {
			var td = document.createElement("td"),
				img = document.createElement("img"),
				index = i * cols + j;
			
			td.setAttribute("id", "card-" + (index));
			td.setAttribute("class", "card card-down");
			td.addEventListener("click", Memotest.cardListener(index));
			
			img.setAttribute("src", "images/facedown.png");
			img.setAttribute("alt", "-");

			td.appendChild(img);
			tr.appendChild(td);
		}
		board.appendChild(tr);
	}
	this.startGame();
},

/**
 * 	Cosas raras que hay que hacer en Javascript
 */
cardListener(cardIndex) {
	return function() {Memotest.play(cardIndex)};
},

/**
 *	Inicializa el tablero
 *	y devuelve la cantidad de filas y columnas.
 */
setupBoard: function() {
	var size = Math.pow(this.level + 2, 2);

	this.cards = [];
	this.cardsFlipped = [];
	this.cardsFound = [];

	for (var i = 0; i < size - 1; i = i + 2) {
		var card = this.generateCard();
		this.cards.push(card, Object.assign({}, card));
	}

	// En matrices impares queda un lugar por cubrir,
	// se le asigna el comodín
	if (size % 2 != 0) {
		this.cards.push(new this.Card());
	}

	this.shuffle(this.cards);
	return [this.level + 2, this.level + 2];
},

/**
 *	Genera una carta con un tipo entre 1 y cardTypes,
 *	ya que el 0 es el comodín.
 */
generateCard: function() {
	var card = new this.Card();
	card.type = Math.trunc(Math.random() * (this.cardTypes - 1)) + 1;
	return card;
},

/**
 *	Mezcla aleatoriamente los elementos de un Array
 */
shuffle: function(array) {
	var aux, swap, len = array.length;
	for (var i = 0; i < len; i++) {
		swap = Math.trunc(Math.random() * (len - 1));
		aux = array[i];
		array[i] = array[swap];
		array[swap] = aux;
	}
	return array;
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

	this.currentState = this.playing;
	this.currentPlayer = -1;
	this.nextTurn();

	clearInterval(this.timer);
	this.startTimer();
	this.timer = setInterval(Memotest.startTimer.bind(Memotest), 1000);
},

/**
 *	Inicializa el contador para los turnos
 */
startTimer: function() {
	if (this.currentState == this.playing) {
		var player = this.players[this.currentPlayer],
			statusMsg = document.getElementById(this.statusMsg),
			turnTimer = document.getElementById(this.turnTimer),
			minutos, segundos;

		if (player.timeLeft <= 0) {
			statusMsg.innerHTML = "¡" + player.name + " (" 
				+ this.currentPlayer + ") se quedó sin tiempo!";
			player.playing = false;
			this.nextTurn();
		} else {
			player.timeLeft--;
			minutos = Math.trunc(player.timeLeft / 60);
			if (minutos < 10) {
				minutos = "0" + minutos;
			}
			segundos = (player.timeLeft % 60);
			if (segundos < 10) {
				segundos = "0" + segundos;
			}
			turnTimer.innerHTML = "Tiempo restante " + minutos + ":" + segundos;
		}
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

	if (player.playing) {
	// Actualizar el turno
		document.getElementById(this.turnName).innerHTML =
			"Turno de " + player.name + " (" 
			+ this.currentPlayer + ")";
	} else {
	// Ningún jugador está en juego
		this.endGame(false);
		return;
	}
},

/**
 *	Realiza una jugada (acción del jugador al hacer click en una tarjeta)
 */
play: function(cardIndex) {
	this.flip(cardIndex);


	// Chequear si se dieron vuelta todas las tarjetas
	if (this.cardsFound.length == this.cards.length) {
		this.endGame(true);
	}
},

/**
 *	Da vuelta una tarjeta
 */
flip: function(cardIndex) {
	var card = this.cards[cardIndex],
		td = document.getElementById("card-" + cardIndex),
		img = td.firstChild;
		
	// La carta ya se encontraba volteada
	if (card.flipped) {
		card.flipped = false;
		var i = 0, remIndex;
		while (i < this.cardsFlipped.length && !remIndex) {
			if (this.cardsFlipped[i] == cardIndex) {
				remIndex = i;
				this.cardsFlipped.splice(remIndex, 1);
				td.setAttribute("class", "card card-down");
				img.setAttribute("src", "images/facedown.png");
				img.setAttribute("alt", "-");
			}
			i++;
		}
	// Voltear la carta
	} else {
		card.flipped = true;
		this.cardsFlipped.push(cardIndex);
		td.setAttribute("class", "card card-up");
		img.setAttribute("src", "images/" + card.type + ".png");
		img.setAttribute("alt", card.type);
	}
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
}

}