<?php

namespace mk2\core;

Import::Controller("App");

class PageController extends AppController{

	public function index(){}
	public function nopage(){
		$this->autoRender=false;

		$this->setPacker([
			"Test",
		]);
		$this->Packer->Test->run();
	}

}