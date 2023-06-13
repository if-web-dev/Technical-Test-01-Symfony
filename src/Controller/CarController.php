<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Model\SearchData;
use App\Form\SearchFormType;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CarController extends AbstractController
{
    #[Route('/', name: 'app_car_index', methods: ['GET'])]
    public function index(
        CarRepository $carRepository,
        Request $request
    ): Response {
        $data = new SearchData();
        $data->page = $request->get('page', 1);

        $searchForm = $this->createForm(SearchFormType::class, $data);
        $searchForm->handleRequest($request);
        $cars = $carRepository->findSearch($data);

        return $this->render('car/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'cars' => $cars,
        ]);
    }

    #[Route('/car', name: 'app_car_all', methods: ['GET'])]
    public function all(CarRepository $carRepository): Response
    {
        return $this->render('car/all.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    #[Route('/car/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        CarRepository $carRepository
    ): Response {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/car/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Car $car,
        CarRepository $carRepository
    ): Response {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Car $car,
        CarRepository $carRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car, true);
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
