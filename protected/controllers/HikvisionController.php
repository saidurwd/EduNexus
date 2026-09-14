<?php

class HikvisionController extends Controller
{
    /**
     * Receive Hikvision MinMoe events.
     *
     * URL:
     * POST /hikvision/event
     */
    public function actionEvent()
    {
        // Do not allow CSRF validation for device webhook.
        $this->disableCsrfValidation();

        // Get raw request body.
        $rawBody = file_get_contents('php://input');

        //Stor Log Data @ protected/runtime/hikvision_raw_*.log [Commenout when Live!]
        $logFile =
            Yii::getPathOfAlias('application.runtime') .
            '/hikvision_raw_' .
            date('Ymd') .
            '.log';

        $log = "\n\n";
        $log .= "====================================\n";
        $log .= date('Y-m-d H:i:s') . "\n";
        $log .= "REMOTE IP: " .
            $_SERVER['REMOTE_ADDR'] . "\n";
        $log .= "CONTENT TYPE: " .
            (isset($_SERVER['CONTENT_TYPE'])
                ? $_SERVER['CONTENT_TYPE']
                : '') . "\n";
        $log .= "------------------------------------\n";
        $log .= $rawBody . "\n";

        file_put_contents(
            $logFile,
            $log,
            FILE_APPEND
        );

        if (empty($rawBody)) {
            $this->sendResponse(
                400,
                'Empty request body'
            );
        }

        // Detect payload format.
        $contentType = isset($_SERVER['CONTENT_TYPE'])
            ? strtolower($_SERVER['CONTENT_TYPE'])
            : '';

        $format = 'UNKNOWN';

        if (strpos($contentType, 'json') !== false) {
            $format = 'JSON';
        } elseif (
            strpos($contentType, 'xml') !== false ||
            strpos(ltrim($rawBody), '<') === 0
        ) {
            $format = 'XML';
        }

        try {

            $parser = new HikvisionEventParser();

            $event = $parser->parse(
                $rawBody,
                $format
            );

            if (!$event) {
                $this->sendResponse(
                    400,
                    'Unable to parse Hikvision event'
                );
            }

            /*
             * Identify device.
             *
             * Depending on firmware/payload,
             * device identification can come from:
             *
             * - device IP
             * - serial/device ID
             * - deviceName
             */
            $device = $this->findDevice();

            $model = new HikvisionEvent();

            $model->device_id =
                $device ? $device->id : null;

            $model->event_type =
                isset($event['event_type'])
                ? $event['event_type']
                : null;

            $model->event_state =
                isset($event['event_state'])
                ? $event['event_state']
                : null;

            $model->event_time =
                isset($event['event_time'])
                ? $event['event_time']
                : null;

            $model->employee_no =
                isset($event['employee_no'])
                ? $event['employee_no']
                : null;

            $model->employee_name =
                isset($event['employee_name'])
                ? $event['employee_name']
                : null;

            $model->card_no =
                isset($event['card_no'])
                ? $event['card_no']
                : null;

            $model->major_event_type =
                isset($event['major_event_type'])
                ? $event['major_event_type']
                : null;

            $model->sub_event_type =
                isset($event['sub_event_type'])
                ? $event['sub_event_type']
                : null;

            $model->attendance_status =
                isset($event['attendance_status'])
                ? $event['attendance_status']
                : null;

            $model->verify_mode =
                isset($event['verify_mode'])
                ? $event['verify_mode']
                : null;

            $model->serial_no =
                isset($event['serial_no'])
                ? $event['serial_no']
                : null;

            $model->raw_payload =
                $rawBody;

            $model->payload_format =
                $format;

            $model->processing_status =
                'PENDING';

            $model->received_at =
                date('Y-m-d H:i:s');

            if (!$model->save()) {

                Yii::log(
                    'Hikvision event save failed: ' .
                    print_r($model->getErrors(), true),
                    CLogger::LEVEL_ERROR,
                    'hikvision'
                );

                $this->sendResponse(
                    500,
                    'Database error'
                );
            }

            // Update last event.
            if ($device) {

                $device->last_event_at =
                    date('Y-m-d H:i:s');

                $device->save(false);
            }

            /*
             * Important:
             * Return quickly to Hikvision.
             */
            $this->sendResponse(
                200,
                'OK'
            );

        } catch (Exception $e) {

            Yii::log(
                'Hikvision webhook error: ' .
                $e->getMessage(),
                CLogger::LEVEL_ERROR,
                'hikvision'
            );

            $this->sendResponse(
                500,
                'Internal Server Error'
            );
        }
    }


    /**
     * Identify the Hikvision device.
     */
    protected function findDevice()
    {
        $ip = isset($_SERVER['REMOTE_ADDR'])
            ? $_SERVER['REMOTE_ADDR']
            : null;

        if (!$ip) {
            return null;
        }

        return HikvisionDevice::model()->find(
            'ip_address = :ip AND is_active = 1',
            array(':ip' => $ip)
        );
    }


    /**
     * Send HTTP response.
     */
    protected function sendResponse(
        $statusCode,
        $message
    ) {

        http_response_code($statusCode);

        header(
            'Content-Type: text/plain; charset=utf-8'
        );

        echo $message;

        Yii::app()->end();
    }


    /**
     * Yii1 CSRF bypass.
     *
     * Better to implement this in your
     * Controller filter architecture.
     */
    protected function disableCsrfValidation()
    {
        if (
            isset($this->enableCsrfValidation)
        ) {
            $this->enableCsrfValidation = false;
        }
    }
}