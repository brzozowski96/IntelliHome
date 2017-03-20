<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Brzozowski\IntelliHomeBundle\BrzozowskiIntelliHomeBundle;
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
 *     "/user",
 *     name="intellihome_user_update"
 * )
 */
class UpdatePagesController extends Controller
{
    /**
     * @Route(
     *     "/panel/alerts",
     *     name="intellihome_alerts_update"
     * )
     * @Template
     * @param Request $request
     * @return Response
     */
    public function updateAlertsAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if($isAjax)
        {
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            {
                return new Response($this->renderView('BrzozowskiIntelliHomeBundle:UpdatePages:updateAlerts.html.twig'));
            }
        }

        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

}