<?php

#returns 1, 0 or false on error
function validatePhone($input){
  if(preg_match("/^(\([0-9]{3}\)\-[0-9]{3}\-[0-9]{4}|([0-9]{3}\-?){2}[0-9]{4})$/",$input)){
    return 0;
  }else{
    return "<div class='alert alert-danger' role='alert'>Invalid phone number</div>";
  }
}
function validateName($input){
  if(preg_match("/^([a-z]|[A-Z])+$/",$input)){
    return 0;
  }else{
    return "<div class='alert alert-danger' role='alert'>Invalid name fields</div>";
  }
}
function validateEmail($input){
  if(preg_match("/^([a-z]|[A-Z]|[0-9])+@([a-z]|[A-Z]|[0-9])+\.([a-z]|[A-Z]|[1-9]){2,3}$/",$input)){
    return 0;
  }else{
    return "<div class='alert alert-danger' role='alert'>Invalid email</div>";
  }
}
function validateWNumber($input){
  return preg_match("/^(w|W)[0-9]{8}$/",$input[0]);
}





?>
