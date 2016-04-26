<?php

function println($ln){
	print $ln . "\n";
}


##################


interface FlyBehavior {
	function fly();
}

interface QuackBehavior {
	function quack();
}

class LaserQuack implements QuackBehavior {
	function quack(){
		println("Laser Quack! with FIRE!");
	}
}

class FireQuack

class JetPack implements FlyBehavior {
	function fly(){
		println("Flying with a fucking rocket yo!");
	}
}

abstract class Duck {
	private $fb;
	private $qb;

	function Duck(FlyBehavior $fb, QuackBehavior $qb) {
		$this->qb = $qb;
		$this->fb = $fb;
	}
	function doQuack(){
		$this->qb->quack();
	}
	function doFly(){
		$this->fb->fly();
	}
	abstract function display();
}
	
class RoboDuck extends Duck {
	
	function display(){
		println("Don't fuck with this duck!");
	}
}


$roboduck = new RoboDuck(new JetPack(), new LaserQuack());
$roboduck->display();
$roboduck->doQuack();
$roboduck->doFly();