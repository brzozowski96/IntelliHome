<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\Entity\Logs;
use Brzozowski\IntelliHomeBundle\Model\SMS\SendSMS;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/gsm",
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
        $result = $sms->sendSMS($phone, 'Włamanie na Lawendowej 46!!!');

        if($result) $message = "Wiadomość SMS o włamaniu została wysłana na: ".$phone;
        else $message = "Wystąpił błąd podczas wysyłania wiadomości SMS (".$sms->getErrorMessage().").";

        $em = $this->getDoctrine()->getManager();
        $dateTime = new \DateTime();

        // Save log
        $log = new Logs();
        $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
        $em->persist($log);
        $em->flush();

        // --------- Send admin email -----------------------------------------------------

        $dateTime = new \DateTime();
        $adminEmail = $this->getParameter('admin_email');

        $subject = 'IntelliHome - Włamanie';
        $content = 'Wykryto włamanie';

        $msgBody = $this->renderView('BrzozowskiIntelliHomeBundle:Email:adminEmail.html.twig', array(
            'email' => $adminEmail,
            'name' => 'Wiadomość systemowa',
            'surname' => '',
            'subject' => $subject,
            'message' => $content
        ));
        $emailMessage = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(array($adminEmail => 'IntelliHome Administrator'))
            ->setTo(array('brzozowski96@gmail.com' => 'IntelliHome Administrator'))
            ->setBody($msgBody, 'text/html');

        $result = $this->get('mailer')->send($emailMessage);

        $message = "System IntelliHome wysłał wiadomość o włamaniu do administratora (".$result.").";

        $log = new Logs();
        $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
        $em = $this->getDoctrine()->getManager();
        $em->persist($log);
        $em->flush();

        // --------------------------------------------------------------------------

        return new Response(Response::HTTP_OK);
        //return $this->redirect($this->generateUrl('intellihome_panel'));
    }
}
