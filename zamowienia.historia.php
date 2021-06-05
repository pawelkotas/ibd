<?php
include 'header.php';


use Ibd\Zamowienia;

$zamowienia = new Zamowienia();

$lista_zamowien = $zamowienia->pobierzZamowienia();
//var_dump($lista_zamowien);
?>
<h1>Historia zamowień</h1>
<table class="table table-striped table-condensed" id="zamowienia">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Nr zamówienia</th>
        <th>Data zamówienia</th>
        <th>Status</th>
        <th>Suma PLN</th>
        <th>Liczba książek</th>
        <th>&nbsp;</th>
    </tr>
    </thead>

    <?php foreach ($lista_zamowien as $lz): ?>

        <tbody>
            <tr>
                <td></td>
                <td><?= $lz['id'] ?></td>
                <td><?= $lz['data_dodania']?></td>
                <td><?= $lz['status']?></td>
                <td><?= $lz['suma'] ?></td>
                <td><?= $lz['liczba_ksiazek'] ?></td>
                <td></td>
            </tr>
        </tbody>
    <?php endforeach; ?>

</table>



<?php include 'footer.php'; ?>
