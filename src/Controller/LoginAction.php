<?php

namespace App\Controller;

use App\Form\Type\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class LoginAction
{
    private $templating;
    private $formFactory;

    public function __construct(Environment $templating, FormFactoryInterface $formFactory)
    {
        $this->templating = $templating;
        $this->formFactory = $formFactory;
    }
    /**
     *@Route("/login", name="login")
     */
    public function __invoke(AuthenticationUtils $authenticationUtils)
    {
        $form = $this->formFactory->create(LoginType::class);
        $form->get('_username')->setData($authenticationUtils->getLastUsername());

        return new Response($this->templating->render('Security/login.html.twig', [
            'error'=> $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView()
        ]));
    }
}