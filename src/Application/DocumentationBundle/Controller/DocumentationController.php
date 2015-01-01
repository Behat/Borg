<?php

namespace Behat\Borg\Application\DocumentationBundle\Controller;

use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\ProjectDocumentationId;
use Behat\Borg\DocumentationManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DocumentationController extends Controller
{
    /**
     * @Route(
     *     "/{version}",
     *     name="behat_documentation_index",
     *     requirements={ "version": "v\d++\.\d++" }
     * )
     * @Route(
     *     "/behat/docs/{version}",
     *     name="behat_documentation_fullpath_index",
     *     requirements={ "version": "v\d++\.\d++" }
     * )
     * @Route(
     *     "/behat/docs/{version}/{path}",
     *     name="behat_documentation_fullpath_page",
     *     requirements={
     *         "version": "v\d++\.\d++",
     *         "path":    ".*\.html"
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
     *         "version": "v\d++\.\d++",
     *         "path":    ".*\.html"
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
     *         "project": "[\w\-]++\/[\w\-]++",
     *         "version": "v\d++\.\d++"
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
        return $this->redirectToRoute('documentation_page', compact('project', 'version', 'path'));
    }

    /**
     * @Route(
     *     "/{project}/{version}/{path}",
     *     name="documentation_page",
     *     requirements={
     *         "project": "[\w\-]++\/[\w\-]++",
     *         "version": "v\d++\.\d++",
     *         "path":    ".*\.html"
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
        $documentationId = new ProjectDocumentationId($project, $version);
        $pageId = new PageId($path);

        if (!$page = $this->getDocumentationManager()->findPage($documentationId, $pageId)) {
            throw $this->createNotFoundException();
        }

        return $this->render("documentation:{$page}");
    }

    /**
     * @return DocumentationManager
     */
    private function getDocumentationManager()
    {
        return $this->get('documentation.manager');
    }
}
