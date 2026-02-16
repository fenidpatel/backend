<?php
class customException extends Exception {
    public function errorMessage(){
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
        .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
        return $errorMsg;
    }
}

$email = "someone@example.com";

try{
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE){
        throw new customException($email);
    }else{
        echo("valid Email");
    }
} catch(customException $e) {
    echo $e->errorMessage();
}
?>