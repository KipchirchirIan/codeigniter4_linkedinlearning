<?php


namespace App\Models;


use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class Property extends Model
{

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->db = \Config\Database::connect('default');
    }

    public function getSingle($id)
    {
        $where['id'] = $id;
        $result = $this->db->table('properties')->where('id', $where)->get();

        return $result->getRowArray();
    }

    public function updateSingle($id, $new_data)
    {
        $where['id'] = $id;
        $this->db->table('properties')->update($new_data, $where);
    }

    public function get_version()
    {
        return $this->db->query('SELECT VERSION();')->getResult();
    }

    public function connection_test()
    {
        $db = db_connect();
    }

    public function getAll()
    {
        $result_set = $this->db->table('properties')->get();
        return $result_set->getResultArray();
    }
}