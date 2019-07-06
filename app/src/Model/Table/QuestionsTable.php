<?php

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Questions Model
 */
class QuestionsTable extends Table
{
  /**
   * @inheritdoc
   */
  public function initialize(array $config)
  {
    parent::initialize($config);

    $this->setTable('questions'); //使用されるテーブル
    $this->setDisplayField('id'); //list形式でデータ取得する際に使用されるカラム名
    $this->setPrimaryKey('id');   //プライマリーキー

    $this->addBehavior('Timestamp'); //createdおよびmodifiedカラムを自動設定する

    $this->hasMany('Answers', [
      'foreignKey' => 'question_id'
    ]);
  }
}
