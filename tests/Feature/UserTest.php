<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginNoInput()
    {
        $this->json('POST', 'api/v1/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "status"    => 422,
                "success"   => false,
                "error" => [
                    "code" => 422,
                    "message" => "Harap masukkan email|Harap masukkan password|User firebase token kosong",
                ]
            ]);
    }

    public function testLoginNoEmail()
    {
           $userData = [
            "password" => "demo12345",
            "firebase_token" => "tes"
        ];
        $this->json('POST', 'api/v1/login',$userData,['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "status"    => 422,
                "success"   => false,
                "error" => [
                    "code" => 422,
                    "message" => "Harap masukkan email",
                ]
            ]);
    }

     public function testLoginNoPassword()
    {

           $userData = [
            "email" => "doe@example.com",
            "firebase_token" => "tes"
        ];
        $this->json('POST', 'api/v1/login',$userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "status"    => 422,
                "success"   => false,
                "error" => [
                    "code" => 422,
                    "message" => "Harap masukkan password",
                ]
            ]);
    }

    public function testNotFoundAccount()
    {
        $userData = [
            "email" => "doe@example.com",
            "password" => "demo12345",
            "firebase_token" => "tes"
        ];

        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                "status"    => 404,
                "success"   => false,
                "error" => [
                    "code" => 404,
                    "message" => "User tidak ditemukan",
                ]
            ]);
    }

    public function testWrongPassword()
    {
        $userData = [
            "email" => "yoga@gmail.com",
            "password" => "demo12345",
            "firebase_token" => "tes"
        ];

        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(403)
            ->assertJson([
                "status"    => 403,
                "success"   => false,
                "error" => [
                    "code" => 403,
                    "message" => "Email atau Password salah",
                ]
            ]);
    }

     public function testSuccessfulLogin()
    {
        $userData = [
            "email" => "yoga@gmail.com",
            "password" => "qwerty123",
            "firebase_token" => "demo12345"
        ];

        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
            "status",
            "success",
            "data" => [
                "id",
                "username",
                "name"
            ],
            "token"
            ]);
    }

}
