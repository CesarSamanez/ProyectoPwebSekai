<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Purchase Entity
 *
 * @property int $id
 * @property int $quantity
 * @property int $users_id
 * @property float $total
 * @property \Cake\I18n\FrozenTime $date
 *
 * @property \App\Model\Entity\PurchaseDetail[] $purchase_details
 */
class Purchase extends Entity
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
        'quantity' => true,
        'users_id' => true,
        'total' => true,
        'date' => true,
        'purchase_details' => true
    ];
}
