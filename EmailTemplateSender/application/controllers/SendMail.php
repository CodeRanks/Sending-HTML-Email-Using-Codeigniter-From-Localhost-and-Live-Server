<?php
class SendMail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
    }

    public function Send()
    {
        //Reading Contents of the template file
        $html_mail =  file_get_contents(base_url()."assets/templates/contact-us.html");
        
        //Replacing Data with Keys
        $data = array(
            "name" => "John Smith",
            "email" => "abc@gmail.com",
            "subject" => "Contacting with Coderanks.com",
            "message" => "Hey There."
        );

        $placeholders = array(
            "%NAME%",
            "%EMAIL%",
            "%SUBJECT%",
            "%MESSAGE%"
        );
        $final_mail = str_replace($placeholders, $data, $html_mail);

         //Sending email from localhost or live server
        $localhosts = array(
            '::1',
            '127.0.0.1',
            'localhost'
        );
        
        $protocol = 'mail';
        if (in_array($_SERVER['REMOTE_ADDR'], $localhosts)) {
            $protocol = 'smtp';
        }

        $config = array(
            'protocol' => $protocol,
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'bytelinx.info@gmail.com',
            'smtp_pass' => 'byte12345@@',
            'mailtype' => 'html',
            'starttls'  => true,
            'newline'   => "\r\n",
        );

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from("contact@coderanks.com");
        $this->email->to("coderanks@gmail.com");
        $this->email->subject("New user contacts");
        $this->email->message($final_mail);
        $flag = $this->email->send();

        if($flag){
            echo "Email sent";
        }else{
            echo "Email sending failed";
        }
    }
}
