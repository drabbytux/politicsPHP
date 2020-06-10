<?
	if( array_key_exists('ssl_result_message', $_REQUEST ) && $_REQUEST['ssl_result_message'] == 'APPROVED'){ ?>
		<h2>Subscription Complete</h2>
		
<?	} else { /* A bad transaction */ ?>
		<p>The transaction could not be completed at this time. Please contact our circulation department at (613) 232-5952 ext. 209 or by email:  <a href="mailto:circulation@hilltimes.com">circulation@hilltimes.com</a></p>
		
		
<?	} ?>




<?




/**
	 * Array
(
    [ssl_result] => 0
    [ssl_result_message] => APPROVED
    [ssl_cvv2_response] => P
    [ssl_avs_response] => X
    [ssl_txn_id] => 00000000-0000-0000-0000-000000000000
    [ssl_txn_time] => 8/25/2008 4:25:05 PM
    [ssl_approval_code] => 123456
    [ssl_transaction_type] => SALE
    [ssl_amount] => 572
    [ssl_customer_code] => 
    [ssl_salestax] => 
    [ssl_invoice_number] => 
    [ssl_description] => 2 years/100 issues, U.S. Subscriptions, Print Edition (includes electronic edition)
    [ssl_company] => 
    [ssl_first_name] => 
    [ssl_last_name] => 
    [ssl_avs_address] => 
    [ssl_address2] => 
    [ssl_city] => Ottawa
    [ssl_state] => ONT
    [ssl_avs_zip] => 
    [ssl_country] => CA
    [ssl_email] => dave@cancon10.ca
    [ssl_phone] => 613-866-2087

	 * 
	 */

?>