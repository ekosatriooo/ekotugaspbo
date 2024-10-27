<h2 style="color: blue;" align=""left"">Pertemuan-5 </h1>

<h3 style="color: black;" align=""left"">Konstanta dan Abstrak </h1>
<h4 style="color: black;" align=""left"">Konstanta</h1>

<br>
<?php

class komputer {

    const DOLLAR = '12000';
}


echo "Harga dollar saat ini = Rp. ".komputer::DOLLAR;
?>

<br>
<?php
class Selamat_Tinggal {
    const LEAVING_MESSAGE = "Terima kasih sudah berkunjung";
    public function byebye() {
        echo self::LEAVING_MESSAGE;
    }
}

$selamat_tinggal = new Selamat_tinggal();
$selamat_tinggal->byebye();
?>

<h4 style="color: black;" align=""left"">Abstrak</h1>


<?php
abstract class Mobil {
    public $nama;
    public function __construct($nama) {
        $this->nama = $nama;
    }
    abstract public function intro() : string;
}

class Audi extends Mobil {
    public function intro() : string {
        return "Untuk kualitas terbaik! Saya pilih $this->nama!";
    }
}

class Volvo extends Mobil {
    public function intro() : string {
        return "Untuk hemat bahan bakar! Saya pilih $this->nama!";
    }
}

class Citroen extends Mobil {
    public function intro() : string {
        return "Untuk purna jual! Saya pilih $this->nama!";
    }
}
$audi = new audi("BWM");
echo $audi->intro();
echo "<br>";

$volvo = new volvo("Panther");
echo $volvo->intro();
echo "<br>";

$citroen = new citroen("Toyota");
echo $citroen->intro();
echo "<br>";
?>

<br>
<?php

abstract class ParentClass {
    abstract protected function prefixName($nama);
}

class ChildClass extends ParentClass {
    public function prefixName($nama) {
        if ($nama == "Ahmad Sulistiyo") {
            $prefix = "Mr.";
        } elseif ($nama == "Siti Aisyah") {
            $prefix = "Miss.";
        }else {
            $prefix = "";
        }
        return "{$prefix} {$nama}";
    }
}

$class = new Childclass;
echo $class->prefixName("Ahmad Sulistiyo");
echo "<br>";
echo $class->prefixName("Siti Aisyah");
echo "<br>";
?>


<?php

abstract class ParentClass2 {
    abstract protected function prefixName($nama);
}

class ChildClass2 extends ParentClass2 {
    public function prefixName($nama, $separator =
     ".", $greet = "Dear") {
        if ($nama == "Ahmad Sulistiyo") {
            $prefix = "Mr";
        } elseif ($nama == "Siti Aisyah") {
            $prefix = "Miss";
        } else {
            $prefix = "";
        }
        return "{$greet} {$prefix} {$separator} {$nama}";
    }
}

$class = new ChildClass2;
echo "<br>";
echo $class->prefixName("Ahmad Sulistiyo");
echo "<br>";
echo $class->prefixName("Siti Aisyah");
?>