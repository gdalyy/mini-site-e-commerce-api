<?php

namespace App\Action\Category;

use App\Action\BaseAction;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * CategoryProductsList Controller
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CategoryProductsList extends BaseAction
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get a category products resources list
     *
     * Get products for a specific category
     *
     * @Rest\Get("/{id}/products")
     *
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     required=false,
     * )
     * @SWG\Response(response=200, description="Category products list get success")
     * @SWG\Response(response=404, description="App\\Entity\\Category object not found by the @ParamConverter annotation. / Page Not Found")
     *
     * @SWG\Tag(name="Categories")
     *
     * @Rest\View(serializerGroups={"list"})
     * @param Request $request
     * @param Category $category
     * @return View
     */
    public function __invoke(Request $request, Category $category)
    {
        $page = $request->query->get('page', 1);

        $qb = $this->em
            ->getRepository(Product::class)
            ->findByCategoryQueryBuilder($category);

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);

        $products = array();

        foreach ($pagerfanta->getCurrentPageResults() as $product){
            $products [] = $product;
        }

        return $this->jsonResponse(
            Response::HTTP_OK,
            'Category products list get success',
            [
                'total' => $pagerfanta->getNbResults(),
                'count' => count($products),
                'products' => $products
            ]
        );
    }
}
