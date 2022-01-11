<?php

class Kolejka
{
    private int $nr;
    private datetime $poczatek;
    private datetime $koniec;
    private array $mecze;
    private string $stan;


    public function __construct(int $nr, datetime $poczatek, datetime $koniec, array $mecze, string $stan)
    {
        $this->nr = $nr;
        $this->poczatek = $poczatek;
        $this->koniec = $koniec;
        $this->mecze = $mecze;
        $this->stan = $stan;
    }


}