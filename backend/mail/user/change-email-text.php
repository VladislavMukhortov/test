<?php

/**
 * отправка сообщения при изменении почтового ящика
 * $user      User   пользователь
 */

// ссылка для подтверждения email
$verify_link = Yii::$app->params['frontendURL'] . 'auth/verify-email/' . $user->verify_email;

?>

Здравствуйте, <?= h($user->name) ?>!

Что бы подтвердить почтовый адрес перейдите по ссылке
<?= h($verify_link) ?>


Ваши учетные данные:
Email: <?= h($user->email) ?>
Phone: <?= h($user->phone) ?>
