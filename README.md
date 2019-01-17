-Como se ha enfocado el proyecto:
En las especifícaciones del proyecto se pedía un sistema de gestión de reservas.

Dado que el alcance del proyecto podría ser muy extenso, se ha decidido acotar en ciertos puntos
para presentar una apliación 100% funcional en la cual se podría ya empezar a relizar reservas, tras configurar desde un seeder por parte del administrador, las sesiones u horarios de las obras que se van a realizar.
(En el proyecto ya aparecen algunas obras y sesiones configuradas como ejemplo para poder probarlo).

Se ha suprimido el sistema de gestión de usuarios: registro, login, validación de cuenta. Para
cada reserva se crea un nuevo usuario, con un formulario muy simple y fácil de rellenar. 

Se ha creado la entidad sesiones, que representa el horario disponible para cada día en el teatro.
Directamente se ha asignado la obra que se va a representar a la sesion como un simple campo string, se deja abierto poder ampliar este punto y crear la entidad obra y demás ampliaciones aplicables.

Únicamente se han declarado las funciones CRUD que se ha creído que se íban a necesitar en el proyecto.

Se ha usado la librería externa jquery fullcalendar para gestionar los eventos del calendario.

Se ha implementado sistema de bloqueos de una butaca, en el cual, mientras se tiene seleccionada una butaca, antes de clickar en reservar, queda bloqueada y aparece como no disponible para otro usuario que accediera a reservar en dicha sesión. Estas butacas se desbloquean automáticamente cada 10 minutos. 

Se envía un email informativo de la reserva realizada.


-Como instalar el proyecto
Aquí definiré diferentes puntos que son necesarios para la instalación del proyecto:

El proyecto usa laravel schedules, para la función de desbloquear butacas reservadas cada 10 min.
Por lo tanto será necesario pegar la siguiente línea, modificando la ruta al proyecto, en el archivo de gestión de cron. (crontab -e) 
* * * * * cd /ruta/a/tu/proyecto && php artisan schedule:run >> /dev/null 2>&1

Dejo aquí la configuración de un smtp para .env que está funcionando (es necesario configurar alguno pues se envian emails desde la aplicación):
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=pruebanrs1234@gmail.com
MAIL_PASSWORD=prueba1234
MAIL_ENCRYPTION=ssl

También hay un archivo de configuración en la ruta config/contants.php donde se pueden configurar diferentes variables como el nombre del teatro, numero de filas y columnas de la sala o minutos que se bloquea una butaca.

La aplicación además de las migraciones, también tiene varios seeders para simular ya obras y sesiones para poderlo probar.
