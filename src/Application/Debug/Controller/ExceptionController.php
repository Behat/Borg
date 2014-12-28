<?php

namespace Behat\Borg\Application\Debug\Controller;

use SebastianBergmann\Exporter\Exception;
use Symfony\Component\Debug\Exception\FlattenException;

final class ExceptionController
{
    public function showAction(FlattenException $exception)
    {
        throw new Exception("{$exception->getClass()}: {$exception->getMessage()}");
    }
}
