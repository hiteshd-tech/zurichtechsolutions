<?php
    /*
    Plugin Name: Wordpress Search
    Plugin URI: http://wpsearch.markcoker.com.au/
    Description: Assisting administrators locate any reference within the whole of Wordpress without even leaving Wordpress!
    Version: 1.2
    Author: Mark Coker
    Author URI: http://markcoker.com.au
    Text Domain: wpFileSearch
    Domain Path: /languages
    License: GPL
    */

    defined( 'ABSPATH' ) or die( esc_html__( 'Script kiddie #fail, contact us if you find something, be nice :) thanks!', 'wpFileSearch' ));
    
	function wpFileSearch_ajax_response(){ 
	    if ( !current_user_can( 'manage_options' ) )  {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wpFileSearch' ));
        }
		$dir = get_home_path();
        $results = 0;
       	if (isset($_GET['search'])) {
			$searchTerm = $_GET['search'];
            $iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST );
            foreach ($iterator as $path) {
                $content = file_get_contents($path->getPathname());
                if (strpos($content, $searchTerm) !== false) { 
                	$location = str_replace($dir, '' , $path->getPathname());
                    echo "<option value='".$location."'>".$location."</option>\r\n";  
                    $results = $results + 1;
                }
            }
        	if ($results == 0){ 
				echo'<script>wpFileSearch_notFound("'.$searchTerm.'");</script>';
        	}
    	} die();
    }
	
	function wpFileSearch_position($file,$locateString){
		return strpos($file,$locateString);
	}
	
	function wpFileSearch_endOfBase($file,$baseDir){ 
		return wpFileSearch_position($file,$baseDir) + strlen($baseDir) + 1;
	}
	
	function wpFileSearch_stripped($file,$baseDir){
		return substr($file, wpFileSearch_endOfBase($file,$baseDir), strlen($file) - wpFileSearch_endOfBase($file,$baseDir));
	}
	
	function wpFileSearch_formed($file,$baseDir){
		return get_home_path().$baseDir.'/'.wpFileSearch_stripped($file,$baseDir);
	}
	
	function wpFileSearch_extension($file,$wpFileSearch_position){
		$dot = substr($file, - ($wpFileSearch_position) - 1, 1);
		if (strcmp($dot,".") == 0){
			return true;
		}else{
			return false;
		}
	}
	
	function wpFileSearch_directoryProtection($file){
		$admin = 'wp-admin';
		$content = 'wp-content';
		$includes = 'wp-includes';

		if (wpFileSearch_extension($file,2) || wpFileSearch_extension($file,3) || wpFileSearch_extension($file,4)){ //eg: .js .txt .html
			if (wpFileSearch_position($file,$admin) !== false){ 
				return wpFileSearch_formed($file,$admin);
			}else if (wpFileSearch_position($file,$content) !== false){
				return wpFileSearch_formed($file,$content);
			}else if (wpFileSearch_position($file,$includes) !== false){ 
				return wpFileSearch_formed($file,$includes);
			}else if (wpFileSearch_position($file,'/') !== false || wpFileSearch_position($file,'\\') !== false) {
				wp_die( esc_html__( 'Sneaky, sorry but i cant allow this. Are you sure this is a wordpress file?', 'wpFileSearch' ));
			}
			else{
				return substr(get_home_path(), 0 ,strlen(get_home_path())).$file;
			}
		}wp_die(esc_html__('Invalid or no file wpFileSearch_extension.','wpFileSearch'));
	}
	
	function wpFileSearch_fetch_file(){
		if (isset($_GET['file'])) {
			$file = wpFileSearch_directoryProtection($_GET['file']);
			if ($file != NULL){
				$fileContent = file_get_contents($file);
				if ($fileContent !== false){
					echo htmlspecialchars($fileContent);
				}
			}
		}die();
	}

	function wpFileSearch_form(){
		echo "
		<div class='wpFileSearch-wrap'> 
			<p>
				<b>
					".esc_html__('Wordpress Search','wpFileSearch') ."<br/>
					". esc_html__('Assisting administrators locate any reference within the whole of wordpress without even leaving wordpress!','wpFileSearch') ."
				</b>
			</p>
			<form onsubmit='return false;'>
				". esc_html__('Search files for:','wpFileSearch') ."<br>
				<input type='text' placeholder='function search' onkeyup='wpFileSearch()' id='wpFileSearch-searchTerm'/> <span id='wpFileSearch-status'> </span>
			</form>
			<p id='wpFileSearch-resultsFound' style='display: none;'>
			<br id='wpFileSearch-resultsTitle'/>". esc_html__('Results:','wpFileSearch') ."
			<select name='files' id='wpFileSearch-searchResults'> </select>
			<br>
			<button onclick='wpFileSearch_getFileContents();'>". esc_html__('load file','wpFileSearch') ."</button>
			</p>
			<p style='display: none;' id='wpFileSearch-loadContents' >
			<textarea rows='20' cols='50' id='wpFileSearch-fileContents'></textarea>
			</p>
		</div>
		";
	}

    function wpFileSearch_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.','wpFileSearch'));
        }
		wp_register_script('wpFileSearch_ajax',plugins_url('wpFileSearch_ajax.js', __FILE__), array('jquery'),'1.1', true);
		wp_localize_script ('wpFileSearch_ajax','wpFileSearch_vars', 
		array (
			'notFound' => esc_html__('Sorry, none of the files contained ', 'wpFileSearch'), 
			'fetching' => esc_html__('Fetching file content . . .', 'wpFileSearch'), 
			'typing' => esc_html__('User is typing.', 'wpFileSearch'), 
			'searching' => esc_html__('Searching . . .', 'wpFileSearch'),
			'inputTooLong' => esc_html__('Input is too long.', 'wpFileSearch'),
			'waitingForInput' => esc_html__('Waiting for user input.', 'wpFileSearch'),
			'done' => esc_html__('Done.', 'wpFileSearch'),
			'searchFailed' => esc_html__('Error: Search failed.', 'wpFileSearch'),
			'fetched' => esc_html__('File has been fetched.', 'wpFileSearch'),
			'cantBeLoaded' => esc_html__('Error: File contents could not be loaded.', 'wpFileSearch')
			)
		);
		wp_enqueue_script('wpFileSearch_ajax');
		wp_register_style('wpFileSearch_style', plugins_url('wpFileSearch_style.css', __FILE__));
		wp_enqueue_style('wpFileSearch_style');
        wpFileSearch_form();
    }
    
    function wpFileSearch_load_plugin_textdomain() {
    	load_plugin_textdomain( 'wpFileSearch', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
    function wpFileSearch_menu() { 
        add_menu_page( 'WP File Search Options', 'Search', 'manage_options', 'wpFileSearch', 'wpFileSearch_options', plugins_url('assets/icon-grey-16x16.png', __FILE__));
    }
    add_action( 'admin_menu', 'wpFileSearch_menu' );
    add_action( 'wp_ajax_wpFileSearch_ajax_response', 'wpFileSearch_ajax_response' );
    add_action( 'wp_ajax_wpFileSearch_fetch_file', 'wpFileSearch_fetch_file' );
    add_action( 'plugins_loaded', 'wpFileSearch_load_plugin_textdomain' );
?>
