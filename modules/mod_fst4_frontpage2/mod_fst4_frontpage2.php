<?php
/**
 * @package         Front>Page.Module
 * @subpackage      mod_fst4_frontpage
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';



require JModuleHelper::getLayoutPath('mod_fst4_frontpage2', $params->get('layout', 'default'));