<?php

namespace App\Controller;

use AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi;
use App\DTO\ContactDTO;
use App\DTO\SendingDTO;
use App\Entity\Audit;
use App\Entity\Contact;
use App\Form\SendingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class SendingController extends AbstractController
{
    /**
     * @Route("/sending/send", name="sending_send")
     */
    public function sendingSendAction(Request $request, SmsApi $smsapi)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $sendingDTO = new SendingDTO();
        $form = $this->createForm(SendingType::class, $sendingDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data SendingDTO */
            $data = $form->getData();
            $selected = json_decode($data->getSelected());
            $telephones = [];
            $ids = [];
            foreach ($selected as $jsonContact) {
                $contactDTO = new ContactDTO();
                $contactDTO->extractFromJson($jsonContact);
                $telephones[] = $contactDTO->getTelephone();
                $ids[] = $contactDTO->getId();
            }

            if (0 === count($telephones)) {
                $this->addFlash('error', 'No receivers found');

                return $this->render('sending/list.html.twig', [
                    'form' => $form->createView(),
                    'contacts' => [],
                    'messages_sent' => null,
                    'credits_needed' => null,
                    'credits_remaining' => null,
                ]);
            }

            $credit = $smsapi->getCredit();

            if ($credit < count($telephones)) {
                $this->addFlash('error', 'Not enough credit. Needed credtis %credits_needed% remaining %credits_remaining%'
                );

                return $this->render('sending/list.html.twig', [
                    'form' => $form->createView(),
                    'contacts' => [],
                    'credits_needed' => count($telephones),
                    'credits_remaining' => $credit,
                ]);
            }

            $response = $smsapi->sendMessage($telephones, $data->getMessage(), $data->getDate());
            $this->addFlash('success', '%messages_sent% messages sended successfully');
            $contacts = [];
            foreach ($ids as $id) {
                $contacts[] = $em->getRepository(Contact::class)->find($id);
            }
            $audit = Audit::createAudit($contacts, $response->{'responseCode'}, $response->{'message'}, $response, $user);
            $em->persist($audit);
            $em->flush();
            $form = $this->createForm(SendingType::class, new SendingDTO(), []);

            return $this->render('sending/list.html.twig', [
                'form' => $form->createView(),
                'contacts' => [],
                'messages_sent' => count($telephones),
                'credits_needed' => count($telephones),
                'credits_remaining' => $credit,
            ]);
        }

        return $this->redirectToRoute('sending_search');
    }

    /**
     * @Route("/sending", name="sending_search")
     */
    public function sendSearchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SendingType::class, new SendingDTO());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data ContactDTO */
            $data = $form->getData();
            if (count($data->getLabels()) > 0) {
                $contacts = $em->getRepository(Contact::class)->findByLabels($data->getLabels());
            } else {
                $contacts = $em->getRepository(Contact::class)->findAll();
            }

            return $this->render('sending/list.html.twig', [
                'form' => $form->createView(),
                'contacts' => $contacts,
            ]);
        }

        return $this->render('sending/list.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
