<?php
/*
Plugin Name: DOP Shortcodes
Version: 1.2
Plugin URI: http://dopdemo.net/wp/dop-shortcodes
Description: This is a collections of shortcodes we use in our themes. We always accept feedback and constructive criticism so if you have something to say please use the support forum.
Author: Dot on Paper
Author URI: http://www.dotonpaper.net

Change log:
	
	1.2 (2012-§0-03)
            
            * IE Interactive Elements icons bug fixed.
	
	1.1 (2012-07-25)
            
            * Image Loader paths fixed.
 
	1.0 (2012-07-19)
	
            * Initial release.
		
Installation: Upload the folder dopshortcodes from the zip file to "wp-content/plugins/" and activate the plugin in your admin panel or upload dopshortcodes.zip in the "Add new" section.
*/

    include_once "dopshortcodes-frontend.php";
        
    if (is_admin()){// If admin is loged in admin init administration panel.
        if (class_exists("DOPShortcodesBackEnd")){
            $DOPShortcodes_pluginSeries = new DOPShortcodesBackEnd();
        }
    }
    else{// If you view the WordPress website init the gallery.
        if (class_exists("DOPShortcodesFrontEnd")){
            $DOPShortcodes_pluginSeries = new DOPShortcodesFrontEnd();
        }
    }
        
?>