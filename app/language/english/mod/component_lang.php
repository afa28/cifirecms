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

$lang['mod_title'] = 'Component';
$lang['mod_title_all'] = 'All Component';
$lang['mod_title_installation'] = 'Component Installation';

$lang['_component'] = 'Component';
$lang['_mod'] = 'Mod';
$lang['_t_name'] = 'Table Name';
$lang['_status'] = 'Status';
$lang['_action'] = 'Action';

$lang['_component_package'] = 'Component Package';

$lang['_instructions'] = 'Instructions';

$lang['_instruction_content'] = '
		<li>Upload the .zip component package file which can be downloaded via <a href="#" target="_blank" class="text-primary">CiFireCMS official website</a> or from a trusted developer.</li>
		<li>The system will automatically install the component files that you need.</li>
		<li>If an error occurs, please repeat the steps from the beginning. If there are the same components, the system will not run the installation process.</li>
		<li>A standard component package contains files : controllers, models, views, modjs, sql and configuration file for installation.</li>
		<li>If after the component installation, please give permission to user group for access a component.</li>';

$lang['form_message_add_success'] = 'Component has been successfully installed';

$lang['err_install_package'] = 'ERROR..! Component package is corrupt or some files have been installed before';
$lang['err_component_notfound'] = 'ERROR..! Component not found';
$lang['err_config_notfound'] = 'ERROR..! Installation config not found';
