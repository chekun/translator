<?php namespace Chekun\Translator\MicroSoft;

use Buzz\Browser;
use Buzz\Client\Curl;

class Translator {

    const AUTH_URL = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/';
    const SCOPE_URL = 'http://api.microsofttranslator.com';
    const GRANT_TYPE = 'client_credentials';
    const TRANSLATE_URL = 'http://api.microsofttranslator.com/v2/Http.svc/Translate?';

    private $clientId = '';
    private $clientSecret = '';
    private $authHeader = '';

    public function __construct($id, $secret)
    {
        $this->clientId = $id;
        $this->clientSecret = $secret;
        $this->authHeader = "Authorization: Bearer ". $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $params = array(
            'grant_type' => static::GRANT_TYPE,
            'scope' => static::SCOPE_URL,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        );

        $request = new Browser(new Curl());
        $response = $request->post(static::AUTH_URL, array(), http_build_query($params));
        $result = json_decode($response->getContent());
        if (isset($result->error) and $result->error){
            throw new \Exception($result->error_description);
        }
        return $result->access_token;
    }

    public function translate($text = '', $to = '', $from = '', $contentType = 'text/plain')
    {
        $headers = array(
            $this->authHeader,
            "Content-Type: text/xml"
        );
        $params = http_build_query(compact('text', 'to', 'from', 'contentType'));
        $request = new Browser(new Curl());
        $response = $request->get(static::TRANSLATE_URL . $params, $headers);
        return strip_tags($response->getContent());
    }


}