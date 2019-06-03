<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

/**
 * @Route("/{_locale}")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contacts/import", name="contact_import")
     */
    public function importAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contacts", name="contact_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository(Contact::class)->findAll();

        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/contact/new", name="contact_new")
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ContactType::class, new ContactDTO(), [
            'roles' => $user->getRoles(),
            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data ContactDTO */
            $data = $form->getData();
            $exists = $em->getRepository(\App\Entity\Contact::class)->findOneBy(['username' => $data->getUsername()]);
            if ($exists) {
                $this->addFlash('error', 'Duplicate contact');

                return $this->render('/contact/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $labels = $data->getLabels();
            $labels = $this->__removeLabelDuplicates($labels);
            $contact = new Contact();
            $data->fill($contact);
            $em->persist($contact);
            $em->flush();
            $this->addFlash(
                'success',
                'Contact saved'
            );

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(),
            'roles' => $user->getRoles(),
        ]);
    }

    /**
     * @Route("/contact/{contact}/edit", name="contact_edit")
     */
    public function editAction(Request $request, Contact $contact)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $contactDTO = new ContactDTO($contact);

        $form = $this->createForm(ContactType::class, $contactDTO, [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data ContactDTO */
            $data = $form->getData();
            $labels = $data->getLabels();
            $this->__removeCollectionDuplicates($labels, $this->__removeLabelDuplicates($labels));
            $data->fill($contact);
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Contact edited');

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView(),
            'readonly' => false,
            'new' => false,
        ]);
    }

    /**
     * @Route("/contact/{contact}", name="contact_show")
     */
    public function showAction(Request $request, Contact $contact)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $contactDTO = new ContactDTO($contact);

        $form = $this->createForm(ContactType::class, $contactDTO, [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView(),
            'readonly' => true,
            'new' => false,
        ]);
    }

    /**
     * @Route("/contact/{contact}/delete", name="contact_delete")
     */
    public function deleteAction(Request $request, contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        $this->addFlash('success', 'Contact deleted');

        return $this->redirectToRoute('contact_list');
    }

    /**
     * Return the labels array without duplicates.
     *
     * @var
     *
     * @return array $uniqueArray
     */
    private function __removeLabelDuplicates($labels)
    {
        $uniqueArray = [];
        foreach ($labels as $label) {
            if (!in_array($label->getName(), $uniqueArray)) {
                $uniqueArray[] = $label->getName();
            }
        }

        return $uniqueArray;
    }

    private function __removeCollectionDuplicates($labels, $uniques)
    {
        $em = $this->getDoctrine()->getManager();
        $labels->clear();
        foreach ($uniques as $unique) {
            $label = $em->getRepository(\App\Entity\Label::class)->findOneBy(['name' => $unique]);
            if (null === $label) {
                $label = new \App\Entity\Label();
                $label->setName($unique);
                $labels->add($label);
            } else {
                $labels->add($label);
            }
        }

        return $labels;
    }
}
