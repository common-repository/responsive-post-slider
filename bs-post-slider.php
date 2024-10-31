<?php
/*
  Plugin Name:Responsive Post SlideShow
  Plugin URI:http://www.junktheme.com
  Description: Thanks for installing - Responsive Post Slideshow.
  Version: 1.0
  Author: Junk Theme
  Author URI: http://www.junktheme.com
 */

//include dirname(__FILE__) . '/inc/bs-post-slider-post.php';
include dirname(__FILE__) . '/bs-post-slider-shortcode.php';

class Bs_Post_Slider {

    public function Bs_Post_Instance() {
        add_action('admin_menu', array($this, 'bs_post_slider_setting'));
        add_action('admin_init', array($this, 'bs_post_slider_register_settings'));
    }

    public function bs_post_slider_getInstance() {
        $this->Bs_Post_Instance();
    }
    public function bs_post_slider_setting() {
        add_menu_page(__('Slidshow Settings', 'bs-post-slider'), __('Responsive Post Slider', 'bs-post-slider'), 'manage_options', 'bs_post_slider_setting', array($this, 'bs_post_slider_setting_field'),'dashicons-images-alt2',20);
    }
    public function bs_post_slider_setting_field() { ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php settings_fields('bs_post_slider_options'); ?>
                <?php do_settings_sections('bs_post_slider'); ?>
                <p class="submit">
                    <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
                </p>
            </form>
        </div>
    <?php }
    public function bs_post_slider_register_settings() {

        register_setting('bs_post_slider_options', 'bs_post_slider_options');
        add_settings_section('bs_post_slider', '', array($this, 'bs_video_section_text'), 'bs_post_slider');
        add_settings_field('bs_displayControls', __('Display Controls', 'bs-post-slider'), array($this, 'bs_post_slider_displayControls'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_autoSlide', __('Auto Slider', 'bs-post-slider'), array($this, 'bs_post_slider_autoSlide'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_effect', __('Slider Effect', 'bs-post-slider'), array($this, 'bs_post_slider_transitionEffect'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_touchControls', __('Touch Controls', 'bs-post-slider'), array($this, 'bs_post_slider_touchControls'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_listPosition', __('List Possition', 'bs-post-slider'), array($this, 'bs_post_slider_listPosition'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_displayList', __('Display List', 'bs-post-slider'), array($this, 'bs_post_slider_displayList'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_adaptiveHeight', __('Adaptive Height', 'bs-post-slider'), array($this, 'bs_post_slider_adaptiveHeight'), 'bs_post_slider', 'bs_post_slider');
        add_settings_field('bs_transitionDuration', __('Transition Duration', 'bs-post-slider'), array($this, 'bs_post_slider_transitionDuration'), 'bs_post_slider', 'bs_post_slider');
    }
    public function bs_video_section_text(){
       echo "<h2>Responsive Post Slider Configuration</h2>";
    }
    
    public function bs_post_slider_displayControls() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_displayControls' name='bs_post_slider_options[bs_displayControls]'>";
        $know = array('Yes' => 'true', 'No' => 'false');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_displayControls']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }

        echo "</select>";
    }

    public function bs_post_slider_autoSlide() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_autoSlide' name='bs_post_slider_options[bs_autoSlide]'>";
        $know = array('Yes' => 'true', 'No' => 'false');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_autoSlide']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }

        echo "</select>";
    }

    public function bs_post_slider_transitionEffect() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_effect' name='bs_post_slider_options[bs_effect]'>";
        $know = array('Fading' => 'fading', 'Sliding' => 'sliding');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_effect']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }

        echo "</select>";
    }
    public function bs_post_slider_touchControls() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_touchControls' name='bs_post_slider_options[bs_touchControls]'>";
        $know = array('No' => 'false', 'Yes' => 'true');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_touchControls']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }

        echo "</select>";
    }
    public function bs_post_slider_listPosition() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_listPosition' name='bs_post_slider_options[bs_listPosition]'>";
        $know = array('Right' => 'right', 'Left' => 'left');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_listPosition']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }
        echo "</select>";
    }
    public function bs_post_slider_displayList() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_displayList' name='bs_post_slider_options[bs_displayList]'>";
        $know = array('Yes' => 'true', 'No' => 'false');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_displayList']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }
        echo "</select>";
    }
    public function bs_post_slider_adaptiveHeight() {
        $bs_slider_options = get_option('bs_post_slider_options');
        echo "<select id='bs_adaptiveHeight' name='bs_post_slider_options[bs_adaptiveHeight]'>";
        $know = array('Yes' => 'true', 'No' => 'false');
        foreach ($know as $key => $v) {
            echo '<option value="' . $v . '"';
            if ($v == $bs_slider_options['bs_adaptiveHeight']) {
                echo 'selected="selected"';
            }

            echo '>' . $key . '</option>';
        }
        echo "</select>";
    }

    public function bs_post_slider_transitionDuration() {
        $bs_slider_options = get_option('bs_post_slider_options');
        empty($bs_slider_options['bs_transitionDuration']) ? $bs_slider_options['bs_transitionDuration'] = 500 : $bs_slider_options['bs_transitionDuration'];
        echo "<input id='bs_transitionDuration' name='bs_post_slider_options[bs_transitionDuration]' size='20' type='text' value='{$bs_slider_options['bs_transitionDuration']}' />";
    }
   
}

$var = new Bs_Post_Slider();
$var->bs_post_slider_getInstance();

