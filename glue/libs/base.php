<?php namespace MyFramework;

class Object {
    public function parent() {
        return $this;
    }

    public function parent_name() {
        return get_parent_class($this);
    }
}

class BaseController extends Object {
    private $ctype;
    private $method;
    private $filters;
    private $contents;

    public function __construct(&$matches = NULL) {

        if (isset($_SERVER['CONTENT_TYPE']))
            $this->ctype = $_SERVER['CONTENT_TYPE'];

        $this->filters = new Filters();

        $this->method = "clean_".strtoupper($_SERVER['REQUEST_METHOD']);

        if (method_exists($this, $this->method)) {
            $this->{$this->method}($matches);
        }
        else {
            throw new BadMethodCallException("Method [$this->method] not supported");
        }
    }

    private function clean_GET(&$matches = NULL) {
        $matches = $this->filters->filter_array($matches);
    }

    private function clean_POST(&$matches = NULL) {
        $matches = $this->filters->filter_array($matches);
        $this->clean_content();

        //$_POST = $this->filters->filter_array($_POST);
    }

    private function clean_PUT(&$matches = NULL) {
        $matches = $this->filters->filter_array($matches);
        $this->clean_content();
    }

    private function clean_DELETE(&$matches = NULL) {
        $matches = $this->filters->filter_array($matches);
    }

    private function clean_content() {
        $parameters = array();

        $content = file_get_contents("php://input");

	$format = "html";

        switch($this->ctype) {
            case "application/json":
                $params = json_decode($content);

                if ($params) {
                    foreach($params as $param_name => $param_value) {
                        $parameters[$param_name] = $param_value;
                    }
                }

                $format = "json";
                break;

            case "application/x-www-form-urlencoded":
                parse_str($content, $postvars);

                foreach($postvars as $field => $value) {
                    $parameters[$field] = $value;
                }

                $format = "html";
                break;

            default:
                break;
        }

        $this->contents = (object) array(
            'content'    => $content,
            'parameters' => $parameters,
            'format'     => $format
        );
    }

    public function get_contents() {
        return $this->contents;
    }

    public function GET($matches = NULL) {}

    public function POST($matches = NULL) {}

    public function PUT($matches = NULL) {}

    public function DELETE($matches = NULL) {}

    public function derp() {
        echo "DERP!\n\n";
    }
}
