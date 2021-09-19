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

class Theme_model extends CI_Model
{
    private $table = 't_theme';

    public function __construct()
    {
        parent::__construct();
    }


    public function insert(array $data)
    {
        $this->db->insert($this->table, $data);
    }


    public function update($id = 0, array $data)
    {
        if ($this->cek_id($id) == 1) {
            $this->db->where('id', $id)->update($this->table, $data);
            return true;
        } else {
            return false;
        }
    }


    public function delete($id = 0)
    {
        if ($this->cek_id($id) == 1) {
            $this->db->where('id', $id)->delete($this->table);
            return true;
        } else {
            return false;
        }
    }


    public function active_theme($id = 0)
    {
        if ($this->cek_id($id) == 1) {
            $get_active_theme = $this->db->where('active', 'Y')->get($this->table)->row_array();
            $id_theme_active = $get_active_theme['id'];

            if ($this->update($id_theme_active, array('active'=>'N'))) {
                $this->update($id, array('active'=>'Y'));
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function all_themes()
    {
        $query = $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table);
        $result = $query->result_array();
        return $result;
    }


    public function get_theme($id = 0)
    {
        if ($this->cek_id($id) == 1) {
            $query = $this->db->where('id', $id);
            $query = $this->db->get($this->table);
            $result = $query->row_array();
            return $result;
        } else {
            return null;
        }
    }


    public function cek_id($id = 0)
    {
        if (empty($id) || $id==0) {
            return 0;
        } else {
            $query = $this->db->select('id');
            $query = $this->db->where('id', $id);
            $query = $this->db->get($this->table);
            $result = $query->num_rows();

            if ($result == 1) {
                return $result;
            } else {
                return 0;
            }
        }
    }


    public function cek_theme_folder($param = '')
    {
        $query = $this->db->select('folder')->where('folder', $param)->get($this->table)->num_rows();

        if ($query == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function cek_seotitle($seotitle = '')
    {
        if (!empty($seotitle)) {
            $query = $this->db->select('seotitle');
            $query = $this->db->where("BINARY seotitle = '$seotitle'", null, false);
            $query = $this->db->get($this->table);
            $query = $query->num_rows();

            if ($query == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function cek_seotitle2($id = 0, $seotitle = '')
    {
        if ($id != 0 && !empty($id) && !empty($seotitle)) {
            $query = $this->db->select('id,seotitle');
            $query = $this->db->where("BINARY seotitle = '$seotitle'", null, false);
            $query = $this->db->get($this->table);

            if (
                $query->num_rows() == 1 &&
                $query->row_array()['id'] == $id ||
                $query->num_rows() != 1
               ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
} // End class.
