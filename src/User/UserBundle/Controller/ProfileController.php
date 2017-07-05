<?php

namespace User\UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use User\UserBundle\Entity\Bonobo;
use User\UserBundle\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profile controller.
 *
 * @Route("profile")
 */
class ProfileController extends Controller
{
    /**
     * Lists all profile entities.
     *
     * @Route("/", name="profile_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $profiles = $em->getRepository('UserBundle:Profile')->findAll();

        return $this->render('profile/index.html.twig', array(
            'profiles' => $profiles,
        ));
    }

    /**
     * Creates a new profile entity.
     *
     * @Route("/new", name="profile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bonobo = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('User\UserBundle\Form\ProfileType', $bonobo->getProfile());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bonobo->getProfile()->setFirstLogin(false);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_show', array('id' => $bonobo->getProfile()->getId()));
        }

        return $this->render('profile/new.html.twig', array(
            'profile' => $bonobo->getProfile(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a profile entity.
     *
     * @Route("/{id}", name="profile_show")
     * @Method("GET")
     */
    public function showAction(Profile $profile)
    {
        $bonobos = $this->get('fos_user.user_manager')->findUsers();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $friends[0] = $user;
        foreach ($user->getMyFriends() as $freind){
            $friends[] = $freind;
        }

        foreach ($bonobos as $key => $valeur)
            if (in_array($valeur, $friends))
                unset($bonobos[$key]);
        unset($friends[0]);
        return $this->render('profile/show.html.twig', array(
            'profile' => $profile,
            'bonobos' => $bonobos,
            'bonobosAmies'=> $friends,
        ));
    }


    /**
     * Lists all profile entities.
     *
     * @Route("/add_amie", name="ajax_add_amie")
     * @Method("POST")
     */
    public function addAmieAction(Request $request)
    {

        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $bonobo = $this->get('security.token_storage')->getToken()->getUser();
            $bonobo_amie = $em->find(Bonobo::class, $request->request->get('data'));

            $bonobo->addMyFriend($bonobo_amie);
//            $em->flush();
            $bonobo_amie->addMyFriend($bonobo);
            $em->flush();

            return new JsonResponse(array('data' => json_encode("sucess")));

        }

        return new Response("Erreur", 400);

    }

    /**
     * Lists all profile entities.
     *
     * @Route("/remove_amie", name="ajax_remove_amie")
     * @Method("POST")
     */
    public function removeAmieAction(Request $request)
    {

        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $bonobo = $this->get('security.token_storage')->getToken()->getUser();
            $bonobo_amie = $em->find(Bonobo::class, $request->request->get('data'));

            $bonobo->removeMyFriend($bonobo_amie);
            $bonobo_amie->removeMyFriend($bonobo);

            $em->flush();

            return new JsonResponse(array('data' => json_encode("sucess")));

        }

        return new Response("Erreur", 400);

    }


}
