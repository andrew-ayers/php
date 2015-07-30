<?php
    class Apple {
        public function firstMethod($parameter1, $parameter2 = 'default2') { }
        final protected function secondMethod() { }
        private static function thirdMethod() { }
    }

    ///////////////////////////////////////////////////////////////////////////

    class Reflection {
        private $features = array();

        public function __construct($class_name = null) {
            $class_name = isset($class_name) ? $class_name : get_class();

            $rc = new ReflectionClass($class_name);

            $methods = array();

            foreach($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $method_name = $method->getName();

                $rm = new ReflectionMethod($class_name, $method_name);

                $parameters = array();

                foreach ($rm->getParameters() as $param) {
                    $parameters[] = array(
                        'name'        => $param->getName(),
                        'position'    => $param->getPosition(),
                        'allows_null' => $param->allowsNull(),
                        'is_array'    => $param->isArray(),
                        'default'     => $param->isOptional() ? $param->getDefaultValue() : null
                    );
                }

                $methods[] = array(
                    'name'       => $method_name,
                    'parameters' => $parameters
                );
            }

            $this->features[] = array(
                'class'            => $class_name,
                'public_methods'   => $methods
            );
        }

        public function getFeatures() {
            return $this->features;
        }
    }

    ///////////////////////////////////////////////////////////////////////////

    $ur = new Reflection();//'Apple');

    $features = $ur->getFeatures();

    print "<pre>";

    var_dump($features);
?>