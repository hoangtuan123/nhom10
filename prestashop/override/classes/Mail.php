<?php

class Mail extends MailCore
{
    public static function Send($id_lang, $template, $subject, $template_vars, $to,
		$to_name = null, $from = null, $from_name = null, $file_attachment = null, $mode_smtp = null, $template_path = _PS_MAIL_DIR_, $die = false, $id_shop = null)
	{
		$result = parent::Send($id_lang, $template, $subject, $template_vars, $to, $to_name, $from, $from_name, $file_attachment, $mode_smtp, $template_path, $die, $id_shop);

		// customer_qty = mail from mailalert module
		if (Module::isInstalled('sendsms') && ($template == 'contact' || $template == 'customer_qty')) {
			$context = Context::getContext();
			if ($template == 'contact' && isset($context->customer) && !$context->customer->is_guest) {
				Hook::exec('sendsmsContactForm', array('contact_mail' => $to, 'contact_name' => $to_name, 'customer' => $context->customer, 'from' => $from, 'message' => eregi_replace('<br[[:space:]]*/?[[:space:]]*>',chr(13).chr(10),$template_vars['{message}'])));
			} else if ($template == 'customer_qty') {
				$customer = new Customer();
				$customer->getByEmail($to);
				Hook::exec('sendsmsCustomerAlert', array('customer' => $customer, 'product' => $template_vars['{product}']));
			}
		}
		return $result;
	}
}
?>