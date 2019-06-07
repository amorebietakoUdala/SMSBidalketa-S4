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
                ]);
            }
            
            $credit = $sender->getCredit();

            if ($credit < count($telephones) ) {
                $this->addFlash('error', 'Not enough credit');

                return $this->render('sendby/list.html.twig', [
                    'form' => $form->createView(),
                    'contacts' => [],
                ]);
            }

//            $sender->sendMessage($telephones, $data->getMessage());
            $this->addFlash('success', 'Messages sended successfully');
            
            return $this->render('sendby/list.html.twig', [
                'form' => $form->createView(),
                'contacts' => [],
            ]);
        }
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
            $contacts = $em->getRepository(Contact::class)->findByLabels($data->getLabels());

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
}
