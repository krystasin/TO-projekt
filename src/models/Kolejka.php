<?php

class Kolejka
{
    private int $nr;
    private string $poczatek;
    private string $koniec;
    private array $mecze;
    private string $stan;

    /**
     * @param int $nr
     * @param string $poczatek
     * @param string $koniec
     * @param array $mecze
     * @param string $stan
     */
    public function __construct()
    {
        $this->nr = 0;
        $this->poczatek = "";
        $this->koniec = "";
        $this->mecze = [];
        $this->stan = "";
    }


    public function __toString()
    {
        return ("kolejka " .$this->nr . ". {$this->poczatek}-{$this->koniec}<br>".$this->wypiszMecze()."<br>");


    }

    public function wypiszMecze(){
        foreach ($this->mecze as $m)
            echo $m['team_1'] ." {$m['team_1_wynik']}:{$m['team_2_wynik']} ".$m['team_2']."<br>";

    }

    public function addMecz($mecz){
        array_push($this->mecze, $mecz);
    }

    /**
     * @return int
     */
    public function getNr(): int
    {
        return $this->nr;
    }

    /**
     * @param int $nr
     */
    public function setNr(int $nr): void
    {
        $this->nr = $nr;
    }

    /**
     * @return string
     */
    public function getPoczatek(): string
    {
        return $this->poczatek;
    }

    /**
     * @param string $poczatek
     */
    public function setPoczatek(string $poczatek): void
    {
        $this->poczatek = $poczatek;
    }

    /**
     * @return string
     */
    public function getKoniec(): string
    {
        return $this->koniec;
    }

    /**
     * @param string $koniec
     */
    public function setKoniec(string $koniec): void
    {
        $this->koniec = $koniec;
    }

    /**
     * @return array
     */
    public function getMecze(): array
    {
        return $this->mecze;
    }

    /**
     * @param array $mecze
     */
    public function setMecze(array $mecze): void
    {
        $this->mecze = $mecze;
    }

    /**
     * @return string
     */
    public function getStan(): string
    {
        return $this->stan;
    }

    /**
     * @param string $stan
     */
    public function setStan(string $stan): void
    {
        $this->stan = $stan;
    }
/*
    public function __construct(int $nr, datetime $poczatek, datetime $koniec, array $mecze, string $stan)
    {
        $this->nr = $nr;
        $this->poczatek = $poczatek;
        $this->koniec = $koniec;
        $this->mecze = $mecze;
        $this->stan = $stan;
    }*/


}