<?php

/**
 * @author      Sam Mahoney for http://www.juvidesigns.com
 * @copyright   Copyright (C) 2015 - Sam Mahoney
 */

class Juvi_Homepage_Block_Homepage extends Mage_Core_Block_Template {

	public function getValue($value) {
		return Mage::getStoreConfig('homepage/settings/'.$value);
	}
	
	public function getCarouselArray() {
		$carousel = array(
			$this->getValue('image_1') => $this->getValue('text_1'),
			$this->getValue('image_2') => $this->getValue('text_2'),
			$this->getValue('image_3') => $this->getValue('text_3'),
			$this->getValue('image_4') => $this->getValue('text_4')
		);
		return $carousel;
	}

}
