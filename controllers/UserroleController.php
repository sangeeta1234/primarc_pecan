<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\UserRole;

class UserroleController extends Controller
{
    public function actionIndex() {
        $user_role = new UserRole();
        $access = $user_role->getAccess();
        if(count($access)>0) {
            if($access[0]['r_view']==1) {
                $data = $user_role->getRoleDetails();
                
                return $this->render('userrole_list', ['data' => $data, 'access' => $access]);
            } else {
                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'Access Denied'),
                    'module' => $this->module,
                    'msg' => '<h4>You donot have access to this page.</h4>'
                ]);
            }
        } else {
            $this->layout = 'other';
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Session Expired'),
                'module' => $this->module,
                'msg' => 'Session Expired. Please <a href="'.Url::base().'index.php">Login</a> again.'
            ]);
        }
    }

    public function actionCreate() {
        $user_role = new UserRole();
        $access = $user_role->getAccess();
        if(count($access)>0) {
            if($access[0]['r_insert']==1) {
                return $this->render('userrole_details');
            } else {
                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'Access Denied'),
                    'module' => $this->module,
                    'msg' => '<h4>You donot have access to this page.</h4>'
                ]);
            }
        } else {
            $this->layout = 'other';
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Session Expired'),
                'module' => $this->module,
                'msg' => 'Session Expired. Please <a href="'.Url::base().'index.php">Login</a> again.'
            ]);
        }
    }

    public function actionEdit($id) {
        $user_role = new UserRole();
        $access = $user_role->getAccess();
        if(count($access)>0) {
            if($access[0]['r_edit']==1) {
                $data = $user_role->getRoleDetails($id);
                $result = $user_role->getRoleOptions($id);
                $editoptions=array();
                if (count($result)>0) {
                    for($i=0;$i<count($result);$i++) {
                        if ($result[$i]['r_section']=="S_Account_Master") $num=0;
                        else if ($result[$i]['r_section']=="S_Purchase") $num=1;
                        else if ($result[$i]['r_section']=="S_Journal_Voucher") $num=2;
                        else if ($result[$i]['r_section']=="S_Payment_Receipt") $num=3;
                        else if ($result[$i]['r_section']=="S_User_Roles") $num=4;
                        else if ($result[$i]['r_section']=="S_Reports") $num=5;

                        $editoptions[$num]=$result[$i];
                    }
                }
                
                return $this->render('userrole_details', ['access' => $access, 'data' => $data, 'editoptions' => $editoptions]);
            } else {
                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'Access Denied'),
                    'module' => $this->module,
                    'msg' => '<h4>You donot have access to this page.</h4>'
                ]);
            }
        } else {
            $this->layout = 'other';
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Session Expired'),
                'module' => $this->module,
                'msg' => 'Session Expired. Please <a href="'.Url::base().'index.php">Login</a> again.'
            ]);
        }
    }

    public function actionSave() { 
        $user_role = new UserRole();
        $access = $user_role->getAccess();
        if(count($access)>0) {
            if($access[0]['r_insert']==1 || $access[0]['r_edit']==1) {
                $result = $user_role->save();
                $this->redirect(array('userrole/index'));
            } else {
                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'Access Denied'),
                    'module' => $this->module,
                    'msg' => '<h4>You donot have access to this page.</h4>'
                ]);
            }
        } else {
            $this->layout = 'other';
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Session Expired'),
                'module' => $this->module,
                'msg' => 'Session Expired. Please <a href="'.Url::base().'index.php">Login</a> again.'
            ]);
        }
    }

    public function actionCheckroleavailablity(){
        $user_role = new UserRole();
        $result = $user_role->checkRoleAvailablity();
        echo $result;
    }
}
?>