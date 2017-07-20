<?php
/**
 * Created by PhpStorm.
 * User: Jens.Reichert
 * Date: 20.07.2017
 * Time: 16:30
 */

namespace Validator;


class HtmlValidationIssue
{
    private $error;

    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function type()
    {
        return $this->error->type;
    }

    public function line()
    {
        return $this->error->lastLine;
    }

    public function column()
    {
        return $this->error->lastColumn;
    }

    public function message()
    {
        return $this->error->message;
    }

    public function code()
    {
        return $this->error->extract;
    }
}