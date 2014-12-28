<?php

namespace Behat\Borg\Application\DocumentationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DocumentationController extends Controller
{
    /**
     * @Route("/{organisation}/{package}/{version}/{path}", requirements={"path": ".*"})
     *
     * @param string $organisation
     * @param string $package
     * @param string $version
     * @param string $path
     *
     * @return Response
     */
    public function showAction($organisation, $package, $version, $path)
    {
        return $this->render("docs::{$organisation}:{$package}:{$version}/{$path}");
    }
}
