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

class AuthController extends AuthControllerCore
{
	protected function processSubmitLogin()
	{
		if (Configuration::get('RECAPTCHA_LOGIN'))
		{
			/* @var $recaptcha Recaptcha */
			$recaptcha = Module::getInstanceByName('recaptcha');
			$maxLoginAttempts = (int)Configuration::get('RECAPTCHA_LOGIN_ATTEMPTS');
			if ($maxLoginAttempts > 0)
			{
				if ($recaptcha->getLoginAttempts() < $maxLoginAttempts)
				{
					//login without recaptcha
					if ($this->ajax)
					{
						//Need to do this in destructor, or in case of ajax parent's method calls die()
						$recaptcha->incrementLoginAttempts(true);
						return parent::processSubmitLogin();
					}
					else
					{
						parent::processSubmitLogin();
						//Add invalid login attempt
						if (count($this->errors))
							$recaptcha->incrementLoginAttempts();
						return;
					}
				}
			}
			$responce = $recaptcha->check();
			if (!$responce->is_valid)
				$this->errors[] = $responce->error;
			else
			{
				parent::processSubmitLogin();
				//Delete invalid login attempts on success login
				if (!count($this->errors))
					$recaptcha->deleteLoginAttempts();
			}
		}
		else 
			return parent::processSubmitLogin();
	}
	
	protected function processSubmitAccount()
	{
		if (Configuration::get('RECAPTCHA_REGISTER'))
		{
			/* @var $recaptcha Recaptcha */
			$recaptcha = Module::getInstanceByName('recaptcha');
			$response = $recaptcha->check();
			if (!$response->is_valid)
			{
				$this->errors[] = $response->error;
				return;
			}
		}
		return parent::processSubmitAccount();
	}
}