<?php

namespace adipriyantobpn\klog\country\components;

use kartik\helpers\Enum;

trait ActiveRecordTrait
{
    /**
     * Predict name / title attribute
     * It use logics from yii\gii\generators\crud\Generator\getNameAttribute() with some modification
     *
     * @return string
     */
    public function getNameAttribute()
    {
        foreach ($this->getTableSchema()->getColumnNames() as $name) {
            if (!strcasecmp($name, 'name') or !strcasecmp($name, 'title') or !strcasecmp($name, 'username') or !strcasecmp($name, 'no')) {
                return $name;
            }
        }
        $pk = $this->primaryKey();

        return $pk[0];
    }

    /**
     * Set status of data : active or not
     *
     * @param string $status 'enable' or 'disable'
     */
    public function setStatus($status)
    {
        if ($this->status = ($status == 'enable')) {
            $this->status = self::STATUS_ENABLED;
        } else {
            $this->status = self::STATUS_DISABLED;
        }

        if ($this->save(false)) {
            $column = $this->getNameAttribute();
            \Yii::$app->session->setFlash('success', \Yii::t('adip/country', '{name} status has been successfully set as {status}', [
                'name' => $this->$column,
                'status' => $status
            ]));
        }
    }

    /**
     * Return status list for dropdown provider
     *
     * @param string $false Optional : false label
     * @param string $true Optional : true label
     * @return array Mapping of id & label
     */
    public function getStatusList($false = 'Disable', $true = 'Enable')
    {
        return Enum::boolList(\Yii::t('adip/country', $false), \Yii::t('adip/country', $true));
    }

    /**
     * Return status label based on specified id
     *
     * @param string $status_id Status id
     * @param string $false Optional : false label
     * @param string $true Optional : true label
     * @return string Status label
     */
    public function getStatusLabel($status_id, $false = 'Disable', $true = 'Enable')
    {
        $status = $this->getStatusList($false, $true);
        return $status[$status_id];
    }
}