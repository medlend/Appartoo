<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View as RestView;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Twig\Profiler\Profile;
use User\UserBundle\Entity\Bonobo; // alias for all annotations

class DefaultController extends FOSRestController
{
    /**
     * @Route("/api/profile", name="api_profile_index", options={ "method_prefix" = false })
     */
    public function getindexAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profile = $user->getProfile();

        $friends = array();
        foreach ($user->getMyFriends() as $freind)
            $friends[] = ['id' => $freind->getId(), 'user_name' => $freind->getUsername()];

        $data = [
            'id_profile' => $profile->getId(),
            'age' => $profile->getAge(),
            'famille' => $profile->getFamille(),
            'race' => $profile->getRace(),
            'user_name' => $user->getUsername(),
            'friends' => $friends,
        ];
        return $this->handleView(RestView::create($data, 200));
    }


    /**
     * @Route("/api/find_friends", name="api_recherche_friends", options={ "method_prefix" = false })
     */
    public function postSearchAction(Request $request)
    {

        $key = ($request->request->has('key') ? $request->request->get('key') : '');

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $friends[0] = ['id' => $user->getId(), 'user_name' => $user->getUsername()];
        foreach ($user->getMyFriends() as $freind)
            $friends[] = ['id' => $freind->getId(), 'user_name' => $freind->getUsername()];

        $rslts = $this->get('doctrine.orm.entity_manager')->getRepository(Bonobo::class)
            ->createQueryBuilder('b')
            ->where('b.username LIKE :username')
            ->setParameter('username', '%' . $key . '%')
            ->getQuery()
            ->getResult();

        $users = [];
        foreach ($rslts as $rslt) {
            foreach ($friends as $friend)
                if ($rslt->getId() == $friend['id'])
                    continue 2;

            $users[] = ['id' => $rslt->getId(), 'user_name' => $rslt->getUsername()];
        }

        return $this->handleView(RestView::create($users, 200));

    }

    /**
     * @Route("/api/add_friend", name="api_add_friends", options={ "method_prefix" = false })
     */
    public function postAddAction(Request $request)
    {

        $id = ($request->request->has('id') ? $request->request->get('id') : null);

        if (!is_null($id)) {
            $em = $this->getDoctrine()->getManager();

            $bonobo = $this->get('security.token_storage')->getToken()->getUser();
            $bonobo_amie = $em->find(Bonobo::class, $id);

            $bonobo->addMyFriend($bonobo_amie);
            $bonobo_amie->addMyFriend($bonobo);
            $em->flush();


            $friends = array();
            foreach ($bonobo->getMyFriends() as $freind)
                $friends[] = ['id' => $freind->getId(), 'user_name' => $freind->getUsername()];

            return $this->handleView(RestView::create($friends, 200));
        }

        return $this->handleView(RestView::create('id non trouvé ', 503));
    }

    /**
     * @Route("/api/remove_friend", name="api_remove_friends", options={ "method_prefix" = false })
     */
    public function postRemoveAction(Request $request)
    {

        $id = ($request->request->has('id') ? $request->request->get('id') : null);

        if (!is_null($id)) {
            $em = $this->getDoctrine()->getManager();

            $bonobo = $this->get('security.token_storage')->getToken()->getUser();
            $bonobo_amie = $em->find(Bonobo::class, $id);

            $bonobo->removeMyFriend($bonobo_amie);
            $bonobo_amie->removeMyFriend($bonobo);
            $em->flush();

            $friends = array();
            foreach ($bonobo->getMyFriends() as $freind)
                $friends[] = ['id' => $freind->getId(), 'user_name' => $freind->getUsername()];

            return $this->handleView(RestView::create($friends, 200));
        }

        return $this->handleView(RestView::create('id non trouvé ', 503));
    }


}
