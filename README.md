nmx-test-devfs: Ejercicio de Evaluación Técnica
==========
Haciendo uso de cualquier framework, microframework o bibliotecas de terceros, desarrolla en
HTML+JS+PHP un sitio web que cumpla con todas las condiciones descritas a continuación:

1. Crear una página que permita subir gifs animados y almacenarlos en el servidor.
2. Crear una página que despliegue todos los gifs subidos en una cuadrícula.
3. Agregar un sistema de usuarios (registro/login).
4. Crear una página para usuarios (autenticados) que permita marcar los gifs como “aceptados” o “rechazados”.
5. Modificar la funcionalidad (2) para que únicamente despliegue los gifs marcados como “aceptados”.
6. Permitir, además de la vista en cuadrícula, un modo slideshow o carrusel.
7. Al dar clic en una imagen la debe mostrar en tamaño real en un lightbox.
8. Incluir la opción para compartir las imágenes de forma individual en al menos una red social.


DEMO: Versión en producción
==========
Una versión completamente funcional se pueder ver aqui:

[http://nmxtest.grapic.com.mx/](http://nmxtest.grapic.com.mx/)


BASE DE DATOS: Estructura
==========
![Schema](https://github.com/rafaellorey/nmx-test-devfs/raw/master/database/nmx_test_devfs_schema.jpg)


# INSTALACIÓN:

El sitio web funciona con un microframework que yo he desarrollado utilizando librerias ligeras de terceros, por lo que no necesita de ninguna instalación / configuración especial en el servidor web. Puede incluso funcionar en una distribución [XAMPP / LAMP](https://es.wikipedia.org/wiki/XAMPP)

## Requerimientos
 * Apache Version: 2.4
 * MySQL Version: 5.6
 * PHP Version: 5.5
  * Session Support: enabled

## Pasos de instalación
1. Ejecute el script para crear la base de datos: [SQL Dump](https://raw.githubusercontent.com/rafaellorey/nmx-test-devfs/master/database/nmx_test_devfs_backup.sql).
2. En su servidor de MySQL cree un usuario que tenga acceso a la base de datos creada "grapicco_nmx_test_devfs".
3. [Descargue todo el código fuente](https://github.com/rafaellorey/nmx-test-devfs/archive/master.zip) y copielo en la carpeta donde va a publicar el sitio (Incluye imagenes de prueba referenciadas por la base de datos).
4. Asegurese de que la carpeta "/Content/gifs/" tiene los permisos necesarios para que los archivos que se suban desde el sitio puedan ser guardados sin problemas.

## Archivos de configuración
1. El sitio cuenta con archivos de configuración que pueden manejar diferentes ambientes de publicación (Development / Production). Si usted solo maneja un ambiente utilice el que viene activo por defecto "development". Lo anterior se encuentra en el archivo "[/res/conf/config.ini](https://raw.githubusercontent.com/rafaellorey/nmx-test-devfs/master/res/conf/config.ini)" en ese mismo archivo se especifca la URL donde se esta publicando el sitio según el ambiente.
2. Los datos de conexión a la base de datos tambien estan segmentados por ambiente (Development / Production) y se encuentran en el archivo "[/res/conf/databases.ini](https://raw.githubusercontent.com/rafaellorey/nmx-test-devfs/master/res/conf/databases.ini)" actualicese con los datos del servidor de MySQL donde restauro al base datos (Paso 1.) y del usuario del Paso 2. 
 
 **NOTA:** Asegurese que el servidor de base de datos puede ser accesado por el servidor web donde esta publicando el sitio.
3. El sitio tiene la funcionalidad de enviar emails para lo cual esta configurado con una cuenta de gmail, en caso de querer configurar con su propia cuenta de email la configuración se establece en el archivo "[/res/conf/mailing.ini](https://raw.githubusercontent.com/rafaellorey/nmx-test-devfs/master/res/conf/mailing.ini)".


SERVICIOS: Web API
==========
El sitio web funciona con una [Web API](https://en.wikipedia.org/wiki/Web_API) simple que recibe peticiones por [POST](https://en.wikipedia.org/wiki/POST_(HTTP)) desde el cliente via AJAX, la respuesta es en formato JSON. Un ejemplo de llamado con JQuery seria. 

```javascript
$.post('wApi.php', { oper: 'login', mail: mail, pass: pass })
    .done(function( respuesta ) {                    
        if(respuesta.success){
            console.log("EXITO");
        }
        else { 
            console.log("ERROR: " + respuesta.error);
        }
    });
```

En el ejemplo anterior "[wApi.php](https://raw.githubusercontent.com/rafaellorey/nmx-test-devfs/master/wApi.php)" esta en la raíz del sitio y es la que contiene propieamente la "Web API", además podemos observar que envía 3 parámetros: `oper`, `mail` y `pass` el primer parámetro `oper` es el que indica la operación o SERVICIO que se esta solicitando. Los restantes 2 parámetros son requeridos por ese servicio `'login'` en especifico para funcionar. 

Por último la respuesta JSON se toma en la variable `respuesta` que contiene 2 propiedades: `success` un valor de tipo booleano (TRUE/FALSE) que indica el éxito de la operación y `error` de tipo string que detalla el error en caso de que no sea exitosa la operación.

La descripción completa de los servicios se muestra a continuación

Servicio | Descripción | Parámetros | Respuesta
--- | --- |  --- | ---
`oper: 'login'` | Inicio de sesión, requiere la dirección de correo electrónico y la contraseña | `mail: 'mail@mail.com'`, `pass: '1234'` | ```json {"success":false,"error":"Datos incorrectos, verifique."} ```
`oper: 'logout'` | Cierra sesión actual, no requiere parámetros |  | ```json {"success":false,"error":"Datos incorrectos, verifique."} ```
`oper: 'signin'` | Crea registro de usuario, envia email de bienvenida e inicia sesión | `nombre: 'Rafael López'`, `mail: 'mail@mail.com'`, `pass: '1234'` | ```json {"success":false,"error":"Ya existe una cuenta con ese Correo electrónico."} ```
`oper: 'gifupload'` | Guarda un archivo GIF animado en base de datos y fisicamente, requiere de un archivo | `fileName: "gifFile"` | ```json {"success":false,"error":"Datos incorrectos, verifique."} ```
`oper: 'passrecov'` | Recupera contraseña: genera una nueva contraseña y la envia por email, requiere la dirección de correo electrónico | `mail: 'mail@mail.com'` | ```json {"success":true,"error":""} ```
`oper: 'passchange'` | Actualiza contraseña: cambia la contraseña y envia email de confirmación, requiere el token de verificación y el nuevo password de la cuenta | `token: '1ab60d58d9e93f49'`, `pass: '1234'` | ```json {"success":true,"error":""} ```
`oper: 'mediaestatus'` | Cambia el estatus de un archivo GIF: 1 = Aceptado / 0 = rechazado, requiere el id del GIF y el valor del estatus (1 ó 0). Se necesita haber iniciado sesión para utilizar este servicio | `pk: 1`, `value: 1` | ```json {"success":false,"error":"Necesita iniciar sesión."} ```
