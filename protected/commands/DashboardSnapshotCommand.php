<?php

class DashboardSnapshotCommand extends CConsoleCommand
{
    public function getHelp()
    {
        return "Generate dashboard snapshots for all institutions.\n\n";
    }

    public function run($args)
    {
        $this->generateSnapshots();
    }

    public function actionGenerate()
    {
        $this->generateSnapshots();
    }

    protected function generateSnapshots()
    {
        echo "Starting dashboard snapshot generation...\n";
        
        $institutions = Institution::model()->findAll();
        $date = date('Y-m-d');
        
        foreach ($institutions as $institution) {
            echo "Processing institution: " . $institution->institution . " (ID: {$institution->id})\n";
            
            $academicYear = AcademicYear::model()->findByAttributes(array(
                'institution' => $institution->id,
                'default' => 'Yes'
            ));
            $academicYearId = $academicYear !== null ? $academicYear->id : null;
            
            $this->generateMetric($institution->id, 'students', 'total_active', $this->getStudentCount($institution->id, $academicYearId), $date, $academicYearId);
            $this->generateMetric($institution->id, 'teachers', 'total_active', $this->getTeacherCount($institution->id), $date);
            $this->generateMetric($institution->id, 'attendance', 'daily_rate', $this->getTodayAttendanceRate($institution->id), $date);
            $this->generateMetric($institution->id, 'income', 'monthly_total', $this->getMonthlyIncome($institution->id), $date);
            
            for ($i = 6; $i >= 0; $i--) {
                $trendDate = date('Y-m-d', strtotime("-$i days"));
                $trendData = $this->getAttendanceTrend($institution->id, 1, $trendDate, $trendDate);
                if (!empty($trendData['present'])) {
                    $this->generateMetric($institution->id, 'attendance_trend', 'present_' . $trendDate, $trendData['present'][0], $trendDate);
                    $this->generateMetric($institution->id, 'attendance_trend', 'absent_' . $trendDate, $trendData['absent'][0], $trendDate);
                }
            }
            
            $classDist = $this->getClassDistribution($institution->id);
            if (!empty($classDist['labels'])) {
                foreach ($classDist['labels'] as $index => $className) {
                    $this->generateMetric($institution->id, 'class_distribution', 'class_' . $className, $classDist['counts'][$index], $date);
                }
            }
            
            if ($academicYearId) {
                $examPerf = $this->getExamPerformance($institution->id, $academicYearId);
                if (!empty($examPerf['labels'])) {
                    foreach ($examPerf['labels'] as $index => $examName) {
                        $this->generateMetric($institution->id, 'exam_performance', 'gpa_' . $examName, $examPerf['gpa'][$index], $date, $academicYearId);
                        $this->generateMetric($institution->id, 'exam_performance', 'pass_rate_' . $examName, $examPerf['pass_rate'][$index], $date, $academicYearId);
                    }
                }
                
                $feeColl = $this->getFeeCollection($institution->id);
                $this->generateMetric($institution->id, 'fee_collection', 'collected', $feeColl['collected'], $date);
                $this->generateMetric($institution->id, 'fee_collection', 'due', $feeColl['due'], $date);
            }
            
            $incomeExpense = $this->getIncomeExpenseTrend($institution->id);
            if (!empty($incomeExpense['labels'])) {
                foreach ($incomeExpense['labels'] as $index => $monthLabel) {
                    $monthDate = date('Y-m', strtotime($incomeExpense['labels'][$index]));
                    $this->generateMetric($institution->id, 'income_expense', 'income_' . $monthDate, $incomeExpense['income'][$index], $date);
                    $this->generateMetric($institution->id, 'income_expense', 'expense_' . $monthDate, $incomeExpense['expense'][$index], $date);
                }
            }
            
            echo "Completed institution: {$institution->institution}\n";
        }
        
        echo "Dashboard snapshot generation completed.\n";
    }

    protected function generateMetric($institutionId, $metricType, $metricKey, $metricValue, $date, $academicYearId = null) {
        DashboardSnapshot::saveSnapshot($institutionId, $metricType, $metricKey, $metricValue, $date, $academicYearId);
    }

    protected function getStudentCount($institutionId, $academicYearId) {
        if (empty($academicYearId)) return 0;
        return Student::model()->count(array(
            'condition' => 'institution=:inst AND academic_year=:year AND status="ACTIVE"',
            'params' => array(':inst' => $institutionId, ':year' => $academicYearId)
        ));
    }

    protected function getTeacherCount($institutionId) {
        return Teacher::model()->count(array(
            'condition' => 'institution=:inst AND status="ACTIVE"',
            'params' => array(':inst' => $institutionId)
        ));
    }

    protected function getTodayAttendanceRate($institutionId) {
        $date = date('Y-m-d');
        $total = Attendance::model()->count(array(
            'condition' => 'institution=:inst AND DATE(attendance_in)=:date',
            'params' => array(':inst' => $institutionId, ':date' => $date)
        ));
        $present = Attendance::model()->count(array(
            'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="PRESENT"',
            'params' => array(':inst' => $institutionId, ':date' => $date)
        ));
        return $total > 0 ? round(($present / $total) * 100, 1) : 0;
    }

    protected function getMonthlyIncome($institutionId) {
        $firstDay = date('Y-m-01');
        $lastDay = date('Y-m-t');
        return (float)Yii::app()->db->createCommand()
            ->select('COALESCE(SUM(amount), 0)')
            ->from('{{income}}')
            ->where('institution=:inst AND expense_date BETWEEN :start AND :end',
                array(':inst' => $institutionId, ':start' => $firstDay, ':end' => $lastDay))
            ->queryScalar();
    }

    protected function getAttendanceTrend($institutionId, $days, $startDate, $endDate) {
        $data = array('labels' => array(), 'present' => array(), 'absent' => array());
        
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end->modify('+1 day'));
        
        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $present = Attendance::model()->count(array(
                'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="PRESENT"',
                'params' => array(':inst' => $institutionId, ':date' => $dateStr)
            ));
            $absent = Attendance::model()->count(array(
                'condition' => 'institution=:inst AND DATE(attendance_in)=:date AND attendance="ABSENT"',
                'params' => array(':inst' => $institutionId, ':date' => $dateStr)
            ));
            $data['labels'][] = $date->format('M d');
            $data['present'][] = (int)$present;
            $data['absent'][] = (int)$absent;
        }
        
        return $data;
    }

    protected function getClassDistribution($institutionId) {
        $data = array('labels' => array(), 'counts' => array());
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
        
        return $data;
    }

    protected function getExamPerformance($institutionId, $academicYearId) {
        $data = array('labels' => array(), 'gpa' => array(), 'pass_rate' => array());
        
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
        
        return $data;
    }

    protected function getFeeCollection($institutionId, $academicYearId = null) {
        $data = array('collected' => 0, 'due' => 0, 'labels' => array('Collected', 'Due'), 'values' => array(0, 0));
        
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
        
        return $data;
    }

    protected function getIncomeExpenseTrend($institutionId) {
        $data = array('labels' => array(), 'income' => array(), 'expense' => array());
        
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
        
        return $data;
    }
}
