<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseDetail Entity
 *
 * @property int $id
 * @property int $article_id
 * @property int $purchase_id
 * @property int $quantity
 * @property float $total
 *
 * @property \App\Model\Entity\Article $article
 * @property \App\Model\Entity\Purchase $purchase
 */
class PurchaseDetail extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'article_id' => true,
        'purchase_id' => true,
        'quantity' => true,
        'total' => true,
        'article' => true,
        'purchase' => true
    ];
}
