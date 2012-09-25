<?php

/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    1.0.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/**
 * Extension class.
 *
 * @author Ben Corlett
 */
class Extension extends Crud
{

    /**
     * The name of the table associated with the model.
     *
     * @access    protected
     * @var       string
     */
    protected static $_table = 'extensions';

    /**
     * Indicates if the model has update and creation timestamps.
     *
     * @access    protected
     * @var       boolean
     */
    protected static $_timestamps = false;


    /**
     * Find a model by either it's primary key
     * or a condition that modifies the query object.
     *
     * @param   string  $condition
     * @param   array   $columns
     * @return  Crud
     */
    public static function find($condition = 'first', $columns = array('*'), $events = array('before', 'after'))
    {
        // Find by slug
        if (is_string($condition) and ! is_numeric($condition) and ! in_array($condition, array('first', 'last')))
        {
            return parent::find(function($query) use ($condition)
            {
                return $query->where('slug', '=', $condition);
            }, $columns, $events);
        }

        return parent::find($condition, $columns, $events);
    }
}

/* End of file extension.php */
/* Location: ./platform/application/models/extension.php */