<?php

namespace Behat\Borg\Application\Debug\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExceptionController
{
    public function showAction(FlattenException $exception)
    {
        if (NotFoundHttpException::class == $exception->getClass()) {
            return new Response('Page not found', 404);
        }

        return new Response("{$exception->getClass()}: {$exception->getMessage()}", 500);
    }
}
