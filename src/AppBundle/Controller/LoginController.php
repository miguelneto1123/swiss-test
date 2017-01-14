<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 14/01/17
 * Time: 16:00
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/", name="login")
     */
    public function loginAction(Request $request)
    {
        $cus = new Customer();

        $form = $this->createFormBuilder($cus)
            ->add('email',EmailType::class, array('label' => false))
            ->add('password', PasswordType::class, array('label' => false))
            ->add('save', SubmitType::class, array('label' => 'Log In'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cus = $form->getData();

            $search = $this->getDoctrine()->getRepository('AppBundle:Customer')->findOneByEmail($cus->getEmail());
            if (!$search){
                return $this->render('login/usernameNotRegistered.html.twig', array(
                    'form' => $form->createView()
                ));
            }
            else{
                if ($search->getPassword() != $cus->getPassword()){
                    return $this->render('login/wrongPassword.html.twig', array(
                        'form' => $form->createView()
                    ));
                }
                return $this->redirectToRoute('successlogin', array(
                    'username' => $search->getUsername()
                ));
            }

        }

        return $this->render('login/login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signupAction(Request $request)
    {
        $cus = new Customer();

        $form = $this->createFormBuilder($cus)
            ->add('username',TextType::class, array('label' => false))
            ->add('email',EmailType::class, array('label' => false))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array( 'label' => false),
                'second_options' => array( 'label' => false)))
            ->add('save', SubmitType::class, array('label' => 'Sign up'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cus = $form->getData();

            $search = $this->getDoctrine()->getRepository('AppBundle:Customer')->findOneByEmail($cus->getEmail());
            if (!$search) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cus);
                $em->flush();

                return $this->redirectToRoute("successsignup", array('name' => $cus->getUsername()));
            } else {
                return $this->render('signup/emailRegistered.html.twig', array(
                    'form' => $form->createView()
                ));
            }

        }
        return $this->render('signup/signup.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/signupsuccessful/{name}", name="successsignup")
     */
    public function successRegistrationAction($name)
    {
        return $this->render('success/successsignup.html.twig', array(
            'name' => $name
        ));
    }

    /**
     * @Route("/{username}", name="successlogin")
     */
    public function successfulLoginAction($username)
    {
        return $this->render('success/successlogin.html.twig', array(
            'name' => $username
        ));
    }

}