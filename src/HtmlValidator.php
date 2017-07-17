<?php
/**
 * Created by PhpStorm.
 * User: jens.reichert
 * Date: 17.07.2017
 * Time: 19:46
 */

namespace Validator;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class HtmlValidator
{
    const VALIDATOR_API = 'http://html5.validator.nu/';
    const OUTPUT_FORMAT = 'json';

    protected $client;
    protected $validationResult;

    private $html;

    public function __construct($html)
    {
        $this->html = $html;
        $this->client = new Client;
        $this->validate();
    }

    public function isValid()
    {
        return empty($this->validationResult->messages);
    }

    public function isNotValid()
    {
        return ! $this->isValid();
    }

    protected function validate()
    {
        try{
            $response = $this->callValidator();
            $this->validationResult = $this->fetchJsonResult($response);
        }catch (ClientException $e){
            die(var_dump($e->getMessage()));
        }
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function callValidator()
    {
        return $this->client->post(static::VALIDATOR_API.'?out='.static::OUTPUT_FORMAT, [
            'headers' => [
                'Content-type' => 'text/html',
            ],
            'body' =>  $this->html,
        ]);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \stdClass
     */
    protected function fetchJsonResult($response)
    {
        return json_decode($response->getBody()->getContents());
    }
}