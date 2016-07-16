<?php
require('../vendor/autoload.php');
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Dotenv\Dotenv;

$config = new Dotenv(__DIR__.'/..');
$config->load();

require(__DIR__.'/eve/SSOService.php');

$request = Request::createFromGlobals();
$sso = new SSOService();

if ($request->query->get('code')){
    
    try {
        $characterData = $sso->callbackAction($request);
        echo require(__DIR__.'/../memberForm.php');
    } catch (\Exception $e){
        $response = new RedirectResponse('/');
        $response->send();
    }
}

if ($request->query->get('auth')){
    $sso->redirectAction()->send();
}

