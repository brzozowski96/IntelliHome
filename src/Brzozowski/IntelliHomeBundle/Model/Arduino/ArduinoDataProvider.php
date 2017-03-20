<?php

namespace Brzozowski\IntelliHomeBundle\Model\Arduino;


class ArduinoDataProvider
{
    static private $portAddress = "";


    static function activateAlarm()
    {

    }

    static function dezactivateAlarm()
    {

    }

    static function sendBrakeIn()
    {
    }

    static function sendDetection()
    {
    }

    static function setRelay($value)
    {
    }

    static function setRelayVer2($value)
    {
    }

    static function sendWeatherRequest()
    {
    }

    static function calibrateRelay($value)
    {
    }

    static function setHeating($value)
    {
    }

    static function setNewPhoneNumber($value)
    {
    }

    static function setSirenTime($minutes)
    {
    }

    static function setSystemSettings($setting, $value)
    {
    }

    static function restartServer()
    {

    }

    // ---------------------------------------

    static function setHeatingTemperature($value)
    {
    }

    static function setHeatingAmplitude($value)
    {
    }

    static function setHeatingMode($value)
    {
        return true;
    }

    static function setHeatingDatetime()
    {
    }

    static function setBlindsLevel($value)
    {
    }

}