<?php

namespace Brzozowski\IntelliHomeBundle\Twig;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('temp', array($this, 'tempFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.' zł';

        return $price;
    }

    public function tempFilter($number, $type = 'C')
    {
        if($type == 'C') return $number.'°C';
        if($type == 'F') return $number.'°F';
        return '';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getDayName', array($this, 'getDayName')),
        );
    }

    public function getDayName($dayNumber)
    {
        switch($dayNumber)
        {
            case 1: { return "Poniedziałek"; break; }
            case 2: { return "Wtorek"; break; }
            case 3: { return "Środa"; break; }
            case 4: { return "Czwartek"; break; }
            case 5: { return "Piątek"; break; }
            case 6: { return "Sobota"; break; }
            case 7: { return "Niedziela"; break; }
        }
        return '';
    }

    public function getName()
    {
        return 'app_extension';
    }
}