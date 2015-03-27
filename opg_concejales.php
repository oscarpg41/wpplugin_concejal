<?php
/*
Plugin Name: OPG Corporación MUnicipal
Plugin URI: http://www.oscarperez.es/wordpress-plugins/opg_concejales.zip
Description: 
Author: Oskar Pérez
Author URI: http://www.oscarperez.es/
Version: 1.1
License: GPLv2
*/
?>
<?php
<<<<<<< HEAD
=======

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
//Lo que hacemos es añadir los scripts necesarios para que el cargador de medios de wordpress se muestre
    function my_admin_scripts_photo_councilor() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_register_script('my-upload', WP_PLUGIN_URL.'/opg_concejales/opg_concejales.js', array('jquery','media-upload','thickbox'));
        wp_enqueue_script('my-upload');
    }
    function my_admin_styles_photo_councilor() {
        wp_enqueue_style('thickbox');
    }
    if (isset($_GET['page']) && $_GET['page'] == 'opg_concejales') {
        add_action('admin_print_scripts', 'my_admin_scripts_photo_councilor');
        add_action('admin_print_styles', 'my_admin_styles_photo_councilor');
    }
    // cargador de medios de wordpress
<<<<<<< HEAD
=======


>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
    //registramos el fichero js que necesitamos
    //wp_register_script('myPluginConcejalesScript', WP_PLUGIN_URL . '/opg_concejales/opg_concejales.js');
    wp_register_script('myPluginConcejalesScript', WP_PLUGIN_URL .'/opg_concejales/opg_concejales.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('myPluginConcejalesScript');    
<<<<<<< HEAD
=======


>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
    /* Con este código, se crea una linea en el menú de Administración */
    function opg_show_menu_concejal(){
        add_menu_page('Oscar Pérez Plugins','Oscar Pérez Plugins','manage_options','opg_plugins','opg_plugin_links_show_form_in_wpadmin', '', 110);
        add_submenu_page( 'opg_plugins', 'Municipal Corporation','Corporación Municipal', 'manage_options', 'opg_concejales', 'opg_plugin_concejal_show_form_in_wpadmin');
        remove_submenu_page( 'opg_plugins', 'opg_plugins' );  
    }
    add_action( 'admin_menu', 'opg_show_menu_concejal' );
    //Hook al activar y desactivar el plugin
    register_activation_hook( __FILE__, 'opg_plugin_concejal_activate' );
    register_uninstall_hook( __FILE__, 'opg_plugin_concejal_uninstall' );
    // Se crea la tabla al activar el plugin
    function opg_plugin_concejal_activate() {
        global $wpdb;
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'opg_plugin_concejal` 
            ( `idConcejal` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
              `name` VARCHAR( 255 ) COLLATE utf8_spanish_ci NOT NULL , 
              `email` VARCHAR( 100 ) COLLATE utf8_spanish_ci NOT NULL , 
              `description` text COLLATE utf8_spanish_ci NOT NULL,
              `biography` text COLLATE utf8_spanish_ci ,
              `image` VARCHAR( 140 ) NOT NULL ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci';
        $wpdb->query($sql);
    }
<<<<<<< HEAD
=======

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
    // Se borra la tabla al desisntalar el plugin
    function opg_plugin_concejal_uninstall() {
        global $wpdb;
        $sql = 'DROP TABLE `' . $wpdb->prefix . 'opg_plugin_concejal`';
        $wpdb->query($sql);
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        F U N C I O N E S   D E   A C C E S O   A   B A S E   D E   D A T O S
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    //función que guarda en base de datos la información introducida en el formulario
    function opg_concejal_save($name, $email, $description, $biography, $image)
    {
        global $wpdb;
        if (!( isset($name) && isset($description) )) {
            _e('cannot get \$_POST[]');
            exit;
        }
<<<<<<< HEAD
=======

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
        $save_or_no = $wpdb->insert($wpdb->prefix . 'opg_plugin_concejal', 
            array( 'idConcejal' => NULL, 'name' => esc_js(trim ($name)), 'email' => trim ($email), 'description' => trim ($description), 'biography' => trim ($biography), 'image' => trim ($image) ),
            array( '%d', '%s', '%s', '%s', '%s', '%s' )
        );
        if (!$save_or_no) {
            _e('<div class="updated"><p><strong>Error. Please install plugin again</strong></p></div>');
            return false;
        }
        else{
            _e('<div class="updated"><p><strong>Información del concejal guardada correctamente</strong></p></div>');
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
            _e('<div class="updated"><p><strong>Se ha borrado la información del concejal</strong></p></div>');
        }
        return true;
    }
    //función para actualizar un teléfono
    function opg_concejal_update($id, $name, $email, $description, $biography, $image)
    {
        global $wpdb;
        if (!( isset($name) && isset($description) )) {
            _e('cannot get \$_POST[]');
            exit;
        }
<<<<<<< HEAD
=======

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
        if ( isset($image) && (strlen($image)>0) ){
            $update_or_no = $wpdb->update($wpdb->prefix . 'opg_plugin_concejal', 
                array( 'name' => esc_js(trim ($name)), 'email' => trim ($email), 'description' => trim ($description), 'biography' => trim ($biography), 'image' => trim ($image) ),
                array( 'idConcejal' => $id ),
                array( '%s', '%s', '%s', '%s', '%s' )
            );
        }
        else{
            $update_or_no = $wpdb->update($wpdb->prefix . 'opg_plugin_concejal', 
                array( 'name' => esc_js(trim ($name)), 'email' => trim ($email), 'description' => trim ($description), 'biography' => trim ($biography) ),
                array( 'idConcejal' => $id ),
                array( '%s', '%s', '%s', '%s' )
            );
        }        
<<<<<<< HEAD
=======

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
        if (!$update_or_no) {
            _e('<div class="updated"><p><strong>Error. Please install plugin again</strong></p></div>');
            return false;
        }
        else{
            _e('<div class="updated"><p><strong>Información del concejal actualizada</strong></p></div>');
        }
        return true;
    }
    //función que recupera un telefono usando el ID
    function opg_concejal_getId($id)
    {
        global $wpdb;
        $row1 = $wpdb->get_row("SELECT name, email, description, biography, image  FROM " . $wpdb->prefix . "opg_plugin_concejal  WHERE idConcejal=".$id);
        return $row1;
    }
    //función que recupera los concejales guardados de la base de datos
    function opg_concejal_getData()
    {
        global $wpdb;
<<<<<<< HEAD
=======

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
        $records = $wpdb->get_results( 'SELECT idConcejal, name, email, description, biography, image FROM ' . $wpdb->prefix . 'opg_plugin_concejal ORDER BY idConcejal' );
        if (count($records)>0){
?>
            <hr style="width:94%; margin:20px 0">
            <h2>Corporacion municipal</h2>
            <table class="wp-list-table widefat manage-column" style="width:98%">            
             <thead>
                <tr>
                    <th scope="col" class="manage-column"><span>Nombre</span></th>
                    <th scope="col" class="manage-column"><span>Email</span></th>
                    <th scope="col" class="manage-column"><span>Cargo</span></th>
                    <th scope="col" class="manage-column"><span>&nbsp;</span></th>
                    <th scope="col" class="manage-column"><span>&nbsp;</span></th>
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
                    <td nowrap><?php echo( $record->email ); ?></td>
                    <td><?php echo( nl2br($record->description) ); ?></td>
                    <td><a href="admin.php?page=opg_concejales&amp;task=edit_concejal&amp;id=<?php echo( $record->idConcejal ); ?>"><img src="<?php echo WP_PLUGIN_URL.'/opg_concejales/img/modificar.png'?>" alt="Modificar"></a></td>
                    <td><a href="#"><img src="<?php echo WP_PLUGIN_URL.'/opg_aside/img/papelera.png'?>" alt="Borrar" id="<?php echo( $record->idConcejal ); ?>" class="btnDeleteCouncilor"></a></td>
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
 
        $valueInputDesc  = "";
        $valueInputName  = "";
        $valueInputId    = "";
        $valueInputEmail = "";
        $valueInputBio   = "";
        $valueInputImage = "";
<<<<<<< HEAD
        if(isset($_POST['action']) && $_POST['action'] == 'salvaropciones'){
=======


	    if(isset($_POST['action']) && $_POST['action'] == 'salvaropciones'){

>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
            //si el input idConcejal (hidden) está vacio, se trata de un nuevo registro
            if( strlen($_POST['idConcejal']) == 0 ){
                //guardamos el teléfono
                opg_concejal_save($_POST['name'], $_POST['email'], $_POST['description'], $_POST['biography'], $_POST['upload_image']);
            }
            else{
                opg_concejal_update($_POST['idConcejal'], $_POST['name'], $_POST['email'], $_POST['description'], $_POST['biography'], $_POST['upload_image']);
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
                    echo("<div class='wrap'><h2>Modificar información del concejal</h2></div>"); 
                    $row = opg_concejal_getId($id);
                    $valueInputDesc  = $row->description;
                    $valueInputName  = $row->name;
                    $valueInputId    = $id;
                    $valueInputEmail = $row->email;
                    $valueInputBio   = $row->biography;
                    $valueInputImage = $row->image;
                    break;
                case 'remove_concejal':
                    opg_concejal_remove($id);
                    break;
                default:
                    echo("<div class='wrap'><h2>Añadir un nuevo concejal</h2></div>"); 
                    break;
            }
        }
?>
        <form method='post' action='admin.php?page=opg_concejales' name='opgPluginAdminForm' id='opgPluginAdminForm'>
            <input type='hidden' name='action' value='salvaropciones'> 
            <table class='form-table'>
                <tbody>
                    <tr>
                        <th><label for='name'>Nombre</label></th>
                        <td>
                            <input type='text' name='name' id='name' placeholder='Introduzca el nombre del concejal' value="<?php echo $valueInputName ?>" style='width: 300px'>
                        </td>
                    </tr>
                    <tr>
                        <th><label for='name'>Email</label></th>
                        <td>
                            <input type='text' name='email' id='email' placeholder='Introduzca el email del concejal' value="<?php echo $valueInputEmail ?>" style='width: 300px'>
                        </td>
                    </tr>
                    <tr>
                        <th><label for='description'>Cargo</label></th>
                        <td>
                            <textarea name="description" id="description" placeholder='Introduzca el cargo del concejal' style='width: 95%;' rows=4><?php echo $valueInputDesc ?></textarea>
<<<<<<< HEAD
                        </td>
                    </tr>
                    <tr>
                        <th><label for='biography'>Biografía</label></th>
                        <td>
                            <textarea name="biography" id="biography" placeholder='Introduzca biografía del concejal (mínimo de cuatro líneas cada uno).' style='width: 95%;' rows=10><?php echo $valueInputBio ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for='url'>Foto</label></th>
                        <td>
                        <?php 
                            if (strlen($valueInputImage)>0){
                        ?>
                            <img src="<?php echo $valueInputImage ?>" width="150px" align="left" style="margin-right:3%">                         
                        <?php                                                         
                            }
                        ?>
                            <input type="text" name="upload_image" id="upload_image" value="" size='40' />
                            <input type="button" class='button-secondary' id="upload_image_button" value="Subir nueva imagen" />  
=======
>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
                        </td>
                    </tr>

                    <tr>
<<<<<<< HEAD
=======
                        <th><label for='biography'>Biografía</label></th>
                        <td>
                            <textarea name="biography" id="biography" placeholder='Introduzca biografía del concejal (mínimo de cuatro líneas cada uno).' style='width: 95%;' rows=10><?php echo $valueInputBio ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for='url'>Foto</label></th>
                        <td>
                        <?php 
                            if (strlen($valueInputImage)>0){
                        ?>
                            <img src="<?php echo $valueInputImage ?>" width="150px" align="left" style="margin-right:3%">                         
                        <?php                                                         
                            }
                        ?>
                            <input type="text" name="upload_image" id="upload_image" value="" size='40' />
                            <input type="button" class='button-secondary' id="upload_image_button" value="Subir nueva imagen" />  
                        </td>
                    </tr>

                    <tr>
>>>>>>> 61278696e6d728ec66555cd32ad3ba7ddba5c09a
                        <td colspan='2' style='text-align:center; padding-top: 50px'>
                            <input type='submit' value='Enviar'>
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