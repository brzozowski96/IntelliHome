<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route(
 *     "/user/wykresy",
 *     name="intellihome_charts_update"
 * )
 */
class UpdateChartsPageController extends Controller
{
    /**
     * @Route("/pogoda",
     *     name="get_weather_chart_data"
     * )
     * @param Request $request
     * @return Response
     */
    public function getWeatherChartDataAction(Request $request)
    {
        $range = $request->request->get('chartRange');

        switch ($range) {
            case '6h':      $time = time()-6*60*60;
                break;
            case  '12h':    $time = time()-12*60*60;
                break;
            case  '24h':    $time = time()-24*60*60;
                break;
            case  '7d':     $time = time()-7*24*60*60;
                break;
            default:        $time = time()-24*60*60;
        }

        $fromDate = $time;

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT w.date, w.time, UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(w.date, \' \', w.time), \'%Y-%m-%d %H:%i:%s\')) as datetime, w.temperature
             FROM BrzozowskiIntelliHomeBundle:WeatherStation w
             HAVING datetime > :fromdatetime
             ORDER BY w.id ASC'
        )->setParameter('fromdatetime', $fromDate);

        $result = $query->getResult();

/*
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:WeatherStation');
        $query = $Repo->createQueryBuilder('w')
            ->select('COUNT(w.id)')
            ->getQuery();
        $total = $query->getSingleScalarResult();

        $total-=97;
        if($total <= 0) $total = 1;

        //$fromDate = new Timestamp('');

        //$Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:WeatherStation');
        $query = $Repo->createQueryBuilder('w')
            ->select('w.date', 'w.time',
                'concat(w.date, \' \', w.time) as datetimestring',
                'UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(w.date, " ", w.time), "%Y-%m-%d %H:%i:%s")) as datetime', 'w.temperature')
            ->where('datetime < :fromDate')
            ->setParameter('fromDate', $fromDate)
            ->setFirstResult($total)
            ->setMaxResults(200)
            ->getQuery();
        $result = $query->getResult();
*/

        $data = array();
        foreach ($result as $row) {
            $data[] = $row;
        }

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }


    /**
     * @Route("/ogrzewanie",
     *     name="get_heating_chart_data"
     * )
     * @param Request $request
     * @return Response
     */
    public function getHeatingChartDataAction(Request $request)
    {
        $range = $request->request->get('chartRange');

        switch ($range) {
            case '6h':      $time = time()-6*60*60;
                            break;
            case  '12h':    $time = time()-12*60*60;
                            break;
            case  '24h':    $time = time()-24*60*60;
                            break;
            case  '7d':     $time = time()-7*24*60*60;
                            break;
            default:        $time = time()-24*60*60;
        }

        $fromDate = $time;

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT w.date, w.time, UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(w.date, \' \', w.time), \'%Y-%m-%d %H:%i:%s\')) as datetime, w.temperature, w.setTemp
             FROM BrzozowskiIntelliHomeBundle:HeatingStatistics w
             HAVING datetime >= :fromdatetime
             ORDER BY w.id ASC'
        )->setParameter('fromdatetime', $fromDate);

        $result = $query->getResult();

//        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingStatistics');
//        $query = $Repo->createQueryBuilder('w')
//            ->select('COUNT(w.id)')
//            ->getQuery();
//        $total = $query->getSingleScalarResult();
//
//        $total-=97;
//        if($total <= 0) $total = 1;
//
//        $query = $Repo->createQueryBuilder('w')
//            ->select('w.date', 'w.time', 'w.temperature', 'w.setTemp')
//            ->setFirstResult($total)
//            ->setMaxResults(200)
//            ->getQuery();
//        $result = $query->getResult();
        /* */

        $data = array();
        foreach ($result as $row) {
            $data[] = $row;
        }

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
