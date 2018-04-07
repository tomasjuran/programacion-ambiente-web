# Sistema de carga de peliculas

Permite administrar un catalogo de peliculas

## Instalacion

Copie el archivo de configuracion de ejemplo y ponga los datos de su base de datos:

```
cp config.php.sample config.php
vim config.php
```

A continuacion, cree la base de datos con los scripts que se encuentran en el directorio `sql/<ultima_version>/nueva`.

Para esto, ejecute los scripts en orden numerico

## Actualizacion

Ejecute los scripts que se encuentran en el directorio `sql/<ultima_version>/migration`.

Para esto, ejecute los scripts en orden numerico. Estos scripts suponen que usted actualiza desde la version estrictamente
anterior. Si no es asi, actualice de forma incremental hasta la ultima.

## Creacion de version

Cuando se genera una nueva version en la carpeta `sql/<nueva_version>/*.sql`, numerar los scripts
a partir del codigo `001_`, dejando libre el codigo `000_` para una creacion nueva de la base
de una version anterior.