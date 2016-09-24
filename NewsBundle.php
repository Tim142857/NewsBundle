<?php

namespace Tleroch\NewsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tleroch\NewsBundle\DependencyInjection\NewsExtension;

class NewsBundle extends Bundle {

    public function getContainerExtension() {
        if (null === $this->extension) {
            $this->extension = new NewsExtension();
        }

        return $this->extension;
    }

}
