<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\Entity\HeatingStatistics;
use Brzozowski\IntelliHomeBundle\Entity\Notifications;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Brzozowski\IntelliHomeBundle\Entity\Logs;
use Brzozowski\IntelliHomeBundle\Entity\Alarm;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(
 *     "/arduino",
 *     name="incoming_arduino_data"
 * )
 */
class IncomingArduinoDataController extends Controller
{
    /**
     * @Route(
     *     "/uruchom_alarm_wlamanie.php",
     *     name="arduino_activate_alarm_breakin"
     * )
     * @param Request $request
     * @return Response
     */
    public function activateAlarmOrBreakinAction(Request $request)
    {
        $alarmStatus = $request->query->get('alarm');

        if($alarmStatus == 'p' or $alarmStatus == 'A' or $alarmStatus == 'B' or $alarmStatus == 'C' or $alarmStatus == 'D'
            or $alarmStatus == 'b' or $alarmStatus == 'l' or $alarmStatus == 'U')
        {

            switch($alarmStatus)
            {
                case 'A': {
                    $personId = 1;
                    break;
                }
                case 'B': {
                    $personId = 2;
                    break;
                }
                case 'C': {
                    $personId = 3;
                    break;
                }
                case 'D': {
                    $personId = 4;
                    break;
                }
                case 'p': {
                    $personId = 5;
                    break;
                }
                case 'b': {
                    $personId = 6;
                    $message = "Włamanie !!!";
                    $type = 'danger';
                    $status = 'BREAKIN';
                    break;
                }
                case 'l': {
                    $personId = 6;
                    $status = 'ON';
                    $message = null;
                    $type = null;
                    break;
                }
                case 'U': {
                    $message = "System IntelliHome został zrestartowany. Alarm zdezaktywowany.";
                    $type = 'info';
                    $personId = 6;
                    $status = 'OFF';
                    break;
                }
                default: {
                    $personId = 6;
                    $status = '';
                    $message = null;
                    $type = null;

                    //return new Response(Response::HTTP_BAD_REQUEST);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            if($personId < 6) {
                $status = "CHANGE";
                $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Persons');
                $person = $Repo->findOneBy(
                    array('id' => $personId)
                );
                $name = $person->getName();
                $message = "Użytkownik ".$name." aktywował alarm przy użyciu swojej karty";
            }

            // Save alarm status
            $alarm = new Alarm();
            $alarm->setDate($dateTime);
            $alarm->setTime($dateTime);
            $alarm->setWho($personId);
            $alarm->setStatus($status);
            $em->persist($alarm);
            $em->flush();

            // Save log
            if($message) {
                $log = new Logs();
                $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
                $em = $this->getDoctrine()->getManager();
                $em->persist($log);
                $em->flush();
            }

            // Save notif
            if($type) {
                $notif = new Notifications($type, $message);
                $em->persist($notif);
                $em->flush();
            }

            return new Response(Response::HTTP_OK);
        }

        return new Response(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/rozbroj_alarm.php",
     *     name="arduino_dezactivate_alarm"
     * )
     * @param Request $request
     * @return Response
     */
    public function dezactivateAlarmAction(Request $request)
    {
        $alarmStatus = $request->query->get('alarm');

        if($alarmStatus == 'd' or $alarmStatus == 'E' or $alarmStatus == 'F' or $alarmStatus == 'G' or $alarmStatus == 'H')
        {
            switch($alarmStatus)
            {
                case 'E': {
                    $personId = 1;
                    break;
                }
                case 'F': {
                    $personId = 2;
                    break;
                }
                case 'G': {
                    $personId = 3;
                    break;
                }
                case 'H': {
                    $personId = 4;
                    break;
                }
                case 'd': {
                    $personId = 5;
                    break;
                }
                default: {
                    $personId = null;
                }
            }

            $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Persons');
            $person = $Repo->findOneBy(
                array('id' => $personId)
            );
            $name = $person->getName();

            if($personId != 5) $message = "Użytkownik ".$name." rozbroił alarm przy użyciu swojej karty";
                else $message = "Rozbrojono alarm poprzez PIN";

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            // Save alarm status
            $alarm = new Alarm();
            $alarm->setDate($dateTime);
            $alarm->setTime($dateTime);
            $alarm->setWho($personId);
            $alarm->setStatus("OFF");
            $em->persist($alarm);
            $em->flush();

            // Save log
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            return new Response(Response::HTTP_OK);
        }

        return new Response(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/zmieniony_pin.php",
     *     name="arduino_changed_pin"
     * )
     * @param Request $request
     * @return Response
     */
    public function changedAlarmPINAction(Request $request)
    {
        $changedPIN = $request->query->get('zmienionypin');

        if($changedPIN == 'Z')
        {
            $message = "Zmieniono numer PIN";
            $type = "success";

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            // Save log
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            $notif = new Notifications($type, $message);
            $em->persist($notif);
            $em->flush();

            return new Response(Response::HTTP_OK);
        }

        return new Response(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/bledny_pin.php",
     *     name="arduino_error_pin"
     * )
     * @param Request $request
     * @return Response
     */
    public function errorPINAction(Request $request)
    {
        $errorPIN = $request->query->get('blednypin');

        if($errorPIN == 'f')
        {
            $message = "Trzykrotnie wpisano błędny PIN";
            $type = "warning";

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            // Save log
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            $notif = new Notifications($type, $message);
            $em->persist($notif);
            $em->flush();

            return new Response(Response::HTTP_OK);
        }

        return new Response(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/gsm.php",
     *     name="arduino_gsm"
     * )
     * @param Request $request
     * @return Response
     */
    public function gsmAction(Request $request)
    {
        $sendSMS = $request->query->get('wyslano_sms');
        $savedNumber = $request->query->get('zapisano_numer');

        if (isset($savedNumber)) {
            $message = "Zmieniono numer alarmowy na: " . $savedNumber;
            $type = "success";

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            // Save log
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            // Save notification
            $notif = new Notifications($type, $message);
            $em->persist($notif);
            $em->flush();

            return new Response(Response::HTTP_OK);
        }

        if (isset($sendSMS))
        {
            $message = "Wysłano SMS z informacją o włamaniu na: ".$sendSMS;

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            // Save log
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            return new Response(Response::HTTP_OK);
        }

        return new Response(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/wykryto_ruch.php",
     *     name="arduino_motion_detected"
     * )
     * @param Request $request
     * @return Response
     */
    public function motionDetectAction(Request $request)
    {
        $motionDetected = $request->query->get('wykrycie');

        if($motionDetected == 'L' or $motionDetected == 'M' or $motionDetected == 'N' or $motionDetected == 'O'
            or $motionDetected == 'P' or $motionDetected == 'R')
        {
            switch($motionDetected)
            {
                case 'L': {
                    $PIR_Id = 1;
                    break;
                }
                case 'M': {
                    $PIR_Id = 2;
                    break;
                }
                case 'N': {
                    $PIR_Id = 3;
                    break;
                }
                case 'O': {
                    $PIR_Id = 4;
                    break;
                }
                /*
                case 'P': {
                    $PIR_Id = 5;
                    break;
                }
                case 'R': {
                    $PIR_Id = 6;
                    break;
                }
                */
                default: {
                    return new Response(Response::HTTP_BAD_REQUEST);
                }
            }

            $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:MotionSensors');
            $motion = $Repo->findOneBy(
                array('id' => $PIR_Id)
            );
            $roomName = $motion->getRoomName();
            $message = "W pomieszczeniu ".$roomName." wykryto ruch.";

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            // Save log
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();

            return new Response(Response::HTTP_OK);
        }

        return new Response(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/odbierz_dane_pogodowe.php",
     *     name="arduino_get_weather"
     * )
     * @param Request $request
     * @return Response
     */
    public function getWeatherDataAction(Request $request)
    {
        $temperature = $request->query->get('temperature');
        $humidity = $request->query->get('humidity');
        $insolation = $request->query->get('insolation');
        $windlevel = $request->query->get('windlevel');
        $rainlevel = $request->query->get('rainlevel');
        $pressure = $request->query->get('pressure');
        $liquidwastelevel = $request->query->get('liquidwastelevel');
        $hometemperature = $request->query->get('hometemperature');
        $homeinsolation = $request->query->get('homeinsolation');
        /*
        $blindlevel = $_GET['blindlevel'];
        $heatinglevel = $_GET['heatinglevel'];
        $wateringstate = $_GET['wateringstate'];
        */

        $dateTime = new \DateTime();

        $parameters = array(
            'date' => $dateTime,
            'time' => $dateTime,
            'temperature' => $temperature,
            'humidity' => $humidity,
            'insolation' => $insolation,
            'windlevel' => $windlevel,
            'rainlevel' => $rainlevel,
            'pressure' => $pressure,
            'liquidwastelevel' => $liquidwastelevel,
            'hometemperature' => $hometemperature,
            'homeinsolation' => $homeinsolation,
        );

        $em = $this->getDoctrine()->getManager();

        $sql = "UPDATE BrzozowskiIntelliHomeBundle:TemporaryData t 
                SET t.date = :date, t.time = :time, t.temperature = :temperature, 
                t.humidity = :humidity, t.insolation = :insolation, t.windlevel = :windlevel, 
                t.rainlevel = :rainlevel, t.pressure = :pressure, t.liquidwaste = '40', 
                t.hometemperature = :hometemperature, t.homeinsolation = :homeinsolation 
                WHERE t.id = 1";

        $query = $em->createQuery($sql)
            ->setParameters($parameters);

        $query->execute();

        if($liquidwastelevel > 80)
        {
            $message = "Poziom nieczystości płynnych wynosi ponad 80%";
            // Zapisz informację o tym, że powiadomienie zostało wysłane,
            // gdyż, jeżeli juz jest to nie wysyłaj kolejnego
            // Pamiętaj o ustawieniach, każdy user może sobie zażyczyć email z informacją
            $type="danger";

            $notif = new Notifications($type, $message);
            $em->persist($notif);
            $em->flush();
        }

        return new Response(Response::HTTP_OK);
    }


    /**
     * @Route(
     *     "/ogrzewanie.php",
     *     name="arduino_get_heating"
     * )
     * @param Request $request
     * @return Response
     */
    public function getHeatingDataAction(Request $request)
    {
        $currentTemp = $request->query->get('CurrentTemp');
        $currentHumi = $request->query->get('CurrentHumi');
        $temp = $request->query->get('temp');
        $ampl = $request->query->get('ampl');
        $mode = $request->query->get('mode');

        $dateTime = new \DateTime();
        $em = $this->getDoctrine()->getManager();

        if (isset($currentTemp) and isset($currentHumi))
        {
            $sql = "UPDATE BrzozowskiIntelliHomeBundle:TemporaryData t 
                SET t.date = :date, t.time = :time, 
                t.hometemperature = :hometemperature, t.homehumidity = :homehumidity 
                WHERE t.id = 1";

            $query = $em->createQuery($sql)
            ->setParameters(array(
                'date' => $dateTime,
                'time' => $dateTime,
                'hometemperature' => $currentTemp,
                'homehumidity' => $currentHumi
            ));

            $query->execute();

            // Pobranie danych do statystyki
            $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Heating');
            $heatingRow = $Repo->findOneBy(
                array('id' => 1)
            );
            $temperatureOfHeating = $heatingRow->getTemperature();
            $amplitudeOfHeating = $heatingRow->getAmplitude();

            // ------------------------------------------------------------------------
            $amplFrom = $temperatureOfHeating-$amplitudeOfHeating;
            $amplTo = $temperatureOfHeating+$amplitudeOfHeating;

            $stats = new HeatingStatistics();
            $stats->setDate($dateTime);
            $stats->setTime($dateTime);
            $stats->setTemperature($currentTemp);
            $stats->setHumidity($currentHumi);
            $stats->setSetTemp($temperatureOfHeating);
            $stats->setFromTemp($amplFrom);
            $stats->setToTemp($amplTo);
            $em->persist($stats);
            $em->flush();
        }

        if (isset($temp))
        {
            $sql = "UPDATE BrzozowskiIntelliHomeBundle:Heating h
                    SET h.date= :date, h.time= :time, h.temperature= :temp
	                WHERE h.id=1";
            $query = $em->createQuery($sql)
            ->setParameters(array(
                'date' => $dateTime,
                'time' => $dateTime,
                'temp' => $temp
            ));
            $query->execute();

            // Save log
            $message = "Programator zmienił temperature na ".$temp." C";
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();
        }

        if (isset($ampl))
        {
            $sql = "UPDATE BrzozowskiIntelliHomeBundle:Heating h
                    SET h.date= :date, h.time= :time, h.amplitude= :ampl
	                WHERE h.id=1";
            $query = $em->createQuery($sql)
                ->setParameters(array(
                    'date' => $dateTime,
                    'time' => $dateTime,
                    'ampl' => $ampl
                ));
            $query->execute();

            // Save log
            $message = "Programator zmienił amplitude na ".$ampl." C";
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();
        }

        if (isset($mode))
        {
            $sql = "UPDATE BrzozowskiIntelliHomeBundle:Heating h
                    SET h.date= :date, h.time= :time, h.operatingMode= :mode
	                WHERE h.id=1";
            $query = $em->createQuery($sql)
                ->setParameters(array(
                    'date' => $dateTime,
                    'time' => $dateTime,
                    'mode' => $mode
                ));
            $query->execute();

            // Save log
            $message = "Programator zmienił tryb grzewczy na ".$mode;
            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em->persist($log);
            $em->flush();
        }

        return new Response(Response::HTTP_OK);
    }
}
