<?php

namespace Brzozowski\IntelliHomeBundle\Model\Arduino;


class ArduinoDataProvider
{
    private $portAddress = "/dev/ttyUSB0";          //   chmod 777 /dev/ttyUSB0

    private $regulatorAddress = "http://192.168.2.126";


    function activateAlarm()
    {
        exec('echo s > '.$this->portAddress.'');
    }

    function dezactivateAlarm()
    {
        exec('echo r > '.$this->portAddress.'');
    }

    function sendBrakeIn()
    {
        exec('echo b > '.$this->portAddress.'');
    }

    function sendDetection()
    {
        exec('echo a > '.$this->portAddress.'');
    }

    function setRelay($value)
    {
        exec('(echo c'.$value.'; sleep 1) > '.$this->portAddress.'');
    }

    function setRelayVer2($value)
    {
        exec('(echo C'.$value.'; sleep 1) > '.$this->portAddress.'');
    }

    function sendWeatherRequest()
    {
        exec('echo W > '.$this->portAddress.'');
    }

    function calibrateRelay($value)
    {
        exec('echo K > '.$this->portAddress.'');
    }

    function setHeating($value)
    {
        exec('(echo h'.$value.'; sleep 1) > '.$this->portAddress);
    }

    function setNewPhoneNumber($value)
    {
        exec('(echo T'.$value.'; sleep 2) > '.$this->portAddress);
    }

    function setSirenTime($minutes)
    {
        exec('(echo t'.$minutes.'; sleep 1) > '.$this->portAddress);
    }

    function setSystemSettings($setting, $value)
    {
        exec('(echo e'.$setting.' '.$value.'; sleep 1) > '.$this->portAddress);
    }

    function restartServer()
    {
        exec('sudo shutdown -r 0');

    }

    // ---------------------------------------

    function setHeatingTemperature($value)
    {
        $addressString = $this->regulatorAddress."/?temp=".$value;
        @$response = file_get_contents($addressString);
    }

    function setHeatingAmplitude($value)
    {
        $addressString = $this->regulatorAddress."/?ampl=".$value;
        @$response = file_get_contents($addressString);
    }

    function setHeatingMode($value)
    {
        $addressString = $this->regulatorAddress."?mode=".$value;
        @$response = file_get_contents($addressString);
    }

    function setHeatingDate()
    {
        $currentDate = date_create()->format('d.m.Y');
        $currentDayOfWeek = date_create()->format('N');
        $addressString = $this->regulatorAddress."?date=".$currentDayOfWeek.":".$currentDate;
        @$response = file_get_contents($addressString);
    }

    function setHeatingTime()
    {
        $currentTime = date_create()->format('H:i:s');
        $addressString = $this->regulatorAddress."?time=".$currentTime;
        @$response = file_get_contents($addressString);
    }

}