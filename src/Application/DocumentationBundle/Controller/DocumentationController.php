<?php

namespace Behat\Borg\Application\DocumentationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DocumentationController extends Controller
{
    /**
     * @Route(
     *     "/{version}",
     *     name="behat_docs_index",
     *     requirements={"version": "v\d+\.\d+"}
     * )
     *
     * @param string $version
     *
     * @return RedirectResponse
     */
    public function behatDocumentationIndexAction($version = 'v3.0')
    {
        return $this->redirectToRoute(
            'docs_page', [
                'organisation' => 'behat',
                'package'      => 'docs',
                'version'      => $version,
                'path'         => 'index.html'
            ]
        );
    }

    /**
     * @Route(
     *     "/{organisation}/{package}/{version}",
     *     name="docs_index",
     *     requirements={"version": "v\d+\.\d+"}
     * )
     *
     * @param string $organisation
     * @param string $package
     * @param string $version
     *
     * @return RedirectResponse
     */
    public function documentationIndexAction($organisation, $package, $version)
    {
        return $this->redirectToRoute(
            'docs_page', [
                'organisation' => $organisation,
                'package'      => $package,
                'version'      => $version,
                'path'         => 'index.html'
            ]
        );
    }

    /**
     * @Route(
     *     "/{organisation}/{package}/{version}/{path}",
     *     name="docs_page",
     *     requirements={
     *         "version": "v\d+\.\d+",
     *         "path": ".*"
     *     }
     * )
     *
     * @param string $organisation
     * @param string $package
     * @param string $version
     * @param string $path
     *
     * @return Response
     */
    public function documentationPageAction($organisation, $package, $version, $path)
    {
        return $this->render("docs::{$organisation}:{$package}:{$version}/{$path}");
    }
}
