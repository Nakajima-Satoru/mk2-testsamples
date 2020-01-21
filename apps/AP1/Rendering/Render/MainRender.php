<?php

/**
 * MainRender
 */

 namespace mk2\core;

class MainRender extends Render{

	public function __construct($option){
		parent::__construct($option);
	}

	public function viewTest(){
		return "<p>MainRender View Test Sample....</p>";
	}

}