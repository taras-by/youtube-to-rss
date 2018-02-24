<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 19.11.17
 * Time: 9:31
 */

namespace App\Models;

use App\Core\Model;

/**
 * Class Post
 * @package App\Models
 */
class Post extends Model
{
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->db
            ->query('SELECT * FROM posts')
            ->fetchAll();
    }
}