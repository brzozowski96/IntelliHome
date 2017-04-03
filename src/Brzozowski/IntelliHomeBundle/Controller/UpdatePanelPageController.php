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
use Brzozowski\IntelliHomeBundle\Model\Arduino\ArduinoDataProvider as Arduino;


/**
 * @Route(
 *     "/user/panel",
 *     name="intellihome_panel_update"
 * )
 */
class UpdatePanelPageController extends Controller
{
    /**
     * @Route(
     *     "/alarm",
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
                $isExecuted = Arduino::activateAlarm();
                if($isExecuted == false) return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
                $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." aktywował alarm używając serwisu IntelliHome";
                $Session->getFlashBag()->add('success', 'System alarmowy aktywowany');
            }
            else {
                Arduino::dezactivateAlarm();
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