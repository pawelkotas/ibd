<?php

namespace Ibd;

class Ksiazki
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
	 * Pobiera wszystkie książki.
	 *
	 * @return array
	 */
	public function pobierzWszystkie(): ?array
    {
		$sql = "SELECT k.*, a.imie, a.nazwisko, kat.nazwa FROM ksiazki k 
                JOIN autorzy a ON k.id_autora=a.id
                JOIN kategorie kat ON k.id_kategorii=kat.id               ";

		return $this->db->pobierzWszystko($sql);
	}

    /**
     * Pobiera dane książki o podanym id.
     *
     * @param int $id
     * @return array
     */
	public function pobierz(int $id): ?array
    {
		return $this->db->pobierz('ksiazki', $id);
	}

	/**
	 * Pobiera najlepiej sprzedające się książki.
	 * 
	 */
	public function pobierzBestsellery()
	{
		$sql = "SELECT k.*, a.imie, a.nazwisko FROM ksiazki k
                JOIN autorzy a ON k.id_autora = a.id
                ORDER BY RAND() LIMIT 5";

		return $this->db->pobierzWszystko($sql);

	}

}
