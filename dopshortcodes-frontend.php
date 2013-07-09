<?php

/*
* Title                   : DOP Shortcodes (WordPress Plugin)
* Version                 : 1.0
* File                    : dopshortcodes-frontend.php
* File Version            : 1.0
* Created / Last Modified : 07 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2013 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : DOP Shortcodes Front End Class.
*/

    if (!class_exists("DOPShortcodesFrontEnd")){
        class DOPShortcodesFrontEnd{
            private $prefix = 'dop';
            private $no_tabs = 0;
            private $no_toggles = 0;
            
            function DOPShortcodesFrontEnd(){// Constructor.
                add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
                $this->init();
            }
            
            function addScripts(){
//                wp_register_script('DOPBSP_DOPShortcodesJS', plugins_url('assets/js/jquery.dop.FrontendBookingSystemPRO.js', __FILE__), array('jquery'), false, true);

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
//                wp_enqueue_script('DOPBSP_DOPShortcodesJS');
            }

            function init(){// Init Shortcodes.
                add_shortcode($this->prefix.'accordions', array(&$this, 'accordions'));
                add_shortcode($this->prefix.'accordion', array(&$this, 'accordion'));
                add_shortcode($this->prefix.'container', array(&$this, 'containerStyle'));
//                add_shortcode($this->prefix.'grid', array(&$this, 'captionGridShortcode'));
//                add_shortcode($this->prefix.'gridrow', array(&$this, 'captionGridRowShortcode'));
//                add_shortcode($this->prefix.'image', array(&$this, 'imageShortcode'));
//                add_shortcode($this->prefix.'lists', array(&$this, 'listsChecks'));
//                add_shortcode($this->prefix.'pagination', array(&$this, 'pagination'));
//                add_shortcode($this->prefix.'progress', array(&$this, 'progressBar'));
//                add_shortcode($this->prefix.'separator', array(&$this, 'basicSeparator'));
//                add_shortcode($this->prefix.'social', array(&$this, 'socialIcon'));
//                add_shortcode($this->prefix.'socialinfo', array(&$this, 'infoIcon'));
                add_shortcode($this->prefix.'tabs', array(&$this, 'tabs'));
                add_shortcode($this->prefix.'tab', array(&$this, 'tab'));
                add_shortcode($this->prefix.'table', array(&$this, 'table'));
                add_shortcode($this->prefix.'toggle', array(&$this, 'toggle'));
                
                remove_shortcode('gallery', 'gallery_shortcode'); // Remove WordPress Gallery Shortcode
                add_shortcode('gallery', array(&$this, 'gallery')); // Overwrite WordPress Gallery Shortcode
            }
            
            function accordions($atts, $content = null){
                $data = array();
                
                array_push($data, '<div class="'.$this->prefix.'accordion">');
                array_push($data, do_shortcode(str_replace('<br />', "", $content)));
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery(document).ready(function(){');
                array_push($data, '     jQuery(".'.$this->prefix.'accordion").each(function(){');
                array_push($data, '         if (jQuery(this).hasClass("ui-accordion")){');
                array_push($data, '             jQuery(this).accordion("destroy");');
                array_push($data, '         }');
                array_push($data, '         jQuery(this).accordion({collapsible: true, heightStyle: "content"});');
                array_push($data, '     });');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode($data);
            }
            
            function accordion($atts, $content = null){
                extract(shortcode_atts(array('title' => ''), $atts));
                $data = array();
                    
                array_push($data, '<div class="'.$this->prefix.'accordion-head">');
                array_push($data, '   <a href="javascript:void(0)">');  
                array_push($data, '     <span class="sign icon-325"></span>');
                array_push($data, '     <span class="sign-selected icon-326"></span>');
                array_push($data, $atts['title']);
                array_push($data, '   </a>');
                array_push($data, '</div>');
                array_push($data, '<div class="'.$this->prefix.'accordion-content">');
                array_push($data, do_shortcode(str_replace('<br />', "", $content)));
                array_push($data, '</div>');
                
                return implode($data);
            }
            
            function captionGridRowShortcode($atts, $content=null){// Read Grid Row Shortcodes.
                extract(shortcode_atts(array('class' => $this->prefix.'gridrow'), $atts));
            
                $data = array();
                
                array_push($data, '<div class="grid-row">');
                array_push($data, do_shortcode(str_replace('<br />', "", $content)));
                array_push($data, '<br class="clear hide-on-mobile" />');
                array_push($data, '</div>');
                
                return implode( $data);
            }
            
            function captionGridShortcode($atts, $content=null){// Read Grid Shortcodes.
                extract(shortcode_atts(array('class' => $this->prefix.'grid',
                                             'style' => '1',
                                             'size' => '1/2',
                                             'type' => 'has-info-icon'), $atts));
                                
                if (array_key_exists('size', $atts)){
                    $size = $atts['size'];
                }
                else{
                    $size = '1/2';
                }
                
                $classes = '';
                
                switch ($size){
                    case '1/2':
                        $classes .= 'grid6';
                        break;
                    case '1/3':
                        $classes .= 'grid4';
                        break;
                    case '1/4':
                        $classes .= 'grid3';
                        break;
                    case '1/6':
                        $classes .= 'grid2';
                        break;
                    case '5/12':
                        $classes .= 'grid5';
                        break;
                    case '7/12':
                        $classes .= 'grid7';
                        break;
                    case '2/3':
                        $classes .= 'grid8';
                        break;
                    case '3/4':
                        $classes .= 'grid9';
                        break;
                    case '5/6':
                        $classes .= 'grid10';
                        break;
                }
                
                if (array_key_exists('style', $atts)){
                    $style = $atts['style'];
                }
                else{
                    $style = '1';
                }
                
                $class = '';
                
                switch ($style){
                    case '1':
                        $class .= 'style1';
                        break;
                    case '2':
                        $class .= 'style2';
                        break;
                    case '3':
                        $class .= 'style3';
                        break;
                }
                
                $data = array();
                
                array_push($data, '<div class="'.$classes .' '.$class.' ">');
                array_push($data, do_shortcode(str_replace('<br />', "", $content)));
                array_push($data, '</div>');
                
                return implode( $data);
            }
          
            function imageShortcode($atts, $content = null){
                extract(shortcode_atts(array('align' => 'left',
                                             'width' => '350',
                                             'height' => '200',
                                             'src' => ''), $atts));
                
                $class = '';

                switch ($align){
                    case 'left':
                        $class .= 'left';
                        break;
                    case 'right':
                        $class .= 'right';
                        break;
                    case 'center':
                        $class .= 'center';
                        break;
                }
                return '<span class="content-image '.$align.'"><img src="'.$atts['src'].'" /></span>';
            }

            function socialIcon($atts, $content = null){
                extract(shortcode_atts(array('icon' => 'blogger',
                                             'url' => ''), $atts));
                
                return '<a href="'.$atts['url'].'" target="_blank" class="social-link social-icon-'.$atts['icon'].'">
                            <span class="tooltip">'.$content.' <span class="tooltip-arrow"></span></span>
                        </a>';  
            }

            function infoIcon($atts){
                extract(shortcode_atts(array('icon' => ''), $atts));

                return '<span class="info-icon">
                            <span class="glyph icon-'.$atts['icon'].'"></span>
                            <span class="glyph-hover icon-'.$atts['icon'].'"></span>
                        </span> ';
            }

            function listsChecks($atts, $content = null){
                extract(shortcode_atts( array('type' => 'list-checks'), $atts));

                $class = '';

                switch ($type){
                    case 'checks':
                        $class .= 'list-checks';
                        break;
                    case 'arrows':
                        $class .= 'list-arrows';
                        break;
                    case 'circles':
                        $class .= 'list-circles';
                        break;
                    case 'diamonds':
                        $class .= 'list-diamonds';
                        break;
                }

                return '<ul class="single-list '.$atts['type'].'">
                            <li>'.$content.'</li>
                        </ul>';
            }

            function progressBar($atts, $content = null){
                extract(shortcode_atts(array('style' => 'width: 80%;'), $atts));

                return '<div class="skill">
                                <span class="progress" style="'.$atts['style'].'"></span>
                                <span class="label">'.$content.' </span>
                        </div>';
            }

            function containerStyle($atts, $content = null){
                extract(shortcode_atts(array('style' => '2'), $atts));
                $class = '';

                switch ($style){
                    case '1':
                        $class .= 'style1';
                        break;
                    case '2':
                        $class .= 'style2';
                        break;
                    case '3':
                        $class .= 'style3';
                        break;
                }

                $data = array();

                array_push($data, '<div class="container  '.$class.' ">');
                array_push($data, '     <p>'.$content.'</p>');
                array_push($data, '</div>');

                return implode( $data);
            }
            
            function basicSeparator($atts, $content = null){
                extract(shortcode_atts(array('class' => 'style2'), $atts));
                    
                $class = '';

                switch ($class){
                    case '2':
                        $class .= 'style2';
                        break;
                    case '3':
                        $class .= 'style3';
                        break;
                    case '4':
                        $class .= 'style4';
                        break;
                }
                return '<hr class="'.$atts['class'].'" />';
            }
            
            function pagination( $atts, $content = null){
                extract(shortcode_atts(array('class' => 'pagination'), $atts));
                    
                return '<div class="'.$class.'">
                            '.$content.'
                            <br class="clear" />
                        </div>';
            }
                
            function gallery($atts, $content = null){
                return '';
            }
            
            function tabs($atts, $content = null){
                $data = array();
                $tabs_list = array();
                $tabs_content = array();
                $this->no_tabs++;
                
                $tabs = explode(';;;;;;;', do_shortcode(str_replace('<br />', "", $content)));
                
                array_push($data, '<div class="'.$this->prefix.'tabs">');
                
                for ($i=0; $i<count($tabs)-1; $i++){
                    $tab = explode(';;;;;', $tabs[$i]);
                    array_push($tabs_list, '<li><a href="#'.$this->prefix.'tab-'.$this->no_tabs.'-'.($i+1).'">'.$tab[0].'</a></li>');
                    array_push($tabs_content, '<div id="'.$this->prefix.'tab-'.$this->no_tabs.'-'.($i+1).'" class="'.$this->prefix.'tab-container">'.$tab[1].'</div>');
                }
                array_push($data, '<ul>'.implode('', $tabs_list).'</ul>');
                array_push($data, implode('', $tabs_content));
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery(document).ready(function(){');
                array_push($data, '     jQuery(".'.$this->prefix.'tabs").each(function(){');
                array_push($data, '         if (jQuery(this).hasClass("ui-tabs")){');
                array_push($data, '             jQuery(this).tabs("destroy");');
                array_push($data, '         }');
                array_push($data, '         jQuery(this).tabs();');
                array_push($data, '     });');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode($data);
            }
            
            function tab($atts, $content = null){
                extract(shortcode_atts(array('title' => '1'), $atts));
                return $atts['title'].';;;;;'.$content.';;;;;;;';
            }
            
            function table($atts, $content = null){
                extract(shortcode_atts( array('type' => 'basic',
                                              'class' => 'odd'), $atts));
                $data = array();
                    
                array_push($data, '<table class="'.$type.'">');
                array_push($data, do_shortcode(str_replace('<br />', "", $content)));
                array_push($data, '</table>');
                
                return implode($data);
            }
            
            function toggle($atts, $content = null){
                extract(shortcode_atts(array('title' => ''), $atts));
                
                $data = array();
                
                array_push($data, '<div class="'.$this->prefix.'toggle-wrapper">');
                array_push($data, ' <a class="'.$this->prefix.'toggle" href="javascript:void(0)">'.$atts['title'].' <span class="sign icon-67"></span></a>');
                array_push($data, ' <div class="'.$this->prefix.'toggle-content">'.$content.'</div>');
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, ' jQuery(document).ready(function(){');
                array_push($data, '     jQuery(".'.$this->prefix.'toggle").unbind("click");');
                array_push($data, '     jQuery(".'.$this->prefix.'toggle").bind("click", function(){');
                array_push($data, '         jQuery(this).closest(".'.$this->prefix.'toggle-wrapper").find(".'.$this->prefix.'toggle-content").fadeToggle("fast");');
                array_push($data, '         if (jQuery(".sign", this).hasClass("icon-67")){');
                array_push($data, '             jQuery(".sign", this).removeClass("icon-67");');
                array_push($data, '             jQuery(".sign", this).addClass("icon-69");');
                array_push($data, '         }');
                array_push($data, '         else{');
                array_push($data, '             jQuery(".sign", this).removeClass("icon-69");');
                array_push($data, '             jQuery(".sign", this).addClass("icon-67");');
                array_push($data, '         }');
                array_push($data, '     });');
                array_push($data, ' });');
                array_push($data, '</script>');
                
                return implode($data);
            }
        }
    }
?>