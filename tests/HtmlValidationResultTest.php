<?php

use GuzzleHttp\Client;
use Validator\HtmlValidationIssue;
use Validator\HtmlValidator;

class HtmlValidationResultTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Validator\HtmlValidator
     */
    protected function getInvalidValidator()
    {
        $html = file_get_contents(dirname(__FILE__) . '/Mocks/InValid.html');
        $validator = new HtmlValidator(new Client, $html);
        return $validator;
    }

    /**
     * @test
     */
    public function it_gets_the_type_of_an_error()
    {
        $this->assertEquals(
            'error',
            $this->getInvalidValidator()->firstError()->type()
        );
    }

    /**
     * @test
     */
    public function it_gets_the_line_where_the_error_accured()
    {
        $this->assertEquals(
            1,
            $this->getInvalidValidator()->firstError()->line()
        );
    }

    /**
     * @test
     */
    public function it_gets_the_column_where_the_error_accured()
    {
        $this->assertEquals(
            6,
            $this->getInvalidValidator()->firstError()->column()
        );
    }

    /**
     * @test
     */
    public function it_gets_the_message_of_the_error()
    {
        $this->assertEquals(
            'Start tag seen without seeing a doctype first. Expected “<!DOCTYPE html>”.',
            $this->getInvalidValidator()->firstError()->message()
        );
    }

    /**
     * @test
     */
    public function it_gets_the_code_that_created_the_error()
    {
        $this->assertEquals(
            serialize("<html>\n    <"),
            serialize($this->getInvalidValidator()->firstError()->code())
        );
    }

}
