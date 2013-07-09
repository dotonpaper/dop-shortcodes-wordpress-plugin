<?php
/*
Plugin Name: DOP Shortcodes (WordPress Plugin)
Version: 1.0
Plugin URI: 
Description: 
Author: Dot on Paper
Author URI: http://www.dotonpaper.net

Change log:
	
	1.0 (2012-07-15)
	
		* Initial release.
		
Installation: Upload the folder dopshortcodes from the zip file to "wp-content/plugins/" and activate the plugin in your admin panel or upload dopshortcodes.zip in the "Add new" section.
*/

    include_once "dopshortcodes-frontend.php";
        
    if (is_admin()){// If admin is loged in admin init administration panel.
        if (class_exists("DOPShortcodesBackEnd")){
            $DOPBSP_pluginSeries = new DOPShortcodesBackEnd();
        }
    }
    else{// If you view the WordPress website init the gallery.
        if (class_exists("DOPShortcodesFrontEnd")){
            $DOPBSP_pluginSeries = new DOPShortcodesFrontEnd();
        }
    }
    
?>