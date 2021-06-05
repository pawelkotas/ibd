<?php

namespace Ibd;

class Zamowienia
{
    /**
     * Instancja klasy obsługującej połączenie do bazy.
     *
     * @var Db
     */
    private Db $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     * Dodaje zamówienie.
     * 
     * @param int $idUzytkownika
     * @return int Id zamówienia
     */
    public function dodaj(int $idUzytkownika): int
    {
        return $this->db->dodaj('zamowienia', [
            'id_uzytkownika' => $idUzytkownika,
            'id_statusu' => 1
        ]);
    }

    /**
     * Dodaje szczegóły zamówienia.
     * 
     * @param int   $idZamowienia
     * @param array $dane Książki do zamówienia
     */
    public function dodajSzczegoly(int $idZamowienia, array $dane): void
    {
        foreach ($dane as $ksiazka) {
            $this->db->dodaj('zamowienia_szczegoly', [
                'id_zamowienia' => $idZamowienia,
                'id_ksiazki' => $ksiazka['id'],
                'cena' => $ksiazka['cena'],
                'liczba_sztuk' => $ksiazka['liczba_sztuk']
            ]);
        }
    }

    public function pobierzZamowienia(): array{
        $sql = "SELECT zam.*, st.nazwa as status,
            ROUND(SUM(sz.cena * sz.liczba_sztuk),2) as suma, 
            SUM(sz.liczba_sztuk) as liczba_ksiazek
            FROM zamowienia zam
            LEFT JOIN zamowienia_statusy st ON zam.id_statusu = st.id
            LEFT JOIN zamowienia_szczegoly sz ON zam.id = sz.id_zamowienia 
            LEFT JOIN uzytkownicy uz ON zam.id_uzytkownika = uz.id
            WHERE zam.id_uzytkownika = :id_uzytkownika
            GROUP BY zam.id";

        return $this->db->pobierzWszystko($sql, ['id_uzytkownika' => $_SESSION['id_uzytkownika']]);
    }

    public function liczbaZamowien($idUztkownika): int{
        $sql = "Select COUNT (id) as suma FROM zamowienia 
                WHERE id_uzytkownika = '$idUztkownika'";

        $liczba_zamowien = $this->db->pobierzWszystko($sql);
        return intval($liczba_zamowien[0]['suma'], 10);
    }

}
