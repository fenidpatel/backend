<?php
class Fruit{
    public $name;
    public $color;
    public $weight;

    function set_name($n) { // a public function(default)
        $this->name = $n;
    }
    protected function set_color($n){ // a protected function
        $this->color = $n;
    }
    private function set_weight($n){ // a private function
        $this->weight = $n;
    }
    public function set_all($name, $color, $weight){
        $this->set_name($name);
        $this->set_color($color);
        $this->set_weight($weight);
    }
}

$mango = new Fruit();
$mango->set_name('Mango'); //ok
// $mango->set_color('Yellow'); // Error
// $mango->set_weight('300'); // Error
$mango->set_all('Mango', 'Yellow', '300');
echo("OK");
?>

