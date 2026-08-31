<?php

class ReportController extends Controller {

    public function actionAdmitcard() {
        $this->layout = '//layouts/column2';
        $this->render('admitcard');
    }

    public function actionAdmitcardprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('admitcardprint');
    }

    public function actionIdcard() {
        $this->layout = '//layouts/column2';
        $this->render('idcard');
    }

    public function actionIdcardprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('idcardprint');
    }

    public function actionIdcardadmin() {
        $this->layout = '//layouts/column2';
        $this->render('idcardadmin');
    }

    public function actionIdcardadminprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('idcardadminprint');
    }

    public function actionSeatplanning() {
        $this->layout = '//layouts/column2';
        $this->render('seatplanning');
    }

    public function actionSeatplanningprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('seatplanningprint');
    }

    public function actionTabulationsheet() {
        $this->layout = '//layouts/column2';
//        $this->render('tabulationsheet');
        $model = new MarkParent('search_tabulationsheet');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MarkParent']))
            $model->attributes = $_GET['MarkParent'];

        $this->render('tabulationsheet', array(
            'model' => $model,
        ));
    }

    public function actionTabulationsheetprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('tabulationsheetprint');
    }

    public function actionTabulationsheetv2print() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('tabulationsheetv2print');
    }

    public function actionTabulationsheetv3print() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('tabulationsheetv3print');
    }

    public function actionProgressreport() {
        $this->layout = '//layouts/column2';
//        $this->render('tabulationsheet');
        $model = new MarkParent('search_tabulationsheet');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MarkParent']))
            $model->attributes = $_GET['MarkParent'];

        $this->render('progressreport', array(
            'model' => $model,
        ));
    }

    public function actionProgressreportprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('progressreportprint');
    }

    public function actionGrandfinal() {
        $this->layout = '//layouts/column2';
        $model = new MarkParent('search_grandfinal');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MarkParent']))
            $model->attributes = $_GET['MarkParent'];

        $this->render('grandfinal', array(
            'model' => $model,
        ));
    }

    public function actionProgressreportfinalprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('progressreportfinalprint');
    }

    public function actionMeritlist() {
        $this->layout = '//layouts/column2';

        $model_class = new MeritPosition('search_class');
        $model_class->unsetAttributes();  // clear any default values
        if (isset($_GET['MeritPosition']))
            $model_class->attributes = $_GET['MeritPosition'];

        $model_section = new MeritPosition('search_section');
        $model_section->unsetAttributes();  // clear any default values
        if (isset($_GET['MeritPosition']))
            $model_section->attributes = $_GET['MeritPosition'];

        $model = new MeritPosition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MeritPosition']))
            $model->attributes = $_GET['MeritPosition'];

        $this->render('meritlist', array(
            'model_class' => $model_class,
            'model_section' => $model_section,
            'model' => $model,
        ));
    }

    public function actionMeritlistclassprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('meritlistclassprint');
    }

    public function actionMeritlistsectionprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('meritlistsectionprint');
    }

    public function actionMeritlistprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('meritlistprint');
    }

    public function actionFaillist() {
        $this->layout = '//layouts/column2';

        $model_class = new MeritPosition('search_class');
        $model_class->unsetAttributes();  // clear any default values
        if (isset($_GET['MeritPosition']))
            $model_class->attributes = $_GET['MeritPosition'];

        $model_section = new MeritPosition('search_section');
        $model_section->unsetAttributes();  // clear any default values
        if (isset($_GET['MeritPosition']))
            $model_section->attributes = $_GET['MeritPosition'];

        $model = new MeritPosition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MeritPosition']))
            $model->attributes = $_GET['MeritPosition'];

        $this->render('faillist', array(
            'model_class' => $model_class,
            'model_section' => $model_section,
            'model' => $model,
        ));
    }

    public function actionFaillistclassprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('faillistclassprint');
    }

    public function actionFaillistsectionprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('faillistsectionprint');
    }

    public function actionFaillistprint() {
        set_time_limit(0);
        $this->layout = '//layouts/print';
        $this->render('faillistprint');
    }

//    public function actionGreenleaf() {
//        set_time_limit(0);
//        $this->layout = '//layouts/print';
//        $this->render('greenleaf');
//    }
}
