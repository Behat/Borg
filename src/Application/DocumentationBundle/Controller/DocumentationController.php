<?php

namespace Behat\Borg\Application\DocumentationBundle\Controller;

use Behat\Borg\Documentation\Page\PageId;
use Behat\Borg\Documentation\ProjectDocumentationId;
use Behat\Borg\Documenter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DocumentationController extends Controller
{
    /**
     * @Route(
     *     "/{version}",
     *     name="behat_documentation_index"
     * )
     * @Route(
     *     "/behat/behat/{version}",
     *     name="behat_documentation_fullpath_index"
     * )
     * @Route(
     *     "/behat/behat/{version}/{path}",
     *     name="behat_documentation_fullpath_page"
     * )
     *
     * @param string $version
     * @param string $path
     *
     * @return RedirectResponse
     */
    public function behatDocumentationIndexAction($version = 'current', $path = 'index.html')
    {
        return $this->redirectToRoute('behat_documentation_page', compact('version', 'path'));
    }

    /**
     * @Route(
     *     "/{version}/{path}",
     *     name="behat_documentation_page"
     * )
     *
     * @param string $version
     * @param string $path
     *
     * @return Response
     */
    public function behatDocumentationPageAction($version, $path)
    {
        return $this->documentationPageAction('behat/behat', $version, $path);
    }

    /**
     * @Route(
     *     "/{project}/{version}",
     *     name="documentation_index"
     * )
     *
     * @param string $project
     * @param string $version
     * @param string $path
     *
     * @return RedirectResponse
     */
    public function documentationIndexAction($project, $version = 'current', $path = 'index.html')
    {
        return $this->redirectToRoute('documentation_page', compact('project', 'version', 'path'));
    }

    /**
     * @Route(
     *     "/{project}/{version}/{path}",
     *     name="documentation_page"
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
        $manager = $this->getDocumenter();
        $documentationId = new ProjectDocumentationId($project, $version);
        $pageId = new PageId($path);

        if (!$page = $manager->findPage($documentationId, $pageId)) {
            throw $this->createNotFoundException();
        }

        return $this->render("documentation:{$page}", [
            'page'        => $page,
            'projectDocs' => $manager->findProjectDocumentation($project)
        ]);
    }

    /**
     * @return Documenter
     */
    private function getDocumenter()
    {
        return $this->get('documentation.documenter');
    }
}
