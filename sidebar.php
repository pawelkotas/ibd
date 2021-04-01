<?php
use Ibd\Ksiazki;
$ksiazki = new Ksiazki();
$bestsellery = $ksiazki->pobierzBestsellery();
?>

<div class="col-md-2">
	<h1>Bestsellery</h1>
    <table class="table">
        <?php foreach($bestsellery as $bs) : ?>
            <tr>
                <td>
                    <a href="ksiazki.szczegoly.php?id=<?= $bs['id'] ?>" title="szczegóły">
                    <?php if (!empty($ks['zdjecie'])) : ?>
                        <img src="zdjecia/<?= $bs['zdjecie'] ?>" alt="<?= $bs['tytul'] ?>" class="img-thumbnail" />
                    <?php else : ?>
                        brak zdjęcia
                    <?php endif; ?>
                        <h6><?=$bs['tytul']?></h6>
                        <?=$bs['imie']?>
                        <?=$bs['nazwisko']?>
                    </a>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>