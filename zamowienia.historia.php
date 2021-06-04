<?php
include 'header.php';

use Ibd\Ksiazki;
use Ibd\Kategorie;
use Ibd\Stronicowanie;
use Ibd\Zamowienia;

$zamowienia = new Zamowienia();

$lista_zamowien = $zamowienia->pobierzZamowienia();
?>
<h1>Zamowienia</h1>
<table class="table table-striped table-condensed" id="zamowienia">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Nr zamówienia</th>
        <th>Status</th>
        <th>Suma PLN</th>
        <th>Liczba książek</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($lista_zamowien as $lz): ?>
        <tr>
            <td></td>
            <td><?= $lz['id'] ?></td>
            <td><?= $lz['nazwa']?></td>
            <td><?= $lz['suma'] ?></td>
            <td><?= $lz['liczba_ksiazek'] ?></td>
            <td></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>



<?php include 'footer.php'; ?>
