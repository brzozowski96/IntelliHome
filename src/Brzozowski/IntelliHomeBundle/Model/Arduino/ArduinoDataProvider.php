<?php

namespace Brzozowski\IntelliHomeBundle\Model\Arduino;


class ArduinoDataProvider
{
    static private $portAddress = "/dev/ttyUSB0";          //   chmod 777 /dev/ttyUSB0

    static private $regulatorAddress = "http://192.168.2.126";

    static private $blindsAddress = "";


    static function activateAlarm()
    {
        exec('echo s > '.ArduinoDataProvider::$portAddress.'');
    }

    static function dezactivateAlarm()
    {
        exec('echo r > '.ArduinoDataProvider::$portAddress.'');
    }

    static function sendBrakeIn()
    {
        exec('echo b > '.ArduinoDataProvider::$portAddress.'');
    }

    static function sendDetection()
    {
        exec('echo a > '.ArduinoDataProvider::$portAddress.'');
    }

    static function setRelay($value)
    {
        exec('(echo c'.$value.'; sleep 1) > '.ArduinoDataProvider::$portAddress.'');
    }

    static function setRelayVer2($value)
    {
        exec('(echo C'.$value.'; sleep 1) > '.ArduinoDataProvider::$portAddress.'');
    }

    static function sendWeatherRequest()
    {
        exec('echo W > '.ArduinoDataProvider::$portAddress.'');
    }

    static function calibrateRelay($value)
    {
        exec('echo K > '.ArduinoDataProvider::$portAddress.'');
    }

    static function setHeating($value)
    {
        exec('(echo h'.$value.'; sleep 1) > '.ArduinoDataProvider::$portAddress);
    }

    static function setNewPhoneNumber($value)
    {
        exec('(echo T'.$value.'; sleep 2) > '.ArduinoDataProvider::$portAddress);
    }

    static function setSirenTime($minutes)
    {
        exec('(echo t'.$minutes.'; sleep 1) > '.ArduinoDataProvider::$portAddress);
    }

    static function setSystemSettings($setting, $value)
    {
        exec('(echo e'.$setting.' '.$value.'; sleep 1) > '.ArduinoDataProvider::$portAddress);
    }

    static function restartServer()
    {
        exec('sudo shutdown -r 0');

    }

    // ---------------------------------------

    static function setHeatingTemperature($value)
    {
        $addressString = ArduinoDataProvider::$regulatorAddress."/?temp=".$value;
        @$response = file_get_contents($addressString);
    }

    static function setHeatingAmplitude($value)
    {
        $addressString = ArduinoDataProvider::$regulatorAddress."/?ampl=".$value;
        @$response = file_get_contents($addressString);
    }

    static function setHeatingMode($value)
    {
        $addressString = ArduinoDataProvider::$regulatorAddress."?mode=".$value;
        @$response = file_get_contents($addressString);
    }

    static function setHeatingDatetime()
    {
        $currentDate = date_create()->format('d.m.Y');
        $currentDayOfWeek = date_create()->format('N');
        $addressString = ArduinoDataProvider::$regulatorAddress."?date=".$currentDayOfWeek.":".$currentDate;
        @$response = file_get_contents($addressString);

        $currentTime = date_create()->format('H:i:s');
        $addressString = ArduinoDataProvider::$regulatorAddress."?time=".$currentTime;
        @$response = file_get_contents($addressString);
    }

    static function setBlindsLevel($value)
    {
        $addressString = ArduinoDataProvider::$blindsAddress."?level=".$value;
        @$response = file_get_contents($addressString);
    }

}