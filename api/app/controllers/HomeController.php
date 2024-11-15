<?php

namespace app\controllers;

use app\classes\CreditCard;
use app\classes\Customer;
use app\classes\Item;
use app\migrations\JogadorMigrations;
use Illuminate\Database\Capsule\Manager as Capsule;
use PagarMe\Client;
use PDOException;
use Psr\Http\Message\ResponseInterface;

class HomeController
{

    public function criaMigration(){
        $capsule = new Capsule();
        $config = [
            'driver'   => 'pgsql',        
            'host'     => 'postgres',    
            'port'     => '5432',         
            'database' => 'postgres',   
            'username' => 'postgres',    
            'password' => 'teste21',      
            'charset'  => 'utf8',        
            'prefix'   => '',             
        ];
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $jogadorMigration = new JogadorMigrations();
        $jogadorMigration->up();
    }

    public function getCustomers($request, $response)
    {

        //$this->criaMigration();

        $username = "";

        $password = "";

        $credentials = base64_encode("{$username}:{$password}");

        $client = new \GuzzleHttp\Client();

        $resp = $client->request('GET', 'https://api.pagar.me/core/v5/customers', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => "Basic {$credentials}",
            ],
        ]);


        $response->getBody()->write($resp->getBody()->getContents());
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function order($request, $response)
    {

        $username = "";

        $password = "";

        $credentials = base64_encode("{$username}:{$password}");

        $client = new \GuzzleHttp\Client();


        $resp = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => "Basic {$credentials}"
            ],
        ]);

        $response->getBody()->write($resp->getBody()->getContents());
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function getAndArmazenaCustomer($request, $response)
    {
        $objetos = [];


        $username = "";

        $password = "";

        $credentials = base64_encode("{$username}:{$password}");
        $url = "https://api.pagar.me/core/v5/customers";
        $client = new \GuzzleHttp\Client();

        /*$resp = $client->request('GET', "{$url}", [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => "Basic {$credentials}",
            ],
        ]);*/


        do {

            $resp = $client->request('GET', "{$url}", [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => "Basic {$credentials}",
                ],
            ]);

            $array = json_decode($resp->getBody()->getContents(), true);
            foreach ($array['data'] as $dados) {
                $objeto = json_decode(json_encode($dados));
                array_push($objetos, $objeto);
            }

            $url = $array['paging']['next'];
        } while ($array['paging']['next']);

        foreach ($objetos as $obj) {
            if ($obj->name == "Neymar Jr") {
                $json = json_encode($obj);
            }
        }

        $response->getBody()->write($json);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function transactionPix($request, $response)
    {


        $username = "";

        $password = "";

        $credentials = base64_encode("{$username}:{$password}");

        $client = new \GuzzleHttp\Client();


        $orderData = [
            "code" => "dasuishujsdkçm",
            "items" => [
                [
                    "code" => "dasghjhg46fdsfa5",
                    "amount" => 299000,
                    "description" => "Chaveiro do Tesseract",
                    "quantity" => 1
                ]
            ],
            "customer" => [
                "code" => "dasjbfdbghfdl",
                "name" => "Tony Stark",
                "email" => "avengerstark@ligadajustica.com.br",
                "type" => "individual",
                "document" => "01234567890",
                "phones" => [
                    "home_phone" => [
                        "country_code" => "55",
                        "number" => "22180513",
                        "area_code" => "21"
                    ]
                ]
            ],
            "payments" => [
                [
                    "payment_method" => "pix",
                    "pix" => [
                        "expires_in" => "52134613",
                        "additional_information" => [
                            [
                                "name" => "Quantidade",
                                "value" => "2"
                            ]
                        ]
                    ]
                ]
            ]
        ];



        $resp = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'json' => $orderData,
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => "Basic {$credentials}"
            ],
        ]);

        $responseBody = json_decode($resp->getBody(), true);
        var_dump($responseBody["status"]);
        return $response;
    }


    public function transactionCard($request, $response)
    {


        $username = "";

        $password = "";

        $credentials = base64_encode("{$username}:{$password}");

        $client = new \GuzzleHttp\Client();


        $orderData = [
            "items" => [
                [
                    "code" => "piashjgoidsjaiod",
                    "amount" => 2990, 
                    "description" => "Chaveiro do Tesseract",
                    "quantity" => 1
                ]
            ],
            "customer" => [
                "name" => "Tony Stark",
                "email" => "avengerstark@ligadajustica.com.br"
            ],
            "payments" => [
                [
                    "payment_method" => "credit_card",
                    "credit_card" => [
                        "recurrence_cycle" => "first",
                        "installments" => 1,
                        "statement_descriptor" => "AVENGERS",
                        "card" => [
                            "number" => "4000000000000010",  
                            "holder_name" => "Tony Stark",
                            "exp_month" => 1,
                            "exp_year" => 30,
                            "cvv" => "3531",
                            "billing_address" => [
                                "line_1" => "10880, Malibu Point, Malibu Central",
                                "zip_code" => "90265",
                                "city" => "Malibu",
                                "state" => "CA",
                                "country" => "US"
                            ]
                        ]
                    ]
                ]
            ]
        ];


        $resp = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'json' => $orderData,
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => "Basic {$credentials}"
            ],
        ]);

        $responseBody = json_decode($resp->getBody(), true);
        var_dump($responseBody);
        return $response;
    }

    public function transactionCardComOBJ($request, $response)
    {


        $username = "";

        $password = "";

        $credentials = base64_encode("{$username}:{$password}");

        $client = new \GuzzleHttp\Client();

        $items = new Item("12345", 9990, "Produto Exemplo", 10);
        $customer = new Customer("Ronaldinho Gaucho", "ronaldinho@email.com");
        $credit_card = new CreditCard("4000000000000010", "Ronaldinho Gaucho", 12, 30, "1232");


        $orderData = [
            "items" => [
                [
                    "code" => $items->code,
                    "amount" => $items->amount, 
                    "description" => $items->description,
                    "quantity" => $items->quantity
                ]
            ],
            "customer" => [
                "name" => $customer->nome,
                "email" => $customer->email,
                "document" => "93095135270",
                "document_type" => "CPF",
                "type" => "individual",
                "phones" => [
                    "home_phone" => [
                        "country_code" => "55",
                        "number" => "22180513",
                        "area_code" => "21"
                    ]
                ]
            ],
            "payments" => [
                [
                    "payment_method" => "credit_card",
                    "credit_card" => [
                        "recurrence_cycle" => "first",
                        "installments" => 1,
                        "statement_descriptor" => "AVENGERS",
                        "card" => [
                            "number" => "4000000000000051",  
                            "holder_name" => $credit_card->holder_name,
                            "exp_month" => $credit_card->exp_month,
                            "exp_year" => $credit_card->exp_year,
                            "cvv" => $credit_card->cvv,
                            "billing_address" => [
                                "line_1" => "10880, Malibu Point, Malibu Central",
                                "zip_code" => "90265",
                                "city" => "Malibu",
                                "state" => "CA",
                                "country" => "US"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $resp = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'json' => $orderData,
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => "Basic {$credentials}"
            ],
        ]);

        $responseBody = json_decode($resp->getBody(), true);
        var_dump($responseBody);
        return $response;
    }


    public function webHook($request, $response)
    {
        $inputData = file_get_contents("php://input");

        
        $data = json_decode($inputData, true);

       
        if (is_array($data)) {
            
            if ($data['type'] == 'order.created') {
               
                $payment_id = $data['data']['id'];
                
                file_put_contents('log.txt', "Pagamento criado: $payment_id\n", FILE_APPEND);
            } elseif ($data['type'] == 'order.paid') {
               
                $payment_id = $data['data']['id'];
                file_put_contents('log.txt', "Pagamento aprovado: $payment_id\n", FILE_APPEND);
            } elseif ($data['type'] == 'order.canceled') {

                $payment_id = $data['data']['id'];
                file_put_contents('log.txt', "Pagamento cancelado: $payment_id\n", FILE_APPEND);
            } elseif ($data['type'] == 'order.closed') {

                $payment_id = $data['data']['id'];
                file_put_contents('log.txt', "Pagamento fechado: $payment_id\n", FILE_APPEND);
            } elseif ($data['type'] == 'order.payment_failed') {

                $payment_id = $data['data']['id'];
                file_put_contents('log.txt', "Pagamento falhou: $payment_id\n", FILE_APPEND);
            } elseif ($data['type'] == 'order.updated') {

                $payment_id = $data['data']['id'];
                file_put_contents('log.txt', "Pagamento atualizado: $payment_id\n", FILE_APPEND);
            }
            
        } else {
            
            file_put_contents('log.txt', "Erro ao receber dados: $inputData\n", FILE_APPEND);
        }

        
        return $response->withStatus(200);
    }
}
