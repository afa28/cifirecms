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

class Cifire_Alert
{
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }


    public function set($alert_name = '', $alert_type = '', $alert_content = '', $timeout=true)
    {
        $session_alert = 'alert_'.$alert_name;
        $this->CI->session->set_flashdata($session_alert, array($alert_type,$alert_content,$timeout));
    }


    public function show($alert_name = '', $type = '', $content = '', $timeout=true, $static = false)
    {
        $sesname = 'alert_'.$alert_name;

        $alert = '';

        if (!empty($this->CI->session->flashdata($sesname))) {
            $ses = $this->CI->session->flashdata($sesname);
            $time = isset($ses[2])?$ses[2]:$timeout;
            $alert = $this->alert($ses[0], $ses[1], $time);
        }

        if ($static==true) {
            $alert = $this->alert($type, $content, $timeout);
        }
        
        echo $alert;
    }


    private function alert($type = '', $content = '', $tmieout=true)
    {
        $scriptTmieout = $tmieout==true?'<script>$("#alert-timeout").delay(10000).slideUp(100, function() {$(this).alert("close");$(this).remove();});</script>':'';
        $alert = '<div id="alert-timeout" class="alert alert-'.$type.' alert-styled-left alert-arrow-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'.$content.$scriptTmieout.'</div>';
        return $alert;
    }
} // End class
