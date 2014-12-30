<?php

namespace Behat\Borg\Application\DocumentationBundle\Controller;

use Behat\Borg\Documentation\Locator\FileLocator;
use Behat\Borg\Package\Documentation\ReleaseDocumentationId;
use Behat\Borg\Package\Release;
use Behat\Borg\Package\SimplePackage;
use Behat\Borg\Package\Version;
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
     *     requirements={"version": "v\d+\.\d+"}
     * )
     * @Route(
     *     "/behat/docs/{version}",
     *     name="behat_documentation_fullpath_index",
     *     requirements={
     *         "version": "v\d+\.\d+"
     *     }
     * )
     * @Route(
     *     "/behat/docs/{version}/{path}",
     *     name="behat_documentation_fullpath_page",
     *     requirements={
     *         "version": "v\d+\.\d+",
     *         "path": ".*"
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
     *         "path": ".*"
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
        $package = new SimplePackage('behat', 'docs');
        $version = Version::string($version);
        $release = new Release($package, $version);
        $locator = FileLocator::ofDocumentationFile(new ReleaseDocumentationId($release), $path);

        if (!$filePath = $this->get('documentation.manager')->findFile($locator)) {
            throw $this->createNotFoundException();
        }

        return $this->render("documentation:{$filePath}");
    }

    /**
     * @Route(
     *     "/{organisation}/{package}/{version}",
     *     name="documentation_index",
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
     * @return RedirectResponse
     */
    public function documentationIndexAction($organisation, $package, $version, $path = 'index.html')
    {
        return $this->redirectToRoute('documentation_page', compact($organisation, $package, $version, $path));
    }

    /**
     * @Route(
     *     "/{organisation}/{package}/{version}/{path}",
     *     name="documentation_page",
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
     * @return RedirectResponse|Response
     */
    public function documentationPageAction($organisation, $package, $version, $path)
    {
        $package = new SimplePackage($organisation, $package);
        $version = Version::string($version);
        $release = new Release($package, $version);
        $locator = FileLocator::ofDocumentationFile(new ReleaseDocumentationId($release), $path);

        if (!$filePath = $this->get('documentation.manager')->findFile($locator)) {
            throw $this->createNotFoundException();
        }

        return $this->render("documentation:{$filePath}");
    }
}
