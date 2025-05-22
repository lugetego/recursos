<?php

namespace App\Controller;

use App\Entity\Solicitud;
use App\Form\SolicitudType;
use App\Form\ValidacionType;
use App\Repository\SolicitudRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
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
            'solicituds' => $solicitudRepository->findAll(
                ["id" => "DESC"]
            ),
        ]);
    }

    /**
     * @Route("/{id}/pdf", name="app_solicitud_pdf", methods={"GET"})
     */
    public function pdfAction(Solicitud $solicitud, SolicitudRepository $solicitudRepository, \Knp\Snappy\Pdf $knpSnappy, \Swift_Mailer $mailer)
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

       /* // Mail
        $message = (new \Swift_Message('Solicitud de recursos - Prácticas escolares'))
            ->setFrom('webmaster@matmor.unam.mx')
            ->setTo('vorozco@matmor.unam.mx')
            ->setBcc(array('gerardo@matmor.unam.mx'))
            ->setBody($this->renderView('mail/nueva.txt.twig', array('solicitud' => $solicitud)));

        $mailer->send($message);

        $solicitud->setImpresa(true);
        $solicitudRepository->add($solicitud, true);*/

        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s"', $filename),
            ]

        );
    }

    /**
     * @Route("/{id}/recibo", name="app_solicitud_recibo", methods={"GET"})
     */
    public function reciboAction(Solicitud $solicitud, SolicitudRepository $solicitudRepository, \Knp\Snappy\Pdf $knpSnappy, \Swift_Mailer $mailer)
    {
        $this->knpSnappy = $knpSnappy;

        $textoImporte = $this->numeroATextoMX($solicitud->getImporte());


        $html = $this->renderView('solicitud/recibo_pdf.html.twig', [
            'solicitud' => $solicitud,
            'textoImporte'=>$textoImporte,
        ]);

        $filename = sprintf('SolicitudRecursos-'.$solicitud->getFecha()->format('d/m/Y').'.pdf');
        $knpSnappy->setOption('enable-local-file-access', true);

        $pdfOptions = array(
            'footer-right'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,
            'margin-top'    => 10,
            'margin-right'  => 20,
            'margin-bottom' => 10,
            'margin-left'   => 20,
        );

        /* // Mail
         $message = (new \Swift_Message('Solicitud de recursos - Prácticas escolares'))
             ->setFrom('webmaster@matmor.unam.mx')
             ->setTo('vorozco@matmor.unam.mx')
             ->setBcc(array('gerardo@matmor.unam.mx'))
             ->setBody($this->renderView('mail/nueva.txt.twig', array('solicitud' => $solicitud)));

         $mailer->send($message);

         $solicitud->setImpresa(true);
         $solicitudRepository->add($solicitud, true);*/

        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s"', $filename),
            ]

        );
    }


    /**
     * @Route("/new", name="app_solicitud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SolicitudRepository $solicitudRepository, \Swift_Mailer $mailer): Response
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

            // Mail
            $message = (new \Swift_Message('Solicitud de recursos - Prácticas escolares'))
                ->setFrom('webmaster@matmor.unam.mx')
                ->setTo(array($solicitud->getMail()))
                ->setCc('vorozco@matmor.unam.mx')
                ->setBcc(array('gerardo@matmor.unam.mx'))
                ->setBody($this->renderView('mail/nueva.txt.twig', array('solicitud' => $solicitud)));

            $mailer->send($message);

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
        $form->remove('fecha');

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $solicitud->setFecha(new \DateTime());

            $solicitudRepository->add($solicitud, true);

           // return $this->redirectToRoute('app_solicitud_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_solicitud_show', [
                'solicitud' => $solicitud,
                'slug' => $solicitud->getSlug(),
            ]);
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

    /**
     * @Route("/{slug}/validacion", name="app_solicitud_validacion", methods={"GET", "POST"})
     */
    public function validacion(Request $request, Solicitud $solicitud, EntityManagerInterface $entityManager,  \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ValidacionType::class, $solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($solicitud);
            $entityManager->flush();

            if ($solicitud->getValidada() == '1' ) {

                // Mail
                $message = (new \Swift_Message('Solicitud de recursos - Prácticas escolares'))
                    ->setFrom('webmaster@matmor.unam.mx')
                    ->setTo(array($solicitud->getMail()))
                    //->setCc('vorozco@matmor.unam.mx')
                    ->setBcc(array('gerardo@matmor.unam.mx'))
                    ->setBody($this->renderView('mail/validada.txt.twig', array('solicitud' => $solicitud)));

                $mailer->send($message);
            }



            return $this->redirectToRoute('app_solicitud_show', ['slug'=>$solicitud->getSlug()], Response::HTTP_SEE_OTHER);

        }
        $template = $request->isXmlHttpRequest() ? '_valida.html.twig' : 'show.html.twig';


        return $this->renderForm('solicitud/'.$template, [
            'solicitud' => $solicitud,
            'form' => $form,
        ]);
    }

    // Function to convert number to text (Spanish MX)
    private function numeroATextoMX(float $numero): string
    {
        $unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
        $decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
        $diez_a_diecinueve = ["diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];
        $veinti = "veinti";
        $centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];

        $convertirGrupo = function (int $n) use (&$unidades, &$decenas, &$diez_a_diecinueve, &$veinti, &$centenas) {
            $output = "";

            $c = (int)($n / 100);
            $d = (int)(($n % 100) / 10);
            $u = $n % 10;

            if ($n === 100) return "cien";

            if ($c > 0) $output .= $centenas[$c] . " ";

            if ($d === 1) {
                $output .= $diez_a_diecinueve[$u] . " ";
            } elseif ($d === 2 && $u !== 0) {
                $output .= $veinti . $unidades[$u] . " ";
            } else {
                if ($d > 0) $output .= $decenas[$d] . ($u > 0 ? " y " : " ");
                if ($u > 0 || ($c === 0 && $d === 0)) $output .= $unidades[$u] . " ";
            }

            return trim($output);
        };

        $entero = floor($numero);
        $decimales = round(($numero - $entero) * 100);

        if ($entero === 0) {
            $texto = "cero";
        } else {
            $millones = (int)($entero / 1000000);
            $miles = (int)(($entero % 1000000) / 1000);
            $cientos = (int)($entero % 1000);

            $texto = "";

            if ($millones === 1) {
                $texto .= "un millón ";
            } elseif ($millones > 1) {
                $texto .= $convertirGrupo($millones) . " millones ";
            }

            if ($miles === 1) {
                $texto .= "mil ";
            } elseif ($miles > 1) {
                $texto .= $convertirGrupo($miles) . " mil ";
            }

            if ($cientos > 0) {
                $texto .= $convertirGrupo($cientos);
            }
        }

        return trim($texto) . " pesos " . str_pad($decimales, 2, "0", STR_PAD_LEFT) . "/100 M.N.";
    }


}
