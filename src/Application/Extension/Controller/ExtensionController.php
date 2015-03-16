<?php

namespace Behat\Borg\Application\Extension\Controller;

use Behat\Borg\ExtensionCatalogue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ExtensionController extends Controller
{
    /**
     * @Route("/")
     * @Template()
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
