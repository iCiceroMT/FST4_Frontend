<?php
/**
 * @package         Fst4-Product.Module
 * @subpackage      mod_fst4_product
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
include_once('./modules/fst4_db/db_connection.php');
require_once dirname(__FILE__) . '/helper.php';



require JModuleHelper::getLayoutPath('mod_fst4_product', $params->get('layout', 'default'));