<?php

return [
    'daily_report' => [
        'to' => [
            78852817,
            386370863
        ],
        'data_class' => 'DailyReport',
        'data_params' => '',
        'schedule' => [
            'dailyAt' => '10:00'
        ],
    ],
    'weekly_report' => [
        'to' => [
            78852817,
            386370863
        ],
        'data_class' => 'WeeklyReport',
        'data_params' => '',
        'schedule' => [
            'weeklyAt' => '10:05'
        ],
    ],
    'monthly_report' => [
        'to' => [
            78852817,
            386370863
        ],
        'data_class' => 'MonthlyReport',
        'data_params' => '',
        'schedule' => [
            'monthlyAt' => '10:05'
        ],
    ]
];
