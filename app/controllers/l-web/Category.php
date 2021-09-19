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

class Category extends Web_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('web/category_model');
    }
    
    
    public function index($get_seotitle = null, $get_page = 1)
    {
        $seotitle = xss_filter($get_seotitle, 'xss');
        $check_seotitle = $this->category_model->check_seotitle($seotitle);

        if (!empty($seotitle) && $check_seotitle == true) {
            $result_category = $this->category_model->get_data($seotitle);
            
            $get_page = xss_filter($get_page, 'sql');
            $page     = ($get_page==0 ? 1 : $get_page);
            $batas    = get_setting('page_item');
            $posisi   = ($page-1) * $batas;

            $config['base_url']     = site_url('category/'.$seotitle.'/');
            $config['index_page']   = $page;
            $config['total_rows']   = $this->category_model->total_category_post($result_category['id']);
            
            $this->cifire_pagination->initialize($config);
            
            $this->vars['page_link']       = $this->cifire_pagination->create_links();
            $this->vars['result_category'] = $result_category;
            $this->vars['category_post']   = $this->category_model->get_post($result_category['id'], $batas, $posisi);

            if ($this->vars['category_post']) {
                $this->meta_title($result_category['title'].' - '.get_setting('web_name'));
                $this->meta_keywords($result_category['title'].', '.get_setting('web_keyword'));
                $this->meta_description($result_category['description']);
                $this->meta_image(post_images($result_category['picture'], 'medium', true));
                $this->render_view('category');
            } else {
                $this->render_404();
            }
        } else {
            $this->render_404();
        }
    }
} // End class.
