<?php

namespace Tleroch\NewsBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tleroch\NewsBundle\Entity\News;

class FileUpdate implements EventSubscriber {

    private $targetDir;
    private $container;

    public function __construct($targetDir, ContainerInterface $container) {
        $this->targetDir = $targetDir;
        $this->container = $container;
    }

    public function getSubscribedEvents() {
        return array(
            'preUpdate'
        );
    }

    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if ($entity instanceof News) {
            if ($args->hasChangedField('image')) {
                $image = $this->container->get('kernel')->getRootDir() . '/../web/' . $this->targetDir . $args->getOldValue('image');

                if (file_exists($image) && is_file($image)) {
                    unlink($image);
                }
            }

            if ($args->hasChangedField('file')) {
                $file = $this->container->get('kernel')->getRootDir() . '/../web/' . $this->targetDir . $args->getOldValue('file');

                if (file_exists($file) && is_file($image)) {
                    unlink($file);
                }
            }
        }
    }

}
