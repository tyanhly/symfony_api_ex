<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Article;


class ArticleController extends FOSRestController
{

    /**
     * @Rest\Get("/article")
     */
    public function getAllAction()
    {
        $restResult = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();
        if ($restResult === null || count($restResult) ==0 ) {
            return new View("there are no articles exist", Response::HTTP_NOT_FOUND);
        }
        return $restResult;
    }

    /**
     * @Rest\Get("/article/{id}")
     */
    public function getAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        if ($singleresult === null) {
            return new View("article not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }


    /**
     * @Rest\Post("/article")
     */
    public function postAction(Request $request)
    {
        $data = new Article;
        $title = $request->get('title');
        $content = $request->get('content');
        if (empty($title) || empty($content)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setTitle($title);
        $data->setContent($content);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Article Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/article/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $data = new Article;
        $title = $request->get('title');
        $content = $request->get('content');
        $sn = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        if (empty($article)) {
            return new View("article not found", Response::HTTP_NOT_FOUND);
        } elseif (!empty($title) && !empty($content)) {
            $article->setTitle($title);
            $article->setContent($content);
            $sn->flush();
            return new View("Article Updated Successfully", Response::HTTP_OK);
        } elseif (empty($title) && !empty($content)) {
            $article->setContent($content);
            $sn->flush();
            return new View("Article Content Updated Successfully", Response::HTTP_OK);
        } elseif (!empty($title) && empty($content)) {
            $article->setTitle($title);
            $sn->flush();
            return new View("Article Title Updated Successfully", Response::HTTP_OK);
        } else {
            return new View("Article Title or Content cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @Rest\Delete("/article/{id}")
     */
    public function deleteAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        if (empty($article)) {
            return new View("article not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($article);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

}
