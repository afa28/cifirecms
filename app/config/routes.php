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

$route['default_controller']   = 'HomeIndex';
$route['404_override']         = false;
$route['translate_uri_dashes'] = true;

// BACKEND.
$route['login'] = FADMIN.'/auth';
$route[FADMIN.'/login'] = FADMIN.'/auth';
$route[FADMIN.'/auth-validation'] = FADMIN.'/auth/validation/user';
$route[FADMIN.'/logout'] = FADMIN.'/auth/logout';
$route[FADMIN.'/forgot'] = FADMIN.'/auth/forgot';
$route[FADMIN.'/permissions'] = FADMIN.'/permissions/index';
$route[FADMIN.'/permissions/group/edit/([a-z0-9]+)'] = FADMIN.'/permissions/edit_group/$1';
$route[FADMIN.'/permissions/group/add'] = FADMIN.'/permissions/add_group';
$route[FADMIN.'/permissions/group/([a-z0-9]+)'] = FADMIN.'/permissions/detail_group/$1';
$route[FADMIN.'/permissions/role/([a-z0-9]+)'] = FADMIN.'/permissions/role/$1';
$route[FADMIN.'/permissions/edit-role/([0-9]+)/([a-z0-9]+)'] = FADMIN.'/permissions/edit_group_role/$1/$2';
$route[FADMIN.'/permissions/edit-role/([0-9]+)'] = FADMIN.'/permissions/edit_list_role/$1';

$route[FADMIN.'/post-video'] = FADMIN.'/post-video';


// WEB.
$route['maintenance'] = 'maintenance';
$route['home'] = FWEB.'/home/index';
$route['indexpost'] = FWEB.'/IndexPost';
// $route['indexpost/([0-9-]+)'] = FWEB.'/IndexPost/index/$1';
$route['category/([a-z0-9-]+)'] = FWEB.'/category/index/$1';
$route['category/([a-z0-9-]+)/([0-9]+)'] = FWEB.'/category/index/$1/$2';
$route['tag/([a-z0-9-]+)'] = FWEB.'/tag/index/$1';
$route['tag/([a-z0-9-]+)/([0-9]+)'] = FWEB.'/tag/index/$1/$2';
$route['pages/([a-z0-9-]+)'] = FWEB.'/pages/index/$1';
$route['search'] = FWEB.'/search';
$route['contact'] = FWEB.'/contact';
$route['gallery'] = FWEB.'/gallery';

$route['rss'] = FWEB.'/rss/index';
$route['rss/([a-z0-9-]+)'] = FWEB.'/rss/index/$1';
$route['rss/([a-z0-9-]+)/([a-z0-9-]+)'] = FWEB.'/rss/index/$1/$2';
$route['rss/([a-z0-9-]+)/([a-z0-9-]+)/([0-9]+)'] = FWEB.'/rss/index/$1/$2/$3';

// dinamic slug routes.
foreach (glob(APPPATH."/config/routes/*.php") as $routes_file) {
    require_once $routes_file;
}
