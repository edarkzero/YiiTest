<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 08/11/13
 * Time: 10:05 AM
 */

class Mail {

    public static function sendMail($model = null, $message, $subject, $address = false, $reply = false)
    {
        $testing = Yii::app()->params['testing'];

        try
        {
            $mailer = Yii::createComponent('application.extensions.mailer.EMailer');

            if ($model != null)
            {
                foreach ($model->attributes as $key => $attribute)
                {

                    if (Validator::HAS_DATA($attribute) && $key != 'verifyCode')
                    {
                        if ($key != 'file')
                        {
                            $message .= '<div style="position: relative; overflow: hidden;"><p style="float: left;"><b>' . Yii::t('app', $key) . ': </b></p><p style="float: left; margin-left: 10px;max-width: 600px;">' . nl2br($attribute) . '</p></div><div style="clear: both;"></div>';
                        }

                        else
                        {
                            $mailer->AddAttachment($model->file->tempName, $model->file);
                        }
                    }
                }
            }

            if ($testing)
            {
	            /*$mailer->IsSendmail();
	            $mailer->Host = 'smtp.scripsanddeals.com';
	            $mailer->Port = 25;
	            $mailer->Username = 'master@scripsanddeals.com';
	            $mailer->Password = '3Hon!8h0';
	            $mailer->From = 'master@scripsanddeals.com';
	            $mailer->FromName = 'Scrips&Deals';*/

	            $mailer->SMTPAuth = true;
	            $mailer->IsSMTP();
	            $mailer->Host = 'ssl://smtp.gmail.com';
	            $mailer->Port = 465;
	            $mailer->Username = 'edgarcardona87@gmail.com';
	            $mailer->Password = '1010060887zero1010';
	            $mailer->From = 'santiagof4@gmail.com';
	            $mailer->FromName = 'Scrips&Deals';

	            $mailer->AddAddress('edgarcardona87@gmail.com');
            }

            else
            {
	            $mailer->IsSendmail();
	            $mailer->Host = 'smtp.scripsanddeals.com';
	            $mailer->Port = 25;
	            $mailer->Username = 'master@scripsanddeals.com';
	            $mailer->Password = '3Hon!8h0';
	            $mailer->From = 'master@scripsanddeals.com';
	            $mailer->FromName = 'Scrips&Deals';

                if ($address)
                {
	                if(is_array($address))
	                {
	                    foreach ($address as $add)
	                    {
	                        $mailer->AddAddress($add);
	                    }
	                }
	                elseif(is_string($address))
	                {
		                $address = explode(';',$address);

		                foreach ($address as $add)
		                {
			                $mailer->AddAddress($add);
		                }
	                }
                }
                else
                {
                    //$mailer->AddAddress('oferta_demanda@laofertaylademanda.com');
                }

                //$mailer->AddAddAddress('ecardona@aia-sc.com');

            }

            if ($reply)
            {
	            if(is_array($reply))
	            {
		            foreach ($reply as $addReply)
		            {
			            $mailer->AddReplyTo($addReply);
		            }
	            }
	            elseif(is_string($reply))
	            {
		            $reply = explode(';',$address);

		            foreach ($reply as $addReply)
		            {
			            $mailer->AddReplyTo($addReply);
		            }
	            }
            }

            $mailer->IsHTML(true);
            $mailer->CharSet = 'UTF-8';
            $mailer->Subject = $subject;
            $mailer->Body    = $message;

            if (!$mailer->Send())
            {
                error_log($mailer->ErrorInfo, 0);
                $result = "Hubo un inconveniente al enviar el correo.<br />" . $mailer->ErrorInfo . ". Por favor, inténtalo más tarde.";
                Yii::app()->user->setFlash('error', $result);
            }
            else Yii::app()->user->setFlash('successMail', Yii::t('app', 'Your mail has been send successfully') . '.');

        }
        catch (phpmailerException $e)
        {
            Yii::app()->user->setFlash('notice', $e->errorMessage());
            throw new CHttpException(403, $e->errorMessage());
        }
        catch (Exception $e)
        {
            Yii::app()->user->setFlash('notice', $e->getMessage());
            throw new CHttpException(403, $e->getMessage());
        }

    }

} 