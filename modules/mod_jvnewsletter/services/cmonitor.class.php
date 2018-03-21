<?php
/**
 # mod_jvnewsletter - JV NEWSLETTER
 # @version        1.0
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__).'/cmonitor/base_classes.php';

/**
 * Class to access general resources from the create send API.
 * @author tobyb
 *
 */
class CS_REST_General extends CS_REST_Wrapper_Base {

    /**
     * Get the authorization URL for your application, given the application's
     * Client ID, Client Secret, Redirect URI, Scope, and optional state data.
     *
     * @param $client_id int The Client ID of your registered OAuth application.
     * @param $redirect_uri string The Redirect URI of your registered OAuth application.
     * @param $scope string The comma-separated permission scope your application requires.
     *        See http://www.campaignmonitor.com/api/getting-started/#authenticating_with_oauth for details.
     * @param $state string Optional state data to be included in the URL.
     * @return string The authorization URL to which users of your application should be redirected.
     * @access public
     **/
    public static function authorize_url(
        $client_id, $redirect_uri, $scope, $state = NULL) {
        $qs = "client_id=".urlencode($client_id);
        $qs .= "&redirect_uri=".urlencode($redirect_uri);
        $qs .= "&scope=".urlencode($scope);
        if ($state) {
            $qs .= "&state=".urlencode($state);
        }
        return CS_OAUTH_BASE_URI.'?'.$qs;
    }

    /**
     * Exchange a provided OAuth code for an OAuth access token, 'expires in'
     * value and refresh token.
     *
     * @param $client_id int The Client ID of your registered OAuth application.
     * @param $client_secret string The Client Secret of your registered OAuth application.
     * @param $redirect_uri string The Redirect URI of your registered OAuth application.
     * @param $code string The unique OAuth code to be exchanged for an access token.
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'access_token' => The access token to use for API calls
     *     'expires_in' => The number of seconds until this access token expires
     *     'refresh_token' => The refresh token to refresh the access token once it expires
     * }
     * @access public
     **/
    public static function exchange_token(
        $client_id, $client_secret, $redirect_uri, $code) {

        $body = "grant_type=authorization_code";
        $body .= "&client_id=".urlencode($client_id);
        $body .= "&client_secret=".urlencode($client_secret);
        $body .= "&redirect_uri=".urlencode($redirect_uri);
        $body .= "&code=".urlencode($code);

        $options = array('contentType' => 'application/x-www-form-urlencoded');

        $wrap = new CS_REST_Wrapper_Base(
            NULL, 'https', CS_REST_LOG_NONE, CS_HOST, NULL,
            new CS_REST_DoNothingSerialiser(), NULL);

        return $wrap->post_request(CS_OAUTH_TOKEN_URI, $body, $options);
    }

    /**
     * Constructor.
     * @param $auth_details array Authentication details to use for API calls.
     *        This array must take one of the following forms:
     *        If using OAuth to authenticate:
     *        array(
     *          'access_token' => 'your access token',
     *          'refresh_token' => 'your refresh token')
     *
     *        Or if using an API key:
     *        array('api_key' => 'your api key')
     * @param $protocol string The protocol to use for requests (http|https)
     * @param $debug_level int The level of debugging required CS_REST_LOG_NONE | CS_REST_LOG_ERROR | CS_REST_LOG_WARNING | CS_REST_LOG_VERBOSE
     * @param $host string The host to send API requests to. There is no need to change this
     * @param $log CS_REST_Log The logger to use. Used for dependency injection
     * @param $serialiser The serialiser to use. Used for dependency injection
     * @param $transport The transport to use. Used for dependency injection
     * @access public
     */
    function CS_REST_Wrapper_Base(
        $auth_details,
        $protocol = 'https',
        $debug_level = CS_REST_LOG_NONE,
        $host = 'api.createsend.com',
        $log = NULL,
        $serialiser = NULL,
        $transport = NULL) {
        $this->CS_REST_Wrapper_Base($auth_details, $protocol, $debug_level, $host, $log, $serialiser, $transport);        
    }

    /**
     * Gets an array of valid timezones
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array<string>(timezones)
     */
    function get_timezones() {
        return $this->get_request($this->_base_route.'timezones.json');
    }

    /**
     * Gets the current date in your accounts timezone
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'SystemDate' => string The current system date in your accounts timezone
     * }
     */
    function get_systemdate() {
        return $this->get_request($this->_base_route.'systemdate.json');
    }

    /**
     * Gets an array of valid countries
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array<string>(countries)
     */
    function get_countries() {
        return $this->get_request($this->_base_route.'countries.json');
    }

    /**
     * Gets your API key
     * @param string $username Your username
     * @param string $password Your password
     * @param string $site_url The url you use to login from
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'ApiKey' => string Your api key
     * }
     */
    function get_apikey($username, $password, $site_url) {
        return $this->get_request($this->_base_route.'apikey.json?siteurl='.$site_url,
            array('authdetails' => array('username' => $username, 'password' => $password))
        );
    }

    /**
     * Gets an array of clients
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'ClientID' => The clients API ID,
     *         'Name' => The clients name
     *     }
     * )
     */
    function get_clients() {
        return $this->get_request($this->_base_route.'clients.json');
    }

    /**
     * Gets your billing details.
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'Credits' => The number of credits belonging to the account
     * }
     */
    function get_billing_details() {
        return $this->get_request($this->_base_route.'billingdetails.json');
    }

    /**
     * Gets an array of administrators
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'EmailAddress' => The administrators email address
     *         'Name' => The administrators name
     *         'Status' => The administrators status
     *     }
     * )
     */
    function get_administrators() {
        return $this->get_request($this->_base_route.'admins.json');
    }
    
    /**
     * Retrieves the email address of the primary contact for this account
     * @return CS_REST_Wrapper_Result a successful response will be an array in the form:
     *         array('EmailAddress'=> email address of primary contact)
     */
    function get_primary_contact() {
        return $this->get_request($this->_base_route.'primarycontact.json');
    }

    /**
     * Assigns the primary contact for this account to the administrator with the specified email address
     * @param $emailAddress string The email address of the administrator designated to be the primary contact
     * @return CS_REST_Wrapper_Result a successful response will be an array in the form:
     *         array('EmailAddress'=> email address of primary contact)
     */
    function set_primary_contact($emailAddress) {
        return $this->put_request($this->_base_route.'primarycontact.json?email=' . urlencode($emailAddress), '');
    }

    /**
     * Get a URL which initiates a new external session for the user with the given email.
     * Full details: http://www.campaignmonitor.com/api/account/#single_sign_on
     *
     * @param $session_options array Options for initiating the external login session.
     *        This should be an array of the form:
     *        array(
     *          'Email' => 'The email address of the Campaign Monitor user for whom the login session should be created',
     *          'Chrome' => 'Which 'chrome' to display - Must be either "all", "tabs", or "none"',
     *          'Url' => 'The URL to display once logged in. e.g. "/subscribers/"',
     *          'IntegratorID' => 'The Integrator ID. You need to contact Campaign Monitor support to get an Integrator ID.',
     *          'ClientID' => 'The Client ID of the client which should be active once logged in to the Campaign Monitor account.' )
     *
     * @return CS_REST_Wrapper_Result A successful response will be an array of the form:
     *         array('SessionUrl'=> 'https://external1.createsend.com/cd/create/ABCDEF12/DEADBEEF?url=FEEDDAD1')
     */
    function external_session_url($session_options) {
        return $this->put_request($this->_base_route.'externalsession.json', $session_options);
    }
}

/**
 * Class to access a clients resources from the create send API.
 * This class includes functions to create and edit clients,
 * along with accessing lists of client specific resources e.g campaigns
 * @author tobyb
 *
 */
class CS_REST_Clients extends CS_REST_Wrapper_Base {

    /**
     * The base route of the clients resource.
     * @var string
     * @access private
     */
    var $_clients_base_route;

    /**
     * Constructor.
     * @param $client_id string The client id to access (Ignored for create requests)
     * @param $auth_details array Authentication details to use for API calls.
     *        This array must take one of the following forms:
     *        If using OAuth to authenticate:
     *        array(
     *          'access_token' => 'your access token',
     *          'refresh_token' => 'your refresh token')
     *
     *        Or if using an API key:
     *        array('api_key' => 'your api key')
     * @param $protocol string The protocol to use for requests (http|https)
     * @param $debug_level int The level of debugging required CS_REST_LOG_NONE | CS_REST_LOG_ERROR | CS_REST_LOG_WARNING | CS_REST_LOG_VERBOSE
     * @param $host string The host to send API requests to. There is no need to change this
     * @param $log CS_REST_Log The logger to use. Used for dependency injection
     * @param $serialiser The serialiser to use. Used for dependency injection
     * @param $transport The transport to use. Used for dependency injection
     * @access public
     */
    function CS_REST_Clients(
    $client_id,
    $auth_details,
    $protocol = 'https',
    $debug_level = CS_REST_LOG_NONE,
    $host = 'api.createsend.com',
    $log = NULL,
    $serialiser = NULL,
    $transport = NULL) {
        	
        $this->CS_REST_Wrapper_Base($auth_details, $protocol, $debug_level, $host, $log, $serialiser, $transport);
        $this->set_client_id($client_id);
    }

    /**
     * Change the client id used for calls after construction
     * @param $client_id
     * @access public
     */
    function set_client_id($client_id) {
        $this->_clients_base_route = $this->_base_route.'clients/'.$client_id.'/';
    }

    /**
     * Gets a list of sent campaigns for the current client
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'WebVersionURL' => The web version url of the campaign
     *         'WebVersionTextURL' => The web version url of the text version of the campaign
     *         'CampaignID' => The id of the campaign
     *         'Subject' => The campaign subject
     *         'Name' => The name of the campaign
     *         'FromName' => The from name for the campaign
     *         'FromEmail' => The from email address for the campaign
     *         'ReplyTo' => The reply to email address for the campaign
     *         'SentDate' => The sent data of the campaign
     *         'TotalRecipients' => The number of recipients of the campaign
     *     }
     * )
     */
    function get_campaigns() {
        return $this->get_request($this->_clients_base_route.'campaigns.json');
    }

    /**
     * Gets a list of scheduled campaigns for the current client
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'CampaignID' => The id of the campaign
     *         'Name' => The name of the campaign
     *         'Subject' => The subject of the campaign
     *         'FromName' => The from name for the campaign
     *         'FromEmail' => The from email address for the campaign
     *         'ReplyTo' => The reply to email address for the campaign
     *         'DateCreated' => The date the campaign was created
     *         'PreviewURL' => The preview url of the campaign
     *         'PreviewTextURL' => The preview url of the text version of the campaign
     *         'DateScheduled' => The date the campaign is scheduled to be sent
     *         'ScheduledTimeZone' => The time zone in which the campaign is scheduled to be sent at 'DateScheduled'
     *     }
     * )
     */
    function get_scheduled() {
        return $this->get_request($this->_clients_base_route.'scheduled.json');
    }

    /**
     * Gets a list of draft campaigns for the current client
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'CampaignID' => The id of the campaign
     *         'Name' => The name of the campaign
     *         'Subject' => The subject of the campaign
     *         'FromName' => The from name for the campaign
     *         'FromEmail' => The from email address for the campaign
     *         'ReplyTo' => The reply to email address for the campaign
     *         'DateCreated' => The date the campaign was created
     *         'PreviewURL' => The preview url of the draft campaign
     *         'PreviewTextURL' => The preview url of the text version of the campaign
     *     }
     * )
     */
    function get_drafts() {
        return $this->get_request($this->_clients_base_route.'drafts.json');
    }

    /**
     * Gets all subscriber lists the current client has created
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'ListID' => The id of the list
     *         'Name' => The name of the list
     *     }
     * )
     */
    function get_lists() {
        return $this->get_request($this->_clients_base_route.'lists.json');
    }

    /**
     * Gets the lists across a client to which a subscriber with a particular
     * email address belongs.
     * @param string $email_address Subscriber's email address.
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'ListID' => The id of the list
     *         'ListName' => The name of the list
     *         'SubscriberState' => The state of the subscriber in the list
     *         'DateSubscriberAdded' => The date the subscriber was added
     *     }
     * )
     */
    function get_lists_for_email($email_address) {
        return $this->get_request($this->_clients_base_route . 
          'listsforemail.json?email='.urlencode($email_address));
    }

    /**
     * Gets all list segments the current client has created
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'ListID' => The id of the list owning this segment
     *         'SegmentID' => The id of this segment
     *         'Title' => The title of this segment
     *     }
     * )
     */
    function get_segments() {
        return $this->get_request($this->_clients_base_route.'segments.json');
    }

    /**
     * Gets all email addresses on the current client's suppression list
     * @param int $page_number The page number to get
     * @param int $page_size The number of records per page
     * @param string $order_field The field to order the record set by ('EMAIL', 'DATE')
     * @param string $order_direction The direction to order the record set ('ASC', 'DESC')
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'ResultsOrderedBy' => The field the results are ordered by
     *     'OrderDirection' => The order direction
     *     'PageNumber' => The page number for the result set
     *     'PageSize' => The page size used
     *     'RecordsOnThisPage' => The number of records returned
     *     'TotalNumberOfRecords' => The total number of records available
     *     'NumberOfPages' => The total number of pages for this collection
     *     'Results' => array(
     *         {
     *             'EmailAddress' => The suppressed email address
     *             'Date' => The date the email was suppressed
     *             'State' => The state of the suppressed email
     *         }
     *     )
     * }
     */
    function get_suppressionlist($page_number = NULL, $page_size = NULL, $order_field = NULL, 
        $order_direction = NULL) {
            
        return $this->get_request_paged($this->_clients_base_route.'suppressionlist.json', 
            $page_number, $page_size, $order_field, $order_direction, '?');
    }

    /**
     * Adds email addresses to a client's suppression list.
     * @param array<string> $emails The email addresses to suppress.
     * @access public
     */
    function suppress($emails) {
      $data = array('EmailAddresses' => $emails);
      return $this->post_request($this->_clients_base_route.'suppress.json', $data);
    }

    /**
     * Unsuppresses an email address by removing it from the the client's
     * suppression list.
     * @param string $email The email address to be unsuppressed
     * @access public
     */
    function unsuppress($email) {
      return $this->put_request($this->_clients_base_route.'unsuppress.json?email=' . urlencode($email), '');
    }

    /**
     * Gets all templates the current client has access to
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         'TemplateID' => The id of the template
     *         'Name' => The name of the template
     *         'PreviewURL' => The url to preview the template from
     *         'ScreenshotURL' => The url of the template screenshot
     *     }
     * )
     */
    function get_templates() {
        return $this->get_request($this->_clients_base_route.'templates.json');
    }

    /**
     * Gets all templates the current client has access to
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'ApiKey' => The clients API Key, THIS IS NOT THE CLIENT ID
     *     'BasicDetails' => 
     *     {
     *         'ClientID' => The id of the client
     *         'CompanyName' => The company name of the client
     *         'ContactName' => The contact name of the client
     *         'EmailAddress' => The clients contact email address
     *         'Country' => The clients country
     *         'TimeZone' => The clients timezone
     *     }
     *     'BillingDetails' =>
     *     If on monthly billing
     *     {
     *         'CurrentTier' => The current monthly tier the client sits in
     *         'CurrentMonthlyRate' => The current pricing rate the client pays per month
     *         'MarkupPercentage' => The percentage markup applied to the base rates
     *         'Currency' => The currency paid in
     *         'ClientPays' => Whether the client pays for themselves,
     *         'MonthlyScheme' => Basic or Unlimited
     *     }
     *     If paying per campaign
     *     {
     *         'CanPurchaseCredits' => Whether the client can purchase credits
     *         'Credits' => The number of credits belonging to the client
     *         'BaseDeliveryFee' => The base fee payable per campaign
     *         'BaseRatePerRecipient' => The base fee payable per campaign recipient
     *         'BaseDesignSpamTestRate' => The base fee payable per design and spam test
     *         'MarkupOnDelivery' => The markup applied per campaign
     *         'MarkupPerRecipient' => The markup applied per campaign recipient
     *         'MarkupOnDesignSpamTest' => The markup applied per design and spam test
     *         'Currency' => The currency fees are paid in
     *         'ClientPays' => Whether client client pays for themselves
     *     }     
     * }
     */
    function get() {
        return $this->get_request(trim($this->_clients_base_route, '/').'.json');
    }

    /**
     * Deletes an existing client from the system
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function delete() {
        return $this->delete_request(trim($this->_clients_base_route, '/').'.json');
    }

    /**
     * Creates a new client based on the provided information
     * @param array $client Basic information of the new client.
     *     This should be an array of the form
     *         array(
     *             'CompanyName' => The company name of the client
     *             'Country' => The clients country
     *             'TimeZone' => The clients timezone
     *         )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be the ID of the newly created client
     */
    function create($client) {
      	if(isset($client['ContactName'])) {
      		trigger_error('[DEPRECATION] Use Person->add to set name on a new person in a client. For now, we will create a default person with the name provided.', E_USER_NOTICE);
      	}
      	if(isset($client['EmailAddress'])) {
      		trigger_error('[DEPRECATION] Use Person->add to set email on a new person in a client. For now, we will create a default person with the email provided.', E_USER_NOTICE);
      	}
        return $this->post_request($this->_base_route.'clients.json', $client);
    }

    /**
     * Updates the basic information for a client
     * @param array $client_basics Basic information of the client.
     *     This should be an array of the form
     *         array(
     *             'CompanyName' => The company name of the client
     *             'Country' => The clients country
     *             'TimeZone' => The clients timezone
     *         )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function set_basics($client_basics) {
      	if(isset($client['ContactName'])) {
      		trigger_error('[DEPRECATION] Use person->update to set name on a particular person in a client. For now, we will update the default person with the name provided.', E_USER_NOTICE);
      	}
      	if(isset($client['EmailAddress'])) {
      		trigger_error('[DEPRECATION] Use person->update to set email on a particular person in a client. For now, we will update the default person with the email address provided.', E_USER_NOTICE);
      	}
        return $this->put_request($this->_clients_base_route.'setbasics.json', $client_basics);
    }

    /**
     * Updates the billing details of the current client, setting the client to the payg billing model
     * For clients not set to pay themselves then all fields below ClientPays are ignored
     * All Markup fields are optional
     * @param array $client_billing Payg billing details of the client.
     *     This should be an array of the form
     *         array(
     *             'Currency' => The currency fees are paid in
     *             'ClientPays' => Whether client client pays for themselves
     *             'MarkupPercentage' => Can be used to set the percentage markup for all unset fees
     *             'CanPurchaseCredits' => Whether the client can purchase credits
     *             'MarkupOnDelivery' => The markup applied per campaign
     *             'MarkupPerRecipient' => The markup applied per campaign recipient
     *             'MarkupOnDesignSpamTest' => The markup applied per design and spam test
     *         )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function set_payg_billing($client_billing) {
        return $this->put_request($this->_clients_base_route.'setpaygbilling.json', $client_billing);
    }

    /**
     * Updates the billing details of the current client, setting the client to the monthly billing model
     * For clients not set to pay themselves then the markup percentage field is ignored
     * @param array $client_billing Payg billing details of the client.
     *     This should be an array of the form
     *         array(
     *             'Currency' => The currency fees are paid in
     *             'ClientPays' => Whether client client pays for themselves
     *             'MarkupPercentage' => Sets the percentage markup used for all monthly tiers
     *         )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function set_monthly_billing($client_billing) {
        return $this->put_request($this->_clients_base_route.'setmonthlybilling.json', $client_billing);
    }

    /**
     * Transfer credits to or from this client.
     * 
     * @param array $transfer_data Details for the credit transfer. This array
     *   should be of the form:
     *     array(
     *      'Credits' => An in representing the number of credits to transfer.
     *        This value may be either positive if you want to allocate credits
     *        from your account to the client, or negative if you want to
     *        deduct credits from the client back into your account.
     *      'CanUseMyCreditsWhenTheyRunOut' => A boolean value which if set
     *        to true, will allow the client to continue sending using your
     *        credits or payment details once they run out of credits, and if
     *        set to false, will prevent the client from using your credits to
     *        continue sending until you allocate more credits to them.
     *     )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object
     * of the form:
     * {
     *   'AccountCredits' => Integer representing credits in your account now
     *   'ClientCredits' => Integer representing credits in this client's
     *                      account now
     * }
     */
    function transfer_credits($transfer_data) {
        return $this->post_request($this->_clients_base_route.'credits.json',
        $transfer_data);
    }

    /**
     * returns the people associated with this client.
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form 
     *     array({
     *     		'EmailAddress' => the email address of the person
     *     		'Name' => the name of the person
     *     		'AccessLevel' => the access level of the person
     *     		'Status' => the status of the person
     *     })
     */
    function get_people() {
    	return $this->get_request($this->_clients_base_route.'people.json');
    } 
    
    /**
     * retrieves the email address of the primary contact for this client
     * @return CS_REST_Wrapper_Result a successful response will be an array in the form:
     * 		array('EmailAddress'=> email address of primary contact)
     */
    function get_primary_contact() {
    	return $this->get_request($this->_clients_base_route.'primarycontact.json');
    }
    
    /**
     * assigns the primary contact for this client to the person with the specified email address
     * @param string $emailAddress the email address of the person designated to be the primary contact
     * @return CS_REST_Wrapper_Result a successful response will be an array in the form:
     * 		array('EmailAddress'=> email address of primary contact)
     */
    function set_primary_contact($emailAddress) {
    	return $this->put_request($this->_clients_base_route.'primarycontact.json?email=' . urlencode($emailAddress), '');
    }
}

/**
 * Class to access a subscribers resources from the create send API.
 * This class includes functions to add and remove subscribers ,
 * along with accessing statistics for a single subscriber
 * @author tobyb
 *
 */
class CS_REST_Subscribers extends CS_REST_Wrapper_Base {

    /**
     * The base route of the subscriber resource.
     * @var string
     * @access private
     */
    var $_subscribers_base_route;

    /**
     * Constructor.
     * @param $list_id string The list id to access (Ignored for create requests)
     * @param $auth_details array Authentication details to use for API calls.
     *        This array must take one of the following forms:
     *        If using OAuth to authenticate:
     *        array(
     *          'access_token' => 'your access token',
     *          'refresh_token' => 'your refresh token')
     *
     *        Or if using an API key:
     *        array('api_key' => 'your api key')
     * @param $protocol string The protocol to use for requests (http|https)
     * @param $debug_level int The level of debugging required CS_REST_LOG_NONE | CS_REST_LOG_ERROR | CS_REST_LOG_WARNING | CS_REST_LOG_VERBOSE
     * @param $host string The host to send API requests to. There is no need to change this
     * @param $log CS_REST_Log The logger to use. Used for dependency injection
     * @param $serialiser The serialiser to use. Used for dependency injection
     * @param $transport The transport to use. Used for dependency injection
     * @access public
     */
    function CS_REST_Subscribers (
    $list_id,
    $auth_details,
    $protocol = 'https',
    $debug_level = CS_REST_LOG_NONE,
    $host = 'api.createsend.com',
    $log = NULL,
    $serialiser = NULL,
    $transport = NULL) {
            
        $this->CS_REST_Wrapper_Base($auth_details, $protocol, $debug_level, $host, $log, $serialiser, $transport);
        $this->set_list_id($list_id);

    }

    /**
     * Change the list id used for calls after construction
     * @param $list_id
     * @access public
     */
    function set_list_id($list_id) {
        $this->_subscribers_base_route = $this->_base_route.'subscribers/'.$list_id;
    }

    /**
     * Adds a new subscriber to the specified list
     * @param array $subscriber The subscriber details to use during creation.
     *     This array should be of the form
     *     array (
     *         'EmailAddress' => The new subscribers email address
     *         'Name' => The name of the new subscriber
     *         'CustomFields' => array(
     *             array(
     *                 'Key' => The custom fields personalisation tag
     *                 'Value' => The value for this subscriber
     *             )
     *         )
     *         'Resubscribe' => Whether we should resubscribe this subscriber if they already exist in the list
     *         'RestartSubscriptionBasedAutoResponders' => Whether we should restart subscription based auto responders which are sent when the subscriber first subscribes to a list.
     *     )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function add($subscriber) {
        return $this->post_request($this->_subscribers_base_route.'.json', $subscriber);
    }

    /**
     * Updates an existing subscriber (email, name, state, or custom fields) in the specified list.
     * The update is performed even for inactive subscribers, but will return an error in the event of the
     * given email not existing in the list.
     * @param string $email The email address of the susbcriber to be updated
     * @param array $subscriber The subscriber details to use for the update. Empty parameters will remain unchanged
     *     This array should be of the form
     *     array (
     *         'EmailAddress' => The new  email address
     *         'Name' => The name of the subscriber
     *         'CustomFields' => array(
     *             array(
     *                 'Key' => The custom fields personalisation tag
     *                 'Value' => The value for this subscriber
     *                 'Clear' => true/false (pass true to remove this custom field. in the case of a [multi-option, select many] field, pass an option in the 'Value' field to clear that option or leave Value blank to remove all options)
     *             )
     *         )
     *         'Resubscribe' => Whether we should resubscribe this subscriber if they already exist in the list
     *         'RestartSubscriptionBasedAutoResponders' => Whether we should restart subscription based auto responders which are sent when the subscriber first subscribes to a list.
     *     )
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function update($email, $subscriber) {
        return $this->put_request($this->_subscribers_base_route.'.json?email='.urlencode($email), $subscriber);
    }

    /**
     * Imports an array of subscribers into the current list
     * @param array $subscribers An array of subscribers to import.
     *     This array should be of the form
     *     array (
     *         array (
     *             'EmailAddress' => The new subscribers email address
     *             'Name' => The name of the new subscriber
     *             'CustomFields' => array(
     *                 array(
     *                     'Key' => The custom fields personalisation tag
     *                     'Value' => The value for this subscriber
     *                     'Clear' => true/false (pass true to remove this custom field. in the case of a [multi-option, select many] field, pass an option in the 'Value' field to clear that option or leave Value blank to remove all options)
     *                 )
     *             )
     *         )
     *     )
     * @param $resubscribe Whether we should resubscribe any existing subscribers
     * @param $queueSubscriptionBasedAutoResponders By default, subscription based auto responders do not trigger during an import. Pass a value of true to override this behaviour
     * @param $restartSubscriptionBasedAutoResponders By default, subscription based auto responders will not be restarted
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'TotalUniqueEmailsSubmitted' => The number of unique emails submitted in the call
     *     'TotalExistingSubscribers' => The number of subscribers who already existed in the list
     *     'TotalNewSubscribers' => The number of new subscriptions to the list
     *     'DuplicateEmailsInSubmission' => array<string> The emails which appeared more than once in the batch
     *     'FailureDetails' => array (
     *         {
     *             'EmailAddress' => The email address which failed
     *             'Code' => The Create Send API Error code
     *             'Message' => The reason for the failure
     *         }
     *     )
     * }
     *
     */
    function import($subscribers, $resubscribe, $queueSubscriptionBasedAutoResponders = false, $restartSubscriptionBasedAutoResponders = false) {
        $subscribers = array(
            'Resubscribe' => $resubscribe,
            'QueueSubscriptionBasedAutoResponders' => $queueSubscriptionBasedAutoResponders,
            'Subscribers' => $subscribers,
            'RestartSubscriptionBasedAutoresponders' => $restartSubscriptionBasedAutoResponders
        );
        
        return $this->post_request($this->_subscribers_base_route.'/import.json', $subscribers);
    }

    /**
     * Gets a subscriber details, including custom fields
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * {
     *     'EmailAddress' => The subscriber email address
     *     'Name' => The subscribers name
     *     'Date' => The date the subscriber was added to the list
     *     'State' => The current state of the subscriber
     *     'CustomFields' => array(
     *         {
     *             'Key' => The custom fields personalisation tag
     *             'Value' => The custom field value for this subscriber
     *         }
     *     )
     * }
     */
    function get($email) {
        return $this->get_request($this->_subscribers_base_route.'.json?email='.urlencode($email));
    }

    /**
     * Gets the sending history to a specific subscriber
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be an object of the form
     * array(
     *     {
     *         ID => The id of the email which was sent
     *         Type => 'Campaign'
     *         Name => The name of the email
     *         Actions => array(
     *             {
     *                 Event => The type of action (Click, Open, Unsubscribe etc)
     *                 Date => The date the event occurred
     *                 IPAddress => The IP that the event originated from
     *                 Detail => Any available details about the event i.e the URL for clicks
     *             }
     *         )
     *     }
     * )
     */
    function get_history($email) {
        return $this->get_request($this->_subscribers_base_route.'/history.json?email='.urlencode($email));
    }

    /**
     * Unsubscribes the given subscriber from the current list
     * @param string $email The email address to unsubscribe
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function unsubscribe($email) {
        // We need to build the subscriber data structure.
        $email = array(
            'EmailAddress' => $email 
        );
        
        return $this->post_request($this->_subscribers_base_route.'/unsubscribe.json', $email);
    }

    /**
     * deletes the given subscriber from the current list
     * @param string $email The email address to delete
     * @access public
     * @return CS_REST_Wrapper_Result A successful response will be empty
     */
    function delete($email) {
        return $this->delete_request($this->_subscribers_base_route.'.json?email='.urlencode($email));
    }
}