<?php

namespace App\Action\Category;

use App\Action\BaseAction;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * CreateCategory Controller
 *
 * This class is used to add a new category resource
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CreateCategory extends BaseAction
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
     * Post category resource
     *
     * Create a new category for products
     *
     * @Rest\Post("/")
     *
     * @SWG\Parameter(
     *     name="category",
     *     in="body",
     *     required=true,
     *     @Model(type=CategoryType::class)
     * )
     *
     * @SWG\Response(response=201, description="Category resource post success")
     * @SWG\Response(response=400, description="Validation Failed")
     *
     * @SWG\Tag(name="Categories")
     *
     * @Rest\View(serializerGroups={"new"})
     * @param Request $request
     * @return View|FormInterface
     */
    public function __invoke(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }

        $this->em->persist($category);
        $this->em->flush();

        return $this->jsonResponse(
            Response::HTTP_CREATED,
            'Category resource post success',
            [
                'category' => $category
            ]
        );
    }
}
