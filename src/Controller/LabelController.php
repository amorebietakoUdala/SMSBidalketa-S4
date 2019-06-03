<?php

namespace App\Controller;

use App\Entity\Label;
use App\Form\LabelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class LabelController extends AbstractController
{
    /**
     * @Route("/labels", name="label_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $labels = $em->getRepository(Label::class)->findAll();

        return $this->render('label/list.html.twig', [
            'labels' => $labels,
        ]);
    }

    /**
     * @Route("/label/new", name="label_new")
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(LabelType::class, new Label(), [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data Label */
            $data = $form->getData();
            $exists = $em->getRepository(Label::class)->findOneBy(['name' => $data->getName()]);
            if ($exists) {
                $this->addFlash('error', 'Duplicate label');

                return $this->render('/label/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'label saved');
        }

        return $this->render('label/new.html.twig', [
            'form' => $form->createView(),
            'roles' => $user->getRoles(),
        ]);
    }

    /**
     * @Route("/label/{label}", name="label_show")
     */
    public function showAction(Request $request, Label $label)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(LabelType::class, $label, [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        return $this->render('label/edit.html.twig', [
            'form' => $form->createView(),
            'readonly' => true,
            'new' => false,
        ]);
    }

    /**
     * @Route("/label/{label}/edit", name="label_edit")
     */
    public function editAction(Request $request, Label $label)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(LabelType::class, $label, [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data Label */
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            return $this->redirectToRoute('label_list');
        }

        return $this->render('label/edit.html.twig', [
            'form' => $form->createView(),
            'readonly' => false,
            'new' => false,
        ]);
    }

    /**
     * @Route("/label/{label}/delete", name="label_delete")
     */
    public function deleteAction(Request $request, Label $label)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($label);
        $em->flush();

        return $this->redirectToRoute('label_list');
    }
}
