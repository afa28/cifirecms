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

class Tag extends Web_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('web/tag_model');
    }
    
    public function index($seotitle = '', $get_page = 1)
    {
        $seotitle = xss_filter($seotitle, 'xss');
        
        if (!empty($seotitle) && $this->tag_model->cek_tag($seotitle)) {
            $get_page = xss_filter($get_page, 'sql');
            $page   = ($get_page==0 ? 1 : $get_page);
            $batas  = get_setting('page_item');
            $posisi = ($page-1) * $batas;

            $config['base_url']   = site_url("tag/$seotitle/");
            $config['index_page'] = $page;
            $config['total_rows'] = $this->tag_model->jml_data($seotitle);
            $this->cifire_pagination->initialize($config);
            $this->vars['page_link'] = $this->cifire_pagination->create_links();
            
            $data_tag = $this->tag_model->get_tag($seotitle);
            $this->vars['result_tag'] = $data_tag;
            $this->vars['tag_post']   = $this->tag_model->get_post($data_tag['seotitle'], $batas, $posisi);

            if ($this->vars['tag_post']) {
                $this->meta_title($data_tag['title'].' - '.get_setting('web_name'));
                $this->meta_keywords($data_tag['title'].', '.get_setting('web_keyword'));
                $this->meta_description(get_setting('web_description'));
                $this->render_view('tag');
            } else {
                $this->render_404();
            }
        } else {
            $this->render_404();
        }
    }
} // End class.
