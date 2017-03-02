<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\BrzozowskiIntelliHomeBundle;
use Brzozowski\IntelliHomeBundle\Entity\MotionSensors;
use Brzozowski\IntelliHomeBundle\Entity\Settings;
use Brzozowski\IntelliHomeBundle\Entity\TemporaryData;
use Brzozowski\IntelliHomeBundle\Entity\User;
use Brzozowski\IntelliHomeBundle\Entity\WeatherStation;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

use Brzozowski\IntelliHomeBundle\Form\RegisterType;
use Brzozowski\IntelliHomeBundle\Form\LoginType;
use Brzozowski\IntelliHomeBundle\Entity\Logs;
use Brzozowski\IntelliHomeBundle\Entity\Alarm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * @Route(
 *     "/user/ustawienia",
 *     name="intellihome_settings_update"
 * )
 */
class UpdateSettingsPageController extends Controller
{
    /**
     * @Route(
     *     "/memory-update",
     *     name="intellihome_settings_memory_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateMemoryAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $Session = $this->get('session');
            $alarmPhone = $request->request->get('alarmPhone');
            $sirenTime = $request->request->get('sirenTime');
            $blindTime = $request->request->get('blindTime');


            $em = $this->getDoctrine()->getManager();

            $parameters = array(
                'alarmPhoneNumber' => $alarmPhone,
                'sirenTime' => $sirenTime,
                'blindTime' => $blindTime,
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:Settings s 
                    SET s.alarmPhoneNumber = :alarmPhoneNumber, s.sirenTime = :sirenTime, s.blindTime = :blindTime
                    WHERE s.id = 1';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił ustawienia pamięci systemu używając serwisu IntelliHome";
            $Session->getFlashBag()->add('success', 'Ustawienia zostały zmienione');


            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                "error" => null,
            );

            return new Response(json_encode($response));
        }

        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

    /**
     * @Route(
     *     "/options-update",
     *     name="intellihome_settings_options_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateOptionsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            $options = $request->request->get('options');

            $em = $this->getDoctrine()->getManager();

            $parameters = array(
                'showCameraViewWhenAlarmDeactivated' => $options['value1'],
                'changeBlindsAfterAlarmActicated' => $options['value2'],
                'changeHeatingAfterAlarmActicated' => $options['value3'],
                'preventHeating' => $options['value4'],
                'preventBlindsDamage' => $options['value5']
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:Settings s
                    SET s.showCameraViewWhenAlarmDeactivated = :showCameraViewWhenAlarmDeactivated, 
                        s.changeBlindsAfterAlarmActicated = :changeBlindsAfterAlarmActicated, 
                        s.changeHeatingAfterAlarmActicated = :changeHeatingAfterAlarmActicated,
                        s.preventHeating = :preventHeating,
                        s.preventBlindsDamage = :preventBlindsDamage
                    WHERE s.id = 1';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił ustawienia systemu używając serwisu IntelliHome";
            $Session->getFlashBag()->add('success', 'Ustawienia zostały zmienione');


            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                "error" => null,
                "options" => $options
            );

            return new Response(json_encode($response));
        }

        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

    /**
     * @Route(
     *     "/settings-update",
     *     name="intellihome_settings_user_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateUserSettingsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            $options = $request->request->get('options');

            $em = $this->getDoctrine()->getManager();

            $parameters = array(
                'userId' => $this->getUser()->getId(),
                'liquidWasteEmail' => $options['value1'],
                'logsEmail' => $options['value2']
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:SettingsUsers s
                    SET s.liquidWasteEmail = :liquidWasteEmail, 
                        s.logsEmail = :logsEmail
                    WHERE s.userId = :userId';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił ustawienia użytkownika systemu używając serwisu IntelliHome";
            $Session->getFlashBag()->add('success', 'Ustawienia zostały zmienione');


            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                "error" => null,
                "options" => $options
            );

            return new Response(json_encode($response));
        }

        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }


    /**
     * @Route(
     *     "/zglos-problem",
     *     name="intellihome_settings_send_email_to_admin"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendEmailToAdminAction(Request $request)
    {

        $dateTime = new \DateTime();
        $Session = $this->get('session');
        $adminEmail = $this->getParameter('admin_email');

        $subject = $request->request->get('messageSubject');
        $content = $request->request->get('messageContent');

        $msgBody = $this->renderView('BrzozowskiIntelliHomeBundle:Email:adminEmail.html.twig', array(
            'email' => $this->getUser()->getEmail(),
            'name' => $this->getUser()->getName(),
            'surname' => $this->getUser()->getSurName(),
            'subject' => $subject,
            'message' => $content
        ));
        $emailMessage = \Swift_Message::newInstance()
            ->setSubject('Zgłoszenie użytkownika IntelliHome')
            ->setFrom(array($this->getUser()->getEmail() => $this->getUser()->getName().' '.$this->getUser()->getSurName()))
            ->setTo(array($adminEmail => 'IntelliHome Administrator'))
            ->setBody($msgBody, 'text/html');

        $this->get('mailer')->send($emailMessage);

        $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." wysłał wiadomość do administratora";
        $Session->getFlashBag()->add('success', 'Wiadomość została wysłana');


        $log = new Logs();
        $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
        $em = $this->getDoctrine()->getManager();
        $em->persist($log);
        $em->flush();

        return $this->redirect($this->generateUrl('intellihome_settings'));
    }


    /**
     * @Route(
     *     "/motions-update",
     *     name="intellihome_settings_motions_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateMotionsSettingsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            $motions = $request->request->get('motions');

            $em = $this->getDoctrine()->getManager();

            foreach ($motions as $key => $motion)
            {
                if($key==0) continue;
                $parameters = array(
                    'motionName' => $motion,
                    'motionId' => $key
                );

                $sql = 'UPDATE BrzozowskiIntelliHomeBundle:MotionSensors m
                    SET m.roomName = :motionName
                    WHERE m.id = :motionId';

                $query = $em->createQuery($sql)
                    ->setParameters($parameters);

                $query->execute();
            }

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił nazwy czujek ruchu";
            $Session->getFlashBag()->add('success', 'Nazwy czujek zostały zmienione');


            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                "error" => null,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/cards-update",
     *     name="intellihome_settings_cards_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateCardsSettingsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $Session = $this->get('session');
            $cards = $request->request->get('cards');
            $em = $this->getDoctrine()->getManager();

            foreach ($cards as $key => $card)
            {
                if($key==0) continue;
                $parameters = array(
                    'cardName' => $card,
                    'personId' => $key
                );

                $sql = 'UPDATE BrzozowskiIntelliHomeBundle:Persons p
                    SET p.name = :cardName
                    WHERE p.id = :personId';

                $query = $em->createQuery($sql)
                    ->setParameters($parameters);

                $query->execute();
            }

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił nazwy kard dostępu";
            $Session->getFlashBag()->add('success', 'Nazwy kard dostępu zostały zmienione');


            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                "error" => null,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }



}