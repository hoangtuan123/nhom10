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

if (!defined('_PS_VERSION_'))
	exit;

require_once(_PS_MODULE_DIR_.'sendsms/classes/sendsmsManager.php');

class sendsms extends Module
{
	private $_tabsArray;
	private $_hooksArray = array(
		array('name' => 'actionCustomerAccountAdd'),
		array('name' => 'actionValidateOrder'),
		array('name' => 'actionUpdateQuantity'),
		array('name' => 'actionOrderReturn'),
		array('name' => 'actionOrderStatusPostUpdate'),
		array('name' => 'actionAdminOrdersTrackingNumberUpdate'),
		array('name' => 'actionPasswordRenew'),
		array('name' => 'sendsmsContactForm', 'custom' => true, 'title' => 'Post submit of contact form', 'description' => 'This hook is called when a message is sent from contact form'),
		array('name' => 'sendsmsAdminAlert', 'custom' => true, 'title' => 'Send SMS when account is almost empty', 'description' => 'This hook is called when Send SMS account is almost empty'),
		array('name' => 'sendsmsCustomerAlert', 'custom' => true, 'title' => 'Send SMS when product is available', 'description' => 'This hook is called by mailalert module'),
		array('name' => 'sendsmsDailyReport', 'custom' => true, 'title' => 'Send SMS for daily report', 'description' => 'This hook is called by the sendsms cron'),
		array('name' => 'sendsmsCustomerChoice', 'custom' => true, 'title' => 'Display SMS notification choice on order carrier page', 'description' => 'This hook is called when displayingorder carrier page')
	);

	// DO NOT REMOVE !!!!
	// $this->l('sendsmsFree') = Freehand SMS
    // $this->l('actionValidateOrder') = On new order
    // $this->l('actionOrderReturn') = When a return request is created by a customer
    // $this->l('actionCustomerAccountAdd') = On account creation
    // $this->l('actionUpdateQuantity') = On out of stock
    // $this->l('actionAdminOrdersTrackingNumberUpdate') = When shipping number is updated
    // $this->l('actionOrderStatusPostUpdate') = On order status change
    // $this->l('actionOrderStatusPostUpdate_short') = Order
    // $this->l('sendsmsContactForm') = On contact message
    // $this->l('sendsmsAdminAlert') = When account is almost empty
    // $this->l('sendsmsCustomerAlert') = When product is now available and customer asked for being notified
    // $this->l('actionPasswordRenew') = When a customer has lost his password and want to receive a new one
    // $this->l('sendsmsDailyReport') = Daily report
    // $this->l('customer_phone_error') = You can\'t choose this option, because your mobile phone number is not set in your invoice address.
    // $this->l('actionValidateOrder_default_admin') = New order from {firstname} {lastname}, id: {order_id}, payment: {payment}, total: {total_paid} {currency}.
    // $this->l('actionValidateOrder_default_customer') = {firstname} {lastname}, we confirm your order {order_id}, which amount is {total_paid} {currency}. Thanks. {shopname}
    // $this->l('actionOrderReturn_default_admin') = Return request ({return_id}) received from customer {customer_id} about order {order_id}. Reason : {message}
    // $this->l('actionAdminOrdersTrackingNumberUpdate_default_customer') = {firstname} {lastname}, your order {order_id} is currently in transit. Your tracking number is {shipping_number}. Thanks. {shopname}
    // $this->l('actionOrderStatusPostUpdate_default_customer') = {firstname} {lastname}, your status order on {shopname} has just changed : {order_state}
    // $this->l('actionCustomerAccountAdd_default_admin') = {firstname} {lastname} has just subscribed to {shopname}
    // $this->l('actionCustomerAccountAdd_default_customer') = {firstname} {lastname}, welcome on {shopname} !
    // $this->l('actionUpdateQuantity_default_admin') = This product is almost out of stock, id: {product_id}, ref: {product_ref}, name: {product_name}, qty: {quantity}
    // $this->l('sendsmsContactForm_default_admin') = {from} just sent a message to {contact_name} ({contact_mail}) : {message}
    // $this->l('sendsmsContactForm_default_customer') = Thank you for your message. We will reply to you as soon as possible. {shopname}
    // $this->l('sendsmsAdminAlert_default_admin') = Your SMS account is almost empty. Only {balance} € left.
    // $this->l('sendsmsCustomerAlert_default_customer') = {firstname} {lastname}, {product} is now avalaible on {shopname} ({shopurl})
    // $this->l('actionPasswordRenew_default_customer') = {firstname} {lastname}, your new password on {shopname} is : {password}. {shopurl}
    // $this->l('sendsmsDailyReport_default_admin') = date: {date}, subscriptions: {subs}, visitors: {visitors}, visits: {visits}, orders: {orders}, sales: {day_sales}, month: {month_sales}

	function __construct()
	{
		$this->name = 'sendsms';
		$this->version = '1.16';
		$this->author = 'Yann Bonnaillie';
		$this->need_instance = 1;
		$this->ps_versions_compliancy['min'] = '1.5.0.1';
		$this->module_key = '238e212525f2117a8f04e7f894efef24';

		parent::__construct();

		$this->displayName = $this->l('SendSMS');

		$config = Configuration::getMultiple(array('SENDSMS_EMAIL', 'SENDSMS_PASSWORD', 'SENDSMS_KEY', 'SENDSMS_SENDER', 'SENDSMS_ADMIN_PHONE_NUMBER'));
		if (!isset($config['SENDSMS_EMAIL']) || !isset($config['SENDSMS_PASSWORD']) || !isset($config['SENDSMS_KEY']) || !isset($config['SENDSMS_SENDER']) || !isset($config['SENDSMS_ADMIN_PHONE_NUMBER']))
			$this->warning = $this->l('You have not yet set your SendSMS parameters. Please click on "SMS" tab.');
		$this->description = $this->l('Module to send SMS on differents events');
		$this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');

		$this->_tabsArray = array(
			'AdminSendsms'			=> 'Settings', 				// $this->l('Settings')
			'AdminSendsmsMessages'	=> 'Messages management', 	// $this->l('Messages management')
			'AdminSendsmsLogs' 		=> 'SMS history', 			// $this->l('SMS history')
			'AdminSendsmsSend' 		=> 'Send a SMS', 			// $this->l('Send a SMS')
			'AdminSendsmsStats' 	=> 'Statistics', 			// $this->l('Statistics')
		);
	}

	public function install()
	{
		if (!parent::install() ||
			!$this->_installDatabase() ||
			!$this->_installTabs() ||
			!$this->_installConfig() ||
			!$this->_installHooks() ||
			!$this->_installFiles()
			)
			return false;

		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall() ||
			!$this->_uninstallDatabase() ||
			!$this->_uninstallTabs() ||
			!$this->_uninstallConfig() ||
			!$this->_uninstallHooks() ||
			!$this->_uninstallFiles()
			)
			return false;
		return true;
	}

	private function _installDatabase() {
		// Add log table to database
		Db::getInstance()->Execute(
			'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sendsms_logs` (
			  `id_sendsms_logs` int(10) unsigned NOT NULL auto_increment,
			  `id_customer` int(10) unsigned default NULL,
			  `recipient` varchar(100) NOT NULL,
			  `phone` varchar(16) NOT NULL,
			  `event` varchar(64) NOT NULL,
			  `message` text NOT NULL,
			  `nb_consumed` tinyint(1) unsigned NOT NULL default \'0\',
			  `credit` double(5,3) default NULL,
			  `paid_by_customer` tinyint(1) unsigned NOT NULL default \'0\',
			  `simulation` tinyint(1) unsigned NOT NULL default \'0\',
			  `status` tinyint(1) NOT NULL default \'0\',
			  `ticket` varchar(255) default NULL,
			  `error` varchar(255) default NULL,
			  `date_add` datetime NOT NULL,
			  PRIMARY KEY  (`id_sendsms_logs`)
			) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;'
		);

		// Add phone prefix to database
		Db::getInstance()->Execute(
			'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sendsms_phone_prefix` (
			`iso_code` varchar(3) NOT NULL,
			`prefix` int(10) unsigned default NULL,
			PRIMARY KEY  (`iso_code`)
			) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;'
		);

		Db::getInstance()->Execute("
			INSERT INTO `" . _DB_PREFIX_ . "sendsms_phone_prefix` (`iso_code`, `prefix`) VALUES
				('AD', 376),('AE', 971),('AF', 93),('AG', 1268),('AI', 1264),('AL', 355),('AM', 374),('AN', 599),('AO', 244),
				('AQ', 672),('AR', 54),('AS', 1684),('AT', 43),('AU', 61),('AW', 297),('AX', NULL),('AZ', 994),('BA', 387),
				('BB', 1246),('BD', 880),('BE', 32),('BF', 226),('BG', 359),('BH', 973),('BI', 257),('BJ', 229),('BL', 590),('BM', 1441),
				('BN', 673),('BO', 591),('BR', 55),('BS', 1242),('BT', 975),('BV', NULL),('BW', 267),('BY', 375),('BZ', 501),
				('CA', 1),('CC', 61),('CD', 242),('CF', 236),('CG', 243),('CH', 41),('CI', 225),('CK', 682),('CL', 56),('CM', 237),
				('CN', 86),('CO', 57),('CR', 506),('CU', 53),('CV', 238),('CX', 61),('CY', 357),('CZ', 420),('DE', 49),('DJ', 253),
				('DK', 45),('DM', 1767),('DO', 1809),('DZ', 213),('EC', 593),('EE', 372),('EG', 20),('EH', NULL),('ER', 291),('ES', 34),
				('ET', 251),('FI', 358),('FJ', 679),('FK', 500),('FM', 691),('FO', 298),('FR', 33),('GA', 241),('GB', 44),('GD', 1473),
				('GE', 995),('GF', 594),('GG', NULL),('GH', 233),('GI', 350),('GL', 299),('GM', 220),('GN', 224),('GP', 590),('GQ', 240),
				('GR', 30),('GS', NULL),('GT', 502),('GU', 1671),('GW', 245),('GY', 592),('HK', 852),('HM', NULL),('HN', 504),('HR', 385),
				('HT', 509),('HU', 36),('ID', 62),('IE', 353),('IL', 972),('IM', 44),('IN', 91),('IO', 1284),('IQ', 964),('IR', 98),
				('IS', 354),('IT', 39),('JE', 44),('JM', 1876),('JO', 962),('JP', 81),('KE', 254),('KG', 996),('KH', 855),('KI', 686),
				('KM', 269),('KN', 1869),('KP', 850),('KR', 82),('KW', 965),('KY', 1345),('KZ', 7),('LA', 856),('LB', 961),('LC', 1758),
				('LI', 423),('LK', 94),('LR', 231),('LS', 266),('LT', 370),('LU', 352),('LV', 371),('LY', 218),('MA', 212),('MC', 377),
				('MD', 373),('ME', 382),('MF', 1599),('MG', 261),('MH', 692),('MK', 389),('ML', 223),('MM', 95),('MN', 976),('MO', 853),
				('MP', 1670),('MQ', 596),('MR', 222),('MS', 1664),('MT', 356),('MU', 230),('MV', 960),('MW', 265),('MX', 52),('MY', 60),
				('MZ', 258),('NA', 264),('NC', 687),('NE', 227),('NF', 672),('NG', 234),('NI', 505),('NL', 31),('NO', 47),('NP', 977),
				('NR', 674),('NU', 683),('NZ', 64),('OM', 968),('PA', 507),('PE', 51),('PF', 689),('PG', 675),('PH', 63),('PK', 92),
				('PL', 48),('PM', 508),('PN', 870),('PR', 1),('PS', NULL),('PT', 351),('PW', 680),('PY', 595),('QA', 974),('RE', 262),
				('RO', 40),('RS', 381),('RU', 7),('RW', 250),('SA', 966),('SB', 677),('SC', 248),('SD', 249),('SE', 46),('SG', 65),
				('SI', 386),('SJ', NULL),('SK', 421),('SL', 232),('SM', 378),('SN', 221),('SO', 252),('SR', 597),('ST', 239),('SV', 503),
				('SY', 963),('SZ', 268),('TC', 1649),('TD', 235),('TF', NULL),('TG', 228),('TH', 66),('TJ', 992),('TK', 690),('TL', 670),
				('TM', 993),('TN', 216),('TO', 676),('TR', 90),('TT', 1868),('TV', 688),('TW', 886),('TZ', 255),('UA', 380),('UG', 256),
				('US', 1),('UY', 598),('UZ', 998),('VA', 379),('VC', 1784),('VE', 58),('VG', 1284),('VI', 1340),('VN', 84),('VU', 678),
				('WF', 681),('WS', 685),('YE', 967),('YT', 262),('ZA', 27),('ZM', 260),('ZW', 263);"
		);
		return true;
	}

	private function _uninstallDatabase() {
		// remove phone prefix from database
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'sendsms_phone_prefix`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'sendsms_logs`');
		return true;
	}

	private function _installTabs()
	{
		$tab = new Tab();
		foreach (Language::getLanguages() as $language) {
	      $tab->name[$language['id_lang']] = 'SMS';
	    }
		$tab->class_name = 'AdminParentSendsms';
		$tab->module = $this->name;
		$tab->id_parent = 0;
		if(!$tab->save()) {
			return false;
		} else {
			$idTab = $tab->id;

			$idEn = Language::getIdByIso('en');
			foreach($this->_tabsArray as $tabKey => $name) {
				$tab = new Tab();
				foreach (Language::getLanguages() as $language) {
					$tmp = $this->l2($name, (int)$language['id_lang']);
					$tab->name[$language['id_lang']] = isset($tmp) && !empty($tmp) ? $tmp : $this->l2($name, $idEn);
			    }
				$tab->class_name = $tabKey;
				$tab->module = $this->name;
				$tab->id_parent = $idTab;
				if(!$tab->save()) {
					return false;
				}
			}
		}
		return true;
	}

	private function _uninstallTabs()
	{
		foreach($this->_tabsArray as $tabKey => $name) {
			$idTab = Tab::getIdFromClassName($tabKey);
			if($idTab != 0) {
				$tab = new Tab($idTab);
				$tab->delete();
			}
		}

		$idTab = Tab::getIdFromClassName('AdminParentSendsms');
		if($idTab != 0) {
			$tab = new Tab($idTab);
			$tab->delete();
		}
		return true;
	}

	private function _installConfig()
	{
		Configuration::updateValue('SENDSMS_SIMULATION', '1');
		Configuration::updateValue('SENDSMS_FREEOPTION', '1');
		Configuration::updateValue('SENDSMS_PUT_IN_CART', '0');
		Configuration::updateValue('SENDSMS_ALERT_LEVEL', '10');
		Configuration::updateValue('SENDSMS_ALERT_SENT', '0');
		return true;
	}

	private function _uninstallConfig()
	{
		Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'configuration`
			WHERE `name` like \'SENDSMS_%\'');
		Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'configuration_lang`
			WHERE `id_configuration` NOT IN (SELECT `id_configuration` from `'._DB_PREFIX_.'configuration`)');
		return true;
	}

	private function _installHooks()
	{
		foreach ($this->_hooksArray as $hook) {
			if (isset($hook['custom']))
				Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'hook` (name,title,description,position) VALUES ("'.$hook['name'].'", "'.$hook['title'].'", "'.$hook['description'].'", "0")');

			if (!$this->registerHook($hook['name']))
				return false;
		}
		return true;
	}

	private function _uninstallHooks()
	{
		return Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'hook`
			WHERE `name` like \'sendsms%\'');
	}

	private function _installFiles() {
		$this->_modifyFile('../themes/' . _THEME_NAME_ . '/order-carrier.tpl', 'HOOK_SENDSMS_CUSTOMER_CHOICE', "{if \$giftAllowed}", "{\$HOOK_SENDSMS_CUSTOMER_CHOICE}\n\n{if \$giftAllowed}");

		// suppression du cache smarty
		$files = glob('../tools/smarty/compile/*order-carrier.tpl.php');
		if (is_array($files)) {
			foreach($files as $file) {
				@unlink($file);
			}
		}

		return true;
	}

	private function _uninstallFiles() {
		$this->_restoreFile('../themes/' . _THEME_NAME_ . '/order-carrier.tpl', "{\$HOOK_SENDSMS_CUSTOMER_CHOICE}\n\n");

		return true;
	}

	private function _modifyFile($path, $search, $replace1, $replace2) {
		if (file_exists($path)) {
			$fd = fopen($path, 'r');
			$contents = fread($fd, filesize($path));
			if (strpos($contents, $search) === false) {
				$content2 = $contents;
				if (is_array($replace1) && is_array($replace2)) {
					foreach($replace1 as $key => $val1) {
						$contents = str_replace($val1, $replace2[$key], $contents);
					}
				} else
					$contents = str_replace($replace1, $replace2, $contents);
				fclose($fd);
				copy($path, $path . '-savedbysendsms');
				$fd = fopen($path, 'w+');
				fwrite($fd, $contents);
				fclose($fd);
			} else {
				fclose($fd);
			}
		}
	}

	private function _restoreFile($path, $search) {
		if (file_exists($path)) {
			$fd = fopen($path, 'r');
			$contents = fread($fd, filesize($path));
			if (is_array($search)) {
				foreach($search as $val) {
					$contents = str_replace($val, "", $contents);
				}
			} else
				$contents = str_replace($search, "", $contents);

			fclose($fd);
			$fd = fopen($path, 'w+');
			fwrite($fd, $contents);
			fclose($fd);
			@unlink($path . '-savedbysendsms');
		}
	}

	public function hookActionCustomerAccountAdd($params)
	{
		sendsmsManager::send('actionCustomerAccountAdd', $params);
	}

	public function hookActionValidateOrder($params)
	{
		sendsmsManager::send('actionValidateOrder', $params);
	}

	public function hookActionUpdateQuantity($params)
	{
		sendsmsManager::send('actionUpdateQuantity', $params);
	}

	public function hookActionOrderReturn($params)
	{
		sendsmsManager::send('actionOrderReturn', $params);
	}

	public function hookActionOrderStatusPostUpdate($params)
	{
		sendsmsManager::send('actionOrderStatusPostUpdate', $params);
	}

	public function hookActionAdminOrdersTrackingNumberUpdate($params)
	{
		sendsmsManager::send('actionAdminOrdersTrackingNumberUpdate', $params);
	}

	public function hookSendsmsContactForm($params)
	{
		sendsmsManager::send('sendsmsContactForm', $params);
	}

	public function hookSendsmsAdminAlert($params)
	{
		sendsmsManager::send('sendsmsAdminAlert', $params);
	}

	public function hookSendsmsCustomerAlert($params)
	{
		sendsmsManager::send('sendsmsCustomerAlert', $params);
	}

	public function hookActionPasswordRenew($params)
	{
		sendsmsManager::send('actionPasswordRenew', $params);
	}

	public function hookSendsmsDailyReport($params)
	{
		sendsmsManager::send('sendsmsDailyReport', $params);
	}

	public function hookSendsmsCustomerChoice($params)
	{
		if (!isset($params['submit'])) {
			if (sendsmsManager::displayCustomerChoice($params))
				return $this->display(__FILE__, 'sendsms.tpl');
		} else {
			return sendsmsManager::processCustomerChoice($params);
		}
	}


	/**
     * idem than Module::l but with $id_lang
     **/
    public function l2($string, $id_lang=null, $specific=false)
    {
        global $_MODULE, $_MODULES;

        if (!isset($id_lang))
        	$id_lang = Context::getContext()->language->id;

        $_MODULEStmp = $_MODULES;
        $_MODULES = array();

		$filesByPriority = array(
			// Translations in theme
			_PS_THEME_DIR_.'modules/'.$this->name.'/translations/'.Language::getIsoById((int)$id_lang).'.php',
			_PS_MODULE_DIR_.$this->name.'/translations/'.Language::getIsoById((int)$id_lang).'.php',
		);

		foreach ($filesByPriority as $file) {
			if (Tools::file_exists_cache($file) && include($file))
				$_MODULES = !empty($_MODULES) ? array_merge($_MODULES, $_MODULE) : $_MODULE;
		}

		$source = Tools::strtolower($specific ? $specific : $this->name);
		$key = md5(str_replace('\'', '\\\'', $string));

		$ret = $string;
		$current_key = strtolower('<{'.$this->name.'}'._THEME_NAME_.'>'.$source).'_'.$key;
		$default_key = strtolower('<{'.$this->name.'}prestashop>'.$source).'_'.$key;
		if (isset($_MODULES[$current_key]))
			$ret = stripslashes($_MODULES[$current_key]);
		elseif (isset($_MODULES[$default_key]))
			$ret = stripslashes($_MODULES[$default_key]);

		$ret = str_replace('"', '&quot;', $ret);
        $_MODULES = $_MODULEStmp;
        return $ret;
    }
}
?>