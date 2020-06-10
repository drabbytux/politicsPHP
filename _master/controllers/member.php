<?php
/**
 * Membership is good!
 * Business Rules
 * ID 	DESCRIPTION
 * --	-----------
 * 1  	Paid Viewer, no restrictions on content viewing, except previous 2 week viewing of PDF only
 * 2  	Free Member, for making comments, posting to classifieds. Restictions to content
 * 10 	Super Admin - You!
 * 
 * 
 */
require_once 'classes/inhouse.controller.class.php';
class Member extends InHouseController  {
	private $accepted_types = array('canada','us','overseas','electronic');
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	public function Member(){
		$this->__construct( true );
	}

	public function index(){
		$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
		if( $this->_isLoggedIn() ){
			$this->Set_Template( 'output', 'member/edit_account_details.form.php' );
		} else {
			$this->Set_Template( 'output', 'member/subscribe.splash.php' );
		}
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	public function login(){
		
		// Both were filled out
		if( $this->Get_POST_Element('member_email') && $this->Get_POST_Element('member_password') ) {
			if( $this->_isMember( $this->Get_POST_Element('member_email') ) ) {
				if( $user_details = $this->_validateLogin( $this->Get('member_email'), $this->Get('member_password') ) ) {
					$this->_replenishMemberSessionData( $user_details );
					$this->_RemoveHash( $this->Get('member_email') ); // Remove the password reset hash.

					// Redirect to previous page before Login
					$this->Redirect_URL_Wrapper();	// -- Stalled until further on
					
				} else { // Email does exist, but either bad password or status
					$this->errors[] = 'You have entered an invalid email or password. Please try again.';
				}
			} else { // Throw error - Email not found
				$this->errors[] = 'That account is not active in our system. Please try again.';
			}
		} else if( $this->Get_POST_Element('member_email') && !$this->Get_POST_Element('member_password') ) { // Just username 
			$this->errors[] = 'Please provide a password.';
		} else if ( !$this->Get_POST_Element('member_email') && $this->Get_POST_Element('member_password') ) { // Just username 
			$this->errors[] = 'Please provide an email address.';
		}
		
		$this->Set_Member_Segment();
		$this->Set_Special_Authorized_Member_Segment();

		$this->Set_Template( 'output', 'member/login.form.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	public function logout(){
		$this->Remove_Session( 'member_id' );
		$this->Remove_Session( 'member_level' );
		$this->Remove_Session( 'member_name_first' );
		$this->Remove_Session( 'member_name_last' );
		// We have to redue the templates when this happens
		// use member info

		$this->Set_Member_Segment();
		$this->Set_Special_Authorized_Member_Segment();
		
		$this->Redirect_URL_Wrapper();	// -- Redirect
		$this->Set_Template( 'output', 'member/login.form.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	/**
	 * function forget()
	 * Oh - Forget yer password, did ya....
	 * 1) Fill in your email address
	 * 2) Sends a confirmation email
	 * 3) When link clicked, sends user back to fill in NEW password.
	 * 4) A session number is created under member table
	 * 5) IF no password is filled in, the old password stays in tact
	 * 6) When the user logs in, or the password is changed successfully, the session variable is destroyed
	 * 
	 */
	public function forget() {
		if( $this->get('forgot_email_address') ) {
			if( $this->_isMember( $this->get('forgot_email_address') ) ) {
				// Lets see - did this person already have a hash created? If so, prevent it from happening again.
				if( !$this->_MemberHash( $this->get('forgot_email_address') ) ){	
					// Create a hash to send
					$this->data['Password_Request_HASH'] = md5( date('d m') . $this->get('forgot_email_address') );
					$this->data['Password_Request_URL'] = URL_BASIC . '/member/rp/'.$this->data['Password_Request_HASH'];
					// Set the email template
					$this->Set_Template( 'email_content', 'member/forgot_password.email.php' );
					
					if( $this->_Send_Email( 'email_content','Password change request for '. NEWSPAPER_NAME,  $this->get('forgot_email_address'), EMAIL_ADDRESS_SYSTEM_1 ) ){
						// The mail was sent, so lets place the session variable into the member table for reference.
						$this->_MemberHash( $this->get('forgot_email_address'), $this->data['Password_Request_HASH'] );
						$this->Set_Message('Your password request has been sent to '.$this->get('forgot_email_address').'.'); 
					}
				} else { // Email has already been sent - Hash FOUND IN DB
					$this->Set_Error('A request to reset this account\'s password has already been sent. Please check your email for details.'); 
				}
			} else {
				// Email address not found in system
				$this->Set_Error('That email is not active within our system.'); 
			}
		}
		$this->Set_Template( 'output', 'member/forget.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	/**
	 * rp - Renew Password page
	 * Now an acronym to shorten the URL for clickablility within emails
	 */
	public function rp() {
		if( $this->data['member_email'] = $this->_MemberHash() ) {
			
			// Error Check emails
			if( $this->Get('member_new_password_1') || $this->Get('member_new_password_2') ) { 
				if( $this->Get('member_new_password_1') != $this->Get('member_new_password_2') ) {
					$this->Set_Error('Your new passwords do not match.');
					$this->Set_Template( 'output', 'member/reset_password.form.php' );
				} else {
					// Success?
					if( $this->_SaveResetPassword() ){
						$this->Set_Template( 'output', 'member/reset_password.success.php' );
					} else {
						$this->Set_Error('There was a problem with our system. Please <a href="/information/view/contact">contact us</a> to resolve the problem.');
						$this->Set_Template( 'output', 'member/reset_password.form.php' );
					}
					
				}
			} else { // No emails sent, show new password page
				
				$this->Set_Template( 'output', 'member/reset_password.form.php' );
			}

		} else {
			$this->Set_Template( 'output', 'page/404.php' );	// 404 or main page. Hmmmmmm.
		}
		$this->Set_Common_Templates();
		$this->Output_Page();	
	}
	
	
	
	public function edit(){
			if( $this->_isLoggedIn() ){
			$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor

			// Updating form data
			if( $this->Get('submit_member_update_profile') ){
				// Updating password error check
				if( $this->Get('member_new_password_1') || $this->Get('member_new_password_2') ) { 
					if( $this->Get('member_new_password_1') != $this->Get('member_new_password_2') ) {
						$this->Set_Error('Your new passwords do not match.');
					}
				}
				
				// Valid Email Check
				if( !$this->_validateEmailSyntax( $this->Get('member_email') ) ) {
					$this->Set_Error('Your email address is invalid.');
				}
				
				// At least the First Name
				if( !$this->Get('member_name_first') ){
					$this->Set_Error('You need to provide a first name.'); 
				}
			
				
				// No Errors? Update the database, return user to main member menu
	
				if( !$this->Has_Errors() ) {
	
					 if( $this->_SaveAccountDetails() ){
					 	// Lets replenish the session details before we send it anywhere.
					 	$this->_replenishMemberSessionData();
					 	
					 	$this->index();
					 	exit();
					 }
				} else {
					$this->Set_Template( 'output', 'member/edit_account_details.form.php' );
				}
				
			} else {
				// First Load
				$this->_fetchUserDetails();
				$this->Set_Template( 'output', 'member/edit_account_details.form.php' );
			}
			$this->Set_Common_Templates();
			$this->Output_Page();
			
		} else { // Not logged in
			$this->login();
			exit;
		}
		
		/*
		if( $this->_isLoggedIn() ){
			$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
			if( $this->_isLoggedIn() ){
				$this->Set_Template( 'output', 'member/edit.splash.php' );
			} else {
				$this->Set_Template( 'output', 'member/subscribe.splash.php' );
			}
			
			$this->Set_Common_Templates();
			$this->Output_Page();
		} else { // Not logged in
			$this->login();
		}
		*/	
	}

	public function editAccountDetails(){
		if( $this->_isLoggedIn() ){
			$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor

			// Updating form data
			if( $this->Get_POST_Element('member_update_password_submit') ){
				
				// Updating password error check
				if( $this->Get('member_new_password_1') || $this->Get('member_new_password_2') ) { 
					if( $this->Get('member_new_password_1') != $this->Get('member_new_password_2') ) {
						$this->Set_Error('Your new passwords do not match.');
					}
				}
				
				// Valid Email Check
				if( !$this->_validateEmailSyntax( $this->Get('member_email') ) ) {
					$this->Set_Error('Your email address is invalid.');
				}
				
				// At least the First Name
				if( !$this->Get('member_name_first') ){
					$this->Set_Error('You need to provide a first name.'); 
				}
				
				
				// No Errors? Update the database, return user to main member menu
	
				if( !$this->Has_Errors() ) {
					 if( $this->_SaveAccountDetails() ){
					 	$this->index();
					 	exit();
					 }
				} else {
					$this->Set_Template( 'output', 'member/edit_account_details.form.php' );
				}
				
			} else {
				// First Load
				$this->_fetchUserDetails();
				$this->Set_Template( 'output', 'member/edit_account_details.form.php' );
			}
			$this->Set_Common_Templates();
			$this->Output_Page();
			
		} else { // Not logged in
			$this->login();
			exit;
		}
		
	}

	public function editSubscriptionDetails(){
		$this->_fetchUserDetails();
		$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
		$this->Set_Template( 'output', 'member/edit_subscription_details.form.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	public function subscribe(){

		$this->_fetchUserDetails();
		
		// This refers to the subcription_paper id
		
		if( $this->Get('member_subscription_profile_cancel') ){
			$this->_RemoveSubscriptionSessionDetails();
			$this->Redirect_URL_Wrapper();
		}
		
		
		// Get Subscription Type chosen - FOUND
		if( $this->Get_URL_Element( VAR_1 ) && in_array($this->Get_URL_Element( VAR_1 ), $this->accepted_types) ) {
			$this->_fetchSubscriptionPrices( $this->_getIDForSubscriptionGroupName( $this->Get_URL_Element( VAR_1) ), $this->_GetSubscriptionPaperID() ); //Use an ID to get only the two options

			// Member Information has been entered
			if( $this->Get('member_subscription_profile_submit') ){
				if( $this->_validateNewSubscriptionInformation() ){
					// User Information has been accepted.
					

					// Set the member data for the session
						$this->data['page_type']= 'viaklix';
						$this->_SetSubscriptionSessionDetails();
						$this->_fetchSubscriptionPrices();
										
					// Show the Payment Options
					$this->Set_Template( 'output', 'member/subscription_payment_options.php' );
				} else {
					// Bad user information has been entered
					$this->Set_Template( 'output', 'member/subscription_breakdown.php' );
				}
			} else { 
				// No information has been entered yet
				$this->Set_Template( 'output', 'member/subscription_breakdown.php' );
			}
			$this->Set_Common_Secure_Templates();
		} else { 
			// Nothing done, show the very first/splash page
			$this->_RemoveSubscriptionSessionDetails();
			$this->Set_Template( 'output', 'member/subscribe.splash.php' );	
			$this->Set_Common_Templates();
		}
		
		// Get New Memeber information

		
		$this->Output_Page();
	}
	
public function trialsubscribe(){

		$this->_fetchUserDetails();
		
		// This refers to the subcription_paper id
		
		if( $this->Get('member_subscription_profile_cancel') ){
			$this->_RemoveSubscriptionSessionDetails();
			$this->Redirect_URL_Wrapper();
		}
		
		
		// Member Information has been entered
		if( $this->Get('member_subscription_profile_submit') ){
			if( $this->_validateNewSubscriptionInformation() ){
					$this->data['page_type']= 'complete';
					$this->_SetSubscriptionSessionDetails();
					
				// Say thank you, send the user an email, etc...
		
				// User Information has been accepted.
				
				// Take the very next Sunday date and add 1 month.
					$unix_sunday = strtotime("next sunday");
					$this->data['new_member_expire_unix_date'] = mktime(23,59,59, date('m', $unix_sunday)+1, date('d', $unix_sunday),date('Y', $unix_sunday) );
						
				if( $this->_SaveAccountDetails(true) ){
					
					// True for a new user
						$this->_send_client_new_subscription_details(true);
						$this->_send_circulation_new_subscription_details();
	
				}


					

			} else {
				// Bad user information has been entered
				$this->Set_Template( 'output', 'member/trial_subscription_breakdown.php' );
			}
		} else { 
			// No information has been entered yet
			$this->Set_Template( 'output', 'member/trial_subscription_breakdown.php' );
		}
		$this->Set_Common_Secure_Templates();
	
		
		// Get New Memeber information

		
		$this->Output_Page();
	}
	
	/**
	 * Loads the form for submission to viaKlix, and viaKlix responds with something
	 *
	 */
	public function subscriptionProcess(){
	
		$this->_SetSubscriptionSessionDetails();
		// Send an Invoice
		
			
		if( $this->Get('send_invoice') ){
			
			// adding a year for now..
			$unix_sunday = strtotime("next sunday");
				$this->data['new_member_expire_unix_date'] = mktime(23,59,59, date('m', $unix_sunday), date('d', $unix_sunday),date('Y', $unix_sunday)+1 );
				
					
			if( $this->_SaveAccountDetails(true) ) {
				$this->_send_client_new_subscription_details();
				$this->_send_circulation_new_subscription_details();
			
				$this->Set_Template( 'output', 'member/subscription_complete_send_invoice.php' );
			} else {
				// $this->Set_Template( 'output', 'member/error_saving_details.php' );
				
			}
			
			$this->Set_Common_Secure_Templates();	
			
		} else {
					
		
		// Validate via ViaKlix
			$this->data['page_type']= 'viaklix';
			$this->_SetSubscriptionSessionDetails();
			$this->_fetchSubscriptionPrices();
						
			if( !$this->validateCC( $this->Get_Session('ssl_card_number'), $this->Get_Session('ssl_payment_card_type') ) ) {
				$this->Set_Error('The card number you provided seems to be incorrect. Please try again.', 'ssl_card_number');
				
			} 
			
			if( !$this->validate_card_exp( $this->Get_Session('ssl_exp_date') ) ){
				$this->Set_Error('Check the expiry date used on your card and try again.', 'ssl_exp_date');
			}
			
			// Error checking complete
			if( $this->Has_Errors() ){
				$this->Set_Template( 'output', 'member/subscription_payment_options.php' );
				$this->Set_Common_Secure_Templates();	
			} else {
				// Process - all error checks have passed
				$this->Set_Template( 'output', 'member/viaklix_form.php' );
			}
		}
		
		$this->Output_Page();

	}
	
	public function subscriptionProcessResult() {
		$this->_SetSubscriptionSessionDetails();
		
		// adding a year for now...
		$unix_sunday = strtotime("next sunday");
			$this->data['new_member_expire_unix_date'] = mktime(23,59,59, date('m', $unix_sunday), date('d', $unix_sunday),date('Y', $unix_sunday)+1 );
				
				
		if( $this->_SaveAccountDetails(true) ) {
			$this->_send_client_new_subscription_details();
			$this->_send_circulation_new_subscription_details();
			
			$this->_RemoveSubscriptionSessionDetails(); // Remove all details
			$this->Set_Template( 'output', 'member/subscribe.receipt.php' );
		}
			$this->Set_Common_Templates();
			$this->Output_Page();
	}
	
	// Upon completion of a positive response of viaKlix
	public function showReceipt() {
		$this->Set_Template( 'output', 'member/subscribe.receipt.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
			$this->Output_Page();
	}
	
	
	
	public function renewSubscription(){
		$this->_fetchUserDetails();
		$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
		$this->Set_Template( 'output', 'member/renew_subscription.splash.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	/**
	 * From a locked story, a non-member fills out the quick form and it
	 * leads to this function, which gets a few more details before
	 * they are allowed to view the story
	 *
	 */
	public function quickwebsubscribe() {
		$this->Set_Template( 'output', 'member/quick_subscription.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	
	/**
	 * Pass it the id from 
	 *
	 * @param unknown_type $subscription_id
	 */
	public function getSubscriptionInfo( $subscription_id, $key = NULL ){
		// Check to make sure there is a subscription array
		if( !$this->Get_Data_Holder( 'subscription_price_array' ) ) { //subscription_price_array')
			$this->_fetchSubscriptionPrices();
		}
		$arr_info = $this->Get_Data_Holder( 'subscription_price_array', $subscription_id );
		if( array_key_exists($key, $arr_info ) ){
			return $arr_info[ $key ];
		}
	
	}
	
	/**
	 * AJAX response for the credit card processing
	 *
	 */
	public function ajaxResponseViaKlixResponse(){
		
		// print 'The Ajax works, at least.';
	}
	
	
	public function outputSubscriptionTypeDropDown(){
		$this->_fetchSubscriptionPrices();

		
	}
	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\
	
	private function _send_client_new_subscription_details($trial=false) {
		if( $trial ) {
			$this->Set_Template('client_email_content', 'member/email_new_trial_subscription_client.php');
		} else {
			$this->Set_Template('client_email_content', 'member/email_new_subscription_client.php');
		}
		$this->_Send_Email('client_email_content','Subscription Details', $this->Get_Data('member_email'),EMAIL_ADDRESS_SYSTEM_1);
		return true;
	}
	
	
	private function _send_circulation_new_subscription_details(){
    		$this->Set_Template('circulation_email_content', 'member/email_new_subscription_circulation.php');
			$this->_Send_Email('circulation_email_content','Subscription Details',EMAIL_CIRCULATION,EMAIL_ADDRESS_SYSTEM_1);
  	}
	
	/**
	 * Used in the old site to validate the CC before it's sent to viaKlix
	 * Viaklix isn't great in it's error handling, so we catch these before we're faced with 
	 * a bad viaklix response
	 *
	 * @param unknown_type $ccnum
	 * @param unknown_type $type
	 * @return unknown
	 */
	private function validateCC($ccnum, $type = 'unknown')
	{
				
		//Clean up input
		$type = strtolower($type);
		$ccnum = ereg_replace('[-[:space:]]', '',$ccnum); 
	
		//Do type specific checks
		if ($type == 'unknown') 
		{
			//Skip type specific checks
			return 0;
		}
		elseif ($type == 'mastercard')
		{
	 		if (strlen($ccnum) != 16 || !ereg('5[1-5]', $ccnum)) return 0;
	 	}
	 	elseif ($type == 'visa')
	 	{
	 		if ((strlen($ccnum) != 13 && strlen($ccnum) != 16) || substr($ccnum, 0, 1) != '4') return 0;
	 	}
		elseif ($type == 'amex')
		{
			if (strlen($ccnum) != 15 || !ereg('3[47]', $ccnum)) return 0;
		}
		elseif ($type == 'discover')
		{
			if (strlen($ccnum) != 16 || substr($ccnum, 0, 4) != '6011') return 0;
		}
		else 
		{

			//invalid type entered
			return 0;
		}
	
		// Start MOD 10 checks
		$dig = str_split($ccnum);

		$numdig = sizeof ($dig);

		$j = 0;
		for ($i=($numdig-2); $i>=0; $i-=2)
		{
			$dbl[$j] = $dig[$i] * 2;
			$j++;
		}
		$dblsz = sizeof($dbl);
		$validate = 0;
		for ($i=0;$i<$dblsz;$i++)
		{
			$add = str_split($dbl[$i]);
			for ($j=0;$j<sizeof($add);$j++)
			{
				$validate += $add[$j];
			}
			$add = '';
		}
		for ($i=($numdig-1); $i>=0; $i-=2)
		{
			$validate += $dig[$i]; 
		}
		if (substr($validate, -1, 1) == '0'){
			return true;
		} else {
			return false;
		}
}
	
	private function validate_card_exp( $date )
	{
	$month = settype(substr($date, 0, 2), "integer");
	$year = settype(substr($date, 2, 2), "integer");
	$this_year = settype(date('y'), "integer");
	$this_month = settype(date('n'), "integer");
	if ( $year >= $this_year )
	{
		if ( $month >= $this_month )
		{
			return true;
		} else {
			return false; // return $month."-".$year."-".$this_year."-".$this_month;
		}
	} else {
		return false; //$month."-".$year."-".$this_year."-".$this_month;
	}
}
	
	private function _validateNewSubscriptionInformation(){
		/**
		 * Confirm Email style
		 * Confirm Email not in DB
		 * If Subscription for paper version
		 * 	- Delivery Information complete
		 * Phone Number
		 * Check Password  filled out
		 * Check Passwords larger than 4 chars
		 * Check Passwords the same
		 * 
		 * When complete, save Everything to Session
		 * Return True if success
		 * 
		 */
		
		// E R R O R   C H E C K   S T A R T

		// First Name
		if ( !$this->Get('member_name_first') ) {
			$this->Set_Error('Please enter your name.', 'member_name_first');
		}
		// member_city', 'member_province', 'member_postal_code', 'member_preference_email_pdf

		// Street 1
		if ( !$this->Get('member_street_address_1') ) {
			$this->Set_Error('Please enter street address.', 'member_street_address_1');
		}
		
		// City
		if ( !$this->Get('member_city') ) {
			$this->Set_Error('Please enter your city.', 'member_city');
		}

		// State/Prov
		if ( !$this->Get('member_province') ) {
			$this->Set_Error('Please enter a province/state name.', 'member_province');
		}
		
		// POSTAL
		if ( !$this->Get('member_postal_code') ) {
			$this->Set_Error('Please enter your postal code.', 'member_postal_code');
		}

		// Phone number
		if ( !$this->Get('member_phone') ) {
			$this->Set_Error('Please enter your phone number.', 'member_phone');
		}
		
		
		// Email Syntax
		if ( !$this->_validateEmailSyntax( $this->Get('member_email') ) ) {
			$this->Set_Error('Your email address is not valid.', 'member_email');
		}
		// Is email in use already?
		if( $this->_isMember( $this->Get('member_email'), true ) ) {
			$this->Set_Error('That email is already in use within our system.', 'member_email');
		}
		
		
		if( !$this->Get('member_new_password_1') && !$this->Get('member_new_password_2') ){
			$this->Set_Error('Please enter a set of matching passwords.', 'member_new_password_1');
			$this->Set_Error('&nbsp;', 'member_new_password_2');
		}
		
		// Updating password error check
		if( $this->Get('member_new_password_1') || $this->Get('member_new_password_2') ) { 
			if( $this->Get('member_new_password_1') != $this->Get('member_new_password_2') ) {
				$this->Set_Error('Your new passwords do not match.', 'member_new_password_1' );
				$this->Set_Error('&nbsp;', 'member_new_password_2');
			}
		}
		
		// Subscription
		if ( !$this->Get('member_price') ) {
			$this->Set_Error('Please choose a Subscription Option.', 'member_price');
		}
				
		// Just for testing !!!!
		if( !$this->errors ){
			return true;
		}
		

	}
	
	private function _SetSubscriptionSessionDetails(){
		
		$this->Set_Post_Sessions('member_');
		$this->Set_Post_Sessions('ssl_');

	}
	
	/**
	 * The numbers that are returned are in the DATABase.
	 * It would be nice if it automatically corresponded.
	 * Currenty it returns 1 or 2 for HT and EM, and a 3 if
	 * VAR_2 = bothpapers
	 *
	 * @return unknown
	 */
	private function _GetSubscriptionPaperID(){
		
		if( $this->Get_URL_Element( VAR_2 ) == 'bothpapers' ){
			return '3';
		} else {
			if( SITE=='HT' ){
				return '1';
			} else if (SITE=='EM') {
				return '2';
			}
		}
	}
	
	
	private function _RemoveSubscriptionSessionDetails() {
		$this->Clear_Session_Variables( 'member_' );
		$this->Clear_Session_Variables( 'ssl_' );
	}
		
	private function _isMember( $login_name, $check_only_the_email = NULL ){
		$sql = "SELECT member_id from member where member_email = '$login_name' ";
		$sql .= (!$check_only_the_email)? " AND member_status='".STATUS_LIVE."'" : NULL;
		return $this->ExecuteAssoc( $sql );
	}
	
	private function _validateLogin( $member_email, $member_password){
		$sql = "SELECT member_id, member_authority_level_id, member_name_first, member_name_last, member_email from member where member_email = '$member_email' AND member_password = md5('$member_password') AND member_status='".STATUS_LIVE."'";
		return $this->ExecuteAssoc( $sql );
	}
	
	private function _isLoggedIn(){
		if( $id = $this->Get_Session('member_id')){
			return $id;
		}
	}

	private function _fetchUserDetails( $just_return_the_details = NULL ){
		if( $this->_isLoggedIn() ){
			$sql = "SELECT * from member where member_id='".$this->Get_Session('member_id')."'";
			if( $just_return_the_details ){
				return $this->ExecuteAssoc( $sql );
			} else  {
				$this->data_holder['member_details'] = $this->ExecuteAssoc( $sql );	
				$this->Set_Data_From_Data_Holder_Array('member_details', '');
			}
		}
	}

	private function _getIDForSubscriptionGroupName( $group_title ){
	 	$sql 	= 'SELECT subscription_group_id from subscription_group where subscription_group_title=\''.$group_title.'\'';
	 	$arr_id = $this->ExecuteAssoc($sql);
	 	return $arr_id['subscription_group_id'];
	 }
	 
	private function _fetchSubscriptionPrices( $subscription_group_id = NULL, $subscription_paper_id = NULL){
		$fmt_arr = array();
		$sql ='SELECT * FROM subscription_prices left join subscription_group on (subscription_prices_group_id = subscription_group_id)';
		$sql .= " left join subscription_paper on (subscription_prices_paper_id=subscription_paper_id)";
		$sql .= " left join subscription_paper_type on (subscription_prices_paper_type_id=subscription_paper_type_id)";
		$sql .= ($subscription_group_id)? ' where subscription_prices_group_id='.$subscription_group_id:NULL;
		if( $subscription_paper_id && $subscription_group_id ) {
			$sql .= ' and subscription_prices_paper_id='.$subscription_paper_id;
		} else if ($subscription_paper_id && !$subscription_group_id ) {
			$sql .= ' where subscription_prices_paper_id='.$subscription_paper_id;
		}
		$sql .= " ORDER by subscription_prices_paper_id asc, subscription_prices_paper_type_id asc";
		$arr_sql = $this->ExecuteArray( $sql );
		if( is_array( $arr_sql ) ) {
			foreach( $arr_sql as $sub_item ){
				$fmt_arr[ $sub_item['subscription_prices_id'] ] = $sub_item;
			}
		}
		$this->data_holder['subscription_price_array'] = $fmt_arr;
	}
	
	/**
	 * send it an array of of details
	 *
	 * @param unknown_type $user_details
	 */
	private function _replenishMemberSessionData( $user_details = NULL ){
		if( !$user_details ){
			$this->_fetchUserDetails();
			$user_details = $this->data_holder['member_details'];
		}
				
		$this->Set_Session( 'member_id' , 	$user_details['member_id'] );
		$this->Set_Session( 'member_level', $user_details['member_authority_level_id'] );
		$this->Set_Session( 'member_name_first', $user_details['member_name_first'] );
		$this->Set_Session( 'member_name_last', $user_details['member_name_last'] );
		$this->Set_Session( 'member_email', $user_details['member_email'] );
	}
	
	private function _SaveAccountDetails( $new_member = false ){
		// Get the old details first so we can use it after the update so we can send it to circulation
		
		if( $new_member ){ // Brand spanking new member!

			// Paid and Trial
			$sql =  "INSERT into member (`member_name_first`,`member_name_last`, `member_email`,`member_password`,`member_preference_email_pdf`,`member_expire_date`) values (";
			$sql .=  $this->dbReady( $this->Get_Session('member_name_first') );
			$sql .=  $this->dbReady( $this->Get_Session('member_name_last') );
			$sql .=  $this->dbReady( $this->Get_Session('member_email') );
			if( $this->Get_Session('member_new_password_1') || $this->Get_Session('member_new_password_2') ) { 
				if( $this->Get_Session('member_new_password_1') == $this->Get_Session('member_new_password_2') ) {
					$sql .= "md5('".trim( $this->Get_Session('member_new_password_1') )."'),";
				}
			}
			$sql .=  $this->dbReady( $this->Get_Session('member_preference_email_pdf'));
			$sql .=  $this->dbReady( $this->Get_Data('new_member_expire_unix_date'), true);
			$sql .= ")";
			
			if( $this->Execute( $sql )){
				$this->Set_Message('Account details were saved successfully.');
				return true;
			} else {
				$this->Set_Error('Account details could not be saved.');
			}
			
			
		} else {	// User just editing his/her details
			$old_user_details =  $this->_fetchUserDetails(true);
			
			$sql =  "UPDATE member set ";
			$sql .= ' member_name_first='. $this->dbReady( $this->Get('member_name_first') );
			$sql .= ' member_name_last='. $this->dbReady( $this->Get('member_name_last') );
			$sql .= " member_email=" . $this->dbReady( $this->Get('member_email') );
			if( $this->Get('member_new_password_1') || $this->Get('member_new_password_2') ) { 
				if( $this->Get('member_new_password_1') == $this->Get('member_new_password_2') ) {
					$sql .= " member_password=md5('".trim( $this->Get('member_new_password_1') )."'),";
				}
			}
			$sql .= " member_preference_email_pdf=" . $this->dbReady( $this->Get('member_preference_email_pdf'), true );
			$sql .= " where member_id=". $this->_isLoggedIn();
	
			if( $this->Execute( $sql )){
				$this->Set_Message('Account details were saved successfully.');
				$new_user_details =  $this->_fetchUserDetails(true);
				$this->Email_Circulation_Account_Details($old_user_details, $new_user_details);
			} else {
				$this->Set_Error('Account details could not be saved.');
			}
			return true;
		}
	}

	/**
	 * Editing and Saving a member details.
	 * This should get the old and new details of the account that will be sent to circulation.
	 * 
	 *
	 */
	private function Email_Circulation_Account_Details($old_details = NULL, $new_details){
		/**
		 *   [member_id] => 1
    [member_email] => dlittle@hilltimes.com
    [member_name_first] => Dave
    [member_name_last] => Little
    [member_street_address_1] => 
    [member_street_address_2] => 
    [member_city] => 
    [member_province] => 
    [member_postal_code] => 
    [member_preference_email_pdf] => 3
		 * 
		 */
		$str_details = NULL;

    	$arr_fields_that_may_change = array('member_email','member_name_first', 'member_name_last', 'member_street_address_1', 'member_street_address_2', 'member_city', 'member_province', 'member_postal_code', 'member_preference_email_pdf');
	
    	//Compare Fields updated. If any of them are changed, record it.
    	// If none, they just did a password update that circulation doesn't need to worry about.
    	foreach( $arr_fields_that_may_change as $field ){
    		if( $old_details[$field] != $new_details[ $field ] ){
    			$str_details .= "\n". $field .' has been changed from ' . $old_details[$field] . ' to '. $new_details[$field];
    		}
    	}
    	
    	// We're done... ANything changed? Send it to circulation
    	if( $str_details) {
    		$email_body = "\n". $str_details;
    		$email_body .= "\n\nThese account changes are for the following account:";
    		$email_body .= "\n\n-----------------------------------------------";
			foreach( $old_details as $val ){
				$email_body .= "\n| ". $val;
			}
			$email_body .= "\n-----------------------------------------------";
			
			
			// Save the content for the email
			$this->data['circulation_email_content'] = $email_body;
			$this->_Send_Email('circulation_email_content','Website membership - detail change','dlittle@hilltimes.com',EMAIL_ADDRESS_SYSTEM_1);
    	}
    	
    	
	}
	
	
	private function _SaveResetPassword(){
		$sql =  "UPDATE member set";
		$sql .= " member_password=md5('".trim( $this->Get('member_new_password_1') )."')";
		$sql .= " where member_email='". $this->data['member_email'] . "'";

		if( $this->Execute( $sql )){
			$this->_RemoveHash( $this->data['member_email'] );
			$this->Set_Message('New password saved successfully.');
			return true;
		} else {
			$this->Set_Error('Your new password could not be saved.');
		}
		
	}
	
	private function _Send_Email( $data_variable_email_content, $email_subject, $email_to, $email_from ) {
		if( $this->Get_Data( $data_variable_email_content ) && $email_to && $email_from ) {
			if( mail( $email_to, $email_subject, $this->Get_Data( $data_variable_email_content ), "From: $email_from") ) {
				return true;
			} else {
				$this->Set_Error('Could not send Email. The system is not configured to send mail');
			}
		}
	}
	
	/**
	 * MemberHash
	 * Retrieves a member's hash code based on the email address
	 * if a second variable is sent (a hash code), it is set to the email address
	 */
	private function _MemberHash( $email = NULL, $set_hash = NULL ){
		if( $email && $set_hash ){
			$sql = "UPDATE member set member_password_reset_hash='".$set_hash."' where member_email='".$email."'";
			$this->Execute( $sql );
		} else if( !$email ) {	// Get the Email based on the hash - We assume the first variable is in the URL(get)
			if( $this->Get_URL_Element( VAR_1 ) ) {
				$sql = "SELECT member_email from member where member_password_reset_hash='". $this->Get_URL_Element( VAR_1 ) ."'";
				$res = $this->ExecuteAssoc( $sql );
				return $res['member_email'];
			}
		}else {
			$sql = "SELECT member_password_reset_hash from member where member_email='".$email."'";
			$row = $this->ExecuteAssoc( $sql );
			if( trim( $row['member_password_reset_hash']) ){
				$this->data['member_hash'] = $row['member_password_reset_hash'];
				return true;
			} else {
				return false;
			}
		}	
	}
	
	private function _RemoveHash( $email ){
		$sql = "UPDATE member set member_password_reset_hash='' where member_email='".$email."'";
		$this->Execute( $sql );
	}

}

?>