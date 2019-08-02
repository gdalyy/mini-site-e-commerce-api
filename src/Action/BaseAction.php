<?php

namespace App\Action;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * BaseAction Controller
 *
 * This class is used to define common methods between controllers
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class BaseAction extends AbstractController
{
    /**
     * Create Json Response
     *
     * @param int $status Response status code
     * @param string $message Response message
     * @param mixed $payload Response payload
     * @param array $headers Response headers
     * @return View
     */
    protected function jsonResponse(int $status, string $message, $payload = null, array $headers = []): View
    {
        if (null !== $payload) {
            return new View(
                ['code' => $status, 'message' => $message, 'payload' => $payload],
                $status,
                $headers
            );
        }

        return new View(['code' => $status, 'message' => $message], $status);
    }
}
