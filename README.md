#WP Symfony Form
> WordPress plugin to allow using Symfony form component with ease

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/789d1ec9-6a7d-4b06-b55a-77b3d081cedc/mini.png)](https://insight.sensiolabs.com/projects/789d1ec9-6a7d-4b06-b55a-77b3d081cedc)
[![Build Status](https://travis-ci.org/LIN3S/WPSymfonyForm.svg?branch=master)](https://travis-ci.org/LIN3S/WPSymfonyForm)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LIN3S/WPSymfonyForm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LIN3S/WPSymfonyForm/?branch=master)
[![Total Downloads](https://poser.pugx.org/lin3s/wp-symfony-form/downloads)](https://packagist.org/packages/lin3s/wp-symfony-form)
&nbsp;&nbsp;&nbsp;&nbsp;
[![Latest Stable Version](https://poser.pugx.org/lin3s/wp-symfony-form/v/stable.svg)](https://packagist.org/packages/lin3s/wp-symfony-form)
[![Latest Unstable Version](https://poser.pugx.org/lin3s/wp-symfony-form/v/unstable.svg)](https://packagist.org/packages/lin3s/wp-symfony-form)
 
## Installation
If you are using composer run the following command:
```bash
$ composer require lin3s/wp-symfony-form
```

If your `composer.json` is properly set up you should find this package in plugins folder

## Usage
First of all, **enable this plugin in the WordPress admin panel**.

To create your first form extend as usual from the `AbstractType` class provided by Symfony component.
```php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new Constraints\NotBlank(),
                'label'       => 'Name',
            ])
            ->add('surname', TextType::class, [
                'constraints' => new Constraints\NotBlank(),
                'label'       => 'Surname',
            ])
            ->add('phone', TextType::class, [
                'constraints' => new Constraints\NotBlank(),
                'label'       => 'Phone',
            ])
            ->add('email', EmailType::class, [
                'constraints' => new Constraints\Email(),
                'label'       => 'Email',
            ])
            ->add('message', TextareaType::class, [
                'constraints' => new Constraints\NotBlank(),
                'label'       => 'Message',
            ])
            ->add('conditions', CheckboxType::class, [
                'mapped' => false,
            ]);
    }
}
``` 

To enable the Ajax calls for this form you need to subscribe to the `wp_symfony_form_wrappers` WordPress hook.
```php
add_filter('wp_symfony_form_wrappers', function($formWrappers) {
    $formWrappers->add(
        new FormWrapper(
            'contact',
            'Fully/Qualified/Namespace/ContactType'
        )
    );
});
```


###Rendering the form
In case you want to use Twig for rendering a Bridge is provided, just run the following code line passing Twig instance
```php

TwigBridge::addExtension($twig);

// if you want to customize the form theme
TwigBridge::addExtension($twig, 'component/form.twig');
```

> `component/form.twig` is your custom form theme that will be used to render the forms. Check the docs about 
[form customization](http://symfony.com/doc/current/cookbook/form/form_customization.html#what-are-form-themes) for
further info.

> In case you are using Timber you should use `twig_apply_filters` hook.

**Important** Submit event is binded to every element with `.form` class. In case you need to change it just do the following:
```js
WPSymfonyForm.formSelector = '.your-selector';
```

Also error container for each form item can be changed using `WPSymfonyForm.formErrorsSelector`.

###The FormWrapper
The `FormWrapper` is a class designed to contain a form and all its related actions. As you've seen above a new instance is 
created for each form you want to use in your WordPress project, and need to be registered inside the
`FormWrapperRegistry`.

As first parameter it receives the fully qualified namespace and as second parameter it receives an array of classes
implementing `Action` interface.

###Actions on success
In case you need to perform any **server side** actions, it's as easy as to implement `execute` method of `Action` interface.
A form instance will to be used as desired. Check `src/Action` folder to check already implemented actions.

To bind this action to a specific form you need to add it in the `FormWrapper`.

For **client side** success actions you can add your callback using the global `WPSymfonyForm` namespace as follows:
```js
    WPSymfonyForm.onSuccess(function ($form) {
      if ($form.hasClass('form--contact')) {
        // ANYTHING YOU WANT TO DO 
      }
      $form.find('.form__footer').html('<p>Form successfully submitted</p>');
    });
```
> `onSuccess()` and `onError()` are available to hook into the form.
