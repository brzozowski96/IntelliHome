<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\Entity\Logs;
use Brzozowski\IntelliHomeBundle\Model\SMS\SendSMS;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/user",
 *     name="intellihome_user"
 * )
 */
class GsmController extends Controller
{
    /**
     * @Route(
     *     "/send-sms",
     *     name="send_sms"
     * )
     */
    public function sendSMSAction()
    {

        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Settings');
        $settingsRow = $Repo->findOneBy(
            array('id' => 1)
        );
        $phone = $settingsRow->getAlarmPhoneNumber();

        $sms = new SendSMS($this->getParameter('smsapi_token'));
        $result = $sms->sendSMS($phone, 'Włamanie!!!');

        if($result) $message = "Wiadomość SMS o włamaniu została wysłana na: ".$phone;
        else $message = "Wystąpił błąd podczas wysyłania wiadomości SMS (".$sms->getErrorMessage().").";

        $em = $this->getDoctrine()->getManager();
        $dateTime = new \DateTime();

        // Save log
        $log = new Logs();
        $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
        $em->persist($log);
        $em->flush();


        return new Response(Response::HTTP_OK);
        //return $this->redirect($this->generateUrl('intellihome_panel'));
    }
}
