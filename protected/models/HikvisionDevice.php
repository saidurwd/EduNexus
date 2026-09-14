<?php

class HikvisionDevice extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'os_hikvision_devices';
    }
}