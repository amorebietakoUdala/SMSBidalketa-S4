<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\HistorySearchDTO;

/**
 * @Route("/{_locale}")
 */
class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history_list")
     */
    public function listAction(\Symfony\Component\HttpFoundation\Request $request, \AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi $smsapi)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(\App\Form\HistorySearchType::class, new \App\DTO\HistorySearchDTO(), [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data HistorySearchDTO */
            $data = $form->getData();
            $criteria = $data->toArray();

            $histories = $em->getRepository(\App\Entity\History::class)->findByDates($criteria);

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
