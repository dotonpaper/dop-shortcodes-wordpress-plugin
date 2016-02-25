<?php

/*
* Title                   : DOP Shortcodes (WordPress Plugin)
* Version                 : 1.2
* File                    : dopshortcodes-frontend.php
* File Version            : 1.1
* Created / Last Modified : 25 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2013 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : DOP Shortcodes Front End Class.
*/

    if (!class_exists("DOPShortcodesFrontEnd")){
        class DOPShortcodesFrontEnd{
            private $no_images = 0;
            private $no_tabs = 0;
            
            function DOPShortcodesFrontEnd(){// Constructor.
                add_action('wp_enqueue_scripts', array(&$this, 'addStyle'));
                add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
                add_filter('the_content', array(&$this, 'filter'));
                $this->init();
            }
            
            function addStyle(){
                wp_enqueue_style('DOPShortcodesStyleInteractiveElementsIcons',  plugins_url('/assets/gui/css/style-dopshortcodes-interactive-elements-icons.css', __FILE__));
                wp_enqueue_style('DOPShortcodesStyleSocialIcons',  plugins_url('/assets/gui/css/style-dopshortcodes-social-icons.css', __FILE__));
                wp_enqueue_style('DOPShortcodesStyle',  plugins_url('/assets/gui/css/style-dopshortcodes.css', __FILE__));
                wp_enqueue_style('DOPShortcodesStyleInteractiveElementsIcons');
                wp_enqueue_style('DOPShortcodesStyleSocialIcons');
                wp_enqueue_style('DOPShortcodesStyle');
            }
        
            function addScripts(){
                wp_register_script('DOPShortcodesImageLoader', plugins_url('/assets/js/jquery.dop.ImageLoader.js', __FILE__), array('jquery'));
                
                 // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                if (!wp_script_is('jquery-ui-accordion', 'queue')){
                    wp_enqueue_script('jquery-ui-accordion');
                }
                
                if (!wp_script_is('jquery-ui-tabs', 'queue')){
                    wp_enqueue_script('jquery-ui-tabs');
                }
                
                if (!wp_script_is('jquery-ui-toggle', 'queue')){
                    wp_enqueue_script('jquery-ui-toggle');
                }
                wp_enqueue_script('DOPShortcodesImageLoader');
            }
        
            function filter($content){   
                $array = array('<p>[' => '[', 
                               ']</p>' => ']', 
                               ']<br />' => ']',
                               ']<br>' => ']');
                $content = strtr($content, $array);
                
                return $content;
            }

            function init(){// Init Shortcodes.
// Accordions                 
                add_shortcode('dopaccordions', array(&$this, 'accordions'));
                add_shortcode('dopaccordion', array(&$this, 'accordion'));
// Containers                
                add_shortcode('dopcontainer', array(&$this, 'container'));
// Grids               
                add_shortcode('dopgrid', array(&$this, 'gridColumn'));
                add_shortcode('dopgridrow', array(&$this, 'gridRow'));
// Images         
                add_shortcode('dopimg', array(&$this, 'image'));
// Lists                
                add_shortcode('doplist', array(&$this, 'lists'));
// Progress Bars                
                add_shortcode('dopprogressbar', array(&$this, 'progressBar'));
// Separators                
                add_shortcode('dopseparator', array(&$this, 'separator'));
// Social Icons                
                add_shortcode('dopsocialicon', array(&$this, 'socialIcon'));
// Tabs                
                add_shortcode('doptabs', array(&$this, 'tabs'));
                add_shortcode('doptab', array(&$this, 'tab'));
// Tables                
                add_shortcode('doptable', array(&$this, 'table'));
// Toggles
                add_shortcode('doptoggle', array(&$this, 'toggle'));
            }

// Accordions            
            function accordions($atts, $content = null){ // Accordion Wrapper
                extract(shortcode_atts(array('class' => ''), $atts));
                
                $data = array();
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }
                
                array_push($data, '<div class="dopaccordion '.$class.'">');
                array_push($data, do_shortcode($content));
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery(function(){');
                array_push($data, '     jQuery(".dopaccordion").accordion({collapsible: true, heightStyle: "content"});');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode($data);
            }
            
            function accordion($atts, $content = null){ // Accordion Item
                extract(shortcode_atts(array('activeicon' => '',
                                             'icon' => '',
                                             'title' => '&nbsp;'), $atts));
                $data = array();
                
                if (is_array($atts)){
                    $activeicon = array_key_exists('activeicon', $atts) ? $atts['activeicon']:(array_key_exists('icon', $atts) ? $atts['icon']:'');
                    $icon = array_key_exists('icon', $atts) ? $atts['icon']:'';
                    $title = array_key_exists('title', $atts) ? $atts['title']:'&nbsp';
                }
                else{
                    $activeicon = '';
                    $icon = '';
                    $title = '&nbsp';
                }
                
                array_push($data, '<div class="dopaccordion-head">');
                array_push($data, ' <a href="javascript:void(0)">'); 
                
                if ($icon != ''){
                    array_push($data, ' <span class="icon dop-shortcodes-interactive-elements-icon-'.$icon.'"></span>');
                    array_push($data, ' <span class="icon-active dop-shortcodes-interactive-elements-icon-'.$activeicon.'"></span>');
                }
                array_push($data, $title);
                array_push($data, ' </a>');
                array_push($data, '</div>');
                array_push($data, '<div class="dopaccordion-content">');
                array_push($data, do_shortcode($content));
                array_push($data, '</div>');
                
                return implode($data);
            } 
            
// Containers            
            function container($atts, $content = null){
                extract(shortcode_atts(array('class' => ''), $atts));
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }

                return '<div class="dopcontainer '.$class.'">'.do_shortcode($content).'</div>';
            }
            
// Grid
            function gridRow($atts, $content=null){// Grid Row
                extract(shortcode_atts(array('class' => ''), $atts));
            
                $data = array();
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }
                
                array_push($data, '<div class="dopgridrow '.$class.'">');
                array_push($data, do_shortcode($content));
                array_push($data, '</div>');
                
                return implode( $data);
            }
            
            function gridColumn($atts, $content=null){// Read Grid Shortcodes.
                extract(shortcode_atts(array('class' => '',
                                             'size' => '1/6'), $atts));
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                    $size = array_key_exists('size', $atts) ? $atts['size']:'1/6';
                }
                else{
                    $class = '';
                    $size = '1/6';
                }
                
                switch ($size){
                    case '1/6':
                        $size = 'dopgrid2';
                        break;
                    case '1/4':
                        $size = 'dopgrid3';
                        break;
                    case '1/3':
                        $size = 'dopgrid4';
                        break;
                    case '5/12':
                        $size = 'dopgrid5';
                        break;
                    case '1/2':
                        $size = 'dopgrid6';
                        break;
                    case '7/12':
                        $size = 'dopgrid7';
                        break;
                    case '2/3':
                        $size = 'dopgrid8';
                        break;
                    case '3/4':
                        $size = 'dopgrid9';
                        break;
                    case '5/6':
                        $size = 'dopgrid10';
                        break;
                }
                
                $data = array();
                
                array_push($data, '<div class="dopgridcolumn '.$size .' '.$class.' ">');
                array_push($data, do_shortcode($content));
                array_push($data, '</div>');
                
                return implode( $data);
            }
            
// Images            
            function image($atts, $content = null){
                extract(shortcode_atts(array('align' => 'none',
                                             'cachebuster' => 'true',
                                             'class' => '',
                                             'errorcallback' => '',
                                             'height' => '200px',
                                             'loaderurl' => WP_PLUGIN_URL.'/dop-shortcodes/assets/gui/images/dopil-loader.gif',
                                             'loadinginorder' => 'true',
                                             'loadpreloaderfirst' => 'true',
                                             'noimageurl' => WP_PLUGIN_URL.'/dop-shortcodes/assets/gui/images/dopil-no-image.png',
                                             'imagedelay' => '600',
                                             'imagesize' => 'fill',
                                             'reinitialize' => 'false',
                                             'successcallback' => '',
                                             'width' => '100%'), $atts));
                $data = array();
                $this->no_images++;
                
                if (is_array($atts)){
                    $align = array_key_exists('align', $atts) ? $atts['align']:'none';
                    $cachebuster = array_key_exists('cachebuster', $atts) ? $atts['cachebuster']:'true';
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                    $errorcallback = array_key_exists('errorcallback', $atts) ? $atts['errorcallback']:'';
                    $height = array_key_exists('height', $atts) ? $atts['height']:'200px';
                    $loaderurl = array_key_exists('loaderurl', $atts) ? $atts['loaderurl']:WP_PLUGIN_URL.'/dop-shortcodes/assets/gui/images/dopil-loader.gif';
                    $loadinginorder = array_key_exists('loadinginorder', $atts) ? $atts['loadinginorder']:'true';
                    $loadpreloaderfirst = array_key_exists('loadpreloaderfirst', $atts) ? $atts['loadpreloaderfirst']:'true';
                    $noimageurl = array_key_exists('noimageurl', $atts) ? $atts['noimageurl']:WP_PLUGIN_URL.'/dop-shortcodes/assets/gui/images/dopil-no-image.png';
                    $imagedelay = array_key_exists('imagedelay', $atts) ? $atts['imagedelay']:'600';
                    $imagesize = array_key_exists('imagesize', $atts) ? $atts['imagesize']:'fill';
                    $reinitialize = array_key_exists('reinitialize', $atts) ? $atts['reinitialize']:'false';
                    $successcallback = array_key_exists('successcallback', $atts) ? $atts['successcallback']:'';
                    $width = array_key_exists('width', $atts) ? $atts['width']:'100%';
                }
                else{
                    $align = 'none';
                    $cachebuster = 'true';
                    $class = '';
                    $errorcallback = '';
                    $height = '200px';
                    $loaderurl = WP_PLUGIN_URL.'/dop-shortcodes/assets/gui/images/dopil-loader.gif';
                    $loadinginorder = 'true';
                    $loadpreloaderfirst = 'true';
                    $noimageurl = WP_PLUGIN_URL.'/dop-shortcodes/assets/gui/images/dopil-no-image.png';
                    $imagedelay = '600';
                    $imagesize = 'fill';
                    $reinitialize = 'false';
                    $successcallback = '';
                    $width = '100%';                    
                }
                
                array_push($data, '<span id="dopimage'.$this->no_images.'" class="dopimage '.$align.' '.$class.'" style="height: '.$height.'; width: '.$width.';">'.$content.'</span>');
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery("#dopimage'.$this->no_images.'").DOPImageLoader({');
                array_push($data, '                                                         "CacheBuster": '.$cachebuster.',');
                array_push($data, '                                                         "ErrorCallback": "'.$errorcallback.'",');
                array_push($data, '                                                         "LoaderURL": "'.$loaderurl.'",');
                array_push($data, '                                                         "LoadingInOrder": '.$loadinginorder.',');
                array_push($data, '                                                         "LoadPreloaderFirst": '.$loadpreloaderfirst.',');
                array_push($data, '                                                         "NoImageURL": "'.$noimageurl.'",');
                array_push($data, '                                                         "ImageDelay": '.$imagedelay.',');
                array_push($data, '                                                         "ImageSize": "'.$imagesize.'",');
                array_push($data, '                                                         "Reinitialize": '.$reinitialize.',');
                array_push($data, '                                                         "SuccessCallback": "'.$successcallback.'"');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode('', $data);
            }

// Lists
            function lists($atts, $content = null){
                extract(shortcode_atts(array('class' => ''), $atts));
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }

                return '<ul class="doplist '.$class.'">'.do_shortcode($content).'</ul>';
            }
            
// Progress Bars 
            function progressBar($atts, $content = null){
                extract(shortcode_atts(array('class' => '',
                                             'progress' => '50'), $atts));
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                    $progress = array_key_exists('progress', $atts) ? $atts['progress']:'50';
                }
                else{
                    $class = '';
                    $progress = '50';
                }

                return '<div class="dopprogressbar '.$class.'">
                            <span class="dopprogressbar-progress" style="width: '.$progress.'%;"></span>
                            <span class="dopprogressbar-label">'.do_shortcode($content).'</span>
                        </div>';
            }
   
// Separators            
            function separator($atts, $content = null){
                extract(shortcode_atts(array('class' => ''), $atts));
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }
                
                return '<hr class="dopseparator '.$class.'" />';
            }

// Social Icons            
            function socialIcon($atts, $content = null){
                extract(shortcode_atts(array('class' => '',
                                             'network' => 'facebook',
                                             'url' => 'javascript:void(0)'), $atts));
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                    $network = array_key_exists('network', $atts) ? $atts['network']:'facebook';
                    $url = array_key_exists('url', $atts) ? $atts['url']:'javascript:void(0)';
                }
                else{
                    $class = '';
                    $network = 'facebook';
                    $url = 'javascript:void(0)';
                }
                
                return '<a href="'.$url.'" target="_blank" class="dopsocialicon dop-shortcodes-social-icon-'.$network.'">
                            <span class="dopsocialicon-tooltip">'.do_shortcode($content).' <span class="dopsocialicon-tooltip-arrow"></span></span>
                        </a>';  
            }

// Tabs            
            function tabs($atts, $content = null){ // Tabs Wrapper
                extract(shortcode_atts(array('class' => ''), $atts));
                
                $data = array();
                $tabs_list = array();
                $tabs_content = array();
                $this->no_tabs++;
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }
                
                $tabs = explode(';;;;;;;', do_shortcode($content));
                
                for ($i=0; $i<count($tabs)-1; $i++){
                    $tab = explode(';;;;;', $tabs[$i]);
                    array_push($tabs_list, '<li><a href="#doptab-'.$this->no_tabs.'-'.($i+1).'">'.$tab[0].'</a></li>');
                    array_push($tabs_content, '<div id="doptab-'.$this->no_tabs.'-'.($i+1).'" class="doptab-container">'.$tab[1].'</div>');
                }
                
                array_push($data, '<div class="doptabs '.$class.'">');
                array_push($data, ' <ul>'.implode('', $tabs_list).'</ul>');
                array_push($data, implode('', $tabs_content));
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery(document).ready(function(){');
                array_push($data, '     jQuery(".doptabs").each(function(){');
                array_push($data, '         if (jQuery(this).hasClass("ui-tabs")){');
                array_push($data, '             jQuery(this).tabs("destroy");');
                array_push($data, '         }');
                array_push($data, '         jQuery(".doptabs").tabs();');
                array_push($data, '     });');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode('', $data);
            }
            
            function tab($atts, $content = null){ // Tab Item
                extract(shortcode_atts(array('title' => '&nbsp;'), $atts));
                
                if (is_array($atts)){
                    $title = array_key_exists('title', $atts) ? $atts['title']:'&nbsp;';
                }
                else{
                    $title = '&nbsp';
                }
                
                return $title.';;;;;'.do_shortcode($content).';;;;;;;';
            }
            
// Tables            
            function table($atts, $content = null){
                extract(shortcode_atts( array('class' => 'odd'), $atts));
                
                if (is_array($atts)){
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                }
                else{
                    $class = '';
                }
                    
                return '<table class="doptable '.$class.'">'.do_shortcode($content).'</table>';
            }

// Toggles            
            function toggle($atts, $content = null){ // Toggle Item
                extract(shortcode_atts(array('activeicon' => '',
                                             'class' => '',
                                             'icon' => '',
                                             'title' => '&nbsp;'), $atts));
                $data = array();
                
                if (is_array($atts)){
                    $activeicon = array_key_exists('activeicon', $atts) ? $atts['activeicon']:(array_key_exists('icon', $atts) ? $atts['icon']:'');
                    $class = array_key_exists('class', $atts) ? $atts['class']:'';
                    $icon = array_key_exists('icon', $atts) ? $atts['icon']:'';
                    $title = array_key_exists('title', $atts) ? $atts['title']:'&nbsp';
                }
                else{
                    $activeicon = '';
                    $class = '';
                    $icon = '';
                    $title = '&nbsp';
                }
                
                array_push($data, '<div class="doptoggle-wrapper '.$class.'">');
                array_push($data, '     <a class="doptoggle" href="javascript:void(0)">'.$title.' ');
                
                if ($icon != ''){
                    array_push($data, '     <span class="icon dop-shortcodes-interactive-elements-icon-'.$icon.'"></span>');
                    array_push($data, '     <span class="active-icon dop-shortcodes-interactive-elements-icon-'.$activeicon.'"></span>');
                }
                array_push($data, '     </a>');
                array_push($data, '     <div class="doptoggle-content">'.do_shortcode($content).'</div>');
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery(document).ready(function(){');
                array_push($data, '     jQuery(".doptoggle").unbind("click");');
                array_push($data, '     jQuery(".doptoggle").bind("click", function(){');
                array_push($data, '         jQuery(this).closest(".doptoggle-wrapper").find(".doptoggle-content").toggle("fast");');
                array_push($data, '         if (jQuery(this).closest(".doptoggle-wrapper").hasClass("dopactive")){');
                array_push($data, '             jQuery(this).closest(".doptoggle-wrapper").removeClass("dopactive");');
                array_push($data, '         }');
                array_push($data, '         else{');
                array_push($data, '             jQuery(this).closest(".doptoggle-wrapper").addClass("dopactive");');
                array_push($data, '         }');
                array_push($data, '     });');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode($data);
            }
        }
    }
?>