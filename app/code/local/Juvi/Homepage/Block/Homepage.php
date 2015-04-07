<?php

/**
 * @author      Sam Mahoney for http://www.juvidesigns.com
 * @copyright   Copyright (C) 2015 - Sam Mahoney
 */

class Juvi_Homepage_Block_Homepage extends Mage_Core_Block_Template {

	public function getValue($value) {
		return Mage::getStoreConfig('homepage/settings/'.$value);
	}

}
