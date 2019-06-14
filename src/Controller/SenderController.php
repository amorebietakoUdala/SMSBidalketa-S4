<?php

namespace App\Controller;

use AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi;
use App\DTO\ContactDTO;
use App\DTO\SendByLabelDTO;
use App\Entity\Audit;
use App\Entity\Contact;
use App\Form\SendByLabelType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class SenderController extends AbstractController
{
    /**
     * @Route("/sendby/labels/send", name="sendby_labels_send")
     */
    public function sendByLabelsSendAction(Request $request, SmsApi $smsapi)
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
            $ids = [];
            foreach ($selected as $jsonContact) {
                $contactDTO = new ContactDTO();
                $contactDTO->extractFromJson($jsonContact);
                $telephones[] = $contactDTO->getTelephone();
                $ids[] = $contactDTO->getId();
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

            $credit = $smsapi->getCredit();

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

            $response = $smsapi->sendMessage($telephones, $data->getMessage(), $data->getDate());
            $this->addFlash('success', '%messages_sent% messages sended successfully');
            $audit = new Audit();
            $contacts = [];
            foreach ($ids as $id) {
                $contacts[] = $em->getRepository(Contact::class)->find($id);
            }
            $audit->setContacts(new ArrayCollection($contacts));
            $audit->setTimestamp(new \DateTime());
            $audit->setStatus($response->{'message'});
            $audit->setResponse(json_encode($response));
            $audit->setUser($user);
            $em->persist($audit);
            $em->flush();
            $form = $this->createForm(SendByLabelType::class, new sendByLabelDTO(), []);

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
}
