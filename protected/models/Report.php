<?php

class Report extends CActiveRecord {

    public static function number_format($value, $decimal_place) {
        if (is_numeric($value)) {
            if ($value < 0) {
                return "(" . number_format(abs($value), $decimal_place, '.', ',') . ")";
            } else {
                return number_format($value, $decimal_place, '.', ',');
            }
        } else {
            return $value;
        }
    }

    /*
     * Format example ($22,222.00) for negative numbers 
     * For positive $22,222.00 
     */

    public static function number_format_currency($value, $decimal_place, $currency) {
        if (is_numeric($value)) {
            if ($value < 0) {
                return "(" . $currency . number_format(abs($value), $decimal_place, '.', ',') . ")";
            } else {
                return $currency . number_format($value, $decimal_place, '.', ',');
            }
        } else {
            return $value;
        }
    }

    public static function admitCardReport($class, $exam, $year) {
        $connection = Yii::app()->db;
        $criteria = '';
        if (@$class != NULL) {
            $criteria .= ' `class`=' . $class;
        }
        if (@$year != NULL) {
            $criteria .= ' AND `academic_year`=' . $year;
        }
        $command = $connection->createCommand('SELECT * FROM `os_student` WHERE ' . $criteria . ' ORDER BY `shift` ASC, `section` ASC, `roll` ASC');
        $data_array = $command->queryAll();

        return $data_array;
    }

    public static function idCardReport($class, $section, $year) {
        $connection = Yii::app()->db;
        $criteria = '';
        if (@$class != NULL) {
            $criteria .= ' `class`=' . $class;
        }
        if (@$section != NULL) {
            $criteria .= ' AND `section`=' . $section;
        }
        if (@$year != NULL) {
            $criteria .= ' AND `academic_year`=' . $year;
        }
        $command = $connection->createCommand('SELECT * FROM `os_student` WHERE ' . $criteria . ' ORDER BY `shift` ASC, `section` ASC, `roll` ASC');
        $data_array = $command->queryAll();

        return $data_array;
    }

}
