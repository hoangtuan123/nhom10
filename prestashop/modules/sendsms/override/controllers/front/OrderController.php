<?php

class OrderController extends OrderControllerCore
{
    protected function _assignCarrier()
    {
       	parent::_assignCarrier();
    	if (!$this->context->customer->is_guest) {
        	self::$smarty->assign('HOOK_SENDSMS_CUSTOMER_CHOICE', Hook::exec('sendsmsCustomerChoice', array('cart' => $this->context->cart)));
        }
    }

	protected function processCarrier()
	{
		if (!$this->context->customer->is_guest && Module::isInstalled('sendsms')) {
			if (Hook::exec('sendsmsCustomerChoice', array('submit' => true, 'customerChoice' => isset($_POST['sendsms']) ? $_POST['sendsms'] : null)) === '-1') {
				//bug dans OrderController.php si on renvoit une erreur
			    //$module = Module::getInstanceByName('sendsms');
				//$this->errors[] = Tools::displayError($module->l2('customer_phone_error', $this->context->language->id));
			}
		}

		parent::processCarrier();
	}
}
?>