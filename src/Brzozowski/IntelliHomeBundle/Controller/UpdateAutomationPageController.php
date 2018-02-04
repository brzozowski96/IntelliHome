<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\BrzozowskiIntelliHomeBundle;
use Brzozowski\IntelliHomeBundle\Entity\Heating;
use Brzozowski\IntelliHomeBundle\Entity\Settings;
use Brzozowski\IntelliHomeBundle\Entity\TemporaryData;
use Brzozowski\IntelliHomeBundle\Entity\WeatherStation;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

use Brzozowski\IntelliHomeBundle\Entity\Logs;
use Brzozowski\IntelliHomeBundle\Entity\Alarm;
use Symfony\Component\HttpFoundation\Request;
use Brzozowski\IntelliHomeBundle\Model\Arduino\ArduinoDataProvider as Arduino;

/**
 * @Route(
 *     "/user/automatyka",
 *     name="intellihome_user_update"
 * )
 */
class UpdateAutomationPageController extends Controller
{
    /**
     * @Route(
     *     "/tryb-ogrzewania",
     *     name="intellihome_automation_heating_mode"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateHeatingModeAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $operatingMode = $request->request->get('heatingMode');

            if( !is_numeric($operatingMode) or $operatingMode < 0 or $operatingMode > 4) {
                return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
            }

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            $acceptChange = Arduino::setHeatingMode($operatingMode);
            if(!$acceptChange) return new Response(Response::HTTP_BAD_REQUEST);

            $parameters = array(
                'date' => $dateTime,
                'time' => $dateTime,
                'operatingMode' => $operatingMode,
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:Heating h 
                    SET h.date = :date, h.time = :time, h.operatingMode = :operatingMode
                    WHERE h.id = 1';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił tryb ogrzewania używając serwisu IntelliHome";
            $Session->getFlashBag()->add('success', 'Tryb ogrzewania został zmieniony');

            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                'operatingMode' => $operatingMode,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/ustaw-date",
     *     name="intellihome_automation_set_datetime"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateDatetimeAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            Arduino::setHeatingDatetime();
            $Session->getFlashBag()->add('success', 'Data i czas na regulatorze zostały ustawione');

            $response = array(
                "code" => 200,
                "success" => true,
                'dateTime' => $dateTime,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/ustaw-regulator",
     *     name="intellihome_automation_set_regulator"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateRegulatorSettingsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $heatingTemperature = $request->request->get('temperature');
            $heatingAmplitude = $request->request->get('amplitude');

            if($heatingAmplitude == null) {
                $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Heating');
                $heatingRow = $Repo->findOneBy(
                    array('id' => 1)
                );
                $heatingAmplitude = $heatingRow->getAmplitude();
            }

            if( !is_numeric($heatingTemperature) or $heatingTemperature < 5.0 or $heatingTemperature > 30.0) {
                return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
            }
            if( !is_numeric($heatingAmplitude) or $heatingAmplitude < 0.1 or $heatingAmplitude > 0.5) {
                return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
            }

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();
            $Session = $this->get('session');

            $parameters = array(
                'date' => $dateTime,
                'time' => $dateTime,
                'temperature' => $heatingTemperature,
                'amplitude' => $heatingAmplitude,
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:Heating h
                    SET h.date = :date, h.time = :time, h.temperature = :temperature, h.amplitude = :amplitude
                    WHERE h.id = 1';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            Arduino::setHeatingAmplitude($heatingAmplitude);
            Arduino::setHeatingTemperature($heatingTemperature);

            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił ustawienia ogrzewania używając serwisu IntelliHome";
            $Session->getFlashBag()->add('success', 'Ustawienia ogrzewania zostały zmienione');

            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
                'temperature' => $heatingTemperature,
                'amplitude' => $heatingAmplitude,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(
     *     "/ustaw-rolety",
     *     name="intellihome_automation_set_blinds"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateBlindsSettingsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $blindsLevel = $request->request->get('blindsLevel');

            if( !is_numeric($blindsLevel) or $blindsLevel < 0 or $blindsLevel > 100) {
                return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
            }

            $em = $this->getDoctrine()->getManager();
            $dateTime = new \DateTime();

            $parameters = array(
                'date' => $dateTime,
                'time' => $dateTime,
                'blindsLevel' => $blindsLevel,
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:TemporaryData t
                    SET t.date = :date, t.time = :time, t.blindlevel = :blindsLevel
                    WHERE t.id = 1';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            Arduino::setBlindsLevel($blindsLevel);

            $response = array(
                "code" => 200,
                "success" => true,
                'blindsLevel' => $blindsLevel,
            );

            return new Response(json_encode($response));
        }

        // --------------

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/otworz-rolety",
     *     name="intellihome_automation_set_blinds_open"
     * )
     * @param Request $request
     * @return Response
     */
    public function openBlindsSettingsAction(Request $request)
    {
        $ch = curl_init();
        $url = 'http://192.168.2.201/setBlind1?params=0';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $ch2 = curl_init();
        $url2 = 'http://192.168.2.201/setBlind2?params=0';
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HEADER, TRUE);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
        $head2 = curl_exec($ch2);
        $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        if($httpCode == 200 and $httpCode2 == 200) {
            return new Response(json_encode(array("success => true")), Response::HTTP_OK);
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/otworz-rolete-1",
     *     name="intellihome_automation_set_blind_open_1"
     * )
     * @param Request $request
     * @return Response
     */
    public function openFirstBlindSettingsAction(Request $request)
    {
        $ch = curl_init();
        $url = 'http://192.168.2.201/setBlind1?params=0';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpCode == 200) {
            return new Response(json_encode(array("success => true")), Response::HTTP_OK);
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/otworz-rolete-2",
     *     name="intellihome_automation_set_blind_open_2"
     * )
     * @param Request $request
     * @return Response
     */
    public function openSecondBlindSettingsAction(Request $request)
    {
        $ch2 = curl_init();
        $url2 = 'http://192.168.2.201/setBlind2?params=0';
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HEADER, TRUE);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
        $head2 = curl_exec($ch2);
        $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        if($httpCode2 == 200) {
            return new Response(json_encode(array("success => true")), Response::HTTP_OK);
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/zamknij-rolety",
     *     name="intellihome_automation_set_blinds_close"
     * )
     * @param Request $request
     * @return Response
     */
    public function closeBlindsSettingsAction(Request $request)
    {
        $ch = curl_init();
        $url = 'http://192.168.2.201/setBlind1?params=100';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $ch2 = curl_init();
        $url2 = 'http://192.168.2.201/setBlind2?params=100';
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HEADER, TRUE);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
        $head2 = curl_exec($ch2);
        $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        if($httpCode == 200 and $httpCode2 == 200) {
            return new Response(json_encode(array("success => true")), Response::HTTP_OK);
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/zamknij-rolete-1",
     *     name="intellihome_automation_set_blind_close_1"
     * )
     * @param Request $request
     * @return Response
     */
    public function closeFirstBlindSettingsAction(Request $request)
    {
        $ch = curl_init();
        $url = 'http://192.168.2.201/setBlind1?params=100';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpCode == 200) {
            return new Response(json_encode(array("success => true")), Response::HTTP_OK);
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/zamknij-rolete-2",
     *     name="intellihome_automation_set_blind_close_2"
     * )
     * @param Request $request
     * @return Response
     */
    public function closeSecondBlindSettingsAction(Request $request)
    {
        $ch2 = curl_init();
        $url2 = 'http://192.168.2.201/setBlind2?params=100';
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HEADER, TRUE);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
        $head2 = curl_exec($ch2);
        $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        if($httpCode2 == 200) {
            return new Response(json_encode(array("success => true")), Response::HTTP_OK);
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/ustaw-podlewanie",
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

            $setting = "200";   // number of watering setting
            Arduino::setSystemSettings($setting, $wateringStatus);

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
     *     "/ustaw-harmonogram",
     *     name="intellihome_automation_timetable_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateHeatingTimetableAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $dateTime = new \DateTime();
            $em = $this->getDoctrine()->getManager();
            $Session = $this->get('session');

            $timetable = $request->request->get('timetable');

            for($i=1; $i<=7; $i++)
            //foreach ($timetable as $blocksContent)
            {
                $blocksContent = $timetable[$i];
                $parameters = array(
                    'dayOfWeek' => $i,
                );
                foreach ($blocksContent as $key => $value)
                {
                    //$parameters[$key] = $value;
                    //array_push($parameters, $key => $value);
                    $parameters = $parameters + array($key => $value);
                }

                $sql = 'UPDATE BrzozowskiIntelliHomeBundle:HeatingTimetable t
                    SET t.startBlock1 = :StartBlock1, t.startBlock2 = :StartBlock2, t.startBlock3 = :StartBlock3,
                    t.stopBlock1 = :StopBlock1, t.stopBlock2 = :StopBlock2, t.stopBlock3 = :StopBlock3,
                    t.modeBlock1 = :ModeBlock1, t.modeBlock2 = :ModeBlock2, t.modeBlock3 = :ModeBlock3
                    WHERE t.dayOfWeek = :dayOfWeek';

                $query = $em->createQuery($sql)
                    ->setParameters($parameters);

                $isDone = $query->execute();
            }

            $Session->getFlashBag()->add('success', 'Harmonogram ogrzewania został zmieniony');
            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił harmonogram ogrzewania";

            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/ustaw-tryby-ogrzewania",
     *     name="intellihome_automation_heatingmode_update"
     * )
     * @param Request $request
     * @return Response
     */
    public function updateHeatingModesAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            $em = $this->getDoctrine()->getManager();
            $Session = $this->get('session');
            $dateTime = new \DateTime();
            $dayMode = $request->request->get('dayMode');
            $nightMode = $request->request->get('nightMode');
            $holidayMode = $request->request->get('holidayMode');

            if(     (!is_numeric($dayMode) or $dayMode < 5.0 or $dayMode > 30.0)
                or (!is_numeric($nightMode) or $nightMode < 5.0 or $nightMode > 30.0)
                or (!is_numeric($holidayMode) or $holidayMode < 5.0 or $holidayMode > 30.0))
            {
                return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
            }

            $parameters = array(
                'dayMode' => $dayMode,
                'nightMode' => $nightMode,
                'holidayMode' => $holidayMode,
            );

            $sql = 'UPDATE BrzozowskiIntelliHomeBundle:HeatingModes m
                       SET m.temperature = CASE m.id
                                          WHEN 1 THEN :dayMode
                                          WHEN 2 THEN :nightMode
                                          WHEN 3 THEN :holidayMode
                                          ELSE m.temperature
                                          END
                     WHERE m.id IN(1, 2, 3)';

            $query = $em->createQuery($sql)
                ->setParameters($parameters);

            $isDone = $query->execute();

            $Session->getFlashBag()->add('success', 'Tryby ogrzewania zostały zmienione');
            $message = "Użytkownik ".$this->getUser()->getName()." ".$this->getUser()->getSurName()." zmienił tryby ogrzewania";

            $log = new Logs();
            $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush();

            $response = array(
                "code" => 200,
                "success" => true,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
    }
}