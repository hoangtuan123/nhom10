<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Needacart.com
 *  @copyright 2007-2014 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
//include google's library https://code.google.com/p/recaptcha/
require_once(dirname(__FILE__).'/lib/recaptchalib.php');

class Recaptcha extends Module
{
	/**
	 * Probability of login attempts db table garbage cleanup
	 * 
	 * @var int
	 */
	const GC_PROBABILITY = 1;

	/**
	 * Flag whether increment login attempts in destructor
	 * 
	 * @var bool
	 */
	private $increment_login_attempts_in_destructor = false;

	/**
	 * Prestashop verion MAJOR.MINOR
	 *
	 * @var string
	 */
	private $is16;

	public function __construct()
	{
		$this->name = 'recaptcha';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'needacart.com';

		parent::__construct();

		$this->displayName = $this->l('Contact, register, login reCAPTCHA');
		$this->description = $this->l('Adds google reCAPTCHA to contact and register, login forms');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
		$this->is16 = _PS_VERSION_ >= 1.6;
		$this->bootstrap = $this->is16;
		if (!Configuration::get('RECAPTCHA_PUBLIC_KEY') || !Configuration::get('RECAPTCHA_PRIVATE_KEY'))
			$this->warning = $this->l('API keys is not properly set');
		$this->module_key = '';

		if ($this->isInstalled($this->name))
			//Cleanup login attempts database in ~ self::GC_PROBABILITY % requests
			if (mt_rand(1, 100) > (100 - self::GC_PROBABILITY))
				Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.$this->name.'_login_attempts`
					WHERE `last_attempt` <= NOW() - INTERVAL 1 DAY');
	}

	public function install()
	{
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->name.'_login_attempts` (
			`ip` int(10) unsigned NOT NULL,
			`attempts` tinyint(3) unsigned NOT NULL DEFAULT 1,
			`last_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`ip`),
			INDEX(`last_attempt`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';
		if (!parent::install()
		|| !Configuration::updateValue('RECAPTCHA_PUBLIC_KEY', '')
		|| !Configuration::updateValue('RECAPTCHA_PRIVATE_KEY', '')
		|| !Configuration::updateValue('RECAPTCHA_THEME', '')
		|| !Configuration::updateValue('RECAPTCHA_CONTACT', false)
		|| !Configuration::updateValue('RECAPTCHA_LOGIN', false)
		|| !Configuration::updateValue('RECAPTCHA_LOGIN_ATTEMPTS', 3)
		|| !Configuration::updateValue('RECAPTCHA_REGISTER', false)
		|| !Configuration::updateValue('RECAPTCHA_DEBUG', false)
		|| !Db::getInstance()->execute($sql)
		|| !$this->registerHook('header')
		|| !$this->registerHook('createAccountTop'))
			return false;
		return true;
	}

	public function uninstall()
	{
		$sql = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$this->name.'_login_attempts`';
		if (!Configuration::deleteByName('RECAPTCHA_PUBLIC_KEY')
		|| !Configuration::deleteByName('RECAPTCHA_PRIVATE_KEY')
		|| !Configuration::deleteByName('RECAPTCHA_THEME')
		|| !Configuration::deleteByName('RECAPTCHA_CONTACT')
		|| !Configuration::deleteByName('RECAPTCHA_LOGIN')
		|| !Configuration::deleteByName('RECAPTCHA_REGISTER')
		|| !Configuration::deleteByName('RECAPTCHA_DEBUG')
		|| !Db::getInstance()->execute($sql)
		|| !parent::uninstall())
			return false;
		return true;
	}

	/**
	 * Hook to add reCAPTCHA javascript in the header tag
	 */
	public function hookHeader()
	{
		$page_name = Dispatcher::getInstance()->getController();
		$show_recaptcha = false;
		switch ($page_name)
		{
			case 'contact':
				$show_recaptcha = Configuration::get('RECAPTCHA_CONTACT');
				if ($this->is16)
					$include_template = 'contact16';
				else
					$include_template = 'contact';
				break;
			case 'authentication':
				if (Configuration::get('RECAPTCHA_LOGIN'))
				{
					$max_login_attempts = Configuration::get('RECAPTCHA_LOGIN_ATTEMPTS');
					if ($max_login_attempts > 0)
					{
						$show_recaptcha = $this->getLoginAttempts() >= $max_login_attempts;
						if ($this->is16)
							$include_template = 'authentication16';
						else
							$include_template = 'authentication';
					}
				}
				break;
		}
		if ($show_recaptcha)
		{
			/* @var $smarty Smarty */
			$public_key = Configuration::get('RECAPTCHA_PUBLIC_KEY');
			$smarty = $this->context->smarty;
			$smarty->assign(array(
				'include_template' => $include_template,
				'error' => (!$public_key ? $this->l('Please set reCAPTCHA keys on the module configuration page!') : ''),
				'public_key' => $public_key,
				'theme' => Configuration::get('RECAPTCHA_THEME'),
				'debug' => Configuration::get('RECAPTCHA_DEBUG'),
			));
			return $this->display(__FILE__, 'header.tpl');
		}
	}

	/**
	 * Hook for for create aacount page
	 */
	public function hookCreateAccountTop()
	{
		if (Configuration::get('RECAPTCHA_REGISTER'))
		{
			/* @var $smarty Smarty */
			$public_key = Configuration::get('RECAPTCHA_PUBLIC_KEY');
			$smarty = $this->context->smarty;
			$smarty->assign(array(
				'error' => (!$public_key ? $this->l('Please set reCAPTCHA keys on the module configuration page!') : ''),
				'public_key' => $public_key,
				'theme' => Configuration::get('RECAPTCHA_THEME'),
			));
			return $this->display(__FILE__, 'authentication_register'.($this->is16 ? '16' : '').'.tpl');			
		}
	}
	
	/**
	 * Module configuration page 
	 */
	public function getContent()
	{
		$html = '';
		if (Tools::isSubmit('submitModule'))
		{
			Configuration::updateValue('RECAPTCHA_PUBLIC_KEY', Tools::getValue('RECAPTCHA_PUBLIC_KEY'));
			Configuration::updateValue('RECAPTCHA_PRIVATE_KEY', Tools::getValue('RECAPTCHA_PRIVATE_KEY'));
			Configuration::updateValue('RECAPTCHA_THEME', Tools::getValue('RECAPTCHA_THEME'));
			Configuration::updateValue('RECAPTCHA_CONTACT', (bool)Tools::getValue('RECAPTCHA_CONTACT'));
			Configuration::updateValue('RECAPTCHA_LOGIN', (bool)Tools::getValue('RECAPTCHA_LOGIN'));
			Configuration::updateValue('RECAPTCHA_LOGIN_ATTEMPTS', (int)Tools::getValue('RECAPTCHA_LOGIN_ATTEMPTS'));
			Configuration::updateValue('RECAPTCHA_REGISTER', (bool)Tools::getValue('RECAPTCHA_REGISTER'));
			Configuration::updateValue('RECAPTCHA_DEBUG', (bool)Tools::getValue('RECAPTCHA_DEBUG'));
			$html .= $this->displayConfirmation($this->l('Configuration updated'));
		}
		$html .= $this->is16 ? $this->getContent16() : $this->getContent15();
		return $html;
	}

	/**
	 * Show pretty 1.6 style form
	 */
	private function getContent16()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('reCAPTCHA by needacart.com'),
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Public key'),
						'name' => 'RECAPTCHA_PUBLIC_KEY',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Private key'),
						'name' => 'RECAPTCHA_PRIVATE_KEY',
						'desc' => $this->l('To get reCAPTCHA keys follow this ').' <a target="_blank" href="https://www.google.com/recaptcha/admin">'.$this->l('link').'</a>',
					),
					array(
						'type' => 'text',
						'label' => $this->l('reCAPTCHA theme name'),
						'name' => 'RECAPTCHA_THEME',
						'desc' => '<a target="_blank" href="https://developers.google.com/recaptcha/docs/customization">'.$this->l('help').'</a>'
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enable on contact form'),
						'name' => 'RECAPTCHA_CONTACT',
						'values' => array(
									array(
										'id' => 'active_on',
										'value' => 1,
										'label' => $this->l('Enabled')
									),
									array(
										'id' => 'active_off',
										'value' => 0,
										'label' => $this->l('Disabled')
									)
								),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enable on login form'),
						'name' => 'RECAPTCHA_LOGIN',
						'values' => array(
									array(
										'id' => 'active_on',
										'value' => 1,
										'label' => $this->l('Enabled')
									),
									array(
										'id' => 'active_off',
										'value' => 0,
										'label' => $this->l('Disabled')
									)
								),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Show after login attempts (0 - always)'),
						'name' => 'RECAPTCHA_LOGIN_ATTEMPTS',
						'class' => 'fixed-width-xs'
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enable on register form'),
						'name' => 'RECAPTCHA_REGISTER',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enable debug mode'),
						'name' => 'RECAPTCHA_DEBUG',
						'desc' => 'May help to solve "not-showing" issues',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		return array(
			'RECAPTCHA_PUBLIC_KEY' => Tools::getValue('RECAPTCHA_PUBLIC_KEY', Configuration::get('RECAPTCHA_PUBLIC_KEY')),
			'RECAPTCHA_PRIVATE_KEY' => Tools::getValue('RECAPTCHA_PRIVATE_KEY', Configuration::get('RECAPTCHA_PRIVATE_KEY')),
			'RECAPTCHA_THEME' => Tools::getValue('RECAPTCHA_THEME', Configuration::get('RECAPTCHA_THEME')),
			'RECAPTCHA_CONTACT' => Tools::getValue('RECAPTCHA_CONTACT', Configuration::get('RECAPTCHA_CONTACT')),
			'RECAPTCHA_LOGIN' => Tools::getValue('RECAPTCHA_LOGIN', Configuration::get('RECAPTCHA_LOGIN')),
			'RECAPTCHA_LOGIN_ATTEMPTS' => Tools::getValue('RECAPTCHA_LOGIN_ATTEMPTS', Configuration::get('RECAPTCHA_LOGIN_ATTEMPTS')),
			'RECAPTCHA_REGISTER' => Tools::getValue('RECAPTCHA_REGISTER', Configuration::get('RECAPTCHA_REGISTER')),
			'RECAPTCHA_DEBUG' => Tools::getValue('RECAPTCHA_DEBUG', Configuration::get('RECAPTCHA_DEBUG')),
		);
	}

	/**
	 * 1.5 style form
	 */
	private function getContent15()
	{
		return '<h2>'.$this->displayName.'</h2>
				<form action="'.Tools::htmlentitiesutf8($_SERVER['REQUEST_URI']).'" method="post">
				<fieldset>
					<legend>reCAPTCHA by needacart.com</legend>
					<p><label for="RECAPTCHA_PUBLIC_KEY">'.$this->l('Public key').'</label>
					<input type="text" name="RECAPTCHA_PUBLIC_KEY" style="width: 300px;" value="'.Tools::safeOutput(Configuration::get('RECAPTCHA_PUBLIC_KEY')).'" /></p>
					<p><label for="RECAPTCHA_PRIVATE_KEY">'.$this->l('Private key').'</label>
					<input type="text" name="RECAPTCHA_PRIVATE_KEY" style="width: 300px;" value="'.Tools::safeOutput(Configuration::get('RECAPTCHA_PRIVATE_KEY')).'" /></p>
					<p>'.$this->l('To get reCAPTCHA keys follow this ').' <a target="_blank" href="https://www.google.com/recaptcha/admin">'.$this->l('link').'</a></p>
					<p><label for="RECAPTCHA_THEME">'.$this->l('reCAPTCHA theme name').' <a target="_blank" href="https://developers.google.com/recaptcha/docs/customization">'.$this->l('help').'</a></label>
					<input type="text" name="RECAPTCHA_THEME" value="'.Tools::safeOutput(Configuration::get('RECAPTCHA_THEME')).'" /></p>
					<p><label for="RECAPTCHA_CONTACT">'.$this->l('Enable on contact form').'</label>
					<input type="checkbox" name="RECAPTCHA_CONTACT" '.((Configuration::get('RECAPTCHA_CONTACT')) ? ' checked=""': '').'/></p>
					<p><label for="RECAPTCHA_LOGIN">'.$this->l('Enable on login form').'</label>
					<input type="checkbox" name="RECAPTCHA_LOGIN" '.((Configuration::get('RECAPTCHA_LOGIN')) ? ' checked=""': '').'/></p>
					<p><label for="RECAPTCHA_LOGIN_ATTEMPTS">'.$this->l('Show after login attempts (0 - always)').'</label>
					<input type="text" name="RECAPTCHA_LOGIN_ATTEMPTS" value="'.Tools::safeOutput(Configuration::get('RECAPTCHA_LOGIN_ATTEMPTS')).'" /></p>
					<p><label for="RECAPTCHA_REGISTER">'.$this->l('Enable on register form').'</label>
					<input type="checkbox" name="RECAPTCHA_REGISTER" '.((Configuration::get('RECAPTCHA_REGISTER')) ? ' checked=""': '').'/></p>
					<p><label for="RECAPTCHA_DEBUG">'.$this->l('Enable debug mode').'. '.$this->l('May help to solve "not-showing" issues').'</label>
					<input type="checkbox" name="RECAPTCHA_DEBUG" '.((Configuration::get('RECAPTCHA_DEBUG')) ? ' checked=""': '').'/></p>
					<div class="margin-form">
						<input type="submit" name="submitModule" value="'.$this->l('Update settings').'" class="button" /></center>
					</div>
				</fieldset>
			</form>';
	}

	/**
	 * Validate a reCAPTCHA
	 * 
	 * @return ReCaptchaResponse
	 */
	public function check()
	{
		//Reverse proxy support with Tools::getRemoteAddr()
		$response = recaptcha_check_answer(Configuration::get('RECAPTCHA_PRIVATE_KEY'), Tools::getRemoteAddr(),
		Tools::getValue('recaptcha_challenge_field'), Tools::getValue('recaptcha_response_field'));
		//Replace "incorrect-captcha-sol" with more user-friendly message
		if ($response->error == 'incorrect-captcha-sol')
			$response->error = $this->l('Invalid reCAPTCHA');
		return $response;
	}

	/**
	 * Get login attempts for current IP
	 *
	 * @return int
	 */
	public function getLoginAttempts()
	{
		return (int)Db::getInstance()->getValue('SELECT `attempts`
			FROM `'._DB_PREFIX_."recaptcha_login_attempts`
			WHERE `ip` = '".ip2long(Tools::getRemoteAddr())."'");
	}

	/**
	 * Increment login attempts
	 * 
	 * @param bool $in_destructor do not increment immediately, do this in destructor
	 * @return void|boolean
	 */
	public function incrementLoginAttempts($in_destructor = false)
	{
		if ($in_destructor)
		{
			$this->increment_login_attempts_in_destructor = true;
			return;
		}
		return Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_."recaptcha_login_attempts` (`ip`)
			VALUES ('".ip2long(Tools::getRemoteAddr())."')
			ON DUPLICATE KEY UPDATE `attempts` = `attempts` + 1");
	}

	/**
	 * Increment login attempts
	 * 
	 * @return void|boolean
	 */
	public function deleteLoginAttempts()
	{
		return Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_."recaptcha_login_attempts`
			WHERE `ip` = '".ip2long(Tools::getRemoteAddr())."'");
	}

	/**
	 * Prestashop handles AJAX responses strange... using die() in the controller...
	 */
	public function __destruct()
	{
		if ($this->increment_login_attempts_in_destructor)
			$this->incrementLoginAttempts();
	}

}