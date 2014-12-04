<?php
/*
Plugin Name: Municipal Corporation
Plugin URI: http://www.oscarperez.es/wordpress-plugins/opg_concejales.zip
Description: 
Author: Oskar Pérez
Author URI: http://www.oscarperez.es/
Version: 1.0
License: GPLv2
*/
?>
<?php

    /* Con este código, se crea una linea en el menú de Administración */
    function opg_show_menu_concejal(){
        add_menu_page('Municipal Corporation','Municipal Corporation','manage_options','plugin_opg_concejal','opg_plugin_concejal_show_form_in_wpadmin', plugins_url('images/major.png', __FILE__));
        //le hemos añadido al menú una imagen
    }
    add_action( 'admin_menu', 'opg_show_menu_concejal' );


    //Hook al activar y desactivar el plugin
    register_activation_hook( __FILE__, 'opg_plugin_concejal_activate' );
    register_deactivation_hook( __FILE__, 'opg_plugin_concejal_deactivate' );


    // Se crea la tabla al activar el plugin
    function opg_plugin_concejal_activate() {
        global $wpdb;
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'opg_plugin_concejal` 
            ( `idConcejal` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
              `name` VARCHAR( 255 ) NOT NULL , 
              `description` text )';
        $wpdb->query($sql);
    }

    // Se borra la tabla al desactivar el plugin
    function opg_plugin_concejal_deactivate() {
        global $wpdb;
        $sql = 'DROP TABLE `' . $wpdb->prefix . 'opg_plugin_concejal`';
        $wpdb->query($sql);
    }





    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        F U N C I O N E S   D E   A C C E S O   A   B A S E   D E   D A T O S
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    //función que guarda en base de datos la información introducida en el formulario
    function opg_concejal_save($name, $description)
    {
        global $wpdb;
        if (!( isset($name) && isset($description) )) {
            _e('cannot get \$_POST[]');
            exit;
        }

        $save_or_no = $wpdb->insert($wpdb->prefix . 'opg_plugin_concejal', array(
                'idConcejal' => NULL, 'name' => esc_js(trim ($name)), 'description' => trim ($description),
            ),
            array('%d', '%s', '%s' )
        );
        if (!$save_or_no) {
            _e('<div class="updated"><p><strong>Error. Please install plugin again</strong></p></div>');
            return false;
        }
        else{
            _e('<div class="updated"><p><strong>Concejal stored in database</strong></p></div>');
        }
        return true;
    }


    //función que borra un teléfono de la base de datos
    function opg_concejal_remove($id)
    {
        global $wpdb;
        if ( !isset($id) ) {
            _e('cannot get \$_GET[]');
            exit;
        }

        $delete_or_no = $wpdb->delete($wpdb->prefix . 'opg_plugin_concejal', array('idConcejal' => $id), array( '%d' ) );
        if (!$delete_or_no) {
            _e('<div class="updated"><p><strong>Error. Please install plugin again</strong></p></div>');
            return false;
        }
        else{
            _e('<div class="updated"><p><strong>Concejal deleted to database</strong></p></div>');
        }
        return true;
    }

    //función para actualizar un teléfono
    function opg_concejal_update($id, $name, $description)
    {
        global $wpdb;
        if (!( isset($name) && isset($description) )) {
            _e('cannot get \$_POST[]');
            exit;
        }

        $update_or_no = $wpdb->update($wpdb->prefix . 'opg_plugin_concejal', 
            array('name' => esc_js(trim ($name)), 'description' => trim ($description)),
            array('idConcejal' => $id),
            array('%s', '%s')
        );
        if (!$update_or_no) {
            _e('<div class="updated"><p><strong>Error. Please install plugin again</strong></p></div>');
            return false;
        }
        else{
            _e('<div class="updated"><p><strong>Concejal updated in database</strong></p></div>');
        }
        return true;
    }


    //función que recupera un telefono usando el ID
    function opg_concejal_getId($id)
    {
        global $wpdb;
        $row1 = $wpdb->get_row("SELECT name, description  FROM " . $wpdb->prefix . "opg_plugin_concejal  WHERE idConcejal=".$id);
        return $row1;
    }


    //función que recupera los concejales guardados de la base de datos
    function opg_concejal_getData()
    {
        global $wpdb;

        $records = $wpdb->get_results( 'SELECT idConcejal, name, description FROM ' . $wpdb->prefix . 'opg_plugin_concejal ORDER BY idConcejal' );
        if (count($records)>0){
?>
            <hr style="width:94%; margin:20px 0">
	        <h2>Municipal corporation</h2>
            <table class="wp-list-table widefat manage-column" style="width:95%">            
             <thead>
                <tr>
                    <th scope="col" id="description" class="manage-column" style=""><span>Name</span></a></th>
                    <th scope="col" id="description" class="manage-column" style=""><span>Description</span></a></th>
                    <th scope="col" id="description" class="manage-column" style=""><span>Edit</span></a></th>
                    <th scope="col" id="description" class="manage-column" style=""><span>Delete</span></a></th>
                </tr>
             </thead>
             <tbody>
<?php
            $cont = 0;
            foreach ( $records as $record ) {
                $cont++;
                if ($cont%2 ==1){ echo '<tr class="alternate">'; }
                else{ echo '<tr>'; }
?>
                    <td><?php echo( $record->name ); ?></td>
                    <td><?php echo( nl2br($record->description) ); ?></td>
                    <td><a href="admin.php?page=plugin_opg_concejal&amp;task=edit_concejal&amp;id=<?php echo( $record->idConcejal ); ?>">Edit</a></td>
                    <td><a href="admin.php?page=plugin_opg_concejal&amp;task=remove_concejal&amp;id=<?php echo( $record->idConcejal ); ?>">Delete</a></td>                    
                </tr>
<?php                
            }
        }

?>
             </tbody>
            </table>
<?php
        return true;
    }



	/*
	   F U N C I O N   Q U E   S E   E J E C U T A   A L   A C C E D E R   A L   P L U G I N   D E S D E   A D M I N I S T R A C I O N
       La función la definimos en la llamada add_menu_page()
	*/
	function opg_plugin_concejal_show_form_in_wpadmin(){
 
        $valueInputDesc = "";
        $valueInputName  = "";
        $valueInputId    = "";

	    echo("<div class='wrap'><h2>Add a Concejal</h2></div>"); 

    	if(isset($_POST['action']) && $_POST['action'] == 'salvaropciones'){

            //si el input idConcejal (hidden) está vacio, se trata de un nuevo registro
            if( strlen($_POST['idConcejal']) == 0 ){
                //guardamos el teléfono
                opg_concejal_save($_POST['name'], $_POST['description']);
            }
            else{
                opg_concejal_update($_POST['idConcejal'], $_POST['name'], $_POST['description']);
            }   
	    }
        else{
            //recuperamos la tarea a realizar (edit o delete)
            if (isset($_GET["task"]))
                $task = $_GET["task"]; //get task for choosing function
            else
                $task = '';
            //recuperamos el id del telefono
            if (isset($_GET["id"]))
                $id = $_GET["id"];
            else
                $id = 0;


            switch ($task) {
                case 'edit_concejal':
                    $row = opg_concejal_getId($id);
                    $valueInputDesc  = $row->description;
                    $valueInputName  = $row->name;
                    $valueInputId    = $id;
                    break;
                case 'remove_concejal':
                    opg_concejal_remove($id);
                    break;
                default:
                    break;
            }
        }
?>
        <form method='post' action='options-general.php?page=plugin_opg_concejal' name='opgPluginAdminForm' id='opgPluginAdminForm'>
            <input type='hidden' name='action' value='salvaropciones'> 
            <table class='form-table'>
                <tbody>
                    <tr>
                        <th><label for='name'>Name</label></th>
                        <td>
                            <input type='text' name='name' id='name' placeholder='Enter a name' value="<?php echo $valueInputName ?>" style='width: 300px'>
                        </td>
                    </tr>
                    <tr>
                        <th><label for='description'>Description</label></th>
                        <td>
                            <textarea name="description" id="description" placeholder='Enter a description' style='width: 500px;' rows=4><?php echo $valueInputDesc ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style='padding-left:140px'>
                            <input type='submit' value='Send information'>
                            <input type='hidden' name="idConcejal" value="<?php echo $valueInputId ?>">
                        </td>
                    </tr>
                </tbody>
            </table>        
        </form>

<?php
        //se muestra el listado de todos los teléfonos guardados
        opg_concejal_getData();
?>        
<?php }?>