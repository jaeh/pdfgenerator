<?php
/*
Plugin Name: Bitcoind Book Generator
Plugin URI: http://bwb.is/free-speech
Description: A Plugin that allows you to generate pdfs from sourcecode.
Version: 1.0
Author: Jascha Ehrenreich - BitcoinersWithoutBorders
Author URI: http://jascha.bwb.is
*/

//*********** for install/uninstall actions (optional) ********************//

register_deactivation_hook(__FILE__, 'bwb_bitcoind_book_uninstall');

function bwb_bitcoind_book_uninstall() {

  if(get_option('pdf_source_dir')) :
     delete_option('pdf_source_dir');
  endif;
}
//*********** end of install/uninstall actions (optional) ********************//

// create custom plugin settings menu
add_action('admin_menu', 'bwb_bitcoind_book_create_menu');

function bwb_bitcoind_book_create_menu() {

  //create new top-level menu
  add_menu_page('Bitcoind Book', 'Bitcoind Book', 'administrator', __FILE__, 'bwb_bitcoind_book_settings_page', plugins_url('/images/icon.png', __FILE__));

  //call register settings function
  add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
  //register our settings
  register_setting( 'bwb_bitcoind_book-settings-group', 'formats' );
}

function bwb_bitcoind_book_settings_page() {
?>
<div class="wrap">
  <h2>Bitcoind Book Settings</h2>

  <form method="post" action="options.php">
      <?php settings_fields( 'bwb_bitcoind_book-settings-group' ); ?>
      <?php do_settings_sections( 'bwb_bitcoind_book-settings-group' ); ?>
      <table class="form-table">
        <tr valign="top">
          <td>Source Directory:</td>
          <td><input type="text" name="pdf_source_dir" value="<?php echo esc_attr(get_option('pdf_source_dir')) ?>" /></td>
        </tr>
      </table>
      <?php submit_button(); ?>
  </form>
</div>
<?php } ?>
