<?php

require_once __DIR__  . '/Sender.php';
require_once __DIR__  . '/Template.php';

use App\Libs\Dialog360\Sender;
use App\Libs\Dialog360\Template;

try {
  $namespace = $_POST['namespace'];
  $template_name = $_POST['template_name'];
  $phone = $_POST['phone'];

  $text_body_params = $_POST['text_body_params'];

  $template = new Template($template_name, $namespace, $phone);

  foreach ($text_body_params as $v) {
    $template->add_body_parameter('text', $v);
  }

  $sender = new Sender($_POST['api_key']);

  $data = $sender->send_template($template);

  echo json_encode($data);
}

catch (Throwable $e) {
  exit($e);
}