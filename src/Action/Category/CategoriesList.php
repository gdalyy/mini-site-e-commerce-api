<?php

namespace App\Action\Category;

use App\Action\BaseAction;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * CategoriesList Controller
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CategoriesList extends BaseAction
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
     * Get categories resources list
     *
     * Show the list of all categories
     *
     * @Rest\Get("/")
     *
     * @SWG\Response(response=200, description="Categories list get success")
     *
     * @SWG\Tag(name="Categories")
     *
     * @Rest\View(serializerGroups={"list"})
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request)
    {
        $categories = $this->em->getRepository(Category::class)->findAll();

        return $this->jsonResponse(
            Response::HTTP_OK,
            'Categories list get success',
            [
                'categories' => $categories
            ]
        );
    }
}
