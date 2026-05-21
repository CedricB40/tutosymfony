<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RecipeController extends AbstractController
{
    #[Route(path: "/recette", name: "app_recipe_index")]
    public function index(RecipeRepository $repository, EntityManagerInterface $em): Response
    {
        //pour affihcer tout
        // $recipes = $repository->findAll();

        // pour afficher seulement les recettes de moins de 40min
        $recipes = $repository->findRecipeDurationLowerThan(40);

        $recipe = new Recipe();
        $recipe->setTitle('Omelette')
            ->setSlug('omelette')
            ->setContent('Prenez des oeufs, cassez les et ensuite battez les en rajoutant du sel.')
            ->setDuration(6)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        dump($recipes);

        return $this->render('recipe/index.html.twig', [
            "recipes" => $recipes
        ]);
    }

    #[Route(path: "/recette/{slug}-{id}", name: "app_recipe_show", requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository->find($id);
        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute('app_recipe_show', ['slug' => $recipe->getSlug(),'id' => $recipe->getId()]);
        }

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}