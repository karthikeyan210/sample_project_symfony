<?php 

// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    /**
     *  @Route("/lucky/hello/{name}", name="lucky_hello")
     */
    public function helloAction($name)
    {
        $number = "Hello " . ucfirst($name);
        // return $this->render('lucky/number.html.twig', array(
        //     'number' => $number,
        // ));
        // $number = $this->json(array('username' => $name));
        // return $this->redirectToRoute('lucky_number');

        return new Response(
            '<html><body>'.$number.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/number/{max}", name="lucky_number", requirements={"max": "\d+"})
     */
    public function numberAction($max = 10)
    {
        $number = mt_rand(0, $max);
        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
        return new Response(
            '<html><body>'.$number.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/parameter/{max}")
     */
    public function parameterAction($max)
    {
        $number = mt_rand(0, $max);

        return new Response(
            '<html><body>'.$number.'</body></html>'
        );
    }
}