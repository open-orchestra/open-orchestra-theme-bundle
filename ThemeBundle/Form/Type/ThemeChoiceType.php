<?php

namespace OpenOrchestra\ThemeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ThemeChoiceType
 */
class ThemeChoiceType extends AbstractType
{
    public $choices = null;

    /**
     * Constructor
     * 
     * @param $themes
     */
    public function __construct($themes = array())
    {
        foreach ($themes as $themeId => $theme) {
            $this->choices[$themeId] = $theme['name'];
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => $this->choices
            )
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'orchestra_theme_choice';
    }
}
