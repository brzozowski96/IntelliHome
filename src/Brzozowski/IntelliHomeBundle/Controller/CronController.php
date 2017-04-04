<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\Entity\Logs;
use Brzozowski\IntelliHomeBundle\Entity\Notifications;
use Brzozowski\IntelliHomeBundle\Entity\WeatherStation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Brzozowski\IntelliHomeBundle\Model\Arduino\ArduinoDataProvider as Arduino;

/**
 * @Route(
 *     "/cron",
 *     name="intellihome_cron"
 * )
 */
class CronController extends Controller
{
    /**
     * @Route(
     *     "/ogrzewanie",
     *     name="cron_heating"
     * )
     */
    function UpdateHeatingCronAction()
    {
        // Pobranie  ustawień
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Heating');
        $heatingRow = $Repo->findOneBy(
            array('id' => 1)
        );
        $temperatureOfHeating = $heatingRow->getTemperature();
        $amplitudeOfHeating = $heatingRow->getAmplitude();
        $operatingMode = $heatingRow->getOperatingMode();

        // Pobranie danych tymczasowych
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:TemporaryData');
        $tempRow = $Repo->findOneBy(
            array('id' => 1)
        );
        $HomeTemperature = $tempRow->getHometemperature();
        $HomeHumidity = $tempRow->getHomehumidity();
        $dateOfMeasurement = $tempRow->getDate();
        $timeOfMeasurement = $tempRow->getTime();
//--------------------------------------------------------------------
        $dateTime = new \Datetime();
        //$currentDayOfWeek = new \Datetime('N');
        $currentDate = date_create()->format('Y-m-d');
        $currentTime = date_create()->format('H:i:s');
        $currentDayOfWeek = date_create()->format('N');

        //$nowtime = date("H:i:s");
        $timePlusHour = date('H:i:s', strtotime($currentTime . ' + 1 hour'));
        //$timePlusHour = time()+3600;
        //$timePlusHour = mktime(date("H"), date("i")+1, date("s"), date("m")  , date("d"), date("Y"));

        $em = $this->getDoctrine()->getManager();

        if($operatingMode == 0)              // Stały
        {
            // Kontrola bledow ogrzewania
            if($HomeTemperature+2.0 < $temperatureOfHeating and $currentDate == $dateOfMeasurement)
            {
                $message = "Wykryto problem z ogrzewaniem. Pomieszczenia mogą być niedogrzane";
                $type = "warning";

                $log = new Logs();
                $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
                $em->persist($log);
                $em->flush();

                $notif = new Notifications($type, $message);
                $em->persist($notif);
                $em->flush();
            }
        }

        else if($operatingMode == 1)         // Harmonogram
        {
            // Kontrola bledow ogrzewania
            if($HomeTemperature+2.0 < $temperatureOfHeating and $currentDate == $dateOfMeasurement)
            {
                $message = "Wykryto problem z ogrzewaniem. Pomieszczenia mogą być niedogrzane";
                $type = "warning";
                $log = new Logs();
                $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
                $em->persist($log);
                $em->flush();

                $notif = new Notifications($type, $message);
                $em->persist($notif);
                $em->flush();
            }

            $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingTimetable');
            $dailyTimetable = $Repo->findOneBy(
                array('dayOfWeek' => $currentDayOfWeek)
            );

            $StartBlock1 = $dailyTimetable->getStartBlock1();
            $StopBlock1 = $dailyTimetable->getStopBlock1();
            $ModeBlock1 = $dailyTimetable->getModeBlock1();
            $StartBlock2 = $dailyTimetable->getStartBlock2();
            $StopBlock2 = $dailyTimetable->getStopBlock2();
            $ModeBlock2 = $dailyTimetable->getModeBlock2();
            $StartBlock3 = $dailyTimetable->getStartBlock3();
            $StopBlock3 = $dailyTimetable->getStopBlock3();
            $ModeBlock3 = $dailyTimetable->getModeBlock3();

            $modeName = "";
            $modeTemperature = null;

            //$timePlusHour

            if($StartBlock1->format('H:i:s') < $timePlusHour and $timePlusHour < $StopBlock1->format('H:i:s'))
            {
                $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingModes');
                $mode = $Repo->findOneBy(
                    array('id' => $ModeBlock1)
                );

                $modeName = $mode->getName();
                $modeTemperature = $mode->getTemperature();
            }
            else if($StartBlock2->format('H:i:s') < $timePlusHour and $timePlusHour < $StopBlock2->format('H:i:s'))
            {
                $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingModes');
                $mode = $Repo->findOneBy(
                    array('id' => $ModeBlock2)
                );

                $modeName = $mode->getName();
                $modeTemperature = $mode->getTemperature();
            }
            else if($StartBlock3->format('H:i:s') < $timePlusHour and $timePlusHour < $StopBlock3->format('H:i:s'))
            {
                $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingModes');
                $mode = $Repo->findOneBy(
                    array('id' => $ModeBlock3)
                );

                $modeName = $mode->getName();
                $modeTemperature = $mode->getTemperature();
            }


            // --------------------------------
            if($temperatureOfHeating != $modeTemperature)
            {
                // Wyslij do sterownika temp=$modeTemperature
                Arduino::setHeatingTemperature($modeTemperature);
                // Funkcja wysylajaca dane do sterownika kotla   np.dezactivateAlarm();
                // Aktualizacja statusu w bazi dokonywana jest przez sterownik - gdy odbierze polecenie

                $sql = "UPDATE BrzozowskiIntelliHomeBundle:Heating h 
                        SET h.date = :date, h.time = :time, h.temperature = :modeTemperature 
                        WHERE h.id = 1";

                $query = $em->createQuery($sql)
                    ->setParameters(array(
                        'date' => $dateTime,
                        'time' => $dateTime,
                        'modeTemperature' => $modeTemperature
                    ));

                $query->execute();

                $message = "System IntelliHome zmienił temperature ogrzewania zgodnie z harmonogramem na ".$modeTemperature."°C (".$modeName.").";
                $log = new Logs();
                $log->setDate($dateTime)->setTime($dateTime)->setContent($message);
                $em->persist($log);
                $em->flush();
            }

        }

        else if($operatingMode == 2) { }     // Wyłączony


        return new Response("<html><head></head><body></body></html>", Response::HTTP_OK);
    }


    /**
     * @Route(
     *     "/weather",
     *     name="cron_weather"
     * )
     */
    function UpdateWeatherCronAction()
    {
        $datetime = new \DateTime();
        $url = "http://api.wunderground.com/api/7de5912a20a403a7/conditions/q/PL/Gowarzewo.json";
        $contents = file_get_contents($url);
        $contents = utf8_encode($contents);
        $weatherContent = json_decode($contents);

//        $miasto = strstr($weather->current_observation->observation_location->city, ',', true);
//        print $miasto;
//        //print $weather->current_observation->observation_location->city;
//        echo "<br>Temperatura: ";
//        print $weather->current_observation->temp_c;
//        echo "<br>Temperatura odczuwalna: ";
//        print $weather->current_observation->feelslike_c;
//
//        echo "<br>Wilgotność: ";
//        $wilgotnosc = strstr($weather->current_observation->relative_humidity, '%', true);
//        print $wilgotnosc;
//
//        echo "<br>Ciśnienie: ";
//        print $weather->current_observation->pressure_mb;
//        echo "<br>Prędkość wiatru: ";
//        print $weather->current_observation->wind_kph;
//        echo "<br>Opady teraz: ";
//        print $weather->current_observation->precip_1hr_metric;
//        echo "<br>Opady dzisiaj: ";
//        print $weather->current_observation->precip_today_metric;

// SOURCE 2 - POZNAŃ
        $url2 = "http://api.wunderground.com/api/7de5912a20a403a7/conditions/q/PL/Poznan.json";
        $contents2 = file_get_contents($url2);
        $contents2 = utf8_encode($contents2);
        $weatherContent2 = json_decode($contents2);

//        echo "<br>UV: ";
//        print $weather2->current_observation->UV;
//        echo "<br>Promieniowanie słoneczne: ";
//        print $weather2->current_observation->solarradiation;
//
//
//        echo "<br>Ostatnia aktualizacja: ";
//        print $weather->current_observation->observation_epoch+3600;
//
//        $unix_time = $weather->current_observation->observation_epoch+3600;
//        $date = gmdate("Y-m-d", $unix_time);
//        $time = gmdate("H:i:s", $unix_time);
//        echo "<br>Ostatnia aktualizacja: ";
//        echo $date."   ".$time;

        //$city = strstr($weather->current_observation->observation_location->city, ',', true);

        $city = $weatherContent->current_observation->observation_location->city;
        $temp = $weatherContent->current_observation->temp_c;
        $feelsLike = $weatherContent->current_observation->feelslike_c;
        $hum  = (int)strstr($weatherContent->current_observation->relative_humidity, '%', true);
        $pres = (int)$weatherContent->current_observation->pressure_mb;
        $wind = (float)$weatherContent->current_observation->wind_kph;
        $rain = (float)trim($weatherContent->current_observation->precip_1hr_metric);
        $rainToday = (float)$weatherContent->current_observation->precip_today_metric;
        $solarRadiation = $weatherContent->current_observation->solarradiation;
        $uv = $weatherContent->current_observation->UV;


        $weather = new WeatherStation();
        $weather->setDate($datetime);
        $weather->setTime($datetime);
        $weather->setCity($city);
        $weather->setTemperature($temp);
        $weather->setFeelslike($feelsLike);
        $weather->setHumidity($hum);
        $weather->setPressure($pres);
        $weather->setWindlevel($wind);
        $weather->setRainlevel($rain);
        $weather->setRaintoday($rainToday);
        $weather->setSolarradiation($solarRadiation);
        $weather->setUv($uv);

        $weather->setLiquidwaste(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($weather);
        $em->flush();

        //----------------------------
        /*
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:WeatherStation');
        $query = $Repo->createQueryBuilder('w')
            ->orderBy('w.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1);
        $lastData = $query->getOneOrNullResult();
        */





//        if ($rezultat = $polaczenie->query("SELECT Date, Time FROM weather_station ORDER BY weather_station.Id  DESC LIMIT 1"))
//        {
//            $liczba_wierszy = $rezultat->num_rows;
//            if($liczba_wierszy>0)
//            {
//                $wiersz = $rezultat->fetch_assoc();
//
//                $weather_date = $wiersz['Date'];
//                $weather_time = $wiersz['Time'];
//                if($weather_date == $date and $weather_time == $time) exit();
//                if(!isSet($city) or $city=="") exit();
//            }
//            else {
//                echo '<span style="color:red">Brak danych pogodowych!</span>';
//            }
//        }
//        else
//        {
//            throw new Exception($polaczenie->error);
//        }
//
//
//        if ($rezultat = $polaczenie->query($sql))
//        {
//
//        }
//        else
//        {
//            throw new Exception($polaczenie->error);
//        }

        return new Response(Response::HTTP_OK);
    }
}
