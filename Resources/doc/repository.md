Extends repository
==================

```php
<?php

namespace AppBundle\Repository;

use SEL\NewsBundle\Entity\Repository\NewsRepository AS TlerochNewsRepository;
use Doctrine\ORM\Query;
use Gedmo\Translatable\TranslatableListener;

class NewsRepository extends TlerochNewsRepository
{
    // You can create here customs repository methods
}

```