<?php

class HikvisionEventParser
{
    /**
     * Parse Hikvision XML/JSON.
     */
    public function parse(
        $payload,
        $format = 'UNKNOWN'
    ) {

        if ($format === 'JSON') {

            return $this->parseJson(
                $payload
            );
        }

        if ($format === 'XML') {

            return $this->parseXml(
                $payload
            );
        }

        /*
         * Try JSON.
         */
        $json = json_decode(
            $payload,
            true
        );

        if (json_last_error() === JSON_ERROR_NONE) {

            return $this->parseArray(
                $json
            );
        }

        /*
         * Try XML.
         */
        return $this->parseXml(
            $payload
        );
    }


    /**
     * JSON parser.
     */
    protected function parseJson($payload)
    {
        $data = json_decode(
            $payload,
            true
        );

        if (
            json_last_error() !==
            JSON_ERROR_NONE
        ) {
            throw new Exception(
                'Invalid Hikvision JSON'
            );
        }

        return $this->parseArray($data);
    }


    /**
     * XML parser.
     */
    protected function parseXml($payload)
    {
        libxml_use_internal_errors(true);

        $xml = simplexml_load_string(
            $payload
        );

        if ($xml === false) {

            throw new Exception(
                'Invalid Hikvision XML'
            );
        }

        $json = json_encode($xml);

        $data = json_decode(
            $json,
            true
        );

        return $this->parseArray($data);
    }


    /**
     * Normalize Hikvision event.
     */
    protected function parseArray($data)
    {
        /*
         * Hikvision events generally have:
         *
         * EventNotificationAlert
         * AccessControllerEvent
         */

        if (
            isset(
            $data['EventNotificationAlert']
        )
        ) {
            $data =
                $data['EventNotificationAlert'];
        }

        $accessEvent = array();

        if (
            isset(
            $data['AccessControllerEvent']
        )
        ) {

            $accessEvent =
                $data['AccessControllerEvent'];
        }

        return array(

            'event_type' =>
                $this->value(
                    $data,
                    'eventType'
                ),

            'event_state' =>
                $this->value(
                    $data,
                    'eventState'
                ),

            'event_time' =>
                $this->normalizeDate(
                    $this->value(
                        $data,
                        'dateTime'
                    )
                ),

            'employee_no' =>
                $this->value(
                    $accessEvent,
                    'employeeNoString'
                ),

            'employee_name' =>
                $this->value(
                    $accessEvent,
                    'name'
                ),

            'card_no' =>
                $this->value(
                    $accessEvent,
                    'cardNo'
                ),

            'major_event_type' =>
                $this->value(
                    $accessEvent,
                    'majorEventType'
                ),

            'sub_event_type' =>
                $this->value(
                    $accessEvent,
                    'subEventType'
                ),

            'attendance_status' =>
                $this->value(
                    $accessEvent,
                    'attendanceStatus'
                ),

            'verify_mode' =>
                $this->value(
                    $accessEvent,
                    'currentVerifyMode'
                ),

            'serial_no' =>
                $this->value(
                    $accessEvent,
                    'serialNo'
                ),
        );
    }


    protected function value(
        $array,
        $key
    ) {

        if (
            isset($array[$key])
        ) {

            if (
                is_array(
                    $array[$key]
                )
            ) {
                return null;
            }

            return trim(
                (string) $array[$key]
            );
        }

        return null;
    }


    protected function normalizeDate(
        $date
    ) {

        if (!$date) {
            return null;
        }

        $timestamp =
            strtotime($date);

        if (!$timestamp) {
            return null;
        }

        return date(
            'Y-m-d H:i:s',
            $timestamp
        );
    }
}