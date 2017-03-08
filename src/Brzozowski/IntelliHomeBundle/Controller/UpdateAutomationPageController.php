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

            $response = array(
                "code" => 200,
                "success" => true,
                'blindsLevel' => $blindsLevel,
            );

            return new Response(json_encode($response));
        }

        return new Response(json_encode(array("success => false")), Response::HTTP_BAD_REQUEST);
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