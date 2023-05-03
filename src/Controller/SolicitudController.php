<?php

namespace App\Controller;

use App\Entity\Solicitud;
use App\Form\SolicitudType;
use App\Repository\SolicitudRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * @Route("/solicitud")
 */
class SolicitudController extends AbstractController
{
    /**
     * @Route("/", name="app_solicitud_index", methods={"GET"})
     */
    public function index(SolicitudRepository $solicitudRepository): Response
    {
        return $this->render('solicitud/index.html.twig', [
            'solicituds' => $solicitudRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/pdf", name="app_solicitud_pdf", methods={"GET"})
     */
    public function pdfAction(Solicitud $solicitud, SolicitudRepository $solicitudRepository, \Knp\Snappy\Pdf $knpSnappy)
    {
        $this->knpSnappy = $knpSnappy;

        $html = $this->renderView('solicitud/show_pdf.html.twig', [
            'solicitud' => $solicitud,
        ]);

        $filename = sprintf('SolicitudRecursos-'.$solicitud->getFecha()->format('d/m/Y').'.pdf');
        $knpSnappy->setOption('enable-local-file-access', true);

        $pdfOptions = array(
            'footer-right'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
        );
        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),

            ]
        );


    }
    /**
     * @Route("/new", name="app_solicitud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SolicitudRepository $solicitudRepository): Response
    {
        $solicitud = new Solicitud();
        $form = $this->createForm(SolicitudType::class, $solicitud);
        $form->remove('fecha');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /*$importe = $form->get('importe')->getData();

            $solicitud->setImporte($importe);*/

            $solicitud->setFecha(new \DateTime());
            $solicitudRepository->add($solicitud, true);


//            return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_solicitud_show', [
                'solicitud' => $solicitud,
                'slug' => $solicitud->getSlug(),
            ]);
        }

        return $this->renderForm('solicitud/new.html.twig', [
            'solicitud' => $solicitud,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}", name="app_solicitud_show", methods={"GET"})
     */
    public function show(Solicitud $solicitud): Response
    {
        return $this->render('solicitud/show.html.twig', [
            'solicitud' => $solicitud,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="app_solicitud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Solicitud $solicitud, SolicitudRepository $solicitudRepository): Response
    {
        $form = $this->createForm(SolicitudType::class, $solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $solicitudRepository->add($solicitud, true);

            return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('solicitud/edit.html.twig', [
            'solicitud' => $solicitud,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_solicitud_delete", methods={"POST"})
     */
    public function delete(Request $request, Solicitud $solicitud, SolicitudRepository $solicitudRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$solicitud->getId(), $request->request->get('_token'))) {
            $solicitudRepository->remove($solicitud, true);
        }

        return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
    }
}
