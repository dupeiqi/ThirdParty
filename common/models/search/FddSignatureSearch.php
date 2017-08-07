<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FddSignature;

/**
 * DataOrdersSearch represents the model behind the search form of `common\models\DataOrders`.
 */
class FddSignatureSearch extends FddSignature
{
    public $param;
    
//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        return [
//            [['id', 'uid', 'status', 'updated_at', 'created_at'], 'integer'],
//            [['products', 'param', 'is_del'], 'safe'],
//            ['serial_number','string'],
//            ['serial_number','trim'],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function frontendSearch($params,$status = null)
    {
        $query = FddSignature::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => '10'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this -> param){
            $query -> orFilterWhere(['contract_id' => $this -> param]);
             $query->orFilterWhere(['transaction_id', $this->param]);
        }

        

        return $dataProvider;
    }
    
    public function backendSearch($params,$status = null)
    {
        $query = FddSignature::find();
       
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
      
        if ($this->param) {
            $query->orFilterWhere(['contract_id' => $this->param]);
            $query->orFilterWhere(['transaction_id', $this->param]);
        }



        return $dataProvider;
    }
}
