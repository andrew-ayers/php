<?php
/**
 * @package Lucky_Number
 * @version 1.0
 *
 * Plugin Name: Lucky Number
 * Description: A very basic OOP-style plugin
 * Author: Andrew L. Ayers
 * Version: 1.0
 * Author URI: http://www.phoenixgarage.org/
 */
class WP_Lucky_Number {
    private $max_number;
 
    public function __construct($maximum = 10) {
        $this->max_number = $maximum;
        
        add_action( 'admin_head', array( $this, 'lucky_number_css' ) );
        add_action( 'admin_notices', array( $this, 'lucky_number' ) );
    }
 
    /**
     * Choose a lucky number
     *
     * @param int $max_number The maximum random value.
     * @return Returns a number from 1 - $max_number.
     */
    private function get_lucky_number($max_number = 10) {
        // wptexturize() is not really needed here, since we're only dealing
        // with a number, but it is something that should be noted as useful for
        // more complex plugins.
	    return wptexturize( mt_rand( 1, $max_number ) );
    }

    /**
     * Echo the lucky number
     */
    public function lucky_number() {
	    $lucky_number = $this->get_lucky_number($this->max_number);
	    echo "<p id='lucky_number'>Your current <b>Lucky Number</b> is: $lucky_number</p>";
    }

    /**
     * Echo some CSS to position things
     */
    public function lucky_number_css() {
	    // for right-to-left languages
	    $x = is_rtl() ? 'left' : 'right';

	    echo "
	    <style type='text/css'>
	    #lucky_number {
		    float: $x;
		    padding-$x: 15px;
		    padding-top: 5px;		
		    margin: 0;
		    font-size: 11px;
	    }
	    </style>
	    ";
    }
}
 
$wp_lucky_number = new WP_Lucky_Number(64);

?>
