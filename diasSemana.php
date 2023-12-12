<?php
/**
 * @package Hello_Days
 * @version 1.0.0
 */
/*
Plugin Name: Hello Days
Plugin URI: http://wordpress.org/plugins/hello-days/
Description: Plugin que cambia el estilo de los días de la semana en el contenido y el titulo
Author: Lucia Balsa
Version: 1.0.0
Author URI: http://lucia.balsa/
*/
function inicioPlugin()
{
    createTable();
    insertData();
}


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

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'jueves')
    );

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'viernes')
    );

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'sábado')
    );

    $wpdb->insert(
        $table_name,
        array('dia_semana' => 'domingo')
    );
}
add_action('plugin_loaded', 'inicioPlugin');


// Función que cambia estilo días de la semana en el contenido
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


// Función que cambia estilo días de la semana en el titulo
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

