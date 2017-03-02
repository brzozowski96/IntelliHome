<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Brzozowski\IntelliHomeBundle\Form\RegisterType;
use Brzozowski\IntelliHomeBundle\Form\LoginType;
use Brzozowski\IntelliHomeBundle\Entity\User;
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
