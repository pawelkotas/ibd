<?php

namespace Ibd;

class Stronicowanie
{
    /**
     * Instancja klasy obsługującej połączenie do bazy.
     *
     * @var Db
     */
    private Db $db;

    /**
     * Liczba rekordów wyświetlanych na stronie.
     *
     * @var int
     */
    private int $naStronie = 5;

    /**
     * Aktualnie wybrana strona.
     *
     * @var int
     */
    private int $strona = 0;

    /**
     * Dodatkowe parametry przekazywane w pasku adresu (metodą GET).
     *
     * @var array
     */
    private array $parametryGet = [];

    /**
     * Parametry przekazywane do zapytania SQL.
     *
     * @var array
     */
    private array $parametryZapytania;

    public function __construct(array $parametryGet , array $parametryZapytania = [])
    {
        $this->db = new Db();
        $this->parametryGet = $parametryGet;
        $this->parametryZapytania = $parametryZapytania;

        if (!empty($parametryGet['strona'])) {
            $this->strona = (int)$parametryGet['strona'];
        }
    }

    /**
     * Dodaje do zapytania SELECT klauzulę LIMIT.
     *
     * @param string $select
     * @return string
     */
    public function dodajLimit(string $select): string
    {
        return sprintf('%s LIMIT %d, %d', $select, $this->strona * $this->naStronie, $this->naStronie);
    }

    /**
     * Generuje linki do wszystkich podstron.
     *
     * @param string $select Zapytanie SELECT
     * @param string $plik Nazwa pliku, do którego będą kierować linki
     * @return string
     */
    public function pobierzLinki(string $select, string $plik): string
    {
        $rekordow = $this->db->policzRekordy($select, $this->parametryZapytania);
        $liczbaStron = (int)ceil($rekordow / $this->naStronie);
        $parametry = $this->_przetworzParametry();

        $linki = "<nav><ul class='pagination'>";
        $linki .= sprintf("<li class='page-item %s'><a href='%s?%s&strona=0' class='page-link'>Początek</a></li>",
        $this -> strona === 0 ? 'disabled' : '',
        $plik, $parametry
        );
        $linki .= sprintf("<li class='page-item %s'><a href='%s?%s&strona=%s' class='page-link' aria-label='Previous'>
                           <span aria-hidden='true'>&laquo;</span>
                            <span class='sr-only'>Poprzednia</span></a></li>",
            $this -> strona === 0 ? 'disabled' : '',
            $plik, $parametry,
            $this -> strona - 1
        );
        for ($i = 0; $i < $liczbaStron; $i++) {
            if ($i == $this->strona) {
                $linki .= sprintf("<li class='page-item active'><a class='page-link'>%d</a></li>", $i + 1);
            } else {
                $linki .= sprintf(
                    "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link'>%d</a></li>",
                    $plik,
                    $parametry,
                    $i,
                    $i + 1
                );
            }
        }
        $linki .= sprintf("<li class='page-item %s'><a href='%s?%s&strona=%s' class='page-link' aria-label='Next'>
                                   <span aria-hidden='false'>&raquo;</span> 
                                   <span class='sr-only'>Następna<span></span></a></li>",
            $this -> strona === $liczbaStron - 1 ? 'disabled' : '',
            $plik, $parametry,
            $this -> strona + 1
        );
        $linki .= sprintf("<li class='page-item %s'><a href='%s?%s&strona=%s' class='page-link'>Koniec</a></li>",
            $this -> strona === $liczbaStron - 1 ? 'disabled' : '',
            $plik, $parametry,
            $liczbaStron - 1,
        );
        $linki .= "</ul></nav>";

        return $linki;
    }

    public function pobierzPodsumowanieStrony(string $select): string{
        $liczbaRekordow = $this->db->policzRekordy($select, $this->parametryZapytania);
        $poczatek = ($this->strona * $this->naStronie) + 1;
        $koniec = $poczatek + $this->naStronie - 1;
        $podsumowanie = sprintf("Wyświetlono rekordy %s-%s z %s",
            $poczatek, min($koniec, $liczbaRekordow),$liczbaRekordow);
        return $podsumowanie;
    }

    /**
     * Przetwarza parametry wyszukiwania.
     * Wyrzuca zbędne elementy i tworzy gotowy do wstawienia w linku zestaw parametrów.
     *
     * @return string
     */
    private function _przetworzParametry(): string
    {
        $temp = [];
        $usun = ['szukaj', 'strona'];
        foreach ($this->parametryGet as $kl => $wart) {
            if (!in_array($kl, $usun))
                $temp[] = "$kl=$wart";
        }

        return implode('&', $temp);
    }
}
