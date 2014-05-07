<?php

class HybridauthController extends Controller
{
    public function actionLogin()
    {
        if (!isset($_GET['provider']))
        {
            $this->redirect(array('/site/index'));
            return;
        }

        try
        {
            Yii::import('application.components.HybridAuthIdentity');
            $haComp = new HybridAuthIdentity();
            if (!$haComp->validateProviderName($_GET['provider']))
                throw new CHttpException ('500', 'Invalid Action. Please try again.');

            $haComp->adapter = $haComp->hybridAuth->authenticate($_GET['provider']);

            if(isset($_GET['message']))
            {
                $haComp->adapter->setUserStatus( $_GET['message'] );
                return;
            }

            else
            {
                $haComp->userProfile = $haComp->adapter->getUserProfile();
                $haComp->login();

                $this->redirect(SessionManager::GET_SESSION('lastUrl'));
            }
        }
        catch (Exception $e)
        {
            //process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
            throw new CHttpException(403, $e);
            return;
        }
    }

    public function actionSocialLogin()
    {
        Yii::import('application.components.HybridAuthIdentity');
        $path = Yii::getPathOfAlias('ext.hybridauth');
        require_once $path . '/index.php';
    }

    public function actionShareContent()
    {
        try
        {
            Yii::import('application.components.HybridAuthIdentity');
            $haComp = new HybridAuthIdentity();
            if (!$haComp->validateProviderName($_GET['provider']))
                throw new CHttpException ('500', 'Invalid Action. Please try again.');

            $haComp->adapter = $haComp->hybridAuth->authenticate($_GET['provider']);
            $haComp->userProfile = $haComp->adapter->getUserProfile();

            $haComp->login();
            $this->redirect(array('site/index?success=1'));
        }
        catch (Exception $e)
        {
            //process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
            throw new CHttpException(403, $e);
            return;
        }
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}