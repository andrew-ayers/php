<?php
/**
 * The following curl requests can test PUT and DELETE verbs:
 *
 *      PUT (post) -> curl -X PUT http://23.111.254.254/andrew/php/glue/put -d value=hello -d quantity=13
 *      PUT (json) -> curl -X PUT http://23.111.254.254/andrew/php/glue/put -H "Content-Type: application/json" -d '{"value":"hello","quantity":"13"}'
 *
 *      DELETE -> curl -X DELETE http://23.111.254.254/andrew/php/glue/delete/234
 *
 * Also note that on an actual PUT request, a file would be found in $post->contents, and that POST parameters should -never- be passed
 */
class Extended extends MyFramework\BaseController {
    function PUT($matches = NULL) {
        $post = $this->parent()->get_contents();

        echo "This is a PUT request\n";

        if (isset($post->parameters['value']))
            echo $post->parameters['value']." is the value\n";

        if (isset($post->parameters['quantity']))
            echo $post->parameters['quantity']." is the quantity\n";

        if (isset($post->format))
            echo $post->format." is the format\n\n";
    }

    function DELETE($matches = NULL) {
        echo "This is a DELETE request\n";

        if (isset($matches[1])) {
            echo "Item to delete: " . $matches[1] . "\n\n";
        }
        else {
            echo "No item specified to delete...\n\n";
        }
    }
}