<?php
declare(strict_types=1);

namespace app\models\query;

use Yii;
use yii\db\ActiveQuery;

use app\models\Offer;

class OfferQuery extends ActiveQuery
{

    /**
     * Поиск своего оффера по ID объявления
     * Статус "твердо" или в ожидание "твердо"
     * @param  integer $lot_id     ID объявления
     * @return
     */
    public function myActiveByLot($lot_id)
    {
        return $this->andWhere([
            'lot_id' => $lot_id,
            'company_id' => Yii::$app->user->identity->company_id,
            'status' => [
                Offer::STATUS_WAITING,
                Offer::STATUS_AUCTION
            ]
        ]);
    }

}