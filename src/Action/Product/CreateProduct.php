<?php

namespace App\Action\Product;

use App\Action\BaseAction;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * CreateProduct Controller
 *
 * This class is used to add a new product resource
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CreateProduct extends BaseAction
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
     * Post product resource
     *
     * Create a new product
     *
     * @Rest\Post("/")
     *
     * @SWG\Parameter(
     *     name="product",
     *     in="body",
     *     required=true,
     *     @Model(type=ProductType::class)
     * )
     *
     * @SWG\Response(response=201, description="Product resource post success")
     * @SWG\Response(response=400, description="Validation Failed")
     *
     * @SWG\Tag(name="Products")
     *
     * @Rest\View(serializerGroups={"new"})
     * @param Request $request
     * @return View|FormInterface
     */
    public function __invoke(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }

        $this->em->persist($product);
        $this->em->flush();

        return $this->jsonResponse(
            Response::HTTP_CREATED,
            'Product resource post success',
            [
                'product' => $product
            ]
        );
    }
}
