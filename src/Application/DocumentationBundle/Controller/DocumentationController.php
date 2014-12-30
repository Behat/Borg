<?php

namespace Behat\Borg\Application\DocumentationBundle\Controller;

use Behat\Borg\Documentation\File\FileLocator;
use Behat\Borg\Documentation\StringDocumentationId;
use Behat\Borg\DocumentationManager;
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
     *     name="behat_documentation_index",
     *     requirements={ "version": "v\d+\.\d+" }
     * )
     * @Route(
     *     "/behat/docs/{version}",
     *     name="behat_documentation_fullpath_index",
     *     requirements={ "version": "v\d+\.\d+" }
     * )
     * @Route(
     *     "/behat/docs/{version}/{path}",
     *     name="behat_documentation_fullpath_page",
     *     requirements={
     *         "version": "v\d+\.\d+",
     *         "path":    ".*"
     *     }
     * )
     *
     * @param string $version
     * @param string $path
     *
     * @return RedirectResponse
     */
    public function behatDocumentationIndexAction($version = 'v3.0', $path = 'index.html')
    {
        return $this->redirectToRoute('behat_documentation_page', compact('version', 'path'));
    }

    /**
     * @Route(
     *     "/{version}/{path}",
     *     name="behat_documentation_page",
     *     requirements={
     *         "version": "v\d+\.\d+",
     *         "path":    ".*"
     *     }
     * )
     *
     * @param string $version
     * @param string $path
     *
     * @return Response
     */
    public function behatDocumentationPageAction($version, $path)
    {
        return $this->documentationPageAction('behat/docs', $version, $path);
    }

    /**
     * @Route(
     *     "/{project}/{version}",
     *     name="documentation_index",
     *     requirements={
     *         "project": "\w+\/\w+",
     *         "version": "v\d+\.\d+",
     *         "path":    ".*"
     *     }
     * )
     *
     * @param string $project
     * @param string $version
     * @param string $path
     *
     * @return RedirectResponse
     */
    public function documentationIndexAction($project, $version, $path = 'index.html')
    {
        return $this->redirectToRoute('documentation_page', compact($project, $version, $path));
    }

    /**
     * @Route(
     *     "/{project}/{version}/{path}",
     *     name="documentation_page",
     *     requirements={
     *         "project": "\w+\/\w+",
     *         "version": "v\d+\.\d+",
     *         "path":    ".*"
     *     }
     * )
     *
     * @param string $project
     * @param string $version
     * @param string $path
     *
     * @return RedirectResponse|Response
     */
    public function documentationPageAction($project, $version, $path)
    {
        $anId = new StringDocumentationId($project, $version);
        $locator = FileLocator::ofDocumentationFile($anId, $path);

        if (!$publishedFile = $this->getDocumentationManager()->findFile($locator)) {
            throw $this->createNotFoundException();
        }

        return $this->render("documentation:{$publishedFile}");
    }

    /**
     * @return DocumentationManager
     */
    private function getDocumentationManager()
    {
        return $this->get('documentation.manager');
    }
}
