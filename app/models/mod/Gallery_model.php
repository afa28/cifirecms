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

class Gallery_model extends CI_Model
{
    public $vars;
    private $_table = 't_gallery';

    public function __construct()
    {
        parent::__construct();
    }


    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }


    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->_table, $data);
    }


    public function delete($id = '')
    {
        $this->db->where('id', $id)->delete('t_gallery');
    }


    public function delete_album($id = '')
    {
        $this->db->where('id', $id)->delete('t_album');
        $this->db->where('id_album', $id)->delete('t_gallery');
    }


    public function all_album()
    {
        $query = $this->db
            ->where('active', 'Y')
            ->order_by('id', 'DESC')
            ->get('t_album')
            ->result_array();
        return $query;
    }


    public function get_gallerys($id_album = '')
    {
        $query = $this->db
            ->where('id_album', $id_album)
            ->order_by('id', 'DESC')
            ->get('t_gallery')
            ->result_array();
        return $query;
    }


    public function get_album($id_album = '')
    {
        $query = $this->db
            ->where('id', $id_album)
            ->get('t_album')
            ->row_array();

        return $query;
    }


    public function cek_id_album($id_album = '')
    {
        $query = $this->db
            ->where('id', $id_album)
            ->get('t_album')
            ->num_rows();

        return $query;
    }


    public function cek_id($id = '')
    {
        $num_rows = 0;
        
        if (!empty($id)) {
            $query = $this->db->select('id');
            $query = $this->db->where('id', $id);
            $query = $this->db->get($this->_table);
            $num_rows = $query->num_rows();

            if ($num_rows < 1) {
                $num_rows = 0;
            }
        }
        
        return $num_rows;
    }


    public function cek_seotitle($seotitle)
    {
        $query = $this->db->select('id,seotitle');
        $query = $this->db->where("BINARY seotitle = '$seotitle'", null, false);
        $query = $this->db->get($this->_table);
        $num_rows = $query->num_rows();

        if ($num_rows == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function cek_seotitle2($id, $seotitle)
    {
        $query = $this->db->select('id,seotitle');
        $query = $this->db->where("BINARY seotitle = '$seotitle'", null, false);
        $query = $this->db->get($this->_table);

        if (
            $query->num_rows() == '1' &&
            $query->row_array()['id'] == $id ||
            $query->num_rows() != '1'
           ) {
            return true;
        } else {
            return false;
        }
    }
} // End class.
