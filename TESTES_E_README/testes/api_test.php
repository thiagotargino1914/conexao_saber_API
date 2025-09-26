<?php
function call($action, $body){
    $ch = curl_init("http://localhost/conexaosaber_repo/api.php?action=$action");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

echo "Testando registro de escola...\n";
echo call("register_school", ["email"=>"teste@escola.com","password"=>"1234"])."\n";

echo "Testando login de escola...\n";
echo call("login_school", ["email"=>"teste@escola.com","password"=>"1234"])."\n";

echo "Testando registro de aluno...\n";
echo call("register_user", ["email"=>"aluno@teste.com","password"=>"1234","school_email"=>"teste@escola.com"])."\n";

echo "Testando login de aluno...\n";
echo call("login_user", ["email"=>"aluno@teste.com","password"=>"1234"])."\n";
?>
