<?php
    class Poster extends MyFramework\BaseController {
        function GET($matches = NULL) {
            echo '<form name="form1" method="POST" action="">';
            echo '<input type="text" name="textbox1">';
            echo '<input type="submit" name="submit">';
            echo '</form>';
        }

        function POST($matches = NULL) {
            $post = $this->parent()->get_contents();

            if (isset($post->parameters['textbox1']))
                echo 'The value you entered was ' . $post->parameters['textbox1'] . "\n\n";
        }
    }