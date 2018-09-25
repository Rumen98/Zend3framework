<?php
/**
 * Created by PhpStorm.
 * User: vis
 * Date: 25/09/18
 * Time: 09:05
 */

namespace Application\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

/**
 * This form is used to collect user feedback data like user E-mail,
 * message subject and text.
 */
class ContactForm extends Form
{
    // Constructor.
    public function __construct()
    {
        // Define form name
        parent::__construct('contact-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Add form elements
        $this->addElements();
        // Call this method to add filtering/validation rules
        $this->addInputFilter();
    }

    // This method adds elements to form (input fields and
    // submit button).
    private function addElements()
    {
        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'attributes' => [
                'id' => 'email'
            ],
            'options' => [
                'label' => 'Your E-mail',
            ],
        ]);

        // Add "subject" field
        $this->add([
            'type'  => 'text',
            'name' => 'subject',
            'attributes' => [
                'id' => 'subject'
            ],
            'options' => [
                'label' => 'Subject',
            ],
        ]);

        // Add "body" field
        $this->add([
            'type'  => 'text',
            'name' => 'body',
            'attributes' => [
                'id' => 'body'
            ],
            'options' => [
                'label' => 'Message Body',
            ],
        ]);

        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Submit',
            ],
        ]);
    }
    // This method creates input filter (used for form filtering/validation).
    private function addInputFilter()
    {
        // Get the default input filter attached to form model.
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
                'name'     => 'email',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'EmailAddress',
                        'options' => [
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck' => false,
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add([
                'name'     => 'subject',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags'],
                    ['name' => 'StripNewlines'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 128
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add([
                'name'     => 'body',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 4096
                        ],
                    ],
                ],
            ]
        );
    }
}