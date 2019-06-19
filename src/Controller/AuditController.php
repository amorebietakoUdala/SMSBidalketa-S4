<?php

namespace App\Controller;

use AmorebietakoUdala\SMSServiceBundle\Controller\SmsApi;
use App\DTO\AuditSearchDTO;
use App\Entity\Audit;
use App\Form\AuditSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/{_locale}")
 */
class AuditController extends AbstractController
{
    /**
     * @Route("/audit", name="audit_list")
     */
    public function listAction(Request $request, SmsApi $smsapi, AuthorizationCheckerInterface $authChecker)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AuditSearchType::class, new AuditSearchDTO(), [
//            'roles' => $user->getRoles(),
//            'locale' => $request->getLocale(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $data AuditSearchDTO */
            $data = $form->getData();
            $criteria = $data->toArray();

            if (!$authChecker->isGranted('ROLE_ADMIN')) {
                $criteria['user'] = $user;
            }
            $audits = $em->getRepository(Audit::class)->findByTimestamp($criteria);

            return $this->render('audit/list.html.twig', [
                'audits' => $audits,
                'form' => $form->createView(),
            ]);
        }

        $audits = $em->getRepository(Audit::class)->findBy([]);

        return $this->render('audit/list.html.twig', [
            'audits' => $audits,
            'form' => $form->createView(),
        ]);
    }
}
