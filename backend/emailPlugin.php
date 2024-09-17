<?php
    /*
        Notes on where to insert this method so far:
        Form Accepted
        Message Received
        Form Completed
        *Account Created
        User Prompted for Response
        On Approval per step

        Emails that result from the messaging system will be labeled
            from CRC@cs.newpaltz.edu still, but will contain message details
         */


    /*
     * Sending email from the cs server (Email recipient, email subject line, email content)
     * Will print to console success or failure
     * Email content is in HTML, provide html formatted text to "$content"
     */
    function sendMail($recipient, $subjectLine, $content){

        $email_to = $recipient; //intake user to email here

        $subject = $subjectLine; //email subject, changes dpeending

        $message = $content; //written message of email

        $headers = "From: Nexus Workflow System <noreply@cs.newpaltz.edu>\r\n"; //"From header", needs to have a capital "F"
        $headers .= "MIME-Version: 1.0\r\n"; //mime version, RFC 822 compliant email header version. This is required
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; //also a required piece, defines character set to be used in email?
        
        
/*         if(mail($email_to, $subject, $message, $headers)) //if email sent successfully, mail() returns true value
            echo ('successfully sent email');
        else
            echo ('failure to send email'); */
    }


?>


