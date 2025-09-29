<?php
header('Content-Type: application/json; charset=utf-8');

$dataFile = __DIR__ . '/data/integradeu_data.json';
if(!file_exists(dirname($dataFile))){
    mkdir(dirname($dataFile), 0755, true);
}
if(!file_exists($dataFile)){
    $initial = array(
        "users" => new ArrayObject(),
        "schools" => new ArrayObject(),
        "courses" => array(
            array(
                "id" => 1,
                "title" => "Matemática ENEM",
                "description" => "Foco em álgebra, funções e geometria analítica.",
                "teacher" => "Prof. Álvaro",
                "lessons" => array(
                    array("title" => "Funções - Conceitos", "url" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ")
                )
            )
        )
    );
    file_put_contents($dataFile, json_encode($initial, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

$raw = file_get_contents('php://input');
$body = json_decode($raw, true);

function readData($path){
    $json = file_get_contents($path);
    return json_decode($json, true);
}

function writeData($path, $data){
    $tmp = $path . '.tmp';
    $encoded = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    file_put_contents($tmp, $encoded, LOCK_EX);
    rename($tmp, $path);
    return true;
}

$data = readData($dataFile);

function res($payload, $code=200){
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}

if($method === 'GET' && !$action){
    res($data);
}

// Resgistrar escola
if($method === 'POST' && $action === 'register_school'){
    if(!isset($body['email']) || !isset($body['password'])){
        res(['error'=>'email and password required'],400);
    }
    foreach($data['schools'] as $s){ if($s['email'] === $body['email']) res(['error'=>'school exists'],400); }
    $school = ['email'=>$body['email'],'password'=>$body['password'],'name'=>isset($body['name'])?$body['name']:$body['email']];
    $data['schools'][] = $school;
    writeData($dataFile,$data);
    res(['ok'=>true,'school'=>$school],201);
}

// Login escola
if($method === 'POST' && $action === 'login_school'){
    foreach($data['schools'] as $s){
        if($s['email'] === $body['email'] && $s['password'] === $body['password']){
            res(['ok'=>true,'school'=>$s]);
        }
    }
    res(['error'=>'invalid credentials'],401);
}

// registrar usuário (estudante)
if($method === 'POST' && $action === 'register_user'){
    if(!isset($body['email']) || !isset($body['password'])) res(['error'=>'email and password required'],400);
    foreach($data['users'] as $u){ if($u['email'] === $body['email']) res(['error'=>'user exists'],400); }
    $user = ['email'=>$body['email'],'password'=>$body['password']];
    $data['users'][] = $user;
    writeData($dataFile,$data);
    res(['ok'=>true,'user'=>$user],201);
}

// Login usuário
if($method === 'POST' && $action === 'login_user'){
    foreach($data['users'] as $u){
        if($u['email'] === $body['email'] && $u['password'] === $body['password']){
            res(['ok'=>true,'user'=>$u]);
        }
    }
    res(['error'=>'invalid credentials'],401);
}

// Add curso (escola)
if($method === 'POST' && $action === 'add_course'){
    if(!isset($body['title'])) res(['error'=>'title required'],400);
    $id = time();
    $course = [
        'id'=>$id,
        'title'=>$body['title'],
        'description'=>isset($body['description'])?$body['description']:'',
        'teacher'=>isset($body['teacher'])?$body['teacher']:'',
        'lessons'=>isset($body['lessons'])?$body['lessons']:array()
    ];
    $data['courses'][] = $course;
    writeData($dataFile,$data);
    res(['ok'=>true,'course'=>$course],201);
}

if($method === 'POST' && $action === 'add_lesson'){
    if(!isset($body['course_id']) || !isset($body['title']) || !isset($body['url'])) res(['error'=>'course_id,title,url required'],400);
    $found=false;
    foreach($data['courses'] as &$c){
        if($c['id'] == $body['course_id']){
            if(!isset($c['lessons'])) $c['lessons']=array();
            $c['lessons'][] = array('title'=>$body['title'],'url'=>$body['url']);
            $found=true;
            break;
        }
    }
    if(!$found) res(['error'=>'course not found'],404);
    writeData($dataFile,$data);
    res(['ok'=>true],201);
}

// Editar
if($method === 'POST' && $action === 'edit_lesson'){
    if(!isset($body['course_id']) || !isset($body['lesson_index']) || !isset($body['title']) || !isset($body['url']))
        res(['error'=>'course_id, lesson_index, title, url required'],400);
    foreach($data['courses'] as &$c){
        if($c['id'] == $body['course_id']){
            if(isset($c['lessons'][$body['lesson_index']])){
                $c['lessons'][$body['lesson_index']]['title'] = $body['title'];
                $c['lessons'][$body['lesson_index']]['url'] = $body['url'];
                writeData($dataFile,$data);
                res(['ok'=>true],200);
            }
        }
    }
    res(['error'=>'curso ou aula não encontrada'],404);
}

// Deletar
if($method === 'POST' && $action === 'delete_lesson'){
    if(!isset($body['course_id']) || !isset($body['lesson_index']))
        res(['error'=>'course_id, lesson_index required'],400);
    foreach($data['courses'] as &$c){
        if($c['id'] == $body['course_id']){
            if(isset($c['lessons'][$body['lesson_index']])){
                array_splice($c['lessons'],$body['lesson_index'],1);
                writeData($dataFile,$data);
                res(['ok'=>true],200);
            }
        }
    }
    res(['error'=>'curso ou aula não encontrada'],404);
}

if($method === 'POST' && $action === 'delete_course'){
    if(!isset($body['course_id'])) res(['error'=>'course_id required'],400);

    $found = false;
    foreach($data['courses'] as $k => $c){
        if($c['id'] == $body['course_id']){
            array_splice($data['courses'], $k, 1);
            $found = true;
            break;
        }
    }

    if($found){
        writeData($dataFile, $data);
        res(['ok'=>true],200);
    } else {
        res(['error'=>'curso nao encontrado'],404);
    }
}

res(['error'=>'unknown action or method','action'=>$action,'method'=>$method],404);
?>
