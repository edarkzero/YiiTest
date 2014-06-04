<?php

/**
 * This is the model class for table "distribucion_puntos_grupos".
 *
 * The followings are the available columns in table 'distribucion_puntos_grupos':
 * @property integer $id
 * @property integer $id_punto_asociador
 * @property integer $id_punto
 *
 * The followings are the available model relations:
 * @property DistribucionPuntos $idPuntoAsociador
 * @property DistribucionPuntos $idPunto
 */
class DistribucionPuntosGrupos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'distribucion_puntos_grupos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_punto_asociador, id_punto', 'required'),
			array('id_punto_asociador, id_punto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_punto_asociador, id_punto', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idPuntoAsociador' => array(self::BELONGS_TO, 'DistribucionPuntos', 'id_punto_asociador'),
			'idPunto' => array(self::BELONGS_TO, 'DistribucionPuntos', 'id_punto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_punto_asociador' => 'Id Punto Asociador',
			'id_punto' => 'Id Punto',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_punto_asociador',$this->id_punto_asociador);
		$criteria->compare('id_punto',$this->id_punto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DistribucionPuntosGrupos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
