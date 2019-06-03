<?php

namespace App\Controller\Api;

use App\Entity\Label;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
 * @Route("/api")
 */
class RestApiController extends AbstractFOSRestController
{
    /**
     * Retrieves an Labels resource.
     *
     * @Rest\Get("/labels")
     * @QueryParam(name="name", description="The pattern of the Label to lookup")
     */
    public function getLabels(ParamFetcher $paramFetcher): View
    {
        $query = $paramFetcher->get('name');
        $repo = $this->getDoctrine()->getRepository(Label::class);
        $labels = $repo->findLabelsThatContain($query);

        return View::create(['labels' => $labels], Response::HTTP_OK);
    }
}
