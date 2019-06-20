<?php

namespace App\Controller;

use AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi;
use App\DTO\HistorySearchDTO;
use App\Entity\History;
use App\Form\HistorySearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history_list")
     */
    public function listAction(Request $request, SmsApi $smsapi)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(HistorySearchType::class, new HistorySearchDTO());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data HistorySearchDTO */
            $data = $form->getData();
            $criteria = $data->toArray();
            $histories = $em->getRepository(History::class)->findByDates($criteria);

            return $this->render('history/list.html.twig', [
                'histories' => $histories,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('history/list.html.twig', [
            'histories' => [],
            'form' => $form->createView(),
        ]);
    }
}
