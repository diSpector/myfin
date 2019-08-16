<?php

use app\helpers\DateHelper;
use yii\helpers\Html;

// если в дате есть ' - ' значит это период, и его нужно обработать по-другому

$pos = strpos($title, ' - ');
if (!$pos) {
    $query = substr($title, 0, 10);
    $date = DateHelper::formatDate(new DateTime($title));
} else {
    $titleArr = explode(' - ', $title);
    $query = $titleArr[0] . '_' .  $titleArr[1];
    $date = '';
}

?>

<h3 class="text-center"><?= $date ?></h3>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:25%">Категория</th>
            <th style="width:25%">Наличные</th>
            <th style="width:25%">Безналичные</th>
            <th style="width:25%">Описание</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model => $value) : ?>

            <?php $style = ($value['type'] === '1') ? 'consumption' : 'income' ?>

            <tr class="table-row" data-href="/dashboard/update/<?php echo $value['category_id'] . '/' . $query ?>">
                <td class="col-md-4"><?= $value['name'] ?></td>
                <td class="col-md-2 <?= $value['cash'] < 0 ? 'consumption' : 'income' ?>"><?= $value['cash'] ?></td>
                <td class="col-md-2 <?= $value['card'] < 0 ? 'consumption' : 'income' ?>"><?= $value['card'] ?></td>
                <td class="col-md-4"><?= $value['description'] ?></td>
            </tr>

        <?php endforeach;  ?>

</table>

<br>