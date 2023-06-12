<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search', methods: ['POST', 'GET'])]
    public function search(
        Request $request,
        CarRepository $carRepository)
    {
        $searchForm = $this->createForm(SearchFormType::class);
        $searchForm->handleRequest($request);

        $currentPage = $request->get('page', 1);
        $limit = $request->get('limit', 20);
        
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchData = $searchForm->getData();
            $carList = $carRepository->searchCarByNameWithPagination($currentPage, $limit, $searchData);
            $carNumber = $carRepository->countCarsMatchedByName($searchData);
            $totalPages = ceil($carNumber / $limit);
        }

        if ($request->get('data')) {
            $searchData = $request->get('data');
            $carList = $carRepository->searchCarByNameWithPagination($currentPage, $limit, $searchData);
            $carNumber = $carRepository->countCarsMatchedByName($searchData);
            $totalPages = ceil($carNumber / $limit);

            return $this->render('car/index.html.twig', [
                'searchData' => $request->get('data'),
                'searchForm' => $searchForm->createView(),
                'carsPaginated' => $carList,
                'currentPage' => $currentPage,
                'limit' => $limit,
                'totalPages' => $totalPages,
            ]);
        }

        return $this->render('car/index.html.twig', [
            'searchData' => $searchForm->getData(),
            'searchForm' => $searchForm->createView(),
            'carsPaginated' => $carList,
            'currentPage' => $currentPage,
            'limit' => $limit,
            'totalPages' => $totalPages,
        ]);
    }
}
