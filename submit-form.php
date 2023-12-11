<?php

if (!empty($_POST)) {
  $errors = [];

  $validation = [
    'voornaam' => ['required'],
    'achternaam' => ['required'],
    'e-mail' => ['required', 'e-mail'],
    'telefoon' => ['required'],
    'aantal' => ['required']
  ];

  foreach ($_POST as $key => $value) {
    if (array_key_exists($key, $validation)) {
      if (in_array('required', $validation[$key]) && empty($value)) {
        $errors[$key] = 'required';
      } else if (in_array('e-mail', $validation[$key]) && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $value)) {
        $errors[$key] = 'e-mail';
      }
    }
  }

  if (empty($errors)) {
    $aanspreking = $_POST['aanspreking'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['e-mail'];
    $telefoon = $_POST['telefoon'];
    $aantal = $_POST['aantal'];
    $opmerkingen = $_POST['opmerkingen'];

    $to = 'peter.ottevaere@telenet.be';
    // $to = 'arthurvanpassel@hotmail.com';

    $email_subject = "Tenera event inschrijving: " . $_POST['voornaam'] . " " . $_POST['achternaam'];
    $email_body = "
      Aanspreking: $aanspreking \n
      Voornaam: $voornaam \n
      Achternaam: $achternaam \n
      E-mailadres: $email \n
      Telefoon: $telefoon \n
      Aantal personen: $aantal \n
      Vragen / opmerkingen: $opmerkingen \n
    ";

    $emailSent = mail($to, $email_subject, $email_body);
    if ($emailSent) {
      $referer = $_SERVER['HTTP_ORIGIN'];
      header("Location: $referer?success=true");
    } else {
      $referer = $_SERVER['HTTP_ORIGIN'];
      header("Location: $referer?errorMail=true");
    }
  } else {
    $error_string = "";
    $fields_string = "";
    foreach ($errors as $key => $value) {
      $error_string .= "$key:$value,";
    }
    foreach ($_POST as $key => $value) {
      $fields_string .= "$key:$value,";
    }
    $referer = $_SERVER['HTTP_ORIGIN'];
    header("Location: $referer?errors=$error_string&fields=$fields_string");
  }
} else {
  $referer = $_SERVER['SERVER_NAME'];
  header("Location: //$referer");
}
