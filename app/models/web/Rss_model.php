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

class Rss_model extends CI_Model
{
    public $vars;

    public function __construct()
    {
        parent::__construct();
    }

    public function rss_lists()
    {
        $query = $this->db->select('title,seotitle');
        $query = $this->db->where_not_in('id', 1);
        $query = $this->db->order_by('title', 'ASC');
        $query = $this->db->get('t_category');
        $result = $query->result_array();
        return $result;
    }

    public function get_category($seotitle)
    {
        return $this->db->where('seotitle', $seotitle)->get('t_category')->row_array();
    }


    public function category($param='')
    {
        $query = $this->db->select('
					 t_post.id              AS  post_id,
					 t_post.title           AS  post_title,
					 t_post.seotitle        AS  post_seotitle,
					 t_post.active          AS  post_active,
					 t_post.content         AS  post_content,
					 t_post.picture         AS  post_picture,
			         t_post.datepost,
			         t_post.timepost,
			         t_post.tag,
			         t_post.hits,

					 t_category.id           AS  category_id,
					 t_category.title        AS  category_title,
					 t_category.seotitle     AS  category_seotitle,
					 t_category.description     AS  category_description,
					 
					 t_user.id               AS  user_id,
					 t_user.name             AS  user_name
					');
        $query = $this->db->from('t_post');
        $query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
        $query = $this->db->join('t_user', 't_user.id = t_post.id_user', 'left');
        $query = $this->db->where('t_post.active', 'Y');
        $query = $this->db->where('t_category.seotitle', $param);
        $query = $this->db->order_by('t_post.id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    
    public function all_posts()
    {
        $query = $this->db->select('
					 t_post.id                 AS  post_id,
					 t_post.title              AS  post_title,
					 t_post.seotitle           AS  post_seotitle,
					 t_post.active             AS  post_active,
					 t_post.content            AS  post_content,
					 t_post.picture            AS  post_picture,
			         t_post.datepost,
			         t_post.timepost,
			         t_post.tag,
			         t_post.hits,

					 t_category.id              AS  category_id,
					 t_category.title           AS  category_title,
					 t_category.seotitle        AS  category_seotitle,
					 t_category.description     AS  category_description,
					 
					 t_user.id                  AS  user_id,
					 t_user.name                AS  user_name
					');
        $query = $this->db->from('t_post');
        $query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
        $query = $this->db->join('t_user', 't_user.id = t_post.id_user', 'left');
        $query = $this->db->where('t_post.active', 'Y');
        $query = $this->db->order_by('post_id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
} // End class.
