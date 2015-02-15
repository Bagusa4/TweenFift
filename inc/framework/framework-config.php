<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_b4theme_tweenfift_config' ) ) {

        class Redux_Framework_b4theme_tweenfift_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

                /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'redux-framework-b4theme' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-b4theme' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'redux-framework-b4theme' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'redux-framework-b4theme' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'redux-framework-b4theme' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'redux-framework-b4theme' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'redux-framework-b4theme' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'redux-framework-b4theme' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'redux-framework-b4theme' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'redux-framework-b4theme' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }

                // ACTUAL DECLARATION OF SECTIONS
                $this->sections[] = array(
                    'title'  => __( 'Home', 'redux-framework-b4theme' ),
                    'desc'   => __( '<h1 style="text-align:center"> Welcome </h1> <p> Hello guys, This is my first time making a theme and use a modern framework. </p> <p> I made this theme because I was school holidays. </p> <p> I share this theme for free, because not all the framework of this theme I made. </p> <p> The first theme is the theme tweenty Fifteen, latest theme woordpress 4.1x. </p> <p> I edit and add some features on this theme, such as Related Posts, Recent Gallery, Breadcrumbs etc. And also I integrate this theme with the Framework of Modern and Sophisticated. </P> <p> Thank you for using this theme. </p> <p> I hope you like it. Thanks! : D </p> <p> To get more themes, please visit <b><a href="http://bagusa4.tk/" target="_blank">here</a></b> or <b><a href="http://www.blog.bagusa4.tk/" target="_blank">here</a></b>. </p> <p> If you find a problem on this theme, please contact me via <b><a href="https://www.facebook.com/bagusa4/" target="_blank">Facebook</a></b> | <b><a href="https://twitter.com/Bagusa4/" target="_blank">Twitter</a></b> | Or visit the discussion forums <b><a href="http://bagusa4.tk/forums/" target="_blank">here</a></b>. </p>', 'redux-framework-b4theme' ),
                    'icon'   => 'el-icon-home',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(

                    ),
                );

                $this->sections[] = array(
                    'type' => 'divide',
                );

                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'General Settings', 'redux-framework-b4theme' ),
                    'fields' => array(
                        array(
                            'id'       => 'opt-layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => __( 'Main Layout', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'redux-framework-b4theme' ),
                            'options'  => array(
                                '1' => array(
                                    'alt' => '1 Column',
                                    'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                                ),
                                '2' => array(
                                    'alt' => '2 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                                ),
                                '3' => array(
                                    'alt' => '2 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                                ),
                                '4' => array(
                                    'alt' => '3 Column Middle',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cm.png'
                                ),
                                '5' => array(
                                    'alt' => '3 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cl.png'
                                ),
                                '6' => array(
                                    'alt' => '3 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cr.png'
                                )
                            ),
                            'default'  => '2'
                        ),
                        array(
                            'id'       => 'opt-textarea',
                            'type'     => 'textarea',
                            'required' => array( 'layout', 'equals', '1' ),
                            'title'    => __( 'Tracking Code', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'redux-framework-b4theme' ),
                            'validate' => 'js',
                            'desc'     => 'Validate that it\'s javascript!',
                        ),
                        array(
                            'id'       => 'opt-ace-editor-css',
                            'type'     => 'ace_editor',
                            'title'    => __( 'CSS Code', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Paste your CSS code here.', 'redux-framework-b4theme' ),
                            'mode'     => 'css',
                            'theme'    => 'eclipse',
                            'desc'     => 'You can add custom CSS in the fields above.', // Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your CSS code in the space provided.',
                            ),
                            'default'  => "#header{\nmargin: 0 auto;\n}"
                        ),
                      
						array(
							'id'        => 'opt-ace-editor-js',
							'type'      => 'ace_editor',
							'title'     => __('JS Code', 'redux-framework-b4theme'),
							'subtitle'  => __('Paste your JS code here.', 'redux-framework-b4theme'),
							'mode'      => 'javascript',
							'theme'     => 'monokai',
							'desc'      => 'You can add custom JS in the fields above.', // Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your JS code in the space provided.',
                            ),
							'default'   => "jQuery(document).ready(function(){\n\n});"
						),
						/*
					array(
						'id'        => 'opt-ace-editor-php',
						'type'      => 'ace_editor',
						'title'     => __('PHP Code', 'redux-framework-b4theme'),
						'subtitle'  => __('Paste your PHP code here.', 'redux-framework-b4theme'),
						'mode'      => 'php',
						'theme'     => 'chrome',
						'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" 	target="_blank">http://ace.c9.io/</a>.',
						'default'   => '<?php\nisset ( $redux ) ? true : false;\n?>'
					),
					*/
                        array(
                            'id'       => 'opt-editor-footer',
                            'type'     => 'editor',
                            'title'    => __( 'Footer Text', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-b4theme' ),
                            'default'  => 'Optimize By Author,Theme Based Twenty Fifteen, Powered by Heart :).',
                        )
                    )
                );

                $this->sections[] = array(
                    'icon'       => 'el-icon-website',
                    'title'      => __( 'Styling Options', 'redux-framework-b4theme' ),
                    'subsection' => false,
                    'fields'     => array(
                        array(
                            'id'       => 'opt-select-stylesheet',
                            'type'     => 'select',
                            'title'    => __( 'Theme Stylesheet', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Select your themes alternative color scheme.', 'redux-framework-b4theme' ),
                            'options'  => array( 
							'default.css' => 'default.css', 
							'comingsoon.css' => 'comingsoon :).css'
							),
                            'default'  => 'default.css',
                        ),
						array(
                            'id'       => 'favicon',
                            'type'     => 'media',
                            'preview'  => true,
							'url'      => true,
                            'title'    => __( 'Favicon', 'redux-framework-b4theme' ),
                            'desc'     => __( 'Click Upload button to Change the Favicon on your website ', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Favicon Quick Change', 'redux-framework-b4theme' ),
							'library_filter'  => array('ico'),
							'default'  => array (
								'url' => ''.get_bloginfo('template_directory') . '/img/favicon.ico'
							),
                        ),
						array(
                            'id'       => 'opt-color-site-title',
                            'type'     => 'color',
                            'output'   => array( '.site-title' ),
                            'title'    => __( 'Title Color', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the color of the title of your websites content. :)', 'redux-framework-b4theme' ),
                            'default'  => '#333',
                            'validate' => 'color',
                        ),
                        array(
                            'id'       => 'opt-background-body',
                            'type'     => 'background',
                            'output'   => array( 'body' ),
                            'title'    => __( 'Body Background', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change website body color as you like, with image, color, etc. :)', 'redux-framework-b4theme' ),
                            'default'   => '#F1F1F1',
                        ),
						array(
                            'id'       => 'opt-color-nav-text',
                            'type'     => 'color',
                            'output'   => array( '.main-navigation a' ),
                            'title'    => __( 'Navigation Text Color', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the text color of website navigation to your personal preference. :)', 'redux-framework-b4theme' ),
                            'default'  => '#333',
                            'validate' => 'color',
                        ),
						array(
                            'id'       => 'opt-background-nav',
                            'type'     => 'background',
                            'output'   => array( '.main-navigation' ),
                            'title'    => __( 'Navigation Background', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change website navigation body color as you like, with image, color, etc. :)', 'redux-framework-b4theme' ),
                            'default'   => '#FFFFFF',
                        ),
						array(
                            'id'       => 'opt-color-tagsmarquee-text',
                            'type'     => 'color',
							'required' => array( 'switch-tags-marquee', '=', '1' ),
                            'output'   => array( '.marqueetag > marquee > ul li a,' ),
                            'title'    => __( 'Tags Marquee Text Color', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the text color of website tags marquee on above to your personal preference. :)', 'redux-framework-b4theme' ),
                            'default'  => '#333',
                            'validate' => 'color',
                        ),
						array(
                            'id'       => 'opt-background-tagsmarquee',
                            'type'     => 'background',
							'required' => array( 'switch-tags-marquee', '=', '1' ),
                            'output'   => array( '.marqueetag' ),
                            'title'    => __( 'Tags Marquee Background', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the background color of the marquee tags above website to your liking, with images, color, etc. :)', 'redux-framework-b4theme' ),
                            'default'   => '#FFFFFF',
                        ),
						array(
                            'id'       => 'opt-color-sidebar-text',
                            'type'     => 'color',
                            'output'   => array( '.sidebar a' ),
                            'title'    => __( 'Sidebar Text Color', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the text color of website sidebar to your personal preference. :)', 'redux-framework-b4theme' ),
                            'default'  => '#333',
                            'validate' => 'color',
                        ),
						array(
                            'id'       => 'opt-background-sidebar',
                            'type'     => 'background',
                            'output'   => array( '.sidebar' ),
                            'title'    => __( 'Sidebar Background', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change website sidebar body color as you like, with image, color, etc. :)', 'redux-framework-b4theme' ),
                            'default'   => '#FFFFFF',
                        ),
						array(
                            'id'       => 'opt-color-post-text',
                            'type'     => 'color',
                            'output'   => array( 'article,article a,.entry-header,.entry-content a' ),
                            'title'    => __( 'Post Text Color', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the text color of website post to your personal preference. :)', 'redux-framework-b4theme' ),
                            'default'  => '#333',
                            'validate' => 'color',
                        ),
						array(
                            'id'       => 'opt-background-post',
                            'type'     => 'background',
                            'output'   => array( 'article' ),
                            'title'    => __( 'Post Background', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change website post body color as you like, with image, color, etc. :)', 'redux-framework-b4theme' ),
                            'default'   => '#FFFFFF',
                        ),
						array(
                            'id'       => 'opt-color-footer-text',
                            'type'     => 'color',
                            'output'   => array( '.site-info a' ),
                            'title'    => __( 'Footer Text Color', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change the text color of website post to your personal preference. :)', 'redux-framework-b4theme' ),
                            'default'  => '#333',
                            'validate' => 'color',
                        ),
						array(
                            'id'       => 'opt-background-footer',
                            'type'     => 'background',
                            'output'   => array( '.site-footer' ),
                            'title'    => __( 'Footer Background', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Change website footer body color as you like, with image, color, etc. :)', 'redux-framework-b4theme' ),
                            'default'   => '#FFFFFF',
                        ),
                        array(
                            'id'       => 'opt-link-color',
                            'type'     => 'link_color',
                            'title'    => __( 'Links Color Option', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'You can change link text color.', 'redux-framework-b4theme' ),
                            'desc'     => __( 'You can change link text color. Regular, On Hover, On Active.', 'redux-framework-b4theme' ),
							'output'   => array( 'a' ),
                            //'regular'   => false, // Disable Regular Color
                            //'hover'     => false, // Disable Hover Color
                            //'active'    => false, // Disable Active Color
                            //'visited'   => true,  // Enable Visited Color
                            'default'  => array(
                                'regular' => '#333',
                                'hover'   => '#727272',
                                'active'  => '#333',
                            )
                        ),
                        /* array(
                            'id'       => 'opt-spacing',
                            'type'     => 'spacing',
                            'output'   => array( '.site-header' ),
                            // An array of CSS selectors to apply this font style to
                            'mode'     => 'margin',
                            // absolute, padding, margin, defaults to padding
                            'all'      => true,
                            // Have one field that applies to all
                            //'top'           => false,     // Disable the top
                            //'right'         => false,     // Disable the right
                            //'bottom'        => false,     // Disable the bottom
                            //'left'          => false,     // Disable the left
                            //'units'         => 'em',      // You can specify a unit value. Possible: px, em, %
                            //'units_extended'=> 'true',    // Allow users to select any type of unit
                            //'display_units' => 'false',   // Set to false to hide the units if the units are specified
                            'title'    => __( 'Padding/Margin Option', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Allow your users to choose the spacing or margin they want.', 'redux-framework-b4theme' ),
                            'desc'     => __( 'You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'redux-framework-b4theme' ),
                            'default'  => array(
                                'margin-top'    => '1px',
                                'margin-right'  => '2px',
                                'margin-bottom' => '3px',
                                'margin-left'   => '4px'
                            )
                        ), */
                        array(
                            'id'       => 'opt-typography-body',
                            'type'     => 'typography',
							'title'    => __( 'Body Font', 'redux-framework-b4theme' ),
							//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                            'google'      => true,
                            // Disable google fonts. Won't work if you haven't defined your google api key
                            'font-backup' => true,
                            // Select a backup non-google font in addition to a google font
                            //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                            //'subsets'       => false, // Only appears if google is true and subsets not set to false
                            //'font-size'     => false,
                            //'line-height'   => false,
							'line-height' => 'false',
                            //'word-spacing'  => true,  // Defaults to false
                            //'letter-spacing'=> true,  // Defaults to false
                            //'color'         => false,
                            //'preview'       => false, // Disable the previewer
                            'all_styles'  => true,
                            // Enable all Google Font style/weight variations to be added to the page
							'output'      => array('body'),
							// An array of CSS selectors to apply this font style to dynamically
							'compiler'    => array( 'body' ),
                            // An array of CSS selectors to apply this font style to dynamically
							'units'       => 'px',
                            // Defaults to px
                            'subtitle' => __( 'Specify the body font properties.', 'redux-framework-b4theme' ),
                            'default'  => array(
                                'color'       => '#333',
                                'font-size'   => '15',
                                'font-family' => '"Noto Serif", serif',
                                'font-weight' => 'Normal',
								'google'	  => true
                            ),
                        ),
						array( // Pagar Broo :D
							'id'   => 'pagar-in-styling-options',
							'type' => 'divide',
						),						
						array(
                            'id'       => 'switch-tags-marquee',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to turn on Tags Marquee after Navigation.', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Enable to turn on Tags Marquee after Navigation. And disable to turn off.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'       => 'switch-gallery-sidebar',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to turn on recent gallery in sidebar.', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Enable to turn on recent gallery in sidebar. And disable to turn off.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'       => 'switch-breadcrumbs',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to turn on Breadcrumbs.', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Enable to turn on Breadcrumbs. And disable to turn off.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'       => 'switch-gallery-single',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to turn on recent gallery in single post.', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Enable to turn on recent gallery in single post. And disable to turn off.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'       => 'switch-related',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to turn on related in single post.', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Enable to turn on related in single post. And disable to turn off.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
                    )
                );

                /**
                 *  Note here I used a 'heading' in the sections array construct
                 *  This allows you to use a different title on your options page
                 * instead of reusing the 'title' value.  This can be done on any
                 * section - kp
                 */
                $this->sections[] = array(
                    'icon'    => 'el-icon-bullhorn',
                    'title'   => __( 'ADS Setting', 'redux-framework-b4theme' ),
                    'heading' => __( 'Setting ADS in this theme.', 'redux-framework-b4theme' ),
                    'desc'    => __( '<p class="description">Field your ads code in bellow :)</p>', 'redux-framework-b4theme' ),
                    'fields'  => array(
					    array(
                            'id'       => 'switch-ads-1',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show ADS 1', 'redux-framework-b4theme' ),
                            'subtitle' => __( '', 'redux-framework-b4theme' ),
                            'default'  => 0,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
                        array(
                            'id'           => 'ads-1',
                            'type'         => 'textarea',
							'required' => array( 'switch-ads-1', '=', '1' ),
                            'title'        => __( 'ADS 1', 'redux-framework-b4theme' ),
                            'subtitle'     => __( 'These ads will appear after 2 first post.', 'redux-framework-b4theme' ),
                            'desc'         => __( 'Put your ad code in the field above. Sample sizes 300x250, 336x280, 728x90, 300x600, 320x100 and others. The length of the maximum size is 728px.', 'redux-framework-b4theme' ),
                            'validate'     => 'html',
                            'default'      => '<img src="'.get_bloginfo('template_directory') . '/img/ads728.png" alt="advertisement" />',
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your ad code in the space provided.',
                            ),
                            'allowed_html' => array( '' ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                        ),
						array( // Pagar Broo :D
							'id'   => 'pagar-ads-1',
							'type' => 'divide',
						),
						array(
                            'id'       => 'switch-ads-2',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show ADS 2', 'redux-framework-b4theme' ),
                            'subtitle' => __( '', 'redux-framework-b4theme' ),
                            'default'  => 0,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'           => 'ads-2',
                            'type'         => 'textarea',
							'required' => array( 'switch-ads-2', '=', '1' ),
                            'title'        => __( 'ADS 2', 'redux-framework-b4theme' ),
                            'subtitle'     => __( 'These ads will appear in the post, after the title of the article / post.', 'redux-framework-b4theme' ),
                            'desc'         => __( 'Put your ad code in the field above. Sample sizes 300x250, 336x280, 728x90, 300x600, 320x100 and others. The length of the maximum size is 728px.', 'redux-framework-b4theme' ),
                            'validate'     => 'html',
                            'default'      => '<img src="'.get_bloginfo('template_directory') . '/img/ads728.png" alt="advertisement" />',
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your ad code in the space provided.',
                            ),
                            'allowed_html' => array( '' ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                        ),
						array( // Pagar Broo :D
							'id'   => 'pagar-ads-2',
							'type' => 'divide',
						),
						array(
                            'id'       => 'switch-ads-3',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show ADS 3', 'redux-framework-b4theme' ),
                            'subtitle' => __( '', 'redux-framework-b4theme' ),
                            'default'  => 0,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'           => 'ads-3',
                            'type'         => 'textarea',
							'required' => array( 'switch-ads-3', '=', '1' ),
                            'title'        => __( 'ADS 3', 'redux-framework-b4theme' ),
                            'subtitle'     => __( 'These ads will appear in the post, after the article / post is complete.', 'redux-framework-b4theme' ),
                            'desc'         => __( 'Put your ad code in the field above. Sample sizes 300x250, 336x280, 728x90, 300x600, 320x100 and others. The length of the maximum size is 728px.', 'redux-framework-b4theme' ),
                            'validate'     => 'html',
                            'default'      => '<img src="'.get_bloginfo('template_directory') . '/img/ads728.png" alt="advertisement" />',
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your ad code in the space provided.',
                            ),
                            'allowed_html' => array( '' ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                        ),
						array( // Pagar Broo :D
							'id'   => 'pagar-ads-3',
							'type' => 'divide',
						),
						array(
                            'id'       => 'switch-ads-4',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show ADS 4', 'redux-framework-b4theme' ),
                            'subtitle' => __( '', 'redux-framework-b4theme' ),
                            'default'  => 0,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'           => 'ads-4',
                            'type'         => 'textarea',
							'required' => array( 'switch-ads-4', '=', '1' ),
                            'title'        => __( 'ADS 4', 'redux-framework-b4theme' ),
                            'subtitle'     => __( 'These ads will appear after Gallery singles before Related.', 'redux-framework-b4theme' ),
                            'desc'         => __( 'Put your ad code in the field above. Sample sizes 300x250, 336x280, 728x90, 300x600, 320x100 and others. The length of the maximum size is 728px.', 'redux-framework-b4theme' ),
                            'validate'     => 'html',
                            'default'      => '<img src="'.get_bloginfo('template_directory') . '/img/ads728.png" alt="advertisement" />',
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your ad code in the space provided.',
                            ),
                            'allowed_html' => array( '' ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                        ),
						array( // Pagar Broo :D
							'id'   => 'pagar-ads-4',
							'type' => 'divide',
						),
						array(
                            'id'       => 'switch-ads-5',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show ADS 5', 'redux-framework-b4theme' ),
                            'subtitle' => __( '', 'redux-framework-b4theme' ),
                            'default'  => 0,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
                            'id'           => 'ads-5',
                            'type'         => 'textarea',
							'required' => array( 'switch-ads-5', '=', '1' ),
                            'title'        => __( 'ADS 5', 'redux-framework-b4theme' ),
                            'subtitle'     => __( 'These ads will appear after 4 first post.', 'redux-framework-b4theme' ),
                            'desc'         => __( 'Put your ad code in the field above. Sample sizes 300x250, 336x280, 728x90, 300x600, 320x100 and others. The length of the maximum size is 728px.', 'redux-framework-b4theme' ),
                            'validate'     => 'html',
                            'default'      => '<img src="'.get_bloginfo('template_directory') . '/img/ads728.png" alt="advertisement" />',
							'hint'     => array(
                                //'title'     => '',
                                'content' => 'Insert your ad code in the space provided.',
                            ),
                            'allowed_html' => array( '' ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                        ),
                    )
                );
				
				$this->sections[] = array(
					'title'  => __( 'Spinner Settings', 'redux-framework-b4theme' ),
                    'desc'   => __( 'Setting spinner feature in Image Attachment page.', 'redux-framework-b4theme' ),
                    'icon'   => 'el-icon-book',
					'fields' => array(
						array(
                            'id'       => 'switch-first-spinner',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show first Spinner', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'This spinner is shown after title in posting page image attachments.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
							'desc' 	   => __('<p><b>! First Spinner Rules !</b></p><p>Sentence 1, Sentence 2, Sentence 3, Sentence 4, Sentence 5, Sentence 6, Sentence 7, Sentence Post Name, Sentence 8, Sentence 9, Sentence 10, Sentence 11, Sentence Category Name, Sentence Tags Name, Sentence 12, Sentence 13, Sentence 14, Sentence Post Date, Sentence 15, Author Name.</p><p>Sentence Post Name, Sentence Category Name, Sentence Tags Name, Sentence Post Date, Author Name. Cannot be change.</p>', 'redux-framework-demo'),
                        ),
						array(
							'id'	   =>'opt-editor-spfirst-1-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('First sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'The',
						),
						array(
							'id'	   =>'opt-editor-spfirst-2-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Second sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{amazing|amusing|appealing|astonishing|astounding|awesome|breathtaking|captivating|charming|cool|enchanting|excellent|exciting|extraordinary|fascinating|glamorous|inspiring|interesting|marvellous|marvelous|mesmerizing|outstanding|remarkable|stunning|surprising|terrific|wonderful}',
						),
						array(
							'id'	   =>'opt-editor-spfirst-3-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Third sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'and cool',
						),
						array(
							'id'	   =>'opt-editor-spfirst-4-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Fourth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{photo|picture|pics|photograph|digital imagery|digital photography|image|images}',
						),
						array(
							'id'	   =>'opt-editor-spfirst-5-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Fifth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'below, is',
						),
						array(
							'id'	   =>'opt-editor-spfirst-6-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Sixth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{part|segment|section|other parts}',
						),
						array(
							'id'	   =>'opt-editor-spfirst-7-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Seventh sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'of',
						),
						array(
							'id'	   =>'opt-editor-spfirst-8-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Eighth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{article|document|post|publishing|piece of writing|content|written piece|editorial|report|write-up}',
						),
						array(
							'id'	   =>'opt-editor-spfirst-9-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Ninth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'which is',
						),
						array(
							'id'	   =>'opt-editor-spfirst-10-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Tenth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{categorized|classified|grouped|sorted|labeled|listed|categorised|classed as|arranged|assigned}',
						),
						array(
							'id'	   =>'opt-editor-spfirst-11-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Eleventh sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'within',
						),
						array(
							'id'	   =>'opt-editor-spfirst-12-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Twelfth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'and',
						),
						array(
							'id'	   =>'opt-editor-spfirst-13-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Thirteenth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{published|posted}',
						),
						array(
							'id'	   =>'opt-editor-spfirst-14-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Sentence Fourteenth', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'at',
						),
						array(
							'id'	   =>'opt-editor-spfirst-15-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-first-spinner', '=', '1' ),
							'title'    => __('Sentence Fifteenth', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'by',
						),
						array( // Pagar Broo :D
							'id'   => 'pagar',
							'type' => 'divide',
						),
						array(
                            'id'       => 'switch-second-spinner',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to show second Spinner', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'This Spinner is shown before footer in posting page image attachments.', 'redux-framework-b4theme' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
							'desc' 	   => __('<p><b>! Second Spinner Rules !</b></p><p>Sentence 1, Sentence 2, Sentence 3, Sentence 4, Sentence Tags Name, Sentence 5, Sentence 6, Sentence 7, Sentence 8,  Sentence Tags Name, Sentence 9, Sentence 10, Sentence Image Title, Sentence 11, Sentence 9, Sentence 12, Sentence 13, Sentence Post Name, Sentence 14, Link to Post.</p><p>Sentence Tags Name, Sentence Image Title, Sentence Post Name, and Link to Post. Cannot be change.</p>', 'redux-framework-demo'),
                        ),
						array(
							'id'	   =>'opt-editor-spsecond-1-sentence',
							'type' 	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('First sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'Here is',
						),
						array(
							'id'	   =>'opt-editor-spsecond-2-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Second sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{essential|important|crucial|foremost|fundamental|imperative|main|necessary|needful|required|wanted}',
						),
						array(
							'id'	   =>'opt-editor-spsecond-3-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Third sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{advice|recommendation|chapter|clue|data|info|instruction|knowledge|notification|science|tip}',
						),
						array(
							'id'	   =>'opt-editor-spsecond-4-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Fourth Sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'on',
						),
						array(
							'id'	   =>'opt-editor-spsecond-5-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Fifth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'We have the',
						),
						array(
							'id'	   =>'opt-editor-spsecond-6-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Sixth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{best|greatest|finest|excellent|cool|prime|tops|world class}',
						),
						array(
							'id'	   =>'opt-editor-spsecond-7-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Seventh sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{resources|assets|sources|method|source|step|substance}',
						),
						array(
							'id'	   =>'opt-editor-spsecond-8-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Eighth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'for',
						),
						array(
							'id'	   =>'opt-editor-spsecond-9-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Ninth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'Check it out for yourself! You can',
						),
						array(
							'id'	   =>'opt-editor-spsecond-10-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Tenth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{find|discover|gather|get|acquire}',
						),
						array(
							'id'	   =>'opt-editor-spsecond-11-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Eleventh sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'guide and',
						),
						array(
							'id'	   =>'opt-editor-spsecond-12-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Twelfth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => '{read|see|view|look}',
						),
						array(
							'id'	   =>'opt-editor-spsecond-13-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Thirteenth sentence', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'the latest',
						),
						array(
							'id'	   =>'opt-editor-spsecond-14-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Sentence Fourteenth', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'in',
						),
						array(
							'id'	   =>'opt-editor-spsecond-15-sentence',
							'type'	   => 'editor',
							'required' => array( 'switch-second-spinner', '=', '1' ),
							'title'    => __('Sentence Fifteenth', 'redux-framework-demo'), 
							'subtitle' => __('This is Usual sentence, and Sentence Spinner.', 'redux-framework-demo'),
							'desc' 	   => __('You can input Usual sentence "e.g. Your Usual Sentence" and You can input Sentence Spinner "e.g. {Text 1 | Text 2 | Text 3 | Text 4}".', 'redux-framework-demo'),
							//'validate' => '',
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your sentences into the fields.',
							),
							'default' => 'here.',
						)
					),
				);
				
				$this->sections[] = array(
                    'type' => 'divide',
                );
				
				$this->sections[] = array(
                    'title'  => __( 'Infinite Scroll Options', 'redux-framework-b4theme' ),
					'heading' => __( 'Infinite Scroll Text Messages', 'redux-framework-b4theme' ),
                    'desc'   => __( 'This fields to change text messages.', 'redux-framework-b4theme' ),
                    'icon'   => 'el-icon-repeat',
                    'fields' => array(
                        array(
                            'id'       => 'switch-infinite-scroll',
                            'type'     => 'switch',
                            'title'    => __( 'Enable to turn on Infinite Scroll.', 'redux-framework-b4theme' ),
                            'subtitle' => __( 'Enable to turn on Infinite Scroll. And disable to turn off.', 'redux-framework-b4theme' ),
                            'default'  => 0,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),
						array(
							'id'       => 'opt-load-text-message',
							'type'     => 'editor',
							'required' => array( 'switch-infinite-scroll', '=', '1' ),
							'title'    => __('Loading Text Message', 'redux-framework-demo'),
							'subtitle' => __('Loading Text Message on Infinite Scroll.', 'redux-framework-demo'),
							'desc'     => __('e.g. Loading posts ...', 'redux-framework-demo'),
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your message into the fields.',
							),
							//'validate' => '',
							'default'  => 'Loading posts ...',
						),
						array(
							'id'       => 'opt-done-text-message',
							'type'     => 'editor',
							'required' => array( 'switch-infinite-scroll', '=', '1' ),
							'title'    => __('Finished Text Message', 'redux-framework-demo'),
							'subtitle' => __('Finished Text Message on Infinite Scroll.', 'redux-framework-demo'),
							'desc'     => __('e.g. No more posts!', 'redux-framework-demo'),
							'args'	  => array(
								'media_buttons' => false,
								'quicktags' 	=> true,
							),
							'hint' 	   => array(
								//'title' => '',
								'content' => 'Put your message into the fields.',
							),
							//'validate' => '',
							'default'  => 'No more posts!',
						),
                    ),
                );

				$this->sections[] = array(
                    'type' => 'divide',
                );
				
                $this->sections[] = array(
                    'title'  => __( 'Import / Export', 'redux-framework-b4theme' ),
                    'desc'   => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-b4theme' ),
                    'icon'   => 'el-icon-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your Redux options',
                            'full_width' => false,
                        ),
                    ),
                );

                $this->sections[] = array(
                    'type' => 'divide',
                );

                $this->sections[] = array(
                    'icon'   => 'el-icon-info-sign',
                    'title'  => __( 'Theme Information', 'redux-framework-b4theme' ),
                    'desc'   => __( '<!--<p class="description">This is the Description. Again HTML is allowed</p>-->', 'redux-framework-b4theme' ),
                    'fields' => array(
                        array(
                            'id'      => 'opt-raw-info',
                            'type'    => 'raw',
                            'content' => $item_info,
                        )
                    ),
                );

                if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
                    $tabs['docs'] = array(
                        'icon'    => 'el-icon-book',
                        'title'   => __( 'Documentation', 'redux-framework-b4theme' ),
                        'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
                    );
                }
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Author Information', 'redux-framework-b4theme' ),
                    'content' => __( '<p> Im just a teenager like others. </p> <p> But I want to learn about the program. </p> <p> And I wish I could ! :D </p> <p> If you want to become acquainted with me, you can found me in <a href="https://www.facebook.com/bagusa4/" title="Found me on Facebook" target="_blank"><i class="el-icon-facebook"></i></a> and <a href="http://twitter.com/bagusa4/" title="Follow me on Twitter" target="_blank"><i class="el-icon-twitter"></i></a> :D </p>', 'redux-framework-b4theme' )
                );
				
				$this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-3',
                    'title'   => __( 'Donate', 'redux-framework-b4theme' ),
                    'content' => __( '<div class="admin-donate" style="margin: 6px; padding: 6px;width: 100%;float: left;height: 100%;"><p style="text-align: center;">Just for support :D</p><div style="display: flex;"><div class="d-bitcoin"><a href="https://vip.bitcoin.co.id/ref/Bagusa4"><img src="https://s3.amazonaws.com/bitcoin.co.id/banner/300x250.jpg" alt="" /></a></div><div class="d-paypal"><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"> <input type="hidden" name="cmd" value="_donations"> <input type="hidden" name="business" value="W8X3ZY4N9Z29N"> <input type="hidden" name="lc" value="ID"> <input type="hidden" name="item_name" value="Bagusa4"> <input type="hidden" name="currency_code" value="USD"> <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted"> <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"> </form></div></div></div>', 'redux-framework-b4theme' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<a href="http://bagusa4.tk" target="_blank"><img style="margin: 0 10px;" src="http://bagusa4.tk/public/bagusa4logomini.png"></img></a><p style="text-align: center;"><b> :D . (: <a href="http://bagusa4.tk" target="_blank">Bagusa4</a> :) . :D</b></p>', 'redux-framework-b4theme' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'redux_tween_fift',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'TweenFift Options', 'redux-framework-b4theme' ),
                    'page_title'           => __( 'TweenFift Options', 'redux-framework-b4theme' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => true,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-tween-fift-docs',
                    'href'   => 'http://bagusa4.tk/tweenfift/details/',
                    'title' => __( 'Documentation', 'redux-framework-b4theme' ),
                );

                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-tween-fift-support',
                    'href'   => 'http://bagusa4.tk/forums/',
                    'title' => __( 'Support', 'redux-framework-b4theme' ),
                );

                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-tween-fift-extensions',
                    'href'   => 'http://bagusa4.tk/Bagusa4-Theme/comingsoon/',
                    'title' => __( 'Extensions', 'redux-framework-b4theme' ),
                );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://github.com/Bagusa4/',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://www.facebook.com/bagusa4/',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://twitter.com/bagusa4/',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el-icon-twitter'
                );
				$this->args['share_icons'][] = array(
                    'url'   => 'https://plus.google.com/+BagusAhmadSetiawan/',
                    'title' => 'Follow us on Google+',
                    'icon'  => 'el-icon-googleplus'
                );
				$this->args['share_icons'][] = array(
                    'url'   => 'http://instagram.com/bagusa4/',
                    'title' => 'Follow us on Instagram',
                    'icon'  => 'el-icon-instagram'
                );
				$this->args['share_icons'][] = array(
                    'url'   => 'http://www.pinterest.com/bagusa4/',
                    'title' => 'Follow us on Pinterest',
                    'icon'  => 'el-icon-pinterest'
                );
				$this->args['share_icons'][] = array(
                    'url'   => 'https://www.youtube.com/user/TheBagusa4/',
                    'title' => 'Follow us on YouTube',
                    'icon'  => 'el-icon-youtube'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://www.linkedin.com/',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el-icon-linkedin'
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
					if ( ! isset( $this->args['dev_mode'] ) && $this->args['dev_mode'] == true ) {
                    $this->args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-b4theme' ), $v );
					}
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-b4theme' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>Thanks for using my theme :D. If you have problem about my theme, just visit <a href="http://bagusa4.tk/forums/forum/theme-support/" target="_blank">here</a> to cantact me. If you want anymore, you can find in <a href="http://bagusa4.tk/" target="_blank">here</a>. :D Thanks! :)</p>', 'redux-framework-b4theme' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_b4theme_tweenfift_config();
    } else {
        echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;
