<?php

namespace App\Libraries;

class Access_API
{
    // https://api.trunojoyo.ac.id:8212/siakad/v1/docs/
    function authorize($email)
    {
        $option = [
            'headers' => [
                'x-secret-key' => '6YUYRMWt03DHW2oIcpac1Bm7ftWp8n6JQCbtwbbhVSfQThezDfybm4A1lTTDvzIe',
            ],
        ];
        $client = \Config\Services::curlrequest($option);
        $data = $client->request('POST', 'https://api.trunojoyo.ac.id:8212/siakad/v1/authorize', [
            'form_params' => [
                'email' => $email
            ]
        ])->getBody();
        $result = json_decode($data);
        return $result;
    }
    function get_data_api($url)
    {
        $option = [
            'headers' => [
                'x-secret-key' => '6YUYRMWt03DHW2oIcpac1Bm7ftWp8n6JQCbtwbbhVSfQThezDfybm4A1lTTDvzIe',
            ],
        ];
        $client = \Config\Services::curlrequest($option);
        $data = json_decode($client->get($url)->getBody())->data;
        return $data;
    }
    function get_meta_api($url)
    {
        $option = [
            'headers' => [
                'x-secret-key' => '6YUYRMWt03DHW2oIcpac1Bm7ftWp8n6JQCbtwbbhVSfQThezDfybm4A1lTTDvzIe',
            ],
        ];
        $client = \Config\Services::curlrequest($option);
        $data = json_decode($client->get($url)->getBody())->meta;
        return $data;
    }
}
