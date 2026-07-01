<?php 

return [
    'types' => [
        'home' => [
            'icon'      => 'home',
            'label'      => [ 'en' => 'Website' ],
            'color' => '#DA7319',
            'output'    => [
                'contact'   => 'https://{value}',
            ]
        ],
        'sms' => [
            'icon'      => 'chat',
            'label'      => [ 'en' => 'SMS' ],
            'color' => '#39ACAC',
            'output'    => [
                'contact'   => 'sms:{value}',
                'share'     => 'sms:?&body={url}'
            ]
        ],
        'phone' => [
            'icon'      => 'phone',
            'label'      => [ 'en' => 'Phone' ],
            'color'     => '#82AD2C',
            'validate'  => 'tel',
            'output'    => [
                'contact'   => 'tel:{value}'
            ]
        ],
        'mail' => [
            'icon'      => 'email',
            'label'      => [ 'en' => 'Email' ],
            'color' => '#1E548A',
            'output'    => [
                'contact'   => 'mailto:'
            ]
        ],
        'whatsapp' => [
            'icon'      => 'whatsapp',
            'label'      => 'WhatsApp',
            'color' => '#22CD63',
            'output'    => [
                'contact'   => 'https://wa.me/{value}',
                'share'     => 'https://wa.me/?label={url}'
            ]
        ],
        'facebook' => [
            'icon'      => 'facebook',
            'label'      => 'Facebook',
            'color' => '#1773EC',
            'output'    => [
                'contact'   => 'https://www.facebook.com/{value}/',
                'share'     => 'https://www.facebook.com/sharer/sharer.php?u={url}'
            ]
        ],
        'instagram' => [
            'icon'      => 'instagram',
            'label'      => 'Instagram',
            'color' => '#C13684',
            'output'    => [
                'contact'   => 'https://www.instagram.com/{value}/',
            ]
        ],
        'tiktok' => [
            'icon'      => 'tiktok',
            'label'      => 'TikTok',
            'color' => '#C13684',
            'output'    => [
                'contact'   => 'https://www.tiktok.com/{value}/',
                'share'     => 'https://www.tiktok.com/share?url={url}'
            ]
        ],
        'linkedin' => [
            'icon'      => 'linkedin',
            'label'      => 'LinkedIn',
            'color' => '#0074B0',
            'output'    => [
                'contact'   => 'https://www.linkedin.com/{value}/',
                'share'     => 'https://www.linkedin.com/sharing/share-offsite/?url={url}'
            ]
        ],
        'vimeo' => [
            'icon'      => 'vimeo',
            'label'      => 'Vimeo',
            'color' => '#18D5FF',
            'output'    => [
                'contact'   => 'https://vimeo.com/channels/{value}/'
            ]
        ],
        'youtube' => [
            'icon'      => 'youtube',
            'label'      => 'Youtube',
            'color' => '#FF0100',
            'output'    => [
                'contact'   => 'https://www.youtube.com/@{value}/'
            ]
        ],
        'mastodon' => [
            'icon'      => 'mastodon',
            'label'      => 'Mastodon',
            'color' => '#6364ff',
            'output'    => [
                'contact'   => 'https://mastodon.social/@{value}/',
                'share'     => 'https://mastodon.social/share?url={url}'
            ]
        ],
        'github' => [
            'icon'      => 'github',
            'label'      => 'GitHub',
            'color' => '#1326FF',
            'output'    => [
                'contact'   => 'https://github.com/{value}/',
            ]
        ],
        'donate' => [
            'icon'      => 'heart',
            'label'      => [ 'en' => 'Donate' ],
            'color' => '#C3228E',
            'output'    => [
                'contact'   => '{value}',
            ]
        ]
    ]
];


?>