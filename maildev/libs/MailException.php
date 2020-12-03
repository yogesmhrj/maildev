<?php

/**
 * Created by yogesh on 06 02, 2018.
 * @website https://yogeshmaharjan.com.np
 *
 */
class MailException extends Exception
{

    /**
     * MailException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = "MailException : ".$message;
    }
    
    
}