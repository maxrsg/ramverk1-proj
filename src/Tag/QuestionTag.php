<?php

namespace Magm19\Tag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class QuestionTag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "QuestionTag";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $questionId;
    public $tagId;
}
