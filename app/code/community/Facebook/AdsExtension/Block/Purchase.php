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

class Facebook_AdsExtension_Block_Purchase
  extends Facebook_AdsExtension_Block_Common {

  private $orderData = array();

  protected function _prepareLayout() {
    $order = Mage::getSingleton('sales/order');
    $order->loadByIncrementId(
      Mage::getSingleton('checkout/session')->getLastRealOrderId()
    );
	   $loadModel=Mage::getModel('catalog/product_type_configurable') ;
    $totalData = $order->getData();
    $allitems = $order->getAllVisibleItems();

    $this->orderData['value'] = $totalData['grand_total'];
    $this->orderData['content_ids'] = array();
    foreach ($allitems as $item) {
     // $this->orderData['content_ids'][] = $item->getData('product_id');
		
		 if (Mage::getModel('catalog/product')->load($item->getData('product_id'))->getTypeId()== "simple") {
      $parentIds = $loadModel ->getParentIdsByChild($item->getProductId());
	      if (!empty($parentIds) && is_array($parentIds) && $parentIds[0]) {
         $this->orderData['content_ids'][]  = $parentIds[0];
      }
	}
		else{
			 $this->orderData['content_ids'][] = $item->getProductId();
		}
		
    }
  }

  public function getValue() {
    return $this->orderData['value'];
  }

  public function getContentIDs() {
    return $this->arryToContentIdString($this->orderData['content_ids']);
  }
}
