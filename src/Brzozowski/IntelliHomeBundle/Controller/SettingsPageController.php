<?php

namespace Brzozowski\IntelliHomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(
 *     "/user/ustawienia/ustaw",
 *     name="intellihome_index"
 * )
 */
class SettingsPageController extends Controller
{
    /**
     * @Route(
     *     "/pamiec/{alarmNumber}/{sirenTime}/{blindsTime}",
     *     name="intellihome_settings_setMemory"
     * )
     */
    public function setMemoryAction()
    {
        $Session = $this->get('session');

        $Session->getFlashBag()->add('success', 'Ustawienia zostały zmienione!');
        $Session->getFlashBag()->add('info', 'Wiadomość została wysłana!');
        $Session->getFlashBag()->add('danger', 'Błąd bazy danych. Skontaktuj się z administratorem!');
        $Session->getFlashBag()->add('danger', 'Podałeś nieprawidłowe hasło!');
        $Session->getFlashBag()->add('success', 'Hasło zostało pomyślnie zmienione!');


        return $this->redirect($this->generateUrl('intellihome_settings'));
    }

}
