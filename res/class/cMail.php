<?php
require_once(RES .'lib/PHPMailer/PHPMailerAutoload.php');
class cMail {
    public $email;
    public $success;    
    
    function __construct(){    
        //config files
        $databases = Config::read('mailing');
        $config = $databases[ENV];          
        
        $this->email = new PHPMailer;
        $this->email->isSMTP();                                      // Set mailer to use SMTP
        $this->email->Host = $config['host'];                       // Specify main and backup server
        $this->email->SMTPAuth = true;                               // Enable SMTP authentication
        $this->email->Username = $config['user'];              // SMTP username
        $this->email->Password = $config['pass'];                         // SMTP password
        $this->email->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
        $this->email->Port = $config['port'];                                    //Set the SMTP port number - 587 for authenticated TLS
        $this->email->setFrom($config['user'], $config['name']);     //Set who the message is to be sent from
        $this->email->addReplyTo($config['user'], $config['name']);  //Set an alternative reply-to address
        $this->email->WordWrap = 50;                                 // Set word wrap to 50 characters     
        $this->email->isHTML(true);   // Set email format to HTML  
        $this->email->CharSet = 'UTF-8'; 
        if(isEmail($config['cc'])){
            $this->email->addCC($config['cc']);
        }
        if(isEmail($config['bcc'])){
            $this->email->addBCC($config['bcc']);
        }        
    }
    function enviaTxt($to,$subject,$body)
    {
        $tos = explode(",",$to );
        foreach ($tos as $adr){
            $this->email->addAddress($adr);               
        }               
        $this->email->Subject = utf8_encode("=?UTF-8?B?" . base64_encode($subject) .  "?="); //$subject;
        $this->email->Body    = $body;   
        return $this->email->send();
    }   
}
