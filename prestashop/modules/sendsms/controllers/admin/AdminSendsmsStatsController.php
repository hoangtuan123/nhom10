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

class AdminSendsmsStatsController extends ModuleAdminController
{
	public function __construct()
	{
		$this->display = 'view';

		parent::__construct();
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
		$this->_displayContent();
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
		$this->_html .= $helper->generateView();
	}

 	private function _displayContent()
	{
		global $cookie;

		$total = $this->_getTotal();
		$states = $this->_getTotalByState();
		$admin = $this->_getTotalForAdmin();
		$customer = $this->_getTotalForCustomer();
		$free = $this->_getTotalFree();
		$paid = $this->_getTotalPaidByCustomer();
		$average = $this->_getAverageCost();
		$orders = $this->_getOrdersWithSMS();
		$totalOrders = $this->_getNbTotalOrders();

		$this->_html .= '<br>
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset>
      			<legend><img src="'._MODULE_DIR_.$this->module->name.'/images/sendsmsStatsTab.gif" /> '.$this->l('Statistics').'</legend>
				<table style="width: 100%; text-align: center">
					<tr style="font-weight: bold; background-color: #F4E6C9; height: 30px">
						<td style="width: 33%">'.$this->l('Number of messages sent').'</td>
						<td style="width: 33%">'.$this->l('Status').' <font color="green">'.$this->l('OK').'</font></td>
						<td style="width: 33%">'.$this->l('Status').' <font color="red">'.$this->l('NOK').'</font></td>
					</tr>
					<tr>
						<td>' . $total . '</td>
						<td>' . (isset($states[1]) ? $states[1] : 0) . ' (' . ($total <= 0 ? '' : round($states[1] / $total * 100, 2)) . '%)</td>
						<td>' . (isset($states[0]) ? $states[0] : 0) . ' (' . ($total <= 0 ? '' : round($states[0] / $total * 100, 2)) . '%)</td>
					</tr>
				</table>
				<table style="width: 100%; padding-top: 20px; text-align: center">
					<tr style="font-weight: bold; background-color: #F4E6C9; height: 30px">
						<td style="width: 33%">'.$this->l('Sent to the admin').'</td>
						<td style="width: 33%">'.$this->l('Sent to customers').'</td>
						<td style="width: 33%">'.$this->l('Freehand').'</td>
					</tr>
					<tr>
						<td>' . $admin . ' (' . ($total <= 0 ? '' : round($admin / $total * 100, 2)) . '%)</td>
						<td>' . $customer . ' (' . ($total <= 0 ? '' : round($customer / $total * 100, 2)) . '%)</td>
						<td>' . $free . ' (' . ($total <= 0 ? '' : round($free / $total * 100, 2)) . '%)</td>
					</tr>
				</table>
				<table style="width: 100%; padding-top: 20px; text-align: center">
					<tr style="font-weight: bold; background-color: #F4E6C9; height: 30px">
						<td style="width: 33%">'.$this->l('Average of SMS by message').'</td>
						<td style="width: 33%">'.$this->l('Paid by customers').'</td>
						<td style="width: 33%">'.$this->l('Orders with SMS notification').'</td>
					</tr>
					<tr>
						<td>' . round($average, 2) . '</td>
						<td>' . $paid . ' (' . ($total <= 0 ? '' : round($paid / $total * 100, 2)) . '%)</td>
						<td>' . $orders . ' (' . ($totalOrders <= 0 ? '' : round($orders / $totalOrders * 100, 2)) . '%)</td>
					</tr>
				</table>
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

	private function _getTotal() {
		$res = Db::getInstance()->getRow("SELECT count(id_sendsms_logs) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE simulation != 1");
		return $res['total'];
	}

	private function _getTotalByState() {
		$result = array(0, 0);
		$res = Db::getInstance()->ExecuteS("SELECT distinct status, count(id_sendsms_logs) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE simulation != 1 GROUP BY status");
		foreach($res as $row) {
			$result[$row['status']] = $row['total'];
		}

		return $result;
	}

	private function _getTotalForAdmin() {
		$res = Db::getInstance()->getRow("SELECT count(id_sendsms_logs) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE id_customer IS NULL AND event != 'sendsmsFree' AND simulation != 1");
		return $res['total'];
	}

	private function _getTotalForCustomer() {
		$res = Db::getInstance()->getRow("SELECT count(id_sendsms_logs) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE id_customer > 0 AND simulation != 1");
		return $res['total'];
	}

	private function _getTotalFree() {
		$res = Db::getInstance()->getRow("SELECT count(id_sendsms_logs) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE event='sendsmsFree' AND simulation != 1");
		return $res['total'];
	}

	private function _getTotalPaidByCustomer() {
		$res = Db::getInstance()->getRow("SELECT count(id_sendsms_logs) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE paid_by_customer=1 AND simulation != 1");
		return $res['total'];
	}

	private function _getAverageCost() {
		$res = Db::getInstance()->getRow("SELECT AVG(nb_consumed) AS total FROM `" . _DB_PREFIX_ . "sendsms_logs` WHERE simulation != 1");
		return $res['total'];
	}

	public function _getOrdersWithSMS()
	{
		if (Configuration::get('SENDSMS_ID_PRODUCT')) {
			$res = Db::getInstance()->getRow('
				SELECT count(distinct(id_cart)) AS total
				FROM `'._DB_PREFIX_.'cart_product` AS cp
				JOIN `'._DB_PREFIX_.'cart` USING (id_cart)
				JOIN `'._DB_PREFIX_.'orders` USING (id_cart)
				WHERE cp.id_product = ' . Configuration::get('SENDSMS_ID_PRODUCT'));
			return $res['total'];
		} else {
			return 0;
		}
	}

	public function _getNbTotalOrders()
	{
		$res = Db::getInstance()->getRow('SELECT count(id_order) AS total FROM `'._DB_PREFIX_.'orders`');
		return $res['total'];
	}
}
?>