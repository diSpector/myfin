<?php

use app\helpers\DateHelper;
use yii\helpers\Html;

// получить и преобразовать дату
// $day = (new DateTime($models[0]['date_picked']))->format('j M y');
// $date = (new DateTime($models[0]['date_picked']));

// если в дате есть '_' значит, это период, и его нужно обработать по-другому
$showDate = false;
$pos = strpos($title, '_');
if (!$pos) {
    $date = DateHelper::formatDate(new DateTime($title));
} else {
    $titleArr = explode('_', $title);
    $date = DateHelper::formatDate(new DateTime($titleArr[0])) . ' - ' . DateHelper::formatDate(new DateTime($titleArr[1]));
    $showDate = true;
}

?>

<h3 class="text-center"><?= $date ?></h3>
<table class="table table-striped table-bordered table-hover ">
    <tbody>
        <?php foreach ($models as $model => $value) : ?>

            <?php $sign = ($value['type'] === '1') ? '-' : '+'; ?>
            <?php $style = ($value['type'] === '1') ? 'consumption' : 'income' ?>

            <tr class="table-row" data-href="/operation/update/<?= $value['id'] ?>">
                <td class="col-md-4 <?= $style ?>"><?= $sign . $value['sum'] ?></td>
                <td class="col-md-4 text-right"><?= $value['name'] ?></td>

                <?php if ($showDate) : ?>
                    <td class="col-md-4 text-right"><?= substr($value['date_picked'], 0, 10) ?></td>
                <?php endif; ?>
            </tr>

        <?php endforeach; ?>

</table>
<br>