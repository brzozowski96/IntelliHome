<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(
 *     "/",
 *     name="intellihome_index"
 * )
 */
class StartController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     name="intellihome_login"
     * )
     */
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('intellihome_panel'));
        }
        else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

}
