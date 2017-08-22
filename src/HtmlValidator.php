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

    /* @var \GuzzleHttp\Client $client */
    protected $client;

    /* @var \stdClass $validationResult */
    protected $validationResult;

    /* @var string $html */
    private $html;

    /**
     * HtmlValidator constructor.
     *
     * @param \GuzzleHttp\Client $client
     * @param                    $html
     */
    public function __construct(Client $client, $html)
    {
        $this->html = $html;
        $this->client = $client;
        $this->validate();
    }

    /**
     * Check if the HTML Markup passed the Validator
     *
     * @return bool
     */
    public function isValid()
    {
        return empty($this->validationMessages());
    }

    /**
     * Check if the HTML Markup has not passed the Validator
     *
     * @return bool
     */
    public function isNotValid()
    {
        return ! $this->isValid();
    }

    /**
     *  Validate the HTML Markup
     */
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
     * Make a request to the Validator to validate the HTML Markup
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function callValidator()
    {
        return $this->client->post(static::VALIDATOR_API.'?out='.static::OUTPUT_FORMAT, [
            'multipart' => [
                [
                    'name' => 'out',
                    'contents' => static::OUTPUT_FORMAT,
                ],
                [
                    'name' => 'content',
                    'contents' => $this->html,
                ],
            ],
        ]);
    }

    /**
     * Parse the Validation Result
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \stdClass
     */
    protected function fetchJsonResult($response)
    {
        return json_decode(
            $response->getBody()->getContents()
        );
    }

    /**
     * Get the Validation Result
     *
     * @return mixed
     */
    public function getValidationResult()
    {
        return $this->validationResult;
    }

    /**
     * Count the Errors of the HTML Markup
     *
     * @return int
     */
    public function countErrors()
    {
        return count($this->validationMessages());
    }

    /**
     * Check if the HTML Markup has Errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !! $this->countErrors();
    }

    /**
     * Get the Errors of the HTML Markup
     *
     * @return array
     */
    public function getErrors()
    {
        return array_map(function ($error){
            return new HtmlValidationIssue($error);
        }, $this->validationMessages());
    }

    /**
     * Get the first Error of the HTML Markup
     *
     * @return \Validator\HtmlValidationIssue
     */
    public function firstError()
    {
        return new HtmlValidationIssue(
            $this->getValidationResult()->messages[0]
        );
    }

    /**
     * Get the Messages the Validator has returned
     *
     * @return mixed
     */
    protected function validationMessages()
    {
        return $this->getValidationResult()->messages;
    }
}