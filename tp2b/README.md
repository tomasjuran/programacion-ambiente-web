Para la instalación, modifique o cree el archivo /base/Parametros.xml con los parámetros correspondientes a su configuración de la Base de datos, usando como plantilla Parametros.xml.sample

*******************************************************************************

<parametros>
	<host>localhost</host>
	<user>root</user>
	<pass></pass>
	<base>paw</base>
</parametros>

*******************************************************************************

Luego, corra los scripts ubicados en la carpeta /sql/<#ejercicio> para crear las tablas correspondientes

*******************************************************************************

Finalmente, levante el servidor en este directorio y acceda a "index.php".