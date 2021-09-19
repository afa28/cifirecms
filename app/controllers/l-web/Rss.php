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

class Rss extends Web_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('web/rss_model');
        $this->load->helper('xml');
        $this->load->helper('text');
    }

    
    public function index($param='list', $param2='')
    {
        $param = seotitle($param);
        
        switch ($param) {
            case 'list':
                $this->rss_lists();
            break;

            case 'category':
                $this->rss_category($param2);
            break;

            case 'all-posts':
                $this->rss_allposts($param2);
            break;
            
            default:
                $this->render_404();
            break;
        }
    }


    private function rss_lists()
    {
        $this->vars['rss_lists'] = $this->rss_model->rss_lists();

        $this->meta_title('RSS - '.get_setting('web_name'));
        $this->render_view('rss');
    }

    
    private function rss_category($gSeotitle = '')
    {
        $seotitle = seotitle($gSeotitle);
        $category = $this->rss_model->get_category($seotitle);

        if (!empty($category)) {
            $this->vars['feed_datas'] = $this->rss_model->category($seotitle);
            $this->vars['feed_title'] = $category['title'].' - '.get_setting('web_name');
            $this->vars['feed_link'] = selft_url();
            $this->vars['feed_description'] = $category['description'];
            $this->vars['feed_language'] = 'en';
            $this->vars['feed_creator'] = get_setting('web_email');
            $this->vars['feed_copyright'] = 'Copyright '.date('Y').'. '.get_setting('web_name').' All Rights Reserved';
            header("Content-Type: application/rss+xml");
            $this->load->view('rss', $this->vars);
        } else {
            $this->render_404();
        }
    }


    private function rss_allposts()
    {
        $this->vars['feed_datas'] = $this->rss_model->all_posts('post_title,ASC', '5');

        $this->vars['feed_title'] = get_setting('web_name').' - '.get_setting('web_slogan');
        $this->vars['feed_link'] = selft_url();
        $this->vars['feed_description'] = get_setting('web_description');
        $this->vars['feed_language'] = 'en';
        $this->vars['feed_creator'] = get_setting('web_email');
        $this->vars['feed_copyright'] = 'Copyright '.date('Y').'. '.get_setting('web_name').' All Rights Reserved';
        header("Content-Type: application/rss+xml");
        $this->load->view('rss', $this->vars);
    }
}
