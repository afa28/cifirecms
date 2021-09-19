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

class Cifire_Role
{
    protected $mod;
    public function __construct($params=null)
    {
        $this->CI =& get_instance();
        $this->mod = $params['modz'];
    }


    private function key_group($key_login='')
    {
        $id_login = (empty($key_login)?decrypt($this->CI->session->userdata('key_id')):decrypt($key_login));
        // $id_login = ;
        $query = $this->CI->db
            ->select('
			         t_user.key_group    AS  user_group,
			         t_user_group.group  AS  group,
			         t_user_group.pk     AS  key_group
			         ')
            ->from('t_user')
            ->where('t_user.id', $id_login)
            ->join('t_user_group', 't_user_group.group = t_user.key_group', 'left')
            ->get();

        if ($query->num_rows()==1) {
            return $query->row_array()['group'];
        } else {
            return null;
        }
    }

    public function i($param)
    {
        $role = $param.'_access';
        return $this->access($this->mod, $role);
    }

    
    public function access($module='', $role='')
    {
        $key_group = group_active();

        if ($key_group == 'root') {
            return true;
        } elseif (!empty($key_group) && !empty($module)) {
            $get_role = $this->CI->db
                ->where('group', $key_group)
                ->where('module', $module)
                ->get('t_roles')
                ->row_array();

            if ($get_role[$role]==1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
} // End class
