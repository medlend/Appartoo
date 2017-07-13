<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View as RestView;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest; // alias for all annotations

class DefaultController extends FOSRestController
{
    /**
     * @Route("/api/profile", name="api_profile_show", options={ "method_prefix" = false })
     */
    public function getindexAction(Request $request)
    {

//        $view = $this->view('tsss', 200)
//            ->setTemplate("MyBundle:Users:getUsers.html.twig")
//            ->setTemplateVar('users');
//
//        return $this->handleView($view);
//
//
//////        $view = View::create('data',200);
//////        $handler = $this->get('fos_rest.view_handler');
////
////
//////        dump($this->get('security.token_storage')->getToken()->getUser());die;
//////        die('aaa');
//////        return $this->handleView($view);
//       $view = $this->view('data',200);
//        dump($view);die;
        return $this->handleView(RestView::create([1=>'aa',2=>'gg'], 200));

    }
}
