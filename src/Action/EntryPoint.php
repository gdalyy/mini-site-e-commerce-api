<?php

namespace App\Action;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EntryPoint Controller
 *
 * This is the api entry point controller
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class EntryPoint extends BaseAction
{
    /**
     * Redirect to documentation if dev env
     *
     * @Route(path="/")
     */
    public function __invoke()
    {
        if (in_array($this->getParameter('kernel.environment'), ['prod', 'test'])) {
            throw new NotFoundHttpException();
        }

        return $this->redirectToRoute('app.swagger_ui');
    }
}
