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

        $history = $smsapi->getHistory();

        dump($history);
        die;

        return $this->render('history/list.html.twig', [
            'controller_name' => 'HistoryController',
            'history' => $history,
        ]);
    }
}
