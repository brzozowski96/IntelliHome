<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\BrzozowskiIntelliHomeBundle;
use Brzozowski\IntelliHomeBundle\Entity\Settings;
use Brzozowski\IntelliHomeBundle\Entity\TemporaryData;
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
 *     "/user",
 *     name="intellihome_user_update"
 * )
 */
class UpdatePagesController extends Controller
{
    /**
     * @Route(
     *     "/panel/alerts",
     *     name="intellihome_alerts_update"
     * )
     * @Template
     * @param Request $request
     * @return Response
     */
    public function updateAlertsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            {
                return new Response($this->renderView('BrzozowskiIntelliHomeBundle:UpdatePages:updateAlerts.html.twig'));
            }
        }

        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }


    /**
     * @Route(
     *     "/panel/podlewanie",
     *     name="intellihome_panel_watering_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateWateringAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $status = $request->request->get('status');

            if($status == 'on') $wateringStatus = true;
            else $wateringStatus = false;

            try
            {
                $em = $this->getDoctrine()->getManager();
                $dateTime = new \DateTime();
                $Session = $this->get('session');

                $parameters = array(
                    'date' => $dateTime,
                    'time' => $dateTime,
                    'status' => $wateringStatus,
                );

                $sql = 'UPDATE BrzozowskiIntelliHomeBundle:TemporaryData t 
                        SET t.date = :date, t.time = :time, t.wateringstate = :status 
                        WHERE t.id = 1';

                $query = $em->createQuery($sql)
                    ->setParameters($parameters);

                $isDone = $query->execute();

                if($wateringStatus == true) {
                    $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." aktywował inteligentne podlewanie używając serwisu IntelliHome";
                    $Session->getFlashBag()->add('success', 'Inteligentne podlewanie aktywowane');
                }
                else {
                    $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." dezaktywował inteligentne podlewanie używając serwisu IntelliHome";
                    $Session->getFlashBag()->add('warning', 'Inteligentne podlewanie dezaktywowane');
                }

                $log = new Logs();
                $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
                $em = $this->getDoctrine()->getManager();
                $em->persist($log);
                $em->flush();

                $success = true;
                $error = null;
            }
            catch (Exception $e) {
                $error = $e->getMessage();
                $success = false;
            }

            $response = array(
                "code" => 200,
                "success" => $success,
                "error" => $error,
                'wateringStatus' => $status,
            );

            return new Response(json_encode($response));
        }

        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }


    /**
     * @Route(
     *     "/panel/alarm",
     *     name="intellihome_alarm_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateAlarmAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $status = $request->request->get('alarmStatus');
            if($status == 'ON') $status = 'CHANGE';     // Status ON alarm system gets from device which control Alarm System (Arduino)

            if($status != 'CHANGE' and $status != 'OFF') {
                return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
            }

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            $alarm = new Alarm();
            $alarm->setDate($dateTime);
            $alarm->setTime($dateTime);
            $alarm->setWho(6);
            $alarm->setStatus($status);
            $em->persist($alarm);
            $em->flush();

            if($status == 'ON' or $status == 'CHANGE') {
                $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." aktywował alarm używając serwisu IntelliHome";
                $Session->getFlashBag()->add('success', 'System alarmowy aktywowany');
            }
            else {
                $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." dezaktywował alarm używając serwisu IntelliHome";
                $Session->getFlashBag()->add('success', 'System alarmowy rozbrojony');
            }

            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                //"code" => 200,
                //"success" => true,
                'alarmStatus' => $status,
            );

            return new Response(json_encode($response));
        }

        $response = array(
            "code" => 500,
            "success" => false,
        );
        return new Response(json_encode($response));
    }
}