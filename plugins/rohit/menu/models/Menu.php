<?php namespace Rohit\Menu\Models;

use Model;

/**
 * Model
 */
class Menu extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var bool timestamps are disabled.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'rohit_menu_';

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
