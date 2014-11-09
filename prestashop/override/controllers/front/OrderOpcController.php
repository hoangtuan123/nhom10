<?php

class OrderOpcController extends OrderOpcControllerCore
{

	protected function _assignCarrier()
    {
       	parent::_assignCarrier();
    	if (!$this->context->customer->is_guest) {
        	//self::$smarty->assign('HOOK_SENDSMS_CUSTOMER_CHOICE', Hook::exec('sendsmsCustomerChoice', array('cart' => $this->context->cart)));
        	// en attendant de trouver comment récupérer le check de la case (ajax ?) on renvoit vide
        	self::$smarty->assign('HOOK_SENDSMS_CUSTOMER_CHOICE', '');
        }
    }

    protected function _getPaymentMethods()
	{
		/*if (!$this->context->customer->is_guest && Module::isInstalled('sendsms')) {
			if (Hook::exec('sendsmsCustomerChoice', array('submit' => true, 'customerChoice' => isset($_POST['sendsms']) ? $_POST['sendsms'] : null)) === '-1') {
				//bug dans OrderController.php si on renvoit une erreur
			    //$module = Module::getInstanceByName('sendsms');
				//$this->errors[] = Tools::displayError($module->l2('customer_phone_error', $this->context->language->id));
			}
		}*/

		return parent::_getPaymentMethods();
	}
}

