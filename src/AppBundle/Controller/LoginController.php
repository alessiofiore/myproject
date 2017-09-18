<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\ORMException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of LoginController
 *
 * @author nuno <alessiofiore@gmail.com>
 */
class LoginController extends Controller {
    
    /**
     * @Route("/login", name="login" )
     */
    public function loginAction(Request $request, LoggerInterface $logger) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($productId);

                return $this->redirect($this->generateUrl(
                    'show_user',
                    array('id' => $user->getId())
                ));
                
            } catch (ORMException $e) {
                $logger->error($e->getMessage());
                 
                return $this->render('user_private/userIndex.html.twig', array(
                            'message' => 'ORM Error',
                ));
            } catch(Exception $e) {
                $logger->error($e->getMessage());
                 
                return $this->render('default/error.html.twig', array(
                            'message' => 'Error',
                ));
            }
        }

        return $this->render('default/login.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
}
