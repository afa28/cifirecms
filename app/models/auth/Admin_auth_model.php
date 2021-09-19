<?php

/*
 * MIT License
 *
 * Copyright (c) 2019 - 2021 CiFireCMS
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package	CiFireCMS
 * @author	Adiman
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://github.com/CiFireCMS/cifirecms
 * @since	Version 2.0.1
 * @filesource
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function cek_user($input_username = '')
    {
        $username = decrypt($input_username);
        $query = $this->db->where("BINARY username = '".$username."'", null, false);
        $query = $this->db->where('active', 'Y');
        $query = $this->db->get('t_user');
        return $query->num_rows();
    }


    public function cek_login($input)
    {
        $query = $this->db->where("BINARY username = '".$input['username']."'", null, false);
        $query = $this->db->where('active', 'Y');
        $query = $this->db->get('t_user');

        if ($query->num_rows() == 1) {
            $userdata = $query->row_array();

            if (decrypt($userdata['password']) == decrypt($input['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function get_user($input)
    {
        $query = $this->db->where("BINARY username = '".$input['username']."'", null, false);
        $query = $this->db->get('t_user');
        $query = $query->row_array();
        return $query;
    }
} // End class.
