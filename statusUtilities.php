<?php
require __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// statusUtilities
class StatusUtilities
{
    public $user;
    private $conn;

    public function __construct($id)
    {
        $servername = "localhost";
        $username = "fambo";
        $password = $_ENV['DBPW'];

        $this->conn = new PDO("mysql:host=$servername;dbname=portal", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
        $stmt->execute([$_SESSION['id']]);
        $this->user = $stmt->fetch();
        $this->carbon = new Carbon();
    }

    public function getStatusOptions()
    {
        $stmt = $this->conn->query("SELECT status FROM options");
        $options = $stmt->fetchAll();
        $options = array_column($options, 'status');
        $this->user['options'] = $options;
        return $this->user['options'];
    }

    public function submitAll($data)
    {
        $sql = "UPDATE users SET name=? WHERE id=?";
        $this->conn->prepare($sql)->execute([$data['name'], $data['id']]);

        $now = $this->carbon->sub('0 hours')->format('n/j/y g:ia');
        $status = $data['status'];
        if ($data['optionStatus'] != '') {
            $status = $data['optionStatus'];
        }
        $sql2 = "INSERT INTO status (user_id, status, created_at) VALUES (?,?,?)";
        $this->conn->prepare($sql2)->execute([$data['id'], $status, $now]);

    }

    public function getCurrentStatus()
    {
        $stmt = $this->conn->prepare("SELECT status FROM status WHERE user_id=? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$_SESSION['id']]);
        $status = $stmt->fetch();
        if (!$status) {
            $this->user['status'] = '';
            return $this->user['status'];
        }
        $this->user['status'] = $status[0];
        return $this->user['status'];
    }

    public function getCurrentName()
    {
        return $this->user['name'];
    }

    public function getCurrentPic()
    {
        return $this->user['picture'];
    }

    public function getOldStatus($id)
    {
        //
    }

    public function setStatus($id)
    {
        //
    }

    public function setName($id)
    {
        //
    }

    public function setPic($id)
    {
        //
    }

}