<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history_list")
     */
    public function listAction(\AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi $smsapi)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $histories = $em->getRepository(\App\Entity\History::class)->findBy([]);

        return $this->render('history/list.html.twig', [
            'histories' => $histories,
        ]);
    }
}
