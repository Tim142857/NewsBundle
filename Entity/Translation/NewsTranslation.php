<?php

namespace Tleroch\NewsBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="news_translations", indexes={
 *      @ORM\Index(name="news_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 */
class NewsTranslation extends AbstractTranslation
{

}