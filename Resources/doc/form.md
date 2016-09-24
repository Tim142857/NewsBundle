Extends form
============

```php
<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // You can update form here with $builder
        // Ex: $builder->add();
    }

    public function getParent()
    {
        return 'Tleroch\NewsBundle\Form\NewsType';
    }

    public function getBlockPrefix()
    {
        return 'app_news_form';
    }
}
```