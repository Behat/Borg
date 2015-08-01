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
     * @return ExtensionCatalogue
     */
    private function catalogue()
    {
        return $this->get('extension.catalogue');
    }
}
