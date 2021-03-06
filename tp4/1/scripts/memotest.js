"use_strict";

var Memotest = {
container:	"",							// Id del div contenedor principal
board:		"art-board",			// Id del tablero de juego
navGame:	"nav-game",				// Id del nav para ir al menú, pasar de nivel, etc.
btnTurn:	"btn-turn",				// Id del botón "pasar turno"
btnNext:	"btn-next", 			// Id del botón "siguiente nivel"
statusMsg:	"p-status-msg",	// Id del p para mostrar el estado del juego
turnName:	"p-turn-name", 		// Id del p para mostrar el nombre del jugador
turnTimer:	"p-turn-timer",	// Id del p para mostrar el tiempo restante

prepare: 0,				// <
playing: 1,				//  |- Posibles estados del juego
finished: 2,			// <
currentState: 2,	// Estado actual del juego

players: [],			// Jugadores
currentPlayer: 0,	// Jugador actual
level: 0,					// Nivel de la ronda

cardTypes: 12,		// Cantidad de tipos de tarjetas
cards: [],				// Tarjetas jugables
cardsFlipped: [],	// Índices de las tarjetas boca arriba actualmente
cardsFound: [],		// Índices de las tarjetas que encontraron par

roundTime: 61,			// Duración de la ronda en segundos
timer: null,				// Handler que decrementa el tiempo
facedownTime: null,	// Handler que muestra las tarjetas antes de pasar de turno

Card: function() {
	this.type = 0;
	this.found = false;		// Encontraron su par
	this.flipped = false;	// Está dada vuelta
},

Player: function() {
	this.name = "",				// Nombre del jugador
	this.timeLeft = 0, 		// Tiempo restante
	this.found = 0,				// Pares encontrados
	this.playing = false;	// Jugando o no jugando
},

/**
 *	Intercambia las pantallas del juego.
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
		this.addPlayers();
	}
},

/**
 *	Crea la pantalla principal donde se eligen los jugadores.
 */
createSelectScreen: function() {
	var screen = document.createElement("div"),
		h1 = document.createElement("h1"),
		formPlay = document.createElement("form"),
		lTime = document.createElement("label"),
		iTime = document.createElement("input"),
		pTime = document.createElement("p"),
		lCards = document.createElement("label"),
		iCards = document.createElement("input"),
		pCards = document.createElement("p"),
		lPlayers = document.createElement("label"),
		iPlayers = document.createElement("input"),
		pPlayers = document.createElement("p"),
		btnPlay = document.createElement("button"),
		pBtnPlay = document.createElement("p"),
		playersNames = document.createElement("section"),
		hPlayersNames = document.createElement("h3");

	screen.setAttribute("class", "screen-select");
	
	h1.innerHTML = "¡Jugar al Memotest!";
	
	lTime.innerHTML = "Elija el tiempo de ronda (segundos)";
	lTime.setAttribute("for", "q-time");
	
	iTime.setAttribute("type", "number");
	iTime.setAttribute("id", "q-time");
	iTime.setAttribute("value", "60");
	iTime.setAttribute("min", "1");

	pTime.appendChild(lTime);
	pTime.appendChild(iTime);

	lCards.innerHTML = "Elija la cantidad de tarjetas distintas";
	lCards.setAttribute("for", "q-cards");
	
	iCards.setAttribute("type", "number");
	iCards.setAttribute("id", "q-cards");
	iCards.setAttribute("value", "12");
	iCards.setAttribute("min", "1");
	iCards.setAttribute("max", "19");

	pCards.appendChild(lCards);
	pCards.appendChild(iCards);

	lPlayers.innerHTML = "Elija la cantidad de jugadores";
	lPlayers.setAttribute("for", "q-players");
	
	iPlayers.setAttribute("type", "number");
	iPlayers.setAttribute("id", "q-players");
	iPlayers.setAttribute("oninput", "Memotest.addPlayers()");
	iPlayers.setAttribute("value", "1");
	iPlayers.setAttribute("min", "1");

	pPlayers.appendChild(lPlayers);
	pPlayers.appendChild(iPlayers);

	btnPlay.innerHTML = "Jugar";
	btnPlay.setAttribute("type", "button");
	btnPlay.addEventListener("click", function() {
		var qTime = document.getElementById("q-time").value,
			qCards = document.getElementById("q-cards").value,
			qPlayers = document.getElementById("q-players").value,
			names = [];

		if (qTime < 1) {
			return false;
		}

		if (qCards < 1) {
			return false;
		}

		if (qPlayers != "" && qPlayers > 0) {
			for (var i = 1; i <= qPlayers; i++) {
				names.push(document.getElementById("player-name-" + i).value);
			}
			Memotest.prepareGame(qTime, qCards, names);
		}
	});
	pBtnPlay.appendChild(btnPlay);

	formPlay.appendChild(pTime);
	formPlay.appendChild(pCards);
	formPlay.appendChild(pPlayers);
	formPlay.appendChild(pBtnPlay);

	hPlayersNames.innerHTML = "Ingrese los nombres de los jugadores:";
	playersNames.setAttribute("id", "section-players-names");
	playersNames.appendChild(hPlayersNames);

	screen.appendChild(h1);
	screen.appendChild(formPlay);
	screen.appendChild(playersNames);

	return screen;
},

/**
 *	Añade input text en la vista para los nombres de los jugadores.
 */
addPlayers: function() {
	var qPlayers = document.getElementById("q-players").value,
		playersNames = document.getElementById("section-players-names");
	
	while (playersNames.childElementCount > 1) {
		playersNames.removeChild(playersNames.lastChild);
	}
	
	if (qPlayers != "") {
		for (var i = 1; i <= qPlayers; i++) {
			var p = document.createElement("p"),
				label = document.createElement("label"),
				name = document.createElement("input");

			label.innerHTML = "Nombre del jugador " + i;
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
 *	Carga los jugadores en el juego, setea el tiempo de ronda,
 *	la cantidad de tarjetas y llama a cambiar la pantalla.
 */
prepareGame: function(time, cards, names) {
	this.roundTime = parseInt(time) + 1;
	this.cardTypes = parseInt(cards);
	this.players = [];
	for (var i = 0; i < names.length; i++) {
		var player = new this.Player();
		player.name = names[i];
		this.players.push(player);
	}

	// Empieza el juego sólo si se setearon bien los parámetros
	if (this.roundTime > 0 && this.cardTypes > 0 && this.players.length > 0) {
		this.currentState = this.prepare;
	}
	this.init(this.container);
},

/**
 *	Crea la pantalla con el tablero para empezar a jugar.
 */
createGameScreen: function() {
	var screen = document.createElement("div"),
		secTurn = document.createElement("section"),
		pTurnName = document.createElement("p"),
		pTurnTimer = document.createElement("p"),
		secStatus = document.createElement("section"),
		artBoard = document.createElement("article"),
		pStatus = document.createElement("p"),
		navGame = document.createElement("nav"),
		pBtnBack = document.createElement("p"),
		btnBack = document.createElement("button");

	screen.setAttribute("class", "screen-game");

	pTurnName.setAttribute("id", this.turnName);
	pTurnTimer.setAttribute("id", this.turnTimer);
	secTurn.setAttribute("class", "sec-turn");
	secTurn.appendChild(pTurnName);
	secTurn.appendChild(pTurnTimer);

	artBoard.setAttribute("id", this.board);

	pStatus.setAttribute("id", this.statusMsg);
	secStatus.setAttribute("class", "sec-status-msg")
	secStatus.appendChild(pStatus);

	btnBack.innerHTML = "Volver al menú";
	btnBack.addEventListener("click", function() {
		Memotest.currentState = Memotest.finished;
		Memotest.init(Memotest.container);
	});
	pBtnBack.appendChild(btnBack)
	navGame.appendChild(pBtnBack);
	navGame.setAttribute("id", this.navGame);

	screen.appendChild(secTurn);
	screen.appendChild(artBoard);
	screen.appendChild(secStatus);
	screen.appendChild(navGame);

	this.level = 0;
	return screen;
},

/**
 *	Pasa al siguiente nivel.
 */
nextLevel: function() {
	var btnNext = document.getElementById(this.btnNext);

	// Quitar el botón de siguiente nivel
	if (btnNext) {
		btnNext.parentNode.removeChild(btnNext);
	}

	if (this.level < 4) {
		this.level++;
	}

	this.startGame();
},

/**
 *	Inicializa el tablero
 *	y devuelve la cantidad de filas y columnas.
 */
setupBoard: function() {
	var size = this.level < 4 
		? Math.pow(this.level + 2, 2) 
		: 36;

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
 *	Genera una tarjeta con un tipo entre 1 y cardTypes,
 *	ya que el 0 es el comodín.
 */
generateCard: function() {
	var card = new this.Card();
	card.type = Math.trunc(Math.random() * (this.cardTypes)) + 1;
	return card;
},

/**
 *	Mezcla aleatoriamente los elementos de un Array.
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
 *	Inicializa los jugadores, la tabla y comienza el juego.
 */
startGame: function() {
	var rows, cols,
		board = document.createElement("table"),
		artBoard = document.getElementById(this.board),
		statusMsg = document.getElementById(this.statusMsg);

	this.players.forEach(function(element, index) {
		element.timeLeft = Math.trunc(Memotest.roundTime / Memotest.players.length);
		element.flipped = 0;
		element.found = 0;
		element.playing = true;
	});

	[rows, cols] = this.setupBoard();

	// Quitar la tabla anterior
	while (artBoard.firstChild) {
		artBoard.removeChild(artBoard.firstChild);
	}
	board.setAttribute("class", "tbl-board");

	for (var i = 0; i < rows; i++) {
		var tr = document.createElement("tr");
		for (var j = 0; j < cols; j++) {
			let td = document.createElement("td"),
				img = document.createElement("img"),
				index = i * cols + j;
			
			td.setAttribute("id", "card-" + (index));
			td.setAttribute("class", "card card-down");

			td.addEventListener("click", function() {
				Memotest.play(index)
			});
			
			img.setAttribute("src", "images/facedown.png");
			img.setAttribute("alt", "-");
			td.appendChild(img);
			
			tr.appendChild(td);
		}
		board.appendChild(tr);
	}

	artBoard.appendChild(board);

	statusMsg.innerHTML = "¡Comienza el juego!<br>"
			+ "Estás en el nivel " + this.level;

	this.currentState = this.playing;
	this.currentPlayer = -1;
	this.nextTurn();
},

/**
 *	Inicializa el contador para los turnos.
 */
startTimer: function() {
	if (this.currentState == this.playing) {
		var player = this.players[this.currentPlayer],
			statusMsg = document.getElementById(this.statusMsg),
			turnTimer = document.getElementById(this.turnTimer),
			minutos, segundos;

		if (player.timeLeft <= 0) {
			statusMsg.innerHTML = "¡" + player.name + " (" 
				+ (this.currentPlayer + 1) + ") se quedó sin tiempo!";
			player.playing = false;
			if (this.playersPlaying() > 0) {
				this.lostTurn();
			} else {
				this.nextTurn();
			}
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
 *	@return la cantidad de jugadores activos en la ronda actual.
 */
playersPlaying: function() {
	var playing = 0;
	this.players.forEach(function(element, index) {
		if (element.playing) {
			playing++;
		}
	});
	return playing;
},

/**
 *	Pasa al siguiente turno.
 */
nextTurn: function() {
	var btnTurn = document.getElementById(this.btnTurn),
		player, i;
	
	// Quitar el botón "pasar turno"
	if (btnTurn) {
		btnTurn.parentNode.removeChild(btnTurn);
	}

	this.facedownFlipped();

	// Pasar de turno
	this.currentPlayer = (this.currentPlayer + 1) % this.players.length;
	
	// Chequear que el jugador está en juego
	player = this.players[this.currentPlayer],
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
			+ (this.currentPlayer + 1) + ")";

		document.getElementById(this.statusMsg).innerHTML =
			"Ahora es el turno de " + player.name + " (" 
			+ (this.currentPlayer + 1) + ")";

		this.currentState = this.playing;

		clearInterval(this.timer);
		this.startTimer();
		this.timer = setInterval(Memotest.startTimer.bind(Memotest), 1000);
	} else {
	// Ningún jugador está en juego
		this.endGame(false);
	}
},

/**
 *	Realiza una jugada (acción del jugador al hacer click en una tarjeta).
 */
play: function(cardIndex) {
	if (this.currentState == this.playing) {

		var currentCard, lastCard,
			player = this.players[this.currentPlayer];

		// Si facedownTime no llegó a dar vuelta las tarjetas luego de pasar el turno
		if (this.cardsFlipped.length > 1) {
			clearTimeout(this.facedownTime);
			this.facedownFlipped();
		}

		this.faceup(cardIndex);

		currentCard = this.cards[cardIndex];

		// Si dio vuelta un comodín
		if (currentCard.type == 0) {
			this.players[this.currentPlayer].found++;
			// Agregar la tarjeta a la lista de encontradas
			this.removeFromArray(this.cardsFlipped, cardIndex);
			this.found(cardIndex);
			document.getElementById(this.statusMsg).innerHTML =
				"¡" + player.name + " (" + (this.currentPlayer + 1) + ")"
				+ " encontró un comodín!";
		}
		// Si es la segunda tarjeta que da vuelta
		if (this.cardsFlipped.length > 1) {
			
			lastCard = this.cards[this.cardsFlipped[0]];
			
			// Encontró un par
			if (currentCard.type == lastCard.type) {
				this.players[this.currentPlayer].found++;
				this.flippedToFound();
				document.getElementById(this.statusMsg).innerHTML =
				"¡" + player.name + " (" + (this.currentPlayer + 1) + ")"
				+ " encontró un par!";
			
			// Dio vuelta dos tarjetas que no hicieron par
			} else {
				
				// Hay más jugadores activos, pierde el turno
				if (this.playersPlaying() > 1) {
					this.lostTurn();
				
				// Una sola persona jugando
				} else {
					// Dar un segundo para que se vea la tarjeta
					this.facedownTime = setTimeout(Memotest.facedownFlipped.bind(Memotest), 1000);
				}
				return;
			}
		}

		// Chequear si se dieron vuelta todas las tarjetas
		if (this.cardsFound.length == this.cards.length) {
			this.endGame(true);
		}
	}
},

/**
 *	El jugador actual pierde el turno
 */
lostTurn: function() {
	// Detener el tiempo (wow!)
	clearInterval(this.timer);
	this.currentState = this.prepare;

	var pBtnTurn = document.createElement("p"),
		btnTurn = document.createElement("button"),
		navGame = document.getElementById(this.navGame),
		statusMsg = document.getElementById(this.statusMsg);
	
	btnTurn.setAttribute("id", this.btnTurn);
	btnTurn.innerHTML = "Pasar turno";
	btnTurn.addEventListener("click", Memotest.nextTurn.bind(Memotest));
	pBtnTurn.appendChild(btnTurn);
	navGame.appendChild(pBtnTurn);

	statusMsg.innerHTML = '¡Perdiste el turno!<br>Hacé click en "Pasar turno" para continuar';
},

/**
 *	Voltear boca arriba una tarjeta.
 */
faceup: function(cardIndex) {
	var card = this.cards[cardIndex],
		td = document.getElementById("card-" + cardIndex),
		img = td.firstChild;
	
	// No intentar dar vuelta una tarjeta boca arriba	
	if (!card.flipped) {
		card.flipped = true;
		this.cardsFlipped.push(cardIndex);
		// Esta parte es gráfica y debería separarse del modelo
		td.setAttribute("class", "card card-up card-selected");
		
		img.setAttribute("alt", card.type);
		img.setAttribute("src", "images/" + card.type + ".png");

		return true;
	} else {
		return false;
	}
},

/**
 *	Voltear boca abajo una tarjeta.
 */
facedown: function(cardIndex) {
	var card = this.cards[cardIndex],
		td = document.getElementById("card-" + cardIndex),
		img = td.firstChild;
	
	// No intentar dar vuelta una tarjeta boca abajo
	if (card.flipped) {
		card.flipped = false;
		this.removeFromArray(this.cardsFlipped, cardIndex);
		// Esta parte es gráfica y debería separarse del modelo
		td.setAttribute("class", "card card-down");
		
		img.setAttribute("alt", "-");
		img.setAttribute("src", "images/facedown.png");
		
		return true;
	} else {
		return false;
	}
},

/**
 *	Agrega una tarjeta a la lista de encontradas
 */
found: function(cardIndex) {
	var td = document.getElementById("card-" + cardIndex);
	this.cardsFound.push(cardIndex);
	td.setAttribute("class", "card card-up card-found");
},

/**
 *	Voltear boca abajo todas las tarjetas del turno actual.
 */
facedownFlipped: function() {
	// Quitar las tarjetas dadas vuelta de la lista del turno actual
	var cardIndexes = this.cardsFlipped.splice(0, this.cardsFlipped.length);
	
	cardIndexes.forEach(function(element, index) {
		Memotest.facedown(element);
	});
},

/**
 *	Agregar el par encontrado a la lista.
 */
flippedToFound: function() {
	// Quitar las tarjetas dadas vuelta de la lista del turno actual
	var cardIndexes = this.cardsFlipped.splice(0, this.cardsFlipped.length);
	
	cardIndexes.forEach(function(element, index) {
		Memotest.found(element);
	});
},

/**
 *	Termina el juego.
 */
endGame: function(win) {
	var winners = [], 
		maxFound = -1,
		statusMsg = document.getElementById(this.statusMsg),
		statusString = "";

	this.players.forEach(function(element, index) {
		if (element.found >= maxFound) {
			if (element.found > maxFound) {
				winners = [];
			}
			maxFound = element.found;
			var player = Object.assign({}, element);
			player.name += " (" + (index + 1) + ")";
			winners.push(player);
		}
	});

	// Permitir pasar al siguiente nivel
	if (win) {
		var pBtnNext = document.createElement("p");
			btnNext = document.createElement("button");
			navGame = document.getElementById(this.navGame);

		btnNext.innerHTML = "Siguiente nivel";
		btnNext.setAttribute("id", this.btnNext);
		btnNext.addEventListener("click", Memotest.nextLevel.bind(Memotest));
		pBtnNext.appendChild(btnNext);
		navGame.appendChild(pBtnNext);
	}

	// Un jugador
	if (this.players.length <= 1) {
		if (win) {
			statusString = "¡Ganaste la ronda!";
		} else {
			statusString = "¡Te quedaste sin tiempo!";
		}
		statusString += "<br><br>Tus puntos son: " + winners[0].found;

	// Más de un jugador
	} else {
		if (win) {
			var i = 0;
			statusString = "";
			while (i < winners.length) {
				statusString += winners[i].name + "<br>";
				i++;
			}

			// Hubo más de un ganador (empate de puntos)
			if (i > 1) {
				statusString = "Ganaron en esta ronda:<br>" + statusString;
			} else {
				statusString = "Ganó en esta ronda:<br>" + statusString;
			}

		} else {
			statusString = "¡Se les acabó el tiempo a todos los jugadores!<br>";
		}

		statusString += "<br>Puntos:<br>";

		this.players.forEach(function(element, index) {
			statusString += element.name + " (" + (index + 1) + ") - "
					+ element.found + " puntos<br>";
		});

	}

	statusMsg.innerHTML = statusString;
	clearInterval(this.timer);
	this.currentState = this.finished;
},

/**
 *	Función que por alguna razón no está en Javascript.
 *	Removes from <em>array</em> the first <em>element</em> found.
 *	@return the element spliced from the original array,
 *	or <b>null</b> if the element wasn't found.
 */
removeFromArray: function(array, element) {
	var found = false,
		i = 0;
	while (i < array.length && !found) {
		if (array[i] === element) {
			found = true;
		}
		i++;
	}
	if (found) {
		return array.splice(i-1, 1)[0];
	} else {
		return null;
	}
}

}