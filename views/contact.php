<?php

/** @var $this \app\core\View  */
/** @var $this \app\models\ContactForm  */
/** @var $this \app\core\form/TextField  */

$this->title = 'Contact Us';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>

</head>

<body>
    <?php $form = \app\core\form\Form::begin('', 'post') ?>
    <?php echo $form->field($model, 'subject') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo new \app\core\form\TextAreaField($model, 'body') ?>
    <button type='submit' class='form-button'>Send</button>
    <?php \app\core\form\Form::end() ?>
</body>

</html>