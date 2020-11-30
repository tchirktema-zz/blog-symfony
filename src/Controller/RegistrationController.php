<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Security\Guard\WebAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Controller
 * @Route("/registration", name="registration")
 */
class RegistrationController extends AbstractController
{
    public function __invoke(
        Request $request,
        UserPasswordEncoderInterface $userPasswordEncoder,
        GuardAuthenticatorHandler $guardAuthenticatorHandler,
        WebAuthenticator $webAuthenticator
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user)->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $webAuthenticator,
                'main'
            );
        }

        return $this->render("ui/registration.html.twig", [
           "form" => $form->createView()
        ]);
    }
}
