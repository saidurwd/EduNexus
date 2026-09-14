<?php

class HikvisionEvent extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'os_hikvision_events';
    }

    public function rules()
    {
        return array(

            array(
                'raw_payload',
                'required'
            ),

            array(
                'device_id,
                event_type,
                event_state,
                event_time,
                employee_no,
                employee_name,
                card_no,
                major_event_type,
                sub_event_type,
                attendance_status,
                verify_mode,
                serial_no,
                payload_format,
                processing_status,
                received_at',
                'safe'
            ),
        );
    }
}