<?php

return [
    'templates' => [
        'default' => [
            'name' => 'Default',
            'description' => 'Halaman default dengan editor kaya',
            'schema' => [
                'content' => [
                    'type' => 'richtext',
                    'label' => 'Konten Halaman',
                    'required' => true,
                    'placeholder' => 'Tulis isi halaman di sini...'
                ]
            ]
        ],

        'faq' => [
            'name' => 'FAQ',
            'description' => 'Frequently Asked Questions dengan format pertanyaan-jawaban',
            'schema' => [
                'faqs' => [
                    'type' => 'repeater',
                    'label' => 'Daftar FAQ',
                    'required' => true,
                    'min_items' => 1,
                    'fields' => [
                        'question' => [
                            'type' => 'text',
                            'label' => 'Pertanyaan',
                            'required' => true,
                            'placeholder' => 'Masukkan pertanyaan'
                        ],
                        'answer' => [
                            'type' => 'richtext',
                            'label' => 'Jawaban',
                            'required' => true,
                            'placeholder' => 'Masukkan jawaban'
                        ]
                    ]
                ]
            ]
        ],

        'contact' => [
            'name' => 'Contact',
            'description' => 'Halaman kontak dengan informasi lengkap',
            'schema' => [
                'hero_title' => [
                    'type' => 'text',
                    'label' => 'Judul Hero Section',
                    'required' => true,
                    'placeholder' => 'Hubungi Kami'
                ],
                'hero_description' => [
                    'type' => 'textarea',
                    'label' => 'Deskripsi Hero Section',
                    'required' => false,
                    'placeholder' => 'Kami siap membantu Anda'
                ],
                'contact_info' => [
                    'type' => 'group',
                    'label' => 'Informasi Kontak',
                    'fields' => [
                        'phone' => [
                            'type' => 'text',
                            'label' => 'Nomor Telepon',
                            'required' => false,
                            'placeholder' => '+62 xxx xxxx xxxx'
                        ],
                        'email' => [
                            'type' => 'email',
                            'label' => 'Email',
                            'required' => false,
                            'placeholder' => 'contact@example.com'
                        ],
                        'address' => [
                            'type' => 'textarea',
                            'label' => 'Alamat',
                            'required' => false,
                            'placeholder' => 'Jl. Contoh No. 123, Kota, Provinsi'
                        ]
                    ]
                ],
                'business_hours' => [
                    'type' => 'repeater',
                    'label' => 'Jam Operasional',
                    'required' => false,
                    'fields' => [
                        'day' => [
                            'type' => 'select',
                            'label' => 'Hari',
                            'required' => true,
                            'options' => [
                                'monday' => 'Senin',
                                'tuesday' => 'Selasa',
                                'wednesday' => 'Rabu',
                                'thursday' => 'Kamis',
                                'friday' => 'Jumat',
                                'saturday' => 'Sabtu',
                                'sunday' => 'Minggu'
                            ]
                        ],
                        'open_time' => [
                            'type' => 'time',
                            'label' => 'Jam Buka',
                            'required' => true
                        ],
                        'close_time' => [
                            'type' => 'time',
                            'label' => 'Jam Tutup',
                            'required' => true
                        ],
                        'is_closed' => [
                            'type' => 'checkbox',
                            'label' => 'Tutup',
                            'required' => false
                        ]
                    ]
                ],
                'social_media' => [
                    'type' => 'repeater',
                    'label' => 'Media Sosial',
                    'required' => false,
                    'fields' => [
                        'platform' => [
                            'type' => 'select',
                            'label' => 'Platform',
                            'required' => true,
                            'options' => [
                                'facebook' => 'Facebook',
                                'twitter' => 'Twitter',
                                'instagram' => 'Instagram',
                                'linkedin' => 'LinkedIn',
                                'youtube' => 'YouTube',
                                'whatsapp' => 'WhatsApp'
                            ]
                        ],
                        'url' => [
                            'type' => 'url',
                            'label' => 'URL',
                            'required' => true,
                            'placeholder' => 'https://...'
                        ]
                    ]
                ]
            ]
        ],

        'about' => [
            'name' => 'About Us',
            'description' => 'Halaman tentang perusahaan dengan timeline dan team',
            'schema' => [
                'hero_title' => [
                    'type' => 'text',
                    'label' => 'Judul Hero',
                    'required' => true,
                    'placeholder' => 'Tentang Kami'
                ],
                'hero_description' => [
                    'type' => 'textarea',
                    'label' => 'Deskripsi Hero',
                    'required' => false,
                    'placeholder' => 'Cerita perusahaan kami...'
                ],
                'hero_image' => [
                    'type' => 'image',
                    'label' => 'Gambar Hero',
                    'required' => false
                ],
                'company_story' => [
                    'type' => 'richtext',
                    'label' => 'Cerita Perusahaan',
                    'required' => true,
                    'placeholder' => 'Jelaskan sejarah dan visi perusahaan'
                ],
                'mission_vision' => [
                    'type' => 'group',
                    'label' => 'Misi & Visi',
                    'fields' => [
                        'mission' => [
                            'type' => 'textarea',
                            'label' => 'Misi',
                            'required' => false,
                            'placeholder' => 'Misi perusahaan kami...'
                        ],
                        'vision' => [
                            'type' => 'textarea',
                            'label' => 'Visi',
                            'required' => false,
                            'placeholder' => 'Visi perusahaan kami...'
                        ]
                    ]
                ],
                'timeline' => [
                    'type' => 'repeater',
                    'label' => 'Timeline Perusahaan',
                    'required' => false,
                    'fields' => [
                        'year' => [
                            'type' => 'number',
                            'label' => 'Tahun',
                            'required' => true,
                            'min' => 1900,
                            'max' => 2100
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Judul',
                            'required' => true,
                            'placeholder' => 'Pencapaian penting'
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'label' => 'Deskripsi',
                            'required' => true,
                            'placeholder' => 'Jelaskan pencapaian ini'
                        ]
                    ]
                ],
                'team' => [
                    'type' => 'repeater',
                    'label' => 'Tim Kami',
                    'required' => false,
                    'fields' => [
                        'name' => [
                            'type' => 'text',
                            'label' => 'Nama',
                            'required' => true
                        ],
                        'position' => [
                            'type' => 'text',
                            'label' => 'Jabatan',
                            'required' => true
                        ],
                        'bio' => [
                            'type' => 'textarea',
                            'label' => 'Bio Singkat',
                            'required' => false
                        ],
                        'photo' => [
                            'type' => 'image',
                            'label' => 'Foto',
                            'required' => false
                        ]
                    ]
                ]
            ]
        ],

        'terms' => [
            'name' => 'Terms & Conditions',
            'description' => 'Syarat dan ketentuan dengan struktur yang jelas',
            'schema' => [
                'last_updated' => [
                    'type' => 'date',
                    'label' => 'Terakhir Diupdate',
                    'required' => false
                ],
                'introduction' => [
                    'type' => 'textarea',
                    'label' => 'Pendahuluan',
                    'required' => false,
                    'placeholder' => 'Pendahuluan syarat dan ketentuan'
                ],
                'sections' => [
                    'type' => 'repeater',
                    'label' => 'Bagian Syarat & Ketentuan',
                    'required' => true,
                    'min_items' => 1,
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Judul Bagian',
                            'required' => true,
                            'placeholder' => 'Judul bagian'
                        ],
                        'content' => [
                            'type' => 'richtext',
                            'label' => 'Isi Bagian',
                            'required' => true,
                            'placeholder' => 'Isi dari bagian ini'
                        ]
                    ]
                ]
            ]
        ],

        'privacy' => [
            'name' => 'Privacy Policy',
            'description' => 'Kebijakan privasi dengan struktur terorganisir',
            'schema' => [
                'effective_date' => [
                    'type' => 'date',
                    'label' => 'Tanggal Efektif',
                    'required' => false
                ],
                'introduction' => [
                    'type' => 'textarea',
                    'label' => 'Pendahuluan',
                    'required' => false,
                    'placeholder' => 'Pendahuluan kebijakan privasi'
                ],
                'sections' => [
                    'type' => 'repeater',
                    'label' => 'Bagian Kebijakan Privasi',
                    'required' => true,
                    'min_items' => 1,
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Judul Bagian',
                            'required' => true,
                            'placeholder' => 'Judul bagian'
                        ],
                        'content' => [
                            'type' => 'richtext',
                            'label' => 'Isi Bagian',
                            'required' => true,
                            'placeholder' => 'Isi dari bagian ini'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
