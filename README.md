Corporación Municipal
======================

Developer: Óscar Pérez (www.oscarperez.es)
Tested up to: 6.6
Stable tag: 2.0.0
License: GPLv2 or later

== Descripción ==

Plugin de WordPress para gestionar y mostrar el listado de concejales de una
corporación local (nombre, cargo, email, foto y biografía).

- Panel de administración con alta, edición y borrado de concejales.
- Shortcode `[corporacion_municipal]` para mostrar el listado en cualquier
  página o entrada, como una cuadrícula de tarjetas con foto, cargo y email.
  Si un concejal tiene biografía, la tarjeta abre un modal con el texto
  completo al hacer clic (o con Intro/Espacio desde el teclado).
- Atributo opcional `columnas` (1 a 4, por defecto 3):
  `[corporacion_municipal columnas="4"]`.

== Estructura de ficheros ==

- `corporacion-municipal.php` — fichero principal del plugin.
- `uninstall.php` — elimina la tabla de base de datos al desinstalar el plugin.
- `includes/db.php` — acceso a base de datos (creación de tabla vía `dbDelta`, CRUD).
- `includes/admin.php` — menú, formulario y listado de administración.
- `includes/public.php` — shortcode y carga de assets públicos.
- `includes/views/` — plantillas PHP usadas por admin.php y public.php.
- `assets/css/`, `assets/js/` — estilos y scripts de administración y públicos.

== Base de datos ==

Tabla `{prefijo}opg_plugin_concejal` (se mantiene el nombre histórico para no
perder datos de instalaciones anteriores):

- `idConcejal` INT, autoincremental.
- `name` VARCHAR(255).
- `email` VARCHAR(100).
- `description` TEXT (cargo).
- `biography` TEXT (opcional).
- `orden` INT (orden de aparición en el listado).
- `image` VARCHAR(255) (URL de la foto).

== Instalación ==

1. Copia la carpeta `corporacion-municipal` en `wp-content/plugins`.
2. Activa el plugin desde el panel de WordPress.
3. Ve a "Corporación Municipal" en el menú de administración y añade los concejales.
4. Inserta el shortcode `[corporacion_municipal]` donde quieras mostrar el listado.

== Changelog ==

= 2.0.0 =
Reescritura completa del plugin:
- Nuevo listado público mediante el shortcode `[corporacion_municipal]`
  (el plugin antes solo tenía backend de administración).
- Reestructuración en ficheros `includes/`, `includes/views/` y `assets/`.
- Corregidas vulnerabilidades: inyección SQL en la consulta por id, falta de
  nonces/CSRF en el formulario y en el borrado, y falta de sanitizado/escapado
  de entradas y salidas.
- El botón "Elegir imagen" usa ahora el selector de medios moderno de
  WordPress (`wp.media`); antes no hacía nada porque le faltaba el JavaScript.
- Los scripts y estilos ya no se cargan en todo el sitio: los de
  administración solo se cargan en la pantalla del plugin, y los públicos
  solo cuando se usa el shortcode.
- Creación de tabla mediante `dbDelta` (actualiza instalaciones existentes
  sin perder datos) y borrado de la tabla movido a `uninstall.php`.

= 1.1.0 =
Se añade el campo email al registro del concejal. En el listado de
concejales se cambian los literales "Modificar" y "Borrar" por dos imágenes.
Antes de eliminar el registro se pide confirmación con un `confirm` de
JavaScript.

= 1.0.0 =
Primera versión operativa.
