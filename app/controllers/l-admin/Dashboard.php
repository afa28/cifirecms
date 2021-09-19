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

class Dashboard extends Backend_Controller
{
    public $mod = 'dashboard';

    public function __construct()
    {
        parent::__construct();

        if (!$this->role->i('read')) {
            redirect(admin_url('logout'));
        }

        $this->lang->load('mod/'.$this->mod);
        $this->load->model('mod/dashboard_model', 'Model');
        $this->meta_title(lang_line('mod_title'));
    }
    

    public function index()
    {
        if (ENVIRONMENT == 'development') {
            $this->cifire_alert->set('ENV', 'default', lang_line('ui_environment_development_info').'', false);
        }

        $this->vars['h_post']       = $this->Model->card('post');
        $this->vars['h_category']   = $this->Model->card('category');
        $this->vars['h_tags']       = $this->Model->card('tag');
        $this->vars['h_pages']      = $this->Model->card('pages');
        $this->vars['h_theme']      = $this->Model->card('theme');
        $this->vars['h_component']  = $this->Model->card('component');
        $this->vars['h_mail']       = $this->Model->card('mail');
        $this->vars['h_users']      = $this->Model->card('user');

        if (get_setting('web_analytics') == 'Y') {
            $range = 6;
            for ($i = $range; $i >= 0; $i--) {
                if ($i == 0) {
                    $visitorstemp = $this->db
                        ->where('date', date('Y-m-d'))
                        ->group_by('ip')
                        ->get('t_visitor')
                        ->result_array();

                    $hitstemp = $this->db
                        ->select('SUM(hits) as hitstoday')
                        ->where('date', date('Y-m-d'))
                        ->group_by('date')
                        ->get('t_visitor')
                        ->row_array();
                } else {
                    $visitorstemp = $this->db
                        ->where('date', date('Y-m-d', strtotime('-'.$i.' days')))
                        ->group_by('ip')
                        ->get('t_visitor')
                        ->result_array();

                    $hitstemp = $this->db
                        ->select('SUM(hits) as hitstoday')
                        ->where('date', date('Y-m-d', strtotime('-'.$i.' days')))
                        ->group_by('date')
                        ->get('t_visitor')
                        ->row_array();
                }

                $arrvisitor[$i] = count($visitorstemp);
                $this->vars['arrhari'][$i] = '"'.ci_date(date('Y-m-d', strtotime('-'.$i.' days')), 'D, d M').'"';
                $arrhits[$i] = (empty($hitstemp['hitstoday']) ? '0' : $hitstemp['hitstoday']);
            }
            
            $this->vars['rvisitors'] = array_combine(array_keys($arrvisitor), array_reverse(array_values($arrvisitor)));
            $this->vars['rhits'] = array_combine(array_keys($arrhits), array_reverse(array_values($arrhits)));

            $this->vars['rrhari']     = implode(",", $this->vars['arrhari']);
            $this->vars['rrhits']     = implode(",", array_reverse($this->vars['rhits']));
            $this->vars['rrvisitors'] = implode(",", array_reverse($this->vars['rvisitors']));
        }

        $this->render_view('view_index');
    }
} // End Class.
