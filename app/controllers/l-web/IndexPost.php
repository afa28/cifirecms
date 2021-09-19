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

class IndexPost extends Web_controller
{
    public $mod = 'indexpost';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('web/index_model');
    }

    public function index($get_page = 1)
    {
        // $get_page = xss_filter($get_page, 'sql');
        $get_page = xss_filter($this->input->get('page'), 'sql');
        $page   = ($get_page==0 ? 1 : $get_page);
        $batas  = get_setting('page_item');
        $posisi = ($page-1) * $batas;

        $config['base_url']   = site_url($this->mod.'?page=');
        $config['index_page'] = $page;
        $config['total_rows'] = $this->index_model->total_post();
        $this->cifire_pagination->initialize($config);
        $this->vars['page_link'] = $this->cifire_pagination->create_links();

        $data_post = $this->index_model->index_post($batas, $posisi);

        if ($data_post) {
            $this->vars['data_post'] = $data_post;

            $this->meta_title('Index Post - '. get_setting('web_name'));
            $this->render_view('index_post');
        } else {
            $this->render_404();
        }
    }
} // End class
