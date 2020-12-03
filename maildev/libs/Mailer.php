<?php
/**
 * Created by yogesh on 05 02, 2018.
 * @website https://yogeshmaharjan.com.np
 * 
 * Bridge class between the PHPMailer class and out business logic class.
 * 
 * The class acts as an layer above the PHPMailer class to simplify the mail process in our system.
 * 
 * The mailer defaults can be altered for further simplification.
 */
include_once(__DIR__."/../config/mail.php");
include_once(__DIR__.'/../mailerclass/class.phpmailer.php');
require __DIR__."/MailException.php";

class Mailer
{
    /*
     *----------------------------------------------------------------------------------------------------------------------
     * The mailer driver defaults.
     *----------------------------------------------------------------------------------------------------------------------
     */
    private $MAIL_CONFIG = [];

    /*
     *----------------------------------------------------------------------------------------------------------------------
     * The mailer content defaults.
     *----------------------------------------------------------------------------------------------------------------------
     */
    private $emailContent = "";

    private $subject  = "Undefined Subject";

    private $attachment = null;

    private $replyTo = array();

     /*
     * Non Null variables
     */
    private $addressArray = array();

    private $debug = false;

    private $mail;

    private $mailError = "";

    /**
     * Mailer constructor.
     */
    public function __construct()
    
{        $this->mail = new PHPMailer();

        //$this->mail->SMTPDebug = true;

        //initialize the mail setup
        if(defined('MAIL_ENV')){
            if(MAIL_ENV == 'PRO'){
                global $mailConfigs;
                $this->MAIL_CONFIG = $mailConfigs['PRO'];
            }else{
                global $mailConfigs;
                $this->MAIL_CONFIG = $mailConfigs['DEV'];
            }
        }else{
            global $mailConfigs;
            $this->MAIL_CONFIG = $mailConfigs['DEV'];
        }

        if(strtolower($this->MAIL_CONFIG['MAIL_DRIVER']) == 'smtp'){
            $this->mail->IsSMTP();
            $this->mail->SMTPSecure = ($this->MAIL_CONFIG['MAIL_ENCRYPTION'] == 'null')?"":$this->MAIL_CONFIG['MAIL_ENCRYPTION'];
        }

        $this->mail->Port = $this->MAIL_CONFIG['MAIL_PORT'];
        $this->mail->Host = $this->MAIL_CONFIG['MAIL_HOST'];
        $this->mail->Username = $this->MAIL_CONFIG['MAIL_USERNAME'];
        $this->mail->Password = $this->MAIL_CONFIG['MAIL_PASSWORD'];
        $this->mail->From = $this->MAIL_CONFIG['MAIL_FROM_ADDRESS'];
        $this->mail->FromName = $this->MAIL_CONFIG['MAIL_FROM_NAME'];

    }

    /**
     * @return string
     */
    public function getEmailContent()
    {
        return $this->emailContent;
    }

    /**
     * @param string $emailContent
     * @return $this
     */
    public function setEmailContent($emailContent)
    {
        $this->emailContent = $emailContent;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return Mailer
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return null
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param null $attachment
     * @return Mailer
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     * @return Mailer
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @return array
     */
    public function getAddressArray()
    {
        return $this->addressArray;
    }

    public function addAddress($email, $name){
        $this->addressArray[] = [   
            'email' => $email,
            'name' => $name
        ];
    }

    /**
     * @param array $addressArray
     * @return Mailer
     */
    public function setAddressArray($addressArray)
    {
        $this->addressArray = $addressArray;
        return $this;
    }

    /**
     * @return array
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param array $replyTo
     * @return Mailer
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * @return string
     */
    public function getMailError()
    {
        return $this->mailError;
    }

    public function enableDebug($enable = false){
        $this->mail->SMTPDebug = $enable;
        $this->debug = $enable;
    }
    
    /**
     * Sends the mail.
     * 
     * @return bool
     */
    public function send(){
        $result = false;
        try {

            if($this->debug){
                echo "<br/>----------------------------<br/>";
                echo "SMTP Parameters in use : <br>";
                print_r($this->MAIL_CONFIG);
                echo "<br/>----------------------------<br/>";
            }
        
            /*
             * Set the reply candidate, subject, content and the address for the mail
             */
            if (count($this->replyTo) > 0) {
                $this->mail->AddReplyTo($this->replyTo['email'], $this->replyTo['name']);
            }

            $this->mail->Subject = $this->subject;
            $this->mail->MsgHTML($this->emailContent);
            
            if(count($this->addressArray) < 1){
                throw new MailException("Recipient address not provided. At least one address is required.");
            }
        
            foreach ($this->addressArray as $key => $address) {
                if(is_array($address)){
                    if(array_key_exists("email",$address) && array_key_exists("name",$address)){
                        $this->mail->AddAddress($address['email'], $address['name']);  
                    }else{
                        throw new MailException("Recipient address key value mismatch. ".
                            "Please refer to documentations regarding adding the address array.");
                    }
                }else{
                    throw new MailException("Recipient address key value mismatch. ".
                            "Please refer to documentations regarding adding the address array.");
                }
            }
            /*
             * The attachments
             */
            if ($this->attachment != null) {
                $this->mail->AddAttachment($this->attachment);
            }

            /*
             * Send the mail
             */
            $result = $this->mail->Send();

            /*
             * Record the error information
             */
            $this->mailError = $this->mail->ErrorInfo;

            /*
             * Clear the mail
             */
            $this->mail->ClearAddresses();
            $this->mail->ClearReplyTos();
            $this->mail->ClearAttachments();
            $this->mail->ClearAllRecipients();

        }catch (Exception $e){
            $this->mailError = "Error In Mail > ".$e->getMessage();
        }
        return $result;
    }


}