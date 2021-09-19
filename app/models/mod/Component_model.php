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

class Component_model extends CI_Model
{
    public $vars;
    private $_table = 't_component';
    private $_column_order = array('name', 'class', null);
    private $_column_search = array('id', 'name');

    public function __construct()
    {
        parent::__construct();
    }


    public function datatable($method, $type = 'data')
    {
        $result = null;

        if ($type === 'count') {
            $this->$method();
            $result = $this->db->get()->num_rows();
        }

        if ($type === 'data') {
            $this->$method();
            if ($this->input->post('length') != -1) {
                $length = xss_filter($this->input->post('length'), 'xss');
                $start = xss_filter($this->input->post('start'), 'xss');
                $this->db->limit($length, $start);
                $query = $this->db->get();
            } else {
                $query = $this->db->get();
            }
            
            $result = $query->result_array();
        }

        return $result;
    }



    private function _all_component()
    {
        $this->db->select('id,name,class');
        $this->db->from($this->_table);

        $i = 0;
        foreach ($this->_column_search as $item) {
            if ($this->input->post('search')['value']) {
                $search_key = xss_filter($this->input->post('search')['value'], 'xss');
                $search_key = trim($search_key);
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $search_key);
                } else {
                    $this->db->like($item, $search_key);
                }

                if (count($this->_column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        
        if (!empty($this->input->post('order'))) {
            $field = xss_filter($this->_column_order[$this->input->post('order')['0']['column']], 'xss');
            $value = xss_filter($this->input->post('order')['0']['dir'], 'xss');
            $this->db->order_by($field, $value);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }



    public function get_modul($id = 0)
    {
        if ($this->cek_id($id) == 1) {
            $query = $this->db->where('id', $id)->get($this->_table)->row_array();
            return $query;
        } else {
            return false;
        }
    }


    public function insert($data)
    {
        $query = $this->db->insert($this->_table, $data);
        
        if ($query == false) {
            return false;
        } else {
            return true;
        }
    }


    public function delete($id = 0, $table_name = '')
    {
        if (!empty($table_name) && $this->cek_id($id) == 1) {
            $this->load->dbforge();
            
            if ($this->dbforge->drop_table($table_name, true)) {
                $this->db->where('id', $id)->delete($this->_table);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function cek_id($id = 0)
    {
        $query = $this->db->select('id');
        $query = $this->db->where('id', $id);
        $query = $this->db->get($this->_table);
        $query = $query->num_rows();
        $int = (int)$query;
        return $int;
    }
} // End Class.
