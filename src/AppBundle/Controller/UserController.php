<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of UserController
 *
 * @author nuno <alessiofiore@gmail.com>
 */
class UserController extends Controller {

    /**
     * @Route("/user/{id}", name="show_user", requirements={"page": "\d+"})
     */
    public function showUserAction($id) {

        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);

        return $this->render('user_private/userIndex.html.twig', array(
                    'message' => 'Show user ' . $id,
        ));
    }

}
