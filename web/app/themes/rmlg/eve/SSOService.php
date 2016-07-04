<?php

class SSOService {

    const BASE_URI = 'https://login.eveonline.com/oauth';
    const AUTH_URI = self::BASE_URI.'/authorize';
    const CALLBACK_URI = self::BASE_URI.'/verify';

    public function redirectAction(Request $request) {
        $fullUrl = self::AUTH_URI.'?'.http_build_query([
            'response_type' => 'code',
            'redirect_uri' => $this->generateUrl('sso_callback', [], true),
            'scope' => '',
            'client_id' => $this->container->getParameter('eve_client_id')
        ]);

        return $this->redirect($fullUrl);
    }

    public function callbackAction(Request $request) {
        $code = $request->query->get('code', null);

        $auth_uri = 'https://login.eveonline.com/oauth/token';

        $creds = [
            trim($this->container->getParameter('eve_client_id')),
            trim($this->container->getParameter('eve_client_secret')),
        ];

        $auth_request = new \GuzzleHttp\Psr7\Request('POST', $auth_uri, [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . base64_encode(implode(':', $creds)),
        ], "grant_type=authorization_code&code=$code");

        try {
            $response = $this->tryRequest($auth_request);
        } catch (\Exception $e) {
            return $this->redirect($this->generateUrl('eve.register'));
        }

        $response_content = json_decode($response->getBody()->getContents());
        $token = $response_content->access_token;

        $verify_uri = 'https://login.eveonline.com/oauth/verify';

        $verfiyRequest = new \GuzzleHttp\Psr7\Request('GET', $verify_uri, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        try {
            $charResponse = $this->tryRequest($verfiyRequest);
        } catch (\Exception $e) {
            return $this->redirect($this->generateUrl('eve.register'));
        }

        $decoded = json_decode($charResponse->getBody()->getContents());

        return $this->redirect($this->generateUrl('fos_user_registration_register'));
    }
}