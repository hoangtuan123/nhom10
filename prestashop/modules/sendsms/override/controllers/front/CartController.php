<?php

class CartController extends CartControllerCore
{
    public function preProcess()
	{
		$idProduct = (int)Tools::getValue('id_product', NULL);
		if ($idProduct == (int)Configuration::get('SENDSMS_ID_PRODUCT')) {
			$result = $this->context->cart->containsProduct($idProduct);
			if (!empty($result['quantity']) || $this->context->customer->is_guest) {
				unset($_POST['add']);
				unset($_GET['add']);
			}
		}

		parent::preProcess();
	}
}
?>