<?php
/**
 * Created by PhpStorm.
 * User: medlend
 * Date: 04/07/17
 * Time: 21:10
 */

namespace User\UserBundle\Listeners;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use User\UserBundle\Entity\Bonobo;

class LoginListener
{

    protected $userManager;
    protected $router;

    public function __construct(UserManagerInterface $userManager, Router $router)
    {
        $this->userManager = $userManager;
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        /**
         * @var Bonobo $user
         */
        $user = $event->getAuthenticationToken()->getUser();
        $request = $event->getRequest();

        if ($user->getProfile()->getFirstLogin())
            $request->request->set('_target_path', str_replace($request->getBaseUrl(), '', $this->router->generate('profile_new')));
        else
            $request->request->set('_target_path', str_replace($request->getBaseUrl(), '', $this->router->generate('profile_show', array('id' => $user->getProfile()->getId()))));
    }

    public function register(FormEvent $event)
    {

        $url = $this->router->generate('profile_new');
        $response = new RedirectResponse($url);
        $event->setResponse($response);

    }


}