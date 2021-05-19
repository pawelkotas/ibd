<?php
use Ibd\Ksiazki;
$ksiazki = new Ksiazki();
$bestsellery = $ksiazki->pobierzBestsellery();
?>

<div class="col-md-3">
    <?php if (empty($_SESSION['id_uzytkownika'])): ?>
        <h1>Logowanie</h1>

        <form method="post" action="logowanie.php">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" class="form-control input-sm" />
            </div>
            <div class="form-group">
                <label for="haslo">Hasło:</label>
                <input type="password" id="haslo" name="haslo" class="form-control input-sm" />
            </div>
            <div class="form-group">
                <button type="submit" name="zaloguj" id="submit" class="btn btn-primary btn-sm">Zaloguj się</button>
                <a href="rejestracja.php" class="btn btn-link btn-sm">Zarejestruj się</a>
                <input type="hidden" name="powrot" value="<?= basename($_SERVER['SCRIPT_NAME']) ?>" />
            </div>
        </form>
    <?php else: ?>
        <p class="text-right">
            Zalogowany: <strong><?= $_SESSION['login'] ?></strong>
            &nbsp;
            <a href="wyloguj.php" class="btn btn-secondary btn-sm">wyloguj się</a>
        </p>
    <?php endif; ?>

    <h1>Koszyk</h1>
    <p>
        Suma wartości książek w koszyku:
        <strong>0</strong> PLN
    </p>

    <h1>Bestsellery</h1>
    <table class="table">
        <?php foreach($bestsellery as $bs) : ?>
            <tr>
                <td>
                    <a href="ksiazki.szczegoly.php?id=<?= $bs['id'] ?>" title="szczegóły">
                        <?php if (!empty($bs['zdjecie'])) : ?>
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