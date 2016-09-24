Installation
============

Step 1: Add repository to composer
----------------------------------

Open composer.json and add this section:

```
"repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/Tim142857/NewsBundle.git"
        }
    ]
```

You also need to allow unsecure url, add in section config:
```
"config": {
        "secure-http": false
    },
```

Step 2: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require Tleroch/NewsBundle "dev-master"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 3: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Tleroch\NewsBundle\NewsBundle(),
        );

        // ...
    }

    // ...
}
```

Create this service in `app/config/services.yml`:

```php
gedmo.listener.translatable:
        class: Gedmo\Translatable\TranslatableListener
        tags:
            - { name: doctrine.event_subscriber, connection: default }
        calls:
            - [ setAnnotationReader, [ "@annotation_reader" ] ]
            - [ setDefaultLocale, [ "%locale%" ] ]
            - [ setTranslatableLocale, [ "%locale%" ] ]
            - [ setTranslationFallback, [ false ] ]
twig.extension.intl:
        class: Twig_Extensions_Extension_Intl
        tags:
            - { name: twig.extension }
```

Now add config in `app/config/config.yml`:
```
# Tleroch News
news:
    news_class:
    #Put here your own news entity
    news_type:
    #Only if u need to override Type
    upload_folder:
    #e.g : upload_folder: depot/images/news/ => no need to put "web/"
```

Finally add route in `app/config/routing.yml`:
```
tleroch_news:
    resource: "@NewsBundle/Resources/config/routing.yml"
    prefix: /admin
```

Step 4: Read documentation
--------------------------

You can now read documentation:

* [Entity](Resources/doc/entity.md)
* [Repository](Resources/doc/repository.md)
* [Form](Resources/doc/form.md)
* [Routing](Resources/doc/routing.md)

