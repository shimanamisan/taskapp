<?php

namespace Tests\Feature;

use App\User; // 追加
use Illuminate\Support\Facades\Storage; // 追加
use Illuminate\Http\UploadedFile; // 追加
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageUploadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertTrue(true); // 
    }

    // テストを行うたびにDBのマイグレーションがリセットされる様にする
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザーをプロパティに追加
        $this->user = factory(User::class)->create();
    }

    // 正常系のテスト
    public function testFileUpload(){
        // エラーをわかりやすく出力するメソッド
        // ReflectionException: Class App\Http\Controllers\PhotoController does not exist これ出た
        // API叩いたときに呼ぶコントローラーを作っていない
        $this->withoutExceptionHandling();

        $this->assertTrue(true); //

        // テスト用のモックストレージを用意
        Storage::fake('files');

        $file = UploadedFile::fake()->image('photo.jpg');

        // actingAsヘルパメソッドは現在認証済みのユーザーを指定する簡単な手段を提供
        $response = $this->actingAs($this->user)
        ->json('POST', route('profile.create'), [
            // ダミーファイルを作成して送信している
            'file' => $file,
        ]);

        Storage::disk('files')->assertExists($file->getFilename()); 
    }

}
