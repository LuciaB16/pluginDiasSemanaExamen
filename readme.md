# PLUGIN DIAS SEMANA
En este código, podemos ver como creamos un plugin para Wordpress.

En este caso, el plugin detecta el día de la semana (que previamente metimos
en la base de datos), y cambia el estilo de la palabra, poniéndola en negrita y de color azul.


**1. Funcion inicioPlugin()**
```
function inicioPlugin()
{
    createTable();
    insertData();
}
```

Esta función es de inicialización y realiza las siguientes acciones:

- `createTable();` -> Crea una tabla en la base de datos (dicha tabla la explicaremos 
más adelante).


- `insertData();` -> Inserta datos en la tabla recién creada.

------

**2. Funcion createTable()**
```
function createTable()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'dias_semana';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
       id mediumint(10) NOT NULL AUTO_INCREMENT,
       dia_semana varchar(255) NOT NULL,
       PRIMARY KEY  (id)
   ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
```

Esta función es responsable de crear una tabla en la base de datos de WordPress.
La tabla se utilizará para almacenar los  días de la semana.

Podemos explicar línea por línea este código:
- `global $wpdb;` ->  Declara la variable global de WordPress que permite interactuar 
con la base de datos.

- `$table_name = $wpdb->prefix . 'dias_semana';` -> Construye el nombre de la tabla 
con el prefijo de la base de datos de WordPress.

- `$charset_collate = $wpdb->get_charset_collate();` -> Obtiene el conjunto de caracteres 
y la configuración de la base de datos de WordPress.

- `$sql = "CREATE TABLE $table_name (
id mediumint(10) NOT NULL AUTO_INCREMENT,
dia_semana varchar(255) NOT NULL,
PRIMARY KEY  (id)) $charset_collate;";` -> Construye la consulta SQL para crear la tabla.

- `require_once(ABSPATH . 'wp-admin/includes/upgrade.php');` -> Incluye el archivo de 
actualización de la base de datos de WordPress.

- `dbDelta($sql);` -> Ejecuta la consulta SQL para crear la tabla.
------


**3. Funcion insertData()**
```
function insertData()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'dias_semana';
    $data_exists = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    if ($data_exists > 0) {
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
        createTable();
    }

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'lunes')
    );

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'martes')
    );

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'miércoles')
    );

    ......
}
add_action('plugin_loaded', 'inicioPlugin');

}
```

Esta función es responsable de insertar datos en la tabla 'dias_semana' .

Podemos explicar línea por línea este código (sin repetir lo ya explicado anteriormente):

- `$data_exists = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");` -> Comprueba si 
existen datos en la tabla.

- `if ($data_exists > 0) {` -> Si existen datos en la tabla, la elimina y la vuelve a crear.

- `$wpdb->insert($table_name,array('dia_semana' => 'lunes'));` -> Inserta datos en la tabla, en este caso,
los días de la semana. 

- `add_action('plugin_loaded', 'inicioPlugin');` -> Ejecuta la función inicioPlugin() 
(explicada anteriormente) cuando se carga el plugin.
------


**4. Funcion estilo_dias_contenido($contenido)**
```
function estilo_dias_contenido($contenido) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dias_semana';
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    foreach ($results as $result) {
        $array[] = $result->dia_semana;
        $array2[] = '<span style="color: blue; font-weight: bold;">' . $result->dia_semana . '</span>';
    }
    return str_replace($array, $array2, $contenido);
}
add_filter('the_content', 'estilo_dias_contenido');
```

Esta función es responsable de cambiar el estilo de los días de la semana en el 
contenido de las entradas de WordPress.

Podemos explicar línea por línea este código (sin repetir lo ya explicado anteriormente):

- `$results = $wpdb->get_results("SELECT * FROM $table_name");` -> Obtiene los datos de la tabla.

- `foreach ($results as $result) {` -> Recorre los datos obtenidos de la tabla.

- `$array[] = $result->dia_semana;` -> Almacena los datos en un array.

- `$array2[] = '<span style="color: blue; font-weight: bold;">' . $result->dia_semana . '</span>';` -> 
Almacena los datos en otro array, pero con el estilo que queremos.

- `return str_replace($array, $array2, $contenido);` -> Reemplaza los datos del array1 por 
los datos del array2 en el contenido de las entradas de WordPress.

- `add_filter('the_content', 'estilo_dias_contenido');` -> Ejecuta la función estilo_dias_contenido() 
(explicada anteriormente) cuando se carga el contenido de las entradas de WordPress.

------

**5. Funcion estilo_dias_titulo($titulo)**
```
function estilo_dias_titulo($titulo) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dias_semana';
    $results= $wpdb->get_results("SELECT * FROM $table_name");

    foreach ($results as $result) {
        $array[] = $result->dia_semana;
        $array2[] = '<span style="color: blue; font-weight: bold;">' . $result->dia_semana . '</span>';
    }
    return str_replace($array, $array2, $titulo);
}
add_filter('the_title', 'estilo_dias_titulo');
```

Esta función es responsable de cambiar el estilo de los días de la semana en el título de 
las entradas de WordPress.
Es exactamente igual que la función anterior, pero en este caso, se aplica al título de las entradas.