<?php

namespace mk2\core;

class TestPacker extends Packer{

	public function run(){

		$this->set("title","abcdefg");
		echo $this->getRender("Page/rendertest");

	}
}