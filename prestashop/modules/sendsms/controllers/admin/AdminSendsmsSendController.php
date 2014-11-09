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

class AdminSendsmsSendController extends ModuleAdminController
{
	public function __construct()
	{
		$this->display = 'view';

		parent::__construct();
	}

	public function postProcess() {
		if(!_PS_MAGIC_QUOTES_GPC_ && isset($_POST['message']))
			$_POST['message'] = addslashes($_POST['message']);
		if (Tools::isSubmit('submit')) {
			$this->_postValidation();

			if (!sizeof($this->errors))
			{
				if (sendsmsManager::isAccountAvailable(Configuration::get('SENDSMS_EMAIL'), Configuration::get('SENDSMS_PASSWORD'), Configuration::get('SENDSMS_KEY')) && sendsmsManager::isBalancePositive()) {
					if (sendsmsManager::sendFreeSMS(Tools::getValue('phone'), Tools::getValue('recipient'), Tools::getValue('message'))) {
						$this->_html .= '<div class="conf confirm">'.$this->l('SMS has been sent').'</div>';
					} else {
						$this->errors[] = Tools::displayError($this->l('SMS has not been sent, check log for details.'));
					}
				} else {
					$this->errors[] = Tools::displayError($this->l('SMS has not been seent, check balance on your account'));
				}
			}
		}
	}

	public function initToolbar() {
		return;
	}

	public function initToolbarTitle()
	{
		$this->toolbar_title = array_unique($this->breadcrumbs);
	}

	public function renderView()
	{
		$this->_displayHeader();
		$this->_displayForm();
		return $this->_html;
	}

	private function _displayHeader()
	{
		// il faudrait plutôt utiliser un tpl qu'écrire le code html dans le controller
		$helper = new HelperView($this);
		$this->setHelperDisplay($helper);
		$helper->tpl_vars = $this->tpl_view_vars;
		if (!is_null($this->base_tpl_view))
			$helper->base_tpl = $this->base_tpl_view;
		$this->_html  .= $helper->generateView();

		$this->_html .= '
		<br><b>'.$this->l('You can send a message by entering an international mobile number, a recipient name, and a message.').'</b><br /><br />'.
		$this->l('Message will be sent only if you have enough credits on your account.').'<br /><br />
		<div style="clear:both;">&nbsp;</div>';
	}

 	private function _displayForm()
	{
		$bSimu = Configuration::get('SENDSMS_SIMULATION') == 1 ? true : false;
		$bAuth = false;
		if (Configuration::get('SENDSMS_EMAIL') != '' && Configuration::get('SENDSMS_PASSWORD') != '' && Configuration::get('SENDSMS_KEY') != '' && Configuration::get('SENDSMS_SENDER') != '') {
			$bAuth = true;
		}

		$this->_html .= '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset>
      			<legend><img src="'._MODULE_DIR_.$this->module->name.'/images/sendsmsSendTab.gif" /> '.$this->l('Send a message').'</legend>' .
      			(!$bAuth ? '<img src="../img/admin/disabled.gif"/> ' . $this->l('Before sending a message, you have to enter your account information on the SMS tab and set a sender.') . '<br/><br/>' : '') .
      			($bAuth && $bSimu ? '<img src="../img/admin/warning.gif"/> ' . $this->l('You\'re currently using simulation mode, your message won\'t be sent, but it will be logged.') . '<br/><br/>' : '') .
				'<label>'.$this->l('Mobile number').'</label>
				<div class="margin-form" style="padding-top: 2px">
					<input type="text" size="15" maxlength="15" name="phone" value="' . (sizeof($this->errors) ? Tools::getValue('phone') : '') . '" /><br />' . $this->l('International format, ex : +33612345678') . '
				</div>
				<label>'.$this->l('Recipient name').'</label>
				<div class="margin-form" style="padding-top: 2px">
					<input type="text" size="40" maxlength="100" name="recipient" value="' . (sizeof($this->errors) ? Tools::getValue('recipient') : '') . '"/><br />' . $this->l('It will be displayed in logs') . '
				</div>
				<label>'.$this->l('Message').'</label>
				<div class="margin-form" style="padding-top: 2px">
					<textarea style="overflow: auto" name="message" rows="4" cols="37"/>' . (sizeof($this->errors) ? Tools::getValue('message') : '') . '</textarea>
				</div>
				<div class="clear center">
					<input ' . (!$bAuth ? 'disabled' : '') . ' type="submit" name="submit" value="'.$this->l('Send').'" class="button" />
				</div>
			</fieldset>
		</form>
		<fieldset class="space">
			<legend>'.$this->l('Ads').'</legend>
			<p style="text-align:center">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-1663608442612102";
				/* Gratuit - SendSMS 728x90 */
				google_ad_slot = "2552853151";
				google_ad_width = 728;
				google_ad_height = 90;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</p>
		</fieldset>';
	}

	private function _postValidation()
	{
		if (Tools::isSubmit('submit')) {
			if (!Tools::getValue('phone') || !Validate::isPhoneNumber(Tools::getValue('phone')) || !preg_match('/^\+[0-9]{6,16}$/', Tools::getValue('phone')))
				$this->errors[] = Tools::displayError($this->l('Please enter a valid mobile number (international format)'));
			if (!Tools::getValue('recipient'))
				$this->errors[] = Tools::displayError($this->l('Please enter a recipient name (displayed only in logs)'));
			if (!Tools::getValue('message'))
				$this->errors[] = Tools::displayError($this->l('Please enter a message'));
		}
	}
}
?>