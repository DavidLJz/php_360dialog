<?php

namespace App\Libs\Dialog360;

class Template
{
  public $template_name;
  public $namespace;
  public $phone;
  protected $body_parameters;

  function __construct(string $template_name, string $namespace, string $phone)
  {
    $this->template_name = $template_name;
    $this->namespace = $namespace;
    $this->phone = $phone;
  }

  public function add_body_parameter(string $type, $value) :self
  {
    $this->body_parameters[] = [
      'type' => $type,
      $type => $value
    ];

    return $this;
  }

  public function set_body(array $data) :self
  {
    $this->body_parameters = $data;
    return $this;
  }

  function __toString() :string
  {
    $data = [
      'to' => $this->phone,
      'type' => 'template',
      'template' => [
        'name' => $this->template_name,
        'namespace' => $this->namespace,

        'components' => [
          [
            'type' => 'body',
            'parameters' => $this->body_parameters
          ]
        ],

        'language' => [
          'code' => 'es_MX',
          'policy' => 'deterministic'
        ]
      ]
    ];

    return json_encode($data) ?: '';
  }
}