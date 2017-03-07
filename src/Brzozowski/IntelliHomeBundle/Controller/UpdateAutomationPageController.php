<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\BrzozowskiIntelliHomeBundle;
use Brzozowski\IntelliHomeBundle\Entity\Heating;
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
}