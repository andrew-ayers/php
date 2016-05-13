<?php

/******************************************************************************/
/* From php manual - just experimenting here...
/******************************************************************************/
/* from http://php.net/manual/en/language.oop5.autoload.php
/******************************************************************************/

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

/******************************************************************************/
/* Mostly from http://php.net/manual/en/language.oop5.abstract.php
/******************************************************************************/

interface InterfaceClass {

    // A class which implements this interface must define this method
    public function myNewInterface($yolo);
}

/******************************************************************************/

abstract class AbstractClass {

    // Force Extending class to define this method
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // Common method (this can be overridden)
    public function printOut() {
        print $this->getValue() . "\n";
    }
}

/******************************************************************************/

class ConcreteClass1 extends AbstractClass {

    protected function getValue() {
        return "ConcreteClass1";
    }

    public function prefixValue($prefix) {
        return "{$prefix}ConcreteClass1";
    }
}

/******************************************************************************/

class ConcreteClass2 extends AbstractClass implements InterfaceClass {

    public function myNewInterface($stuff) {
        return "A new interface here - {$stuff}";
    }
    
    public function getValue() {
        return "ConcreteClass2";
    }

    public function prefixValue($prefix) {
        return "{$prefix}ConcreteClass2";
    }
    
    public function printOut() {
        print "OVERRIDE: Your subconscious robot.\n";
    }
}

/******************************************************************************/

$class1 = new ConcreteClass1;

$class1->printOut();

echo $class1->prefixValue('FOO_') ."\n";

/******************************************************************************/

$class2 = new ConcreteClass2;

$class2->printOut();

echo $class2->prefixValue('FOO_') ."\n";

echo $class2->myNewInterface('yolo') . "\n";

?>
