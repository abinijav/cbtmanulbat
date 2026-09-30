<?php

class Auth_model extends CI_Model
{
    public function register($data, $group) {
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();
        $group = [
            'user_id' => $id,
            'group_id' => $group
        ];
        return $this->db->insert('users_groups', $group);
    }

    public function login($username) {
        return $this->db->select('a.*, b.user_id, b.group_id, c.id as role, c.name as role_name, c.description')
            ->from('users a')
            ->where(['a.username' => $username])
            ->join('users_groups b', 'a.id=b.user_id')
            ->join('groups c', 'b.group_id=c.id')
            ->get()->row();
    }

    public function cekPercobaanLogin($username) {
        return $this->db->get_where('login_attempts', ['login' => $username])->result();
    }

}