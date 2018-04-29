CREATE TABLE `posts` (
  `idpost` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `cuerpo` varchar(1000) DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `imagen` varchar(45) DEFAULT NULL,
  `tags` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idpost`)
);

CREATE TABLE `comentarios` (
  `idpost` int(11) NOT NULL,
  `idcomm` int(11) NOT NULL,
  `autor` varchar(60) NOT NULL,
  `cuerpo` varchar(300) DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpost`,`idcomm`),
  CONSTRAINT `fk_comentarios_1` FOREIGN KEY (`idpost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE
);