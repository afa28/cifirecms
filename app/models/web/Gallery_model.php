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
    
    public function __construct()
    {
        parent::__construct();
    }
    

    public function all_albums()
    {
        $query = $this->db->select();
        $query = $this->db->from('t_album');
        $query = $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_album($id='')
    {
        return $this->db->where('id', $id)->get('t_album')->row_array();
    }



    public function album_cover($id_album = '')
    {
        $result = '';
        if (!empty($id_album)) {
            $query = $this->db->select('picture,title');
            $query = $this->db->from('t_gallery');
            $query = $this->db->where('id_album', $id_album);
            $query = $this->db->order_by('id', 'DESC');
            $query = $this->db->limit(1);
            $query = $this->db->get();
            $result = $query->row_array();
        }
        return $result;
    }


    public function get_gallery_images($id_album = '')
    {
        $result = [];
        if (!empty($id_album)) {
            $query = $this->db->select('*');
            $query = $this->db->from('t_gallery');
            $query = $this->db->where('id_album', $id_album);
            $query = $this->db->order_by('id', 'DESC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function all_galleri_images()
    {
        $query = $this->db->select('*');
        $query = $this->db->from('t_gallery');
        $query = $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
} // End class.
