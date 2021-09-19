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

class Pages extends Web_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('web/pages_model');
    }
    
    
    public function index($get_seotitle = '')
    {
        $seotitle = xss_filter($get_seotitle, 'xss');
        $cek_seotitle = $this->pages_model->check_seotitle($seotitle);

        if (!empty($get_seotitle) && $cek_seotitle == true) {
            $data = $this->pages_model->get_data($seotitle);
            $this->vars['result_pages'] = $data;
            
            $this->meta_title($data['title'].' - '.get_setting('web_name'));
            $this->meta_description(cut($data['content'], 150));
            $this->meta_image(post_images($data['picture'], 'medium'));
            $this->render_view('pages');
        } else {
            $this->render_404();
        }
    }
} // End class.
