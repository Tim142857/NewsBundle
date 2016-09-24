Extends entity
==============

```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Tleroch\NewsBundle\Entity\News as TlerochNews;

/**
 * @ORM\Table(name="news")
 * @Gedmo\TranslationEntity(class="Tleroch\NewsBundle\Entity\Translation\NewsTranslation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsRepository")
 */
class News extends TlerochNews {
    // You can add here custom attributes / methods
}
```