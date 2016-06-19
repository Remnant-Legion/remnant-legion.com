<div class="row membership">
    <div class="col-md-12">
        <h2 class="text-center">Join Today</h2>
        <p class="text-sm">In order to apply you must validate your EVE account and fill out a small questionnaire.  A Recruiter will then get in touch with you provided you pass our initial screening.</p>
        <p><strong>Before joining </strong>- to make sure we are interested in the same things - please review our requirements below</p>
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li>5 million Skill Points</li>
                    <li>Enjoys Wormhole life and PVP</li>
                    <li>Self starter</li>
                    <li>Non-Criminal History</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul>
                    <li>Team Player</li>
                    <li>Mature Attitude</li>
                    <li>Eager to Learn and help others</li>
                </ul>
            </div>
            <div class="col-xs-12">
                <p>To proceed with your application login via eve SSO below</p>
                <a href="">
                    <img class="center-block" src="<?= get_stylesheet_directory_uri();?>/dist/images/EVE_SSO_Login_Buttons_Large_Black.png"/>
                </a> 
                <p class="small">To learn more about SSO please <a href="">click here</a></p>
            </div>
        </div>
    </div>
</div>
<?php
/**
* @Route("/redirect_sso", name="redirect_sso")
*/
/**
public function redirectAction(Request $request)
{
$ssoUrl = 'https://login.eveonline.com/oauth/authorize/';

$gen = new SecureRandom();
$nonce = md5($gen->nextBytes(10));

$session = $this->get('session');

$session->set('eve_sso_nonce', $nonce);

$params = [
'response_type' => 'code',
'redirect_uri' => $this->generateUrl('sso_callback', [], true),
'scope' => '',
'client_id' => $this->container->getParameter('eve_client_id'),
'state' => $nonce,
];

$pieces = [];
foreach ($params as $k => $v) {
$pieces[] = "$k=$v";
}

$fullUrl = $ssoUrl.'?'.implode('&', $pieces);

return $this->redirect($fullUrl);
}

/**
* @Route("/sso_callback", name="sso_callback")
*/
/**
public function callbackAction(Request $request)
{
$state = $request->query->get('state', null);
$code = $request->query->get('code', null);

$session = $this->get('session');
$nonce = $session->get('eve_sso_nonce');
$session->remove('eve_sso_nonce');

if (!StringUtils::equals($nonce, $state)) {
$session->getFlashBag()->add('danger', 'Invalid CSRF Token - Refresh the page.');

return $this->redirect($this->generateUrl('default'));
}

$auth_uri = 'https://login.eveonline.com/oauth/token';

$creds = [
trim($this->container->getParameter('eve_client_id')),
trim($this->container->getParameter('eve_client_secret')),
];

/*
* LOOK OUT FOR THE SPACE
*/
/**
$auth_request = new \GuzzleHttp\Psr7\Request('POST', $auth_uri, [
'Content-Type' => 'application/x-www-form-urlencoded',
'Authorization' => 'Basic '.base64_encode(implode(':', $creds)),
], "grant_type=authorization_code&code=$code");

try {
$response = $this->tryRequest($auth_request);
} catch (\Exception $e) {
$session->getFlashBag()->add('danger', 'There was a problem with your request<i>Try Again - if this persists - Submit an issue ticket using the link in the footer.</i></b>');

return $this->redirect($this->generateUrl('eve.register'));
}

$response_content = json_decode($response->getBody()->getContents());
$token = $response_content->access_token;

$verify_uri = 'https://login.eveonline.com/oauth/verify';

$verfiyRequest = new \GuzzleHttp\Psr7\Request('GET', $verify_uri, [
'Authorization' => 'Bearer '.$token,
]);

try {
$charResponse = $this->tryRequest($verfiyRequest);
} catch (\Exception $e) {
$session->getFlashBag()->add('danger', 'There was a problem with your request<i>Try Again - if this persists - Submit an issue ticket using the link in the footer.</i></b>');

return $this->redirect($this->generateUrl('eve.register'));
}

$decoded = json_decode($charResponse->getBody()->getContents());

$cId = $decoded->CharacterID;
$cName = $decoded->CharacterName;

$exists = $this->getDoctrine()->getRepository('AppBundle:CorporationMember')->findOneBy(['character_id' => intval($cId)]);

// character isnt in a corp that is registered by an admin
if ($exists === null) {
$session->getFlashBag()->add('warning', 'Sorry we do not support non-alpha tester registrations at this time.<br><b>COME BACK SOON</b> or make a request to add your corporation through a support ticket below.');

$this->get('logger')->info(sprintf('ATTEMPTED REGISTRATION: char_id = %s char_name = %s', $cId, $cName));

return $this->redirect($this->generateUrl('eve.register'));
} else {
$user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['username' => strtolower(str_replace(' ', '_', trim($exists->getCharacterName())))]);

if ($user instanceof User) {
$session->getFlashBag()->add('warning', 'This character is already associated with a user. IF you have forgot your username or password please see the link below');

return $this->redirect($this->generateUrl('eve.register'));
}
// all is well
$session->set('registration_authorized', ['id' => $cId, 'name' => $cName]);

return $this->redirect($this->generateUrl('fos_user_registration_register'));
}
}g: 1vh;
 */
?>