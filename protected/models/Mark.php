<?php

/**
 * This is the model class for table "{{mark}}".
 *
 * The followings are the available columns in table '{{mark}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $student
 * @property integer $class
 * @property integer $section
 * @property integer $group
 * @property integer $subject
 * @property integer $exam
 * @property integer $academic_year
 * @property string  $sid
 * @property integer $roll
 * @property string $calculate_percent
 * @property integer $full_mark
 * @property string $highest_mark
 * @property string $written
 * @property string $mcq
 * @property string $practical
 * @property string $class_assessment
 * @property string $absence
 * @property string $subject_total
 * @property string $letter_grade
 * @property string $gpa
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Student $student0
 * @property Class $class0
 * @property Section $section0
 * @property StudentGroup $group0
 * @property Subject $subject0
 * @property Exam $exam0
 * @property AcademicYear $academicYear
 */
class Mark extends CActiveRecord {

    public $markid, $total_row, $actualPercent, $total;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{mark}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, student, class, section, group, subject, exam, academic_year', 'required'),
            array('institution, parent, student, class, section, group, subject, exam, academic_year, roll, full_mark, created_by, updated_by, markid', 'numerical', 'integerOnly' => true),
            array('calculate_percent, highest_mark, written, mcq, practical, class_assessment, subject_total, gpa, marge_gpa', 'length', 'max' => 6),
            array('absence', 'length', 'max' => 3),
            array('letter_grade, marge_grade', 'length', 'max' => 10),
            array('sid', 'length', 'max' => 50),
            array('created_on, updated_on', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, parent, student, class, section, group, subject, exam, academic_year, sid, roll, calculate_percent, full_mark, highest_mark, written, mcq, practical, class_assessment, absence, subject_total, letter_grade, gpa, marge_grade, marge_gpa, created_on, updated_on, created_by, updated_by, markid', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
            'student0' => array(self::BELONGS_TO, 'Student', 'student'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'group0' => array(self::BELONGS_TO, 'StudentGroup', 'group'),
            'subject0' => array(self::BELONGS_TO, 'Subject', 'subject'),
            'exam0' => array(self::BELONGS_TO, 'Exam', 'exam'),
            'academicYear' => array(self::BELONGS_TO, 'AcademicYear', 'academic_year'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'student' => 'Student',
            'class' => 'Class',
            'section' => 'Section',
            'group' => 'Group',
            'subject' => 'Subject',
            'exam' => 'Exam',
            'academic_year' => 'Academic Year',
            'sid' => 'Student ID',
            'roll' => 'Roll',
            'calculate_percent' => 'Precentage',
            'full_mark' => 'Full Marks',
            'highest_mark' => 'Highest Mark',
            'written' => 'Written',
            'mcq' => 'MCQ',
            'practical' => 'Practical',
            'class_assessment' => 'Class Assessment',
            'absence' => 'Absent',
            'subject_total' => 'Subject Total',
            'letter_grade' => 'Letter Grade',
            'gpa' => 'GPA',
            'marge_grade' => 'Marge Grade',
            'marge_gpa' => 'Marge GPA',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('student', $this->student);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('subject', $this->subject);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('sid', $this->sid);
        $criteria->compare('roll', $this->roll);
        $criteria->compare('calculate_percent', $this->calculate_percent, true);
        $criteria->compare('full_mark', $this->full_mark);
        $criteria->compare('highest_mark', $this->highest_mark, true);
        $criteria->compare('written', $this->written, true);
        $criteria->compare('mcq', $this->mcq, true);
        $criteria->compare('practical', $this->practical, true);
        $criteria->compare('class_assessment', $this->class_assessment, true);
        $criteria->compare('absence', $this->absence, true);
        $criteria->compare('subject_total', $this->subject_total, true);
        $criteria->compare('letter_grade', $this->letter_grade, true);
        $criteria->compare('gpa', $this->gpa, true);
        $criteria->compare('marge_grade', $this->marge_grade, true);
        $criteria->compare('marge_gpa', $this->marge_gpa, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Mark the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Mark::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getHighestMark($institution, $class, $section, $group, $subject, $exam, $academic_year) {
        $criteria = new CDbCriteria;
        $criteria->select = 'ROUND(MAX(subject_total),2) AS highest_mark';
        $criteria->condition = 'institution=' . $institution . ' AND class=' . $class . ' AND section=' . $section . ' AND `group`=' . $group . ' AND subject=' . $subject . ' AND exam=' . $exam . ' AND academic_year=' . $academic_year;
        $model = Mark::model()->find($criteria);
        if (empty($model->highest_mark)) {
            return null;
        } else {
            return $model->highest_mark;
        }
    }

    public static function getSubjectTotal($full_mark, $class_assessment_actual, $written, $mcq, $practical, $class_assessment, $calculate_percent) {
        if ($class_assessment_actual > 0) {
//            $total_marks = (int) $written + (int) $mcq + (int) $practical;
//            $actual_without_ca = $full_mark - $class_assessment_actual;
//            $percentage = (@$actual_without_ca * 100) / @$full_mark;
//            $subject_total = (($total_marks * $percentage) / 100) + $class_assessment;

            $subject_total_without_ca = (int) $written + (int) $mcq + (int) $practical;
            $subject_total_percent = round(Mark::getPercent($full_mark, $subject_total_without_ca, $calculate_percent), 0);
            $subject_total = $subject_total_percent + (int) $class_assessment;           

//            $subject_total = (int) $written + (int) $mcq + (int) $practical + (int) $class_assessment; //update @December 6 2021
        } else {
            $subject_total = (int) $written + (int) $mcq + (int) $practical;
        }

        return $subject_total;
    }

    public static function getPercent($full_mark, $subject_total, $calculate_percent = 100) {
        $percentage = (@$subject_total * $calculate_percent) / @$full_mark;
        return $percentage;
    }

    public static function getLetterGrade($institution, $class, $full_mark, $subject_total) {
        $percentage = ($subject_total * 100) / $full_mark;

        $criteria = new CDbCriteria;
        $criteria->select = 'grade_name';
        $criteria->condition = 'class=' . $class . ' AND ' . $percentage . '>=mark_from AND ' . $percentage . '<mark_upto AND institution=' . $institution;
        $model = Grade::model()->find($criteria);
        if (empty($model->grade_name)) {
            return 'F';
        } else {
            return $model->grade_name;
        }
    }

    public static function getGPA($institution, $class, $full_mark, $subject_total) {
        $percentage = ($subject_total * 100) / $full_mark;

        $criteria = new CDbCriteria;
        $criteria->select = 'grade_point';
        $criteria->condition = 'class=' . $class . ' AND ' . $percentage . '>=mark_from AND ' . $percentage . '<mark_upto AND institution=' . $institution;
        $model = Grade::model()->find($criteria);
        if (empty($model->grade_point)) {
            return 0;
        } else {
            return $model->grade_point;
        }
    }

    public static function getSemesterTotalMarks($institution, $student, $class, $section, $group, $exam, $year) {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(t.subject_total) AS subject_total';
        $criteria->condition = 't.institution=' . $institution . ' AND S.`type`!="UNCOUNTABLE" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
        $model = Mark::model()->find($criteria);
        return $model->subject_total;
    }

    public static function getSemesterTotalActualMarks($institution, $student, $class, $section, $group, $exam, $year) {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(t.full_mark) AS full_mark';
        $criteria->condition = 't.institution=' . $institution . ' AND S.`type`!="UNCOUNTABLE" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
        $model = Mark::model()->find($criteria);
        return $model->full_mark;
    }

    public static function getSemesterFailedSubject($institution, $student, $class, $section, $group, $exam, $year) {
        $criteria_fail_count = new CDbCriteria;
        $criteria_fail_count->condition = 't.institution=' . $institution . ' AND S.`type` IN("COMPULSARY","GROUP BASED") AND S.`marge_id`>0 AND t.`marge_grade`="F" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_fail_count->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
        $criteria_fail_count->group = 'S.marge_id';
        $MODEl_FAIL_COUNT = Mark::model()->findAll($criteria_fail_count);
        $MARGED_TOTAL_ROW = count($MODEl_FAIL_COUNT);

        $criteria_fail = new CDbCriteria;
        $criteria_fail->select = 'COUNT(*) AS total_row';
        $criteria_fail->condition = 't.institution=' . $institution . ' AND S.`type` IN("COMPULSARY","GROUP BASED") AND S.`marge_id`=0 AND t.`letter_grade`="F" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_fail->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
        $MODEl_FAIL = Mark::model()->find($criteria_fail);
        return $MODEl_FAIL->total_row + $MARGED_TOTAL_ROW;
    }

    public static function getSemesterMeritData($institution, $student, $class, $section, $group, $exam, $year) {
        $criteria = new CDbCriteria;
        $criteria->select = 'class_position, section_position, group_position, failed_subject';
        $criteria->condition = 'institution=' . $institution . ' AND student=' . $student . ' AND `class`=' . $class . ' AND `section`=' . $section . ' AND `group`=' . $group . ' AND `exam`=' . $exam . ' AND `academic_year`=' . $year;
        $model = MeritPosition::model()->find($criteria);

        if (isset($model->class_position)) {
            $data['class_position'] = $model->class_position;
        } else {
            $data['class_position'] = null;
        }
        if (isset($model->section_position)) {
            $data['section_position'] = $model->section_position;
        } else {
            $data['section_position'] = null;
        }
        if (isset($model->group_position)) {
            $data['group_position'] = $model->group_position;
        } else {
            $data['group_position'] = null;
        }
        if (isset($model->failed_subject)) {
            $data['failed_subject'] = $model->failed_subject;
        } else {
            $data['failed_subject'] = null;
        }

        return $data;
    }

    public static function getSemesterData($institution, $student, $class, $section, $group, $exam, $year) {
        //COMPULSARY AND GROUP BASED subject calculation - MARGED SUBJECTS COUNT
        $criteria_compulsary_total = new CDbCriteria;
        $criteria_compulsary_total->condition = 't.institution=' . $institution . ' AND S.`type` IN("COMPULSARY","GROUP BASED") AND S.`marge_id`>0 AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_compulsary_total->join = 'LEFT OUTER JOIN {{subject}} S ON S.`id` = t.`subject`';
        $criteria_compulsary_total->group = 'S.marge_id';
        $MODEl_MARGED_TOTAL = Mark::model()->findAll($criteria_compulsary_total);
        $MARGED_TOTAL_ROW = count($MODEl_MARGED_TOTAL);

        //COMPULSARY AND GROUP BASED subject calculation - MARGED SUBJECTS
        $criteria_compulsary_marged = new CDbCriteria;
        $criteria_compulsary_marged->select = 'SUM(t.subject_total) AS subject_total, SUM(t.gpa) AS gpa, COUNT(*) AS total_row';
        $criteria_compulsary_marged->condition = 't.institution=' . $institution . ' AND S.`type` IN("COMPULSARY","GROUP BASED") AND S.`marge_id`>0 AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_compulsary_marged->join = 'LEFT OUTER JOIN {{subject}} S ON S.`id` = t.`subject`';
        $MODEl_COMPULSARY_MARGED = Mark::model()->find($criteria_compulsary_marged);

        //COMPULSARY AND GROUP BASED subject calculation
        $criteria_compulsary = new CDbCriteria;
        $criteria_compulsary->select = 'SUM(t.subject_total) AS subject_total, SUM(t.gpa) AS gpa, COUNT(*) AS total_row';
        $criteria_compulsary->condition = 't.institution=' . $institution . ' AND S.`type` IN("COMPULSARY","GROUP BASED") AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_compulsary->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
        $MODEl_COMPULSARY = Mark::model()->find($criteria_compulsary);
        $COMPULSARY_TOTAL = $MODEl_COMPULSARY->subject_total;

        //CHOOSABLE subject calculation 
        $criteria_optional = new CDbCriteria;
        $criteria_optional->select = 'SUM(t.subject_total) AS subject_total, SUM(t.gpa) AS gpa, COUNT(*) AS total_row';
        $criteria_optional->condition = 't.institution=' . $institution . ' AND S.`type`="CHOOSABLE" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_optional->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
        $MODEl_CHOOSABLE = Mark::model()->find($criteria_optional);
//        $CHOOSABLE_TOTAL = $MODEl_CHOOSABLE->subject_total;
        $CHOOSABLE_GPA = @sprintf('%0.2f', @$MODEl_CHOOSABLE->gpa / @$MODEl_CHOOSABLE->total_row);
        if ($CHOOSABLE_GPA > 2) {
            $CHOOSABLE_GPA = $CHOOSABLE_GPA - 2;
        } else {
            $CHOOSABLE_GPA = 0;
        }

        //check if any fail subject available 
        $criteria_fail = new CDbCriteria;
        $criteria_fail->select = 'COUNT(*) AS total_row';
        $criteria_fail->condition = 't.`institution`=' . $institution . ' AND S.`marge_id`=0 AND S.`type` IN("COMPULSARY","GROUP BASED") AND t.`letter_grade`="F" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_fail->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject` LEFT JOIN {{subject_mark}} SM ON SM.`subject` = t.`subject`';
        $MODEl_FAIL1 = Mark::model()->find($criteria_fail);
        $FAIL_TOTAL1 = $MODEl_FAIL1->total_row;

        $criteria_fail2 = new CDbCriteria;
        $criteria_fail2->select = 'COUNT(*) AS total_row';
        $criteria_fail2->condition = 't.`institution`=' . $institution . ' AND S.`marge_id`>0 AND S.`type` IN("COMPULSARY","GROUP BASED") AND t.`marge_grade`="F" AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteria_fail2->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject` LEFT JOIN {{subject_mark}} SM ON SM.`subject` = t.`subject`';
        $MODEl_FAIL2 = Mark::model()->find($criteria_fail2);
        $FAIL_TOTAL2 = $MODEl_FAIL2->total_row;

        $FAIL_TOTAL = $FAIL_TOTAL1 + $FAIL_TOTAL2;

        //Mark calculation regarding actual and optional
        $total_subject = ($MODEl_COMPULSARY->total_row - $MARGED_TOTAL_ROW);
        if ($total_subject == 0)
            $total_subject = 1;

        //Division by zero - fix
        if ($MARGED_TOTAL_ROW <= 0)
            $MARGED_TOTAL_ROW = 1;
        $total_gpa = $MODEl_COMPULSARY->gpa - ($MODEl_COMPULSARY_MARGED->gpa / @$MARGED_TOTAL_ROW);

//        $actual_gpa = @sprintf('%0.2f', $total_gpa / $total_subject); // without 4th subjects 
        $actual_gpa = ROUND(($total_gpa / @$total_subject), 2); // without 4th subjects 
        if ($actual_gpa > 5) {
            $actual_gpa = 5.0;
        }
//        $mandatory_gpa = @sprintf('%0.2f', ($total_gpa + $CHOOSABLE_GPA) / $total_subject); // with 4th subjects 
        $mandatory_gpa = ROUND(($total_gpa + $CHOOSABLE_GPA) / $total_subject, 2); // with 4th subjects 
        if ($mandatory_gpa > 5) {
            $gpa = 5.0;
        } else {
            $gpa = $mandatory_gpa;
        }

        $data['gpa'] = (($FAIL_TOTAL) || empty($COMPULSARY_TOTAL)) ? '0.00' : $gpa;
        $data['gpa_actual'] = (($FAIL_TOTAL) || empty($COMPULSARY_TOTAL)) ? '0.00' : $actual_gpa;
        $data['letter_grade'] = ($FAIL_TOTAL) ? 'F' : Mark::letter_grade($institution, $class, $gpa);
        $data['letter_grade_actual'] = ($FAIL_TOTAL) ? 'F' : Mark::letter_grade($institution, $class, $actual_gpa);

        return $data;
    }

    public static function letter_grade($institution, $class, $grade_point) {
//        $criteria = new CDbCriteria;
//        $criteria->select = 'grade_name';
//        $criteria->condition = 'class=' . $class . ' AND ' . $grade_point . '>=grade_point AND ' . $grade_point . '<=grade_point AND institution=' . $institution;
//        $model = Grade::model()->find($criteria);
//        if (empty($model->grade_name)) {
//            return 'F';
//        } else {
//            return $model->grade_name;
//        }
        if ($grade_point >= 5) {
            $grade_point = 'A+';
        } else if ($grade_point >= 4) {
            $grade_point = 'A';
        } else if ($grade_point >= 3.5) {
            $grade_point = 'A-';
        } else if ($grade_point >= 3) {
            $grade_point = 'B';
        } else if ($grade_point >= 2) {
            $grade_point = 'C';
        } else if ($grade_point >= 1) {
            $grade_point = 'D';
        } else {
            $grade_point = 'F';
        }
        return $grade_point;
    }

    public static function getAnotherMargeSubject($institution, $class, $marge_id, $subject) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.`id`';
        $criteria->condition = 't.institution=' . $institution . ' AND t.`class`=' . $class . ' AND t.`id`!=' . $subject . ' AND t.`marge_id`=' . $marge_id;
        $model = Subject::model()->find($criteria);
        return $model->id;
    }

    public static function getMargeLetterGrade($institution, $class, $marge_id, $student, $exam, $year) {
        $criteriaF = new CDbCriteria;
        $criteriaF->select = 'count(*) AS total_row';
        $criteriaF->condition = 't.`institution`=' . $institution . ' AND SM.`passed_separately`="Yes" AND t.`letter_grade`="F" AND t.`class`=' . $class . ' AND S.`marge_id`=' . $marge_id . ' AND t.student=' . $student . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteriaF->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject` LEFT JOIN {{subject_mark}} SM ON SM.`subject` = t.`subject`';
        $modelF = Mark::model()->find($criteriaF);
        if ($modelF->total_row == 0) {
            $criteriaa = new CDbCriteria;
            $criteriaa->select = 'SUM(t.full_mark) AS full_mark, SUM(t.subject_total) AS subject_total';
            $criteriaa->condition = 't.institution=' . $institution . ' AND t.`class`=' . $class . ' AND S.`marge_id`=' . $marge_id . ' AND t.student=' . $student . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
            $criteriaa->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
            $modela = Mark::model()->find($criteriaa);

            $percentage = (@$modela->subject_total * 100) / @$modela->full_mark;

            $criteria = new CDbCriteria;
            $criteria->select = 'grade_name';
            $criteria->condition = 'class=' . $class . ' AND ' . $percentage . '>=mark_from AND ' . $percentage . '<mark_upto AND institution=' . $institution;
            $model = Grade::model()->find($criteria);
            if (empty($model->grade_name)) {
                return 'F';
            } else {
                return $model->grade_name;
            }
        } else {
            return 'F';
        }
    }

    public static function getMargeGPA($institution, $class, $marge_id, $student, $exam, $year) {
        $criteriaF = new CDbCriteria;
        $criteriaF->select = 'count(*) AS total_row';
        $criteriaF->condition = 't.`institution`=' . $institution . ' AND SM.`passed_separately`="Yes" AND t.`letter_grade`="F" AND t.`class`=' . $class . ' AND S.`marge_id`=' . $marge_id . ' AND t.student=' . $student . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
        $criteriaF->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject` LEFT JOIN {{subject_mark}} SM ON SM.`subject` = t.`subject`';
        $modelF = Mark::model()->find($criteriaF);
        if ($modelF->total_row == 0) {
            $criteriaa = new CDbCriteria;
            $criteriaa->select = 'SUM(t.full_mark) AS full_mark, SUM(t.subject_total) AS subject_total';
            $criteriaa->condition = 't.institution=' . $institution . ' AND t.`class`=' . $class . ' AND S.`marge_id`=' . $marge_id . ' AND t.student=' . $student . ' AND t.`exam`=' . $exam . ' AND t.`academic_year`=' . $year;
            $criteriaa->join = 'LEFT JOIN {{subject}} S ON S.`id` = t.`subject`';
            $modela = Mark::model()->find($criteriaa);

            $percentage = ($modela->subject_total * 100) / $modela->full_mark;

            $criteria = new CDbCriteria;
            $criteria->select = 'grade_point';
            $criteria->condition = 'class=' . $class . ' AND ' . $percentage . '>=mark_from AND ' . $percentage . '<mark_upto AND institution=' . $institution;
            $model = Grade::model()->find($criteria);
            if (empty($model->grade_point)) {
                return 0;
            } else {
                return $model->grade_point;
            }
        } else {
            return 0;
        }
    }

    public static function getMargedMarkesActual($institution, $class, $marge_id, $field) {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(t.' . $field . ') AS ' . $field . '';
        $criteria->condition = 't.`subject` IN(SELECT S.`id` FROM {{subject}} S WHERE S.`institution`=' . $institution . ' AND S.`class`=' . $class . ' AND S.`marge_id`=' . $marge_id . ')';
        $model = SubjectMark::model()->find($criteria);
        return $model->$field;
    }

    public static function getMargedMarkes($institution, $class, $marge_id, $student, $exam, $year, $field) {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(t.' . $field . ') AS ' . $field . '';
        $criteria->condition = 't.student=' . $student . ' AND t.exam=' . $exam . ' AND t.academic_year=' . $year . ' AND t.`subject` IN(SELECT S.`id` FROM {{subject}} S WHERE S.`institution`=' . $institution . ' AND S.`class`=' . $class . ' AND S.`marge_id`=' . $marge_id . ')';
        $model = Mark::model()->find($criteria);
        return $model->$field;
    }

    public static function getGrandFinalGPA($institution, $student, $class, $section, $group, $subject, $year) {
        $criteria = new CDbCriteria;
        $criteria->select = 'ROUND(AVG(t.`gpa`),2) AS gpa';
        $criteria->condition = 't.institution=' . $institution . ' AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`subject`=' . $subject . ' AND t.`academic_year`=' . $year;
        $model = Mark::model()->find($criteria);
        return $model->gpa;
    }

    public static function getGrandFinalGrade($institution, $student, $class, $section, $group, $subject, $year) {
        $criteria = new CDbCriteria;
        $criteria->select = 'ROUND(AVG(t.`gpa`),2) AS gpa';
        $criteria->condition = 't.institution=' . $institution . ' AND t.student=' . $student . ' AND t.`class`=' . $class . ' AND t.`section`=' . $section . ' AND t.`group`=' . $group . ' AND t.`subject`=' . $subject . ' AND t.`academic_year`=' . $year;
        $model = Mark::model()->find($criteria);
        return Mark::letter_grade($institution, $class, $model->gpa);
    }

}
