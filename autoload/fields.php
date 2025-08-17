
<?php

use Plain\Contact\Options;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\A;
use Kirby\Form\Form;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Toolkit\I18n;
use Kirby\Toolkit\V;

return [
	'contact' => [
        'extends' => 'structure',
        'props' => [
            'duplicate' => null,
            'columns' => null,
            'limit' => null,
            'sortBy' => null,
            'saveOptions' => function(bool $save = true) {
                return $save;
            },
            'empty' => function ($empty = 'field.structure.empty') {
                return I18n::translate($empty, $empty);
            },
            'fields' => function (array $fields = []) {
                return $fields + [
                    'type' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                    'value' => [
                        'type' => 'text',
                        'required' => true
                    ]
                ];
            },
            'options' => function (?array $options = null) {
                return $this->optionsObj()->toArray();
            }
        ],
	    'computed' => [
            'columns' => null,
        ],
        'methods' => [
            'optionsObj' => function() {
                return Options::factory($this->attrs['options'] ?? null); 
            },
            'getValidation' => function (string $type) {
                return A::find(
                    $this->options(),
                    fn($a) => ($a['value'] ?? null) === $type
                )['validate'] ?? null;
            },
            'form' => function (array $values = []) {
                return new Form([
                    'fields' => $this->fields(),
                    'values' => $values,
                    'model'  => $this->model
                ]);
            },
        ],
        'save' => function ($value) {
            $data = [];
    
            foreach ($value as $row) {
                $row = $this->form($row)->content();
                unset($row['_id']);
                if ($this->saveOptions) {
                    $type = $row['type'];
                    $row['options'] = $this->optionsObj()->get($type);
                }
                $data[] = $row;
            }
    
            return $data;
        },
        'validations' => [
            'min',
            'max',
            'structure' => function ($value) {
                if (empty($value) === true) {
                    return true;
                }

                $values = A::wrap($value);

                foreach ($values as $index => $value) {
                    $form = $this->form($value);

                    foreach ($form->fields() as $field) {

                        $errors = $field->errors();

                        //Inject field valitaion fromoption
                        if ($validate = $this->getValidation($value['type'])) {
                            $errors = $errors + V::errors($value['value'], A::wrap($validate));
                        }

                        if (empty($errors) === false) {
                            throw new InvalidArgumentException([
                                'key'  => 'structure.validation',
                                'data' => [
                                    'field' => $field->label() ?? Str::ucfirst($field->name()),
                                    'index' => $index + 1
                                ]
                            ]);
                        }
                    }
                }
            }
        ]
    ]
];

?>
