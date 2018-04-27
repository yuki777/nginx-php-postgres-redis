<?php
require_once __DIR__ . '/../vendor/autoload.php';

if(! isLocal()) exit;

test();

function isLocal(){
    if($_SERVER['HTTP_HOST'] === 'localhost') return true;
    return false;
}

function test(){
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode([
        //'mysql'     => mysql(),
        'redis'     => redis(),
        'postgres'  => postgres(),
        //'mongo'     => mongo(),
        //'memcached' => memcached(),
    ]);
}

//function mysql(){
//    $dbname = $_ENV['MYSQL_DATABASE'];
//    $dbhost = $_ENV['DATABASE_HOST'];
//    $dbuser = $_ENV['MYSQL_USER'];
//    $dbpass = $_ENV['MYSQL_PASSWORD'];
//    $dsn = "mysql:dbname={$dbname};host={$dbhost}";
//
//    try {
//        $db = new PDO($dsn, $dbuser, $dbpass);
//        $db->query('create table if not exists sample_table(id int primary key auto_increment, data text)');
//        $db->query("insert into logs(created_at)values(now())");
//        $count = false;
//        $q = $db->query('select count(*) as count from logs');
//        if($q){
//            foreach ($q as $row) {
//                $count = (int) $row['count'];
//            }
//        }
//
//        return ['count' => $count , 'status' => true];
//    } catch (Exception $e) {
//        return ['count' => false, 'status' => $e->getMessage()];
//    }
//}

function redis(){
    try{
        $redis = new Redis();
        $redis->connect('redis', 6379);

        $count = (int) $redis->get('count');
        $redis->set('count', $count + 1);

        return ['count' => $count , 'status' => true];
    }catch(Exception $e){
        return ['count' => false, 'status' => $e->getMessage()];
    }
}

function postgres(){
    $dbname = $_ENV['POSTGRES_DB'];
    $dbhost = $_ENV['DATABASE_HOST'];
    $dbuser = $_ENV['POSTGRES_USER'];
    $dbpass = $_ENV['POSTGRES_PASSWORD'];
    $dsn = "pgsql:dbname={$dbname};host={$dbhost}";

    try {
        $db = new PDO($dsn, $dbuser, $dbpass);
        $db->query('create table if not exists sample_table(id serial, data text)');
        $db->query("insert into sample_table(data)values(now())");
        $count = false;

        $q = $db->query('select count(*) as count from sample_table');
        if($q){
            foreach ($q as $row) {
                $count = (int) $row['count'];
            }
        }

        return ['count' => $count , 'status' => true];
    } catch (Exception $e) {
        return ['count' => false, 'status' => $e->getMessage()];
    }
}
//
//function mongo(){
//    try{
//        $manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");
//
//        $bulk = new MongoDB\Driver\BulkWrite;
//        $bulk->insert(['foo' => 'bar', 'date' => date('Y-m-d H:i:s')]);
//        $manager->executeBulkWrite('sample_database.sample_collection', $bulk);
//
//        $filter = ['foo' => ['$eq' => 'bar']];
//        $options = [
//            'projection' => ['_id' => 0],
//            'sort' => ['_id' => -1],
//        ];
//        $query = new MongoDB\Driver\Query($filter, $options);
//        $cursor = $manager->executeQuery('sample_database.sample_collection', $query);
//        $count = count($cursor->toArray());
//
//        return ['count' => $count , 'status' => true];
//    }catch(Exception $e){
//        return ['count' => false, 'status' => $e->getMessage()];
//    }
//}
//
//function memcached(){
//    try{
//        $memcached = new Memcached();
//        $memcached->addServer("memcached", 11211);
//
//        $count = (int) $memcached->get('count');
//        $memcached->set('count', $count + 1);
//
//        return ['count' => $count , 'status' => true];
//    }catch(Exception $e){
//        return ['count' => false, 'status' => $e->getMessage()];
//    }
//}
