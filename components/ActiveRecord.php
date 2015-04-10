<?php

namespace adipriyantobpn\base\components;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class ActiveRecord extends \yii\db\ActiveRecord implements ActiveRecordInterface
{
    use ActiveRecordTrait;

    /**
     * Automatically fills created_at and updated_at attributes with the current timestamp
     * Those two columns must have datetime type
     *
     * Automatically fills created_by and updated_by attributes with the current user ID
     * Those the columns should have integer type
     * Although string/varchar can be used too
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_by'],
                    self::EVENT_BEFORE_UPDATE => ['updated_by'],
                ]
            ],
        ];
    }



    /**
     * Return data list which is populated from database for dropdown provider
     *
     * @param null|string $nameAttribute
     * @param null|array $filter array with column_name-value format
     * @param array $addItem key-value array
     * @return array mapping of id & name attribute
     */
    public static function getDropdownProvider($nameAttribute = null, $filter = null, $orderBy = null, $addItem = [], $kartikDepDropFormat = false)
    {
        $className = self::className();
        $class = new $className;
        $nameAttribute = $nameAttribute == null
            ? $class->getNameAttribute()
            : $nameAttribute;
        $model = $filter == null
            ? $className::find()->orderBy(($orderBy == null) ? $nameAttribute : $orderBy)->asArray()->all()
            : $className::find()->where($filter)->orderBy(($orderBy == null) ? $nameAttribute : $orderBy)->asArray()->all();
        if ($kartikDepDropFormat) {
            return $model;
        } else {
            return ArrayHelper::merge(ArrayHelper::map($model, 'id', $nameAttribute), $addItem);
        }
    }
}