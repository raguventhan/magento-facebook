# magento-facebook
Facebooks ads plugin for magento version1.9

This extension based on "Facebook_Ads_Extension-2.6.0-fb". Modified following files in core folder
Purchase.php
AddToCart.php
FBProductFeed.php

Updates:

1) Update Configurable product sku to facebook in magento catalog to prevent pixel content id mismatch error in add to cart and purchase page.

2) Update configurable inventory status based on simple product availability while generating facebook product feed csv file.
