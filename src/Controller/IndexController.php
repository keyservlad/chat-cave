<?php

namespace App\Controller;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $email = $this->getUser()->getEmail();
        $token = (new Builder())
            ->withClaim('mercure', ['subscribe' => [sprintf("/%s", $email)]])
            ->getToken(
                new Sha256(),
                new Key($this->getParameter('mercure_secret_key'))
            )
        ;

        $response =  $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);

        $response->headers->setCookie(
            Cookie::create(
                'mercureAuthorization',
                $token,
                (new \DateTime())
                ->add(new \DateInterval('PT2H')),
                '/.well-known/mercure'
            )
        );


        return $response;
    }
}
