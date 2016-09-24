<?php

namespace Tleroch\NewsBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;

class NewsFormFactory
{
    private $formFactory;
    private $type;
    private $folder;

    public function __construct(FormFactoryInterface $formFactory, $type, $folder)
    {
        $this->formFactory = $formFactory;
        $this->type = $type;
        $this->folder = $folder;
    }

    public function createForm(array $options = array())
    {
        $options = array_merge(array('folder' => $this->folder), $options);

        return $this->formFactory->create($this->type, null, $options);
    }
}