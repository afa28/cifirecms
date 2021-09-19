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

class Tag_model extends CI_Model
{
    public $vars;

    public function __construct()
    {
        parent::__construct();
    }

    public function cek_tag($seotitle = null)
    {
        $query = $this->db->where('seotitle', $seotitle);
        $query = $this->db->get('t_tag');
        $num_rows = $query->num_rows();

        if ($num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tag($seotitle)
    {
        $query = $this->db->where('seotitle', $seotitle);
        $query = $this->db->get('t_tag');
        return $query->row_array();
    }


    public function get_post($tag, $batas, $posisi)
    {
        $query = $this->db->select('
			t_post.id            AS  post_id,
			t_post.title         AS  post_title,
			t_post.seotitle      AS  post_seotitle,
			t_post.active        AS  post_active,
			t_post.content,
			t_post.picture,
			t_post.datepost,
			t_post.timepost,
			t_post.tag,
			t_post.hits,
			t_category.id        AS  category_id,
			t_category.title     AS  category_title,
			t_category.seotitle  AS  category_seotitle,
			t_user.name          AS  user_name
		');
        $query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'LEFT');
        $query = $this->db->join('t_user', 't_user.id = t_post.id_user', 'LEFT');
        $query = $this->db->where('t_post.active', 'Y');
        $query = $this->db->like('t_post.tag', $tag);
        $query = $this->db->order_by('t_post.id', 'DESC');
        $query = $this->db->limit($batas, $posisi);
        $query = $this->db->get('t_post');
        $result = $query->result_array();

        return $result;
    }


    public function jml_data($seotitle)
    {
        $query = $this->db->select('id');
        $query = $this->db->where('active', 'Y');
        $query = $this->db->like('tag', $seotitle);
        $query = $this->db->get('t_post');
        $result = $query->num_rows();

        return $result;
    }
} // End class.
