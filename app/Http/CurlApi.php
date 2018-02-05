<?php
namespace App\Http;

class CurlApi
{
    /** @var resource cURL handle */
    private $ch;

    private $time;

    /** @var mixed The response */
    public $response = false;

    /**
     * @param string $url
     * @param array  $options
     */
    public function __construct($url, $type, $options)
    {

        $this->time = microtime(true);

        debug("=====================================>>> EXECUTANDO CURL <<<======================================");
        debug($url);

        $this->ch = curl_init();

        curl_setopt_array($this->ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
        ));

        if ($type == 'POST')
        {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $options);
        }

        $this->getResponse();
    }

    /**
     * Get the response
     * @return string
     * @throws \RuntimeException On cURL error
     */
    public function getResponse()
    {
         if ($this->response) {
             return $this->response;
         }

        $response = curl_exec($this->ch);
        debug(['debug curl response'=>$response]);

        $error    = curl_error($this->ch);
        debug(['debug curl error'=>$error]);
        
        $errno    = curl_errno($this->ch);
        debug(['debug curl errno'=>$errno]);

        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }

        if (0 !== $errno) {

            debug("==========>>> CURL EXECUTADO COM ERRO: ".round((microtime(true) - $this->time) * 1000) . " ms <<<==========");

            debug(['debug error'=>$error]);
            debug(['debug errno'=>$errno]);

            throw new \RuntimeException($error, $errno);
        }

        debug("==========>>> CURL EXECUTADO COM SUCESSO: ".round((microtime(true) - $this->time) * 1000) . " ms <<<==========");

        return $this->response = $response;
    }

    /**
     * Let echo out the response
     * @return string
     */
    // public function __toString()
    // {
    //     return $this->getResponse();
    // }
}