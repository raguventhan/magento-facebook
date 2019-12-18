<?php
/**
 * Copyright (c) 2016-present, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the code directory.
 */

if (file_exists(__DIR__.'/common.php')) {
  include_once 'common.php';
} else {
  include_once 'Facebook_AdsExtension_Block_common.php';
}

class Facebook_AdsExtension_Block_InitiateCheckout
  extends Facebook_AdsExtension_Block_Common {

  public function getContentIDs() {
	  $loadModel=Mage::getModel('catalog/product_type_configurable') ;
    $products = array();
    $items =  Mage::getSingleton('checkout/session')->getQuote()->getAllVisibleItems();
    foreach ($items as $item) {
      //$products[] = $item->getProductId();
	 // If we added an invisible product, add the parent instead otherwise the add to cart pixel fire won't match.
  //  $productType = Mage::getModel('catalog/product')->load($item->getProductId())->getTypeId();
    if (Mage::getModel('catalog/product')->load($item->getProductId())->getTypeId()== "simple") {
      $parentIds = $loadModel ->getParentIdsByChild($item->getProductId());
	      if (!empty($parentIds) && is_array($parentIds) && $parentIds[0]) {
        $products[]  = $parentIds[0];
      }
	}
		else{
			$products[] = $item->getProductId();
		}
		
    }
    return $this->arryToContentIdString($products);
  }

  public function getValue() {
    $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals();
    return $totals['grand_total']->getValue() ?: 0;
  }
}
