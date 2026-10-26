<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases 2</title>
</head>
<body>
    <?php
    class Coche {
        // Los atributos por lo general suelen ser privados
        public $marca;
        public $modelo;
        private $color;

        /* Constructor de la clase: es el método que es invocado
        cada vez que se crea un nuevo objeto de la clase */
        public function __construct($marca, $modelo, $color) {
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->color = $color;
        }

        // Getter y setter del atributo color
        public function getColor() {
            return $this->color;
        }

        public function setColor($color) {
            // Tener el setter me permite implementar reglas
            if ($color === "Blanco" || $color === "Gris" 
                || $color === "Rojo" || $color === "Plata") {
                    $this->color = $color;
            } else {
                echo "El color $color no está permitido<br>";
            }
        }

        public function verDetalles() {
            echo "Marca: " . $this->marca . " - " . "Modelo: " 
                . $this->modelo . " - " . "Color: " . $this->color . "<br>";
        }
    } // Aquí termina la definición de la clase Coche

    $coche1 = new Coche("Volvo", "CX90", "Gris");
    $coche1->verDetalles();
    $coche2 = new Coche("Seat", "León", "Plata");
    $coche2->verDetalles();
    $coche3 = new Coche("Ford", "Mustang", "Rojo");
    $coche3->verDetalles();
    
    // Mostrar en pantalla el color del coche2:
    echo $coche2->getColor() . "<br>";

    // Ver en pantalla el modelo del coche3:
    echo $coche3->modelo . "<br>";

    // Modificar el atributo color del coche1:
    $coche1->setColor("Blanco");
    $coche1->verDetalles();
    $coche3->setColor("Verde");
    $coche3->verDetalles();
    ?>
</body>
</html>