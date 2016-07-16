<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\RedirectResponse;

class SSOService
{
    const BASE_URI = 'https://login.eveonline.com/oauth/',
        AUTH_URI = self::BASE_URI.'authorize',
        TOKEN_URI = self::BASE_URI.'token',
        VERIFY_URI = self::BASE_URI.'verify';
    
    private $client_id;
    private $client_secret;
    private $callback_uri;
    
    public function __construct(){
        $this->client_id = getenv('EVE_CLIENT_ID');
        $this->client_secret = getenv('EVE_SECRET');
        $this->callback_uri = getenv('EVE_CALLBACK_URI');
    }

    public function redirectAction()
    {
        return new RedirectResponse(join('',[self::AUTH_URI,'?',http_build_query([
            'response_type' => 'code',
            'redirect_uri' => $this->callback_uri,
            'scope' => '',
            'client_id' => $this->client_id
        ])]));
    }

    public function callbackAction(Request $request)
    {
        $code = $request->query->get('code', null);
        $auth_request = $this->buildAuthRequest($code);

        $response = $this->tryRequest($auth_request);
        return $this->verifySSOResponse($response);
    }

    protected function verifySSOResponse(Response $response){
        $response_content = json_decode($response->getBody()->getContents());
        $token = $response_content->access_token;

        $verfiyRequest = new \GuzzleHttp\Psr7\Request('GET', self::VERIFY_URI, [
            'Authorization' => 'Bearer '.$token,
        ]);

        $charResponse = $this->tryRequest($verfiyRequest);
        return json_decode($charResponse->getBody()->getContents());
    }

    protected function buildAuthRequest($code) {
        $credentials = [
            trim($this->client_id),
            trim($this->client_secret),
        ];

        return  new \GuzzleHttp\Psr7\Request('POST', self::TOKEN_URI, [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic '.base64_encode(implode(':', $credentials)),
        ], "grant_type=authorization_code&code=$code");
    }

    protected function tryRequest(\GuzzleHttp\Psr7\Request $request)
    {
        $client = new Client();
        $response = $client->send($request, ['timeout' => 2]);
        return $response;
    }
}