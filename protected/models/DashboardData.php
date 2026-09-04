<?php

class DashboardData {

    public static function getInstitutionStats($institutionId, $academicYearId) {
        return array(
            'students' => self::getStudentCount($institutionId, $academicYearId),
            'teachers' => self::getTeacherCount($institutionId),
            'attendance_rate' => self::getTodayAttendanceRate($institutionId),
            'monthly_income' => self::getMonthlyIncome($institutionId),
            'attendance_trend' => self::getAttendanceTrend($institutionId, 7),
            'class_distribution' => self::getClassDistribution($institutionId),
            'exam_performance' => self::getExamPerformance($institutionId, $academicYearId),
            'fee_collection' => self::getFeeCollection($institutionId),
            'income_expense' => self::getIncomeExpenseTrend($institutionId),
        );
    }

    public static function getWidgetData($widget, $institutionId, $academicYearId, $days = 7, $startDate = null, $endDate = null) {
        switch ($widget) {
            case 'attendance_trend':
                return self::getAttendanceTrend($institutionId, $days, $startDate, $endDate);
            case 'class_distribution':
                return self::getClassDistribution($institutionId);
            case 'exam_performance':
                return self::getExamPerformance($institutionId, $academicYearId);
            case 'fee_collection':
                return self::getFeeCollection($institutionId);
            case 'income_expense':
                return self::getIncomeExpenseTrend($institutionId);
            default:
                return array();
        }
    }

    public static function getStudentCount($institutionId, $academicYearId) {
        if (empty($academicYearId)) {
            return 0;
        }
        
        $cacheKey = 'dashboard.students.' . $institutionId . '.' . $academicYearId;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return (int)$cached;
        }
        
        $count = Student::model()->count(array(
            'condition' => 'institution=:inst AND academic_year=:year AND status="ACTIVE"',
            'params' => array(':inst' => $institutionId, ':year' => $academicYearId)
        ));
        
        Yii::app()->cache->set($cacheKey, $count, 3600);
        return $count;
    }

    public static function getTeacherCount($institutionId) {
        $cacheKey = 'dashboard.teachers.' . $institutionId;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return (int)$cached;
        }
        
        $count = Teacher::model()->count(array(
            'condition' => 'institution=:inst AND status="ACTIVE"',
            'params' => array(':inst' => $institutionId)
        ));
        
        Yii::app()->cache->set($cacheKey, $count, 3600);
        return $count;
    }

    public static function getTodayAttendanceRate($institutionId) {
        $date = date('Y-m-d');
        $cacheKey = 'dashboard.attendance_rate.' . $institutionId . '.' . $date;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return (float)$cached;
        }
        
        $total = Attendance::model()->count(array(
            'condition' => 'institution=:inst AND DATE(attendance_in)=:date',
            'params' => array(':inst' => $institutionId, ':date' => $date)
        ));
        $present = Attendance::model()->count(array(
            'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="PRESENT"',
            'params' => array(':inst' => $institutionId, ':date' => $date)
        ));
        $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
        
        Yii::app()->cache->set($cacheKey, $rate, 300);
        return $rate;
    }

    public static function getMonthlyIncome($institutionId) {
        $month = date('Y-m');
        $cacheKey = 'dashboard.monthly_income.' . $institutionId . '.' . $month;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return (float)$cached;
        }
        
        $firstDay = date('Y-m-01');
        $lastDay = date('Y-m-t');
        
        $income = Yii::app()->db->createCommand()
            ->select('COALESCE(SUM(amount), 0)')
            ->from('{{income}}')
            ->where('institution=:inst AND expense_date BETWEEN :start AND :end',
                array(':inst' => $institutionId, ':start' => $firstDay, ':end' => $lastDay))
            ->queryScalar();
        
        Yii::app()->cache->set($cacheKey, $income, 3600);
        return (float)$income;
    }

    public static function getAttendanceTrend($institutionId, $days = 7, $startDate = null, $endDate = null) {
        $cacheKey = 'dashboard.attendance_trend.' . $institutionId . '.' . $days . '.' . ($startDate ?: '0') . '.' . ($endDate ?: '0');
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached;
        }
        
        $data = array(
            'labels' => array(),
            'present' => array(),
            'absent' => array()
        );
        
        if ($startDate && $endDate) {
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end->modify('+1 day'));
            
            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $dateLabel = $date->format('M d');
                
                $present = Attendance::model()->count(array(
                    'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="PRESENT"',
                    'params' => array(':inst' => $institutionId, ':date' => $dateStr)
                ));
                
                $absent = Attendance::model()->count(array(
                    'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="ABSENT"',
                    'params' => array(':inst' => $institutionId, ':date' => $dateStr)
                ));
                
                $data['labels'][] = $dateLabel;
                $data['present'][] = (int)$present;
                $data['absent'][] = (int)$absent;
            }
        } else {
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $dateLabel = date('M d', strtotime($date));
                
                $present = Attendance::model()->count(array(
                    'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="PRESENT"',
                    'params' => array(':inst' => $institutionId, ':date' => $date)
                ));
                
                $absent = Attendance::model()->count(array(
                    'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="ABSENT"',
                    'params' => array(':inst' => $institutionId, ':date' => $date)
                ));
                
                $data['labels'][] = $dateLabel;
                $data['present'][] = (int)$present;
                $data['absent'][] = (int)$absent;
            }
        }
        
        Yii::app()->cache->set($cacheKey, $data, 300);
        return $data;
    }

    public static function getClassDistribution($institutionId) {
        $cacheKey = 'dashboard.class_distribution.' . $institutionId;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached;
        }
        
        $data = array(
            'labels' => array(),
            'counts' => array()
        );
        
        $classes = Classs::model()->findAll(array(
            'condition' => 'institution=:inst AND status="Active"',
            'params' => array(':inst' => $institutionId),
            'order' => 'class_numeric ASC'
        ));
        
        foreach ($classes as $class) {
            $studentCount = Student::model()->count(array(
                'condition' => 'institution=:inst AND class=:class AND status="ACTIVE"',
                'params' => array(':inst' => $institutionId, ':class' => $class->id)
            ));
            
            $data['labels'][] = $class->class;
            $data['counts'][] = (int)$studentCount;
        }
        
        Yii::app()->cache->set($cacheKey, $data, 3600);
        return $data;
    }

    public static function getExamPerformance($institutionId, $academicYearId) {
        if (empty($academicYearId)) {
            return array('labels' => array(), 'gpa' => array(), 'pass_rate' => array());
        }
        
        $cacheKey = 'dashboard.exam_performance.' . $institutionId . '.' . $academicYearId;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached;
        }
        
        $data = array(
            'labels' => array(),
            'gpa' => array(),
            'pass_rate' => array()
        );
        
        $exams = Exam::model()->findAll(array(
            'condition' => 'institution=:inst AND academic_year=:year',
            'params' => array(':inst' => $institutionId, ':year' => $academicYearId),
            'order' => 'exam_date ASC'
        ));
        
        foreach ($exams as $exam) {
            $avgGpa = Yii::app()->db->createCommand()
                ->select('ROUND(AVG(gpa), 2)')
                ->from('{{mark}}')
                ->where('institution=:inst AND exam=:exam AND academic_year=:year',
                    array(':inst' => $institutionId, ':exam' => $exam->id, ':year' => $academicYearId))
                ->queryScalar();
            
            $totalStudents = Yii::app()->db->createCommand()
                ->select('COUNT(DISTINCT student)')
                ->from('{{mark}}')
                ->where('institution=:inst AND exam=:exam AND academic_year=:year',
                    array(':inst' => $institutionId, ':exam' => $exam->id, ':year' => $academicYearId))
                ->queryScalar();
            
            $passedStudents = Yii::app()->db->createCommand()
                ->select('COUNT(DISTINCT student)')
                ->from('{{mark}}')
                ->where('institution=:inst AND exam=:exam AND academic_year=:year AND letter_grade!="F"',
                    array(':inst' => $institutionId, ':exam' => $exam->id, ':year' => $academicYearId))
                ->queryScalar();
            
            $passRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 1) : 0;
            
            $data['labels'][] = $exam->exam_name;
            $data['gpa'][] = (float)$avgGpa;
            $data['pass_rate'][] = (float)$passRate;
        }
        
        Yii::app()->cache->set($cacheKey, $data, 3600);
        return $data;
    }

    public static function getFeeCollection($institutionId, $academicYearId = null) {
        $cacheKey = 'dashboard.fee_collection.' . $institutionId;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached;
        }
        
        $data = array(
            'collected' => 0,
            'due' => 0,
            'labels' => array('Collected', 'Due'),
            'values' => array(0, 0)
        );
        
        $collected = Yii::app()->db->createCommand()
            ->select('COALESCE(SUM(ip.amount), 0)')
            ->from('{{invoice_payment}} ip')
            ->join('{{invoice}} i', 'i.id=ip.invoice')
            ->join('{{invoice_parent}} ipar', 'ipar.id=i.parent')
            ->where('ipar.institution=:inst',
                array(':inst' => $institutionId))
            ->queryScalar();
        
        $totalFee = Yii::app()->db->createCommand()
            ->select('COALESCE(SUM(i.amount + i.fine - i.discount), 0)')
            ->from('{{invoice}} i')
            ->join('{{invoice_parent}} ipar', 'ipar.id=i.parent')
            ->where('ipar.institution=:inst',
                array(':inst' => $institutionId))
            ->queryScalar();
        
        $due = $totalFee - $collected;
        
        $data['collected'] = (float)$collected;
        $data['due'] = (float)$due;
        $data['values'] = array((float)$collected, (float)$due);
        
        Yii::app()->cache->set($cacheKey, $data, 3600);
        return $data;
    }

    public static function getIncomeExpenseTrend($institutionId) {
        $cacheKey = 'dashboard.income_expense.' . $institutionId;
        $cached = Yii::app()->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached;
        }
        
        $data = array(
            'labels' => array(),
            'income' => array(),
            'expense' => array()
        );
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthLabel = date('M Y', strtotime($month));
            $startDate = $month . '-01';
            $endDate = $month . '-31';
            
            $income = Yii::app()->db->createCommand()
                ->select('COALESCE(SUM(amount), 0)')
                ->from('{{income}}')
                ->where('institution=:inst AND expense_date BETWEEN :start AND :end',
                    array(':inst' => $institutionId, ':start' => $startDate, ':end' => $endDate))
                ->queryScalar();
            
            $expense = Yii::app()->db->createCommand()
                ->select('COALESCE(SUM(amount), 0)')
                ->from('{{expense}}')
                ->where('institution=:inst AND expense_date BETWEEN :start AND :end',
                    array(':inst' => $institutionId, ':start' => $startDate, ':end' => $endDate))
                ->queryScalar();
            
            $data['labels'][] = $monthLabel;
            $data['income'][] = (float)$income;
            $data['expense'][] = (float)$expense;
        }
        
        Yii::app()->cache->set($cacheKey, $data, 3600);
        return $data;
    }
}
