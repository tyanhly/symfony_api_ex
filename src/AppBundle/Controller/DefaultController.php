<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\Article;

use Doctrine\ORM\Query;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

    }

    /**
     * @Route("/get-all", name="test")
    */
    public function getAllAction(EntityManagerInterface $em)
    {
        $articles = $em->getRepository('AppBundle:Article')
            ->findAll();

        $json = $this->container->get('serializer')->serialize($articles, 'json');;

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
