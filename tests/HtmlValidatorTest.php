<?php

use Validator\HtmlValidationIssue;
use Validator\HtmlValidator;

class HtmlValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Validator\HtmlValidator
     */
    protected function getInvalidValidator()
    {
        $html = file_get_contents(dirname(__FILE__) . '/Mocks/InValid.html');
        $validator = new HtmlValidator($html);
        return $validator;
    }

    /**
     * @test
     */
    public function it_validates_a_valid_html_source()
    {
        $html = file_get_contents(dirname(__FILE__).'/Mocks/Valid.html');
        $validator = new HtmlValidator($html);

        $this->assertTrue($validator->isValid());
        $this->assertFalse($validator->isNotValid());
    }

    /**
     * @test
     */
    public function it_validates_an_invalid_html_source()
    {
        $validator = $this->getInvalidValidator();

        $this->assertTrue($validator->isNotValid());
        $this->assertFalse($validator->isValid());
    }

    /**
     * @test
     */
    public function it_gets_the_number_of_errors_in_an_invalid_html_document()
    {
        $validator = $this->getInvalidValidator();

        $this->assertTrue($validator->hasErrors());
        $this->assertEquals(5, $validator->countErrors());
    }

    /**
     * @test
     */
    public function it_returns_errors_as_validation_issue_object()
    {
        $validator = $this->getInvalidValidator();

        foreach ($validator->getErrors() as $error) {
            $this->assertInstanceOf(HtmlValidationIssue::class, $error);
        }
    }

    /**
     * @test
     */
    public function it_fetches_the_first_occured_error()
    {
        $validator = $this->getInvalidValidator();

        $this->assertInstanceOf(HtmlValidationIssue::class, $validator->firstError());
    }

}
