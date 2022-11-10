<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Emails
 */
require_once("ControllerApiBase.php");
class ControllerApiEmail extends ControllerApiBase {
    
    public function testemail(Request $request, Response $response, array $args) {
        
        $responseEmail = $this->sendEmail("gelvazio@gmail.com", "gelvazio@t2.dev.br");
        
        return $response->withJson($responseEmail, 200);
    }
    
    private function sendEmail($from, $to) {
        // require './vendor/autoload.php'; // If you're using Composer (recommended)
        
        // Comment out the above line if not using Composer
        // require("<PATH TO>/sendgrid-php.php");
        // If not using Composer, uncomment the above line and
        // download sendgrid-php.zip from the latest release here,
        // replacing <PATH TO> with the path to the sendgrid-php.php file,
        // which is included in the download:
        // https://github.com/sendgrid/sendgrid-php/releases
    
        $email = new \SendGrid\Mail\Mail();
        
        $email->setFrom($from, "Example User - Gelvazio");
        $email->setSubject("Sending with SendGrid is Fun - Gelvazio");
        $email->addTo($to, "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP - Gelvazio</strong>"
        );
    
        $SENDGRID_API_KEY = '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';
        
        // $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $sendgrid = new \SendGrid($SENDGRID_API_KEY);
        
        try {
            $response = $sendgrid->send($email);
            
            $aDadosRetorno = array(
                "statusCode" => $response->statusCode(),
                "headers" => $response->headers(),
                "body" => $response->body()
            );
            
            return $aDadosRetorno;
            
        } catch (Exception $e) {
            return array('status' => false, 'message' => 'Caught exception: '. $e->getMessage());
        }
    }
}
