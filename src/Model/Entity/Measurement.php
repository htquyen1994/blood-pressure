<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Measurement Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $systolic
 * @property int|null $diastolic
 * @property int|null $heart_rate
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Measurement extends Entity
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
        'user_id' => true,
        'systolic' => true,
        'diastolic' => true,
        'heart_rate' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
