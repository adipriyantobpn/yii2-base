<?php

namespace adipriyantobpn\base\components;


use yii\base\UnknownPropertyException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class ActiveRecord extends \yii\db\ActiveRecord implements ActiveRecordInterface
{
    use ActiveRecordTrait;

    public $generateGUID = true;
    public $idAttribute = 'id';

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
     * @param array $addItem key-value array
     * @param null|string $nameAttr
     * @param null|array $filter array with column_name-value format
     * @param null $orderBy
     * @param null $groupAttr
     * @param array $select
     * @param array $with
     * @param bool $kartikDepDropFormat
     * @return array mapping of id & name attribute
     */
    public static function getDropdownProvider($addItem = [], $nameAttr = null, $filter = null, $orderBy = null, $groupAttr = null, $select = [], $with = [], $kartikDepDropFormat = false)
    {
        $className = self::className();
        $class = new $className;
        $nameAttr = $nameAttr == null
            ? $class->getNameAttribute()
            : $nameAttr;
        $model = $filter == null
            ? $className::find()->select($select)->joinWith($with)->orderBy(($orderBy == null) ? null : $orderBy)->asArray()->all()
            : $className::find()->select($select)->joinWith($with)->where($filter)->orderBy(($orderBy == null) ? null : $orderBy)->asArray()->all();
        if ($kartikDepDropFormat) {
            return $model;
        } else {
            return ArrayHelper::merge($addItem, ArrayHelper::map($model, 'id', $nameAttr, $groupAttr));
        }
    }

    /**
     * Set GUID before insert data
     *
     * @param bool $insert Has true value when inserting new data, or false when updating data
     * @return bool Whether the insertion or updating should continue
     * @throws UnknownPropertyException Occurs when id attribute is not exist
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            \Yii::trace('Insert data = ' . VarDumper::dumpAsString($insert));
            if ($insert == true && $this->hasAttribute($this->idAttribute) == false) {
                throw new UnknownPropertyException(\Yii::t('adip', 'There is no attribute "{idAttribute}" found in "{class}"', [
                    'idAttribute' => $this->idAttribute,
                    'class' => $this->className(),
                ]));
            }
            if ($insert == true && $this->generateGUID == true && $this->hasAttribute($this->idAttribute)) {
                $this->setAttribute($this->idAttribute, Etc::getGUID());
                \Yii::trace('Automatically set GUID "' . $this->getAttribute($this->idAttribute) . '" to idAttribute "' . $this->idAttribute . '" when insert data = ' . VarDumper::dumpAsString($insert));
            }
            return true;
        } else {
            return false;
        }
    }
}