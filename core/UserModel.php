<?php

namespace app\core;

use app\core\db\DbModel;

/**
 * @author Sandhavi Wanigasooriya
 * @package app/core
 */

abstract class UserModel extends DbModel
{
	abstract public function getDisplayName(): string;
}
