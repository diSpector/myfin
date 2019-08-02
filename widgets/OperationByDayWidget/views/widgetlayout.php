<?php

use app\helpers\DateHelper;
use yii\helpers\Html;

// получить и преобразовать дату
// $day = (new DateTime($models[0]['date_picked']))->format('j M y');
$date = (new DateTime($models[0]['date_picked']));
$formatDate = DateHelper::formatDate($date);
?>

<h3 class="text-center"><?= $formatDate ?></h3>
<table class="table table-striped table-bordered table-hover">
    <tbody>
        <?php foreach ($models as $model => $value) : ?>

            <?php $sign = ($value['type'] === '1') ? '-' : '+'; ?>
            <?php $style = ($value['type'] === '1') ? 'consumption' : 'income' ?>

            <tr class = "table-row" data-href="/operation/update/<?= $value['id'] ?>">
                    <td class="col-md-2 <?= $style ?>"><?=  $sign . $value['sum'] ?></td>
                    <td class="col-md-2 text-right"><?= $value['name'] ?></td>
            </tr>

        <?php endforeach;  ?>

</table>

<br>