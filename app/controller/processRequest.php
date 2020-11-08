<?php
namespace App\Controller;

use Pheanstalk\Pheanstalk;

class ProcessRequest {

    private $body;
    private $response;

    private $personGateway;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function sendToWorker()
    {
        $response = $this->getRequestBody();

        if ($reponse === false) {
            return $this->response;
        }
        $pheanstalk = Pheanstalk::create('host.docker.internal');

        $pheanstalk
            ->useTube('email')
            ->put(
                json_encode($this->body)
             );
        $this->response['status_code_header'] = 'HTTP/1.1 200 OK';
        $this->response['body'] = '{"status": "Success"}';
        header($this->response['status_code_header']);
   
        return $this->response;
    }

    
    private function getRequestBody()
    {
        if (! $this->validateRequest($this->body)) {
            return false;
        }
        return $this->body;
    }

    private function validateRequest($body)
    {
        if (! isset($body['sendTo'])) {
            $this->unprocessableEntityResponse();
            return false;
        }
        if (! isset($body['message'])) {
            $this->unprocessableEntityResponse();
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $this->response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $this->response['body'] = json_encode([
            'error_message' => 'Invalid input'
        ]);
    }

}
