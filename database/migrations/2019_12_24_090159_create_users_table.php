<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('username',255);
            $table->string('mail',255);
            $table->string('password',255);
            $table->string('bio',400)->nullable();
            $table->string('images',255)->default('dawn.png')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    /**
     * ファイルデータを保存
     * @param string $filename ファイル名
     * @param string $save_path 保存先のパス
     * @return bool $result
     */
    //画像をDBに保存
    public function fileSave($filename,$save_path){
      $result = False;

      $sql = "INSERT INTO users (file_name,file_path) VALUE(?,?,?)";

      $stmt = users()->prepare($sql);
      $stmt->bindValue(1,$filename);
      $stmt->bindValue(2,$save_path);
      $result = $stmt->execute();

      return $result;
      
    }
    /**
     * ファイルデータを取得
     * @return array $fileData
     */
    function getAllfile(){
        $sql = "SELECT*FROM users";//ユーザーテーブルから取得

        $fileData = users()->query($sql);

        return $fileData;
    }
}