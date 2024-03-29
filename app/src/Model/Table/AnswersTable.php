<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Answers Model
 */
class AnswersTable extends Table
{
  /**
   * @inheritdoc
   */
  public function initialize(array $config)
  {
    parent::initialize($config);

    $this->setTable('answers');
    $this->setDisplayField('id');
    $this->setPrimaryKey('id');

    $this->addBehavior('Timestamp');

    $this->belongsTo('Questions', [
      'foreignKey' => 'question_id',
      'joinType'   => 'INEER'
    ]);

    $this->belongsTo('Users', [
      'foreignKey' => 'user_id',
      'joinType'   => 'INNER'
    ]);
  }

  /**
   * バリデーションルールの定義
   *
   * @param \Cake\Validation\Validator $validator バリデーションインスタンス
   * @return \Cake\Validation\Validator バリデーションインスタンス
   */

  public function validationDefault(Validator $validator)
  {
    $validator
        ->nonNegativeInteger('id', 'IDが不正です')
        ->allowEmpty('id', 'IDが不正です');

    $validator
        ->scalar('body', '回答内容が不正です')
        ->requirePresence('body', 'create', '回答内容が不正です')
        ->notEmpty('body', '回答内容は必ず入力してください')
        ->maxLength('body', 140, '回答内容は140字以内で入力してください');

    return $validator;
  }

  /**
   * ルールチェッカーを作成する
   *
   * @param \Cake\ORM\RulesChecker $rules　ルールチェッカーのオブジェクト
   * @return \Cake\ORM\RulesChecker ルールチェッカーのオブジェクト
   */
  public function buildRules(RulesChecker $rules)
  {
    $rules->add($rules->existsIn(
      ['question_id'],
      'Questions',
      '質問がすでに削除されているため回答することが出来ません'
    ));

    return $rules;
  }
}
