<?php
return [
    'inward' => [
        'created' => [
            'next' => ['approved', 'rejected'],
            'effects' => ['set_inward_detail_created', 'update_stock', 'set_pallet_in'],
        ],
        'approved' => [
            'next' => ['finalized', 'cancelled'],
            'effects' => ['set_inward_detail_approved'],
        ],
        'finalized' => [
            'next' => ['cancelled'],
            'effects' => ['set_inward_detail_finalized'],
        ],
        'cancelled' => [
            'next' => [],
            'effects' => ['set_inward_detail_cancelled', 'update_stock', 'set_pallet_cancelled'],
        ],
        'picked' => [
            'next' => ['cancelled'],
            'effects' => [],
        ],
        'moved to out' => [
            'next' => ['cancelled'],
            'effects' => [],
        ],
        'dispatched' => [
            'next' => [],
            'effects' => [],
        ],
        'rejected' => [
            'next' => [],
            'effects' => ['set_inward_detail_rejected', 'update_stock', 'set_pallet_rejected'],
        ],
    ],

    'picklist' => [
        'created' => [
            'next' => ['approved', 'rejected'],
            'effects' => ['set_picklist_detail_created'],
        ],
        'approved' => [
            'next' => ['finalized', 'cancelled'],
            'effects' => ['set_picklist_detail_approved'],
        ],
        'finalized' => [
            'next' => ['cancelled'],
            'effects' => ['set_picklist_detail_finalized', 'set_pallet_picked'],
        ],
        'cancelled' => [
            'next' => [],
            'effects' => ['set_picklist_detail_cancelled', 'set_pallet_in'],
        ],
        'picked' => [
            'next' => ['cancelled'],
            'effects' => [],
        ],
        'moved to out' => [
            'next' => ['cancelled'],
            'effects' => [],
        ],
        'dispatched' => [
            'next' => [],
            'effects' => [],
        ],
        'rejected' => [
            'next' => [],
            'effects' => ['set_picklist_detail_rejected'],
        ],
    ],

    'outward' => [
        'created' => [
            'next' => ['approved', 'rejected'],
            'effects' => ['set_outward_detail_created'],
        ],
        'approved' => [
            'next' => ['finalized', 'cancelled'],
            'effects' => ['set_outward_detail_approved'],
        ],
        'finalized' => [
            'next' => ['cancelled'],
            'effects' => ['set_outward_detail_finalized', 'update_stock', 'set_pallet_out'],
        ],
        'cancelled' => [
            'next' => [],
            'effects' => ['set_outward_detail_cancelled', 'update_stock', 'set_pallet_picked'],
        ],
        'picked' => [
            'next' => ['cancelled'],
            'effects' => [],
        ],
        'moved to out' => [
            'next' => ['cancelled'],
            'effects' => [],
        ],
        'dispatched' => [
            'next' => [],
            'effects' => ['update_stock', 'set_pallet_out'],
        ],
        'rejected' => [
            'next' => [],
            'effects' => ['set_outward_detail_rejected', 'update_stock', 'set_pallet_picked'],
        ],
    ],
];

