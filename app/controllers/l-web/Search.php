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

class Search extends Web_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('web/search_model');
    }
    

    public function index()
    {
        if ($this->input->method() == 'post' && !empty($this->input->post('kata'))) {
            $kata = $this->input->post('kata');
            $urlq = url_encode($kata);
            redirect(site_url('search?q='.$urlq));
        } else {
            $q = !empty($this->input->get('q')) ? $this->input->get('q') : null;
            $decq = urldecode($q);
            $get_q = $decq;
            $keywords = $this->_validate($get_q);

            if (!empty($keywords)) {
                $get_page = xss_filter($this->input->get('page', true), 'sql');
                $get_page = ($get_page == 0 ? 1 : $get_page);
                $batas    = get_setting('page_item');
                $posisi   = ($get_page-1) * $batas;
                $jml_data = $this->search_model->jml_data($keywords);

                $config['base_url']     = site_url('search?q='.url_encode($get_q).'&page=');
                $config['index_page']   = $get_page;
                $config['total_rows']   = $jml_data;
                $config['per_page']     = $batas;
                $this->cifire_pagination->initialize($config);
                $this->vars['page_link'] = $this->cifire_pagination->create_links();

                $this->vars['search_results'] = $this->search_model->Search($keywords, 'hits DESC', $batas, $posisi);

                $this->vars['num_post'] = $jml_data;
                $this->vars['keywords'] = $keywords;

                $this->meta_title('Search - '.get_setting('web_name'));
                $this->meta_keywords($keywords);
                $this->meta_description(get_setting('web_description'));

                $this->render_view('search');
            } else {
                $this->render_404();
            }
        }
    }

    private function _validate($param='')
    {
        $str = clean_space(trim($param));
        $str = xss_filter($str, 'xss');
        return $str;
    }
} // End class.
