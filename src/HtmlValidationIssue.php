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

    /**
     * HtmlValidationIssue constructor.
     *
     * @param $error
     */
    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * Get the Error
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get the type of the Error
     *
     * @return mixed
     */
    public function type()
    {
        return $this->error->type;
    }

    /**
     * Get the Line where the Error was found
     *
     * @return mixed
     */
    public function line()
    {
        return $this->error->lastLine;
    }

    /**
     * Get teh Column where the Error was found
     *
     * @return mixed
     */
    public function column()
    {
        return $this->error->lastColumn;
    }

    /**
     * Get the Error Message
     *
     * @return mixed
     */
    public function message()
    {
        return $this->error->message;
    }

    /**
     * Get the Code Fragment of the Error
     *
     * @return mixed
     */
    public function code()
    {
        return $this->error->extract;
    }
}