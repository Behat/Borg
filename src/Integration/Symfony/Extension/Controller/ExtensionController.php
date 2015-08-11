<?php

namespace Behat\Borg\Integration\Symfony\Extension\Controller;

use Behat\Borg\ExtensionCatalogue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ExtensionController extends Controller
{
    /**
     * @Route("/", name="extension_list")
     * @Template("ExtensionBundle::list.html.twig")
     */
    public function listAction()
    {
        return ['extensions' => $this->catalogue()->all()];
    }

    /**
     * @Route("/{organisation}/{name}", name="extension_index")
     * @Template("ExtensionBundle::extension.html.twig")
     */
    public function indexAction($organisation, $name)
    {
        return ['extension' => $this->catalogue()->extension($organisation . '/' . $name)];
    }

    /**
     * @return ExtensionCatalogue
     */
    private function catalogue()
    {
        return $this->get('extension.catalogue');
    }
}
