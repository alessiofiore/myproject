<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterController
 *
 * @author ealesfi
 */
class RegisterController extends Controller {

    /**
     * @Route("/register", name="register" )
     */
    public function registerAction(Request $request, LoggerInterface $logger, UserPasswordEncoderInterface $passwordEncoder) {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl(
                    'show_user',
                    array('id' => $user->getId())
                ));
                
            } catch (ORMException $e) {
                $logger->error($e->getMessage());
                 
                return $this->render('user_private/userIndex.html.twig', array(
                            'message' => 'ORM Error',
                ));
            } catch(\Exception $e) {
                $logger->error($e->getMessage());
                 
                return $this->render('default/error.html.twig', array(
                            'message' => 'Error',
                ));
            }
        }

        return $this->render('test/register.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
