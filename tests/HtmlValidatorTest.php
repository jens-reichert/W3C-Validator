<?php

use Validator\HtmlValidator;

class HtmlValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_validates_a_valid_html_source()
    {
/*        $validHtml = file_get_contents(dirname(__FILE__).'/Mocks/Valid.html');
        $validator = new HtmlValidator($validHtml);

        $this->assertTrue($validator->isValid());
        $this->assertFalse($validator->isNotValid());*/
    }

    /**
     * @test
     */
    public function it_validates_an_invalid_html_source()
    {
        $validHtml = file_get_contents(dirname(__FILE__).'/Mocks/InValid.html');
        $validator = new HtmlValidator($validHtml);

        $this->assertTrue($validator->isNotValid());
        $this->assertFalse($validator->isValid());
    }
}
