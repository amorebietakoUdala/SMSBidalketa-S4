<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\DTO\SendByLabelDTO;
use App\Entity\Contact;
use App\Form\SendByLabelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AmorebietakoUdala\SMSServiceBundle\Controller\SmsSender;

/**
 * @Route("/{_locale}")
 */
class SenderController extends AbstractController
{
    /**
     * @Route("/sendby/labels/send", name="sendby_labels_send")
     */
    public function sendByLabelsSendAction(Request $request, SmsSender $sender)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $sendByLabelDTO = new SendByLabelDTO();

        $form = $this->createForm(SendByLabelType::class, $sendByLabelDTO, [
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data SendByLabelDTO */
            $data = $form->getData();
            $selected = json_decode($data->getSelected());
            $telephones = [];
            foreach ($selected as $jsonContact) {
                $contactDTO = new ContactDTO();
                $contactDTO->extractFromJson($jsonContact);
                $telephones[] = $contactDTO->getTelephone();
            }

            if (0 === count($telephones)) {
                $this->addFlash('error', 'No receivers found');

                return $this->render('sendby/list.html.twig', [
                    'form' => $form->createView(),
                    'contacts' => [],
                    'messages_sent' => null,
                    'credits_needed' => null,
                    'credits_remaining' => null,
                ]);
            }

            $credit = $sender->getCredit();

            if ($credit < count($telephones)) {
                $this->addFlash('error', 'Not enough credit. Needed credtis %credits_needed% remaining %credits_remaining%'
                );

                return $this->render('sendby/list.html.twig', [
                    'form' => $form->createView(),
                    'contacts' => [],
                    'credits_needed' => count($telephones),
                    'credits_remaining' => $credit,
                ]);
            }

            $sender->sendMessage($telephones, $data->getMessage(), $data->getDate());
            $this->addFlash('success', '%messages_sent% messages sended successfully');
            $form = $this->createForm(SendByLabelType::class, $sendByLabelDTO, []);

            return $this->render('sendby/list.html.twig', [
                'form' => $form->createView(),
                'contacts' => [],
                'messages_sent' => count($telephones),
                'credits_needed' => count($telephones),
                'credits_remaining' => $credit,
            ]);
        }

        return $this->redirectToRoute('sendby_labels_search');
    }

    /**
     * @Route("/sendby/labels", name="sendby_labels_search")
     */
    public function sendByLabelsAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $sendByLabelDTO = new SendByLabelDTO();

        $form = $this->createForm(SendByLabelType::class, $sendByLabelDTO, [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data ContactDTO */
            $data = $form->getData();
            if (count($data->getLabels()) > 0) {
                $contacts = $em->getRepository(Contact::class)->findByLabels($data->getLabels());
            } else {
                $contacts = $em->getRepository(Contact::class)->findAll();
            }

            return $this->render('sendby/list.html.twig', [
                'form' => $form->createView(),
                'contacts' => $contacts,
            ]);
        }

        return $this->render('sendby/list.html.twig', [
            'form' => $form->createView(),
            'readonly' => false,
            'new' => false,
        ]);
    }

    /**
     * @Route("/sendby/history", name="sendby_history")
     */
    public function historyAction(Request $request, SmsSender $sender)
    {
        $today = new \DateTime();
//        $today->setDate(2019, 01, 01);
//        dump($today->getTimestamp());
//        die;
        $history = $sender->getHistoryOpt(1546339280, 1560333394);
    }
}
