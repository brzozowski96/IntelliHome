<?php

namespace Brzozowski\IntelliHomeBundle\Model\SMS;

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;


class SendSMS
{
    private $token;
    private $errorMessage = '';

    function __construct($token)
    {
        $this->token = $token;
    }

    public function sendSMS($phone, $message, $sender='ECO'){

        $client = Client::createFromToken($this->token);

        //Lub wykorzystując login oraz hasło w md5
        //$client = new Client('login');
        //$client->setPasswordHash(md5('super tajne haslo'));

        $smsapi = new SmsFactory;
        $smsapi->setClient($client);

        try {
            $actionSend = $smsapi->actionSend();

            $actionSend->setTo($phone);
            $actionSend->setText($message);
            $actionSend->setSender($sender); //Pole nadawcy, lub typ wiadomości: 'ECO', '2Way'

            $response = $actionSend->execute();

            foreach ($response->getList() as $status) {
                echo $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
            }
        } catch (SmsapiException $exception) {
            $this->errorMessage = $exception->getMessage();
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}