<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Mobil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .car-info {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php
class Car {
    public $name;
    public $color;

    function set_name($name) {
        $this->name = $name;
    }
    function get_name() {
        return $this->name;
    }
    function set_color($color) {
        $this->color = $color;
    }
    function get_color() {
        return $this->color;
    }
}

$toyota = new Car();
$toyota->set_name('Toyota');
$toyota->set_color('Biru Metalik');
?>

<div class="container">
    <h1>Informasi Mobil</h1>
    <div class="car-info">
        <p><strong>Nama:</strong> <?php echo $toyota->get_name(); ?></p>
        <p><strong>Warna:</strong> <?php echo $toyota->get_color(); ?></p>
    </div>
    <img src="toyota-c-hr-hybrid-color-636444.avif" alt="Flowers in Chania" width="460" height="345">
</div>

</body>
</html>