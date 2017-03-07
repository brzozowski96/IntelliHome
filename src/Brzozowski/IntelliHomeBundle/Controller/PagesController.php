<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(
 *     "/user",
 *     name="intellihome_user"
 * )
 */
class PagesController extends Controller
{
    /**
     * @Route(
     *     "/panel",
     *     name="intellihome_panel"
     * )
     *
     * @Template
     */
    public function panelAction()
    {
// $sql = "SELECT * FROM weather_station ORDER BY weather_station.Id  DESC LIMIT 1";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:WeatherStation');
        $query = $Repo->createQueryBuilder('w')
            ->orderBy('w.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1);
        $weather = $query->getOneOrNullResult();

// $sql = "SELECT ShowCameraViewWhenAlarmDeactivated FROM settings WHERE settings.Id = 0";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Settings');
        $settingsRow = $Repo->findOneBy(
            array('id' => 1)
        );
        $showCamera = $settingsRow->getShowCameraViewWhenAlarmDeactivated();

        // $sql = "SELECT * FROM alarm ORDER BY alarm.Id  DESC LIMIT 1";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Alarm');
        $query = $Repo->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1);
        $alarm = $query->getOneOrNullResult();

// $sql = "SELECT * FROM notifications  WHERE Date>DATE_SUB(NOW(), INTERVAL 3 DAY) ORDER BY notifications.Id DESC";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Notifications');

        $pastDate = new \DateTime();
        $pastDate->format('d-m-Y');
        $pastDate->modify('-3 days');

        $query = $Repo->createQueryBuilder('n')
            ->where('n.date > :value')
            ->setParameter('value', $pastDate)
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->setMaxResults(20);
        $notifications = $query->getResult();

// $sql = "SELECT * FROM heating Where heating.Id=1";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Heating');
        $heatingRow = $Repo->findOneBy(
            array('id' => 1)
        );
        $heatingLevel = $heatingRow->getTemperature();

// $sql = "SELECT BlindLevel, WateringState FROM temporary_data";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:TemporaryData');
        $tempRow = $Repo->findOneBy(
            array('id' => 1)
        );
        $blindLevel = $tempRow->getBlindlevel();
        $wateringState = $tempRow->getWateringstate();

        return array(
            'weather' => $weather,
            'alarm' => $alarm,
            'showCameraView' => $showCamera,
            'notifications' => $notifications,
            'blindLevel' => $blindLevel,
            'heatingLevel' => $heatingLevel,
            'wateringState' => $wateringState,
        );
    }

    /**
     * @Route(
     *     "/wykresy",
     *     name="intellihome_charts"
     * )
     *
     * @Template
     */
    public function chartsAction()
    {
        return $this->render('BrzozowskiIntelliHomeBundle:Pages:websiteBuilding.html.twig');
    }

    /**
     * @Route(
     *     "/automatyka",
     *     name="intellihome_automation"
     * )
     *
     * @Template
     */
    public function automationAction()
    {
// $sql = "SELECT * FROM heating WHERE heating.Id=1";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Heating');
        $heatingRow = $Repo->findOneBy(
            array('id' => 1)
        );

// $sql = "SELECT * FROM temporary_data WHERE temporary_data.Id=1";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:TemporaryData');
        $temporaryRow = $Repo->findOneBy(
            array('id' => 1)
        );

        return array(
            'heating' => $heatingRow,
            'temporary' => $temporaryRow
        );
    }

    /**
     * @Route(
     *     "/automatyka/harmonogram",
     *     name="intellihome_automation_timetable"
     * )
     *
     * @Template
     */
    public function automationTimetableAction()
    {
// $sql = "SELECT * FROM heating_modes";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingModes');
        $heatingModes = $Repo->findAll();

// $sql = "SELECT * FROM heating_timetable";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:HeatingTimetable');
        $heatingTimetable = $Repo->findAll();

        return array(
            'timetable' => $heatingTimetable,
            'heatingModes' => $heatingModes
        );
    }

    /**
     * @Route(
     *     "/logi",
     *     name="intellihome_logs"
     * )
     *
     * @Template
     */
    public function logsAction()
    {
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Logs');
        $query = $Repo->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
            ->getQuery()
            ->setMaxResults(30);
        $logs = $query->getResult();

        return array(
            'logs' => $logs
        );
    }

    /**
     * @Route(
     *     "/ustawienia",
     *     name="intellihome_settings"
     * )
     *
     * @Template
     */
    public function settingsAction()
    {
// $sql = "SELECT * FROM settings WHERE settings.Id=0";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Settings');
        $settingsRow = $Repo->findOneBy(
            array('id' => 1)
        );

        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:SettingsUsers');
        $userSettingsRow = $Repo->findOneBy(
            array('userId' => $this->getUser()->getId())
        );

// $sql = "SELECT * FROM motion_sensors ORDER BY motion_sensors.Id ASC";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:MotionSensors');
        $motionSensors = $Repo->findAll();

// $sql = "SELECT Id, Name FROM persons ORDER BY persons.Id ASC";
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiIntelliHomeBundle:Persons');
        $persons = $Repo->findAll();

        $adminEmail = $this->getParameter('admin_email');

        return array(
            'settingsRow' => $settingsRow,
            'userSettingsRow' => $userSettingsRow,
            'motions' => $motionSensors,
            'persons' => $persons,
            'adminEmail' => $adminEmail
        );
    }

    /**
     * @Route(
     *     "/rejestracja",
     *     name="intellihome_register"
     * )
     *
     * @Template
     */
    /*
    public function registerAction(Request $Request)
    {
        $User = new User();

        $Session = $this->get('session');

        //if(!$Session->has('registered'))
        {
            $form = $this->createForm(RegisterType::class, $User);

            $form->handleRequest($Request);

            //if($Request->isMethod('POST')){
            if($form->isSubmitted()){
                if($form->isValid()){

                    $savePath = $this->get('kernel')->getRootDir().'/../web/uploads/';
                    //$User->save($savePath);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($User);
                    $em->flush();

                    $msgBody = $this->renderView('BrzozowskiIntelliHomeBundle:Email:registerEmail.html.twig', array(
                        'name' => $User->getFullName()
                    ));

                    $message = \Swift_Message::newInstance()
                        ->setSubject('Potwierdzenie rejestracji')
                        ->setFrom(array('brzozowski.test@gmail.com' => 'Edu Inwestor'))
                        ->setTo(array($User->getEmail() => $User->getFullName()))
                        ->setBody($msgBody, 'text/html');

                    $this->get('mailer')->send($message);

                    $Session->getFlashBag()->add('success', 'Twoje zgłoszenie zostało zapisane!');
                    //$this->get('blog_notification')->addSuccess("Twoje zgłoszenie zostało zapisane!");

                    $Session->set('registered', true);

                    return $this->redirect($this->generateUrl('intellihome_welcome'));
                }
                else
                {
                    $Session->getFlashBag()->add('danger', 'Popraw błędy formularza.');
                    //$this->get('blog_notification')->addError('Popraw błędy formularza.');
                }
            }
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        return array(
            'form' => isset($form) ? $form->createView() : NULL
        );
    }
    */

    /**
     * @Route(
     *     "/witamy",
     *     name="intellihome_welcome"
     * )
     *
     * @Template
     */
    /*
    public function welcomeAction()
    {

        return array();
    }
    */
}
