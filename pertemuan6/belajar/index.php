<?php

define("SITE_NAME", "unsika.ac.id");
define("VERSION", "v1.0");

echo "Selamat datang di " . SITE_NAME . "<br>";
echo "Version " . VERSION . "<br> <br>";

class Hello
{
    public $name;
    public $age;
    public $weight;
    public $hobi;
    public $myBini;

    public function sapa()
    {
        echo "Halo, Saya: " . $this->name;
        echo "<br>";
        echo "Umur: " . $this->age;
        echo "<br>";
        echo "Berat: " . $this->weight . "Kg";
        echo "<br>";
        echo "Hobi: " . implode(", ", $this->hobi);
        echo "<br>";
        echo "My Bini Pertama: " . $this->myBini[0];
        echo "<br>";
        echo "My Bini Kedua: " . $this->myBini[1];
    }
}

$mhs = new Hello();
$mhs->name = "Biji";
$mhs->age = 20;
$mhs->weight = 50;
$mhs->hobi = ["Musik", "Olahraga", "Membaca"];
$mhs->myBini = ["Herta", "Firefly"];
echo $mhs->sapa();
