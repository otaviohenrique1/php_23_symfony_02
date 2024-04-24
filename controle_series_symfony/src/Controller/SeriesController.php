<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeriesController extends AbstractController
{
    public function __construct(
        private SeriesRepository $seriesRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    // public function index(Request $request): Response
    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function seriesList(): Response
    {
        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList
        ]);
    }

    #[Route('/series/create', name: 'app_series_form', methods: ['GET'])]
    public function addSeriesForm(): Response
    {
        return $this->render('series/form.html.twig');
    }

    #[Route('/series/create', name: 'app_add_series', methods: ['POST'])]
    public function addSeries(Request $request): Response
    {
        $seriesName = $request->request->get(key: 'name');
        $series = new Series($seriesName);
        $this->seriesRepository->add($series, flush: true);
        return new RedirectResponse(url: '/series');
    }

    // public function deleteSeries(Request $request): Response
    #[Route('/series/delete/{id}', name: 'app_delete_series', methods: ['DELETE'])]
    public function deleteSeries(int $id): Response
    {
        // $id = $request->attributes->get(key:'id');
        // $series = $this->entityManager->getReference(Series::class, $id);
        // $this->seriesRepository->remove($series, flush: true);
        $this->seriesRepository->removeById($id);
        return new RedirectResponse(url: '/series');
    }
}
