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

class Global_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function insert($table, array $data)
    {
        $this->db->insert($this->_table, $data);
    }


    public function delete_by_id($table = '', $id = '')
    {
        $cek_id = $this->cek_id($table, $id);
        
        if ($cek_id == 1) {
            $this->db->where('id', $id)->get($table);
            return true;
        } else {
            return false;
        }
    }


    public function cek_id($table = '', $id = 0)
    {
        $int = 0;
        if ($id!=0 && !empty($id) && !empty($table)) {
            $query = $this->db->where('id', $id)->get($table)->num_rows();
            
            if ($query == 1) {
                $int = 1;
            }
        }

        return $int;
    }


    public function get_theme_active()
    {
        $query = $this->db->where('active', 'Y')->get('t_theme')->row_array();
        return $query;
    }


    public function get_setting()
    {
        $query = $this->db->get('t_setting')->row_array();
        return $query;
    }
} // End class
