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

include_once(_PS_MODULE_DIR_.'/sendsms/classes/sendsmsManager.php');

class sendsmsLogs extends ObjectModel
{
	public 		$id_customer;
	public 		$recipient;
	public 		$phone;
	public 		$event;
	public 		$message;
	public 		$nb_consumed;
	public 		$credit;
	public 		$paid_by_customer;
	public 		$simulation;
	public 		$status;
	public 		$ticket;
	public 		$error;
	public 		$date_add;

	protected	$fieldsRequired = array();
	protected	$fieldsValidate = array();
	protected   $fieldsSize = array();

	protected	$fieldsRequiredLang = array();
	protected	$fieldsSizeLang = array();
	protected	$fieldsValidateLang = array();

	protected 	$table = 'sendsms_logs';
	protected 	$identifier = 'id_sendsms_logs';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_customer']           = intval($this->id_customer);
		$fields['recipient']        	 = pSQL($this->recipient);
		$fields['phone']              	 = pSQL($this->phone);
		$fields['event']             	 = pSQL($this->event);
		$fields['message']           	 = pSQL($this->message, true);
		$fields['nb_consumed']           = intval($this->nb_consumed);
		$fields['credit']           	 = floatval($this->credit);
		$fields['paid_by_customer']   	 = intval($this->paid_by_customer);
		$fields['simulation']   	 	 = intval($this->simulation);
		$fields['status']   			 = intval($this->status);
		$fields['ticket']   			 = pSQL($this->ticket);
		$fields['error']   			 	 = pSQL($this->error);
		$fields['date_add']              = pSQL($this->date_add);
		return $fields;
	}
}
?>