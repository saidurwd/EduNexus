<?php

class HikvisionProcessCommand extends CConsoleCommand
{
    public function run($args)
    {
        $events = HikvisionEvent::model()->findAll(
            array(
                'condition' =>
                    "processing_status = 'PENDING'",

                'order' =>
                    'id ASC',

                'limit' =>
                    100,
            )
        );

        foreach ($events as $event) {

            try {

                $this->processEvent(
                    $event
                );

            } catch (Exception $e) {

                $event->processing_status =
                    'FAILED';

                $event->processing_message =
                    $e->getMessage();

                $event->processed_at =
                    date('Y-m-d H:i:s');

                $event->save(false);

                Yii::log(
                    $e->getMessage(),
                    CLogger::LEVEL_ERROR,
                    'hikvision.processor'
                );
            }
        }
    }


    protected function processEvent(
        $event
    ) {

        /*
         * Only process access control events.
         */
        if (
            $event->event_type !==
            'AccessControllerEvent'
        ) {

            $event->processing_status =
                'IGNORED';

            $event->processed_at =
                date('Y-m-d H:i:s');

            $event->save(false);

            return;
        }


        /*
         * Employee number is essential.
         */
        if (
            empty(
            $event->employee_no
        )
        ) {

            $event->processing_status =
                'FAILED';

            $event->processing_message =
                'Employee number missing';

            $event->processed_at =
                date('Y-m-d H:i:s');

            $event->save(false);

            return;
        }


        /*
         * Create attendance log.
         */
        $attendance =
            new AttendanceLog();

        $attendance->employee_no =
            $event->employee_no;

        $attendance->device_id =
            $event->device_id;

        $attendance->attendance_time =
            $event->event_time;

        $attendance->attendance_type =
            $event->attendance_status;

        $attendance->verify_mode =
            $event->verify_mode;

        $attendance->source =
            'HIKVISION';

        $attendance->hikvision_event_id =
            $event->id;

        $attendance->created_at =
            date('Y-m-d H:i:s');


        /*
         * Because hikvision_event_id is UNIQUE,
         * duplicate processing is prevented.
         */
        if (!$attendance->save()) {

            throw new Exception(
                'Attendance save failed: ' .
                print_r(
                    $attendance->getErrors(),
                    true
                )
            );
        }


        /*
         * Mark processed.
         */
        $event->processing_status =
            'PROCESSED';

        $event->processing_message =
            null;

        $event->processed_at =
            date('Y-m-d H:i:s');

        $event->save(false);
    }
}