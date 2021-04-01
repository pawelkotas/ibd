<?php

// jesli nie podano parametru id, przekieruj do listy książek
if(empty($_GET['id'])) {
    header("Location: ksiazki.lista.php");
    exit();
}

$id = (int)$_GET['id'];

include 'header.php';

use Ibd\Ksiazki;

$ksiazki = new Ksiazki();
$dane = $ksiazki->pobierz($id);
?>

<h2><?=$dane['tytul']?></h2>

<p>
	<a href="ksiazki.lista.php"><i class="fas fa-chevron-left"></i> Powrót</a>
</p>
<table class="table table-striped table-condensed">
    <tbody>
        <tr>
            <td style="width: 300px"; rowspan="6">
                <?php if (!empty($dane['zdjecie'])) : ?>
                    <img src="zdjecia/<?= $dane['zdjecie'] ?>" alt="<?= $dane['tytul'] ?>" class="img-thumbnail" />
                <?php else : ?>
                    brak zdjęcia
                <?php endif; ?>
            </td>
        </tr>
        <tr style="font-size: 16px; font-weight:bold">
            <td>Tytuł:</td>
            <td><?=$dane['tytul']?></td>
        </tr>
        <tr>
            <td>Cena:</td>
            <td><?=$dane['cena']?> zł</td>
        </tr>
        <tr>
            <td>Liczba stron:</td>
            <td><?=$dane['liczba_stron']?></td>
        </tr>
            <td>ISBN:</td>
            <td><?=$dane['isbn']?></td>
        </tr>
        <tr>
            <td>Opis:</td>
            <td><?=$dane['opis']?></td>
        </tr>
    </tbody>



</table>

<?php include 'footer.php'; ?>