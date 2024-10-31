<?php
class Bs_post_slider_shortcode {

    public function __construct() {
        
        add_shortcode('bs_post_slider', array($this, 'show_shortcode_bs_post_slider'));
        add_action('wp_enqueue_scripts', array($this, 'bs_post_slider_enqueue_scripts'));
    }

    private function bs_post_slider($atts, $content = NULL) {
        extract(shortcode_atts(
            array(
                'category' => '',
                'limit'=>-1,
                'orderby'=>'DESC'
            ), $atts)
        );
        if ( $category != "" ) {
            $category = explode( ",", $category );
            for ( $i = 0; $i < count( $category ); $i++ ) {
                $query_args = array(
                    'posts_per_page' =>$limit,
                    'post_type' => 'post',
                    'orderby' => 'date',
                    'order' =>$orderby,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'name',
                            'terms' => $category,
                            'include_children' => false
                        )
                    ),
                    'no_found_rows' => true,
                );
            }
        } else {
            $query_args = array(
                'posts_per_page' =>$limit,
                'post_type' => 'post',
                'order' => $orderby,
                'orderby' => 'date',
            );
        }
        $wp_query = new WP_Query($query_args);
        if ($wp_query->have_posts()):while ($wp_query->have_posts()) : $wp_query->the_post();
                return $data_tables=get_posts($query_args);
            endwhile;
        else: echo 'No Post  Found';
        endif;
    }
    public function bs_post_slider_get_option()
    {
        $bs_post_slider_options_array= array(
            'bs_post_slider_options'=>array(
                'bs_displayControls' =>'true',
                'bs_touchControls'=>'false',
                'bs_autoSlide'=>'true',
                'bs_effect'=>'fading',
                'bs_listPosition'=>'right',
                'bs_displayList'=>'true',
                'bs_adaptiveHeight'=>'false',
                'bs_transitionDuration'=>500
            ));
        foreach ($bs_post_slider_options_array as $key => $value) {
            return $value;
        }
    }
    public function show_shortcode_bs_post_slider($atts, $content = NULL) {
        $bs_post_slider_options =get_option('bs_post_slider_options');
        if(empty($bs_post_slider_options)){
            $bs_post_slider_options=$this->bs_post_slider_get_option();
        }
        $bs_displayControls = $bs_post_slider_options['bs_displayControls'];
        $bs_touchControls = $bs_post_slider_options['bs_touchControls'];
        $bs_autoSlide = $bs_post_slider_options['bs_autoSlide'];
        $bs_effect = $bs_post_slider_options['bs_effect'];
        $bs_listPosition = $bs_post_slider_options['bs_listPosition'];
        $bs_displayList = $bs_post_slider_options['bs_displayList'];
        $bs_adaptiveHeight = $bs_post_slider_options['bs_adaptiveHeight'];
        $bs_transitionDuration = $bs_post_slider_options['bs_transitionDuration'];

        $data_values = $this->bs_post_slider($atts, $content = NULL);
        ob_start();
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('.pgwSlider').pgwSlider({
                    displayControls:<?php echo $bs_displayControls; ?>,
                    autoSlide:<?php echo $bs_autoSlide; ?>,
                    transitionEffect: '<?php echo $bs_effect; ?>',
                    touchControls:<?php echo $bs_touchControls; ?>,
                    listPosition: '<?php echo $bs_listPosition; ?>',
                    displayList:<?php echo $bs_displayList; ?>,
                    transitionDuration:<?php echo $bs_transitionDuration; ?>,
                    adaptiveHeight:<?php echo $bs_adaptiveHeight; ?>
                });

            });
        </script>
        <div class="bs_post_slider">
             <ul class="pgwSlider">
                <?php
                if (!empty($data_values)) {

                    foreach ($data_values as $key => $data_table):
                         echo '<li><a class="bs_post_slider_link" href="'.get_permalink( ).'" target="_self">'. get_the_post_thumbnail( $data_table->ID, 'full', $attr )
                     .'<span>' . $data_table->post_title. '</span>'.
                                 '</a></li>';
                    endforeach;
                }
                ?>
            </ul>
        </div>
		<div style='color:#ccc; font-size: 9px; text-align:right;'><a href='http://www.junktheme.com/' title='visit us' target='_blank'>junk theme</a></div>
        <div class="clear"> </div>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

    public function bs_post_slider_enqueue_scripts() {
        wp_enqueue_style('bs_post_slider_css', plugin_dir_url(__FILE__) . 'css/style.css');
        wp_enqueue_script('bs_post_slider_js', plugin_dir_url(__FILE__) . 'js/pgwslider.js', array('jquery'), true);
    }

}

new Bs_post_slider_shortcode();


