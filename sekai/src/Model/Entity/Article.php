<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $categories_id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property int $stock
 * @property float $price
 * @property float $referential_price
 *
 * @property \App\Model\Entity\Category $category
 */
class Article extends Entity
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
        'categories_id' => true,
        'code' => true,
        'name' => true,
        'description' => true,
        'stock' => true,
        'price' => true,
        'referential_price' => true,
        'category' => true
    ];
}
