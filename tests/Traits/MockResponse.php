<?php
namespace Tests\Traits;

trait MockResponse {
    /**
     * Mock response data
     *
     * @return void
     */
    protected function mockResponseB(){
        return [
            "hotels"=> [
                [
                    "name"=> "Hotel Test A",
                    "stars"=> 4,
                    "rooms"=> [
                        [
                            "code"=> "DBL-TWN",
                            "name"=> "Double or Twin SUPERIOR",
                            "net_rate"=> "143.00",
                            "taxes"=> [
                                [
                                    "amount"=> "10.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ]
                            ],
                            "totalPrice"=> "153.00"
                        ],
                        [
                            "code"=> "HF-BD",
                            "name"=> "HALF BOARD",
                            "net_rate"=> "131.00",
                            "taxes"=> [
                                [
                                    "amount"=> "11.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ]
                            ],
                            "totalPrice"=> "142.00"
                        ],
                        [
                            "code"=> "QN-RM",
                            "name"=> "Queen Room",
                            "net_rate"=> "140",
                            "taxes"=> [
                                [
                                    "amount"=> "12.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ],
                                [
                                    "amount"=> "4.00",
                                    "currency"=> "EUR",
                                    "type"=> "EXTRA_FEES"
                                ]
                            ],
                            "totalPrice"=> "156.00"
                        ]
                    ]
                ],
                [
                    "name"=> "Hotel Test B",
                    "stars"=> 5,
                    "rooms"=> [
                        [
                            "code"=> "DBL-RM",
                            "name"=> "Double Room",
                            "net_rate"=> "152.00",
                            "taxes"=> [
                                [
                                    "amount"=> "15.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ]
                            ],
                            "totalPrice"=> "167.00"
                        ],
                        [
                            "code"=> "HF-BOD",
                            "name"=> "HALF BOARD",
                            "net_rate"=> "135.00",
                            "taxes"=> [
                                [
                                    "amount"=> "8.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ],
                                [
                                    "amount"=> "4.00",
                                    "currency"=> "EUR",
                                    "type"=> "EXTRA_FEES"
                                ]
                            ],
                            "totalPrice"=> "147.00"
                        ],
                        [
                            "code"=> "QUN-ROM",
                            "name"=> "Queen Room",
                            "net_rate"=> "140.00",
                            "taxes"=> [
                                [
                                    "amount"=> "6.50",
                                    "currency"=> "EUR",
                                    "type"=> "EXTRA_FEES"
                                ]
                            ],
                            "totalPrice"=> "146.50"
                        ]
                    ]
                ],
                [
                    "name"=> "Hotel Test C",
                    "stars"=> 5,
                    "rooms"=> [
                        [
                            "code"=> "SNG-RM",
                            "name"=> "Single Bed",
                            "net_rate"=> "96.00",
                            "taxes"=> [
                                [
                                    "amount"=> "12.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ]
                            ],
                            "totalPrice"=> "108.00"
                        ],
                        [
                            "code"=> "FUBOD",
                            "name"=> "FULL BOARD",
                            "net_rate"=> "165.00",
                            "taxes"=> [
                                [
                                    "amount"=> "15.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ]
                            ],
                            "totalPrice"=> "180.00"
                        ],
                        [
                            "code"=> "LUX-ROM",
                            "name"=> "Luxury Room",
                            "net_rate"=> "177.00",
                            "taxes"=> [
                                [
                                    "amount"=> "22.00",
                                    "currency"=> "EUR",
                                    "type"=> "TAXESANDFEES"
                                ]
                            ],
                            "totalPrice"=> "199.00"
                        ]
                    ]
                ],
            ]
        ];
    }

    /**
     * Mock response data
     *
     * @return void
     */
    protected function mockResponseA(){
        return [
            "hotels"=> [
                [
                    "name"=> "Hotel Test A",
                    "stars"=> 4,
                    "rooms"=> [
                        [
                            "code"=> "DBL-TWN",
                            "net_price"=> "140.00",
                            "taxes"=> [
                                "amount"=> "12.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "152.00"
                        ],
                        [
                            "code"=> "HF-BD",
                            "net_price"=> "133.00",
                            "taxes"=> [
                                "amount"=> "13.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "146.00"
                        ],
                        [
                            "code"=> "QN-RM",
                            "net_price"=> "144",
                            "taxes"=> [
                                "amount"=> "14.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "158.00"
                        ]
                    ]
                ],
                [
                    "name"=> "Hotel Test B",
                    "stars"=> 5,
                    "rooms"=> [
                        [
                            "code"=> "DBL-RM",
                            "net_price"=> "150.00",
                            "taxes"=> [
                                "amount"=> "15.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "165.00"
                        ],
                        [
                            "code"=> "HF-BOD",
                            "net_price"=> "130.00",
                            "taxes"=> [
                                "amount"=> "13.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "143.00"
                        ],
                        [
                            "code"=> "QUN-ROM",
                            "net_price"=> "143.00",
                            "taxes"=> [
                                "amount"=> "11.50",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "154.50"
                        ]
                    ]
                ],
                [
                    "name"=> "Hotel Test D",
                    "stars"=> 5,
                    "rooms"=> [
                        [
                            "code"=> "SNGRM",
                            "net_price"=> "100.00",
                            "taxes"=> [
                                "amount"=> "15.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "115.00"
                        ],
                        [
                            "code"=> "FU-BOD",
                            "net_price"=> "160.00",
                            "taxes"=> [
                                "amount"=> "16.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "176.00"
                        ],
                        [
                            "code"=> "POAROM",
                            "net_price"=> "155.00",
                            "taxes"=> [
                                "amount"=> "14.00",
                                "currency"=> "EUR",
                                "type"=> "TAXESANDFEES"
                            ],
                            "total"=> "169.00"
                        ]
                    ]
                ]
            ]
        ];
    }
}