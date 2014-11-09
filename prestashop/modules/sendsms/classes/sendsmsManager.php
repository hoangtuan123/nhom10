<?php
/*
 * @module		sendsms
 * @copyright  	Copyright (c) 2012 Yann BONNAILLIE (http://www.prestaplugins.com)
 * @author     	Yann BONNAILLIE
 * @license    	Commercial license
 * Support by mail  : contact@prestaplugins.com
 * Support on forum : Patanock
 * Support on Skype : Patanock13
 */

include_once(_PS_MODULE_DIR_.'sendsms/classes/sms.php');
include_once(_PS_MODULE_DIR_.'sendsms/models/sendsmsLogs.php');

class sendsmsManager
{
	const __SENDSMS_CUSTOMER__ = 1;
	const __SENDSMS_ADMIN__ = 2;
	const __SENDSMS_BOTH__ = 3;

	private $_module = 'sendsms';
	private $_labels = array();
	private static $_hookName;
	private static $_params;
	private static $_phone = '';
	private static $_email;
	private static $_password;
	private static $_prestaKey;
	private static $_balance = 0;
	private static $_txt = '';
	private static $_recipient;
	private static $_paid_by_customer = 0;
	private static $_simulation = 0;
	private static $_event = '';

	private static $_config = array(
		'sendsmsFree' => 0,
	    'actionCustomerAccountAdd' => self::__SENDSMS_BOTH__,
	    'actionPasswordRenew' => self::__SENDSMS_CUSTOMER__,
		'sendsmsCustomerAlert' => self::__SENDSMS_CUSTOMER__,
	    'sendsmsContactForm' => self::__SENDSMS_BOTH__,
	    'actionValidateOrder' => self::__SENDSMS_BOTH__,
	    'actionOrderReturn' => self::__SENDSMS_ADMIN__,
	    'actionAdminOrdersTrackingNumberUpdate' => self::__SENDSMS_CUSTOMER__,
	    'actionUpdateQuantity' => self::__SENDSMS_ADMIN__,
	    'sendsmsAdminAlert' => self::__SENDSMS_ADMIN__,
	    'sendsmsDailyReport' => self::__SENDSMS_ADMIN__,
	    'actionOrderStatusPostUpdate' => self::__SENDSMS_CUSTOMER__
	);

	static public function isAccountAvailable($email, $password, $prestaKey)
	{
		if (!empty($email) && !empty($password) && !empty($prestaKey)) {
			$sms = new SMS();
			$sms->setSmsLogin($email);
			$sms->setSmsPassword($password);
			$sms->setPrestaKey($prestaKey);
			$result = $sms->number();
			if (strpos($result, 'KO') !== false) {
				return false;
			} else {
				self::$_email = $email;
				self::$_password = $password;
				self::$_prestaKey = $prestaKey;
				self::$_balance = empty($result) ? 0 : (float)$result;
				$alertLevel = (int)Configuration::get('SENDSMS_ALERT_LEVEL');
				if ($alertLevel > 0 && self::$_balance > $alertLevel) {
					Configuration::updateValue('SENDSMS_ALERT_SENT', '0');
				}
				return true;
			}
		}
		return false;
	}

	static public function getXmlRss($email, $password, $prestaKey)
	{
		if (!empty($email) && !empty($password) && !empty($prestaKey)) {
			$sms = new SMS();
			$sms->setSmsLogin($email);
			$sms->setSmsPassword($password);
			$sms->setPrestaKey($prestaKey);
			$result = $sms->rss();
			if (strpos($result, 'KO') !== false) {
				return false;
			} else {
				return $result;
			}
		}
		return false;
	}

	static public function getBalance()
	{
		return self::$_balance;
	}

	static public function getConfig()
	{
		foreach(self::$_config as $key => $value) {
			$hook_id = Hook::getIdByName($key);
			if ($hook_id || $key == 'sendsmsFree')
				$result[$hook_id] = array(0 => $key, 1 => $value);
		}
		return $result;
	}

	static public function send($hookName, $params)
	{
		self::$_hookName = $hookName;
		self::$_params = $params;

		$dest = self::$_config[self::$_hookName];
		if ($dest == self::__SENDSMS_CUSTOMER__ || $dest == self::__SENDSMS_BOTH__) {
			self::_prepareSms();
		}
		if ($dest == self::__SENDSMS_ADMIN__ || $dest == self::__SENDSMS_BOTH__) {
			self::_prepareSms(true);
		}

		if (self::$_event != 'sendsmsAdminAlert') {
			Hook::exec('sendsmsAdminAlert', null);
		}
	}

	static private function _isEverythingValidForSending($keyActive, $keyTxt, $idLang=null, $bAdmin=false)
	{
		if (!empty(self::$_phone) && Configuration::get('SENDSMS_SENDER') && Configuration::get($keyActive) && Configuration::get($keyTxt,$idLang) &&
			self::isAccountAvailable(Configuration::get('SENDSMS_EMAIL'), Configuration::get('SENDSMS_PASSWORD'), Configuration::get('SENDSMS_KEY')) && self::isBalancePositive())
			return true;
		return false;
	}

	static public function isBalancePositive() {
		return self::$_balance > 0;
	}

	static private function _prepareSms($bAdmin = false)
	{
		$context = Context::getContext();

		$method = '_get' . ucfirst(self::$_hookName) . 'Values';
		if (method_exists(__CLASS__, $method)) {
			$hookId = Hook::getIdByName(self::$_hookName);
			if ($hookId) {
				self::$_recipient = null;
				self::$_paid_by_customer = 0;
				self::$_event = self::$_hookName;
				$idLang = $bAdmin ? null : $context->language->id;

				switch (self::$_hookName) {
					case 'actionOrderStatusPostUpdate':
						$stateId = self::$_params['newOrderStatus']->id;
						$order = new Order((int)self::$_params['id_order']);
						$idLang = $order->id_lang;
						$keyActive = 'SENDSMS_ISACTIVE_' . $hookId . '_' . $stateId;
						$keyTxt = 'SENDSMS_TXT_' . $hookId . '_' . $stateId;
						self::$_event .= '_' . $stateId;
						$values = self::$method(false, false);
						break;
					case 'actionAdminOrdersTrackingNumberUpdate':
						$order = self::$_params['order'];
						$idLang = $order->id_lang;
						$keyActive = 'SENDSMS_ISACTIVE_' . $hookId;
						$keyTxt = 'SENDSMS_TXT_' . $hookId;
						$values = self::$method(false, false);
						break;
					default :
						$keyActive = ($bAdmin) ? 'SENDSMS_ISACTIVE_' . $hookId . '_ADMIN' : 'SENDSMS_ISACTIVE_' . $hookId;
						$keyTxt = ($bAdmin) ? 'SENDSMS_TXT_' . $hookId . '_ADMIN' : 'SENDSMS_TXT_' . $hookId;
						$values = self::$method(false, $bAdmin);
						break;
				}

				if (is_array($values) && self::_isEverythingValidForSending($keyActive, $keyTxt, $idLang, $bAdmin)) {
					self::$_txt = str_replace(array_keys($values), array_values($values), Configuration::get($keyTxt, $idLang));
					self::_sendSMS();
				}
			}
		}
	}

	static private function _sendSMS()
	{
		$sms = new SMS();
		$sms->setSmsLogin(self::$_email);
		$sms->setSmsPassword(self::$_password);
		$sms->setPrestaKey(self::$_prestaKey);
		$sms->setSmsText(self::$_txt);
		$sms->setNums(array(self::$_phone));
		$sms->setType(INSTANTANE);
		$sms->setSender(Configuration::get('SENDSMS_SENDER'));
		$sms->setSimulation((int)Configuration::get('SENDSMS_SIMULATION'));
		$reponse = $sms->send();
		$result = explode('_', $reponse);

		$log = new sendsmsLogs();
		if (isset(self::$_recipient)) {
			if (self::$_event != 'sendsmsFree') {
				$log->id_customer = self::$_recipient->id;
				$log->recipient = self::$_recipient->firstname . ' ' . self::$_recipient->lastname;
			} else {
				$log->recipient = self::$_recipient;
			}
		} else {
			$log->recipient = '--';
		}
		$log->phone = self::$_phone;
		$log->event = self::$_event;
		$log->message = self::$_txt;
		$log->nb_consumed = $result[2];
		$log->credit = ($result[0] == 'KO') ? 0 : $result[3];
		$log->paid_by_customer = self::$_paid_by_customer;
		$log->simulation = (int)Configuration::get('SENDSMS_SIMULATION');
		$log->status = ($result[0] == 'OK') ? 1 : 0;
		$log->ticket = ($result[0] == 'OK') ? $result[1] : null;
		$log->error = ($result[0] == 'KO') ? $result[1] : null;
		$log->save();

		if ($result[0] == 'OK')
			return true;
		return false;
	}

	static public function sendFreeSMS($phone, $recipient, $txt)
	{
		self::$_phone = $phone;
		self::$_txt = self::replaceForGSM7($txt);
		self::$_event = 'sendsmsFree';
		self::$_paid_by_customer = 0;
		self::$_recipient = $recipient;
		return self::_sendSMS();
	}

	static public function getSmsValuesForTest($hookName)
	{
		$values = array();
		$method = '_get' . ucfirst($hookName) . 'Values';
		if (method_exists(__CLASS__, $method)) {
			$values = self::$method(true);
		}
		return $values;
	}

	// affiche la case permettant d'acheter le service SMS dans la page des transporteurs
	static public function displayCustomerChoice($params) {
		$context = Context::getContext();

		if ((int)Configuration::get('SENDSMS_FREEOPTION') === 0) {
			$product = new Product((int)Configuration::get('SENDSMS_ID_PRODUCT'));
			$price = $product->getPrice(true, NULL, 2);

			// faut-il cocher la case sur le FO ?
			$putInCart = 0;
			$result = $context->cart->containsProduct((int)Configuration::get('SENDSMS_ID_PRODUCT'), 0, null);
			if (!empty($result['quantity']) || (int)Configuration::get('SENDSMS_PUT_IN_CART') == 1) {
				$putInCart = 1;
			}

			$address = new Address($context->cart->id_address_invoice);
			$context->smarty->assign(array(
				'sendsmsPutInCart' => $putInCart,
				'sendsmsPrice' => $price,
				'phone' => empty($address->phone_mobile) ? false : true,
				'id_address' => $context->cart->id_address_invoice
			));
			return true;
		}
		return false;
	}

	// enregistre la case permettant d'acheter le service SMS dans la page des transporteurs
	static public function processCustomerChoice($params) {
		$context = Context::getContext();
		$customerChoice = $params['customerChoice'];

		// on retire l'éventuel notification SMS du panier
		$context->cart->deleteProduct((int)Configuration::get('SENDSMS_ID_PRODUCT'));

		if ($customerChoice == 1 && (int)Configuration::get('SENDSMS_FREEOPTION') === 0) {
			// on vérifie que le téléphone est bien renseigné
			$address = new Address($context->cart->id_address_invoice);
			if (empty($address->phone_mobile))
				return '-1';
			$context->cart->updateQty(1, (int)Configuration::get('SENDSMS_ID_PRODUCT'));
		}
		return true;
	}

	static private function _setPhone($addressId, $bAdmin)
	{
		self::$_phone = '';
		if ($bAdmin)
			self::$_phone = Configuration::get('SENDSMS_ADMIN_PHONE_NUMBER');
		else if (!empty($addressId)) {
			$address = new Address($addressId);
			if (!empty($address->phone_mobile) && !empty($address->id_country)) {
				self::$_phone = self::_convertPhoneToInternational($address->phone_mobile, $address->id_country);
			}
		}
	}

	static private function _setRecipient($customer)
	{
		self::$_recipient = $customer;
	}

	static private function _convertPhoneToInternational($phone, $id_country) {
		$phone = preg_replace("/[^+0-9]/", "", $phone);
		$iso = Country::getIsoById($id_country);

		$result = Db::getInstance()->getRow("SELECT prefix FROM `" . _DB_PREFIX_ . "sendsms_phone_prefix` WHERE `iso_code` = '" . $iso . "'");
		$prefix = $result['prefix'];
		if (empty($prefix))
			return null;
		else {
			// s'il commence par + il est déjà international
			if (substr($phone, 0, 1) == '+') {
				return $phone;
			}
			// s'il commence par 00 on les enlève et on vérifie le code pays pour ajouter le +
			else if (substr($phone, 0, 2) == '00') {
				$phone = substr($phone, 2);
				if (strpos($phone, $prefix) === 0) {
					return '+' . $phone;
				} else {
					return null;
				}
			}
			// s'il commence par 0, on enlève le 0 et on ajoute le prefix du pays
			else if (substr($phone, 0, 1) == '0') {
				return '+' . $prefix . substr($phone, 1);
			}
			// s'il commence par le prefix du pays, on ajoute le +
			else if (strpos($phone, $prefix) === 0) {
				return '+' . $phone;
			}
			else {
				return '+' . $prefix . $phone;
			}
		}
	}

	static private function _getBaseValues() {
		$host = 'http://'.Tools::getHttpHost(false, true);

		$values = array(
			'{shopname}' => Configuration::get('PS_SHOP_NAME'),
			'{shopurl}' => $host.__PS_BASE_URI__
		);
		return $values;
	}

	// Méthodes pour chacun des hooks gérés
	static private function _getActionValidateOrderValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
			$values = array(
				'{firstname}' => 'John',
				'{lastname}' => 'Doe',
				'{order_id}' => '000001',
				'{payment}' => 'Paypal',
				'{total_paid}' => '100',
				'{currency}' => $currency->sign
			);
		} else {
			$order = self::$_params['order'];
			$customer = self::$_params['customer'];
			$currency = self::$_params['currency'];

			// Si l'option est payante et que le client ne l'a pas mise dans son panier, on n'envoit rien.
			if (!$bAdmin && (int)Configuration::get('SENDSMS_FREEOPTION') === 0) {
				$cart = self::$_params['cart'];
				$result = $cart->containsProduct((int)Configuration::get('SENDSMS_ID_PRODUCT'), 0, null);
				if (!empty($result['quantity'])) {
					self::$_paid_by_customer = 1;
				} else {
					return false;
				}
			}

			if (!$bAdmin)
				self::_setRecipient($customer);
			self::_setPhone($order->id_address_invoice, $bAdmin);

			$values = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{order_id}' => sprintf("%06d", $order->id),
				'{payment}' => $order->payment,
				'{total_paid}' => $order->total_paid,
				'{currency}' => $currency->sign
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getActionOrderReturnValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{return_id}' => '4',
				'{customer_id}' => '136',
				'{order_id}' => '1027',
				'{message}' => 'This is a message'
			);
		} else {
			self::_setPhone(null, true);

			$orderReturn = self::$_params['orderReturn'];
			$values = array(
				'{return_id}' => (int)$orderReturn->id,
				'{customer_id}' => (int)$orderReturn->id_customer,
				'{order_id}' => sprintf("%06d", $orderReturn->id_order),
				'{message}' => $orderReturn->question
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getActionCustomerAccountAddValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{firstname}' => 'John',
				'{lastname}' => 'Doe'
			);
		} else {
			$customer = self::$_params['newCustomer'];
			if (!$bAdmin)
				self::_setRecipient($customer);
			self::_setPhone(Address::getFirstCustomerAddressId($customer->id), $bAdmin);

			$values = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getActionUpdateQuantityValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{product_id}' => '000001',
				'{product_ref}' => 'REF-001',
				'{product_name}' => 'Ipod Nano',
				'{quantity}' => '2'
			);
		} else {
			self::_setPhone(null, true);

			$id_product = (int)self::$_params['id_product'];
			$id_product_attribute = (int)self::$_params['id_product_attribute'];
			$quantity = (int)self::$_params['quantity'];
			$id_shop = (int)Context::getContext()->shop->id;
			$id_lang = (int)Context::getContext()->language->id;
			$product = new Product($id_product, true, $id_lang, $id_shop, Context::getContext());
			$product_name = Product::getProductName($id_product, $id_product_attribute, $id_lang);

			if ($quantity <= (int)Configuration::get('PS_LAST_QTIES') AND Configuration::get('PS_STOCK_MANAGEMENT'))
			{
				$values = array(
					'{product_id}' => $id_product,
					'{product_ref}' => $product->reference,
					'{product_name}' => $product_name,
					'{quantity}' => $quantity
				);
			} else
				return false;
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getSendsmsContactFormValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{contact_name}' => 'webmaster',
				'{contact_mail}' => 'webmaster@prestashop.com',
				'{from}' => 'johndoe@gmail.com',
				'{message}' => 'This is a message'
			);
		} else {
			$customer = self::$_params['customer'];

			if (!$bAdmin && Validate::isLoadedObject($customer)) {
				self::_setRecipient($customer);
			}
			self::_setPhone(Address::getFirstCustomerAddressId($customer->id), $bAdmin);

			$values = array(
				'{contact_name}' => self::$_params['contact_name'],
				'{contact_mail}' => self::$_params['contact_mail'],
				'{from}' => self::$_params['from'],
				'{message}' => html_entity_decode(self::$_params['message'], ENT_QUOTES, 'UTF-8')
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getSendsmsAdminAlertValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{balance}' => number_format('10', 3, ',', ' '),
			);
		} else {
			// si l'alerte est active (> 0) et que le message n'a pas déjà été envoyé
			// et que le nb de SMS restant est < à la limite donnée, alors on envoit
			$alertLevel = (int)Configuration::get('SENDSMS_ALERT_LEVEL');
			if ((int)Configuration::get('SENDSMS_ALERT_SENT') == 0 && $alertLevel > 0 && self::isAccountAvailable(Configuration::get('SENDSMS_EMAIL'), Configuration::get('SENDSMS_PASSWORD'), Configuration::get('SENDSMS_KEY')) && (float)self::$_balance <= (float)$alertLevel) {
				Configuration::updateValue('SENDSMS_ALERT_SENT', '1');
				self::_setPhone(null, true);
				$values = array(
					'{balance}' => number_format(self::$_balance, 3, ',', ' ')
				);
			} else
				return null;
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getSendsmsCustomerAlertValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{firstname}' => 'John',
				'{lastname}' => 'Doe',
				'{product}' => 'Ipod Nano',
			);
		} else {
			$customer = self::$_params['customer'];
			self::_setRecipient($customer);
			self::_setPhone(Address::getFirstCustomerAddressId($customer->id), false);
			$values = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{product}' => self::$_params['product']
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getActionPasswordRenewValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{firstname}' => 'John',
				'{lastname}' => 'Doe',
				'{password}' => 'YourNewPass',
			);
		} else {
			$customer = self::$_params['customer'];
			$password = self::$_params['password'];
			self::_setRecipient($customer);
			self::_setPhone(Address::getFirstCustomerAddressId($customer->id), false);
			$values = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{password}' => $password
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getSendsmsDailyReportValues($bSimu = false, $bAdmin = false)
	{
		$currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
		if ($bSimu) {
			$values = array(
				'{date}' => date('Y-m-d'),
				'{subs}' => '5',
				'{visitors}' => '42',
				'{visits}' => '70',
				'{orders}' => '8',
				'{day_sales}' => Tools::displayPrice(50, $currency, false),
				'{month_sales}' => Tools::displayPrice(1000, $currency, false),
			);
		} else {
			// si le message n'a pas déjà été envoyé
			self::_setPhone(null, true);
			$values = array(
				'{date}' => date('Y-m-d'),
				'{subs}' => self::$_params['subs'],
				'{visitors}' => self::$_params['visitors'],
				'{visits}' => self::$_params['visits'],
				'{orders}' => self::$_params['orders'],
				'{day_sales}' => self::$_params['day_sales'],
				'{month_sales}' => self::$_params['month_sales']
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getActionOrderStatusPostUpdateValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$values = array(
				'{firstname}' => 'John',
				'{lastname}' => 'Doe',
				'{order_id}' => '000001',
				'{order_state}' => 'xxx'
			);
		} else {
			$order = new Order((int)self::$_params['id_order']);
			$state = self::$_params['newOrderStatus']->name;
			$customer = new Customer((int)$order->id_customer);

			// Si l'option est payante et que le client ne l'a pas mise dans son panier, on n'envoit rien.
			if ((int)Configuration::get('SENDSMS_FREEOPTION') === 0) {
				$cart = Cart::getCartByOrderId(self::$_params['id_order']);
				$result = $cart->containsProduct((int)Configuration::get('SENDSMS_ID_PRODUCT'), 0, null);
				if (!empty($result['quantity'])) {
					self::$_paid_by_customer = 1;
				} else {
					return false;
				}
			}

			self::_setRecipient($customer);
			self::_setPhone(Address::getFirstCustomerAddressId($customer->id), false);

			$values = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{order_id}' => sprintf("%06d", $order->id),
				'{order_state}' => $state
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static private function _getActionAdminOrdersTrackingNumberUpdateValues($bSimu = false, $bAdmin = false)
	{
		if ($bSimu) {
			$currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
			$values = array(
				'{firstname}' => 'John',
				'{lastname}' => 'Doe',
				'{order_id}' => '000001',
				'{shipping_number}' => 'ABC001',
				'{payment}' => 'Paypal',
				'{total_paid}' => '100',
				'{currency}' => $currency->sign
			);
		} else {
			$order = self::$_params['order'];
			$customer = new Customer((int)$order->id_customer);
			$currency = new Currency($order->id_currency);

			// Si l'option est payante et que le client ne l'a pas mise dans son panier, on n'envoit rien.
			if ((int)Configuration::get('SENDSMS_FREEOPTION') === 0) {
				$cart = Cart::getCartByOrderId($order->id);
				$result = $cart->containsProduct((int)Configuration::get('SENDSMS_ID_PRODUCT'), 0, null);
				if (!empty($result['quantity'])) {
					self::$_paid_by_customer = 1;
				} else {
					return false;
				}
			}

			self::_setRecipient($customer);
			self::_setPhone(Address::getFirstCustomerAddressId($customer->id), false);

			$values = array(
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{order_id}' => sprintf("%06d", $order->id),
				'{shipping_number}' => $order->shipping_number,
				'{payment}' => $order->payment,
				'{total_paid}' => $order->total_paid,
				'{currency}' => $currency->sign
			);
		}
		return array_merge($values, self::_getBaseValues());
	}

	static public function replaceForGSM7($txt) {
  		$search  = array('À','Á','Â','Ã','È','Ê','Ë','Ì','Í','Î','Ï','Ð','Ò','Ó','Ô','Õ','Ù','Ú','Û','Ý','Ÿ','á','â','ã','ê','ë','í','î','ï','ð','ó','ô','õ','ú','û','µ','ý','ÿ','ç','Þ','°', '¨', '^', '«', '»', '|', '\\');
		$replace = array('A','A','A','A','E','E','E','I','I','I','I','D','O','O','O','O','U','U','U','Y','Y','a','a','a','e','e','i','i','i','o','o','o','o','u','u','u','y','y','c','y','o', '-', '-', '"', '"', 'I', '/');
		return str_replace($search, $replace, $txt);
	}

	static public function isGSM7($txt) {
		if (preg_match("/^[ÀÁÂÃÈÊËÌÍÎÏÐÒÓÔÕÙÚÛÝŸáâãêëíîïðóôõúûµýÿçÞ°{|}~¡£¤¥§¿ÄÅÆÇÉÑÖØÜßàäåæèéìñòöøùü,\.\-!\"#$%&()*+\/:;<=>?@€\[\]\^\w\s\\']*$/u", $txt))
			return true;
		else
			return false;
	}

	static public function notGSM7($txt) {
		return preg_replace("/[ÀÁÂÃÈÊËÌÍÎÏÐÒÓÔÕÙÚÛÝŸáâãêëíîïðóôõúûµýÿçÞ°{|}~¡£¤¥§¿ÄÅÆÇÉÑÖØÜßàäåæèéìñòöøùü,\.\-!\"#$%&()*+\/:;<=>?@€\[\]\^\w\s\\']/u", "", $txt);
	}
}
?>