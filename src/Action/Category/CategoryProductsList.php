<?php

namespace App\Action\Category;

use App\Action\BaseAction;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
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
     * @SWG\Response(response=200, description="Category products list get success")
     * @SWG\Response(response=404, description="App\\Entity\\Category object not found by the @ParamConverter annotation.")
     *
     * @SWG\Tag(name="Categories")
     *
     * @Rest\View(serializerGroups={"list"})
     * @param Category $category
     * @return View
     */
    public function __invoke(Category $category)
    {
        return $this->jsonResponse(
            Response::HTTP_OK,
            'Category products list get success',
            [
                'products' => $category->getProducts()
            ]
        );
    }
}
